<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
                @foreach ($ruangan as $item)
                    <div
                        class=" bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <div class="max-w-sm p-4 border-b border-gray-200 rounded-t-lg">
                            <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                Informasi Pemakaian
                            </h5>
                            <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-500 dark:text-white">
                                <span class="text-gray-700">Ruangan</span>: {{ $item->ruangan }}
                            </h5>
                        </div>
                        <div class="max-w-sm p-6">
                            <h4 class="text-lg font-semibold tracking-tight text-gray-500 dark:text-white">Pengguna
                                Sekarang:</h4>
                            <ul class="mb-6">
                                @forelse($item->bookings as $booking)
                                    @if ($booking->mulai <= now() && $booking->selesai >= now())
                                        <li class="text-green-900 bg-green-300 p-2 my-1 rounded shadow">
                                            <strong>Nama:</strong> {{ $booking->user->name }} <br>
                                            <strong>Mulai:</strong>
                                            {{ Carbon\Carbon::parse($booking->mulai)->translatedformat('H:i - j F, Y') }}
                                            <br>
                                            <!-- Konversi string ke Carbon -->
                                            <strong>Selesai:</strong>
                                            {{ Carbon\Carbon::parse($booking->selesai)->translatedformat('H:i - j F, Y') }}
                                            <br>
                                            <!-- Konversi string ke Carbon -->
                                            <strong>Keperluan:</strong> {{ $booking->keperluan }}
                                        </li>
                                    @endif
                                @empty
                                    <li class="text-red-900 bg-red-300 p-2 my-1 rounded shadow">Tidak ada booking
                                        aktif
                                        saat ini.</li>
                                @endforelse
                            </ul>

                            <h4 class="text-lg font-semibold tracking-tight text-gray-500 dark:text-white">Booking
                                Selanjutnya:</h4>
                            <ul>
                                @if ($item->nextBooking)
                                    <li class="text-blue-900 bg-blue-300 p-2 my-1 rounded shadow">
                                        <strong>Nama:</strong> {{ $item->nextBooking->user->name }} <br>
                                        <strong>Mulai:</strong>
                                        {{ Carbon\Carbon::parse($item->nextBooking->mulai)->translatedformat('H:i - j F, Y') }}
                                        <br>
                                        <!-- Konversi string ke Carbon -->
                                        <strong>Selesai:</strong>
                                        {{ Carbon\Carbon::parse($item->nextBooking->selesai)->translatedformat('H:i - j F, Y') }}
                                        <br>
                                        <!-- Konversi string ke Carbon -->
                                        <strong>Keperluan:</strong> {{ $item->nextBooking->keperluan }}
                                    </li>
                                @else
                                    <li class="text-red-900 bg-red-300 p-2 my-1 rounded shadow">Tidak ada booking
                                        selanjutnya.</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
