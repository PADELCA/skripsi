<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
   content="width=device-width, initial-scale=1">

<title>
    Apotik Limas
</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="{{ asset('css/style.css') }}">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="wrapper">


<aside class="sidebar">

    <div class="logo-area">

        <h4>
            💊 APOTIK LIMAS
        </h4>

        <small>
            AI Forecasting System
        </small>

    </div>

    <nav>

        <a href="/dashboard">

            <i class="fa-solid fa-house"></i>

            Dashboard

        </a>

        <a href="/manajemen-data">

            <i class="fa-solid fa-database"></i>

            Manajemen Data

        </a>

        <a href="/prediksi">

            <i class="fa-solid fa-chart-line"></i>

            Prediksi

        </a>

        <a href="/laporan">

            <i class="fa-solid fa-file-lines"></i>

            Laporan

        </a>

    </nav>

</aside>

<main class="main-content">

    <header class="topbar">

        <div>

            <h5 class="m-0">

                Sistem Prediksi Stok Obat

            </h5>

        </div>

<div class="profile-box">

    <div class="user-avatar">

        <i class="fa-solid fa-user"></i>

    </div>

    <div>

        <strong>

            {{ Auth::user()->name }}

        </strong>

        <br>

        <small>

            Administrator

        </small>

    </div>

    <form
        method="POST"
        action="{{ route('logout') }}">

        @csrf

        <button
            type="submit"
            class="btn btn-danger btn-sm">

            <i class="fa-solid fa-right-from-bracket"></i>

            Logout

        </button>

    </form>


    </header>

    <section class="page-content">

        @yield('content')

    </section>

</main>
```

</div>

</body>

</html>
