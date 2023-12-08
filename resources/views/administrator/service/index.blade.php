<x-administrator-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Layanan Tersedia') }}
        </h2>
    </x-slot>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="p-8  bg-white shadow sm:rounded-lg">
        <div class="mb-4 flex justify-between">
            <form method="get" class="flex gap-2 items-center">
                <div>
                    <x-text-input class="w-96 p-2" type="text" name="cari" :value="$_GET['cari'] ?? ''" placeholder="cari nama layanan..." />
                </div>

                <x-primary-button class="py-3">
                    {{ __('Cari..') }}
                </x-primary-button>
            </form>
            <x-primary-link href="{{ route('administrator.services.create') }}">
                Buat Layanan Baru
            </x-primary-link>
        </div>

        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-12">No</th>
                        <th scope="col" class="px-6 py-3 text-left">Nama Layanan</th>
                        <th scope="col" class="px-6 py-3 text-left">Harga Jasa (Rp)</th>
                        <th scope="col" class="px-6 py-3">Ongkos Kirim (Rp)</th>
                        <th scope="col" class="px-6 py-3">Lama Pengerjaan (hari)</th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services['data'] as $service)
                        <tr class="border-b">
                            <td class="text-center px-6 py-3">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3">{{ strtoupper($service['name']) }}</td>
                            <td class="px-6 py-3 w-48">Rp {{ number_format($service['price'], 0, ',', '.') }}</td>
                            <td class="px-6 py-3 w-48">Rp {{ number_format($service['shipping_cost'], 0, ',', '.') }}</td>
                            <td class="px-6 py-3 w-48">{{ $service['days_of_work'] }} hari</td>
                            <td class="px-6 py-3 flex gap-4 justify-end">
                                <a 
                                    class="text-blue-600 hover:underline uppercase text-sm"
                                    href="{{ route('administrator.services.edit', ['service' => $service['id']]) }}">Edit</a>
                                
                                <button
                                    class="text-blue-600 hover:underline uppercase text-sm"
                                    type="button"
                                    x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion-{{ $loop->iteration }}')"
                                >Hapus</button>

                                <x-modal name="confirm-user-deletion-{{ $loop->iteration }}" show="">
                                    <form method="post" action="{{ route('administrator.services.destroy', ['service' => $service['id']]) }}" class="p-6">
                                        @csrf
                                        @method('delete')
                            
                                        <h2 class="text-lg font-medium text-gray-900">
                                            Apakah anda yakin ingin menghapus layanan: '{{ $service['name'] }}' ?
                                        </h2>
                            
                                        <p class="mt-1 text-sm text-gray-600">
                                            Data yang terhapus akan hilang dan tidak bisa dikembalikan. Jika anda yakin silahkan memilih tombol 'Lanjutkan'.
                                        </p>
                            
                                        <div class="mt-6 flex justify-end">
                                            <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                                            <x-danger-button class="ms-3">Lanjutkan</x-danger-button>
                                        </div>
                                    </form>
                                </x-modal>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center px-6 py-4 italic text-gray-400" colspan="6">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="flex gap-2 justify-end mt-8">
            @if($services['prev_page_url'])
            <a href="{{ $services['prev_page_url'] }}" class="underline font-semibold text-xs text-gray-700 uppercase hover:text-gray-400">
                Sebelumnya
            </a>
            @endif

            @if($services['next_page_url'])
            <a href="{{ $services['next_page_url'] }}" class="underline font-semibold text-xs text-gray-700 uppercase hover:text-gray-400">
                Selanjutnya
            </a>
            @endif
        </div>
    </div>
</x-administrator-layout>


