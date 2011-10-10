<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Crawler extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->users->valid_login();
		$this->load->model('profiles_model');
		$this->load->model('urls_model');
		$this->load->model('tags_model');
		$this->load->model('cookies_model');
	}
	public function index(){
	
	$data = array();
	$logs = array();
	
	
		$logs[] = array('item'=>'Skrypt', 'message'=>'Uruchomiono skrypt');
		$data['profiles'] = $this->profiles_model->get();
		
			foreach( $data['profiles'] as $profile_row ){
			
				$logs[] = array('item' => 'Profil: '.$profile_row->name , 'message' => 'Otworzono profil');
				
				$this->urls_model->idProfiles = $profile_row->id;
				$data['urls'] = $this->urls_model->get_by_profile();
					
				if($data['urls'] and isset($data['urls'])) {
					
					foreach( $data['urls'] as $url_row ){
					
						$logs[] = array('item' => 'Adres URL', 'message' => $url_row->url);
				
						$adres = prep_url($url_row->url);
						
						$this->cookies_model->idProfiles = $profile_row->id;
						$cookies = $this->cookies_model->get_by_profile(1);
						
						$this->tags_model->idProfiles = $profile_row->id;
						$tags = $this->tags_model->get_by_profile();
						
						// LOAD PAGE INTO VAR WITH COOKIE
						$c = curl_init($url_row->url);
						curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
						$result_page = curl_exec($c);
						curl_close($c);
						
						/*foreach($tags as $tag_row){
						
							switch($tag_row->type){
							
								case 'video' : break;
								
								case 'url' :  break;
								
								case 'desc' :  break;
								
								case 'title' :  break;			
							
							}
								// IF URL > DATABASE
							// IF REST THEN MYSQL IT 
						
						}			*/	
					
					}
					
				}
		
			}
	
		
		$data = array();
		$this->users->id = $this->session->userdata('id');
		$data['userdata'] = $this->users->get_by_id();
		
		$data['tags'] = $this->tags_model->get();
		$data['logs'] = $logs;
		
		
		$this->load->view('crawler',$data);
		
	
	
	}

}

?>