@extends('layouts.main')

@section('title', 'User Dashboard')

@section('content')
<div class="container-fluid">

    {{-- INFO CARD --}}
    <div class="row mb-4">

        {{-- TOTAL BUKU --}}
        <div class="col-md-6 stretch-card grid-margin">
            <div class="card bg-gradient-danger text-white">
                <div class="card-body">
                    <h4>Total Buku</h4>
                    <h2>{{ $totalBuku }}</h2>
                </div>
            </div>
        </div>

        {{-- TOTAL KATEGORI --}}
        <div class="col-md-6 stretch-card grid-margin">
            <div class="card bg-gradient-info text-white">
                <div class="card-body">
                    <h4>Total Kategori</h4>
                    <h2>{{ $totalKategori }}</h2>
                </div>
            </div>
        </div>

    </div>

    {{-- CHART --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>Statistik Data</h5>
                    <canvas id="dashboardChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('dashboardChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Buku', 'Kategori'],
        datasets: [{
            label: 'Jumlah Data',
            data: [
                {{ $totalBuku }},
                {{ $totalKategori }}
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endsection
