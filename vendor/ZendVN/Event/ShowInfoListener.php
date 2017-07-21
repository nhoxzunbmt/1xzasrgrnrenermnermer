<?php
namespace ZendVN\Event;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class ShowInfoListener implements ListenerAggregateInterface{
	protected $listeners = array();
	public function attach(EventManagerInterface $event){
		$shareEventManager = $event->getSharedManager();
		$this->listeners[] =  $shareEventManager->attach('ZendVN\Event\Foo','showInfo',array($this,'functionDoOne'));
		$this->listeners[] =  $shareEventManager->attach('ZendVN\Event\Foo','showInfo',array($this,'functionDoTwo'));
	
	}

	public function detach(EventManagerInterface $event){
		if(!empty($this->listeners)){
			foreach($this->listeners as $index->$listener){
				if($event->detach($listener)) unset($this->listeners[$index]);
			}
		}
		
	}

	public function functionDoOne($e){
		echo '<pre>';
        print_r('eventManagerOne : Event eventNew 01');
        echo '</pre>';
	}

	public function functionDoTwo($e){
		echo '<pre>';
        print_r('eventManagerOne : Event eventNew 02');
        echo '</pre>';
	}
}