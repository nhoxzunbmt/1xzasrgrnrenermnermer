<?php
namespace User\Model\Entity;

class RegisterEmail{
	public $id;
	public $name;
	public $email;
	public $transaction;
	public $cat_id;
	public $city;
	public $district;
	public $pricefrom;
	public $priceto;
	public $area;
	public $road;
	public $direction;
	public $juridical;
	public $order;
	public $status;
	public $date_time;
	

	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->name  		= 	(!empty($data['name'])) ? $data['name'] : null;
		$this->email  		= 	(!empty($data['email'])) ? $data['email'] : null;
		$this->transaction  	= 	(!empty($data['transaction'])) ? $data['transaction'] : null;
		$this->cat_id  		= 	(!empty($data['cat_id'])) ? $data['cat_id'] : null;
		$this->city  		= 	(!empty($data['city'])) ? $data['city'] : null;
		$this->district  	= 	(!empty($data['district'])) ? $data['district'] : null;
		$this->pricefrom  		= 	(!empty($data['pricefrom'])) ? $data['pricefrom'] : null;
		$this->priceto  	= 	(!empty($data['priceto'])) ? $data['priceto'] : null;
		$this->area= 	(!empty($data['area'])) ? $data['area'] : null;
		$this->road  	= 	(!empty($data['road'])) ? $data['road'] : null;
		$this->direction  		= 	(!empty($data['direction'])) ? $data['direction'] : null;
		$this->juridical  	= 	(!empty($data['juridical'])) ? $data['juridical'] : null;
		$this->order  		= 	(!empty($data['order'])) ? $data['order'] : null;
		$this->status  	= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->date_time  	= 	(!empty($data['date_time'])) ? $data['date_time'] : null;
		
		
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}