<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Shelf;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index() {
        $shelves = Shelf::withCount('products')->get();
        return view('inventory.index', compact('shelves'));
    }

    public function show($rackId)
    {
        $rack = Shelf::with(['products.attributeValues'])->findOrFail($rackId);

        return response()->json([
            'name'  => $rack->name,
            'count' => $rack->products->count(),
            'items' => $rack->products->map(fn($p) => [
                'id'    => $p->id,
                'name'  => $p->nama_produk,
                'sku'   => $p->barcode,
                'price' => (float) $p->jual,
                'stock' => $p->attributeValues->sum('stok'), // 🔥 stok dari sum
            ]),
        ]);
    }

    public function getShelfItems($id) {
        $shelf = Shelf::with(['products.attributeValues'])->withCount('products')->findOrFail($id);

        $items = $shelf->products->map(fn($p) => [
            'id'    => $p->id,
            'name'  => $p->nama_produk,
            'sku'   => $p->barcode,
            'price' => (float) $p->jual,
            'stock' => $p->attributeValues->sum('stok'),
        ]);

        return response()->json([
            'id'    => $shelf->id,
            'name'  => $shelf->name,
            'count' => $shelf->products_count,
            'items' => $items,
        ]);
    }

    public function history($productId, $attributeValueId = null)
    {
        $query = DB::table('inventory_histories')
            ->where('product_id', $productId);

        if ($attributeValueId) {
            $query->where('product_attribute_values_id', $attributeValueId);
        }

        $histories = $query->orderBy('created_at', 'desc')->get();

        return response()->json($histories);
    }

    public function barangMasuk(){
        return view('barangmasuk.index');
    }
}
