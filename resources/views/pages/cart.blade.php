@extends('layouts.app')

@section('title', 'Store Cart Page')

@section('content')
    <!-- Page Content -->
    <div class="page-content page-cart">
        <!-- Breadcrumbs -->
        <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <div class="ol breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Cart</li>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cart -->
        <section class="store-cart">
            <div class="container">
                <!-- Table Cart -->
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-12 table-responsive">
                        <table class="table table-borderless table-cart">
                            <thead>
                                <td>Image</td>
                                <td>Name &amp; Seller</td>
                                <td>Price</td>
                                <td>Menu</td>
                            </thead>
                            <tbody>
                                @php $totalPrice = 0; @endphp

                                @forelse ($carts as $cart)
                                    <tr>
                                        <td style="width: 20%">
                                            @if ($cart->product->galleries->count())
                                                <img src="{{ Storage::url($cart->product->galleries->first()->photos) }}"
                                                    alt="" class="cart-image" />
                                            @endif
                                        </td>
                                        <td style="width: 35%">
                                            <div class="product-title">{{ $cart->product->name }}</div>
                                            <div class="product-subtitle">by {{ $cart->product->user->store_name }}</div>
                                        </td>
                                        <td style="width: 35%">
                                            <div class="product-title">${{ number_format($cart->product->price) }}</div>
                                            <div class="product-subtitle">USD</div>
                                        </td>
                                        <td style="width: 20%">
                                            <form action="{{ route('cart-delete', $cart->id) }}" method="post">
                                                @method('delete')
                                                @csrf

                                                <button type="submit" class="btn btn-remove-cart">Remove</button>
                                            </form>
                                        </td>
                                    </tr>

                                    @php $totalPrice += $cart->product->price @endphp
                                @empty
                                    <tr class="text-center">
                                        <td colspan="4">No Products Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Divider and Heading -->
                <div class="row" data-aos="fade-up" data-aos-delay="150">
                    <div class="col-12">
                        <hr />
                    </div>
                    <div class="col-12">
                        <h2 class="mb-4">Shipping Details</h2>
                    </div>
                </div>

                <form action="{{ route('checkout') }}" method="post" id="locations">
                    @csrf

                    <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                    <!-- Shipping Details -->
                    <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address_one">Address 1</label>
                                <input type="text" class="form-control" id="address_one" name="address_one" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address_two">Address 2</label>
                                <input type="text" class="form-control" id="address_two" name="address_two" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone_number">Mobile</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="country" name="country" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="provinces_id">Province</label>
                            <select name="province_id" id="province_id" class="form-control" v-if="provinces"
                                v-model="province_id">
                                <option v-for="province in provinces" :value="province.province_id">@{{ province.province }}
                                </option>
                            </select>
                            <select v-else class="form-control"></select>
                        </div>
                        <div class="col-md-4">
                            <label for="regencies_id">City</label>
                            <select name="city_id" id="city_id" class="form-control" v-if="cities" v-model="city_id"
                                @change="getCitiesData">
                                <option v-for="city in cities" :value="city.city_id">@{{ city.type }}
                                    @{{ city.city_name }}</option>
                            </select>
                            <select v-else class="form-control"></select>
                        </div>
                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="zip_code">Postal Code</label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code" />
                            </div>
                        </div> --}}


                    </div>

                    <!-- Divider and Heading -->
                    <div class="row" data-aos="fade-up" data-aos-delay="150">
                        <div class="col-12">
                            <hr />
                        </div>
                        <div class="col-12">
                            <h2 class="mb-1">Payment Informations</h2>
                        </div>
                    </div>

                    <!-- Payment Informations -->
                    <div class="row" data-aos="fade-up" data-aos-delay="200">
                        <div class="col-4 col-md-2">
                            <div class="product-title">$0</div>
                            <div class="product-subtitle">Country Tax</div>
                        </div>
                        <div class="col-4 col-md-3">
                            <div class="product-title">$0</div>
                            <div class="product-subtitle">Product Insurance</div>
                        </div>
                        <div class="col-4 col-md-2">
                            <div class="product-title">$0</div>
                            <div class="product-subtitle">Ship to <p id="destination"></p>
                            </div>
                        </div>
                        <div class="col-4 col-md-2">
                            <div class="product-title text-success">${{ number_format($totalPrice ?? 0) }}</div>
                            <div class="product-subtitle">Total</div>
                        </div>
                        <div class="col-8 col-md-3">
                            <button type="submit" class="btn btn-success mt-4 px-4 btn-block">Checkout Now</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        var locations = new Vue({
            el: "#locations",
            mounted() {
                AOS.init();
                this.getProvincesData();
            },
            data: {
                provinces: null,
                province_id: null,
                cities: null,
                city_id: null
                city_name: null
            },
            methods: {
                async getProvincesData() {
                    await axios.get('{{ route('api-provinces') }}').then(({
                        data
                    }) => {
                        this.provinces = data.data;
                    });
                },
                async getCitiesData() {
                    if (this.province_id) {
                        await axios.get('{{ url('api/cities') }}/' + this.province_id).then(({
                            data
                        }) => {
                            this.cities = data.data.cities;
                            this.city_name = data.data.city_name;
                            document.getElementById("destination").innerText = this.city_name.type +
                                " " +
                                this.city_name.city_name;
                        });
                    }
                },
                // async getCityData() {
                //     if (this.province_id && this.city_id) {
                //         await axios.get('{{ url('api/city') }}/' + this.city_id).then(({
                //             data
                //         }) => {
                //             console.log(data.data);
                //             this.city_name = data.data;
                //             document.getElementById("destination").innerText = this.city_name.type +
                //                 " " +
                //                 this.city_name.city_name;
                //         });
                //     }
                // }
            },
            watch: {
                province_id: function(val, oldVal) {
                    this.city_id = null;
                    this.getCitiesData();
                }
            }
        });
    </script>
@endpush
