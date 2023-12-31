<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use  App\Models\Setting;
use Redirect;

class SettingsController extends Controller
{
    public $model      =   'settings';
    public function __construct(Request $request)
    {   
        $this->listRouteName = 'admin-settings.index';
        View()->share('model', $this->model);
        View()->share('listRouteName', $this->listRouteName);
        $this->request = $request;
    }

    public function index(Request $request)
    {
        $DB = Setting::query();
        $searchVariable  =  array();
        $inputGet    =  $request->all();
        if ($inputGet) {
            $searchData  =  $request->all();
            foreach ($searchData as $fieldName => $fieldValue) {
                if (!empty($fieldValue)) {
                    if ($fieldName == "title") {
                        $DB->where("settings.title", 'like', '%' . $fieldValue . '%');
                    }
                    $searchVariable  =  array_merge($searchVariable, array($fieldName => $fieldValue));
                }
            }
        }
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'id';
        $order  = ($request->input('order')) ? $request->input('order')   : 'ASC';
        $offset = !empty($request->input('offset')) ? $request->input('offset') : 0 ;
        $limit =  !empty($request->input('limit')) ? $request->input('limit') : Config("Reading.records_per_page"); 
        
        $results = $DB->orderBy($sortBy, $order)->offset($offset)->limit($limit)->get();
        $totalResults = $DB->count();

        if($request->ajax()){

            return  View("admin.$this->model.load_more_data", compact('results','totalResults'));
        }else{
            
            return  View("admin.$this->model.index", compact('results','totalResults'));
        }
    }

    public function create()
    {
        return  View("admin.$this->model.add");
    }


    public function store(Request $request)
    {   
   
        $validated = $request->validate([
            'title' => 'required',
            'key' => 'required',
            // 'key'  => 'required',
            'input_type' => 'required',
        ]);
        $obj              = new Setting;
        $obj->title       = $request->title;
        $obj->key         = $request->key;
        $obj->value       = $request->value;
        $obj->input_type  = $request->input_type;
        $obj->editable    = 1;

        if ($request->input_type == "file" || $request->input_type == "File") {
            if ($request->hasFile('value')) {
                $extension = $request->file('value')->getClientOriginalExtension();
                $originalName = $request->file('value')->getClientOriginalName();
                $fileName = time() . '-settings.' . $extension;

                $folderName = strtoupper(date('M') . date('Y')) . "/";
                $folderPath = Config('constant.SETTINGS_IMAGE_ROOT_PATH') . $folderName;
                if (!File::exists($folderPath)) {
                    File::makeDirectory($folderPath, $mode = 0777, true);
                }
                if ($request->file('value')->move($folderPath, $fileName)) {
                    $obj->value = $folderName . $fileName;
                }
            } else {
                $obj->value       =  "";
            }
        }
        $savedata = $obj->save();
        if ($savedata) {
            Session()->flash('flash_notice', 'Setting added successfully.');
            return Redirect()->route("admin-".$this->model . ".index");
        }
    }

    public function edit($ensetid)
    {
        $Set_id = '';
        $setdetails =    array();
        if (!empty($ensetid)) {
            $Set_id = base64_decode($ensetid);
            $setdetails   =   Setting::find($Set_id);
            $data = compact('setdetails');
            return  View("admin.$this->model.edit", $data);
        } else {
            return Redirect()->route("admin-".$this->model . ".index");
        }
    }

    public function update(Request $request, $ensetid)
    {   
     
        $Set_id = '';
        $setdetails =    array();
        if (!empty($ensetid)) {
            $Set_id = base64_decode($ensetid);
        } else {
            return Redirect()->route("admin-".$this->model . ".index");
        }
    
        $validated = $request->validate([
            'title' => 'required',
            'key' => 'required',
            // 'key'  => 'required',
            'input_type' => 'required',
        ]);
        $obj   = Setting::find($Set_id);
        $obj->title        = $request->title;
        $obj->key         = $request->key;
        $obj->value       = $request->value;
        $obj->input_type       = $request->input_type;
        $obj->editable      = 1;

        if ($request->input_type == "file" || $request->input_type == "File") {
            if ($request->hasFile('value')) {
                $extension = $request->file('value')->getClientOriginalExtension();
                $originalName = $request->file('value')->getClientOriginalName();
                $fileName = time() . '-settings.' . $extension;

                $folderName = strtoupper(date('M') . date('Y')) . "/";
                $folderPath = Config('constant.SETTINGS_IMAGE_ROOT_PATH') . $folderName;
                if (!File::exists($folderPath)) {
                    File::makeDirectory($folderPath, $mode = 0777, true);
                }
                if ($request->file('value')->move($folderPath, $fileName)) {
                    $obj->value = $folderName . $fileName;
                }
            } else {
                $obj->value       =  "";
            }
        }
        $savedata = $obj->save();
        if ($savedata) {
            Session()->flash('flash_notice', 'Setting Updated successfully.');
            return Redirect()->route("admin-".$this->model . ".index");
        }
    }

    public function destroy($ensetid)
    {
        $id = '';
        if (!empty($ensetid)) {
            $id = base64_decode($ensetid);
        }
        $settingDetails   =  Setting::find($id);
        if ($settingDetails) {
            $settingDetails->delete();
            Session()->flash('flash_notice', " Setting deleted successfully");
        }
        return back();
    }

    public function prefix(Request $request, $enslug = null)
    {       
        $prefix = $enslug;
        if ($request->isMethod('POST')) {
           
            $allData        =  $request->all();
            if (!empty($allData)) {
                if (!empty($allData['Setting'])) {
                    foreach ($allData['Setting'] as $key => $value) {
                        if (!empty($value["'id'"]) && !empty($value["'key'"])) {
                            if ($value["'type'"] == 'checkbox') {
                                $val  =  (isset($value["'value'"])) ? 1 : 0;
                            } elseif ($value["'type'"] == 'file'){
                                if(!empty($value["'value'"])) {
                                    if ($value["'value'"] instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
                                        // Handle file upload here
                                        $uploadedFile = $value["'value'"];
                    
                                        // Generate a unique file name
                                        $extension = $uploadedFile->getClientOriginalExtension();
                                        $fileName = time() . '-settings.' . $extension;
                    
                                        // Define the folder path to store the uploaded file
                                        $folderName = strtoupper(date('M') . date('Y')) . "/";
                                        $folderPath = Config('constant.SETTINGS_IMAGE_ROOT_PATH') . $folderName;
                    
                                        // Ensure the folder exists
                                        if (!File::exists($folderPath)) {
                                            File::makeDirectory($folderPath, $mode = 0777, true);
                                        }
                    
                                        // Move the uploaded file to the specified folder
                                        if ($uploadedFile->move($folderPath, $fileName)) {
                                            $val = $folderName . $fileName;
                                        }
                                    }
                                } else {
                                    $SettingData = Setting::where('id', $value["'id'"])->first();
                                    $val = $SettingData->value;
                                }
                            } else {
                                $val  =  (isset($value["'value'"])) ? $value["'value'"] : '';
                            }
                            Setting::where('id', $value["'id'"])->update(array(
                                'key'          =>  $value["'key'"],
                                'value'       =>  $val
                            ));
                        }
                    }
                }
            }
            $this->settingFileWrite();
            Session()->flash('flash_notice', 'Settings updated successfully.');
            return  Redirect()->back();
        }
        $result = Setting::where('key', 'like', $prefix . '%')->orderBy('id', 'ASC')->get()->toArray();
        if(!empty($result)) {
            foreach($result as &$val) {
               if($val['input_type'] == "file") {
                    $val['value'] = Config('constant.SETTINGS_IMAGE_URL').$val['value'];
               }
            }
        }
        return  View('admin.settings.prefix', compact('result', 'prefix'));
    }

    public function settingFileWrite()
    {
        $DB    =  Setting::query();
        $list  =  $DB->orderBy('key', 'ASC')->get(array('key', 'value'))->toArray();
        $file = Config('constant.SETTING_FILE_PATH');
        $settingfile = '<?php ' . "\n";
        $append_string    =  "";
        foreach ($list as $value) {
            $val      =   str_replace('"', "'", $value['value']);
            $settingfile .=  'config(["' . $value['key'] . '"=>"' . $val . '"]);' . "\n";
        }
        $bytes_written = File::put($file, $settingfile);
        if ($bytes_written === false) {
            die("Error writing to file");
        }
    }
}
