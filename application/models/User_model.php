<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	function __construct() {
		$this->load->database();
	}

	public function get($id='') {
		if($id != '') $this->db->where('id', $id);

		return $this->db->select('id, firstname, lastname, address, gender, status, username, image')
						->get('user')
						->result_array();
	}

	public function add($details) {
		$details['password'] = hash("sha512", $details['password']);

		$this->db->insert('user', $details);
		if($this->db->affected_rows() > 0) return true;
		return false;
	}

	public function update($id, $details) {
		$this->db->where('id', $id);
		$this->db->update('user', $details);
		if($this->db->affected_rows() > 0) return true;
		return false;
	}

	public function get_dogs($user_id) {
		return $this->db->select('*')
						->where('userid', $user_id)
						->get('dog')
						->result_array();
	}
}
