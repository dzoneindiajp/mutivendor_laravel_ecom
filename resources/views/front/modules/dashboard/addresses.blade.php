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
                                    <a href="{{route('front-user.orders')}}"><i class="fa fa-shopping-bag"></i>
                                        Orders</a>
                                    <a href="{{route('front-user.wishlist')}}"><i class="fa fa-heart"></i> Wishlist</a>
                                    <!-- <a href="#"><i class="fa fa-credit-card"></i> Payment Method</a> -->
                                    <a href="{{route('front-user.addresses')}}" class="active"><i class="fa fa-map"></i>
                                        address</a>
                                    <a href="{{route('front-user.logout')}}"><i class="fa fa-sign-out"></i> Logout</a>
                                </div>
                            </div>
                            <!-- My Account Tab Menu End -->
                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade show active" id="address-edit" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Address</h3>
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
                                                                @if($address->is_primary == 1)<span
                                                                    class="primary-button">Primary</span>@endif
                                                            </p>
                                                        </td>
                                                        <td align="right">
                                                            @if($address->is_primary == 0)
                                                            <button class="btn btn-outline-primary btn-sm"
                                                                onclick="window.open('{{route('front-user.makeAddressPrimary',$address->id)}}','_self')">Make
                                                                address as primary</button>
                                                            @endif
                                                            <a href="{{route('front-user.editAddress',$address->id)}}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit-address{{$address->id}}"
                                                                class="edit-address">
                                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M13.2603 3.60022L5.05034 12.2902C4.74034 12.6202 4.44034 13.2702 4.38034 13.7202L4.01034 16.9602C3.88034 18.1302 4.72034 18.9302 5.88034 18.7302L9.10034 18.1802C9.55034 18.1002 10.1803 17.7702 10.4903 17.4302L18.7003 8.74022C20.1203 7.24022 20.7603 5.53022 18.5503 3.44022C16.3503 1.37022 14.6803 2.10022 13.2603 3.60022Z"
                                                                        stroke="#173334" stroke-width="1.5"
                                                                        stroke-miterlimit="10" stroke-linecap="round"
                                                                        stroke-linejoin="round" />
                                                                    <path
                                                                        d="M11.8896 5.0498C12.3196 7.8098 14.5596 9.9198 17.3396 10.1998"
                                                                        stroke="#173334" stroke-width="1.5"
                                                                        stroke-miterlimit="10" stroke-linecap="round"
                                                                        stroke-linejoin="round" />
                                                                    <path d="M3 22H21" stroke="#173334"
                                                                        stroke-width="1.5" stroke-miterlimit="10"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round" />
                                                                </svg>
                                                            </a>
                                                            <a href="{{route('front-user.deleteAddress',$address->id)}}"
                                                                class="delete-address">
                                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M20.9997 6.72998C20.9797 6.72998 20.9497 6.72998 20.9197 6.72998C15.6297 6.19998 10.3497 5.99998 5.11967 6.52998L3.07967 6.72998C2.65967 6.76998 2.28967 6.46998 2.24967 6.04998C2.20967 5.62998 2.50967 5.26998 2.91967 5.22998L4.95967 5.02998C10.2797 4.48998 15.6697 4.69998 21.0697 5.22998C21.4797 5.26998 21.7797 5.63998 21.7397 6.04998C21.7097 6.43998 21.3797 6.72998 20.9997 6.72998Z"
                                                                        fill="#FF0505" />
                                                                    <path
                                                                        d="M8.49977 5.72C8.45977 5.72 8.41977 5.72 8.36977 5.71C7.96977 5.64 7.68977 5.25 7.75977 4.85L7.97977 3.54C8.13977 2.58 8.35977 1.25 10.6898 1.25H13.3098C15.6498 1.25 15.8698 2.63 16.0198 3.55L16.2398 4.85C16.3098 5.26 16.0298 5.65 15.6298 5.71C15.2198 5.78 14.8298 5.5 14.7698 5.1L14.5498 3.8C14.4098 2.93 14.3798 2.76 13.3198 2.76H10.6998C9.63977 2.76 9.61977 2.9 9.46977 3.79L9.23977 5.09C9.17977 5.46 8.85977 5.72 8.49977 5.72Z"
                                                                        fill="#FF0505" />
                                                                    <path
                                                                        d="M15.2104 22.7501H8.79039C5.30039 22.7501 5.16039 20.8201 5.05039 19.2601L4.40039 9.19007C4.37039 8.78007 4.69039 8.42008 5.10039 8.39008C5.52039 8.37008 5.87039 8.68008 5.90039 9.09008L6.55039 19.1601C6.66039 20.6801 6.70039 21.2501 8.79039 21.2501H15.2104C17.3104 21.2501 17.3504 20.6801 17.4504 19.1601L18.1004 9.09008C18.1304 8.68008 18.4904 8.37008 18.9004 8.39008C19.3104 8.42008 19.6304 8.77007 19.6004 9.19007L18.9504 19.2601C18.8404 20.8201 18.7004 22.7501 15.2104 22.7501Z"
                                                                        fill="#FF0505" />
                                                                    <path
                                                                        d="M13.6601 17.25H10.3301C9.92008 17.25 9.58008 16.91 9.58008 16.5C9.58008 16.09 9.92008 15.75 10.3301 15.75H13.6601C14.0701 15.75 14.4101 16.09 14.4101 16.5C14.4101 16.91 14.0701 17.25 13.6601 17.25Z"
                                                                        fill="#FF0505" />
                                                                    <path
                                                                        d="M14.5 13.25H9.5C9.09 13.25 8.75 12.91 8.75 12.5C8.75 12.09 9.09 11.75 9.5 11.75H14.5C14.91 11.75 15.25 12.09 15.25 12.5C15.25 12.91 14.91 13.25 14.5 13.25Z"
                                                                        fill="#FF0505" />
                                                                </svg>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="modal" id="edit-address{{$address->id}}">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close"
                                                                data-bs-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="" data-id="{{$address->id}}"
                                                                class="editAddressForm" method="POST"
                                                                enctype="multipart/form-data">
                                                                <!-- product details inner end -->
                                                                <div class="edit-account">
                                                                    <div class="row mt-30">
                                                                        <div class="col-lg-12 col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Full Name</label>
                                                                                <input type="text" name="name"
                                                                                    class="form-control login"
                                                                                    value="{{$address->name ?? ''}}" />
                                                                                <div class="invalid-feedback"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Email</label>
                                                                                <input type="text" name="email"
                                                                                    class="form-control login"
                                                                                    value="{{$address->email ?? ''}}" />
                                                                                <div class="invalid-feedback"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Phone Number</label>
                                                                                <input type="text" name="phone_number"
                                                                                    class="form-control login"
                                                                                    value="{{$address->phone_number ?? ''}}" />
                                                                                <div class="invalid-feedback"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Address line 1</label>
                                                                                <input type="text" name="address_line_1"
                                                                                    class="form-control login"
                                                                                    value="{{$address->address_line_1 ?? ''}}" />
                                                                                <div class="invalid-feedback"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Address line 2</label>
                                                                                <input type="text" name="address_line_2"
                                                                                    class="form-control login"
                                                                                    value="{{$address->address_line_2 ?? ''}}" />
                                                                                <div class="invalid-feedback"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-12">
                                                                            <div class="form-group">
                                                                                <label>Postal code</label>
                                                                                <input type="text" name="postal_code"
                                                                                    class="form-control login"
                                                                                    value="{{$address->postal_code ?? ''}}" />
                                                                                <div class="invalid-feedback"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-12">
                                                                            <div class="form-group">
                                                                                <label>Landmark</label>
                                                                                <input type="text" name="landmark"
                                                                                    class="form-control login"
                                                                                    value="{{$address->landmark ?? ''}}" />
                                                                                <div class="invalid-feedback"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-12">
                                                                            <div class="form-group">
                                                                                <label>City</label>
                                                                                <input type="text" name="city"
                                                                                    class="form-control login"
                                                                                    value="{{$address->city ?? ''}}" />
                                                                                <div class="invalid-feedback"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-12">
                                                                            <div class="form-group">
                                                                                <label>State</label>
                                                                                <input type="text" name="state"
                                                                                    class="form-control login"
                                                                                    value="{{$address->state ?? ''}}" />
                                                                                <div class="invalid-feedback"></div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="col-lg-12 col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Country</label>
                                                                                <input type="text" name="country"
                                                                                    class="form-control login"
                                                                                    value="{{$address->country ?? ''}}" />
                                                                                <div class="invalid-feedback"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-md-12">
                                                                            <div class="form-group">
                                                                                <buttton type="submit"
                                                                                    class="sqr-btn mt-3 d-block updateAddressBtn">
                                                                                    Update
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
                                    <!-- Single Tab Content End -->

                                    <!-- add address modal start -->
                                    <div class="modal" id="add-address">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close"
                                                        data-bs-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" class="addAddressForm" method="POST"
                                                        enctype="multipart/form-data">
                                                        <!-- product details inner end -->
                                                        <div class="edit-account">
                                                            <div class="row mt-30">
                                                                <div class="col-lg-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Full Name</label>
                                                                        <input type="text" name="name"
                                                                            class="form-control login"
                                                                            value="{{$address->name ?? ''}}" />
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Email</label>
                                                                        <input type="text" name="email"
                                                                            class="form-control login"
                                                                            value="{{$address->email ?? ''}}" />
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Phone Number</label>
                                                                        <input type="text" name="phone_number"
                                                                            class="form-control login"
                                                                            value="{{$address->phone_number ?? ''}}" />
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Address line 1</label>
                                                                        <input type="text" name="address_line_1"
                                                                            class="form-control login" />
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Address line 2</label>
                                                                        <input type="text" name="address_line_2"
                                                                            class="form-control login" />
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Postal code</label>
                                                                        <input type="text" name="postal_code"
                                                                            class="form-control login" />
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Landmark</label>
                                                                        <input type="text" name="landmark"
                                                                            class="form-control login" />
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-12">
                                                                    <div class="form-group">
                                                                        <label>City</label>
                                                                        <input type="text" name="city"
                                                                            class="form-control login" />
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-12">
                                                                    <div class="form-group">
                                                                        <label>State</label>
                                                                        <input type="text" name="state"
                                                                            class="form-control login" />
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
            window.location.href = "{{route('front-user.addresses')}}";
        }
    };
    const ajaxOptions = {
        url: "{{route('front-user.addAddress')}}",
        method: 'post',
        data: formData
    };

    makeAjaxRequest(ajaxOptions, attributes);
});

$(document).on('click', '.updateAddressBtn', function(e) {
    e.preventDefault();
    $btnName = $(this).html();
    $(this).prop('disabled', true);
    $(this).html(
        '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> ' +
        $btnName);
    const that = this;
    var formData = new FormData($(this).parents('.editAddressForm')[0]);
    const attributes = {
        hasButton: true,
        btnSelector: '.updateAddressBtn',
        btnText: $btnName,
        handleSuccess: function() {
            localStorage.setItem('flashMessage', datas['msg']);
            window.location.href = "{{route('front-user.addresses')}}";
        }
    };
    let url = "{{route('front-user.editAddress',':addressId')}}";
    url = url.replace(':addressId', $(this).parents('.editAddressForm').attr('data-id'));
    const ajaxOptions = {
        url: url,
        method: 'post',
        data: formData
    };

    makeAjaxRequest(ajaxOptions, attributes);
});
</script>
@endsection