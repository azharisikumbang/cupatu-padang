<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nomor Pesanan #') . $order['id'] }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-8 bg-white shadow rounded-lg">
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
                <div class="mb-2">
                    <div class="font-medium">Total Tagihan</div>
                    <div>Rp. {{ number_format($order['order_price_total'], 0, ',', '.') }}</div>
                </div>
                
            </div>
    
            <div class="mt-8 p-8 bg-white shadow rounded-lg">
                <h3 class="uppercase text-md font-medium border-b pb-2 mb-4">Rincian Pemesanan</h3>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 w-12">No</th>
                            <th scope="col" class="px-6 py-3 text-left">Jenis Layanan</th>
                            <th scope="col" class="px-6 py-3 text-left">Merk Sepatu</th>
                            <th scope="col" class="px-6 py-3 text-right w-64">Ongkos Jasa Perawatan (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order['details'] as $orderItem)
                        <tr class="border-b">
                            <td class="px-6 py-3 text-center">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3 w-64">{{ $orderItem['service_name'] }}</td>
                            <td class="px-6 py-3">{{ $orderItem['shoe_brand_name'] }}</td>
                            <td class="px-6 py-3 text-right">Rp. {{ number_format($orderItem['service_price'], 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="px-6 py-3 text-right font-semibold" colspan="3">Ongkos Kirim</td>
                            <td class="px-6 py-3 font-semibold text-right">Rp. {{ number_format($order['order_shipping_cost'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 text-right font-semibold" colspan="3">Total</td>
                            <td class="px-6 py-3 font-semibold text-right">Rp. {{ number_format($order['order_price_total'], 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-customer-layout>
