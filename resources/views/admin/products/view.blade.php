@extends('admin.layout.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}">
@endpush
@section('content')

<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <a class="btn btn-dark" href="{{ url()->previous() }}">Back</a>
    <div class="ms-md-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Poduct Details</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Products Details
                </div>
            </div>
            <div class="card-body">
                <div class="row gx-5">
                    <div class="col-xxl-3 col-xl-12">
                        <div class="row">
                            <div class="col-xxl-12 col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-md-5 mb-3">
                                <p class="fs-15 fw-semibold mb-2">Front Product Image :</p>
                                <img class="img-fluid" src="{{ $product->front_image_url }}" alt="img">
                            </div>
                            <div class="col-xxl-12 col-xl-6 col-lg-6 col-md-6 col-sm-12 d-md-block d-none">
                                <p class="fs-15 fw-semibold mb-2">Back Product Image :</p>
                                <img class="img-fluid" src="{{ $product->back_image_url }}" alt="img">
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-9 col-xl-12">
                        <div class="row gx-5">
                            <div class="col-xl-8 mt-xxl-0 mt-3">
                                <div>
                                    <p class="fs-18 fw-semibold mb-0">{{ $product->name }}</p>
                                    {{-- <p class="fs-18 mb-4">
                                        <i class="ri-star-s-fill text-warning align-middle"></i>
                                        <i class="ri-star-s-fill text-warning align-middle"></i>
                                        <i class="ri-star-s-fill text-warning align-middle"></i>
                                        <i class="ri-star-s-fill text-warning align-middle"></i>
                                        <i class="ri-star-half-s-fill text-warning align-middle"></i>
                                        <span class="fw-semibold text-muted ms-1">4.3<a class="text-info" href="javascript:void(0);">(2.4k Reviews)</a></span>
                                    </p> --}}
                                    <div class="row mt-4 mb-4">
                                        <div class="col-xxl-3 col-xl-12">
                                            <p class="mb-1 lh-1 fs-11 text-success fw-semibold">Price</p>
                                            <p class="mb-1"><span class="h3"><sup class="fs-14">$</sup>{{ $product->price ?? "N/A" }}<sup class="fs-14">.00</sup></span></p>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <p class="fs-15 fw-semibold mb-1">Description :</p>
                                        <p class="text-muted mb-0">
                                            {{ $product->description ?? "N/A" }}
                                        </p>
                                    </div>
                                    <div class="mb-4">
                                        <p class="fs-15 fw-semibold mb-2">Product Details :</p>
                                        <div class="row">
                                            <div class="col-xl-10">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered text-nowrap">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row" class="fw-semibold">
                                                                    Category
                                                                </th>
                                                                <td>{{ $product->category->name ?? "N/A" }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" class="fw-semibold">
                                                                    Sub Category
                                                                </th>
                                                                <td>
                                                                    {{ $product->subCategory->name ?? "N/A" }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row" class="fw-semibold">
                                                                    Child Category
                                                                </th>
                                                                <td>
                                                                    {{ $product->childCategory->name ?? "N/A" }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
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
        </div>
    </div>
</div>

@endsection

@push('scripts')
      <!-- Custom-Switcher JS -->
      <script src="{{ asset('assets/js/custom-switcher.min.js') }}"></script>

      <!-- Swiper JS -->
      <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

      <script src="{{ asset('assets/js/product-details.js') }}"></script>
@endpush