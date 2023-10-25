@extends('admin.layout.master')

@section('guest_content')
<div class="container">
    <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
        <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
            <div class="my-5 d-flex justify-content-center">
                <a href="index.html">
                    <img src="{{ asset('assets/images/brand-logos/desktop-logo.png') }}" alt="logo"
                        class="desktop-logo">
                    <img src="{{ asset('assets/images/brand-logos/desktop-dark.png') }}" alt="logo"
                        class="desktop-dark">
                </a>
            </div>
            <div class="card custom-card">
                <div class="card-body p-5">
                    <p class="h5 fw-semibold mb-2 text-center">Sign In</p>
                    <p class="mb-4 text-muted op-7 fw-normal text-center">Welcome back Jhon !</p>
                    <form class="form-horizontal" method="post" action="{{ route('admin-verify-login') }}">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-xl-12">
                                <label for="email" class="form-label text-default">Email</label>
                                <input type="text" class="form-control form-control-lg" id="email" name="email"
                                    placeholder="Enter Email">
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label for="password" class="form-label text-default d-block">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-lg" id="password" name="password"
                                        placeholder="password">
                                    <button class="btn btn-light" type="button"
                                        onclick="createpassword('signin-password',this)" id="button-addon2"><i
                                            class="ri-eye-off-line align-middle"></i></button>
                                </div>
                                <div class="mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                        <label class="form-check-label text-muted fw-normal" for="defaultCheck1">
                                            Remember password ?
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 d-grid mt-2">
                                <button class="btn btn-lg btn-primary" type="submit">Sign In</button>
                            </div>
                        </div>
                    </form>
                    {{-- <div class="text-center">
                        <p class="fs-12 text-muted mt-3">Dont have an account? <a href="sign-up-basic.html"
                                class="text-primary">Sign Up</a></p>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
     <!-- Custom-Switcher JS -->
     <script src="{{ asset('assets/js/custom-switcher.min.js') }}"></script>

     <!-- Bootstrap JS -->
     <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 
     <!-- Show Password JS -->
     <script src="{{ asset('assets/js/show-password.js') }}"></script>
@endpush