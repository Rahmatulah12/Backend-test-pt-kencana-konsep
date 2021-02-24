<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Student;
use Validator;
use Illuminate\Support\Facades\DB;

class StudentController extends BaseController
{
    private $student;

    public function __construct()
    {
          $this->student = new Student();
    }

    public function index(Request $request)
    {
      $students;
      if(count($request->input()) > 0)
      {
            $students = $this->student->getAllData($request->input('size'), $request->input('keyword'));
            return response()->json([
                  'error' => false,
                  'data' => $students
            ],200);
      }

      $students = $this->student->getAllData();
      return response()->json([
            'error' => false,
            'data' => $students
      ],200);
    }

    public function store(Request $request)
    {

      $data = [
            "name" => strtolower(htmlspecialchars($request->name)),
            "email" => strtolower(htmlspecialchars($request->email)),
            "phone" => htmlspecialchars($request->phone),
            "address" => strtolower(htmlspecialchars($request->address)),
      ];

      // validation with Validator
      $validator = Validator::make($data, [
            "name" => 'required|max:50',
            'email' => 'required|email|unique:students|max:35',
            'phone' => 'required|min:10|max:12',
            'address' => 'required'
      ]);

      // check validaton
      if($validator->fails())
      {
          return response()->json([
              'error' => true,
              'message' => $validator->errors(),
          ], 400);
      }

      // Insert data
      $this->student->name = $data['name'];
      $this->student->email = $data["email"];
      $this->student->phone = $data["phone"];
      $this->student->address = $data["address"];
      $this->student->save();

      if(!$this->student){
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

    public function update(Request $request, $id)
    {
      $data = [
            "name" => strtolower(htmlspecialchars($request->name)),
            "email" => strtolower(htmlspecialchars($request->email)),
            "phone" => htmlspecialchars($request->phone),
            "address" => strtolower(htmlspecialchars($request->address)),
      ];

      // validation with Validator
      $validator = Validator::make($data, [
            "name" => 'required|max:50',
            'email' => 'required|email|max:35',
            'phone' => 'required|min:10|max:12',
            'address' => 'required'
      ]);

      // check validaton
      if($validator->fails())
      {
          return response()->json([
              'error' => true,
              'message' => $validator->errors(),
          ], 400);
      }

      // Insert data
      $student = $this->student->find($id);
      $student->name = $data['name'];
      $student->email = $data["email"];
      $student->phone = $data["phone"];
      $student->address = $data["address"];
      $student->save();

      if(!$student){
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

    public function delete($id)
    {
      $studentHobby = DB::table('student_hobies')->where('student_id', $id)->delete();
      $student = $this->student->where('id',$id)->delete();
      if(!$studentHobby && !$student){
            return response()->json([
                  'error' => true,
                  'message' => "Something went wrong.",
            ], 500);
      }
      return response()->json([
            'error' => false,
            'message' => "Data has been deleted.",
      ], 200);
    }

    public function view($id){
          $student = $this->student->find($id);
          
          if(is_null($student)){
                return response()->json([
                      "error" => true,
                      "message" => "Data not found."
                ], 500);
          }

          return response()->json([
                "error" => false,
                "data" => $student,
          ],200);
    }

    public function option()
    {
          $students = $this->student->select("id", "name")->get();
          if(!$students){
            return response()->json([
                  "error" => true,
                  "message" => "Data not found."
            ], 500);
          }
          return response()->json([
            "error" => false,
            "data" => $students,
      ],200);
    }

}
