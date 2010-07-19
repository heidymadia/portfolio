<?
/** copy_to_another_directory.php */
/** @author heidy.madia@gmail.com
    copy satu file ke file lainnya dengan nama file baru 
	*/
	
	
		
$test = opendir('/usr/sd/simage/map_tiles/editorial/13/');
while (($file = readdir($test)) !== false) {
	echo "filename: $file &nbsp;&nbsp;";
	$new_file = preg_replace('/^([0-9]+)_(.*)/', "14_$2", $file);
	echo "fileNewname: $new_file <br>\n";
	copy('/usr/sd/simage/map_tiles/editorial/13/'.$filename, '/usr/sd/simage/map_tiles/editorial/14/'.$new_file);
}
closedir($test);