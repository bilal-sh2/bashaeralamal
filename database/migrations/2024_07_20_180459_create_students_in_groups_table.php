<?php
// database/migrations/xxxx_xx_xx_create_students_in_groups_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsInGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('students_in_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->string('student_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students_in_groups');
    }
}
