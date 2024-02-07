@extends('front.layouts.app')
@section('content')    
<div class="breadcrumb-area pb-80 pt-80" style="background-image: url({{asset('assets/front/img/slider/bg-about.png')}}); background-size: 100%; background-repeat: no-repeat; ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <h2 class="text-white">My Profile</h2>
                        <p class="text-white">Home / My Profile</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- page main wrapper start -->
    <!-- page main wrapper start -->
    <main>
        <!-- my account wrapper start -->
        <div class="my-account-wrapper pt-50 pb-50 pt-sm-58 pb-sm-58">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- My Account Page Start -->
                        <div class="myaccount-page-wrapper">
                            <!-- My Account Tab Menu Start -->
                            <div class="row">
                                <div class="col-lg-3 col-md-4">
                                    <div class="myaccount-tab-menu nav" role="tablist">
                                        <a href="{{route('front-user.dashboard')}}"><i class="fa fa-dashboard"></i>Dashboard</a>
                                        <a href="{{route('front-user.orders')}}"><i class="fa fa-shopping-bag"></i> Orders</a>
                                        <a href="{{route('front-user.wishlist')}}" class="active"><i class="fa fa-heart"></i> Wishlist</a>
                                        <!-- <a href="#"><i class="fa fa-credit-card"></i> Payment Method</a> -->
                                        <a href="{{route('front-user.addresses')}}"><i class="fa fa-map"></i> address</a>
                                        <a href="{{route('front-user.logout')}}"><i class="fa fa-sign-out"></i> Logout</a>
                                    </div>
                                </div>
                                <!-- My Account Tab Menu End -->
                                <!-- My Account Tab Content Start -->
                                <div class="col-lg-9 col-md-8">
                                    <div class="tab-content" id="myaccountContent">
                                       
                                        <div class="tab-pane fade show active" id="mywishlist" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h3>My Wishlist</h3>
                                                <div class="shop-product-wrap grid row">
                                                    @if(!empty($wishlistData))
                                                    @foreach($wishlistData as $cartVal)
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6">
                                                        <div class="product-item mb-20">
                                                            <div class="product-description">
                                                                <div class="manufacturer">
                                                                    <p>
                                                                        <a href="{{route('front-shop.productDetail',$cartVal['slug'])}}">{{$cartVal['category_name'] ?? ''}}</a>
                                                                        <span style="float:right;">
                                                                            <a class="wishlist-list wish" href="#" title="" tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path><use xlink:href="#wish"></use></svg></a>
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                                <div class="product-name">
                                                                    <h3><a href="{{route('front-shop.productDetail',$cartVal['slug'])}}">{{$cartVal['product_name'] ?? ''}}</a></h3>
                                                                </div>
                                                            </div>
                                                            <div class="product-thumb">
                                                                <a href="{{route('front-shop.productDetail',$cartVal['slug'])}}">
                                                                    <img src="{{!empty($cartVal['product_image'][0]) ? $cartVal['product_image'][0]  : ''}}" class="simple-product" alt="product image">
                                                                    <img src="{{!empty($cartVal['product_image'][1]) ? $cartVal['product_image'][1]  : ''}}" class="hover-product" alt="product image">
                                                                </a>
                                                                <!-- <div class="box-label">
                                                                    <div class="product-label new">
                                                                        <span>SPECIAL OFFER</span>
                                                                    </div>
                                                                </div> -->
                                                            </div>
                                                            <div class="product-description">
                                                                <div class="price-box mt-10 mb-3">
                                                                    <span class="regular-price">{{config('Reading.default_currency').number_format($cartVal['product_price'] ?? 0,2)}}</span>
                                                                    <span class="old-price"><del>{{config('Reading.default_currency').number_format($cartVal['buying_price'] ?? 0,2)}}</del></span>
                                                                    <span style="float:right;">
                                                                        <a href="#" class="text-center cartIconAction {{!empty($cartVal['isProductAddedIntoCart']) ? 'added' : ''}}" data-id="{{$cartVal['product_id'] ?? ''}}">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16">
                                                                                <path fill-rule="evenodd" fill="{{!empty($cartVal['isProductAddedIntoCart']) ? '#FF0000' : ''}}" clip-rule="evenodd" d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"></path>
                                                                                <path fill-rule="evenodd" fill="{{!empty($cartVal['isProductAddedIntoCart']) ? '#FF0000' : ''}}" clip-rule="evenodd" d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"></path>
                                                                            </svg>
                                                                        </a>
                                                                        <a href="{{route('front-user.removeFromWishlist',['product_id' => $cartVal['product_id']])}}" class="text-center">
                                                                            <svg class="product-list-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M20.9997 6.72998C20.9797 6.72998 20.9497 6.72998 20.9197 6.72998C15.6297 6.19998 10.3497 5.99998 5.11967 6.52998L3.07967 6.72998C2.65967 6.76998 2.28967 6.46998 2.24967 6.04998C2.20967 5.62998 2.50967 5.26998 2.91967 5.22998L4.95967 5.02998C10.2797 4.48998 15.6697 4.69998 21.0697 5.22998C21.4797 5.26998 21.7797 5.63998 21.7397 6.04998C21.7097 6.43998 21.3797 6.72998 20.9997 6.72998Z" fill="#FF0505"></path>
                                                                                <path d="M8.49977 5.72C8.45977 5.72 8.41977 5.72 8.36977 5.71C7.96977 5.64 7.68977 5.25 7.75977 4.85L7.97977 3.54C8.13977 2.58 8.35977 1.25 10.6898 1.25H13.3098C15.6498 1.25 15.8698 2.63 16.0198 3.55L16.2398 4.85C16.3098 5.26 16.0298 5.65 15.6298 5.71C15.2198 5.78 14.8298 5.5 14.7698 5.1L14.5498 3.8C14.4098 2.93 14.3798 2.76 13.3198 2.76H10.6998C9.63977 2.76 9.61977 2.9 9.46977 3.79L9.23977 5.09C9.17977 5.46 8.85977 5.72 8.49977 5.72Z" fill="#FF0505"></path>
                                                                                <path d="M15.2104 22.7501H8.79039C5.30039 22.7501 5.16039 20.8201 5.05039 19.2601L4.40039 9.19007C4.37039 8.78007 4.69039 8.42008 5.10039 8.39008C5.52039 8.37008 5.87039 8.68008 5.90039 9.09008L6.55039 19.1601C6.66039 20.6801 6.70039 21.2501 8.79039 21.2501H15.2104C17.3104 21.2501 17.3504 20.6801 17.4504 19.1601L18.1004 9.09008C18.1304 8.68008 18.4904 8.37008 18.9004 8.39008C19.3104 8.42008 19.6304 8.77007 19.6004 9.19007L18.9504 19.2601C18.8404 20.8201 18.7004 22.7501 15.2104 22.7501Z" fill="#FF0505"></path>
                                                                                <path d="M13.6601 17.25H10.3301C9.92008 17.25 9.58008 16.91 9.58008 16.5C9.58008 16.09 9.92008 15.75 10.3301 15.75H13.6601C14.0701 15.75 14.4101 16.09 14.4101 16.5C14.4101 16.91 14.0701 17.25 13.6601 17.25Z" fill="#FF0505"></path>
                                                                                <path d="M14.5 13.25H9.5C9.09 13.25 8.75 12.91 8.75 12.5C8.75 12.09 9.09 11.75 9.5 11.75H14.5C14.91 11.75 15.25 12.09 15.25 12.5C15.25 12.91 14.91 13.25 14.5 13.25Z" fill="#FF0505"></path>
                                                                            </svg>
                                                                        </a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    @else
                                                    <h5 class="text-center">No Wishlists Found</h5>
                                                    @endif
                                                  
                                                        
                                                </div>
                                            </div>
                                        </div>
                                       
                                        
                                       
                                    </div>
                                </div> <!-- My Account Tab Content End -->
                            </div>
                        </div> <!-- My Account Page End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- my account wrapper end -->
    </main>
    <!-- page main wrapper end -->

    
@endsection