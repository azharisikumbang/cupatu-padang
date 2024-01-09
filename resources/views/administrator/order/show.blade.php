<x-administrator-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Nomor Pesanan #') . $order['id'] }}
            </h2>

            <div class="flex justify-between gap-2">
                @if($order['order_status_action_list']['actual_next_order_status'])
                <div>
                    <x-primary-button 
                    type="button"
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-order-status-update-next')">{{ $order['order_status_action_list']['next_order_status_message'] }}</x-primary-button>

                    <x-modal name="confirm-order-status-update-next" show="">
                        <form method="post" action="{{ route('administrator.order-status-updater.store', ['order' => $order['id'], 'action' => 'next']) }}" class="p-6">
                            @csrf
                            <h2 class="text-lg font-medium text-gray-900">
                                Apakah anda yakin ingin {{ $order['order_status_action_list']['next_order_status_message'] }} ?
                            </h2>
                
                            <p class="mt-1 text-sm text-gray-600">
                                Perubahan yang terjadi tidak akan bisa dikembalikan. Jika anda yakin silahkan memilih tombol '{{ $order['order_status_action_list']['next_order_status_message'] }}'.
                            </p>
                
                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                                <x-primary-button class="ms-3">{{ $order['order_status_action_list']['next_order_status_message'] }}</x-primary-button>
                            </div>
                        </form>
                    </x-modal>
                </div>
                @endif

                @if($order['order_status_action_list']['actual_prev_order_status'])
                <div>
                    <x-danger-button 
                    type="button"
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-order-status-update-prev')">{{ $order['order_status_action_list']['prev_order_status_message'] }}</x-danger-button>

                    <x-modal name="confirm-order-status-update-prev" show="">
                        <form method="post" action="{{ route('administrator.order-status-updater.store', ['order' => $order['id'], 'action' => 'prev']) }}" class="p-6">
                            @csrf
                            <h2 class="text-lg font-medium text-gray-900">
                                Apakah anda yakin ingin {{ $order['order_status_action_list']['prev_order_status_message'] }} ?
                            </h2>
                
                            <p class="mt-1 text-sm text-gray-600">
                                Perubahan yang terjadi tidak akan bisa dikembalikan. Jika anda yakin silahkan memilih tombol '{{ $order['order_status_action_list']['prev_order_status_message'] }}'.
                            </p>
                
                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                                <x-danger-button class="ms-3">{{ $order['order_status_action_list']['prev_order_status_message'] }}</x-danger-button>
                            </div>
                        </form>
                    </x-modal>
                </div>
                @endif
            </div>
        </div>
    </x-slot>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div>
        <div class="p-8 bg-white shadow rounded-lg">
            <div class="uppercase text-md font-medium border-b pb-2 mb-4 flex items-center gap-4">
                <h3 class="">Informasi Pemesanan</h3>
            </div>
            <div class="mb-2">
                <div class="font-medium">Tanggal Pemesanan</div>
                <div>{{ date('d/m/Y H:i', strtotime($order['created_at'])) }} WIB</div>
            </div>
            <div class="mb-2">
                <div class="font-medium">Estimasi Penyelesaian</div>
                <div>{{ date('d/m/Y H:i', strtotime($order['est_date_completion'])) }} WIB</div>
            </div>
            <div class="mb-2">
                <div class="font-medium">Status Pesanan</div>
                <div class="text-sm">
                    <span class="py-1 underline text-sm mt-1 text-yellow-500 italic">{{ $order['order_status_readable'] }}</span>
                </div>
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
                <div>
                    <span>Rp. {{ number_format($order['order_price_total'], 0, ',', '.') }} </span>
                    <small>
                        (<a href="{{ route('administrator.order-invoice.export', ['order' => $order['id']]) }}" target="_blank" class="text-red-500 hover:text-red-700 hover:underline">Download Invoice</a>)
                    </small>
                </div>
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
                        <td class="px-6 py-3">
                            {{ $orderItem['shoe_brand_name'] }}
                            <small>(<a target="_blank" class="text-red-500 hover:underline" href="{{ url('storage/' . $orderItem['shoe_image']) }}">Lihat Gambar</a>)</small>
                        </td>
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
</x-administrator-layout>

