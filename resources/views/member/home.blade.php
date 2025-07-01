@extends('layouts.app')

@section('content')
    <section class="py-3"
        style="background-image: url('images/background-pattern.jpg');background-repeat: no-repeat;background-size: cover;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="banner-blocks">

                        <div class="banner-ad large bg-info block-1">

                            <div class="swiper main-swiper">
                                <div class="swiper-wrapper">

                                    <div class="swiper-slide">
                                        <div class="row banner-content p-5">
                                            <div class="content-wrapper col-md-7">
                                                <div class="categories my-3">100% Delicious</div>
                                                <h3 class="display-4">Salmon Grilled</h3>
                                                <p>Grilled salmon is a healthy and delicious dish made by cooking fresh salmon over an open flame or grill.
                                                    It has a tender, juicy texture with a slightly smoky flavor, often seasoned with herbs, lemon, and garlic to enhance its natural taste.</p>
                                                <a href="#"
                                                    class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1 px-4 py-3 mt-3">Shop
                                                    Now</a>
                                            </div>
                                            <div class="img-wrapper col-md-5">
                                                <img src="images/makanan_berat.jpeg"class="img-fluid">
                                            </div>
                                        </div>
                                    </div>

                                <div class="swiper-pagination"></div>

                            </div>
                        </div>

                        <div class="banner-ad bg-success-subtle block-2"
                            style="background:url('images/ad-image-4.png') no-repeat;background-position: right bottom">
                            <div class="row banner-content p-5">

                                <div class="content-wrapper col-md-7">
                                    <div class="categories sale mb-3 pb-3">80% Happines + 20% Craving</div>
                                    <h3 class="banner-title">Dessert</h3>
                                    <a href="#" class="d-flex align-items-center nav-link">Shop Collection <svg
                                            width="24" height="24">
                                            <use xlink:href="#arrow-right"></use>
                                        </svg></a>
                                </div>

                            </div>
                        </div>

                        <div class="banner-ad bg-danger block-3"
                            style="background:url('images/minuman.jpeg') no-repeat;background-position: right bottom">
                            <div class="row banner-content p-5">

                                <div class="content-wrapper col-md-7">
                                    <div class="categories sale mb-3 pb-3">100% Thirsty</div>
                                    <h3 class="item-title">Favorite Drink</h3>
                                    <a href="#" class="d-flex align-items-center nav-link">Shop Collection <svg
                                            width="24" height="24">
                                            <use xlink:href="#arrow-right"></use>
                                        </svg></a>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 overflow-hidden">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header d-flex flex-wrap justify-content-between mb-5">
                        <h2 class="section-title">Categories</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="category-carousel swiper">
                        <div class="swiper-wrapper">
                            @foreach ($categories as $category)
                                <a href="{{ route('menus.byCategory', $category->id) }}" class="nav-link category-item swiper-slide">
                                    {{-- Gambar default atau sesuai kategori --}}
                                    <img src="{{ asset('images/app-store.jpg') }}" alt="{{ $category->name }}">
                                    <h3 class="category-title">{{ $category->name }}</h3>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 overflow-hidden">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header d-flex flex-wrap justify-content-between mb-5">
                        <h2 class="section-title">Newly Arrived Brands</h2>
                        <div class="d-flex align-items-center">
                            <a href="#" class="btn-link text-decoration-none">View All Categories →</a>
                            <div class="swiper-buttons">
                                <button class="swiper-prev brand-carousel-prev btn btn-yellow">❮</button>
                                <button class="swiper-next brand-carousel-next btn btn-yellow">❯</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="brand-carousel swiper">
                        <div class="swiper-wrapper">
                            @foreach ([11, 12, 13, 14, 11, 12] as $thumb)
                            <div class="swiper-slide">
                                <div class="card mb-3 p-3 rounded-4 shadow border-0">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="images/product-thumb-{{ $thumb }}.jpg" class="img-fluid rounded" alt="Card title">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body py-0">
                                                <p class="text-muted mb-0">Amber Jar</p>
                                                <h5 class="card-title">Honey best nectar you wish to get</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="bootstrap-tabs product-tabs">
                        <div class="tabs-header d-flex justify-content-between border-bottom my-5">
                            <h3>Our Menu</h3>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            @foreach (['all', 'heavy', 'drinks', 'snacks', 'dessert'] as $tab)
                            <div class="tab-pane fade {{ $tab == 'all' ? 'show active' : '' }}" id="nav-{{ $tab }}" role="tabpanel" aria-labelledby="nav-{{ $tab }}-tab">
                                <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                                    @for ($i = 0; $i < 10; $i++)
                                        @include('partials.product-card')
                                    @endfor
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container-fluid">
            <div class="row">
                @foreach (range(1, 2) as $i)
                    @include('partials.event-card')
                @endforeach
            </div>
        </div>
    </section>

    @include('layouts.slider')

    <section id="latest-blog" class="py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="section-header d-flex align-items-center justify-content-between my-5">
                    <h2 class="section-title">Our Recent Blog</h2>
                    <div class="btn-wrap align-right">
                        <a href="#" class="d-flex align-items-center nav-link">Read All Articles <svg width="24" height="24"><use xlink:href="#arrow-right"></use></svg></a>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach (range(1, 3) as $i)
                    @include('partials.blog-card')
                @endforeach
            </div>
        </div>
    </section>
@endsection
