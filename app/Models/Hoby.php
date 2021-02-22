<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hoby extends Model
{
      protected $table = 'hobies';

      protected $fillable = [
            'name',
      ];
}