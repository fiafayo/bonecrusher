<?php
/* 
   DATE CREATED : 08/04/08
   KEGUNAAN     : MENAMPILKAN JABATAN AKADEMIK DOSEN
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
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN 
      ~</strong> JABATAN AKADEMIK DOSEN</font></font> </td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">DOSEN</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form>
  <table width="80%" align="center" class="body" >
    <tr>
      <td width="26%">&nbsp;</td>
      <td width="3%">&nbsp;</td>
      <td width="71%">&nbsp;</td>
    </tr>
    <tr>
      <td>Jabatan Akademik </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
		<select name="frm_s_jab_akademik" id="frm_s_jab_akademik" class="tekboxku">
			<option value="lokal" selected>Lokal</option>
			<option value="kopertis">Kopertis</option>
		</select>
	  </td>
    </tr>
    <tr> 
      <td>NPK Dosen</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_s_kode_dosen" type="text" class="tekboxku" id="frm_s_kode_dosen" size="8" maxlength="6"></td>
    </tr>
    <tr>
      <td nowrap>Nama Dosen</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input type="text" name="frm_s_nama" id="frm_s_nama" class="tekboxku"></td>
    </tr>
    <tr> 
      <td nowrap><i>Banyak Data yang ditampilkan</i></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> <select name="frm_s_jum_data" id="frm_s_jum_data" class="tekboxku">
          <option value=10 selected>10</option> 
          <option value=20>20</option>
          <option value=50>50</option>
		  </select> </td>
    </tr>
    <tr> 
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td></td>
      <td><input type="hidden" name="mode" id="mode" value="2"></td>
      <td><input type="submit" value="Proses"  class="tombol"></td>
    </tr>
  </table>
</form>
<?
}
else
{
// JIKA MODE<>0 MAKSUDNYA JIKA FORM DI SUBMIT MAKA KELUAR LAPORAN

//DATE_FORMAT(riwayat_jabatan_lokal.tgl_terhitung,'%d/%m/%Y') as tgl_terhitung,

if ($frm_s_jab_akademik=='lokal')
{	        
	$sql="SELECT riwayat_jabatan_lokal.urut_id,
				 riwayat_jabatan_lokal.kode,
				 riwayat_jabatan_lokal.NPK,
				 riwayat_jabatan_lokal.NAMA,
				 riwayat_jabatan_lokal.golongan,
				 riwayat_jabatan_lokal.jabatan_lokal,
				 riwayat_jabatan_lokal.tgl_terhitung,
				 riwayat_jabatan_lokal.LEGALITAS
			FROM riwayat_jabatan_lokal
		   WHERE riwayat_jabatan_lokal.jabatan_lokal<>''";
		   
	if ($mode=="2" || $mode=="3" || $mode=="4")
	{
		if ($frm_s_kode_dosen!="")
		{
			 $sql .= " and (riwayat_jabatan_lokal.kode='".$frm_s_kode_dosen."')";
		}
		if ($frm_s_nama!="")
		{
			 $sql .= " and (riwayat_jabatan_lokal.NAMA LIKE '%".$frm_s_nama."%')";
		}
	}
	
}
else if ($frm_s_jab_akademik=='kopertis')
{
	$sql="SELECT riwayat_jabatan_kopertis.urut_id,
				 riwayat_jabatan_kopertis.kode,
				 riwayat_jabatan_kopertis.NPK,
				 riwayat_jabatan_kopertis.NAMA,
				 riwayat_jabatan_kopertis.golongan,
				 riwayat_jabatan_kopertis.jabatan_kopertis,
				 riwayat_jabatan_kopertis.tgl_terhitung,
				 riwayat_jabatan_kopertis.LEGALITAS
			FROM riwayat_jabatan_kopertis
		   WHERE riwayat_jabatan_kopertis.jabatan_kopertis<>'' ";
	
	if ($mode=="2" || $mode=="3" || $mode=="4")
	{
		if ($frm_s_kode_dosen!="")
		{
			 $sql .= " and (riwayat_jabatan_kopertis.kode='".$frm_s_kode_dosen."')";
		}
		if ($frm_s_nama!="")
		{
			 $sql .= " and (riwayat_jabatan_kopertis.NAMA LIKE '%".$frm_s_nama."%')";
		}
	}
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

$vlink="lap_riwayat_jabatan_akademik.php";
$abc="?mode=2&frm_s_kode_dosen=$frm_s_kode_dosen&frm_s_nama=$frm_s_nama&frm_s_jab_akademik=$frm_s_jab_akademik&frm_s_jum_data=$frm_s_jum_data";

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
      ~</strong> </font><font color="#006699"><font color="#0099CC" size="1">JABATAN AKADEMIK DOSEN</font></font> </td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">DOSEN</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div>
<?

if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="lap_riwayat_jabatan_akademik_export.php">
<input type="hidden" name="mode" value="3">
<input type="hidden" name="frm_s_jab_akademik" id="frm_s_jab_akademik" value="<?php echo $frm_s_jab_akademik; ?>">
<input type="hidden" name="frm_s_kode_dosen" id="frm_s_kode_dosen" value="<?php echo $frm_s_kode_dosen; ?>">
<input type="hidden" name="frm_s_nama" id="frm_s_nama" value="<?php echo $frm_s_nama; ?>">
<input type="hidden" name="frm_s_jum_data" id="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<?
}
if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=lap_riwayat_jabatan_akademik.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}
if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
	<table width="100%" border="1" cellpadding="5" cellspacing="0" class="table">
      <tr bgcolor="#C6E2FF">
        <td nowrap><strong>Kode</strong></td>
        <td nowrap><strong>NPK</strong></td>
        <td nowrap><strong>Nama</strong></td>
        <td nowrap><strong>Golongan</strong></td>
		<? if ($frm_s_jab_akademik=='lokal') {?>
        	<td nowrap><strong>Jabatan Lokal</strong></td>
		<? } 
		else if ($frm_s_jab_akademik=='kopertis')
		{?>
			<td nowrap><strong>Jabatan Kopertis</strong></td>
		<? }?>
        <td nowrap><strong>Tgl.Terhitung </strong></td>
        <td nowrap><strong>Legalitas</strong></td>
      </tr>
<?
while(($row = mysql_fetch_array($result)))
{
?>
      <tr>
        <td width=6% nowrap><? echo $row["kode"];?></td>
        <td width=4% nowrap><? echo $row["NPK"];?></td>
        <td width="4%" nowrap><? echo $row["NAMA"];?></td>
        <td width="5%" nowrap align="center"><? echo $row["golongan"];?></td>
		<? if ($frm_s_jab_akademik=='lokal') {?>
        	<td width="17%" nowrap><? echo $row["jabatan_lokal"];?></td>
		<? } 
		else if ($frm_s_jab_akademik=='kopertis')
		{?>
			<td width="17%" nowrap><? echo $row["jabatan_kopertis"];?></td>
		<? }?>
		
        <td width="28%" nowrap><? echo $row["tgl_terhitung"];?></td>
        <td width="17%" nowrap><? echo $row["LEGALITAS"];?></td>
      </tr>
<?
}
?>
      <tr>
        <td colspan="8" nowrap><input name="excel"   type="image" onClick="document.fexcel.action='lap_riwayat_jabatan_akademik_export.php?t=excel'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18">
      Export ke File Excel&nbsp;
      <input name="printer" type="image"  onClick="document.fexcel.action='lap_riwayat_jabatan_akademik_export.php?t=printer'" src="../img/print.gif" align="bottom" width="18" height="18">
      Print</td>
      </tr>
    </table>
</FORM>
<?
}
?>
<?
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
</body>
</html>