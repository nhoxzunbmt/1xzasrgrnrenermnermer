<?php
namespace Block;
use Zend\View\Helper\AbstractHelper;

class BlkBangGiaDuAn extends AbstractHelper{
	protected $_data;

	public function __invoke(){
		require_once  'BlkBangGiaDuAn/default.phtml';
	}

	public function setData($table){
		$this->_data = $table->listItem(null,array('task'=>'block-bang-gia-du-an'));
		
		return $this->_data;
	}
}