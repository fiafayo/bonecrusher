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

//echo "<br>mode=".$mode;

if ($mode=="" || $mode=="0") 
{?>
<font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN ~</strong> 
      SCORE CARD JURUSAN</font></font></td>
    <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">SCORE CARD</font></strong></div></td>
  </tr>
</table>
<strong><font color="#0099CC" size="1"></font></strong> 
<hr size="1" color="#FF9900">
<form name="form_penelitian" id="form_penelitian" action="view_scard_jurusan.php">
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
	    <option value="2001">2001</option>
		<option value="2002">2002</option>
		<option value="2003">2003</option>
		<option value="2004">2004</option>
		<option value="2005">2005</option>
		<option value="2006">2006</option>
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
      <td>&nbsp;</td>
      <td>Jurusan</td>
      <td><strong>:</strong></td>
      <td>
	  <select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku">
        <option value="">Pilih
        <?php
				 $result2 = @mysql_query("SELECT * FROM `jurusan` WHERE `jurusan`.id>0 AND `jurusan`.id<6");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["id"].">".$row2["jurusan"];
	             }
         	?>
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
else if ($mode=="1") 
{ 
	if ($frm_s_jurusan=='')  
	{
		//$error = 1;
		$mode="";
		$pesan=$pesan."<br>Silahkan pilih jurusan terlebih dahulu !";
		?>
			<script language="JavaScript">
				document.location="view_scard_jurusan.php?mode0=&pesan=<? echo $pesan?>";
			</script>
		<?
	}

// BEGIN AKREDITASI JURUSAN					  
  $sql_akredit_jur="SELECT akreditasi, id FROM jurusan WHERE jurusan.id='$frm_s_jurusan'";
  $result_akredit_jur = mysql_query($sql_akredit_jur);
  if ($row_akredit_jur = mysql_fetch_array($result_akredit_jur)) {
      $frm_akredit_jur = $row_akredit_jur["akreditasi"];
	  $frm_jur_id = $row_akredit_jur["id"];
	  
	   //echo $nama_dekan;
  }
// END AKREDITASI JURUSAN


// BEGIN NAMA KETUA JURUSAN		
switch($frm_jur_id)
{
	case "1" :
		$sql_kajur="SELECT nama FROM jabatan_struktural WHERE jabatan LIKE '%Elektro'";
	break;

	case "2" :
		$sql_kajur="SELECT nama FROM jabatan_struktural WHERE jabatan LIKE '%Kimia'";
	break;

	case "3" :
		$sql_kajur="SELECT nama FROM jabatan_struktural WHERE jabatan LIKE '%Industri'";
	break;

	case "4" :
		$sql_kajur="SELECT nama FROM jabatan_struktural WHERE jabatan LIKE '%Informatika'";
	break;

	case "5" :
		$sql_kajur="SELECT nama FROM jabatan_struktural WHERE jabatan LIKE '%Manufaktur'";
	break;
}
					  
  $result_kajur = mysql_query($sql_kajur);
  if ($row_kajur = mysql_fetch_array($result_kajur)) {
      $nama_kajur=$row_kajur["nama"];
  }
// END NAMA KETUA JURUSAN

//JUMLAH DOSEN S-1
$result_s1 = mysql_query("SELECT count( * ) as jum_dsn_s1
						   FROM `dosen`
					      WHERE `dosen`.`kode` LIKE '61%' AND dosen.jurusan='$frm_s_jurusan' AND
						       (`dosen`.`pendidikan_terakhir` = 'S1' or `dosen`.`pendidikan_terakhir` = '5')");
if ($row_s1 = mysql_fetch_array($result_s1)) {
  $jum_dsn_s1=$row_s1["jum_dsn_s1"];
  //echo "<br>jum_dsn_s1=".$jum_dsn_s1;
}
//END JUMLAH DOSEN S-1

//JUMLAH DOSEN S-2
$result_s2 = mysql_query("SELECT count( * ) as jum_dsn_s2
						FROM `dosen`
					   WHERE `dosen`.`kode` LIKE '61%' AND dosen.jurusan='$frm_s_jurusan' AND
						     (`dosen`.`pendidikan_terakhir` = 'S2' or `dosen`.`pendidikan_terakhir` = '6')");
if ($row_s2 = mysql_fetch_array($result_s2)) {
  $jum_dsn_s2=$row_s2["jum_dsn_s2"];
  //echo "<br>jum_dsn_s2=".$jum_dsn_s2;
}
//END JUMLAH DOSEN S-2

//JUMLAH DOSEN S-3 : JUMLAH DOSEN
$result_s3 = mysql_query("SELECT count( * ) as jum_dsn_s3
						   FROM `dosen`
					      WHERE `dosen`.`kode` LIKE '61%' AND dosen.jurusan='$frm_s_jurusan' AND
						       (`dosen`.`pendidikan_terakhir` = 'S3' or `dosen`.`pendidikan_terakhir` = '7')");
if ($row_s3 = mysql_fetch_array($result_s3)) {
  $jum_dsn_s3=$row_s3["jum_dsn_s3"];
  
  //echo "<br>jum_dsn_s3=".$jum_dsn_s3;
}
//END JUMLAH DOSEN S-3

//JUMLAH GURU BESAR
$result_GB = mysql_query("SELECT count( * ) as jum_dsn_GB
						   FROM `dosen`
					      WHERE `dosen`.`kode` LIKE '61%' AND dosen.jurusan='$frm_s_jurusan' AND
						       (`dosen`.`jab_akademik` LIKE 'Guru Besar%')");
if ($row_GB = mysql_fetch_array($result_GB)) {
  $jum_dsn_GB=$row_GB["jum_dsn_GB"];
  //echo "<br>jum_dsn_Guru besar=".$jum_dsn_GB;
}
//END JUMLAH GURU BESAR

//JUMLAH LEKTOR KEPALA
$result_LK = mysql_query("SELECT count( * ) as jum_dsn_LK
						   FROM `dosen`
					      WHERE `dosen`.`kode` LIKE '61%' AND dosen.jurusan='$frm_s_jurusan' AND
						       (`dosen`.`jab_akademik` LIKE 'Lektor Kepala%')");
if ($row_LK = mysql_fetch_array($result_LK)) {
  $jum_dsn_LK=$row_LK["jum_dsn_LK"];
  //echo "<br>jum_dsn_Lektor Kepala=".$jum_dsn_LK;
}
//END JUMLAH LEKTOR KEPALA

//JUMLAH LEKTOR
$result_LE = mysql_query("SELECT count( * ) as jum_dsn_LE
						   FROM `dosen`
					      WHERE `dosen`.`kode` LIKE '61%' AND dosen.jurusan='$frm_s_jurusan' AND
						       (`dosen`.`jab_akademik` LIKE 'Lektor-%')");
if ($row_LE = mysql_fetch_array($result_LE)) {
  $jum_dsn_LE=$row_LE["jum_dsn_LE"];
  //echo "<br>jum_dsn_Lektor=".$jum_dsn_LE;
}
//END JUMLAH LEKTOR

//JUMLAH ASISTEN AHLI
$result_AA = mysql_query("SELECT count( * ) as jum_dsn_AA
						   FROM `dosen`
					      WHERE `dosen`.`kode` LIKE '61%' AND dosen.jurusan='$frm_s_jurusan' AND
						       (`dosen`.`jab_akademik` LIKE 'Asisten Ahli%')");
if ($row_AA = mysql_fetch_array($result_AA)) {
  $jum_dsn_AA=$row_AA["jum_dsn_AA"];
  //echo "<br>jum_dsn_Asisten Ahli=".$jum_dsn_AA;
}
//END JUMLAH ASISTEN AHLI


//JUMLAH MAHASISWA AKTIF

$result_mhs_aktif = mysql_query("SELECT jum_mhs, angkatan
						           FROM mhs_aktif
					              WHERE mhs_aktif.angkatan='$frm_thn' AND mhs_aktif.id_jurusan='$frm_s_jurusan'");
if ($row_mhs_aktif = mysql_fetch_array($result_mhs_aktif)) {
  $jum_mhs_aktif = $row_mhs_aktif["jum_mhs"];
  //echo "<br>####jum_mhs_aktif =".$jum_mhs_aktif;
}
//END JUMLAH MAHASISWA AKTIF

//JUMLAH LABORATORIUM
$result_jum_lab = mysql_query("SELECT count( * ) as jum_lab
						         FROM master_lab
					            WHERE master_lab.id_jurusan=$frm_s_jurusan");
if ($row_jum_lab = mysql_fetch_array($result_jum_lab)) {
  $jum_lab_jur = $row_jum_lab["jum_lab"];
  //echo "<br>jum_lab_jur =".$jum_lab_jur;
}
//END JUMLAH LABORATORIUM


//JUMLAH TENAGA AKADEMIK
$result_tng_akademik = mysql_query("SELECT count( * ) as jum_tenaga_akademik
						              FROM `dosen`
					                 WHERE `dosen`.`kode` LIKE '61%' AND dosen.jurusan=$frm_s_jurusan");
if ($row_tng_akademik = mysql_fetch_array($result_tng_akademik)) {
  $jum_tng_akademik = $row_tng_akademik["jum_tenaga_akademik"];
  $hasil_dsn_s3=$jum_dsn_s3/$jum_tng_akademik;
  //echo "<br>jum_tng_akademik=".$jum_tng_akademik;
  //echo "<br>jum_tng_akademik=";
}
//END JUMLAH TENAGA AKADEMIK

//JUMLAH TENAGA PENUNJANG AKADEMIK
$result_tng_PNJ_akademik = mysql_query("SELECT count(*) as jum_tng_PNJ
										  FROM master_karyawan, jabatan_akademik 
										 WHERE master_karyawan.id_jabatan=  jabatan_akademik.id and
										       jabatan_akademik.nama LIKE '%Laboran%' and
											   master_karyawan.jurusan=$frm_s_jurusan");
if ($row_tng_PNJ_akademik = mysql_fetch_array($result_tng_PNJ_akademik)) {
  $jum_tng_PNJ_akademik = $row_tng_PNJ_akademik["jum_tng_PNJ"];
  //echo "<br>jum_tng penunjang akademik=".$jum_tng_PNJ_akademik;
  //echo "<br>jum_tng_akademik=";
}
//END TENAGA PENUNJANG AKADEMIK

//JUMLAH LUAS RUANG KULIAH
$result_luas_r_kul = mysql_query("SELECT Sum(master_ruang.luas) as tot_r_kul
						            FROM `master_ruang`
					               WHERE `master_ruang`.`nama` LIKE 'R kuliah'");
if ($row_r_kul = mysql_fetch_array($result_luas_r_kul)) {
  $total_luas_r_kul = $row_r_kul["tot_r_kul"];
  //echo "<br>Total Luas ruang kuliah=".$total_luas_r_kul;
  //echo "<br>jum_tng_akademik=";
}
//END LUAS RUANG KULIAH

//JUMLAH LUAS RUANG DOSEN
$result_luas_r_dos = mysql_query("SELECT Sum(master_ruang.luas) as tot_r_dos
						            FROM `master_ruang`
					               WHERE `master_ruang`.`nama` LIKE 'R dosen%'");
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



?>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN ~</strong> 
      SCORE CARD JURUSAN</font></font></td>
    <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">SCORE CARD</font></strong></div></td>
  </tr>
</table>
<strong><font color="#0099CC" size="1"></font></strong> 
<hr size="1" color="#FF9900">
<FORM METHOD="Post" name="form_excel_1" id="form_excel_1" action="view_scard_jurusan_export1.php">

<table width="95%"  border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td>
	<?
			$sql_jur="SELECT jurusan as nama_jur
			            FROM jurusan
			           WHERE jurusan.id=$frm_s_jurusan";
		   $res_jur = @mysql_query($sql_jur);
		   $row_jur = @mysql_fetch_array($res_jur);
		    
	?>
      <div align="center" class="style1">SCORE CARD <br>
         <? 
		 $nama_jurusan = $row_jur["nama_jur"];
		 echo "JURUSAN ".$nama_jurusan;
		?><br>
        <span class="style2">Tahun Akademik &nbsp;<? echo $frm_thn;?></span> </div></td>
  </tr>
  <tr>
    <td><table width="100%"  border="1" cellspacing="0" cellpadding="5">
      <tr>
        <td bgcolor="#FFFFE8"><table width="80%"  border="0" align="center" cellpadding="3" cellspacing="0">
          <tr>
            <td>AKREDITASI</td>
            <td><strong>:</strong></td>
            <td><? echo $frm_akredit_jur;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="31%">NAMA KETUA JURUSAN </td>
            <td width="2%"><strong>:</strong></td>
            <td width="67%"><? echo $nama_kajur;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>JUMLAH DOSEN S1 | S2 | S3 </td>
            <td><strong>:</strong></td>
            <td><? echo $jum_dsn_s1." | ".$jum_dsn_s2." | ".$jum_dsn_s3;?></td>
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
            <td nowrap>JUMLAH PROGRAM DIBAWAH PRODI </td>
            <td><strong>:</strong></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>JUMLAH MAHASISWA AKTIF</td>
            <td><strong>:</strong></td>
            <td><? echo $jum_mhs_aktif;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>JUMLAH LABORATORIUM </td>
            <td><strong>:</strong></td>
            <td><? echo $jum_lab_jur;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
              <? $sql_lab = mysql_query ("SELECT master_lab.nama 
		                                    FROM master_lab
					                       WHERE master_lab.id_jurusan=$frm_s_jurusan ORDER BY id ASC") or die ("Error in query: $sql_lab".mysql_error()); ?>
              <table width="100%"  border="0" cellspacing="0" cellpadding="5">
                <? while($row_nama_lab=mysql_fetch_array($sql_lab)) {?>
                <tr>
                  <td>&#8226; <? echo $row_nama_lab["nama"];?></td>
                </tr>
                <? }?>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>JUMLAH KONSENTRASI </td>
            <td><strong>:</strong></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>KONSENTRASI ... </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>KONSENTRASI ... </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>KONSENTRASI ... </td>
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
            <td><? echo $jum_tng_akademik;?></td>
          </tr>
          <tr>
            <td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;Tenaga Penunjang Akademik </td>
            <td><strong>:</strong></td>
            <td><? echo $jum_tng_PNJ_akademik;?></td>
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
            <td><? echo $total_luas_r_kul;?> <span class="style3">m2</span></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Dosen</td>
            <td><strong>:</strong></td>
            <td><? echo $total_luas_r_dos;?> <span class="style3">m2</span></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Tata Usaha</td>
            <td><strong>:</strong></td>
            <td><? echo $total_luas_r_tu;?> <span class="style3">m2</span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3">
			<input type="hidden" name="frm_thn" id="frm_thn" value="<?php echo $frm_thn; ?>">
			<input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
			<input type="hidden" name="frm_akredit_jur" id="frm_akredit_jur" value="<?php echo $frm_akredit_jur; ?>">
			<input type="hidden" name="nama_kajur" id="nama_kajur" value="<?php echo $nama_kajur; ?>">
			<input type="hidden" name="jum_dsn_s1" id="jum_dsn_s1" value="<?php echo $jum_dsn_s1; ?>">
			<input type="hidden" name="jum_dsn_s2" id="jum_dsn_s2" value="<?php echo $jum_dsn_s2; ?>">
			<input type="hidden" name="jum_dsn_s3" id="jum_dsn_s3" value="<?php echo $jum_dsn_s3; ?>">
			<input type="hidden" name="jum_dsn_GB" id="jum_dsn_GB" value="<?php echo $jum_dsn_GB; ?>">
			<input type="hidden" name="jum_dsn_LK" id="jum_dsn_LK" value="<?php echo $jum_dsn_LK; ?>">
			<input type="hidden" name="jum_dsn_LE" id="frm_akredit_jur" value="<?php echo $jum_dsn_LE; ?>">
			<input type="hidden" name="jum_dsn_AA" id="jum_dsn_AA" value="<?php echo $jum_dsn_AA; ?>">
			<input type="hidden" name="jum_mhs_aktif" id="jum_mhs_aktif" value="<?php echo $jum_mhs_aktif; ?>">
			<input type="hidden" name="jum_lab_jur" id="jum_lab_jur" value="<?php echo $jum_lab_jur; ?>">
			<input type="hidden" name="jum_tng_akademik" id="jum_tng_akademik" value="<?php echo $jum_tng_akademik; ?>">
			<input type="hidden" name="jum_tng_PNJ_akademik" id="jum_tng_PNJ_akademik" value="<?php echo $jum_tng_PNJ_akademik; ?>">
			<input type="hidden" name="total_luas_r_kul" id="total_luas_r_kul" value="<?php echo $total_luas_r_kul; ?>">
			<input type="hidden" name="total_luas_r_dos" id="total_luas_r_dos" value="<?php echo $total_luas_r_dos; ?>">
			<input type="hidden" name="total_luas_r_tu" id="total_luas_r_tu" value="<?php echo $total_luas_r_tu; ?>">
			
			<input name="excel" id="excel" type="image" onClick="document.form_excel_1.action='view_scard_jurusan_export1.php?t=excel'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18">
			Export ke File Excel
			<input name="printer" id="printer" type="image"  onClick="document.form_excel_1.action='view_scard_jurusan_export1.php?t=printer'" src="../img/print.gif" align="bottom" width="18" height="18">
			Print 
	  		</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</FORM>
<br>
<table width="80%"  border="0" align="center" cellpadding="1" cellspacing="0">
  <tr>
    <td width="81%">
	</td>
    <td width="19%" align="right">
      <form name="form1" method="post" action="view_scard_jurusan.php">
	      <input type="hidden" name="frm_thn" id="frm_thn" value="<? echo $frm_thn;?>">
	      <input type="hidden" name="jum_dsn_s3" id="jum_dsn_s3" value="<? echo $jum_dsn_s3;?>">
		  <input type="hidden" name="jum_tng_akademik" id="jum_tng_akademik" value="<? echo $jum_tng_akademik;?>">
		  <input type="hidden" name="hasil_dsn_s3" id="hasil_dsn_s3" value="<? echo $hasil_dsn_s3;?>">
		  
		  <input type="hidden" name="mode" id="mode" value="2">
		  <input type="hidden" name="thn" id="thn" value="<? echo $frm_thn;?>">
		  <input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<? echo $frm_s_jurusan;?>">
		  <input type="hidden" name="frm_nama_jur" id="frm_nama_jur" value="<? echo $nama_jurusan;?>">
 		  <input type="submit" name="Submit" id="Submit" value="Lanjut >>">
      </form>
  </tr>
</table>
<br>
<br>
<br>
<? 
}
else if ($mode=="2") 
{
// LAPORAN YANG DIHASILKAN
?>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN 
      ~</strong> SCORE CARD JURUSAN </font></font></td>
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

if ($mode=="2")
{
	?>
	<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="score_scard_jurusan_export2.php">
	<input type="hidden" name="mode" value="3">
	<input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
	<input type="hidden" name="frm_s_kode" id="frm_s_kode" value="<?php echo  $frm_s_kode;?>">
	<input type="hidden" name="frm_s_nama" id="frm_s_nama" value="<?php echo  $frm_s_nama;?>">
	<input type="hidden" name="frm_s_jum_data" id="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
	<input type="hidden" name="frm_o1" id="frm_o1" value="<?php echo $frm_o1; ?>">
	<input type="hidden" name="frm_o2" id="frm_o2" value="<?php echo $frm_o2; ?>">
	<input type="hidden" name="frm_o3" id="frm_o3" value="<?php echo $frm_o3; ?>">
	<input type="hidden" name="jum_dsn_s3" id="jum_dsn_s3" value="<? echo $jum_dsn_s3;?>">
<?
//if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }

//JUMLAH DOSEN S-3 : JUMLAH DOSEN
/*$result1 = mysql_query("SELECT count( * ) as jum_dsn_s3
						FROM `dosen`
					   WHERE `dosen`.`kode` LIKE '61%' AND
						     (`dosen`.`pendidikan_terakhir` = 'S3' or `dosen`.`pendidikan_terakhir` = '7')");
if ($row1 = mysql_fetch_array($result1)) {
  $jum_dsn_s3=$row1["jum_dsn_s3"];
  echo "<br>jum_dsn_s3=".$jum_dsn_s3;
}

$result = mysql_query("SELECT count( * ) as jum_dsn
						FROM `dosen`
					   WHERE `dosen`.`kode` LIKE '61%'");
if ($row = mysql_fetch_array($result)) {
  $jum_dsn=$row["jum_dsn"];
  $hasil_dsn_s3=$jum_dsn_s3/$jum_dsn;
}*/
//END JUMLAH DOSEN S-3 : JUMLAH DOSEN


//JUMLAH LAYANAN INDUSTRI
switch ($frm_thn) {
    case '2001':
		$tgl_1="2001-01-01";
		$tgl_2="2001-12-31";
		break;
	case '2002':
		$tgl_1="2002-01-01";
		$tgl_2="2002-12-31";
		break;
	case '2003':
		$tgl_1="2003-01-01";
		$tgl_2="2003-12-31";
		break;
	case '2004':
		$tgl_1="2004-01-01";
		$tgl_2="2004-12-31";
		break;
	case '2005':
		$tgl_1="2005-01-01";
		$tgl_2="2005-12-31";
		break;
	case '2006':
		$tgl_1="2006-01-01";
		$tgl_2="2006-12-31";
		break;
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
//echo "<br>T A H U N=".$frm_thn;
$result1 = mysql_query("SELECT count(*) as jum
						  FROM pengabdian
						 WHERE pengabdian.mulai between '".$tgl_1."' and '".$tgl_2."' AND
						       pengabdian.jurusan=$frm_s_jurusan");
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
	
switch ($frm_s_jurusan) {
	case '1':
		$jur_text="6B";
		break;
	case '2':
		$jur_text="6C";
		break;
	case '3':
		$jur_text="6D";
		break;
	case '4':
		$jur_text="6E";
		break;
	case '5':
		$jur_text="6F";
		break;
}

$result = mysql_query("SELECT avg(IPK_lulus) as rata
						 FROM master_alumni, master_mhs
						WHERE master_alumni.tanggal_lulus between '".$tgl_1."' and '".$tgl_2."' AND
						      master_alumni.nrp=master_mhs.NRP AND
                              master_mhs.JURUSAN='$jur_text'");
if ($row = mysql_fetch_array($result)) {
  $rata_IPK_lulusan=$row["rata"];
//  echo "<br>rata_IPK_lulusan=".$rata_IPK_lulusan;
}

//END RATA-RATA IPK LULUSAN berdasarkan tahun

// PERSENTASI LULUSAN DENGAN IPK >= 3,00
// WHERE master_alumni.tanggal_lulus between '".$tgl_1."' and '".$tgl_2."' AND
// WHERE master_alumni.tanggal_lulus between '".$tgl_1."' and '".$tgl_2."'
$result = mysql_query("SELECT count(*) as jum_mhs
						 FROM master_alumni, master_mhs
						WHERE master_alumni.tanggal_lulus between '".$tgl_1."' and '".$tgl_2."' AND
						      master_alumni.IPK_lulus >= 3.00 AND
							  master_alumni.nrp=master_mhs.NRP AND
							  master_mhs.JURUSAN='$jur_text'");
if ($row = mysql_fetch_array($result)) {
  $jum_lulusan_IPK3=$row["jum_mhs"];
//  echo "<br>jum_lulusan_IPK3=".$jum_lulusan_IPK3;
//  echo "<br>jur_text=".$jur_text;
  
}

$result = mysql_query("SELECT count(*) as jum_mhs
						 FROM master_alumni, master_mhs
						WHERE master_alumni.tanggal_lulus between '".$tgl_1."' and '".$tgl_2."' AND
						      master_alumni.nrp=master_mhs.NRP AND
							  master_mhs.JURUSAN='$jur_text'");
if ($row = mysql_fetch_array($result)) {
  $jum_lulusan_IPK=$row["jum_mhs"];
//  echo "<br>jum_lulusan_IPK=".$jum_lulusan_IPK;
  if ($jum_lulusan_IPK <> 0) {
	  $persen_IPK3=($jum_lulusan_IPK3/$jum_lulusan_IPK)*100;
  }
//  echo "<br>persen_IPK3=".$persen_IPK3;
}

//END PERSENTASI LULUSAN DENGAN IPK >= 3,00

// PERSENTASI LULUSAN DENGAN MASA STUDI
$result_rata2_masa_studi = mysql_query("SELECT avg(master_alumni.masa_studi) as rata_masa_studi
						                  FROM master_alumni, master_mhs
						                 WHERE master_alumni.tanggal_lulus between '".$tgl_1."' and '".$tgl_2."' AND
										       master_alumni.nrp=master_mhs.NRP AND
											   master_mhs.JURUSAN='$jur_text'");
if ($row_rata2_masa_studi = mysql_fetch_array($result_rata2_masa_studi)) {
  $rata2_masa_studi=number_format($row_rata2_masa_studi["rata_masa_studi"], 2,',','');
//  echo "<br>rata2_masa_studi=".$rata2_masa_studi;
}
// END PERSENTASI LULUSAN DENGAN MASA STUDI

// PERSENTASI LULUSAN DENGAN MASA STUDI <= 4 TAHUN
$result = mysql_query("SELECT count(*) as jum_mhs
						 FROM master_alumni, master_mhs
						WHERE master_alumni.tanggal_lulus between '".$tgl_1."' and '".$tgl_2."' AND
						      master_alumni.masa_studi <= 8 AND
							  master_alumni.nrp=master_mhs.NRP AND
							  master_mhs.JURUSAN='$jur_text'");
if ($row = mysql_fetch_array($result)) {
  $jum_masa_studi4thn=$row["jum_mhs"];
//  echo "<br>jum_masa_studi4thn=".$jum_masa_studi4thn;
	if ($jum_lulusan_IPK<>0) {
		$persen_studi4thn=($jum_masa_studi4thn/$jum_lulusan_IPK)*100;
	}
//  echo "<br>persen_studi4thn=".$persen_studi4thn;
}
// END PERSENTASI LULUSAN DENGAN MASA STUDI <= 4 TAHUN

// PERSENTASI RATA-RATA GAJI PERTAMA ALUMNI
/*
$result = mysql_query("SELECT avg(gaji.id) as rata
						 FROM master_alumni, gaji
						WHERE master_alumni.tanggal_lulus between '".$tgl_1."' and '".$tgl_2."' AND
						      master_alumni.gaji_pertama = gaji.id");*/
							//echo "<br>******JURTEXT=".$jur_text;  
							//echo "<br>******tgl_1=".$tgl_1; 
							//echo "<br>******tgl_2=".$tgl_2; 
$result = mysql_query("SELECT avg(gaji.id) as rata
						 FROM master_alumni,master_mhs,gaji
						WHERE master_alumni.tanggal_lulus between '".$tgl_1."' and '".tgl_2."' AND
							  master_alumni.nrp=master_mhs.NRP  AND
							  master_mhs.JURUSAN='".$jur_text."' AND
							  master_alumni.gaji_pertama = gaji.id");
		   
		   
if ($row = mysql_fetch_array($result)) {
    //$rata2_gaji_alumni=round($row["rata"]);
	$rata2_gaji_alumni=$row["rata"];
	//echo "<br>rata2_GAJI_alumni=".$rata2_gaji_alumni;
	if (is_null($rata2_gaji_alumni))
	{
		$rata2_gaji_alumni=0;
	} 
	else
	{
		echo "<br>rata2_gaji_alumni=".$rata2_gaji_alumni;
	}
		  $result2 = mysql_query("SELECT gaji
							        FROM gaji
							       WHERE gaji.id=$rata2_gaji_alumni");
		if ($row2 = mysql_fetch_array($result2)) {
		  $rata2_gaji_alumni_riil=$row2["gaji"];
		  //echo "<br>rata2_gaji_alumni_riil=".$rata2_gaji_alumni_riil;
		  
		}
}
//END RATA-RATA GAJI PERTAMA ALUMNI

// JUMLAH GRANT YG DITERIMA
$result = mysql_query("SELECT Sum(grant_prodi.jumlah) as tot_grant
						 FROM grant_prodi
						WHERE grant_prodi.tgl_awal between '".$tgl_1."' and '".$tgl_2."' AND
						      grant_prodi.jurusan_id=$frm_s_jurusan");
if ($row_grant = mysql_fetch_array($result)) {
 $jum_grant_prodi=$row_grant["tot_grant"];
  //echo "<br>jum_grant_prodi=".$jum_grant_prodi;
}
//END JUMLAH GRANT YG DITERIMA


// Rasio DO : mhs aktif
$result = mysql_query("SELECT jum_mhs_DO, jum_mhs_aktif
						 FROM do
						WHERE do.semester LIKE '".$frm_thn."%' AND
						      do.jurusan_id=$frm_s_jurusan");
if ($row = mysql_fetch_array($result)) {
  $jum_mhs_DO=$row["jum_mhs_DO"];
  //echo "<br>jum_mhs_DO=".$jum_mhs_DO;
}
//END Rasio DO : mhs aktif

// Rasio PO : mhs aktif
$result = mysql_query("SELECT jum_mhs_PO, jum_mhs_aktif
						 FROM po
						WHERE po.semester LIKE '".$frm_thn."%' AND
						      po.jurusan_id=$frm_s_jurusan");
if ($row = mysql_fetch_array($result)) {
  $jum_mhs_PO=$row["jum_mhs_PO"];
 // echo "<br>jum_mhs_PO=".$jum_mhs_PO;
}
//END Rasio PO : mhs aktif




// JUMLAH KERJASAMA DENGAN PIHAK LUAR
$result = mysql_query("SELECT count(*) as jum_kerjasama
						 FROM profil_kerjasama
						WHERE profil_kerjasama.mulai between '".$tgl_1."' and '".$tgl_2."' AND
						      profil_kerjasama.jurusan=$frm_s_jurusan");
if ($row = mysql_fetch_array($result)) {
  $jum_kerjasama=$row["jum_kerjasama"];
 // echo "<br>jum_kerjasama=".$jum_kerjasama;
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
						 WHERE master_alumni.tanggal_lulus between '' and '".$tgl_2."'");
if ($row = mysql_fetch_array($result)) {
  $rata_IPK_lulusan=$row["rata"];
  echo "rata_IPK_lulusan=".$rata_IPK_lulusan;
}*/
// END RATA-RATA MASA LAMA STUDI PADA TAHUN YG BERSANGKUTAN

//RATA-RATA MASA TUNGGU DAPAT KERJA						 
$result = mysql_query("SELECT avg(To_days( tanggal_mulai_kerja ) - TO_DAYS( tanggal_lulus )) as rata_tunggu
                         FROM master_alumni, master_mhs
                        WHERE (master_alumni.tanggal_lulus<>'0000-00-00' or master_alumni.tanggal_lulus<>NULL) and
	                          (master_alumni.tanggal_mulai_kerja<>'0000-00-00' or master_alumni.tanggal_mulai_kerja<>NULL) and
							  master_alumni.nrp=master_mhs.NRP AND
							  master_mhs.JURUSAN='$jur_text'");

if ($row = mysql_fetch_array($result)) {
  $rata_tunggu_kerja=round($row["rata_tunggu"]);
 // echo "<br>rata_tunggu_kerja=".$rata_tunggu_kerja;
	
}
//END RATA-RATA MASA TUNGGU DAPAT KERJA

//echo "<br>****frm_tahun=".$_GET["thn"];
//echo "<br>****frm_s_jurusan=".$frm_s_jurusan;
// JUMLAH MAHASISWA BARU PER TAHUN
$result = mysql_query("SELECT maharu.jum_mhs
						 FROM maharu
						WHERE maharu.angkatan = '".$_POST["thn"]."' and maharu.jurusan_id=$frm_s_jurusan");
						
if ($row = mysql_fetch_array($result)) {
  $jum_mhs_perTahun=$row["jum_mhs"];
//  echo "<br>---jum_mhs_perTahun=".$jum_mhs_perTahun;
}
//END JUMLAH MAHASISWA BARU PER TAHUN


// JUMLAH PENELITIAN PER TAHUN
$result_penil = mysql_query("SELECT count(*) as jum_penelitian
						       FROM penelitian
						      WHERE penelitian.tanggal_mulai between '".$tgl_1."' and '".$tgl_2."' AND
							        penelitian.jurusan_id=$frm_s_jurusan");
						
if ($row_penil = mysql_fetch_array($result_penil)) {
  $jum_penil=$row_penil["jum_penelitian"];
//  echo "<br>jum_penil=".$jum_penil;
}
//echo "<br>JURUSAN=".$frm_s_jurusan;
//END JUMLAH PENELITIAN PER TAHUN

// JUMLAH PUBLIKASI JURNAL NASIONAL TERAKREDITASI PER TAHUN
$result_pub_status = mysql_query("SELECT id_pub, nama
						            FROM status_publikasi
								   WHERE status_publikasi.nama='Nasional'");
						
if ($row_pub_status = mysql_fetch_array($result_pub_status)) {
   $status_pub1=$row_pub_status["id_pub"];
   //echo "<br>status_pub_nas=".$status_pub1;
}

$result_pub_jurnal_nas = mysql_query("SELECT count(*) as jum_jurnal_nasional
						                FROM penelitian
						               WHERE penelitian.pub_tanggal between '".$tgl_1."' and '".$tgl_2."' AND
									   		 penelitian.jurusan_id=$frm_s_jurusan AND
						                     penelitian.publikasi=$status_pub1");
						
if ($row_pub_jurnal_nas = mysql_fetch_array($result_pub_jurnal_nas)) {
  $jum_pub_jurnal_nas=$row_pub_jurnal_nas["jum_jurnal_nasional"];
//  echo "<br>jum_pub_jurnal_nas=".$jum_pub_jurnal_nas;
}
//END JUMLAH PUBLIKASI JURNAL NASIONAL TERAKREDITASI PER TAHUN


// JUMLAH PUBLIKASI JURNAL INTERNASIONAL TERAKREDITASI PER TAHUN
$result_pub_status = mysql_query("SELECT id_pub, nama
						            FROM status_publikasi
								   WHERE status_publikasi.nama='Internasional'");
						
if ($row_pub_status = mysql_fetch_array($result_pub_status)) {
   $status_pub1=$row_pub_status["id_pub"];
  // echo "<br>status_pub_inter=".$status_pub1;
 
}

$result_pub_jurnal_inter = mysql_query("SELECT count(*) as jum_jurnal_internasional
						                  FROM penelitian
						                 WHERE penelitian.pub_tanggal between '".$tgl_1."' and '".$tgl_2."' AND
									           penelitian.jurusan_id=$frm_s_jurusan AND
						                       penelitian.publikasi=$status_pub1");
						
if ($row_pub_jurnal_inter = mysql_fetch_array($result_pub_jurnal_inter)) {
  $jum_pub_jurnal_inter=$row_pub_jurnal_inter["jum_jurnal_internasional"];
//  echo "<br>jum_pub_jurnal_inter=".$jum_pub_jurnal_inter;
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
										        penelitian.jurusan_id=$frm_s_jurusan AND
						                        penelitian.publikasi=$status_pub1 AND penelitian.pub_ISBN<>''");
						
if ($row_pub_prosiding_nas = mysql_fetch_array($result_pub_prosiding_nas)) {
  $jum_pub_prosiding_nas=$row_pub_prosiding_nas["jum_prosiding_nasional"];
 // echo "<br>jum_row_pub_prosiding_nas=".$jum_pub_prosiding_nas;
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
									         penelitian.jurusan_id=$frm_s_jurusan AND
						                     penelitian.publikasi=$status_pub1 AND penelitian.pub_ISBN<>''");
						
if ($row_pub_prosiding_inter = mysql_fetch_array($result_pub_prosiding_inter)) {
  $jum_pub_prosiding_inter=$row_pub_prosiding_inter["jum_prosiding_internasional"];
//  echo "<br>jum_pub_prosiding_inter=".$jum_pub_prosiding_inter;
}
//END JUMLAH PUBLIKASI PROSIDING INTERNASIONAL TERAKREDITASI PER TAHUN

//JUMLAH PATEN PENELITIAN
$result_PATEN = mysql_query("SELECT count(*) as jum_PATEN_penelitian
							   FROM penelitian
							  WHERE penelitian.pub_tanggal between '".$tgl_1."' and '".$tgl_2."' AND
							        penelitian.jurusan_id=$frm_s_jurusan AND
								    penelitian.no_paten <>'-'");
						
if ($row_PATEN = mysql_fetch_array($result_PATEN)) {
  $jum_PATEN=$row_PATEN["jum_PATEN_penelitian"];
//  echo "<br>jum_PATEN=".$jum_PATEN;
}
//END PATEN PENELITIAN


// JUMLAH DANA PENELITIAN DARI PIHAK EXTERNAL
/*$result_dana_ext = mysql_query("SELECT Sum(penelitian.dana) as tot_dana
						          FROM penelitian
								 WHERE penelitian.tanggal_mulai between '".$tgl_1."' and '".$tgl_2."' and
									   penelitian.id_sumber_dana <> 5");*/
									   
$result_dana_ext = mysql_query("SELECT sum(dana) AS jum_dana_ext
                                  FROM (SELECT penelitian.dana AS dana
                                          FROM penelitian 
                                         WHERE (penelitian.tanggal_mulai between '".$tgl_1."' and '".$tgl_2."') and
                                               (penelitian.id_sumber_dana <> 1 or penelitian.id_sumber_dana <> 5) and
											   (penelitian.jurusan_id=$frm_s_jurusan)
                                      GROUP BY penelitian.kode_pen) AS penelitian");
						
if ($row_dana_ext = mysql_fetch_array($result_dana_ext)) {
  $jum_dana_external=$row_dana_ext["jum_dana_ext"];
//  echo "<br>~~~jum_dana_external=".$jum_dana_external;
}
//END JUMLAH DANA PENELITIAN DARI PIHAK EXTERNAL

// Partisipasi mahasiswa dalam kegiatan ilmiah NASIONAL
$result_part_mhs_nas = mysql_query("SELECT count(*) as jum_part_mhs_nas
						          FROM prestasi, status_publikasi
						         WHERE (prestasi.tgl_kegiatan between '".$tgl_1."' and '".$tgl_2."') AND
								       (prestasi.jurusan = $frm_s_jurusan) AND
						               (prestasi.tingkat = status_publikasi.id_pub) AND 
									   (status_publikasi.nama='Nasional')");
						
if ($row_part_mhs_nas = mysql_fetch_array($result_part_mhs_nas)) {
  $jum_part_mhs_nas=$row_part_mhs_nas["jum_part_mhs_nas"];
//  echo "<br>~~~jum_partisipasi MHS nasional=".$jum_part_mhs_nas;
}
// END Partisipasi mahasiswa dalam kegiatan ilmiah NASIONAL

// Partisipasi mahasiswa dalam kegiatan ilmiah INTERNASIONAL
$result_part_mhs_inter = mysql_query("SELECT count(*) as jum_part_mhs_inter
						                FROM prestasi, status_publikasi
						               WHERE (prestasi.tgl_kegiatan between '".$tgl_1."' and '".$tgl_2."') AND
									   	     (prestasi.jurusan = $frm_s_jurusan) AND
						                     (prestasi.tingkat = status_publikasi.id_pub) AND 
									         (status_publikasi.nama='Internasional')");
						
if ($row_part_mhs_inter = mysql_fetch_array($result_part_mhs_inter)) {
  $jum_part_mhs_inter=$row_part_mhs_inter["jum_part_mhs_inter"];
//  echo "<br>~~~jum_partisipasi MHS Internasional=".$jum_part_mhs_inter;
}
// END Partisipasi mahasiswa dalam kegiatan ilmiah INTERNASIONAL

// PRESTASI mahasiswa dalam kegiatan ilmiah NASIONAL
$result_pres_mhs_nas = mysql_query("SELECT count(*) as jum_pres_mhs_nas
						              FROM prestasi, status_publikasi
						             WHERE (prestasi.tgl_kegiatan between '".$tgl_1."' and '".$tgl_2."') AND
									       (prestasi.jurusan = $frm_s_jurusan) AND
						                   (prestasi.tingkat = status_publikasi.id_pub) AND 
									        status_publikasi.nama='Nasional' AND prestasi.hasil<>''");
						
if ($row_pres_mhs_nas = mysql_fetch_array($result_pres_mhs_nas)) {
  $jum_pres_mhs_nas=$row_pres_mhs_nas["jum_pres_mhs_nas"];
 // echo "<br>~~~jum_PRESTASI MHS nasional=".$jum_pres_mhs_nas;
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
//  echo "<br>~~~jum_PRESTASI MHS Internasional=".$jum_pres_mhs_inter;
}
// END Partisipasi mahasiswa dalam kegiatan ilmiah INTERNASIONAL

// BEGIN TARGET SC JUR
$res_target_sc_jur = mysql_query("SELECT *
								    FROM sc_jur
								   WHERE tahun=$frm_thn AND jurusan=$frm_s_jurusan");
				
						if ($row = mysql_fetch_array($res_target_sc_jur)) {
							$frm_exist=1;
							$frm_id_sc_jur=1;
							$frm_sc_jur_LD1=$row["LD1"];
							$frm_sc_jur_LD2=$row["LD2"];
							$frm_sc_jur_LD3=$row["LD3"];
							$frm_sc_jur_LD4=$row["LD4"];
							$frm_sc_jur_LD5=$row["LD5"];
							$frm_sc_jur_LD6=$row["LD6"];
							$frm_sc_jur_LD7=$row["LD7"];
							$frm_sc_jur_LD8=$row["LD8"];
							$frm_sc_jur_LD9=$row["LD9"];
							$frm_sc_jur_LD10=$row["LD10"];
							$frm_sc_jur_LD11=$row["LD11"];
							$frm_sc_jur_LD12=$row["LD12"];
							$frm_sc_jur_LD13=$row["LD13"];
							$frm_sc_jur_LD14=$row["LD14"];
							$frm_sc_jur_LD15=$row["LD15"];
							$frm_sc_jur_LD16=$row["LD16"];
							$frm_sc_jur_LD17=$row["LD17"];
							
							$frm_sc_jur_S1=$row["SUS1"];
							$frm_sc_jur_S2=$row["SUS2"];
							$frm_sc_jur_S3=$row["SUS3"];
							$frm_sc_jur_S4=$row["SUS4"];
							
							$frm_sc_jur_P1=$row["PRO1"];
							$frm_sc_jur_P2=$row["PRO2"];
							$frm_sc_jur_P3=$row["PRO3"];
							$frm_sc_jur_P4=$row["PRO4"];
							$frm_sc_jur_P5=$row["PRO5"];
							$frm_sc_jur_P6=$row["PRO6"];
							$frm_sc_jur_M1=$row["MAN1"];
							$frm_sc_jur_M2=$row["MAN2"];
							$frm_sc_jur_PN1=$row["PN1"];
						}
						else
						{
							$frm_exist=0;
							$frm_sc_jur_LD1=0;
							$frm_sc_jur_LD2=0;
							$frm_sc_jur_LD3=0;
							$frm_sc_jur_LD4=0;
							$frm_sc_jur_LD5=0;
							$frm_sc_jur_LD6=0;
							$frm_sc_jur_LD7=0;
							$frm_sc_jur_LD8=0;
							$frm_sc_jur_LD9=0;
							$frm_sc_jur_LD10=0;
							$frm_sc_jur_LD11=0;
							$frm_sc_jur_LD12=0;
							$frm_sc_jur_LD13=0;
							$frm_sc_jur_LD14=0;
							$frm_sc_jur_LD15=0;
							$frm_sc_jur_LD16=0;
							$frm_sc_jur_LD17=0;
							
							$frm_sc_jur_S1=0;
							$frm_sc_jur_S2=0;
							$frm_sc_jur_S3=0;
							$frm_sc_jur_S4=0;
							
							$frm_sc_jur_P1=0;
							$frm_sc_jur_P2=0;
							$frm_sc_jur_P3=0;
							$frm_sc_jur_P4=0;
							$frm_sc_jur_P5=0;
							$frm_sc_jur_P6=0;
							$frm_sc_jur_M1=0;
							$frm_sc_jur_M2=0;
							$frm_sc_jur_PN1=0;
						}
// END TARGET SC JUR

// JUMLAH RATA-RATA INDEX PEMBELAJARAN DOSEN TETAP PER JURUSAN
$result = mysql_query("SELECT avg(ipk_dsn) as rata_ipk_dsn 
						 FROM index_belajar_dosen
						WHERE index_belajar_dosen.semester LIKE '".$_POST["thn"]."%' AND
						      index_belajar_dosen.jurusan=$frm_s_jurusan AND
							  index_belajar_dosen.kode_dosen LIKE '61%'");
						
if ($row = mysql_fetch_array($result)) {
  $jum_rata_ipk_dsn = $row["rata_ipk_dsn"];
//  echo "<br>---jum_revenue_3darma=".$jum_revenue_3darma;
}
//END RATA-RATA INDEX PEMBELAJARAN DOSEN TETAP PER JURUSAN

// JUMLAH PRODUKTIVITAS REVENUE PER JURUSAN
$result = mysql_query("SELECT revenue.revenue
						 FROM revenue
						WHERE revenue.tahun = '".$_POST["thn"]."' and revenue.jurusan=$frm_s_jurusan");
						
if ($row = mysql_fetch_array($result)) {
  $jum_revenue_jur_perTahun=$row["revenue"];
//  echo "<br>---jum_mhs_perTahun=".$jum_mhs_perTahun;
}
//END JUMLAH PRODUKTIVITAS REVENUE PER JURUSAN

// JUMLAH PRODUKTIVITAS DIRECT COST PER JURUSAN
$result = mysql_query("SELECT direct_cost.dr_cost
						 FROM direct_cost
						WHERE direct_cost.tahun = '".$_POST["thn"]."' and direct_cost.jurusan=$frm_s_jurusan");
						
if ($row = mysql_fetch_array($result)) {
  $jum_direct_cost_jur_perTahun=$row["dr_cost"];
//  echo "<br>---jum_mhs_perTahun=".$jum_mhs_perTahun;
}
//END JUMLAH PRODUKTIVITAS DIRECT COST PER JURUSAN

// JUMLAH REVENUE TRI-DHARMA DILUAR TUITION FEE PER JURUSAN
$result = mysql_query("SELECT total_grant, total_dana_penelitian, total_dana_abdi_masy
						 FROM revenue_3darma
						WHERE revenue_3darma.tahun = '".$_POST["thn"]."' and revenue_3darma.jurusan=$frm_s_jurusan");
						
if ($row = mysql_fetch_array($result)) {
  $jum_revenue_3darma = $row["total_grant"] + $row["total_dana_penelitian"] + $row["total_dana_abdi_masy"];
//  echo "<br>---jum_revenue_3darma=".$jum_revenue_3darma;
}
//END REVENUE TRI-DHARMA DILUAR TUITION FEE PER JURUSAN


$frm_thn=$_POST["thn"];
?>
<strong><? echo "<br>Periode: ".$frm_thn." &nbsp;&nbsp; | &nbsp;&nbsp; Jurusan: ".$frm_nama_jur;?></strong>
<table width="95%"  border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><table width="85%"  border="1" align="center" cellpadding="3" cellspacing="0" class="table">
      <tr bgcolor="#C6E2FF">
        <td width="4%" nowrap><strong>No</strong></td>
        <td width="52%" nowrap><b>Nama KPI </b></td>
        <td width="11%" nowrap><div align="center"><strong>Target</strong></div></td>
        <td width="10%" nowrap><div align="center"><strong>Capaian</strong></div></td>
        <td width="12%" nowrap><div align="center"><strong>%<br>
            capaian</strong></div></td>
        <td width="11%" nowrap><div align="center"><strong>Rata-rata<br>
            % capaian </strong></div></td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td colspan="6" valign="top" nowrap><em>Isu Strategis:</em> <strong>Learning &amp; Discovery </strong></td>
      </tr>
      <tr>
        <td nowrap valign="top">1</td>
        <td nowrap valign="top"> Jumlah Penelitian Dosen </td>
        <td valign="top" nowrap><? echo $frm_sc_jur_LD1;?></td>
        <td valign="top" nowrap><? echo $jum_penil;?></td>
        <td valign="top" nowrap>
		<? 
		if ($frm_sc_jur_LD1<>0) {
			echo number_format(($jum_penil/$frm_sc_jur_LD1)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?>
		</td>
        <td rowspan="17" valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td nowrap valign="top">2</td>
        <td nowrap valign="top">Jumlah publikasi jurnal nasional terakreditasi </td>
        <td valign="top" nowrap><? echo $frm_sc_jur_LD2;?></td>
        <td valign="top" nowrap><? echo $jum_pub_jurnal_nas;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_LD2<>0) {
			echo number_format(($jum_pub_jurnal_nas/$frm_sc_jur_LD2)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">3</td>
        <td nowrap valign="top">Jumlah publikasi jurnal internasional</td>
        <td valign="top" nowrap><? echo $frm_sc_jur_LD3;?></td>
        <td valign="top" nowrap><? echo $jum_pub_jurnal_inter;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_LD3<>0) {
			echo number_format(($jum_pub_jurnal_inter/$frm_sc_jur_LD3)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">4</td>
        <td nowrap valign="top">Jumlah publikasi prosiding nasional</td>
        <td valign="top" nowrap><? echo $frm_sc_jur_LD4;?></td>
        <td valign="top" nowrap><? echo $jum_pub_prosiding_nas;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_LD4<>0) {
			echo number_format(($jum_pub_prosiding_nas/$frm_sc_jur_LD4)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">5</td>
        <td valign="top" nowrap>Jumlah publikasi prosiding internasional</td>
        <td valign="top" nowrap><? echo $frm_sc_jur_LD5;?></td>
        <td valign="top" nowrap><? echo $jum_pub_prosiding_inter;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_LD5<>0) {
			echo number_format(($jum_pub_prosiding_inter/$frm_sc_jur_LD5)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">6</td>
        <td nowrap valign="top">Jumlah paten</td>
        <td valign="top" nowrap><? echo $frm_sc_jur_LD6;?></td>
        <td valign="top" nowrap><? echo $jum_PATEN;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_LD6<>0) {
			echo number_format(($jum_PATEN/$frm_sc_jur_LD6)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">7</td>
        <td nowrap valign="top">Jumlah Layanan Industri </td>
        <td valign="top" nowrap><? echo $frm_sc_jur_LD7;?></td>
        <td valign="top" nowrap><? echo $jum_layanan_industri;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_LD7<>0) {
			echo number_format(($jum_layanan_industri/$frm_sc_jur_LD7)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">8</td>
        <td nowrap valign="top">Rata-rata IPK lulusan </td>
        <td valign="top" nowrap><? echo $frm_sc_jur_LD8;?></td>
        <td valign="top" nowrap><? echo number_format($rata_IPK_lulusan, 3,'.','') ;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_LD8<>0) {
			echo number_format(($rata_IPK_lulusan/$frm_sc_jur_LD8)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">9</td>
        <td nowrap valign="top">% lulusan dengan IPK &gt;= 3,00</td>
        <td valign="top" nowrap><? echo $frm_sc_jur_LD9;?></td>
        <td valign="top" nowrap><? echo number_format($persen_IPK3, 3,'.','') ;?>%</td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_LD9<>0) {
			echo number_format(($persen_IPK3/$frm_sc_jur_LD9)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">10</td>
        <td nowrap valign="top">Rasio DO : mhs aktif </td>
        <td valign="top" nowrap><? echo $frm_sc_jur_LD10;?></td>
        <td valign="top" nowrap><? echo $jum_mhs_DO;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_LD10<>0) {
			echo number_format(($jum_mhs_DO/$frm_sc_jur_LD10)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">11</td>
        <td nowrap valign="top">Rasio PO : mhs aktif </td>
        <td valign="top" nowrap><? echo $frm_sc_jur_LD11;?></td>
        <td valign="top" nowrap><? echo $jum_mhs_PO;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_LD11<>0) {
			echo number_format(($jum_mhs_PO/$frm_sc_jur_LD11)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">12</td>
        <td nowrap valign="top">Rata-rata masa studi </td>
        <td valign="top" nowrap><? echo $frm_sc_jur_LD12;?></td>
        <td valign="top" nowrap><? echo $rata2_masa_studi;?> tahun</td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_LD12<>0) {
			echo number_format(($rata2_masa_studi/$frm_sc_jur_LD12)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">13</td>
        <td nowrap valign="top">% lulusan dengan masa studi &lt;= 4 tahun </td>
        <td valign="top" nowrap><? echo $frm_sc_jur_LD13;?></td>
        <td valign="top" nowrap><? echo number_format($persen_studi4thn, 3,'.','') ;?>%</td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_LD13<>0) {
			echo number_format(($persen_studi4thn/$frm_sc_jur_LD13)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">14</td>
        <td nowrap valign="top">Masa tunggu alumni dapat kerja </td>
        <td valign="top" nowrap><? echo $frm_sc_jur_LD14;?></td>
        <td valign="top" nowrap><? echo $rata_tunggu_kerja;?> hari</td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_LD14<>0) {
			echo number_format(($rata_tunggu_kerja/$frm_sc_jur_LD14)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">15</td>
        <td nowrap valign="top">Gaji pertama <? //echo "THUN= ".$thn." | tgl_1=".$tgl_1." | tgl_2=".$tgl_2; ?> </td>
        <td valign="top" nowrap><? echo $frm_sc_jur_LD15;?></td>
        <td valign="top" nowrap><? echo $rata2_gaji_alumni_riil;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_LD15<>0) {
			echo number_format(($rata2_gaji_alumni_riil/$frm_sc_jur_LD15)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">16</td>
        <td nowrap valign="top">Jumlah grant yang diterima </td>
        <td valign="top" nowrap><? echo $frm_sc_jur_LD16;?></td>
        <td valign="top" nowrap><? echo $jum_grant_prodi;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_LD16<>0) {
			echo number_format(($jum_grant_prodi/$frm_sc_jur_LD16)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">17</td>
        <td nowrap valign="top">Rata-rata indeks pembelajaran per jurusan (dosen tetap) </td>
        <td valign="top" nowrap><? echo $frm_sc_jur_LD17;?></td>
        <td valign="top" nowrap><? echo number_format($jum_rata_ipk_dsn, 3,'.',''); ?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_LD17<>0) {
			echo number_format(($jum_rata_ipk_dsn/$frm_sc_jur_LD17)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">&nbsp;</td>
        <td nowrap valign="top">&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td colspan="6" valign="top" nowrap><em>Isu Strategis:</em> <strong>Sustainability</strong> </td>
      </tr>
      <tr>
        <td nowrap valign="top">18</td>
        <td nowrap valign="top">Jumlah dana penelitian dari pihak eksternal</td>
        <td valign="top" nowrap><? echo $frm_sc_jur_S1;?></td>
        <td valign="top" nowrap><? echo $jum_dana_external;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_S1<>0) {
			$persen_s1=($jum_dana_external/$frm_sc_jur_S1)*100;
			echo number_format($persen_s1, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        <td rowspan="4" nowrap align="center">&nbsp;</td>
      </tr>
      <tr>
        <td nowrap valign="top">19</td>
        <td nowrap valign="top">Produktivitas dana = income (revenue - direct cost) / <br>          <img src="../img/sigma.gif" width="10" height="12" align="absbottom"> direct employe </td>
        <td valign="top" nowrap><? echo $frm_sc_jur_S2;?>
		</td>
        <td valign="top" nowrap><? 
		 //$total_jum_dosen = $jum_dsn_s1 + $jum_dsn_s2 + $jum_dsn_s3;
		 // jum_tng_akademik ---> jumlah dosen tetap per jurusan
		 $total_tng_akademik = $jum_tng_akademik +$jum_tng_PNJ_akademik;
		 $prod_dana = ($jum_revenue_jur_perTahun - $jum_direct_cost_jur_perTahun)/ ($total_tng_akademik);
		 echo number_format($prod_dana, 3,'.','');
		?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_S2<>0) {
			$persen_s2 = ($prod_dana/$frm_sc_jur_S2)*100;
			echo number_format($persen_s2, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">20</td>
        <td nowrap valign="top">% non-tuition fee = revenue berbasis kegiatan <br>
          tri-dharma di luar tuition fee / <img src="../img/sigma.gif" width="10" height="12" align="absbottom"> revenue total </td>
        <td valign="top" nowrap><? echo $frm_sc_jur_S3;?></td>
        <td valign="top" nowrap>
				<? 
				if ($jum_revenue_jur_perTahun<>0) {
					//$total_jum_dosen = $jum_dsn_s1 + $jum_dsn_s2 + $jum_dsn_s3;
					// jum_tng_akademik ---> jumlah dosen tetap per jurusan
					$total_non_tuition_fee = $jum_revenue_3darma/ $jum_revenue_jur_perTahun;
					echo number_format($total_non_tuition_fee, 3,'.','');
				}
				else
				{
					echo "-";
				}
				?>		%		</td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_S3<>0) {
			$persen_s3 = ($total_non_tuition_fee/$frm_sc_jur_S3)*100;
			echo number_format($persen_s3 , 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">21</td>
        <td nowrap valign="top">Jumlah mahasiswa baru </td>
        <td valign="top" nowrap><? echo $frm_sc_jur_S4;?></td>
        <td valign="top" nowrap><? echo $jum_mhs_perTahun;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_S4<>0) {
			$persen_s4 = ($jum_mhs_perTahun/$frm_sc_jur_S4)*100;
			echo number_format($persen_s4, 3,'.',''); 
			//$rata2_capaian_sustainability = ($persen_s1 + $persen_s2 + $persen_s3 + $persen_s4)/4;
			//echo "<br>";
			//echo number_format($rata2_capaian_sustainability, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?>
          
			
		</td>
        </tr>
      <tr>
        <td nowrap valign="top">&nbsp;</td>
        <td nowrap valign="top">&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td nowrap align="center"><?
			$rata2_capaian_sustainability = ($persen_s1 + $persen_s2 + $persen_s3 + $persen_s4)/4;
			echo number_format($rata2_capaian_sustainability, 3,'.','');
		?></td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td colspan="6" valign="top" nowrap><em>Isu Strategis:</em> <strong>Promotion</strong></td>
      </tr>
      <tr>
        <td nowrap valign="top">22</td>
        <td nowrap valign="top">Partisipasi mahasiswa dalam kegiatan ilmiah nasional</td>
        <td valign="top" nowrap><? echo $frm_sc_jur_P1;?></td>
        <td valign="top" nowrap><? echo $jum_part_mhs_nas;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_P1<>0) {
			echo number_format(($jum_part_mhs_nas/$frm_sc_jur_P1)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        <td rowspan="6" valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td nowrap valign="top">23</td>
        <td nowrap valign="top">Partisipasi mahasiswa dalam kegiatan ilmiah internasional</td>
        <td valign="top" nowrap><? echo $frm_sc_jur_P2;?></td>
        <td valign="top" nowrap><? echo $jum_part_mhs_inter;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_P2<>0) {
			echo number_format(($jum_part_mhs_inter/$frm_sc_jur_P2)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">24</td>
        <td nowrap valign="top">Prestasi mahasiswa dalam kegiatan ilmiah nasional</td>
        <td valign="top" nowrap><? echo $frm_sc_jur_P3;?></td>
        <td valign="top" nowrap><? echo $jum_pres_mhs_nas;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_P3<>0) {
			echo number_format(($jum_pres_mhs_nas/$frm_sc_jur_P3)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">25</td>
        <td valign="top" nowrap>Prestasi mahasiswa dalam kegiatan ilmiah internasional</td>
        <td valign="top" nowrap><? echo $frm_sc_jur_P4;?></td>
        <td valign="top" nowrap><? echo $jum_pres_mhs_inter;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_P4<>0) {
			echo number_format(($jum_pres_mhs_inter/$frm_sc_jur_P4)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">26</td>
        <td nowrap valign="top">Jumlah buku yang ditulis dosen dan diterbitkan</td>
        <td valign="top" nowrap><? echo $frm_sc_jur_P5;?></td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        </tr>
      <tr>
        <td nowrap valign="top">27</td>
        <td nowrap valign="top">Jumlah publikasi karya mahasiswa dan dosen di media massa </td>
        <td valign="top" nowrap><? echo $frm_sc_jur_P6;?></td>
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
      <tr bgcolor="#CCCCCC">
        <td colspan="6" valign="top" nowrap><em>Isu Strategis:</em> <strong>Management</strong> </td>
      </tr>
      <tr>
        <td nowrap valign="top">28</td>
        <td nowrap valign="top"><img src="../img/sigma.gif" width="10" height="12" align="absbottom"> dosen S3(<? echo $_POST["jum_dsn_s3"];?>) : <img src="../img/sigma.gif" width="10" height="12" align="absbottom"> dosen(<? echo $jum_tng_akademik;?>)</td>
        <td valign="top" nowrap><? echo $frm_sc_jur_M1;?></td>
        <td valign="top" nowrap><? echo number_format($hasil_dsn_s3, 3,'.','') ;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_M1<>0) {
			echo number_format(($hasil_dsn_s3/$frm_sc_jur_M1)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        <td rowspan="2" valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td nowrap valign="top">29</td>
        <td nowrap valign="top">Tingkat kepuasan layanan administrasi</td>
        <td valign="top" nowrap><? echo $frm_sc_jur_M2;?></td>
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
      <tr bgcolor="#CCCCCC">
        <td colspan="6" valign="top" nowrap><em>Isu Strategis: </em><strong>Partnership &amp; Networking </strong></td>
      </tr>
      <tr>
        <td nowrap valign="top">30</td>
        <td nowrap valign="top">Jumlah Kerjasama</td>
        <td valign="top" nowrap><? echo $frm_sc_jur_PN1;?></td>
        <td valign="top" nowrap><? echo $jum_kerjasama;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_jur_PN1<>0) {
			echo number_format(($jum_kerjasama/$frm_sc_jur_PN1)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
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
        <td nowrap valign="top">&nbsp;</td>
        <td nowrap valign="top">&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td colspan=7>
          <input name="excel" type="image" onClick="document.fexcel.action='score_scard_dosen_export.php?t=excel'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18">
      Export ke File Excel
      <input name="printer" type="image"  onClick="document.fexcel.action='score_scard_dosen_export.php?t=printer'" src="../img/print.gif" align="bottom" width="18" height="18">
      Print </td>
      </tr>
    </table></td>
  </tr>
</table>
    </FORM>
<table width="80%"  border="0" align="center" cellpadding="1" cellspacing="0">
  <tr>
    <td width="81%">
	  <form name="form2" method="post" action="view_scard_jurusan.php">
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
	
}
?>		
</body>
</html>