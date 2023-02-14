@extends('layouts.app')

@section('title', 'Store Detail Page')

@section('content')
    <!-- Page Content -->
    <div class="page-content page-details">
      <!-- Breadcrumbs -->
      <section
        class="store-breadcrumbs"
        data-aos="fade-down"
        data-aos-delay="100"
      >
        <div class="container">
          <div class="row">
            <div class="col-12">
              <nav>
                <div class="ol breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="/index.html">Home</a>
                  </li>
                  <li class="breadcrumb-item active">Page Details</li>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </section>

      <!-- Gallery -->
      <section class="store-gallery mb-3" id="gallery">
        <div class="container">
          <div class="row">
            <div class="col-lg-8" data-aos="zoom-in">
              <transition name="slide-fade" mode="out-in">
                <img
                  :src="photos[activePhoto].url"
                  :key="photos[activePhoto].id"
                  alt=""
                  class="w-100 main-image"
                />
              </transition>
            </div>
            <div class="col-lg-2">
              <div class="row">
                <div
                  class="col-3 col-lg-12 mt-2 mt-lg-0"
                  v-for="(photo, index) in photos"
                  :key="photo.id"
                  data-aos="zoom-in"
                  data-aos-delay="100"
                >
                  <a href="#" @click="changeActive(index)">
                    <img
                      :src="photo.url"
                      alt=""
                      class="w-100 thumbnail-image"
                      :class="{ active: index == activePhoto }"
                    />
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Details Product -->
      <div class="store-details-container" data-aos="fade-up">
        <!-- Heading Details Product -->
        <section class="store-heading">
          <div class="container">
            <div class="row">
              <div class="col-lg-8">
                <h1>{{ $product->name }}</h1>
                <div class="owner">By {{ $product->user->store_name }}</div>
                <div class="price">${{ number_format($product->price) }}</div>
              </div>
              <div class="col-lg-2">
                @auth
                    <form action="{{ route('detail-add', $product->id) }}" method="post" enctype="multipart/form-data">
                      @csrf
                      <button
                        type="submit"
                        class="btn btn-success px-4 text-white btn-block mb-3"
                        >Add to Cart</button
                      >
                    </form>
                @else
                    <a
                      href="{{ route('login') }}"
                      class="btn btn-success px-4 text-white btn-block mb-3"
                      >Sign in to Add</a
                    >
                @endauth
              </div>
            </div>
          </div>
        </section>

        <!-- Description Details Product -->
        <section class="store-description">
          <div class="container">
            <div class="row">
              <div class="col-12 col-lg-8">
                {!! $product->description !!}
              </div>
            </div>
          </div>
        </section>

        <!-- Customer Review -->
        <section class="store-review">
          <div class="container">
            <div class="row">
              <div class="col-12 col-lg-8 mt-3 mb-3">
                <h5>Customer Review (3)</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-lg-8">
                <ul class="list-unstyled">
                  <li class="media">
                    <img
                      src="/images/pic-review-1.png"
                      alt=""
                      class="mr-3 rounde-circle"
                    />
                    <div class="media-body">
                      <h5 class="mt-2 mb-1">Hazza Risky</h5>
                      Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                      Expedita eligendi ad consequatur quis unde? Facere optio
                      dolor ducimus vel pariatur.
                    </div>
                  </li>
                  <li class="media">
                    <img
                      src="/images/pic-review-2.png"
                      alt=""
                      class="mr-3 rounde-circle"
                    />
                    <div class="media-body">
                      <h5 class="mt-2 mb-1">Aisyah Khairunnisa</h5>
                      Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                      Expedita eligendi ad consequatur quis unde? Facere optio
                      dolor ducimus vel pariatur.
                    </div>
                  </li>
                  <li class="media">
                    <img
                      src="/images/pic-review-3.png"
                      alt=""
                      class="mr-3 rounde-circle"
                    />
                    <div class="media-body">
                      <h5 class="mt-2 mb-1">Azizah Mala</h5>
                      Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                      Expedita eligendi ad consequatur quis unde? Facere optio
                      dolor ducimus vel pariatur.
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script>
      var gallery = new Vue({
        el: "#gallery",
        mounted() {
          AOS.init();
        },
        data: {
          activePhoto: 0,
          photos: [
            @foreach( $product->galleries as $gallery )
            {
              id: {{ $gallery->id }},
              url: "{{ Storage::url($gallery->photos) }}",
            },
            @endforeach
          ],
        },
        methods: {
          changeActive(id) {
            this.activePhoto = id;
          },
        },
      });
    </script>
@endpush