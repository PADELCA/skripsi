<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>
        APOTIK LIMAS | AI Forecasting
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

    {{-- ===================== --}}
    {{-- SIDEBAR --}}
    {{-- ===================== --}}

    <aside class="sidebar">

        <div class="logo-area">

            <div class="logo-icon">

                💊

            </div>

            <h3>

                APOTIK LIMAS

            </h3>

            <small>

                AI Forecasting System

            </small>

            <div class="mt-3">

                <span class="badge bg-success">

                    <i class="fa-solid fa-circle-check"></i>

                    Model LSTM Aktif

                </span>

            </div>

        </div>

        <nav>

            <a
                href="/dashboard"
                class="{{ request()->is('dashboard') ? 'active' : '' }}">

                <i class="fa-solid fa-chart-pie"></i>

                Dashboard

            </a>

            <a
                href="/manajemen-data"
                class="{{ request()->is('manajemen-data*') ? 'active' : '' }}">

                <i class="fa-solid fa-database"></i>

                Dataset Historis

            </a>

            <a
                href="/prediksi"
                class="{{ request()->is('prediksi*') ? 'active' : '' }}">

                <i class="fa-solid fa-brain"></i>

                Forecasting

            </a>

            <a
                href="/laporan"
                class="{{ request()->is('laporan*') ? 'active' : '' }}">

                <i class="fa-solid fa-file-pdf"></i>

                Laporan

            </a>

        </nav>

        <div class="sidebar-footer">

            <hr>

            <small>

                Forecasting Stok Obat

            </small>

            <br>

            <small>

                Long Short-Term Memory

            </small>

            <br>

            <small>

                Version 1.0

            </small>

        </div>

    </aside>

    {{-- ===================== --}}
    {{-- MAIN --}}
    {{-- ===================== --}}

    <main class="main-content">

        <header class="topbar">

            <div>

                <h4 class="m-0">

                    Sistem Forecasting Stok Obat

                </h4>

                <small class="text-muted">

                    Dashboard Monitoring Artificial Intelligence

                </small>

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

                    <small class="text-muted">

                        Administrator

                    </small>

                </div>

                <div class="vr mx-2"></div>

                <div class="text-end">

                    <small>

                        {{ now()->format('d F Y') }}

                    </small>

                    <br>

                    <small class="text-success">

                        <i class="fa-solid fa-circle"></i>

                        Online

                    </small>

                </div>

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                    class="ms-3">

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-danger">

                        <i class="fa-solid fa-right-from-bracket"></i>

                        Logout

                    </button>

                </form>

            </div>

        </header>

        <section class="page-content">

            @yield('content')

        </section>

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>

</html>