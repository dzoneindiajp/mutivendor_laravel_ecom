<div class="top-header">
    <div class="container-fluid">
        <div class="top-text">
            <p class="text-white">Tiranga Sale - Flat 45% Off | Avail Extra 5% OFF Only On Prepaid Orders</p>

        </div>
    </div>
</div>
<div class="select-language">
    <select class="form-control">
        <option>INR</option>
        <option>USD</option>
        <option>EUR</option>
    </select>
</div>
<!-- header area start -->
<header>
    <!-- main menu area start -->
    <div class="header-main transparent-menu sticky">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-2 col-md-3 col-6">
                    @php
                    $LOGO_icon = Config('constant.SETTINGS_IMAGE_URL').Config('Site.logo');
                   @endphp
                    <div class="logo">
                        <a href="{{route('front-home.index')}}">
                            <img src="{{$LOGO_icon}}" alt="Brand logo">
                        </a>
                    </div>
                </div>
                @php
                    $categories = \App\Models\Category::where('categories.parent_id', null)->where('categories.is_active', 1)->where('categories.is_deleted', 0)
                                        ->select('categories.id','categories.parent_id','categories.name','categories.slug','categories.description','categories.image','categories.thumbnail_image','categories.video','categories.category_order')->limit(8)->orderBy('category_order', 'ASC')->get()->toArray();
                    if (!empty($categories)) {
                        foreach ($categories as &$category) {
                            $category['sub_categories'] = \App\Models\Category::where('categories.parent_id', $category['id'])->where('categories.is_active', 1)->where('categories.is_deleted', 0)
                                        ->select('categories.id','categories.parent_id','categories.name','categories.slug','categories.description','categories.image','categories.thumbnail_image','categories.video','categories.category_order')->limit(8)->orderBy('category_order', 'ASC')->get()->toArray();

                            if(!empty($category['sub_categories'])) {
                                foreach ($category['sub_categories'] as &$sub_cat) {
                                    $sub_cat['child_categories'] = \App\Models\Category::where('categories.parent_id', $sub_cat['id'])->where('categories.is_active', 1)->where('categories.is_deleted', 0)
                            ->select('categories.id','categories.parent_id','categories.name','categories.slug','categories.description','categories.image','categories.thumbnail_image','categories.video','categories.category_order')->orderBy('category_order', 'ASC')->limit(8)->get()->toArray();
                                }
                            }
                        }
                    }

                    // echo "<pre>"; print_r($categories); die;
                @endphp
                <div class="col-lg-8 d-none d-lg-block">
                    <div class="main-header-inner">
                        <div class="main-menu">
                            <nav id="mobile-menu">
                                <ul>
                                    <li class="active"><a href="{{route('front-home.index')}}">Home</a></li>
                                    {{-- <li><a href="javascript:void(0)">About Us</a></li>
                                    <li><a href="{{route('front-shop.index')}}">Shop</a></li> --}}
                                    @if(!empty($categories))
                                        @foreach ($categories as $item)
                                        @if(!empty($item['sub_categories']))
                                        <li class="static">
                                            <a href="javascript:void(0)"> {{$item['name']}}<i class="fa fa-angle-down"></i></a>
                                            <ul class="megamenu dropdown">
                                                @foreach ($item['sub_categories'] as $subCategory)
                                                @if(!empty($subCategory['child_categories']))
                                                <li class="static">
                                                    <a href="javascript:void(0)">{{$subCategory['name']}} </a>
                                                    <ul class="megamenu dropdown">
                                                        @foreach ($subCategory['child_categories'] as $childCategory)
                                                        <li class="mega-title">
                                                            <a href="{{route('front-shop.index', $childCategory['slug'])}}">
                                                                {{$childCategory['name']}}
                                                            </a>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                @else
                                                <li class="mega-title">
                                                    <a href="{{route('front-shop.index', $subCategory['slug'])}}">
                                                        {{$subCategory['name']}}
                                                    </a>
                                                </li>
                                                @endif

                                                @endforeach
                                            </ul>
                                        </li>
                                        @else
                                        <li><a href="{{route('front-shop.index', $item['slug'])}}">{{$item['name']}}</a></li>
                                        @endif
                                        @endforeach

                                    @endif
                                    {{-- @if(!empty($categories))
                                        <li class="static">
                                            <a href="javascript:void(0)">Categories <i class="fa fa-angle-down"></i></a>
                                            <ul class="megamenu dropdown">
                                                @foreach ($categories as $item)
                                                <li class="mega-title">
                                                    <a href="{{route('front-shop.index', $item['slug'])}}">
                                                        {{$item['name']}}
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </li>

                                    @endif --}}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-6 ms-auto">
                    <div class="header-setting-option">
                        <div class="settings-top">
                            <button type="submit" class="search-trigger">
                                <!--<span class="header-text">Search</span>-->
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                                <p>Search</p>
                            </button>
                        </div>
                        <div class="settings-top">
                            <div class="settings-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                                </svg>
                                <p>Sandeep</p>
                            </div>
                            <ul class="settings-list">
                                <li>
                                    <ul>
                                        <li>
                                            <a href="#">
                                                <h5>Hi Sandeep</h5>
                                            </a>
                                            <span class="email">Sandeep@gmail.com</span>
                                        </li>
                                        <li style="border-top:1px solid #ccc;"><a href="my-profile.html">My Profile</a></li>
                                        <li><a href="login.html">login</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="settings-top">
                            <a href="my-profile.html">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-suit-heart" viewBox="0 0 16 16">
                                    <path d="m8 6.236-.894-1.789c-.222-.443-.607-1.08-1.152-1.595C5.418 2.345 4.776 2 4 2 2.324 2 1 3.326 1 4.92c0 1.211.554 2.066 1.868 3.37.337.334.721.695 1.146 1.093C5.122 10.423 6.5 11.717 8 13.447c1.5-1.73 2.878-3.024 3.986-4.064.425-.398.81-.76 1.146-1.093C14.446 6.986 15 6.131 15 4.92 15 3.326 13.676 2 12 2c-.777 0-1.418.345-1.954.852-.545.515-.93 1.152-1.152 1.595L8 6.236zm.392 8.292a.513.513 0 0 1-.784 0c-1.601-1.902-3.05-3.262-4.243-4.381C1.3 8.208 0 6.989 0 4.92 0 2.755 1.79 1 4 1c1.6 0 2.719 1.05 3.404 2.008.26.365.458.716.596.992a7.55 7.55 0 0 1 .596-.992C9.281 2.049 10.4 1 12 1c2.21 0 4 1.755 4 3.92 0 2.069-1.3 3.288-3.365 5.227-1.193 1.12-2.642 2.48-4.243 4.38z" />
                                </svg>
                                <p>Wishlist</p>
                                <span class="cart-notification">0</span>
                            </a>
                        </div>
                        @php
                            $cartData = getCartData();
                        @endphp
                        <div class="header-mini-cart">
                            <div class="mini-cart-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1258 5.12599H2.87416C2.04526 5.12599 1.38823 5.82536 1.43994 6.65265L1.79919 12.4008C1.84653 13.1581 2.47458 13.7481 3.23342 13.7481H10.7666C11.5254 13.7481 12.1535 13.1581 12.2008 12.4008L12.5601 6.65265C12.6118 5.82536 11.9547 5.12599 11.1258 5.12599ZM2.87416 3.68896C1.21635 3.68896 -0.0977 5.08771 0.00571155 6.74229L0.364968 12.4904C0.459638 14.0051 1.71574 15.1852 3.23342 15.1852H10.7666C12.2843 15.1852 13.5404 14.0051 13.635 12.4904L13.9943 6.74229C14.0977 5.08771 12.7836 3.68896 11.1258 3.68896H2.87416Z"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.40723 4.4075C3.40723 2.42339 5.01567 0.814941 6.99979 0.814941C8.9839 0.814941 10.5923 2.42339 10.5923 4.4075V5.84453C10.5923 6.24135 10.2707 6.56304 9.87384 6.56304C9.47701 6.56304 9.15532 6.24135 9.15532 5.84453V4.4075C9.15532 3.21703 8.19026 2.25197 6.99979 2.25197C5.80932 2.25197 4.84425 3.21703 4.84425 4.4075V5.84453C4.84425 6.24135 4.52256 6.56304 4.12574 6.56304C3.72892 6.56304 3.40723 6.24135 3.40723 5.84453V4.4075Z"></path>
                                </svg>
                                <span class="cart-notification mainCartCounter">{{count($cartData)}}</span>
                                <p>Cart</p>
                            </div>
                            <ul class="cart-list cartDataContainer">
                                @include('front.includes.cart_data')
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-12 d-block d-lg-none">
                    <div class="mobile-menu"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- main menu area end -->
    <!-- Start Search Popup -->
    <div class="box-search-content search_active block-bg close__top">
        <div class="top-header">
            <div class="container-fluid">
                <div class="top-text">
                    <p class="text-white">Tiranga Sale - Flat 45% Off | Avail Extra 5% OFF Only On Prepaid Orders</p>

                </div>
            </div>
        </div>
        <form class="minisearch" action="#">
            <div class="field__search">
                <input type="text" placeholder="Search Our Catalog">
                <div class="action">
                    <a href="#">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.25329 16.7467 2 11.5 2C6.25329 2 2 6.25329 2 11.5C2 16.7467 6.25329 21 11.5 21Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M22 22L20 20" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </form>
        <div class="close__wrap">
            <span>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M6 6L18 18" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
        </div>
    </div>
    <!-- End Search Popup -->
</header>
<!-- header area end -->
@push('scripts')
<script>
    var removeFromCartUrl = "{{route('front-user.removeFromCart')}}";
    var addToCartUrl = "{{route('front-user.addToCart')}}";
</script>
<script src="{{ asset('assets/js/custom/header.js') }}"></script>
@endpush