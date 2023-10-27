<?php

namespace App\Http\Controllers\Admin;

use App\Config;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Redirect,DB,Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class UsersController extends Controller
{
    public $model = 'admin_users';
    public function __construct(Request $request)
    {
        View()->share('model', $this->model);
        $this->request = $request;
    }

    public function index(Request $request)
    {
        $DB = User::query();
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
                $DB->whereBetween('users.created_at', [$dateS . " 00:00:00", $dateE . " 23:59:59"]);
            } elseif (!empty($searchData['date_from'])) {
                $dateS = $searchData['date_from'];
                $DB->where('users.created_at', '>=', [$dateS . " 00:00:00"]);
            } elseif (!empty($searchData['date_to'])) {
                $dateE = $searchData['date_to'];
                $DB->where('users.created_at', '<=', [$dateE . " 00:00:00"]);
            }
            foreach ($searchData as $fieldName => $fieldValue) {
                if ($fieldValue != "") {
                    if ($fieldName == "name") {
                        $DB->where("users.name", 'like', '%' . $fieldValue . '%');
                    }
                    if ($fieldName == "phone_number") {
                        $DB->where("users.phone_number", 'like', '%' . $fieldValue . '%');
                    }
                    if ($fieldName == "email") {
                        $DB->where("users.email", 'like', '%' . $fieldValue . '%');
                    }
                    if ($fieldName == "is_active") {
                        $DB->where("users.is_active", 'like', '%' . $fieldValue . '%');
                    }
                }
                $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }
        $DB->where("users.is_deleted", 0);
        $DB->where("users.user_role_id", 2);
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'users.created_at';
        $order = ($request->input('order')) ? $request->input('order') : 'DESC';
        $records_per_page = ($request->input('per_page')) ? $request->input('per_page') : Config("Reading.records_per_page");
        $results = $DB->orderBy($sortBy, $order)->paginate($records_per_page);
        
        
        $complete_string = $request->query();
        unset($complete_string["sortBy"]);
        unset($complete_string["order"]);
        $query_string = http_build_query($complete_string);
        $results->appends($inputGet)->render();
        $resultcount = $results->count();

        if(!empty($results)) {
            foreach($results as &$result) {
                if(!empty($result->image)){
                    $result->image = Config('constant.USER_IMAGE_URL').$result->image;
                }
            }
        }
        return View("admin.$this->model.index", compact('resultcount', 'results', 'searchVariable', 'sortBy', 'order', 'query_string'));
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
            $userDetails = User::where('users.id',$user_id)->first();

            if(!empty($userDetails->image)){
                $userDetails->image = Config('constant.USER_IMAGE_URL').$userDetails->image;
            }

            return View("admin.$this->model.edit", compact( 'userDetails'));
        }
    }
    public function save(Request $request)
    {

        $formData = $request->all();
        
        if (!empty($formData)) {
            $validator = Validator::make(
                $request->all(),
                array(

                    'name' => 'required',
                    'email' => 'required|email',
                    'phone_number' =>  ['required','numeric', Rule::unique('users')->where('user_role_id',config('constant.ROLE_ID.CUSTOMER_ROLE_ID')),'digits:10'],
                    'image' => 'nullable|mimes:jpg,jpeg,png',
                    'gender' => 'required',
                    'date_of_birth' => 'required',
                ),
                array(
                    "name.required" => trans("The name field is required."),
                    "phone_number.required" => trans("The phone number field is required."),
                    "phone_number.numeric" => trans("The phone number should be numeric."),
                    "email.required" => trans("The email field is required."),
                    "email.email" => trans("The email must be a valid email address"),
                    "email.unique" => trans("The email has already been taken."),
                    "phone_number.unique" => trans("The phone number has already been taken."),
                    "image.required" => trans("The profile image field is required."),
                    "date_of_birth.required" => trans("The date of birth field is required."),
                    "gender.required" => trans("The gender field is required."),
                    "image.mimes" => trans("The profile image should be of type jpeg,jpg,png."),
                )
            );
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            } else {
                DB::beginTransaction();
                $obj                                = new User;
                $obj->user_role_id                  = 2;
                $obj->name                          = $request->input('name');
                $obj->email                         = $request->input('email');
                $obj->phone_number                  = $request->input('phone_number');
                $obj->date_of_birth =   !empty($request->input('date_of_birth')) ? date('Y-m-d', strtotime($request->input('date_of_birth'))) : NULL;
                $obj->gender = $request->input('gender');
                $obj->password = Hash::make($this->generateRandomPassword());
                // if(!empty($request->password)){
                //     $obj->password                      = Hash::make($request->password);
                // }
                if ($request->hasFile('image')) {
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $originalName = $request->file('image')->getClientOriginalName();
                    $fileName = time() . '-image.' . $extension;

                    $folderName = strtoupper(date('M') . date('Y')) . "/";
                    $folderPath = Config('constant.USER_IMAGE_ROOT_PATH') . $folderName;
                    if (!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777, true);
                    }
                    if ($request->file('image')->move($folderPath, $fileName)) {
                        $obj->image = $folderName . $fileName;
                    }
                }
                $obj->is_verified = 1;
                $obj->is_active = 1;
                $obj->is_approved = 1;

                $obj->save();
                $lastId = $obj->id;
                if(!empty($lastId)){
                    DB::commit();
                }else{
                    DB::rollback();
                    Session()->flash('flash_notice', 'Something Went Wrong');
                    return Redirect::route('admin-admin_users.index');
                }
                Session()->flash('flash_notice', trans("User saved successfully."));
                return Redirect::route('admin-admin_users.index');
            }
        }

    }
    public function update(Request $request, $enuserid = null)
    {
        
        $model = User::find($enuserid);
        if (empty($model)) {
            return View("admin.$this->model.edit");
        } else {
            $formData = $request->all();
            if (!empty($formData)) {
                $validator = Validator::make(
                    $request->all(),
                    array(

                        'name' => 'required',
                        'email' => 'nullable|email',
                        'phone_number' => ['required','numeric', Rule::unique('users')->ignore($enuserid)->where('user_role_id',config('constant.ROLE_ID.CUSTOMER_ROLE_ID')),'digits:10'],
                        'image' => 'nullable|mimes:jpg,jpeg,png',
                        'gender' => 'required',
                        'date_of_birth' => 'required',

                    ),
                    array(

                        "name.required" => trans("The name field is required."),
                        "phone_number.required" => trans("The phone number field is required."),
                        "phone_number.numeric" => trans("The phone number should be numeric."),
                        "email.required" => trans("The email field is required."),
                        "email.email" => trans("The email must be a valid email address"),
                        "email.unique" => trans("The email has already been taken."),
                        "phone_number.unique" => trans("The phone number has already been taken."),
                        "image.required" => trans("The profile image field is required."),
                        "image.mimes" => trans("The profile image should be of type jpeg,jpg,png."),
                        "date_of_birth.required" => trans("The date of birth field is required."),
                        "gender.required" => trans("The gender field is required."),
                    )
                );
                if ($validator->fails()) {
                    return Redirect::back()->withErrors($validator)->withInput();
                } else {
                    DB::beginTransaction();
                    $obj                                = $model;
                    $obj->name                          = $request->input('name');
                    $obj->email                         = $request->input('email');
                    $obj->phone_number                  = $request->input('phone_number');
                    
                    $obj->date_of_birth =   !empty($request->input('date_of_birth')) ? date('Y-m-d', strtotime($request->input('date_of_birth'))) : NULL;
                    $obj->gender = $request->input('gender');
                   
                    if ($request->hasFile('image')) {
                        $extension = $request->file('image')->getClientOriginalExtension();
                        $originalName = $request->file('image')->getClientOriginalName();
                        $fileName = time() . '-image.' . $extension;

                        $folderName = strtoupper(date('M') . date('Y')) . "/";
                        $folderPath = Config('constant.USER_IMAGE_ROOT_PATH') . $folderName;
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
                    if(!empty($lastId)){
                        DB::commit();
                    }else{
                        DB::rollback();
                        Session()->flash('flash_notice', 'Something Went Wrong');
                        return Redirect::route('admin-admin_users.index');
                    }
                    Session()->flash('flash_notice', trans("User updated successfully."));
                    return Redirect::route('admin-admin_users.index');
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
        $userDetails = User::find($user_id);
        if (empty($userDetails)) {
            return Redirect()->route($this->model . '.index');
        }
        if ($user_id) {
            $email = 'delete_' . $user_id . '_' . $userDetails->email;
            $deleted_at = Carbon::now();
            // $phone_number = 'delete_' . $user_id . '_' . !empty($userDetails->phone_number);

            User::where('id', $user_id)->update(array(
                'email' => $email,
                'is_deleted' => 1,
                'deleted_at' => $deleted_at
                
            ));

            Session()->flash('flash_notice', trans("User has been removed successfully."));
        }
        return back();
    }

    public function changeStatus($modelId = 0, $status = 0)
    {
        if ($status == 1) {
            $statusMessage = trans("User has been deactivated successfully");
        } else {
            $statusMessage = trans("User has been activated successfully");
        }
        $user = User::find($modelId);
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

    public function changedPassword(Request $request, $enuserid = null)
    {
        $user_id = '';
        if (!empty($enuserid)) {
            $user_id = base64_decode($enuserid);
        } else {
            return redirect()->route($this->model . ".index");
        }
        if ($request->isMethod('POST')) {
            if (!empty($user_id)) {
                $validated = $request->validate([
                    'new_password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
                    'confirm_password' => 'required|same:new_password',
                ]);
                $userDetails = User::find($user_id);
                $userDetails->password = Hash::make($request->new_password);
                $SavedResponse = $userDetails->save();
                if (!$SavedResponse) {
                    Session()->flash('error', trans("Something went wrong."));
                    return Redirect()->back();
                }
                Session()->flash('success', trans("Password changed successfully."));
                return Redirect()->route($this->model . '.index');
            }
        }
        $userDetails = array();
        $userDetails = User::find($user_id);
        $data = compact('userDetails');
        return view("admin.$this->model.change_password", $data);
    }


    public function show(Request $request, $enuserid = null)
    {
        $user_id = '';
        if (!empty($enuserid)) {

            $user_id = base64_decode($enuserid);
            $userDetails = User::where('users.id',$user_id)->first();

            if(!empty($userDetails->image)){
                $userDetails->image = Config('constant.USER_IMAGE_URL').$userDetails->image;
            }
           
            $data = compact('user_id', 'userDetails');

            return View("admin.$this->model.view", $data);
        }
    }

}