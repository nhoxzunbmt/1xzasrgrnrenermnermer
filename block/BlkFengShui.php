<?php
namespace Block;
use Zend\View\Helper\AbstractHelper;

class BlkFengShui extends AbstractHelper{
	protected $_data;

	public function __invoke(){
		require_once  'BlkFengShui/default.phtml';
	}

	public function setData($table){
		$this->_data = $table->listItem(null,array('task'=>'list-items-fengshui-news-moi-nhat'));
		
		return $this->_data;
	}
}