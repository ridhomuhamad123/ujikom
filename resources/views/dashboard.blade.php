@extends('layouts.app')

@section('title', 'Dashboard')

@section('content') 
@if (session('success'))
<script>
    alert('{{ session('success') }}')
</script>
@endif
@if (session('tes'))
<script>
    alert('{{ session('tes') }}')
</script>
@endif

@if(Auth::user()->role == 'petugas')
<div class="container">
    <div class="row justify-content-center">

        {{-- <!-- Card Statistik -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <i class="fa fa-box fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Produk</h5>
                    <p class="fs-4">{{$totalProduct}}</p>
                </div>
            </div>
        </div> --}}

        <div class="d-flex justify-content-center align-items-center min-vh-100">
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body text-center">
                        <i class="fa fa-shopping-cart fa-3x text-success mb-3"></i>
                        <h5 class="fw-bold">Pembelian</h5>
                        <p class="fs-4">{{$totalPurchase}}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <i class="fa fa-users fa-3x text-warning mb-3"></i>
                    <h5 class="fw-bold">User</h5>
                    <p class="fs-4">{{$totalUser}}</p>
                </div>
            </div>
        </div> --}}

        {{-- <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <i class="fa fa-user fa-3x text-danger mb-3"></i>
                    <h5 class="fw-bold">Member</h5>
                    <p class="fs-4">{{$totalMember}}</p>
                </div>
            </div>
        </div> --}}

    </div>
</div>
@endif

@if(Auth::user()->role == 'admin')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Ini Halaman Dashboard</h3>
                <div class="row">
                    <div class="col-8">
                        <canvas id="myChart" width="368" height="184"></canvas>
                    </div>
                    <div class="col-4">
                        <canvas id="myChart2" width="170" height="170"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const barLabels = @json($barLabels);
        const barData = @json($barData);
        const pieLabels = @json($pieLabels);
        const pieData = @json($pieData);

        // Bar Chart
        const ctx = document.getElementById('myChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: barLabels,
                datasets: [{
                    label: 'Jumlah Penjualan',
                    data: barData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        const ctx2 = document.getElementById('myChart2').getContext('2d');
        const myPieChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    label: 'Persentase Penjualan Produk',
                    data: pieData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: {
                        display: true,
                        text: 'Persentase Penjualan Produk'
                    }
                }
            }
        });
    });
</script>
@endif
@endsection