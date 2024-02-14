@if($results->isNotEmpty())
@forelse($results as $result)
<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6 col-6 list-data-row"  data-total-count="{{$totalResults}}">
    <div class="product-item mb-20">
        <div class="product-description">
            <div class="manufacturer">
                <p>
                    <a href="{{route('front-shop.productDetail',$result->slug)}}">{{$result->category_name ?? ''}}</a>
                    <span style="float:right;">
                        <a class="wishlist-list wish wishlistIconAction {{!empty($result->isProductAddedIntoWishlist) ? 'added' : ''}}" data-id = "{{$result->id}}" href="javascript:void(0)" title="" tabindex="0"><svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="{{!empty($result->isProductAddedIntoWishlist) ? 'red' : 'none'}}" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-heart">
                            <path
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                            </path>
                            <use xlink:href="#wish"></use>
                        </svg></a>
                    </span>
                </p>
            </div>
            <div class="product-name">
                <h3><a href="{{route('front-shop.productDetail',$result->slug)}}">{{$result->name ?? ''}} {{$result->variant_value1_name ?? ''}} {{$result->variant_value2_name ?? ''}}</a></h3>
            </div>
        </div>
        <div class="product-thumb">
            <a href="{{route('front-shop.productDetail',$result->slug)}}">
                @if(!empty($result->productImages))
                @foreach($result->productImages as $productImageKey => $productImage)
                <img src="{{$productImage}}" class="{{($productImageKey == 0 ? 'simple-product' : 'hover-product')}}"
                    alt="product image">
                @endforeach
                @else
                <img src="{{Config('constant.IMAGE_URL') . 'noimage.png'}}" class="simple-product" alt="product image">
                @endif

            </a>
            <!-- <div class="box-label">
                <div class="product-label new">
                    <span>SPECIAL OFFER</span>
                </div> -->
            <!-- </div> -->
        </div>
        <div class="product-description">
            <div class="price-box mt-10">
                <span
                    class="regular-price">{{getDropPrices($result->id,['category_id' => $result->category_id, 'sub_category_id' => $result->sub_category_id, 'child_category_id' => $result->child_category_id,'selling_price' => $result->selling_price,'product_id' => $result->product_id],'selling')}}</span>
                <span
                    class="old-price"><del>{{getDropPrices($result->id,['category_id' => $result->category_id, 'sub_category_id' => $result->sub_category_id, 'child_category_id' => $result->child_category_id,'buying_price' => $result->buying_price,'product_id' => $result->product_id],'buying')}}</del></span>
                <span style="float:right;">
                    <a href="javascript:void(0)" class="d-block text-center cartIconAction {{!empty($result->isProductAddedIntoCart) ? 'added' : ''}}"  data-id = "{{$result->id}}">
                        <svg class="product-list-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                            viewBox="0 0 14 16">
                            <path fill-rule="evenodd" clip-rule="evenodd" fill="{{!empty($result->isProductAddedIntoCart) ? '#FF0000' : ''}}"
                                d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z">
                            </path>
                            <path fill-rule="evenodd" clip-rule="evenodd"  fill="{{!empty($result->isProductAddedIntoCart) ? '#FF0000' : ''}}"
                                d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z">
                            </path>
                        </svg>
                    </a>
                </span>
            </div>
        </div>
    </div>
</div>

@empty
@endforelse
@else
<div class="noresults-row text-center">
    <h6>No Products found.</h6>
</div>
@endif

