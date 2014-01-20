<? 
/* 
   DATE CREATED : 15/11/07 - RAHADI
   KEGUNAAN     : SETTING MAHASIWA AKTIF AJARAN
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
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<?
$filename = "umum_mhs_aktif.php"; // name of this file 
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
$off_sql = mysql_query ("SELECT * FROM mhs_aktif") or die ("Error in query: $off_sql".mysql_error()); 
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
//BEGIN URUT berdasarkan angkatan
$sort_angkatan=$_GET[sort];
if (isset($sort_angkatan)) {
$sql = mysql_query ("SELECT * FROM mhs_aktif ORDER BY angkatan ".$sort_angkatan." LIMIT $limit") or die ("Error in query: $sql".mysql_error()); 
}
else
{
$sql = mysql_query ("SELECT * FROM mhs_aktif ORDER BY angkatan DESC LIMIT $limit") or die ("Error in query: $sql".mysql_error()); 
}
//END URUT berdasarkan angkatan

$count=1;
?>
<body>
<font face="Verdana, Arial, Helvetica, sans-serif"> </font> 

<font face="Verdana, Arial, Helvetica, sans-serif"></font>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><hr size="1" color="#FF9900"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>SETTING ~</strong> MAHASISWA AKTIF </font></font> </td>
        <td width="9%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">UMUM</font></strong></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><hr size="1" color="#FF9900"></td>
  </tr>
</table>
<font face="Verdana, Arial, Helvetica, sans-serif"><br>
<?
if (mysql_num_rows($sql)<>0)
{
?>
<form name="formMhsAktif" id="formMhsAktif">
  <table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#999999" class="table">
    <tr bgcolor="#F0F9FF"> 
      <td width="334"> <div align="center"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>JURUSAN</strong></font></div></td>
      <td width="117"> 
	  <div align="center"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
	  <a href="umum_mhs_aktif.php?sort=asc" title="Urut kecil ke besar"><img src="../img/s_asc.png" width="10" height="10"></a>
	  <strong>
	  ANGKATAN
	  </strong></font>
	  <a href="umum_mhs_aktif.php?sort=desc" title="Urut besar ke kecil"><img src="../img/s_desc.png" width="10" height="10"></a>
	  </div>
	  </td>
      <td width="302"><div align="center"><font size="1"><strong>SEMESTER</strong></font></div></td>
      <td width="151"> <div align="center"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>JUMLAH MAHASISWA</strong></font></div></td>
      <td width="25"> <div align="center"><font color="#000000" size="1"><strong>Ubah</strong></font></div></td>
      <td width="30"> <div align="center"><font color="#000000" size="1"><strong>Hapus</strong></font></div></td>
    </tr>
	
    <?
  while($row=mysql_fetch_array($sql)) {?>
    <tr bgcolor="#FFFFFF" onMouseOver="style.background='#D2E8F2'" onMouseOut="style.background='#FFFFFF'"> 
      <td><font size="1"> 
        <?
			$result2 = mysql_query("select jurusan.jurusan as nama_jur,
										   mhs_aktif.id_jurusan
									from mhs_aktif, jurusan
									where mhs_aktif.id_jurusan=jurusan.id AND
										  mhs_aktif.id_jurusan=".$row['id_jurusan']."
									group by mhs_aktif.id_jurusan");
			$row2 = mysql_fetch_array($result2);
			 if ($row2)
			 {
				  echo $row2["nama_jur"];
			 }
		?>
        &nbsp;</font></td>
      <td><font size="1"> 
        <?=$row['angkatan']?>
        &nbsp;</font></td>
      <td><font size="1">
        <?
			/*$result2 = mysql_query("SELECT	tahun_ajar.id,
											tahun_ajar.tahun_ajaran,
											tahun_ajar.semester,
											tahun_ajar.awal,
											tahun_ajar.akhir
									FROM tahun_ajar, mhs_aktif
									WHERE mhs_aktif.periode='".$row['periode']."'");
			$row2 = mysql_fetch_array($result2);
			 if ($row2)
			 {
				  $tahun2=$row2["tahun_ajaran"]+1;
				  echo $row2["semester"]." ".$row2["tahun_ajaran"]."-".$tahun2;
			 }*/
			 $periode_semester=substr($row["periode"], 4,1); 
			 $periode_tahun=substr($row["periode"], 0,4); 
			 $periode_tahun2=$periode_tahun+1;
			 switch ($periode_semester) {
				case '1':
					$periode_text='GASAL';
					break;
				case '2':
					$periode_text='GENAP';
					break;
			}
			 echo $periode_text." ".$periode_tahun."-".$periode_tahun2;
		?>
        </font></td>
      <td align="center"><font size="1"> 
        <?=$row['jum_mhs']?>
        &nbsp;</font></td>
      <td><div align="center"><font size="1"><a href="umum_mhs_aktif_ubah.php?kd=<?=$row['idnya']?>&offset=<? if (isset($_GET["offset"])) echo $_GET["offset"];?>&go=<? if (isset($_GET["go"])) echo $_GET["go"];?>"><img src="../img/edit.png" width="13" height="13" border="0"></a></font></div></td>
      <td><div align="center"><font size="1"><a href="umum_mhs_aktif.php?act=hapus&kd=<?=$row['idnya']?>&offset=<? if (isset($_GET["offset"])) echo $_GET["offset"];?>&go=<? if (isset($_GET["go"])) echo $_GET["go"];?>" onClick="return konfirmasiHapus();"><img src="../img/hapus.png" width="11" height="13" border="0"></a></font></div></td>
    </tr>
    <? } //F0F9FF?>
    <tr bgcolor="#F0F9FF"> 
      <td height="25" colspan="6"> <table width="5%" border="1" align="right" cellpadding="0" cellspacing="0" bordercolor="#FF9900">
          <tr> 
            <td bgcolor="#AAAAAA" onMouseOver="style.background='#CCCCCC'" onMouseOut="style.background='#AAAAAA'"><div align="center"><font size="1"><a href="umum_mhs_aktif_add.php">Tambah</a></font></div></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
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
  </font></div>
<?
}
else
{
?>
<table width="70%" border="0" align="center" cellpadding="0" cellspacing="5">
  <tr> 
    <td><div align="center"><img src="../images/folder_announce_new.gif" width="19" height="18" align="absbottom"> 
        <font color="#FF0000" size="2">Tidak ada <font face="Verdana, Arial, Helvetica, sans-serif">D</font>ata 
        <font face="Verdana, Arial, Helvetica, sans-serif">Aksesoris</font> di 
        dalam Database</font>.</div></td>
  </tr>
  <tr> 
    <td><div align="center"><font size="1"><a href="ADMaksesoris_tambah.php">Tambah 
        Data <font face="Verdana, Arial, Helvetica, sans-serif">Aksesoris</font></a>&nbsp;</font></div></td>
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
	   
	   $result = mysql_query("delete from mhs_aktif where idnya=$kode");
	   
	   if($result)
  	   {
	    ?>
			<script language="JavaScript">
	          document.location="umum_mhs_aktif.php?offset=<? if (isset($_GET["offset"])) echo $_GET["offset"];?>&go=<? if (isset($_GET["go"])) echo $_GET["go"];?>";
         	</script>
	    <? 
	   }
	   else
	   {
		  //echo("<br><strong>Data gagal di hapus !!!</strong>");
		  ?>
	    <script language="JavaScript">
	    <!--
	        alert ("Maaf, Data GAGAL DIHAPUS !!!\n Tidak Ada Perubahan Terhadap Database.");
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