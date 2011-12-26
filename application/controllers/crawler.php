<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

class Crawler extends CI_Controller {

	function __construct(){
		parent::__construct();
		//$this->users->valid_login();
		$this->load->model('profiles_model');
		$this->load->model('urls_model');
		$this->load->model('tags_model');
		$this->load->model('cookies_model');
		$this->load->model('logs_model');
		$this->output->enable_profiler(TRUE);
	}

	
	public function index($id = null){
	
		if($_POST){
		
			switch($this->input->post('mode')){
			
				case 'profiles' : $this->run($this->input->post('profile') ); 
					break;
				case 'url' : $this->url($this->input->post('profile') ); 
					break;
			}
		
		}else{
	
			$this->users->id = $this->session->userdata('id');
			$data['userdata'] = $this->users->get_by_id();

			$data['profiles'] = $this->profiles_model->get();
			
			$this->load->view('crawler_run',$data);
		
		}
	}
	
	public function url($id = null) {
	
		// Setting null arrays
		$data = array();
		$logs = array();
	
			$this->benchmark->mark('code_start');
			// Get profiles
			$this->logs_model->add( 'Skrypt',  'Uruchomiono skrypt');
			
			if(isset($id) and $id){
				$this->profiles_model->id = $id;
				$data['profiles'] = $this->profiles_model->get_by_id();
			}else{
				$data['profiles'] = $this->profiles_model->get();
			}
		
			foreach( $data['profiles'] as $profile_row ){
			
				$this->logs_model->add(  'Profil: '.$profile_row->name ,   'Otworzono profil');
				
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
						
						if(  startsWith($urla,'/') ){
							$urla = $profile_row->url . $urla;
						}
						$adres = prep_url($urla);
						
						// LOAD PAGE INTO VAR WITH COOKIE
						$c = curl_init($adres);
						curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
						//curl_setopt($c, CURLOPT_COOKIE, $cookie);9im
						//curl_setopt($c, CURLOPT_HEADER, TRUE);
						curl_setopt($c, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.googlebot.com/bot.html)');
						$result_page = curl_exec($c);
						curl_close($c);
						//echo $result_page;

						$this->logs_model->add(  'Adres URL',   $urla);
						

						foreach($tags as $tag_row){
						
							//$tag_text = addslashes( str_replace('(:any)', '(.*)' ,$tag_row->text) );
							$tag_text = $tag_row->text;
							switch($tag_row->type){
								
								case 'url' :  
								
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
												$this->urls_model->save();
												
												//print_r(htmlspecialchars($row));
												$this->logs_model->add( 'Adres URL' ,   'Dodany nowy adres URL.');
												//unset($base);
										}else{
											$this->logs_model->add( 'Adres URL' ,   'Nie znaleziono adresu URL');
										}
									}
									break;
							
							}

						}
						
						unset($result_page);
					
					}
					
				}else{
				
					$this->logs_model->add( 'Adres URL' ,   'Brak adresów URL');
				
				}
		
			}
		
			$this->benchmark->mark('code_end');
			$lol = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->logs_model->time_elapsed = $lol; 
			$this->logs_model->mode = 'Adresy URL'; 
			$this->logs_model->add('Skrypt', 'Skrypt zakończył działanie w czasie:'.$lol.'s');
			
			$data['logs'] = $this->logs_model->get();
			$this->logs_model->save();
			
			if($this->input->is_cli_request() == TRUE){
			
				foreach($data['logs'] as $key => $value){
				
					print($key.'. '.$value['item'].' > '.$value['message'].PHP_EOL);
					
				}
				
			}else{
			
				$this->users->id = $this->session->userdata('id');
				$data['userdata'] = $this->users->get_by_id();
				$this->load->view('crawler',$data);
			
			}
			
	}
	
	public function profile(){
	
	
		if( $this->uri->segment(3) ){
		
			$this->profiles_model->id = $this->uri->segment(3);
			$profile = $this->profiles_model->get_by_id();
			
			if($profile and isset($profile)){
			
			//	print ("DUPA");
				$this->run($this->uri->segment(3));
			
			}else{
				//print ("ddd");
				$this->run();
			
			}
		
		}else{
		
			$this->run();
		
		}
	
	}
	
	public function run($id = null){
	
		$this->benchmark->mark('code_start');

		// Setting arrays
		$data = array();
		$autor = array(1 => 'Foxa',2 => 'Mozek',3 => 'Fifek',4 => 'Derok',5 => 'Films',6 => 'Worte',7 => 'Kolerty',8 => 'Monus',9 => 'Yrek',10 => 'Polek',);
	
		// Get profiles
		$this->logs_model->add( 'Skrypt',  'Uruchomiono skrypt');
		
		if($id and isset($id)){
		
			$this->profiles_model->id = $id;
			$data['profiles'] = $this->profiles_model->get_by_id();
			
		}else{
		
			$data['profiles'] = $this->profiles_model->get();
			
		}
		
		if( $data['profiles'] and isset($data['profiles']) ){
		
			foreach( $data['profiles'] as $profile_row ){
			
				$this->logs_model->add(  'Profil: '.$profile_row->name ,   'Otworzono profil');
				
				// Profiles linking
				//
				$this->urls_model->idProfiles = $profile_row->id;
				$this->cookies_model->idProfiles = $profile_row->id;
				$this->tags_model->idProfiles = $profile_row->id;
				
				
				// Get data according to profile
				//
				$data['urls'] = $this->urls_model->get_by_profile();
				$cookies = $this->cookies_model->get_by_profile();
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
						
						if(isset($cookies) and $cookies){
							//$cookie = CREATE COOKIE
						
							$cookie = 'cookie';
							$ch = curl_init($cookies->url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_USERAGENT, $cookies->agent);
							curl_setopt ($ch, CURLOPT_HEADER, 0);
							curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
							curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
							curl_setopt($ch, CURLOPT_POST, true);
							curl_setopt($ch, CURLOPT_POSTFIELDS,$cookies->content);
							$resuslti = curl_exec ($ch);
							curl_close ($ch);
							$this->logs_model->add('Cookie', 'Zainicjowano ciasteczko cookie');
							
							
							curl_setopt($c, CURLOPT_USERAGENT, $cookies->agent );
							curl_setopt($c, CURLOPT_COOKIEFILE, 'cookie');
							//echo $resulti;
						}
						
						// USE COOKIE
						curl_setopt($c, CURLOPT_HEADER, TRUE);
						$result_page = curl_exec($c);
						curl_close($c);
						//echo $result_page;

						$this->logs_model->add(  'Adres URL',   $urla);
						

						foreach($tags as $tag_row){
						
							$tag_text = $tag_row->text;
							switch($tag_row->type){
							
								case 'video' : 
									preg_match($tag_text, $result_page, $base_video);
									//print_r($base_video)."\n";
									if(isset($base_video) and $base_video and $base_video[1]<>''){
										$video = $base_video[1];
										
										//$video = substr(parse_url($videos, PHP_URL_PATH), 3, 8);
										$this->logs_model->add( 'Video' ,   'Znaleziono i dodano wideo.');
										
									
									}else{
										$video ='';
										$this->logs_model->add( 'Video' ,   'Brak wideo.');
									}
								break;
								
								case 'desc' :
									preg_match($tag_text, $result_page, $base_desc);
									if(isset($base_desc) and $base_desc and $base_desc[1]<>''){
										$desc = $base_desc[1];
										//print_r($base_desc);
										$this->logs_model->add( 'Opis' ,   'Znaleziono i dodano opis.');
									}else{
										$desc = '';
										$this->logs_model->add( 'Opis' ,   'Brak opisiu.');
									}
								
								break;
								
								case 'title' : 
									preg_match($tag_text, $result_page, $base_title);
									if(isset($base_title) and $base_title and $base_title[1]<>''){
										$title= $base_title[1];
										//print_r($base_img);
										$this->logs_model->add( 'Tytuł' ,   'Znaleziono i dodano tytuł.');
									}else{
										$title = '';
										$this->logs_model->add('Tytuł', 'Nie znaleziono tytułu');
									}
								
								break;
								
								case 'img' :
									preg_match($tag_text, $result_page, $base_img);
								//	print_r($base_img)."\n";
									if(isset($base_img) and $base_img){
										$img = $base_img[1];										
										$this->logs_model->add( 'Obrazek' ,   'Znaleziono i dodano obrazek.');
									}else{
										$img = '';
										$this->logs_model->add( 'Obrazek' ,   'Brak obrazka.');
									}
								break;
								
								case 'category' :
									// Compare each category 
									preg_match($tag_text, $result_page, $base_cat);
									if(isset($base_cat) and $base_cat){
																		
										$catsy = explode("," , $base_cat[1]);
										
										$gard = array();
										
										foreach($catsy as $key){
											//echo($key);
											$this->db->select('id');
											$this->db->where('name' , trim($key));
											$ol = $this->db->get('dle_category');
											//print_r($ol->row());
											if($ol->num_rows()>0){
											
												$kf = $ol->row();
												array_push($gard,$kf->id);
											
											}else{
											
											}
										}
										
										$category = implode(",",$gard);
										//print_r($category);
										$this->logs_model->add( 'Kategoria',   'znaleziono i dodano kategorie.');
									
									}else{
										$category = '';
										$this->logs_model->add( 'Kategoria',   'Brak kategorii');
									}
								break;
							
							}

						}
						
						unset($result_page);
						
				if(isset($video) and $video<>''){
					$dats = date('YmdHis');
					if(!isset($img)){
						$img = ' ';
					}
					$xfileds = 'image|'.$img.'||jakosc|Dobra||jezyk|Brak Danych||rok|Brak Danych';			
					
					$this->db->where('full_story',$video);
					$qury = $this->db->get('dle_post',1);
					
						if($qury->num_rows()==0){
							$sql = "INSERT INTO dle_post SET 
									autor='".$autor[rand(1, 10)]."',
									category='".$category."', 
									date='".$dats."',
									title='".$title."',
									alt_name='".url_title($title)."',
									short_story='".$desc."',
									full_story='".$video."',
									xfields='".$xfileds."',
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
									";
				
							$this->db->query($sql);
							$this->logs_model->add( 'Film' ,   'Zapisano film w bazie danych.');
						}else{
							$this->logs_model->add( 'Film' ,   'Film już istnieje w bazie danych.');
						}
				
				}
					
					}
					
				}else{
				
					$this->logs_model->add('Adres URL', 'Brak adresów URL');
				
				}
		
			}
			
			$this->benchmark->mark('code_end');
			$lol = $this->benchmark->elapsed_time('code_start', 'code_end');
			$this->logs_model->time_elapsed = $lol; 
			$this->logs_model->mode = 'Profil'; 
			$this->logs_model->add('Skrypt', 'Skrypt zakończył działanie w czasie:'.$lol.'s');
			
			$data['logs'] = $this->logs_model->get();
			$this->logs_model->save();
			
		if($this->input->is_cli_request() == TRUE){
		
			foreach($data['logs'] as $key => $value){
			
				print($key.'. '.$value['item'].' > '.$value['message'].PHP_EOL);
				
			}
			
		}else{
		
			$this->users->id = $this->session->userdata('id');
			$data['userdata'] = $this->users->get_by_id();
			$this->load->view('crawler',$data);
		
		}
		
		}
	
	}

}

?>