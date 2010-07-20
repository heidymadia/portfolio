<?
/** regex_alamat.php
	@author heidy.madia@gmail.com
	@version beta0 
	@since 2010-06-21
	
*/

require_once "lib_address.php";

if(!empty($_REQUEST['text_alamat'])){

	//echo "<pre>"; var_dump($_REQUEST['text_alamat']); 
	$hasil = explode("\n", str_replace("\"", "", $_REQUEST['text_alamat'])); 
}



?>
<style>
#text_alamat{
	width:1000px;
	height:300px;
}	
</style>
<div>
	<form id="form1" method="post">
    	<table>
        	<tr>
            	<td valign="top">
			        <label>Alamat</label>
                </td>
                <td>
                	<textarea name="text_alamat" id="text_alamat"><?=$_REQUEST['text_alamat']?></textarea>
                </td>
            </tr>
			<tr>
            	<td colspan="2">
                	<input type="submit" value="Submit" />
                </td>
            </tr>
        </table>
        
    </form>
</div>

<div id="hasil">
<?php 
	
	$addr = new LibAddress();
	foreach($hasil as $val_hasil){
		
		$hasil = $addr->main($val_hasil); 
		echo "<pre>"; var_dump($hasil);
	} 
?>
</div>
