<?php
App::uses('AppModel', 'Model');
/**
 * Request Model
 *
 */
class Request extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'file';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'file' => array(
            'files' => array(
                'rule'    => array('extension', array('pdf')),
                'message' => 'Please supply a valid pdf.'
            )
		),
		'uuid' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

    /**
     * @param array $options
     * generating uuid and saving filename
     */
    public function beforeSave($options = array()){
        $this->data['Request']['uuid']=String::uuid();
        $this->data['Request']['file']=$this->data['Request']['file']['name'];
    }
}
