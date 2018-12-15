<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInstitutes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username',20)->unique();
            $table->string('email')->unique();
            $table->string('password',255);
            $table->string('phone',20)->nullable();
            $table->string('logo',60)->nullable();
            $table->string('address',255)->nullable();
            $table->string('region',100)->nullable();
            $table->string('district',100)->nullable();
            $table->string('ward',100)->nullable();
            $table->string('zipcode',15)->nullable();
            $table->integer('client_male')->default(0);
            $table->integer('client_female')->default(0);
            $table->integer('staff_male')->default(0);
            $table->integer('staff_female')->default(0);
            $table->integer('boardmember_male')->default(0);
            $table->integer('boardmember_female')->default(0);
            $table->integer('status')->default(0);
            $table->rememberToken();
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
        Schema::table('institutes', function (Blueprint $table) {
            //
        });
    }
}
