<?php

namespace App\Http\Controllers;
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
            default:
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

}