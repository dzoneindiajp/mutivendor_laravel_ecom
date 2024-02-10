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
                    @if($categoriesData->isNotEmpty())
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
                                                    @foreach($categoriesData as $category)
                                                    <label class="container categoriesCheck" onclick = "window.open('{{
                                                        !empty($childCategorySlug) ?
                                                            route('front-shop.index', [$categorySlug, $subCategorySlug, $childCategorySlug]) :
                                                            (!empty($subCategorySlug) ?
                                                                route('front-shop.index', [$categorySlug, $subCategorySlug,$category->slug]) :
                                                                (!empty($categorySlug) ?
                                                                    route('front-shop.index', [$categorySlug,$category->slug]) :
                                                                    route('front-shop.index',$category->slug)
                                                                )
                                                            )
                                                    }}','_self')">
                                                        {{$category->name ?? ''}}
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>

                                                    </label>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- single sidebar end -->
                        </div>
                    </div>
                    @endif
                    {{-- <div class="col-xl-3 col-lg-4 hidden-xs">
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
                    </div> --}}
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
                                                <p>Showing 1–{{(Config("Reading.records_per_page") > $totalResults) ? $totalResults : Config("Reading.records_per_page")}} of {{$totalResults ?? 0}} results</p>
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

                            @if($results->isNotEmpty())
                            @include('front.modules.shop.load_more_data', ['results' => $results])
                            @else
                            <div class="noresults-row text-center">
                                <h6>No Products found.</h6>
                            </div>
                            @endif
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