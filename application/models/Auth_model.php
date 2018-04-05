<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

	function __construct() {
		$this->load->database();
	}

	public function auth($details) {
		$details['password'] = hash("sha512", $details['password']);

		$query = $this->db->select('id, firstname, lastname, address, gender, status, username')
							->where($details)
							->get('user');

		if ($query->num_rows() > 0) {
			return $query->first_row();
		}
		return false;
	}
}
