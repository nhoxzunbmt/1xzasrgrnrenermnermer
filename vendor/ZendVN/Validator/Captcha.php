<?php
namespace ZendVN\Validator;

use Zend\Validator\AbstractValidator;

class Captcha extends AbstractValidator{
	const NOT_EQUAL = 'captchaNotEqual';
	protected $_captchaID;
	protected $messageTemplates = array(
		self::NOT_EQUAL => 'Mã xác nhận không chính xác'
	);

	public function __construct($captchaID){
		$this->_captchaID = $captchaID;
		parent::__construct($captchaID);
	}

	public function isValid($value){
		$capchatSession = new \Zend\Session\Container('Zend_Form_Captcha_'.$this->_captchaID);
        if(strcmp($value, $capchatSession->word) != 0){
            $this->error(self::NOT_EQUAL);
            return false;
        }
        return true;
	}
}