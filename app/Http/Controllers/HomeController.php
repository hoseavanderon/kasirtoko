<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\DetailTransaction;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with('subcategories')->get();
        $products = Product::all();
        return view('home', compact('categories','products'));
    }

    public function loadPartial($page)
    {
        if (!view()->exists("partials.$page")) {
            return response('Page not found', 404);
        }

        $data = [];

        switch ($page) {
            case 'home':
                $data['categories'] = Category::with('subcategories')->get();
                $data['products'] = Product::all();
                break;

            case 'history':
                $today = now()->toDateString();

                $transactions = Transaction::with(['detailTransactions.product'])
                    ->whereDate('created_at', $today)
                    ->get();

                // total dari transaksi langsung (bukan dari detail)
                $data['totalPenjualan'] = $transactions->sum('subtotal'); 
                $data['transactions'] = $transactions;
                break;
        }

        return view("partials.$page", $data);
    }

    public function filterProducts(Request $request)
    {
        $id = $request->id;
        $products = Product::where('sub_category_id', $id)->get();
        $sub = SubCategory::find($id);

        $html = view('partials.products', compact('products'))->render();

        return response()->json([
            'html' => $html,
            'title' => 'Subcategory: ' . ($sub->nama ?? '-')
        ]);
    }

   public function saveTransaction(Request $request)
    {
        DB::transaction(function () use ($request) {
            $nota = Transaction::generateNota();

            $transaction = Transaction::create([
                'nomor_nota' => $nota,
                'subtotal'   => $request->subtotal,
                'dibayar'    => $request->dibayar,
                'kembalian'  => $request->kembalian,
                'user_id'    => Auth::id(),
                'is_lunas'   => $request->is_lunas ? 1 : 0,
                'customer_id'=> $request->customer_id,
                'paid_at'    => now(),
            ]);

            foreach ($request->items as $item) {
                DetailTransaction::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $item['id'],
                    'qty'            => $item['quantity'],
                    'harga_satuan'   => $item['harga'],
                    'subtotal'       => $item['harga'] * $item['quantity'],
                ]);
            }
        });

        return response()->json(['success' => true]);
    }
}