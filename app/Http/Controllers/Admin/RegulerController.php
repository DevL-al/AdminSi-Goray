<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RegulerController extends Controller
{
    /**
     * Default jam operasional sistem.
     *
     * Nanti bisa dipindahkan ke config/database
     * jika backend sudah tersedia.
     */
    private function defaultStartTime(): string
    {
        return '08:00';
    }

    private function defaultEndTime(): string
    {
        return '17:00';
    }


    /**
     * Menampilkan daftar slot/kuota harian.
     */
    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | DUMMY DATA
        |--------------------------------------------------------------------------
        */

        if (!$request->session()->has('dummy_reguler_slots_v2')) {

            $dummySlots = [
                [
                    'date' => '2026-09-10',
                    'start_time' => $this->defaultStartTime(),
                    'end_time' => $this->defaultEndTime(),
                    'quota' => 500,
                    'used' => 200,
                    'status' => 'active',
                ],
                [
                    'date' => '2026-09-11',
                    'start_time' => $this->defaultStartTime(),
                    'end_time' => $this->defaultEndTime(),
                    'quota' => 500,
                    'used' => 500,
                    'status' => 'active',
                ],
                [
                    'date' => '2026-09-12',
                    'start_time' => $this->defaultStartTime(),
                    'end_time' => $this->defaultEndTime(),
                    'quota' => 500,
                    'used' => 0,
                    'status' => 'active',
                ],
                [
                    'date' => '2026-09-13',
                    'start_time' => $this->defaultStartTime(),
                    'end_time' => $this->defaultEndTime(),
                    'quota' => 500,
                    'used' => 420,
                    'status' => 'active',
                ],
                [
                    'date' => '2026-09-14',
                    'start_time' => $this->defaultStartTime(),
                    'end_time' => $this->defaultEndTime(),
                    'quota' => 500,
                    'used' => 100,
                    'status' => 'active',
                ],
            ];

            $request->session()->put(
                'dummy_reguler_slots_v2',
                $dummySlots
            );
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA
        |--------------------------------------------------------------------------
        */

        $slots = collect(
            $request->session()->get(
                'dummy_reguler_slots_v2',
                []
            )
        );

        /*
        |--------------------------------------------------------------------------
        | HITUNG MONITORING
        |--------------------------------------------------------------------------
        */

        $totalQuota = $slots->sum('quota');

        $totalUsed = $slots->sum('used');

        $totalRemaining = $slots->sum(
            function ($slot) {
                return max(
                    $slot['quota'] - $slot['used'],
                    0
                );
            }
        );

        $totalBooking = $totalUsed;

        return view(
            'admin.reguler.tiket-reguler',
            [
                'slots' => $slots,
                'totalQuota' => $totalQuota,
                'totalUsed' => $totalUsed,
                'totalRemaining' => $totalRemaining,
                'totalBooking' => $totalBooking,
            ]
        );
    }


    /**
     * Menampilkan halaman pengaturan
     * untuk tanggal tertentu.
     */
    public function edit(
        Request $request,
        string $date
    ): View {

        $slots = collect(
            $request->session()->get(
                'dummy_reguler_slots_v2',
                []
            )
        );

        $slot = $slots->first(
            function ($slot) use ($date) {
                return $slot['date'] === $date;
            }
        );

        if (!$slot) {
            abort(404);
        }

        return view(
            'admin.reguler.update-slot',
            [
                'slot' => $slot,
            ]
        );
    }


    /**
     * Menyimpan perubahan kuota, jam dan status.
     */
    public function update(
        Request $request,
        string $date
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $request->validate(
            [
                'start_time' => [
                    'required',
                    'date_format:H:i',
                ],

                'end_time' => [
                    'required',
                    'date_format:H:i',
                    'after:start_time',
                ],

                'quota' => [
                    'required',
                    'integer',
                    'min:1',
                ],

                'status' => [
                    'required',
                    'in:active,inactive',
                ],
            ],
            [
                'start_time.required' =>
                'Jam mulai wajib diisi.',

                'start_time.date_format' =>
                'Format jam mulai tidak valid.',

                'end_time.required' =>
                'Jam selesai wajib diisi.',

                'end_time.date_format' =>
                'Format jam selesai tidak valid.',

                'end_time.after' =>
                'Jam selesai harus lebih besar dari jam mulai.',

                'quota.required' =>
                'Kuota harian wajib diisi.',

                'quota.integer' =>
                'Kuota harus berupa angka.',

                'quota.min' =>
                'Kuota minimal 1.',

                'status.required' =>
                'Status tanggal wajib dipilih.',

                'status.in' =>
                'Status tanggal tidak valid.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA
        |--------------------------------------------------------------------------
        */

        $slots = collect(
            $request->session()->get(
                'dummy_reguler_slots_v2',
                []
            )
        );

        /*
        |--------------------------------------------------------------------------
        | CARI DATA BERDASARKAN TANGGAL
        |--------------------------------------------------------------------------
        */

        $slotIndex = $slots->search(
            function ($slot) use ($date) {
                return $slot['date'] === $date;
            }
        );

        if ($slotIndex === false) {

            return redirect()
                ->route('admin.reguler.index')
                ->with(
                    'error',
                    'Data tanggal tidak ditemukan.'
                );
        }

        $slot = $slots->get($slotIndex);

        /*
        |--------------------------------------------------------------------------
        | KUOTA TIDAK BOLEH LEBIH KECIL DARI YANG TERPAKAI
        |--------------------------------------------------------------------------
        */

        if (
            (int) $request->quota
            < (int) $slot['used']
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Kuota tidak boleh lebih kecil dari jumlah yang sudah terpakai (' .
                        $slot['used'] .
                        ').'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $slots[$slotIndex]['start_time'] =
            $request->start_time;

        $slots[$slotIndex]['end_time'] =
            $request->end_time;

        $slots[$slotIndex]['quota'] =
            (int) $request->quota;

        $slots[$slotIndex]['status'] =
            $request->status;

        /*
        |--------------------------------------------------------------------------
        | SIMPAN SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->put(
            'dummy_reguler_slots_v2',
            $slots->values()->all()
        );

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.reguler.index')
            ->with(
                'success',
                'Pengaturan tanggal, jam, kuota, dan status berhasil diperbarui.'
            );
    }
}
