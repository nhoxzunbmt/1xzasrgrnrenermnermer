<?php
namespace ZendVN\Controller;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\PluginManager;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;
class ActionController extends AbstractActionController{
	protected $_formObj;
	protected $_tableObj;
	protected $_params;
	protected $_arrParam;
	protected $_options = array(
		'tableName',
		'formName'
	);

	public function setPluginManager(PluginManager $plugins){
		$this->getEventManager()->attach(MvcEvent::EVENT_DISPATCH,array($this,'onInit'),100);
		parent::setPluginManager($plugins);
	}
	public function onInit(MvcEvent $e){
		
		//GET MODULE - CONTROLLER - ACTION
		$this->_arrParam    	= $this->params()->fromRoute();
		$routeMatch 			= $e->getRouteMatch();
		$controllerArray		= explode('\\', $routeMatch->getParam('controller'));

		$this->_params['module']	=	strtolower($controllerArray[0]);
		$this->_params['controller']=	strtolower($controllerArray[2]);
		$this->_params['action']	=	$routeMatch->getParam('action');

		$viewModel 				= $e->getApplication()->getMvcEvent()->getViewModel();
		$viewModel->module 		= $this->_params['module'];
		$viewModel->controller 	= $this->_params['controller'];
		$viewModel->action 		= $this->_params['action'];
		//SET LAYOUT
		//$config = $this->getServiceLocator()->get('config');
		//$this->layout($config['module_layouts'][$controllerArray[0]]);

		//CHECK PERMISSION 
		
		$loggedStatus 	= $this->identity() ? true : false;
		if($this->_params['module'] == 'admin' || $this->_params['module'] == 'user'){
			if($loggedStatus == false && $this->_params['module'] == 'user') $this->goLogin();
			if($loggedStatus == false && $this->_params['module'] == 'admin') $this->goLoginAdmin();
				
			$info 		= new \ZendVN\System\Info();
			$groupAcp	= $info->getGroupInfo('group_acp');

			if($loggedStatus == true && $groupAcp == 0) $this->goNoAccess();
			$permission = $info->getPermission();
			if($permission['privileges'] != 'full'){
				$aclObj = new \ZendVN\System\Acl($permission['role'],$permission['privileges']);
				if($aclObj->isAllowed($this->_params) == false) $this->goNoAccess();
			}
			

		}else if($this->_params['module'] == 'user'){
			if($this->_params['controller'] == 'account' && $loggedStatus == false) $this->goLogin();
		}

		//KIỂM TRA TIN BẤT ĐỘNG SẢN ĐĂNG 
		if($this->_params['controller'] == 'realestate' && $this->_params['action'] == 'detail'){
			$RealEstateTable 	= $this->getServiceLocator()->get('Home\Model\RealEstateTable');
			$item               = $this->getTable()->getItem($this->_arrParam); 
			$hansudung = explode("/",$item['date_end']);
			
	        //tính số ngày còn lại của tin đăng
	        $month  = !empty($hansudung[1]) ? $hansudung[1] : '';
	        $day    = !empty($hansudung[0]) ? $hansudung[0] : '';
	        $year   = !empty($hansudung[2]) ? $hansudung[2] : '';

	        $remain = ceil((mktime(0,0,0,$month,$day,$year) - time()) / 86400);  
	        //Nếu tin chưa kích hoạt, thời hạn đăng đã hết thì không thể xem được tin đó
			if(empty($item['type_news']) || $item['status'] != 5 || $remain <= 0){
				//$this->goNoView();
			}
		}

		//Kiểm tra bảo trì website
		if($this->_params['module'] == 'home' || $this->_params['module'] == 'user'){
			$config 	= $this->getServiceLocator()->get('Admin\Model\ConfigTable');
			$itemConfig = $config->getItem(array('id'=>1),array('task'=>'get-item'));      
            $arrConfig  = \Zend\Json\Json::decode($itemConfig->maintenance);

            if($arrConfig->status == 1){
            	$this->goMaintenance();
            }
		}

		//Cấm truy cập website(ban nick\ip)
		if($this->_params['module'] == 'home' || $this->_params['module'] == 'user'){
			$flagBan = false;
			//Trường hợp thành viên đăng nhập(cấm nick)
			if(!empty($this->identity()->id)){
				$userTable 	= $this->getServiceLocator()->get('Admin\Model\UserTable');
				$itemBan 	= $userTable->getItem(array('id'=>$this->identity()->id),array('task'=>'get-item-with-id'));
				if(!empty($itemBan)){
					$flagBan = true;
				}
			}else{
				//Trường hợp cấm IP
				$ip = $_SERVER['REMOTE_ADDR'];
				$validator = new \Zend\Validator\Ip();
				if($validator->isValid($ip)) {
				    $userTable 	= $this->getServiceLocator()->get('Admin\Model\UserTable');
					$itemBan 	= $userTable->getItem(array('ip'=>$ip),array('task'=>'get-item-with-ip'));
					if(!empty($itemBan)){
						$flagBan = true;
					}
				}
			}
			
			if($flagBan == true){
				$this->goBanned();
			}	
		}

		//Kiểm tra trang doanh nghiệp có tồn tại không
		if($this->_params['module'] == 'home' && $this->_params['controller'] == 'business' ){
			if($this->_params['action'] == 'detail'
				|| $this->_params['action'] == 'landsale'
				|| $this->_params['action'] == 'landforrent'
				|| $this->_params['action'] == 'investors'
				|| $this->_params['action'] == 'construction'
				|| $this->_params['action'] == 'management'
				|| $this->_params['action'] == 'design'
				|| $this->_params['action'] == 'distributors'
				|| $this->_params['action'] == 'contact'
				|| $this->_params['action'] == 'department'){
				$businessTable 	= $this->getServiceLocator()->get('Home\Model\BusinessTable');
				
				$item           = $businessTable->getItem($this->_arrParam);
				if(empty($item)){
					$this->goNotFoundPageBusiness();
				}
			}
		}
		$this->init();
		
	}

	public function init(){

	}

	public function getTable(){
        if(empty($this->_tableObj)){
            $this->_tableObj = $this->getServiceLocator()->get($this->_options['tableName']);
        }
        return $this->_tableObj;
    }

    public function getForm(){
        if(empty($this->_formObj)){
            $this->_formObj =  $this->serviceLocator->get('FormElementManager')->get($this->_options['formName']);
        }
        return $this->_formObj;
    }

    public function goLogin(){
    	$url 		= $this->url()->fromRoute('MVC_HomeRouter/action',array(
    		'module'		=>	'home',
    		'controller'	=>	'user',
    		'action'		=>	'login'
    	));
    	$response 	= $this->getResponse();
    	$response->setStatusCode(302);
    	$response->getHeaders()->addHeaderLine('Location',$url);

    	$this->getEvent()->stopPropagation();
    	return $response;
    }

    public function goLoginAdmin(){
    	$url 		= $this->url()->fromRoute('MVC_HomeRouter/action',array(
    		'module'		=>	'home',
    		'controller'	=>	'user',
    		'action'		=>	'login-admin'
    	));
    	$response 	= $this->getResponse();
    	$response->setStatusCode(302);
    	$response->getHeaders()->addHeaderLine('Location',$url);

    	$this->getEvent()->stopPropagation();
    	return $response;
    }

     public function goNoAccess(){
    	
    	$url 		= $this->url()->fromRoute('MVC_HomeRouter/action',array(
    		'module'		=>	'home',
    		'controller'	=>	'notice',
    		'action'		=>	'no-access'
    	));
    	$response 	= $this->getResponse();
    	$response->setStatusCode(302);
    	$response->getHeaders()->addHeaderLine('Location',$url);

    	$this->getEvent()->stopPropagation();
    	return $response;
    }

    public function goNoView(){
    	
    	$url 		= $this->url()->fromRoute('MVC_HomeRouter/action',array(
    		'module'		=>	'home',
    		'controller'	=>	'notice',
    		'action'		=>	'no-view'
    	));
    	$response 	= $this->getResponse();
    	$response->setStatusCode(302);
    	$response->getHeaders()->addHeaderLine('Location',$url);

    	$this->getEvent()->stopPropagation();
    	return $response;
    }

    public function goNotFoundPageBusiness(){
    	
    	$url 		= $this->url()->fromRoute('MVC_HomeRouter/action',array(
    		'module'		=>	'home',
    		'controller'	=>	'notice',
    		'action'		=>	'not-found-page-business'
    	));
    	$response 	= $this->getResponse();
    	$response->setStatusCode(302);
    	$response->getHeaders()->addHeaderLine('Location',$url);

    	$this->getEvent()->stopPropagation();
    	return $response;
    }

    public function goMaintenance(){
    	
    	$url 		= $this->url()->fromRoute('MVC_HomeRouter/action',array(
    		'module'		=>	'home',
    		'controller'	=>	'notice',
    		'action'		=>	'maintenance'
    	));
    	$response 	= $this->getResponse();
    	$response->setStatusCode(302);
    	$response->getHeaders()->addHeaderLine('Location',$url);

    	$this->getEvent()->stopPropagation();
    	return $response;
    }

    public function goBanned(){
    	
    	$url 		= $this->url()->fromRoute('MVC_HomeRouter/action',array(
    		'module'		=>	'home',
    		'controller'	=>	'notice',
    		'action'		=>	'banned'
    	));
    	$response 	= $this->getResponse();
    	$response->setStatusCode(302);
    	$response->getHeaders()->addHeaderLine('Location',$url);

    	$this->getEvent()->stopPropagation();
    	return $response;
    }
}
