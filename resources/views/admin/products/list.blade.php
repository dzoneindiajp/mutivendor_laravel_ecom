@extends('admin.layout.master')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endpush

@section('content')

@include('admin.layout.response_message')
<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <h1 class="page-title fw-semibold fs-18 mb-0">Products</h1>
    <div class="ms-md-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Products</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Products
                </div>
                <div class="prism-toggle">
                    <a href="javascript:void(0);" class="btn btn-primary dropdown-toggle mr-2" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne6">
                        Search
                    </a>
                    <a href="{{ route('admin-product-create') }}" class="btn btn-primary"
                        style="margin-right: 10px;">Add
                        Product</a>
                </div>
            </div>
            <div class="card-body">
                <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample6">
                    <div id="collapseOne6" class="collapse m-3 <?php echo !empty($searchVariable) ? 'show' : ''; ?>"
                        data-parent="#accordionExample6">
                        <div>
                            <form id="listSearchForm" class="row mb-6">

                                <div class="col-lg-3 mb-lg-5 mb-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder=" Name"
                                        value="{{$searchVariable['name'] ?? '' }}">
                                </div>
                                <div class="col-lg-3 select2-error">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select class="js-example-placeholder-single js-states form-control"
                                        name="category_id" id="category_id"
                                        data-action="{{ route('admin-product-sub-category-list') }}">
                                        <option value="" selected>None</option>
                                        @forelse ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @empty
                                        <option value="" selected>No Data found</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    {{-- <div id="sub_categegory_select"></div> --}}
                                    <label for="sub_category_id" class="form-label">Sab Category</label>
                                    <select class="js-example-placeholder-single js-states form-control"
                                        name="sub_category_id" id="sub_category_id"
                                        data-action="{{ route('admin-product-child-category-list') }}">
                                        <option value="" selected>None</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="product-size-add" class="form-label">Child Category</label>
                                    <select class="js-example-placeholder-single js-states form-control"
                                        name="child_category_id" id="child_category_id">
                                        <option value="" selected>None</option>
                                    </select>
                                </div>

                                <div class="col-lg-3 mb-lg-5 mb-6">
                                    <label for="date_from" class="form-label">Date
                                        From</label>
                                    <input type="date" class="form-control @error('date_from') is-invalid @enderror"
                                        id="date_from" name="date_from" placeholder="Date From">

                                </div>
                                <div class="col-lg-3 mb-lg-5 mb-6">
                                    <label for="date_to" class="form-label">Date
                                        To</label>
                                    <input type="date" class="form-control @error('date_to') is-invalid @enderror"
                                        id="date_to" name="date_to" placeholder="Date To">

                                </div>


                            </form>
                            <div class="row mt-8">
                                <div class="col-lg-12">
                                    <button class="btn btn-primary btn-primary--icon" id="kt_search_btn">
                                        <span>
                                            <i class="la la-search"></i>
                                            <span>Search</span>
                                        </span>
                                    </button>
                                    &nbsp;&nbsp;
                                    <a href='{{ route($listRouteName)}}' class="btn btn-secondary btn-secondary--icon">
                                        <span>
                                            <i class="la la-close"></i>
                                            <span>Clear Search</span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>

                <div class="container mt-4">
                    <button type="button" class="btn btn-outline-primary my-1 me-2" fdprocessedid="g9dg58f"> Total
                        Products:
                        <span class="badge ms-2 totalDataCount">{{ $totalResults ?? 0 }}</span> </button>

                </div>
                <table id="datatable-basic" data-sorting="" data-order="" class="table table-bordered text-nowrap"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th class="sortable" data-column="products.name">Name <i class="sort-icon ri-sort-asc"></i></th>
                            <th class="sortable" data-column="category_name">Category <i class="sort-icon ri-sort-asc"></i></th>
                            <th class="sortable" data-column="sub_category_name">Sub Category <i class="sort-icon ri-sort-asc"></i>
                            </th>
                            <th class="sortable" data-column="child_category_name">Child Category <i class="sort-icon ri-sort-asc"></i>
                            </th>
                            <th>Image</th>
                            <th class="sortable" data-column="products.name">Price <i class="sort-icon ri-sort-asc"></i></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="loader-row" style="display: none;">
                            <td colspan="7" style="text-align: center;">
                                <button class="btn btn-light" type="button" disabled="">
                                    <span class="spinner-grow spinner-grow-sm align-middle" role="status"
                                        aria-hidden="true"></span> Loading...
                                </button>
                            </td>
                        </tr>
                        @if($results->isNotEmpty())
                        @include('admin.products.load_more_data', ['results' => $results])
                        @else
                        <tr>
                            <td colspan="7" style="text-align: center;">No results found.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                @if($results->isNotEmpty() && $totalResults > Config('Reading.records_per_page'))
            <div class="my-3" style="display: flex; justify-content: center;">
                <button class="btn btn-primary-light btn-border-down" fdprocessedid="l5zhli" id="load-more"
                    data-offset="{{ Config('Reading.records_per_page') }}" data-default-offset="0"
                    data-limit="{{ Config('Reading.records_per_page') }}"
                    data-default-limit="{{ Config('Reading.records_per_page') }}">
                    <span class="loadMoreText me-2">Load More</span>
                    <span class="loading"><i class="ri-refresh-line fs-16"></i></span>
                </button>
            </div>
            @else
            <div class="my-3" style="display: flex; justify-content: center;">
                <button class="btn btn-primary-light btn-border-down" style="display:none;" fdprocessedid="l5zhli"
                    id="load-more" data-offset="{{ Config('Reading.records_per_page') }}" data-default-offset="0"
                    data-limit="{{ Config('Reading.records_per_page') }}"
                    data-default-limit="{{ Config('Reading.records_per_page') }}">
                    <span class="loadMoreText me-2">Load More</span>
                    <span class="loading"><i class="ri-refresh-line fs-16"></i></span>
                </button>
            </div>
            @endif
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

<script src="{{ asset('assets/js/custom/product.js') }}"></script>

<!-- Datatables Cdn -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script>
var routeName = '{{route($listRouteName)}}';
// Your DataTables initialization or other JavaScript logic here
</script>
<!-- Internal Datatables JS -->
<script src="{{ asset('assets/js/datatables.js') }}"></script>

<!-- Sweetalerts JS -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/js/sweet-alerts.js') }}"></script>


@endpush