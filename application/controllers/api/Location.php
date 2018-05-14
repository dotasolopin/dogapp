<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Location extends REST_Controller {

	function __construct() {

		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, OPTIONS');
		header('Access-Control-Allow-Headers: authorization, content-type, x-requested-with, Access-Control-Allow-Methods');
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
		$dogid = ($this->get('dogid')) ? $this->get('dogid'):'';
		$id = ($this->get('id')) ? $this->get('id'):'';

		$result = $this->dog_model->get_location($dogid, $id);

		return $this->response($result, REST_Controller::HTTP_OK);
	}

	public function index_post() {
		$array = array(
			'dogid' => $this->post('dogid'),
			'longitude' => $this->post('longitude'),
			'latitude' => $this->post('latitude'),
			'client_time' => $this->post('time'),
			'address' => $this->post('address')
		);

		$insert = $this->dog_model->add_location($array);
		if($insert) {
			$insert['tracklets'] = $this->dog_model->save_tracklets($insert['id'], $this->post('tracklets'));
			return $this->response($insert, REST_Controller::HTTP_CREATED);
		}
		return $this->response(array('message' => "Unable to save location"), REST_Controller::HTTP_BAD_REQUEST);
	}

	public function index_delete($id) {

		$delete = $this->dog_model->delete_location($id);
		if($delete) return $this->response($delete, REST_Controller::HTTP_OK);
		return $this->response(array('message' => "Unable to delete location", "id" => $id), REST_Controller::HTTP_BAD_REQUEST);

	}
}
