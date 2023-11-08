@extends('admin.layout.master')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/libs/dropzone/dropzone.css') }}">
<link href="{{ asset('assets/plugin/tagify/tagify.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
@endpush
<style>
.uploaded-images-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.uploaded-image {
    position: relative;
}

.uploaded-image img {
    max-width: 100px;
    /* Adjust image width */
    max-height: 100px;
    /* Adjust image height */
}

.remove-icon {
    position: absolute;
    top: 0;
    right: 0;
    cursor: pointer;
    color: red;
    /* Adjust icon color */
}

.portfolioPicContainer {
  height: 100px;
  width: 100px;
  background-color: #404040;
}

  .portfolioPicContainerImg {
    height: 100%;
    width: 100%;
    object-fit: contain;
    object-position: center;
  }
  .closePortImgBtn{padding:0 !important;height:15px;width:15px;font-size:15px}
  .portfolioImgAciveInput{width:2em !important;height:1.2em !important}.portfolioImgAciveLabel{font-size:12px !important}

</style>

@section('content')
<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <a class="btn btn-dark" href="{{ url()->previous() }}">Back</a>
    <div class="ms-md-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Product</li>
            </ol>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title"> Create Product </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <ul class="nav nav-tabs flex-column vertical-tabs-2" role="tablist">
                            <li class="nav-item" role="presentation"> <a class="nav-link active" data-bs-toggle="tab"
                                    role="tab" aria-current="page" href="#basicInformationTab" aria-selected="false"
                                    tabindex="-1">
                                    <p class="mb-1"><i class="ri-home-4-line"></i></p>
                                    <p class="mb-0 text-break">Basic Information</p>
                                </a> </li>
                            <li class="nav-item" role="presentation"> <a class="nav-link" href="#detailsTab">
                                    <p class="mb-1"><i class="ri-phone-line"></i></p>
                                    <p class="mb-0 text-break">Details</p>
                                </a> </li>
                            <li class="nav-item" role="presentation"> <a class="nav-link " href="#pricesTab">
                                    <p class="mb-1"><i class="ri-customer-service-line"></i></p>
                                    <p class="mb-0 text-break">Prices</p>
                                </a> </li>
                            <li class="nav-item" role="presentation"> <a class="nav-link " href="javascript:void(0);">
                                    <p class="mb-1"><i class="ri-customer-service-line"></i></p>
                                    <p class="mb-0 text-break">Specifications</p>
                                </a> </li>
                            <li class="nav-item" role="presentation"> <a class="nav-link " href="javascript:void(0);">
                                    <p class="mb-1"><i class="ri-customer-service-line"></i></p>
                                    <p class="mb-0 text-break">Shipping Specifications</p>
                                </a> </li>
                            <li class="nav-item" role="presentation"> <a class="nav-link " href="javascript:void(0);">
                                    <p class="mb-1"><i class="ri-customer-service-line"></i></p>
                                    <p class="mb-0 text-break">Medias</p>
                                </a> </li>
                            <li class="nav-item" role="presentation"> <a class="nav-link " href="javascript:void(0);">
                                    <p class="mb-1"><i class="ri-customer-service-line"></i></p>
                                    <p class="mb-0 text-break">Variants</p>
                                </a> </li>
                            <!-- <li class="nav-item" role="presentation"> <a class="nav-link " href="javascript:void(0);">
                                    <p class="mb-1"><i class="ri-customer-service-line"></i></p>
                                    <p class="mb-0 text-break">Advance SEO </p>
                                </a> </li> -->
                        </ul>
                    </div>
                    <div class="col-md-10">
                        <div class="tab-content">
                            <div class="tab-pane text-muted active show" data-next-tab="detailsTab" data-prev-tab=""
                                id="basicInformationTab" role="tabpanel">
                                <form id="basicInformationTabForm">
                                    <div class="row gx-5">
                                        <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                                            <div class="card custom-card shadow-none mb-0 border-0">
                                                <div class="card-body p-0">
                                                    <div class="row gy-3">
                                                        <div class="col-xl-12">
                                                            <label for="product-name-add" class="form-label"><span
                                                                    class="text-danger">* </span>Product Name</label>
                                                            <input type="text" class="form-control" id="name"
                                                                name="name" placeholder="Enter Name"
                                                                onkeyup="displaySlug($(this))">
                                                                <div class="invalid-feedback fw-bold"></div>
                                                            <h6 class="product-slug mt-2"></h6>
                                                        </div>
                                                        <div class="col-xl-12 select2-error">
                                                            <label for="category_id" class="form-label"><span
                                                                    class="text-danger">*
                                                                </span>Category</label>
                                                            <select
                                                                class="js-example-placeholder-single js-states form-control"
                                                                name="category_id" id="category_id"
                                                                data-action="{{ route('admin-product-sub-category-list') }}">
                                                                <option value="" selected>None</option>
                                                                @forelse ($categories as $category)
                                                                <option value="{{ $category->id }}">
                                                                    {{ $category->name }}
                                                                </option>
                                                                @empty
                                                                <option value="" selected>No Data found</option>
                                                                @endforelse
                                                            </select>
                                                            <div class="invalid-feedback fw-bold"></div>
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <label for="product-size-add" class="form-label">Child
                                                                Category</label>
                                                            <select
                                                                class="js-example-placeholder-single js-states form-control"
                                                                name="child_category_id" id="child_category_id">
                                                                <option value="" selected>None</option>
                                                            </select>
                                                            <div class="invalid-feedback fw-bold"></div>
                                                        </div>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                                            <div class="card custom-card shadow-none mb-0 border-0">
                                                <div class="card-body p-0">
                                                    <div class="row gy-4">
                                                        <div class="col-xl-12">
                                                            <label for="bar_code" class="form-label"><span
                                                                    class="text-danger">* </span>Bar Code</label>
                                                            <input type="text" class="form-control" id="bar_code"
                                                                name="bar_code" placeholder="Enter Bar Code">
                                                                <div class="invalid-feedback fw-bold"></div>

                                                        </div>
                                                        <div class="col-xl-12">
                                                            {{-- <div id="sub_categegory_select"></div> --}}
                                                            <label for="sub_category_id" class="form-label">Sub
                                                                Category</label>
                                                            <select
                                                                class="js-example-placeholder-single js-states form-control"
                                                                name="sub_category_id" id="sub_category_id"
                                                                data-action="{{ route('admin-product-child-category-list') }}">
                                                                <option value="" selected>None</option>
                                                            </select>
                                                            <div class="invalid-feedback fw-bold"></div>
                                                        </div>
                                                        <div class="col-xl-12 select2-error">
                                                            <label for="brand_id" class="form-label"><span
                                                                    class="text-danger">*
                                                                </span>Brand</label>
                                                            <select
                                                                class="js-example-placeholder-single js-states form-control"
                                                                name="brand_id" id="brand_id">
                                                                <option value="" selected>None</option>
                                                                @forelse ($brands as $brand)
                                                                <option value="{{ $brand->id }}">{{ $brand->name }}
                                                                </option>
                                                                @empty
                                                                <option value="" selected>No Data found</option>
                                                                @endforelse
                                                            </select>
                                                            <div class="invalid-feedback fw-bold"></div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div
                                        class="py-3 border-top border-block-start-dashed d-sm-flex justify-content-end">
                                        <button type="button" class="btn btn-primary" id="actionBtn" data-action="next"
                                            data-current-tab="basicInformationTab">Next</button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane text-muted" id="detailsTab" data-next-tab="pricesTab"
                                data-prev-tab="basicInformationTab" role="tabpanel">
                                <form id="detailsTabForm" class="row gx-5 gy-5">
                                    <div class="col-xl-12">
                                        <label for="description" class="form-label"><span class="text-danger">
                                            </span>Short Description</label>
                                        <textarea class="form-control" name="short_description" id="short_description"
                                            cols="20" rows="5"></textarea>
                                            <div class="invalid-feedback fw-bold"></div>
                                    </div>
                                    <div class="col-xl-12">
                                        <label for="long_description" class="form-label"><span class="text-danger">*
                                            </span>Long Description</label>
                                        <textarea class="form-control" name="long_description" id="long_description"
                                            cols="30" rows="5"></textarea>
                                            <div class="invalid-feedback fw-bold"></div>
                                    </div>
                                    <div class="col-xl-12">
                                        <label for="return_policy" class="form-label"><span class="text-danger">
                                            </span>Return Policy</label>
                                        <textarea class="form-control" name="return_policy" id="return_policy" cols="20"
                                            rows="5"></textarea>
                                            <div class="invalid-feedback fw-bold"></div>
                                    </div>
                                    <div class="col-xl-12">
                                        <label for="seller_information" class="form-label"><span class="text-danger">
                                            </span>Seller Information</label>
                                        <textarea class="form-control" name="seller_information" id="seller_information"
                                            cols="20" rows="5"></textarea>
                                            <div class="invalid-feedback fw-bold"></div>
                                    </div>
                                    <div
                                        class="py-3 border-top border-block-start-dashed d-sm-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary" id="actionBtn" data-action="next"
                                            data-current-tab="detailsTab">Next</button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane text-muted" id="pricesTab" data-next-tab="specificationsTab"
                                data-prev-tab="detailsTab" role="tabpanel">
                                <form id="pricesTabForm" class="row gx-5">
                                    <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                                        <div class="card custom-card shadow-none mb-0 border-0">
                                            <div class="card-body p-0">
                                                <div class="row gy-3">
                                                    <div class="col-xl-12">
                                                        <label for="buying_price" class="form-label"><span
                                                                class="text-danger">* </span>Buying Price</label>
                                                        <input type="text" class="form-control" id="buying_price"
                                                            name="buying_price" placeholder="Enter Buying Price">

                                                            <div class="invalid-feedback fw-bold"></div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                                        <div class="card custom-card shadow-none mb-0 border-0">
                                            <div class="card-body p-0">
                                                <div class="row gy-4">
                                                    <div class="col-xl-12">
                                                        <label for="selling_price" class="form-label"><span
                                                                class="text-danger">* </span>Selling Price</label>
                                                        <input type="text" class="form-control" id="selling_price"
                                                            name="selling_price" placeholder="Enter Selling Price">
                                                            <div class="invalid-feedback fw-bold"></div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="py-3 border-top border-block-start-dashed d-sm-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary" id="actionBtn" data-action="next"
                                            data-current-tab="pricesTab">Next</button>
                                    </div>

                                </form>
                            </div>
                            <div class="tab-pane text-muted" id="specificationsTab"
                                data-next-tab="shippingSpecificationsTab" data-prev-tab="pricesTab" role="tabpanel">
                                <form id="specificationsTabForm" class="row gx-5">
                                    <div
                                        class="py-3 border-top border-block-start-dashed d-sm-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary" id="actionBtn" data-action="next"
                                            data-current-tab="specificationsTab">Next</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane text-muted" id="shippingSpecificationsTab" data-next-tab="mediasTab"
                                data-prev-tab="specificationsTab" role="tabpanel">
                                <form id="shippingSpecificationsTabForm" class="row gx-5">
                                    <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                                        <div class="card custom-card shadow-none mb-0 border-0">
                                            <div class="card-body p-0">
                                                <div class="row gy-3">
                                                    <div class="col-xl-12">
                                                        <label for="height" class="form-label"><span
                                                                class="text-danger">*
                                                            </span>Height</label>
                                                        <input type="text" class="form-control" id="height"
                                                            name="height" placeholder="Height">

                                                    </div>
                                                    <div class="col-xl-12">
                                                        <label for="width" class="form-label"><span
                                                                class="text-danger">*
                                                            </span>Width</label>
                                                        <input type="text" class="form-control" id="width" name="width"
                                                            placeholder="Width">

                                                    </div>
                                                    <div class="col-xl-12">
                                                        <label for="dc" class="form-label"><span class="text-danger">*
                                                            </span>DC</label>
                                                        <input type="text" class="form-control" id="dc" name="dc"
                                                            placeholder="DC">

                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                                        <div class="card custom-card shadow-none mb-0 border-0">
                                            <div class="card-body p-0">
                                                <div class="row gy-4">
                                                    <div class="col-xl-12">
                                                        <label for="weight" class="form-label"><span
                                                                class="text-danger">*
                                                            </span>Weight</label>
                                                        <input type="text" class="form-control" id="weight"
                                                            name="weight" placeholder="Weight">

                                                    </div>
                                                    <div class="col-xl-12">
                                                        <label for="length" class="form-label"><span
                                                                class="text-danger">*
                                                            </span>Length</label>
                                                        <input type="text" class="form-control" id="length"
                                                            name="length" placeholder="Length">

                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="py-3 border-top border-block-start-dashed d-sm-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary" id="actionBtn" data-action="next"
                                            data-current-tab="shippingSpecificationsTab">Next</button>
                                    </div>

                                </form>
                            </div>
                            <div class="tab-pane text-muted" id="mediasTab" data-next-tab="variantsTab"
                                data-prev-tab="shippingSpecificationsTab" role="tabpanel">
                                <div class="row gx-5">
                                    <div id="imageDropzone" class="dropzone">Drop files here to upload</div>
                                    <div id="uploadedImagesContainer" class="uploaded-images-container row p-3 text-center"></div>

                                    <div
                                        class="py-3 border-top border-block-start-dashed d-sm-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary" id="actionBtn" data-action="next"
                                            data-current-tab="mediasTab">Next</button>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane text-muted" id="variantsTab" data-next-tab="" data-prev-tab="mediasTab"
                                role="tabpanel">
                                <form id="variantsTabForm" class="row gx-5">
                                    <div
                                        class="py-3 border-top border-block-start-dashed d-sm-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary" id="actionBtn" data-action="next"
                                            data-current-tab="variantsTab">Next</button>
                                    </div>
                                </form>
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
<!-- Select2 Cdn -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/plugin/tagify/tagify.min.js') }}"></script>

<!-- Internal Select-2.js -->
<script src="{{ asset('assets/js/select2.js') }}"></script>

<script src="{{ asset('assets/libs/dropzone/dropzone-min.js') }}"></script>

<script src="{{ asset('assets/js/custom/product.js') }}"></script>
<script src="{{ asset('assets/js/repeater.js')}}"></script>

{{-- <script src="{{ asset('assets/js/fileupload.js') }}"></script> --}}
<script src="{{ asset('assets/plugin/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/form-validation.js') }}"></script>
<script>
CKEDITOR.replace(<?php echo 'long_description'; ?>, {
    filebrowserUploadUrl: '<?php echo URL()->to('base/uploder'); ?>',
    enterMode: CKEDITOR.ENTER_BR
});
CKEDITOR.replace(<?php echo 'short_description'; ?>, {
    filebrowserUploadUrl: '<?php echo URL()->to('base/uploder'); ?>',
    enterMode: CKEDITOR.ENTER_BR
});
CKEDITOR.replace(<?php echo 'return_policy'; ?>, {
    filebrowserUploadUrl: '<?php echo URL()->to('base/uploder'); ?>',
    enterMode: CKEDITOR.ENTER_BR
});
CKEDITOR.replace(<?php echo 'seller_information'; ?>, {
    filebrowserUploadUrl: '<?php echo URL()->to('base/uploder'); ?>',
    enterMode: CKEDITOR.ENTER_BR
});
CKEDITOR.config.allowedContent = true;


Dropzone.autoDiscover = false;
const myDropzone = new Dropzone("#imageDropzone", {
    url: "/your-upload-endpoint",
    autoProcessQueue: false,
    maxFiles: 10, // Adjust the maximum number of files allowed

    init: function() {
        this.on("addedfile", function(file) {
            file.previewElement.remove();
            const reader = new FileReader();
            reader.onload = function(e) {
                const imageUrl = e.target.result; // Get the image URL
                const imageElement = document.createElement('div');
                imageElement.classList.add('uploaded-image');
                imageElement.classList.add('col-auto');
                imageElement.innerHTML = `
               
<div class="img-wrap rounded-2 mb-3 portfolioPicContainer"><span class="close removePortfolioImage closePortImgBtn d-flex align-items-center justify-content-center remove-icon" data-image-url="${imageUrl}">&times;</span><img src="${imageUrl}" alt="${file.name}" class="card-img rounded-2 portfolioPicContainerImg"  /></div>
<div class="form-check form-switch ">
  <input class="form-check-input  "  type="radio" id="frontImage" name="frontImage" value="${imageUrl}" checked}}>
  <label class="form-check-label " for="frontImage">Front Image</label>
</div>
<div class="form-check form-switch ">
  <input class="form-check-input  "  type="radio" id="backImage" name="backImage" value="${imageUrl}" checked}}>
  <label class="form-check-label " for="backImage" >Back Image</label>
</div>


                
                
                `;
                document.getElementById('uploadedImagesContainer').appendChild(imageElement);

                const radioButtons = imageElement.querySelectorAll('.image-radio');
                radioButtons.forEach(radio => {
                    radio.addEventListener('change', function(e) {
                        const name = e.target.name;
                        const value = e.target.value;
                        if (name === 'frontImage') {
                            document.querySelectorAll('[name="frontImage"]')
                                .forEach(item => {
                                    if (item.value !== value) {
                                        item.checked = false;
                                    }
                                });
                        } else if (name === 'backImage') {
                            document.querySelectorAll('[name="backImage"]')
                                .forEach(item => {
                                    if (item.value !== value) {
                                        item.checked = false;
                                    }
                                });
                        }
                    });
                });

                const removeIcons = imageElement.querySelectorAll('.remove-icon');
                removeIcons.forEach(icon => {
                    icon.addEventListener('click', function(e) {
                        const imageUrl = e.target.getAttribute(
                            'data-image-url'
                        ); // Get the image URL from the data attribute
                        const file = urlToFileMap.get(
                            imageUrl); // Find the file by URL from the map
                        if (file) {
                            myDropzone.removeFile(file);
                            urlToFileMap.delete(
                                imageUrl); // Remove the file URL from the map
                        }
                        e.target.parentElement.remove();
                    });
                });

                urlToFileMap.set(imageUrl, file); // Store the file in the map with its URL
            };
            reader.readAsDataURL(file);
        });
    }
});

const urlToFileMap = new Map();

// document.getElementById('submitBtnImages').addEventListener('click', function(event) {
//     event.preventDefault();
//     const formData = new FormData();

//     const frontImageURL = document.querySelector('input[name="frontImage"]:checked').value;
//     const backImageURL = document.querySelector('input[name="backImage"]:checked').value;

//     const frontImageIndex = [...urlToFileMap.keys()].findIndex(url => url === frontImageURL);
//     const backImageIndex = [...urlToFileMap.keys()].findIndex(url => url === backImageURL);

//     if (frontImageIndex !== -1 && backImageIndex !== -1) {
//         formData.append('frontImage', frontImageIndex);
//         formData.append('backImage', backImageIndex);

//         urlToFileMap.forEach((file, url) => {
//             formData.append('images[]', file);
//         });

//         fetch("{{ route('admin-product-store') }}", {
//                 method: 'POST',
//                 body: formData,
//                 headers: {
//                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 }
//             })
//             .then(response => response.json())
//             .then(data => {
//                 console.log(data);
//                 // Handle response or redirect after successful upload
//             })
//             .catch(error => {
//                 console.error('Error:', error);
//                 // Handle errors
//             });
//     } else {
//         console.error('Front or back image index not found.');
//     }
// });

$(document).on('click', '#actionBtn', function(e) {
    e.preventDefault();
    if ($(this).attr('data-action') && $(this).attr('data-action') == 'next') {
        $btnName = 'Next';
        $loadingText = 'Processing...';
        $(this).prop('disabled', true);
        $(this).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> ' +
            $loadingText);
        const that = this;
        var formData = new FormData($('#' + $(this).attr('data-current-tab') + 'Form')[0]);
        formData.append('current_tab' , $(this).attr('data-current-tab'));
        if ($(this).attr('data-current-tab') == 'basicInformationTab') {
            $.ajax({
                url: "{{ route('admin-product-store') }}",
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $("#loader_img").hide();
                    $('.invalid-feedback').html("");
                    $('.invalid-feedback').removeClass("error");
                    $('.is-invalid').removeClass("is-invalid");

                    error_array = JSON.stringify(response);
                    datas = JSON.parse(error_array);
                    if (datas['status'] == 'success') {
                        $nextTab = $(that).parents('.tab-pane').attr('data-next-tab');
                        $('.nav-link').removeClass('active');
                        $('.tab-pane').removeClass('active show');
                        $('.tab-pane[id='+$nextTab+']').addClass('active show');
                        $('.nav-link[href="#'+$nextTab+'"]').addClass('active');
                    } else {
                        if (datas['status'] == 'error' && datas['errors']) {
                            $.each(datas['errors'], function(index, html) {
                                if (index == 'description') {
                                    $("textarea[name = " + index + "]").addClass(
                                        'is-invalid');
                                    $("textarea[name = " + index + "]").next().addClass(
                                        'error');
                                    $("textarea[name = " + index + "]").next().html(html);
                                    $("textarea[name = " + index + "]").show();
                                } else if (index == 'category_id' || index ==
                                    'sub_category_id' || index == 'child_category_id' || index ==
                                    'brand_id') {
                                    $("select[name = " + index + "]").addClass(
                                    'is-invalid');
                                    $("select[name = " + index + "]").next()
                                        .next().addClass('error');
                                    $("select[name = " + index + "]").next()
                                        .next().html(html);
                                    $("select[name = " + index + "]").next()
                                        .next().show();
                                    // $("select[name = " + index + "]").show();
                                } else if (index == 'profile_pic') {
                                    $("input[name = " + index + "]").addClass('is-invalid');
                                    $("input[name = " + index + "]").parent().next().next()
                                        .addClass('error');
                                    $("input[name = " + index + "]").parent().next().next()
                                        .html(html);
                                    $("input[name = " + index + "]").parent().next().next()
                                        .show();
                                    $("input[name = " + index + "]").show();
                                } else if (index == 'gender') {
                                    $("select[name = " + index + "]").addClass(
                                    'is-invalid');
                                    $("select[name = " + index + "]").parents('.choices')
                                        .next().addClass('error');
                                    $("select[name = " + index + "]").parents('.choices')
                                        .next().html(html);
                                    $("select[name = " + index + "]").parents('.choices')
                                        .next().show();
                                    $("select[name = " + index + "]").show();
                                } else if (index == 'date_of_birth') {
                                    $("input[name = " + index + "]").addClass('is-invalid');
                                    $("input[name = " + index + "]").next().addClass(
                                        'error');
                                    $("input[name = " + index + "]").next().html(html);
                                    $("input[name = " + index + "]").next().show();
                                    $("input[name = " + index + "]").show();
                                } else if (index ==
                                    'are_you_working_on_any_other_online_portal') {
                                    $("input[name = " + index + "]").addClass('is-invalid');
                                    $("input[name = " + index + "]").parent().next()
                                        .addClass('error');
                                    $("input[name = " + index + "]").parent().next().html(
                                        html);
                                    $("input[name = " + index + "]").parent().next().show();
                                    $("input[name = " + index + "]").show();
                                } else {

                                    $("input[name = " + index + "]").addClass('is-invalid');
                                    $("input[name = " + index + "]").next().addClass(
                                        'error');
                                    $("input[name = " + index + "]").next().html(html);
                                    $("input[name = " + index + "]").show();
                                }


                            });
                        } else if (datas['status'] == 'error') {
                            show_message(datas['msg'], 'error');
                        } else {
                            show_message(datas, 'error');
                        }


                    }
                    $(that).prop('disabled', false);
                    $(that).text($btnName);
                },
                error: function(xhr, status, errorThrown) {
                    if (xhr.responseJSON && xhr.responseJSON.status) {
                        if (xhr.responseJSON.status == 'error') {

                            show_message(xhr.responseJSON.msg, 'error');
                        } else {
                            show_message(xhr.responseJSON, 'error');
                        }
                    } else {
                        show_message(xhr.responseText, 'error');
                    }
                    $(that).prop('disabled', false);
                    $(that).text($btnName);

                }
            });

        }else if ($(this).attr('data-current-tab') == 'detailsTab') {
            var long_description = CKEDITOR.instances.long_description.getData();
            var return_policy = CKEDITOR.instances.return_policy.getData();
            var seller_information = CKEDITOR.instances.seller_information.getData();
            var short_description = CKEDITOR.instances.short_description.getData();

            formData.append('long_description',long_description);
            formData.append('return_policy',return_policy);
            formData.append('seller_information',seller_information);
            formData.append('short_description',short_description);
            
            $.ajax({
                url: "{{ route('admin-product-store') }}",
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $("#loader_img").hide();
                    $('.invalid-feedback').html("");
                    $('.invalid-feedback').removeClass("error");
                    $('.is-invalid').removeClass("is-invalid");

                    error_array = JSON.stringify(response);
                    datas = JSON.parse(error_array);
                    if (datas['status'] == 'success') {
                        $nextTab = $(that).parents('.tab-pane').attr('data-next-tab');
                        $('.nav-link').removeClass('active');
                        $('.tab-pane').removeClass('active show');
                        $('.tab-pane[id='+$nextTab+']').addClass('active show');
                        $('.nav-link[href="#'+$nextTab+'"]').addClass('active');
                    } else {
                        if (datas['status'] == 'error' && datas['errors']) {
                            $.each(datas['errors'], function(index, html) {
                                if (index == 'long_description' || index == 'short_description' || index == 'return_policy' || index == 'seller_information') {
                                    $("textarea[name = " + index + "]").addClass(
                                        'is-invalid');
                                    $("textarea[name = " + index + "]").next().next().addClass(
                                        'error');
                                    $("textarea[name = " + index + "]").next().next().html(html);
                                    $("textarea[name = " + index + "]").next().next().show();
                                } else if (index == 'category_id' || index ==
                                    'sub_category_id' || index == 'child_category_id' || index ==
                                    'brand_id') {
                                    $("select[name = " + index + "]").addClass(
                                    'is-invalid');
                                    $("select[name = " + index + "]").next()
                                        .next().addClass('error');
                                    $("select[name = " + index + "]").next()
                                        .next().html(html);
                                    $("select[name = " + index + "]").next()
                                        .next().show();
                                    // $("select[name = " + index + "]").show();
                                } else if (index == 'profile_pic') {
                                    $("input[name = " + index + "]").addClass('is-invalid');
                                    $("input[name = " + index + "]").parent().next().next()
                                        .addClass('error');
                                    $("input[name = " + index + "]").parent().next().next()
                                        .html(html);
                                    $("input[name = " + index + "]").parent().next().next()
                                        .show();
                                    $("input[name = " + index + "]").show();
                                } else if (index == 'gender') {
                                    $("select[name = " + index + "]").addClass(
                                    'is-invalid');
                                    $("select[name = " + index + "]").parents('.choices')
                                        .next().addClass('error');
                                    $("select[name = " + index + "]").parents('.choices')
                                        .next().html(html);
                                    $("select[name = " + index + "]").parents('.choices')
                                        .next().show();
                                    $("select[name = " + index + "]").show();
                                } else if (index == 'date_of_birth') {
                                    $("input[name = " + index + "]").addClass('is-invalid');
                                    $("input[name = " + index + "]").next().addClass(
                                        'error');
                                    $("input[name = " + index + "]").next().html(html);
                                    $("input[name = " + index + "]").next().show();
                                    $("input[name = " + index + "]").show();
                                } else if (index ==
                                    'are_you_working_on_any_other_online_portal') {
                                    $("input[name = " + index + "]").addClass('is-invalid');
                                    $("input[name = " + index + "]").parent().next()
                                        .addClass('error');
                                    $("input[name = " + index + "]").parent().next().html(
                                        html);
                                    $("input[name = " + index + "]").parent().next().show();
                                    $("input[name = " + index + "]").show();
                                } else {

                                    $("input[name = " + index + "]").addClass('is-invalid');
                                    $("input[name = " + index + "]").next().addClass(
                                        'error');
                                    $("input[name = " + index + "]").next().html(html);
                                    $("input[name = " + index + "]").show();
                                }


                            });
                        } else if (datas['status'] == 'error') {
                            show_message(datas['msg'], 'error');
                        } else {
                            show_message(datas, 'error');
                        }


                    }
                    $(that).prop('disabled', false);
                    $(that).text($btnName);
                },
                error: function(xhr, status, errorThrown) {
                    if (xhr.responseJSON && xhr.responseJSON.status) {
                        if (xhr.responseJSON.status == 'error') {

                            show_message(xhr.responseJSON.msg, 'error');
                        } else {
                            show_message(xhr.responseJSON, 'error');
                        }
                    } else {
                        show_message(xhr.responseText, 'error');
                    }
                    $(that).prop('disabled', false);
                    $(that).text($btnName);

                }
            });

        }else if ($(this).attr('data-current-tab') == 'pricesTab') {
            
            $.ajax({
                url: "{{ route('admin-product-store') }}",
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $("#loader_img").hide();
                    $('.invalid-feedback').html("");
                    $('.invalid-feedback').removeClass("error");
                    $('.is-invalid').removeClass("is-invalid");

                    error_array = JSON.stringify(response);
                    datas = JSON.parse(error_array);
                    if (datas['status'] == 'success') {
                        $('#specificationsTabForm').html(datas['data']);
                        $nextTab = $(that).parents('.tab-pane').attr('data-next-tab');
                        $('.nav-link').removeClass('active');
                        $('.tab-pane').removeClass('active show');
                        $('.tab-pane[id='+$nextTab+']').addClass('active show');
                        $('.nav-link[href="#'+$nextTab+'"]').addClass('active');
                    } else {
                        if (datas['status'] == 'error' && datas['errors']) {
                            $.each(datas['errors'], function(index, html) {
                                if (index == 'long_description' || index == 'short_description' || index == 'return_policy' || index == 'seller_information') {
                                    $("textarea[name = " + index + "]").addClass(
                                        'is-invalid');
                                    $("textarea[name = " + index + "]").next().next().addClass(
                                        'error');
                                    $("textarea[name = " + index + "]").next().next().html(html);
                                    $("textarea[name = " + index + "]").next().next().show();
                                } else if (index == 'category_id' || index ==
                                    'sub_category_id' || index == 'child_category_id' || index ==
                                    'brand_id') {
                                    $("select[name = " + index + "]").addClass(
                                    'is-invalid');
                                    $("select[name = " + index + "]").next()
                                        .next().addClass('error');
                                    $("select[name = " + index + "]").next()
                                        .next().html(html);
                                    $("select[name = " + index + "]").next()
                                        .next().show();
                                    // $("select[name = " + index + "]").show();
                                } else if (index == 'profile_pic') {
                                    $("input[name = " + index + "]").addClass('is-invalid');
                                    $("input[name = " + index + "]").parent().next().next()
                                        .addClass('error');
                                    $("input[name = " + index + "]").parent().next().next()
                                        .html(html);
                                    $("input[name = " + index + "]").parent().next().next()
                                        .show();
                                    $("input[name = " + index + "]").show();
                                } else if (index == 'gender') {
                                    $("select[name = " + index + "]").addClass(
                                    'is-invalid');
                                    $("select[name = " + index + "]").parents('.choices')
                                        .next().addClass('error');
                                    $("select[name = " + index + "]").parents('.choices')
                                        .next().html(html);
                                    $("select[name = " + index + "]").parents('.choices')
                                        .next().show();
                                    $("select[name = " + index + "]").show();
                                } else if (index == 'date_of_birth') {
                                    $("input[name = " + index + "]").addClass('is-invalid');
                                    $("input[name = " + index + "]").next().addClass(
                                        'error');
                                    $("input[name = " + index + "]").next().html(html);
                                    $("input[name = " + index + "]").next().show();
                                    $("input[name = " + index + "]").show();
                                } else if (index ==
                                    'are_you_working_on_any_other_online_portal') {
                                    $("input[name = " + index + "]").addClass('is-invalid');
                                    $("input[name = " + index + "]").parent().next()
                                        .addClass('error');
                                    $("input[name = " + index + "]").parent().next().html(
                                        html);
                                    $("input[name = " + index + "]").parent().next().show();
                                    $("input[name = " + index + "]").show();
                                } else {

                                    $("input[name = " + index + "]").addClass('is-invalid');
                                    $("input[name = " + index + "]").next().addClass(
                                        'error');
                                    $("input[name = " + index + "]").next().html(html);
                                    $("input[name = " + index + "]").show();
                                }


                            });
                        } else if (datas['status'] == 'error') {
                            show_message(datas['msg'], 'error');
                        } else {
                            show_message(datas, 'error');
                        }


                    }
                    $(that).prop('disabled', false);
                    $(that).text($btnName);
                },
                error: function(xhr, status, errorThrown) {
                    if (xhr.responseJSON && xhr.responseJSON.status) {
                        if (xhr.responseJSON.status == 'error') {

                            show_message(xhr.responseJSON.msg, 'error');
                        } else {
                            show_message(xhr.responseJSON, 'error');
                        }
                    } else {
                        show_message(xhr.responseText, 'error');
                    }
                    $(that).prop('disabled', false);
                    $(that).text($btnName);

                }
            });

        }
    } else if ($(this).attr('data-action') && $(this).attr('data-action') == 'prev') {

    }



});

$('#specificationValuesSelect').select2({
    // tags: true,
    placeholder: 'Select Values',
    tokenSeparators: [',', ' '], // Separate tags by comma or space
    createTag: function(params) {
        return {
            id: params.term,
            text: params.term,
            newTag: true
        };
    }
});
</script>
@endpush