@extends('layouts.app')

@section('title', 'lihat')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <h5>Nama: {{ $purchase->Member ? $purchase->Member->name : 'NON-MEMBER' }}</h5>
                                <h5>No Hp: {{ $purchase->Member ? $purchase->Member->no_phone : '0' }}</h5>
                                <h5>Poin: {{ $purchase->Member ? $purchase->Member->poin : '0' }}</h5>

                                @foreach($purchase->details as $detail)
                                    <p>Nama Produk: {{ $detail->product->name }}</p>
                                    <p>qty: {{ $detail->quantity }}</p>
                                    <p>Total Harga: Rp. {{ number_format($detail->product->price, 0, '', '.') }}</p>
                                    <p>Sub Total: Rp. {{ number_format($detail->sub_total, 0, '', '.') }}</p>
                                @endforeach
                                <p>total: {{ $purchase->total_price }}</p>
                                <p>Tanggal: {{ $purchase->sale_date }}</p>
                                <p>Oleh: {{ $purchase->user->username }}</p>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection