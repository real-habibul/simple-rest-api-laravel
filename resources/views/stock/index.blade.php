<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Stocks</title>
    <link href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css.map') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <div class="container">
        <h1>Stocks</h1>
        <div class="row flex">
            <div class="col-md-4">
                <label id="label-leftside" class="w-100 text-center mb-3">Add Stock</label>
                <div id="stock-form" style="display">
                    <form id="add-stock-form">
                        <div class="mb-3">
                            <label for="nama-produk" class="form-label">Nama Produk</label>
                            <select class="form-control" id="nama-produk" name="nama_produk" multiple data-placeholder="Pilih Produk">
                                @foreach ($dataProduk as $produk)
                                    <option value="{{ $produk->nama }}">{{ $produk->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tambah-stok" class="form-label">Tambah Stok <small class="text-info">stock sekarang: 20</small> </label>
                            <input type="text" class="form-control" id="tambah-stok" name="tambah_stok">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <table id="stocks-table" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Produk ID</th>
                            <th>Nama Produk</th>
                            <th>Stok Sekarang</th>
                            <th>Stok Terjual</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    
    <!-- select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            var stocksTable = $('#stocks-table').DataTable({
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Stock...",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "&rarr;",
                        previous: "&larr;"
                    },
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    emptyTable: "No data available",
                    zeroRecords: "No matching records found"
                },
                processing: true,
                serverSide: false,
                ajax: {
                    url: "http://localhost:8000/api/v1/stocks/get-all",
                    type: 'GET',
                    dataSrc: 'data',
                },
                columns: [
                    {data: 'produk_id', name: 'produk_id'},
                    {data: 'nama_produk', name: 'nama_produk'},
                    {data: 'stok_sekarang', name: 'stok_sekarang'},
                    {data: 'stok_terjual', name: 'stok_terjual'}
                ]
            });

            // Show the stock form when the "Add Stock" button is clicked
            $('#add-stock-btn').click(function() {
                $('#stock-form').show();
            });

            // Handle the form submission to add a new stock entry
            $('#add-stock-form').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "http://localhost:8000/api/v1/stocks/add",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // If the stock is successfully added, update the DataTable
                        stocksTable.ajax.reload();
                        // Hide the form after successful submission
                        $('#stock-form').hide();
                        // Clear the form fields
                        $('#add-stock-form')[0].reset();
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error(error);
                    }
                });
            });

            // Handle search in nama-produk form field 
            $('#nama-produk').select2({
                placeholder: "Select a product",
                allowClear: true
            });
        });
    </script>
</body>
</html>
