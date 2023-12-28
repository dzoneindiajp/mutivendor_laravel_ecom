@extends('admin.layout.master')

@push('styles')
<link href="{{ asset('assets/plugin/tagify/tagify.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css" />

<!-- Include Pickr JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr"></script>

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
                <li class="breadcrumb-item active" aria-current="page">Create Variant</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->

<div class="row">
    <div class="col-xl-12">
        <form action="{{route('admin-'.$model.'.store')}}" method="post" id="variantForm" autocomplete="off"
            enctype="multipart/form-data">
            @csrf
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Create Variant
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card-body p-0">
                                <div class="mb-3">
                                    <label for="name" class="form-label"><span class="text-danger">* </span>Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Enter Name"
                                        value="{{ $recordDetails->name ?? '' }}">
                                    @if ($errors->has('name'))
                                    <div class=" invalid-feedback">
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
                        Variant Values
                    </div>
                </div>
                <div class="card-body">
                    @if(!empty(($variantValuesData)))
                    <?php $iterationCount = 0; ?>
                    <div id="kt_repeater_1" class="ml-7">
                        <div class="form-group row" id="kt_repeater_1">
                            <div data-repeater-list="dataArr" class="col-lg-12">
                                @foreach($variantValuesData as $dataKey => $dataVal)
                                @if(!empty($dataVal['name']))
                                <div data-repeater-item class="form-group row align-items-center mb-0">
                                    <div class="col-md-5 mb-3">
                                        <div class="form-group">
                                            <label for="name">Name</label><span class="text-danger">
                                                 </span>
                                            <input type="text" name="name"
                                                class="form-control form-control-solid form-control-lg  @error('name') is-invalid @enderror"
                                                value="{{!empty($dataVal['name']) ? $dataVal['name'] : ''}}">

                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3 colorPickerIn" style="display:none ">
                                        <div class="form-group">
                                            <label for="color">Color</label><span class="text-danger">
                                                 </span>
                                            <!-- <input type="text" id="color-picker" /> -->
                                            <!-- <input type="color" name="color_code" id="color_code"
                                                class="form-control form-control-color border-0 @error('color_code') is-invalid @enderror" value="{{!empty($dataVal['color_code']) ? $dataVal['color_code'] : ''}}"> -->
                                            <input type="text" name="color_code" id="color-picker"
                                                class="form-control form-control-color border-0 @error('color_code') is-invalid @enderror" value="{{!empty($dataVal['color_code']) ? $dataVal['color_code'] : ''}}">

                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        @if($iterationCount == 0)
                                        <a href="javascript:;" data-repeater-create=""
                                            class="btn btn-teal-primary btn-border-down">
                                            <i class="la la-plus"></i>Add More Variant Value
                                        </a>
                                        <a href="javascript:;" data-repeater-delete=""
                                            class="btn btn-sm font-weight-bolder btn-light-danger"
                                            style="display:none;">
                                            <i class="la la-trash-o"></i>Delete Variant Value
                                        </a>
                                        @else
                                        <a href="javascript:;" data-repeater-create=""
                                            class="btn btn-teal-primary btn-border-down"
                                            style="display:none;">
                                            <i class="la la-plus"></i>Add More Variant Value
                                        </a>
                                        <a href="javascript:;" data-repeater-delete=""
                                            class="btn btn-sm font-weight-bolder btn-light-danger">
                                            <i class="la la-trash-o"></i>Delete Variant Value
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                @endif


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
                                    <div class="col-md-5 mb-3">
                                        <div class="form-group">
                                            <label for="name">Name</label><span class="text-danger">
                                                 </span>
                                            <input type="text" name="name"
                                                class="form-control form-control-solid form-control-lg variant-value @error('name') is-invalid @enderror"
                                                value="">

                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3 colorPickerIn"  style="display: none;">
                                        <div class="form-group">
                                            <label for="color">Color</label><span class="text-danger">
                                                 </span>
                                            <input type="text" name="color_code" id="color-picker"
                                                class="form-control form-control-color border-0 @error('color_code') is-invalid @enderror" value="#136ad0">

                                        </div>
                                    </div>



                                    <div class="col-md-2">
                                        <a href="javascript:;" data-repeater-create=""
                                            class="btn btn-sm font-weight-bolder btn btn-primary-light btn-border-down">
                                            <i class="la la-plus"></i>Add More Variant Value
                                        </a>
                                        <a href="javascript:;" data-repeater-delete=""
                                            class="btn btn-sm font-weight-bolder btn btn-danger-light btn-border-down"
                                            style="display:none;">
                                            <i class="la la-trash-o"></i>Delete Variant Value
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
<script src="{{ asset('assets/plugin/tagify/tagify.min.js') }}"></script>
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/js/sweet-alerts.js') }}"></script>
<script src="{{ asset('assets/js/repeater.js')}}"></script>
<script src="{{ asset('assets/js/custom/variants.js')}}"></script>
<!-- <script src="{{ asset('assets/js/form-validation.js') }}"></script> -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#name').on('input', function() {
            var name = $(this).val().toLowerCase();

            // Check if the name contains "color" or "Color"
            if (name.toString() === 'color') {
                $('.colorPickerIn').show();
            } else {
                $('.colorPickerIn').hide();
            }
        });

        // // Event listener for the color picker
        // $(document).on('change', 'input[name="color_code"]', function() {
        //     var selectedColor = $(this).val();
            
        //     // Find the corresponding "Name" input field within the same block
        //     var nameInput = $(this).closest('.form-group').find('.variant-value');

        //     // Set the value of the "Name" field to the selected color
        //     nameInput.val(selectedColor);

        //     // Check if the value was updated
        //     alert(nameInput.val());
        // });
        
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pickr = Pickr.create({
            el: '#color-picker',
            theme: 'classic', // You can change the theme if needed
            useAsButton: true,
            swatches: [
                'rgba(244, 67, 54, 1)',
                'rgba(233, 30, 99, 0.95)',
                'rgba(156, 39, 176, 0.9)',
                'rgba(103, 58, 183, 0.85)',
                'rgba(63, 81, 181, 0.8)',
                'rgba(33, 150, 243, 0.75)',
                'rgba(3, 169, 244, 0.7)',
                'rgba(0, 188, 212, 0.7)',
                'rgba(0, 150, 136, 0.7)',
                'rgba(76, 175, 80, 0.7)',
                'rgba(139, 195, 74, 0.7)',
                'rgba(205, 220, 57, 0.8)',
                'rgba(255, 235, 59, 0.9)',
                'rgba(255, 193, 7, 1)'
            ],
            components: {
                preview: true,
                opacity: true,
                hue: true,
                interaction: {
                    hex: true,
                    rgba: true,
                    hsla: true,
                    hsva: true,
                    cmyk: true,
                    input: true,
                    clear: true,
                    save: true
                }
            }
        });
    });
</script>

@endpush