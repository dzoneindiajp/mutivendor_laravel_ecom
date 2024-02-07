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
                                    <a href="{{route('front-user.dashboard')}}" class="active"><i
                                            class="fa fa-dashboard"></i>Dashboard</a>
                                    <a href="{{route('front-user.orders')}}"><i class="fa fa-shopping-bag"></i>
                                        Orders</a>
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
                                    <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                        <div class="myaccount-content">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="prof">
                                                        <img src="{{!empty($user->image) ? $user->image :  asset('assets/front/img/team/user.png')}}"
                                                            class="profile-img" />
                                                        <div class="profile-details">
                                                            <h4>
                                                                {{auth()->guard('customer')->user()->name ?? ''}}
                                                                <span style="float:right;">
                                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                        data-bs-target="#edit-profile"
                                                                        class="edit-profile">
                                                                        <svg class="edit-profiless" width="20"
                                                                            height="20" viewBox="0 0 20 20" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M11.0504 3.00002L4.20878 10.2417C3.95045 10.5167 3.70045 11.0584 3.65045 11.4334L3.34211 14.1334C3.23378 15.1084 3.93378 15.775 4.90045 15.6084L7.58378 15.15C7.95878 15.0834 8.48378 14.8084 8.74211 14.525L15.5838 7.28335C16.7671 6.03335 17.3004 4.60835 15.4588 2.86668C13.6254 1.14168 12.2338 1.75002 11.0504 3.00002Z"
                                                                                stroke="#173334" stroke-width="1.5"
                                                                                stroke-miterlimit="10"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" />
                                                                            <path
                                                                                d="M9.9082 4.2085C10.2665 6.5085 12.1332 8.26683 14.4499 8.50016"
                                                                                stroke="#173334" stroke-width="1.5"
                                                                                stroke-miterlimit="10"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" />
                                                                            <path d="M2.5 18.3335H17.5" stroke="#173334"
                                                                                stroke-width="1.5"
                                                                                stroke-miterlimit="10"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" />
                                                                        </svg> Edit
                                                                    </a>
                                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                        data-bs-target="#change-password"
                                                                        class="edit-profile" class="edit-profile">
                                                                        <svg class="edit-profiless" width="20"
                                                                            height="20" viewBox="0 0 20 20" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M15 8.95817C14.6583 8.95817 14.375 8.67484 14.375 8.33317V6.6665C14.375 4.0415 13.6333 2.2915 10 2.2915C6.36667 2.2915 5.625 4.0415 5.625 6.6665V8.33317C5.625 8.67484 5.34167 8.95817 5 8.95817C4.65833 8.95817 4.375 8.67484 4.375 8.33317V6.6665C4.375 4.24984 4.95833 1.0415 10 1.0415C15.0417 1.0415 15.625 4.24984 15.625 6.6665V8.33317C15.625 8.67484 15.3417 8.95817 15 8.95817Z"
                                                                                fill="#173334" />
                                                                            <path
                                                                                d="M10.0003 16.0417C8.50866 16.0417 7.29199 14.825 7.29199 13.3333C7.29199 11.8417 8.50866 10.625 10.0003 10.625C11.492 10.625 12.7087 11.8417 12.7087 13.3333C12.7087 14.825 11.492 16.0417 10.0003 16.0417ZM10.0003 11.875C9.20033 11.875 8.54199 12.5333 8.54199 13.3333C8.54199 14.1333 9.20033 14.7917 10.0003 14.7917C10.8003 14.7917 11.4587 14.1333 11.4587 13.3333C11.4587 12.5333 10.8003 11.875 10.0003 11.875Z"
                                                                                fill="#173334" />
                                                                            <path
                                                                                d="M14.167 18.9585H5.83366C2.15866 18.9585 1.04199 17.8418 1.04199 14.1668V12.5002C1.04199 8.82516 2.15866 7.7085 5.83366 7.7085H14.167C17.842 7.7085 18.9587 8.82516 18.9587 12.5002V14.1668C18.9587 17.8418 17.842 18.9585 14.167 18.9585ZM5.83366 8.9585C2.85033 8.9585 2.29199 9.52516 2.29199 12.5002V14.1668C2.29199 17.1418 2.85033 17.7085 5.83366 17.7085H14.167C17.1503 17.7085 17.7087 17.1418 17.7087 14.1668V12.5002C17.7087 9.52516 17.1503 8.9585 14.167 8.9585H5.83366Z"
                                                                                fill="#173334" />
                                                                        </svg>
                                                                        Change password
                                                                    </a>
                                                                </span>
                                                            </h4>
                                                            <p>
                                                                <svg width="20" height="20" viewBox="0 0 20 20"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M14.167 17.7082H5.83366C2.79199 17.7082 1.04199 15.9582 1.04199 12.9165V7.08317C1.04199 4.0415 2.79199 2.2915 5.83366 2.2915H14.167C17.2087 2.2915 18.9587 4.0415 18.9587 7.08317V12.9165C18.9587 15.9582 17.2087 17.7082 14.167 17.7082ZM5.83366 3.5415C3.45033 3.5415 2.29199 4.69984 2.29199 7.08317V12.9165C2.29199 15.2998 3.45033 16.4582 5.83366 16.4582H14.167C16.5503 16.4582 17.7087 15.2998 17.7087 12.9165V7.08317C17.7087 4.69984 16.5503 3.5415 14.167 3.5415H5.83366Z"
                                                                        fill="#173334" />
                                                                    <path
                                                                        d="M9.99998 10.725C9.29998 10.725 8.59165 10.5083 8.04998 10.0666L5.44164 7.98331C5.17498 7.76664 5.12498 7.37497 5.34165 7.10831C5.55831 6.84164 5.94998 6.79164 6.21665 7.00831L8.82497 9.09164C9.45831 9.59998 10.5333 9.59998 11.1666 9.09164L13.775 7.00831C14.0416 6.79164 14.4416 6.83331 14.65 7.10831C14.8666 7.37497 14.825 7.77498 14.55 7.98331L11.9416 10.0666C11.4083 10.5083 10.7 10.725 9.99998 10.725Z"
                                                                        fill="#173334" />
                                                                </svg>
                                                                {{auth()->guard('customer')->user()->email ?? ''}}
                                                            </p>
                                                            <p>
                                                                <svg width="20" height="20" viewBox="0 0 20 20"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M14.542 18.9582C13.6003 18.9582 12.6087 18.7332 11.5837 18.2998C10.5837 17.8748 9.57533 17.2915 8.59199 16.5832C7.61699 15.8665 6.67533 15.0665 5.78366 14.1915C4.90033 13.2998 4.10033 12.3582 3.39199 11.3915C2.67533 10.3915 2.10033 9.3915 1.69199 8.42484C1.25866 7.3915 1.04199 6.3915 1.04199 5.44984C1.04199 4.79984 1.15866 4.18317 1.38366 3.60817C1.61699 3.0165 1.99199 2.4665 2.50033 1.9915C3.14199 1.35817 3.87533 1.0415 4.65866 1.0415C4.98366 1.0415 5.31699 1.1165 5.60033 1.24984C5.92533 1.39984 6.20033 1.62484 6.40033 1.92484L8.33366 4.64984C8.50866 4.8915 8.64199 5.12484 8.73366 5.35817C8.84199 5.60817 8.90033 5.85817 8.90033 6.09984C8.90033 6.4165 8.80866 6.72484 8.63366 7.0165C8.50866 7.2415 8.31699 7.48317 8.07533 7.72484L7.50866 8.3165C7.51699 8.3415 7.52533 8.35817 7.53366 8.37484C7.63366 8.54984 7.83366 8.84984 8.21699 9.29984C8.62533 9.7665 9.00866 10.1915 9.39199 10.5832C9.88366 11.0665 10.292 11.4498 10.6753 11.7665C11.1503 12.1665 11.4587 12.3665 11.642 12.4582L11.6253 12.4998L12.2337 11.8998C12.492 11.6415 12.742 11.4498 12.9837 11.3248C13.442 11.0415 14.0253 10.9915 14.6087 11.2332C14.8253 11.3248 15.0587 11.4498 15.3087 11.6248L18.0753 13.5915C18.3837 13.7998 18.6087 14.0665 18.742 14.3832C18.867 14.6998 18.9253 14.9915 18.9253 15.2832C18.9253 15.6832 18.8337 16.0832 18.6587 16.4582C18.4837 16.8332 18.267 17.1582 17.992 17.4582C17.517 17.9832 17.0003 18.3582 16.4003 18.5998C15.8253 18.8332 15.2003 18.9582 14.542 18.9582ZM4.65866 2.2915C4.20033 2.2915 3.77533 2.4915 3.36699 2.8915C2.98366 3.24984 2.71699 3.6415 2.55033 4.0665C2.37533 4.49984 2.29199 4.95817 2.29199 5.44984C2.29199 6.22484 2.47533 7.0665 2.84199 7.93317C3.21699 8.8165 3.74199 9.73317 4.40866 10.6498C5.07533 11.5665 5.83366 12.4582 6.66699 13.2998C7.50033 14.1248 8.40033 14.8915 9.32533 15.5665C10.2253 16.2248 11.1503 16.7582 12.067 17.1415C13.492 17.7498 14.8253 17.8915 15.9253 17.4332C16.3503 17.2582 16.7253 16.9915 17.067 16.6082C17.2587 16.3998 17.4087 16.1748 17.5337 15.9082C17.6337 15.6998 17.6837 15.4832 17.6837 15.2665C17.6837 15.1332 17.6587 14.9998 17.592 14.8498C17.567 14.7998 17.517 14.7082 17.3587 14.5998L14.592 12.6332C14.4253 12.5165 14.2753 12.4332 14.1337 12.3748C13.9503 12.2998 13.8753 12.2248 13.592 12.3998C13.4253 12.4832 13.2753 12.6082 13.1087 12.7748L12.4753 13.3998C12.1503 13.7165 11.6503 13.7915 11.267 13.6498L11.042 13.5498C10.7003 13.3665 10.3003 13.0832 9.85866 12.7082C9.45866 12.3665 9.02533 11.9665 8.50033 11.4498C8.09199 11.0332 7.68366 10.5915 7.25866 10.0998C6.86699 9.6415 6.58366 9.24984 6.40866 8.92484L6.30866 8.67484C6.25866 8.48317 6.24199 8.37484 6.24199 8.25817C6.24199 7.95817 6.35033 7.6915 6.55866 7.48317L7.18366 6.83317C7.35033 6.6665 7.47533 6.50817 7.55866 6.3665C7.62533 6.25817 7.65033 6.1665 7.65033 6.08317C7.65033 6.0165 7.62533 5.9165 7.58366 5.8165C7.52533 5.68317 7.43366 5.53317 7.31699 5.37484L5.38366 2.6415C5.30033 2.52484 5.20033 2.4415 5.07533 2.38317C4.94199 2.32484 4.80033 2.2915 4.65866 2.2915ZM11.6253 12.5082L11.492 13.0748L11.717 12.4915C11.6753 12.4832 11.642 12.4915 11.6253 12.5082Z"
                                                                        fill="#173334" />
                                                                </svg>
                                                                {{auth()->guard('customer')->user()->phone_number ?? ''}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="welcome mt-30">
                                                <p>Hello,
                                                    <strong>{{auth()->guard('customer')->user()->name ?? ''}}</strong>
                                                    (If Not <strong>{{auth()->guard('customer')->user()->name ?? ''}}
                                                        !</strong><a href="{{route('front-user.logout')}}"
                                                        class="logout"> Logout</a>)
                                                </p>
                                            </div>
                                            <p class="mb-0">From your account dashboard. you can easily check & view
                                                your recent orders, manage your shipping and billing addresses and edit
                                                your password and account details.</p>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Edit profile modal start -->
                                    <div class="modal" id="edit-profile">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close"
                                                        data-bs-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" id="editProfileForm" method="POST"
                                                        enctype="multipart/form-data">
                                                        <!-- product details inner end -->
                                                        <div class="edit-account">
                                                            <div class="profile-img-change">
                                                                <div class="profile-pic-wrapper">
                                                                    <div class="pic-holder">
                                                                        <!-- uploaded pic shown here -->
                                                                        <img id="profilePic" class="pic"
                                                                            src="{{!empty($user->image) ? $user->image :  asset('assets/front/img/team/user.png')}}" />
                                                                            
                                                                        <Input class="uploadProfileInput" type="file"
                                                                            name="image" id="newProfilePhoto"
                                                                            accept="image/*" style="opacity: 0;"
                                                                            onchange="updateImage(this)" />
                                                                        <label for="newProfilePhoto"
                                                                            class="upload-file-block">
                                                                            <div class="text-center">
                                                                                <div class="mb-2">
                                                                                    <i class="fa fa-camera fa-2x"></i>
                                                                                </div>
                                                                                <div class="text-uppercase">
                                                                                    Update <br /> Profile Photo
                                                                                </div>
                                                                            </div>
                                                                        </label>
                                                                    </div>
                                                                    <div class="invalid-feedback "></div>
                                                                </div>


                                                            </div>
                                                            @php
                                                            $name = explode(" ", $user->name, 2);
                                                            @endphp
                                                            <div class="row mt-30">
                                                                <div class="col-lg-6 col-md-6">
                                                                    <div class="form-group">
                                                                        <label>First Name</label>
                                                                        <input name="first_name" type="text"
                                                                            class="form-control login"
                                                                            value="{{!empty($name[0]) ? $name[0] : ''}}" />
                                                                            <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Last name</label>
                                                                        <input name="last_name" type="text"
                                                                            class="form-control login"
                                                                            value="{{!empty($name[1]) ? $name[1] : ''}}" />
                                                                            <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Email</label>
                                                                        <input name="email" type="text"
                                                                            class="form-control login"
                                                                            value="{{$user->email ?? ''}}" />
                                                                            <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Phone number</label>
                                                                        <input name="phone_number" type="text"
                                                                            class="form-control login"
                                                                            value="{{$user->phone_number ?? ''}}" />
                                                                            <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <button type="submit"
                                                                            class="sqr-btn mt-3 d-block saveBtn">
                                                                            Save
                                                                            <svg width="30" height="8"
                                                                                viewBox="0 0 30 8" fill="none"
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
                                    <!-- Edit profile modal end -->



                                    <!-- change password modal start -->
                                    <div class="modal" id="change-password">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close"
                                                        data-bs-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" id="changePasswordForm" method="POST"
                                                        enctype="multipart/form-data">
                                                        <!-- product details inner end -->
                                                        <div class="edit-account">


                                                            <div class="row mt-30">
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Current Password</label>
                                                                        <input name="current_password" type="password"
                                                                            class="form-control login" value="" />
                                                                            <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <label>New Password</label>
                                                                        <input name="new_password" type="password"
                                                                            class="form-control login" value="" />
                                                                            <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Confirm Password</label>
                                                                        <input name="confirm_password" type="password"
                                                                            class="form-control login" value="" />
                                                                            <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <button type="submit"
                                                                            class="sqr-btn mt-3 d-block changePasswordBtn">
                                                                            Change Password
                                                                            <svg width="30" height="8"
                                                                                viewBox="0 0 30 8" fill="none"
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
                                    <!-- Edit profile modal end -->

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

<script>
function updateImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            // Update the image source
            $('#profilePic').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);


    }
}
$(document).on('submit', '#editProfileForm', function(e) {
    e.preventDefault();
    $btnName = $(this).find('button[type=submit]').html();
    $(this).find('button[type=submit]').prop('disabled', true);
    $(this).find('button[type=submit]').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> ' +
        $btnName);
    const that = this;
    var formData = new FormData($('#editProfileForm')[0]);
    const attributes = {
        hasButton: true,
        btnSelector: '.saveBtn',
        btnText: $btnName,
        handleSuccess: function() {
            localStorage.setItem('flashMessage', datas['msg']);
            window.location.href = "{{route('front-user.dashboard')}}";
        }
    };
    const ajaxOptions = {
        url: "{{route('front-user.updateProfile')}}",
        method: 'post',
        data: formData
    };

    makeAjaxRequest(ajaxOptions, attributes);
});
$(document).on('submit', '#changePasswordForm', function(e) {
     e.preventDefault();
    $btnName = $(this).find('button[type=submit]').html();
    $(this).find('button[type=submit]').prop('disabled', true);
    $(this).find('button[type=submit]').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> ' +
        $btnName);
    const that = this;
    var formData = new FormData($('#changePasswordForm')[0]);
    const attributes = {
        hasButton: true,
        btnSelector: '.changePasswordBtn',
        btnText: $btnName,
        handleSuccess: function() {
            localStorage.setItem('flashMessage', datas['msg']);
            window.location.href = "{{route('front-user.dashboard')}}";
        }
    };
    const ajaxOptions = {
        url: "{{route('front-user.changePassword')}}",
        method: 'post',
        data: formData
    };

    makeAjaxRequest(ajaxOptions, attributes);
});
</script>
@endsection