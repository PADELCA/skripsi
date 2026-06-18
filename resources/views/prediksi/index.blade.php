@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card p-4 shadow-sm mb-4" style="height: 400px;"> 
        <h3>Hasil Prediksi AI</h3>
        <hr>
        <canvas id="grafikStok"></canvas>
    </div>

    <div class="card p-4 shadow-sm">
        <h5>Prediksi Stok Berikutnya: <strong>{{ $prediksi }}</strong></h5>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
window.addEventListener('load', function() {
    // 1. Ambil data dengan aman
    const dataStok = {!! json_encode($dataStok) !!};
    
    const canvas = document.getElementById('grafikStok');
    
    if (canvas) {
        const ctx = canvas.getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['H-7', 'H-6', 'H-5', 'H-4', 'H-3', 'H-2', 'Hari Ini'],
                datasets: [{
                    label: 'Data Historis (Jumlah Terjual)',
                    data: dataStok,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
});
</script>
@endsection