<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecificUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specific_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('name', 80);
            $table->string('last_name', 80);
            $table->string('username', 25)->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->integer('sex');
            $table->date('birthday');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('specific_users');
    }
}
