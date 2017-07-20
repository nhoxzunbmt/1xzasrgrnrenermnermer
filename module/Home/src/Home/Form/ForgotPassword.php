<?php
namespace Home\Form;
use \Zend\Form\Form as Form;
use Zend\Form\Element as Element;

class ForgotPassword extends Form {
	
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