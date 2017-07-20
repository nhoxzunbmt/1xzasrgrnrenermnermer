<?php
namespace Block;
use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorInterface;

use Zend\ServiceManager\ServiceLocatorAwareInterface;

class BlkRelated extends AbstractHelper implements ServiceLocatorAwareInterface {
    protected $_data;
	protected $_table;

	public function __invoke($position){
	    
	    $routeMatch = $this->serviceLocator->getServiceLocator()->get('Application')->getMvcEvent()->getRouteMatch();
	    echo '<pre>';
	        print_r($routeMatch);
	    echo '</pre>';
	    $this->setData($position);
		require_once  'Block/default.phtml';
	}
	public function setTable($table){
	    $this->_table = $table;
	}
	private function setData($position){
	    if($position){
            $this->_data = $this->_table->listItem($this->_arrParam,array('task'=>'tin-tuong-tu'));
	    }
		return $this->_data;
	}
	
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
	    $this->serviceLocator = $serviceLocator;
	}
	public function getServiceLocator() {
	    return $this->serviceLocator;
	}
}