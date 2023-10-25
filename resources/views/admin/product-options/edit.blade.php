@extends('admin.layout.master')

@section('content')
@include('admin.layout.response_message')
<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <a class="btn btn-dark" href="{{ url()->previous() }}">Back</a>
    <div class="ms-md-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Option</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->

<div class="col-xl-6">
    <div class="card custom-card">
        <div class="card-header">
            <div class="card-title">
                Edit Category
            </div>
        </div>
        <form action="{{ route('admin-product-options-update',['token' => encrypt($productOption->id)]) }}"
            method="post" id="editProductOptionsForm">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card-body p-0">

                            <div class="mb-3">
                                <label for="Name" class="form-label"><span class="text-danger">* </span>Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $productOption->name }}" placeholder="Enter Category">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection
@push('scripts')
<script src="{{ asset('assets/plugin/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/form-validation.js') }}"></script>
@endpush