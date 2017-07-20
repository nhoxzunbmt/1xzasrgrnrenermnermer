<?php
namespace Admin\Form;
use  Zend\InputFilter\InputFilter;
use  Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
class BanFilter extends InputFilter{
	public function __construct($options = null){
		
		if($options == null){
			//Fullname
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập username !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));
			
			
			
			
		}

		if($options['task'] == 'edit'){
			//Fullname
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Họ và tên của khách hàng !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));
		}
		
	}
}