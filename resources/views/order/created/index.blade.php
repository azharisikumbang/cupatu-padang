<x-guest-layout>
    <div class="bg-gray-100 min-h-screen">
        @if (Route::has('login'))
            <div class="text-right p-6">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="max-w-7xl mx-auto p-6 lg:p-8 mt-8 bg-dots-darker">
            <h2 class="text-2xl font-bold mb-4 uppercase">
                Detail Pemesanan
            </h2>

            <div class="p-6 bg-white rounded-lg shadow shadow-gray-500/20 mb-4">
                <h3 class="text-xl">Pesanan telah dibuat!</h3>
                <p>Pesanan anda akan segera kami konfirmasi dan lakukan pengambilan, mohon tunggu untuk informasi lebih lanjut. Terima Kasih.</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="">
                    <div class="p-6 bg-white rounded-lg shadow shadow-gray-500/20 mb-4">
                        <h3 class="uppercase text-md font-medium border-b pb-2 mb-4">Informasi Pemesanan</h3>
                        <div class="mb-2">
                            <div class="font-medium">Tanggal Pemesanan</div>
                            <div>{{ date('d/m/Y H:i', strtotime($order['created_at'])) }} WIB</div>
                        </div>
                        <div class="mb-2">
                            <div class="font-medium">Estimasi Penyelesaian</div>
                            <div>{{ date('d/m/Y H:i', strtotime($order['est_date_completion'])) }} WIB</div>
                        </div>
                        <div class="mb-2">
                            <div class="font-medium">Nama Pelanggan</div>
                            <div>{{ $order['customer_name'] }}</div>
                        </div>
                        <div class="mb-2">
                            <div class="font-medium">Nomor Handphone</div>
                            <div>{{ $order['customer_contact'] }}</div>
                        </div>
                        <div class="mb-2">
                            <div class="font-medium">Alamat Pengambilan Sepatu</div>
                            <div>{{ $order['customer_address'] }}</div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="p-6 bg-white rounded-lg shadow shadow-gray-500/20">
                        <h3 class="uppercase text-md font-medium border-b pb-2 mb-4">Item Pemesanan</h3>
                        <div class="flex flex-col gap-2">
                            @foreach($order['details'] as $orderItem)
                            <div class="flex justify-between">
                                <div>
                                    <div>{{ $orderItem['shoe_brand_name'] }}</div>
                                    <div class="text-sm italic text-gray-400">
                                    {{ $orderItem['service_name'] }}
                                    </div>
                                </div>
                                <div>Rp {{ number_format($orderItem['service_price'], 0, ',', '.') }}</div>
                            </div>
                            @endforeach
                        </div>
                        <div class="flex justify-between items-center mt-4 font-semibold border-t pt-2">
                            <div>Ongkos Kirim</div>
                            <div>Rp {{ number_format($order['order_shipping_cost'], 0, ',', '.') }}</div>
                        </div>
                        <div class="flex justify-between items-center font-semibold pt-2">
                            <div>Total</div>
                            <div>Rp {{ number_format($order['order_price_total'], 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="w-full mt-4 block items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 w-full text-center py-4" href="{{ route('homepage') }}">Kembali ke Halaman Utama</a>
        </div>
    </div>
</x-guest-layout>
