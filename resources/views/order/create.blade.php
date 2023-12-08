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

        <div class="max-w-7xl mx-auto p-6 lg:p-8 mt-8 bg-dots-darker">
            <h2 class="text-2xl font-bold mb-4 uppercase">
                Buat pesanan
            </h2>

            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-2">
                    <div class="p-6 bg-white rounded-lg shadow shadow-gray-500/20">
                        <div>
                            <div class="mb-4">
                                <x-input-label for="shoe-name" :value="__('Merk atau Brand Sepatu')" />
                                <x-text-input x-model="properties.form.shoe_name" id="shoe-name" class="block mt-1 w-full" type="text" name="shoe-name" :value="old('shoe-name')" required autofocus autocomplete="shoe-name" />
                                <x-input-error :messages="$errors->get('shoe-name')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="shoe-name" :value="__('Silahkan pilih jenis layanan yang sesuai')" />
                                <div class="grid grid-cols-3 gap-4 mt-1">
                                    @foreach($services as $service)
                                    <div @click="selectServiceItem({{ $service['id'] }})" :class="properties.form.service == {{ $service['id'] }} ? 'border-red-400' : ''" class="border-2 p-4 rounded-lg hover:border-red-400 hover:text-red-400 cursor-pointer">
                                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $service['name'] }}</h2>

                                        <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                            {{ substr($service['description'], 0, 50) }}...
                                        </p>
                                        <div class="text-sm text-gray-600 italic mt-4 w-full flex justify-between">
                                            <span>Rp {{ $service['price'] }} - </span>
                                            <span>{{ $service['days_of_work'] }} hari pengerjaan.</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <x-primary-button @click="addItemToCart" class="w-full text-center py-4 !block mt-4">Tambahkah ke keranjang pesanan</x-primary-button>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="p-6 bg-white rounded-lg shadow shadow-gray-500/20">
                        <h3 class="uppercase text-md font-medium border-b pb-2 mb-4 text-center">Daftar pesanan anda</h3>
                        <div class="flex flex-col gap-2">
                            <template x-if="properties.data.cart.items > 0" x-for="cart in properties.data.cart.items">
                                <div class="flex justify-between">
                                    <div>
                                        <div x-text="cart.shoe_name"></div>
                                        <div class="text-sm italic text-gray-400">
                                            <span x-text="cart.service.name"></span>
                                            - <button @click="removeItemFromCart(cart.key)" type="button" class="text-red-500 hover:underline">hapus</button>
                                        </div>
                                    </div>
                                    <div x-text="currencyToRupiah(cart.service.price)"></div>
                                </div>
                            </template>
                            <template x-if="properties.data.cart.items < 1">
                                <div class="italic text-sm text-gray-500 text-center">
                                    tidak ada pesanan.
                                </div>
                            </template>
                        </div>
                        <div class="flex justify-between items-center mt-4 font-semibold border-t pt-2">
                            <div>Total</div>
                            <div x-text="currencyToRupiah(properties.data.cart.total)"></div>
                        </div>
                    </div>
                    <a href="{{ route('order-customer-info.create') }}" class="block items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 w-full text-center py-4">Proses Pesanan</a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
<script type="text/javascript">
    document.addEventListener('alpine:init', () => {
        const actions = {
            "selectServiceItem": function (item) {
                if(this.properties.form.service == item) this.properties.form.service = null;
                else this.properties.form.service = item;
            },
            "addItemToCart": function () {
                this.postData(
                    '/api/cart/add',
                    this.createFormData({
                        'service': this.properties.form.service,
                        'shoe_name': this.properties.form.shoe_name
                    }),
                    response => {
                        this.loadCartItem();

                        this.properties.form.service = null;
                        this.properties.form.shoe_name = null;
                    },
                    err => {
                        console.error(err);
                    }
                )
            },
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
            "removeItemFromCart": function (key) {
                this.deleteData(
                    `/api/cart/${key}`,
                    {},
                    response => {
                        this.loadCartItem();

                        this.properties.form.service = null;
                        this.properties.form.shoe_name = null;
                    },
                    err => {
                        console.error(err);
                    }
                )
            }
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
            "deleteData": function (to, data, callback, callbackError) {
                let that = this;
                return axios
                    .delete(this.properties.sites.api_url + to, data)
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
                    "messages": {
                        "errors": [],
                        "normal": []
                    },
                    "data": {
                        "cart": []
                    },
                    "form": {
                        "shoe_name": "",
                        "service": null
                    }
                },
                "init": function() {
                    this.loadCartItem();
                }
            })
        );
    });
</script>
