<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="mb-4 flex justify-end">
                    <form method="get" class="flex gap-2 items-center">
                        <div>
                            <x-text-input class="w-96 p-2" type="text" name="cari" :value="$_GET['cari'] ?? ''" placeholder="cari nama nomor order..." />
                        </div>
                
                        <x-primary-button class="py-3">
                            {{ __('Cari..') }}
                        </x-primary-button>
                    </form>
                </div>
                
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 w-12">No</th>
                                <th scope="col" class="px-6 py-3 text-left">Tanggal Pemesanan</th>
                                <th scope="col" class="px-6 py-3 text-left">Nomor Pesanan</th>
                                <th scope="col" class="px-6 py-3">Atas Nama Pemesan</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Total (Rp)</th>
                                <th scope="col" class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders['data'] as $order)
                                <tr class="border-b">
                                    <td class="text-center px-6 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-3 w-32">{{ date('d/m/Y H:i', strtotime($order['created_at'])) }} WIB</td>
                                    <td class="px-6 py-3 w-64">{{ '-' }}</td>
                                    <td class="px-6 py-3">{{ $order['customer_name'] }}</td>
                                    <td class="px-6 py-3">{{ $order['order_status'] }}</td>
                                    <td class="px-6 py-3">Rp. {{ number_format($order['order_price_total'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-3 text-right">
                                        <a href="{{ route('order.show', ['order' => $order['id']]) }}" class="text-blue-600 hover:underline uppercase text-sm">Lihat detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-gray-500 py-4">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="flex gap-2 justify-end mt-8">
                    @if($orders['prev_page_url'])
                    <a href="{{ $orders['prev_page_url'] }}" class="underline font-semibold text-xs text-gray-700 uppercase hover:text-gray-400">
                        Sebelumnya
                    </a>
                    @endif
                
                    @if($orders['next_page_url'])
                    <a href="{{ $orders['next_page_url'] }}" class="underline font-semibold text-xs text-gray-700 uppercase hover:text-gray-400">
                        Selanjutnya
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
