<?php
App::uses('AppController', 'Controller');
/**
 * Services Controller
 *
 */
class ServicesController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;

	public function json($id = null) {
		$this->layout = null;
		$this->Service->id = $id;
		if (!$this->Service->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('service', $this->Service->read(null, $id));
	}

}
