<?php

namespace App\Http\Controllers\Admin;

use App\Config;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\TestimonialDescription;
use Illuminate\Http\Request;
use App\Models\Language;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Redirect,DB,View;

class TestimonialController extends Controller
{
    public $model = 'testimonials';
    public function __construct(Request $request)
    {
        parent::__construct();
        View()->share('model', $this->model);
        $this->request = $request;
    }

    public function index(Request $request)
    {
        $DB = Testimonial::query();
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
                $DB->whereBetween('testimonials.created_at', [$dateS . " 00:00:00", $dateE . " 23:59:59"]);
            } elseif (!empty($searchData['date_from'])) {
                $dateS = $searchData['date_from'];
                $DB->where('testimonials.created_at', '>=', [$dateS . " 00:00:00"]);
            } elseif (!empty($searchData['date_to'])) {
                $dateE = $searchData['date_to'];
                $DB->where('testimonials.created_at', '<=', [$dateE . " 00:00:00"]);
            }
            foreach ($searchData as $fieldName => $fieldValue) {
                if ($fieldValue != "") {
                    if ($fieldName == "name") {
                        $DB->where("testimonials.name", 'like', '%' . $fieldValue . '%');
                    }

                    if ($fieldName == "city") {
                        $DB->where("testimonials.city", $fieldValue);
                    }
                   
                    if ($fieldName == "is_active") {
                        $DB->where("testimonials.is_active", $fieldValue);
                    }
                }
                $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }
        
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'testimonials.created_at';
        $order = ($request->input('order')) ? $request->input('order') : 'DESC';
        $records_per_page = ($request->input('per_page')) ? $request->input('per_page') : Config("Reading.records_per_page");
        $results = $DB->orderBy($sortBy, $order)->paginate($records_per_page);
       
        $complete_string = $request->query();
        unset($complete_string["sortBy"]);
        unset($complete_string["order"]);
        $query_string = http_build_query($complete_string);
        $results->appends($inputGet)->render();
        $resultcount = $results->count();
        return View("admin.$this->model.index", compact('resultcount', 'results', 'searchVariable', 'sortBy', 'order', 'query_string'));
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
            $userDetails = Testimonial::where('testimonials.id',$user_id)->first();

            $CategoryDescription	=	TestimonialDescription::where('parent_id', '=',  $user_id)->get();
            $multiLanguage		 	=	array();
            if(!empty($CategoryDescription)){
                foreach($CategoryDescription as $description) {
                    $multiLanguage[$description->language_id]['name']			=	$description->name;
                    $multiLanguage[$description->language_id]['description']			=	$description->description;
                    $multiLanguage[$description->language_id]['city']			=	$description->city;
                }
            }

            //echo "<pre>";print_r($multiLanguage);die;
            $languages = Language::where('is_active', 1)->get();
            $language_code = Config('constants.DEFAULT_LANGUAGE.LANGUAGE_ID');
            return  View::make("admin.$this->model.edit",array('languages' => $languages,'language_code' => $language_code,'userDetails' => $userDetails,'multiLanguage' => $multiLanguage));
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
                    'name'             => $dafaultLanguageArray['name'],
                    'description'      => $dafaultLanguageArray['description'],
                    'city'             => $dafaultLanguageArray['city'],
                    'image'            => !empty($request->image) ? $request->image : '',
                    'rating'           => $request->input('rating'),
                ),
                array(
                    'name'              => 'required',
                    'description'       => 'required',
                    'rating'            => 'required',
                    'city'              => 'required',
                    'image'             => 'nullable|mimes:jpg,jpeg,png',
                )
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $obj = new Testimonial;
                $obj->name                 = $dafaultLanguageArray['name'];
                $obj->description          = $dafaultLanguageArray['description'];
                $obj->city                 = $dafaultLanguageArray['city'];
                $obj->rating               = $request->input('rating');

                if ($request->hasFile('image')) {
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $originalName = $request->file('image')->getClientOriginalName();
                    $fileName = time() . '-image.' . $extension;

                    $folderName = strtoupper(date('M') . date('Y')) . "/";
                    $folderPath = Config('constants.TESTIMONIAL_IMAGE_ROOT_PATH') . $folderName;
                    if (!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777, true);
                    }
                    if ($request->file('image')->move($folderPath, $fileName)) {
                        $obj->image = $folderName . $fileName;
                        // $obj->original_image_name = $originalName;
                    }
                }
				
                $obj->save();
                $lastId = $obj->id;
                if (!empty($thisData)) {
                    foreach ($thisData['data'] as $language_id => $value) {
                        $subObj                 = new TestimonialDescription();
                        $subObj->language_id    = $language_id;
                        $subObj->parent_id      = $lastId;
                        $subObj->name           = $value['name'];
                        $subObj->description    = $value['description'];
                        $subObj->city           = $value['city'];
                        $subObj->save();
                    }
                }
                Session()->flash('success', Config('constants.TESTIMONIAL.TESTIMONIAL_TITLE') . " has been added successfully");
                return Redirect()->route($this->model . ".index");
            }
        }

    }

    public function update(Request $request, $enuserid = null)
    {
        $model = Testimonial::find($enuserid);
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
                        'name'             => $dafaultLanguageArray['name'],
                        'description'      => $dafaultLanguageArray['description'],
                        'city'             => $dafaultLanguageArray['city'],
                        'image'            => !empty($request->image) ? $request->image : '',
                        'rating'           => $request->input('rating'),
                    ),
                    array(
                        'name'              => 'required',
                        'description'       => 'required',
                        'rating'            => 'required',
                        'city'              => 'required',
                        'image'             => 'nullable|mimes:jpg,jpeg,png',
                    )
                );
                
                if ($validator->fails()) {	
                    return Redirect::back()
                        ->withErrors($validator)->withInput();
                }else{
                    
                    DB::beginTransaction();
                    $obj                       = $model;
                    $obj->name                 = $dafaultLanguageArray['name'];
                    $obj->description          = $dafaultLanguageArray['description'];
                    $obj->city                 = $dafaultLanguageArray['city'];
                    $obj->rating               = $request->input('rating');

                    if ($request->hasFile('image')) {
                        $extension = $request->file('image')->getClientOriginalExtension();
                        $originalName = $request->file('image')->getClientOriginalName();
                        $fileName = time() . '-image.' . $extension;
    
                        $folderName = strtoupper(date('M') . date('Y')) . "/";
                        $folderPath = Config('constants.TESTIMONIAL_IMAGE_ROOT_PATH') . $folderName;
                        if (!File::exists($folderPath)) {
                            File::makeDirectory($folderPath, $mode = 0777, true);
                        }
                        if ($request->file('image')->move($folderPath, $fileName)) {
                            $obj->image = $folderName . $fileName;
                            // $obj->original_image_name = $originalName;
                        }
                    }

                    $objSave = $obj->save();
                    
                    if(!$objSave) {
                        DB::rollback();
                        Session::flash('error', trans("Something went wrong.")); 
                        return Redirect::route($this->model.".index");
                    }
                    $last_id			=	$obj->id;
                    
                    TestimonialDescription::where('parent_id', '=', $last_id)->delete();
                    if (!empty($thisData)) {
                        foreach ($thisData['data'] as $language_id => $value) {
                            $subObj                =    new TestimonialDescription();
                            $subObj->language_id   =    $language_id;
                            $subObj->parent_id     =    $last_id;
                            $subObj->name         =    $value['name'];
                            $subObj->description          =    $value['description'];
                            $subObj->city          =    $value['city'];
                            $subObj->save();
                        }
                    }
                    DB::commit();
                    Session()->flash('success', Config('constants.TESTIMONIAL.TESTIMONIAL_TITLE'). " has been updated successfully");
                    return Redirect()->route($this->model . ".index");
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
        $userDetails = Testimonial::find($user_id);
        if (empty($userDetails)) {
            return Redirect()->route($this->model . '.index');
        }
        Testimonial::where('id',$user_id)->delete();
        TestimonialDescription::where('parent_id', '=', $user_id)->delete();
        Session()->flash('flash_notice', trans(config('constants.TESTIMONIAL.TESTIMONIAL_TITLE')." has been removed successfully."));
        
        return back();
    }

    public function changeStatus($modelId = 0, $status = 0)
    {
        if ($status == 1) {
            $statusMessage = trans(Config('constants.TESTIMONIAL.TESTIMONIAL_TITLE') . " has been deactivated successfully");
        } else {
            $statusMessage = trans(Config('constants.TESTIMONIAL.TESTIMONIAL_TITLE') . " has been activated successfully");
        }
        $user = Testimonial::find($modelId);
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
            $userDetails = Testimonial::where('testimonials.id',$user_id)->first();

            $data = compact('user_id', 'userDetails');

            return View("admin.$this->model.view", $data);
        }
    }
}
