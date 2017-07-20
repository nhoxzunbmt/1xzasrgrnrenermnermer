<?php
namespace Home\Form;

use Zend\InputFilter\InputFilter;

class EmailNewsLetterFilter extends InputFilter {
	
	public function __construct(){
		
		//Email
			$this->add(array(
				'name'	=>	'email',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Địa chỉ Email !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					/*array(
						'name'	=>	'EmailAddress',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\EmailAddress::INVALID_FORMAT => 'Bạn phải nhập đúng định dạng Email !'
							)
						),
						//'break_chain_on_failure'	=> true
					),*/
					
				),
			));
		
		//Fullname
			$this->add(array(
				'name'	=>	'fullname',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Họ và tên!'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));

		
	}
}