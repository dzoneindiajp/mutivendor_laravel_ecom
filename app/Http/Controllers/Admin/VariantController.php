<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use  App\Models\Variant;
use  App\Models\VariantValue;
use DB,Redirect;
class VariantController extends Controller
{
    public $model        =    'variants';
    public function __construct(Request $request){
        $this->listRouteName = 'admin-variants.index';
        View()->share('model', $this->model);
        View()->share('listRouteName', $this->listRouteName);
        $this->request = $request;
        
    }
    public function index(Request $request){

        $DB = Variant::query();
        $sortBy = $request->input('sortBy') ? $request->input('sortBy') : 'variants.created_at';
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
                $DB->whereBetween('variants.created_at', [$dateS . " 00:00:00", $dateE . " 23:59:59"]);
            } elseif (!empty($searchData['date_from'])) {
                $dateS = $searchData['date_from'];
                $DB->where('variants.created_at', '>=', [$dateS . " 00:00:00"]);
            } elseif (!empty($searchData['date_to'])) {
                $dateE = $searchData['date_to'];
                $DB->where('variants.created_at', '<=', [$dateE . " 00:00:00"]);
            }
            foreach ($searchData as $fieldName => $fieldValue) {
                if ($fieldValue != "") {
                    if ($fieldName == "name") {
                        $DB->where("variants.name", 'like', '%' . $fieldValue . '%');
                    }
                    if ($fieldName == "is_active") {
                        $DB->where("variants.is_active", $fieldValue);
                    }
                   
                }
            }
        }

        $DB->where("is_deleted", 0);
        $results = $DB->orderBy($sortBy, $order)->offset($offset)->limit($limit)->get();
        $totalResults = $DB->count();
        if($request->ajax()){

            return  View("admin.$this->model.load_more_data", compact('results','totalResults'));
        }else{
            
            return  View("admin.$this->model.index", compact('results','totalResults'));
        }
    }

    public function create(){
        return view("admin.$this->model.add");
    }

    public function store(Request $request){
        $formData = $request->all();
        if (!empty($formData)) {
            $validator = Validator::make(
                $request->all(),
                array(

                    'name' => 'required',
                ),
                array(
                    "name.required" => trans("The name field is required."),
                )
            );
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            } else {
                DB::beginTransaction();
                $obj                                = new Variant;
                $obj->name                          = $request->input('name');
                $obj->save();
                $lastId = $obj->id;
                if(!empty($lastId)){
                    if(!empty($request->dataArr)){
                        foreach($request->dataArr as $variantValue){
                            if(!empty($variantValue['name']) ){
                               $obj2   =  new VariantValue;
                               $obj2->variant_id = $lastId;
                               $obj2->name = $variantValue['name'];
                               $obj2->color_code = !empty($variantValue['name']) ? $variantValue['name'] : null;
                               $obj2->save();
                               if(empty($obj2->id)){
                                    DB::rollback();
                               }
                            }
                        }
                    }
                    DB::commit();
                    Session()->flash('flash_notice', trans("Variant saved successfully."));
                    return Redirect::route('admin-variants.index');
                }else{
                    DB::rollback();
                    Session()->flash('flash_notice', 'Something Went Wrong');
                    return Redirect::route('admin-variants.index');
                }
               
            }
        }
    }

    public function edit($endepid){
        $record_id = '';
        if (!empty($endepid)) {
            $record_id = base64_decode($endepid);
            $recordDetails   =   Variant::find($record_id);

            $variantValuesData = VariantValue::where('variant_id',$record_id)->get()->toArray();
            return  View("admin.$this->model.edit", compact('recordDetails','variantValuesData'));
        } else {
            return redirect()->route('admin-'.$this->model . ".index");
        }
    }

    public function update(Request $request, $endepid){
        $record_id     = base64_decode($endepid);
        $model = Variant::find($record_id);
        if (empty($model)) {
            return View("admin.$this->model.edit");
        } else {
            $formData = $request->all();
            if (!empty($formData)) {
                $validator = Validator::make(
                    $request->all(),
                    array(

                        'name' => 'required',
                       
                    ),
                    array(

                        "name.required" => trans("The name field is required."),
                        
                    )
                );
                if ($validator->fails()) {
                    return Redirect::back()->withErrors($validator)->withInput();
                } else {
                    DB::beginTransaction();
                    $obj                                = $model;
                    $obj->name                          = $request->input('name');
                  
                    $obj->save();
                    $lastId = $obj->id;
                    if(!empty($lastId)){
                        if(!empty($request->dataArr)){
                            VariantValue::where('variant_id',$lastId)->delete();
                            foreach($request->dataArr as $variantValue){
                                if(!empty($variantValue['name']) ){
                                   $obj2   =  new VariantValue;
                                   $obj2->variant_id = $lastId;
                                   $obj2->name = $variantValue['name'];
                                   $obj2->save();
                                   if(empty($obj2->id)){
                                        DB::rollback();
                                   }
                                }
                            }
                        }
                        DB::commit();
                        Session()->flash('flash_notice', trans("Variant updated successfully."));
                        return Redirect::route('admin-variants.index');
                    }else{
                        DB::rollback();
                        Session()->flash('flash_notice', 'Something Went Wrong');
                        return Redirect::route('admin-variants.index');
                    }
                   
                }
            }
        }
    }

    public function destroy($endepid){
        $record_id = '';
        if (!empty($endepid)) {
            $record_id     = base64_decode($endepid);
        }
        $recordDetails     =   Variant::find($record_id);
        if (empty($recordDetails)) {
            return Redirect()->route('admin-'.$this->model . '.index');
        }
        if ($record_id) {
            Variant::where('id', $record_id)->update(array('is_deleted' => 1));
            VariantValue::where('variant_id', $record_id)->delete();
            Session()->flash('flash_notice', trans(Config('constant.VARIANT.VARIANT_TITLE') . " has been removed successfully"));
        }
        return back();
    }

    public function changeStatus($modelId = 0, $status = 0){
        if ($status == 1) {
            $statusMessage   =   trans(Config('constant.VARIANT.VARIANT_TITLE') . " has been deactivated successfully");
        } else {
            $statusMessage   =   trans(Config('constant.VARIANT.VARIANT_TITLE') . " has been activated successfully");
        }
        $user = Variant::find($modelId);
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
}
