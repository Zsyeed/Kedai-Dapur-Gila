<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Laporan Penjualan Dapur Gila Ramen</h2>
    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $report)
            <tr>
                <td>#{{ $report->id }}</td>
                <td>{{ $report->kode_transaksi }}</td>
                <td>{{ $report->created_at->format('d/m/Y') }}</td>
                <td>Rp {{ number_format($report->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>