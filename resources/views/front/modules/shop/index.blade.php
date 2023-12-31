@extends('front.layouts.app')
@section('content')    
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area pb-60 pt-60" style="background-image: url({{asset('assets/front/img/slider/bg-about.png')}}); background-size: 100%; background-repeat: no-repeat; ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <h2 class="text-white">Product List</h2>
                        <p class="text-white">Home / Product List</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->
    <!-- page main wrapper start -->
    <main class="main-bg">
        <!-- search start -->
        <!--<div class="search-list">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-xs-12 col-12"></div>
                    <div class="col-md-6 col-xs-12 col-12">
                        <div class="form-group">
                            <input type="text" id="searchlist" class="form-control search" placeholder="Search......" />
                            <button class="search" type="button">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.25329 16.7467 2 11.5 2C6.25329 2 2 6.25329 2 11.5C2 16.7467 6.25329 21 11.5 21Z" stroke="#FFB932" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M22 22L20 20" stroke="#FFB932" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                            </button>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12 col-12"></div>
                </div>
            </div>
        </div>-->
        <!-- search end -->
        <div class="shop-main-wrapper pt-50 pb-50 pt-sm-58 pb-sm-58">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 hidden-xs">
                        <div class="sidebar-wrapper mt-md-100 mt-sm-48 mobile-none">
                            <div class="sidebar-body">
                                <div class="accordion" id="general-question1">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="mb-0">
                                                <button class="accordio-heading" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Categories
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseOne" class="collapse custom-list open-1" aria-labelledby="headingOne" data-bs-parent="#general-question">
                                            <div class="card-body">
                                                <div class="filter-check">
                                                    <label class="container">
                                                        Earrings
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        Necklace
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        Rings
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        Bangles
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        Earrings & Mangtikka Sets
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        Maang Tikka
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        Nose Pin
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        Hair Accessories
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        Kaanchain
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- single sidebar end -->
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 hidden-xs">
                        <div class="sidebar-wrapper mt-md-100 mt-sm-48 mobile-none">
                            <div class="sidebar-body">
                                <div class="accordion" id="general-question2">
                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h5 class="mb-0">
                                                <button class="accordio-heading" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                    Collection
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseTwo" class="collapse custom-list open-2" aria-labelledby="headingTwo" data-bs-parent="#general-question">
                                            <div class="card-body">
                                                <div class="filter-check">
                                                    <label class="container">
                                                        Greece
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        Hollywood
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        Libera
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        Whispers from the Valley
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        Rooted
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        Rouge
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- single sidebar end -->
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 hidden-xs">
                        <div class="sidebar-wrapper mt-md-100 mt-sm-48 mobile-none">
                            <div class="sidebar-body">
                                <div class="accordion" id="general-question3">
                                    <div class="card">
                                        <div class="card-header" id="headingThree">
                                            <h5 class="mb-0">
                                                <button class="accordio-heading" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                                    Metal Color
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseThree" class="collapse custom-list open-3" aria-labelledby="headingThree" data-bs-parent="#general-question">
                                            <div class="card-body">
                                                <div class="filter-check">
                                                    <label class="container">
                                                        Rose Gold
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        White Gold
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        White and Rose Gold
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        Yellow Gold
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        Yellow and White Gold
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- single sidebar end -->
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 hidden-xs">
                        <div class="sidebar-wrapper mt-md-100 mt-sm-48 mobile-none">
                            <div class="sidebar-body">
                                <div class="accordion" id="general-question4">
                                    <div class="card">
                                        <div class="card-header" id="headingfive">
                                            <h5 class="mb-0">
                                                <button class="accordio-heading" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                                    Price
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseFour" class="collapse custom-list open-4" aria-labelledby="headingfive" data-bs-parent="#general-question">
                                            <div class="card-body">
                                                <div class="price-filter">
                                                    <div class="middle">
                                                        <div class="multi-range-slider">
                                                            <input type="range" id="input-left" class="range2" min="0" max="100" value="25" onmousemove="rangeLeftSlider(this.value)">
                                                            <input type="range" id="input-right" class="range2" min="0" max="100" value="75" onmousemove="rangeRightSlider(this.value)">

                                                            <div class="slider">
                                                                <div class="track"></div>
                                                                <div class="range"></div>
                                                                <div class="thumb left"></div>
                                                                <div class="thumb right"></div>
                                                            </div>
                                                        </div>
                                                        <div id="multi_range">
                                                            ₹<span id="range2LeftValue">25</span>
                                                            <span style="float:right;">₹<span id="range2RightValue">75</span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- single sidebar end -->
                        </div>
                    </div>
                    <!-- product view wrapper area start -->
                    <div class="col-xl-12 col-lg-12">
                        <div class="shop-product-wrapper">
                            <!-- shop product top wrap start -->
                            <div class="shop-top-bar mt-3">
                                <div class="row">
                                    <div class="col-lg-7 col-md-6">
                                        <div class="top-bar-left">
                                            <!--<div class="product-view-mode">
                                                <a class="active" href="#" data-target="grid"><i class="fa fa-th"></i></a>
                                                <a href="#" data-target="list"><i class="fa fa-list"></i></a>
                                            </div>-->
                                            <div class="product-amount">
                                                <p>Showing 1–16 of 21 results</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6 mobile-none">
                                        <div class="top-bar-right">
                                            <div class="product-short">
                                                <select class="nice-select" name="sortby">
                                                    <option value="trending">SORT BY</option>
                                                    <option value="sales">Name (A - Z)</option>
                                                    <option value="sales">Name (Z - A)</option>
                                                    <option value="rating">Price (Low &gt; High)</option>
                                                    <option value="date">Rating (Lowest)</option>
                                                    <option value="price-asc">Model (A - Z)</option>
                                                    <option value="price-asc">Model (Z - A)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- shop product top wrap start -->
                            <!-- product view mode wrapper start -->
                            <div class="shop-product-wrap grid row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                                    <div class="product-item mb-20">
                                        <div class="product-description">
                                            <div class="manufacturer">
                                                <p>
                                                    <a href="product-details.html">Ring</a>
                                                    <span style="float:right;">
                                                        <a class="wishlist-list wish" href="#" title="" tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path><use xlink:href="#wish"></use></svg></a>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="product-name">
                                                <h3><a href="product-details.html">Endeavor Daytrip</a></h3>
                                            </div>
                                        </div>
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="{{asset('assets/front/img/product/product-1.jpg')}}" class="simple-product" alt="product image">
                                                <img src="{{asset('assets/front/img/product/product-2.jpg')}}" class="hover-product" alt="product image">
                                            </a>
                                            <div class="box-label">
                                                <div class="product-label new">
                                                    <span>SPECIAL OFFER</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-description">
                                            <div class="price-box mt-10">
                                                <span class="regular-price">$100.00</span>
                                                <span class="old-price"><del>$120.00</del></span>
                                                <span style="float:right;">
                                                    <a href="#" class="d-block text-center">
                                                        <svg class="product-list-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"></path>
                                                        </svg>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                                    <div class="product-item mb-20">
                                        <div class="product-description">
                                            <div class="manufacturer">
                                                <p>
                                                    <a href="product-details.html">Ring</a>
                                                    <span style="float:right;">
                                                        <a class="wishlist-list wish" href="#" title="" tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path><use xlink:href="#wish"></use></svg></a>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="product-name">
                                                <h3><a href="product-details.html">Endeavor Daytrip</a></h3>
                                            </div>
                                        </div>
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="{{asset('assets/front/img/product/product-2.jpg')}}" class="simple-product" alt="product image">
                                                <img src="{{asset('assets/front/img/product/product-3.jpg')}}" class="hover-product" alt="product image">
                                            </a>
                                            <div class="box-label">
                                                <div class="product-label discount">
                                                    <span>FAST SELLING</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-description">
                                            <div class="price-box mt-10">
                                                <span class="regular-price">$100.00</span>
                                                <span class="old-price"><del>$120.00</del></span>
                                                <span style="float:right;">
                                                    <a href="#" class="d-block text-center">
                                                        <svg class="product-list-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"></path>
                                                        </svg>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                                    <div class="product-item mb-20">
                                        <div class="product-description">
                                            <div class="manufacturer">
                                                <p>
                                                    <a href="product-details.html">Ring</a>
                                                    <span style="float:right;">
                                                        <a class="wishlist-list wish" href="#" title="" tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path><use xlink:href="#wish"></use></svg></a>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="product-name">
                                                <h3><a href="product-details.html">Endeavor Daytrip</a></h3>
                                            </div>
                                        </div>
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="{{asset('assets/front/img/product/product-3.jpg')}}" class="simple-product" alt="product image">
                                                <img src="{{asset('assets/front/img/product/product-4.jpg')}}" class="hover-product" alt="product image">
                                            </a>
                                            <div class="box-label">
                                                <div class="product-label discount">
                                                    <span>FAST SELLING</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-description">
                                            <div class="price-box mt-10">
                                                <span class="regular-price">$100.00</span>
                                                <span class="old-price"><del>$120.00</del></span>
                                                <span style="float:right;">
                                                    <a href="#" class="d-block text-center">
                                                        <svg class="product-list-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"></path>
                                                        </svg>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                                    <div class="product-item mb-20">
                                        <div class="product-description">
                                            <div class="manufacturer">
                                                <p>
                                                    <a href="product-details.html">Ring</a>
                                                    <span style="float:right;">
                                                        <a class="wishlist-list wish" href="#" title="" tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path><use xlink:href="#wish"></use></svg></a>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="product-name">
                                                <h3><a href="product-details.html">Endeavor Daytrip</a></h3>
                                            </div>
                                        </div>
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="{{asset('assets/front/img/product/product-4.jpg')}}" class="simple-product" alt="product image">
                                                <img src="{{asset('assets/front/img/product/product-5.jpg')}}" class="hover-product" alt="product image">
                                            </a>
                                            <div class="box-label">
                                                <div class="product-label new">
                                                    <span>SPECIAL OFFER</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-description">
                                            <div class="price-box mt-10">
                                                <span class="regular-price">$100.00</span>
                                                <span class="old-price"><del>$120.00</del></span>
                                                <span style="float:right;">
                                                    <a href="#" class="d-block text-center">
                                                        <svg class="product-list-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"></path>
                                                        </svg>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                                    <div class="product-item mb-20">
                                        <div class="product-description">
                                            <div class="manufacturer">
                                                <p>
                                                    <a href="product-details.html">Ring</a>
                                                    <span style="float:right;">
                                                        <a class="wishlist-list wish" href="#" title="" tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path><use xlink:href="#wish"></use></svg></a>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="product-name">
                                                <h3><a href="product-details.html">Endeavor Daytrip</a></h3>
                                            </div>
                                        </div>
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="{{asset('assets/front/img/product/product-5.jpg')}}" class="simple-product" alt="product image">
                                                <img src="{{asset('assets/front/img/product/product-6.jpg')}}" class="hover-product" alt="product image">
                                            </a>
                                            <div class="box-label">
                                                <div class="product-label new">
                                                    <span>SPECIAL OFFER</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-description">
                                            <div class="price-box mt-10">
                                                <span class="regular-price">$100.00</span>
                                                <span class="old-price"><del>$120.00</del></span>
                                                <span style="float:right;">
                                                    <a href="#" class="d-block text-center">
                                                        <svg class="product-list-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"></path>
                                                        </svg>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                                    <div class="product-item mb-20">
                                        <div class="product-description">
                                            <div class="manufacturer">
                                                <p>
                                                    <a href="product-details.html">Ring</a>
                                                    <span style="float:right;">
                                                        <a class="wishlist-list wish" href="#" title="" tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path><use xlink:href="#wish"></use></svg></a>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="product-name">
                                                <h3><a href="product-details.html">Endeavor Daytrip</a></h3>
                                            </div>
                                        </div>
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="{{asset('assets/front/img/product/product-6.jpg')}}" class="simple-product" alt="product image">
                                                <img src="{{asset('assets/front/img/product/product-7.jpg')}}" class="hover-product" alt="product image">
                                            </a>
                                            <div class="box-label">
                                                <div class="product-label discount">
                                                    <span>FAST SELLING</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-description">
                                            <div class="price-box mt-10">
                                                <span class="regular-price">$100.00</span>
                                                <span class="old-price"><del>$120.00</del></span>
                                                <span style="float:right;">
                                                    <a href="#" class="d-block text-center">
                                                        <svg class="product-list-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"></path>
                                                        </svg>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                                    <div class="product-item mb-20">
                                        <div class="product-description">
                                            <div class="manufacturer">
                                                <p>
                                                    <a href="product-details.html">Ring</a>
                                                    <span style="float:right;">
                                                        <a class="wishlist-list wish" href="#" title="" tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path><use xlink:href="#wish"></use></svg></a>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="product-name">
                                                <h3><a href="product-details.html">Endeavor Daytrip</a></h3>
                                            </div>
                                        </div>
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="{{asset('assets/front/img/product/product-7.jpg')}}" class="simple-product" alt="product image">
                                                <img src="{{asset('assets/front/img/product/product-8.jpg')}}" class="hover-product" alt="product image">
                                            </a>
                                            <div class="box-label">
                                                <div class="product-label new">
                                                    <span>SPECIAL OFFER</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-description">
                                            <div class="price-box mt-10">
                                                <span class="regular-price">$100.00</span>
                                                <span class="old-price"><del>$120.00</del></span>
                                                <span style="float:right;">
                                                    <a href="#" class="d-block text-center">
                                                        <svg class="product-list-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"></path>
                                                        </svg>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                                    <div class="product-item mb-20">
                                        <div class="product-description">
                                            <div class="manufacturer">
                                                <p>
                                                    <a href="product-details.html">Ring</a>
                                                    <span style="float:right;">
                                                        <a class="wishlist-list wish" href="#" title="" tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path><use xlink:href="#wish"></use></svg></a>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="product-name">
                                                <h3><a href="product-details.html">Endeavor Daytrip</a></h3>
                                            </div>
                                        </div>
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="{{asset('assets/front/img/product/product-8.jpg')}}" class="simple-product" alt="product image">
                                                <img src="{{asset('assets/front/img/product/product-1.jpg')}}" class="hover-product" alt="product image">
                                            </a>
                                            <div class="box-label">
                                                <div class="product-label new">
                                                    <span>SPECIAL OFFER</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-description">
                                            <div class="price-box mt-10">
                                                <span class="regular-price">$100.00</span>
                                                <span class="old-price"><del>$120.00</del></span>
                                                <span style="float:right;">
                                                    <a href="#" class="d-block text-center">
                                                        <svg class="product-list-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"></path>
                                                        </svg>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                                    <div class="product-item mb-20">
                                        <div class="product-description">
                                            <div class="manufacturer">
                                                <p>
                                                    <a href="product-details.html">Ring</a>
                                                    <span style="float:right;">
                                                        <a class="wishlist-list wish" href="#" title="" tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path><use xlink:href="#wish"></use></svg></a>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="product-name">
                                                <h3><a href="product-details.html">Endeavor Daytrip</a></h3>
                                            </div>
                                        </div>
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="{{asset('assets/front/img/product/product-1.jpg')}}" class="simple-product" alt="product image">
                                                <img src="{{asset('assets/front/img/product/product-2.jpg')}}" class="hover-product" alt="product image">
                                            </a>
                                            <div class="box-label">
                                                <div class="product-label new">
                                                    <span>SPECIAL OFFER</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-description">
                                            <div class="price-box mt-10">
                                                <span class="regular-price">$100.00</span>
                                                <span class="old-price"><del>$120.00</del></span>
                                                <span style="float:right;">
                                                    <a href="#" class="d-block text-center">
                                                        <svg class="product-list-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"></path>
                                                        </svg>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- product view mode wrapper start -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- page main wrapper end -->
    <div class="filter-mobile">
        <div class="row">
            <div class="col-md-6 col-xs-6 col-6">
                <div class="nice-select" tabindex="0">
                    <span class="current mobile-filter">SORT BY</span>
                    <ul class="list">
                        <li data-value="trending" class="option selected focus">SORT BY</li>
                        <li data-value="sales" class="option">Name (A - Z)</li>
                        <li data-value="sales" class="option">Name (Z - A)</li>
                        <li data-value="rating" class="option">Price (Low &gt; High)</li>
                        <li data-value="date" class="option">Rating (Lowest)</li>
                        <li data-value="price-asc" class="option">Model (A - Z)</li>
                        <li data-value="price-asc" class="option">Model (Z - A)</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-xs-6 col-6">
                <div class="nice-select" tabindex="0">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#filter" class="mobile-filter"> FILTER</a>
                </div>
            </div>
        </div>
    </div>
@endsection