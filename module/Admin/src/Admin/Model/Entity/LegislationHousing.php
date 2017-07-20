<?php
namespace Admin\Model\Entity;

class LegislationHousing{
	public $id;
	public $cat_id;
	public $title;
	public $content;
	public $number;
	public $placeissued;
	public $dateissued;
	public $effectivedate;
	public $expirydate;
	public $effect;
	public $status;
	public $order;
	public $date_time;
	
	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->cat_id 		= 	(!empty($data['cat_id'])) ? $data['cat_id'] : null;
		$this->title  		= 	(!empty($data['title'])) ? $data['title'] : null;
		$this->content  	= 	(!empty($data['content'])) ? $data['content'] : null;
		$this->number  		= 	(!empty($data['number'])) ? $data['number'] : null;
		$this->placeissued  	= 	(!empty($data['placeissued'])) ? $data['placeissued'] : null;
		$this->dateissued  		= 	(!empty($data['dateissued'])) ? $data['dateissued'] : null;
		$this->effectivedate  		= 	(!empty($data['effectivedate'])) ? $data['effectivedate'] : null;
		$this->expirydate  		= 	(!empty($data['expirydate'])) ? $data['expirydate'] : null;
		$this->effect  		= 	(!empty($data['effect'])) ? $data['effect'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->order  		= 	(!empty($data['order'])) ? $data['order'] : null;
		$this->date_time  		= 	(!empty($data['date_time'])) ? $data['date_time'] : null;
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}