<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Stocks</title>
    <link href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Stocks</h1>
        <table id="stocks-table" class="display">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
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
        });
    </script>
</body>
</html>
