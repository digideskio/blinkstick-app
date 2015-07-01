<?php
App::uses('AppModel', 'Model');
/**
 * Service Model
 *
 */
class Service extends AppModel {
	public $belongsTo = array (
			"Program" =>  array(
	            'className'  => 'Program'
            )
		);
}
