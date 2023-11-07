@extends('admin.layout.master')

@push('styles')
<link href="{{ asset('assets/plugin/tagify/tagify.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endpush
@section('content')
@include('admin.layout.response_message')
<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <a class="btn btn-dark" href="{{ url()->previous() }}">Back</a>
    <div class="ms-md-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{  route('admin-category.index')}}">Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Sub Category</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->
<div class="row">
    <div class="col-xl-12">
        <form action="{{ route('admin-sub-category.add',base64_encode($dep_id)) }}" method="post" id="categoryForm"
            enctype="multipart/form-data">
            @csrf
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Create Sub Category
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card-body p-0">
                                <div class="mb-3">
                                    <label for="name" class="form-label"><span class="text-danger">* </span>Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Enter Name" onkeyup="displaySlug($(this))">
                                    <h6 class="category-slug mt-2"></h6>
                                    @if ($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <label for="image" class="form-label"><span class="text-danger">
                                </span>Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image">
                            @if ($errors->has('image'))
                            <div class="invalid-feedback">
                                {{ $errors->first('image') }}
                            </div>
                            @endif
                        </div>
                        <div class="col-xl-6">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title"
                                placeholder="Meta TItle">
                        </div>
                        <div class="col-xl-6 mt-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                placeholder="Meta Keywords">
                        </div>
                        <div class="col-xl-6">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description" id="meta_description" cols="30"
                                rows="5"></textarea>
                        </div>

                    </div>
                </div>

            </div>

            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Variants
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 select2-error">
                            <label for="category_id" class="form-label"><span class="text-danger">
                                </span>Variants</label>
                            <select class="js-example-placeholder-single js-states form-control" multiple="multiple"
                                name="variantsData[]" id="variantsSelect">
                                <!-- <option value="" selected>None</option> -->
                                @forelse ($variants as $variant)
                                <option value="{{ $variant->id }}">{{ $variant->name }}</option>
                                @empty
                                <option value="" selected>No Data found</option>
                                @endforelse
                            </select>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Specifications
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 select2-error">
                            <label for="category_id" class="form-label"><span class="text-danger">
                                </span>Specifications</label>
                            <select class="js-example-placeholder-single js-states form-control" multiple="multiple"
                                name="specificationsData[]" id="specificationsSelect">
                                <!-- <option value="" selected>None</option> -->
                                @forelse ($specifications as $specification)
                                <option value="{{ $specification->id }}">{{ $specification->name }}</option>
                                @empty
                                <option value="" selected>No Data found</option>
                                @endforelse
                            </select>

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
<!-- Select2 Cdn -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/plugin/tagify/tagify.min.js') }}"></script>
<!-- Internal Select-2.js -->
<script src="{{ asset('assets/js/select2.js') }}"></script>
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/js/sweet-alerts.js') }}"></script>
<script src="{{ asset('assets/js/form-validation.js') }}"></script>
<script src="{{ asset('assets/js/custom/category.js') }}"></script>
@endpush