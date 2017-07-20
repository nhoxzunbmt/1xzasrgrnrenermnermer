<?php
namespace Admin\Form;
use  Zend\InputFilter\InputFilter;
use  Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
class ConfigAdvanceFilter extends InputFilter{
	public function __construct($options = null){
		
		if($options == null){
			//Tiêu đề
			$this->add(array(
				'name'	=>	'GoogleAnalyticsCode',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Google Analytics Code !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'limitSendEmailMarketing',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập limitSendEmailMarketing !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			
			
			
		}

		if($options['task'] == 'edit'){
			//Tiêu đề
			//Tiêu đề
			$this->add(array(
				'name'	=>	'Google Analytics Code',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Google Analytics Code !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			$this->add(array(
				'name'	=>	'limitSendEmailMarketing',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập limitSendEmailMarketing !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));
			
		}
		
	}
}