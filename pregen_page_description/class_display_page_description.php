<?
/**
	class_display_page_description.php
	@author heidy.madia@gmail.com
	@version beta 0
	@since 13:18 01/07/2010
*/

require_once 'sd_global.php';
require_once $sdGloBaseDir.'/lib/sd_m/dbconn/sdlib_dbconn.php';

class display_page_description{
	private $db; 
	private $tbl; 
	
	public function __construct(){
		$this->db  = sdlib_dbconn::getInstance('local_gw',FALSE,TRUE);
		$this->tbl = "`valorian`.`pregen_page_description_checked`";
	}
	
	public function showList($array_data){
		$list = $this->getListFromDB($array_data); 	

		$html_list = $this->getHTMLFromList($list); 
		echo $html_list; 
		//echo "<pre>"; var_dump($list); exit; 
	}
	
	public function setNotRelated($array_data){
		$data["seo"]    = addslashes($array_data["seo"]); 
		$data["source"] = $array_data["source"]; 
		$data["isRelated"] = 1; 
		
		$this->db->AutoExecute($this->tbl, $data, "UPDATE", "seo_title = '".$data["seo"]."' AND source_url = '".$data["source"]."' "); 
	}
	
	/* fungsi tambahan */
	private function getListFromDB($array_data){
		$field 		  = $array_data["field"]; 
		$search_query = "%".$array_data["query"]."%"; 
		$start		  = $array_data["start"]; 
		$list		  = $array_data["list"]; 
		
		$sql = "SELECT seo_title, description, source_url, isRelated FROM $this->tbl WHERE $field LIKE '$search_query' LIMIT $start, $list ";
		echo $sql; 
		return $this->db->getAll($sql); 
	}
	
	private function getHTMLFromList($array_list){
		unset($hasil);
		$divHead	= "<div>"; 
		$divFoot	= "</div>";
		$tableHead	= "<table><tr><td>SEO TITLE</td><td>SOURCE URL</td><td>IS RELATED</td></tr>"; 
		$tableFoot	= "</table>"; 
		
		foreach($array_list as $val_list){
			if($val_list["isRelated"] == 1){
				$hasil .= "<tr class=\"isNotRelated\">
						  <td>".$val_list["seo_title"]."</td>
						  <td>".$val_list["source_url"]."</td>
						  <td>".$val_list["isRelated"]."</td>
						  </tr>"; 
			} else {
				$hasil .= "<tr>
						  <td>".$val_list["seo_title"]."</td>
						  <td>".$val_list["source_url"]."</td>
						  <td>".$val_list["isRelated"]."&nbsp;<input type=\"button\" onClick=\"javascript:setNotRelated('".addslashes($val_list["seo_title"])."', '".$val_list["source_url"]."')\"  value=\"not related\" /></td>
						  </tr>"; 
			}
		}
		
		return $divHead.$tableHead.$hasil.$tableFoot.$divFoot; 
		
	}
}	