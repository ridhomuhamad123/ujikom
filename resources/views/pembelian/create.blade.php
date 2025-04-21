@extends('layouts.app')

@section('title', 'penjualan')

@section('content')
<div class="container">
    <div class="row">
        @foreach ($produks as $item)
        <div class="col-md-4 mb-4">
            <div class="card text-center p-3 shadow-sm">
                <td>
                    <img src="{{ asset('storage/' . $item->image) }}"
                    alt="{{ $item->name }}"
                    class="w-full h-48 object-cover rounded-md" />
                </td>
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="text-muted">Stok: <span id="stock-{{ $item->id }}">{{ $item->stock }}</span></p>
                    <p class="fw-bold">Rp. <span id="price-{{ $item->id }}">{{ number_format($item->price, 0, ',', '.') }}</span></p>

                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn btn-outline-secondary btn-sm" data-id="{{ $item->id }}" onclick="updateJumlah(this, 'decrement')">-</button>
                        <span class="mx-2 jumlah" id="jumlah-{{ $item->id }}">0</span>
                        <button class="btn btn-outline-secondary btn-sm" data-id="{{ $item->id }}" onclick="updateJumlah(this, 'increment')">+</button>
                    </div>

                    <p class="mt-2">Sub Total <strong>Rp. <span id="subtotal-{{ $item->id }}">0</span></strong></p>
                </div>
            </div>
        </div>
        @endforeach
        <div class="text-center">
            <form action="{{ route('purchases.post') }}" method="post">
                @csrf
                <input type="hidden" name="products" id="productsInput">
                <button type="submit" class="btn btn-primary">Selanjutnya</button>
            </form>
        </div>
    </div>
</div>

<script>
    function updateJumlah(element, action) {
        const id = element.getAttribute('data-id');
        const jumlahObject = document.getElementById('jumlah-' + id);
        const stockObject = document.getElementById('stock-' + id);
        const subtotalObject = document.getElementById('subtotal-' + id);
        const priceObject = document.getElementById('price-' + id);

        if (jumlahObject && priceObject) {
            let jumlah = parseInt(jumlahObject.textContent) || 0;
            let price = parseInt(priceObject.textContent.replace(/\D/g, '')) || 0;

            if (action === 'increment') {
                let stock = parseInt(stockObject?.textContent) || 0;
                if (jumlah < stock) {
                    jumlah += 1;
                } else {
                    alert('Stocknya kurang');
                    return;
                }
            } else if (action === 'decrement') {
                if (jumlah > 0) {
                    jumlah -= 1;
                } else {
                    alert('Tidak bisa dikurangi');
                    return;
                }
            }

            jumlahObject.textContent = jumlah;
            if (subtotalObject) {
                subtotalObject.textContent = new Intl.NumberFormat('id-ID').format(jumlah * price);
            }

            updateCart();
        } else {
            console.error("Elemen jumlah atau harga tidak ditemukan untuk ID: " + id);
        }
    }


    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("form");
        form.addEventListener("submit", function (event) {
            updateCart();
        });
    });

    function updateCart() {
            let selectedProducts = [];

        document.querySelectorAll(".jumlah").forEach(element => {
            let id = element.id.split("-")[1];
            let jumlah = parseInt(element.textContent) || 0;
            let price = parseInt(document.getElementById("price-" + id).textContent.replace(/\D/g, '')) || 0;
            let name = document.querySelector(`#jumlah-${id}`).closest('.card-body').querySelector('.card-title').textContent;

            if (jumlah > 0) {
                selectedProducts.push({
                    id: id,
                    name: name,
                    quantity: jumlah,
                    price: price,
                    subtotal: jumlah * price
                });
            }
        });

        document.getElementById("productsInput").value = JSON.stringify(selectedProducts);
    }

</script>
@endsection