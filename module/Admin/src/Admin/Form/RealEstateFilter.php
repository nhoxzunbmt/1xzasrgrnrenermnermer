<?php
namespace Admin\Form;
use  Zend\InputFilter\InputFilter;
use  Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
class RealEstateFilter extends InputFilter{
	public function __construct($options = null){
		
		if($options == null){
			//Title
			$this->add(array(
				'name'	=>	'title',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Tiêu đề bất động sản !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'StringLength',
						'options'	=>	array(
							'min'	=>	30,
							'max'	=>	100,
							'messages'	=>	array(
								\Zend\Validator\StringLength::TOO_SHORT=>'Chiều dài của Tiêu đề lớn hơn %min% ký tự !',
								\Zend\Validator\StringLength::TOO_LONG=>'Chiều dài của Tiêu đề nhỏ hơn %max% ký tự !',
							),
						),
						//'break_chain_on_failure'	=> true
					)
					
				),
			));
			//Nội dung
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Nội dung chi tiết bất động sản!'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'StringLength',
						'options'	=>	array(
							'min'	=>	50,
							'messages'	=>	array(
								\Zend\Validator\StringLength::TOO_SHORT=>'Chiều dài của Nội dung lớn hơn %min% ký tự !',
	
							),
						),
						//'break_chain_on_failure'	=> true
					)
					
				),
			));
			//Diện tích
			$this->add(array(
				'name'	=>	'area',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Diện tích bất động sản !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'Digits',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\Digits::NOT_DIGITS=>'Diện tích phải là số !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
				),
			));

			//Giá
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Giá bất động sản !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'Digits',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\Digits::NOT_DIGITS=>'Giá bất động sản phải là số !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
				),
			));

			//Giá / m2
			$this->add(array(
				'name'	=>	'price_m2',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Giá/m2 bất động sản !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'Digits',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\Digits::NOT_DIGITS=>'Giá/m2 bất động sản phải là số !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
				),
			));

			
			
			
		}

		if($options['task'] == 'edit'){
			//Title
			$this->add(array(
				'name'	=>	'title',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Tiêu đề bất động sản !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'StringLength',
						'options'	=>	array(
							'min'	=>	30,
							'max'	=>	100,
							'messages'	=>	array(
								\Zend\Validator\StringLength::TOO_SHORT=>'Chiều dài của Tiêu đề lớn hơn %min% ký tự !',
								\Zend\Validator\StringLength::TOO_LONG=>'Chiều dài của Tiêu đề nhỏ hơn %max% ký tự !',
							),
						),
						//'break_chain_on_failure'	=> true
					)
					
				),
			));
			//Nội dung
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Nội dung chi tiết bất động sản!'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'StringLength',
						'options'	=>	array(
							'min'	=>	50,
							'messages'	=>	array(
								\Zend\Validator\StringLength::TOO_SHORT=>'Chiều dài của Nội dung lớn hơn %min% ký tự !',
	
							),
						),
						//'break_chain_on_failure'	=> true
					)
					
				),
			));
			//Diện tích
			$this->add(array(
				'name'	=>	'area',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Diện tích bất động sản !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'Digits',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\Digits::NOT_DIGITS=>'Diện tích phải là số !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
				),
			));

			//Giá
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Giá bất động sản !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'Digits',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\Digits::NOT_DIGITS=>'Giá bất động sản phải là số !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
				),
			));

			//Giá / m2
			$this->add(array(
				'name'	=>	'price_m2',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Giá/m2 bất động sản !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'Digits',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\Digits::NOT_DIGITS=>'Giá/m2 bất động sản phải là số !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
				),
			));
		}
		
	}
}