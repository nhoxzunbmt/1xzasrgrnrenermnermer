<?php
namespace Admin\Form;
use  Zend\InputFilter\InputFilter;
use  Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
class UserFilter extends InputFilter{
	public function __construct($options = null){
		
		if($options == null){
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Họ và tên của khách hàng !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));
			
			//Username
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Tên đăng nhập của khách hàng !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'DbNoRecordExists',
						'options'	=>	array(
							'table'	=>	'users',
							'field'	=>	'username',
							'adapter'	=>	GlobalAdapterFeature::getStaticAdapter(),
						),
						'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'StringLength',
						'options'	=>	array(
							'min'	=>	3,
							'max'	=>	50,
							'messages'	=>	array(
								\Zend\Validator\StringLength::TOO_SHORT=>'Chiều dài của Tên đăng nhập lớn hơn %min% ký tự !',
								\Zend\Validator\StringLength::TOO_LONG=>'Chiều dài của Tên đăng nhập nhỏ hơn %max% ký tự !',
							),
						),
						//'break_chain_on_failure'	=> true
					)
				),
			));
			
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
					array(
						'name'	=>	'DbNoRecordExists',
						'options'	=>	array(
							'table'	=>	'users',
							'field'	=>	'email',
							'adapter'	=>	GlobalAdapterFeature::getStaticAdapter(),
						),
						//'break_chain_on_failure'	=> true
					),
				),
			));
			//Username
			$this->add(array(
				'name'	=>	'phone',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Số điện thoại của khách hàng !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'DbNoRecordExists',
						'options'	=>	array(
							'table'	=>	'users',
							'field'	=>	'phone',
							'adapter'	=>	GlobalAdapterFeature::getStaticAdapter(),
						),
						'break_chain_on_failure'	=> true
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Mật khẩu của khách hàng !'
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

		if($options['task'] == 'edit'){
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Họ và tên của khách hàng !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					
				),
			));
			
			//Username
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
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Tên đăng nhập của khách hàng !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'DbNoRecordExists',
						'options'	=>	array(
							'table'	=>	'users',
							'field'	=>	'username',
							'adapter'	=>	GlobalAdapterFeature::getStaticAdapter(),
							'exclude'	=>	array(
								'field'	=>	'id',
								'value'	=>	$options['id'],
							),
						),
						'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'StringLength',
						'options'	=>	array(
							'min'	=>	3,
							'max'	=>	50,
							'messages'	=>	array(
								\Zend\Validator\StringLength::TOO_SHORT=>'Chiều dài của Tên đăng nhập lớn hơn %min% ký tự !',
								\Zend\Validator\StringLength::TOO_LONG=>'Chiều dài của Tên đăng nhập nhỏ hơn %max% ký tự !',
							),
						),
						//'break_chain_on_failure'	=> true
					)
				),
			));
			
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
					array(
						'name'	=>	'DbNoRecordExists',
						'options'	=>	array(
							'table'	=>	'users',
							'field'	=>	'email',
							'adapter'	=>	GlobalAdapterFeature::getStaticAdapter(),
							'exclude'	=>	array(
								'field'	=>	'id',
								'value'	=>	$options['id'],
							),
							
						),
						//'break_chain_on_failure'	=> true
					),
				),
			));
			//Phone
			$this->add(array(
				'name'	=>	'phone',
				'required'	=>	true,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					array(
						'name'	=>	'NotEmpty',
						'options'	=>	array(
							'messages'	=>	array(
								\Zend\Validator\NotEmpty::IS_EMPTY=>'Bạn phải nhập thông tin Số điện thoại của khách hàng !'
							),
						),
						//'break_chain_on_failure'	=> true
					),
					array(
						'name'	=>	'DbNoRecordExists',
						'options'	=>	array(
							'table'	=>	'users',
							'field'	=>	'phone',
							'adapter'	=>	GlobalAdapterFeature::getStaticAdapter(),
							'exclude'	=>	array(
								'field'	=>	'id',
								'value'	=>	$options['id'],
							),
						),
						'break_chain_on_failure'	=> true
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
			
			//Password
			$this->add(array(
				'name'	=>	'password',
				'required'	=>	false,
				'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
				'validators'	=>	array(
					
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
}