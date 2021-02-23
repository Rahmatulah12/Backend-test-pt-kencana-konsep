<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hoby extends Model
{
      protected $table = 'hobies';

      protected $fillable = [
            'name',
      ];

      public function getAllData($keyword = null, $size = 25){
            $students = $this->select("id", "name", "created_at", "updated_at")->where("id", 'LIKE', "%$keyword%")
            ->orWhere("name", "LIKE", "%$keyword%")->orWHere("created_at", "LIKE", "%$keyword%")->orWhere("updated_at", "LIKE", "%$keyword%")->paginate($size);
            return $students;
      }
}