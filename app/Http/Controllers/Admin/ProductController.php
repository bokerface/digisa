<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.pages.product.index')
            ->with(compact('products'));
    }

    public function create()
    {
        return view('admin.pages.product.create');
    }

    public function store(StoreProductRequest $request)
    {
        ProductService::storeProduct($request);
        return redirect()->to(route('admin.product_index'))->with('success', 'Produk baru ditambahkan');
    }

    public function edit($id)
    {
        $product = ProductService::productDetail($id)->fetch();
        $selected_categories = explode(',', $product->category_id);
        // dd($selected_categories);
        return view('admin.pages.product.edit')
            ->with(compact('product', 'selected_categories'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        // dd($request->all());
        ProductService::productDetail($id)->updateProduct($request);
        return redirect()->back()->with('success', 'Perubahan data produk berhasil disimpan');
    }

    public function delete($id)
    {
        ProductService::productDetail($id)->deleteProduct();

        return redirect()->to(route('admin.product_index'))->with('success', 'Produk dihapus');
    }

    public function saleStats()
    {
        $sales = ProductService::sales();
        // dd($sales);
        return view('admin.pages.product.stats')
            ->with(compact('sales'));
    }
}
