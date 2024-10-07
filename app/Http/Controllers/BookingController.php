<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Ruangan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Booking::query();

        // Filter berdasarkan tanggal mulai (jika ada)
        if ($request->filled('start_date')) {
            $query->whereDate('mulai', '>=', $request->start_date);
        }

        // Filter berdasarkan tanggal selesai (jika ada)
        if ($request->filled('end_date')) {
            $query->whereDate('selesai', '<=', $request->end_date);
        }

        // Filter berdasarkan ruangan (jika ada)
        if ($request->filled('ruangan_id')) {
            $query->where('ruangan_id', $request->ruangan_id);
        }

        // Jalankan query dan paginasi hasil
        $booking = $query->orderBy('id', 'desc')->with('ruangan')->paginate(10);

        // Ambil daftar ruangan untuk dropdown filter
        $ruangans = Ruangan::all();
        return view('booking.index', compact('booking', 'ruangans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::get();
        $ruangans = Ruangan::get();
        return view('booking.create', compact('users', 'ruangans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $now = now();
        // dd($now);
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'ruangan_id' => 'required|exists:ruangans,id',
            'mulai' => [
                'required',
                'date',
                'after_or_equal:' . $now,  // Validasi agar mulai tidak boleh sebelum waktu sekarang
                function ($attribute, $value, $fail) use ($request) {
                    // Cek apakah ada booking lain yang waktunya sama
                    $booking = Booking::where('ruangan_id', $request->ruangan_id)
                        ->where(function ($query) use ($value, $request) {
                            $query->where('mulai', '<=', $value)
                                ->where('selesai', '>=', $value)
                                ->orWhereBetween('selesai', [$value, $request->selesai]);
                        })->exists();

                    if ($booking) {
                        $fail('Waktu mulai sudah ada di jadwal ruangan tersebut.');
                    }
                }
            ],
            'selesai' => [
                'required',
                'date',
                'after:mulai',  // Validasi agar selesai harus setelah mulai
                'after_or_equal:' . $now,  // Validasi agar selesai tidak boleh sebelum waktu sekarang
                function ($attribute, $value, $fail) use ($request) {
                    // Cek apakah ada booking lain yang waktunya sama
                    $booking = Booking::where('ruangan_id', $request->ruangan_id)
                        ->where(function ($query) use ($value, $request) {
                            $query->where('mulai', '<=', $value)
                                ->where('selesai', '>=', $value)
                                ->orWhereBetween('selesai', [$request->mulai, $value]);
                        })->exists();

                    if ($booking) {
                        $fail('Waktu selesai sudah ada di jadwal ruangan tersebut.');
                    }
                }
            ],
            'keperluan' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'konsumsi' => 'required|min:0',
        ]);

        // Buat data baru berdasarkan input
        $booking = new Booking();
        $booking->user_id = $request->user_id;
        $booking->ruangan_id = $request->ruangan_id;
        $booking->mulai = $request->mulai;
        $booking->selesai = $request->selesai;
        $booking->keperluan = $request->keperluan;
        $booking->jumlah = $request->jumlah;
        $booking->konsumsi = $request->konsumsi;

        // Simpan data ke database
        $booking->save();

        // Redirect atau response setelah berhasil simpan
        return redirect()->route('list-book.index')->with('success', 'Data booking berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $users = User::get();
        $booking = Booking::findOrFail($id);
        $ruangans = Ruangan::all(); // Untuk pilihan dropdown ruangan
        return view('booking.edit', compact('booking', 'ruangans', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);
        $now = now();
        $request->validate([
            'mulai' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request, $booking) {
                    // Konversi $value ke format Y-m-d H:i:s
                    $formattedValue = Carbon::parse($value)->format('Y-m-d H:i:s');

                    // Misalnya, kita ingin membandingkan dengan $existingBooking->mulai
                    $existingBooking = $booking;

                    // Jika waktu mulai berubah, lakukan pengecekan
                    if ($existingBooking->mulai != $formattedValue) {
                        $conflictBooking = Booking::where('ruangan_id', $request->ruangan_id)
                            ->where(function ($query) use ($formattedValue, $request) {
                                $query->where('mulai', '<=', $formattedValue)
                                    ->where('selesai', '>=', $formattedValue)
                                    ->orWhereBetween('selesai', [$formattedValue, $request->selesai]);
                            })->exists();

                        if ($conflictBooking) {
                            $fail('Waktu mulai sudah ada di jadwal ruangan tersebut.');
                        }
                    }
                }
            ],
            'selesai' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request, $booking) {
                    // Konversi $value ke format Y-m-d H:i:s
                    $formattedValue = Carbon::parse($value)->format('Y-m-d H:i:s');

                    // Misalnya, kita ingin membandingkan dengan $existingBooking->selesai
                    $existingBooking = $booking;

                    // Jika waktu selesai berubah, lakukan pengecekan
                    if ($existingBooking->selesai != $formattedValue) {
                        $conflictBooking = Booking::where('ruangan_id', $request->ruangan_id)
                            ->where(function ($query) use ($formattedValue, $request) {
                                $query->where('mulai', '<=', $formattedValue)
                                    ->where('selesai', '>=', $formattedValue)
                                    ->orWhereBetween('selesai', [$request->mulai, $formattedValue]);
                            })->exists();

                        if ($conflictBooking) {
                            $fail('Waktu selesai sudah ada di jadwal ruangan tersebut.');
                        }
                    }
                }
            ],
        ]);

        $booking->update($request->all());

        return redirect()->route('list-book.index')->with('success', 'Booking berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('list-book.index')->with('success', 'Booking berhasil dihapus');
    }
}
