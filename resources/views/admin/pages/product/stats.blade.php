<x-admin.layout>
    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
            integrity="sha512-kq3FES+RuuGoBW3a9R2ELYKRywUEQv0wvPTItv3DSGqjpbNtGWVdvT8qwdKkqvPzT93jp8tSF4+oN4IeTEIlQA=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endpush
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Penjualan</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            Detail penjualan per produk
        </div>
        <div class="card-body">
            @foreach ($sales['perProduct'] as $product)
                <div class=" mb-1">
                    <div class="">
                        <h5 class="font-weight-bold">
                            {{ $product->name }}
                        </h5>
                        <span class="font-weight-light">
                            {{ $product->transactionItems->count() }} terjual
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-admin.layout>
