<?php
namespace Home\Form;
use \Zend\Form\Form as Form;
use Zend\Form\Element as Element;

class RestorePassword extends Form {
	
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
		
		// Password
		$this->add(array(
				'name'			=> 'password',
				'type'			=> 'Password',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'id'			=> 'inputPassword',
						'placeholder'	=> 'Mật khẩu mới',
				),
				'options'		=> array(
						'label'				=> 'Mật khẩu mới',
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
	

		$this->add(array(
				'name'			=> 'my-button-submit',
				'type'			=> 'Button',
				'attributes'	=> array(
						'type'			=> 'submit',
						'class'			=> 'actionButton',
				),
				'options'		=> array(
						'label'				=> 'Gửi',
				),
		));
		
		
	}
}