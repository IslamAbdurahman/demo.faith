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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->timestamp('email_verified_at');
            $table->string('password');
            $table->string('image');
            $table->bigInteger('role')->unsigned();
            $table->foreign('role')->references('id')->on('roles')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->string('remember_token');
            $table->integer('science_id')->nullable();
            $table->double('balance');
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
        Schema::dropIfExists('users');
    }
};
