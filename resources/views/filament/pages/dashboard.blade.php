<x-filament-panels::page>

    @php
        $customers = \App\Models\CustomersInfo::count();

        $activeCustomers = \App\Models\CustomersInfo::where('status', 'active')->count();

        $routers = \App\Models\RouterList::count();

        $pppoeUsers = \App\Models\PPPSecrets::where('status', '!=', 'removed')->count();

        $monthlyBilling = \App\Models\BillingInfo::sum('monthly_rent');

        $paidAmount = \App\Models\BillingInfo::sum('paid_amount');

        $outstandingDue = max(0, $monthlyBilling - $paidAmount);

        $connectedRouters = \App\Models\RouterList::where('action', 'connected')->count();

        $networkHealth = $routers > 0
            ? round(($connectedRouters / $routers) * 100)
            : 0;
    @endphp

    <div class="container-fluid px-0">

        {{-- ============================================================
             HEADER
        ============================================================ --}}
        <div class="card border-0 shadow-sm mb-4 overflow-hidden">

            <div class="card-body position-relative p-4">

                <div class="row align-items-center">

                    <div class="col">

                        <div class="d-flex align-items-center gap-2 mb-2">

                            <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                                <i class="bi bi-speedometer2 me-1"></i>
                                SUPER ADMIN
                            </span>

                        </div>

                        <h2 class="fw-bold mb-1">
                            SKYTECH INFRANET
                        </h2>

                        <p class="text-muted mb-0">
                            Network, customers and billing overview
                        </p>

                    </div>

                    <div class="col-auto d-none d-md-block">

                        <div class="text-end">

                            <div class="small text-muted">
                                System Status
                            </div>

                            @if($networkHealth >= 80)

                                <div class="fw-bold text-success">
                                    <i class="bi bi-circle-fill me-1"
                                       style="font-size:8px;"></i>
                                    Network Operational
                                </div>

                            @elseif($networkHealth > 0)

                                <div class="fw-bold text-warning">
                                    <i class="bi bi-circle-fill me-1"
                                       style="font-size:8px;"></i>
                                    Partial Network
                                </div>

                            @else

                                <div class="fw-bold text-danger">
                                    <i class="bi bi-circle-fill me-1"
                                       style="font-size:8px;"></i>
                                    Network Offline
                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ============================================================
             EXECUTIVE KPIs
        ============================================================ --}}
        <div class="row g-3 mb-4">

            {{-- Customers --}}
            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>

                                <div class="small text-muted mb-2">
                                    CUSTOMERS
                                </div>

                                <div class="fs-2 fw-bold">
                                    {{ number_format($customers) }}
                                </div>

                                <div class="small text-muted mt-2">
                                    Total registered
                                </div>

                            </div>

                            <div class="rounded-3 bg-primary-subtle text-primary p-3">
                                <i class="bi bi-people-fill fs-4"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Active Customers --}}
            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>

                                <div class="small text-muted mb-2">
                                    ACTIVE CUSTOMERS
                                </div>

                                <div class="fs-2 fw-bold text-success">
                                    {{ number_format($activeCustomers) }}
                                </div>

                                <div class="small text-muted mt-2">
                                    Currently active
                                </div>

                            </div>

                            <div class="rounded-3 bg-success-subtle text-success p-3">
                                <i class="bi bi-person-check-fill fs-4"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Routers --}}
            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>

                                <div class="small text-muted mb-2">
                                    MIKROTIK ROUTERS
                                </div>

                                <div class="fs-2 fw-bold">
                                    {{ number_format($routers) }}
                                </div>

                                <div class="small text-muted mt-2">
                                    {{ $connectedRouters }} currently connected
                                </div>

                            </div>

                            <div class="rounded-3 bg-info-subtle text-info p-3">
                                <i class="bi bi-router-fill fs-4"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- PPPoE --}}
            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>

                                <div class="small text-muted mb-2">
                                    PPPoE USERS
                                </div>

                                <div class="fs-2 fw-bold text-warning">
                                    {{ number_format($pppoeUsers) }}
                                </div>

                                <div class="small text-muted mt-2">
                                    Active system users
                                </div>

                            </div>

                            <div class="rounded-3 bg-warning-subtle text-warning p-3">
                                <i class="bi bi-person-badge-fill fs-4"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ============================================================
             BILLING + NETWORK HEALTH
        ============================================================ --}}
        <div class="row g-3 mb-4">

            {{-- Billing --}}
            <div class="col-12 col-xl-7">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-transparent border-0 p-4 pb-2">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <h5 class="fw-bold mb-1">
                                    <i class="bi bi-cash-stack me-2"></i>
                                    Revenue & Billing
                                </h5>

                                <small class="text-muted">
                                    Current customer billing position
                                </small>

                            </div>

                            <i class="bi bi-bar-chart-line fs-4 text-primary"></i>

                        </div>

                    </div>

                    <div class="card-body p-4">

                        <div class="row g-3">

                            <div class="col-12 col-md-4">

                                <div class="p-3 rounded-3 bg-primary-subtle h-100">

                                    <div class="small text-muted">
                                        MONTHLY BILLING
                                    </div>

                                    <div class="fs-4 fw-bold text-primary mt-2">
                                        {{ number_format($monthlyBilling, 2) }}
                                    </div>

                                    <small class="text-muted">
                                        TZS
                                    </small>

                                </div>

                            </div>


                            <div class="col-12 col-md-4">

                                <div class="p-3 rounded-3 bg-success-subtle h-100">

                                    <div class="small text-muted">
                                        PAID
                                    </div>

                                    <div class="fs-4 fw-bold text-success mt-2">
                                        {{ number_format($paidAmount, 2) }}
                                    </div>

                                    <small class="text-muted">
                                        TZS
                                    </small>

                                </div>

                            </div>


                            <div class="col-12 col-md-4">

                                <div class="p-3 rounded-3 bg-danger-subtle h-100">

                                    <div class="small text-muted">
                                        OUTSTANDING
                                    </div>

                                    <div class="fs-4 fw-bold text-danger mt-2">
                                        {{ number_format($outstandingDue, 2) }}
                                    </div>

                                    <small class="text-muted">
                                        TZS
                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Network Health --}}
            <div class="col-12 col-xl-5">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-transparent border-0 p-4 pb-2">

                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-activity me-2"></i>
                            Network Health
                        </h5>

                        <small class="text-muted">
                            MikroTik infrastructure status
                        </small>

                    </div>

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <span class="text-muted">
                                Routers Online
                            </span>

                            <span class="fw-bold">
                                {{ $connectedRouters }} / {{ $routers }}
                            </span>

                        </div>

                        <div class="progress mb-4"
                             style="height:10px;">

                            <div class="progress-bar
                                @if($networkHealth >= 80)
                                    bg-success
                                @elseif($networkHealth > 0)
                                    bg-warning
                                @else
                                    bg-danger
                                @endif"
                                role="progressbar"
                                style="width: {{ $networkHealth }}%;">
                            </div>

                        </div>

                        <div class="row text-center">

                            <div class="col-6 border-end">

                                <div class="fs-3 fw-bold text-success">
                                    {{ $networkHealth }}%
                                </div>

                                <small class="text-muted">
                                    Network Health
                                </small>

                            </div>

                            <div class="col-6">

                                <div class="fs-3 fw-bold text-info">
                                    {{ number_format($pppoeUsers) }}
                                </div>

                                <small class="text-muted">
                                    PPPoE Users
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ============================================================
             MIKROTIK NETWORK
        ============================================================ --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-transparent border-0 p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-router-fill me-2"></i>
                            MikroTik Network
                        </h5>

                        <small class="text-muted">
                            Router-by-router infrastructure overview
                        </small>

                    </div>

                    <a href="{{ route('mikrotik-sync') }}"
                       class="btn btn-primary btn-sm">
                        <i class="bi bi-gear me-1"></i>
                        Manage MikroTik
                    </a>

                </div>

            </div>


            <div class="card-body p-4">

                <div class="row g-3">

                    @forelse(\App\Models\RouterList::orderBy('id')->get() as $router)

                        @php
                            $routerUsers = 0;

                            if (isset($results[$router->router_name]['pppoe_users'])) {
                                $routerUsers = (int) $results[$router->router_name]['pppoe_users'];
                            } elseif (isset($results[$router->router_name]['users'])) {
                                $routerUsers = (int) $results[$router->router_name]['users'];
                            }
                        @endphp

                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">

                            <div class="border rounded-3 h-100 p-3">

                                <div class="d-flex justify-content-between align-items-start mb-3">

                                    <div class="overflow-hidden">

                                        <div class="fw-bold text-truncate">
                                            {{ $router->router_name }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $router->ip_address }}
                                        </small>

                                    </div>

                                    <i class="bi bi-router fs-4 text-info"></i>

                                </div>


                                <div class="mb-3">

                                    @if($router->action === 'connected')

                                        <span class="badge bg-success-subtle text-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            ONLINE
                                        </span>

                                    @else

                                        <span class="badge bg-danger-subtle text-danger">
                                            <i class="bi bi-x-circle me-1"></i>
                                            OFFLINE
                                        </span>

                                    @endif

                                </div>


                                <div class="d-flex justify-content-between small mb-2">

                                    <span class="text-muted">
                                        PPPoE Users
                                    </span>

                                    <span class="fw-bold">
                                        {{ number_format($routerUsers) }}
                                    </span>

                                </div>


                                <div class="d-flex justify-content-between small">

                                    <span class="text-muted">
                                        SSH Port
                                    </span>

                                    <span class="fw-bold">
                                        {{ $router->ssh_port ?? '-' }}
                                    </span>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="col-12">

                            <div class="text-center py-5">

                                <i class="bi bi-router fs-1 text-muted"></i>

                                <h6 class="mt-3">
                                    No MikroTik routers configured
                                </h6>

                                <p class="text-muted mb-0">
                                    Add a router to begin monitoring your network.
                                </p>

                            </div>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- ============================================================
             QUICK ACTIONS
        ============================================================ --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-transparent border-0 p-4 pb-2">

                <h5 class="fw-bold mb-1">
                    <i class="bi bi-lightning-charge-fill me-2"></i>
                    Quick Actions
                </h5>

                <small class="text-muted">
                    Frequently used administration tools
                </small>

            </div>

            <div class="card-body p-4">

                <div class="row g-3">

                    <div class="col-12 col-sm-6 col-lg-3">

                        <a href="{{ url('/customers') }}"
                           class="btn btn-light border w-100 py-3">

                            <i class="bi bi-people-fill fs-4 d-block mb-1"></i>

                            Customers

                        </a>

                    </div>


                    <div class="col-12 col-sm-6 col-lg-3">

                        <a href="{{ url('/payments') }}"
                           class="btn btn-light border w-100 py-3">

                            <i class="bi bi-cash-coin fs-4 d-block mb-1"></i>

                            Collect Payment

                        </a>

                    </div>


                    <div class="col-12 col-sm-6 col-lg-3">

                        <a href="{{ url('/package-lists') }}"
                           class="btn btn-light border w-100 py-3">

                            <i class="bi bi-box-seam fs-4 d-block mb-1"></i>

                            Packages

                        </a>

                    </div>


                    <div class="col-12 col-sm-6 col-lg-3">

                        <a href="{{ url('/site-settings') }}"
                           class="btn btn-light border w-100 py-3">

                            <i class="bi bi-gear-fill fs-4 d-block mb-1"></i>

                            Settings

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-filament-panels::page>
