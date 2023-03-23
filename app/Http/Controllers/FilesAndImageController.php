<?php

namespace App\Http\Controllers;

use App\FileImage;
use Carbon\Carbon;
use App\FileImageCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilesAndImageController extends Controller
{


	public	function listImage(Request $request){
			$images = FileImage::orderBy('id','desc')->paginate(20);

			return view('list-images',compact('images'));
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFilesOrImages(Request $request)
    {
		$time = Carbon::now()->timestamp.'_';
    	$path = $request->get('save_to_path');
        $prefix = $request->get('prefix');
        $file       = $request->file('file');
        $file_name  = $file->getClientOriginalName();
        $filePath   = $file->move('uploads/'.$path.'/', $prefix.'_'.$time.'_'.$file_name);

        if($request->get('car_id')){
			$car_id = $request->get('car_id');
		}else{
			$car_id = 0;
		}
    
        FileImage::create([
            'file_name'     => $file_name,
            'path'          => $filePath,
            'imei'          => $prefix,
            'car_id'          => $car_id,
            'who_upload'    => $request->get('who_upload')
        ]);
        
        return 'Done';
    }


	/**
	 * @param Request $request
	 * @return string
	 */
	public function quickUploadFile(Request $request)
	{
		$citizen_id = $request->citizen_id;
		$file       = $request->file('file');
		$file_name  = $file->getClientOriginalName();
		$filePath   = $file->move('uploads/customers/', $citizen_id.'_'.$file_name);

		FileImageCustomer::create([
			'file_name'     => $file_name,
			'path'          => $filePath,
			'citizen_id'    => $citizen_id,
			'who_upload'    => $request->get('who_upload')
		]);

		return 'Done';
    }


	/**
	 * @param Request $request
	 * @return string
	 */
	public function saleUploadFile(Request $request)
	{
		$citizen_id = $request->citizen_id;
		$file       = $request->file('file');
		$file_name  = $file->getClientOriginalName();
		$filePath   = $file->move('uploads/customers/', $citizen_id.'_'.$file_name);

		FileImageCustomer::create([
			'file_name'     => $file_name,
			'path'          => $filePath,
			'citizen_id'    => $citizen_id,
			'who_upload'    => $request->get('who_upload')
		]);

		return 'Done';
	}

	public function deleteFilesOrImages($id){
		$file = FileImage::find($id);
		$file->delete();
		return redirect()->back();
	}
}
