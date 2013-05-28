<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profiles extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->users->valid_login();
		$this->load->model('profiles_model');
	}
	
	public function index(){
		
		
		$data = array();
		$this->users->id = $this->session->userdata('id');
		$data['userdata'] = $this->users->get_by_id();
		
		$data['profiles'] = $this->profiles_model->get();
		
		$this->load->view('profiles',$data);
		
	}
	
	function add(){
	
		$data = array();
		
		if($_POST){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name','Nazwa','required|trim|xss_clean');
			$this->form_validation->set_rules('url','Adres URL','required|trim|xss_clean');
			
			if ( $this->form_validation->run()==FALSE ){
			$data['message'] = validation_errors();
			
			}else{
				
				$this->profiles_model->name = $this->input->post('name');
				$this->profiles_model->url = $this->input->post('url');
				$this->profiles_model->save();
				
				$data['message'] = 'Profil został dodany';				
				
				$this->users->id = $this->session->userdata('id');
				$data['userdata'] = $this->users->get_by_id();
				
				$data['profiles'] = $this->profiles_model->get();
				
				$this->load->view('profiles',$data);
			
			}
		
		}else{
		
			$this->index();
			
		}
	
	}
	
	function edit(){
	
		if( $this->uri->segment(3) ){
		
			$this->profiles_model->id = $this->uri->segment(3);
			
			if($_POST){
			
				$this->profiles_model->name = $this->input->post('name');
				$this->profiles_model->url = $this->input->post('url');
				$this->profiles_model->save();
			
				$data['message'] = 'Zapisano zmiany';
				unset($_POST);
			
			}

			$data['profile'] = $this->profiles_model->get_by_id();
			//$data['profiles'] = $this->profiles_model->get();
		
			$this->load->view('profiles_edit',$data);
		}else{
		
			redirect('urls');
		}
	
	}
	
	function delete(){
	$data = array();
	
		if( $this->uri->segment(3) ){
		
			if($this->uri->segment(4) == 'confirmed' ){
			
				$this->profiles_model->id = $this->uri->segment(3);
				$this->profiles_model->delete();
				
				redirect('profiles');
			
			}
			
			$this->load->view('delete',$data);
		
		}else{
		
			redirect('profiles');
		
		}
	
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */