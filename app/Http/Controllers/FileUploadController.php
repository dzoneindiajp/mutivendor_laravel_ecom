<?php

namespace App\Http\Controllers;

use App\Service\FileUploadService;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function store(Request $request)
    {
        try {
            $path = $request->path ?? '';
            if ($request->hasFile('file') && !empty($path)) {
                // $fileExt = $request->file('file')->getClientOriginalExtension();                                
                $uploadedFile = $this->fileUploadService->uploadFile($request->file('file'), $path);
                $uploadFileUrl = url(\Storage::url($uploadedFile));

                return response()->json(['uploadedFile' => $uploadedFile ?? '', 'uploadFileUrl' => $uploadFileUrl ?? '', 'success' => true, 'message' => 'File Uploaded successfully'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'File could not be uploaded'], 400);
            }
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['success' => false, 'message' => 'something is wrong', 'error_msg' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $name = $request->name;

            if (!empty($name)) {
                $this->fileUploadService->deleteFromStorage($name);
            }

            return response()->json(['name' => $name, 'success' => true, 'message' => 'File Deleted successfully'], 200);
        } catch (\Exception $e) {
            \Log::error($e);

            return response()->json(['success' => false, 'message' => 'something is wrong', 'error_msg' => $e->getMessage()], 500);
        }
    }
}
