<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 *
 *	Author: Przemysław Bobak
 *	
 *	13:38 02 September 2011
 */
 
class Users extends CI_Model {

	var $id = '';
	var $name = '';
	var $email = '';
	var $password = '';
	var $salt = '';
 
	/*
	 *	Matkowanie
	 */
	function  __construct() {
		parent::__construct();
	}
	
	function get_by_email(){
	
	$this->db->where('email',$this->email);
	$query = $this->db->get('users',1);
	
		if( $query->num_rows() == 1 ){
			
			return $query->row();
		}else{
			return false;
		}
	
	}
	
	
	
	function get_by_id(){
	
		$this->db->where('id',$this->id);
		$query = $this->db->get('users',1);
	
		if( $query->num_rows() == 1 ){
			
			return $query->row();
		}else{
			return false;
		}
	
	}
	
	
	/*
	 *	VALIDATE
	 */
	function validate(){
		$this->db->select('password, salt');
		$this->db->where('email',$this->input->post('email'));
				 
		$query = $this->db->get('users',1);
		
		if( $query->num_rows() == 1 ){
			
			$lol = $query->row();
			if( $lol->password === sha1($lol->salt.$this->input->post('password') ) ){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	/*
	 *	CHECK IF EXISTS
	 */
	function check_availability(){
	
		$this->db->where('email',$this->email);
		$query = $this->db->get('users',1);
		
		if( $query->num_rows() > 0 ){
			return true;
		}else{
			return false;
		}
	}
	
	/*
	 *	CHECK IF LOGGED IN
	 */
	function check_login(){
	
		$lol = $this->session->userdata('logged_in');
		if( $lol==false or !isset($lol)){
			return false;
		}else{
			return true;
		}
	
	}
	
	/*
	 *	CHECK IF LOGGED IN THEN REDIRECT
	 */
	function valid_login(){
	
		$lol = $this->session->userdata('logged_in');
		if( $lol==false or !isset($lol)){
			redirect('sign_in');
			return false;
		}else{
			return true;
		}
	
	}
	
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */