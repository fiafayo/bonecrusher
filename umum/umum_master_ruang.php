<? 
/* 
   DATE CREATED : 13/12/07 - RAHADI
   KEGUNAAN     : MASTER RUANG
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
$filename = "umum_master_ruang.php"; // name of this file 
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
$off_sql = mysql_query ("SELECT * FROM master_ruang") or die ("Error in query: $off_sql".mysql_error()); 
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

$sql = mysql_query ("SELECT * FROM master_ruang ORDER BY id ASC LIMIT $limit") or die ("Error in query: $sql".mysql_error()); 

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
        <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>SETTING ~</strong> MASTER RUANG </font></font> </td>
        <td width="9%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">UMUM</font></strong></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><hr size="1" color="#FF9900"></td>
  </tr>
</table>
<table width="5%" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#FF9900">
	  <tr> 
		<td bgcolor="#AAAAAA" onMouseOver="style.background='#CCCCCC'" onMouseOut="style.background='#AAAAAA'"><div align="center"><font size="1"><a href="umum_master_ruang_add.php">Tambah</a></font></div></td>
	  </tr>
</table><br><br>
<?
if (mysql_num_rows($sql)<>0)
{
?>
<form name="formSatu" id="formSatu">
  <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#999999" align="left" class="table">
    <tr bgcolor="#F0F9FF"> 
      <td width="106"><div align="center"><font size="1"><strong>KODE</strong></font></div></td>
      <td width="343"><div align="center"><font size="1"><strong>NAMA</strong></font></div></td>
      <td width="301"><div align="center"><font size="1"><strong>JENIS RUANG</strong></font></div></td>
      <td width="150"><div align="center"><font size="1"><strong>KAPASITAS</strong></font></div></td>
      <td width="150"><div align="center"><font size="1"><strong>PROJECTOR</strong></font></div></td>
      <td width="150"><div align="center"><font size="1"><strong>COMPUTER</strong></font></div></td>
      <td width="150"><div align="center"><font size="1"><strong>MIC</strong></font></div></td>
      <td width="150"><div align="center"><font size="1"><strong>SPEAKER</strong></font></div></td>
      <td width="25" bgcolor="#CCCCCC"> <div align="center"><font color="#000000" size="1"><strong>Ubah</strong></font></div></td>
      <td width="33" bgcolor="#CCCCCC"> <div align="center"><font color="#000000" size="1"><strong>Hapus</strong></font></div></td>
    </tr>
    <?
  while($row=mysql_fetch_array($sql)) {?>
    <tr bgcolor="#FFFFFF" onMouseOver="style.background='#D2E8F2'" onMouseOut="style.background='#FFFFFF'"> 
      <td nowrap><font size="1"><? echo $row["kode"];?></font></td>
      <td nowrap><font size="1"><? echo $row['nama'];?></font></td>
      <td nowrap><font size="1">
        <?  switch ($row['tipe']) {
				case 'R':
					$jenis_ruang='Ruang';
					break;
				case 'L':
					$jenis_ruang='Laboratorium';
					break;
			}
			 echo $jenis_ruang;
		?>
        </font></td>
      <td align="center" nowrap><font size="1"><? echo $row['kapasitas'];?></font></td>
      <td align="center" nowrap>
	  	<font size="1">
			<? if ($row['LCD']=="Y") {
			   		echo "ADA";
			   }
			   else
			   {
			    	echo "TIDAK ADA";
			   }
			
			?>
	  </font>	  </td>
      <td align="center" nowrap><font size="1">
        <? if ($row['komputer']=="Y") {
			   		echo "ADA";
			   }
			   else
			   {
			    	echo "TIDAK ADA";
			   }
			
			?>
      </font></td>
      <td align="center" nowrap><font size="1">
        <? if ($row['mic']=="Y") {
			   		echo "ADA";
			   }
			   else
			   {
			    	echo "TIDAK ADA";
			   }
			
			?>
      </font></td>
      <td align="center" nowrap><font size="1">
        <? if ($row['speaker']=="Y") {
			   		echo "ADA";
			   }
			   else
			   {
			    	echo "TIDAK ADA";
			   }
			
			?>
      </font></td>
      <td><div align="center"><font size="1"><a href="umum_master_ruang_ubah.php?kd=<?=$row['id']?>&offset=<? if (isset($_GET["offset"])) echo $_GET["offset"];?>&go=<? if (isset($_GET["go"])) echo $_GET["go"];?>"><img src="../img/edit.png" width="13" height="13" border="0"></a></font></div></td>
      <td><div align="center"><font size="1"><a href="umum_master_ruang.php?act=hapus&kd=<?=$row['id']?>&offset=<? if (isset($_GET["offset"])) echo $_GET["offset"];?>&go=<? if (isset($_GET["go"])) echo $_GET["go"];?>" onClick="return konfirmasiHapus();"><img src="../img/hapus.png" width="11" height="13" border="0"></a></font></div></td>
    </tr>
    <? }?>
    <tr bgcolor="#F0F9FF"> 
      <td height="25" colspan="10"> 
	  <table width="5%" border="1" align="right" cellpadding="0" cellspacing="0" bordercolor="#FF9900">
          <tr> 
            <td bgcolor="#AAAAAA" onMouseOver="style.background='#CCCCCC'" onMouseOut="style.background='#AAAAAA'"><div align="center"><font size="1"><a href="umum_master_ruang_add.php">Tambah</a></font></div></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
  <? /*
echo "<br/>\r\n"; 
if ($off <> 1) { 
$prev = $off - 1; 
echo "&laquo; <a href=\"$filename?mn=3&act=lihat&offset=$prev&amp;go=$go\">prev</a> \r\n"; 
} 
for ($i = 1; $i <= $off_pag; $i ++) { 
if ($i == $off) { 
echo "[<b>$i</b>] \r\n"; 
} else { 
echo " <a href=\"$filename?mn=3&act=lihat&offset=$i&amp;go=$go\">$i</a>  \r\n"; 
} 
} 
if ($off < $off_pag) { 
$next = $off + 1; 
echo "<a href=\"$filename?mn=3&act=lihat&offset=$next&amp;go=$go\">next</a> &raquo; \r\n"; 
} 
echo "<br /><br />\r\n";*/
?>
<?
}
else
{
?>
<table width="70%" border="0" align="center" cellpadding="0" cellspacing="5">
  <tr> 
    <td><div align="center"><img src="../images/folder_announce_new.gif" width="19" height="18" align="absbottom"> 
        <font color="#FF0000" size="2">Data Ruang masih kosong di dalam Database.</font></div></td>
  </tr>
  <tr> 
    <td><div align="center"><font size="1">
	<a href="umum_master_ruang_add.php">Tambah Data Ruang</a>&nbsp;</font></div></td>
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
	   
	   $result = mysql_query("delete from master_ruang where id=$kode");
	   
	   if($result)
  	   {
	    ?>
			<script language="JavaScript">
	          document.location="umum_master_ruang.php?offset=<? if (isset($_GET["offset"])) echo $_GET["offset"];?>&go=<? if (isset($_GET["go"])) echo $_GET["go"];?>";
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
</body>
</html>