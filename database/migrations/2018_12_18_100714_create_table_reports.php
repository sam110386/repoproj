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
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('institute_id')->unsigned(); 
            $table->string('report_category');                       
            $table->integer('submission_period')->unsigned()->default(NULL);
            $table->integer('submission_quater')->unsigned()->default(NULL);
            $table->year('report_year');
            $table->double('total_capital');
            $table->double('total_assest');
            $table->double('total_liability');
            $table->double('loan_advance');
            $table->double('customer_deposits');
            $table->double('profit_before_tax'); 
            $table->double('return_average_assets'); 
            $table->double('return_equity');     
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
