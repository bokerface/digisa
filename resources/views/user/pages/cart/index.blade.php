<x-user.layout>
    <section class="py-5" id="features">

        <div class="container px-5 my-5">
            @if (session()->has('success'))
                <div class="alert alert-success justify-content-between d-flex" role="alert">
                    <span>
                        {{ session()->get('success') }}
                    </span>
                    <a href="{{ route('public.product_collections') }}" class="alert-link">
                        Lanjut Belanja <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            @endif

            @if (session()->has('warning'))
                <div class="alert alert-warning justify-content-between d-flex" role="alert">
                    <span>
                        {{ session()->get('warning') }}
                    </span>
                    <a href="{{ route('public.product_collections') }}" class="alert-link">
                        Lanjut Belanja <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            @endif

            <div class="row gx-5">
                <div class="col-lg-8 col-xl-7 col-xxl-6">
                    <div class="my-5 text-xl-start">
                        <h1 class="display-6 mb-2 fw-bolder">
                            Keranjang
                        </h1>
                    </div>
                </div>
            </div>
            <div class="row gx-5">
                <div class="col-lg-8 col-xl-7 col-xxl-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex">
                                <div class="col-5">Barang</div>
                                <div class="col-5">Harga</div>
                                <div class="col-2"></div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($cart['cartItems'] == null)
                                <p class="text-center">
                                    Keranjang anda kosong
                                </p>
                            @else
                                @foreach ($cart['cartItems'] as $item)
                                    <div class="d-flex mb-2">
                                        <div class="col-5">{{ $item->product->name }}</div>
                                        <div class="col-5">Rp. {{ $item->product->price }}</div>
                                        <div class="col-2 d-flex justify-content-end">
                                            <form action="{{ route('user.remove_item_from_cart', $item->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="badge bg-danger">
                                                    hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-xl-4 col-xxl-4 align-items-center">
                    <div class="text-xl-start mb-5">
                        <h4 class="mb-2">
                            Total Keranjang
                        </h4>
                    </div>
                    <div class="text-xl-start d-flex">
                        <div class="col-6">
                            <h5 class="mb-2 fw-light">
                                Subtotal
                            </h5>

                        </div>
                        <div class="col-6">
                            <h5 class="mb-2 fw-normal">
                                Rp. {{ $cart['subTotal'] }}
                            </h5>
                        </div>
                    </div>
                    <hr>

                    <div class="text-xl-start d-flex mb-5">
                        <div class="col-6">
                            <h5 class="mb-2 fw-light">
                                Total
                            </h5>

                        </div>
                        <div class="col-6">
                            <h5 class="mb-2 fw-normal">
                                Rp. {{ $cart['total'] }}
                            </h5>
                        </div>
                    </div>


                    <a href="{{ route('user.proceed_to_payment') }}"
                        class="text-dark nav-link display-6 fs-5 text-center">
                        Lanjutkan ke pembayaran <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-user.layout>
