<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lid_students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lid_id')->unsigned();
            $table->foreign('lid_id')->references('id')->on('lids')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->bigInteger('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->string('comment');
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
        Schema::dropIfExists('lid_students');
    }
};
