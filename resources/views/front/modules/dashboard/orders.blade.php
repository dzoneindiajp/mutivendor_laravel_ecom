@extends('front.layouts.app')
@section('content')
<div class="breadcrumb-area pb-80 pt-80"
    style="background-image: url({{asset('assets/front/img/slider/bg-about.png')}}); background-size: 100%; background-repeat: no-repeat; ">
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
                                    <a href="{{route('front-user.dashboard')}}"><i
                                            class="fa fa-dashboard"></i>Dashboard</a>
                                    <a href="{{route('front-user.orders')}}" class="active"><i
                                            class="fa fa-shopping-bag"></i> Orders</a>
                                    <a href="{{route('front-user.wishlist')}}"><i class="fa fa-heart"></i> Wishlist</a>
                                    <!-- <a href="#"><i class="fa fa-credit-card"></i> Payment Method</a> -->
                                    <a href="{{route('front-user.addresses')}}"><i class="fa fa-map"></i> address</a>
                                    <a href="{{route('front-user.logout')}}"><i class="fa fa-sign-out"></i> Logout</a>
                                </div>
                            </div>
                            <!-- My Account Tab Menu End -->
                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade show active" id="orders" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>My Orders</h3>
                                            <div class="order-list-profile mt-20">
                                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link active" id="home-tab"
                                                            data-bs-toggle="tab" data-bs-target="#home" type="button"
                                                            role="tab" aria-controls="home" aria-selected="true">Active
                                                            (3)</button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                            data-bs-target="#profile" type="button" role="tab"
                                                            aria-controls="profile" aria-selected="false">Delivered
                                                            (1)</button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                                            data-bs-target="#contact" type="button" role="tab"
                                                            aria-controls="contact" aria-selected="false">Cancelled
                                                            (2)</button>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade show active" id="home" role="tabpanel"
                                                        aria-labelledby="home-tab">
                                                        @if(!empty($active_orders))
                                                            @foreach($active_orders as $active_order)
                                                                <div class="order-list">
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <div class="product-img">
                                                                                <img src="{{$active_order['product_image']}}"
                                                                                    width="100%" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <div class="active-order-list">
                                                                                <h5>{{$active_order['name']}}
                                                                                    <?php
                                                                                        $statusValue = "";
                                                                                        if ($active_order['status'] == "received"){
                                                                                            $statusValue = "Received";
                                                                                        } elseif ($active_order['status'] == "confirmed"){
                                                                                            $statusValue = "Confirmed";
                                                                                        } elseif ($active_order['status'] == "shipped") {
                                                                                            $statusValue = "Shipped";
                                                                                        } else {
                                                                                            $statusValue = "Out For Delivery";
                                                                                        }

                                                                                    ?>
                                                                                    <span
                                                                                        class="delevery-status">{{$statusValue}}
                                                                                    </span>
                                                                                </h5>
                                                                                <p class="order-date mt-10">Ordered on: {{ \Carbon\Carbon::parse($active_order['created_at'])->format('d M Y') }}</p>
                                                                                <h4 class="rate-order mt-10">{{getCurrencySymbol($active_order['currency_code'])}}{{$active_order['total']}}</h4>
                                                                                <p class="delevery-date mt-10">Arriving on Feb
                                                                                    16, 2022 &nbsp; <a href="#"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#track-order{{$active_order['id']}}"
                                                                                        class="track-order">Track Order</a></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="modal" id="track-order{{$active_order['id']}}">
                                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">

                                                                                <button type="button" class="close"
                                                                                    data-bs-dismiss="modal">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <!-- product details inner end -->
                                                                                <h4 class="order-head">Order details</h4>
                                                                                <div class="edit-account">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-12 col-md-6">
                                                                                            <div class="order-list">
                                                                                                <div class="row">
                                                                                                    <div class="col-md-3">
                                                                                                        <div class="product-img">
                                                                                                            <img src="{{asset('assets/front/img/product/product-1.png')}}"
                                                                                                                width="100%" />
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-9">
                                                                                                        <div class="active-order-list">
                                                                                                            <h5>{{$active_order['name']}}</h5>
                                                                                                            <p class="order-date mt-2">Ordered on:
                                                                                                                {{ \Carbon\Carbon::parse($active_order['created_at'])->format('d M Y') }}</p>
                                                                                                            <h4 class="rate-order mt-2">{{getCurrencySymbol($active_order['currency_code'])}}{{$active_order['total']}}
                                                                                                            </h4>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-12 col-md-6">
                                                                                            <div class="cart-amount track-popup mt-3 mb-3">
                                                                                                <div class="cart-calculator-wrapper">
                                                                                                    <div class="cart-calculate-items">
                                                                                                        <h3 class="mb-10">Order summary</h3>

                                                                                                        <div class="table-responsive">
                                                                                                            <table width="100%">
                                                                                                                <tr>
                                                                                                                    <td>Sub-Total</td>
                                                                                                                    <td
                                                                                                                        style="text-align:right;font-weight:bold;">
                                                                                                                        {{getCurrencySymbol($active_order['currency_code'])}}{{$active_order['sub_total']}}</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Shipping</td>
                                                                                                                    <td
                                                                                                                        style="text-align: right; font-weight: bold;">
                                                                                                                        {{getCurrencySymbol($active_order['currency_code'])}}{{$active_order['delivery']}}</td>
                                                                                                                </tr>
                                                                                                                <tr class="total">
                                                                                                                    <td>Discount</td>
                                                                                                                    <td style="text-align: right; font-weight: bold; color: #ffb932; "
                                                                                                                        class="total-amount">- {{getCurrencySymbol($active_order['currency_code'])}}{{$active_order['coupon_discount']}}</td>
                                                                                                                </tr>
                                                                                                                <tr class="total">
                                                                                                                    <td>Total</td>
                                                                                                                    <td
                                                                                                                        style="text-align: right; font-weight: bold;">
                                                                                                                        {{getCurrencySymbol($active_order['currency_code'])}}{{$active_order['total']}}</td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-12 col-md-12">
                                                                                            <div class="wrapper mb-3">
                                                                                                <ul class="StepProgress">
                                                                                                    <li class="StepProgress-item is-done">
                                                                                                        <strong>Ordered on {{ \Carbon\Carbon::parse($active_order['created_at'])->isoFormat('MMM D, YYYY | h:mm A') }}</strong></li>
                                                                                                    @if($active_order['status'] == "shipped")
                                                                                                    <li class="StepProgress-item is-done">
                                                                                                        <strong>Shipped</strong></li>
                                                                                                    @endif
                                                                                                    @if($active_order['status'] == "shipped")
                                                                                                    <li class="StepProgress-item"><strong>Out for
                                                                                                        delivery</strong></li>
                                                                                                    @endif

                                                                                                    <li class="StepProgress-item"><strong>Arriving
                                                                                                            on Sep 30, 2023</strong></li>
                                                                                                </ul>
                                                                                            </div>
                                                                                            <div class="cart-amount track-popup mt-3 mb-3">
                                                                                                <div class="cart-calculator-wrapper">
                                                                                                    <div class="cart-calculate-items">
                                                                                                        <h3 class="mb-10">Shipping address</h3>
                                                                                                        <p>3517 W. Gray St. Utica, Pennsylvania
                                                                                                            57867</p>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-lg-12 col-md-12">
                                                                                            <div class="form-group mb-0">
                                                                                                <a href="#"
                                                                                                    class="sqr-btn d-block bg-danger text-white">
                                                                                                    Cancel order
                                                                                                    <svg width="30" height="8" viewBox="0 0 30 8"
                                                                                                        fill="none"
                                                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                                                        <path
                                                                                                            d="M1 3.5C0.723858 3.5 0.5 3.72386 0.5 4C0.5 4.27614 0.723858 4.5 1 4.5V3.5ZM29.3536 4.35355C29.5488 4.15829 29.5488 3.84171 29.3536 3.64645L26.1716 0.464466C25.9763 0.269204 25.6597 0.269204 25.4645 0.464466C25.2692 0.659728 25.2692 0.976311 25.4645 1.17157L28.2929 4L25.4645 6.82843C25.2692 7.02369 25.2692 7.34027 25.4645 7.53553C25.6597 7.7308 25.9763 7.7308 26.1716 7.53553L29.3536 4.35355ZM1 4.5H29V3.5H1V4.5Z"
                                                                                                            fill="white" />
                                                                                                    </svg>
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- product details inner end -->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="tab-pane fade" id="profile" role="tabpanel"
                                                        aria-labelledby="profile-tab">
                                                        <div class="order-list">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="product-img">
                                                                        <img src="{{asset('assets/front/img/product/product-1.png')}}"
                                                                            width="100%" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div class="active-order-list">
                                                                        <h5>Samiya Earrings <span
                                                                                class="delevery-status">Delivered</span>
                                                                        </h5>
                                                                        <p class="order-date mt-10">Ordered on: 12 Dec
                                                                            2021</p>
                                                                        <h4 class="rate-order mt-10">Rs.1,00,000</h4>
                                                                        <p class="delevery-date mt-10">Date : Feb 16,
                                                                            2022 &nbsp; <a href="#"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#track-order"
                                                                                class="track-order">Track Order</a></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="contact" role="tabpanel"
                                                        aria-labelledby="contact-tab">
                                                        <div class="order-list">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="product-img">
                                                                        <img src="{{asset('assets/front/img/product/product-1.png')}}"
                                                                            width="100%" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div class="active-order-list">
                                                                        <h5>Samiya Earrings <span
                                                                                class="delevery-status text-danger">Cancelled</span>
                                                                        </h5>
                                                                        <p class="order-date mt-10">Ordered on: 12 Dec
                                                                            2021</p>
                                                                        <h4 class="rate-order mt-10">Rs.1,00,000</h4>
                                                                        <p class="delevery-date mt-10">Date : Feb 16,
                                                                            2022 &nbsp; <a href="#"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#track-order"
                                                                                class="track-order">View Details</a></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="order-list">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="product-img">
                                                                        <img src="{{asset('assets/front/img/product/product-1.png')}}"
                                                                            width="100%" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div class="active-order-list">
                                                                        <h5>Samiya Earrings <span
                                                                                class="delevery-status text-danger">Cancelled</span>
                                                                        </h5>
                                                                        <p class="order-date mt-10">Ordered on: 12 Dec
                                                                            2021</p>
                                                                        <h4 class="rate-order mt-10">Rs.1,00,000</h4>
                                                                        <p class="delevery-date mt-10">Date : Feb 16,
                                                                            2022 &nbsp; <a href="#"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#track-order"
                                                                                class="track-order">View Details</a></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- add address modal start -->

                                    <!-- add address modal end -->


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