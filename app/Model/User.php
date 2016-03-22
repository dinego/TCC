<?php 
App::uses('AuthComponent', 'Controller/Component');

// app/Model/User.php
class User extends AppModel {
    public $name = 'User';
    
    public function beforeSave($options = array()) {
	    if (isset($this->data[$this->alias]['password'])) {
	        $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
	    }
	    return true;
	}

    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'A username is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'A password is required'
            )
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'professor', 'aluno')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        )
    );

    // app/Model/User.php


}