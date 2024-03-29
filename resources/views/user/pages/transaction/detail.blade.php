<x-user.layout>
    <section class="py-5" id="features">

        <div class="container px-5 my-5">
            <div class="d-flex justify-content-center gx-5">
                <div class="col-lg-8 col-xl-7 col-xxl-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex">
                                <div class="col-6">
                                    <p class="mb-0">
                                        Barang
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-0">
                                        Harga
                                    </p>
                                </div>
                            </div>
                        </div>
                        @foreach($transaction->transactionItems as $item)
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="col-6">
                                        <p class="mb-0">
                                            {{ $item->product->name }}
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <p class="mb-0">
                                            Rp. {{ $item->product->price }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center gx-5">
                <div class="col-lg-8 col-xl-7 col-xxl-6">
                    <div class="d-flex p-3 pb-0">
                        <div class="col-6">
                            <h6 class="mb-2 fw-light">
                                Total Pembayaran
                            </h6>
                        </div>
                        <div class="col-6">
                            <h6 class="mb-2 fw-normal">
                                Rp. {{ $transaction->payment_amount }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center gx-5 mt-5">
                <div class="col-lg-8 col-xl-7 col-xxl-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex">
                                <div class="col-12">
                                    <p class="mb-0">
                                        Pembayaran
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex pb-0">
                                <div class="col-6">
                                    <h6 class="mb-2 fw-light">
                                        Metode Pembayaran
                                    </h6>
                                </div>
                                <div class="col-6">
                                    <h6 class="mb-2 fw-normal">
                                        {{ $transaction->payment_method }}
                                    </h6>
                                </div>
                            </div>
                            <div class="d-flex pb-0">
                                <div class="col-6">
                                    <h6 class="mb-2 fw-light">
                                        Rekening Pembayaran
                                    </h6>
                                </div>
                                <div class="col-6">
                                    <h6 class="mb-2 fw-normal">
                                        082342445456
                                    </h6>
                                </div>
                            </div>
                            <div class="d-flex pb-0">
                                <div class="col-6">
                                    <h6 class="mb-2 fw-light">
                                        ID Transaksi
                                    </h6>
                                </div>
                                <div class="col-6">
                                    <h6 class="mb-2 fw-normal">
                                        {{ $transaction->id }}
                                    </h6>
                                </div>
                            </div>
                            <div class="d-flex pb-0">
                                <div class="col-6">
                                    <h6 class="mb-2 fw-light">
                                        Tanggal Transaksi
                                    </h6>
                                </div>
                                <div class="col-6">
                                    <h6 class="mb-2 fw-normal">
                                        {{ $transaction->created_at->isoFormat('dddd, d MMMM Y, HH:mm:ss a') }}
                                    </h6>
                                </div>
                            </div>
                            <div class="d-flex pb-0">
                                <div class="col-6">
                                    <h6 class="mb-2 fw-light">
                                        Status Pembayaran
                                    </h6>
                                </div>
                                <div class="col-6">
                                    <h6 class="mb-2 fw-normal">
                                        {{ $transaction->status }}
                                    </h6>
                                </div>
                            </div>
                            @if($transaction->status == 'lunas')
                                <div class="d-flex pb-0">
                                    <div class="col-6">
                                        <h6 class="mb-2 fw-light">
                                            Tanggal Konfirmasi Pembayaran
                                        </h6>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="mb-2 fw-normal">
                                            {{ $transaction->updated_at }}
                                        </h6>
                                    </div>
                                </div>
                            @endif
                            @if($transaction->status == 'pending')
                                <div class="d-flex pb-0">
                                    <div class="col-6">
                                        <h6 class="mb-2 fw-light">
                                            Kirim bukti pembayaran ke
                                        </h6>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="mb-2 fw-normal">
                                            0894-xxx-xxx
                                        </h6>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-user.layout>
