<?php
namespace ZendVN\Convert;
class Price{
	public static function convert($price){
		if($price < 1000){
            $xprice = $price . ' Triệu';
        }else{
            $xprice = round(($price / 1000) * 100) / 100 . " Tỷ";
        }

        return $xprice;
	}

}