<x-manager-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Ganti Kata Sandi Akun') }}
        </h2>
    </x-slot>

    <div class="p-8 bg-white shadow sm:rounded-lg">
        @include('profile.partials.update-password-form')
    </div>
</x-manager-layout>


