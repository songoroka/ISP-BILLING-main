<x-filament-panels::page>

    @if (session('success'))
        <div class="rounded-xl bg-success-50 p-4 text-sm font-medium text-success-700 dark:bg-success-950 dark:text-success-300">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-xl bg-danger-50 p-4 text-sm font-medium text-danger-700 dark:bg-danger-950 dark:text-danger-300">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold tracking-tight">
                    Role & Permission Management
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Manage system roles and their permissions.
                </p>
            </div>

            @if (auth()->user()->can('create-user-role'))
                <x-filament::button
                    icon="heroicon-m-plus"
                    wire:click="createRole"
                >
                    Add New Role
                </x-filament::button>
            @endif
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">

            @forelse ($this->roles as $role)

                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">

                    <div class="flex items-start justify-between gap-3">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-50 text-primary-600 dark:bg-primary-950 dark:text-primary-400">
                                <x-heroicon-o-shield-check class="h-5 w-5" />
                            </div>

                            <div>
                                <h3 class="font-semibold">
                                    {{ $role->name }}
                                </h3>

                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    @if ($role->name === 'Super Admin')
                                        All System Privileges
                                    @else
                                        {{ $role->permissions->count() }}
                                        {{ Str::plural('Permission', $role->permissions->count()) }}
                                    @endif
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="mt-5 flex flex-wrap gap-2">

                        @if ($role->name === 'Super Admin')

                            <span class="inline-flex items-center gap-1 rounded-full bg-success-50 px-3 py-1 text-xs font-medium text-success-700 dark:bg-success-950 dark:text-success-300">
                                <x-heroicon-m-star class="h-3.5 w-3.5" />
                                All Permissions
                            </span>

                        @else

                            @forelse ($role->permissions->take(8) as $permission)

                                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                    {{ $permission->name }}
                                </span>

                            @empty

                                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                    No Permissions Assigned
                                </span>

                            @endforelse

                            @if ($role->permissions->count() > 8)
                                <span class="rounded-full bg-gray-50 px-3 py-1 text-xs font-medium text-gray-500 dark:bg-gray-950 dark:text-gray-400">
                                    + {{ $role->permissions->count() - 8 }} more
                                </span>
                            @endif

                        @endif

                    </div>

                    <div class="mt-5 flex justify-end gap-2 border-t border-gray-100 pt-4 dark:border-gray-800">

                        @if ($role->name !== 'Super Admin')

                            @if (auth()->user()->can('edit-user-role'))
                                <x-filament::button
                                    size="sm"
                                    color="gray"
                                    icon="heroicon-m-pencil-square"
                                    wire:click="editRole({{ $role->id }})"
                                >
                                    Edit
                                </x-filament::button>
                            @endif

                            @if (auth()->user()->can('delete-user-role'))
                                <x-filament::button
                                    size="sm"
                                    color="danger"
                                    icon="heroicon-m-trash"
                                    wire:click="deleteRole({{ $role->id }})"
                                    wire:confirm="Are you sure you want to delete the role '{{ $role->name }}'?"
                                >
                                    Delete
                                </x-filament::button>
                            @endif

                        @else

                            <span class="text-xs font-medium text-gray-500">
                                System Protected
                            </span>

                        @endif

                    </div>

                </div>

            @empty

                <div class="col-span-full rounded-xl bg-white p-8 text-center shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <p class="font-medium text-gray-500">
                        No roles found.
                    </p>
                </div>

            @endforelse

        </div>

        @if ($showRoleForm)

            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">

                <div class="max-h-[90vh] w-full max-w-4xl overflow-y-auto rounded-2xl bg-white shadow-xl dark:bg-gray-900">

                    <div class="flex items-center justify-between border-b border-gray-200 p-5 dark:border-gray-800">

                        <div>
                            <h2 class="text-lg font-semibold">
                                {{ $editingRoleId ? 'Edit Role' : 'Create New Role' }}
                            </h2>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Assign permissions to this role.
                            </p>
                        </div>

                        <button
                            type="button"
                            wire:click="closeRoleForm"
                            class="text-gray-400 hover:text-gray-600"
                        >
                            <x-heroicon-m-x-mark class="h-6 w-6" />
                        </button>

                    </div>

                    <form wire:submit="saveRole">

                        <div class="space-y-6 p-5">

                            <div>
                                <label class="mb-2 block text-sm font-medium">
                                    Role Name
                                </label>

                                <input
                                    type="text"
                                    wire:model="roleName"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800"
                                    required
                                />

                                @error('roleName')
                                    <p class="mt-1 text-sm text-danger-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>

                                <div class="mb-3 flex items-center justify-between">

                                    <label class="text-sm font-medium">
                                        Permissions
                                    </label>

                                    <span class="text-xs text-gray-500">
                                        {{ count($selectedPermissions) }} selected
                                    </span>

                                </div>

                                <div class="grid max-h-[450px] grid-cols-1 gap-2 overflow-y-auto rounded-xl border border-gray-200 p-4 md:grid-cols-2 dark:border-gray-700">

                                    @foreach ($this->permissionList as $permission)

                                        <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-gray-100 p-3 hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800">

                                            <input
                                                type="checkbox"
                                                value="{{ $permission->id }}"
                                                wire:model="selectedPermissions"
                                                class="rounded border-gray-300 text-primary-600"
                                            />

                                            <span class="text-sm">
                                                {{ $permission->name }}
                                            </span>

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                        <div class="flex justify-end gap-3 border-t border-gray-200 p-5 dark:border-gray-800">

                            <x-filament::button
                                type="button"
                                color="gray"
                                wire:click="closeRoleForm"
                            >
                                Cancel
                            </x-filament::button>

                            <x-filament::button
                                type="submit"
                            >
                                Save Role
                            </x-filament::button>

                        </div>

                    </form>

                </div>

            </div>

        @endif

    </div>

</x-filament-panels::page>
