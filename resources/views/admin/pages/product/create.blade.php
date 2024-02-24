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
        <h1 class="h3 mb-0 text-gray-800">Tambah Produk</h1>
    </div>

    <div class="card">
        <div class="card-header">
            Detail Produk
        </div>
        <div class="card-body">
            <form action="{{ route('admin.store_product') }}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- Product Name -->
                <div class="form-group">
                    <label for="name">Nama Produk</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                        required>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Product Category -->
                <div class="form-group">
                    <label for="price">Kategori</label>
                    <div class="form-group">
                        <label for="select_category">Cari berdasarkan nama kategori atau
                            <a href="{{ route('admin.create_category') }}" class="btn btn-primary btn-sm"
                                target="_blank">
                                tambah kategori baru
                            </a>
                        </label>
                        <select class="form-control" name="category_id[]" id="select_category" multiple="multiple">
                            @if (old('category_id') != null)
                                @foreach (old('category_id') as $key => $value)
                                    <option value="{{ $value }}" selected>
                                        {{ App\Models\Category::find($value)->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('category_id')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                </div>

                <!-- Product Thumbnail -->
                <div class="form-group">
                    <label for="thumbnail">Thumbnail</label>
                    <input type="file" class="form-control-file" id="thumbnail" name="thumbnail" accept="image/*">
                    @error('thumbnail')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Product Description -->
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Product File -->
                <div class="form-group">
                    <label for="file">File</label>
                    <input type="file" class="form-control-file" id="file" name="file">
                    @error('file')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Link Gdrive -->
                <div class="form-group">
                    <label for="link_gdrive">Link Google Drive (jika file sudah ada)</label>
                    <textarea class="form-control" id="link_gdrive" name="link_gdrive" rows="3">{{ old('link_gdrive') }}</textarea>
                    @error('link_gdrive')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Product Price -->
                <div class="form-group">
                    <label for="price">Harga</label>
                    <input type="number" class="form-control" id="price" name="price"
                        value="{{ old('price') }}">
                    @error('price')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Product Group -->
                <div class="form-group">
                    <label for="price">Group</label>
                    <div class="form-group">
                        <label for="select_group">Cari berdasarkan nama grup atau
                            <a href="{{ route('admin.create_group') }}" class="btn btn-primary btn-sm" target="_blank">
                                tambah grup baru
                            </a>
                        </label>
                        <select class="form-control" name="group_id" id="select_group">
                            @if (old('group_id') != null)
                                @foreach (old('group_id') as $key => $value)
                                    <option value="{{ $value }}" selected>
                                        {{ App\Models\Group::find($value)->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('group_id')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#select_category').select2({
                    theme: "bootstrap",
                    ajax: {
                        url: "{{ route('admin.get_category_by_name') }}",
                        dataType: 'json',
                        delay: 250,
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.name,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                });

                $('#select_group').select2({
                    theme: "bootstrap",
                    ajax: {
                        url: "{{ route('admin.get_group_by_name') }}",
                        dataType: 'json',
                        delay: 250,
                        processResults: function(data) {
                            // console.log(data);
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.name,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                });
            });
        </script>
    @endpush

</x-admin.layout>
