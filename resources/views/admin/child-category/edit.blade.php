@extends('admin.layout.master')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<link href="{{ asset('assets/plugin/tagify/tagify.css') }}" rel="stylesheet" type="text/css" />
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
                <li class="breadcrumb-item active" aria-current="page">Edit Child Category</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->

<div class="card custom-card">
    <div class="card-header">
        <div class="card-title">
            Crate Child Category
        </div>
    </div>
    <form action="{{ route('admin-product-categories-child-category-update',['token' => encrypt($childCategory->id)]) }}" method="post" id="editChildCateogryForm">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-xl-6">
                    <div class="card-body p-0">
                        <div class="mb-3">
                            <label for="category" class="form-label"><span class="text-danger">* </span>Category</label>
                            <select class="js-example-placeholder-single js-states form-control" name="category_id"
                                id="edit_category_id"
                                data-action="{{ route('admin-product-categories-child-category-child-sub-category-list') }}">
                                <option value="" selected>None</option>
                                @forelse ($categories as $category)
                                <option value="{{ $category->id }}" {{ $childCategory->category_id == $category->id ?
                                    'selected' : '' }}>{{ $category->name }}</option>
                                @empty
                                <option value="" selected>No Data found</option>
                                @endforelse
                            </select>
                        </div>

                        <div class="mb-3 select2-error">
                            <label for="sub_category" class="form-label"><span class="text-danger">* </span>Sub
                                Category</label>
                            <select class="js-example-placeholder-single js-states form-control" name="sub_category_id"
                                id="edit_sub_category_id">
                                <option value="" selected>None</option>
                                <option value="{{ $childCategory->sub_category_id }}" selected>{{
                                    $childCategory->subCategory->name }}</option>
                            </select>
                        </div>

                        <div class="mb-3 select2-error">
                            <label for="child_category" class="form-label"><span class="text-danger">* </span>Child
                                Category</label>
                            <input type="text" class="form-control" id="child_category" name="child_category"
                                placeholder="Enter Child Category" value="{{ $childCategory->name }}"
                                onkeyup="editDisplaySlug($(this))">
                            <h6 class="edit-child-category-slug mt-2"></h6>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label"><span class="text-danger">* </span>Slug</label>
                            <input type="text" class="form-control" disabled value="{{ $childCategory->slug }}">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card-body p-0">
                        <div class="col-xl-12">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title"
                                placeholder="Meta TItle" value="{{ $childCategory->meta_title }}">
                        </div>
                        <div class="col-xl-12 mt-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description" id="meta_description" cols="30"
                                rows="5">{{ $childCategory->meta_description }}</textarea>
                        </div>
                        <div class="col-xl-12 mt-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                placeholder="Meta Keywords" value="{{ $childCategory->meta_keywords }}">
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

@endsection

@push('scripts')
<!-- Select2 Cdn -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Internal Select-2.js -->
<script src="{{ asset('assets/js/select2.js') }}"></script>
<script src="{{ asset('assets/plugin/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/plugin/tagify/tagify.min.js') }}"></script>
<script src="{{ asset('assets/js/form-validation.js') }}"></script>
<script src="{{ asset('assets/js/custom/child-category.js') }}"></script>
@endpush