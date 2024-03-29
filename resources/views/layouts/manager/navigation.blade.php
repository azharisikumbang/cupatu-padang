<div>
    <div class="p-4 border-b flex items-center">
        <a href="{{ route('homepage') }}" class="">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
        </a>
    </div>

    <div class="flex flex-col px-2 mt-4">
        <a 
            href="{{ route('manager.dashboard.index') }}" 
            class="rounded px-4 py-2 text-gray-500 cursor-pointer font-medium hover:bg-gray-200 hover:text-gray-700 hover:underline">
            {{ __('Dashboard') }}
        </a>
        <a 
            href="{{ route('manager.order-reporting') }}" 
            class="rounded px-4 py-2 text-gray-500 cursor-pointer font-medium hover:bg-gray-200 hover:text-gray-700 hover:underline">
            {{ __('Laporan Pemesanan') }}
        </a>
        <a 
            href="{{ route('manager.income-reporting') }}" 
            class="rounded px-4 py-2 text-gray-500 cursor-pointer font-medium hover:bg-gray-200 hover:text-gray-700 hover:underline">
            {{ __('Laporan Pendapatan') }}
        </a>
        <a 
            href="{{ route('manager.change-password') }}" 
            class="rounded px-4 py-2 text-gray-500 cursor-pointer font-medium hover:bg-gray-200 hover:text-gray-700 hover:underline">
            {{ __('Ganti Kata Sandi') }}
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a 
                class="block rounded px-4 py-2 text-gray-500 cursor-pointer font-medium hover:bg-gray-200 hover:text-gray-700 hover:underline"
                :href="route('logout')"
                onclick="event.preventDefault();
                this.closest('form').submit();">
                {{ __('Keluar') }}
            </a>
        </form>
    </div>
</div>