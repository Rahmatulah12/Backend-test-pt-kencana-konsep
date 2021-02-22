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

      public function getAllData(){
            $students = DB::select("SELECT students.id AS student_id, students.name AS student_name,
            GROUP_CONCAT(hobies.name, '') AS hobby FROM student_hobies
            INNER JOIN students ON student_hobies.student_id = students.id
            INNER JOIN hobies ON student_hobies.hoby_id = hobies.id
            GROUP BY students.id");
            return $students;
      }
}