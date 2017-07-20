<?php
namespace Admin\Form;
use  Zend\InputFilter\InputFilter;
use  Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
class BusinessFilter extends InputFilter{
	public function __construct($options = null){
		
		if($options == null){
			//Tên công ty
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Tên doanh nghiệp !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));
			
			//Phone
			$this->add(array(
				'name'	=>	'phone',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Số điện thoại của doanh nghiệp !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'DbNoRecordExists',
						'options'	=>	array(
							'table'	=>	'users',
							'field'	=>	'phone',
							'adapter'	=>	GlobalAdapterFeature::getStaticAdapter(),
						),
						'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'StringLength',
						'options'	=>	array(
							'min'	=>	5,
							'max'	=>	20,
							'messages'	=>	array(
								\Zend\Validator\StringLength::TOO_SHORT=>'Chiều dài của Số điện thoại lớn hơn %min% ký tự !',
								\Zend\Validator\StringLength::TOO_LONG=>'Chiều dài của Số điện thoại nhỏ hơn %max% ký tự !',
							),
						),
						//'break_chain_on_failure'	=> true
					)
				),
			));

			
			//địa chỉ
			$this->add(array(
				'name'	=>	'address',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Địa chỉ doanh nghiệp !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			//Giới thiệu
			$this->add(array(
				'name'	=>	'intro',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Giới thiệu doanh nghiệp !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			//Liên hệ
			$this->add(array(
				'name'	=>	'contact',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Liên hệ doanh nghiệp !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));
			
		}

		if($options['task'] == 'edit'){
			//Tên công ty
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Tên doanh nghiệp !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));
			
			//Phone
			$this->add(array(
				'name'	=>	'phone',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Số điện thoại của doanh nghiệp !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
					array(
						'name'	=>	'StringLength',
						'options'	=>	array(
							'min'	=>	5,
							'max'	=>	20,
							'messages'	=>	array(
								\Zend\Validator\StringLength::TOO_SHORT=>'Chiều dài của Số điện thoại lớn hơn %min% ký tự !',
								\Zend\Validator\StringLength::TOO_LONG=>'Chiều dài của Số điện thoại nhỏ hơn %max% ký tự !',
							),
						),
						//'break_chain_on_failure'	=> true
					)
				),
			));

			
			//địa chỉ
			$this->add(array(
				'name'	=>	'address',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Địa chỉ doanh nghiệp !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			//Giới thiệu
			$this->add(array(
				'name'	=>	'intro',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Giới thiệu doanh nghiệp !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			//Liên hệ
			$this->add(array(
				'name'	=>	'contact',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Liên hệ doanh nghiệp !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));
		}
		
	}
}