<?php
namespace Home\Form;
use \Zend\Form\Form as Form;
use Zend\Form\Element as Element;

class FengShui extends Form {
	
	public function __construct($name = null){
		parent::__construct();
		
		// FORM Attribute
		$this->setAttributes(array(
				'action'	=> '',
				'method'	=> 'POST',
				'class'		=> 'form-horizontal',
				'role'		=> 'form',
				'name'		=> 'feng-shui',
				'id'		=> 'feng-shui',
		));
		//$this->setInputFilter(new \Form\Form\LoginFilter());
		
		// Năm sinh
		$this->add(array(
				'name'			=> 'feng-shui-birth',
				'type'			=> 'Text',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'id'			=> 'txt_Namsinh',
						'placeholder'	=> 'Năm sinh',
				),
				'options'		=> array(
						'label'				=> 'Năm sinh',
						'label_attributes'	=> array(
								'for'		=> 'inputEmail3',
								'class'		=> 'col-sm-3 control-label',
						)
				),
		));
		
		//Giới tính
		$this->add(array(
				'name'			=> 'feng-shui-sex',
				'type'			=> 'Select',
				'attributes'	=> array(
						'id'			=>	'select_Gioitinh',
						
				),
				'options'	=> array(
						'label'			=> 'Ngày sinh',
						'value'			=> 'Submit form',
						
						//'empty_option' 	=> '--Chọn--',
						'value_options'	=> array(
								'1'		=> 'Nam',
			   					'2' 	=> 'Nữ',
			   			),
				),
		));
		//Hướng nhà
		$this->add(array(
				'name'			=> 'feng-shui-huong',
				'type'			=> 'Select',
				'attributes'	=> array(
						'id'			=>	'select_huong',
						
				),
				'options'	=> array(
						'label'			=> 'Hướng nhà',
						'value'			=> 'Submit form',
						
						//'empty_option' 	=> '--Chọn--',
						'value_options'	=> array(
								'1'		=> 'Đông',
			   					'2' 	=> 'Tây',
			   					'3' 	=> 'Nam',
			   					'4' 	=> 'Bắc',
			   					'5' 	=> 'Đông bắc',
			   					'6' 	=> 'Đông Nam',
			   					'7' 	=> 'Tây bắc',
			   					'8' 	=> 'Tây nam',
			   					'9' 	=> 'Chưa xác định',
			   			),
				),
		));
		//submit
		$this->add(array(
				'name'			=> 'feng-shui-submit',
				'type'			=> 'Button',
				'attributes'	=> array(
						'type'			=> 'submit',
						'class'			=> 'send',
						'id'			=>'bntSubmit',
						'value'			=>	'Xem'
				),
				'options'		=> array(
						'label'				=> 'Gửi',
				),
		));
		
		
	}
}