<?php
namespace Admin\Model\Entity;

class Business{
	public $id;
	public $type_business;
	public $name;
	public $logo;
	public $address;
	public $city;
	public $district;
	public $ward;
	public $phone;
	public $fax;
	public $website;
	public $intro;
	public $contact;
	public $department;
	public $date_time;
	public $status;
	public $order;
	public $alias;

	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->type_business= 	(!empty($data['type_business'])) ? $data['type_business'] : null;
		$this->name  		= 	(!empty($data['name'])) ? $data['name'] : null;
		$this->logo  		= 	(!empty($data['logo'])) ? $data['logo'] : null;
		$this->address  	= 	(!empty($data['address'])) ? $data['address'] : null;
		$this->city  		= 	(!empty($data['city'])) ? $data['city'] : null;
		$this->district  	= 	(!empty($data['district'])) ? $data['district'] : null;
		$this->ward  		= 	(!empty($data['ward'])) ? $data['ward'] : null;
		$this->phone  		= 	(!empty($data['phone'])) ? $data['phone'] : null;
		$this->fax  		= 	(!empty($data['fax'])) ? $data['fax'] : null;
		$this->website  	= 	(!empty($data['website'])) ? $data['website'] : null;
		$this->intro  		= 	(!empty($data['intro'])) ? $data['intro'] : null;
		$this->contact  	= 	(!empty($data['contact'])) ? $data['contact'] : null;
		$this->department  	= 	(!empty($data['department'])) ? $data['department'] : null;
		$this->date_time  	= 	(!empty($data['date_time'])) ? $data['date_time'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->order  		= 	(!empty($data['order'])) ? $data['order'] : null;
		$this->alias 		= 	(!empty($data['alias'])) ? $data['alias'] : null;
		
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}