<?php
namespace Admin\Model\Entity;

class Service{
	public $id;
	public $name;
	public $images;
	public $normal;
	public $vip;
	public $hot;
	public $free;
	public $chinhchu;
	public $price;
	public $created;
	public $created_by;
	public $modified;
	public $modified_by;
	public $status;
	public $order;

	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->name 		= 	(!empty($data['name'])) ? $data['name'] : null;
		$this->images  		= 	(!empty($data['images'])) ? $data['images'] : null;
		$this->normal  = 	(!empty($data['normal'])) ? $data['normal'] : null;
		$this->vip  	= 	(!empty($data['vip'])) ? $data['vip'] : null;
		$this->hot  		= 	(!empty($data['hot'])) ? $data['hot'] : null;
		$this->free  		= 	(!empty($data['free'])) ? $data['free'] : null;
		$this->chinhchu  	= 	(!empty($data['chinhchu'])) ? $data['chinhchu'] : null;
		$this->price  		= 	(!empty($data['price'])) ? $data['price'] : null;
		$this->created 	= 	(!empty($data['created'])) ? $data['created'] : null;
		$this->created_by 	= 	(!empty($data['created_by'])) ? $data['created_by'] : null;
		$this->modified 	= 	(!empty($data['modified'])) ? $data['modified'] : null;
		$this->modified_by 	= 	(!empty($data['modified_by'])) ? $data['modified_by'] : null;
		$this->status 	= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->order 	= 	(!empty($data['order'])) ? $data['order'] : null;
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}