<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">

    {{-- Monthly Bill --}}
    <div class="relative overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-blue-500"></div>
        </div>

        <div class="relative p-4">
            <div class="mb-3 flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Monthly Bill
                </span>

                <span class="rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-700 dark:bg-blue-500/20 dark:text-blue-400">
                    BILLING
                </span>
            </div>

            <div class="text-2xl font-semibold text-blue-600 dark:text-blue-400">
                {{ number_format($monthlyBill, 2) }}
            </div>

            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Current Plan Rent
            </div>
        </div>
    </div>

    {{-- Paid Amount --}}
    <div class="relative overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-green-500"></div>
        </div>

        <div class="relative p-4">
            <div class="mb-3 flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Paid Amount
                </span>

                <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700 dark:bg-green-500/20 dark:text-green-400">
                    PAID
                </span>
            </div>

            <div class="text-2xl font-semibold text-green-600 dark:text-green-400">
                {{ number_format($paidAmount, 2) }}
            </div>

            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Amount paid this month
            </div>
        </div>
    </div>

    {{-- Total Due --}}
    <div class="relative overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-red-500"></div>
        </div>

        <div class="relative p-4">
            <div class="mb-3 flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Total Due
                </span>

                @if ($totalDue > 0)
                    <span class="rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-700 dark:bg-red-500/20 dark:text-red-400">
                        DUE
                    </span>
                @else
                    <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700 dark:bg-green-500/20 dark:text-green-400">
                        CLEAR
                    </span>
                @endif
            </div>

            <div class="text-2xl font-semibold {{ $totalDue > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                {{ number_format($totalDue, 2) }}
            </div>

            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                {{ $totalDue > 0 ? 'Pending payment' : 'No outstanding balance' }}
            </div>
        </div>
    </div>

    {{-- Bandwidth --}}
    <div class="relative overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-cyan-500"></div>
        </div>

        <div class="relative p-4">
            <div class="mb-3 flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Bandwidth
                </span>

                <span class="rounded-full bg-cyan-100 px-2 py-1 text-xs font-medium text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-400">
                    SPEED
                </span>
            </div>

            <div class="text-2xl font-semibold text-cyan-600 dark:text-cyan-400">
                {{ $bandwidth }}
            </div>

            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Allocated Speed
            </div>
        </div>
    </div>

    {{-- Uptime --}}
    <div class="relative overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-amber-500"></div>
        </div>

        <div class="relative p-4">
            <div class="mb-3 flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Uptime
                </span>

                <span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-medium text-amber-700 dark:bg-amber-500/20 dark:text-amber-400">
                    SESSION
                </span>
            </div>

            <div class="text-2xl font-semibold text-amber-600 dark:text-amber-400">
                {{ $uptime }}
            </div>

            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Active session duration
            </div>
        </div>
    </div>

    {{-- Connection Status --}}
    @php
        $isOnline = in_array(strtolower($status), ['active', 'online'], true);
    @endphp

    <div class="relative overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full {{ $isOnline ? 'bg-green-500' : 'bg-gray-500' }}"></div>
        </div>

        <div class="relative p-4">
            <div class="mb-3 flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Connection
                </span>

                @if ($isOnline)
                    <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700 dark:bg-green-500/20 dark:text-green-400">
                        ONLINE
                    </span>
                @else
                    <span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700 dark:bg-gray-500/20 dark:text-gray-400">
                        OFFLINE
                    </span>
                @endif
            </div>

            <div class="text-2xl font-semibold {{ $isOnline ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                {{ ucfirst($status) }}
            </div>

            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Current connection status
            </div>
        </div>
    </div>

</div>
