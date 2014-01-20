<?
/* 
   DATE CREATED : 03/04/08
   KEGUNAAN: MENAMPILKAN HASIL SCORE CARD FAKULTAS
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

?>
<html>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../include/tanggalan.js">
</script>
	<style type="text/css">
	<!--
	.style1 {
		font-size: 16px;
		font-weight: bold;
	}
	.style2 {font-size: 12px}
	a:link {
		color: #0000FF;
		text-decoration: none;
	}
	a:visited {
		color: #0000FF;
		text-decoration: none;
	}
	a:hover {
		color: #FF9900;
		text-decoration: underline;
	}
	a:active {
		color: #0000FF;
		text-decoration: none;
	}
.style3 {font-size: 10px}
	-->
	</style>
<body>
<?php
f_connecting();
mysql_select_db($DB);
//$mode=$_GET["mode"];
//echo "<br>--mode=".$mode;

if ($mode=="" || $mode=="0") 
{ ?>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN ~</strong> 
      SCORE CARD FAKULTAS </font></font></td>
    <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">SCORE CARD</font></strong></div></td>
  </tr>
</table>
<strong><font color="#0099CC" size="1"></font></strong> 
<hr size="1" color="#FF9900">
<form name="form_view_scard" id="form_view_scard" action="view_scard_fakultas.php">
  <table width="100%" class="body">
    <tr>
      <td width="9%">&nbsp;</td>
      <td width="19%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="70%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Periode</td>
      <td><strong>:</strong></td>
      <td>
	  <select name="frm_thn" id="frm_thn" class="tekboxku">
	  	<option value="2007">2007</option>
		<option value="2008">2008</option>
		<option value="2009">2009</option>
		<option value="2010">2010</option>
		<option value="2011">2011</option>
		<option value="2012">2012</option>
		<option value="2013">2013</option>
		<option value="2014">2014</option>
		<option value="2015">2015</option>
      </select>
	  </td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td></td> 
      <td></td>
      <td><input type="hidden" name="mode" id="mode" value="1"></td>
      <td><input type="submit" value="Proses" class="tombol"></td>
    </tr>
  </table>
</form>
<?
}
if ($mode=="1") 
{ 
// BEGIN NAMA DEKAN					  
  $sql_dek="SELECT nama FROM jabatan_struktural WHERE jabatan='Dekan'";
  $result_dek = mysql_query($sql_dek);
  if ($row_dek = mysql_fetch_array($result_dek)) {
      $nama_dekan=$row_dek["nama"];
	   //echo $nama_dekan;
  }
// END NAMA DEKAN


//JUMLAH DOSEN S-1
$result_s1 = mysql_query("SELECT count( * ) as jum_dsn_s1
						FROM `dosen`
					   WHERE `dosen`.`kode` LIKE '61%' AND
						     (`dosen`.`pendidikan_terakhir` = 'S1' or `dosen`.`pendidikan_terakhir` = '5')");
if ($row_s1 = mysql_fetch_array($result_s1)) {
  $jum_dsn_s1=$row_s1["jum_dsn_s1"];
 // echo "<br>jum_dsn_s1=".$jum_dsn_s1;
}
//END JUMLAH DOSEN S-1


//JUMLAH DOSEN S-2
$result_s2 = mysql_query("SELECT count( * ) as jum_dsn_s2
						FROM `dosen`
					   WHERE `dosen`.`kode` LIKE '61%' AND
						     (`dosen`.`pendidikan_terakhir` = 'S2' or `dosen`.`pendidikan_terakhir` = '6')");
if ($row_s2 = mysql_fetch_array($result_s2)) {
  $jum_dsn_s2=$row_s2["jum_dsn_s2"];
  //echo "<br>jum_dsn_s2=".$jum_dsn_s2;
}
//END JUMLAH DOSEN S-2

//JUMLAH DOSEN S-3 : JUMLAH DOSEN
$result_s3 = mysql_query("SELECT count( * ) as jum_dsn_s3
						   FROM `dosen`
					      WHERE `dosen`.`kode` LIKE '61%' AND
						       (`dosen`.`pendidikan_terakhir` = 'S3' or `dosen`.`pendidikan_terakhir` = '7')");
if ($row_s3 = mysql_fetch_array($result_s3)) {
  $jum_dsn_s3=$row_s3["jum_dsn_s3"];
 // echo "<br>jum_dsn_s3=".$jum_dsn_s3;
}
//END JUMLAH DOSEN S-3

//JUMLAH GURU BESAR
$result_GB = mysql_query("SELECT count( * ) as jum_dsn_GB
						   FROM `dosen`
					      WHERE `dosen`.`kode` LIKE '61%' AND
						       (`dosen`.`jab_akademik` LIKE 'Guru Besar%')");
if ($row_GB = mysql_fetch_array($result_GB)) {
  $jum_dsn_GB=$row_GB["jum_dsn_GB"];
  //echo "<br>jum_dsn_Guru besar=".$jum_dsn_GB;
}
//END JUMLAH GURU BESAR

//JUMLAH LEKTOR KEPALA
$result_LK = mysql_query("SELECT count( * ) as jum_dsn_LK
						   FROM `dosen`
					      WHERE `dosen`.`kode` LIKE '61%' AND
						       (`dosen`.`jab_akademik` LIKE 'Lektor Kepala%')");
if ($row_LK = mysql_fetch_array($result_LK)) {
  $jum_dsn_LK=$row_LK["jum_dsn_LK"];
  //echo "<br>jum_dsn_Lektor Kepala=".$jum_dsn_LK;
}
//END JUMLAH LEKTOR KEPALA

//JUMLAH LEKTOR
$result_LE = mysql_query("SELECT count( * ) as jum_dsn_LE
						   FROM `dosen`
					      WHERE `dosen`.`kode` LIKE '61%' AND
						       (`dosen`.`jab_akademik` LIKE 'Lektor-%')");
if ($row_LE = mysql_fetch_array($result_LE)) {
  $jum_dsn_LE=$row_LE["jum_dsn_LE"];
  //echo "<br>jum_dsn_Lektor=".$jum_dsn_LE;
}
//END JUMLAH LEKTOR

//JUMLAH ASISTEN AHLI
$result_AA = mysql_query("SELECT count( * ) as jum_dsn_AA
						   FROM `dosen`
					      WHERE `dosen`.`kode` LIKE '61%' AND
						       (`dosen`.`jab_akademik` LIKE 'Asisten Ahli%')");
if ($row_AA = mysql_fetch_array($result_AA)) {
  $jum_dsn_AA=$row_AA["jum_dsn_AA"];
  //echo "<br>jum_dsn_Asisten Ahli=".$jum_dsn_AA;
}
//END JUMLAH ASISTEN AHLI


//JUMLAH PRODI DAN PROGRAM
$result_prodi = mysql_query("SELECT count( * ) as jum_prodi
						   FROM `jurusan`
					      WHERE `jurusan`.`jurusan` LIKE 'PROGRAM STUDI%'");
if ($row_prodi = mysql_fetch_array($result_prodi)) {
  $jum_prodi=$row_prodi["jum_prodi"];
  //echo "<br>jum_PRODI=".$jum_prodi;
}  
  
$result_prog = mysql_query("SELECT count( * ) as jum_prog
						   FROM `jurusan`
					      WHERE `jurusan`.`jurusan` LIKE 'PROGRAM KEKHUSUSAN%'");
if ($row_prog = mysql_fetch_array($result_prog)) {
  $jum_prog=$row_prog["jum_prog"];
 // echo "<br>jum_PROGRAM=".$jum_prog;
}
//END JUMLAH PRODI DAN PROGRAM

//AKREDITASI PRODGRAM STUDI
$result_akredit_TE = mysql_query("SELECT akreditasi
						            FROM `jurusan`
					               WHERE `jurusan`.`id`='1'");
if ($row_akredit_TE = mysql_fetch_array($result_akredit_TE)) {
  $akreditasi_TE=$row_akredit_TE["akreditasi"];
  //echo "<br>akreditasi_TE=".$akreditasi_TE;
}  
  
$result_akredit_TK = mysql_query("SELECT akreditasi
						   FROM `jurusan`
					      WHERE `jurusan`.`id`='2'");
if ($row_akredit_TK = mysql_fetch_array($result_akredit_TK)) {
  $akreditasi_TK=$row_akredit_TK["akreditasi"];
  //echo "<br>akreditasi_TK=".$akreditasi_TK;
}  
  
$result_akredit_TI = mysql_query("SELECT akreditasi
						   FROM `jurusan`
					      WHERE `jurusan`.`id`='3'");
if ($row_akredit_TI = mysql_fetch_array($result_akredit_TI)) {
  $akreditasi_TI=$row_akredit_TI["akreditasi"];
  //echo "<br>akreditasi_TI=".$akreditasi_TI;
}  

$result_akredit_IF = mysql_query("SELECT akreditasi
						   FROM `jurusan`
					      WHERE `jurusan`.`id`='4'");
if ($row_akredit_IF = mysql_fetch_array($result_akredit_IF)) {
  $akreditasi_IF=$row_akredit_IF["akreditasi"];
  //echo "<br>akreditasi_IF=".$akreditasi_IF;
}


$result_akredit_TM = mysql_query("SELECT akreditasi
						   FROM `jurusan`
					      WHERE `jurusan`.`id`='5'");
if ($row_akredit_TM = mysql_fetch_array($result_akredit_TM)) {
  $akreditasi_TM=$row_akredit_TM["akreditasi"];
  //echo "<br>akreditasi_TM=".$akreditasi_TM;
}

//END AKREDITASI PRODGRAM STUDI

//JUMLAH MAHASISWA AKTIF PER PERIODE
$result_mhs_aktif = mysql_query("SELECT jum_mhs
						 FROM `mhs_aktif`
					    WHERE `mhs_aktif`.`angkatan`='$frm_thn'");
if ($row_mhs_aktif = mysql_fetch_array($result_mhs_aktif)) {
  $jum_mhs_aktif=$row_mhs_aktif["jum_mhs"];
  //echo "<br>jum_mhs_aktif=".$jum_mhs_aktif;
}
//END JUMLAH MAHASISWA AKTIF PER PERIODE

//JUMLAH TENAGA AKADEMIK
$result_tng_akademik = mysql_query("SELECT count( * ) as jum_tenaga_akademik
						              FROM `dosen`
					                 WHERE `dosen`.`kode` LIKE '61%'");
if ($row_tng_akademik = mysql_fetch_array($result_tng_akademik)) {
  $jum_tng_akademik = $row_tng_akademik["jum_tenaga_akademik"];
  //echo "<br>jum_tng_akademik=".$jum_tng_akademik;
  //echo "<br>jum_tng_akademik=";
}
//END JUMLAH TENAGA AKADEMIK

//JUMLAH LUAS RUANG KULIAH
$result_luas_r_kul = mysql_query("SELECT Sum(master_ruang.luas) as tot_r_kul
						            FROM `master_ruang`
					               WHERE `master_ruang`.`tipe` = 'R' AND
								         `master_ruang`.`nama` LIKE '%kuliah'");
if ($row_r_kul = mysql_fetch_array($result_luas_r_kul)) {
  $total_luas_r_kul = $row_r_kul["tot_r_kul"];
  //echo "<br>Total Luas ruang kuliah=".$total_luas_r_kul;
  //echo "<br>jum_tng_akademik=";
}
//END LUAS RUANG KULIAH

//JUMLAH LUAS RUANG DOSEN
$result_luas_r_dos = mysql_query("SELECT Sum(master_ruang.luas) as tot_r_dos
						            FROM `master_ruang`
					               WHERE `master_ruang`.`tipe` = 'R' AND
								         `master_ruang`.`nama` LIKE '%dosen%'");
if ($row_r_dos = mysql_fetch_array($result_luas_r_dos)) {
  $total_luas_r_dos = $row_r_dos["tot_r_dos"];
  //echo "<br>Total Luas ruang dosen=".$total_luas_r_dos;
  //echo "<br>jum_tng_akademik=";
}
//END LUAS RUANG DOSEN

//JUMLAH LUAS RUANG TATA USAHA
$result_luas_r_tu = mysql_query("SELECT Sum(master_ruang.luas) as tot_r_tu
						            FROM `master_ruang`
					               WHERE `master_ruang`.`nama` LIKE 'TU Fakultas%'");
if ($row_r_tu = mysql_fetch_array($result_luas_r_tu)) {
  $total_luas_r_tu = $row_r_tu["tot_r_tu"];
  //echo "<br>Total Luas ruang TU FT=".$total_luas_r_tu;
  //echo "<br>jum_tng_akademik=";
}
//END LUAS RUANG TATA USAHA


//JUMLAH TENAGA PENUNJANG AKADEMIK
$result_tng_PNJ_akademik = mysql_query("SELECT count(*) as jum_tng_PNJ
										  FROM master_karyawan, jabatan_akademik 
										 WHERE master_karyawan.id_jabatan=  jabatan_akademik.id and
										       jabatan_akademik.nama LIKE '%Laboran%'");
if ($row_tng_PNJ_akademik = mysql_fetch_array($result_tng_PNJ_akademik)) {
  $jum_tng_PNJ_akademik = $row_tng_PNJ_akademik["jum_tng_PNJ"];
  //echo "<br>jum_tng penunjang akademik=".$jum_tng_PNJ_akademik;
  //echo "<br>jum_tng_akademik=";
}
//END TENAGA PENUNJANG AKADEMIK

?>
<table width="95%"  border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td>&nbsp;      <div align="center" class="style1">SCORE CARD <br>
        FAKULTAS TEKNIK<br>
        <span class="style2">Tahun Akademik <? echo $frm_thn;?></span></div></td>
  </tr>
  <tr>
    <td><table width="100%"  border="1" cellspacing="0" cellpadding="5">
      <tr>
        <td bgcolor="#FFFFE8"><table width="80%"  border="0" align="center" cellpadding="3" cellspacing="0" bordercolor="#0000FF">
          <tr>
            <td width="31%">NAMA DEKAN</td>
            <td width="2%"><strong>:</strong></td>
            <td width="67%"><? echo $nama_dekan;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>JUMLAH DOSEN S1/S2/S3 </td>
            <td><strong>:</strong></td>
            <td><? echo $jum_dsn_s1." / ".$jum_dsn_s2." / ".$jum_dsn_s3; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td nowrap>DISTRIBUSI KEPANGKATAN DOSEN</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Guru besar </td>
            <td><strong>:</strong></td>
            <td><? echo $jum_dsn_GB;?></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Lektor Kepala </td>
            <td><strong>:</strong></td>
            <td><? echo $jum_dsn_LK;?></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Lektor</td>
            <td><strong>:</strong></td>
            <td><? echo $jum_dsn_LE;?></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Asisten Ahli </td>
            <td><strong>:</strong></td>
            <td><? echo $jum_dsn_AA;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>AKREDITASI PROGRAM STUDI</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Teknik Elektro </td>
            <td><strong>:</strong></td>
            <td><? echo $akreditasi_TE;?></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Teknik Kimia </td>
            <td><strong>:</strong></td>
            <td><? echo $akreditasi_TK;?></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Teknik Industri </td>
            <td><strong>:</strong></td>
            <td><? echo $akreditasi_TI;?></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Teknik Informatika </td>
            <td><strong>:</strong></td>
            <td><? echo $akreditasi_IF;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>JUMLAH PRODI DAN PROGRAM</td>
            <td><strong>:</strong></td>
            <td><? echo $jum_prodi." dan ".$jum_prog;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>JUMLAH MAHASISWA AKTIF</td>
            <td><strong>:</strong></td>
            <td>1936 orang<? // echo $jum_mhs_aktif;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>JUMLAH KARYAWAN</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Tenaga Akademik </td>
            <td><strong>:</strong></td>
            <td><? echo $jum_tng_akademik;?> orang</td>
          </tr>
          <tr>
            <td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;Tenaga Penunjang Akademik </td>
            <td><strong>:</strong></td>
            <td><? echo $jum_tng_PNJ_akademik;?> orang</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>LUAS RUANG</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Kelas</td>
            <td><strong>:</strong></td>
            <td><? //echo $total_luas_r_kul;?>2274 <span class="style3">m2</span></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Dosen</td>
            <td><strong>:</strong></td>
            <td><? //echo $total_luas_r_dos;?>1723 <span class="style3">m2</span></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Tata Usaha</td>
            <td><strong>:</strong></td>
            <td><? //echo $total_luas_r_tu;?>240 <span class="style3">m2</span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3">
              <input name="excel_1" id="excel_1" type="image" onClick="document.fexcel_1.action='view_scard_personal_1_export.php?t=excel'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18">
      Export ke File Excel
      <input name="printer_1" id="printer_1" type="image"  onClick="document.fexcel_1.action='view_scard_personal_1_export.php?t=printer'" src="../img/print.gif" align="bottom" width="18" height="18">
      Print </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<br>
<table width="80%"  border="0" align="center" cellpadding="1" cellspacing="0">
  <tr>
    <td width="81%"></td>
    <td width="19%" align="right">
	  <form name="form1" method="post" action="view_scard_fakultas.php">
	      <input type="hidden" name="frm_thn" id="frm_thn" value="<? echo $frm_thn;?>">
	      <input type="hidden" name="jum_dsn_s3" id="jum_dsn_s3" value="<? echo $jum_dsn_s3;?>">
		  <input type="hidden" name="jum_tng_akademik" id="jum_tng_akademik" value="<? echo $jum_tng_akademik;?>">
		  <input type="hidden" name="hasil_dsn_s3" id="hasil_dsn_s3" value="<? echo $hasil_dsn_s3;?>">
		  
		  <input type="hidden" name="mode" id="mode" value="2">
		  <input type="hidden" name="thn" id="thn" value="<? echo $frm_thn;?>">
		  <input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<? echo $frm_s_jurusan;?>">
 		  <input type="submit" name="Submit" id="Submit" value="Lanjut >>">
      </form>
    </td>
  </tr>
</table>
<br>
<br>
<br>
<? 
echo "<br>mode=".$mode;
}

if ($mode=="2") 
{
// LAPORAN YANG DIHASILKAN
?>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN 
      ~</strong> </font><font color="#006699"></font><font color="#0099CC" size="1">SCORE CARD FAKULTAS </font></font></td>
    <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">SCORE CARD</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div><br>
<?
/*if (mysql_num_rows($result)==0) {
    echo "<br><font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=score_card_dosen.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}*/


?>
	<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="score_card_dosen_export.php">
	<input type="hidden" name="mode" value="3">
	<input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
	<input type="hidden" name="frm_s_kode" id="frm_s_kode" value="<?php echo  $frm_s_kode;?>">
	<input type="hidden" name="frm_s_nama" id="frm_s_nama" value="<?php echo  $frm_s_nama;?>">
	<input type="hidden" name="frm_s_jum_data" id="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
	<input type="hidden" name="frm_o1" id="frm_o1" value="<?php echo $frm_o1; ?>">
	<input type="hidden" name="frm_o2" id="frm_o2" value="<?php echo $frm_o2; ?>">
	<input type="hidden" name="frm_o3" id="frm_o3" value="<?php echo $frm_o3; ?>">
<?
//if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }


//JUMLAH DOSEN S-3 : JUMLAH DOSEN
$result_s3 = mysql_query("SELECT count( * ) as jum_dsn_s3
						   FROM `dosen`
					      WHERE `dosen`.`kode` LIKE '61%' AND
						       (`dosen`.`pendidikan_terakhir` = 'S3' or `dosen`.`pendidikan_terakhir` = '7')");
if ($row_s3 = mysql_fetch_array($result_s3)) {
  $jum_dsn_s3=$row_s3["jum_dsn_s3"];
  //echo "<br>jum_dsn_s3=".$jum_dsn_s3;
}

$result = mysql_query("SELECT count( * ) as jum_dsn
						FROM `dosen`
					   WHERE `dosen`.`kode` LIKE '61%'");
if ($row = mysql_fetch_array($result)) {
  $jum_dsn=$row["jum_dsn"];
  $hasil_dsn_s3=$jum_dsn_s3/$jum_dsn;
}
//END JUMLAH DOSEN S-3 : JUMLAH DOSEN


//JUMLAH LAYANAN INDUSTRI
switch ($frm_thn) {
	case '2007':
		$tgl_1="2007-01-01";
		$tgl_2="2007-12-31";
		break;
	case '2008':
		$tgl_1="2008-01-01";
		$tgl_2="2008-12-31";
		break;
	case '2009':
		$tgl_1="2009-01-01";
		$tgl_2="2009-12-31";
		break;
	case '2010':
		$tgl_1="2010-01-01";
		$tgl_2="2010-12-31";
		break;
	case '2011':
		$tgl_1="2011-01-01";
		$tgl_2="2011-12-31";
		break;
	case '2012':
		$tgl_1="2012-01-01";
		$tgl_2="2012-12-31";
		break;
	case '2013':
		$tgl_1="2013-01-01";
		$tgl_2="2013-12-31";
		break;
	case '2014':
		$tgl_1="2014-01-01";
		$tgl_2="2014-12-31";
		break;
	case '2015':
		$tgl_1="2015-01-01";
		$tgl_2="2015-12-31";
		break;
	}

$result1 = mysql_query("SELECT count(*) as jum
						  FROM pengabdian
						 WHERE pengabdian.mulai between '".$tgl_1."' and '".$tgl_2."'");
if ($row1 = mysql_fetch_array($result1)) {
  $jum_layanan_industri=$row1["jum"];
  //echo "thn_layanan_industri=".$thn_layanan_industri;
}

//END JUMLAH LAYANAN INDUSTRI


//RATA-RATA IPK LULUSAN berdasarkan tahun
/*switch ($frm_thn) {
	case '2007':
		$tgl_1="2007-01-01";
		$tgl_2="2007-12-31";
		break;
	case '2008':
		$tgl_1="2008-01-01";
		$tgl_2="2008-12-31";
		break;
	case '2009':
		$tgl_1="2009-01-01";
		$tgl_2="2009-12-31";
		break;
	case '2010':
		$tgl_1="2010-01-01";
		$tgl_2="2010-12-31";
		break;
	case '2011':
		$tgl_1="2011-01-01";
		$tgl_2="2011-12-31";
		break;
	case '2012':
		$tgl_1="2012-01-01";
		$tgl_2="2012-12-31";
		break;
	case '2013':
		$tgl_1="2013-01-01";
		$tgl_2="2013-12-31";
		break;
	case '2014':
		$tgl_1="2014-01-01";
		$tgl_2="2014-12-31";
		break;
	case '2015':
		$tgl_1="2015-01-01";
		$tgl_2="2015-12-31";
		break;
	}*/

$result = mysql_query("SELECT avg(IPK_lulus) as rata
						  FROM master_alumni
						 WHERE master_alumni.tanggal_lulus between '".$tgl_1."' and '".$tgl_2."'");
if ($row = mysql_fetch_array($result)) {
  $rata_IPK_lulusan=$row["rata"];
 // echo "<br>~~~rata_IPK_lulusan=".$rata_IPK_lulusan;
}

//END RATA-RATA IPK LULUSAN berdasarkan tahun

// PERSENTASI LULUSAN DENGAN IPK >= 3,00
// WHERE master_alumni.tanggal_lulus between '2001-01-01' and '2001-12-31' AND
// WHERE master_alumni.tanggal_lulus between '".$tgl_1."' and '".$tgl_2."'
$result = mysql_query("SELECT count(*) as jum_mhs
						 FROM master_alumni
						WHERE master_alumni.tanggal_lulus between '2001-01-01' and '2001-12-31' AND
						      master_alumni.IPK_lulus >= 3.00");
if ($row = mysql_fetch_array($result)) {
  $jum_lulusan_IPK3=$row["jum_mhs"];
 // echo "<br>jum_lulusan_IPK3=".$jum_lulusan_IPK3;
}

$result = mysql_query("SELECT count(*) as jum_mhs
						 FROM master_alumni
						WHERE master_alumni.tanggal_lulus between '2001-01-01' and '2001-12-31'");
if ($row = mysql_fetch_array($result)) {
  $jum_lulusan_IPK=$row["jum_mhs"];
 // echo "<br>jum_lulusan_IPK=".$jum_lulusan_IPK;
  $persen_IPK3=($jum_lulusan_IPK3/$jum_lulusan_IPK)*100;
  // echo "<br>persen_IPK3=".$persen_IPK3;
}

//END PERSENTASI LULUSAN DENGAN IPK >= 3,00

// PERSENTASI LULUSAN DENGAN MASA STUDI <= 4 TAHUN
$result = mysql_query("SELECT count(*) as jum_mhs
						 FROM master_alumni
						WHERE master_alumni.tanggal_lulus between '2001-01-01' and '2001-12-31' AND
						      master_alumni.masa_studi <= 8");
if ($row = mysql_fetch_array($result)) {
  $jum_masa_studi4thn=$row["jum_mhs"];
  //echo "<br>jum_masa_studi4thn=".$jum_masa_studi4thn;
  $persen_studi4thn=($jum_masa_studi4thn/$jum_lulusan_IPK)*100;
  //echo "<br>persen_studi4thn=".$persen_studi4thn;
}
//END PERSENTASI LULUSAN DENGAN MASA STUDI <= 4 TAHUN

// PERSENTASI RATA-RATA GAJI PERTAMA ALUMNI
$result = mysql_query("SELECT avg(gaji.id) as rata
						 FROM master_alumni, gaji
						WHERE master_alumni.tanggal_lulus between '2001-01-01' and '2001-12-31' AND
						      master_alumni.gaji_pertama = gaji.id");
if ($row = mysql_fetch_array($result)) {
  $rata2_gaji_alumni=round($row["rata"]);
  //echo "<br>rata2_gaji_alumni=".$rata2_gaji_alumni;
		  $result2 = mysql_query("SELECT gaji
							 FROM gaji
							WHERE gaji.id=$rata2_gaji_alumni");
		if ($row2 = mysql_fetch_array($result2)) {
		  $rata2_gaji_alumni_riil=$row2["gaji"];
		  //echo "<br>rata2_gaji_alumni_riil=".$rata2_gaji_alumni_riil;
		}
}
//END RATA-RATA GAJI PERTAMA ALUMNI

// Rasio DO : mhs aktif
$result = mysql_query("SELECT jum_mhs_DO, jum_mhs_aktif
						 FROM do
						WHERE do.semester LIKE '".$frm_thn."%'");
if ($row = mysql_fetch_array($result)) {
  $jum_mhs_DO=$row["jum_kerjasama"];
 // echo "<br>jum_mhs_DO=".$jum_mhs_DO;
}
//END Rasio DO : mhs aktif

// Rasio PO : mhs aktif
$result = mysql_query("SELECT jum_mhs_PO, jum_mhs_aktif
						 FROM po
						WHERE po.semester LIKE '".$frm_thn."%'");
if ($row = mysql_fetch_array($result)) {
  $jum_mhs_PO=$row["jum_kerjasama"];
  //echo "<br>jum_mhs_PO=".$jum_mhs_PO;
}
//END Rasio PO : mhs aktif




// JUMLAH KERJASAMA DENGAN PIHAK LUAR
$result = mysql_query("SELECT count(*) as jum_kerjasama
						 FROM profil_kerjasama
						WHERE profil_kerjasama.mulai between '2001-01-01' and '2001-12-31'");
if ($row = mysql_fetch_array($result)) {
  $jum_kerjasama=$row["jum_kerjasama"];
  //echo "<br>jum_kerjasama=".$jum_kerjasama;
}
//END JUMLAH KERJASAMA DENGAN PIHAK LUAR




// RATA-RATA MASA TUNGGU DAPET KERJA - DATE_FORMAT(penelitian.tanggal_terbit,\"%d/%m/%Y\") as tanggal_terbit,

/*$result = mysql_query("SELECT master_alumni.nrp,
							  master_alumni.tanggal_lulus,
                              master_alumni.tanggal_mulai_kerja,
                              (To_days( tanggal_mulai_kerja ) - TO_DAYS( tanggal_lulus )) as difference
                         FROM master_alumni
                        WHERE (master_alumni.tanggal_lulus<>'0000-00-00' or master_alumni.tanggal_lulus<>NULL) and
	                          (master_alumni.tanggal_mulai_kerja<>'0000-00-00' or master_alumni.tanggal_mulai_kerja<>NULL)");
							  
							  avg(gaji.id) as rata 42,3402
							  */
							/*  
if ($row = mysql_fetch_array($result)) {
  $tgl_lulus=$row["tanggal_lulus"];
  $tgl_mulai_kerja=$row["tanggal_mulai_kerja"];
  function daysDifference($endDate, $beginDate)
	{
		//explode the date by "-" and storing to array
		$date_parts1=explode("-", $beginDate);
		$date_parts2=explode("-", $endDate);
		//gregoriantojd() Converts a Gregorian date to Julian Day Count
		$start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
		$end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
		return $end_date - $start_date;
	}
  $selisih = daysDifference($tgl_mulai_kerja, $tgl_lulus);
  echo "<br>tgl_lulus=".$tgl_lulus;
  echo "<br>tgl_mulai_kerja=".$tgl_mulai_kerja;
  echo "<br>SELISIH=".$selisih;
	
}
*/

// RATA-RATA MASA LAMA STUDI PADA TAHUN YG BERSANGKUTAN
/*$result = mysql_query("SELECT avg(IPK_lulus) as rata
						  FROM master_alumni
						 WHERE master_alumni.tanggal_lulus between '".$tgl_1."' and '".$tgl_2."'");
if ($row = mysql_fetch_array($result)) {
  $rata_IPK_lulusan=$row["rata"];
  echo "rata_IPK_lulusan=".$rata_IPK_lulusan;
}*/
// END RATA-RATA MASA LAMA STUDI PADA TAHUN YG BERSANGKUTAN

//RATA-RATA MASA TUNGGU DAPAT KERJA						 
$result = mysql_query("SELECT avg(To_days( tanggal_mulai_kerja ) - TO_DAYS( tanggal_lulus )) as rata_tunggu
                         FROM master_alumni
                        WHERE (master_alumni.tanggal_lulus<>'0000-00-00' or master_alumni.tanggal_lulus<>NULL) and
	                          (master_alumni.tanggal_mulai_kerja<>'0000-00-00' or master_alumni.tanggal_mulai_kerja<>NULL)");

if ($row = mysql_fetch_array($result)) {
  $rata_tunggu_kerja=round($row["rata_tunggu"]);
  //echo "<br>rata_tunggu_kerja=".$rata_tunggu_kerja;
	
}
//END RATA-RATA MASA TUNGGU DAPAT KERJA


// JUMLAH PENELITIAN PER TAHUN
$result_penil = mysql_query("SELECT count(*) as jum_penelitian
						 FROM penelitian
						WHERE penelitian.tanggal_mulai between '".$tgl_1."' and '".$tgl_2."'");
						
if ($row_penil = mysql_fetch_array($result_penil)) {
  $jum_penil=$row_penil["jum_penelitian"];
  //echo "<br>jum_penil=".$jum_penil;
}
//END JUMLAH PENELITIAN PER TAHUN

// JUMLAH PUBLIKASI JURNAL NASIONAL TERAKREDITASI PER TAHUN
$result_pub_status = mysql_query("SELECT id_pub, nama
						            FROM status_publikasi
								   WHERE status_publikasi.nama='Nasional'");
						
if ($row_pub_status = mysql_fetch_array($result_pub_status)) {
   $status_pub1=$row_pub_status["id_pub"];
   //echo "<br>status_pub1=".$status_pub1;
}

$result_pub_jurnal_nas = mysql_query("SELECT count(*) as jum_jurnal_nasional
						                FROM penelitian
						               WHERE penelitian.pub_tanggal between '".$tgl_1."' and '".$tgl_2."' AND
						                     penelitian.publikasi=$status_pub1");
						
if ($row_pub_jurnal_nas = mysql_fetch_array($result_pub_jurnal_nas)) {
  $jum_pub_jurnal_nas=$row_pub_jurnal_nas["jum_jurnal_nasional"];
  //echo "<br>jum_pub_jurnal_nas=".$jum_pub_jurnal_nas;
}
//END JUMLAH PUBLIKASI JURNAL NASIONAL TERAKREDITASI PER TAHUN


// JUMLAH PUBLIKASI JURNAL INTERNASIONAL TERAKREDITASI PER TAHUN
$result_pub_status = mysql_query("SELECT id_pub, nama
						            FROM status_publikasi
								   WHERE status_publikasi.nama='Internasional'");
						
if ($row_pub_status = mysql_fetch_array($result_pub_status)) {
   $status_pub1=$row_pub_status["id_pub"];
 
}

$result_pub_jurnal_inter = mysql_query("SELECT count(*) as jum_jurnal_internasional
						                FROM penelitian
						               WHERE penelitian.pub_tanggal between '".$tgl_1."' and '".$tgl_2."' AND
						                     penelitian.publikasi=$status_pub1");
						
if ($row_pub_jurnal_inter = mysql_fetch_array($result_pub_jurnal_inter)) {
  $jum_pub_jurnal_inter=$row_pub_jurnal_inter["jum_jurnal_internasional"];
  //echo "<br>jum_pub_jurnal_inter=".$jum_pub_jurnal_inter;
}
//END JUMLAH PUBLIKASI JURNAL INTERNASIONAL TERAKREDITASI PER TAHUN


// JUMLAH PUBLIKASI PROSIDING NASIONAL TERAKREDITASI PER TAHUN
$result_pub_status = mysql_query("SELECT id_pub, nama
						            FROM status_publikasi
								   WHERE status_publikasi.nama='Nasional'");
						
if ($row_pub_status = mysql_fetch_array($result_pub_status)) {
   $status_pub1=$row_pub_status["id_pub"];
}

$result_pub_prosiding_nas = mysql_query("SELECT count(*) as jum_prosiding_nasional
						                   FROM penelitian
						                  WHERE penelitian.pub_tanggal between '".$tgl_1."' and '".$tgl_2."' AND
						                        penelitian.publikasi=$status_pub1 AND penelitian.pub_ISBN<>''");
						
if ($row_pub_prosiding_nas = mysql_fetch_array($result_pub_prosiding_nas)) {
  $jum_pub_prosiding_nas=$row_pub_prosiding_nas["jum_prosiding_nasional"];
  //echo "<br>jum_row_pub_prosiding_nas=".$jum_pub_prosiding_nas;
}
//END JUMLAH PUBLIKASI PROSIDING NASIONAL TERAKREDITASI PER TAHUN


//JUMLAH PUBLIKASI PROSIDING INTERNASIONAL TERAKREDITASI PER TAHUN
$result_pub_status = mysql_query("SELECT id_pub, nama
						            FROM status_publikasi
								   WHERE status_publikasi.nama='Internasional'");
						
if ($row_pub_status = mysql_fetch_array($result_pub_status)) {
   $status_pub1=$row_pub_status["id_pub"];
 
}

$result_pub_prosiding_inter = mysql_query("SELECT count(*) as jum_prosiding_internasional
						                FROM penelitian
						               WHERE penelitian.pub_tanggal between '".$tgl_1."' and '".$tgl_2."' AND
						                     penelitian.publikasi=$status_pub1 AND penelitian.pub_ISBN<>''");
						
if ($row_pub_prosiding_inter = mysql_fetch_array($result_pub_prosiding_inter)) {
  $jum_pub_prosiding_inter=$row_pub_prosiding_inter["jum_prosiding_internasional"];
  //echo "<br>jum_pub_prosiding_inter=".$jum_pub_prosiding_inter;
}
//END JUMLAH PUBLIKASI PROSIDING INTERNASIONAL TERAKREDITASI PER TAHUN


// JUMLAH DANA PENELITIAN DARI PIHAK EXTERNAL
/*$result_dana_ext = mysql_query("SELECT Sum(penelitian.dana) as jum_dana_ext
						          FROM penelitian
								 WHERE penelitian.tanggal_mulai between '".$tgl_1."' and '".$tgl_2."' and
									   (penelitian.id_sumber_dana <> 1 or penelitian.id_sumber_dana <> 5)
							  GROUP BY penelitian.kode_pen");*/
							  
$result_dana_ext = mysql_query("SELECT sum(dana) AS jum_dana_ext
                                  FROM (SELECT penelitian.dana AS dana
                                          FROM penelitian 
                                         WHERE (penelitian.tanggal_mulai between '".$tgl_1."' and '".$tgl_2."') and
                                               (penelitian.id_sumber_dana <> 1 or penelitian.id_sumber_dana <> 5)
                                      GROUP BY penelitian.kode_pen) AS penelitian");
						
if ($row_dana_ext = mysql_fetch_array($result_dana_ext)) {
  $jum_dana_external=$row_dana_ext["jum_dana_ext"];
  /*echo "<br>->>>jum_dana_external=".$jum_dana_external;
  echo "<br>->>>tgl_1=".$tgl_1;
  echo "<br>->>>tgl_2=".$tgl_2;
  echo "<br>->>>frm_thn=".$frm_thn;
  */
}
//END JUMLAH DANA PENELITIAN DARI PIHAK EXTERNAL

// JUMLAH MAHASISWA BARU PER TAHUN
$result = mysql_query("SELECT sum(maharu.jum_mhs) as tot_maharu
						 FROM maharu
						WHERE maharu.angkatan = '".$frm_thn."'");
						
if ($row = mysql_fetch_array($result)) {
  $jum_mhs_perTahun=$row["tot_maharu"];
 // echo "<br>---jum_mhs_perTahun=".$jum_mhs_perTahun;
}

//END JUMLAH MAHASISWA BARU PER TAHUN

// Partisipasi mahasiswa dalam kegiatan ilmiah NASIONAL
$result_part_mhs_nas = mysql_query("SELECT count(*) as jum_part_mhs_nas
						          FROM prestasi, status_publikasi
						         WHERE (prestasi.tgl_kegiatan between '".$tgl_1."' and '".$tgl_2."') and
						               (prestasi.tingkat = status_publikasi.id_pub) AND 
									   status_publikasi.nama='Nasional'");
						
if ($row_part_mhs_nas = mysql_fetch_array($result_part_mhs_nas)) {
  $jum_part_mhs_nas=$row_part_mhs_nas["jum_part_mhs_nas"];
  //echo "<br>~~~jum_partisipasi MHS nasional=".$jum_part_mhs_nas;
}
// END Partisipasi mahasiswa dalam kegiatan ilmiah NASIONAL

// Partisipasi mahasiswa dalam kegiatan ilmiah INTERNASIONAL
$result_part_mhs_inter = mysql_query("SELECT count(*) as jum_part_mhs_inter
						          FROM prestasi, status_publikasi
						         WHERE (prestasi.tgl_kegiatan between '".$tgl_1."' and '".$tgl_2."') and
						               (prestasi.tingkat = status_publikasi.id_pub) AND 
									   status_publikasi.nama='Internasional'");
						
if ($row_part_mhs_inter = mysql_fetch_array($result_part_mhs_inter)) {
  $jum_part_mhs_inter=$row_part_mhs_inter["jum_part_mhs_inter"];
  //echo "<br>~~~jum_partisipasi MHS Internasional=".$jum_part_mhs_inter;
}
// END Partisipasi mahasiswa dalam kegiatan ilmiah INTERNASIONAL

// PRESTASI mahasiswa dalam kegiatan ilmiah NASIONAL
$result_pres_mhs_nas = mysql_query("SELECT count(*) as jum_pres_mhs_nas
						              FROM prestasi, status_publikasi
						             WHERE (prestasi.tgl_kegiatan between '".$tgl_1."' and '".$tgl_2."') and
						                   (prestasi.tingkat = status_publikasi.id_pub) AND 
									        status_publikasi.nama='Nasional' AND prestasi.hasil<>''");
						
if ($row_pres_mhs_nas = mysql_fetch_array($result_pres_mhs_nas)) {
  $jum_pres_mhs_nas=$row_pres_mhs_nas["jum_pres_mhs_nas"];
  //echo "<br>~~~jum_PRESTASI MHS nasional=".$jum_pres_mhs_nas;
}
// END PRESTASI mahasiswa dalam kegiatan ilmiah NASIONAL


// PRESTASI mahasiswa dalam kegiatan ilmiah INTERNASIONAL
$result_pres_mhs_inter = mysql_query("SELECT count(*) as jum_pres_mhs_inter
						          FROM prestasi, status_publikasi
						         WHERE (prestasi.tgl_kegiatan between '".$tgl_1."' and '".$tgl_2."') and
						               (prestasi.tingkat = status_publikasi.id_pub) AND 
									   status_publikasi.nama='Internasional' AND prestasi.hasil<>''");
						
if ($row_pres_mhs_inter = mysql_fetch_array($result_pres_mhs_inter)) {
  $jum_pres_mhs_inter=$row_pres_mhs_inter["jum_pres_mhs_inter"];
  //echo "<br>~~~jum_PRESTASI MHS Internasional=".$jum_pres_mhs_inter;
}
// END Partisipasi mahasiswa dalam kegiatan ilmiah INTERNASIONAL


// BEGIN TARGET SC FAK
$res_target_sc_fak = mysql_query("SELECT *
								    FROM sc_fak
								   WHERE tahun=$frm_thn");
				
						if ($row = mysql_fetch_array($res_target_sc_fak)) {
							$frm_exist=1;
							$frm_id_sc_fak=1;
							$frm_sc_fak_LD1=$row["LD1"];
							$frm_sc_fak_S1=$row["SUS1"];
							$frm_sc_fak_S2=$row["SUS2"];
							$frm_sc_fak_S3=$row["SUS3"];
							$frm_sc_fak_S4=$row["SUS4"];
							$frm_sc_fak_P1=$row["PRO1"];
							$frm_sc_fak_P2=$row["PRO2"];
							$frm_sc_fak_P3=$row["PRO3"];
							$frm_sc_fak_P4=$row["PRO4"];
							$frm_sc_fak_P5=$row["PRO5"];
							$frm_sc_fak_M1=$row["MAN1"];
							$frm_sc_fak_M2=$row["MAN2"];
							$frm_sc_fak_PN1=$row["PN1"];
						}
						else
						{
							$frm_exist=0;
							$frm_sc_fak_LD1=0;
							$frm_sc_fak_S1=0;
							$frm_sc_fak_S2=0;
							$frm_sc_fak_S3=0;
							$frm_sc_fak_S4=0;
							$frm_sc_fak_P1=0;
							$frm_sc_fak_P2=0;
							$frm_sc_fak_P3=0;
							$frm_sc_fak_P4=0;
							$frm_sc_fak_P5=0;
							$frm_sc_fak_M1=0;
							$frm_sc_fak_M2=0;
							$frm_sc_fak_PN1=0;
						}
// END TARGET SC FAK

?>
<strong><? echo "<br>Periode:".$_POST["thn"];?></strong>
<table width="95%"  border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><table width="84%"  border="1" align="center" cellpadding="3" cellspacing="0" class="table">
      <tr bgcolor="#C6E2FF">
        <td width="18" nowrap><strong>No</strong></td>
        <td width="393" nowrap><b>Nama KPI </b></td>
        <td width="80" nowrap><div align="center"><strong>Target</strong></div></td>
        <td width="68" nowrap><div align="center"><strong>Capaian</strong></div></td>
        <td width="76" nowrap><div align="center"><strong>% capaian </strong></div></td>
        <td width="95" nowrap><div align="center"><strong>Rata-rata <br>
        % capaian </strong></div></td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td colspan="6" valign="top" nowrap><em>Isu Strategis:</em> <strong>Learning &amp; Discovery </strong></td>
      </tr>
      <tr>
        <td nowrap valign="top">1</td>
        <td nowrap valign="top">Rata-rata indeks pembelajaran per jurusan (dosen tetap) </td>
        <td valign="top" nowrap><? echo $frm_sc_fak_LD1;?></td>
        <td valign="top" nowrap><? //echo $rata2_gaji_alumni_riil;?></td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td colspan="6" valign="top" nowrap><em>Isu Strategis:</em> <strong>Sustainability</strong> </td>
      </tr>
      <tr>
        <td nowrap valign="top">2</td>
        <td nowrap valign="top">Jumlah dana penelitian dari pihak eksternal</td>
        <td valign="top" nowrap><? echo $frm_sc_fak_S1;?></td>
        <td valign="top" nowrap><? echo $jum_dana_external;?></td>
        <td valign="top" nowrap>
		<?
		if ($frm_sc_fak_S1<>0) {
			echo ($jum_dana_external/$frm_sc_fak_S1)*100;
		}
		else
		{
		  echo "-";
		}
		?>
		</td>
        <td rowspan="4" valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td nowrap valign="top">3</td>
        <td nowrap valign="top">Produktivitas dana = income (revenue - direct cost) / <br>
            <img src="../img/sigma.gif" width="10" height="12" align="absbottom"> direct employe </td>
        <td valign="top" nowrap><? echo $frm_sc_fak_S2;?></td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        </tr>
      <tr>
        <td nowrap valign="top">4</td>
        <td nowrap valign="top">% non-tuition fee = revenue berbasis kegiatan <br>
      tri-dharma di luar tuition fee / <img src="../img/sigma.gif" width="10" height="12" align="absbottom"> revenue total </td>
        <td valign="top" nowrap><? echo $frm_sc_fak_S3;?></td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        </tr>
      <tr>
        <td nowrap valign="top">5</td>
        <td nowrap valign="top">Jumlah mahasiswa baru </td>
        <td valign="top" nowrap><? echo $frm_sc_fak_S4;?></td>
        <td valign="top" nowrap><? echo $jum_mhs_perTahun;?></td>
        <td valign="top" nowrap>
		<? 
		if ($frm_sc_fak_S4<>0) {
			echo ($jum_mhs_perTahun/$frm_sc_fak_S4)*100;
			//echo number_format(($jum_mhs_perTahun/$frm_sc_fak_S4)*100, 3,'.','');
		}
		else
		{
		  echo "-";
		}
		?>
		</td>
        </tr>
      <tr bgcolor="#CCCCCC">
        <td colspan="6" valign="top" nowrap><em>Isu Strategis:</em> <strong>Promotion</strong></td>
      </tr>
      <tr>
        <td nowrap valign="top">6</td>
        <td nowrap valign="top">Partisipasi mahasiswa dalam kegiatan ilmiah nasional</td>
        <td valign="top" nowrap><? echo $frm_sc_fak_P1;?></td>
        <td valign="top" nowrap><? echo $jum_part_mhs_nas;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_fak_P1<>0) {
			echo ($jum_part_mhs_nas/$frm_sc_fak_P1)*100;
			//echo number_format(($jum_mhs_perTahun/$frm_sc_fak_S4)*100, 3,'.','');
		}
		else
		{
		  echo "-";
		}
		?></td>
        <td rowspan="5" valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td nowrap valign="top">7</td>
        <td nowrap valign="top">Partisipasi mahasiswa dalam kegiatan ilmiah internasional</td>
        <td valign="top" nowrap><? echo $frm_sc_fak_P2;?></td>
        <td valign="top" nowrap><? echo $jum_part_mhs_inter;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_fak_P2<>0) {
			echo ($jum_part_mhs_inter/$frm_sc_fak_P2)*100;
			//echo number_format(($jum_mhs_perTahun/$frm_sc_fak_S4)*100, 3,'.','');
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">8</td>
        <td nowrap valign="top">Prestasi mahasiswa dalam kegiatan ilmiah nasional</td>
        <td valign="top" nowrap><? echo $frm_sc_fak_P3;?></td>
        <td valign="top" nowrap><? echo $jum_pres_mhs_nas;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_fak_P3<>0) {
			echo ($jum_pres_mhs_nas/$frm_sc_fak_P3)*100;
			//echo number_format(($jum_mhs_perTahun/$frm_sc_fak_S4)*100, 3,'.','');
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">9</td>
        <td valign="top" nowrap>Prestasi mahasiswa dalam kegiatan ilmiah internasional</td>
        <td valign="top" nowrap><? echo $frm_sc_fak_P4;?></td>
        <td valign="top" nowrap><? echo $jum_pres_mhs_inter;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_fak_P4<>0) {
			echo ($jum_pres_mhs_inter/$frm_sc_fak_P4)*100;
			//echo number_format(($jum_mhs_perTahun/$frm_sc_fak_S4)*100, 3,'.','');
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">10</td>
        <td nowrap valign="top">Jumlah publikasi karya mahasiswa dan dosen di media massa </td>
        <td valign="top" nowrap><? echo $frm_sc_fak_P5;?></td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        </tr>
      <tr bgcolor="#CCCCCC">
        <td colspan="6" valign="top" nowrap><em>Isu Strategis:</em> <strong>Management</strong> </td>
      </tr>
      <tr>
        <td nowrap valign="top">11</td>
        <td nowrap valign="top"><img src="../img/sigma.gif" width="10" height="12" align="absbottom"> dosen S3(<? echo $jum_dsn_s3;?>) : <img src="../img/sigma.gif" width="10" height="12" align="absbottom"> dosen(<? echo $jum_dsn;?>)</td>
        <td valign="top" nowrap><? echo $frm_sc_fak_M1;?></td>
        <td valign="top" nowrap><? echo number_format($hasil_dsn_s3, 3,'.','') ;?></td>
        <td valign="top" nowrap>
		<? 
		if ($frm_sc_fak_M1<>0) {
			echo number_format(($hasil_dsn_s3/$frm_sc_fak_M1)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?>
		</td>
        <td rowspan="2" valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td nowrap valign="top">12</td>
        <td nowrap valign="top">Tingkat kepuasan layanan administrasi</td>
        <td valign="top" nowrap><? echo $frm_sc_fak_M2;?></td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        </tr>
      <tr bgcolor="#CCCCCC">
        <td colspan="6" valign="top" nowrap><em>Isu Strategis: </em><strong>Partnership &amp; Networking </strong></td>
      </tr>
      <tr>
        <td nowrap valign="top">13</td>
        <td nowrap valign="top">Jumlah Kerjasama</td>
        <td valign="top" nowrap><? echo $frm_sc_fak_PN1;?></td>
        <td valign="top" nowrap><? echo $jum_kerjasama;?></td>
        <td valign="top" nowrap>
		<? 
		if ($frm_sc_fak_PN1<>0) {
			echo number_format(($jum_kerjasama/$frm_sc_fak_PN1)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?>
		</td>
        <td valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td nowrap valign="top">&nbsp;</td>
        <td nowrap valign="top">&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" valign="top" nowrap>Rata-rata % pencapaian keseluruhan </td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td nowrap valign="top">&nbsp;</td>
        <td nowrap valign="top">&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td colspan=6>
          <input name="excel" type="image" onClick="document.fexcel.action='score_card_dosen_export.php?t=excel'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18">
      Export ke File Excel
      <input name="printer" type="image"  onClick="document.fexcel.action='score_card_dosen_export.php?t=printer'" src="../img/print.gif" align="bottom" width="18" height="18">
      Print </td>
      </tr>
    </table></td>
  </tr>
</table>
    </FORM>
<table width="80%"  border="0" align="center" cellpadding="1" cellspacing="0">
  <tr>
    <td width="81%">
	  <form name="form1" method="post" action="view_scard_fakultas.php">
	      <input type="hidden" name="frm_thn" id="frm_thn" value="<? echo $frm_thn;?>">
		  <input type="hidden" name="mode" id="mode" value="1">
		  <input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<? echo $frm_s_jurusan;?>">
 		  <input type="submit" name="Submit" id="Submit" value="<< Sebelumnya">
      </form>
    </td>
    <td width="19%">&nbsp;</td>
  </tr>
</table>
<br>
<br>
<br>
<?
}

	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
	



?>		
</body>
</html>