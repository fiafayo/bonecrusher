<?php
/* 
   DATE CREATED : 20/11/07
   KEGUNAAN     : MENAMPILKAN RIWAYAT PENDIDIKAN DOSEN
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
      ~</strong> RIWAYAT PENDIDIKAN DOSEN</font></font> </td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">DOSEN</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form>
  <table width="80%" align="center" class="body" >
    <tr> 
      <td width="26%">Jurusan</td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td width="71%">
	    
		<select name="frm_s_jurusan" class="tekboxku">
          <option value="all">Semua 
          <?php
  	             $result2 = @mysql_query("SELECT * FROM `jurusan` WHERE `jurusan`.id>0 AND `jurusan`.id<9");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["id"].">".$row2["jurusan"];
	             }
         	?>
        </select></td>
    </tr>
    <tr> 
      <td>NPK Dosen</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_s_kode_dosen" type="text" class="tekboxku" id="frm_s_kode_dosen" size="8" maxlength="6"></td>
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
/*$sql="select ta.*,
			 master_karyawan.id as id_karyawan
	  from ta, master_karyawan
	  where (ta.id_dosen1=master_karyawan.id or ta.id_dosen1=master_karyawan.kode) ";*/
	        
$sql="SELECT riwayat_pendidikan.id_riwayat,
			 riwayat_pendidikan.kode_dosen,
			 riwayat_pendidikan.jurusan,
			 riwayat_pendidikan.jenjang,
			 riwayat_pendidikan.universitas,
			 riwayat_pendidikan.prodi,
			 riwayat_pendidikan.sumber_dana,
			 riwayat_pendidikan.tahun_selesai,
			 jurusan.jurusan as nama_jur,
			 dosen.nama
	    FROM riwayat_pendidikan,jurusan,dosen
		WHERE riwayat_pendidikan.jurusan=jurusan.id AND
		      riwayat_pendidikan.kode_dosen=dosen.kode ";
	  
if ($mode=="2" || $mode=="3" || $mode=="4")
{
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
	if ($frm_s_kode_dosen!="")
	{
		 $sql .= " and (riwayat_pendidikan.kode_dosen='".$frm_s_kode_dosen."')";
	}
	if ($frm_s_jurusan!="all")
	{ 
		 $sql .= " and (riwayat_pendidikan.jurusan='".$frm_s_jurusan."')";
	}
//echo "<br>SQL= ".$sql;
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

$vlink="lap_riwayat_didik_dosen.php";
$abc="?mode=2&frm_s_jurusan=$frm_s_jurusan&frm_s_kode_dosen=$frm_s_kode_dosen&frm_s_jum_data=$frm_s_jum_data";

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
      ~</strong> RIWAYAT PENDIDIKAN DOSEN</font> </td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">DOSEN</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div>
<?

if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="lap_riwayat_didik_dosen.php">

<input type="hidden" name="mode" value="3">
<input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
<input type="hidden" name="frm_s_kode_dosen" id="frm_s_kode_dosen" value="<?php echo $frm_s_kode_dosen; ?>">
<input type="hidden" name="frm_s_jum_data" id="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<?
}
if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=lap_riwayat_didik_dosen.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}
if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
	<table width="100%" border="1" cellpadding="5" cellspacing="0" class="table">
      <tr bgcolor="#C6E2FF">
        <td><strong>Jurusan</strong></td>
        <td><strong>Kode</strong></td>
        <td><strong>Nama</strong></td>
        <td><strong>Jenjang</strong></td>
        <td><strong>Universitas</strong></td>
        <td><strong>Program Studi</strong></td>
        <td><strong>Sumber dana </strong></td>
        <td nowrap><strong>Tahun Selesai</strong></td>
      </tr>
      <?
			$a=0;
			while(($row = mysql_fetch_array($result)))
			{
			$a++;
		?>
      <tr>
        <td width=6% nowrap><? echo $row["nama_jur"];?></td>
        <td width=4% nowrap><? echo $row["kode_dosen"];?></td>
        <td width="4%" nowrap><? echo $row["nama"];?></td>
        <td width="5%" nowrap align="center"><? echo $row["jenjang"];?></td>
        <td width="28%" nowrap><? echo $row["universitas"];?></td>
        <td width="17%" nowrap><? echo $row["prodi"];?></td>
        <td width="17%" nowrap><? echo $row["sumber_dana"];?></td>
        <td width="19%" nowrap align="center"><? echo $row["tahun_selesai"];?></td>
      </tr>
      <?
			}
			?>
      <tr>
        <td colspan="8" nowrap><input name="excel"   type="image" onClick="document.fexcel.action='lap_riwayat_didik_dosen_export.php?t=excel'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18">
      Export ke File Excel&nbsp;
      <input name="printer" type="image"  onClick="document.fexcel.action='lap_riwayat_didik_dosen_export.php?t=printer'" src="../img/print.gif" align="bottom" width="18" height="18">
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