<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Urls extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->users->valid_login();
		$this->load->model('profiles_model');
		$this->load->model('urls_model');
	}
	
	public function index(){
		
		$data = array();
		$this->users->id = $this->session->userdata('id');
		$data['userdata'] = $this->users->get_by_id();
		$data['profiles'] = $this->profiles_model->get();
		$data['urls'] = $this->urls_model->get();
		
		$this->load->view('urls',$data);
		
	}
	
	function add(){
	
		if ( $_POST ){
		
			$this->form_validation->set_rules('profile','Profil','required|trim|xss_clean');
			$this->form_validation->set_rules('url','Adres URL','required|trim|xss_clean');
			$this->form_validation->set_rules('text','text','required|trim|xss_clean');
			
			if ( $this->form_validation->run()==FALSE ){
			
				$data['message'] = validation_errors();
				
			}else{
			
				$this->urls_model->idProfiles = $this->input->post('profile');
				$this->urls_model->url = $this->input->post('url');
				$this->urls_model->text = $this->input->post('text');
				$this->urls_model->save();
				
				$data['message'] = 'Profil został dodany';	
						
				$this->users->id = $this->session->userdata('id');
				$data['userdata'] = $this->users->get_by_id();
				$data['profiles'] = $this->profiles_model->get();
				$data['urls'] = $this->urls_model->get();
				
				
			
			}
			
			$this->load->view('urls',$data);
		
		}else{
		
			$this->index();
		
		}
	
	
	}
	
	function edit(){
	
		if( $this->uri->segment(3) ){
		
			$this->urls_model->id = $this->uri->segment(3);
			
			if($_POST){
			
				$this->urls_model->idProfiles = $this->input->post('profile');
				$this->urls_model->text = $this->input->post('text');
				$this->urls_model->url = $this->input->post('url');
				$this->urls_model->save();
			
				$data['message'] = 'Zapisano zmiany';
				unset($_POST);
			
			}

			$data['url'] = $this->urls_model->get_by_id();
			$data['profiles'] = $this->profiles_model->get();
		
			$this->load->view('urls_edit',$data);
		}else{
		
			redirect('urls');
		}
	
	}
	
	function delete(){
	$data = array();
	
		if( $this->uri->segment(3) ){
		
			if($this->uri->segment(4) == 'confirmed' ){
			
				$this->urls_model->id = $this->uri->segment(3);
				$this->urls_model->delete();
				
				redirect('urls');
			
			}
			
			$this->load->view('delete',$data);
		
		}else{
		
			redirect('urls');
		
		}
	
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */