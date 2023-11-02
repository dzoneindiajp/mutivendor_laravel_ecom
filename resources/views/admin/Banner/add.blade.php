@extends('admin.layouts.layout')
@section('content')
<style>
    .invalid-feedback {
        display: inline;
    }
</style>
<script src="{{asset('/public/js/ckeditor/ckeditor.js')}}"></script>
<!--begin::Content-->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Subheader-->
	<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
		<div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Info-->
			<div class="d-flex align-items-center flex-wrap mr-1">
				<!--begin::Page Heading-->
				<div class="d-flex align-items-baseline flex-wrap mr-5">
					<!--begin::Page Title-->
					<h5 class="text-dark font-weight-bold my-1 mr-5">
					Add New Banner</h5>
					<!--end::Page Title-->

					<!--begin::Breadcrumb-->
					<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
						<li class="breadcrumb-item">
							<a href="{{ route(dashboard)}}" class="text-muted">Dashboard</a>
						</li>
						<li class="breadcrumb-item">
                            <a href="{{ route($model.'.index')}}" class="text-muted">Banners</a>
                        </li>
					</ul>
					<!--end::Breadcrumb-->
				</div>
				<!--end::Page Heading-->
			</div>
			<!--end::Info-->

			@include("admin.elements.quick_links")
		</div>
	</div>
	<!--end::Subheader-->

	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class=" container ">
			<form action="{{route('Banner.save')}}" method="post" class="mws-form" autocomplete="off" enctype="multipart/form-data">
                @csrf
			
			<div class="card card-custom gutter-b">
				<div class="card-header card-header-tabs-line">
					<div class="card-toolbar border-top">
						<ul class="nav nav-tabs nav-bold nav-tabs-line">
							@if(!empty($languages))
							<?php $i = 1; ?>
							@foreach($languages as $language)
							<li class="nav-item">
								<a class="nav-link {{($i==$language_code)?'active':'' }}" data-toggle="tab" href="#{{$language->title}}">
									<span class="symbol symbol-20 mr-3">
										<img src="{{url (Config::get('constants.LANGUAGE_IMAGE_PATH').$language->image)}}" alt="">
									</span>
									<span class="nav-text">{{$language->title}}</span>
								</a>
							</li>
							<?php $i++; ?>
							@endforeach
							@endif
						</ul>
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						@if(!empty($languages))
						<?php $i = 1; ?>
						@foreach($languages as $language)
						<div class="tab-pane fade {{($i==$language_code)?'show active':'' }}" id="{{$language->title}}" role="tabpanel" aria-labelledby="{{$language->title}}">
							<div class="row">
								<div class="col-xl-12">
									<div class="row">
										<div class="col-xl-12">
											<div class="form-group">
												<div id="kt-ckeditor-1-toolbar{{$language->id}}"></div>
												@if($i == 1)
												<lable>Description </lable><span class="text-danger">  </span>
												<textarea id="description_{{$language->id}}" name="data[{{$language->id}}][description]" class="form-control form-control-solid form-control-lg  @error('description') is-invalid @enderror" value="{{old('description')}}">
												{{old('description')}} </textarea>
												@if ($errors->has('description'))
												<div class="alert invalid-feedback admin_login_alert">
													{{ $errors->first('description') }}
												</div>
												@endif
												@else
												<lable>Description </lable>
												<textarea name="data[{{$language->id}}][description]" id="description_{{$language->id}}" class="form-control form-control-solid form-control-lg">{{old('description')}}</textarea>
												@endif
											</div>
											<script>
												CKEDITOR.replace(<?php echo 'description_' . $language->id; ?>, {
													filebrowserUploadUrl: '<?php echo URL()->to('base/uploder'); ?>',
													enterMode: CKEDITOR.ENTER_BR
												});
												CKEDITOR.config.allowedContent = true;
											</script>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php $i++; ?>
						@endforeach
						@endif
					</div>

					<div class="row">
						<div class="col-xl-6">
							<div class="form-group">
								<label>Image</label><span class="text-danger">*  </span>
								<input type="file" name="image" class="form-control form-control-solid form-control-lg  @error('image') is-invalid @enderror">


								@if (!empty($userDetails->image))
								<a class="fancybox-buttons" data-fancybox-group="button" href="{{isset($userDetails->image)? $userDetails->image:''}}"><img height="50" width="50" src="{{isset($userDetails->image)? $userDetails->image:''}}" />
								</a>
								@endif
								@if ($errors->has('image'))
								<div class="invalid-feedback">
									{{ $errors->first('image') }}
								</div>
								@endif
							</div>
						</div>
						
						<div class="col-xl-6">
							<div class="form-group">
								<label>Mobile Image</label><span class="text-danger">*  </span>
								<input type="file" name="mobile_image" class="form-control form-control-solid form-control-lg  @error('mobile_image') is-invalid @enderror">


								@if (!empty($userDetails->mobile_image))
								<a class="fancybox-buttons" data-fancybox-group="button" href="{{isset($userDetails->mobile_image)? $userDetails->mobile_image:''}}"><img height="50" width="50" src="{{isset($userDetails->mobile_image)? $userDetails->mobile_image:''}}" />
								</a>
								@endif
								@if ($errors->has('mobile_image'))
								<div class="invalid-feedback">
									{{ $errors->first('mobile_image') }}
								</div>
								@endif
							</div>
						</div>
						<div class="col-xl-6">
							<div class="form-group">
								<label for="video_path">Video Path</label><span class="text-danger">  </span>
								<input type="text" name="video_path" class="form-control form-control-solid form-control-lg  @error('video_path') is-invalid @enderror" value="{{isset($userDetails->video_path)?$userDetails->video_path:''}}">
								@if ($errors->has('video_path'))
								<div class=" invalid-feedback">
									{{ $errors->first('video_path') }}
								</div>
								@endif
							</div>
						</div>

						<div class="col-xl-6 ">
                                <div class="checkbox-list">

                                    <label class="checkbox">
                                        <input type="checkbox" name="is_secondary_banner" class="secondaryBannerCheck"
                                            value="1"
                                            {{(!empty($userDetails->is_secondary_banner) && $userDetails->is_secondary_banner == 1 )  ? 'checked':''}} />
                                        <span></span>
                                        Is this a secondary banner ?
                                    </label>
                                </div>
						</div>
						<div class="col-xl-6 ">
                                <div class="checkbox-list">

                                    <label class="checkbox">
                                        <input type="checkbox" name="is_side_banner" class="secondaryBannerCheck"
                                            value="1"
                                            {{(!empty($userDetails->is_side_banner) && $userDetails->is_side_banner == 1 )  ? 'checked':''}} />
                                        <span></span>
                                        Is this a side banner ?
                                    </label>
                                </div>
						</div>
					</div>
					<div class="d-flex justify-content-between border-top mt-5 pt-10">
						<div>
							<button button type="submit" class="btn btn-success adimnBtnStyle1 font-weight-bold text-uppercase px-9 py-4">
								Submit
							</button>
						</div>
					</div>
					
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
@stop