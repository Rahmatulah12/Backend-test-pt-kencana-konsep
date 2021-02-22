<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = [
            ['name' => 'Janah', 'email' => 'janah@123.com', 'phone'=>'081234567890', 'address' => 'Jl. OK'],
            ['name' => 'Jamal', 'email' => 'jamaludin@test.com', 'phone'=>'081234567891', 'address' => 'Jl. OK'],
            ['name' => 'Iksan', 'email' => 'iksan@test.com', 'phone'=>'081234567892', 'address' => 'Jl. OK'],
            ['name' => 'Siti', 'email' => 'siti@test.com', 'phone'=>'081234567893', 'address' => 'Jl. OK'],
        ];
        DB::table('students')->insert($students);
    }
}
