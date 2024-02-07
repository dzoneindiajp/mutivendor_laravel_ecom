@extends('admin.layout.master')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/libs/dropzone/dropzone.css') }}">
<link href="{{ asset('assets/plugin/tagify/tagify.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>

@endpush

@section('content')
<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <a class="btn btn-dark" href="{{ url()->previous() }}">Back</a>
    <div class="ms-md-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Price Drop</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->
<div class="row">
    <div class="col-xl-12">
        <form action="{{ route('admin-price-drops.save') }}" method="post" enctype="multipart/form-data"
            id="createCouponForm">
            @csrf
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Basic Info
                    </div>
                </div>
                <div class="card-body add-products p-0">
                    <div class="p-4">
                        <div class="row gx-5">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                <div class="card custom-card shadow-none mb-0 border-0">
                                    <div class="card-body p-0">
                                        <div class="row gy-3">

                                            <div class="col-xl-6">
                                                <label for="assign_type" class="form-label"><span class="text-danger">*
                                                </span>Assign To</label>
                                                <select class="form-select" name="assign_type" id="assign_type">
                                                    <option value="">Select Type</option>
                                                    <option value="category"
                                                    {{(!empty($userDetails->assign_type) && $userDetails->assign_type == 'category') ? 'selected' : '' }}>
                                                    Category</option>
                                                    <option value="product"
                                                    {{(!empty($userDetails->assign_type) && $userDetails->assign_type == 'product') ? 'selected' : '' }}>
                                                    Product</option>
                                                </select>
                                            </div>

                                            <div class="col-xl-6" id="categoryDropdown" style="display: none;">
                                                <label for="reference" class="form-label">Categories</label>
                                                <select class="js-example-placeholder-single js-states form-control" multiple="multiple" name="categoryData[]">
                                                    @forelse ($categories as $category)
                                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                                    @empty
                                                    <option value="" selected>No Data found</option>
                                                    @endforelse
                                                </select>
                                            </div>

                                            <div class="col-xl-6" id="productDropdown" style="display: none;">
                                                <label for="reference" class="form-label">Products</label>
                                                <select class="js-example-placeholder-single js-states form-control" multiple="multiple" name="productData[]">
                                                    @forelse ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                    @empty
                                                    <option value="" selected>No Data found</option>
                                                    @endforelse
                                                </select>
                                            </div>

                                            <div class="col-xl-6">
                                                <label for="drop_type" class="form-label"><span class="text-danger">*
                                                    </span>Drop Type</label>
                                                <select class="js-example-placeholder-single form-control @error('drop_type') is-invalid @enderror"
                                                    name="drop_type" id="drop_type">
                                                    <option value="" selected>Select Drop Type</option>
                                                    <option value="flat"
                                                        {{(!empty($userDetails->drop_type) && $userDetails->drop_type == 'flat') ? 'selected' : '' }}>
                                                        Flat</option>
                                                    <option value="percentage"
                                                        {{(!empty($userDetails->drop_type) && $userDetails->drop_type == 'percentage') ? 'selected' : '' }}>
                                                        Percentage</option>
                                                </select>
                                                @if ($errors->has('drop_type'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('drop_type') }}
                                                </div>
                                                @endif
                                            </div>

                                            <div class="col-xl-6">
                                                <label for="amount" class="form-label"><span class="text-danger">*
                                                    </span>Amount</label>
                                                <input type="text"
                                                    class="form-control @error('amount') is-invalid @enderror" id="amount"
                                                    name="amount"
                                                    value="{{isset($userDetails->amount) ? $userDetails->amount: old('amount')}}"
                                                    placeholder="Amount">
                                                @if ($errors->has('amount'))
                                                <div class=" invalid-feedback">
                                                    {{ $errors->first('amount') }}
                                                </div>
                                                @endif
                                            </div>

                                            <div class="col-xl-6">
                                                <label for="start_date" class="form-label"><span class="text-danger">* </span>Start Date</label>
                                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{isset($userDetails->start_date) ? $userDetails->start_date: old('start_date')}}" placeholder="Start Date">
                                                @if ($errors->has('start_date'))
                                                    <div class=" invalid-feedback">
                                                        {{ $errors->first('start_date') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="end_date" class="form-label"><span class="text-danger">* </span>End Date</label>
                                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{isset($userDetails->end_date) ? $userDetails->end_date: old('end_date')}}" placeholder="End Date">
                                                @if ($errors->has('end_date'))
                                                    <div class=" invalid-feedback">
                                                        {{ $errors->first('end_date') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
<!-- Select2 Cdn -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/plugin/tagify/tagify.min.js') }}"></script>

<!-- Internal Select-2.js -->
<script src="{{ asset('assets/js/select2.js') }}"></script>

<script src="{{ asset('assets/libs/dropzone/dropzone-min.js') }}"></script>

<script src="{{ asset('assets/js/custom/product.js') }}"></script>

{{-- <script src="{{ asset('assets/js/fileupload.js') }}"></script> --}}
<script src="{{ asset('assets/plugin/jquery-validation/jquery.validate.min.js') }}"></script>
<!-- <script src="{{ asset('assets/js/form-validation.js') }}"></script> -->
<script src="{{ asset('assets/js/repeater.js')}}"></script>

<script>
    $(document).ready(function() {
        // Listen for changes in the assign_type dropdown
        $('#assign_type').change(function() {
            var selectedValue = $(this).val();

            // Hide all dropdowns initially
            $('#categoryDropdown, #productDropdown').hide();

            // Show the dropdown corresponding to the selected assign_type
            if (selectedValue === 'category') {
                $('#categoryDropdown').show();
            } else if (selectedValue === 'product') {
                $('#productDropdown').show();
            }
        });

        // Check the initial value of assign_type and show the corresponding dropdown
        var initialAssignType = $('#assign_type').val();
        if (initialAssignType === 'category') {
            $('#categoryDropdown').show();
        } else if (initialAssignType === 'product') {
            $('#productDropdown').show();
        }

        // Trigger change event on assign_type dropdown to initialize visibility
        $('#assign_type').trigger('change');
    });
</script>

@endpush