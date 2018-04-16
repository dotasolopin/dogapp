<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dog_model extends CI_Model {

	function __construct() {
		$this->load->database();
	}

	public function get($id='', $userid) {
		if($id != '') $this->db->where('id', $id);
		if($userid != '') $this->db->where('userid', $userid);

		return $this->db->select('*')
						->get('dog')
						->result_array();
	}

	public function add($details) {

		$this->db->insert('dog', $details);
		if($this->db->affected_rows() > 0) {
			$details['id'] = $this->db->insert_id();
			return $details;
		}
		return false;
	}

	public function update($id, $details) {
		$this->db->where('id', $id);
		$this->db->update('dog', $details);
		if($this->db->affected_rows() > 0) return true;
		return false;
	}

// for dog locations
	public function get_location($dogid = '', $id = '') {
		if($dogid != '') $this->db->where('dogid', $dogid);
		if($id != '') $this->db->where('id', $id);

		return $this->db->select('*')
						->get('locations')
						->result_array();
	}

	public function add_location($data) {
		$this->db->insert('locations', $data);
		if($this->db->affected_rows() > 0) {
			$data['id'] = $this->db->insert_id();
			return $data;
		}
		return false;
	}

	public function delete_location($id) {
		$this->db->where('id', $id);
		$this->db->delete('locations');

		if($this->db->affected_rows() > 0) {
			return true;
		}
		return false;

	}

// for dog temperature
	public function get_temperature($dogid = '', $id = '') {
		if($dogid != '') $this->db->where('dogid', $dogid);
		if($id != '') $this->db->where('id', $id);

		return $this->db->select('*')
						->get('temperatures')
						->result_array();
	}

	public function add_temperature($data) {
		$this->db->insert('temperatures', $data);
		if($this->db->affected_rows() > 0) {
			$data['id'] = $this->db->insert_id();
			return $data;
		}
		return false;
	}

	public function delete_temperature($id) {
		$this->db->where('id', $id);
		$this->db->delete('temperatures');

		if($this->db->affected_rows() > 0) {
			return true;
		}
		return false;

	}

}


