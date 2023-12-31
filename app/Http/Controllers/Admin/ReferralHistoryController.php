<?php

namespace App\Http\Controllers\Admin;

use App\Config;
use App\Http\Controllers\Controller;
use App\Models\Lookup;
use App\Models\User;
use App\Models\ReferralHistory;
use App\Models\Language;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Redirect,DB,Str,View,Auth;

class ReferralHistoryController extends Controller
{
    public $model = 'referral_histories';

    public function __construct(Request $request)
    {
        $this->listRouteName = 'admin-referral_histories.index';
        View()->share('model', $this->model);
        View()->share('listRouteName', $this->listRouteName);
        $this->request = $request;

    }

    public function index(Request $request)
    {
        if (Auth::user()->user_role_id == 4) {
            $getData = ReferralHistory::leftjoin('users as users_by','referral_histories.referral_by','users_by.id')
            ->leftjoin('users as users_to','referral_histories.referral_to','users_to.id')
            ->where('referral_histories.referral_by', Auth::user()->id)
            ->select('referral_histories.*','users_by.name as by_name','users_to.name as to_name');
        } else {
            $getData = ReferralHistory::leftjoin('users as users_by','referral_histories.referral_by','users_by.id')
            ->leftjoin('users as users_to','referral_histories.referral_to','users_to.id')
            ->select('referral_histories.*','users_by.name as by_name','users_to.name as to_name');
        }

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
                $getData->whereBetween('referral_histories.created_at', [$dateS, $dateE]);
            } elseif (!empty($searchData['date_from'])) {
                $dateS = $searchData['date_from'];
                $getData->where('referral_histories.created_at', '>=', [$dateS]);
            } elseif (!empty($searchData['date_to'])) {
                $dateE = $searchData['date_to'];
                $getData->where('referral_histories.created_at', '<=', [$dateE]);
            }
            foreach ($searchData as $fieldName => $fieldValue) {
                if ($fieldValue != "") {
                    if ($fieldName == "by_name" ) {
                        $getData->where("users_by.name", 'like', '%' . $fieldValue . '%');
                    }
                    if ($fieldName == "to_name" ) {
                        $getData->where("users_to.name", 'like', '%' . $fieldValue . '%');
                    }
                }
                $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }

        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'referral_histories.created_at';
        $order = $request->input('order') ? $request->input('order') : 'desc';
        $offset = !empty($request->input('offset')) ? $request->input('offset') : 0 ;
        $limit =  !empty($request->input('limit')) ? $request->input('limit') : Config("Reading.records_per_page");

        $results = $getData->orderBy($sortBy, $order)->offset($offset)->limit($limit)->get();
        $totalResults = $getData->count();



        $users = User::where("users.user_role_id", 4)->where("users.is_deleted", 0)->where("users.is_active", 1)->orderBy('users.created_at','desc')->paginate(20);
        $usersHtml = View::make("admin.$this->model.userSearch",compact('users'))->render();

        if($request->ajax()){

            return  View("admin.$this->model.load_more_data", compact('results','totalResults','usersHtml'));
        }else{

            return  View("admin.$this->model.index", compact('results','totalResults','usersHtml'));
        }
    }

    public function userSearch(Request $request){

		$value = $request->value;

        $users = User::where("users.user_role_id", 4)->where("users.is_deleted", 0)->where("users.is_active", 1);
		if(!empty($value)){
            $users->where(function($query) use ($value){

                $query->where("users.name", 'like', '%' . $value . '%');
                $query->orWhere("users.phone_number", 'like', '%' . $value . '%');
                $query->orWhere("users.email", 'like', '%' . $value . '%');

            });
		}
        $users = $users->orderBy('users.created_at','desc')->paginate(20);

		return  View::make("admin.$this->model.userSearch",compact('users','value'));

	}

    public function treeView($enuserid){

        $user_id = '';
        if (!empty($enuserid)) {
            $user_id = base64_decode($enuserid);
        }

        $userData = User::where('id',$user_id)->first();
        if (empty($userData)) {
            return Redirect()->route($this->model . '.index');
        }

		if(!empty($userData)){
			$usersCount = ReferralHistory::where('referral_by',$userData->id)->count();
			$itemClass =( !empty($usersCount) && $usersCount > 0 ) ? 'hasItem' : '';
			//$html = '<li> <span class="d-inline-flex '.$itemClass.'"> <img class="avatar-img rounded-circle mr-3" src="'.$userData->profile_pic.'" height="35" width="35" alt="avatar"> <span class="align-self-center mr-3">'.$userData->name.(!empty($userData->email) ? '('.$userData->email.')' : '').'</span> <span class="mr-3">'.date(config("Reading.date_format"),strtotime($userData->created_at)).'</span> <span class="badge badge-light align-self-center">'.$usersCount.'</span> </span> <ul> ';
			$html = '<ul> ';
			$html.= $this->createSubTree($userData->id,$userData->id);
			$html.= '</ul>';
		}
		return View::make("admin.$this->model.tree_view",compact('html','userData'));
	}

    public function createSubTree($userId,$referral_by){

		$html = "";
		$getUsersData = ReferralHistory::where('referral_by',$userId)->get();
		if($getUsersData->isNotEmpty()){

            foreach($getUsersData as $user){
                $userData = User::where('id',$user->referral_to)->first();

                $userData->name = Lookup::getLookupCode($userData->name_title)." ".$userData->name;
				$usersCount = ReferralHistory::where('referral_by',$userData->id)->count();
				$itemClass =( !empty($usersCount) && $usersCount > 0 ) ? 'hasItem' : '';
				$html.= '<li><span class="d-inline-flex '.$itemClass.'"><i class="fa fa-minus-square mr-2 text-white"></i> <img class="avatar-img rounded-circle mr-3" src="'.$userData->profile_pic.'" height="35" width="35" alt="avatar"><span class="align-self-center mr-3">'.$userData->name.(!empty($userData->email) ? '('.$userData->email.')' : '').'</span> <span class="mr-3">'.date(config("Reading.date_format"),strtotime($userData->created_at)).'</span> <span class="badge badge-light align-self-center">'.$usersCount.'</span> &nbsp;</span><ul> ';
				$html.=	 $this->createSubTree($userData->id,$referral_by);
				$html.=		'</ul>
						</li>';
			}
		}
		return $html;
	}

    public function create(Request $request)
    {
        return View("admin.$this->model.add");
    }

    public function save(Request $request)
    {
        //echo "<pre>";print_r($request->all());die;
        $formData = $request->all();
        if (!empty($formData)) {
            $validator = Validator::make(
                $request->all(),
                array(
                    'referral_by' => 'required|email',
                    'referral_to' => 'required|email',
                ),
                array(
                    "referral_by.required" => trans("The referral by field is required."),
                    "referral_by.email" => trans("The referral by email must be a valid email address"),
                    "referral_to.required" => trans("The referral to field is required."),
                    "referral_to.email" => trans("The referral to email must be a valid email address"),
                )
            );
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            } else {
                $getreferralbyUser  = User::where('email',$request->input('referral_by'))->where('user_role_id',1)->where('is_deleted',0)->first();
                if (empty($getreferralbyUser)) {
                    Session()->flash('error', "Sorry! Referral by account doesn't exist.");
                    return Redirect::back();
                }

                $getreferraltoUser  = User::where('email',$request->input('referral_to'))->where('user_role_id',1)->where('is_deleted',0)->first();
                if (empty($getreferraltoUser)) {
                    Session()->flash('error', "Sorry! Referral to account doesn't exist.");
                    return Redirect::back();
                }

                $getReferralData  = ReferralHistory::where("referral_by",$request->input('referral_by'))->where("referral_to",$request->input('referral_to'))->first();
                if(!empty($getReferralData)){
                    Session()->flash('error', "Sorry! This entry is already exist.");
                    return Redirect::back();
                }

                $getReferralToData  = ReferralHistory::where("referral_to",$request->input('referral_to'))->first();
                if(!empty($getReferralToData)){
                    Session()->flash('error', "Sorry! This referral to user is already exist with other user.");
                    return Redirect::back();
                }

                if (empty($getReferralData) && empty($getReferralToData) && !empty($getreferralbyUser) && !empty($getreferraltoUser)) {
                    $obj  =  new ReferralHistory;
                    $obj->referral_by = $getreferralbyUser->id;
                    $obj->referral_to = $getreferraltoUser->id;
                    $obj->save();
                    $lastId = $obj->id;
                    if(empty($lastId)){
                        Session()->flash('error', 'Something Went Wrong');
                        return Redirect::back();
                    }

                } else {
                    Session()->flash('error', 'Something Went Wrong');
                    return Redirect::route('referral_histories.index');
                }

                Session()->flash('flash_notice', "Referral has been saved successfully.");
                return Redirect::route('referral_histories.index');
            }
        }

    }

    public function destroy($enuserid)
    {
        $user_id = '';
        if (!empty($enuserid)) {
            $user_id = base64_decode($enuserid);
        }
        $userDetails = ReferralHistory::find($user_id);
        if (empty($userDetails)) {
            return Redirect()->route($this->model . '.index');
        }
        ReferralHistory::where('id',$user_id)->delete();
        Session()->flash('flash_notice', "Referral has been removed successfully.");

        return back();
    }
    public function referra_map(Request $request) {
        $search_email           =   (!empty($request->input("email"))) ? $request->input("email"): "";
        $referral_histories     =   array();
        $parent_details =   DB::table("users")->where("email",$search_email)->where("is_deleted",0)->first();
        if(!empty($parent_details)){
            $get_associated_childs  =   $this->get_associated_users_detail($parent_details->id,array());
            $get_associated_childs[]  =   $parent_details->id;
            $referral_histories	    =	DB::table('referral_histories')/* ->whereIn('referral_by',$get_associated_childs) */->get()->toArray();
        }
       /*  echo "<pre>";
        print_r($referral_histories);die; */

        return View("admin.$this->model.referra_map",compact("search_email","referral_histories","parent_details"));
    }

    public function get_associated_users_detail($user_id = 0,$merged_record = array()){
		$referral_histories	=	DB::table('referral_histories')->where('referral_by',$user_id)->pluck("referral_to")->toArray();
		if(!empty($referral_histories)){
            foreach($referral_histories as $referral_histories_v){
                $merged_record[]   =   $referral_histories_v;
                $merged_record    =   $this->get_associated_users_detail($referral_histories_v,$merged_record);
            }
		}
        return $merged_record;
	}

}
