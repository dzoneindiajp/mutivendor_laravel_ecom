@extends('admin.layout.master')

@push('styles')
<link href="{{ asset('assets/plugin/tagify/tagify.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
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
                <li class="breadcrumb-item"><a href="{{  route('admin-sub-category.index', base64_encode($SubcategoryDetails->parent_id))}}">Sub Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Child Category</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->


<div class="card custom-card">
    <div class="card-header">
        <div class="card-title">
            Edit Child Category
        </div>
    </div>
    <form action="{{route('admin-'.$model.'.edit',base64_encode($category->id))}}"
        method="post" id="categoryForm" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-xl-6">
                    <div class="card-body p-0">

                        <div class="mb-3">
                            <label for="name" class="form-label"><span class="text-danger">* </span>Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name"
                                placeholder="Enter Name" onkeyup="editDisplaySlug($(this))"
                                value="{{ $category->name }}">
                            <h6 class="edit-category-slug mt-2"></h6>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label"><span class="text-danger">* </span>Slug</label>
                            <input type="text" class="form-control" disabled value="{{ $category->slug }}">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <label for="image" class="form-label"><span class="text-danger">
                        </span>Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    @if (!empty($category->image))
                        <img height="50" width="50" src="{{isset($category->image)? $category->image:''}}" />
                    @endif
                    @if ($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                    @endif
                </div>
                <div class="col-xl-6">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title"
                        placeholder="Meta TItle" value="{{ $category->meta_title }}">
                </div>
                <div class="col-xl-6">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control" name="meta_description" id="meta_description" cols="30"
                        rows="5">{{ $category->meta_description }}</textarea>
                </div>
                <div class="col-xl-6 mt-3">
                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                        placeholder="Meta Keywords" value="{{ $category->meta_keywords }}">
                </div>
            </div>
        </div>
        <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

@endsection
@push('scripts')
<script src="{{ asset('assets/plugin/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/js/sweet-alerts.js') }}"></script>
<script src="{{ asset('assets/js/form-validation.js') }}"></script>
<script src="{{ asset('assets/plugin/tagify/tagify.min.js') }}"></script>
<script src="{{ asset('assets/js/custom/category.js') }}"></script>
@endpush