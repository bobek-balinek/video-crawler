<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sign_in extends CI_Controller {

	function __construct(){
		parent::__construct();
	}
	public function index()
	{
		$data = array();
		
		if($_POST){
		
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<article class="error clearfix">', '</article>');
			$this->form_validation->set_rules('email','Email','trim|required|valid_email');
			$this->form_validation->set_rules('password','Password','trim|required');
			
			if( $this->form_validation->run() === false ){
			
				$data['message'] = array('class' => 'error', 'message' => validation_errors() );
			
			}else{
				
				if( $this->users->validate() == true ){
					$this->users->email = $this->input->post('email');
					$lolo = $this->users->get_by_email();
					$data = array(
						'id' => $lolo->id,
						'name' => $lolo->name,
						'logged_in' => true,
					);
					$this->session->set_userdata($data);
					redirect('home');
				}else{
				
					$data['message'] = array('class' => 'error', 'message' => '<p class="error">'.lang('not_valid_login').'</p>' );
				
				}
				
			}
		
		}
		
		$this->load->view('sign_in',$data);
	}
	
	function sign_out(){
	
		$this->session->sess_destroy();
		redirect('/');
	
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */