<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\path;
use Illuminate\Support\Facades\DB;
use Config;
use Mail;
use Request;
use Str;
use File;
use App\Models\User;
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct() {

	}

    public function buildTree($parentId = 0){
		$user_id	    =	Auth::user()->id;
		$user_role_id	=	Auth::user()->user_role_id;
		$branch         =   array();
		$elements       =   array();
		$superadmin = Config('constant.ROLE_ID.SUPER_ADMIN_ROLE_ID');
		if($user_role_id == $superadmin){
			$elements = DB::table("acls")
							->where("parent_id",$parentId)
							->orderBy('acls.module_order','ASC')
							->get(); 
          
		}else {
			if($parentId == 0){
				$elements = DB::table("acls")
							->where("parent_id",$parentId)
							->where("acls.id",DB::raw("(select admin_module_id from user_permissions where user_permissions.admin_module_id = acls.id AND is_active = 1 AND user_id = $user_id LIMIT 1)"))
							->orderBy('acls.module_order','ASC')
							->get();
			}else{ 
				$elements = 	DB::table("acls")
								->where("parent_id",$parentId)
								->where("acls.id",DB::raw("(select admin_sub_module_id from user_permission_actions where user_permission_actions.admin_sub_module_id = acls.id AND is_active = 1 AND user_id = $user_id LIMIT 1)"))
								->orderBy('acls.module_order','ASC')
								->get();  
			}
		}

		foreach($elements as $element){
			if ($element->parent_id == $parentId){
				$children = $this->buildTree($element->id);
				if ($children){
					$element->children = $children;
				}
				$branch[] = $element;
			}
		}

		return $branch;
	}

	public function generateRandomPassword(){
		
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
		$password = substr( str_shuffle( $chars ), 0, 9 );
		return $password;
	}

	public function getSlug($title, $fieldName,$modelName,$limit = 30){
		$slug 		= 	 substr(Str::slug($title),0 ,$limit);
		$Model		=	 "\App\Models\\$modelName";
		$slugCount 	=    count($Model::where($fieldName, $slug)->get());
		if($slugCount > 0){
			$slugCount 	=    count($Model::where($fieldName,"LIKE", "%".$slug."%")->get());
			return $slug."-".$slugCount;
		}else {
			return $slug;
		}
		
	}//end getSlug()
}
