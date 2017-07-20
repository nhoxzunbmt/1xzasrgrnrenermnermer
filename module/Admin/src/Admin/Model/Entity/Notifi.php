<?php
namespace Admin\Model\Entity;

class Notifi{
	public $id;
	public $title;
	public $content;
	public $status;
	public $date_time;
	public $type;
	
	
	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->title 		= 	(!empty($data['title'])) ? $data['title'] : null;
		$this->content  		= 	(!empty($data['content'])) ? $data['content'] : null;
		$this->status  	= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->date_time  	= 	(!empty($data['date_time'])) ? $data['date_time'] : null;
		$this->type  	= 	(!empty($data['type'])) ? $data['type'] : null;
		
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}