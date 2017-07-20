<?php
namespace Admin\Form;
use  Zend\InputFilter\InputFilter;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
class FindFilter extends InputFilter{
	public function __construct(){
		//Email
		$this->add(array(
			'name'	=>	'my-email',
			'required'	=>	true,
			'validators'	=>	array(
				array(
					'name'	=>	'NotEmpty',
					'options'	=>	array(
						'messages'	=>	array(
							\Zend\Validator\NotEmpty::IS_EMPTY=>'Dữ liệu không được rỗng'
						),
					),
					'break_chain_on_failure'	=> true
				),
				array(
					'name'	=>	'EmailAddress',
					'options'	=>	array(
						'messages'	=>	array(
							\Zend\Validator\EmailAddress::INVALID_FORMAT => 'Không đúng định dạng email'
						)
					),
					'break_chain_on_failure'	=> true
				),
				array(
					'name'	=>	'DbRecordExists',
					'options'	=>	array(
						'table'	=>	'users',
						'field'	=>	'email',
						'adapter'	=>	GlobalAdapterFeature::getStaticAdapter(),
					),
				),
			),
		));
	}
}