<?php
namespace Admin\Form;
use  Zend\InputFilter\InputFilter;
use  Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
class AdsFilter extends InputFilter{
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Tiêu đề quảng cáo !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'url',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Url quảng cáo !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'width',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Chiều rộng !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'height',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Chiều cao !'
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Tiêu đề quảng cáo !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'url',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Url quảng cáo !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'width',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Chiều rộng !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'height',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Chiều cao !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));
		}
		
	}
}