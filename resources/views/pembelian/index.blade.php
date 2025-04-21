@extends('layouts.app')

@section('content')
<div class="ml-64 p-6 mt-10 bg-white rounded-lg shadow-md min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-700">Data Pembelian</h2>
        <a href="{{ route('purchases.export_excel') }}" class="btn btn-primary">Export Penjualan (.xlsx)</a>

        @if(Auth::user()->role == 'petugas')
        <a href="{{route('purchases.create')}}" class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded">
            + Tambah Pembelian
        </a>
        @endif
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pelanggan</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Penjualan</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat Oleh</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($purchase as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">
                        {{ $item->member ? $item->Member->name : 'NON-MEMBER' }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">
                        {{ \Carbon\Carbon::parse($item->sale_date)->format('d-m-Y') }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">
                        Rp {{ number_format($item->total_pay, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">
                        {{ $item->user ? $item->user->username : '-' }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap space-x-2">
                        <a href="{{ route('purchases.lihat', $item['id']) }}" class="bg-black text-white px-3 py-1 rounded text-sm hover:bg-gray-800">Lihat</a>
                        <a href="{{ route('purchases.export-pdf', $item['id']) }}" class="btn btn-primary btn-sm">Unduh BUkti</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection