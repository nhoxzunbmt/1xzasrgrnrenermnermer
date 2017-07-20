<?php
namespace User\Form;
use \Zend\Form\Form as Form;

class ChangePassword extends Form{
	public function __construct(){
		parent::__construct();

		$this->setAttributes(array(
			'action'	=>	'',
			'method'	=>	'POST',
			'class'		=>	'form-horizontal',
			'role'		=>	'form',
			'name'		=>	'login-form',
			'id'		=>	'login-form',
			'enctype'	=>	'multipart/form-data',
		));
		
		
		//Password
		$this->add(array(
			'name'	=>	'password_old',
			'type'	=>	'Password',
			'attributes'	=>	array(
				'class'			=>	'TextInput',
				'id'			=>	'textPassword',
				'placeholder'	=>	'Mật khẩu',
				'class'			=>	'input_password',
			),
			'options'	=>	array(
				'label'	=>	'Mật khẩu cũ',
				'label_attributes'	=>	array(
					'for'	=>	'inputEmail3',
					'class'	=>	'col-sm3 control-label',
				)
			)
		));
		
		//Password
		$this->add(array(
			'name'	=>	'password',
			'type'	=>	'Password',
			'attributes'	=>	array(
				'class'			=>	'TextInput',
				'id'			=>	'textPassword',
				'placeholder'	=>	'Mật khẩu mới',
				'class'			=>	'input_password',
			),
			'options'	=>	array(
				'label'	=>	'Mật khẩu',
				'label_attributes'	=>	array(
					'for'	=>	'inputEmail3',
					'class'	=>	'col-sm3 control-label',
				)
			)
		));

		//Confirm Password
		$this->add(array(
			'name'	=>	'confirm-password',
			'type'	=>	'Password',
			'attributes'	=>	array(
				'class'			=>	'TextInput',
				'id'			=>	'textPassword',
				'placeholder'	=>	'Nhập lại mật khẩu',
				'class'			=>	'input_password',
			),
			'options'	=>	array(
				'label'	=>	'Nhập lại mật khẩu',
				'label_attributes'	=>	array(
					'for'	=>	'inputEmail3',
					'class'	=>	'col-sm3 control-label',
				)
			)
		));

		
	}
}