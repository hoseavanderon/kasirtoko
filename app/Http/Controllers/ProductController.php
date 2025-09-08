<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function searchByBarcode(Request $request)
    {
        $barcode = $request->input('barcode');

        $product = Product::where('barcode', $barcode)->first();

        if (!$product) {
            return response()->json([
                'error' => 'Produk tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'id' => $product->id,
            'nama_produk' => $product->nama_produk,
            'harga' => $product->jual,
            'barcode' => $product->barcode,
        ]);
    }

    public function getProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Produk tidak ditemukan.'], 404);
        }

        return response()->json([
            'id' => $product->id,
            'nama_produk' => $product->nama_produk,
            'harga' => $product->jual,
            'barcode' => $product->barcode,
        ]);
    }
}
