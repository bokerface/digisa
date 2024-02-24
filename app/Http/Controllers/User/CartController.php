<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $cart = CartService::cartIndex($userId);
        // dd($cart);
        return view('user.pages.cart.index')
            ->with(compact('cart'));
    }

    public function addToCart($productId)
    {
        $userId = Auth::user()->id;
        $cartItem = CartService::addProductToCart($userId, $productId);
        $product = ProductService::productDetail($productId, $userId)->fetch();
        // dd($cartItem);

        if ($cartItem == 'exists' || $product->is_bought) {
            return redirect()
                ->to(route('public.product_detail', $productId))
                ->with('warning', 'Barang yang anda inginkan sudah ada di keranjang atau sudah pernah anda beli.');
        }

        return redirect()
            ->to(route('user.cart'))
            ->with('success', 'Barang berhasil ditambahkan ke keranjang.');
    }
}
