<?
/* 
   HISTORY      : 25/08/03- Masih ada yang bisa ditambahkan ?
       
   DATE CREATED : 25/08/03
   UPDATE  		: 25/08/03 - EKO
   	  		  
   PROBLEM 		:
   KEGUNAAN     : PETA KONDISI MATA KULIAH
   VARIABEL     : 
  
   
*/
session_start();
require("../include/global.php");
require("../include/sia_function.php");


f_connecting();
	mysql_select_db($DB);
	$result=mysql_query("Select Count(*) as jumlah from master_mk");
	$row=mysql_fetch_array($result);
	$jumlah_mk=$row["jumlah"]; 


?>
<html>
<head>
<title>Halaman Utama Mata Kuliah</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table  border="0" cellspacing="0" cellpadding="3" >
  <tr>
	<td colspan=4> <strong><font color="#003399">Jumlah Mata Kuliah</font></strong> 
    </td>
  </tr>
<tr>
	<td colspan=4 nowrap>&nbsp;<font color="#0099CC">Jumlah mata kuliah</font> <font face="Georgia, Times New Roman, Times, serif" color="#FF0000">
	<?php echo $jumlah_mk; ?></font> 
    </td>
  </tr>



<tr><td colspan="4">&nbsp;</td></tr>
  
</table>

</body>
</html>
