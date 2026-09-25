<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CustomersInfo;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = CustomersInfo::query()->with(['package:id,package_name,monthly_rent', 'billing']);

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($q) use ($search) {
                $q->where('customer_unique_id', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query->paginate(min($request->integer('per_page', 25), 100));

        return response()->json([
            'success' => true,
            'data' => $customers->items(),
            'meta' => [
                'current_page' => $customers->currentPage(),
                'last_page' => $customers->lastPage(),
                'per_page' => $customers->perPage(),
                'total' => $customers->total(),
            ],
        ]);
    }

    public function show(string $customerUniqueId)
    {
        $customer = CustomersInfo::with(['package', 'billing'])
            ->where('customer_unique_id', $customerUniqueId)
            ->firstOrFail();

        return response()->json(['success' => true, 'data' => [
            'customer_unique_id' => $customer->customer_unique_id,
            'customer_name' => $customer->customer_name,
            'email' => $customer->email,
            'mobile' => $customer->mobile,
            'address' => $customer->address,
            'status' => $customer->status,
            'connection_date' => $customer->connection_date,
            'package' => $customer->package,
            'billing' => $customer->billing,
        ]]);
    }

    public function billing(string $customerUniqueId)
    {
        $customer = CustomersInfo::with('billing')
            ->where('customer_unique_id', $customerUniqueId)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => [
                'customer_unique_id' => $customer->customer_unique_id,
                'customer_name' => $customer->customer_name,
                'status' => $customer->status,
                'billing' => $customer->billing,
            ],
        ]);
    }

    public function payments(Request $request, string $customerUniqueId)
    {
        $customer = CustomersInfo::where('customer_unique_id', $customerUniqueId)->firstOrFail();
        $payments = $customer->collectionSummary()->latest('collection_date')->paginate(min($request->integer('per_page', 25), 100));

        return response()->json([
            'success' => true,
            'data' => $payments->items(),
            'meta' => [
                'current_page' => $payments->currentPage(),
                'last_page' => $payments->lastPage(),
                'per_page' => $payments->perPage(),
                'total' => $payments->total(),
            ],
        ]);
    }
}
