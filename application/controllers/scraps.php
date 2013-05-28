
								// SAVED FOR SEPARATE METHOD
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