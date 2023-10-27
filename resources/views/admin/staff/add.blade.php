@extends('admin.layout.master')
@section('content')
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
        <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        Add New {{Config('constant.STAFF.STAFF_TITLE')}} </h5>
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin-dashboard')}}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin-'.$model.'.index')}}" class="text-muted"> {{Config('constant.STAFF.STAFF_TITLE')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
            @include("admin.elements.quick_links")
        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <div class=" container ">
            <form action="{{route('admin-'.$model.'.store')}}" method="post" class="mws-form" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-1"></div>
                            <div class="col-xl-10">
                                <h3 class="mb-10 font-weight-bold text-dark">
                                    {{Config('constant.STAFF.STAFF_TITLE')}} Information
                                </h3>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="name"> Name</label><span class="text-danger"> * </span>
                                            <input type="text" name="name" class="form-control form-control-solid form-control-lg  @error('name') is-invalid @enderror" value="{{old('name')}}">
                                            @if ($errors->has('name'))
                                            <div class=" invalid-feedback">
                                                {{ $errors->first('name') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="email"> Email</label><span class="text-danger"> * </span>
                                            <input type="text" name="email" class="form-control form-control-solid form-control-lg  @error('email') is-invalid @enderror" value="{{old('email')}}">
                                            @if ($errors->has('email'))
                                            <div class=" invalid-feedback">
                                                {{ $errors->first('email') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number</label><span class="text-danger"> </span>

                                           <br>
                                            <input type="hidden" value="" name="dial_code" id="dial_code">
                                            <input type="hidden" value="" name="country_code" id="country_code">
                                            <input style="width:500px" type="text" id="phone_number_country" name="phone_number" class="form-control form-control-solid form-control-lg small validate_phone_number jquery-intl-phone  @error('phone_number') is-invalid @enderror" value="{{old('phone_number')}}">
                                            @if ($errors->has('phone_number'))
                                            <div class=" invalid-feedback">
                                                {{ $errors->first('phone_number') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                  
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="phone_number"> Password</label><span class="text-danger"> * </span>
                                            <input type="password" name="password" class="form-control form-control-solid form-control-lg  @error('password') is-invalid @enderror" value="{{old('password')}}">
                                            @if ($errors->has('password'))
                                            <div class=" invalid-feedback">
                                                {{ $errors->first('password') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="phone_number">Confirm Password</label><span class="text-danger"> * </span>
                                            <input type="password" name="confirm_password" class="form-control form-control-solid form-control-lg  @error('confirm_password') is-invalid @enderror" value="{{old('confirm_password')}}">
                                            @if ($errors->has('confirm_password'))
                                            <div class=" invalid-feedback">
                                                {{ $errors->first('confirm_password') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h3 class="mb-10 font-weight-bold text-dark">
                                    Department Information</h3>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="department_id">Department</label><span class="text-danger"> * </span>
                                            <select name="department_id" class="DepartmentList form-control form-control-solid form-control-lg @error('department_id') is-invalid @enderror">
                                                <option value="">Select Department</option>
                                                @foreach($departments as $departments)
                                                <option value="{{$departments->id}}"> {{$departments->name}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('department_id'))
                                            <div class=" invalid-feedback">
                                                {{ $errors->first('department_id') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label for="designation_id">Designation</label><span class="text-danger"> * </span>
                                            <select name="designation_id" id="designation_id" class="designation_iddrop form-control form-control-solid form-control-lg chosenselect_designation_id @error('designation_id') is-invalid @enderror">
                                            </select>
                                            @if ($errors->has('designation_id'))
                                            <div class=" invalid-feedback">
                                                {{ $errors->first('designation_id') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="staffPermission"></div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                    <div>
                                        <button button type="button" onclick="submit_form();" class="btn btn-success font-weight-bold text-uppercase px-9 py-4">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        if ($(".parent:input").val() == 1) {
            var parentid = $(".parent:input:checked").attr('id');
            $('.child' + parentid).attr('checked', true);
        }
        $(".checkAll").click(function() {
            $(".parent:input").not(this).prop('checked', this.checked);
            $(".children:input").not(this).prop('checked', this.checked);
        });
        $(".parent:input").click(function() {
            var parentid = $(this).attr('id');
            $('.child' + parentid).not(this).prop('checked', this.checked);
        });

        $(".children").click(function() {
            var childid = $(this).attr('id');
            $('#' + childid).not(this).prop('checked', this.checked);
        });
    });
</script>
<script>
    function DepartmentList() {
        departmentid = ($(".DepartmentList").val() != "") ? $(".DepartmentList").val() : 0;
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            url: '{{route("admin-"."$model.getDesignations")}}',
            type: "POST",
            data: {
                'departmentid': departmentid,
                "selctedid": "0"
            },
            success: function(response) {
                $(".designation_iddrop").html(response);
            }
        });
    }
    $(function() {
        $(".DepartmentList").change(function() {
            DepartmentList();
        });
        DepartmentList();
    });

    $('#designation_id').on('change', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{route("admin-"."$model.getStaffPermission")}}',
            type: 'POST',
            data: {
                'designation_id': id
            }, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(r) {
                if (r != '') {
                    $('.staffPermission').html(r);
                } else {
                    show_message(r.message, 'error');
                }

            }
        });
    });

    function submit_form() {
        $(".mws-form").submit();
    }
</script>


<script >
    $(document).ready(function(){
        $("#phone_number_country").intlTelInput({
                                    allowDropdown:true,
                                    preferredCountries:[],
                                    initialCountry: 'IN',
                                    separateDialCode:true
                                });
    $("#phone_number_country").on('countrychange', function (e, countryData) {

        var data    = $(".iti__selected-dial-code").html();
        var data1   = $("#phone_number_country").intlTelInput("getSelectedCountryData").iso2;
     
        $("#dial_code").val(data);
        $("#country_code").val(data1);

       
    });
    })
   
</script>
@stop