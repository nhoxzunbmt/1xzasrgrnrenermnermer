<?php
namespace ZendVN\Filter;


class ReadMore{
	public static function create($string,$start,$end){
        //Loai bo tag html ra khoi chuoi
        $string = strip_tags($string);
        //Kiem ta xem chuoi lon hon bao nhiêu kí tu quy dinh
        if(strlen($string) > $end){
            //Neu lon hon so kí tu thì thuc hien cut chuoi tu vi trí $start $den vi trí $end
            $stringCut = substr($string,$start,$end);
            $string = substr($stringCut,0,strrpos($stringCut,' ')) .'...';
        }
        return $string;
    }

}