<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $now = Carbon::now();
        $ruangan = Ruangan::with([
            'bookings' => function ($query) use ($now) {
                $query->where(function ($q) use ($now) {
                    // Booking yang sedang aktif (mulai <= sekarang dan selesai >= sekarang)
                    $q->with('user')->where('mulai', '<=', $now)
                        ->where('selesai', '>=', $now);
                })->orderBy('mulai', 'asc'); // Urutkan booking yang sedang aktif
            },
            'nextBooking' => function ($query) use ($now) {
                // Booking selanjutnya (hanya ambil satu booking yang pertama)
                $query->with('user')->where('mulai', '>', $now)
                    ->orderBy('mulai', 'asc')
                    ->limit(1); // Hanya ambil 1 booking selanjutnya
            }
        ])->get();
        return view('dashboard', compact('ruangan'));
    }
}
