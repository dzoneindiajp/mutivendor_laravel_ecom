   
@extends('front.layouts.app')
@section('content')
<!-- slider area start -->
    <div class="hero-area main-slider">
        <div class="hero-slider-active slider-arrow-style slick-dot-style hero-dot">
            <div class="hero-single-slide hero-1 d-flex align-items-center">
                <img src="{{ asset('assets/front/img/slider/slide1.png')}}" width="100%" />
                <div class="slider-content">
                    <!--<h1>Regal Elegance, Affordable Price: Discover Exquisite jewellery fit for Royalty </h1>
                    <a href="#" class="slider-btn">
                        Explore <svg width="30" height="9" viewBox="0 0 30 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 4C0.723858 4 0.5 4.22386 0.5 4.5C0.5 4.77614 0.723858 5 1 5V4ZM29.3536 4.85355C29.5488 4.65829 29.5488 4.34171 29.3536 4.14645L26.1716 0.964466C25.9763 0.769204 25.6597 0.769204 25.4645 0.964466C25.2692 1.15973 25.2692 1.47631 25.4645 1.67157L28.2929 4.5L25.4645 7.32843C25.2692 7.52369 25.2692 7.84027 25.4645 8.03553C25.6597 8.2308 25.9763 8.2308 26.1716 8.03553L29.3536 4.85355ZM1 5H29V4H1V5Z" fill="white" />
                        </svg>
                    </a>-->
                </div>
            </div>
            <div class="hero-single-slide hero-1 d-flex align-items-center">

                <img src="{{ asset('assets/front/img/slider/slide1.png')}}" width="100%" />
                <div class="slider-content">
                    <!--<h1>Regal Elegance, Affordable Price: Discover Exquisite jewellery fit for Royalty </h1>
                    <a href="#" class="slider-btn">
                        Explore
                        <svg width="30" height="9" viewBox="0 0 30 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 4C0.723858 4 0.5 4.22386 0.5 4.5C0.5 4.77614 0.723858 5 1 5V4ZM29.3536 4.85355C29.5488 4.65829 29.5488 4.34171 29.3536 4.14645L26.1716 0.964466C25.9763 0.769204 25.6597 0.769204 25.4645 0.964466C25.2692 1.15973 25.2692 1.47631 25.4645 1.67157L28.2929 4.5L25.4645 7.32843C25.2692 7.52369 25.2692 7.84027 25.4645 8.03553C25.6597 8.2308 25.9763 8.2308 26.1716 8.03553L29.3536 4.85355ZM1 5H29V4H1V5Z" fill="white" />
                        </svg>
                    </a>-->
                </div>
            </div>
        </div>
    </div>
    <!-- slider area end -->
    <!-- banner statistics 01 start -->
    <div class="banner-statistic-one pt-30 top-space-category-1 top-category-s">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-lg-3 col-6">
                    <div class="img-container img-full fix mb-sm-30">
                        <img src="{{ asset('assets/front/img/bestseller/cate-1.jpg')}}" alt="banner image">
                        <div class="category-heading">
                            <div class="border-category">
                                <!--<h5>Category</h5>-->
                                <h2>Rings</h2>
                                <a href="#" class="home-btn btn" tabindex="0">
                                    Check more products &nbsp;&nbsp;&nbsp;
                                    <svg class="right-arrow" width="30" height="9" viewBox="0 0 30 9" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 4C0.723858 4 0.5 4.22386 0.5 4.5C0.5 4.77614 0.723858 5 1 5V4ZM29.3536 4.85355C29.5488 4.65829 29.5488 4.34171 29.3536 4.14645L26.1716 0.964466C25.9763 0.769204 25.6597 0.769204 25.4645 0.964466C25.2692 1.15973 25.2692 1.47631 25.4645 1.67157L28.2929 4.5L25.4645 7.32843C25.2692 7.52369 25.2692 7.84027 25.4645 8.03553C25.6597 8.2308 25.9763 8.2308 26.1716 8.03553L29.3536 4.85355ZM1 5H29V4H1V5Z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-6">
                    <div class="img-container img-full fix mb-sm-30">
                        <img src="{{ asset('assets/front/img/bestseller/cate-2.jpg')}}" alt="banner image">
                        <div class="category-heading">
                            <!--<h5>Category</h5>-->
                            <h2>Bangles</h2>
                            <a href="#" class="home-btn btn" tabindex="0">
                                Check more products &nbsp;&nbsp;&nbsp;
                                <svg class="right-arrow" width="30" height="9" viewBox="0 0 30 9" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 4C0.723858 4 0.5 4.22386 0.5 4.5C0.5 4.77614 0.723858 5 1 5V4ZM29.3536 4.85355C29.5488 4.65829 29.5488 4.34171 29.3536 4.14645L26.1716 0.964466C25.9763 0.769204 25.6597 0.769204 25.4645 0.964466C25.2692 1.15973 25.2692 1.47631 25.4645 1.67157L28.2929 4.5L25.4645 7.32843C25.2692 7.52369 25.2692 7.84027 25.4645 8.03553C25.6597 8.2308 25.9763 8.2308 26.1716 8.03553L29.3536 4.85355ZM1 5H29V4H1V5Z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-6">
                    <div class="img-container img-full fix mb-sm-30">
                        <img src="{{ asset('assets/front/img/bestseller/cate-3.jpg')}}" alt="banner image">
                        <div class="category-heading">
                            <!--<h5>Category</h5>-->
                            <h2>Earrings</h2>
                            <a href="#" class="home-btn btn" tabindex="0">
                                Check more products &nbsp;&nbsp;&nbsp;
                                <svg class="right-arrow" width="30" height="9" viewBox="0 0 30 9" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 4C0.723858 4 0.5 4.22386 0.5 4.5C0.5 4.77614 0.723858 5 1 5V4ZM29.3536 4.85355C29.5488 4.65829 29.5488 4.34171 29.3536 4.14645L26.1716 0.964466C25.9763 0.769204 25.6597 0.769204 25.4645 0.964466C25.2692 1.15973 25.2692 1.47631 25.4645 1.67157L28.2929 4.5L25.4645 7.32843C25.2692 7.52369 25.2692 7.84027 25.4645 8.03553C25.6597 8.2308 25.9763 8.2308 26.1716 8.03553L29.3536 4.85355ZM1 5H29V4H1V5Z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-6">
                    <div class="img-container img-full fix mb-sm-30">
                        <img src="{{ asset('assets/front/img/bestseller/cate-4.jpg')}}" alt="banner image">
                        <div class="category-heading">
                            <!--<h5>Category</h5>-->
                            <h2>Necklaces</h2>
                            <a href="#" class="home-btn btn" tabindex="0">
                                Check more products &nbsp;&nbsp;&nbsp;
                                <svg class="right-arrow" width="30" height="9" viewBox="0 0 30 9" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 4C0.723858 4 0.5 4.22386 0.5 4.5C0.5 4.77614 0.723858 5 1 5V4ZM29.3536 4.85355C29.5488 4.65829 29.5488 4.34171 29.3536 4.14645L26.1716 0.964466C25.9763 0.769204 25.6597 0.769204 25.4645 0.964466C25.2692 1.15973 25.2692 1.47631 25.4645 1.67157L28.2929 4.5L25.4645 7.32843C25.2692 7.52369 25.2692 7.84027 25.4645 8.03553C25.6597 8.2308 25.9763 8.2308 26.1716 8.03553L29.3536 4.85355ZM1 5H29V4H1V5Z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- banner statistics 01 end -->
    <!-- featured product area start -->
    <div class="page-section pt-50 bg-white pb-14 pt-sm-30 pb-sm-0">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="product-details-home">
                        <h2 class="mb-50">
                            Diamonds & <br>Engagement Ring
                        </h2>
                        <p class="mb-80">
                            Experience the beauty of diamond jewellery and find your perfect piece for a special occasion. Find the perfect diamond for any special occasion, from engagement rings and wedding bands to anniversary and Christmas gifts
                        </p>
                        <div class="product-btn">
                            <a href="#" tabindex="0">
                                Check More Product
                                <svg class="right-arrow" width="30" height="9" viewBox="0 0 30 9" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 4C0.723858 4 0.5 4.22386 0.5 4.5C0.5 4.77614 0.723858 5 1 5V4ZM29.3536 4.85355C29.5488 4.65829 29.5488 4.34171 29.3536 4.14645L26.1716 0.964466C25.9763 0.769204 25.6597 0.769204 25.4645 0.964466C25.2692 1.15973 25.2692 1.47631 25.4645 1.67157L28.2929 4.5L25.4645 7.32843C25.2692 7.52369 25.2692 7.84027 25.4645 8.03553C25.6597 8.2308 25.9763 8.2308 26.1716 8.03553L29.3536 4.85355ZM1 5H29V4H1V5Z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="product-carousel-other spt slick-arrow-style slick-padding">
                        <div class="col">
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
                                        <img src="{{ asset('assets/front/img/product/product-1.jpg')}}" class="simple-product" alt="product image">
                                        <img src="{{ asset('assets/front/img/product/product-2.jpg')}}" class="hover-product" alt="product image">
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
                                    <div class="product-btn">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="product-item mb-20">
                                <div class="product-description">
                                    <div class="manufacturer">
                                        <p>
                                            <a href="product-details.html">Neckles</a>
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
                                        <img src="{{ asset('assets/front/img/product/product-3.jpg')}}" class="simple-product" alt="product image">
                                        <img src="{{ asset('assets/front/img/product/product-4.jpg')}}" class="hover-product" alt="product image">
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
                        <div class="col">
                            <div class="product-item mb-20">
                                <div class="product-description">
                                    <div class="manufacturer">
                                        <p>
                                            <a href="product-details.html">Bangles</a>
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
                                        <img src="{{ asset('assets/front/img/product/product-2.jpg')}}" class="simple-product" alt="product image">
                                        <img src="{{ asset('assets/front/img/product/product-1.jpg')}}" class="hover-product" alt="product image">
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
                        <div class="col">
                            <div class="product-item mb-20">
                                <div class="product-description">
                                    <div class="manufacturer">
                                        <p>
                                            <a href="product-details.html">Earning</a>
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
                                        <img src="{{ asset('assets/front/img/product/product-4.jpg')}}" class="simple-product" alt="product image">
                                        <img src="{{ asset('assets/front/img/product/product-5.jpg')}}" class="hover-product" alt="product image">
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
                        <div class="col">
                            <div class="product-item mb-20">
                                <div class="product-description">
                                    <div class="manufacturer">
                                        <p>
                                            <a href="product-details.html">Fashion Manufacturer</a>
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
                                        <img src="{{ asset('assets/front/img/product/product-6.jpg')}}" class="simple-product" alt="product image">
                                        <img src="{{ asset('assets/front/img/product/product-8.jpg')}}" class="hover-product" alt="product image">
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
                </div>
            </div>
        </div>
    </div>
    <!-- featured product area end -->
    <!-- featured product area start -->
    <div class="page-section feature-product-home pt-30 pb-14 pt-sm-60 pb-sm-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title pb-44">
                        <h2>
                            Featured products
                            <span style="float:right;">
                                <span class="product-btn">
                                    <a href="#" tabindex="0">
                                        Check More Product
                                        <svg class="right-arrow" width="30" height="9" viewBox="0 0 30 9" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 4C0.723858 4 0.5 4.22386 0.5 4.5C0.5 4.77614 0.723858 5 1 5V4ZM29.3536 4.85355C29.5488 4.65829 29.5488 4.34171 29.3536 4.14645L26.1716 0.964466C25.9763 0.769204 25.6597 0.769204 25.4645 0.964466C25.2692 1.15973 25.2692 1.47631 25.4645 1.67157L28.2929 4.5L25.4645 7.32843C25.2692 7.52369 25.2692 7.84027 25.4645 8.03553C25.6597 8.2308 25.9763 8.2308 26.1716 8.03553L29.3536 4.85355ZM1 5H29V4H1V5Z"></path>
                                        </svg>
                                    </a>
                                </span>
                            </span>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="product">
                <div class="row">
                    <div class="col-md-3 col-6 col-xs-6">
                        <div class="product-item mb-20">
                            <div class="product-description">
                                <div class="manufacturer">
                                    <p>
                                        <a href="product-details.html">Fashion Manufacturer</a>
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
                                    <img src="{{ asset('assets/front/img/product/product-1.jpg')}}" class="simple-product" alt="product image">
                                    <img src="{{ asset('assets/front/img/product/product-2.jpg')}}" class="hover-product" alt="product image">
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
                    <div class="col-md-3 col-6 col-xs-6">
                        <div class="product-item mb-20">
                            <div class="product-description">
                                <div class="manufacturer">
                                    <p>
                                        <a href="product-details.html">Fashion Manufacturer</a>
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
                                    <img src="{{ asset('assets/front/img/product/product-3.jpg')}}" class="simple-product" alt="product image">
                                    <img src="{{ asset('assets/front/img/product/product-4.jpg')}}" class="hover-product" alt="product image">
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
                    <div class="col-md-3 col-6 col-xs-6">
                        <div class="product-item mb-20">
                            <div class="product-description">
                                <div class="manufacturer">
                                    <p>
                                        <a href="product-details.html">Fashion Manufacturer</a>
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
                                    <img src="{{ asset('assets/front/img/product/product-2.jpg')}}" class="simple-product" alt="product image">
                                    <img src="{{ asset('assets/front/img/product/product-5.jpg')}}" class="hover-product" alt="product image">
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
                    <div class="col-md-3 col-6 col-xs-6">
                        <div class="product-item mb-20">
                            <div class="product-description">
                                <div class="manufacturer">
                                    <p>
                                        <a href="product-details.html">Fashion Manufacturer</a>
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
                                    <img src="{{ asset('assets/front/img/product/product-8.jpg')}}" class="simple-product" alt="product image">
                                    <img src="{{ asset('assets/front/img/product/product-1.jpg')}}" class="hover-product" alt="product image">
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
                    <div class="col-md-3 col-6 col-xs-6">
                        <div class="product-item mb-20">
                            <div class="product-description">
                                <div class="manufacturer">
                                    <p>
                                        <a href="product-details.html">Fashion Manufacturer</a>
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
                                    <img src="{{ asset('assets/front/img/product/product-7.jpg')}}" class="simple-product" alt="product image">
                                    <img src="{{ asset('assets/front/img/product/product-6.jpg')}}" class="hover-product" alt="product image">
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
                    <div class="col-md-3 col-6 col-xs-6">
                        <div class="product-item mb-20">
                            <div class="product-description">
                                <div class="manufacturer">
                                    <p>
                                        <a href="product-details.html">Fashion Manufacturer</a>
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
                                    <img src="{{ asset('assets/front/img/product/product-6.jpg')}}" class="simple-product" alt="product image">
                                    <img src="{{ asset('assets/front/img/product/product-4.jpg')}}" class="hover-product" alt="product image">
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
                    <div class="col-md-3 col-6 col-xs-6">
                        <div class="product-item mb-20">
                            <div class="product-description">
                                <div class="manufacturer">
                                    <p>
                                        <a href="product-details.html">Fashion Manufacturer</a>
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
                                    <img src="{{ asset('assets/front/img/product/product-7.jpg')}}" class="simple-product" alt="product image">
                                    <img src="{{ asset('assets/front/img/product/product-6.jpg')}}" class="hover-product" alt="product image">
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
                    <div class="col-md-3 col-6 col-xs-6">
                        <div class="product-item mb-20">
                            <div class="product-description">
                                <div class="manufacturer">
                                    <p>
                                        <a href="product-details.html">Fashion Manufacturer</a>
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
                                    <img src="{{ asset('assets/front/img/product/product-4.jpg')}}" class="simple-product" alt="product image">
                                    <img src="{{ asset('assets/front/img/product/product-8.jpg')}}" class="hover-product" alt="product image">
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
            </div>
        </div>
    </div>
    <!-- featured product area end -->
    <!-- offer area start -->
    <div class="offer-img">
        <img src="{{ asset('assets/front/img/bestseller/offer-2.png')}}" />
    </div>
    <!-- offer area end -->
    <!-- featured product area start -->
    <div class="page-section feature-product-home pt-100 pb-14 pt-sm-30 pb-sm-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title pb-44">
                        <h2>
                            Discover the world of jewellery & diamonds
                            <span style="float:right;">
                                <span class="product-btn">
                                    <a href="#" tabindex="0">
                                        Check More Product
                                        <svg class="right-arrow" width="30" height="9" viewBox="0 0 30 9" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 4C0.723858 4 0.5 4.22386 0.5 4.5C0.5 4.77614 0.723858 5 1 5V4ZM29.3536 4.85355C29.5488 4.65829 29.5488 4.34171 29.3536 4.14645L26.1716 0.964466C25.9763 0.769204 25.6597 0.769204 25.4645 0.964466C25.2692 1.15973 25.2692 1.47631 25.4645 1.67157L28.2929 4.5L25.4645 7.32843C25.2692 7.52369 25.2692 7.84027 25.4645 8.03553C25.6597 8.2308 25.9763 8.2308 26.1716 8.03553L29.3536 4.85355ZM1 5H29V4H1V5Z"></path>
                                        </svg>
                                    </a>
                                </span>
                            </span>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="product-carousel-one spt slick-arrow-style slick-padding">
                <div class="col">
                    <div class="product-item mb-20">
                        <div class="product-description">
                            <div class="manufacturer">
                                <p>
                                    <a href="product-details.html">Fashion Manufacturer</a>
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
                                <img src="{{ asset('assets/front/img/product/product-j1.jpg')}}" class="simple-product" alt="product image">
                                <img src="{{ asset('assets/front/img/product/product-j2.jpg')}}" class="hover-product" alt="product image">
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
                <div class="col">
                    <div class="product-item mb-20">
                        <div class="product-description">
                            <div class="manufacturer">
                                <p>
                                    <a href="product-details.html">Fashion Manufacturer</a>
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
                                <img src="{{ asset('assets/front/img/product/product-j3.jpg')}}" class="simple-product" alt="product image">
                                <img src="{{ asset('assets/front/img/product/product-j4.jpg')}}" class="hover-product" alt="product image">
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
                <div class="col">
                    <div class="product-item mb-20">
                        <div class="product-description">
                            <div class="manufacturer">
                                <p>
                                    <a href="product-details.html">Fashion Manufacturer</a>
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
                                <img src="{{ asset('assets/front/img/product/product-j5.jpg')}}" class="simple-product" alt="product image">
                                <img src="{{ asset('assets/front/img/product/product-j6.jpg')}}" class="hover-product" alt="product image">
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
                <div class="col">
                    <div class="product-item mb-20">
                        <div class="product-description">
                            <div class="manufacturer">
                                <p>
                                    <a href="product-details.html">Fashion Manufacturer</a>
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
                                <img src="{{ asset('assets/front/img/product/product-j7.jpg')}}" class="simple-product" alt="product image">
                                <img src="{{ asset('assets/front/img/product/product-j8.jpg')}}" class="hover-product" alt="product image">
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
                <div class="col">
                    <div class="product-item mb-20">
                        <div class="product-description">
                            <div class="manufacturer">
                                <p>
                                    <a href="product-details.html">Fashion Manufacturer</a>
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
                                <img src="{{ asset('assets/front/img/product/product-j9.jpg')}}" class="simple-product" alt="product image">
                                <img src="{{ asset('assets/front/img/product/product-j10.jpg')}}" class="hover-product" alt="product image">
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
                <div class="col">
                    <div class="product-item mb-20">
                        <div class="product-description">
                            <div class="manufacturer">
                                <p>
                                    <a href="product-details.html">Fashion Manufacturer</a>
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
                                <img src="{{ asset('assets/front/img/product/product-j11.jpg')}}" class="simple-product" alt="product image">
                                <img src="{{ asset('assets/front/img/product/product-j12.jpg')}}" class="hover-product" alt="product image">
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
                <div class="col">
                    <div class="product-item mb-20">
                        <div class="product-description">
                            <div class="manufacturer">
                                <p>
                                    <a href="product-details.html">Fashion Manufacturer</a>
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
                                <img src="{{ asset('assets/front/img/product/product-j2.jpg')}}" class="simple-product" alt="product image">
                                <img src="{{ asset('assets/front/img/product/product-j5.jpg')}}" class="hover-product" alt="product image">
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
        </div>
    </div>
    <!-- featured product area end -->
    <!-- details area start -->
    <div class="page-section top-space-category pt-150 pb-100 bg-dark pb-14 pt-sm-30 pb-sm-0">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="product-details-home pt-80">
                        <h2 class="mb-50 text-white">
                            Luxury Jewellery<br />Online Buy
                        </h2>
                        <p class="mb-80 text-white">
                            jewelleryanddiamonds.com has the best selection of diamonds in our online jewellery store. Visit us today and have confidence that your diamond is in the safest hands possible.
                        </p>
                        <div class="product-btn">
                            <a href="#" tabindex="0">
                                Check More Product
                                <svg class="right-arrow" width="30" height="9" viewBox="0 0 30 9" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 4C0.723858 4 0.5 4.22386 0.5 4.5C0.5 4.77614 0.723858 5 1 5V4ZM29.3536 4.85355C29.5488 4.65829 29.5488 4.34171 29.3536 4.14645L26.1716 0.964466C25.9763 0.769204 25.6597 0.769204 25.4645 0.964466C25.2692 1.15973 25.2692 1.47631 25.4645 1.67157L28.2929 4.5L25.4645 7.32843C25.2692 7.52369 25.2692 7.84027 25.4645 8.03553C25.6597 8.2308 25.9763 8.2308 26.1716 8.03553L29.3536 4.85355ZM1 5H29V4H1V5Z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="product-img-det pt-80 pb-80">
                        <img src="{{ asset('assets/front/img/product/two-ring.webp')}}" />
                        <div class="product-det">
                            <p>
                                Rings
                                Golden Ring
                                $34.59
                                <a href="#">More</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- details area end -->
    <!-- testimonial area start -->
    <div class="testimonial-area pt-20 pb-50 pt-sm-58 pb-sm-92">
        <!--<img src="{{ asset('assets/front/img/logo/left-shape.svg')}}" class="test-left" />
        <img src="{{ asset('assets/front/img/logo/right-shape.svg')}}" class="test-right" />-->
        <div class="container">
            <div class="heading text-center">
                <!--<img src="{{ asset('assets/front/img/about/OBJECTS.svg')}}" />-->
                <h2 class="heading-title">Testimonials</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="testimonial-carousel-active slick-dot-style">
                        <div class="testimonial-item text-center">
                            <div class="testimonial-border">
                                <div class="row">
                                    <div class="col-md-2 col-2">
                                        <img src="{{ asset('assets/front/img/product/product-1.jpg')}}" class="testimonial-pic" alt="">
                                    </div>
                                    <div class="col-md-10 col-10">
                                        <div class="testimonial-thumb">
                                            <div class="user-details">
                                                <h3>
                                                    <a href="#">Nice Product</a>
                                                    <span style="float:right;">
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star"></i>
                                                        4.5/5.0
                                                    </span>
                                                </h3>

                                            </div>
                                        </div>
                                        <div class="testimonial-content">
                                            <p>
                                                “I was amazed by the quality and beauty of the jewelry I purchased from 8thiniq.
                                                The craftsmanship is exceptional, and each piece truly exudes a regal feel.
                                                The best part is that the prices are so affordable, allowing me to indulge in luxury without breaking the bank.
                                                ”
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-item text-center">
                            <div class="testimonial-border">
                                <div class="row">
                                    <div class="col-md-2 col-2">
                                        <img src="{{ asset('assets/front/img/product/product-2.jpg')}}" class="testimonial-pic" alt="">
                                    </div>
                                    <div class="col-md-10 col-10">
                                        <div class="testimonial-thumb">
                                            <div class="user-details">
                                                <h3>
                                                    <a href="#">Excellent Product</a>
                                                    <span style="float:right;">
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star"></i>
                                                        4.5/5.0
                                                    </span>
                                                </h3>

                                            </div>
                                        </div>
                                        <div class="testimonial-content">
                                            <p>
                                                “I was amazed by the quality and beauty of the jewelry I purchased from 8thiniq.
                                                The craftsmanship is exceptional, and each piece truly exudes a regal feel.
                                                The best part is that the prices are so affordable, allowing me to indulge in luxury without breaking the bank.
                                                ”
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-item text-center">
                            <div class="testimonial-border">
                                <div class="row">
                                    <div class="col-md-2 col-2">
                                        <img src="{{ asset('assets/front/img/product/product-3.jpg')}}" class="testimonial-pic" alt="">
                                    </div>
                                    <div class="col-md-10 col-10">
                                        <div class="testimonial-thumb">
                                            <div class="user-details">
                                                <h3>
                                                    <a href="#">Great Product</a>
                                                    <span style="float:right;">
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star"></i>
                                                        4.5/5.0
                                                    </span>
                                                </h3>

                                            </div>
                                        </div>
                                        <div class="testimonial-content">
                                            <p>
                                                “I was amazed by the quality and beauty of the jewelry I purchased from 8thiniq.
                                                The craftsmanship is exceptional, and each piece truly exudes a regal feel.
                                                The best part is that the prices are so affordable, allowing me to indulge in luxury without breaking the bank.
                                                ”
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-item text-center">
                            <div class="testimonial-border">
                                <div class="row">
                                    <div class="col-md-2 col-2">
                                        <img src="{{ asset('assets/front/img/product/product-4.jpg')}}" class="testimonial-pic" alt="">
                                    </div>
                                    <div class="col-md-10 col-10">
                                        <div class="testimonial-thumb">
                                            <div class="user-details">
                                                <h3>
                                                    <a href="#">Payal Zala</a>
                                                    <span style="float:right;">
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star"></i>
                                                        4.5/5.0
                                                    </span>
                                                </h3>

                                            </div>
                                        </div>
                                        <div class="testimonial-content">
                                            <p>
                                                “I was amazed by the quality and beauty of the jewelry I purchased from 8thiniq.
                                                The craftsmanship is exceptional, and each piece truly exudes a regal feel.
                                                The best part is that the prices are so affordable, allowing me to indulge in luxury without breaking the bank.
                                                ”
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-item text-center">
                            <div class="testimonial-border">
                                <div class="row">
                                    <div class="col-md-2 col-2">
                                        <img src="{{ asset('assets/front/img/product/product-5.jpg')}}" class="testimonial-pic" alt="">
                                    </div>
                                    <div class="col-md-10 col-10">
                                        <div class="testimonial-thumb">
                                            <div class="user-details">
                                                <h3>
                                                    <a href="#">Payal Zala</a>
                                                    <span style="float:right;">
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star fill"></i>
                                                        <i class="fa fa-star"></i>
                                                        4.5/5.0
                                                    </span>
                                                </h3>

                                            </div>
                                        </div>
                                        <div class="testimonial-content">
                                            <p>
                                                “I was amazed by the quality and beauty of the jewelry I purchased from 8thiniq.
                                                The craftsmanship is exceptional, and each piece truly exudes a regal feel.
                                                The best part is that the prices are so affordable, allowing me to indulge in luxury without breaking the bank.
                                                ”
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- testimonial area end -->
    <!-- latest blog area start -->
    <div class="latest-blog-area pt-50 pb-90 pt-sm-58 pb-sm-50">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-12">
                    <div class="blog-bg">
                        <div class="section-title text-center pb-44">
                            <h2>Jaipur Jewellery News</h2>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="blog-list">
                                    <img src="{{ asset('assets/front/img/blog/blog-1.jpg')}}" />
                                    <div class="blog-content">
                                        <h3>Jaipur Jewellers House announces wedding season offering with Muhurat 2.0</h3>
                                        <p>
                                            Thrissur, April 17, 2021: In a bid to celebrate the diverse cultures and changing preferences of millennial brides-to-be, Kalyan Jewellers has revamped its wedding jewellery collection... read more
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="blog-list">
                                    <img src="{{ asset('assets/front/img/blog/blog-1.jpg')}}" />
                                    <div class="blog-content">
                                        <h3>Jaipur Jewellers House announces wedding season offering with Muhurat 2.0</h3>
                                        <p>
                                            Thrissur, April 17, 2021: In a bid to celebrate the diverse cultures and changing preferences of millennial brides-to-be, Kalyan Jewellers has revamped its wedding jewellery collection... read more
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="text-center">
                            <span class="product-btn pt-4">
                                <a href="#" tabindex="0">
                                    View More
                                    <svg class="right-arrow" width="30" height="9" viewBox="0 0 30 9" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 4C0.723858 4 0.5 4.22386 0.5 4.5C0.5 4.77614 0.723858 5 1 5V4ZM29.3536 4.85355C29.5488 4.65829 29.5488 4.34171 29.3536 4.14645L26.1716 0.964466C25.9763 0.769204 25.6597 0.769204 25.4645 0.964466C25.2692 1.15973 25.2692 1.47631 25.4645 1.67157L28.2929 4.5L25.4645 7.32843C25.2692 7.52369 25.2692 7.84027 25.4645 8.03553C25.6597 8.2308 25.9763 8.2308 26.1716 8.03553L29.3536 4.85355ZM1 5H29V4H1V5Z"></path>
                                    </svg>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="blog-bg">
                        <div class="section-title text-center pb-44">
                            <h2>Blogs</h2>
                        </div>

                        <div class="blog-content">
                            <h3>Jaipur Jewellers House announces wedding season offering with Muhurat 2.0</h3>
                            <p>
                                Thrissur, April 17, 2021: In a bid to celebrate the diverse cultures and changing preferences of millennial brides-to-be, Kalyan Jewellers has revamped its wedding jewellery collection... read more
                            </p>
                        </div>
                        <hr />
                        <div class="blog-content">
                            <h3>Jaipur Jewellers House announces wedding season offering with Muhurat 2.0</h3>
                            <p>
                                Thrissur, April 17, 2021: In a bid to celebrate the diverse cultures and changing preferences of millennial brides-to-be, Kalyan Jewellers has revamped its wedding jewellery collection... read more
                            </p>
                        </div>
                        <hr />
                        <br />
                        <div class="text-center">
                            <span class="product-btn">
                                <a href="#" tabindex="0">
                                    View More
                                    <svg class="right-arrow" width="30" height="9" viewBox="0 0 30 9" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 4C0.723858 4 0.5 4.22386 0.5 4.5C0.5 4.77614 0.723858 5 1 5V4ZM29.3536 4.85355C29.5488 4.65829 29.5488 4.34171 29.3536 4.14645L26.1716 0.964466C25.9763 0.769204 25.6597 0.769204 25.4645 0.964466C25.2692 1.15973 25.2692 1.47631 25.4645 1.67157L28.2929 4.5L25.4645 7.32843C25.2692 7.52369 25.2692 7.84027 25.4645 8.03553C25.6597 8.2308 25.9763 8.2308 26.1716 8.03553L29.3536 4.85355ZM1 5H29V4H1V5Z"></path>
                                    </svg>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- latest blog area end -->
    <!-- instagram area start -->
    <div class="latest-blog-area pt-50 pb-20 pt-sm-58 pb-sm-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center pb-44">
                        <h2>Shop by instagram</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-4 space-right">
                    <div class="blog-item">
                        <div class="instagram-img">
                            <img src="{{ asset('assets/front/img/follow/6.jpg')}}" width="100%" />
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-4">
                    <div class="row">
                        <div class="col-md-6 col-6 space-right">
                            <div class="blog-item">
                                <div class="instagram-img">
                                    <img src="{{ asset('assets/front/img/follow/1.jpg')}}" style="height:50%;" />
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="blog-item">
                                <div class="instagram-img">
                                    <img src="{{ asset('assets/front/img/follow/2.jpg')}}" />
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-6 space-right">
                            <div class="blog-item">
                                <div class="instagram-img">
                                    <img src="{{ asset('assets/front/img/follow/3.jpg')}}" style="height:50%;" />
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="blog-item">
                                <div class="instagram-img">
                                    <img src="{{ asset('assets/front/img/follow/5.jpg')}}" />
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 col-4 space-right">
                    <div class="blog-item">
                        <div class="instagram-img">
                            <img src="{{ asset('assets/front/img/follow/7.jpg')}}" width="100%" />
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- instagram area end -->
    <!-- serviec area start -->
    <div class="latest-blog-area pt-50 pb-80 pt-sm-58 pb-sm-50">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2 col-4">
                    <div class="blog-item">
                        <div class="service-part-img">
                            <img src="{{ asset('assets/front/img/logo/fast-delivery.png')}}" />
                            <h5>Free Shipping*</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-4">
                    <div class="blog-item">
                        <div class="service-part-img">
                            <img src="{{ asset('assets/front/img/logo/worldwide.png')}}" />
                            <h5>Worldwise Delivery</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-4">
                    <div class="blog-item">
                        <div class="service-part-img">
                            <img src="{{ asset('assets/front/img/logo/credit-card.png')}}" />
                            <h5>Secured Payments</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-4">
                    <div class="blog-item">
                        <div class="service-part-img">
                            <img src="{{ asset('assets/front/img/logo/cash-on-delivery.png')}}" />
                            <h5>Cash on Delivery*</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-4">
                    <div class="blog-item">
                        <div class="service-part-img">
                            <img src="{{ asset('assets/front/img/logo/customer-service.png')}}" />
                            <h5>Easy Customer Support</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-4">
                    <div class="blog-item">
                        <div class="service-part-img">
                            <img src="{{ asset('assets/front/img/logo/india.png')}}" />
                            <h5>Make in india</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- serviec area end -->
    
@endsection