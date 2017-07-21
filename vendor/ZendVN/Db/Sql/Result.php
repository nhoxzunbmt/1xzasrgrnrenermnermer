<?php
namespace ZendVN\Db\Sql;
class Result{
	public static function toArray($selectObj,$adapter){
		$sqlString	= $selectObj->getSqlString($adapter->getPlatform());
		$result		= $adapter->query($sqlString)->execute();
        //trả về array
        $result     = array_values(iterator_to_array($result));
        return $result;
	}

}