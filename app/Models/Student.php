<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
      protected $table = 'students';

      protected $fillable = [
            'name', 'email', 'phone', 'address'
      ];

      public function getAllData($size = 25, $keyword = null)
      {
            $students = $this->select("id", "name", "email", "phone", "address")->where('name', 'like', '%'.$keyword.'%')
                        ->orWhere('email', 'like', '%'.$keyword.'%')->orWhere('phone', 'like', '%'.$keyword.'%')
                        ->orWhere('address', 'like', '%'.$keyword.'%')->paginate($size);
            return $students;
      }
}