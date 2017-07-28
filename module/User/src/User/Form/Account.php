<?php
namespace User\Form;
use \Zend\Form\Form as Form;

class Account extends Form{
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

		//Fullname
		$this->add(array(
			'name'	=>	'fullname',
			'type'	=>	'Text',
			'attributes'	=>	array(
				'class'			=>	'TextInput',
				'id'			=>	'textFullname',
				'placeholder'	=>	'Họ và tên',
				'class'			=>	'input_text',
			),
			'options'	=>	array(
				'label'	=>	'Họ và tên',
				'label_attributes'	=>	array(
					'for'	=>	'inputEmail3',
					'class'	=>	'col-sm3 control-label',
				)
			)
		));

		
		//Username
		$this->add(array(
			'name'	=>	'username',
			'type'	=>	'Text',
			'attributes'	=>	array(
				'class'			=>	'TextInput',
				'id'			=>	'textUsername',
				'placeholder'	=>	'Tên đăng nhập',
				'class'			=>	'input_text',
			),
			'options'	=>	array(
				'label'	=>	'Tên đăng nhập',
				'label_attributes'	=>	array(
					'for'	=>	'inputEmail3',
					'class'	=>	'col-sm3 control-label',
				)
			)
		));

		//Email
		$this->add(array(
			'name'	=>	'email',
			'type'	=>	'Text',
			'attributes'	=>	array(
				'class'			=>	'TextInput',
				'id'			=>	'textEmail',
				'placeholder'	=>	'Email',
				'class'			=>	'input_text',
				'disable'		=>	'disable',
			),
			'options'	=>	array(
				'label'	=>	'Email',
				'label_attributes'	=>	array(
					'for'	=>	'inputEmail3',
					'class'	=>	'col-sm3 control-label',
				)
			)
		));

		

		//Gioi thiệu
        $this->add(array(
                'name'          => 'introduced',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Mô tả ngắn',
                        
                ),
                'attributes'    => array(
                        'class' => 'textarea',
                        //'cols'      =>  50,
                        //'rows'      =>  10,
                        'id'    =>'description',
                        'class'			=>	'input_text',
                        'style'	=>	'WIDTH: 400px; HEIGHT: 200px', 
                ),
        ));

		//Địa chỉ
		$this->add(array(
			'name'	=>	'diachi',
			'type'	=>	'Text',
			'attributes'	=>	array(
				'class'			=>	'TextInput',
				'id'			=>	'textDiachi',
				'placeholder'	=>	'Địa chỉ',
				'class'			=>	'input_text',
			),
			'options'	=>	array(
				'label'	=>	'Địa chỉ',
				'label_attributes'	=>	array(
					'for'	=>	'inputEmail3',
					'class'	=>	'col-sm3 control-label',
				)
			)
		));


		//File
		$this->add(array(
				'name'			=> 'image',
				'type'			=> 'File',
				'attributes'	=> array(
						'multiple'	=> false,
						'id'		=> 'image',
				),
				'options'		=> array(
						'label'				=> 'Avatar',
						
				),
		));

		
		//yahoo
		$this->add(array(
			'name'	=>	'website',
			'type'	=>	'Text',
			'attributes'	=>	array(
				'class'			=>	'TextInput',
				'id'			=>	'textYahoo',
				'placeholder'	=>	'Yahoo',
				'class'			=>	'input_text',
			),
			'options'	=>	array(
				'label'	=>	'Yahoo',
				'label_attributes'	=>	array(
					'for'	=>	'inputEmail3',
					'class'	=>	'col-sm3 control-label',
				)
			)
		));

		

		//phone
		$this->add(array(
			'name'	=>	'phone',
			'type'	=>	'Text',
			'attributes'	=>	array(
				'class'			=>	'TextInput',
				'id'			=>	'textPhone',
				'placeholder'	=>	'Số điện thoại',
				'class'			=>	'input_text',
			),
			'options'	=>	array(
				'label'	=>	'Số điện thoại',
				'label_attributes'	=>	array(
					'for'	=>	'inputEmail3',
					'class'	=>	'col-sm3 control-label',
				)
			)
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
			'name'	=>	'button-submit',
			'type'	=>	'Button',
			'attributes'	=>	array(
				'type'	=>	'submit',
				'class'	=>	'btn btn-success btn-sm',
				'value'	=>	'Đồng ý',
			),
			'options'	=>	array(
				'label'	=>	'Đồng ý',
			)
		));

		//Reset
		$this->add(array(
			'name'	=>	'button-reset',
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