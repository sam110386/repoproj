<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->increments('id'); 			
            $table->string('report_category',100)->nullable();
            $table->string('submission_period',100)->nullable();
            $table->string('total_capital',100)->nullable();
            $table->string('total_assest',100)->nullable();
            $table->string('total_liability',100)->nullable();
            $table->string('loan_advance',100)->nullable();
            $table->string('customer_deposits',100)->nullable();
            $table->string('profit_before_tax',100)->nullable();
            $table->string('return_average_assets',100)->nullable();
            $table->string('return_equity',100)->nullable();            
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
        Schema::table('reports', function (Blueprint $table) {
            //
        });
    }
}
