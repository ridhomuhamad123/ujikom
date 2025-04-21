<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Penjualan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .info, .footer {
            margin-bottom: 20px;
        }
        .info p, .footer p {
            margin: 2px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>Bukti Penjualan</h2>

    <div class="info">
        <p><strong>Nama Pelanggan:</strong> {{ $sales->Member ? $sales->Member->username : 'NON-MEMBER' }}</p>
        <p><strong>No HP:</strong> {{ $sales->Member ? $sales->Member->no_phone : '-' }}</p>
        <p><strong>Poin:</strong> {{ $sales->Member ? $sales->Member->poin : '0' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales->details as $index => $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>Rp {{ number_format($detail->product->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p class="total">Total: Rp {{ number_format($sales->total_price, 0, ',', '.') }}</p>
        <p><strong>Tanggal Penjualan:</strong> {{ $sales->sale_date }}</p>
        <p><strong>Dibuat Oleh:</strong> {{ $sales->user ? $sales->user->username : 'Tidak Diketahui' }}</p>
        <p>Terima kasih telah berbelanja!</p>
    </div>

</body>
</html>