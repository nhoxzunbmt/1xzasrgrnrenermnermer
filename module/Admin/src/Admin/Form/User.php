<?php
namespace Admin\Form;
use \Zend\Form\Form as Form;

class User extends Form{
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
				'style'			=>	'width:200px;',
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
				'style'			=>	'width:300px;',
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
				'style'			=>	'width:300px;',
			),
			'options'	=>	array(
				'label'	=>	'Email',
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
				'placeholder'	=>	'Mật khẩu',
				'style'			=>	'width:300px;',
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
				'style'			=>	'width:300px;',
			),
			'options'	=>	array(
				'label'	=>	'Nhập lại mật khẩu',
				'label_attributes'	=>	array(
					'for'	=>	'inputEmail3',
					'class'	=>	'col-sm3 control-label',
				)
			)
		));

		//Địa chỉ
		$this->add(array(
			'name'	=>	'diachi',
			'type'	=>	'Text',
			'attributes'	=>	array(
				'class'			=>	'TextInput',
				'id'			=>	'textDiachi',
				'placeholder'	=>	'Địa chỉ',
				'style'			=>	'width:300px;',
			),
			'options'	=>	array(
				'label'	=>	'Địa chỉ',
				'label_attributes'	=>	array(
					'for'	=>	'inputEmail3',
					'class'	=>	'col-sm3 control-label',
				)
			)
		));

		//Nhóm
		/*$this->add(array(
				'name'			=> 'group_id',
				'type'			=> 'Select',
				'attributes'	=> array(
						'style'		=> 'padding: 4px 8px; width:206px;',
						'id'		=> 'my-type',
						'value'		=> '3'
				),
				'options'		=> array(
						'label'				=> 'Chọn nhóm',
						//'empty_option' 	=> '--Chọn nhóm thành viên--',
						'value_options'	=> array(
								'1'		=> 'Admin',
								'2'	=> 'Moderator',
								'3'	=> 'Member',
						)
				),
		));*/

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
				'placeholder'	=>	'website',
				'style'			=>	'width:200px;',
			),
			'options'	=>	array(
				'label'	=>	'website',
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
				'style'			=>	'width:200px;',
			),
			'options'	=>	array(
				'label'	=>	'Số điện thoại',
				'label_attributes'	=>	array(
					'for'	=>	'inputEmail3',
					'class'	=>	'col-sm3 control-label',
				)
			)
		));

		//Tổng quan
        $this->add(array(
                'name'          => 'introduced',
                'type'          => 'Textarea',
                'options'       => array(
                        'label'             => 'Giới thiệu',
                        
                ),
                'attributes'    => array(
                        'class' => 'textarea',
                        //'cols'      =>  50,
                        //'rows'      =>  10,
                        'id'    =>'intro',
                        'style' =>'width:800px;height:200px;'  
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