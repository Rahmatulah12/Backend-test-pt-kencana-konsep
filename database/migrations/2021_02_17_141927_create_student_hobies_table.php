<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentHobiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_hobies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('student_id')->autoIncrement(false)->nullable($value = false);
            $table->integer('hoby_id')->autoIncrement(false)->nullable($value = false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_hobies');
    }
}
