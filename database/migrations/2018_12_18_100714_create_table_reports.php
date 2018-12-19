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
            $table->integer('submission_period')->unsigned();
            $table->integer('submission_quater')->unsigned();
            $table->year('report_year');
            $table->decimal('total_capital',8, 2);
            $table->decimal('total_assest',8, 2);
            $table->decimal('total_liability',8, 2);
            $table->decimal('loan_advance',8, 2);
            $table->decimal('customer_deposits',8, 2);
            $table->decimal('profit_before_tax',8, 2); 
            $table->decimal('return_average_assets',8, 2); 
            $table->decimal('return_equity',8, 2);     
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
