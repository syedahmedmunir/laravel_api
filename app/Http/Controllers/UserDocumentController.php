<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\FileSizeLimit;
use Validator;
use App\Models\UserDocument;

class UserDocumentController extends BaseController
{
   public function store(Request $request){

      $validator = Validator::make($request->all(), [
            'file' => ['required', 'file', new FileSizeLimit()],
            'file_name'       => 'required',
      ]);
      if ($validator->fails()) {
         $errors = $validator->errors()->toArray();
         return  $this->sendErrorResponse($errors,400);
      }

      $fileUrl = $request->file;
      $temporaryName = time().$fileUrl->getClientOriginalName();
      $fileUrl->move('upload/', $temporaryName);
      $fileUrlNew = 'upload/'.$temporaryName;


      
      $already_file = UserDocument::where('file_name',$request->file_name)->first();

      // Deleting Previous FIle
      if($already_file){
         if($already_file->file_path && file_exists($already_file->file_path) ){
            unlink($already_file->file_path);
         }
      }

      $userdocument= UserDocument::updateOrCreate(['file_name'=>$request->file_name],
      [
         'file_path' =>  $fileUrlNew

      ]);

      $message = "Store Successfully";
      return  $this->sendSuccessResponse($message,201);
   }

   public function download(Request $request){

      $validator = Validator::make($request->all(), [
         'file_name'       => 'required'
      ]);
      if ($validator->fails()) {
         $errors = $validator->errors()->toArray();
         return  $this->sendErrorResponse($errors,400);
      }

      $userdocument =UserDocument::where('file_name',$request->file_name)->first();
      if (!$userdocument) {
         $error = "File Not Found";
         return $this->sendErrorResponse($error, 404);
     }
 
      $file_url           =       $userdocument->file_path;
      $file               =       public_path($file_url);

      if(empty($file_url) || !file_exists($file)){
         
         $error ="File Not Found";
         return  $this->sendErrorResponse($error,404);
      }

      return response()->download( $file ,$userdocument->file_name)->setStatusCode(200);
   }
}
