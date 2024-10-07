<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ruangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-end items-center">
                        @role('admin')
                            <a href="{{ route('ruangan.create') }}">
                                <x-primary-button>Tambah ruangan</x-primary-button>
                            </a>
                        @endrole
                    </div>
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Ruangan</th>
                                <th>Fasilitas</th>
                                <th>Kapasitas</th>
                                @role('admin')
                                    <th>Action</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ruangan as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->ruangan }}</td>
                                    <td>{{ $item->fasilitas }}</td>
                                    <td>{{ $item->kapasitas }}</td>
                                    @role('admin')
                                        <td class="flex items-center justify-center gap-2"><a
                                                href="{{ route('ruangan.edit', $item->id) }}"><x-secondary-button>Ubah</x-secondary-button></a>
                                            | <form action="{{ route('ruangan.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah anda yakin ingin menghapus ruangan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <x-danger-button>Hapus</x-danger-button>
                                            </form>
                                        </td>
                                    @endrole
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <th>No</th>
                            <th>Nama Ruangan</th>
                            <th>Fasilitas</th>
                            <th>Kapasitas</th>
                            @role('admin')
                                <th>Action</th>
                            @endrole
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
