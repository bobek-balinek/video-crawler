<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

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
	
	// Setting null arrays
	$data = array();
	$logs = array();
	
	$autor = array(
		1 => 'Foxa',
		2 => 'Mozek',
		3 => 'Fifek',
		4 => 'Derok',
		5 => 'Films',
		6 => 'Worte',
		7 => 'Kolerty',
		8 => 'Monus',
		9 => 'Yrek',
		10 => 'Polek',
	);
	
		// Get profiles
		$logs[] = array('item'=>'Skrypt', 'message'=>'Uruchomiono skrypt');
		$data['profiles'] = $this->profiles_model->get();
		
			foreach( $data['profiles'] as $profile_row ){
			
				$logs[] = array('item' => 'Profil: '.$profile_row->name , 'message' => 'Otworzono profil');
				
				// Profiles linking
				//
				$this->urls_model->idProfiles = $profile_row->id;
				$this->cookies_model->idProfiles = $profile_row->id;
				$this->tags_model->idProfiles = $profile_row->id;
				
				
				// Get data according to profile
				//
				$data['urls'] = $this->urls_model->get_by_profile();
				$cookies = $this->cookies_model->get_by_profile(1);
				$tags = $this->tags_model->get_by_profile();
				
				// /src=[\"']?([^www.megavideo.com/v/?.*])[\"']/i
				///href=[\'"]?[^www.megavideo.com$]([^\'" >]+)[\'" >]/
				// /src=[\"']?([^\"']?.*(png|jpg|gif))[\"']/i
				//  src="http://www.megavideo.com/v/N6EL9OXV"
				// Each url > parse it with tags' patterns	
				if(isset($data['urls']) and $data['urls']) {
					
					foreach( $data['urls'] as $url_row ){
				
						$urla = $url_row->url;
						
						//$cookie = $cookies->
						// COOKIE > SET VALUES > EXEC > RETURN FILE
						
						
						if(  startsWith($urla,'/') ){
							$urla = $profile_row->url . $urla;
						}
						$adres = prep_url($urla);
						
						// LOAD PAGE INTO VAR WITH COOKIE
						$c = curl_init($adres);
						curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
						//curl_setopt($c, CURLOPT_COOKIE, $cookie);
						//curl_setopt($c, CURLOPT_HEADER, TRUE);
						curl_setopt($c, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.googlebot.com/bot.html)');
						$result_page = curl_exec($c);
						curl_close($c);
						//echo $result_page;

						$logs[] = array('item' => 'Adres URL', 'message' => $urla);
						

						foreach($tags as $tag_row){
						
							//$tag_text = addslashes( str_replace('(:any)', '(.*)' ,$tag_row->text) );
							$tag_text = $tag_row->text;
							switch($tag_row->type){
							
								case 'video' : 
									preg_match($tag_text, $result_page, $base_title);
									print_r($base_title)."\n";
									if(isset($base_title) and $base_title and $base_title[1]<>''){
										$video = $base_title[1];
										//print_r($base_title);
										$logs[] = array('item'=>'Video' , 'message' => 'Znaleziono i dodano wideo.');
									}else{
										$video ='';
									}
								break;
								
								/*case 'url' :  
								
									preg_match_all($tag_text, $result_page, $base);
									//[0] = "ALL"
									// [1] = " CONENT ( VAR 1 )"
									$bas = $base[1];
									//print_r($bas);
									foreach($bas as $row){
										if(isset($row) and $row<>'' and $row<>'#' and $row<>'/'){
									
												$this->urls_model->id = '';
												$this->urls_model->idProfiles = $profile_row->id;
												$this->urls_model->url = $row;
												$this->urls_model->text = $row;
										//		$this->urls_model->save();
												
												//print_r(htmlspecialchars($row));
												$logs[] = array('item'=>'Adres URL' , 'message' => 'Dodany nowy adres URL.');
												//unset($base);
										}
									}
									break;
								*/
								case 'desc' :
									preg_match($tag_text, $result_page, $base_desc);
									if(isset($base_desc) and $base_desc and $base_desc[1]<>''){
										$desc = $base_desc[1];
										//print_r($base_img);
										$logs[] = array('item'=>'Opis' , 'message' => 'Znaleziono i dodano opis.');
									}else{
										$desc = '';
									}
								
								break;
								
								case 'title' : 
									preg_match($tag_text, $result_page, $base_title);
									if(isset($base_title) and $base_title and $base_title[1]<>''){
										$title= $base_title[1];
										//print_r($base_img);
										$logs[] = array('item'=>'Tytuł' , 'message' => 'Znaleziono i dodano tytuł.');
									}else{
										$title = '';
									}
								
								break;
								
								case 'img' :
									preg_match($tag_text, $result_page, $base_img);
									print_r($base_img)."\n";
									if(isset($base_img) and $base_img){
										$img = $base_img[1];										
										$logs[] = array('item'=>'Obrazek' , 'message' => 'Znaleziono i dodano obrazek.');
									}else{
										$img = '';
										$logs[] = array('item'=>'Obrazek' , 'message' => 'Nie i chuj.');
									}
								break;
							
							}

						}
						
						unset($result_page);
		// $video , $title, $picture, $desc
		
		// if $type <> 'url'
						
						
		// <img []>
							
		/*$sql_d = "SELECT `id` FROM `dle_category` WHERE `alt_name`='".$cat['2'][$e]."' LIMIT 1";
							
							$sql = "INSERT INTO dle_post SET autor='".$autor[rand(1, 10)]."',
		category='".$id_cat."', date='".$data."',
		title='".$title."',
		alt_name='".url_title($title)."',
		short_story='$opis',
		full_story='$megavideo',
		xfields='$xfileds',
		comm_num='0',
		allow_comm='1', 
		allow_main='1',
		allow_rate='1', 
		approve='1', 
		fixed='0',
		rating='0', 
		access='',
		allow_br='1', 
		vote_num='0', 
		editdate='', 
		news_read='".rand(1, 80)."',
		votes='0', 
		view_edit='0', 
		flag='1'
		";*/
					
					}
					
				}else{
				
					$logs[] = array('item'=>'Adres URL' , 'message' => 'Brak adresów URL');
				
				}
		
			}
		
		$logs[] = array('item'=>'Skrypt', 'message'=>"Skrypt zakończył działanie w czasie: {elapsed_time}s");
	
		$this->users->id = $this->session->userdata('id');
		$data['userdata'] = $this->users->get_by_id();
		
		$data['logs'] = $logs;	
		
		$this->load->view('crawler',$data);
		
	
	
	}

}

?>