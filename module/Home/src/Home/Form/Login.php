<?php
namespace Home\Form;
use \Zend\Form\Form as Form;
use Zend\Form\Element as Element;

class Login extends Form {
	
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
		//$this->setInputFilter(new \Form\Form\LoginFilter());
		
		// Email
		$this->add(array(
				'name'			=> 'my-email',
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
				'name'			=> 'my-password',
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
		
		
		// Checkbox
		$this->add(array(
				'name'			=> 'my-checkbox',
				'type'			=> 'Checkbox',
				'attributes'	=> array(
						'checked' 	=> false,
				),
				'options'		=> array(
						'label'				=> 'Ghi nhớ mật khẩu',
						'label_attributes'	=> array(
								'for'		=> 'my-checkbox',
						),
						'use_hidden_element'=>	true,
						'checked_value' 	=> 	1,
						'unchecked_value' 	=>  0
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
						'label'				=> 'Đăng nhập',
				),
		));
		
		
	}
}