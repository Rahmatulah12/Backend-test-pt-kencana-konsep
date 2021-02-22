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

      public function index()
      {
            $data = $this->studentHobby->getAllData();
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
}