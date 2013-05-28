<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 *
 *	Author: Przemysław Bobak
 *	
 *	13:38 02 September 2011
 */
 
class Urls_Model extends CI_Model {

	var $id = '';
	var $idProfiles = '';
	var $url = '';
	var $text = '';
 
	/*
	 *	Matkowanie
	 */
	function  __construct() {
		parent::__construct();
	}
	
	function get($limit = null, $offset = null){
		$this->db->select('urls.*,profiles.name AS profile_name');
		$this->db->join('profiles','profiles.id = urls.idProfiles','left');
		$query = $this->db->get('urls',$limit,$offset);
	
		if( $query->num_rows() > 0 ){
			return $query->result();
		}else{
			return false;
		}
	
	}
	
	function get_by_profile($limit = null, $offset = null){
	
		$this->db->where('idProfiles',$this->idProfiles);
		$query = $this->db->get('urls',$limit,$offset);
	
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	
	}
	
	function get_by_id(){
	
		$this->db->where('id',$this->id);
		$query = $this->db->get('urls',1);
	
		if( $query->num_rows() == 1 ){
			
			return $query->row();
		}else{
			return false;
		}
	
	}
	
	function save(){
	
		$this->db->where('id',$this->id);
		$query = $this->db->get('urls',1);
	
		if( $query->num_rows() == 1 ){
			$this->db->where('id',$this->id);
			$this->db->update('urls',$this);
			return true;
			
		}else{
		
			$this->db->insert('urls',$this);
			return $this->db->insert_id();
			
		}
	
	
	}
	
	
	function delete(){
	
		$this->db->where('id',$this->id);
		$this->db->delete('urls');
	
		return true;
	
	}
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */