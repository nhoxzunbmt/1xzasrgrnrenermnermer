<?php
namespace User\Model\Entity;

class Account{
	public $id;
	public $username;
	public $password;
	public $email;
	public $avatar;
	public $fullname;
	
	public $city_id;
	public $website;
	public $phone;
	public $active_code;
	public $status;
	public $group_id;
	public $register_ip;
	public $register_date;
	public $diachi;
	public $fpass_code;
	public $banned;
	public $order;
	public $introduced;

	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->username  	= 	(!empty($data['username'])) ? $data['username'] : null;
		$this->password  	= 	(!empty($data['password'])) ? $data['password'] : null;
		$this->email  		= 	(!empty($data['email'])) ? $data['email'] : null;
		$this->avatar  		= 	(!empty($data['avatar'])) ? $data['avatar'] : null;
		$this->fullname  	= 	(!empty($data['fullname'])) ? $data['fullname'] : null;
		
		$this->city_id  	= 	(!empty($data['city_id'])) ? $data['city_id'] : null;
		$this->website  		= 	(!empty($data['website'])) ? $data['website'] : null;
		
		$this->phone  		= 	(!empty($data['phone'])) ? $data['phone'] : null;
		$this->active_code  = 	(!empty($data['active_code'])) ? $data['active_code'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->group_id  	= 	(!empty($data['group_id'])) ? $data['group_id'] : null;
		$this->register_ip  = 	(!empty($data['register_ip'])) ? $data['register_ip'] : null;
		$this->register_date  = 	(!empty($data['register_date'])) ? $data['register_date'] : null;
		$this->diachi  		= 	(!empty($data['diachi'])) ? $data['diachi'] : null;
		$this->fpass_code  	= 	(!empty($data['fpass_code'])) ? $data['fpass_code'] : null;
		$this->banned  		= 	(!empty($data['banned'])) ? $data['banned'] : null;
		$this->order  		= 	(!empty($data['order'])) ? $data['order'] : null;
		$this->introduced  		= 	(!empty($data['introduced'])) ? $data['introduced'] : null;
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}