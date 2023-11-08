<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\ChildCategory;
use App\Models\ProductValues;
use App\Models\ProductOptions;
use App\Models\ProductVariants;
use App\Models\CategorySpecification;
use App\Service\FileUploadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\OptionValueProductVariant;
use App\Models\Brand;
use App\Models\SpecificationValue;
use Validator,Response,Redirect,Str,View;

class ProductController extends Controller
{
    public $fileUploadService;
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
        $this->listRouteName = 'admin-product-list';
        View()->share('listRouteName', $this->listRouteName);
    }

    public function index(Request $request)
    {
        try {
            $DB = Product::leftJoin('categories', 'products.category_id', '=', 'categories.id')
                         ->leftJoin('categories as sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
                         ->leftJoin('categories as child_categories', 'products.child_category_id', '=', 'child_categories.id');
            $sortBy = $request->input('sortBy') ? $request->input('sortBy') : 'products.created_at';
            $order = $request->input('order') ? $request->input('order') : 'desc';
            $offset = !empty($request->input('offset')) ? $request->input('offset') : 0 ;
            $limit =  !empty($request->input('limit')) ? $request->input('limit') : Config("Reading.records_per_page");

            if ($request->all()) {
                $searchData            =    $request->all();
                unset($searchData['display']);
                unset($searchData['_token']);
                if (isset($searchData['order'])) {
                    unset($searchData['order']);
                }
                if (isset($searchData['sortBy'])) {
                    unset($searchData['sortBy']);
                }
                if (isset($searchData['offset'])) {
                    unset($searchData['offset']);
                }
                if (isset($searchData['limit'])) {
                    unset($searchData['limit']);
                }
                if ((!empty($searchData['date_from'])) && (!empty($searchData['date_to']))) {
                    $dateS = $searchData['date_from'];
                    $dateE = $searchData['date_to'];
                    $DB->whereBetween('products.created_at', [$dateS . " 00:00:00", $dateE . " 23:59:59"]);
                } elseif (!empty($searchData['date_from'])) {
                    $dateS = $searchData['date_from'];
                    $DB->where('products.created_at', '>=', [$dateS . " 00:00:00"]);
                } elseif (!empty($searchData['date_to'])) {
                    $dateE = $searchData['date_to'];
                    $DB->where('products.created_at', '<=', [$dateE . " 00:00:00"]);
                }
                foreach ($searchData as $fieldName => $fieldValue) {
                    if ($fieldValue != "") {
                        if ($fieldName == "name") {
                            $DB->where("products.name", 'like', '%' . $fieldValue . '%');
                        }
                        
                        if ($fieldName == "category_id") {
                            $DB->where("products.category_id", $fieldValue);
                        }
                        if ($fieldName == "sub_category_id") {
                            $DB->where("products.sub_category_id", $fieldValue);
                        }
                        if ($fieldName == "child_category_id") {
                            $DB->where("products.child_category_id", $fieldValue);
                        }
                    }
                }
            }


            $results = $DB->select('products.*','categories.name as category_name','sub_categories.name as sub_category_name','child_categories.name as child_category_name')->orderBy($sortBy, $order)->offset($offset)->limit($limit)->get();
            $totalResults = $DB->count();
            if($request->ajax()){

                return  View("admin.products.load_more_data", compact('results','totalResults'));
            }else{
                
                $categories = Category::whereNull('parent_id')->where('is_deleted', 0)->get();
                return view('admin.products.list', compact('results','categories','totalResults'));
            }
            
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function create()
    {

        try {
            $categories = Category::where('is_active',1)->where('is_deleted',0)->get();
            $brands = Brand::where('is_active',1)->where('is_deleted',0)->get();
           
            // $productOptionValuesDatas = $productOptionValues->groupBy('product_option_id');
            // dd($productOptionValuesDatas);
            return view('admin.products.create',compact('categories','brands'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function generateProductNumber($lastId = 0){
		if(!empty($lastId)){
			$productNumber = "JJ-".($lastId + 10000);
			return $productNumber;
			
		}
		
	}

    public function store(Request $request) {  
        $formData	=	$request->all();
		$response	=	array();
		if(!empty($formData)){
            $basicInformationValidationArray = [
                'name' 			=> 'required',
                'bar_code' 	=> 'required',
                'category_id' 	=> 'required',
                'brand_id' 	=> 'required'
            ];
            
            $detailsValidationArray = [
                'long_description'    =>     'required',
            ];
            $pricesValidationArray = [
                'buying_price'    =>      'required|numeric|gt:0',
                'selling_price'    =>     'required|numeric|gt:0',
            ];
            // $lastStepValidationArray = [
            //     'name'                => 'required',
            //     'email' 						=> ['nullable','email', Rule::unique('users')->where('user_role_id',config('constants.ROLE_ID.CLIENT_ROLE_ID'))],
            //     'gender'               =>     'required',
            //     'date_of_birth'                  =>     'required'

            // ];

			// $request->replace($this->arrayStripTags($request->all()));
			$validator 					=	Validator::make(
				$request->all(),
                (!empty($request->current_tab) && $request->current_tab == 'basicInformationTab') ? $basicInformationValidationArray : ((!empty($request->current_tab) && $request->current_tab == 'detailsTab' ) ? $detailsValidationArray : ((  !empty($request->current_tab) && $request->current_tab == 'pricesTab') ? $pricesValidationArray : [] )), 
			
				array(
				)
			);
			
			if ($validator->fails()){
				$response				=	$this->change_error_msg_layout($validator->errors()->getMessages());
                return Response::json($response,200); 
			}else{

                if((!empty($request->current_tab) && $request->current_tab == 'basicInformationTab')){
                    $originalString = $request->name ?? "";
                    $lowercaseString = Str::lower($originalString);
                    $slug = Str::slug($lowercaseString, '-');
                    

                    $alreadyAddedName = Category::where('name', $originalString)->first();
                    
                    if (!is_null($alreadyAddedName)) {
                        return redirect()->back()->with(['error' => 'Slug is already added']);
                    }
                //    print_r($request->name);die;
                    if(!empty($request->session()->has('currentProductId'))){
                        $obj    =   Product::find($request->session()->get('currentProductId'));
                    }else{
                        $obj    =   new Product;
                    }
                    $obj->name     =   !empty($request->name) ? $request->name   : NULL;;
                    $obj->product_number     =   '00';
                    $obj->slug                          = $slug;
                    $obj->bar_code     =   $request->bar_code;
                    $obj->category_id     =   $request->category_id;
                    $obj->brand_id     =   $request->brand_id;
                    $obj->sub_category_id     =   !empty($request->sub_category_id) ? $request->sub_category_id : NULL;
                    $obj->child_category_id     =   !empty($request->child_category_id) ? $request->child_category_id : NULL;
                    $obj->save();
                    $lastId = $obj->id;
                    if(empty($lastId)){
                        $response               =   array();
                        $response["status"]		=	"error";
                        $response["msg"]		=	trans("Something Went Wrong");
                        $response["data"]		=	(object)array();
                        $response["http_code"]		=	500;
                        return Response::json($response,500);
                    }else{
                        // Putting data into session
                        $request->session()->put('currentProductId', $lastId);

                        //Update Product Number
                        Product::where('id',$lastId)->update(['product_number' => $this->generateProductNumber($lastId)]);

                        $response               =   array();
                        $response["status"]		=	"success";
                        $response["msg"]		=	"";
                        $response["data"]		=	(object)array();
                        $response["http_code"]		=	200;
                        return Response::json($response,200); 
                        
                    }
                                      
                }else if((!empty($request->current_tab)  && $request->current_tab == 'detailsTab' )){
                    if (!empty($request->session()->has('currentProductId'))) {
                        $obj    =   Product::find($request->session()->get('currentProductId'));
                        $obj->long_description = !empty($request->long_description) ? $request->long_description : NULL;
                        $obj->short_description = !empty($request->short_description) ? $request->short_description : NULL;
                        $obj->return_policy = !empty($request->return_policy) ? $request->return_policy : NULL;
                        $obj->seller_information = !empty($request->seller_information) ? $request->seller_information : NULL;
                        $obj->save();
                        $lastId = $obj->id;
                        if(empty($lastId)){
                            $response               =   array();
                            $response["status"]		=	"error";
                            $response["msg"]		=	trans("Something Went Wrong");
                            $response["data"]		=	(object)array();
                            $response["http_code"]		=	500;
                            return Response::json($response,500);
                        }else{
                           
                            $response               =   array();
                            $response["status"]		=	"success";
                            $response["msg"]		=	"";
                            $response["data"]		=	(object)array();
                            $response["http_code"]		=	200;
                            return Response::json($response,200); 
                            
                        }
                          
                     }else{
                         $response               =   array();
                         $response["status"]		=	"error";
                         $response["msg"]		=	trans("messages.Invalid_Request");
                         $response["data"]		=	(object)array();
                         $response["http_code"]		=	500;
                         return Response::json($response,500);
                     }
                }else if((!empty($request->current_tab)  && $request->current_tab == 'pricesTab' )){
                    if (!empty($request->session()->has('currentProductId'))) {
                        $obj    =   Product::find($request->session()->get('currentProductId'));
                        $obj->buying_price = !empty($request->buying_price) ? $request->buying_price : '0.00';
                        $obj->selling_price = !empty($request->selling_price) ? $request->selling_price : '0.00';
                        
                        $obj->save();
                        $lastId = $obj->id;
                        if(empty($lastId)){
                            $response               =   array();
                            $response["status"]		=	"error";
                            $response["msg"]		=	trans("Something Went Wrong");
                            $response["data"]		=	(object)array();
                            $response["http_code"]		=	500;
                            return Response::json($response,500);
                        }else{
                            $productData = Product::where('id',$lastId)->first();

                            $specificationsData = CategorySpecification::select('specifications.id', 'specifications.name')
                            ->leftJoin('specifications', 'category_specifications.specification_id', '=', 'specifications.id')
                            ->where(function ($query) use ($productData) {
                                $query->where('category_specifications.category_id', $productData->category_id)
                                    ->orWhere('category_specifications.category_id', $productData->sub_category_id)
                                    ->orWhere('category_specifications.category_id', $productData->child_category_id);
                            })
                            ->distinct()
                            ->get()->toArray();
                            if(!empty($specificationsData)){
                                foreach($specificationsData as &$dataVal){
                                    $dataVal['specification_values'] = SpecificationValue::where('specification_id',$dataVal['id'])->get()->toArray();
                                }
                            }
                          
                            $htmlData = View::make("admin.products.specifications_data", compact('specificationsData'))->render();

                            $response               =   array();
                            $response["status"]		=	"success";
                            $response["msg"]		=	"";
                            $response["data"]		=	$htmlData;
                            $response["http_code"]		=	200;
                            return Response::json($response,200); 
                            
                        }
                          
                     }else{
                         $response               =   array();
                         $response["status"]		=	"error";
                         $response["msg"]		=	trans("messages.Invalid_Request");
                         $response["data"]		=	(object)array();
                         $response["http_code"]		=	500;
                         return Response::json($response,500);
                     }
                }else if((!empty($request->current_tab)  && $request->current_tab == 'specificationsTab' )){
                    if (!empty($request->session()->has('currentProductId'))) {
                        if(!empty($request->specificationDataArr)){
                            foreach($request->specificationDataArr as $specValue){
                                if(!empty($specValue['name']) && !empty($specValue['specification_id']) && !empty($specValue['specification_values']) ){
                                    foreach($specValue['specification_values'] as $dataVal){
                                        $obj2   =  new ProductSpecfication;
                                        $obj2->product_id = $request->session()->get('currentProductId');
                                        $obj2->specification_id = $specValue['specification_id'];
                                        $obj2->specification_value_id = $dataVal;
                                        $obj2->save();
                                    }
                                  
                                }
                            }
                        }
                        $response               =   array();
                        $response["status"]		=	"success";
                        $response["msg"]		=	"";
                        $response["data"]		=	(object)array();
                        $response["http_code"]		=	200;
                        return Response::json($response,200); 
                          
                     }else{
                         $response               =   array();
                         $response["status"]		=	"error";
                         $response["msg"]		=	trans("messages.Invalid_Request");
                         $response["data"]		=	(object)array();
                         $response["http_code"]		=	500;
                         return Response::json($response,500);
                     }
                }else if((!empty($request->current_tab) && !empty($request->type)  && $request->current_tab == 'second_step' && $request->type == 'resend_otp'  )){
                    if ($request->session()->has('customer_login_data')) {
                        $userSignupData =  $request->session()->get('customer_login_data');

                       
                        if($userSignupData['phone_number'] == "8279249283"){
                            $verification_code = "123456";
                        }else{
                            $verification_code   =  $this->getVerificationCodeUSer();
                        }

                        $getLatestVerificationCode = UserOtpHistory::where('phone_number_prefix',$userSignupData['phone_number_prefix'])->where('phone_number',$userSignupData['phone_number'])->orderBy('created_at','desc')->first();
                        if(!empty($getLatestVerificationCode)){
                            if($getLatestVerificationCode->created_at > date("Y-m-d H:i:s",strtotime("-55 seconds"))){
                                $response               =   array();
                                $response["status"]		=	"error";
                                $response["msg"]		=	"You have recently requested to OTP. Please wait for a minute.";
                                $response["data"]		=	(object)array();
                                $response["http_code"]		=	200;
                                return Response::json($response,200); 
                            }
                        }

                        //SEND OTP ON MOBILE AND EMAIL If Exists for customer
                        if(env("PROJECT_ENVIRONMENT") == 1){
                            $message	=	trans("Verify your mobile number on My Astro. Your OTP is: ").$verification_code.".";
                            $this->sendSms($userSignupData['phone_number_prefix'].$userSignupData['phone_number'],$message,"verify_otp");
                        }
                        
                  

                        // Inserting entry in user otp histories table
                        $otpObj                          =    new UserOtpHistory;
                        $otpObj->phone_number_prefix     =   $userSignupData['phone_number_prefix'];
                        $otpObj->phone_number     =   $userSignupData['phone_number'];
                        $otpObj->verification_code     =  $verification_code;
                        $otpObj->save();

                        $response               =   array();
                        $response["status"]		=	"success";
                        $response["msg"]		=	trans("messages.otp_has_been_sent_successfully_on_your_registered_mobile_number_and_email_id");
                        $response["data"]		=	(object)array();
                        $response["http_code"]		=	200;
                        return Response::json($response,200);   
                    }else{
                        $response               =   array();
                        $response["status"]		=	"error";
                        $response["msg"]		=	trans("messages.Invalid_Request");
                        $response["data"]		=	(object)array();
                        $response["http_code"]		=	500;
                        return Response::json($response,500);    
                    }


                }else if((!empty($request->current_tab) && $request->current_tab == 'last_step')){
                    if ($request->session()->has('customer_login_data')) {
                       $userSignupData =  $request->session()->get('customer_login_data');
                       $userSignupData['gender']   =  $request->gender;
                       $userSignupData['date_of_birth']   =  $request->date_of_birth;
                       $userSignupData['email']   =  !empty($request->email) ? $request->email : '';
                       $userSignupData['name']   =  $request->name;

                       $password = $this->generateRandomPassword();
                       DB::beginTransaction();
                        $obj 									=  new User;
                        $obj->user_role_id	 					=  config('constants.ROLE_ID.CLIENT_ROLE_ID');
                        $obj->forgot_password_validate_string	=  md5($request->input('email').time().time());
                        $obj->name 								=  $userSignupData['name'];
                        $obj->display_name 					    =  $userSignupData['name'];
                        $obj->email 							=  !empty($userSignupData['email']) ? $userSignupData['email'] : '' ;
                        $obj->phone_number_prefix 				=  $userSignupData['phone_number_prefix'];
                        $obj->phone_number_country_code 		=  $userSignupData['phone_number_country_code'];
                        $obj->phone_number 						=  $userSignupData['phone_number'];
                        $obj->gender 						    =  $userSignupData['gender'];
                        $obj->date_of_birth 					=  date('Y-m-d',strtotime(str_replace('/','-',$userSignupData['date_of_birth'])));
                        $obj->password	 						=  Hash::make($password);
                        $obj->created_from	 					=  'self';
                        $obj->is_verified	 					=  1;
                        $obj->is_active							=  1;
                        $obj->is_approved						=  0;
                        $obj->save();
                        $userId = $obj->id;

                        if(empty($userId)){
                            DB::rollback();
                            $response               =   array();
                            $response["status"]		=	"error";
                            $response["msg"]		=	trans("messages.something_went_wrong");
                            $response["data"]		=	(object)array();
                            $response["http_code"]		=	500;
                            return Response::json($response,500);
                        }

                        DB::commit();

                         if(!empty($userSignupData['email'])){
                            $lang			=	App::getLocale();
                            $language_id	=	DB::table("languages")->where("lang_code",$lang)->value("id");
    
                            $settingsEmail 		=  Config::get('Site.email');
                            $full_name			=  $userSignupData['name'];
                            $email              =  $userSignupData['email'];
                            $emailActions		= 	EmailAction::where('action','=','customer_on_successful_registration')->get()->toArray();
                            $emailTemplates		= 	EmailTemplate::where('action','=','customer_on_successful_registration')->select("name","action",DB::raw("(select subject from email_template_descriptions where parent_id=email_templates.id AND language_id='$language_id')as subject"),DB::raw("(select body from email_template_descriptions where parent_id=email_templates.id AND language_id='$language_id')as body"))->get()->toArray();

                            $cons 				= 	explode(',',$emailActions[0]['options']);
                            $constants 			= 	array();
                            foreach($cons as $key=>$val){
                                $constants[] = '{'.$val.'}';
                            }
                            $subject 			=  $emailTemplates[0]['subject'];
                            $rep_Array 			= 	array($full_name);
                            $messageBody		=   str_replace($constants, $rep_Array,$emailTemplates[0]['body']);
                            $this->sendMail($email,$full_name,$subject,$messageBody,$settingsEmail);
                        }

                        $request->session()->forget('customer_login_data');

                        if($request->wantsJson()){
                                
                            $user_details			=	User::where("id",$obj->id)->first();

                            $token        			=	$user_details->createToken(Config('Site.title').' app Personal Access Client')->accessToken;
                            
                            $response["status"]		=	"success";
                            $response["msg"]		=	trans("messages.You_are_now_logged_in");
                            $response["data"]		=	$user_details;
                            $response["token"]		=	$token;
                            return json_encode($response);
                        }else{
                       
                            Auth::guard(getGuard())->login($obj);
                            $response               =   array();
                            $response["status"]		=	"success";
                            $response["msg"]		=	trans("messages.You_are_now_logged_in");
                            $response["data"]		=	(object)array();
                            $response["http_code"]		=	200;
                            return Response::json($response,200);  
                        }

                        

                      

                    }else{
                        $response               =   array();
                        $response["status"]		=	"error";
                        $response["msg"]		=	trans("messages.Invalid_Request");
                        $response["data"]		=	(object)array();
                        $response["http_code"]		=	500;
                        return Response::json($response,500);
                    }
                }else{
                    $response               =   array();
                    $response["status"]		=	"error";
                    $response["msg"]		=	trans("messages.Invalid_Request");
                    $response["data"]		=	(object)array();
                    $response["http_code"]		=	500;
                    return Response::json($response,500);    
                }
                
               
			}
		}
		return json_encode($response);
    }

    // public function store(Request $request)
    // {
    //     print_r($request->all());die;
    //     try {
    //         // dd($request->all());
    //         $frontSelectedFile = $request->front_image ?? "";
    //         $backSelectedFile = $request->back_image ?? "";
    //         $productImageFiles = $request->product_images ?? "";
    //         $productVideosFiles = $request->product_videos ?? "";
    //         $productOptionValueids = $request->product_option_value_id ?? [];

    //         if ($frontSelectedFile) {
    //             $frontImage = $request->file('front_image');
    //             $frontImagePath = "products/variants/front-images";
    //             $frontUploadedFile = $this->fileUploadService->uploadFile($frontImage, $frontImagePath);
    //         }

    //         if ($backSelectedFile) {
    //             $backImage = $request->file('back_image');
    //             $backImagePath = "products/variants/back-images";
    //             $backUploadedFile = $this->fileUploadService->uploadFile($backImage, $backImagePath);
    //         }

    //         if ($productImageFiles) {
    //             foreach ($request->file('product_images') as $productImage) {
    //                 $productImagePath = "products/variants/images";
    //                 $productImagesUploadedFiles[] = $this->fileUploadService->uploadFile($productImage, $productImagePath);
    //             }
    //         }

    //         if ($productVideosFiles) {
    //             foreach ($request->file('product_videos') as $productVideo) {
    //                 $productVideoPath = "products/variants/videos";
    //                 $productVideosUploadedFiles[] = $this->fileUploadService->uploadFile($productVideo, $productVideoPath);
    //             }
    //         }

    //         DB::beginTransaction();

    //         $product = Product::create([
    //             'name' => $request->name,
    //             'category_id' => $request->category_id,
    //             'sub_category_id' => $request->sub_category_id ?? null,
    //             'child_category_id' => $request->child_category_id ?? null,
                
                
    //         ]);

    //         $productVariant = ProductVariants::create([
    //             'product_id' => $product->id,
    //             'short_description' => $request->short_description,
    //             'description' => $request->description ?? null,
    //             'front_image' => $frontUploadedFile,
    //             'back_image' => $backUploadedFile,
    //             'images' => json_encode($productImagesUploadedFiles) ?? null,
    //             'videos' => json_encode($productVideosUploadedFiles) ?? null,
    //             'price' => $request->price ?? 100,
    //             'meta_title' => $request->meta_title ?? null,
    //             'meta_description' => $request->meta_description ?? null,
    //             'meta_keywords' => $request->meta_keywords ?? null,
    //         ]);

    //         foreach ($productOptionValueids as $item) {
    //             $productOptionValuesVariant = OptionValueProductVariant::create([
    //                 'value_id' => $item,
    //                 'variant_id' => $productVariant->id,
    //             ]);
    //         }

    //         DB::commit();

    //         return redirect()->route('admin-product-list')->with('success', 'Product created successfully');
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::error($e);
    //         return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
    //     }
    // }

    public function view($token) {
        try {
            $productId = decrypt($token);
            $product = Product::find($productId);
            return view('admin.products.view', compact('product'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function edit($token)
    {
        try {
            $productId = decrypt($token);

            $categories = Category::get();
            $subCategories = SubCategory::get();
            $childCategories = ChildCategory::get();
            $productId = decrypt($token);
            $product = Product::find($productId);
            $productOptions = ProductOptions::whereHas('productOptionValues')->get();
            // dd($productOptions);
            $productOptionValues = ProductValues::get();
            $productOptionValuesDatas = $productOptionValues->groupBy('product_option_id');
            return view('admin.products.edit', compact('categories','subCategories','childCategories','product','productOptions','productOptionValues','productOptionValuesDatas'));
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $token)
    {
        try {
            $productId = decrypt($token);
            $product = Product::find($productId);
            $oldFrontImage = $product->front_image;
            $oldBackImage = $product->back_image;
            $oldProductsImages = $product->images;
            $oldProductsVideos = $product->videos;

            $frontSelectedFile = $request->front_image ?? "";
            $backSelectedFile = $request->back_image ?? "";
            $editProductImageFiles = $request->edit_product_images ?? "";
            $productVideosFiles = $request->product_videos ?? "";

            if ($frontSelectedFile) {
                $frontImage = $request->file('front_image');
                $frontImagePath = "products/variants/front-images";
                $frontUploadedFile = $this->fileUploadService->uploadFile($frontImage, $frontImagePath);
            }

            if ($backSelectedFile) {
                $backImage = $request->file('back_image');
                $backImagePath = "products/variants/back-images";
                $backUploadedFile = $this->fileUploadService->uploadFile($backImage, $backImagePath);
            }

            if ($editProductImageFiles) {
                foreach ($request->file('edit_product_images') as $editProductImage) {
                    $productImagePath = "products/variants/images";
                    $editProductImagesUploadedFile[] = $this->fileUploadService->uploadFile($editProductImage, $productImagePath);
                }
            }

            if ($productVideosFiles) {
                foreach ($request->file('product_videos') as $productVideo) {
                    $productVideoPath = "products/variants/videos";
                    $editProductVideosUploadedFiles[] = $this->fileUploadService->uploadFile($productVideo, $productVideoPath);
                }
            }

            $product = tap($product)->update([

                'name' => $request->name,
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id ?? null,
                'child_category_id' => $request->child_category_id ?? null,
              
            ]);

            // $productVariant = ProductVariants::where('product_id',$product->id)->first();
            $productVariant = ProductVariants::create([
                'product_id' => $product,
                'short_description' => $request->short_description,
                'description' => $request->description ?? null,
                'front_image' => $frontUploadedFile ?? $oldFrontImage,
                'back_image' => $backUploadedFile ?? $oldBackImage,
                'images' => json_encode($editProductImagesUploadedFile) ?? $oldProductsImages,
                'videos' => json_encode($editProductVideosUploadedFiles) ?? null,
                'price' => $request->price,
                'meta_title' => $request->meta_title ?? null,
                'meta_description' => $request->meta_description ?? null,
                'meta_keywords' => $request->meta_keywords ?? null,
            ]); 
            return redirect()->route('admin-product-list')->with('success', 'Product updated successfully');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function destory($token)
    {
        try {
            $productId = decrypt($token);
            $product = Product::find($productId);
            $product->delete();
            return redirect()->route('admin-product-list')->with('success', 'Product deleted successfully');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function getSubCategories(Request $request)
    {
        try {
            $categoryId = $request->category_id ?? "";
            $subCategories = Category::where('parent_id',$categoryId)->where('is_active',1)->where('is_deleted',0)->get();

            return response()->json(['subCategories' => $subCategories, 'success' => true, 'message' => 'Data fetched'], 200);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'Something is wrong', 'success' => false, 'error_msg' => $e->getMessage()], 500);
        }
    }

    public function getChildCategories(Request $request)
    {
        try {
            $subCategoryId = $request->sub_category_id ?? "";
            $childCategories = Category::where('parent_id',$subCategoryId)->where('is_active',1)->where('is_deleted',0)->get();

            return response()->json(['childCategories' => $childCategories, 'success' => true, 'message' => 'Data fetched'], 200);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'Something is wrong', 'success' => false, 'error_msg' => $e->getMessage()], 500);
        }
    }
}