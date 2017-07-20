<?php
namespace Admin\Form;
use  Zend\InputFilter\InputFilter;
use  Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
class ProjectFilter extends InputFilter{
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Tên dự án !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));
			
			
			

			//Tổng quan
			$this->add(array(
				'name'	=>	'overview',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Tổng quan dự án!'
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Giới thiệu dự án!'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
					
				),
			));

			//Hạ tầng, dịch vụ
			$this->add(array(
				'name'	=>	'service',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Hạ tầng, dịch vụ dự án!'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
					
				),
			));

			//Vị trí
			$this->add(array(
				'name'	=>	'location',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Vị trí dự án!'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
					
				),
			));

			//Sơ đồ mặt bằng
			$this->add(array(
				'name'	=>	'siteplan',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Sơ đồ mặt bằng dự án!'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
					
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Diện tích dự án !'
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

		

        //Giá / m2
            $this->add(array(
                'name'  =>  'price_m2',
                'required'  =>  true,
                'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
                'validators'    =>  array(
                    array(
                        'name'  =>  'NotEmpty',
                        'options'   =>  array(
                            'messages'  =>  array(
                                \Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Giá/m2 bất động sản !'
                            ),
                        ),
                        //'break_chain_on_failure'  => true
                    ),
                    array(
                        'name'  =>  'Digits',
                        'options'   =>  array(
                            'messages'  =>  array(
                                \Zend\Validator\Digits::NOT_DIGITS=>'Giá/m2 bất động sản phải là số !'
                            ),
                        ),
                        //'break_chain_on_failure'  => true
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Tên dự án !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Diện tích dự án !'
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

		

        //Giá / m2
            $this->add(array(
                'name'  =>  'price_m2',
                'required'  =>  true,
                'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
                'validators'    =>  array(
                    array(
                        'name'  =>  'NotEmpty',
                        'options'   =>  array(
                            'messages'  =>  array(
                                \Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Giá/m2 bất động sản !'
                            ),
                        ),
                        //'break_chain_on_failure'  => true
                    ),
                    array(
                        'name'  =>  'Digits',
                        'options'   =>  array(
                            'messages'  =>  array(
                                \Zend\Validator\Digits::NOT_DIGITS=>'Giá/m2 bất động sản phải là số !'
                            ),
                        ),
                        //'break_chain_on_failure'  => true
                    ),
                ),
            ));

			//Tổng quan
			$this->add(array(
				'name'	=>	'overview',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Tổng quan dự án!'
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Giới thiệu dự án!'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
					
				),
			));

			//Hạ tầng, dịch vụ
			$this->add(array(
				'name'	=>	'service',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Hạ tầng, dịch vụ dự án!'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
					
				),
			));

			//Vị trí
			$this->add(array(
				'name'	=>	'location',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Vị trí dự án!'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
					
				),
			));

			//Sơ đồ mặt bằng
			$this->add(array(
				'name'	=>	'siteplan',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Sơ đồ mặt bằng dự án!'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
					
				),
			));
			
		}
		
	}
}