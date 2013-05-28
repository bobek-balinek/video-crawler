<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->users->valid_login();
	}
	public function index()
	{
		$data = array();
		$this->users->id = $this->session->userdata('id');
		$data['userdata'] = $this->users->get_by_id();
		$this->load->view('home',$data);
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */