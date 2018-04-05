<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class User extends REST_Controller {

	function __construct() {
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
		header('Access-Control-Allow-Headers: authorization, content-type, x-requested-with');
		if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
			header('HTTP/1.1 204 No Content');
		}

		parent::__construct();

		$this->load->model("user_model");
	}

	public function index_options() {
	    return $this->response(NULL, REST_Controller::HTTP_OK);
	}

	public function index_get() {
		$id = ($this->get('id')) ? $this->get('id'):'';

		$result = $this->user_model->get($id);
		$result = $result[0];
		$result['dogs'] = $this->user_model->get_dogs($result['id']);

		return $this->response($result, REST_Controller::HTTP_OK);
	}

	public function index_post() {
		$array = array(
			'firstname' => $this->post('firstname'), 
			'lastname' => $this->post('lastname'), 
			'address' => $this->post('address'), 
			'gender' => $this->post('gender'), 
			'status' => $this->post('status'), 
			'username' => $this->post('username'), 
			'password' => $this->post('password')
		);

		$insert = $this->user_model->add($array);
		if($insert) return $this->response(array('message' => "User successfully created"), REST_Controller::HTTP_CREATED);
		return $this->response(array('message' => "Unable to create user"), REST_Controller::HTTP_BAD_REQUEST);
	}

	public function index_put() {
		$put = $this->put();
		$id = $put['id'];
		unset($put['id']);

		$update = $this->user_model->update($id, $put);
		if($update) return $this->response(array('message' => "Your profile successfully updated"), REST_Controller::HTTP_OK);
		return $this->response(array('message' => "Unable to update user"), REST_Controller::HTTP_BAD_REQUEST);

	}
}





