<x-user.layout>
    @push('css')
        {{-- <link rel="stylesheet" href="{{ asset('css/datatable-bootstrap-5.min.css') }}">
        --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    @endpush

    <section class="py-5" id="features">
        <div class="container px-5 my-5">
            <div class="card">
                <div class="card-body">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 20%">ID Transaksi</th>
                                <th style="width: 40%">Nama Item</th>
                                <th style="width: 20%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($files as $file)
                                <tr>
                                    <td>
                                        <a href="{{ route('user.transaction_detail', $file->transaction->id) }}">
                                            {{ $file->transaction->id }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $file->product->name }}
                                    </td>
                                    <td>
                                        @if ($file->file != null)
                                            <a href="{{ route('user.download_file', $file->id) }}"
                                                class="btn btn-primary btn-sm openModalButton" id="openModalButton">
                                                Download
                                            </a>
                                        @endif

                                        @if ($file->link_gdrive != null)
                                            <a href="{{ $file->link_gdrive }}"
                                                class="btn btn-primary btn-sm openModalButton" id="openModalButton">
                                                Download (Google Drive)
                                            </a>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Perhatian!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Dengan ini anda setuju untuk tidak membagikan file ini kepada pihak lain.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmButton">Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>


    @push('js')
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script>
            const table = new DataTable('#example');

            // table.on('order.dt search.dt', function() {
            //     let i = 1;

            //     table
            //         .cells(null, 0, {
            //             search: 'applied',
            //             order: 'applied'
            //         })
            //         .every(function(cell) {
            //             this.data(i++);
            //         });
            // }).draw();

            // When the document is ready
            document.addEventListener("DOMContentLoaded", function() {
                // Select all buttons that open the modal
                const openModalButtons = document.querySelectorAll('.openModalButton');

                // Add click event listeners to each button
                openModalButtons.forEach(function(button) {
                    button.addEventListener('click', function(event) {
                        // Prevent the default action (redirecting)
                        event.preventDefault();

                        // Show the modal
                        const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                        modal.show();
                    });
                });

                // Select the confirmation button within the modal
                const confirmButton = document.getElementById('confirmButton');

                // Add a click event listener to the confirmation button
                confirmButton.addEventListener('click', function() {
                    // Hide the modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
                    modal.hide();

                    // Perform the redirect
                    window.location.href = document.querySelector('.openModalButton').getAttribute('href');
                });
            });
        </script>
    @endpush
</x-user.layout>
