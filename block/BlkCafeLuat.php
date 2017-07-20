<?php
namespace Block;
use Zend\View\Helper\AbstractHelper;

class BlkCafeLuat extends AbstractHelper{
	protected $_data;

	public function __invoke(){
		require_once  'BlkCafeLuat/default.phtml';
	}

	public function setData($table){
		$this->_data = $table->listItem(null,array('task'=>'block-cafe-luat'));
		
		return $this->_data;
	}
}