<?php
namespace Admin\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use  Zend\InputFilter\InputFilter;
use  Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
class UserFieldset extends Fieldset implements InputFilterProviderInterface{
	public function __construct(){
		parent::__construct('user');
		//Email
		$this->add(array(
			'name'	=>	'email',
			'type'	=>	'Text',
			'attributes'	=>	array(
				'class'			=>	'TextInput',
				'id'			=>	'textEmail',
				'placeholder'	=>	'Email',
				'style'			=>	'width:300px;',
			),
			'options'	=>	array(
				'label'	=>	'Email',
				'label_attributes'	=>	array(
					'for'	=>	'inputEmail3',
					'class'	=>	'col-sm3 control-label',
				)
			)
		));

	}
	public function getInputFilterSpecification(){
		return array(
			'email'	=>	array(
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
								//'value'	=>	$options['id'],
							),
						),
						//'break_chain_on_failure'	=> true
					),
				),
			),
		);
	}
} 