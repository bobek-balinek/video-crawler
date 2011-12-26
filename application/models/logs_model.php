<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 *
 *	Author: Przemysław Bobak
 *	
 *	13:38 02 September 2011
 */
 
class Logs_model extends CI_Model {

	var $logs = array();
	var $memory_usage = 0;
	var $time_elapsed = 0;
	var $mode = '';
	var $ini = 1;
	/*
	 *	Matkowanie
	 */
	function  __construct() {
		parent::__construct();
	}
	
	function add($item = null, $message = null, $skip_print = false){
	
		if(isset($item) and isset($message)){
		
			$this->logs[] = array('item' => $item, 'message' => $message);
			$this->ini += 1;
			if($skip_print != false){
				echo ($this->ini.". ".$item.' > '.$message."\n");
			}
			return true;
		
		}else{
		
			return false;
		
		}
	
	}
	
	function get(){
	
		return $this->logs;
	}
	
	function save(){
		$datas = array();
		$datas['date_created'] = date('YmdHis');
		$datas['mode'] = $this->mode;
		$datas['time_elapsed'] = $this->time_elapsed;
		$datas['memory_usage'] = $this->memory_usage;
		$strin = '';
		foreach( $this->logs as $key => $value ){
		
			$strin .= $key." ".$value['item']." > ".$value['message']." \n";
		
		}
		$datas['text'] = $strin; 
		$this->db->insert('logs', $datas);
		
		return true;
	
	}
	
	
}