<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pinjam Ruan Rapat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('list-book.store') }}">
                        @csrf
                        <div class="grid md:grid-cols-2 grid-cols-1 gap-4 mb-4">
                            <div class=" mt-4">
                                <x-input-label for="user_id" :value="__('User')" />
                                @role('admin')
                                    <select id="user_id" name="user_id" class="mt-1 block w-full rounded">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <x-text-input id="user_id" name="user_id" type="hidden"
                                        value="{{ auth()->user()->id }}" class="mt-1 block w-full" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                                    <x-text-input id="user_id" name="name" type="text" readonly
                                        value="{{ auth()->user()->name }}" class="mt-1 block w-full" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                @endrole
                                <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                            </div>

                            <!-- Ruangan -->
                            <div class="mt-4">
                                <x-input-label for="ruangan_id" :value="__('Silahkan pilih ruangan')" />
                                <select id="ruangan_id" name="ruangan_id" class="mt-1 block w-full rounded">
                                    @foreach ($ruangans as $ruangan)
                                        <option value="{{ $ruangan->id }}"
                                            {{ old('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                                            {{ $ruangan->ruangan }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('ruangan_id')" />
                            </div>

                            <!-- Mulai -->
                            <div class="mt-4">
                                <x-input-label for="mulai" :value="__('Mulai')" />
                                <x-text-input id="mulai" name="mulai" type="datetime-local" :value="old('mulai')"
                                    class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('mulai')" />
                            </div>

                            <!-- Selesai -->
                            <div class="mt-4">
                                <x-input-label for="selesai" :value="__('Selesai')" />
                                <x-text-input id="selesai" name="selesai" type="datetime-local" :value="old('selesai')"
                                    class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('selesai')" />
                            </div>

                            <!-- Keperluan -->
                            <div class="mt-4">
                                <x-input-label for="keperluan" :value="__('Keperluan')" />
                                <x-text-input id="keperluan" name="keperluan" type="text" :value="old('keperluan')"
                                    class="mt-1 block w-full" required placeholder="Keperluan" />
                                <x-input-error class="mt-2" :messages="$errors->get('keperluan')" />
                            </div>

                            <!-- Jumlah -->
                            <div class="mt-4">
                                <x-input-label for="jumlah" :value="__('Jumlah')" />
                                <x-text-input id="jumlah" name="jumlah" type="number" :value="old('jumlah')"
                                    class="mt-1 block w-full" required placeholder="Jumlah" />
                                <x-input-error class="mt-2" :messages="$errors->get('jumlah')" />
                            </div>

                            <!-- Konsumsi -->
                            <div class="mt-4">
                                <x-input-label for="konsumsi" :value="__('Konsumsi')" />
                                <select id="konsumsi" name="konsumsi" class="mt-1 block w-full rounded">
                                    <option value="makanan besar"
                                        {{ old('konsumsi') == 'makanan besar' ? 'selected' : '' }}>Makanan Besar
                                    </option>
                                    <option value="makanan ringan"
                                        {{ old('konsumsi') == 'makanan ringan' ? 'selected' : '' }}>Makanan Ringan
                                    </option>
                                </select>
                            </div>
                        </div>
                        <x-primary-button>Tambah</x-primary-button>
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
