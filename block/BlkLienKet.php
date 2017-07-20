<?php
namespace Block;
use Zend\View\Helper\AbstractHelper;

class BlkLienKet extends AbstractHelper{
	protected $_data;

	public function __invoke(){
		require_once  'BlkLienKet/default.phtml';
	}

	public function setData($table){
		$this->_data = $table->listItem(null,array('task'=>'block-website-ads'));
		
		return $this->_data;
	}
}