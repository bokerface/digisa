<div class="card mt-2">
    <div class="card-header">
        Detail penjualan per kategori
    </div>
    <div class="card-body">
        @foreach ($sales['perCategory'] as $category)
            <div class=" mb-1">
                <div class="">
                    <h5 class="font-weight-bold">
                        {{ $category->name }}
                    </h5>
                    <span class="font-weight-light">
                        {{ $category->products->count() }} terjual
                    </span>
                </div>
            </div>
        @endforeach
    </div>
</div>
