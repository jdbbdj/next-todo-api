<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
Use Exception;
Use Throwable;


class TaskController extends Controller
{

    public function index()
    {
    

        try {
            $result = Task::all();
            return response()->json([
                'tasks'=>$result
            ],201);
          
          } catch (Throwable $e) {
          
            return response()->json([
                'message'=>'Ye'
            ],400);
          }
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $result = Task::create($input);
        if($result){
            return response()->json([
                'message'=>'User created successfully!',
                'task'=>$result
            ],201);
        }else{
            return response()->json([
                'error'=>$result,
                'message'=>'Something went wrong'
            ],400);
        }
    }


    public function show($id)
    {
        $result = Task::find($id);
        if($result){
            return response()->json([
                'task'=>$result
            ],201);
        }else{
            return response()->json([
                'error'=>$result,
                'message'=>'Something went wrong'
            ],400);
        }


    }

    public function update(Request $request,$id)
    {
        $result = Task::find($id);
        if($result){
        $input = $request->all();
        $result->update($input);
        return response()->json([
            'message'=>'updated!'
        ],201);

        }else{
            return response()->json([
                'message'=>'User not Found!'
            ],400);
        }
        
    }

    public function destroy($id)
    {
        $result = Task::destroy($id);
        if($result){
            return response()->json([
                'message'=>'deleted!'
            ],201);
        }else{
            return response()->json([
                'message'=>'Something went wrong!'
            ],400);
        }
    }
}
