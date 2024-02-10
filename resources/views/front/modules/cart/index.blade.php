@extends('front.layouts.app')
@section('content')    
<!-- header area end -->
<div class="breadcrumb-area pb-60 pt-60" style="background-image: url({{asset('assets/front/img/slider/bg-about.png')}}); background-size: 100%; background-repeat: no-repeat; ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <h2 class="text-white">Cart</h2>
                        <p class="text-white">Home / Cart</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- page main wrapper start -->
    <!-- page main wrapper start -->
    <main class="main-bg">
        <!-- cart main wrapper start -->
        <div class="cart-main-wrapper pt-50 pb-50 pt-sm-58 pb-sm-58">
            <div class="container">
                <div class="row">
                @php
                $totalPrice = 0;
                @endphp
                    @if(!empty($cartData))
                    <div class="col-lg-8">
                        <!-- Cart Table Area -->
                        @foreach($cartData as $cartVal)
                        <div class="cart-lists mb-10">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="pro-thumbnail">
                                        <a href="#">
                                            <img class="img-fluid" src="{{$cartVal['product_image']}}" alt="Product" />
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="product-details-des cart">
                                        <h3 class="mt-10 mb-0">{{$cartVal['product_name'] ?? ''}} {{$cartVal['variant_value1_name'] ?? ''}} {{$cartVal['variant_value2_name'] ?? ''}}</h3>
                                        <!-- <h6>
                                            <span class="category-show">Weight : 10.574g | Size : 38.48cm</span>

                                        </h6> -->
                                        <h6 class="mt-0 pt-0 pb-0">
                                            <span class="category-show">Qty : {{$cartVal['quantity']}}</span>

                                        </h6>
                                        <!--<div class="quantity-cart-box">
                                            <select class="size-input">
                                                <option>Qty</option>
                                                <option>1</option>
                                            </select>
                                        </div>-->
                                        <div class="pricebox mt-10">
                                            <span class="regular-price"> {{config('Reading.default_currency').number_format($cartVal['product_price'] ?? 0,2)}} </span>&nbsp;&nbsp; <del>{{config('Reading.default_currency').number_format($cartVal['buying_price'] ?? 0,2)}}</del>
                                        </div>

                                        <div class="delete-cart-list mt-10">
                                            <a href="{{route('front-user.removeFromCart').'?product_id='.$cartVal['product_id']}}" class="cart-text">
                                                <span style="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                                    </svg>
                                                    Remove
                                                </span>
                                            </a>
                                            &nbsp;&nbsp;|&nbsp;&nbsp;
                                            <a href="{{route('front-user.addToWishlist')."?action=move&product_id=".$cartVal['product_id']}}" class="cart-text">
                                                <span style="">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-suit-heart" viewBox="0 0 16 16">
                                                        <path d="m8 6.236-.894-1.789c-.222-.443-.607-1.08-1.152-1.595C5.418 2.345 4.776 2 4 2 2.324 2 1 3.326 1 4.92c0 1.211.554 2.066 1.868 3.37.337.334.721.695 1.146 1.093C5.122 10.423 6.5 11.717 8 13.447c1.5-1.73 2.878-3.024 3.986-4.064.425-.398.81-.76 1.146-1.093C14.446 6.986 15 6.131 15 4.92 15 3.326 13.676 2 12 2c-.777 0-1.418.345-1.954.852-.545.515-.93 1.152-1.152 1.595L8 6.236zm.392 8.292a.513.513 0 0 1-.784 0c-1.601-1.902-3.05-3.262-4.243-4.381C1.3 8.208 0 6.989 0 4.92 0 2.755 1.79 1 4 1c1.6 0 2.719 1.05 3.404 2.008.26.365.458.716.596.992a7.55 7.55 0 0 1 .596-.992C9.281 2.049 10.4 1 12 1c2.21 0 4 1.755 4 3.92 0 2.069-1.3 3.288-3.365 5.227-1.193 1.12-2.642 2.48-4.243 4.38z" />
                                                    </svg>
                                                    Move to Wishlist
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                        $totalPrice += $cartVal['product_price'] ?? 0;
                        @endphp
                        @endforeach
                      
                    </div>
                    @else
                    <h6 class="text-center">No Data Found</h6>
                    @endif
                    <div class="col-lg-4">
                        <!-- <div class="login-signup mb-20">
                            <p><a href="#">Register</a> / <a href="#"> Login</a> to get exciting offers & benefits on your account</p>
                        </div> -->
                        <div class="cart-amount">
                            <!-- <div class="cart-update-option d-block d-md-flex justify-content-between">
                                <div class="apply-coupon-wrapper" style="width:100%;">
                                    <form action="#" method="post">
                                        <div class="row" style="width: 100%; --bs-gutter-x: 0;">
                                            <div class="col-md-8">
                                                <input type="text" placeholder="Enter Your Coupon Code" class="form-control" required />
                                            </div>
                                            <div class="col-md-4" style="padding-left:10px;">
                                                <button class="sqr-btn w-100" type="submit">Apply</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <p class="mb-20"><a href="#" style="border-bottom: 2px solid #446e6f; color: #446e6f;">CHECK COUPON</a></p>
                            <hr /> -->
                            <div class="cart-calculator-wrapper">
                                <div class="cart-calculate-items">
                                    <h3 class="mb-20">Order Summary</h3>
                                    <hr />
                                    <div class="table-responsive">
                                        <table width="100%">
                                            <!-- <tr>
                                                <td>Sub-Total</td>
                                                <td style="text-align:right;font-weight:500;">{{config('Reading.default_currency').number_format($totalPrice,2)}}</td>
                                            </tr> -->
                                            <!-- <tr>
                                                <td>Delivery Charge</td>
                                                <td style="text-align: right; font-weight: 500;">₹500</td>
                                            </tr>
                                            <tr class="total">
                                                <td>Discount</td>
                                                <td style="text-align: right; font-weight: 500; color: #4eb250; " class="total-amount">-₹1,500</td>
                                            </tr> -->
                                            <tr class="total">
                                                <td style="font-weight:500;">Total ({{count($cartData)}} items)</td>
                                                <td style="text-align: right; font-weight: 500;">{{config('Reading.default_currency').number_format($totalPrice,2)}}</td>
                                            </tr>
                                            <!-- <tr class="total">
                                                <td style="color: #4eb250;">YOU SAVE</td>
                                                <td style="text-align: right; font-weight: 500; color: #4eb250; " class="total-amount">+₹1,500</td>
                                            </tr> -->
                                        </table>
                                    </div>
                                </div>

                            </div>
                            
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cart main wrapper end -->
    </main>
    <!-- page main wrapper end -->
    <div class="checkout-button-fixed mt-10">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h5>Total ({{count($cartData)}} items) &nbsp;&nbsp;:&nbsp;&nbsp; {{config('Reading.default_currency').number_format($totalPrice,2)}}</h5>
                </div>
                <div class="col-md-2">
                    <a href="{{route('front-shop.index')}}" class="sqr-btn d-block">
                        Continue Shopping
                    </a>
                </div>
                <div class="col-md-2">
                    <a href="{{route('front-cart.index').'?checkoutFrom=cartPage'}}" class="sqr-btn buy-now d-block">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection