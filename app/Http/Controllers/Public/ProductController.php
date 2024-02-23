<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TransactionItem;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = ProductService::productList($request);
        // if ($products->count() == 0) {
        //     abort(404);
        // }
        $categories = Category::all();

        return view('public.pages.product.index')
            ->with(compact('products', 'categories'));
    }

    public function show($id)
    {
        $userId = null;
        if (Auth::check() && Auth::user()->role_id == 2) {
            $userId = Auth::user()->id;
        }
        $product = ProductService::productDetail($id, $userId)->fetch();

        return view('public.pages.product.detail')
            ->with(compact('product'));
    }

    public function groupDetail($id)
    {
        $product = ProductService::productDetail($id)->fetch();

        return view('public.pages.product.grouped')
            ->with(compact('product'));
    }
}
