<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Crawler extends CI_Controller(){

	function __construct(){
		parent::__construct();
		$this->users->valid_login();
		$this->load->model('profiles_model');
		$this->load->model('urls_model');
		$this->load->model('tags_model');
		$this->load->model('cookies_model');
	}
	public function index(){
	
		$data['profiles'] = $this->profiles_model->get();
		
		foreach( $data['profiles'] as $profile_row ){
		
			$data['urls'] = $this->urls_model->get_bt_profile();
			
			foreach( $data['url'] as $url_row ){
		
				$adres = prep_url($url_row->url);
				
				// IF COOKIE THEN COOKIE
				
				// GET TAGS 
				
				// LOAD PAGE INTO VAR WITH COOKIE
				
				// LOOP TAGS AND GET DATA
					// IF URL > DATABASE
					// IF REST THEN MYSQL IT 
				
				
				
			
			
			}
			
		}
	
		
		$data = array();
		$this->users->id = $this->session->userdata('id');
		$data['userdata'] = $this->users->get_by_id();
		
		$data['tags'] = $this->tags_model->get();
		
		$this->load->view('tags',$data);
		
	
	
	}

}

?>