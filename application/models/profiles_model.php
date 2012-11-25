<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 *
 *	Author: Przemysław Bobak
 *	
 *	13:38 02 September 2011
 */
 
class Profiles_Model extends CI_Model {

	var $id = '';
	var $name = '';
	var $url = '';
 
	/*
	 *	Matkowanie
	 */
	function  __construct() {
		parent::__construct();
	}
	
	function get($limit = null, $offset = null){
	
	$query = $this->db->get('profiles',$limit,$offset);
	
		if( $query->num_rows() > 0 ){
			return $query->result();
		}else{
			return false;
		}
	
	}
	
	
	
	function get_by_id(){
	
		$this->db->where('id',$this->id);
		$query = $this->db->get('profiles',1);
	
		if( $query->num_rows() == 1 ){
			
			return $query->row();
		}else{
			return false;
		}
	
	}
	
	function save(){
	
		$this->db->where('id',$this->id);
		$query = $this->db->get('profiles',1);
	
		if( $query->num_rows() == 1 ){
			$this->db->where('id',$this->id);
			$this->db->update('profiles',$this);
			return true;
			
		}else{
		
			$this->db->insert('profiles',$this);
			return $this->db->insert_id();
			
		}
	
	
	}

	
	function delete(){
	
		$this->db->where('id',$this->id);
		$this->db->delete('profiles');
	
		return true;
	
	}
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */