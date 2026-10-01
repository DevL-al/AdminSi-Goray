@extends('layouts.admin')

@section('content')
    {{-- <div class="page-header">
        <div>
            <h1>Dashboard</h1>
            <p>Ringkasan aktivitas GOR A. Yani hari ini.</p>
        </div>
    </div> --}}
    
    <h1>BERHASIL</h1>

    <p>Login Admin Berhasil</p>

    {{-- =========================
     STATISTIC CARDS
========================= --}}

    {{-- <div class="stats-grid"> --}}

        {{-- Total User --}}
        {{-- <div class="stat-card">
            <div class="stat-icon">
                <span class="material-symbols-rounded">
                    group
                </span>
            </div>

            <div class="stat-content">
                <span class="stat-label">
                    Total User
                </span>

                <h2>
                    {{ number_format($stats['users']) }}
                </h2>
            </div>
        </div> --}}


        {{-- Booking Hari Ini --}}
        {{-- <div class="stat-card">
            <div class="stat-icon">
                <span class="material-symbols-rounded">
                    calendar_month
                </span>
            </div>

            <div class="stat-content">
                <span class="stat-label">
                    Booking Hari Ini
                </span>

                <h2>
                    {{ number_format($stats['booking_today']) }}
                </h2>
            </div>
        </div> --}}


        {{-- Kuota Hari Ini --}}
        {{-- <div class="stat-card">
            <div class="stat-icon">
                <span class="material-symbols-rounded">
                    confirmation_number
                </span>
            </div>

            <div class="stat-content">
                <span class="stat-label">
                    Kuota Hari Ini
                </span>

                <h2>
                    {{ number_format($stats['quota_today']) }}
                </h2>
            </div>
        </div> --}}


        {{-- Event --}}
        {{-- <div class="stat-card">
            <div class="stat-icon">
                <span class="material-symbols-rounded">
                    event
                </span>
            </div>

            <div class="stat-content">
                <span class="stat-label">
                    Event Aktif
                </span>

                <h2>
                    {{ number_format($stats['active_events']) }}
                </h2>
            </div>
        </div>

    </div> --}}


    {{-- =========================
     RINGKASAN
========================= --}}

    {{-- <div class="dashboard-grid">

        <div class="dashboard-card">

            <div class="card-header">
                <div>
                    <h3>Pendapatan</h3>
                    <p>Total pendapatan sementara</p>
                </div>

                <span class="material-symbols-rounded">
                    payments
                </span>
            </div>

            <div class="revenue-value">
                Rp {{ number_format($stats['revenue'], 0, ',', '.') }}
            </div>

        </div> --}}


        {{-- Event Booking
        <div class="dashboard-card">

            <div class="card-header">
                <div>
                    <h3>Booking Event</h3>
                    <p>Total booking event</p>
                </div>

                <span class="material-symbols-rounded">
                    confirmation_number
                </span>
            </div>

            <div class="revenue-value">
                {{ number_format($stats['event_bookings']) }}
            </div>

        </div>

    </div> --}}


    {{-- =========================
     GRAFIK
========================= --}}

    {{-- <div class="dashboard-card chart-card">

        <div class="card-header">

            <div>
                <h3>Statistik Booking</h3>
                <p>Data booking 7 hari terakhir</p>
            </div>

        </div>

        <div class="chart-container">
            <canvas id="bookingChart"></canvas>
        </div>

    </div> --}}
@endsection
