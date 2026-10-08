<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // ==========================================
        // DUMMY DATA
        // Nanti bagian ini tinggal diganti database
        // ==========================================

        $stats = [
            'users' => 1284,

            'booking_today' => 87,

            'quota_today' => 200,

            'event_bookings' => 333,

            'active_events' => 5,

            'revenue' => 12600000,
        ];

        return view('admin.dashboard', compact('stats'));
    }
}