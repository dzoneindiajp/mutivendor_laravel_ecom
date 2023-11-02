<?php

use App\Models\Acl;
use  App\Models\Department;
use  App\Models\Designation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

  function sideBarNavigation($menus, $children2Data = ""){
 
    $website_url  = Config('constant.WEBSITE_URL');
    $treeView	=	"";  
    $segment3	=	Request()->segment(2); 
    $segment4	=	Request()->segment(2); 
    $segment5	=	Request()->segment(3);  
    $segment6	=	Request()->segment(4);  
    
    if(!empty($menus)){

      // dd($menus);
      $treeView	.=	empty($children2Data) ? "<ul class='main-menu'>" : "<ul class='slide-menu child2'>" ;
      foreach($menus as $record){
        // dd($menus);
        $currentSection	=	"";
        $currentPlugin	=	"";
        $plugin			=	explode('/',$record->path); 
        $pluginSlug3	=	isset($plugin[1])?$plugin[1]:'';        
        $myArray		=	[];
        $myArray1		=	[];      
        if(!empty($record->children)){
          $plugin_array	=	"";
          $plugin_array1	=	"";
          foreach($record->children as $li_record){         
            $plugin			=	explode('/',$li_record->path); 
            $slug			=	isset($plugin[0])?$plugin[0]:''; 
            $slug1			=	isset($plugin[1])?$plugin[1]:'';
            $plugin_array 	.= 	"".$slug.",";
            $plugin_array1 	.= 	"".$slug1.",";
          }
          $myArray = explode(',', $plugin_array);
          $myArray1 = explode(',', $plugin_array1);
        }   
        $class = (in_array($segment3,$myArray1) && ($segment3 != '')) ? 'open':''; #* 
      
        $classActive		=	($pluginSlug3 == $segment3)?"active":'';
        $style = (in_array($segment3,$myArray1) && ($segment3 != '')) ? 'display:block;':'display:none;'; 
        $classActive1 = "";


        $path	=	((!empty($record->path) && ($record->path != 'javascript::void()') && ($record->path != 'javascript::void(0)') && ($record->path != 'javascript:void()') && ($record->path != 'javascript::void();') && ($record->path != 'javascript:void(0);'))?URL($record->path):'javascript:void(0)');

        $second_icon	=	((!empty($record->path) && ($record->path == 'javascript::void()') || ($record->path == 'javascript::void(0)') || ($record->path == 'javascript:void()') || ($record->path == 'javascript::void();') || ($record->path == 'javascript:void(0);'))?'fe fe-chevron-right side-menu__angle':'');   


        if((!empty($record->path) && ($record->path != 'javascript::void()') && ($record->path != 'javascript::void(0)') )){     
          $pluginData			=	explode('/',$record->path);  
          $plugin				=	isset($pluginData[0])?$pluginData[0]:'';      
          $plugin1			=	isset($pluginData[1])?$pluginData[1]:''; 
          $classActive1		=	((($plugin == $segment3 && ($plugin1 == "")) || ($plugin1 == $segment3) || ($plugin == $segment3 && ($plugin1 == "user-chat")))?'active':'');
        }      
        $treeView .= "<li class='slide ".(!empty($record->children)? 'has-sub '.$class:' ').' '.$classActive1."' ><a href='".$path."' class='side-menu__item ".$classActive1."'>"."<i class='".$record->icon."'></i><span class='menu-text'>$record->title</span><i class='".$second_icon."'></i></a>";

        if(!empty($record->children)){       
          $treeView	.= "<ul class='slide-menu child1'>";
          // <li class='slide has-sub' >
          // <span class='menu-link'>
          //   <span class='menu-text'>".$record->title."</span>
          // </span>
          // </li>";
        
          foreach($record->children as $li_record){
            
            $path	=	((!empty($li_record->path) && ($li_record->path != 'javascript::void()') && ($li_record->path != 'javascript::void(0)') && ($li_record->path != 'javascript:void()') && ($li_record->path != 'javascript:void(0);'))?URL($li_record->path):'javascript:void(0)');            
            $second_icon	=	((!empty($li_record->path) && ($li_record->path == 'javascript::void()') || ($li_record->path == 'javascript::void(0)') || ($li_record->path == 'javascript:void()') || ($li_record->path == 'javascript::void();') || ($li_record->path == 'javascript:void(0);'))?'fe fe-chevron-right side-menu__angle':'');   
            $classss = (in_array($segment3,$myArray1) && ($segment3 != '')) ? 'open':'';
            $plugin			=	explode('/',$li_record->path); 
            $currentPlugin	=	isset($plugin[1])?$plugin[1]:'';
          
            $currentPlugin1	=	isset($plugin[2])?$plugin[2]:''; 
            
            $currentPlugin2	=	isset($plugin[3])?$plugin[3]:'';   
      
            $activeClass = "";
          
            if(  (!empty($segment5) && $segment5 == $currentPlugin1 && $segment5 =='Speaker' ) || (!empty($segment6) && $segment6 == $currentPlugin1 && $segment6=='Speaker' ) ){
              
              $activeClass =  "active";
            }elseif( (!empty($segment5) && $segment5 == $currentPlugin1  && $segment5 =='Assistant' ) ||  (!empty($segment6) && $segment6 == $currentPlugin1 && $segment6=='Assistant' )){
              $activeClass =  "active";
            }elseif( $segment4=='lookups-manager'){
              if(!empty($segment5) && $segment4=='lookups-manager' ){
                
              }
            }elseif($segment4=='settings'){
             
                if( $currentPlugin2 == $segment6 ){
                  $activeClass =  "active";

                }elseif( $currentPlugin2 == $segment6 ){
                  $activeClass =  "active";
                  
                }elseif( $currentPlugin2 == $segment6 ){
                  $activeClass =  "active";

                }
              
            }else{
              if( $currentPlugin == $segment4 && $segment4 !='settings' && $segment4!='lookups-manager' && $segment5 !='Speaker' && $segment6 !='Speaker' && $segment5 !='Assistant' && $segment6 !='Assistant'  )
              $activeClass =  "active";
            }
              
         
                $treeView .= "<li class='slide ".(!empty($li_record->children)? 'has-sub '.$classss:' ').' '.$activeClass."' >
                <a href='".$path."' class='side-menu__item'>".$li_record->title."
                <i class='".$second_icon."'></i></a>";
            if(!empty($li_record->children)){ 
              $treeView  .= sideBarNavigation($li_record->children,"Yes");
            } 
            $treeView  .= "</li>"; 
          }
          $treeView  .= "</ul>";
        } 
        $treeView  .= "</li>"; 
      }
      $treeView  .= "</ul>";
    } 
    
    return $treeView;
}

  function functionCheckPermission($function_name = ""){
    if( Auth::user()->id != 1){
     
    
    $user_id				  =	Auth::user()->id;

    $permissionData			=	DB::table("user_permission_actions")
                              ->select("user_permission_actions.is_active")
                              ->leftJoin("acl_admin_actions","acl_admin_actions.id","=","user_permission_actions.admin_module_action_id")
                              ->where('user_permission_actions.user_id',$user_id)
                              ->where('user_permission_actions.is_active',1)
                              ->where('acl_admin_actions.function_name',$function_name)
                              ->first();
   
      if(!empty($permissionData)){
          return 1;
        }else{
          return 0;
        }
      }else {
        return 1;
      }
}

 function  getActiveLanguages() {

  $languages		=	DB::table("languages")->get()->toArray();
  return $languages;
}	

if(!function_exists('AclParnentByName'))
{
    function AclparentByName($parentid=Null)
    {
      $parentidname='';
        if(!empty($parentid))
        {
        
        $parentidname=Acl::where('id',$parentid)->value('title');
        return $parentidname; 
        }
    } 
}

if(!function_exists('DepartmentbyName'))
{
    function DepartmentbyName($Departid=Null)
    {
      $Departmentname='';
        if(!empty($Departid))
        {
      
        $Departmentname=Department::where('id',$Departid)->value('name');
        return $Departmentname; 
        }
    } 
}

if(!function_exists('DesignationbyName'))
{
    function DesignationbyName($Desid=Null)
    {
        if(!empty($Desid))
        {
          $Desginationname='';
        $Desginationname=Designation::where('id',$Desid)->value('name');
        return $Desginationname; 
        }
    } 
}



