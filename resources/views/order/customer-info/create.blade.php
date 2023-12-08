<x-guest-layout>
    <div class="bg-gray-100 min-h-screen" x-data="container">
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

        <x-auth-session-status class="mb-4" :status="session('session')" />

        <form action="{{ route('order-customer-info.create') }}" method="post">
            @csrf
            <div class="max-w-7xl mx-auto p-6 lg:p-8 mt-8 bg-dots-darker">
                <h2 class="text-2xl font-bold mb-4 uppercase">
                    Informasi Pengambilan Sepatu
                </h2>

                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-2">
                        <div class="p-6 bg-white rounded-lg shadow shadow-gray-500/20">
                            <div class="mb-4">
                                <x-input-label for="name" :value="__('Atas Nama Pemesan')" />
                                <x-text-input placeholder="nama lengkap atau nama panggilan yang dikenali" id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="shoe-name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="contact" :value="__('Nomor Handphone')" />
                                <x-text-input placeholder="08.." id="contact" class="block mt-1 w-full" type="text" name="contact" :value="old('contact')"/>
                                <x-input-error :messages="$errors->get('contact')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="address" :value="__('Alamat Pengambilan Sepatu')" />
                                <x-text-area placeholder="alamat akan kami konfirmasi kembali jika gagal ditemukan.." id="address" class="block mt-1 w-full" name="address" :value="old('address')" />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4">
                        <div class="p-6 bg-white rounded-lg shadow shadow-gray-500/20">
                            <h3 class="uppercase text-md font-medium border-b pb-2 mb-4">Daftar pesanan anda</h3>
                            <div class="flex flex-col gap-2">
                                <template x-for="cart in properties.data.cart.items">
                                    <div class="flex justify-between">
                                        <div>
                                            <div x-text="cart.shoe_name"></div>
                                            <div class="text-sm italic text-gray-400">
                                                <span x-text="cart.service.name"></span>
                                            </div>
                                        </div>
                                        <div x-text="currencyToRupiah(cart.service.price)">Rp 20.000</div>
                                    </div>
                                </template>
                            </div>
                            <div class="flex justify-between items-center mt-4 font-semibold border-t pt-2">
                                <div>Total</div>
                                <div x-text="currencyToRupiah(properties.data.cart.total)"></div>
                            </div>
                        </div>
                        <x-primary-button class="w-full text-center py-4 !block mt-4">Selesaikan Pesanan</x-primary-button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>
<script type="text/javascript">
    document.addEventListener('alpine:init', () => {
        const actions = {
            "loadCartItem": function (){
                this.getApiRequest(
                     '/api/cart',
                     null,
                     response => {
                         this.properties.data.cart = response.data;
                     },
                     error => {
                        console.log(error);
                        //  this.addErrorMassage('server_error', 'Server error! Mohon muat ulang halaman dan coba kembali');
                     }
                 );
            },
        };

        const utils = {
            "postData": function (to, data, callback, callbackError) {
                let that = this;
                return axios
                    .post(this.properties.sites.api_url + to, data)
                    .then(res => callback(res))
                    .catch(err => callbackError(err));
            },
            "getApiRequest": function (to, params = null, callback, callbackError) {
                return axios
                    .get(this.properties.sites.api_url + to, { params: params })
                    .then(res => callback(res))
                    .catch(err => callbackError(err));
            },
            "createFormData": function (data) {
                const form = new FormData();
                for (const key in data) form.append(key, data[key]);

                return form;
            },
            "currencyToRupiah": function (number) {
                return 'Rp ' + this.addDotToCurrentcy(number);
            },
            "addDotToCurrentcy": function (number) {
                return (new Intl.NumberFormat('id-Id', {"maximumSignificantDigits": 3}).format(number));
            },
        };

        Alpine.data('container',
            () => ({
                ...actions,
                ...utils,
                "properties": {
                    "sites": {
                        "api_url": "{{ url('/') }}"
                    },
                    "data": {
                        "cart": []
                    },
                },
                "init": function() {
                    this.loadCartItem();
                }
            })
        );
    });
</script>
