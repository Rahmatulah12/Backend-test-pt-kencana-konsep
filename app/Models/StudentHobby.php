<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StudentHobby extends Model
{
      protected $table = 'student_hobies';

      protected $fillable = [
            'student_id', 'hoby_id',
      ];

      public function getAllData($keyword = null, $limit = 25){
            $students = DB::table("student_hobies")->join("students", "student_hobies.student_id", "=", "students.id")
            ->join("hobies", "student_hobies.hoby_id", '=', "hobies.id")
            ->select("student_hobies.id", "students.id as student_id", "students.name as student_name", "hobies.name as hobby")
            ->where("student_hobies.id", "LIKE", "%$keyword%")->orWhere("students.id", "LIKE", "%$keyword%")
            ->orWhere("students.name", "LIKE", "%$keyword%")->orWhere("hobies.name", "LIKE", "%$keyword%")->paginate($limit);
            return $students;
      }
}