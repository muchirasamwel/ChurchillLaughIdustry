<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class uploadFileController extends Controller {
   public function index(){
      return view('uploadfile');
   }
   public function UploadImageFile(Request $request){
      //echo "Hitting my upload";
      $file = $request->file('image');
      //Move Uploaded File
      try {
      	$destinationPath = 'assets/images/';
      	$file->move($destinationPath,$file->getClientOriginalName());
      	return "success "; //location $destinationPath";
      } catch (Exception $e) {
      	return " error "+e;
      }
   }
   
}
