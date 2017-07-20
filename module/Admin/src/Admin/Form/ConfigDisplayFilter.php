<?php
namespace Admin\Form;
use  Zend\InputFilter\InputFilter;
use  Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
class ConfigDisplayFilter extends InputFilter{
	public function __construct($options = null){
		
		if($options == null){
			//Tiêu đề
			$this->add(array(
				'name'	=>	'descriptionNews',
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

			
			
			
		}

		if($options['task'] == 'edit'){
			//Tiêu đề
			//Tiêu đề
			$this->add(array(
				'name'	=>	'descriptionNews',
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

			
			
		}
		
	}
}