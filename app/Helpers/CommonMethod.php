<?php 
namespace App\Helpers;
class CommonMethod {

	/* Format given date to stored date format */
    public static function formatDate($date = null){
    	return date('m/d/Y', strtotime($date));
    }
    /* Format given date to stored date format */
    public static function formatDateWithTime($date = null){
    	return date('m/d/Y h:i A', strtotime($date));;
    }

    public static function getMonthName($id){
    	$months=array(
    		1=>"January",
    		2=>"February",
    		3=>"March",
    		4=>"April",
    		5=>"May",
    		6=>"June",
    		7=>"July",
    		8=>"August",
    		9=>"September",
    		10=>"October",
    		11=>"November",
    		12=>"December"
    		);
    	return isset($months[$id])?$months[$id]:'';
    }

    public static function getQuarterName($id){
    	return 'Q'.$id;
    }
}