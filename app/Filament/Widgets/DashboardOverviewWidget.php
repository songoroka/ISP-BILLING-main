<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class DashboardOverviewWidget extends Widget
{
    protected string $view = 'filament.widgets.dashboard-overview';

    protected int|string|array $columnSpan = 'full';

    public float $monthlyBill = 0;

    public float $paidAmount = 0;

    public float $totalDue = 0;

    public string $bandwidth = 'N/A';

    public string $uptime = '0s';

    public string $status = 'unknown';

    public function mount(): void
    {
        $user = Auth::guard('web')->user();

        $billing = $user?->customer?->billing;

        if ($billing) {
            $this->monthlyBill = (float) ($billing->monthly_rent ?? 0);
            $this->paidAmount = (float) ($billing->paid_amount ?? 0);
            $this->totalDue = (float) ($billing->due_amount ?? 0);
        }

        $this->bandwidth = (string) ($user?->bandwidth ?? 'N/A');
        $this->uptime = (string) ($user?->uptime ?? '0s');
        $this->status = (string) ($user?->status ?? 'unknown');
    }
}
