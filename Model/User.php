<?php
App::uses('AppModel', 'Model','AuthComponent', 'Controller/Component');
/**
 * User Model
 *
 */
class User extends AppModel {
	
	public $belongsTo = array (
			"Service" =>  array(
	            'className'  => 'Service'
            )
		);

	public function beforeSave($options = array()) {
    if (isset($this->data[$this->alias]['password'])) {
        $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
    }
    return true;
	}

	
}
