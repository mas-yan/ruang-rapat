<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('List Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-end items-center">
                        <a href="{{ route('list-book.create') }}">
                            <x-primary-button>Pinjam Ruang Rapat</x-primary-button>
                        </a>
                    </div>
                    <form action="{{ route('list-book.index') }}" method="GET"
                        class="flex justify-center items-center gap-4">
                        <!-- Tanggal Mulai -->
                        <div>
                            <x-input-label for="start_date" :value="__('Dari Tanggal')" />
                            <x-text-input id="start_date" name="start_date" type="date" :value="request('start_date')"
                                class="mt-1 block w-full" />
                        </div>

                        <!-- Tanggal Selesai -->
                        <div>
                            <x-input-label for="end_date" :value="__('Sampai Tanggal')" />
                            <x-text-input id="end_date" name="end_date" type="date" :value="request('end_date')"
                                class="mt-1 block w-full" />
                        </div>

                        <!-- Ruangan -->
                        <div>
                            <x-input-label for="ruangan_id" :value="__('Ruangan')" />
                            <select id="ruangan_id" name="ruangan_id" class="block mt-1 w-full rounded">
                                <option value="">Semua Ruangan</option>
                                @foreach ($ruangans as $ruangan)
                                    <option value="{{ $ruangan->id }}"
                                        {{ request('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                                        {{ $ruangan->ruangan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-primary-button>{{ __('Cari') }}</x-primary-button>

                            <!-- Tombol Reset -->
                            <a href="{{ route('list-book.index') }}">
                                <x-secondary-button>reset</x-secondary-button>
                            </a>
                        </div>
                    </form>

                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pemesan</th>
                                <th>Ruangan</th>
                                <th>Mulai Tanggal</th>
                                <th>Selesai Tanggal</th>
                                <th>Keperluan</th>
                                <th>Jumlah Peserta</th>
                                <th>Konsumsi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($booking as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->ruangan->ruangan }}</td>
                                    <td>{{ $item->mulai }}</td>
                                    <td>{{ $item->selesai }}</td>
                                    <td>{{ $item->keperluan }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ $item->konsumsi }}</td>
                                    <td>
                                        @if (auth()->user()->hasRole('admin') || auth()->user()->id == $item->user->id)
                                            <div class="flex items-center justify-center gap-2">
                                                <a
                                                    href="{{ route('list-book.edit', $item->id) }}"><x-secondary-button>Ubah</x-secondary-button></a>
                                                |
                                                <form action="{{ route('list-book.destroy', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah anda yakin ingin menghapus peminjaman ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-danger-button>Hapus</x-danger-button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <th>No</th>
                            <th>Nama Pemesan</th>
                            <th>Ruangan</th>
                            <th>Mulai Tanggal</th>
                            <th>Selesai Tanggal</th>
                            <th>Keperluan</th>
                            <th>Jumlah Peserta</th>
                            <th>Konsumsi</th>
                            <th>Action</th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('style')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.tailwindcss.css" />
    @endpush
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
            integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
        <script>
            console.log('dev');

            new DataTable('#example');
        </script>
    @endpush
</x-app-layout>
