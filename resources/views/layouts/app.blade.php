<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotik Riski</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="d-flex">
        <div class="bg-dark text-white p-3" style="width: 250px; min-height: 100vh;">
            <h4>APOTIK RISKI</h4>
            <hr>
            <nav class="nav flex-column">
                <a href="/prediksi" class="nav-link text-white">Modul Prediksi</a>
            </nav>
        </div>

        <div class="p-4 flex-grow-1">
            @yield('content')
        </div>
    </div>

</body>
</html>