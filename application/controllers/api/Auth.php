<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Auth extends REST_Controller {

	function __construct() {

		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
		header('Access-Control-Allow-Headers: authorization, content-type, x-requested-with');
		if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
			header('HTTP/1.1 204 No Content');
		}
		
		parent::__construct();
		$this->load->model("auth_model");
		$this->load->model("user_model");
	}

	public function index_options() {
	    return $this->response(NULL, REST_Controller::HTTP_OK);
	}

	public function index_get() {
		return $this->response(array('test' => 'testdata'));
	}

	public function index_post() {
		$array = array(
			'username' => $this->post('username'), 
			'password' => $this->post('password'),
		);

		$auth = $this->auth_model->auth($array);

		if(!$auth) return $this->response(array('message' => "Unable to sign in"), REST_Controller::HTTP_BAD_REQUEST);

		$auth->dogs = $this->user_model->get_dogs($auth->id);
		return $this->response($auth, REST_Controller::HTTP_OK);
	}
}
