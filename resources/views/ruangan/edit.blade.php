<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pinjam Ruang Rapat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('ruangan.update', $ruangan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nama Ruangan -->
                        <div>
                            <x-input-label for="nama_ruangan" :value="__('Nama Ruangan')" />
                            <x-text-input id="nama_ruangan" name="ruangan" :value="old('ruangan', $ruangan->ruangan)" type="text"
                                class="mt-1 block w-full" required placeholder="Nama Ruangan" autofocus
                                autocomplete="nama_ruangan" />
                            <x-input-error class="mt-2" :messages="$errors->get('ruangan')" />
                        </div>

                        <!-- Fasilitas -->
                        <div>
                            <x-input-label for="fasilitas" :value="__('Fasilitas')" />
                            <div class="grid grid-cols-3 gap-4 mt-3">
                                @foreach ($fasilitas as $item)
                                    <div>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="fasilitas[]" value="{{ $item }}"
                                                class="form-checkbox h-5 w-5 text-blue-600"
                                                {{ in_array($item, old('fasilitas', $ruangFas)) ? 'checked' : '' }}>
                                            <span class="ml-2 text-gray-700">{{ $item }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Kapasitas -->
                        <div class="mt-4">
                            <x-input-label for="kapasitas" :value="__('Kapasitas')" />
                            <x-text-input id="kapasitas" name="kapasitas" :value="old('kapasitas', $ruangan->kapasitas)" type="number"
                                class="mt-1 block w-full" required placeholder="Kapasitas" />
                            <x-input-error class="mt-2" :messages="$errors->get('kapasitas')" />
                        </div>

                        <div class="mt-4">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                        </div>
                    </form>

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
