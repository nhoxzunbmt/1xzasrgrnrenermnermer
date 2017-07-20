<?php
namespace Home\Form;

use Zend\InputFilter\InputFilter;

class ContactMeFilter extends InputFilter {
	
	public function __construct(){
		
		//Email
			$this->add(array(
				'name'	=>	'contact-me-email',
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
		
		//Fullname
			$this->add(array(
				'name'	=>	'contact-me-fullname',
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

		//phone
		$this->add(array(
				'name'	=>	'contact-me-phone',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Số điện thoại của khách hàng !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'StringLength',
						'options'	=>	array(
							'min'	=>	10,
							'max'	=>	11,
							'messages'	=>	array(
								\Zend\Validator\StringLength::TOO_SHORT=>'Chiều dài của Số điện thoại lớn hơn %min% ký tự !',
								\Zend\Validator\StringLength::TOO_LONG=>'Chiều dài của Số điện thoại nhỏ hơn %max% ký tự !',
							),
						),
						//'break_chain_on_failure'	=> true
					)
				),
			));

		//content
		
		
		$this->add(array(
				'name'	=>	'contact-me-content',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập Nội dung !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'StringLength',
						'options'	=>	array(
							'min'	=>	10,
							'max'	=>	1000,
							'messages'	=>	array(
								\Zend\Validator\StringLength::TOO_SHORT=>'Chiều dài của Nội dung lớn hơn %min% ký tự !',
								\Zend\Validator\StringLength::TOO_LONG=>'Chiều dài của Nội dung nhỏ hơn %max% ký tự !',
							),
						),
						//'break_chain_on_failure'	=> true
					)
				),
			));
	}
}