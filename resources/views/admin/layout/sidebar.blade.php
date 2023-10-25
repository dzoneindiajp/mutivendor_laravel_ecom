<!-- Start::main-sidebar-header -->
<div class="main-sidebar-header">
    <a href="index.html" class="header-logo">
        <img src="{{ asset('assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
        <img src="{{ asset('assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
        <img src="{{ asset('assets/images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
        <img src="{{ asset('assets/images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
        <img src="{{ asset('assets/images/brand-logos/desktop-white.png') }}" alt="logo" class="desktop-white">
        <img src="{{ asset('assets/images/brand-logos/toggle-white.png') }}" alt="logo" class="toggle-white">
    </a>
</div>
<!-- End::main-sidebar-header -->

<!-- Start::main-sidebar -->
<div class="main-sidebar" id="sidebar-scroll">

    <!-- Start::nav -->
    <nav class="main-menu-container nav nav-pills flex-column sub-open">
        <div class="slide-left" id="slide-left">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
            </svg>
        </div>
        <ul class="main-menu">
            <li class="slide {{ Route::is('admin-dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin-dashboard') }}" class="side-menu__item {{ Route::is('admin-dashboard') ? 'active' : '' }}">
                    <i class="bx bx-home side-menu__icon"></i>
                    <span class="side-menu__label">Dashboard<span
                            class="badge bg-danger-transparent ms-2"></span></span>
                </a>
            </li>
            <li class="slide has-sub {{ Route::is('admin-product*') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="side-menu__item {{ Route::is('admin-product*') ? 'active' : '' }}">
                    <i class="bx bxl-product-hunt side-menu__icon"></i>
                    <span class="side-menu__label">Products</span>
                    <i class="fe fe-chevron-right side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1">
                    <li class="slide has-sub {{ Route::is('admin-product-categories*') ? 'open' : '' }}">
                        <a href="javascript:void(0);" class="side-menu__item {{ Route::is('admin-product-categories*') ? 'active' : '' }}">Categories
                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                        <ul class="slide-menu child2">
                            <li class="slide">
                                <a href="{{ route('admin-product-categories-category-list') }}" class="side-menu__item {{ Route::is('admin-product-categories-category*') ? 'active' : '' }}">Category</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin-product-categories-sub-category-list') }}" class="side-menu__item {{ Route::is('admin-product-categories-sub-category*') ? 'active' : '' }}">Sub Category</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('admin-product-categories-child-category-list') }}" class="side-menu__item {{ Route::is('admin-product-categories-child-category*') ? 'active' : '' }}">Child Category</a>
                            </li>
                        </ul>
                    </li>
                    <li class="slide">
                        <a href="{{ route('admin-product-options-list') }}" class="side-menu__item {{ Route::is('admin-product-options*') ? 'active' : '' }}">Options</a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('admin-product-options-values-list') }}" class="side-menu__item {{ Route::is('admin-product-options-values*') ? 'active' : '' }}">Options Values</a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('admin-product-list') }}" class="side-menu__item {{ Route::is('admin-product-list') ? 'active' : '' }}">List</a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('admin-product-create') }}" class="side-menu__item {{ Route::is('admin-product-create') ? 'active' : '' }}">Add New Product</a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"
                height="24" viewBox="0 0 24 24">
                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
            </svg></div>
    </nav>
    <!-- End::nav -->

</div>
<!-- End::main-sidebar -->