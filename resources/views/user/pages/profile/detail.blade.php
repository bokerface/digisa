<x-user.layout>
    <section class="py-5" id="features">

        <div class="container px-5 my-5">
            @if (session()->has('success'))
                <div class="alert alert-success justify-content-between d-flex" role="alert">
                    <span>
                        {{ session()->get('success') }}
                    </span>
                </div>
            @endif

            @if (session()->has('warning'))
                <div class="alert alert-warning justify-content-between d-flex" role="alert">
                    <span>
                        {{ session()->get('warning') }}
                    </span>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger justify-content-between d-flex" role="alert">
                    <span>
                        {{ session()->get('error') }}
                    </span>
                </div>
            @endif

            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8 col-xl-7 col-xxl-8">
                    <div class="card">
                        <div class="card-header">
                            Profile
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.update_profile', $user->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" id="name"
                                        value="{{ $user->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="organization_name" class="form-label">Nama Instansi</label>
                                    <input type="text" name="organization_name"
                                        class="form-control @error('organization_name') is-invalid @enderror"
                                        id="organization_name" value="{{ $user->organization_name }}">
                                    @error('organization_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <a href="{{ route('user.edit_password') }}">Ubah Password</a>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-header">
                            Transaksi Saya
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <h5 class="font-weight-bold">Tagihan</h5>
                                {{ $unpaidTransactions->count() }} belum dibayar
                            </div>
                            <div class="mb-2">
                                <h5 class="font-weight-bold">File</h5>
                                {{ $downloadable->count() }} arsip dapat diunduh.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-user.layout>
