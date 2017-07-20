<?php
namespace User\Form;
use  Zend\InputFilter\InputFilter;
use  Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
class ChangePasswordFilter extends InputFilter{
	public function __construct($options = null){
		
			//Password
			$this->add(array(
				'name'	=>	'password_old',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Mật khẩu cũ !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'StringLength',
						'options'	=>	array(
							'min'	=>	3,
							'max'	=>	50,
							'messages'	=>	array(
								\Zend\Validator\StringLength::TOO_SHORT=>'Chiều dài của Mật khẩu lớn hơn %min% ký tự !',
								\Zend\Validator\StringLength::TOO_LONG=>'Chiều dài của Mật khẩu nhỏ hơn %max% ký tự !',
							),
						),
						//'break_chain_on_failure'	=> true
					)
				),
			));
			//Password
			$this->add(array(
				'name'	=>	'password',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Mật khẩu mới !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'StringLength',
						'options'	=>	array(
							'min'	=>	3,
							'max'	=>	50,
							'messages'	=>	array(
								\Zend\Validator\StringLength::TOO_SHORT=>'Chiều dài của Mật khẩu lớn hơn %min% ký tự !',
								\Zend\Validator\StringLength::TOO_LONG=>'Chiều dài của Mật khẩu nhỏ hơn %max% ký tự !',
							),
						),
						//'break_chain_on_failure'	=> true
					)
				),
			));
			//Password
			$this->add(array(
				'name'	=>	'confirm-password',
				'required'	=>	false,

				'validators'	=>	array(
					
					array(
                        'name' => 'ZendVN\Validator\ConfirmPassword',
                        'options' => array(
                            'field' => 'password',
                        ),
                    ),
				),
			));
		

		
		
	}
}