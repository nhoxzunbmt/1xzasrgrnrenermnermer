<?php
namespace User\Model\Entity;

class Comment{
	public $id;
	public $user_id;
	public $content;
	public $date_time;
	public $status;
	public $order;
	

	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->user_id  	= 	(!empty($data['user_id'])) ? $data['user_id'] : null;
		$this->content  		= 	(!empty($data['content'])) ? $data['content'] : null;
		$this->date_time  = 	(!empty($data['date_time'])) ? $data['date_time'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->order  		= 	(!empty($data['order'])) ? $data['order'] : null;
	
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}