<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PemesananController extends Controller
{
    /**
     * Menampilkan daftar booking.
     *
     * Untuk sementara menggunakan dummy data melalui session.
     * Nanti bagian ini dapat diganti dengan query Eloquent
     * berdasarkan tabel BOOKINGS dan relasinya.
     */
    public function index(Request $request): View
    {
        if (!$request->session()->has('dummy_bookings')) {
            $request->session()->put(
                'dummy_bookings',
                $this->dummyBookings()
            );
        }

        $bookings = collect(
            $request->session()->get(
                'dummy_bookings',
                []
            )
        );

        /*
         * Filter
         */
        $search = trim(
            (string) $request->query('search', '')
        );

        $type = $request->query('type', 'all');

        $paymentStatus = $request->query(
            'payment_status',
            'all'
        );

        $qrStatus = $request->query(
            'qr_status',
            'all'
        );

        $visitDate = $request->query(
            'visit_date',
            ''
        );

        if ($search !== '') {
            $bookings = $bookings->filter(
                function ($booking) use ($search) {
                    $search = strtolower($search);

                    return str_contains(
                        strtolower($booking['booking_code']),
                        $search
                    )
                    || str_contains(
                        strtolower($booking['user_name']),
                        $search
                    );
                }
            );
        }

        if ($type !== 'all') {
            $bookings = $bookings->filter(
                function ($booking) use ($type) {
                    return $booking['type'] === $type;
                }
            );
        }

        if ($paymentStatus !== 'all') {
            $bookings = $bookings->filter(
                function ($booking) use ($paymentStatus) {
                    return $booking['payment_status']
                        === $paymentStatus;
                }
            );
        }

        if ($qrStatus !== 'all') {
            $bookings = $bookings->filter(
                function ($booking) use ($qrStatus) {
                    return $booking['qr_status']
                        === $qrStatus;
                }
            );
        }

        if ($visitDate !== '') {
            $bookings = $bookings->filter(
                function ($booking) use ($visitDate) {
                    return $booking['visit_date']
                        === $visitDate;
                }
            );
        }

        /*
         * Statistik menggunakan seluruh booking,
         * bukan hasil filter.
         */
        $allBookings = collect(
            $request->session()->get(
                'dummy_bookings',
                []
            )
        );

        $statistics = [
            'total' => $allBookings->count(),

            'regular' => $allBookings
                ->where('type', 'regular')
                ->count(),

            'event' => $allBookings
                ->where('type', 'event')
                ->count(),

            'paid' => $allBookings
                ->where('payment_status', 'paid')
                ->count(),

            'pending' => $allBookings
                ->where('payment_status', 'pending')
                ->count(),

            'failed' => $allBookings
                ->where('payment_status', 'failed')
                ->count(),

            'qr_active' => $allBookings
                ->where('qr_status', 'active')
                ->count(),

            'qr_used' => $allBookings
                ->where('qr_status', 'used')
                ->count(),
        ];

        return view(
            'admin.booking.pemesanan',
            [
                'bookings' => $bookings->values(),
                'statistics' => $statistics,
                'filters' => [
                    'search' => $search,
                    'type' => $type,
                    'payment_status' => $paymentStatus,
                    'qr_status' => $qrStatus,
                    'visit_date' => $visitDate,
                ],
            ]
        );
    }

    /**
     * Menampilkan detail booking.
     */
    public function show(
        Request $request,
        string $bookingCode
    ): View {
        $bookings = collect(
            $request->session()->get(
                'dummy_bookings',
                $this->dummyBookings()
            )
        );

        $booking = $bookings->first(
            function ($booking) use ($bookingCode) {
                return $booking['booking_code']
                    === $bookingCode;
            }
        );

        if (!$booking) {
            abort(404);
        }

        return view(
            'admin.booking.show',
            [
                'booking' => $booking,
            ]
        );
    }

    /**
     * Dummy data sementara.
     *
     * Struktur dibuat mengikuti relasi ERD:
     *
     * BOOKING
     * ├── USER / IDENTITY
     * ├── REGULAR_SLOT atau EVENT_SCHEDULE
     * ├── PAYMENT_TRANSACTIONS
     * ├── QR_TICKETS
     * └── ACCESS_LOGS
     */
    private function dummyBookings(): array
    {
        return [
            [
                'booking_code' => 'BKG-0124',

                'user_id' => 101,
                'user_name' => 'Budi Santoso',
                'identity_name' => 'Budi Santoso',
                'nik_masked' => '3578********1234',
                'is_warga_kota' => true,

                'type' => 'regular',

                'regular_slot_id' => 12,
                'event_schedule_id' => null,

                'schedule_title' => 'Kunjungan Reguler',
                'schedule_detail' => '10 Oktober 2026 · 08:00–17:00',

                'visit_date' => '2026-10-10',

                'amount' => 0,

                'payment_status' => 'free',

                'payment_transactions' => [],

                'qr_status' => 'active',

                'qr_tickets' => [
                    [
                        'code' => 'QR-0124-002',
                        'status' => 'active',
                        'valid_until' => '2026-10-10 23:59',
                        'created_at' => '2026-10-07 07:42',
                        'regenerated_from' => 'QR-0124-001',
                    ],
                    [
                        'code' => 'QR-0124-001',
                        'status' => 'invalid',
                        'valid_until' => '2026-10-10 23:59',
                        'created_at' => '2026-10-07 07:40',
                        'regenerated_from' => null,
                    ],
                ],

                'access_logs' => [],

                'created_at' => '2026-10-07 07:35',
            ],

            [
                'booking_code' => 'BKG-0123',

                'user_id' => 102,
                'user_name' => 'Siti Rahayu',
                'identity_name' => 'Siti Rahayu',
                'nik_masked' => '3579********6721',
                'is_warga_kota' => false,

                'type' => 'event',

                'regular_slot_id' => null,
                'event_schedule_id' => 25,

                'schedule_title' => 'Futsal Tournament 2026',
                'schedule_detail' => '12 Oktober 2026 · 13:00–17:00',

                'visit_date' => '2026-10-12',

                'amount' => 90000,

                'payment_status' => 'paid',

                'payment_transactions' => [
                    [
                        'code' => 'PAY-0123-001',
                        'amount' => 90000,
                        'method' => 'QRIS',
                        'status' => 'failed',
                        'created_at' => '2026-10-07 06:50',
                    ],
                    [
                        'code' => 'PAY-0123-002',
                        'amount' => 90000,
                        'method' => 'QRIS',
                        'status' => 'paid',
                        'created_at' => '2026-10-07 07:10',
                    ],
                ],

                'qr_status' => 'active',

                'qr_tickets' => [
                    [
                        'code' => 'QR-0123-001',
                        'status' => 'active',
                        'valid_until' => '2026-10-12 23:59',
                        'created_at' => '2026-10-07 07:15',
                        'regenerated_from' => null,
                    ],
                ],

                'access_logs' => [],

                'created_at' => '2026-10-07 06:45',
            ],

            [
                'booking_code' => 'BKG-0122',

                'user_id' => 103,
                'user_name' => 'Agus Pratama',
                'identity_name' => 'Agus Pratama',
                'nik_masked' => '3578********4456',
                'is_warga_kota' => false,

                'type' => 'regular',

                'regular_slot_id' => 13,
                'event_schedule_id' => null,

                'schedule_title' => 'Kunjungan Reguler',
                'schedule_detail' => '11 Oktober 2026 · 08:00–17:00',

                'visit_date' => '2026-10-11',

                'amount' => 10000,

                'payment_status' => 'pending',

                'payment_transactions' => [
                    [
                        'code' => 'PAY-0122-001',
                        'amount' => 10000,
                        'method' => 'QRIS',
                        'status' => 'pending',
                        'created_at' => '2026-10-07 07:20',
                    ],
                ],

                'qr_status' => 'none',

                'qr_tickets' => [],

                'access_logs' => [],

                'created_at' => '2026-10-07 07:18',
            ],

            [
                'booking_code' => 'BKG-0121',

                'user_id' => 104,
                'user_name' => 'Dewi Lestari',
                'identity_name' => 'Dewi Lestari',
                'nik_masked' => '3579********8910',
                'is_warga_kota' => false,

                'type' => 'event',

                'regular_slot_id' => null,
                'event_schedule_id' => 26,

                'schedule_title' => 'Badminton Open 2026',
                'schedule_detail' => '13 Oktober 2026 · 09:00–12:00',

                'visit_date' => '2026-10-13',

                'amount' => 50000,

                'payment_status' => 'paid',

                'payment_transactions' => [
                    [
                        'code' => 'PAY-0121-001',
                        'amount' => 50000,
                        'method' => 'Virtual Account',
                        'status' => 'paid',
                        'created_at' => '2026-10-06 16:20',
                    ],
                ],

                'qr_status' => 'used',

                'qr_tickets' => [
                    [
                        'code' => 'QR-0121-001',
                        'status' => 'used',
                        'valid_until' => '2026-10-13 23:59',
                        'created_at' => '2026-10-06 16:25',
                        'regenerated_from' => null,
                    ],
                ],

                'access_logs' => [
                    [
                        'scanned_at' => '2026-10-13 08:42',
                        'officer' => 'Andi Saputra',
                        'result' => 'accepted',
                    ],
                ],

                'created_at' => '2026-10-06 16:15',
            ],

            [
                'booking_code' => 'BKG-0120',

                'user_id' => 105,
                'user_name' => 'Rizky Maulana',
                'identity_name' => 'Rizky Maulana',
                'nik_masked' => '3578********3344',
                'is_warga_kota' => false,

                'type' => 'event',

                'regular_slot_id' => null,
                'event_schedule_id' => 27,

                'schedule_title' => 'Basket Community Day',
                'schedule_detail' => '14 Oktober 2026 · 14:00–17:00',

                'visit_date' => '2026-10-14',

                'amount' => 75000,

                'payment_status' => 'failed',

                'payment_transactions' => [
                    [
                        'code' => 'PAY-0120-001',
                        'amount' => 75000,
                        'method' => 'QRIS',
                        'status' => 'failed',
                        'created_at' => '2026-10-06 15:20',
                    ],
                ],

                'qr_status' => 'none',

                'qr_tickets' => [],

                'access_logs' => [],

                'created_at' => '2026-10-06 15:15',
            ],
        ];
    }
}