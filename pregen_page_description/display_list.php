<?
/*	display_list.php
	@author heidy.madia@gmail.com
	@version beta 0
	@since 10:49 01/07/2010
*/

require_once 'class_display_page_description.php'; 

$display = new display_page_description(); 
if(isset($_REQUEST['show'])){
	//echo "<pre>"; var_dump($data, $_REQUEST); exit; 
	$data["query"]  = $_REQUEST["query"]; 
	$data["field"]  = $_REQUEST["field"]; 
	$data["start"]	= !empty($_REQUEST["start"]) ? $_REQUEST["start"] : 0; 
	$data["list"]	= !empty($_REQUEST["list"]) ? $_REQUEST["list"] : 100; 
	
	$display->showList($data); 
	 

} else if(isset($_REQUEST['set'])){
	$data["seo"]	= $_REQUEST["seo"]; 
	$data["source"]	= $_REQUEST["source"];   
	
	$display->setNotRelated($data);
	//echo "<pre>"; var_dump($data, $_REQUEST);  
}