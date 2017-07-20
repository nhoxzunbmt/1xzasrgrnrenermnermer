<?php
namespace Admin\Model\Entity;

class FengshuiNews{
	public $id;
	public $cat_id;
	public $title;
	public $description;
	public $content;
	public $images;
	public $status;
	public $date_time;
	public $order;
	

	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->cat_id 		= 	(!empty($data['cat_id'])) ? $data['cat_id'] : null;
		$this->title  		= 	(!empty($data['title'])) ? $data['title'] : null;
		$this->description  = 	(!empty($data['description'])) ? $data['description'] : null;
		$this->content  	= 	(!empty($data['content'])) ? $data['content'] : null;
		$this->images  		= 	(!empty($data['images'])) ? $data['images'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->date_time  	= 	(!empty($data['date_time'])) ? $data['date_time'] : null;
		$this->order  		= 	(!empty($data['order'])) ? $data['order'] : null;
			
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}