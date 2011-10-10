<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->users->valid_login();
		$this->load->model('profiles_model');
		$this->load->model('tags_model');
	}
	public function index(){
		
		$data = array();
		$this->users->id = $this->session->userdata('id');
		$data['userdata'] = $this->users->get_by_id();
		$data['profiles'] = $this->profiles_model->get();
		$data['tags'] = $this->tags_model->get();
		
		$this->load->view('tags',$data);
		
	}
	
	function add(){
	
		if($_POST){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('profile','Profil','required');
			$this->form_validation->set_rules('text','Tekst','required|trim|xss_clean');
			$this->form_validation->set_rules('type','Typ','required|trim|xss_clean');
		
			if ( $this->form_validation->run()== FALSE){
				
				$data['message'] = validation_errors();
				
			}else{
			
				$this->tags_model->idProfiles = $this->input->post('profile');
				$this->tags_model->text =  $this->input->post('text');
				$this->tags_model->type = $this->input->post('type');
				$this->tags_model->save();

			}
				$this->users->id = $this->session->userdata('id');
				$data['userdata'] = $this->users->get_by_id();
				$data['profiles'] = $this->profiles_model->get();
				$data['tags'] = $this->tags_model->get();
				
				$this->load->view('tags',$data);
		}else{
		
			$this->index();
		
		}

	}
	
	function edit(){
	
		if( $this->uri->segment(3) ){
		
			$this->tags_model->id = $this->uri->segment(3);
			
			if($_POST){
			
				$this->tags_model->idProfiles = $this->input->post('profile');
				$this->tags_model->text = $this->input->post('text');
				$this->tags_model->type = $this->input->post('type');
				$this->tags_model->save();
			
				$data['message'] = 'Zapisano zmiany';
				unset($_POST);
			
			}

			$data['tag'] = $this->tags_model->get_by_id();
			$data['profiles'] = $this->profiles_model->get();
		
			$this->load->view('tags_edit',$data);
		}else{
		
			redirect('tags');
		}
	
	}
	
	function delete(){
	$data = array();
	
		if( $this->uri->segment(3) ){
		
			if($this->uri->segment(4) == 'confirmed' ){
			
				$this->tags_model->id = $this->uri->segment(3);
				$this->tags_model->delete();
				
				redirect('tags');
			
			}
			
			$this->load->view('delete',$data);
		
		}else{
		
			redirect('tags');
		
		}
	
	}
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */