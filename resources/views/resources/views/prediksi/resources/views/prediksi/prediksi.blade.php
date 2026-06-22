<h1>Hasil Prediksi Stok Obat</h1>
<p>Prediksi untuk besok: <strong>{{ $prediksi }}</strong></p>

<hr>
<h3>Data yang dikirim ke AI:</h3>
<ul>
    @foreach($dataStok as $stok)
        <li>{{ $stok }}</li>
    @endforeach
</ul>