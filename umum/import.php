<?php 
/* 
   HISTORY      : 09/12/03 - Penambahan copy ke database 
   DATE CREATED : 07/07/03 - EKO
   UPDATE  		: 
   PROBLEM 		:
   KEGUNAAN     : QUERY BEBAS
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


		
 $perintah="./dbf2mysql -h sia.ubaya.ac.id -d teknik -t $frm_nama_table -c -f -P eko1nfotech -U teknik ../upload/$frm_nama_file";
 //  $perintah="./dbf2mysql -h sia.ubaya.ac.id -d teknik -t import_mahasiswa -c -f -P eko1nfotech -U teknik ../upload/BIO.DBF";
  
   $pesan.= "<br>".$perintah ;
   exec($perintah);


   
   
 }?>
<form method=post action="import.php?up=1" enctype="multipart/form-data">
  
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
    <td colspan="2"><strong>Import Data Mahasiswa</strong></td>
  </tr>
  
 
  <tr>
    <td>File database yang akan diimport *@</td>
    <td><input name="frm_nama_file" type="text" size="30"></td>
  </tr>
 
  <tr>
    <td>Nama Table *@</td>
    <td><input name="frm_nama_table" type="text" size="30"></td>
  </tr>
  <tr><td>&nbsp;</td><td><input type=submit name=submit value="Import Database">
  </td></tr>
  <tr><td colspan="2">&nbsp;</td></tr>
 <tr><td colspan="2">
 <table>
          <tr>
            <td align="right" valign="top"># </td>
            <td><strong><font color="#FF0000">Apabila data yang lama sudah 
        ada, maka data akan disesuaikan dengan data baru !!!</font></strong></td></tr>
		<tr><td align="right">*</td><td> compulsory / harus diisi</td>
  </tr>
  </table>
  </td>
  </tr>
 
</table>
</form>

</body>
</html>
