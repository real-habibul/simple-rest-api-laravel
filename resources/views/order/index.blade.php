<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pesanan / Order</title>
    <link href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Pesanan / Order</h1>
        <table id="order-table" class="display">
            <thead>
                <tr>
                    <th>pesanan_id</th>
                    <th>no_pesanan</th>
                    <th>tgl_pesanan</th>
                    <th>nama_lengkap_user</th>
                    <th>total_harga</th>
                    <th>jumlah_produk</th>
                </tr>
            </thead>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var stocksTable = $('#order-table').DataTable({
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Pesanan...",
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
                    zeroRecords: "No matching records found",
                },
                processing: true,
                serverSide: false,
                ajax: {
                    url: "http://localhost:8000/api/v1/orders/get-all",
                    type: 'GET',
                    dataSrc: 'data',
                },
                columns: [
                    {data: 'pesanan_id', name: 'pesanan_id'},
                    {data: 'no_pesanan', name: 'no_pesanan'},
                    {data: 'tgl_pesanan', name: 'tgl_pesanan'},
                    {data: 'nama_lengkap_user', name: 'nama_lengkap_user'},
                    {data: 'total_harga', name: 'total_harga'},
                    {data: 'jumlah_produk', name: 'jumlah_produk'}
                ]

            });
        });
    </script>
</body>
</html>
