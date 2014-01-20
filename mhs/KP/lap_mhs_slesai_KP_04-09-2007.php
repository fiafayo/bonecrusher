<?php
/* 
   DATE CREATED : 26/07/07
   KEGUNAAN     : MENAMPILKAN SURAT PERMOHONAN KP
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

// CEK AUTHENTIFIKASI USER
//if (!f_authenticate_user($USERNAME,$PASSWORD,$LOGGED))
//{
//	header("Location:http://".$HOSTNAME."/login.htm");
//	exit();
//}
f_connecting();
mysql_select_db($DB);
?>
<html>
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<body class="body">
<?php

if ($mode=="" || $mode=="0") 
{
?>
<br>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN 
    ~</strong> MAHASISWA SELESAI KP</font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form>
  <table width="100%" align="center" class="body" >
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="11%" nowrap>&nbsp;</td> 
      <td width="18%" nowrap>NRP </td>
      <td width="2%"><div align="center"><strong>:</strong></div></td>
      <td width="69%"><input name="frm_NRP" type="text" class="tekboxku" id="frm_NRP" size="10" maxlength="7"></td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td></td> 
      <td></td>
      <td><input type="hidden" name="mode" id="mode" value="2"><input type="hidden" name="frm_s_jum_data" id="frm_s_jum_data" value="10"></td>
      <td><input type="submit" value="Proses"  class="tombol"></td>
    </tr>
  </table>
</form>
<?
}
else
{
// JIKA MODE<>0 MAKSUDNYA JIKA FORM DI SUBMIT MAKA KELUAR LAPORAN
/*$sql="select ta.*,
			 master_karyawan.id as id_karyawan
	  from ta, master_karyawan
	  where (ta.id_dosen1=master_karyawan.id or ta.id_dosen1=master_karyawan.kode) ";*/
	        
$sql="SELECT  `daftar_kp`.`NO_MOHON`,
			  `daftar_kp`.`UR_MOHON`,
			  `daftar_kp`.`KODE_KP`,
			  `daftar_kp`.`NRP_1`,
			  `daftar_kp`.`NRP_2`,
			  `daftar_kp`.`NRP_3`,
			  `daftar_kp`.`NRP_4`,
			  `daftar_kp`.`NRP_5`,
			  `daftar_kp`.`NA_PERUSH`,
			  `daftar_kp`.`JALAN`,
			  `daftar_kp`.`KOTA`,
			   DATE_FORMAT(`daftar_kp`.`TGL_AWAL`,'%d/%m/%Y') as TGL_AWAL,
			   DATE_FORMAT(`daftar_kp`.`TGL_END`,'%d/%m/%Y') as TGL_END,
			   DATE_FORMAT(`daftar_kp`.`TGL_MOHON`,'%d/%m/%Y') as TGL_MOHON,
			  `daftar_kp`.`NO_ST`,
			  `daftar_kp`.`UR_ST`,
			  `daftar_kp`.`DOSEN`,
			  `daftar_kp`.`PEM_PERUS`,
			   DATE_FORMAT(`daftar_kp`.`TGL_ST`,'%d/%m/%Y') as TGL_ST,
			  `daftar_kp`.`NO_NKP`,
			  `daftar_kp`.`UR_NKP`,
			  `daftar_kp`.`TGL_NKP`,
			  `daftar_kp`.`HONOR`,
			  `daftar_kp`.`STATUS`
		FROM  daftar_kp 
		WHERE (`daftar_kp`.`NRP_1` LIKE '".$frm_NRP."%' or `daftar_kp`.`NRP_2` LIKE '".$frm_NRP."%' or
		      `daftar_kp`.`NRP_3` LIKE '".$frm_NRP."%' or `daftar_kp`.`NRP_4` LIKE '".$frm_NRP."%' or
			  `daftar_kp`.`NRP_5` LIKE '".$frm_NRP."%') and `daftar_kp`.`status`='S1'";
		//WHERE `daftar_kp`.`NO_MOHON`='".$frm_no_SP_KP."')";
	  
//if ($mode=="2" || $mode=="3" || $mode=="4")
//{
// PROSES UNTUK SEARCH (MODE=2)

	/*if ($frm_s_tgl_mulai1!="" || $frm_s_tgl_mulai2!="")
	{  
		if($frm_s_tgl_mulai1!="" && $frm_s_tgl_mulai2!="")
		{ $sql=$sql." and ta.tanggal_mulai between '".datetomysql($frm_s_tgl_mulai1)."' and '".datetomysql($frm_s_tgl_mulai2)."'"; }
		else
		{
			if($frm_s_tgl_mulai1!="")
			{ $sql=$sql." and ta.tanggal_mulai>='".datetomysql($frm_s_tgl_mulai1)."'"; }
			if($frm_s_tgl_mulai2!="")
			{ $sql=$sql." and ta.tanggal_mulai<='".datetomysql($frm_s_tgl_mulai2)."'"; }
		}
	}
	if ($frm_s_tgl_selesai1!="" || $frm_s_tgl_selesai2!="")
	{  
		if($frm_s_tgl_selesai1!="" && $frm_s_tgl_selesai2!="")
		{ $sql=$sql." and ta.tanggal_selesai between '".datetomysql($frm_s_tgl_selesai1)."' and '".datetomysql($frm_s_tgl_selesai2)."'"; }
		else
		{
			if($frm_s_tgl_selesai1!="")
			{ $sql=$sql." and ta.tanggal_selesai>='".datetomysql($frm_s_tgl_selesai1)."'"; }
			if($frm_s_tgl_selesai2!="")
			{ $sql=$sql." and ta.tanggal_selesai<='".datetomysql($frm_s_tgl_selesai2)."'"; }
		}
	}
	
	if ($frm_s_nomor_surat!="")
	{ $sql=$sql." and ta.no_surat_tugas like '%".$frm_s_nomor_surat."%'"; } 
	if ($frm_s_judul!="")
	{ $sql=$sql." and ta.judul like '%".$frm_s_judul."%'"; } */
	
	
//echo "<br>SQL= ".$sql;
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
//}

// UNTUK PAGING --------------------------------
if ($mode=="2")
{
$result=@mysql_query($sql);
$maxrows=mysql_num_rows($result);				
if($hal=="") { $hal=1; }
$recke=(($hal-1)*$frm_s_jum_data);
$limit="$recke,$frm_s_jum_data";
$jumhal=ceil($maxrows/$frm_s_jum_data);


$vlink="lap_mhs_slesai_KP.php";
$abc="?mode=2&frm_no_SP_KP=$frm_no_SP_KP&frm_s_jum_data=$frm_s_jum_data";

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
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN 
      ~</strong> </font><font color="#006699"><font color="#0099CC" size="1">MAHASISWA SELESAI KP</font></font></font> </td>
    <td width="11%"><div align="center"></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<br>
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div><br>
<?

if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="lap_mhs_slesai_KP.php">
<input type="hidden" name="mode" id="mode" value="3">
<input type="hidden" name="frm_NRP" id="frm_NRP" value="<?php echo $frm_NRP; ?>">

<?
}
if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=lap_mhs_slesai_KP.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}
if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
	<table width="100%" border="1" cellpadding="0" cellspacing="0">
<?

$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
?>
		<tr><td>
		<table width="100%">
			<tr>
				<td width=18%>No.</td>
				<td width="1%">:</td>
				<td width="81%"><? echo ($hal-1)*$frm_s_jum_data+$a; ?></td>
			</tr>
			<tr>
			  <td nowrap>No Surat Permohonan KP </td>
			  <td>:</td>
			  <td><? echo $row["NO_MOHON"]; ?></td>
		  </tr>
			<tr>
			  <td nowrap>Kode KP</td>
			  <td>:</td>
			  <td><? echo $row["KODE_KP"]; ?></td>
		  </tr>
			<tr>
			  <td valign=top>Tgl. Surat Permohonan</td>
			  <td valign=top>:</td>
			  <td><? echo $row["TGL_MOHON"]; ?></td>
		  </tr>
			<tr>
				<td valign=top>NRP</td>
				<td valign=top>:</td>
				<td><? echo $row["NRP_1"]; ?></td>
			</tr>
			<tr>
				<td nowrap>Kerja Praktek di </td>
				<td>:</td>
				<td><? echo $row["NA_PERUSH"];?>			
				</td>
			</tr>
			<tr>
			  <td>Jalan</td>
			  <td>:</td>
			  <td><? echo $row["JALAN"]; ?></td>
		  </tr>
			<tr>
			  <td>Kota</td>
			  <td>:</td>
			  <td><? echo $row["KOTA"]; ?></td>
		  </tr>
			<tr>
			  <td>Dosen Pembimbing </td>
			  <td>:</td>
			  <td><? echo $row["DOSEN"]; ?></td>
		  </tr>
			<tr>
			  <td>Pembimbing Perusahaan </td>
			  <td>:</td>
			  <td><? echo $row["PEM_PERUS"]; ?></td>
		  </tr>
			<tr>
			  <td>Tgl. Mulai KP </td>
			  <td>:</td>
			  <td><? echo $row["TGL_AWAL"]; ?></td>
		  </tr>
			<tr>
			  <td>Tgl. Selesai KP </td>
			  <td>:</td>
			  <td><? echo $row["TGL_END"]; ?></td>
		  </tr>
			<tr>
			  <td>Nomor Surat Tugas KP</td>
			  <td>:</td>
			  <td><? echo $row["NO_ST"]; ?></td>
		  </tr>
			<tr>
			  <td>Tgl. Surat Tugas KP </td>
			  <td>:</td>
			  <td><? echo $row["TGL_ST"]; ?></td>
		  </tr>
		</table>
		<br>
		</td>
		</tr>
<?
}
?>
<tr><td>
  
   <input name="excel"   type="image" onClick="document.fexcel.action='mhs_2_13_export.php?t=excel'" src="../../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
   Export ke File Excel&nbsp;
    <input name="printer" type="image"  onClick="document.fexcel.action='mhs_2_13_export.php?t=printer'" src="../../img/print.gif" align="bottom" width="18" height="18"> 
    Print

</td></tr>
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