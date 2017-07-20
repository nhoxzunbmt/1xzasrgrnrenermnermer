<?php
namespace Home\Form;

use Zend\InputFilter\InputFilter;

class ForgotPasswordFilter extends InputFilter {
	
	public function __construct(){
		
		//Email
			$this->add(array(
				'name'	=>	'my-email',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Địa chỉ Email !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'EmailAddress',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\EmailAddress::INVALID_FORMAT => 'Bạn phải nhập đúng định dạng Email !'
							)
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));
		
	}
}