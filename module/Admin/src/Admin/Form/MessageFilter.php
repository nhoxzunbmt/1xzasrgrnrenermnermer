<?php
namespace Admin\Form;
use  Zend\InputFilter\InputFilter;
use  Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
class MessageFilter extends InputFilter{
	public function __construct($options = null){
		
		if($options == null){
			$this->add(array(
				'name'	=>	'name',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Tiêu đề!'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'StringLength',
						'options'	=>	array(
							'min'	=>	3,
							'max'	=>	255,
							'messages'	=>	array(
								\Zend\Validator\StringLength::TOO_SHORT=>'Chiều dài của Tiêu đề lớn hơn %min% ký tự !',
								\Zend\Validator\StringLength::TOO_LONG=>'Chiều dài của Tiêu đề nhỏ hơn %max% ký tự !',
							),
						),
						//'break_chain_on_failure'	=> true
					)
					
				),
			));

			$this->add(array(
				'name'	=>	'username',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Username!'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'content',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Nội dung!'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'StringLength',
						'options'	=>	array(
							'min'	=>	3,
							'max'	=>	1000,
							'messages'	=>	array(
								\Zend\Validator\StringLength::TOO_SHORT=>'Chiều dài của Nội dung lớn hơn %min% ký tự !',
								\Zend\Validator\StringLength::TOO_LONG=>'Chiều dài của Nội dung nhỏ hơn %max% ký tự !',
							),
						),
						//'break_chain_on_failure'	=> true
					)
					
				),
			));
			
		}

		if($options['task'] == 'edit'){
			
		}
		
	}
}