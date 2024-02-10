@extends('front.layouts.app')
@section('content')
<!-- header area end -->
<div class="breadcrumb-area pb-60 pt-60"
    style="background-image: url({{asset('assets/front/img/slider/bg-about.png')}}); background-size: 100%; background-repeat: no-repeat; ">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-wrap">
                    <h2 class="text-white">Checkout</h2>
                    <p class="text-white">Home / Checkout</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- page main wrapper start -->
<!-- page main wrapper start -->
<form id="checkoutForm" action="{{route('front-user.processPayment')}}" method="post">
    <main class="main-bg">
        <!-- cart main wrapper start -->
        <div class="cart-main-wrapper pt-50 pb-50 pt-sm-58 pb-sm-58">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="checkout-details">
                            <div class="accordion" id="general-question">
                                <div class="card mb-3">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <button class="accordio-heading" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                Address Details
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                        data-bs-parent="#general-question" style="">
                                        <div class="card-body">
                                            @if($userAddresses->isNotEmpty())
                                            @foreach($userAddresses as $address)
                                            <div class="address-list">
                                                <table width="100%">
                                                    <tr>
                                                        <td>
                                                            <p><b>{{$address->name ?? ''}}</b></p>
                                                            <p><b>{{$address->email ?? ''}}</b></p>
                                                            <p><b>{{$address->phone_number ?? ''}}</b></p>
                                                            <p>{{$address->address_line_1 ?? ''}},
                                                                {{$address->address_line_2 ?? ''}}<br />
                                                                {{$address->landmark ?? ''}}, {{$address->city ?? ''}},
                                                                {{$address->state ?? ''}},{{$address->country ?? ''}}
                                                                {{$address->postal_code ?? ''}}
                                                                <a href="{{(!empty($checkoutData['address_id']) && $checkoutData['address_id'] == $address->id ) ? 'javascript:void(0)' : route('front-user.checkout')."?action=addressSelect&address_id=".$address->id}}"><span class="primary-button">{{(!empty($checkoutData['address_id']) && $checkoutData['address_id'] == $address->id ) ? 'Selected' : 'Select this address'}}</span></a>
                                                            </p>
                                                        </td>

                                                    </tr>
                                                </table>
                                            </div>

                                            @endforeach
                                            @else
                                            <div class="address-list">
                                                <table width="100%">
                                                    <tr>
                                                        <h6 class="text-center">No Addresses Found</h6>
                                                    </tr>
                                                </table>
                                            </div>
                                            @endif
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#add-address"
                                                class="add-address">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10 4.1665V15.8332" stroke="#283EFF" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M4.16699 10H15.8337" stroke="#283EFF" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                Add address
                                            </a>

                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-header" id="headingTwo">
                                        <h5 class="mb-0">
                                            <button class="accordio-heading collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                aria-controls="collapseTwo" aria-expanded="false">
                                                Payment
                                            </button>
                                        </h5>
                                    </div>

                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                        data-bs-parent="#general-question">
                                        <div class="card-body">
                                            <div class="address-details mt-20">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="order-payment-method">
                                                            <div class="single-payment-method show">
                                                                <div class="payment-method-name">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="cashon"
                                                                            name="paymentmethod" value="cod"
                                                                            class="custom-control-input" checked="">
                                                                        <label class="custom-control-label"
                                                                            for="cashon">Cash On Delivery</label>
                                                                    </div>
                                                                </div>
                                                                <div class="payment-method-details" data-method="cash"
                                                                    style="display: block;">
                                                                    <p>Pay with cash upon delivery.</p>
                                                                </div>
                                                            </div>
                                                            @if($paymentMethods->isNotEmpty())
                                                            @foreach($paymentMethods as $paymentMethod)
                                                            <div class="single-payment-method">
                                                                <div class="payment-method-name">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio"
                                                                            id="paymentmethod{{$paymentMethod->id}}"
                                                                            name="paymentmethod"
                                                                            class="custom-control-input"
                                                                            value="{{strtolower($paymentMethod->name) ?? ''}}">
                                                                        <label class="custom-control-label"
                                                                            for="paymentmethod{{$paymentMethod->id}}">{{$paymentMethod->name ?? ''}}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="payment-method-details" data-method="bank" style="display: none;">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control login" id="full-name" placeholder="Pay with {{$paymentMethod->name ?? ''}}" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                            @endif

                                                            <!-- <div class="single-payment-method">
                                                                <div class="payment-method-name">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="checkpayment" name="paymentmethod" value="check" class="custom-control-input">
                                                                        <label class="custom-control-label" for="checkpayment">Credit card</label>
                                                                    </div>
                                                                </div>
                                                                <div class="payment-method-details" data-method="check" style="display: none;">
                                                                    <p>you can pay with your credit card</p>
                                                                </div>
                                                            </div> -->
                                                            <!-- <div class="single-payment-method">
                                                                <div class="payment-method-name">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="paypalpayment" name="paymentmethod" value="paypal" class="custom-control-input">
                                                                        <label class="custom-control-label" for="paypalpayment">Debit card</label>
                                                                    </div>
                                                                </div>
                                                                <div class="payment-method-details" data-method="paypal" style="display: none;">
                                                                    <p>you can pay with your debit card</p>
                                                                </div>
                                                            </div> -->

                                                        </div>
                                                    </div>

                                                    <div class="col-md-6"></div>
                                                    <!-- <div class="col-md-12">
                                                        <div class="product-btn" style="text-align:right;">
                                                            <a href="#" data-bs-toggle="collapse"
                                                                data-bs-target="#collapseTwo"
                                                                aria-controls="collapseTwo" aria-expanded="false"
                                                                class="sqr-btn mt-3">
                                                                Continue
                                                                <svg class="right-arrow" width="30" height="9"
                                                                    viewBox="0 0 30 9"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M1 4C0.723858 4 0.5 4.22386 0.5 4.5C0.5 4.77614 0.723858 5 1 5V4ZM29.3536 4.85355C29.5488 4.65829 29.5488 4.34171 29.3536 4.14645L26.1716 0.964466C25.9763 0.769204 25.6597 0.769204 25.4645 0.964466C25.2692 1.15973 25.2692 1.47631 25.4645 1.67157L28.2929 4.5L25.4645 7.32843C25.2692 7.52369 25.2692 7.84027 25.4645 8.03553C25.6597 8.2308 25.9763 8.2308 26.1716 8.03553L29.3536 4.85355ZM1 5H29V4H1V5Z">
                                                                    </path>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header" id="headingThree">
                                        <h5 class="mb-0">
                                            <button class="accordio-heading collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                aria-controls="collapseThree" aria-expanded="false">
                                                Review the details
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                        data-bs-parent="#general-question">
                                        <div class="card-body">
                                            @php $allTaxesData = []; @endphp
                                            @if(!empty($checkoutItemData))
                                            @foreach($checkoutItemData as $checkout)
                                            <div class="cart-lists mb-10">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="pro-thumbnail">
                                                            <a href="#">
                                                                <img class="img-fluid"
                                                                    src="{{!empty($checkout['product']['product_image']) ? $checkout['product']['product_image'] : ''}}"
                                                                    alt="Product" />
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="product-details-des cart">
                                                            <h3 class="mt-10 mb-0">
                                                                {{!empty($checkout['product']['product_name']) ? $checkout['product']['product_name'] : ''}}
                                                                {{!empty($checkout['product']['variant_value1_name']) ? $checkout['product']['variant_value1_name'] : ''}}
                                                                {{!empty($checkout['product']['variant_value2_name']) ? $checkout['product']['variant_value2_name'] : ''}}
                                                            </h3>
                                                            <!-- <h6>
                                                            <span class="category-show">Weight : 10.574g | Size :
                                                                38.48cm</span>

                                                        </h6> -->
                                                            <h6 class="mt-0 pt-0 pb-0">
                                                                <span class="category-show">Qty :
                                                                    {{!empty($checkout['quantity']) ? $checkout['quantity'] : ''}}</span>

                                                            </h6>
                                                            <!--<div class="quantity-cart-box">
                                                                <select class="size-input">
                                                                    <option>Qty</option>
                                                                    <option>1</option>
                                                                </select>
                                                            </div>-->
                                                            <div class="pricebox mt-10">
                                                                <span class="regular-price">
                                                                    {{getDefaultCurrencySymbol()}}{{!empty($checkout['sub_total']) ? $checkout['sub_total'] : 0.00}}
                                                                </span>&nbsp;&nbsp;
                                                            </div>

                                                            <div class="delete-cart-list mt-10">
                                                                <a href="{{route('front-user.removeFromCart').'?product_id='.$checkout['product_id']}}"
                                                                    class="cart-text">
                                                                    <span style="">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="16" height="16" fill="currentColor"
                                                                            class="bi bi-trash" viewBox="0 0 16 16">
                                                                            <path
                                                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                                                            <path
                                                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                                                        </svg>
                                                                        Remove
                                                                    </span>
                                                                </a>
                                                                &nbsp;&nbsp;|&nbsp;&nbsp;
                                                                <a href="{{route('front-user.addToWishlist')."?action=move&product_id=".$checkout['product_id']}}"
                                                                    class="cart-text">
                                                                    <span style="">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="16" height="16" fill="currentColor"
                                                                            class="bi bi-suit-heart"
                                                                            viewBox="0 0 16 16">
                                                                            <path
                                                                                d="m8 6.236-.894-1.789c-.222-.443-.607-1.08-1.152-1.595C5.418 2.345 4.776 2 4 2 2.324 2 1 3.326 1 4.92c0 1.211.554 2.066 1.868 3.37.337.334.721.695 1.146 1.093C5.122 10.423 6.5 11.717 8 13.447c1.5-1.73 2.878-3.024 3.986-4.064.425-.398.81-.76 1.146-1.093C14.446 6.986 15 6.131 15 4.92 15 3.326 13.676 2 12 2c-.777 0-1.418.345-1.954.852-.545.515-.93 1.152-1.152 1.595L8 6.236zm.392 8.292a.513.513 0 0 1-.784 0c-1.601-1.902-3.05-3.262-4.243-4.381C1.3 8.208 0 6.989 0 4.92 0 2.755 1.79 1 4 1c1.6 0 2.719 1.05 3.404 2.008.26.365.458.716.596.992a7.55 7.55 0 0 1 .596-.992C9.281 2.049 10.4 1 12 1c2.21 0 4 1.755 4 3.92 0 2.069-1.3 3.288-3.365 5.227-1.193 1.12-2.642 2.48-4.243 4.38z" />
                                                                        </svg>
                                                                        Move to Wishlist
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(!empty($checkout['tax']))
                                            @php $allTaxesData[] = $checkout['tax']; @endphp
                                            @endif
                                            @endforeach
                                            @else
                                            <h5 class="text-center">No Data Found</h5>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="cart-amount">
                            <div class="cart-calculator-wrapper">
                                <div class="cart-calculate-items">
                                    <h3 class="mb-20">Order Summary</h3>
                                    <hr />
                                    <div class="table-responsive">
                                        <table width="100%">
                                            <tr>
                                                <td>Sub-Total</td>
                                                <td style="text-align:right;font-weight:500;">
                                                    {{getDefaultCurrencySymbol()}}{{number_format($checkoutData['sub_total'],2)}}
                                                </td>
                                            </tr>
                                            @if(!empty($checkoutData['delivery']))
                                            <tr>
                                                <td>Delivery Charge</td>
                                                <td style="text-align: right; font-weight: 500;">
                                                    {{getDefaultCurrencySymbol()}}{{number_format($checkoutData['delivery'],2)}}
                                                </td>
                                            </tr>
                                            @endif

                                            @if(!empty($checkoutData['tax']))
                                            @foreach($checkoutData['tax'] as $tax)
                                            <tr>
                                                <td>{{ $tax['tax_name'] ?? '' }}</td>
                                                <td style="text-align: right; font-weight: 500;">
                                                    {{getDefaultCurrencySymbol()}}{{number_format($tax['tax_price'],2) ?? 0 }}
                                                </td>
                                            </tr>

                                            @endforeach
                                            @endif

                                            <tr class="total">
                                                <td style="font-weight:500;">TOTAL (incl of all Taxes.)</td>
                                                <td style="text-align: right; font-weight: 500;">
                                                    {{getDefaultCurrencySymbol()}}{{number_format($checkoutData['total'],2)}}
                                                </td>
                                            </tr>
                                            @if(!empty($checkoutData['coupon_discount']))
                                            <tr class="total">
                                                <td style="color: #4eb250;">YOU SAVE</td>
                                                <td style="text-align: right; font-weight: 500; color: #4eb250; "
                                                    class="total-amount">
                                                    +{{getDefaultCurrencySymbol()}}{{number_format($checkoutData['coupon_discount'],2)}}
                                                </td>
                                            </tr>
                                            @endif
                                            <tr class="total">
                                                <td style="font-weight:500;">AMOUNT PAYABLE (incl of all Taxes.)</td>
                                                <td style="text-align: right; font-weight: 500;">
                                                    {{getDefaultCurrencySymbol()}}{{number_format($checkoutData['total'],2)}}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <!-- <div class="summary-footer-area mt-5">
                            <div class="custom-control custom-checkbox mb-14">
                                <input type="checkbox" class="custom-control-input" id="terms" required="">
                                <label class="custom-control-label" for="terms">I have read and agree to <a
                                        href="index.html">terms and conditions.</a></label>
                            </div>
                        </div> -->
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
                <div class="col-md-10">
                    <h5>Total ({{count($checkoutItemData) ?? 0}} item) &nbsp;&nbsp;:&nbsp;&nbsp;
                        {{getDefaultCurrencySymbol()}}{{number_format($checkoutData['total'],2)}}</h5>
                </div>
                <div class="col-md-2">
                    <button type=submit class="sqr-btn buy-now d-block">
                        Place the order
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- add address modal start -->
<div class="modal" id="add-address">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" class="addAddressForm" method="POST" enctype="multipart/form-data">
                    <!-- product details inner end -->
                    <div class="edit-account">
                        <div class="row mt-30">
                            <div class="col-lg-12 col-md-6">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" name="name" class="form-control login"
                                        value="{{$address->name ?? ''}}" />
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control login"
                                        value="{{$address->email ?? ''}}" />
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" name="phone_number" class="form-control login"
                                        value="{{$address->phone_number ?? ''}}" />
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="form-group">
                                    <label>Address line 1</label>
                                    <input type="text" name="address_line_1" class="form-control login" />
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="form-group">
                                    <label>Address line 2</label>
                                    <input type="text" name="address_line_2" class="form-control login" />
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>Postal code</label>
                                    <input type="text" name="postal_code" class="form-control login" />
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>Landmark</label>
                                    <input type="text" name="landmark" class="form-control login" />
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" name="city" class="form-control login" />
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" name="state" class="form-control login" />
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="sqr-btn mt-3 d-block saveBtn">
                                        Save
                                        <svg width="30" height="8" viewBox="0 0 30 8" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M1 3.5C0.723858 3.5 0.5 3.72386 0.5 4C0.5 4.27614 0.723858 4.5 1 4.5V3.5ZM29.3536 4.35355C29.5488 4.15829 29.5488 3.84171 29.3536 3.64645L26.1716 0.464466C25.9763 0.269204 25.6597 0.269204 25.4645 0.464466C25.2692 0.659728 25.2692 0.976311 25.4645 1.17157L28.2929 4L25.4645 6.82843C25.2692 7.02369 25.2692 7.34027 25.4645 7.53553C25.6597 7.7308 25.9763 7.7308 26.1716 7.53553L29.3536 4.35355ZM1 4.5H29V3.5H1V4.5Z"
                                                fill="black" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- product details inner end -->
            </div>
        </div>
    </div>
</div>
<!-- add address modal end -->

<script>
$(document).on('submit', '.addAddressForm', function(e) {
    e.preventDefault();
    $btnName = $(this).find('button[type=submit]').html();
    $(this).find('button[type=submit]').prop('disabled', true);
    $(this).find('button[type=submit]').html(
        '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> ' +
        $btnName);
    const that = this;
    var formData = new FormData($('.addAddressForm')[0]);
    const attributes = {
        hasButton: true,
        btnSelector: '.saveBtn',
        btnText: $btnName,
        handleSuccess: function() {
            localStorage.setItem('flashMessage', datas['msg']);
            window.location.href = "{{route('front-user.checkout')}}";
        }
    };
    const ajaxOptions = {
        url: "{{route('front-user.addAddress')}}",
        method: 'post',
        data: formData
    };

    makeAjaxRequest(ajaxOptions, attributes);
});
</script>
@endsection