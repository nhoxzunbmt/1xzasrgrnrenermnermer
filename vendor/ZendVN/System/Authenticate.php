<?php
namespace ZendVN\System;

class Authenticate{
	protected $_authService;
	protected $_msgError;

	public function __construct(\Zend\Authentication\AuthenticationService $authService){
		$this->_authService = $authService;
	}
	public function login($arrParam = null,$options = null){
       	$this->_authService->getAdapter()->setIdentity($arrParam['email']);
        $this->_authService->getAdapter()->setCredential($arrParam['password']);
        $result  = $this->_authService->authenticate();

        if(!$result->isValid()){
            $this->_msgError = 'Tài khoản đăng nhập không chính xác';
            return false;
        }else{
            $data = $this->_authService->getAdapter()->getResultRowObject(null,array('password'));
            $this->_authService->getStorage()->write($data);
            return true;
        }
	}

	public function getError($arrParam = null,$options = null){
		return $this->_msgError;
	}
    public function logout($arrParam = null,$options = null){
        $this->_authService->clearIdentity();
    }
}