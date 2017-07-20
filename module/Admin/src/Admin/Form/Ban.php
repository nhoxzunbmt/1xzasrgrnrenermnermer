<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class Ban extends Form{
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
		//add Field set Email
		//$this->add(new \Admin\Form\UserFieldset());

	

        $this->add(array(
                'name'          => 'username',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Cấm thành viên',
                        
                ),
                'attributes'    => array(
                        'class' => 'textarea',
                        //'cols'      =>  50,
                        //'rows'      =>  10,
                        'id'    =>'intro',
                        'style' =>'width:800px;height:50px;'  
                ),
        ));

        $this->add(array(
                'name'          => 'register_ip',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Cấm địa chỉ IP',
                        
                ),
                'attributes'    => array(
                        'class' => 'textarea',
                        //'cols'      =>  50,
                        //'rows'      =>  10,
                        'id'    =>'intro',
                        'style' =>'width:800px;height:50px;'  
                ),
        ));

         $this->add(array(
                'name'          => 'nguyennhan',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Nguyên nhân',
                        
                ),
                'attributes'    => array(
                        'class' => 'textarea',
                        //'cols'      =>  50,
                        //'rows'      =>  10,
                        'id'    =>'intro',
                        'style' =>'width:800px;height:50px;'  
                ),
        ));

		//ID
		$this->add(array(
			'name'	=>	'id',
			
			'attributes'	=>	array(
				'type'	=>	'hidden',
				
			),
			
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