<?php
App::uses('AppController', 'Controller');
/**
 * Programs Controller
 *
 * @property Program $Program
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ProgramsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

	public $paginate = array( 'limit' => 5, 'order' => 'Program.id DESC' );

	public $uses = array("Program", "Service", "User");

	private $service = null;

	public function beforeFilter(){
		$userId = $this->Auth->user('id');
		$userOptions = array('conditions' => array('User.id' => $userId));
		$user = $this->User->find('first', $userOptions);
		$serviceId = $user['User']['service_id'];
		$serviceOptions = array('conditions' => array('Service.id' => $serviceId));
		$service = $this->Service->find('first', $serviceOptions);
		$this->service = $service;
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$currentId = $this->service['Service']['program_id'];
		//What if this service does not have a current id or the current id does not have a program?
		$this->Paginator->settings = $this->paginate;
		$this->Program->recursive = 0;
		$this->set('programs', $this->Paginator->paginate(array('Program.id !=' => $currentId)));
		$options = array('conditions' => array('Program.' . $this->Program->primaryKey => $currentId));
		$this->set('currentProgram', $this->Program->find('first', $options));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Program->exists($id)) {
			throw new NotFoundException(__('Invalid program'));
		}
		$options = array('conditions' => array('Program.' . $this->Program->primaryKey => $id));
		$this->set('program', $this->Program->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Program->create();
			if ($this->Program->save($this->request->data)) {
				$this->Session->setFlash(__('The program has been saved.'));
				$this->service['Service']['program_id'] = $this->Program->getID();
				$this->Service->save($this->service);
				return $this->redirect(array('action' => 'edit',$this->Program->getID()));
			} else {
				$this->Session->setFlash(__('The program could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		//$this->layout = 'flat';
		//Lookup the user id to pass through
		//$this->User->id = $this->Auth->user('id');
		if (!$this->Program->exists($id)) {
			throw new NotFoundException(__('Invalid program'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Program->save($this->request->data)) {
				$this->Session->setFlash(__('The program has been saved.'));
				$this->service['Service']['program_id'] = $id;
				$this->Service->save($this->service);
				return $this->redirect(array('action' => 'edit', $id));
			} else {
				$this->Session->setFlash(__('The program could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Program.' . $this->Program->primaryKey => $id));
			$this->request->data = $this->Program->find('first', $options);
		}
	}

/**
 * select method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function select($id = null) {
		//Lookup the user id to pass through
		//$this->User->id = $this->Auth->user('id');
		if (!$this->Program->exists($id)) {
			throw new NotFoundException(__('Invalid program'));
		}
		$this->service['Service']['program_id'] = $id;
		if ($this->Service->save($this->service)) {
			$this->Session->setFlash(__('The program has been selected.'));
		}
		else {
			$this->Session->setFlash(__('The program could not be selected. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Program->id = $id;
		if (!$this->Program->exists()) {
			throw new NotFoundException(__('Invalid program'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Program->delete()) {
			$this->Session->setFlash(__('The program has been deleted.'));
		} else {
			$this->Session->setFlash(__('The program could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
