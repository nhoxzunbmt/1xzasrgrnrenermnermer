<?php
namespace Admin\Model\Entity;

class ServiceRegister{
	public $id;
	public $user_id;
	public $date_start;
	public $date_end;
	public $total_price;
	public $note;
	public $service_account_id;
	public $hinhthuc_thanhtoan;
	public $payment_status;
	public $payment_type;
	public $status;
	public $upgrade;
	public $order;
	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->user_id 		= 	(!empty($data['user_id'])) ? $data['user_id'] : null;
		$this->date_start  		= 	(!empty($data['date_start'])) ? $data['date_start'] : null;
		$this->date_end  = 	(!empty($data['date_end'])) ? $data['date_end'] : null;
		$this->total_price  	= 	(!empty($data['total_price'])) ? $data['total_price'] : null;
		$this->note  		= 	(!empty($data['note'])) ? $data['note'] : null;
		$this->service_account_id  		= 	(!empty($data['service_account_id'])) ? $data['service_account_id'] : null;
		$this->hinhthuc_thanhtoan  	= 	(!empty($data['hinhthuc_thanhtoan'])) ? $data['hinhthuc_thanhtoan'] : null;
		$this->payment_status 	= 	(!empty($data['payment_status'])) ? $data['payment_status'] : null;
		$this->payment_type 	= 	(!empty($data['payment_type'])) ? $data['payment_type'] : null;
		$this->status 	= 	(!empty($data['status'])) ? $data['status'] : null;
		$this->upgrade 	= 	(!empty($data['upgrade'])) ? $data['upgrade'] : null;
		$this->order 	= 	(!empty($data['order'])) ? $data['order'] : null;
	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}