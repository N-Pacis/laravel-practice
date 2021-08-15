<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documents;
use Validator;

class DocumentController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'user_id'=>'required',
            'file'=>'required|mimes:png,jpg|max:2048',
        ]); 

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }

        if($files = $request->file('file')){
            $file = $request->file->store('public/documents');

            $document = new Documents();
            $document->title = $file;
            $document->user_id = $request->user_id;
            $document->save();

            return response()->json([
                "success"=>true,
                "message"=>"File successfully uploaded",
                "file"=>$file,
                "user"=>$user,
            ]);
        }
    }
}
