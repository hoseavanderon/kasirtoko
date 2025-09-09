<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');

        $customers = Customer::where('customer_name', 'like', '%' . $query . '%')
            ->limit(10)
            ->get(['id', 'customer_name']);

        return response()->json($customers);
    }
}