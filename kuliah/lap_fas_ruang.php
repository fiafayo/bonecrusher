<?php
/* 
   DATE CREATED : 12/12/07
   KEGUNAAN     : MENAMPILKAN LAPORAN FASILITAS RUANG
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
mysql_select_db($DB);
?>

<html>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<body class="body">

<?php
if ($mode=="" || $mode=="0") 
{
?>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#0099CC" size="1"><strong>LAPORAN~</strong>FASILITAS RUANG</font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">PERKULIAHAN</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form>
  <table width="100%" align="center" class="body">
    <tr>
      <td width="11%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="69%">&nbsp;</td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>Ruang</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
		<select name="frm_ruang" id="frm_ruang" class="tekboxku">
			<option value="all">Semua
			<?php
			$result2 = mysql_query("SELECT * FROM master_ruang order by kode ASC");
			while(($row2 = mysql_fetch_array($result2)))
			{
			  echo "<option value='".$row2["kode"]."'>".$row2["kode"]." - ".$row2["nama"];
			}
			?>
		</select>
	  </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>Kapasitas</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_kapasitas" type="text" class="tekboxku" id="frm_kapasitas" size="5" maxlength="5"></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>LCD projector </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
		<select name="frm_LCD" id="frm_LCD" class="tekboxku">
			<option value="all">Pilih</option>
			<option value="Y">Ada</option>
			<option value="T">Tidak</option>
		</select>
	  </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>Komputer</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <select name="frm_kom" id="frm_kom" class="tekboxku">
        <option value="all">Pilih</option>
		<option value="Y">Ada</option>
		<option value="T">Tidak</option>
      </select></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>Microphone</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <select name="frm_mic" id="frm_mic" class="tekboxku">
        <option value="all">Pilih</option>
		<option value="Y">Ada</option>
		<option value="T">Tidak</option>
      </select></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>Speaker</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <select name="frm_speaker" id="frm_speaker" class="tekboxku">
        <option value="all">Pilih</option>
		<option value="Y">Ada</option>
		<option value="T">Tidak</option>
      </select></td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td></td> 
      <td></td>
      <td><input type="hidden" name="mode" id="mode" value="2">
	      <input type="hidden" name="frm_s_jum_data" id="frm_s_jum_data" value="20"></td>
      <td><input type="submit" value="Proses"  class="tombol"></td>
    </tr>
  </table>
</form>
<?
}
else
{
// JIKA MODE<>0 MAKSUDNYA JIKA FORM DI SUBMIT MAKA KELUAR LAPORAN
$sekarang=date("Y-m-d");     
   
$sql="SELECT master_ruang.id,
			 master_ruang.kode,
			 master_ruang.nama,
			 master_ruang.tipe,
			 master_ruang.kapasitas,
			 master_ruang.luas, 
			 master_ruang.LCD,
			 master_ruang.komputer,
			 master_ruang.mic,
			 master_ruang.speaker
	    FROM master_ruang
	   WHERE `master_ruang`.`kode` <> 'NULL'";
	  
if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK cari -> MODE=2
	if ($frm_ruang!="all")
		{ $sql=$sql." and (`master_ruang`.`kode`='".$frm_ruang."')"; }
		
	if ($frm_kapasitas!="")
		{ $sql=$sql." and (`master_ruang`.`kapasitas` <= ".$frm_kapasitas.")"; }
	
	if ($frm_LCD!="all")
		{ $sql=$sql." and (`master_ruang`.`LCD`='".$frm_LCD."')"; }
	
	if ($frm_kom!="all")
		{ $sql=$sql." and (`master_ruang`.`komputer`='".$frm_kom."')"; }
		
	if ($frm_mic!="all")
		{ $sql=$sql." and (`master_ruang`.`mic`='".$frm_mic."')"; }
		
	if ($frm_speaker!="all")
		{ $sql=$sql." and (`master_ruang`.`speaker`='".$frm_speaker."')"; }
		
	
//echo "<br>SQL= ".$sql;
//exit();
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
}

// UNTUK PAGING --------------------------------
if ($mode=="2")
{
$result=@mysql_query($sql);
$maxrows=mysql_num_rows($result);				
if($hal=="") { $hal=1; }
$recke=(($hal-1)*$frm_s_jum_data);
$limit="$recke,$frm_s_jum_data";
$jumhal=ceil($maxrows/$frm_s_jum_data);


$vlink="lap_fas_ruang.php";
$abc="?mode=2&frm_ruang=$frm_ruang&frm_kapasitas=$frm_kapasitas&frm_LCD=$frm_LCD&frm_kom=$frm_kom&frm_mic=$frm_mic&frm_speaker=$frm_speaker&frm_s_jum_data=$frm_s_jum_data";

$vlink=$vlink.$abc;

$fontface="Verdana,Arial,Helvetica,sans-serif";
$fontsize="2";
}
// SELESAI MBULETNYA PAGING ------------------------------
// JIKA MODE HASIL LAPORAN DI MONITOR MAKA PAGING IN ACTION
if ($mode=="2") { $sql=$sql." limit ".$limit; }

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}
//---------------------------------
?>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#0099CC" size="1"><strong>LAPORAN 
    ~</strong>FASILITAS RUANG</font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">PERKULIAHAN</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div>
<?

if ($mode=="2")
{
?>
<form method="Post" name="fexcel" id="fexcel" ACTION="lap_fas_ruang.php">
<input type="hidden" name="mode" id="mode" value="3">
<input type="hidden" name="frm_ruang" id="frm_ruang" value="<?php echo $frm_ruang; ?>">
<input type="hidden" name="frm_kapasitas" id="frm_kapasitas" value="<? echo $frm_kapasitas?>">
<input type="hidden" name="frm_s_jum_data" id="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<input type="hidden" name="frm_LCD" id="frm_LCD" value="<?php echo $frm_LCD; ?>">
<input type="hidden" name="frm_kom" id="frm_kom" value="<?php echo $frm_kom; ?>">
<input type="hidden" name="frm_mic" id="frm_mic" value="<?php echo $frm_mic; ?>">
<input type="hidden" name="frm_speaker" id="frm_speaker" value="<?php echo $frm_speaker; ?>">

<?
}
if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=lap_fas_ruang.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}

if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }

?>
	<table width="100%"  border="1" cellspacing="0" cellpadding="5" class="table">
      <tr bgcolor="#C6E2FF">
        <td nowrap><strong>Kode Ruang </strong></td>
        <td nowrap><strong>Nama Ruang </strong></td>
        <td nowrap><strong>Kapasitas</strong></td>
        <td nowrap><strong>Luas</strong></td>
        <td nowrap><strong>LCD</strong></td>
        <td nowrap><strong>Komputer</strong></td>
        <td nowrap><strong>Microphone</strong></td>
        <td nowrap><strong>Speaker</strong></td>
      </tr>
<?
$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
?>
      <tr>
        <td nowrap valign="top"><? echo $row["kode"]; ?></td>
        <td nowrap valign="top"><? echo $row["nama"]; ?></td>
        <td nowrap valign="top"><? echo $row["kapasitas"]; ?></td>
        <td nowrap valign="top"><? echo $row["luas"]; ?></td>
        <td nowrap valign="top"><? echo $row["LCD"]; ?></td>
        <td nowrap valign="top"><? echo $row["komputer"]; ?></td>
        <td nowrap valign="top"><? echo $row["mic"]; ?></td>
        <td nowrap valign="top"><? echo $row["speaker"]; ?></td>
      </tr>
      <?
}
?>
    </table>
		<input name="excel"   type="image" onClick="document.fexcel.action='lap_fas_ruang_export.php?t=excel'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
		Export ke File Excel&nbsp;
		<input name="printer" type="image"  onClick="document.fexcel.action='lap_fas_ruang_export.php?t=printer'" src="../img/print.gif" align="bottom" width="18" height="18"> 
		Print
</FORM>
<?
}
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
</body>
</html>