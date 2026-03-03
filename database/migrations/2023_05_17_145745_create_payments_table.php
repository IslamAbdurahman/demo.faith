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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('month');
            $table->double('amount')->default(0);
            $table->double('teacher_amount')->default(0);
            $table->double('discount')->default(0);
            $table->tinyInteger('education')->default(0);
            $table->tinyInteger('kitchen')->default(0);
            $table->tinyInteger('bedroom')->default(0);
            $table->string('comment')->nullable();

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->bigInteger('graphic_id')->unsigned();
            $table->foreign('graphic_id')->references('id')->on('graphics')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->bigInteger('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->bigInteger('kassa_id')->unsigned()->default(1);
            $table->foreign('kassa_id')->references('id')->on('kassa')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->bigInteger('transaction_id')->unsigned()->nullable();
            $table->timestamp('date')->default(date('Y-m-d H:i:s'));

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
        Schema::dropIfExists('payments');
    }
};
