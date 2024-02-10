<?php

namespace App\Http\Controllers\Front\Auth;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\AuthRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Redirect,Session,Config,DB,Response,Str;
use App\Models\User;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            return view('front.modules.auth.login');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Somethig went wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function signup(Request $request)
    {
        try {
            return view('front.modules.auth.signup');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Somethig went wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function postLogin(Request $request){
        $formData	=	$request->all();
        
		$response	=	array();
		if(!empty($formData)){
			$request->replace($this->arrayStripTags($request->all()));
            
			$validator = Validator::make(
				$request->all(),
				array(
					'email' 				            => 'required',
					'password' 							=> 'required',
				),
				array(
					"email.required"		 	            => trans("The email field is required"),
					"password.required"			 			=> trans("The password field is required"),
				)
			);
			if ($validator->fails()){
                return Redirect::back()->withErrors($validator)->withInput();
                
               
			}else{
				$email				=	$request->input("email");
				
				$user_details			=	User::where("email",$email)->where('user_role_id',config('constant.ROLE_ID.CUSTOMER_ROLE_ID'))
													->where("is_deleted",0) 
													->first();
                                                 
				if(!empty($user_details)){
					$AuthAttemptUser = (!empty($user_details)) ? Hash::check($request->input('password'), $user_details->getAuthPassword()) : array();
					if(!empty($AuthAttemptUser)){
						if($user_details->is_active == 0){
							return Redirect::back()->with('error', trans("Your account is blocked. Please contact admin"));
						}else {
                            Auth::guard('customer')->login($user_details);
                            moveCartDataFromSession();
                                
                                Session::flash('flash_notice', trans('You are now logged in'));
                                return Redirect::route('front-user.dashboard');
                            
						}
					}else {
						return Redirect::back()->with('error', trans("Email or password is incorrect"));
					}
				}else {
					return Redirect::back()->with('error', trans('Your email is not registered with '.Config::get("Site.title")));
				}
			}
		}else {
            
			return Redirect::back()->with('error', trans("Invalid Request"));
		}
		
    }

    public function postSignup(Request $request){
        $formData	=	$request->all();
		$response	=	array();
		if(!empty($formData)){
			$request->replace($this->arrayStripTags($request->all()));
            
			$validator = Validator::make(
				$request->all(),
				array(
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => ['required','email', Rule::unique('users')->where('user_role_id',config('constant.ROLE_ID.CUSTOMER_ROLE_ID'))],
                    'phone_number' =>  ['required','numeric', Rule::unique('users')->where('user_role_id',config('constant.ROLE_ID.CUSTOMER_ROLE_ID')),'digits:10'],
                    'password'      =>         ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
                    'confirm_password' =>      'required|same:password',
				)
			);
			if ($validator->fails()){
                return Redirect::back()->withErrors($validator)->withInput();
                
               
            } else {
                DB::beginTransaction();

                $originalString = $request->first_name." ".$request->last_name;
                $lowercaseString = Str::lower($originalString);
                $baseSlug = Str::slug($lowercaseString, '-');

                // Check if the base slug already exists
                $alreadyAddedName = User::where('slug', $baseSlug)->first();

                if (!is_null($alreadyAddedName)) {
                    // If the base slug exists and the name is being changed, add a suffix
                    $suffix = 1;

                    while (User::where('slug', $baseSlug . '-' . $suffix)->exists()) {
                        $suffix++;
                    }

                    $slug = $baseSlug . '-' . $suffix;
                } else {
                    $slug = $baseSlug;
                }

                $obj                                = new User;
                $obj->user_role_id                  = config('constant.ROLE_ID.CUSTOMER_ROLE_ID');
                $obj->slug                          = !empty($slug) ? $slug : "";
                $obj->name                          = $request->input('first_name')." ".$request->input('last_name');
                $obj->email                         = $request->input('email');
                $obj->phone_number                  = $request->input('phone_number');
                $obj->date_of_birth =   NULL;
                $obj->gender = NULL;
                $obj->password                             =  Hash::make($request->input('password'));
                $obj->is_verified = 1;
                $obj->is_active = 1;
                $obj->is_approved = 1;

                $obj->save();
                $lastId = $obj->id;
                if(!empty($lastId)){
                    $randomLetters = strtoupper(Str::random(3));

                    $referralCode = $slug . $randomLetters . $lastId;

                    // Save the referral code to the user or do whatever is needed
                    User::where('id', $lastId)->update(["referral_code"=>$referralCode]);

                    DB::commit();
                }else{
                    DB::rollback();
                    Session()->flash('flash_notice', 'Something Went Wrong');
                    return Redirect::route('front-user.signup');
                }
                Session()->flash('flash_notice', trans("You have been registered successfully. Please login to access your dashboard."));
                return Redirect::route('front-user.login');
            }
		}else {
            
			return Redirect::back()->with('error', trans("Invalid Request"));
		}
		
    }

    public function forgetPassword() {  
     
        return view('front.modules.auth.forget_password');
    }

    public function resetPassword($validate_string=null,Request $request){
        if($validate_string!="" && $validate_string!=null){
    
            $userDetail	=	User::where('is_active','1')->where('forgot_password_validate_string',$validate_string)->first();
            if(!empty($userDetail)){
                return View::make('front.modules.auth.reset_password' ,compact('validate_string'));
            }else{
                return Redirect::route('front-user.login')
                ->with('error', trans('Sorry, you are using wrong link.'));
            }
    
        }else{
            return Redirect::route('front-user.login')->with('error', trans('Sorry, you are using wrong link.'));
        }
    }// end resetPassword()

    public function sendPassword(Request $request){
        $thisData				=	$request->all();
        $messages = array(
            'email.required' 		=> trans('The email field is required.'),
            'email.email' 			=> trans('The email must be a valid email address.'),
        );
        $validator = Validator::make(
            $request->all(),
            array(
                'email' 			=> 'required|email',
            ),$messages
        );
        if ($validator->fails()){		
            return Redirect::back()
            ->withErrors($validator)->withInput();
        }else{
            $email		=	$request->input('email');   
            $userDetail	=	User::where('email',$email)->where('user_role_id',config('constant.ROLE_ID.CUSTOMER_ROLE_ID'))->first();
            if(!empty($userDetail)){
                if($userDetail->is_active == 1 ){
                    $forgot_password_validate_string	= 	md5($userDetail->email.time().time());
                    User::where('email',$email)->update(array('forgot_password_validate_string'=>$forgot_password_validate_string));
    
                    $settingsEmail 		=  Config::get('Site.email');
                    $email 				=  $userDetail->email;
                    $full_name			=  $userDetail->name;  
                    $route_url      	= route('front-user.resetPassword',$forgot_password_validate_string);
    
                    // $emailActions		=	EmailAction::where('action','=','forgot_password')->get()->toArray();
                    // $language_id			=	1;
                    // $emailTemplates			= 	EmailTemplate::where('action','=','forgot_password')->select("name","action",DB::raw("(select subject from email_template_descriptions where parent_id=email_templates.id AND language_id=$language_id) as subject"),DB::raw("(select body from email_template_descriptions where parent_id=email_templates.id AND language_id=$language_id) as body"))->get()->toArray();
    
                    // $cons = explode(',',$emailActions[0]['options']);
                    // $constants = array();
    
                    // foreach($cons as $key=>$val){
                    //     $constants[] = '{'.$val.'}';
                    // }
                    // $subject 			=  $emailTemplates[0]['subject'];
                    // $rep_Array 			= array($email,$route_url); 
                    // $messageBody		=  str_replace($constants, $rep_Array, $emailTemplates[0]['body']);
    
                    // $this->sendMail($email,$full_name,$subject,$messageBody,$settingsEmail);
                    Session::flash('flash_notice', trans('An email has been sent to your inbox. To reset your password please follow the steps mentioned in the email.')); 
                    return Redirect::route('front-user.forgetPassword');						
                }else{
                    return Redirect::route('front-user.forgetPassword')->with('error', trans('Your account has been temporarily disabled. Please contact administrator to unlock.'));
                }	
            }else{
                return Redirect::route('front-user.forgetPassword')->with('error', trans('Your email is not registered with '.config::get("Site.title")."."));
            }		
        }
    }// sendPassword()	

    public function resetPasswordSave($validate_string=null,Request $request){
        $thisData				=	$request->all();
        $newPassword		=	$request->input('new_password');
       
        $messages = array(
            'new_password.required' 				=> trans('The new password field is required.'),
            'new_password_confirmation.required' 	=> trans('The confirm password field is required.'),
            'new_password.confirmed' 				=> trans('The confirm password must be match to new password.'),
            'new_password.min' 						=> trans('The password must be at least 8 characters.'),
            'new_password_confirmation.min' 		=> trans('The confirm password must be at least 8 characters.'),
            "new_password.custom_password"			=>	"Password must have combination of numeric, alphabet and special characters.",
        );
        
        Validator::extend('custom_password', function($attribute, $value, $parameters) {
            if (preg_match('#[0-9]#', $value) && preg_match('#[a-zA-Z]#', $value) && preg_match('#[\W]#', $value)) {
                return true;
            } else {
                return false;
            }
        });
        $validator = Validator::make(
            $request->all(),
            array(
                'new_password'			=> 'required|min:8|custom_password',
                'new_password_confirmation' => 'required|same:new_password', 
    
            ),$messages
        );
        if ($validator->fails()){	
            return Redirect::route('front-user.resetPassword',$validate_string)
            ->withErrors($validator)->withInput();
        }else{
            
            $userInfo = User::where('forgot_password_validate_string',$validate_string)->first();
            if(empty($userInfo)){
                Session::flash('error', trans('Invalid Validate String.')); 
                return Redirect::back();
            }
            User::where('forgot_password_validate_string',$validate_string)
            ->update(array(
                'password'							=>	Hash::make($newPassword),
                'forgot_password_validate_string'	=>	''
            ));
            $settingsEmail 		= Config::get('Site.email');			
            // $action				= "reset_password";
    
            // $emailActions		=	EmailAction::where('action','=','reset_password')->get()->toArray();
    
            // $language_id			=	1;
            // $emailTemplates		= 	EmailTemplate::where('action','=','reset_password')->select("name","action",DB::raw("(select subject from email_template_descriptions where parent_id=email_templates.id AND language_id=$language_id)as subject"),DB::raw("(select body from email_template_descriptions where parent_id=email_templates.id AND language_id=$language_id)as body"))->get()->toArray();
            // $cons 				= 	explode(',',$emailActions[0]['options']);
            // $constants 			= 	array();
            // foreach($cons as $key=>$val){
            //     $constants[] = '{'.$val.'}';
            // }
    
            // $subject 			=  $emailTemplates[0]['subject'];
            // $rep_Array 			= array(Lookup::getLookupCode($userInfo->name_title)." ".$userInfo->name); 
            // $messageBody		=  str_replace($constants, $rep_Array, $emailTemplates[0]['body']);
    
            // $this->sendMail($userInfo->email,$userInfo->name,$subject,$messageBody,$settingsEmail);
            Session::flash('flash_notice', trans('Thank you for resetting your password. Please login to access your account.')); 
    
            return Redirect::route('front-user.login');	
        }
    }// end resetPasswordSave()

    public function logout()
    {
        try {
            $user = auth()->guard('customer')->user();
            session()->flush();
            cache()->flush();
            auth()->guard('customer')->logout();

            return redirect()->route('front-user.login')->with('success', "You're logged out successfully");
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Somethig went wrong', 'error_msg' => $e->getMessage()]);
        }
    }
}
