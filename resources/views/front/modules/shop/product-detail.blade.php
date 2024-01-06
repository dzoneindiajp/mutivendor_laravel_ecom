@extends('front.layouts.app')
@section('content')   
<div class="breadcrumb-area pb-60 pt-60" style="background-image: url({{ asset('assets/front/img/slider/bg-about.png')}}); background-size: 100%; background-repeat: no-repeat; ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <h2 class="text-white">Product Details</h2>
                        <p class="text-white">Home / Product Details</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- page main wrapper start -->
    <main class="main-bg">
        <div class="product-details-wrapper pt-50 pb-14 pt-sm-58">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- product details inner end -->
                        <div class="product-details-inner">
                            <div class="row">   
                                @if(!empty($productDetails->productImages))
                                <div class="col-lg-1">
                                    
                                    <div class="pro-nav slick-padding2 slider-arrow-style slider-arrow-style__style-2">
                                        @foreach($productDetails->productImages as $productImageVal)
                                        <div class="pro-nav-thumb"><img src="{{$productImageVal['image'] ?? '' }}" alt="" /></div>
                                        @endforeach
                                       
                                    </div>
                                    
                                    
                                </div>
                                <div class="col-lg-5">
                                    <div class="product-img-space">
                                        <div class="product-large-slider mb-20 slider-arrow-style slider-arrow-style__style-2">
                                            @foreach($productDetails->productImages as $productImageVal)
                                            <div class="pro-large-img img-zoom" id="img1">
                                                <img src="{{$productImageVal['image'] ?? '' }}" alt="" />
                                            </div>
                                           
                                            @endforeach
                                            
                                          
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-lg-6">
                                    <div class="product-details-des pt-md-98 pt-sm-58">
                                        <p class="pb-10">
                                        {{$productDetails->product_number ?? ''}}
                                            <span style="float:right;">
                                                <a href="#">
                                                    <svg class="heart-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                                                    </svg>
                                                </a>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="#">
                                                    <svg class="shares-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                                                        <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z" />
                                                    </svg>
                                                </a>
                                            </span>
                                        </p>
                                        <h3 class="">{{$productDetails->name ?? ''}}</h3>
                                        <p class="pt-2 pb-0">
                                            <i class="fa fa-star fill"></i>
                                            <i class="fa fa-star fill"></i>
                                            <i class="fa fa-star fill"></i>
                                            <i class="fa fa-star fill"></i>
                                            <i class="fa fa-star-o"></i>
                                            Write a review
                                        </p>
                                        @if($productDetails->productDescriptions->isNotEmpty())
                                        @foreach($productDetails->productDescriptions as $productDescription)
                                        @if(strtolower($productDescription->name) == 'short description')
                                        <p class="pt-0 pb-0">{!!$productDescription->value ?? ''!!}</p>
                                        @endif
                                        @endforeach
                                        @endif
                                        


                                        <div class="pricebox">
                                            Offer Price &nbsp;&nbsp;<span class="regular-price"> {{config('Reading.default_currency').number_format($productDetails->selling_price,2)}} </span>&nbsp;&nbsp; <del>{{config('Reading.default_currency').number_format($productDetails->buying_price,2)}}</del>
                                            <div class="toggle-button-cover">
                                                <div class="button-cover">
                                                    <div class="button b2" id="button-10">
                                                        <input type="checkbox" class="checkbox" />
                                                        <div class="knobs">
                                                            <span>{{config('Reading.default_currency')}}</span>
                                                        </div>
                                                        <div class="layer"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="ribbon-bookmark-h mt-10">
                                            <img src="{{ asset('assets/front/img/ribbon.png')}}" width="200" />
                                            <p class="flat-off">Flat 15% OFF</p>
                                        </div> -->
                                        <p class="pt-2 pb-2 mt-0">{{($productDetails->is_including_taxes == 1) ? 'Price Inclusive of all taxes.' : 'Price is not inclusive of all taxes.' }}</p>


                                        <div class="quantity-cart-box d-flex align-items-center mb-10">
                                            @if($productDetails->productVariants->isNotEmpty())
                                            @foreach($productDetails->productVariants as $productVariant)
                                            <select class="size-input">
                                                <option>{{$productVariant->name ?? ''}}</option>
                                                @if($productVariant->variantValuesData->isNotEmpty())
                                                @foreach($productVariant->variantValuesData as $variantValue)
                                                <option {{in_array($variantValue->veriant_value_id,[$productDetails->variant1_value_id,$productDetails->variant2_value_id]) ? 'selected' : ''}}>{{$variantValue->name ?? ''}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @endforeach
                                            @endif
                                            
                                            <select class="size-input">
                                                <option>Qty</option>
                                                <option>1</option>
                                            </select>
                                        </div>
                                        <div class="availability mt-0 mb-10 ">
                                            <h5>Availability:</h5>
                                            <span class="{{($productDetails->in_stock == 1) ? 'inStock' : 'outOfStock'}}">{{($productDetails->in_stock == 1) ? 'in stock' : 'out of stock'}}</span>
                                        </div>
                                        @if($productDetails->in_stock == 1)
                                        <div class="product-btn details-section">
                                            <a href="#" tabindex="0" class="add-to-cart" style="margin-right:30px;" {{(!empty($productDetails->isProductAddedIntoCart)) ? 'disabled' : ''}}>
                                            {{(!empty($productDetails->isProductAddedIntoCart)) ? 'Added to cart' : 'Add to Cart'}}
                                            </a>
                                            <a href="#" class="buy-now" tabindex="0">
                                                Buy Now
                                            </a>
                                        </div>
                                        @endif
                                        <hr />
                                        <div class="row mt-20">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="country">Country</label>
                                                    <select class="form-control pincode">
                                                        <option selected>India</option>
                                                        <option>US</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="country">Pincode</label>
                                                    <input type="text" class="pincode" />
                                                    <button type="button" class="check-pincode">Check</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- product details inner end -->

                        <div class="product-details-reviews pt-98 pt-sm-58">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="product-review-info">
                                        <ul class="nav review-tab" role="tablist">
                                        @if($productDetails->productDescriptions->isNotEmpty())
                                        @foreach($productDetails->productDescriptions as $productDescriptionKey =>  $productDescription)
                                        @if(strtolower($productDescription->name) != 'short description')
                                        
                                        <li>
                                            <a class="{{($productDescriptionKey == 0) ? 'active' : ''}}" data-bs-toggle="tab" href="#tab_{{str_replace(' ','_',$productDescription->name)}}" aria-selected="true" role="tab">{{ucfirst($productDescription->name) ?? ''}}</a>
                                        </li>
                                        @endif
                                        @endforeach
                                        @endif
                                           
                                            <li>
                                                <a class="{{($productDetails->productDescriptions->isEmpty()) ? 'active' : ''}}" data-bs-toggle="tab" href="#tab_two" aria-selected="false" role="tab" class="" tabindex="-1">information</a>
                                            </li>
                                            <li>
                                                <a data-bs-toggle="tab" href="#tab_three" aria-selected="false" role="tab" class="" tabindex="-1">reviews</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content reviews-tab">
                                            @if($productDetails->productDescriptions->isNotEmpty())
                                            @foreach($productDetails->productDescriptions as $productDescriptionKey => $productDescription)
                                            @if(strtolower($productDescription->name) != 'short description')
                                           
                                            <div class="tab-pane fade {{($productDescriptionKey == 0) ? 'active show' : ''}}" id="tab_{{str_replace(' ','_',$productDescription->name)}}" role="tabpanel">
                                                <div class="tab-one">
                                                   {!!$productDescription->value ?? ''!!}
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                            @endif
                                            
                                            <div class="tab-pane fade {{($productDetails->productDescriptions->isEmpty()) ? 'active show' : ''}}" id="tab_two" role="tabpanel">
                                                <div class="product-detail-table">
                                                    <table class="table">
                                                        @if($productDetails->productSpecifications->isNotEmpty()) 
                                                        @foreach($productDetails->productSpecifications as $productSpecification)
                                                        <tr>
                                                            <td>{{$productSpecification->name ?? ''}}:</td>
                                                            <td>{{$productSpecification->specification_values_names ?? ''}}</td>
                                                        </tr>
                                                        @endforeach
                                                        @else
                                                        <h6 class="text-center">
                                                            No Information Available 
                                                        </h6>
                                                        @endif
                                                        
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab_three" role="tabpanel">
                                                <h6 class="text-center">
                                                            No Reviews Available 
                                                        </h6>
                                                <!-- <form action="#" class="review-form">
                                                    <h5>1 review for <span>Chaz Kangeroo Hoodies</span></h5>
                                                    <div class="total-reviews">
                                                        <div class="rev-avatar">
                                                            <img src="{{ asset('assets/front/img/about/avatar.jpg')}}" alt="">
                                                        </div>
                                                        <div class="review-box">
                                                            <div class="ratings">
                                                                <span class="good"><i class="fa fa-star"></i></span>
                                                                <span class="good"><i class="fa fa-star"></i></span>
                                                                <span class="good"><i class="fa fa-star"></i></span>
                                                                <span class="good"><i class="fa fa-star"></i></span>
                                                                <span><i class="fa fa-star"></i></span>
                                                            </div>
                                                            <div class="post-author">
                                                                <p><span>admin -</span> 30 Nov, 2018</p>
                                                            </div>
                                                            <p>Aliquam fringilla euismod risus ac bibendum. Sed sit amet sem varius ante feugiat lacinia. Nunc ipsum nulla, vulputate ut venenatis vitae, malesuada ut mi. Quisque iaculis, dui congue placerat pretium, augue erat accumsan lacus</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col">
                                                            <label class="col-form-label"><span class="text-danger">*</span> Your Name</label>
                                                            <input type="text" class="form-control" required="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col">
                                                            <label class="col-form-label"><span class="text-danger">*</span> Your Email</label>
                                                            <input type="email" class="form-control" required="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col">
                                                            <label class="col-form-label"><span class="text-danger">*</span> Your Review</label>
                                                            <textarea class="form-control" required=""></textarea>
                                                            <div class="help-block pt-10"><span class="text-danger">Note:</span> HTML is not translated!</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col">
                                                            <label class="col-form-label"><span class="text-danger">*</span> Rating</label>
                                                            &nbsp;&nbsp;&nbsp; Bad&nbsp;
                                                            <input type="radio" value="1" name="rating">
                                                            &nbsp;
                                                            <input type="radio" value="2" name="rating">
                                                            &nbsp;
                                                            <input type="radio" value="3" name="rating">
                                                            &nbsp;
                                                            <input type="radio" value="4" name="rating">
                                                            &nbsp;
                                                            <input type="radio" value="5" name="rating" checked="">
                                                            &nbsp;Good
                                                        </div>
                                                    </div>
                                                    <div class="buttons">
                                                        <button class="sqr-btn" type="submit">Continue</button>
                                                    </div>
                                                </form> end of review-form -->
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
    </main>
    <!-- page main wrapper end -->
    @endsection