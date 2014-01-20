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
-->
</style>
<script language="javascript">
function Form(theForm)
{
	if(theForm.frm_s_thn.value=="")
	{
		alert("Silahkan masukkan Tahun Akademik!");
		theForm.frm_s_thn.focus()
		return(false);
	}
	
	if(theForm.frm_s_jurusan.value=="")
	{
		alert("Silahkan masukkan Jurusan!");
		theForm.frm_s_jurusan.focus();
		return(false);
	}
	
	if(theForm.frm_s_lab.value=="")
	{
		alert("Silahkan masukkan Nama Laboratorium!");
		theForm.frm_s_lab.focus();
		return(false);
	}
	
return(true);
}
</script>
<body>
<?php
f_connecting();
mysql_select_db($DB);

//echo "<br>mode=".$mode;

if ($mode=="" || $mode=="0") 
{
?>
<font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN ~</strong> 
      SCORE CARD LABORATORIUM </font></font></td>
    <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">SCORE CARD</font></strong></div></td>
  </tr>
</table>
<strong><font color="#0099CC" size="1"></font></strong> 
<hr size="1" color="#FF9900">
<form name="form_sc_lab" id="form_sc_lab" onSubmit="return Form(this)">
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
	  <select name="frm_s_thn" id="frm_s_thn" class="tekboxku">
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
      </select>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Jurusan</td>
      <td><strong>:</strong></td>
      <td><select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku">
        <option value="">Pilih
        <?php
				 $result2 = @mysql_query("SELECT * FROM `jurusan` WHERE `jurusan`.id>0 AND `jurusan`.id<6");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["id"].">".$row2["jurusan"];
	             }
         	?>
            </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Nama Laboratorium </td>
      <td><strong>:</strong></td>
      <td><select name="frm_s_lab" id="frm_s_lab" class="tekboxku">
        <option value="">Pilih
        <?php
				 $result2 = @mysql_query("SELECT * FROM `master_ruang` WHERE nama LIKE '%lab%' ORDER BY kode ASC");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["id"].">".$row2["kode"]." - ".$row2["nama"];
	             }
         	?>
            </select></td>
			
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
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

   /* if ($frm_s_jurusan=='')  
	{
		//$error = 1;
		$mode="";
		$pesan=$pesan."<br>Silahkan pilih jurusan terlebih dahulu !";
		?>
			<script language="JavaScript">
				document.location="view_scard_lab.php?mode0=&pesan=<? echo $pesan?>";
			</script>
		<?
	}*/



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
?>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN ~</strong> 
      SCORE CARD LABORATORIUM</font></font></td>
    <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">SCORE CARD</font></strong></div></td>
  </tr>
</table>
<strong><font color="#0099CC" size="1"></font></strong> 
<hr size="1" color="#FF9900">
<table width="95%"  border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td>
	<?
		   $sql_jur="SELECT jurusan as nama_jur
			           FROM jurusan
			          WHERE jurusan.id=$frm_s_jurusan";
		   $res_jur = @mysql_query($sql_jur);
		   $row_jur = @mysql_fetch_array($res_jur);
		    
	?>&nbsp;
      <div align="center" class="style1">SCORE CARD<br>
        <? 
			$res_nm_lab = @mysql_query("SELECT * FROM `master_ruang` WHERE id=".$frm_s_lab);
			$row2 = mysql_fetch_array($res_nm_lab);
			echo $row2["nama"];
		?>
        <br>
        JURUSAN TEKNIK <? echo $row_jur["nama_jur"];?><br>
        <span class="style2">Tahun Akademik <? echo $frm_s_thn;?></span> </div></td>
  </tr>
  <tr>
    <td><table width="100%"  border="1" cellspacing="0" cellpadding="5">
      <tr>
        <td bgcolor="#FFFFE8"><table width="80%"  border="0" align="center" cellpadding="3" cellspacing="0">
          <tr>
            <td>NAMA LABORATORIUM </td>
            <td><strong>:</strong></td>
            <td><? echo $row2["nama"];?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="31%">NAMA KEPALA LABORATORIUM</td>
            <td width="2%"><strong>:</strong></td>
            <td width="67%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>JUMLAH DOSEN S1/S2/S3 </td>
            <td><strong>:</strong></td>
            <td><? echo $jum_dsn_s1." / ".$jum_dsn_s2." / ".$jum_dsn_s3;?></td>
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
            <td>MATA KULIAH YANG DI KELOLA</td>
            <td><strong>:</strong></td>
            <td rowspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
    <td width="81%">&nbsp;</td>
    <td width="19%" align="right">
	<form name="form1" method="post" action="view_scard_lab.php">
	      <input type="hidden" name="frm_s_thn" id="frm_s_thn" value="<? echo $frm_s_thn;?>">
	      <input type="hidden" name="jum_dsn_s3" id="jum_dsn_s3" value="<? echo $jum_dsn_s3;?>">
		  <input type="hidden" name="jum_tng_akademik" id="jum_tng_akademik" value="<? echo $jum_tng_akademik;?>">
		  <input type="hidden" name="hasil_dsn_s3" id="hasil_dsn_s3" value="<? echo $hasil_dsn_s3;?>">
		  
		  <input type="hidden" name="mode" id="mode" value="2">
		  <input type="hidden" name="thn" id="thn" value="<? echo $frm_s_thn;?>">
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
}
else if ($mode=="2") 
{
// LAPORAN YANG DIHASILKAN
?>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN 
      ~</strong> SCORE CARD LABORATORIUM </font></font></td>
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
$result1 = mysql_query("SELECT count( * ) as jum_dsn_s3
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
}
//END JUMLAH DOSEN S-3 : JUMLAH DOSEN


//JUMLAH LAYANAN INDUSTRI
switch ($frm_s_thn) {
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

// JUMLAH GRANT YG DITERIMA
$result = mysql_query("SELECT Sum(grant_prodi.jumlah) as tot_grant
						 FROM grant_prodi
						WHERE grant_prodi.tgl_awal between '".$tgl_1."' and '".$tgl_2."' AND
						      grant_prodi.jurusan_id=$frm_s_jurusan");
if ($row_grant = mysql_fetch_array($result)) {
 $jum_grant_prodi=$row_grant["tot_grant"];
  echo "<br>jum_grant_prodi=".$jum_grant_prodi;
}
//END JUMLAH GRANT YG DITERIMA


//RATA-RATA IPK LULUSAN berdasarkan tahun
/*switch ($frm_s_thn) {
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
  echo "rata_IPK_lulusan=".$rata_IPK_lulusan;
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
  echo "<br>jum_lulusan_IPK3=".$jum_lulusan_IPK3;
}

$result = mysql_query("SELECT count(*) as jum_mhs
						 FROM master_alumni
						WHERE master_alumni.tanggal_lulus between '2001-01-01' and '2001-12-31'");
if ($row = mysql_fetch_array($result)) {
  $jum_lulusan_IPK=$row["jum_mhs"];
  echo "<br>jum_lulusan_IPK=".$jum_lulusan_IPK;
  $persen_IPK3=($jum_lulusan_IPK3/$jum_lulusan_IPK)*100;
  echo "<br>persen_IPK3=".$persen_IPK3;
}

//END PERSENTASI LULUSAN DENGAN IPK >= 3,00

// PERSENTASI LULUSAN DENGAN MASA STUDI <= 4 TAHUN
$result = mysql_query("SELECT count(*) as jum_mhs
						 FROM master_alumni
						WHERE master_alumni.tanggal_lulus between '2001-01-01' and '2001-12-31' AND
						      master_alumni.masa_studi <= 8");
if ($row = mysql_fetch_array($result)) {
  $jum_masa_studi4thn=$row["jum_mhs"];
  echo "<br>jum_masa_studi4thn=".$jum_masa_studi4thn;
  $persen_studi4thn=($jum_masa_studi4thn/$jum_lulusan_IPK)*100;
  echo "<br>persen_studi4thn=".$persen_studi4thn;
}
//END PERSENTASI LULUSAN DENGAN MASA STUDI <= 4 TAHUN

// PERSENTASI RATA-RATA GAJI PERTAMA ALUMNI
$result = mysql_query("SELECT avg(gaji.id) as rata
						 FROM master_alumni, gaji
						WHERE master_alumni.tanggal_lulus between '2001-01-01' and '2001-12-31' AND
						      master_alumni.gaji_pertama = gaji.id");
if ($row = mysql_fetch_array($result)) {
  $rata2_gaji_alumni=round($row["rata"]);
  echo "<br>rata2_gaji_alumni=".$rata2_gaji_alumni;
		  $result2 = mysql_query("SELECT gaji
							 FROM gaji
							WHERE gaji.id=$rata2_gaji_alumni");
		if ($row2 = mysql_fetch_array($result2)) {
		  $rata2_gaji_alumni_riil=$row2["gaji"];
		  echo "<br>rata2_gaji_alumni_riil=".$rata2_gaji_alumni_riil;
		  
		}
}
//END RATA-RATA GAJI PERTAMA ALUMNI

// Rasio DO : mhs aktif
$result = mysql_query("SELECT jum_mhs_DO, jum_mhs_aktif
						 FROM do
						WHERE do.semester LIKE '".$frm_s_thn."%'");
if ($row = mysql_fetch_array($result)) {
  $jum_mhs_DO=$row["jum_kerjasama"];
  echo "<br>jum_mhs_DO=".$jum_mhs_DO;
}
//END Rasio DO : mhs aktif

// Rasio PO : mhs aktif
$result = mysql_query("SELECT jum_mhs_PO, jum_mhs_aktif
						 FROM po
						WHERE po.semester LIKE '".$frm_s_thn."%'");
if ($row = mysql_fetch_array($result)) {
  $jum_mhs_PO=$row["jum_kerjasama"];
  echo "<br>jum_mhs_PO=".$jum_mhs_PO;
}
//END Rasio PO : mhs aktif


// JUMLAH KERJASAMA DENGAN PIHAK LUAR
$result = mysql_query("SELECT count(*) as jum_kerjasama
						 FROM profil_kerjasama
						WHERE profil_kerjasama.mulai between '".$tgl_1."' and '".$tgl_2."' AND
						      profil_kerjasama.jurusan=$frm_s_jurusan");
if ($row = mysql_fetch_array($result)) {
  $jum_kerjasama=$row["jum_kerjasama"];
  echo "<br>jum_kerjasama=".$jum_kerjasama;
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
  echo "<br>rata_tunggu_kerja=".$rata_tunggu_kerja;
	
}
//END RATA-RATA MASA TUNGGU DAPAT KERJA



// JUMLAH MAHASISWA BARU PER TAHUN
$result = mysql_query("SELECT maharu.jum_mhs
						 FROM maharu
						WHERE maharu.angkatan = '".$frm_s_thn."'");
						
if ($row = mysql_fetch_array($result)) {
  $jum_mhs_perTahun=$row["jum_mhs"];
  echo "<br>jum_mhs_perTahun=".$jum_mhs_perTahun;
}
//END JUMLAH MAHASISWA BARU PER TAHUN


// JUMLAH PENELITIAN PER TAHUN
$result_penil = mysql_query("SELECT count(*) as jum_penelitian
						 FROM penelitian
						WHERE penelitian.tanggal_mulai between '".$tgl_1."' and '".$tgl_2."'AND
							  penelitian.jurusan_id=$frm_s_jurusan");
						
if ($row_penil = mysql_fetch_array($result_penil)) {
  $jum_penil=$row_penil["jum_penelitian"];
  echo "<br>jum_penil=".$jum_penil;
}
//END JUMLAH PENELITIAN PER TAHUN

// JUMLAH PUBLIKASI JURNAL NASIONAL TERAKREDITASI PER TAHUN
$result_pub_status = mysql_query("SELECT id_pub, nama
						            FROM status_publikasi
								   WHERE status_publikasi.nama='Nasional'");
						
if ($row_pub_status = mysql_fetch_array($result_pub_status)) {
   $status_pub1=$row_pub_status["id_pub"];
   echo "<br>status_pub1=".$status_pub1;
}

$result_pub_jurnal_nas = mysql_query("SELECT count(*) as jum_jurnal_nasional
						                FROM penelitian
						               WHERE penelitian.pub_tanggal between '".$tgl_1."' and '".$tgl_2."' AND
									   		 penelitian.jurusan_id=$frm_s_jurusan AND
						                     penelitian.publikasi=$status_pub1");
						
if ($row_pub_jurnal_nas = mysql_fetch_array($result_pub_jurnal_nas)) {
  $jum_pub_jurnal_nas=$row_pub_jurnal_nas["jum_jurnal_nasional"];
  echo "<br>jum_pub_jurnal_nas=".$jum_pub_jurnal_nas;
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
									         penelitian.jurusan_id=$frm_s_jurusan AND
						                     penelitian.publikasi=$status_pub1");
						
if ($row_pub_jurnal_inter = mysql_fetch_array($result_pub_jurnal_inter)) {
  $jum_pub_jurnal_inter=$row_pub_jurnal_inter["jum_jurnal_internasional"];
  echo "<br>jum_pub_jurnal_inter=".$jum_pub_jurnal_inter;
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
  echo "<br>jum_row_pub_prosiding_nas=".$jum_pub_prosiding_nas;
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
  echo "<br>jum_pub_prosiding_inter=".$jum_pub_prosiding_inter;
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
  echo "<br>jum_PATEN=".$jum_PATEN;
}
//END PATEN PENELITIAN


// JUMLAH DANA PENELITIAN DARI PIHAK EXTERNAL
$result_dana_ext = mysql_query("SELECT count(*) as jum_dana_ext
						 FROM penelitian
						WHERE penelitian.tanggal_mulai between '".$tgl_1."' and '".$tgl_2."' and
						      penelitian.id_sumber_dana <> 5");
						
if ($row_dana_ext = mysql_fetch_array($result_dana_ext)) {
  $jum_dana_external=$row_dana_ext["jum_dana_ext"];
  echo "<br>jum_dana_external=".$jum_dana_external;
}
//END JUMLAH DANA PENELITIAN DARI PIHAK EXTERNAL

// BEGIN TARGET SC LAB
$res_target_sc_lab = mysql_query("SELECT *
								    FROM sc_lab
								   WHERE tahun=$frm_thn");
				
						if ($row = mysql_fetch_array($res_target_sc_lab)) {
							$frm_exist=1;
							$frm_id_sc_lab=1;
							$frm_sc_lab_LD1=$row["LD1"];
							$frm_sc_lab_LD2=$row["LD2"];
							$frm_sc_lab_LD3=$row["LD3"];
							$frm_sc_lab_LD4=$row["LD4"];
							$frm_sc_lab_LD5=$row["LD5"];
							$frm_sc_lab_LD6=$row["LD6"];
							$frm_sc_lab_LD7=$row["LD7"];
							$frm_sc_lab_LD8=$row["LD8"];
							$frm_sc_lab_LD9=$row["LD9"];
							
							$frm_sc_lab_S1=$row["SUS1"];
							
							$frm_sc_lab_P1=$row["PRO1"];
							
							$frm_sc_lab_M1=$row["MAN1"];
							$frm_sc_lab_M2=$row["MAN2"];
							
							$frm_sc_lab_PN1=$row["PN1"];
						}
						else
						{
							$frm_exist=0;
							$frm_sc_lab_LD1=0;
							$frm_sc_lab_LD2=0;
							$frm_sc_lab_LD3=0;
							$frm_sc_lab_LD4=0;
							$frm_sc_lab_LD5=0;
							$frm_sc_lab_LD6=0;
							$frm_sc_lab_LD7=0;
							$frm_sc_lab_LD8=0;
							$frm_sc_lab_LD9=0;
							
							$frm_sc_lab_S1=0;
							
							$frm_sc_lab_P1=0;
							
							$frm_sc_lab_M1=0;
							$frm_sc_lab_M2=0;
							
							$frm_sc_lab_PN1=0;
						}
// END TARGET SC LAB


?>
<strong><? echo "<br>Periode:".$frm_s_thn;?></strong>
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
        <td valign="top" nowrap><? echo $frm_sc_lab_LD1;?></td>
        <td valign="top" nowrap><? echo $jum_penil;?></td>
        <td valign="top" nowrap>
		<? 
		if ($frm_sc_lab_LD1<>0) {
			echo number_format(($jum_penil/$frm_sc_lab_LD1)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        <td rowspan="9" valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td nowrap valign="top">2</td>
        <td nowrap valign="top">Jumlah publikasi jurnal nasional terakreditasi </td>
        <td valign="top" nowrap><? echo $frm_sc_lab_LD2;?></td>
        <td valign="top" nowrap><? echo $jum_pub_jurnal_nas;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_lab_LD2<>0) {
			echo number_format(($jum_pub_jurnal_nas/$frm_sc_lab_LD2)*100, 3,'.',''); 
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
        <td valign="top" nowrap><? echo $frm_sc_lab_LD3;?></td>
        <td valign="top" nowrap><? echo $jum_pub_jurnal_inter;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_lab_LD3<>0) {
			echo number_format(($jum_pub_jurnal_inter/$frm_sc_lab_LD3)*100, 3,'.',''); 
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
        <td valign="top" nowrap><? echo $frm_sc_lab_LD4;?></td>
        <td valign="top" nowrap><? echo $jum_pub_prosiding_nas;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_lab_LD4<>0) {
			echo number_format(($jum_pub_prosiding_nas/$frm_sc_lab_LD4)*100, 3,'.',''); 
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
        <td valign="top" nowrap><? echo $frm_sc_lab_LD5;?></td>
        <td valign="top" nowrap><? echo $jum_pub_prosiding_inter;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_lab_LD5<>0) {
			echo number_format(($jum_pub_prosiding_inter/$frm_sc_lab_LD5)*100, 3,'.',''); 
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
        <td valign="top" nowrap><? echo $frm_sc_lab_LD6;?></td>
        <td valign="top" nowrap><? echo $jum_PATEN;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_lab_LD6<>0) {
			echo number_format(($jum_PATEN/$frm_sc_lab_LD6)*100, 3,'.',''); 
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
        <td valign="top" nowrap><? echo $frm_sc_lab_LD7;?></td>
        <td valign="top" nowrap><? echo $jum_layanan_industri;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_lab_LD7<>0) {
			echo number_format(($jum_layanan_industri/$frm_sc_lab_LD7)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">8</td>
        <td nowrap valign="top">Jumlah grant yang diterima </td>
        <td valign="top" nowrap><? echo $frm_sc_lab_LD8;?></td>
        <td valign="top" nowrap><? echo $jum_grant_prodi;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_lab_LD8<>0) {
			echo number_format(($jum_grant_prodi/$frm_sc_lab_LD8)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">9</td>
        <td nowrap valign="top">Rata-rata indeks pembelajaran per jurusan (dosen tetap) </td>
        <td valign="top" nowrap><? echo $frm_sc_lab_LD9;?></td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        </tr>
      <tr bgcolor="#CCCCCC">
        <td colspan="6" valign="top" nowrap><em>Isu Strategis:</em> <strong>Sustainability</strong> </td>
      </tr>
      <tr>
        <td nowrap valign="top">10</td>
        <td nowrap valign="top">Jumlah dana penelitian dari pihak eksternal</td>
        <td valign="top" nowrap><? echo $frm_sc_lab_S1;?></td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td colspan="6" valign="top" nowrap><em>Isu Strategis:</em> <strong>Promotion</strong></td>
      </tr>
      <tr>
        <td nowrap valign="top">11</td>
        <td nowrap valign="top">Jumlah buku yang ditulis dosen dan diterbitkan</td>
        <td valign="top" nowrap><? echo $frm_sc_lab_P1;?></td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td colspan="6" valign="top" nowrap><em>Isu Strategis:</em> <strong>Management</strong> </td>
      </tr>
      <tr>
        <td nowrap valign="top">12</td>
        <td nowrap valign="top"><img src="../img/sigma.gif" width="10" height="12" align="absbottom"> dosen S3(<? echo $jum_dsn_s3;?>) : <img src="../img/sigma.gif" width="10" height="12" align="absbottom"> dosen(<? echo $jum_dsn;?>)</td>
        <td valign="top" nowrap><? echo $frm_sc_lab_M1;?></td>
        <td valign="top" nowrap><? echo number_format($hasil_dsn_s3, 3,'.','') ;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_lab_M1<>0) {
			echo number_format(($hasil_dsn_s3/$frm_sc_lab_M1)*100, 3,'.',''); 
		}
		else
		{
		  echo "-";
		}
		?></td>
        <td rowspan="2" valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td nowrap valign="top">13</td>
        <td nowrap valign="top">Tingkat kepuasan layanan administrasi</td>
        <td valign="top" nowrap><? echo $frm_sc_lab_M2;?></td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        </tr>
      <tr bgcolor="#CCCCCC">
        <td colspan="6" valign="top" nowrap><em>Isu Strategis: </em><strong>Partnership &amp; Networking </strong></td>
      </tr>
      <tr>
        <td nowrap valign="top">14</td>
        <td nowrap valign="top">Jumlah Kerjasama</td>
        <td valign="top" nowrap><? echo $frm_sc_lab_PN1;?></td>
        <td valign="top" nowrap><? echo $jum_kerjasama;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_lab_PN1<>0) {
			echo number_format(($jum_kerjasama/$frm_sc_lab_PN1)*100, 3,'.',''); 
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
        <td colspan=7>
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
    <td width="35%">
	  <form name="form1" method="post" action="view_scard_lab.php">
	      <input type="hidden" name="frm_s_thn" id="frm_s_thn" value="<? echo $frm_s_thn;?>">
		  <input type="hidden" name="mode" id="mode" value="1">
		  <input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<? echo $frm_s_jurusan;?>">
 		  <input type="submit" name="Submit" id="Submit" value="<< Sebelumnya">
      </form>
	</td>
    <td width="65%">&nbsp;</td>
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