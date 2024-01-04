@if(!empty($cartData))
@php
$totalPrice = 0;
@endphp
@foreach($cartData as $cartVal)
<li>
    <div class="cart-img">
        <a href="product-details.html">
            <img src="{{$cartVal['product_image'] ?? ''}}" alt="">
        </a>
    </div>
    <div class="cart-info">
        <h4><a href="product-details.html">{{$cartVal['product_name'] ?? ''}}</a></h4>
        <span>{{config('Reading.default_currency').number_format($cartVal['product_price'] ?? 0,2)}}</span>
    </div>
</li>
@php
$totalPrice += $cartVal['product_price'] ?? 0;
@endphp
@endforeach

<li class="mini-cart-price" style="border:none;">
    <span class="subtotal">Subtotal : </span>
    <span class="subtotal-price ms-auto">{{config('Reading.default_currency').number_format($totalPrice,2)}}</span>
</li>
<li class="view-cart" style="border:none;margin-bottom:0px;padding:0px;">
    <a href="{{route('front-cart.index')}}" class="sqr-btn d-block w-100">
        View Cart
        <svg width="30" height="8" viewBox="0 0 30 8" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M1 3.5C0.723858 3.5 0.5 3.72386 0.5 4C0.5 4.27614 0.723858 4.5 1 4.5V3.5ZM29.3536 4.35355C29.5488 4.15829 29.5488 3.84171 29.3536 3.64645L26.1716 0.464466C25.9763 0.269204 25.6597 0.269204 25.4645 0.464466C25.2692 0.659728 25.2692 0.976311 25.4645 1.17157L28.2929 4L25.4645 6.82843C25.2692 7.02369 25.2692 7.34027 25.4645 7.53553C25.6597 7.7308 25.9763 7.7308 26.1716 7.53553L29.3536 4.35355ZM1 4.5H29V3.5H1V4.5Z"
                fill="black"></path>
        </svg>
    </a>
</li>
@else
<h6 class="text-center">
    No Data Found
</h6>
@endif