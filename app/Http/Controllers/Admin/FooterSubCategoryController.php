<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\FooterSubcategory;
use App\Models\FooterCategory;

class FooterSubCategoryController extends Controller
{
    public $model =    'footer-subcategory';
    public function __construct(Request $request)
    {   
        
        View()->share('model', $this->model);
        $this->request = $request;
    }

    public function index(Request $request, $endesid = null)
    {
        if (!empty($endesid)) {
            $dep_id = base64_decode($endesid);
        }
        $departmentDetails  =  FooterCategory::where('footer_categories.id', $dep_id)->first();
        if (empty($dep_id)) {
            return Redirect()->back();
        }
        $DB                    =    FooterSubcategory::query();
        $searchVariable        =    array();
        $inputGet            =    $request->all();
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
            if (isset($searchData['page'])) {
                unset($searchData['page']);
            }
            if ((!empty($searchData['date_from'])) && (!empty($searchData['date_to']))) {
                $dateS = $searchData['date_from'];
                $dateE = $searchData['date_to'];
                $DB->whereBetween('footer_subcategories.created_at', [$dateS . " 00:00:00", $dateE . " 23:59:59"]);
            } elseif (!empty($searchData['date_from'])) {
                $dateS = $searchData['date_from'];
                $DB->where('footer_subcategories.created_at', '>=', [$dateS . " 00:00:00"]);
            } elseif (!empty($searchData['date_to'])) {
                $dateE = $searchData['date_to'];
                $DB->where('footer_subcategories.created_at', '<=', [$dateE . " 00:00:00"]);
            }
            foreach ($searchData as $fieldName => $fieldValue) {
                if ($fieldValue != "") {
                    if ($fieldName == "name") {
                        $DB->where("footer_subcategories.name", 'like', '%' . $fieldValue . '%');
                    }
                    if ($fieldName == "is_active") {
                        $DB->where("footer_subcategories.is_active", $fieldValue);
                    }
                }
                $searchVariable    =    array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }
        $DB->where("is_deleted", 0);
        $DB->where("footer_category_id", $dep_id);
        $DB->select("footer_subcategories.*");
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'created_at';
        $order  = ($request->input('order')) ? $request->input('order')   : 'DESC';
        $records_per_page    =    ($request->input('per_page')) ? $request->input('per_page') : Config("Reading.records_per_page");
        $results = $DB->orderBy($sortBy, $order)->paginate($records_per_page);
        $complete_string        =    $request->query();
        unset($complete_string["sortBy"]);
        unset($complete_string["order"]);
        $query_string            =    http_build_query($complete_string);
        $results->appends($inputGet)->render();
        return  View("admin.$this->model.index", compact('results', 'searchVariable', 'sortBy', 'order', 'query_string', 'dep_id'));
    }

    public function add(Request $request, $endesid = null)
    {   

        // dd($request);
        if (!empty($endesid)) {
            $dep_id = base64_decode($endesid);
        }
        if (empty($endesid)) {
            return Redirect()->back();
        }
        $formData =    $request->all();
        $departmentDetails  =  FooterCategory::where('id', $dep_id)->first();
        if ($request->isMethod('POST')) {
            $validated = $request->validate([
                'name' => 'required',
                'url' => 'required',
                'order_number' => 'required',
            ]);
            $obj                        =  new FooterSubcategory;
            $obj->footer_category_id         =  $dep_id;
            $obj->name                  =  $request->name;
            $obj->url                  =  $request->url;
            $obj->order_number                  =  $request->order_number;
            $SavedResponse = $obj->save();
            $userId                    =    $obj->id;
           
            if (!$SavedResponse) {
                Session()->flash('error', trans("Something went wrong."));
                return Redirect()->back()->withInput();
            } else {
                Session()->flash('success', "Footer subcategory has been added successfully");
                return Redirect()->route('admin-'.$this->model . ".index", $endesid);
            }
        }
       
        return  View("admin.$this->model.add", compact('dep_id'));
    }

    public function update(Request $request, $endesid = null)
    {
        $des_id = '';
        if (!empty($endesid)) {
            $des_id = base64_decode($endesid);
        }
        $modell =    FooterSubcategory::where('footer_subcategories.id', $des_id)->first();
        if (empty($modell)) {
            return Redirect()->back();
        }
        if ($request->isMethod('POST')) {
            $formData =    $request->all();
            $validated = $request->validate([
                'name' => 'required',
                'url' => 'required',
                'order_number' => 'required',
            ]);
            $obj             =  FooterSubcategory::find($des_id);
            $obj->name                  =  $request->name;
            $obj->url                  =  $request->url;
            $obj->order_number                  =  $request->order_number;
            $obj->save();
            $userId          =    $obj->id;
            if (!$userId) {
                Session()->flash('error', trans("Something went wrong."));
                return Redirect()->back()->withInput();
            }
           
            Session()->flash('success', trans("Footer subcategory has been updated successfully"));
            return Redirect()->route('admin-'.$this->model . ".index", base64_encode($modell->footer_category_id));
        }
        
        return  View("admin.$this->model.edit", compact('modell'));
    }


    public function changeStatus($modelId = 0, $status = 0){
        if ($status == 1) {
            $statusMessage   =   trans("Footer subcategory has been deactivated successfully");
        } else {
            $statusMessage   =   trans("Footer subcategory has been activated successfully");
        }
        $user = FooterSubcategory::find($modelId);
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

    public  function delete($endesid = null)
    {
  
        $dep_id = '';
        if (!empty($endesid)) {
            $des_id = base64_decode($endesid);
        }
        
        $depDetails   =   FooterSubcategory::find($des_id);
        if (empty($depDetails)) {
            return Redirect()->route('admin-'.$this->model . '.index');
        }
        if ($des_id) {
            FooterSubcategory::where('id', $des_id)->update(array('is_deleted' => 1));
            Session()->flash('flash_notice', trans("Footer subcategory has been removed successfully"));
        }
        return back();
    }
}
