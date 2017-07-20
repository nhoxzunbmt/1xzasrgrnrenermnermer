<?php
namespace Home\Form;
use \Zend\Form\Form as Form;
use Zend\Form\Element as Element;

class Register extends Form {
	
	public function __construct($name = null){
		parent::__construct();
		
		// FORM Attribute
		$this->setAttributes(array(
				'action'	=> '',
				'method'	=> 'POST',
				'class'		=> 'form-horizontal',
				'role'		=> 'form',
				'name'		=> 'login-form',
				'id'		=> 'login-form',
		));
		
		
		// Fullname
		$this->add(array(
				'name'			=> 'fullname',
				'type'			=> 'Text',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'id'			=> 'inputFullname',
						'placeholder'	=> 'Họ tên',
				),
				'options'		=> array(
						'label'				=> 'Họ tên',
						'label_attributes'	=> array(
								'for'		=> 'inputEmail3',
								'class'		=> 'col-sm-3 control-label',
						)
				),
		));
		
		// Username
		$this->add(array(
				'name'			=> 'username',
				'type'			=> 'Text',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'id'			=> 'inputUsername',
						'placeholder'	=> 'Tên đăng nhập',
				),
				'options'		=> array(
						'label'				=> 'Tên đăng nhập',
						'label_attributes'	=> array(
								'for'		=> 'inputEmail3',
								'class'		=> 'col-sm-3 control-label',
						)
				),
		));

		// Email
		$this->add(array(
				'name'			=> 'email',
				'type'			=> 'Text',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'id'			=> 'inputEmail',
						'placeholder'	=> 'Email',
				),
				'options'		=> array(
						'label'				=> 'Email',
						'label_attributes'	=> array(
								'for'		=> 'inputEmail3',
								'class'		=> 'col-sm-3 control-label',
						)
				),
		));
		
		// Password
		$this->add(array(
				'name'			=> 'password',
				'type'			=> 'Password',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'id'			=> 'inputPassword',
						'placeholder'	=> 'Password',
				),
				'options'		=> array(
						'label'				=> 'Password',
						'label_attributes'	=> array(
								'for'		=> 'inputPassword3',
								'class'		=> 'col-sm-3 control-label',
						)
				),
		));
		
		//Confirm Password
		$this->add(array(
			'name'	=>	'confirm-password',
			'type'	=>	'Password',
			'attributes'	=>	array(
				'class'			=>	'TextInput',
				'id'			=>	'inputConfirmPassword',
				'placeholder'	=>	'Nhập lại mật khẩu',
			),
			'options'	=>	array(
				'label'	=>	'Nhập lại mật khẩu',
				'label_attributes'	=>	array(
					'for'	=>	'inputEmail3',
					'class'	=>	'col-sm3 control-label',
				)
			)
		));
		
		// Password
		$this->add(array(
				'name'			=> 'phone',
				'type'			=> 'Text',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'id'			=> 'inputPhone',
						'placeholder'	=> 'Di động',
				),
				'options'		=> array(
						'label'				=> 'Di động',
						'label_attributes'	=> array(
								'for'		=> 'inputPassword3',
								'class'		=> 'col-sm-3 control-label',
						)
				),
		));

		$captchaObj = new \Zend\Captcha\Image();
        $captchaObj->setImgDir(CAPTCHA_PATH .'/images');
        $captchaObj->setImgUrl(CAPTCHA_URL .'/images');
        $captchaObj->setFont(CAPTCHA_PATH .'/fonts/times.ttf');
        $captchaObj->setFontSize(25);
        $captchaObj->setWordlen(5);
        $captchaObj->setWidth(200);
        $captchaObj->setHeight(50);
        $captchaObj->setDotNoiseLevel(100);
        $captchaObj->setLineNoiseLevel(5);

		// Captcha
		$this->add(array(
				'name'			=> 'captcha',
				'type'			=> 'Captcha',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'id'			=> 'inputCaptcha',
				),
				'options'		=> array(
						'label'			=> 'Mã an toàn',
						'captcha'		=>	$captchaObj,
				),
		));
		

		$this->add(array(
				'name'			=> 'my-button-submit',
				'type'			=> 'Button',
				'attributes'	=> array(
						'type'			=> 'submit',
						'class'			=> 'actionButton',
				),
				'options'		=> array(
						'label'				=> 'Tạo tài khoản',
				),
		));
		
		
	}
}