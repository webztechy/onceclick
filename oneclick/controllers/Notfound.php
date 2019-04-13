<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notfound extends CI_Controller {

	public function index() {
		$generated_json = SYSTM::generate_json(null, null);
		echo $generated_json;
	}
}
