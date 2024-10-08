<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pinjam Ruang Rapat') }}
        </h2>
    </x-slot>
    @push('style')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('ruangan.store') }}">
                        @csrf
                        <div class="grid md:grid-cols-2 grid-cols-1 gap-4 mb-4">
                            <div>
                                <x-input-label for="nama_ruangan" :value="__('Nama Ruangan')" />
                                <x-text-input id="nama_ruangan" name="nama_ruangan" :value="old('nama_ruangan')" type="text"
                                    class="mt-1 block w-full" required placeholder="Nama Ruangan" autofocus
                                    autocomplete="nama_ruangan" />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_ruangan')" />
                            </div>
                            <div>
                                <x-input-label for="fasilitas" :value="__('Fasilitas')" />
                                <select name="fasilitas[]" multiple="multiple" id="fasilitas"
                                    class="mt-1 block w-full rounded select">
                                    @foreach ($fasilitas as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                                {{-- <div class="grid grid-cols-3 gap-4 mt-3">
                                    @foreach ($fasilitas as $item)
                                        <div>
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="fasilitas[]" value="{{ $item }}"
                                                    class="form-checkbox h-5 w-5 text-blue-600">
                                                <span class="ml-2 text-gray-700">{{ $item }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div> --}}
                            </div>

                            <div>
                                <x-input-label for="kapasitas" :value="__('Kapasitas')" />
                                <x-text-input id="kapasitas" name="kapasitas" :value="old('kapasitas')" type="number"
                                    class="mt-1 block w-full" required placeholder="Kapasitas" autofocus
                                    autocomplete="kapasitas" />
                                <x-input-error class="mt-2" :messages="$errors->get('kapasitas')" />
                            </div>
                        </div>
                        <x-primary-button>Tambah</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
            integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.select').select2({
                    placeholder: "Pilih Fasilitas",
                    allowClear: true
                });
            });
        </script>
    @endpush
</x-app-layout>
