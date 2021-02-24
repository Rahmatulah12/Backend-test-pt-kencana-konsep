<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Hoby;
use Illuminate\Http\Request;
use Validator;

class HobbyController extends BaseController
{
    private $hobby;

    public function __construct()
    {
          $this->hobby = new Hoby();
    }

    public function index(Request $request){
          $hobbies;
          $keyword = $request->input("keyword")?$request->input("keyword") : null;
          if(count($request->input()) > 0)
          {
                $hobbies = $this->hobby->getAllData($keyword, (int)$request->input("size"));

          } else {
            $hobbies = $this->hobby->getAllData();
          }

          return response()->json([
                "error" => false,
                "data" => $hobbies,
          ],200);

    }

    public function show($id)
    {
      $hobby = $this->hobby->find($id);
      if(!$hobby)
      {
            return response()->json([
                  'error' => true,
                  'message' => "Something went wrong.",
            ], 500);
      }

      return response()->json([
            'error' => false,
            'message' => $hobby,
      ], 200);
    }

    public function store(Request $request){
      $data = [
            "name" => strtolower(htmlspecialchars($request->name)),
      ];
      // validation with Validator
      $validator = Validator::make($data, [
            "name" => 'required',
      ]);
      // check validaton
      if($validator->fails())
      {
          return response()->json([
              'error' => true,
              'message' => $validator->errors(),
          ], 400);
      }
      $this->hobby->name = $data["name"];
      $this->hobby->save();
      if(!$this->hobby){
            return response()->json([
                  'error' => true,
                  'message' => "Something went wrong.",
            ], 500);
      }

      return response()->json([
            'error' => false,
            'message' => "Hobby has been added.",
      ], 200);
    }

    public function update($id, Request $request)
    {
      $data = [
            "name" => strtolower(htmlspecialchars($request->name)),
      ];

      // validation with Validator
      $validator = Validator::make($data, [
            "name" => 'required',
      ]);
      // check validaton
      if($validator->fails())
      {
          return response()->json([
              'error' => true,
              'message' => $validator->errors(),
          ], 400);
      }

      $hobby = $this->hobby->find($id);
      $hobby->name = $data["name"];
      $hobby->save();

      if(!$hobby)
      {
            return response()->json([
                  'error' => true,
                  'message' => "Something went wrong.",
            ], 500);
      }

      return response()->json([
            'error' => false,
            'message' => "Hobby has been updated.",
      ], 200);
    }

    public function delete($id)
    {
      $hobby = $this->hobby->find($id)->delete();
      if(!$hobby)
      {
            return response()->json([
                  'error' => true,
                  'message' => "Something went wrong.",
            ], 500);
      }

      return response()->json([
            'error' => false,
            'message' => "Hobby has been deleted.",
      ], 200);
    }

    public function option()
    {
          $hobbies = $this->hobby->select("id", "name")->get();
          if(!$hobbies)
            {
                  return response()->json([
                        'error' => true,
                        'message' => "Something went wrong.",
                  ], 500);
            }

            return response()->json([
                  'error' => false,
                  'message' => $hobbies,
            ], 200);
    }
}
