<?php

namespace App\Http\Controllers\Admin;

use App\Config;
use App\Http\Controllers\Controller;
use App\Models\Lookup;
use App\Models\Banner;
use App\Models\Language;
use App\Models\BannerDescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Redirect,DB,Str;

class BannerController extends Controller
{
    public $model = 'Banner';
    public function __construct(Request $request)
    {
        $this->listRouteName = 'admin-Banner.index';
        View()->share('model', $this->model);
        View()->share('listRouteName', $this->listRouteName);
        $this->request = $request;
    }

    public function index(Request $request)
    {
        $DB = Banner::query();
        $searchVariable = array();
        $inputGet = $request->all();
        if ($request->all()) {
            $searchData = $request->all();
            unset($searchData['display']);
            unset($searchData['_token']);
            if (isset($searchData['order'])) {
                unset($searchData['order']);
            }
            if (isset($searchData['sortBy'])) {
                unset($searchData['sortBy']);
            }
            if (isset($searchData['page'])) {
                unset($searchData['page']);
            }
            if ((!empty($searchData['date_from'])) && (!empty($searchData['date_to']))) {
                $dateS = $searchData['date_from'];
                $dateE = $searchData['date_to'];
                $DB->whereBetween('banners.created_at', [$dateS, $dateE]);
            } elseif (!empty($searchData['date_from'])) {
                $dateS = $searchData['date_from'];
                $DB->where('banners.created_at', '>=', [$dateS]);
            } elseif (!empty($searchData['date_to'])) {
                $dateE = $searchData['date_to'];
                $DB->where('banners.created_at', '<=', [$dateE]);
            }
            foreach ($searchData as $fieldName => $fieldValue) {
                if ($fieldValue != "") {
                    if ($fieldName == "is_active") {
                        $DB->where("banners.is_active", 'like', '%' . $fieldValue . '%');
                    }
                }
                $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }

        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'banners.created_at';
        $order = ($request->input('order')) ? $request->input('order') : 'DESC';
        $offset = !empty($request->input('offset')) ? $request->input('offset') : 0 ;
        $limit =  !empty($request->input('limit')) ? $request->input('limit') : Config("Reading.records_per_page");

        $results = $DB->orderBy($sortBy, $order)->offset($offset)->limit($limit)->get();
        $totalResults = $DB->count();

        if(!empty($results)) {
            foreach($results as &$result) {


                if($result->type == "full_image") {
                    $result->type_name = "Full Image";
                } else if( $result->type == "left_image") {
                    $result->type_name = "Left Image";
                } else if( $result->type == "right_image") {
                    $result->type_name = "Right Image";
                } else {
                    $result->type_name = "Video";
                }
            }
        }

        if($request->ajax()){

            return  View("admin.$this->model.load_more_data", compact('results','totalResults'));
        }else{
            return  View("admin.$this->model.index", compact('results','totalResults'));
        }
    }

    public function create(Request $request)
    {
        return View("admin.$this->model.add");
    }

    public function edit(Request $request, $enuserid = null)
    {
        $user_id = '';
        if (!empty($enuserid)) {

            $user_id = base64_decode($enuserid);
            $userDetails = Banner::where('banners.id',$user_id)->first();
            return View("admin.$this->model.edit", compact( 'userDetails'));
        }
    }


    public function save(Request $request)
    {
        $thisData = $request->all();
        if (!empty($thisData)) {
            $validator = Validator::make(
                array(
                    'type'               => $request->input('type'),
                    'description'        => $request->input('description'),
                    'height'             => $request->input('height'),
                    'width'              => $request->input('width'),
                    'url'                => $request->input('url'),
                    'image'              => $request->file('image'),
                    'video'              => $request->file('video'),
                ),
                array(
                    'type' => 'required',
                    // 'image' => 'required_if:type,full_image,left_image,right_image|mimes:jpg,jpeg,png',
                    // 'video' => 'required_if:type,video|mimetypes:video/mp4,video/quicktime',
                    'image' => $request->input('type') === 'video' ? 'nullable' : 'required_if:type,full_image,left_image,right_image|mimes:jpg,jpeg,png,webp',
                    'video' => $request->input('type') === 'video' ?'required_if:type,video|mimetypes:video/mp4,video/quicktime' : 'nullable',
                    'description' => 'required_if:type,left_image,right_image',
                    // 'height' => 'required_if:type,full_image,left_image,right_image',
                    // 'width' => 'required_if:type,full_image,left_image,right_image',

                ),
                array(
                    "type.required" => trans("The Banner type field is required."),
                    "image.required_if" => trans("The image field is required."),
                    "image.mimes" => trans("The image should be of type jpeg,jpg,png."),
                    "video.required_if" => trans("The video field is required."),
                    "video.mimetypes" => trans("The video should be of type mp4,mov."),
                    "description.required_if" => trans("The description field is required."),
                )
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                DB::beginTransaction();
                $obj                                = new Banner;

                $obj->type                          = $request->input('type');
                $obj->description                   = !empty($request->input('description')) ? $request->input('description') : "";
                $obj->height                        = !empty($request->input('height')) ? $request->input('height') : NULL;
                $obj->width                         = !empty($request->input('width')) ? $request->input('width') : NULL;
                $obj->url                           = !empty($request->input('url')) ? $request->input('url') : "";
                $obj->order_number                           = !empty($request->input('order_number')) ? $request->input('order_number') : "";

                if ($request->hasFile('image')) {
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $originalName = $request->file('image')->getClientOriginalName();
                    $fileName = time() . '-image.' . $extension;

                    $folderName = strtoupper(date('M') . date('Y')) . "/";
                    $folderPath = Config('constant.BANNER_IMAGE_ROOT_PATH') . $folderName;
                    if (!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777, true);
                    }
                    if ($request->file('image')->move($folderPath, $fileName)) {
                        $obj->image = $folderName . $fileName;
                    }
                }
                if ($request->hasFile('video')) {
                    $extension = $request->file('video')->getClientOriginalExtension();
                    $originalName = $request->file('video')->getClientOriginalName();
                    $fileName = time() . '-video.' . $extension;

                    $folderName = strtoupper(date('M') . date('Y')) . "/";
                    $folderPath = Config('constant.BANNER_VIDEO_ROOT_PATH') . $folderName;
                    if (!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777, true);
                    }
                    if ($request->file('video')->move($folderPath, $fileName)) {
                        $obj->video = $folderName . $fileName;
                    }
                }

                $obj->save();
                $lastId = $obj->id;
                if(!empty($lastId)){
                    DB::commit();
                }else{
                    DB::rollback();
                    Session()->flash('flash_notice', 'Something Went Wrong');
                    return Redirect::route('admin-Banner.index');
                }
                Session()->flash('flash_notice', trans("Banner has been added successfully."));
                return Redirect::route('admin-Banner.index');
            }
        }
    }


    public function update(Request $request, $enuserid = null)
    {
        // echo "<pre>"; print_r($request->all()); die;
        $model = Banner::find($enuserid);
        if (empty($model)) {
            return View("admin.$this->model.edit");
        } else {
            $thisData = $request->all();
            if (!empty($thisData)) {

                $validator = Validator::make(
                    array(
                        'type'               => $request->input('type'),
                        'description'        => $request->input('description'),
                        'height'             => $request->input('height'),
                        'width'              => $request->input('width'),
                        'url'                => $request->input('url'),
                        'image'              => $request->file('image'),
                        'video'              => $request->file('video'),
                    ),
                    array(
                        'type' => 'required',
                        'image' => (($request->input('type') === 'video' ) || (($request->input('type') !== 'video' && empty($request->image) && $model->type === $request->input('type') ))) ? 'nullable' : 'required_if:type,full_image,left_image,right_image|mimes:jpg,jpeg,png',
                        'video' =>(($request->input('type') !== 'video' ) || (($request->input('type') === 'video' && empty($request->video) && $model->type === $request->input('type')))) ? 'nullable' :'required_if:type,video|mimetypes:video/mp4,video/quicktime' ,
                        'description' => 'required_if:type,left_image,right_image',

                    ),
                    array(
                        "type.required" => trans("The Banner type field is required."),
                        "image.required_if" => trans("The image field is required."),
                        "image.mimes" => trans("The image should be of type jpeg,jpg,png."),
                        "video.required_if" => trans("The video field is required."),
                        "video.mimes" => trans("The video should be of type mp4,mov."),
                        "description.required_if" => trans("The description field is required."),
                    )
                );

                if ($validator->fails()) {
                    return Redirect::back()
                        ->withErrors($validator)->withInput();
                }else{

                    DB::beginTransaction();
                    $obj                                = $model;
                    $obj->type                          = $request->input('type');
                    $obj->description                   = !empty($request->input('description')) ? $request->input('description') : $model->description;
                    $obj->height                        = !empty($request->input('height')) ? $request->input('height') : $model->height;
                    $obj->width                         = !empty($request->input('width')) ? $request->input('width') : $model->width;
                    $obj->url                           = !empty($request->input('url')) ? $request->input('url') : $model->url;
                    $obj->order_number                           = !empty($request->input('order_number')) ? $request->input('order_number') : "";

                    if ($request->hasFile('image')) {
                        $extension = $request->file('image')->getClientOriginalExtension();
                        $originalName = $request->file('image')->getClientOriginalName();
                        $fileName = time() . '-image.' . $extension;

                        $folderName = strtoupper(date('M') . date('Y')) . "/";
                        $folderPath = Config('constant.BANNER_IMAGE_ROOT_PATH') . $folderName;
                        if (!File::exists($folderPath)) {
                            File::makeDirectory($folderPath, $mode = 0777, true);
                        }
                        if ($request->file('image')->move($folderPath, $fileName)) {
                            $obj->image = $folderName . $fileName;
                        }
                    }
                    if ($request->hasFile('video')) {
                        $extension = $request->file('video')->getClientOriginalExtension();
                        $originalName = $request->file('video')->getClientOriginalName();
                        $fileName = time() . '-video.' . $extension;

                        $folderName = strtoupper(date('M') . date('Y')) . "/";
                        $folderPath = Config('constant.BANNER_VIDEO_ROOT_PATH') . $folderName;
                        if (!File::exists($folderPath)) {
                            File::makeDirectory($folderPath, $mode = 0777, true);
                        }
                        if ($request->file('video')->move($folderPath, $fileName)) {
                            $obj->video = $folderName . $fileName;
                        }
                    }

                    $obj->save();
                    $lastId = $obj->id;
                    if(!empty($lastId)){

                        DB::commit();
                    }else{
                        DB::rollback();
                        Session()->flash('flash_notice', 'Something Went Wrong');
                        return Redirect::route('admin-Banner.index');
                    }
                    Session()->flash('flash_notice', trans("Banner has been updated successfully."));
                    return Redirect::route('admin-Banner.index');
                }
            }
        }
    }

    public function destroy($enuserid)
    {
        $user_id = '';
        if (!empty($enuserid)) {
            $user_id = base64_decode($enuserid);
        }
        $userDetails = Banner::find($user_id);
        if (empty($userDetails)) {
            return Redirect()->route($this->model . '.index');
        }
        Banner::where('id',$user_id)->delete();
        Session()->flash('flash_notice', trans("Banner has been removed successfully."));

        return back();
    }

    public function changeStatus($modelId = 0, $status = 0)
    {
        if ($status == 1) {
            $statusMessage = trans("Banner has been deactivated successfully");
        } else {
            $statusMessage = trans("Banner has been activated successfully");
        }
        $user = Banner::find($modelId);
        if ($user) {
            $currentStatus = $user->is_active;
            if (isset($currentStatus) && $currentStatus == 0) {
                $NewStatus = 1;
            } else {
                $NewStatus = 0;
            }
            $user->is_active = $NewStatus;
            $ResponseStatus = $user->save();
        }
        Session()->flash('flash_notice', $statusMessage);
        return back();
    }


    public function show(Request $request, $enuserid = null)
    {
        $user_id = '';
        if (!empty($enuserid)) {

            $user_id = base64_decode($enuserid);
            $userDetails = Banner::where('banners.id',$user_id)->select('banners.*')->first();

            $data = compact('user_id', 'userDetails');

            return View("admin.$this->model.view", $data);
        }
    }
}
