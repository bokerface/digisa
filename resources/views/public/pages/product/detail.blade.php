<x-user.layout>
    <section class="py-5" id="features">
        <div class="container px-5 my-5">
            @if (session()->has('warning'))
                <div class="alert alert-warning justify-content-between d-flex" role="alert">
                    <span>
                        {{ session()->get('warning') }}
                    </span>
                    <a href="{{ route('user.cart') }}" class="alert-link">
                        Cek Keranjang <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            @endif
            <div class="row gx-5">
                <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5"
                        src="{{ route('public.product_thumbnail') . '?path=' . $product->thumbnail }}" alt="..." />
                </div>
                <div class="col-lg-8 col-xl-7 col-xxl-6">
                    <div class="my-5 text-xl-start">
                        <h1 class="display-6 mb-2">
                            {{ $product->name }}
                        </h1>
                        <p class="lead fw-normal mb-4">
                            Rp. {{ $product->price }}
                        </p>
                        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                            @if ($product->is_bought)
                                <span class="badge rounded-pill bg-info text-dark">
                                    Barang sudah dibeli
                                </span>
                            @endif
                            @if ($product->is_bought == false)
                                <a href="{{ route('user.add_product_to_cart', $product->id) }}"
                                    class="btn btn-primary btn-lg px-4 me-sm-3">
                                    <i class="bi bi-cart-plus"></i>
                                    Tambahkan ke keranjang
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <div class="row gx-5 mt-5">
                <h1 class="display-6 mb-2">
                    Description
                </h1>
                <hr>
                <p class="lead fw-normal mb-4">
                    {{ $product->description }}
                </p>
            </div>
        </div>
    </section>
</x-user.layout>
