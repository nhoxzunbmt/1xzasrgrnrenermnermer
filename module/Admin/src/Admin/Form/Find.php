<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class Find extends Form{
	public function __construct(){
		parent::__construct();

		$this->setAttributes(array(
			'action'	=>	'',
			'method'	=>	'POST',
			'class'		=>	'form-horizontal',
			'role'		=>	'form',
			'name'		=>	'login-form',
			'id'		=>	'login-form',
		));

		//Email
		$this->add(array(
			'name'	=>	'my-email',
			'type'	=>	'Text',
			'attributes'	=>	array(
				'class'			=>	'form-control',
				'id'			=>	'inputEmail3',
				'placeholder'	=>	'Email',
			),
			'options'	=>	array(
				'label'	=>	'Email',
				'label_attributes'	=>	array(
					'for'	=>	'inputEmail3',
					'class'	=>	'col-sm3 control-label',
				)
			)
		));
		//Submit
		$this->add(array(
			'name'	=>	'my-button-submit',
			'type'	=>	'Button',
			'attributes'	=>	array(
				'type'	=>	'submit',
				'class'	=>	'btn btn-success btn-sm',
			),
			'options'	=>	array(
				'label'	=>	'find User',
			)
		));

		//Reset
		$this->add(array(
			'name'	=>	'my-button-reset',
			'type'	=>	'Button',
			'attributes'	=>	array(
				'type'	=>	'reset',
				'class'	=>	'btn btn-default btn-sm',
				'value'	=>	'Reset',
				'onclick'	=>	'resetForm()'
			),
			'options'	=>	array(
				'label'	=>	'Reset',
			)
		));
	}
}