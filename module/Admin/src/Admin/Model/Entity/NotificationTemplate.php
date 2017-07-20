<?php
namespace Admin\Model\Entity;

class NotificationTemplate{
	public $id;
	public $title;
	public $content;
	

	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->title 		= 	(!empty($data['title'])) ? $data['title'] : null;
		$this->content  		= 	(!empty($data['content'])) ? $data['content'] : null;
		
		
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}