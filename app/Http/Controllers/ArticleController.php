<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Article;
use DB;


class ArticleController extends BaseController
{

    public function index($id=null){

        $articles = Article::orderBy('id');

        if(!empty($id)){
            $articles->where('id',$id);

            $articles=$articles->first();

            if(!$articles){
                $error = "No Article Found";
                return  $this->sendErrorResponse($error,404);
            }

        }else{
            $articles = $articles->get();
        }

        return  $this->sendSuccessResponse($articles,200);
    }


    public function store(Request $request){

     $validator = Validator::make($request->all(), [
            'title'             => 'required|max:30',
            'content'           => 'required',
            'author'            => 'required',
            'category'          => 'required',
            'published_at'      => 'required|date_format:Y-m-d',
      ]);
      if ($validator->fails()) {
         $errors = $validator->errors()->toArray();
         return  $this->sendErrorResponse($errors,400);
      }

      DB::beginTransaction();

      $article = new Article();

      $article->title           = $request->title;
      $article->content         = $request->content;
      $article->author          = $request->author;
      $article->category        = $request->category;
      $article->published_at    = $request->published_at;
      $article->save();

      
      DB::commit();

      $message = "Store Successfully";
      return  $this->sendSuccessResponse($message,201);
    }

    public function update(Request $request,$id){

      $validator = Validator::make($request->all(), [
            'title'             => 'max:30',
            'published_at'      => 'date_format:Y-m-d',
      ]);

      if ($validator->fails()) {
         $errors = $validator->errors()->toArray();
         return  $this->sendErrorResponse($errors,400);
      }

        $article = Article::find($id);
        if (!$article) {
            $error = "Article Not Found";
            return $this->sendErrorResponse($error, 404);
        }

        DB::beginTransaction();

        if($request->title){
            $article->title = $request->title;
        }
        if($request->content){
            $article->content = $request->content;
        }
        if($request->author){
            $article->author = $request->author;
        }
        if($request->category){
            $article->category = $request->category;
        }
        if($request->published_at){
            $article->published_at = $request->published_at;
        }

        $article->update();
       
        DB::commit();

        $message = "Update Successfully";
        return  $this->sendSuccessResponse($message,200);
    }

    public function delete($id){

        $article = Article::find($id);
        if (!$article) {
            $error = "Article Not Found";
            return $this->sendErrorResponse($error, 404);
        }

        DB::beginTransaction();

        $article->delete();

        DB::commit();

        $message = "Deleted Successfully";
        return  $this->sendSuccessResponse($message,200);
    }
}
