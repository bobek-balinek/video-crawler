<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cookies extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->users->valid_login();
		$this->load->model('profiles_model');
		$this->load->model('cookies_model');
	}
	public function index(){
		
		$data = array();
		$this->users->id = $this->session->userdata('id');
		$data['userdata'] = $this->users->get_by_id();
		$data['profiles'] = $this->profiles_model->get();
		$data['cookies'] = $this->cookies_model->get();
		
		$this->load->view('cookies',$data);
		
	}
	
	function add(){
		$data = array();
	
		if($_POST){
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('name','Nazwa','required');
			$this->form_validation->set_rules('agent','Agent','required');
			$this->form_validation->set_rules('content','Treść','required');
			
			if ( $this->form_validation->run()==FALSE ){
			
				$data['message'] = validation_errors();
				
			}else{
			
				$this->cookies_model->idProfiles = $this->input->post('profile');
				$this->cookies_model->name = $this->input->post('name');
				$this->cookies_model->agent = $this->input->post('agent');
				$this->cookies_model->content = $this->input->post('content');
				$this->cookies_model->save();
				
				$data['message'] = 'Dodano ciasteczko';
			
			}
				$this->users->id = $this->session->userdata('id');
				$data['userdata'] = $this->users->get_by_id();
				$data['profiles'] = $this->profiles_model->get();
				$data['cookies'] = $this->cookies_model->get();
				
				$this->load->view('cookies',$data);
		
		}else{
		
			$this->index();
			
		}
	
	}
	
	function edit(){
	
		if( $this->uri->segment(3) ){
		
			$this->cookies_model->id = $this->uri->segment(3);
			
			if($_POST){
			
				$this->cookies_model->idProfiles = $this->input->post('profile');
				$this->cookies_model->name = $this->input->post('name');
				$this->cookies_model->agent = $this->input->post('agent');
				$this->cookies_model->content = $this->input->post('content');
				$this->cookies_model->save();
			
				$data['message'] = 'Zapisano zmiany';
				unset($_POST);
			
			}

			$data['cookie'] = $this->cookies_model->get_by_id();
			$data['profiles'] = $this->profiles_model->get();
		
			$this->load->view('cookies_edit',$data);
		}else{
		
			redirect('cookies');
		}
	
	}
	
	function delete(){
	$data = array();
	
		if( $this->uri->segment(3) ){
		
			if($this->uri->segment(4) == 'confirmed' ){
			
				$this->cookies_model->id = $this->uri->segment(3);
				$this->cookies_model->delete();
				
				redirect('cookies');
			
			}
			
			$this->load->view('delete',$data);
		
		}else{
		
			redirect('cookies');
		
		}
	
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */