<?php
namespace ZendVN\System;

use Zend\Session\Container;

class Info{
	public function __construct(){
		$ssInfo = new Container('info');
	}

	public function storeInfo($data){
		$ssInfo = new Container('info');
		$ssInfo->user 		= $data['user'];
		$ssInfo->group 		= $data['group'];
		$ssInfo->permission = $data['permission'];
	}

	public function destroyInfo(){
		$ssInfo = new Container('info');
		$ssInfo->getManager()->getStorage()->clear();
	}

	public function getUserInfo($element = null){
		$ssInfo = new Container('info');
		$userInfo =  $ssInfo->user;
		$result = !empty($element) ? $userInfo->$element : $userInfo;
		return $result;
	}

	public function getGroupInfo($element = null){
		$ssInfo 	= new Container('info');
		$groupInfo 	=  $ssInfo->group;
		$result 	= !empty($element) ? $groupInfo[$element] : $groupInfo;
		return $result;
	}
	public function getPermission($element = null){
		$ssInfo = new Container('info');
		$permissionInfo =  $ssInfo->permission;
		$result = !empty($element) ? $permissionInfo->$element : $permissionInfo;
		return $result;
	}
}