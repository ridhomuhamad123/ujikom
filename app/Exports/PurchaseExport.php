<?php

namespace App\Exports;

use App\Models\Purchase;
use App\Models\Sale;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Purchase::all();
    }

    public function map($sales): array
    {
        $products = $sales->details->map(function ($detail) {
            return "{$detail->product->name} ({$detail->quantity} : Rp. " . number_format($detail->sub_total, 0, ',', '.') . ")";
        })->implode(', ');
        return [
            $sales->member->name ?? 'Bukan Member',
            $sales->member->no_phone ?? '-',
            $sales->member->poin ?? '-',
            $products ?: '-',
            "Rp. " . number_format($sales->total_price, 0, ',', '.'),
            "Rp. " . number_format($sales->total_pay, 0, ',', '.'),
            $sales->total_poin,
            $sales->total_return,
            $sales->sale_date,
        ];
    }

    public function headings(): array
    {
        return [
            'Member',
            'No. HP',
            'Poin',
            'Produk',
            'Total Harga',
            'Total Bayar',
            'Total Poin',
            'Total Kembalian',
            'Tanggal Transaksi',
        ];
    }
}