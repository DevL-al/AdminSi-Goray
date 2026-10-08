```blade
@extends('layouts.admin')

@section('content')

<div class="ticket-management">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="ticket-page-header">

        <div class="ticket-page-title">
            <h1>Kelola Tiket Event</h1>

            <p>
                Event untuk Jual Tiket Event — Warga Kota gratis,
                Non-Warga bayar retribusi + harga tiket event.
            </p>
        </div>

        <a href="#" class="btn-add-event">
            <span class="material-symbols-rounded">add</span>
            Tambah Event
        </a>

    </div>


    {{-- =========================================================
        INFO
    ========================================================== --}}
    <div class="ticket-info">

        <span class="material-symbols-rounded">warning</span>

        <span>
            Warga Kota Mojokerto gratis untuk semua event.
            Non-Warga dikenakan retribusi + harga tiket event.
            Kuota diatur per event.
        </span>

    </div>


    {{-- =========================================================
        FILTER
    ========================================================== --}}
    <div class="ticket-filter">

        <button class="ticket-filter-item active">
            Semua <span>(9)</span>
        </button>

        <button class="ticket-filter-item">
            Aktif <span>(5)</span>
        </button>

        <button class="ticket-filter-item">
            Selesai <span>(3)</span>
        </button>

        <button class="ticket-filter-item">
            Dibatalkan <span>(1)</span>
        </button>

    </div>


    {{-- =========================================================
        DATA EVENT
    ========================================================== --}}
    @php
        $events = [
            [
                'date' => '10 - 15 Sep',
                'year' => '2026',
                'name' => 'Futsal Tournament 2026',
                'category' => 'Kompetisi futsal antar kecamatan',
                'description' => 'Futsal Tournament 2026 merupakan kompetisi futsal antar sekolah dan komunitas di Kota Mojokerto.',
                'location' => 'Lapangan Utama',
                'price' => 'Rp 75.000',
                'quota' => 300,
                'sold' => 278,
                'status' => 'Aktif',
                'status_class' => 'active',
            ],

            [
                'date' => '10 - 15 Sep',
                'year' => '2026',
                'name' => 'Futsal Tournament 2026',
                'category' => 'Kompetisi futsal antar kecamatan',
                'description' => 'Futsal Tournament 2026 merupakan kompetisi futsal antar sekolah dan komunitas di Kota Mojokerto.',
                'location' => 'Lapangan Utama',
                'price' => 'Rp 75.000',
                'quota' => 300,
                'sold' => 278,
                'status' => 'Aktif',
                'status_class' => 'active',
            ],

            [
                'date' => '10 - 15 Sep',
                'year' => '2026',
                'name' => 'Futsal Tournament 2026',
                'category' => 'Kompetisi futsal antar kecamatan',
                'description' => 'Futsal Tournament 2026 merupakan kompetisi futsal antar sekolah dan komunitas di Kota Mojokerto.',
                'location' => 'Lapangan Utama',
                'price' => 'Rp 75.000',
                'quota' => 300,
                'sold' => 278,
                'status' => 'Aktif',
                'status_class' => 'active',
            ],
        ];
    @endphp


    {{-- =========================================================
        EVENT CARD
    ========================================================== --}}
    <div class="ticket-event-card">

        {{-- CARD HEADER --}}
        <div class="ticket-card-header">

            <div class="ticket-month">

                <span class="material-symbols-rounded">
                    calendar_month
                </span>

                <span>
                    Event Bulan September
                </span>

            </div>


            {{-- DATE NAVIGATION --}}
            <div class="ticket-date-navigation">

                <button type="button">

                    <span class="material-symbols-rounded">
                        chevron_left
                    </span>

                    <span>
                        10 September 2026
                    </span>

                    <span class="material-symbols-rounded">
                        chevron_right
                    </span>

                </button>

            </div>

        </div>


        {{-- =====================================================
            TABLE
        ====================================================== --}}
        <div class="ticket-table-container">

            <table class="ticket-management-table">

                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Event</th>
                        <th>Deskripsi</th>
                        <th>Lokasi</th>
                        <th>Harga Tiket</th>
                        <th>Kuota</th>
                        <th>Terjual</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>


                <tbody>

                    @foreach ($events as $event)

                        <tr>

                            {{-- TANGGAL --}}
                            <td>
                                <strong>
                                    {{ $event['date'] }}
                                </strong>

                                <small>
                                    {{ $event['year'] }}
                                </small>
                            </td>


                            {{-- NAMA EVENT --}}
                            <td>

                                <strong>
                                    {{ $event['name'] }}
                                </strong>

                                <small>
                                    {{ $event['category'] }}
                                </small>

                            </td>


                            {{-- DESKRIPSI --}}
                            <td>

                                <div class="event-description-table">
                                    {{ $event['description'] }}
                                </div>

                            </td>


                            {{-- LOKASI --}}
                            <td>

                                <div class="event-location">

                                    <span class="material-symbols-rounded">
                                        location_on
                                    </span>

                                    {{ $event['location'] }}

                                </div>

                            </td>


                            {{-- HARGA --}}
                            <td>

                                <strong>
                                    {{ $event['price'] }}
                                </strong>

                                <small class="event-free">
                                    Warga Kota : Gratis
                                </small>

                            </td>


                            {{-- KUOTA --}}
                            <td>
                                {{ $event['quota'] }}
                            </td>


                            {{-- TERJUAL --}}
                            <td>
                                {{ $event['sold'] }}
                            </td>


                            {{-- STATUS --}}
                            <td>

                                <span class="event-status {{ $event['status_class'] }}">
                                    {{ $event['status'] }}
                                </span>

                            </td>


                            {{-- AKSI --}}
                            <td>

                                <div class="event-actions">

                                    {{-- LIHAT --}}
                                    <a href="#" title="Lihat Event">

                                        <span class="material-symbols-rounded">
                                            visibility
                                        </span>

                                        Lihat

                                    </a>


                                    {{-- EDIT --}}
                                    <a href="#" title="Edit Event">

                                        <span class="material-symbols-rounded">
                                            edit
                                        </span>

                                        Edit

                                    </a>


                                    {{-- HAPUS --}}
                                    <button
                                        type="button"
                                        title="Hapus Event"
                                    >

                                        <span class="material-symbols-rounded">
                                            delete
                                        </span>

                                        Hapus

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
```
