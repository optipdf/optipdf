<?php
App::uses('AppModel', 'Model');

/**
 * Job Model
 *
 * @property Status $Status
 * @property Language $Language
 * @property Format $Format
 * @property Task $Task
 */
class Job extends AppModel
{

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'file' => array(
            'files' => array(
                'rule' => array('extension', array('pdf')),
                'message' => 'Please supply a valid pdf.'
            )
        ),
        'filename' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'filesize' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'status_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'language_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'rotation_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'layout_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'colormode_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
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

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Status' => array(
            'className' => 'Status',
            'foreignKey' => 'status_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Language' => array(
            'className' => 'Language',
            'foreignKey' => 'language_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Rotation' => array(
            'className' => 'Rotation',
            'foreignKey' => 'rotation_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Layout' => array(
            'className' => 'Layout',
            'foreignKey' => 'layout_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Colormode' => array(
            'className' => 'Colormode',
            'foreignKey' => 'colormode_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function beforeSave($options = array())
    {
        if (!$this->id) {
            $this->data['Job']['filesize'] = $this->data['Job']['file']['size'];
            $filename = str_replace(' ', '_', $this->data['Job']['file']['name']);
            $this->data['Job']['filename'] = str_replace('.PDF', '.pdf', $filename);
            $this->data['Job']['status_id'] = 1;
        }
    }

}
