<?php 
/* 
   HISTORY      : 11/12/03 - Created 
   DATE CREATED : 11/12/03 - EKO
   UPDATE  		: 
   PROBLEM 		:
   KEGUNAAN     : UPLOAD
   VARIABEL     : 
  
   
*/


session_start();
require("../include/global.php");
require("../include/sia_function.php");


f_connecting();
	mysql_select_db($DB);
?>
<html>
<head>
  <title>Import Data Mahasiswa</title>
<link href="../style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php 

//$pesan.=$frm_nama_file_name ;
if ($up==1) { 

   //$pesan.="okdeh";
   if ($frm_nama_file_name != "")
   {
   
     if (@copy($frm_nama_file, "../upload/$frm_nama_file_name")) 
	 {
	 	$pesan.="<br>File database telah berhasil diupload";
		
   
	 }
	 else
	 {
	 	$pesan.="<br>Maaf, tidak bisa upload file. Silahkan hubungi administrator apabila anda masih tidak bisa mengimport data mahasiswa.";
	 } 
  } 
   else
   {
      $pesan.="<br>Tidak ada file yang di-upload...";
   }
   
  
  

   
 }?>
<form method=post action="upload.php?up=1" enctype="multipart/form-data">
  
<table width="80%" border="0" align="center" cellspacing="0" cellpadding="0">
     <tr> 
      <td colspan="2"><img src="spacer" height="4"></td>
    </tr>
    <tr> 
      <td colspan="2"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="2">&nbsp;</td>
    </tr>
 
  <tr>
    <td colspan="2"><strong>Upload File</strong></td>
  </tr>
  
 
  <tr>
    <td>File database yang akan diupload *@</td>
    <td><input name="frm_nama_file" type="file" size="30"></td>
  </tr>
 
  <tr><td>&nbsp;</td><td><input type=submit name=submit value="Upload File">
  </td></tr>
  <tr><td colspan="2">&nbsp;</td></tr>
 <tr><td colspan="2">
 <table>
       <tr><td align="right">*</td><td> compulsory / harus diisi</td>
  </tr>
  </table>
  </td>
  </tr>
 
</table>
</form>

</body>
</html>
