<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{

    public function sendErrorResponse($errors,$code){

        $data=[
            'success' => false,
            'error' => $errors,
            'data'=> null
        ];

        return response()->json($data,$code);
        
    }

    public function sendSuccessResponse($data,$code=200){

        $data=[
            'success' => true,
            'data'=> $data
        ];

        return response()->json($data,$code);
        
    }
   
}
