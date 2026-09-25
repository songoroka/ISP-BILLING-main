<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Privileges extends Page
{
    protected static ?string $title = 'Privileges';

    protected static ?string $navigationLabel = 'Privileges';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected static ?int $navigationSort = 10;

    protected string $view = 'filament.pages.privileges';

    public ?int $editingRoleId = null;

    public string $roleName = '';

    public array $selectedPermissions = [];

    public bool $showRoleForm = false;

    public function mount(): void
    {
        $user = Auth::guard('web')->user();

        abort_unless(
            $user && $user->hasRole('Super Admin'),
            403
        );
    }

    public function getRolesProperty()
    {
        return Role::where('name', '!=', 'Reseller')
            ->with('permissions')
            ->orderBy('id')
            ->get();
    }

    public function getPermissionListProperty()
    {
        return Permission::orderBy('name')->get();
    }

    public function createRole(): void
    {
        $this->authorizeRoleManagement('create-user-role');

        $this->reset([
            'editingRoleId',
            'roleName',
            'selectedPermissions',
        ]);

        $this->showRoleForm = true;
    }

    public function editRole(int $roleId): void
    {
        $this->authorizeRoleManagement('edit-user-role');

        $role = Role::with('permissions')->findOrFail($roleId);

        if ($role->name === 'Super Admin') {
            $this->dispatch('notify', type: 'warning', message: 'Super Admin role cannot be edited.');

            return;
        }

        $this->editingRoleId = $role->id;
        $this->roleName = $role->name;
        $this->selectedPermissions = $role->permissions
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->toArray();

        $this->showRoleForm = true;
    }

    public function saveRole(): void
    {
        $permission = $this->editingRoleId
            ? 'edit-user-role'
            : 'create-user-role';

        $this->authorizeRoleManagement($permission);

        $this->validate([
            'roleName' => 'required|string|max:255|unique:roles,name,' . ($this->editingRoleId ?? 'NULL'),
            'selectedPermissions' => 'array',
            'selectedPermissions.*' => 'integer',
        ]);

        if ($this->editingRoleId) {
            $role = Role::findOrFail($this->editingRoleId);

            if ($role->name === 'Super Admin') {
                abort(403, 'Super Admin role cannot be edited.');
            }

            $role->name = $this->roleName;
            $role->save();

            $role->syncPermissions($this->selectedPermissions);

            session()->flash('success', 'Role updated successfully.');
        } else {
            $role = Role::create([
                'guard_name' => 'web',
                'name' => $this->roleName,
            ]);

            $role->syncPermissions($this->selectedPermissions);

            session()->flash('success', 'Role created successfully.');
        }

        $this->closeRoleForm();
    }

    public function deleteRole(int $roleId): void
    {
        $this->authorizeRoleManagement('delete-user-role');

        $role = Role::findOrFail($roleId);

        if ($role->name === 'Super Admin') {
            session()->flash('error', 'Super Admin role cannot be deleted.');

            return;
        }

        $role->delete();

        session()->flash('success', 'Role deleted successfully.');
    }

    public function closeRoleForm(): void
    {
        $this->showRoleForm = false;

        $this->reset([
            'editingRoleId',
            'roleName',
            'selectedPermissions',
        ]);
    }

    protected function authorizeRoleManagement(string $permission): void
    {
        $user = Auth::guard('web')->user();

        abort_unless(
            $user &&
            $user->hasRole('Super Admin') &&
            $user->can($permission),
            403
        );
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::guard('web')->user();

        return $user && $user->hasRole('Super Admin');
    }
}
