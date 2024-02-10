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
                <li class="breadcrumb-item"><a href="{{  route('admin-size-charts.index')}}">Size Chart</a></li>
                <li class="breadcrumb-item"><a href="{{  route('admin-size-chart-details.index', base64_encode($dep_id))}}">Size Chart Detail</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Size Chart Detail</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->
<div class="row">
    <div class="col-xl-12">
        <form action="{{ route('admin-size-chart-details.add',base64_encode($dep_id)) }}"
        method="post" id="shippingAreaForm"
            enctype="multipart/form-data">
            @csrf
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Create Size Chart Detail
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card-body p-0">
                                <div class="mb-3">
                                    <label for="name" class="form-label"><span class="text-danger">* </span>Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Enter Name">
                                    @if ($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="variantValuesRow card custom-card">

                <div class="card-header">
                    <div class="card-title">
                        Size Chart Detail Values
                    </div>
                </div>
                <div class="card-body">
                    @if(!empty(($sizeChartDetailValue)))
                    <?php $iterationCount = 0; ?>
                    <div id="kt_repeater_1" class="ml-7">
                        <div class="form-group row" id="kt_repeater_1">
                            <div data-repeater-list="dataArr" class="col-lg-12">
                                @foreach($sizeChartDetailValue as $dataKey => $dataVal)

                                <div data-repeater-item class="form-group row align-items-center mb-0">
                                    <div class="col-xl-4 mb-3">
                                        <div class="form-group">
                                            <label for="size_name">Size Name</label><span class="text-danger">
                                                 </span>
                                            <input type="text" name="size_name"
                                                class="form-control form-control-solid form-control-lg  @error('size_name') is-invalid @enderror"
                                                value="{{!empty($dataVal['size_name']) ? $dataVal['size_name'] : ''}}">

                                        </div>
                                    </div>
                                    <div class="col-xl-4 mb-3">
                                        <div class="form-group">
                                            <label for="size_value">Size Value(CM)</label><span class="text-danger">
                                                 </span>
                                            <input type="text" name="size_value"
                                                class="form-control form-control-solid form-control-lg  @error('size_value') is-invalid @enderror"
                                                value="{{!empty($dataVal['size_value']) ? $dataVal['size_value'] : ''}}">

                                        </div>
                                    </div>



                                    <div class="col-md-2">
                                        @if($iterationCount == 0)
                                        <a href="javascript:;" data-repeater-create=""
                                            class="btn btn-teal-primary btn-border-down">
                                            <i class="la la-plus"></i>Add More Value
                                        </a>
                                        <a href="javascript:;" data-repeater-delete=""
                                            class="btn btn-sm font-weight-bolder btn-light-danger"
                                            style="display:none;">
                                            <i class="la la-trash-o"></i>Delete Value
                                        </a>
                                        @else
                                        <a href="javascript:;" data-repeater-create=""
                                            class="btn btn-teal-primary btn-border-down"
                                            style="display:none;">
                                            <i class="la la-plus"></i>Add More Value
                                        </a>
                                        <a href="javascript:;" data-repeater-delete=""
                                            class="btn btn-sm font-weight-bolder btn-light-danger">
                                            <i class="la la-trash-o"></i>Delete Value
                                        </a>
                                        @endif
                                    </div>
                                </div>



                                <?php $iterationCount++; ?>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @else
                    <div id="kt_repeater_1" class="ml-7">
                        <div class="form-group row" id="kt_repeater_1">

                            <div data-repeater-list="dataArr" class="col-lg-12">
                                <div data-repeater-item class="form-group row align-items-center mb-0">
                                    <div class="col-xl-4 mb-3">
                                        <div class="form-group">
                                            <label for="size_name">Size Name</label><span class="text-danger">
                                                 </span>
                                            <input type="text" name="size_name"
                                                class="form-control form-control-solid form-control-lg variant-value @error('size_name') is-invalid @enderror"
                                                value="">

                                        </div>
                                    </div>
                                    <div class="col-xl-4 mb-3">
                                        <div class="form-group">
                                            <label for="size_value">Size Value(CM)</label><span class="text-danger">
                                                 </span>
                                            <input type="text" name="size_value"
                                                class="form-control form-control-solid form-control-lg variant-value @error('size_value') is-invalid @enderror"
                                                value="">

                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <a href="javascript:;" data-repeater-create=""
                                            class="btn btn-sm font-weight-bolder btn btn-primary-light btn-border-down">
                                            <i class="la la-plus"></i>Add More Value
                                        </a>
                                        <a href="javascript:;" data-repeater-delete=""
                                            class="btn btn-sm font-weight-bolder btn btn-danger-light btn-border-down"
                                            style="display:none;">
                                            <i class="la la-trash-o"></i>Delete Value
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    @endif
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
<script src="{{ asset('assets/js/repeater.js')}}"></script>
<script src="{{ asset('assets/js/custom/sizecharts.js')}}"></script>
<script src="{{ asset('assets/js/form-validation.js') }}"></script>


@endpush