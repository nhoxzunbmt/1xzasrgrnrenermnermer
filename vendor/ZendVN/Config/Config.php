<?php

namespace ZendVN\Config;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
class Config{
	protected $adapter;
	protected $sqlObj;
    protected $db;
   	protected $title;
   	protected $keyword;
   	protected $description;
   	protected $server;
   	protected $email;
   	protected $password;
   	protected $port;
   	protected $GoogleAnalyticsCode;
   	protected $activeAccountEmail;
   	protected $limitSendEmailMarketing;
   	protected $descriptionNews;
   	protected $descriptionRealEstate;
   	protected $descriptionLegalhousing;
   	protected $commentFacebook;

    public function __construct(){
        $this->adapter 	= GlobalAdapterFeature::getStaticAdapter();
        $this->sqlObj 	= new Sql($this->adapter);
       	
       	//Config website
       	$this->title 		= $this->getConfigWebsite()->title;
       	$this->keyword 		= $this->getConfigWebsite()->keyword;
       	$this->description 	= $this->getConfigWebsite()->description;

       	//Config Email
       	$this->server 		= $this->getConfigEmail()->server;
       	$this->email 		= $this->getConfigEmail()->email;
       	$this->password 	= $this->getConfigEmail()->password;
       	$this->port 		= $this->getConfigEmail()->port;

       	//Config Advance
       	$this->GoogleAnalyticsCode 		= $this->getConfigAdvance()->GoogleAnalyticsCode;
       	$this->activeAccountEmail 		= $this->getConfigAdvance()->activeAccountEmail;
       	$this->limitSendEmailMarketing 	= $this->getConfigAdvance()->limitSendEmailMarketing;

       	//Config Display
       	$this->descriptionNews 			= $this->getConfigDisplay()->descriptionNews;
       	$this->descriptionRealEstate 	= $this->getConfigDisplay()->descriptionRealEstate;
       	$this->descriptionLegalhousing 	= $this->getConfigDisplay()->descriptionLegalhousing;
       	$this->commentFacebook 			= $this->getConfigDisplay()->commentFacebook;
    }
    
    
    protected function getConfigWebsite(){
		$select     = $this->sqlObj->select();
		$select->from('config')
				->where('id = 1');
		$result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
		$result     = $result[0];
		return \Zend\Json\Json::decode($result['website']);
	}

	protected function getConfigEmail(){
		$select     = $this->sqlObj->select();
		$select->from('config')
				->where('id = 1');
		$result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
		$result     = $result[0];
		return \Zend\Json\Json::decode($result['email']);
	}

	protected function getConfigAdvance(){
		$select     = $this->sqlObj->select();
		$select->from('config')
				->where('id = 1');
		$result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
		$result     = $result[0];
		return \Zend\Json\Json::decode($result['advance']);
	}

	protected function getConfigDisplay(){
		$select     = $this->sqlObj->select();
		$select->from('config')
				->where('id = 1');
		$result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
		$result     = $result[0];
		return \Zend\Json\Json::decode($result['display']);
	}

	public function title(){
		return $this->title;
	}

	public function description(){
		return $this->description;
	}

	public function keyword(){
		return $this->keyword;
	}

	public function server(){
		return $this->server;
	}

	public function email(){
		return $this->email;
	}

	public function password(){
		return $this->password;
	}

	public function port(){
		return $this->port;
	}

	public function GoogleAnalyticsCode(){
		return $this->GoogleAnalyticsCode;
	}

	public function activeAccountEmail(){
		return $this->activeAccountEmail;
	}
	public function limitSendEmailMarketing(){
		return $this->limitSendEmailMarketing;
	} 

	public function descriptionNews(){
		return $this->descriptionNews;
	}

	public function descriptionRealEstate(){
		return $this->descriptionRealEstate;
	}

	public function descriptionLegalhousing(){
		return $this->descriptionLegalhousing;
	}

	public function commentFacebook(){
		return $this->commentFacebook;
	}

	
} 
