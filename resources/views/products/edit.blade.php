@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm p-4">
        <h2 class="fw-bold mb-4 text-center">Edit Produk</h2>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Produk</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Harga</label>
                <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Stok</label>
                <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Gambar Produk</label>
                <input type="file" name="image" class="form-control">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="mt-2 rounded shadow-sm" style="width: 100px; height: 100px; object-fit: cover;">
                @endif
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('products.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update</button>
            </div>
        </form>
    </div>
</div>
@endsection