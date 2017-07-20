<?php
namespace Block;
use Zend\View\Helper\AbstractHelper;

class BlkNhanXet extends AbstractHelper{
	protected $_data;

	public function __invoke(){
		require_once  'BlkNhanXet/default.phtml';
	}

	public function setData($table){
		$this->_data = $table->listItem(null,array('task'=>'block-list-items-comment'));
		
		return $this->_data;
	}
}