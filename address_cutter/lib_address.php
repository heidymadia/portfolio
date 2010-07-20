<?
/* 	lib_addrress.php
	@author heidy.madia@gmail.com
	@version beta 0 
	@since 2010-06-22
*/

require_once 'sd_global.php';
require_once $sdGloBaseDir.'/lib/sd_m/dbconn/sdlib_dbconn.php'; 

class LibAddress{
	private $data; 
	private $db; 
	private $list_place; 
	private $list_building; 
	
	public function __construct(){ 
		$this->db 			= sdlib_dbconn::getInstance('local_gw', FALSE, TRUE);
		$this->tbl_place	= "`address`.`addr_place`"; 
		$this->tbl_building	= "`address`.`addr_building`"; 
		
		$this->list_place 	= $this->db->getAll("SELECT place FROM $this->tbl_place"); 
		$this->list_building = $this->db->getAll("SELECT building FROM $this->tbl_building"); 							
	}
	
	public function main($str_data){
		$this->data = explode(",", $this->cleanUrl($str_data)); 
		
		$this->cekJalan(); 
		$this->cekKavling();
		$this->cekNomor();
		$this->cekKodePos();
		$this->cekPlace();	
		$this->cekLantai();	
		$this->cekUnitNumber();	
		$this->cekBuilding(); 
		
		$this->cleanData();		
		
		return $this->data;
	}
	
	/* FUNGSI PEMBANTU */
	private function cleanUrl($str){
		$find = array('/[^a-zA-Z0-9]/i');
		$repl = array(' ');
		$cleanStr = preg_replace($find, $repl, $str);
		$cleanStr = strtolower($cleanStr);
		$cleanStr = preg_replace('/([\t\n ]){2,}/'," ",$cleanStr);
		$cleanStr = trim($cleanStr); 
		//$cleanStr = str_replace(' ', '-', $cleanStr); 
		
		return $cleanStr;
	}
	
	private function cekJalan(){
		
		if(is_array($this->data)){
			foreach($this->data as $key=>$val){
				if(preg_match('/(jln|jl|jalan)/i', $val)){ // cek wether jalan is there
					$preplace_str	= preg_replace('/(.*)(jln|jl|jalan|jln\.|jl\.|jalan\.)(.*)/i', "$1||jalan$3", $val); //replace jalan with some odd characters
					$jln_temp = explode("||", $preplace_str); // explode the result with odd characters 
					
					unset($this->data[$key]);// unset the val
					
					foreach($jln_temp as $val){
						if(!empty($val))
							array_push($this->data, trim($val)); //set the new one with processed data
					}										
				} 			
			}
			return $this->data;
		}
	}	
	
	private function cekKavling(){
		if(is_array($this->data)){
			foreach($this->data as $key=>$val){
				if(preg_match('/(kav|kavling)/i', $val)){ // cek wether ??? is there
					$preplace_str	= preg_replace('/(.*)(kavling|kav|kavling\.|kav\.)(.*)/i', "$1||kavling $3", $val); //replace ??? with some odd characters
					$jln_temp = explode("||", $preplace_str); // explode the result with odd characters 
					
					unset($this->data[$key]);// unset the val
					
					foreach($jln_temp as $val){
						if(!empty($val))
							array_push($this->data, trim($val)); //set the new one with processed data
					}										
				} 			
			}
			return $this->data;
		}
	}
	
	private function cekNomor(){
		if(is_array($this->data)){
			foreach($this->data as $key=>$val){
				if(preg_match('/(no|nomor)/i', $val)){ // cek wether ??? is there
					$preplace_str	= preg_replace('/(.*)( no | nomor | no\. | nomor\. | no| nomor| no\.| nomor\.)([0-9a-z]+)(.*)/i', "$1||nomor $3||$4", $val); //replace ??? with some odd characters
					$jln_temp = explode("||", $preplace_str); // explode the result with odd characters 
					
					unset($this->data[$key]);// unset the val
					
					foreach($jln_temp as $val){
						if(!empty($val))
							array_push($this->data, trim($val)); //set the new one with processed data
					}										
				} 			
			}
			return $this->data;
		}
	}
	
	private function cekKodePos(){
		if(is_array($this->data)){
			foreach($this->data as $key=>$val){
				if(preg_match('/([\d]{5}?)/', $val)){ // cek wether ??? is there
					$preplace_str	= preg_replace('/(.*)([\d]{5}?)(.*)/i', "$1||$2||$3", $val); //replace ??? with some odd characters
					$jln_temp = explode("||", $preplace_str); // explode the result with odd characters 
					
					unset($this->data[$key]);// unset the val
					
					foreach($jln_temp as $val){
						if(!empty($val))
							array_push($this->data, trim($val)); //set the new one with processed data
					}										
				} 			
			}
			return $this->data;
		}	
	}
	
	private function cekPlace(){
		if(is_array($this->data)){
			foreach($this->list_place as $val_place){
				foreach($this->data as $key=>$val_data){				
					if(preg_match('/('.$val_place["place"].')/i', $val_data)){
						$str_preg 		= '/(.*)('.$val_place["place"].'{1}?)(.*)/i'; 
						
						$preplace_str	= preg_replace($str_preg, "$1||$2||$3", $val_data); //replace ??? with some odd characters
						
						$place_temp = explode("||", $preplace_str); // explode the result with odd characters 
						
						unset($this->data[$key]);// unset the val
						
						foreach($place_temp as $val){
						//echo "<pre>"; var_dump($val, $this->data); //exit; 
							if(!empty($val))
								if(!in_array($val, $this->data))
									array_push($this->data, trim($val)); //set the new one with processed data
						}											
					}
				}
			}
		}
	}
	
	private function cekLantai(){
		if(is_array($this->data)){
			foreach($this->data as $key=>$val){
				if(preg_match('/(lantai|lt)/i', $val)){ // cek wether ??? is there
					$preplace_str	= preg_replace('/(.*)( lantai| lt|  lantai\.| lt\.| lantai | lt |  lantai\. | lt\. )([0-9a-z]+)(.*)/i', "$1||lantai $3||$4", $val); //replace ??? with some odd characters
					$jln_temp = explode("||", $preplace_str); // explode the result with odd characters 
					
					unset($this->data[$key]);// unset the val
					
					foreach($jln_temp as $val){
						if(!empty($val))
							array_push($this->data, trim($val)); //set the new one with processed data
					}										
				} 			
			}
			return $this->data;
		}
	}
	
	private function cekUnitNumber(){
		if(is_array($this->data)){
			foreach($this->data as $key=>$val){
				if(preg_match('/floor/i', $val)){ // cek wether ??? is there
					$preplace_str	= preg_replace('/(.*)( [0-9a-z]+)( floor | floor\. | floor|floor\.)(.*)/i', "$1||$2 floor||$4", $val); //replace ??? with some odd characters
					$jln_temp = explode("||", $preplace_str); // explode the result with odd characters 
					
					unset($this->data[$key]);// unset the val
					
					foreach($jln_temp as $val){
						if(!empty($val))
							array_push($this->data, trim($val)); //set the new one with processed data
					}										
				} 			
			}
			return $this->data;
		}
	}
	
	private function cekBuilding(){
		
		if(is_array($this->data)){
			foreach($this->list_building as $val_building){
				foreach($this->data as $key=>$val_data){
					if(preg_match('/'.$val_building["building"].'/', $val_data)){// cek wether ??? is there
						$preplace_str	= preg_replace("/(.*)(".$val_building["building"].")(.*)/", "$1||$2||$3", $val_data); //replace ??? with some odd characters
						$building_temp	= explode("||", $preplace_str); // explode the result with odd characters
						
						unset($this->data[$key]);// unset the val
						
						foreach($building_temp as $val){
							if(!empty($val))
								array_push($this->data, trim($val)); //set the new one with processed data
						}		
						 
						
						
					}
				}				
			}
		}
	}	
	
	private function cleanData(){
		if(is_array($this->data)){
			foreach($this->data as $key=>$val){
				if(preg_match('/jalan/', $val)){
					unset($this->data[$key]); 
					$this->data["jalan"] = $val; 
				}
				
				if(preg_match('/momor/', $val)){
					unset($this->data[$key]); 
					$this->data["nomor"] = $val; 
				}
				
				if(preg_match('/kavling/', $val)){
					unset($this->data[$key]); 
					$this->data["kavling"] = $val; 
				}
				
				if(preg_match('/floor/', $val)){
					unset($this->data[$key]); 
					$this->data["floor"] = $val; 
				}
				
				if(preg_match('/lantai/', $val)){
					unset($this->data[$key]); 
					$this->data["lantai"] = $val; 
				}
				
				if(preg_match('/([\d]{5}?)/', $val)){
					unset($this->data[$key]); 
					$this->data["kodepos"] = $val; 
				}	
				
				if(preg_match('/nomor/', $val)){
					unset($this->data[$key]); 
					$this->data["nomor"] = $val; 
				}
				
				$this->setBuilding(); 			
				$this->setPlace(); 
			}
		}
	}
	
	private function setBuilding(){
		foreach($this->list_building as $val_building){
			foreach($this->data as $key=>$val_data){
				if(preg_match('/'.$val_building["building"].'/', $val_data)){
					unset($this->data[$key]);
					
					$this->data["building"] = $val_data;
				}
			}
		}
	}
	
	private function setPlace(){
		foreach($this->list_place as $val_place){
			foreach($this->data as $key=>$val_data){
				if(preg_match('/'.$val_place["place"].'/', $val_data)){
					unset($this->data[$key]);
					//echo "<pre>"; var_dump($val_place["place"]); exit; 
					
					$this->data["place"] = $val_data;
				}
			}
		}
	}	
	
}	
	
