<?php
namespace ZendVN\Event;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManagerAwareInterface;

class Foo implements EventManagerAwareInterface{
	protected $events;


	public function setEventManager(EventManagerInterface $eventManager){
		$eventManager->setIdentifiers(__CLASS__);
		$this->events = $eventManager;
		return $this;
	}
	public function getEventManager(){
		if(!$this->events){
			$this->setEventManager(new EventManager(__CLASS__));
		}
		return $this->events;
	}
	public function showInfo($name,$birthday){
		$params = array($name,$birthday);
        $this->getEventManager()->trigger(__FUNCTION__, $this, $params);
	}
}