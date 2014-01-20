<? 
/* 
   DATE CREATED : 13/12/07 - RAHADI
   KEGUNAAN     : MASTER HARI UJIAN
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/
session_start();
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);
?>
<html>
<head>
<script language="JavaScript">
function konfirmasiHapus()
{
		var checkconfirm=confirm("Apakah Anda yakin ingin menghapus Data ini" + " " + "\?")
		if (checkconfirm == true) 
			return true;
		else
			return false;
}
</script>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
</head>
<?
$filename = "umum_master_kode_kp.php"; // name of this file 
$option = array (5, 10, 25, 50, 100, 200); 
$default = 200; // default number of records per page 
$action = $_SERVER['PHP_SELF']; // if this doesn't work, enter the filename 
// end config--------------------------------- 

$opt_cnt = count ($option); 

if (isset($_GET['go']))
{
	$go = $_GET['go']; 
}
else
{
	$go="";
}

if ($go == "") { 
$go = $default; 
} 
elseif (!in_array ($go, $option)) { 
$go = $default; 
} 
elseif (!is_numeric ($go)) { 
$go = $default; 
} 
$nol = $go; 
$limit = "0, $nol"; 
$count = 1; 

//$connection = mysql_connect ($dbhost, $dbuser, $dbpass) or die ("Unable to connect"); 
//mysql_select_db ($dbname) or die ("Unable to select database $db"); 


// control query------------------------------ 
/* this query checks how many records you have in your table. 
change this to match your own table*/ 
$off_sql = mysql_query ("SELECT * FROM master_kode_kp") or die ("Error in query: $off_sql".mysql_error()); 
$off_pag = ceil (mysql_num_rows($off_sql) / $nol); 
//-------------------------------------------- 

if (isset($_GET['offset']))
{	
	$off = $_GET['offset']; 
}
else
{
	$off=1;
}
if (get_magic_quotes_gpc() == 0) { 
$off = addslashes ($off); 
} 
if (!is_numeric ($off)) { 
$off = 1; 
} 
if ($off > $off_pag) { 
$off = 1; 
} 

if ($off == "1") { 
$limit = "0, $nol"; 
} 
elseif ($off <> "") { 
for ($i = 0; $i <= ($off - 1) * $nol; $i ++) { 
$e = 0 + $i; 
$limit = "$e, $nol"; 
$count = $e + 1; 
} 
} 

$sql = mysql_query ("SELECT * FROM master_kode_kp ORDER BY id ASC LIMIT $limit") or die ("Error in query: $sql".mysql_error()); 

$count=1;
?>
<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><hr size="1" color="#FF9900"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="91%"><font color="#0099CC" size="1"><strong>SETTING ~</strong> MASTER KODE KERJA PRAKTEK</font></td>
        <td width="9%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">UMUM</font></strong></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><hr size="1" color="#FF9900"></td>
  </tr>
</table>
<font face="Verdana, Arial, Helvetica, sans-serif"><br>
<font color="#FF0000"><strong><?php echo $pesan; ?></strong></font>
<?
if (mysql_num_rows($sql)<>0)
{
?>
<form name="formSatu" id="formSatu">
  <table width="40%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" class="table">
    <tr bgcolor="#F0F9FF"> 
      <td width="38"> <div align="center"><font color="#000000" size="1"><strong>ID</strong></font></div></td>
      <td width="78" nowrap><div align="center"><font color="#000000" size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">JURUSAN</font></strong></font></div></td>
      <td width="78" nowrap> <div align="center"><font color="#000000" size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">NAMA</font></strong></font></div></td>
      <td width="138" nowrap> <div align="center"><font color="#000000" size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">KODE KP</font></strong></font></div></td>
      <td width="25"> <div align="center"><font color="#000000" size="1"><strong>Ubah</strong></font></div></td>
      <td width="33"> <div align="center"><font color="#000000" size="1"><strong>Hapus</strong></font></div></td>
    </tr>
    <?
  while($row=mysql_fetch_array($sql)) {?>
    <tr bgcolor="#FFFFFF" onMouseOver="style.background='#D2E8F2'" onMouseOut="style.background='#FFFFFF'"> 
      <td><div align="center"><font size="1"><? echo $row["id"];?></font></div></td>
      <td nowrap><font size="1">
        <?  $result2 = mysql_query("SELECT * FROM jurusan 
											WHERE id>0 and id<>9 AND jurusan.id=".$row["jurusan"]);
	         $row2 = mysql_fetch_array($result2);
			 echo $row2["jurusan"];
		?>
      </font></td>
      <td nowrap><div align="center"><font size="1"><? echo $row['nama'];?></font></div></td>
      <td align="center"><font size="1"><? echo $row['kode_kp'];?></font></td>
      <td><div align="center"><font size="1"><a href="umum_master_kode_kp_ubah.php?kd=<?=$row['id']?>&offset=<? if (isset($_GET["offset"])) echo $_GET["offset"];?>&go=<? if (isset($_GET["go"])) echo $_GET["go"];?>"><img src="../img/edit.png" width="13" height="13" border="0"></a></font></div></td>
      <td><div align="center"><font size="1"><a href="umum_master_kode_kp.php?act=hapus&kd=<?=$row['id']?>&offset=<? if (isset($_GET["offset"])) echo $_GET["offset"];?>&go=<? if (isset($_GET["go"])) echo $_GET["go"];?>" onClick="return konfirmasiHapus();"><img src="../img/hapus.png" width="11" height="13" border="0"></a></font></div></td>
    </tr>
    <? }?>
    <tr bgcolor="#F0F9FF"> 
      <td height="25" colspan="6"> 
	  <table width="5%" border="1" align="right" cellpadding="0" cellspacing="0" bordercolor="#FF9900">
          <tr> 
            <td bgcolor="#AAAAAA" onMouseOver="style.background='#CCCCCC'" onMouseOut="style.background='#AAAAAA'"><div align="center"><font size="1"><a href="umum_master_kode_kp_add.php" style="text-decoration: none; ">Tambah</a></font></div></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?
}
else
{
?>
<table width="70%" border="0" align="center" cellpadding="0" cellspacing="5">
  <tr> 
    <td><div align="center"><img src="../img/folder_announce_new.gif" width="19" height="18" align="absbottom"> 
        <font color="#FF0000" size="2">Data <font face="Verdana, Arial, Helvetica, sans-serif">Kode Kerja Praktek </font>masih kosong di dalam Database.</font></div></td>
  </tr>
  <tr> 
    <td><div align="center"><font size="1">
	<a href="umum_master_kode_kp_add.php">Tambah Kode Kerja Praktek</a>&nbsp;</font></div></td>
  </tr>
</table>
<?
}
if(isset($_GET['act']))
{
   $act=$_GET['act'];
   if ($act=="hapus")
   {
       $kode=$_GET["kd"];
	   
	   $result = mysql_query("DELETE FROM master_kode_kp WHERE id=$kode");
	   
	   if($result)
  	   {
	    ?>
			<script language="JavaScript">
	          document.location="umum_master_kode_kp.php?pesan=<?=$pesan?>&offset=<? if (isset($_GET["offset"])) echo $_GET["offset"];?>&go=<? if (isset($_GET["go"])) echo $_GET["go"];?>";
         	</script>
	    <? 
	   }
	   else
	   {
		  //echo("<br><strong>Data gagal di hapus !!!</strong>");
		  ?>
	    <script language="JavaScript">
	    <!--
	        alert ("Maaf, Data GAGAL DIHAPUS !!!\n Tidak Ada Perubahan terhadap Database.");
			history.go(-1);
        //-->
        </script>
	    <?   
	   }
   }
}
?>
</font> 
</body>
</html>