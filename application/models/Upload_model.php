<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_model extends CI_Model {

	function __construct() { }

	public function save($base64) {

		$img = $base64;
		$img = str_replace('data:image/jpeg;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = FCPATH . 'images/' . uniqid() . '.jpg';
		$success = file_put_contents($file, $data);

		if($success) {
			return $file;
		}
		return false;

	}


}
