<?
/* 
   HISTORY      : 25/08/03- Masih ada yang bisa ditambahkan ?
       
   DATE CREATED : 25/08/03
   UPDATE  		: 25/08/03 - EKO
   	  		  
   PROBLEM 		:
   KEGUNAAN     : PETA KONDISI PENELITIAN
   VARIABEL     : 
  
   
*/
session_start();
require("../include/global.php");
require("../include/sia_function.php");


f_connecting();
	mysql_select_db($DB);
	$result=mysql_query("Select Count(*) as jumlah from penelitian");
	$row=mysql_fetch_array($result);
	$jumlah_penelitian=$row["jumlah"]; 


$result=mysql_query("Select DATE_FORMAT(up_date,'%d/%m/%Y') as up_date1 from tulisan_ilmiah order by up_date DESC limit 0,1"); 
$row = mysql_fetch_array($result);
$tulisan_ilmiah_update = $row["up_date1"];

$result=mysql_query("Select DATE_FORMAT(up_date,'%d/%m/%Y') as up_date2 from penelitian order by up_date desc limit 0,1"); 
$row = mysql_fetch_array($result);
$penelitian_update = $row["up_date2"];
$result=mysql_query("Select DATE_FORMAT(up_date,'%d/%m/%Y') as up_date from buku_karya_dosen order by up_date desc limit 0,1"); 
$row = mysql_fetch_array($result);
$buku_update = $row["up_date"];
if ($buku_update=="") { $buku_update = "08/08/2003"; }
$result=mysql_query("Select DATE_FORMAT(up_date,'%d/%m/%Y') as up_date3 from profil_kerjasama order by up_date desc limit 0,1"); 
$row = mysql_fetch_array($result);
$profil_update = $row["up_date3"];
if ($profil_update=="") { $profil_update = "08/08/2003"; }
?>
<html>
<head>
<title>Halaman Utama Penelitian</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table  border="0" cellspacing="0" cellpadding="3" >
  <tr> 
    <td colspan=5> <strong><font color="#003399">Jumlah Penelitian</font></strong> 
    </td>
  </tr>
  <tr> 
    <td width="20"><div align="right"><font color="#FF9900"><strong>&raquo;</strong></font></div></td>
    <td width="153" colspan=4 nowrap> <font color="#0099CC">Jumlah penelitian:</font> 
      <font color="#FF0000" face="Georgia, Times New Roman, Times, serif"><b><?php echo $jumlah_penelitian; ?></b></font> 
    </td>
  </tr>
  <tr> 
    <td colspan=5>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan=5> <strong><font color="#003399">Tulisan Ilmiah Dosen</font></strong> 
    </td>
  </tr>
  <tr> 
    <td><div align="right"><font color="#FF9900"><strong>&raquo;</strong></font></div></td>
    <td colspan=4 nowrap> <font color="#0099CC">Update terakhir:</font> <font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><b><?php echo $tulisan_ilmiah_update; ?></b></font> 
    </td>
  </tr>
  <tr> 
    <td colspan=5>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan=5> <strong><font color="#003399">Penelitian</font></strong> </td>
  </tr>
  <tr> 
    <td><div align="right"><font color="#FF9900"><strong>&raquo;</strong></font></div></td>
    <td colspan=4 nowrap> <font color="#0099CC">Update terakhir:</font> <font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><b><?php echo $penelitian_update; ?></b></font> 
    </td>
  </tr>
  <tr> 
    <td colspan=5>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan=5> <strong><font color="#003399">Buku Karya Dosen</font></strong> 
    </td>
  </tr>
  <tr> 
    <td><div align="right"><font color="#FF9900"><strong>&raquo;</strong></font></div></td>
    <td colspan=4 nowrap> <font color="#0099CC">Update terakhir:</font> <font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><b><?php echo $buku_update; ?></b></font> 
    </td>
  </tr>
  <tr>
    <td colspan=5>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan=5> <strong><font color="#003399">Profil Kerjasama</font></strong> 
    </td>
  </tr>
  <tr> 
    <td><div align="right"><font color="#FF9900"><strong>&raquo;</strong></font></div></td>
    <td colspan=4 nowrap> <font color="#0099CC">Update terakhir:</font> <font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><b><?php echo $profil_update;?></b></font> 
    </td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>

</body>
</html>
