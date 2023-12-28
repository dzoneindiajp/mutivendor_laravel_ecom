<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\City;
use App\Models\CityPostalCode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Redirect,DB,Response;

class CityController extends Controller
{
    public $model = 'cities';
    public function __construct(Request $request)
    {
        $this->listRouteName = 'admin-cities.index';
        View()->share('model', $this->model);
        View()->share('listRouteName', $this->listRouteName);
        $this->request = $request;

    }

    public function index(Request $request)
    {
        try {
            $DB = City::query();
            $sortBy = $request->input('sortBy') ? $request->input('sortBy') : 'cities.created_at';
            $order = $request->input('order') ? $request->input('order') : 'Desc';
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
                    $DB->whereBetween('cities.created_at', [$dateS . " 00:00:00", $dateE . " 23:59:59"]);
                } elseif (!empty($searchData['date_from'])) {
                    $dateS = $searchData['date_from'];
                    $DB->where('cities.created_at', '>=', [$dateS . " 00:00:00"]);
                } elseif (!empty($searchData['date_to'])) {
                    $dateE = $searchData['date_to'];
                    $DB->where('cities.created_at', '<=', [$dateE . " 00:00:00"]);
                }
                foreach ($searchData as $fieldName => $fieldValue) {
                    if ($fieldValue != "") {
                        if ($fieldName == "name") {
                            $DB->where("cities.name", 'like', '%' . $fieldValue . '%');
                        }
                        if ($fieldName == "is_active") {
                            $DB->where("cities.is_active", $fieldValue);
                        }
                    }
                }
            }

            $results = $DB->orderBy($sortBy, $order)->offset($offset)->limit($limit)->get();
            $totalResults = $DB->count();


            if($request->ajax()){

                return  View("admin.$this->model.load_more_data", compact('results','totalResults'));
            }else{
                return  View("admin.$this->model.index", compact('results','totalResults'));
            }

        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }

    }

    public function create()
    {
        try {
            return view('admin.cities.create');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
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
                    $obj                                = new City;
                    $obj->name                          = $request->input('name');
                    $obj->save();

                    $lastId = $obj->id;

                    if(!empty($lastId)){
                        $postal_codes = array();
                        $postal_codes = explode(',', $request->postal_code);
                        if (!empty($postal_codes)) {
                            foreach($postal_codes as $postal_code) {
                                $obj1 = new CityPostalCode;
                                $obj1->city_id  = $lastId;
                                $obj1->postal_code  = $postal_code;
                                $obj1->save();
                                if(empty($obj1->id)){
                                    DB::rollback();
                                    Session()->flash('flash_notice', 'Something Went Wrong');
                                    return Redirect::route('admin-cities.index');
                                }
                            }
                        }
                        DB::commit();
                    }else{
                        DB::rollback();
                        Session()->flash('flash_notice', 'Something Went Wrong');
                        return Redirect::route('admin-cities.index');
                    }

                    return redirect()->route('admin-cities.index')->with('success', 'City created successfully');
                }
            }
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function edit(Request $request, $token = null)
    {
        try {
            $cityId = '';
            if (!empty($token)) {

                $cityId = base64_decode($token);

                $city = City::find($cityId);

                if(!empty($city)) {
                    $postal_codes = CityPostalCode::where('city_id', $cityId)->pluck('postal_code')->toArray();
                    $city_postal_codes = implode(',', $postal_codes);
                }
                return View("admin.$this->model.edit", compact('city', 'city_postal_codes'));
            }
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $token)
    {
        try {

            $cityId = '';
            if (!empty($token)) {
                $cityId = base64_decode($token);
            } else {
                return redirect()->route('admin-'.$this->model . ".index");
            }

            $city = City::find($cityId);
            if (empty($city)) {
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
                        $obj                                = $city;
                        $obj->name                          = $request->input('name');
                        $obj->save();
                        $lastId = $obj->id;
                        if(!empty($lastId)){
                            CityPostalCode::where('city_id',$lastId)->delete();
                            $postal_codes = array();
                            $postal_codes = explode(',', $request->postal_code);
                            if (!empty($postal_codes)) {
                                foreach($postal_codes as $postal_code) {
                                    $obj1 = new CityPostalCode;
                                    $obj1->city_id  = $lastId;
                                    $obj1->postal_code  = $postal_code;
                                    $obj1->save();
                                    if(empty($obj1->id)){
                                        DB::rollback();
                                        Session()->flash('flash_notice', 'Something Went Wrong');
                                        return Redirect::route('admin-cities.index');
                                    }
                                }
                            }
                            DB::commit();
                        }else{
                            DB::rollback();
                            Session()->flash('flash_notice', 'Something Went Wrong');
                            return Redirect::route('admin-cities.index');
                        }
                        Session()->flash('flash_notice', trans("City updated successfully."));
                        return Redirect::route('admin-cities.index');
                    }
                }
            }
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function destroy($token)
    {
        try {
            $cityId = '';
            if (!empty($token)) {
                $cityId = base64_decode($token);
            }
            $city = City::find($cityId);
            if (empty($city)) {
                return Redirect()->route($this->model . '.index');
            }
            if ($city) {
                City::where('id', $cityId)->delete();
                Session()->flash('flash_notice', trans("City has been removed successfully."));
            }
            return back();
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Something is wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function changeStatus($modelId = 0, $status = 0)
    {
        if ($status == 1) {
            $statusMessage = trans("City has been actvated successfully");
        } else {
            $statusMessage = trans("City has been deactivated successfully");
        }
        $city = City::find($modelId);
        if ($city) {
            $currentStatus = $city->is_active;
            if (isset($currentStatus) && $currentStatus == 0) {
                $NewStatus = 1;
            } else {
                $NewStatus = 0;
            }
            $city->is_active = $NewStatus;
            $ResponseStatus = $city->save();
        }
        Session()->flash('flash_notice', $statusMessage);
        return back();
    }


}
