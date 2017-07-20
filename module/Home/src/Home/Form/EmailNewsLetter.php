<?php
namespace Home\Form;
use \Zend\Form\Form as Form;
use Zend\Form\Element as Element;

class EmailNewsLetter extends Form {
	
	public function __construct($name = null){
		parent::__construct();
		
		// FORM Attribute
		$this->setAttributes(array(
				'action'	=> '',
				'method'	=> 'POST',
				'class'		=> 'form-horizontal',
				'role'		=> 'form',
				'name'		=> 'contact-me',
				'id'		=> 'contact-me',
		));
		//$this->setInputFilter(new \Form\Form\LoginFilter());
		
		// Fullname
		$this->add(array(
				'name'			=> 'fullname',
				'type'			=> 'Text',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'id'			=> 'contact_me_txtName',
						'placeholder'	=> 'Tên người gửi',
				),
				'options'		=> array(
						'label'				=> 'Tên người gửi',
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
						'id'			=> 'contact_me_txtEmail',
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
		
		
		
		//submit
		$this->add(array(
				'name'			=> 'submit',
				'type'			=> 'Button',
				'attributes'	=> array(
						'type'			=> 'submit',
						'class'			=> 'send',
						'id'			=>'bntSubmit',
						'value'			=>	'Gửi'
				),
				'options'		=> array(
						'label'				=> 'Gửi',
				),
		));
		
		
	}
}