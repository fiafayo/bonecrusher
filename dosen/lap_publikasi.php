<?php
/* 
   DATE CREATED : 10/08/07
        UPDATES : 28/11/08
   KEGUNAAN: MENAMPILKAN LAPORAN SURAT TUGAS PUBLIKASI DOSEN
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

?>
<html>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../include/tanggalan.js">
</script>
<body class="body">
<?php
f_connecting();
if ($mode=="" || $mode=="0") 
{
?>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN ~</strong> 
      PUBLIKASI</font></font></td>
    <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">DOSEN</font></strong></div></td>
  </tr>
</table>
<strong><font color="#0099CC" size="1"></font></strong> 
<hr size="1" color="#FF9900">
<form name="form_lap_publikasi" id="form_lap_publikasi">
  <table width="100%" class="body">
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="9%">&nbsp;</td> 
      <td width="19%">Tanggal Publikasi </td>
      <td width="2%"><strong>:</strong></td>
      <td width="70%"><input name="frm_s_tgl_publikasi1" type="text" class="tekboxku" id="frm_s_tgl_publikasi1" size="10" maxlength="10">
        <A Href="javascript:show_calendar('form_lap_publikasi.frm_s_tgl_publikasi1',0,0,'DD/MM/YYYY')"> <img src="../img/date.png" width="22" height="22" align="absbottom" border=0></A> -
        <input name="frm_s_tgl_publikasi2" type="text" class="tekboxku" id="frm_s_tgl_publikasi2" size="10" maxlength="10">
        <A Href="javascript:show_calendar('form_lap_publikasi.frm_s_tgl_publikasi2',0,0,'DD/MM/YYYY')"> <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy)</td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal Terbit </td>
      <td><strong>:</strong></td>
      <td><input name="frm_s_tgl_terbit1" type="text" class="tekboxku" id="frm_s_tgl_terbit1" size="10" maxlength="10">
        <A Href="javascript:show_calendar('form_lap_publikasi.frm_s_tgl_terbit1',0,0,'DD/MM/YYYY')"> <img src="../img/date.png" width="22" height="22" align="absbottom" border=0></A> -
        <input name="frm_s_tgl_terbit2" type="text" class="tekboxku" id="frm_s_tgl_terbit2" size="10" maxlength="10">
        <A Href="javascript:show_calendar('form_lap_publikasi.frm_s_tgl_terbit2',0,0,'DD/MM/YYYY')"> <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy)</td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Jurusan</td>
      <td><strong>:</strong></td>
      <td> <select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku">
          <option value="all">Semua 
          <?php
				// f_connecting();
				 mysql_select_db($DB);
				 $result3 = @mysql_query("SELECT * FROM jurusan WHERE `jurusan`.id<>0 ORDER BY id ASC");
				 while(($row3 = mysql_fetch_array($result3)))
				 {
				    echo "<option value=".$row3["id"].">".$row3["jurusan"];
				 }
			?>
        </select> </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>No Surat Tugas </td>
      <td><strong>:</strong></td>
      <td><input name="frm_s_no_st_pub" id="frm_s_no_st_pub" type="text" size="25" maxlength="25" class="tekboxku"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>NPK Dosen</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="frm_s_kode" id="frm_s_kode" class="tekboxku" size="25"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nama</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="frm_s_nama" id="frm_s_nama" class="tekboxku" size="25"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Judul</td>
      <td><strong>:</strong></td>
      <td><input name="frm_s_judul" type="text" class="tekboxku" id="frm_s_judul" size="50"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Skala Publikasi</td>
      <td><strong>:</strong></td>
      <td><? //echo "<br>frm_s_ska_publikasi=".$frm_s_ska_publikasi;?>
        <select name="frm_s_ska_publikasi" id="frm_s_ska_publikasi" class="tekboxku">
          <option value="0" <?php if ($frm_s_ska_publikasi==0){echo "selected";}?>>Tidak ada data</option>
          <option value="1" <?php if ($frm_s_ska_publikasi==1){echo "selected";}?>>Regional</option>
          <option value="2" <?php if ($frm_s_ska_publikasi==2){echo "selected";}?>>Nasional</option>
          <option value="3" <?php if ($frm_s_ska_publikasi==3){echo "selected";}?>>Internasional</option>
        </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tipe Publikasi </td>
      <td><strong>:</strong></td>
      <td><? //echo "pub=".$frm_tipe_publikasi;?>
        <select name="frm_tipe_publikasi" id="frm_tipe_publikasi" class="tekboxku">
          <option value=0 <?php if ($frm_tipe_publikasi==0){echo "selected";}?>>Tidak ada data</option>
          <option value=1 <?php if ($frm_tipe_publikasi==1){echo "selected";}?>>Jurnal</option>
          <option value=2 <?php if ($frm_tipe_publikasi==2){echo "selected";}?>>Prosiding</option>
        </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Sumber Dana</td>
      <td><strong>:</strong></td>
      <td> <select name="frm_s_sumber_dana" id="frm_s_sumber_dana" class="tekboxku">
          <option value="all">Semua 
          <?
			
			$sql2="select * from sumber_dana";
			if(!($result2=mysql_db_query($DB,$sql2)))
			{
				echo mysql_error();
        			return 0;
			}
			while(($row2 = mysql_fetch_array($result2)))
			{
				echo "<option value=".$row2["id"].">".$row2["nama"];
			}
?>
        </select> </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Mandiri/Kelompok</td>
      <td><strong>:</strong></td>
      <td><select name="frm_s_sifat_pen" id="frm_s_sifat_pen" class="tekboxku">
        <option value="all">Semua</option>
        <option value="1">Mandiri</option>
        <option value="2">Kelompok</option>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td nowrap><i>Banyak Data yang ditampilkan</i></td>
      <td><strong>:</strong></td>
      <td> <select name="frm_s_jum_data" id="frm_s_jum_data" class="tekboxku">
          <option value=10>10 
          <option value=15>15 
          <option value=20 selected>20 </select> </td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <!--tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap><b>KRITERIA PENGURUTAN DATA</b></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td height="25">&nbsp;</td> 
      <td>Pengurutan 1</td>
      <td><strong>:</strong></td>
      <td><select name="frm_o1" id="frm_o1" class="tekboxku">
          <option value="penelitian.tanggal_mulai">Tanggal Mulai 
          <option value="penelitian.tanggal_selesai">Tanggal Selesai 
          <option value="master_karyawan.kode">NPK Dosen
          <option value="penelitian.judul">Judul 
          <option value="sumber_dana.nama">Sumber Dana </select> </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Pengurutan 2</td>
      <td><strong>:</strong></td>
      <td><select name="frm_o2" id="frm_o2" class="tekboxku">
          <option value="penelitian.tanggal_mulai">Tanggal Mulai 
          <option value="penelitian.tanggal_selesai">Tanggal Selesai 
          <option value="master_karyawan.kode">NPK Dosen
          <option value="penelitian.judul">Judul 
          <option value="sumber_dana.nama">Sumber Dana </select> </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Pengurutan 3</td>
      <td><strong>:</strong></td>
      <td><select name="frm_o3" id="frm_o3" class="tekboxku">
          <option value="penelitian.tanggal_mulai">Tanggal Mulai 
          <option value="penelitian.tanggal_selesai">Tanggal Selesai 
          <option value="master_karyawan.kode">NPK Dosen
          <option value="penelitian.judul">Judul 
          <option value="sumber_dana.nama">Sumber Dana </select> </td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr-->
    <tr>
      <td></td> 
      <td></td>
      <td><input type="hidden" name="mode" id="mode" value="2"></td>
      <td><input type="submit" value="Proses" class="tombol"></td>
    </tr>
  </table>
</form>
<?
}
else
{
// JIKA MODE<>0 MAKSUDNYA JIKA FORM DI SUBMIT MAKA KELUAR LAPORAN
 /*$sql="SELECT publikasi.no_st_pub,
			  publikasi.urut_st_pub,
			  publikasi.kode_kary,
			  publikasi.kode_kary2,
			  publikasi.kode_kary3,
			  publikasi.kode_kary4,
			  publikasi.kode_kary5,
			  publikasi.status,
			  publikasi.jenis,
			  publikasi.TET_sub,
			  publikasi.TNET_sub,
			  publikasi.tugas,
			  publikasi.hari_go,
			  DATE_FORMAT(publikasi.tgl_go,'%d/%m/%Y') as tgl_go,
			  publikasi.pukul_go,
			  publikasi.tempat_go,
			  publikasi.transport_go,
			  publikasi.hari_dtg,
			  DATE_FORMAT(publikasi.tgl_dtg,'%d/%m/%Y') as tgl_dtg,
			  publikasi.pukul_dtg,
			  publikasi.transport_dtg,
			  publikasi.biaya,
			  publikasi.L_ap_tax,
			  publikasi.L_fiskal,
			  publikasi.L_visa,
			  publikasi.L_saku,
			  publikasi.L_akomo,
			  publikasi.L_other,
			  publikasi.ndt_terakhir,
			  tulisan_ilmiah.kode_dosen1,
			  tulisan_ilmiah.kode_dosen2,
			  tulisan_ilmiah.kode_dosen3,
			  tulisan_ilmiah.kode_dosen4,
			  tulisan_ilmiah.kode_dosen5,
			  tulisan_ilmiah.publikasi,
			  tulisan_ilmiah.jurn_pros,
			  tulisan_ilmiah.jurusan_id,
			  tulisan_ilmiah.man_kel,
			  tulisan_ilmiah.judul,
			  tulisan_ilmiah.pub_ISBN,
			  tulisan_ilmiah.pub_volume,
			  tulisan_ilmiah.pub_penyelenggara,
			  DATE_FORMAT(tulisan_ilmiah.pub_tanggal,'%d/%m/%Y') as pub_tanggal,
			  tulisan_ilmiah.no_paten,
			  tulisan_ilmiah.pemberi_paten,
			  DATE_FORMAT(tulisan_ilmiah.tanggal_terbit,'%d/%m/%Y') as tanggal_terbit,
			  tulisan_ilmiah.id_sumber_dana,
			  tulisan_ilmiah.dana,
			  tulisan_ilmiah.dana_asing,
			  tulisan_ilmiah.kode_dosen1,
			  tulisan_ilmiah.kode_dosen2,
			  tulisan_ilmiah.kode_dosen3,
			  tulisan_ilmiah.kode_dosen4,
			  tulisan_ilmiah.kode_dosen5
		 FROM publikasi, tulisan_ilmiah
	    WHERE tulisan_ilmiah.judul <>'' ";	*/
			 
                   $sql="SELECT publikasi.no_legalitas,
								publikasi.no_st_pub,
								publikasi.urut_st_pub,
								publikasi.jenis,
								publikasi.publikasi,
								DATE_FORMAT(publikasi.tgl_publikasi,'%d/%m/%Y') as tgl_publikasi,
								DATE_FORMAT(publikasi.tgl_publikasi2,'%d/%m/%Y') as tgl_publikasi2,
								publikasi.jurn_pros,
								publikasi.kode_kary,
								publikasi.kode_kary2,
								publikasi.kode_kary3,
								publikasi.kode_kary4,
								publikasi.kode_kary5,
								publikasi.status,
								publikasi.TET_sub,
								publikasi.TNET_sub,
								publikasi.judul,
								publikasi.tugas,
								publikasi.pub_ISBN,
								publikasi.pub_volume,
								publikasi.pub_penyelenggara,
								DATE_FORMAT(publikasi.pub_tgl_pub,'%d/%m/%Y') as pub_tgl_pub,
								publikasi.pub_no_paten,
								publikasi.pub_pemberi_paten,
								DATE_FORMAT(publikasi.pub_tgl_paten,'%d/%m/%Y') as pub_tgl_paten,
								publikasi.pub_id_sumber_dana,
								publikasi.pub_jum_dana_lokal,
								publikasi.pub_jum_dana_asing,
								publikasi.hari_go,
								DATE_FORMAT(publikasi.tgl_go,'%d/%m/%Y') as tgl_go,
								publikasi.pukul_go,
								publikasi.tempat_go,
								publikasi.transport_go,
								publikasi.hari_dtg,
								DATE_FORMAT(publikasi.tgl_dtg,'%d/%m/%Y') as tgl_dtg,
								publikasi.pukul_dtg,
								publikasi.transport_dtg,
								publikasi.biaya,
								publikasi.L_ap_tax,
								publikasi.L_fiskal,
								publikasi.L_visa,
								publikasi.L_saku,
								publikasi.L_akomo,
								publikasi.L_other,
								publikasi.ndt_terakhir,
								publikasi.last_update
					       FROM publikasi
						  WHERE publikasi.tugas <>'' ";
					   // WHERE publikasi.no_st_pub <>''";
			

if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_s_tgl_publikasi1!="" || $frm_s_tgl_publikasi2!="")
	{  
		if($frm_s_tgl_publikasi1!="" && $frm_s_tgl_publikasi2!="")
		{ $sql=$sql." and publikasi.tgl_publikasi between '".datetomysql($frm_s_tgl_publikasi1)."' and '".datetomysql($frm_s_tgl_publikasi2)."'"; }
		else
		{
			if($frm_s_tgl_publikasi1!="")
			{ $sql=$sql." and publikasi.tgl_publikasi >='".datetomysql($frm_s_tgl_publikasi1)."'"; }
			if($frm_s_tgl_publikasi2!="")
			{ $sql=$sql." and publikasi.tgl_publikasi <='".datetomysql($frm_s_tgl_publikasi2)."'"; }
		}
	}	
	if ($frm_s_tgl_terbit1!="" || $frm_s_tgl_terbit2!="")
	{  
		if($frm_s_tgl_terbit1!="" && $frm_s_tgl_terbit2!="")
		{ $sql=$sql." and publikasi.pub_tgl_paten between '".datetomysql($frm_s_tgl_terbit1)."' and '".datetomysql($frm_s_tgl_terbit2)."'"; }
		else
		{
			if($frm_s_tgl_terbit1!="")
			{ $sql=$sql." and publikasi.pub_tgl_paten>='".datetomysql($frm_s_tgl_terbit1)."'"; }
			if($frm_s_tgl_terbit2!="")
			{ $sql=$sql." and publikasi.pub_tgl_paten<='".datetomysql($frm_s_tgl_terbit2)."'"; }
		}
	}
	//echo "<br>frm_s_jurusan=".$frm_s_jurusan;
	//exit();
	if ($frm_s_jurusan != "all")
	{ $sql.=" and publikasi.TET_sub=".$frm_s_jurusan;}	
	
	if ($frm_s_no_st_pub!="")
	{ $sql=$sql." and publikasi.no_st_pub='".$frm_s_no_st_pub."'"; } 
	
	if ($frm_s_kode!="")
	{ $sql=$sql." and ((publikasi.kode_kary like '%".$frm_s_kode."%') or 
					   (publikasi.kode_kary2 like '%".$frm_s_kode."%') or
					   (publikasi.kode_kary3 like '%".$frm_s_kode."%') or
				       (publikasi.kode_kary4 like '%".$frm_s_kode."%') or
					   (publikasi.kode_kary5 like '%".$frm_s_kode."%'))"; } 
	if ($frm_s_nama!="")
	{ 
	  $sql_kode_dosen="SELECT kode
						 FROM dosen
					    WHERE nama LIKE '%".$frm_s_nama."%'";
	  //$result_kode_dosen = @mysql_query($sql_kode_dosen);
	  if(!($result_kode_dosen = mysql_db_query($DB,$sql_kode_dosen)))
			{
				echo mysql_error();
        			return 0;
			}
	  $row_kode_dosen = mysql_fetch_array($result_kode_dosen);
	  
	  //$row_kode_dosen = @mysql_fetch_object($result_kode_dosen);

	  //echo "<br>sql_kode_dosen=".$sql_kode_dosen;
	 // echo "<br>frm_s_nama=".$frm_s_nama;
	 // echo "<br>kodenya -=".$row_kode_dosen['kode'];
	 // exit();
	  
	  $sql=$sql." and ((publikasi.kode_kary like '%".$row_kode_dosen["kode"]."%') or 
					   (publikasi.kode_kary2 like '%".$row_kode_dosen["kode"]."%') or
					   (publikasi.kode_kary3 like '%".$row_kode_dosen["kode"]."%') or
				       (publikasi.kode_kary4 like '%".$row_kode_dosen["kode"]."%') or
					   (publikasi.kode_kary5 like '%".$row_kode_dosen["kode"]."%'))"; }
	if ($frm_s_judul!="")
	{ $sql=$sql." and publikasi.judul like '%".$frm_s_judul."%'"; }
	
	if ($frm_s_sumber_dana!="all")
	{ $sql=$sql." and publikasi.pub_id_sumber_dana=".$frm_s_sumber_dana; }
	
	if ($frm_tipe_publikasi!=0) // jurnal prosiding
	{ $sql=$sql." and publikasi.jurn_pros = ".$frm_tipe_publikasi; } 
	
	if ($frm_s_sifat_pen!="all") // mandiri/kelompok
	{ $sql=$sql." and publikasi.jenis = '".$frm_s_sifat_pen."'"; } 
	
	if ($frm_s_ska_publikasi!="0") // nasional, regional, international
	{ $sql=$sql." and publikasi.publikasi = ".$frm_s_ska_publikasi; } 
	
	$sql=$sql." order by tgl_publikasi DESC ";
	
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
	//echo "<br>SQL=".$sql;
	//echo "<br>frm_tipe_publikasi=".$frm_tipe_publikasi;
	
	//exit();
}

f_connecting();

// UNTUK PAGING --------------------------------
if ($mode=="2")
{
mysql_select_db($DB);
$result=@mysql_query($sql);
$maxrows=mysql_num_rows($result);				
if($hal=="") { $hal=1; }
$recke=(($hal-1)*$frm_s_jum_data);
$limit="$recke,$frm_s_jum_data";
$jumhal=ceil($maxrows/$frm_s_jum_data);

$vlink="lap_publikasi.php";
$abc="?mode=2&frm_s_tgl_publikasi1=$frm_s_tgl_publikasi1&frm_s_tgl_publikasi2=$frm_s_tgl_publikasi2&frm_s_tgl_terbit1=$frm_s_tgl_terbit1&frm_s_tgl_terbit2=$frm_s_tgl_terbit2&frm_s_jurusan=$frm_s_jurusan&frm_s_kode=$frm_s_kode&frm_s_judul=$frm_s_judul&frm_s_sumber_dana=$frm_s_sumber_dana&frm_s_no_st_pub=$frm_s_no_st_pub&frm_s_sifat_pen=$frm_s_sifat_pen&frm_s_ska_publikasi=$frm_s_ska_publikasi&frm_tipe_publikasi=$frm_tipe_publikasi&frm_s_jum_data=$frm_s_jum_data";

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

// LAPORAN YANG DIHASILKAN
?>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN 
      ~</strong> PUBLIKASI</font></font> </td>
    <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">DOSEN</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<?
if ($frm_s_tgl_publikasi1!="" || $frm_s_tgl_publikasi2!="")
{
?>
<div align="right"><b>TANGGAL : <? echo $frm_s_tgl_publikasi1; ?> s/d <? echo $frm_s_tgl_publikasi2; ?></b></div><br>
<?
}
?>
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div><br>
<?
if (mysql_num_rows($result)==0) {
    echo "<br><font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=lap_publikasi.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}

if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="lap_penelitian_dosen_export.php">
<input type="hidden" name="mode" id="mode" value="3">
<input type="hidden" name="frm_s_sifat_pen" id="frm_s_sifat_pen" value="<?php echo $frm_s_sifat_pen; ?>">
<input type="hidden" name="frm_s_ska_publikasi" id="frm_s_ska_publikasi" value="<?php echo $frm_s_ska_publikasi; ?>">
<input type="hidden" name="frm_s_jenis_pen" id="frm_s_ska_publikasi" value="<?php echo $frm_s_jenis_pen; ?>">
<input type="hidden" name="frm_s_tgl_publikasi1" id="frm_s_tgl_publikasi1" value="<?php echo $frm_s_tgl_publikasi1; ?>">
<input type="hidden" name="frm_s_tgl_publikasi2" id="frm_s_tgl_publikasi2" value="<?php echo $frm_s_tgl_publikasi2; ?>">
<input type="hidden" name="frm_s_tgl_terbit1" id="frm_s_tgl_terbit1" value="<?php echo $frm_s_tgl_terbit1; ?>">
<input type="hidden" name="frm_s_tgl_terbit2" id="frm_s_tgl_terbit2" value="<?php echo $frm_s_tgl_terbit2; ?>">
<input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
<input type="hidden" name="frm_s_no_st_pub" id="frm_s_no_st_pub" value="<?php echo  $frm_s_no_st_pub;?>">
<input type="hidden" name="frm_s_kode" id="frm_s_kode" value="<?php echo  $frm_s_kode;?>">
<input type="hidden" name="frm_s_nama" id="frm_s_nama" value="<?php echo  $frm_s_nama;?>">
<input type="hidden" name="frm_s_judul" id="frm_s_judul" value="<?php echo $frm_s_judul;?>">
<input type="hidden" name="frm_s_sumber_dana" id="frm_s_sumber_dana" value="<?php echo  $frm_s_sumber_dana;?>">
<input type="hidden" name="frm_s_kode_buku" id="frm_s_kode_buku" value="<?php echo $frm_s_kode_buku;?>">
<input type="hidden" name="frm_s_jum_data" id="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<input type="hidden" name="frm_tipe_publikasi" id="frm_tipe_publikasi" value="<?php echo $frm_tipe_publikasi; ?>">
<input type="hidden" name="frm_o1" id="frm_o1" value="<?php echo $frm_o1; ?>">
<input type="hidden" name="frm_o2" id="frm_o2" value="<?php echo $frm_o2; ?>">
<input type="hidden" name="frm_o3" id="frm_o3" value="<?php echo $frm_o3; ?>">
<!--
<input name="excel" onClick="document.fexcel.action='penelitian_2_3_export.php?t=excel'"   type="image" src="../img/excel.gif" width="18" height="18"> Export ke File Excel
    <input name="printer"  onClick="document.fexcel.action='penelitian_2_3_export.php?t=printer'" type="image" src="../img/printer.gif" width="18" height="18"> Print
<br>
-->

<?
}
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
<table class="table"  border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="#C6E2FF">
   			<td nowrap><b>Edit/Hapus</b></td>
			<td nowrap><b>No.Surat</b></td>
			<td nowrap><b>Jurusan</b></td>
			<td nowrap><b>Dosen 1</b></td>
			<td nowrap><b>Dosen 2</b></td>
			<td nowrap><b>Dosen 3</b></td>
			<td nowrap><b>Dosen 4</b></td>
			<td nowrap><b>Dosen 5</b></td>
			<td nowrap><b>Judul</b></td>
			<td nowrap><b>Publikasi</b></td>
			<td nowrap><b>Tipe</b></td>
			<td nowrap><b>Mandiri/Kelompok</b></td>
			<td nowrap><b>ISBN/ISSN</b></td>
			<td nowrap><b>Volume</b></td>
			<td nowrap><b>Penyelenggara</b></td>
			<td nowrap><b>Tgl. Publikasi </b></td>
			<td nowrap><b>No. Hak Paten </b></td>
			<td nowrap><b>Pemberi Hak Paten </b></td>
			<td nowrap><b>Tgl. Terbit </b></td>
			<td nowrap><b>Sumber Dana </b></td>
			<td nowrap><b>Nominal Dana</b></td>
			<td nowrap><b>Nominal Dana Asing</b></td>
			<td nowrap><b>TET. sub sistem </b></td>
			<td nowrap><strong> TNET. <b>sub sistem</b></strong></td>
			<td nowrap><b>Status</b></td>
			<td nowrap><b>Tugas</b></td>
			<td nowrap><b>Hari Go </b></td>
			<td nowrap><b>Tgl. Go</b></td>
			<td nowrap><b>Pukul Go</b></td>
			<td nowrap><b>Tempat Go</b></td>
			<td nowrap><b>Transportasi Go</b></td>
			<td nowrap><b>Hari Dtg</b></td>
			<td nowrap><b>Tgl. Dtg</b></td>
			<td nowrap><b>Pukul Dtg</b></td>
			<td nowrap><b>Transportasi Dtg</b></td>
			<td nowrap><b>Biaya Program </b></td>
			<td nowrap><strong> Airport Tax </strong></td>
			<td nowrap><strong>Visa</strong></td>
			<td nowrap><strong> Akomodasi </strong></td>
			<td nowrap><strong> Fiskal Luar Negeri </strong></td>
		    <td nowrap><strong> Uang Saku (biaya hidup) </strong></td>
		    <td nowrap><strong>Lainnya</strong></td>
		    <td nowrap><strong> Non degree training terakhir </strong></td>
		</tr>
<?
while(($row = mysql_fetch_array($result)))
{
?>
		<tr>
			<? if ($mode=="2"){
			?>
			<td nowrap align="right" valign="top">
				Edit <input name="edit" onClick="document.fexcel.action='pen_st_publikasi_entry.php?frm_id_pen=<?php echo $row["id_pen"];?>&frm_s_sifat_pen=<?php echo $row["man_kel"];?>'"   type="image" src="../img/edit.png" width="16" height="16"><br>
				Hapus <input name="hapus"  onclick="if(confirm('Hapus ?')){this.form.action='pen_st_publikasi_entry.php?act=2&frm_id_pen=<?php echo $row["id_pen"];?>';this.form.submit()} else{return false};" type="image" src="../img/hapus.png" width="11" height="13"> 
			</td>
			<? }?>
			<td nowrap valign="top"><? echo $row["no_st_pub"]; ?></td>
			<td nowrap valign="top">
				<?
				$sql_nama_jurusan="SELECT id
							       FROM jurusan
							       WHERE id='".$row["TET_sub"]."'";
				$result_nama_jurusan = mysql_query($sql_nama_jurusan);
				$row_nama_jurusan = mysql_fetch_array($result_nama_jurusan);
				//echo "+".$row_nama_jurusan["id"];
				//echo "+".$row["jurusan_id"];
				
				
				switch ($row_nama_jurusan["id"]) {
					case 1:
						$nama_jurusan='TE';
						break;
					case 2:
						$nama_jurusan='TK';
						break;
					case 3:
						$nama_jurusan='TI';
						break;
					case 4:
						$nama_jurusan='IF';
						break;
					case 5:
						$nama_jurusan='TM';
						break;
					}
					echo $nama_jurusan;
			   ?>
			   <?
				$sql_nama_dosen1="SELECT nama
							       FROM dosen
							       WHERE kode='".$row["kode_kary"]."'";
				$result_nama_dosen1 = @mysql_query($sql_nama_dosen1);
				$row_nama_dosen1=@mysql_fetch_array($result_nama_dosen1);
				//echo $row_nama_dosen1["nama"];
				$sql_nama_dosen2="SELECT nama
							       FROM dosen
							       WHERE kode='".$row["kode_kary2"]."'";
				$result_nama_dosen2 = @mysql_query($sql_nama_dosen2);
				$row_nama_dosen2=@mysql_fetch_array($result_nama_dosen2);
				//echo $row_nama_dosen1["nama"];
				$sql_nama_dosen3="SELECT nama
							       FROM dosen
							       WHERE kode='".$row["kode_kary3"]."'";
				$result_nama_dosen3 = @mysql_query($sql_nama_dosen3);
				$row_nama_dosen3=@mysql_fetch_array($result_nama_dosen3);
				//echo $row_nama_dosen1["nama"];
				$sql_nama_dosen4="SELECT nama
							       FROM dosen
							       WHERE kode='".$row["kode_kary4"]."'";
				$result_nama_dosen4 = @mysql_query($sql_nama_dosen4);
				$row_nama_dosen4=@mysql_fetch_array($result_nama_dosen4);
				//echo $row_nama_dosen1["nama"];
				$sql_nama_dosen5="SELECT nama
							       FROM dosen
							       WHERE kode='".$row["kode_kary5"]."'";
				$result_nama_dosen5 = @mysql_query($sql_nama_dosen5);
				$row_nama_dosen5=@mysql_fetch_array($result_nama_dosen5);
				//echo $row_nama_dosen1["nama"];
			   ?>
			</td>
			<td nowrap valign="top"><? echo $row["kode_kary"]." - ".$row_nama_dosen1["nama"]; ?></td>
			<td nowrap valign="top"><? echo $row["kode_kary2"]." - ".$row_nama_dosen2["nama"]; ?></td>
			<td nowrap valign="top"><? echo $row["kode_kary3"]." - ".$row_nama_dosen3["nama"]; ?></td>
			<td nowrap valign="top"><? echo $row["kode_kary4"]." - ".$row_nama_dosen4["nama"]; ?></td>
			<td nowrap valign="top"><? echo $row["kode_kary5"]." - ".$row_nama_dosen5["nama"]; ?></td>
			<td valign="top" nowrap><? echo $row["judul"]; ?></td>
			<td nowrap valign="top">
				 <? 
				 $sql_nm_publikasi="SELECT id_pub, 
				                           nama 
				 				      FROM status_publikasi
							         WHERE id_pub=".$row["publikasi"];
				 $result_nm_publikasi = @mysql_query($sql_nm_publikasi);
				 $row_nm_publikasi = @mysql_fetch_array($result_nm_publikasi);
				 echo $row_nm_publikasi["nama"];
				 ?>
			</td>
			<td nowrap valign="top">
			<? 
				switch ($row["jurn_pros"]) {
						case 0:
							$nama_tipe='Tidak ada data';
							break;
						case 1:
							$nama_tipe='Jurnal';
							break;
						case 2:
							$nama_tipe='Prosiding';
							break;
						}
						echo $nama_tipe;
			?>
			</td>
			<td nowrap valign="top">
				<? if ($row["jenis"]==1) {
				echo "Mandiri";
				}
				else if ($row["jenis"]==2) {
				echo "Kelompok";
				}
				 ?>
			</td>
			<td nowrap valign="top"><? echo $row["pub_ISBN"]; ?></td>
			<td nowrap valign="top"><? echo $row["pub_volume"]; ?></td>
		    <td nowrap valign="top"><? echo $row["pub_penyelenggara"]; ?></td>
		    <td nowrap valign="top"><? echo $row["pub_tgl_pub "]; ?></td>
		    <td nowrap valign="top"><? echo $row["no_paten"]; ?></td>
		    <td nowrap valign="top"><? echo $row["pemberi_paten"]; ?></td>
		    <td nowrap valign="top"><? echo $row["pub_tgl_paten"]; ?></td>
		    <td nowrap valign="top"><?
				$sql_sumber_dana="SELECT nama
							       FROM sumber_dana
							       WHERE id=".$row["pub_id_sumber_dana"];
				$result_sumber_dana = @mysql_query($sql_sumber_dana);
				$row_sumber_dana=@mysql_fetch_array($result_sumber_dana);
				echo $row_sumber_dana["nama"];
			   ?></td>
		    <td nowrap align="left" valign="top"><? echo $row["pub_jum_dana_lokal"]; ?></td>
		    <td nowrap align="left" valign="top"><? echo $row["pub_jum_dana_asing"]; ?></td>
		    <td nowrap align="left" valign="top">
				<?
				$sql_TET="SELECT id
							       FROM jurusan
							       WHERE id='".$row["TET_sub"]."'";
				$result_TET = @mysql_query($sql_TET);
				$row_TET=@mysql_fetch_array($result_TET);
				//echo $row_nama_jurusan["id"];
				switch ($row_TET["id"]) {
					case 1:
						$nama_jurusan='TE';
						break;
					case 2:
						$nama_jurusan='TK';
						break;
					case 3:
						$nama_jurusan='TI';
						break;
					case 4:
						$nama_jurusan='IF';
						break;
					case 5:
						$nama_jurusan='TM';
						break;
					}
					echo $nama_jurusan;
			   ?>
			</td>
		    <td nowrap align="left" valign="top"><?
				$sql_TNET="SELECT id
							       FROM jurusan
							       WHERE id='".$row["TNET_sub"]."'";
				$result_TNET = @mysql_query($sql_TNET);
				$row_TNET=@mysql_fetch_array($result_TNET);
				//echo $row_nama_jurusan["id"];
				switch ($row_TNET["id"]) {
					case 1:
						$nama_jurusan='TE';
						break;
					case 2:
						$nama_jurusan='TK';
						break;
					case 3:
						$nama_jurusan='TI';
						break;
					case 4:
						$nama_jurusan='IF';
						break;
					case 5:
						$nama_jurusan='TM';
						break;
					}
					echo $nama_jurusan;
			   ?></td>
		    <td nowrap align="left" valign="top"><? echo $row["status"]; ?></td>
		    <td nowrap align="left" valign="top"><? echo $row["tugas"]; ?></td>
		    <td nowrap align="left" valign="top"><? echo $row["hari_go"]; ?></td>
		    <td nowrap align="left" valign="top"><? echo $row["tgl_go"]; ?></td>
		    <td nowrap align="left" valign="top"><? echo $row["pukul_go"]; ?></td>
		    <td nowrap align="left" valign="top"><? echo $row["tempat_go"]; ?></td>
		    <td nowrap align="left" valign="top"><? echo $row["transport_go"]; ?></td>
		    <td nowrap align="left" valign="top"><? echo $row["hari_dtg"]; ?></td>
		    <td nowrap align="left" valign="top"><? echo $row["tgl_dtg"]; ?></td>
		    <td nowrap align="left" valign="top"><? echo $row["pukul_dtg"]; ?></td>
		    <td nowrap align="left" valign="top"><? echo $row["transport_dtg"]; ?></td>
		    <td nowrap align="left" valign="top"><? echo $row["biaya"]; ?></td>
		    <td nowrap align="left" valign="top">
					<? 
					switch ($row["L_ap_tax"]) {
							case 0:
								$tax='TIDAK';
								break;
							case 1:
								$tax='YA';
								break;
					}
					echo $tax; 
					?>
			</td>
		    <td nowrap align="left" valign="top">
					<? 
					switch ($row["L_visa"]) {
							case 0:
								$visa='TIDAK';
								break;
							case 1:
								$visa='YA';
								break;
					}
					echo $visa; 
					?>

			</td>
		    <td nowrap align="left" valign="top">
				   <? 
					switch ($row["L_akomo"]) {
							case 0:
								$ako='TIDAK';
								break;
							case 1:
								$ako='YA';
								break;
					}
					echo $ako; 
					?>
			</td>
		    <td nowrap align="left" valign="top">
				    <? 
					switch ($row["L_fiskal"]) {
							case 0:
								$fiskal='TIDAK';
								break;
							case 1:
								$fiskal='YA';
								break;
					}
					echo $fiskal; 
					?>
			</td>
	        <td nowrap align="left" valign="top">
					<? 
					switch ($row["L_saku"]) {
							case 0:
								$saku='TIDAK';
								break;
							case 1:
								$saku='YA';
								break;
					}
					echo $saku; 
					?>
			</td>
	        <td nowrap align="left" valign="top">
					<? 
					switch ($row["L_other"]) {
							case 0:
								$lain='TIDAK';
								break;
							case 1:
								$lain='YA';
								break;
					}
					echo $lain; 
					?>
			</td>
	        <td nowrap align="left" valign="top"><? echo $row["ndt_terakhir"]; ?></td>
          <?
	$a++;

?>		
		</tr>
<?
}
?><tr>
		<td colspan=44>
			<input name="excel" type="image" onClick="document.fexcel.action='lap_publikasi_export.php?t=excel'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
			Export ke File Excel
			<input name="printer" type="image"  onClick="document.fexcel.action='lap_publikasi_export.php?t=printer'" src="../img/print.gif" align="bottom" width="18" height="18"> 
			Print
		</td>
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