<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PembayaranController extends Controller
{
    /**
     * Halaman utama Kelola Pembayaran.
     *
     * Data dummy tidak berasal dari controller.
     * Data untuk review UI disimpan melalui localStorage browser.
     */
    public function index(): View
    {
        return view('admin.payment.pembayaran');
    }

    /**
     * Halaman detail pembayaran.
     *
     * Data pembayaran akan dibaca oleh JavaScript
     * berdasarkan ID dari localStorage.
     */
    public function show(string $id): View
    {
        return view('admin.pembayaran.show', [
            'paymentId' => $id,
        ]);
    }
}
