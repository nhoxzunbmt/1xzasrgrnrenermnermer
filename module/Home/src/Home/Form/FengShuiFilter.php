<?php
namespace Home\Form;

use Zend\InputFilter\InputFilter;

class FengShuiFilter extends InputFilter {
	
	public function __construct(){
		
		//Email
			$this->add(array(
				'name'	=>	'feng-shui-birth',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập ngày sinh !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
					
				),
			));
		
	}
}