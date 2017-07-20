<?php
namespace Block;
use Zend\View\Helper\AbstractHelper;

class BlkAgency extends AbstractHelper{
	protected $_data;

	public function __invoke(){
		require_once  'BlkAgency/default.phtml';
	}

	public function setData($table){
		$this->_data = $table->listItem(null,array('task'=>'block-list-items-hightlight'));
		
		return $this->_data;
	}
}