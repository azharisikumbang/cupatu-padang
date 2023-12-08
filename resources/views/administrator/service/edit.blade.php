<x-administrator-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight uppercase">
            {{ __('Edit Detai layanan') }}
        </h2>
    </x-slot>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="p-8 bg-white shadow sm:rounded-lg">
        <form method="post" action="{{ route('administrator.services.update', ['service' => $service['id']]) }}" class="max-w-xl">
            @csrf
            @method('patch')

            <div class="mb-4">
                <x-input-label :value="__('Nama Layanan')" />
                <x-text-input name="name" type="text" class="mt-1 block w-full" :value="old('name', $service['name'])" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label :value="__('Deksripsi Layanan')" />
                <x-text-area name="description" type="text" class="mt-1 block w-full" :value="old('description', $service['description'])" required />
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label :value="__('Harga Jasa (Rp)')" />
                <x-text-input name="price" type="number" min="0" value="0" class="mt-1 block w-full" :value="old('price', (int) $service['price'])" required />
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label :value="__('Ongkor Kirim (Rp)')" />
                <x-text-input name="shipping_cost" type="number" min="0" value="0" class="mt-1 block w-full" :value="old('shipping_cost', (int) $service['shipping_cost'])" required />
                <x-input-error :messages="$errors->get('shipping_cost')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label :value="__('Lama Pengerjaan (hari)')" />
                <x-text-input name="days_of_work" type="number" min="0" value="0" class="mt-1 block w-full" :value="old('days_of_work', $service['days_of_work'])" required />
                <x-input-error :messages="$errors->get('days_of_work')" class="mt-2" />
            </div>

            <div class="flex items-center gap-2 mt-8">
                <x-primary-button class="bg-yellow-500 hover:bg-yellow-400">{{ __('Simpan Perubahan') }}</x-primary-button>
                <x-primary-link href="{{ route('administrator.services.index') }}">Kembali</x-primary-link>
            </div>
        </form>
    </div>
</x-administrator-layout>

