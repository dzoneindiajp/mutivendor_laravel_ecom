<?php

namespace App\Http\Controllers\vrihatcpmaster;

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
use Redirect,DB,Str;

class BannerController extends Controller
{
    public $model = 'Banner';
    public function __construct(Request $request)
    {
        parent::__construct();
        View()->share('model', $this->model);
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
        $records_per_page = ($request->input('per_page')) ? $request->input('per_page') : Config("Reading.records_per_page");
        $results = $DB->orderBy($sortBy, $order)->paginate($records_per_page);
       
        $complete_string = $request->query();
        unset($complete_string["sortBy"]);
        unset($complete_string["order"]);
        $query_string = http_build_query($complete_string);
        $results->appends($inputGet)->render();
        return View("admin.$this->model.index", compact('results', 'searchVariable', 'sortBy', 'order', 'query_string'));
    }

    public function create(Request $request)
    {
        $languages = Language::where('is_active', 1)->get();
        $language_code = Config('constants.DEFAULT_LANGUAGE.LANGUAGE_ID');
        return View("admin.$this->model.add", compact('languages','language_code'));
    }
    
    public function edit(Request $request, $enuserid = null)
    {
        $user_id = '';
        if (!empty($enuserid)) {

            $user_id = base64_decode($enuserid);
            $userDetails = Banner::where('banners.id',$user_id)->first();
            //echo "<pre>"; print_r($userDetails); die;
            
            $BannerDescription	=	BannerDescription::where('parent_id', '=',  $user_id)->get();
            $multiLanguage		 	=	array();
            if(!empty($BannerDescription)){
                foreach($BannerDescription as $description) {
                    $multiLanguage[$description->language_id]['description']			=	$description->description;
                }
            }
            $languages = Language::where('is_active', 1)->get();
            $language_code = Config('constants.DEFAULT_LANGUAGE.LANGUAGE_ID');
            return View("admin.$this->model.edit", compact( 'userDetails','languages','language_code','multiLanguage'));
        }
    }
    public function save(Request $request)
    {

        $thisData = $request->all();
        if (!empty($thisData)) {
			$this->request->replace($this->arrayStripTags($request->all()));
			$default_language           =    Config('constants.DEFAULT_LANGUAGE.FOLDER_CODE');
            $language_code              =   Config('constants.DEFAULT_LANGUAGE.LANGUAGE_ID');
            $dafaultLanguageArray       =    $thisData['data'][$language_code];
            $validator = Validator::make(
                array(
                    'description'        => $dafaultLanguageArray['description'],
                    'image'              => $request->file('image'),
                    'mobile_image'              => $request->file('mobile_image'),
                ),
                array(
                    'image'             => 'required|mimes:jpg,jpeg,png',
                    'mobile_image'             => 'required|mimes:jpg,jpeg,png',
                ),
                array(
                    "image.required" => trans("The image field is required."),
                    "image.mimes" => trans("The image should be of type jpeg,jpg,png."),
                    "mobile_image.required" => trans("The mobile image field is required."),
                    "mobile_image.mimes" => trans("The mobile image should be of type jpeg,jpg,png."),
                )
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                DB::beginTransaction();
                $obj                                = new Banner;
                $obj->description                   = $dafaultLanguageArray['description'];
                $obj->is_secondary_banner              = !empty($request->is_secondary_banner) ? 1 : 0 ;
                $obj->is_side_banner              = !empty($request->is_side_banner) ? 1 : 0 ;
                $obj->video_path              = !empty($request->video_path) ? $request->video_path : "" ;

                if ($request->hasFile('image')) {
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $originalName = $request->file('image')->getClientOriginalName();
                    $fileName = time() . '-image.' . $extension;

                    $folderName = strtoupper(date('M') . date('Y')) . "/";
                    $folderPath = Config('constants.BANNER_IMAGE_ROOT_PATH') . $folderName;
                    if (!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777, true);
                    }
                    if ($request->file('image')->move($folderPath, $fileName)) {
                        $obj->image = $folderName . $fileName;
                        // $obj->original_image_name = $originalName;
                    }
                }
                if ($request->hasFile('mobile_image')) {
                    $extension = $request->file('mobile_image')->getClientOriginalExtension();
                    $originalName = $request->file('mobile_image')->getClientOriginalName();
                    $fileName = time() . '-mobile_image.' . $extension;

                    $folderName = strtoupper(date('M') . date('Y')) . "/";
                    $folderPath = Config('constants.BANNER_IMAGE_ROOT_PATH') . $folderName;
                    if (!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777, true);
                    }
                    if ($request->file('mobile_image')->move($folderPath, $fileName)) {
                        $obj->mobile_image = $folderName . $fileName;
                        // $obj->original_image_name = $originalName;
                    }
                }
               
                $obj->save();
                $lastId = $obj->id;
                if(!empty($lastId) && !empty($thisData)){
                    foreach ($thisData['data'] as $language_id => $value) {
                        $subObj                 = new BannerDescription();
                        $subObj->language_id    = $language_id;
                        $subObj->parent_id      = $lastId;
                        $subObj->description           = $value['description'];
                        $subObj->save();
                    }

                    DB::commit();
                }else{
                    DB::rollback();
                    Session()->flash('flash_notice', 'Something Went Wrong');
                    return Redirect::route('Banner.index');
                }
                Session()->flash('flash_notice', trans(config('constants.BANNER.BANNER_TITLE')." has been added successfully."));
                return Redirect::route('Banner.index');
            }
        }
    }
    public function update(Request $request, $enuserid = null)
    {
        $model = Banner::find($enuserid);
        if (empty($model)) {
            return View("admin.$this->model.edit");
        } else {
            $thisData = $request->all();
            if (!empty($thisData)) {
                $this->request->replace($this->arrayStripTags($request->all()));
                $default_language			=	Config('constants.DEFAULT_LANGUAGE.FOLDER_CODE');
                $language_code 				=    Config('constants.DEFAULT_LANGUAGE.LANGUAGE_ID');
                $dafaultLanguageArray		=	$thisData['data'][$language_code];
                $validator = Validator::make(
                    array(
                        'description'        => $dafaultLanguageArray['description'],
                        'image'              => $request->file('image'),
                        'mobile_image'              => $request->file('mobile_image'),
                    ),
                    array(
                        'image'             => 'nullable|mimes:jpg,jpeg,png',
                        'mobile_image'             => 'nullable|mimes:jpg,jpeg,png',
                    ),
                    array(
                        "image.mimes" => trans("The image should be of type jpeg,jpg,png."),
                        "mobile_image.mimes" => trans("The mobile image should be of type jpeg,jpg,png."),
                    )
                );
                
                if ($validator->fails()) {
                    return Redirect::back()
                        ->withErrors($validator)->withInput();
                }else{
                    
                    DB::beginTransaction();
                    $obj                                = $model;
                    $obj->description                   = $dafaultLanguageArray['description'];
                    $obj->is_secondary_banner              = !empty($request->is_secondary_banner) ? 1 : 0 ;
                    $obj->is_side_banner              = !empty($request->is_side_banner) ? 1 : 0 ;
                    $obj->video_path              = !empty($request->video_path) ? $request->video_path : "" ;

                    if ($request->hasFile('image')) {
                        $extension = $request->file('image')->getClientOriginalExtension();
                        $originalName = $request->file('image')->getClientOriginalName();
                        $fileName = time() . '-image.' . $extension;

                        $folderName = strtoupper(date('M') . date('Y')) . "/";
                        $folderPath = Config('constants.BANNER_IMAGE_ROOT_PATH') . $folderName;
                        if (!File::exists($folderPath)) {
                            File::makeDirectory($folderPath, $mode = 0777, true);
                        }
                        if ($request->file('image')->move($folderPath, $fileName)) {
                            $obj->image = $folderName . $fileName;
                            // $obj->original_image_name = $originalName;
                        }
                    }
                    if ($request->hasFile('mobile_image')) {
                        $extension = $request->file('mobile_image')->getClientOriginalExtension();
                        $originalName = $request->file('mobile_image')->getClientOriginalName();
                        $fileName = time() . '-mobile_image.' . $extension;
    
                        $folderName = strtoupper(date('M') . date('Y')) . "/";
                        $folderPath = Config('constants.BANNER_IMAGE_ROOT_PATH') . $folderName;
                        if (!File::exists($folderPath)) {
                            File::makeDirectory($folderPath, $mode = 0777, true);
                        }
                        if ($request->file('mobile_image')->move($folderPath, $fileName)) {
                            $obj->mobile_image = $folderName . $fileName;
                            // $obj->original_image_name = $originalName;
                        }
                    }
                    
                    $obj->save();
                    $lastId = $obj->id;
                    if(!empty($lastId)){
                        BannerDescription::where('parent_id', '=', $lastId)->delete();
                        if (!empty($thisData)) {
                            foreach ($thisData['data'] as $language_id => $value) {
                                $subObj                =    new BannerDescription();
                                $subObj->language_id   =    $language_id;
                                $subObj->parent_id     =    $lastId;
                                $subObj->description   =    $value['description'];
                                $subObj->save();
                            }
                        }
                        DB::commit();
                    }else{
                        DB::rollback();
                        Session()->flash('flash_notice', 'Something Went Wrong');
                        return Redirect::route('Banner.index');
                    }
                    Session()->flash('flash_notice', trans(config('constants.BANNER.BANNER_TITLE')." has been updated successfully."));
                    return Redirect::route('Banner.index');
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
        BannerDescription::where('parent_id', '=', $user_id)->delete();
        Session()->flash('flash_notice', trans(config('constants.BANNER.BANNER_TITLE')." has been removed successfully."));
        
        return back();
    }

    public function changeStatus($modelId = 0, $status = 0)
    {
        if ($status == 1) {
            $statusMessage = trans(Config('constants.BANNER.BANNER_TITLE') . " has been deactivated successfully");
        } else {
            $statusMessage = trans(Config('constants.BANNER.BANNER_TITLE') . " has been activated successfully");
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
            $userDetails = Banner::where('blogs.id',$user_id)->select('blogs.*')->first();

            $data = compact('user_id', 'userDetails');

            return View("admin.$this->model.view", $data);
        }
    }
}
