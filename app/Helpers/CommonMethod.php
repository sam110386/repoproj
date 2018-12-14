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
}