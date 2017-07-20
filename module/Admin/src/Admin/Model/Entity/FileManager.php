<?php
namespace Admin\Model\Entity;

class FileManager{
	public $id;
	public $name;
	public $description;
	public $order;
	public $date_time;
	public $chmod;
	public $ChmodOwnerRead;
	public $ChmodOwnerWrite;
	public $ChmodOwnerExecute;
	public $ChmodGroupRead;
	public $ChmodGroupWrite;
	public $ChmodGroupExecute;
	public $ChmodEveryoneRead;
	public $ChmodEveryoneWrite;
	public $ChmodEveryoneExecute;
	public $status;
	public function exchangeArray($data){
		$this->id 			= 	(!empty($data['id'])) ? $data['id'] : null;
		$this->name 		= 	(!empty($data['name'])) ? $data['name'] : null;
		$this->description  		= 	(!empty($data['description'])) ? $data['description'] : null;
		$this->order  		= 	(!empty($data['order'])) ? $data['order'] : null;
		$this->date_time  		= 	(!empty($data['date_time'])) ? $data['date_time'] : null;
		$this->chmod  		= 	(!empty($data['chmod'])) ? $data['chmod'] : null;
		$this->ChmodOwnerRead  		= 	(!empty($data['ChmodOwnerRead'])) ? $data['ChmodOwnerRead'] : null;
		$this->ChmodOwnerWrite  		= 	(!empty($data['ChmodOwnerWrite'])) ? $data['ChmodOwnerWrite'] : null;
		$this->ChmodOwnerExecute  		= 	(!empty($data['ChmodOwnerExecute'])) ? $data['ChmodOwnerExecute'] : null;
		$this->ChmodGroupRead  		= 	(!empty($data['ChmodGroupRead'])) ? $data['ChmodGroupRead'] : null;
		$this->ChmodGroupWrite  		= 	(!empty($data['ChmodGroupWrite'])) ? $data['ChmodGroupWrite'] : null;
		$this->ChmodGroupExecute  		= 	(!empty($data['ChmodGroupExecute'])) ? $data['ChmodGroupExecute'] : null;
		$this->ChmodEveryoneRead  		= 	(!empty($data['ChmodEveryoneRead'])) ? $data['ChmodEveryoneRead'] : null;
		$this->ChmodEveryoneWrite  		= 	(!empty($data['ChmodEveryoneWrite'])) ? $data['ChmodEveryoneWrite'] : null;
		$this->ChmodEveryoneExecute  		= 	(!empty($data['ChmodEveryoneExecute'])) ? $data['ChmodEveryoneExecute'] : null;
		$this->status  		= 	(!empty($data['status'])) ? $data['status'] : null;

	}
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}