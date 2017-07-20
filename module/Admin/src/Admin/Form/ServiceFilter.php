<?php
namespace Admin\Form;
use  Zend\InputFilter\InputFilter;
use  Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
class ServiceFilter extends InputFilter{
	public function __construct($options = null){
		
		if($options == null){
			//Tiêu đề
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Tên dịch vụ !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));
			
			
			$this->add(array(
				'name'	=>	'normal',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Số tin thường Kích hoạt !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'vip',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Số tin VIP Kích hoạt !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'hot',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Số tin HOT Kích hoạt !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'free',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Số tin Miễn phí Kích hoạt !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'chinhchu',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Số tin Chính chủ Kích hoạt !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'price',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Giá dịch vụ / tháng !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));
			
		}

		if($options['task'] == 'edit'){
			//Tiêu đề
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Tên dịch vụ !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));
			
			
			$this->add(array(
				'name'	=>	'normal',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Số tin thường Kích hoạt !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'vip',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Số tin VIP Kích hoạt !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'hot',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Số tin HOT Kích hoạt !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'free',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Số tin Miễn phí Kích hoạt !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'chinhchu',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Số tin Chính chủ Kích hoạt !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'price',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Giá dịch vụ / tháng !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));
			
		}
		
	}
}