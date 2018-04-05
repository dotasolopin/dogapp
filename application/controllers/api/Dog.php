<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Dog extends REST_Controller {

	function __construct() {
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
		header('Access-Control-Allow-Headers: authorization, content-type, x-requested-with');
		if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
			header('HTTP/1.1 204 No Content');
		}

		parent::__construct();

		$this->load->model('dog_model');

	}

	public function index_options() {
	    return $this->response(NULL, REST_Controller::HTTP_OK);
	}

	public function index_get() {
		$id = ($this->get('id')) ? $this->get('id'):'';
		$userid = ($this->get('userid')) ? $this->get('userid'):'';

		$result = $this->dog_model->get($id, $userid);
		return $this->response($result, REST_Controller::HTTP_OK);
		
	}

	public function index_post() {
		$array = array(
			'name' => $this->post('name'), 
			'breed' => $this->post('breed'), 
			'birthdate' => $this->post('birthdate'), 
			'gender' => $this->post('gender'),
			'userid' => $this->post('userid')
		);

		$insert = $this->dog_model->add($array);
		if($insert) return $this->response($insert, REST_Controller::HTTP_CREATED);
		return $this->response(array('message' => "Unable to add dog"), REST_Controller::HTTP_BAD_REQUEST);
	}

	public function index_put() {
		$put = $this->put();
		$id = $put['id'];
		unset($put['id']);

		$update = $this->dog_model->update($id, $put);
		if($update) return $this->response(array('message' => "Dog profile successfully updated"), REST_Controller::HTTP_OK);
		return $this->response(array('message' => "Unable to update dog"), REST_Controller::HTTP_BAD_REQUEST);
	}

}











