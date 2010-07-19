<?
/*	display_page_description.php
	@author heidy.madia@gmail.com
	@version beta 0 
	@since 10:16 01/07/2010
*/
require_once 'sd_global.php';
require_once $sdGloBaseDir.'/lib/sd_m/dbconn/sdlib_dbconn.php';

?>
<style>
body{
	font-family:"Calibri", "Courier New", Courier, monospace; 
	font-size:12px; 
	color:#333333;	
}
.isNotRelated{
	color:#CC0033;
	background-color:#CCCCCC;
}
</style>

<div id="form">
	<form id="form1" method="post"> 
    	<label>Find </label>&nbsp;
        <input type="text" name="search_query" id="search_query" />&nbsp;
        <select name="search_method" id="search_method">
        	<option value="seo_title">Seo Title</option>
            <option value="description">Description</option>
            <option value="source_url" selected>Source URL</option>
        </select>&nbsp;&nbsp;
        <label>From Record No. </label>&nbsp;
        <input type="text" name="start_record" id="start_record" style="width:60px;"/> &nbsp;
        <label>Show </label>&nbsp;
        <input type="text" name="show_record" id="show_record" style="width:60px;" />
        <input type="button" name="find_now" value="Find Now" id="find_now" />
    </form>
</div>

<div id="result">

</div> 

<script src="/js/jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="/js/jquery/urlEncode.js" type="text/javascript"></script>
<script type="application/javascript" >

	function showList(){
		
		url_post = "<?=$GLOBALS['sdGloBaseUrl']?>/no-uploads/nico/heidy/201007/pregen_page_description/display_list.php?show&query="+$.URLEncode($('#search_query').val())+"&field="+$.URLEncode($('#search_method').val())+"&start="+$.URLEncode($('#start_record').val())+"&list="+$.URLEncode($('#show_record').val())+"";
		author="+$.URLEncode(str_author)+"
		
		$.ajax({
			type	: "POST", 
			url 	: url_post, 
			success : function(data){
				$('#result').html(data);				
			}			
		}); 
	}
	
	$('#find_now').click(function(){
	 	showList();  		 	
	}); 
	
	function setNotRelated(seo, source){
		url_post = "<?=$GLOBALS['sdGloBaseUrl']?>/no-uploads/nico/heidy/201007/pregen_page_description/display_list.php?set&seo="+$.URLEncode(seo)+"&source="+$.URLEncode(source)+"";
		
		$.ajax({
			type	: "POST", 
			url 	: url_post, 
			success : function(){
				//$('#result').html(data);
				showList();			
			}			
		}); 
	}

</script>