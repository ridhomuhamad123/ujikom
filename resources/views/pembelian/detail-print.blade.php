@extends('layouts.app')

@section('title', 'penjualan')

@section('content')
<style>
    .invoice-price {
        background: #f0f3f4;
        display: table;
        width: 100%;
    }

    .invoice-price .invoice-price-left,
    .invoice-price .invoice-price-right {
        display: table-cell;
        padding: 20px;
        font-size: 20px;
        font-weight: 600;
        width: 75%;
        position: relative;
        vertical-align: middle;
    }

    .invoice-price .invoice-price-left .sub-price {
        display: table-cell;
        vertical-align: middle;
        padding: 0 20px;
    }

    .invoice-price small {
        font-size: 12px;
        font-weight: 400;
        display: block;
    }

    .invoice-price .invoice-price-row {
        display: table;
        float: left;
    }

    .invoice-price .invoice-price-right {
        width: 25%;
        background: #2d353c;
        color: #fff;
        font-size: 28px;
        text-align: right;
        vertical-align: bottom;
        font-weight: 300;
    }

    .invoice-price .invoice-price-right small {
        display: block;
        opacity: .6;
        position: absolute;
        top: 10px;
        left: 10px;
        font-size: 12px;
    }
</style>
<div class="container">
    <div class="row bg-light px-3 py-4 gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card p-4">
                <div class="card-body p-0">
                    <div class="invoice-container">
                        <div class="invoice-header">
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="custom-actions-btns mb-5">
                                        <a href="#"
                                            class="btn btn-primary">
                                            <i class="icon-download"></i> Unduh
                                        </a>
                                        <a href="{{ route('purchases.index') }}" class="btn btn-secondary">
                                            <i class="icon-printer"></i> Kembali
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row gutters">
                                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                    <div class="invoice-details">
                                        <div class="invoice-num">
                                            <div>Invoice - #{{ str_pad($purchase->id, 3, '0', STR_PAD_LEFT) }}</div>
                                            <div>{{ \Carbon\Carbon::parse($purchase->sale_date)->format('d F Y') }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                    <div class="invoice-details">
                                        <div class="invoice-num">
                                            <div>Nomor HP: {{ $purchase->Member->no_phone ?? '-' }}</div>
                                            <div>MEMBER SEJAK: {{ $purchase->Member ? \Carbon\Carbon::parse($purchase->Member->created_at)->format('d F Y') : 'Bukan Member' }}</div>
                                            <div>POIN MEMBER: {{ $purchase->Member->poin ?? 0 }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-body">
                            <div class="row gutters">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table custom-table m-0">
                                            <thead>
                                                <tr>
                                                    <th>Produk</th>
                                                    <th>Harga</th>
                                                    <th>Quantity</th>
                                                    <th>Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($purchase->details as $detail)
                                                    <tr class="service">
                                                        <td class="tableitem">
                                                            <p class="itemtext">{{ $detail->product->name ?? 'Produk' }}</p>
                                                        </td>
                                                        <td class="tableitem">
                                                            <p class="itemtext">Rp. {{ number_format($detail->product->price, 0, ',', '.') }}</p>
                                                        </td>
                                                        <td class="tableitem">
                                                            <p class="itemtext">{{ $detail->quantity }}</p>
                                                        </td>
                                                        <td class="tableitem">
                                                            <p class="itemtext">Rp. {{ number_format($detail->sub_total, 0, ',', '.') }}</p>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-price">
                            <div class="invoice-price-left">
                                <div class="invoice-price-row">
                                    <div class="sub-price">
                                        <small>POIN DIGUNAKAN</small>
                                        <span class="text-inverse">{{ $purchase->point_use }}</span>
                                    </div>
                                    <div class="sub-price">
                                        <small>KASIR</small>
                                        <span class="text-inverse">{{ $purchase->user->name ?? 'Kasir' }}</span>
                                    </div>
                                    <div class="sub-price">
                                        <small>uang yang diberi</small>
                                        <span class="text-inverse">Rp. {{ number_format($purchase->total_pay, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="sub-price">
                                        <small>KEMBALIAN</small>
                                        <span class="text-inverse">Rp. {{ number_format($purchase->total_return, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-price-right">
                                <small>TOTAL</small>
                                
                                @php
                                    $selectedDetails = $purchase->details->take(3);
                                    $selectedTotal = $selectedDetails->sum('sub_total');
                                @endphp
                            
                                <span class="f-w-600" style="text-decoration: line-through; text-decoration-color: red;">
                                    Rp. {{ number_format($selectedTotal, 0, ',', '.') }}
                                </span>
                                
                                <br>
                                <span class="f-w-600" style="text-decoration: none;">
                                    Rp. {{ number_format($purchase->total_price, 0, ',', '.') }}
                                </span>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection