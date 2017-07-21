<?php
namespace ZendVN\Date;
class BetweenDate{
	public static function isValid($currentDate,$DateBegin,$DateEnd){
		$dateCurrent 	= strtotime($currentDate);
		$startDate 		= strtotime($DateBegin);
		$endDate 		= strtotime($DateEnd);

		$flag 			= false;
		if($dateCurrent > $startDate && $dateCurrent < $endDate){
   			$flag = true;
		}  
		return $flag;
	}

}