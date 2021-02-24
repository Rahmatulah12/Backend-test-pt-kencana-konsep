<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\StudentHobby;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;

class StudentHobbyController extends BaseController
{
      private $studentHobby;

      public function __construct()
      {
            $this->studentHobby = new StudentHobby();
      }

      public function store(Request $request){
            $data = [];
            $temp = [];
            foreach($request->hoby_id as $hoby){
                  $temp = [
                        "student_id" => $request->student_id,
                        "hoby_id" => $hoby,
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s"),
                  ];
                  array_push($data, $temp);
            }
            $save = $this->studentHobby->insert($data);
            if(!$save){
                  return response()->json([
                        'error' => true,
                        'message' => "Something went wrong.",
                  ], 500);
            }
            return response()->json([
                  'error' => false,
                  'message' => "Data has been saved.",
            ], 200);
      }

      public function index(Request $request)
      {
            $data;
            if(count($request->input()) > 0){
                  $data = $this->studentHobby->getAllData($request->input("keyword"), (int)$request->input("size"));
            } else {
                  $data = $this->studentHobby->getAllData();
            }
            if(!$data){
                  return response()->json([
                        "error" => true,
                        "message" => "Something went wrong."
                  ], 500);
            }
            return response()->json([
                  "error" => false,
                  "data" => $data
            ], 200);
      }

      public function show($id)
      {
            $data = $this->studentHobby->find($id);
            if(!$data)
            {
                  return response()->json([
                        "error" => true,
                        "message" => "Something went wrong."
                  ], 500);
            }
            return response()->json([
                  "error" => false,
                  "data" => $data
            ], 200);
      }

      public function update($id, Request $request)
      {
            $data = $this->studentHobby->find($id);
            if(!$data){
                  return response()->json([
                        "error" => true,
                        "message" => "Data not found."
                  ], 500);
            }

            $data->student_id = $request->student_id;
            $data->hoby_id = $request->hoby_id;
            $data->save();

            if(!$data){
                  return response()->json([
                        "error" => true,
                        "message" => "Something went wrong."
                  ], 500);
            }

            return response()->json([
                  "error" => false,
                  "data" => "Data has been updated."
            ], 200);
      }

      public function delete($id){
            $data = $this->studentHobby->find($id)->delete();
            if(!$data){
                  return response()->json([
                        "error" => true,
                        "message" => "Something went wrong."
                  ], 500);
            }

            return response()->json([
                  "error" => false,
                  "data" => "Data has been deleted."
            ], 200);
      }
}