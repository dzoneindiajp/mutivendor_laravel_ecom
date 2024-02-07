@extends('front.layouts.app',['page' => 'login'])
@push('styles')
<link href="{{ asset('assets/front/css/login.css') }}" rel="stylesheet">
@endpush
@section('content')  
<form action="{{route('front-user.postSignup')}}" method="post" autocomplete="off">  
@csrf
<div class="login-section">
        <div class="container">
            <div class="login-box">

                <div class="white-box">
                    <!--<h2 class="mb-4">REGISTER</h2>-->
                    <div class="text-center w-100 mb-5">
                        <img src="{{asset('assets/front/img/logo/logo-black.png')}}" width="250" />
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First name</label>
                                <input type="text" name="first_name" class="form-control login @error('first_name') is-invalid @enderror" placeholder="Enter your email" value="{{old('first_name')}}" />
                                @if ($errors->has('first_name'))
                                <div class=" invalid-feedback">
                                    {{ $errors->first('first_name') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last name</label>
                                <input type="text" name="last_name" class="form-control login @error('last_name') is-invalid @enderror" placeholder="Enter your last name" value="{{old('last_name')}}" />
                                @if ($errors->has('last_name'))
                                <div class=" invalid-feedback">
                                    {{ $errors->first('last_name') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control login @error('email') is-invalid @enderror" placeholder="Enter your email" value="{{old('email')}}" />
                        @if ($errors->has('email'))
                        <div class=" invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Phone number</label>
                        <input type="text" name="phone_number" class="form-control login @error('phone_number') is-invalid @enderror" placeholder="Enter your phone number" value="{{old('phone_number')}}" />
                        @if ($errors->has('phone_number'))
                        <div class=" invalid-feedback">
                            {{ $errors->first('phone_number') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control login @error('password') is-invalid @enderror" placeholder="Enter your password" />
                        @if ($errors->has('password'))
                        <div class=" invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control login @error('confirm_password') is-invalid @enderror" placeholder="Enter your password again" />
                        @if ($errors->has('confirm_password'))
                        <div class=" invalid-feedback">
                            {{ $errors->first('confirm_password') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="login-button">
                            Register <svg class="right" width="30" height="8" viewBox="0 0 30 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 3.5C0.723858 3.5 0.5 3.72386 0.5 4C0.5 4.27614 0.723858 4.5 1 4.5V3.5ZM29.3536 4.35355C29.5488 4.15829 29.5488 3.84171 29.3536 3.64645L26.1716 0.464466C25.9763 0.269204 25.6597 0.269204 25.4645 0.464466C25.2692 0.659728 25.2692 0.976311 25.4645 1.17157L28.2929 4L25.4645 6.82843C25.2692 7.02369 25.2692 7.34027 25.4645 7.53553C25.6597 7.7308 25.9763 7.7308 26.1716 7.53553L29.3536 4.35355ZM1 4.5H29V3.5H1V4.5Z" fill="black" />
                            </svg>
                        </button>
                    </div>
                    <div class=" text-center form-group">
                        <p>Already have an account? <a href="{{route('front-user.login')}}" class="forgot-password">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection