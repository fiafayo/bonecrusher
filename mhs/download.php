<?php

$nama_file = "abstract/".$id;

header("Cache-Control:no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-Type: application/octet-stream");

if (file_exists($nama_file.".doc"))
	{ 
header("Content-Disposition: attachment; filename="."info_biro_".$id.".doc");
$fp=fopen($nama_file.".doc","r");
print fread($fp, filesize($nama_file.".doc"));

fclose($fp);
}

if (file_exists($nama_file.".zip"))
	{ 
header("Content-Disposition: attachment; filename="."info_biro_".$id.".zip");
$fp=fopen($nama_file.".zip","r");
print fread($fp, filesize($nama_file.".zip"));

fclose($fp);
}

if (file_exists($nama_file.".txt"))
	{ 
header("Content-Disposition: attachment; filename="."info_biro_".$id.".txt");
$fp=fopen($nama_file.".txt","r");
print fread($fp, filesize($nama_file.".txt"));

fclose($fp);
}
if (file_exists($nama_file.".pdf"))
	{ 
header("Content-Disposition: attachment; filename="."info_biro_".$id.".pdf");
$fp=fopen($nama_file.".pdf","r");
print fread($fp, filesize($nama_file.".pdf"));

fclose($fp);
}
header("Connection: close");
?>