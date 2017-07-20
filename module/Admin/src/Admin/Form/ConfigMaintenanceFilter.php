<?php
namespace Admin\Form;
use  Zend\InputFilter\InputFilter;
use  Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
class ConfigMaintenanceFilter extends InputFilter{
	public function __construct($options = null){
		
		if($options == null){
			//Tiêu đề
			$this->add(array(
				'name'	=>	'notice',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Thông báo !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

			
			
			
			
		}

		if($options['task'] == 'edit'){
			$this->add(array(
				'name'	=>	'notice',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Thông báo !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));
			
		}
		
	}
}