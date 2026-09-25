<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\PackageList;

class PackageController extends Controller
{
    public function index()
    {
        $packages = PackageList::query()->get();

        return response()->json(['success' => true, 'data' => $packages]);
    }
}
