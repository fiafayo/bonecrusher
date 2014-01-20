<?
/* 
   DATE CREATED : 10/04/08
   updated : 14/04/2009 -  tambah search berdasarkan jurusan
   KEGUNAAN: MENAMPILKAN LAPORAN TUGAS KELEMBAGAAN
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
      TUGAS KELEMBAGAAN</font></font> </td>
    <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">DOSEN</font></strong></div></td>
  </tr>
</table>
<strong><font color="#0099CC" size="1"></font></strong> 
<hr size="1" color="#FF9900">
<form name="form_lap_pengabdian" id="form_lap_pengabdian">
  <table width="100%" class="body">
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="9%">&nbsp;</td> 
      <td width="19%">Tanggal Mulai</td>
      <td width="2%"><strong>:</strong></td>
      <td width="70%"><input name="frm_s_tanggal_mulai1" type="text" class="tekboxku" id="frm_s_tanggal_mulai1" value="<?php echo $sekarang; ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('form_lap_pengabdian.frm_s_tanggal_mulai1',0,0,'DD/MM/YYYY')"> <img src="../img/date.png" width="22" height="22" align="absbottom" border=0></A> -
        <input name="frm_s_tanggal_mulai2" type="text" class="tekboxku" id="frm_s_tanggal_mulai2" value="<?php echo $sekarang; ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('form_lap_pengabdian.frm_s_tanggal_mulai2',0,0,'DD/MM/YYYY')"> <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy)</td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal Selesai</td>
      <td><strong>:</strong></td>
      <td>
        <input name="frm_s_tanggal_selesai1" type="text" class="tekboxku" id="frm_s_tanggal_selesai1" value="<?php echo $sekarang; ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('form_lap_pengabdian.frm_s_tanggal_selesai1',0,0,'DD/MM/YYYY')"> <img src="../img/date.png" width="22" height="22" align="absbottom" border=0></A> -
        <input name="frm_s_tanggal_selesai2" type="text" class="tekboxku" id="frm_s_tanggal_selesai2" value="<?php echo $sekarang; ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('form_lap_pengabdian.frm_s_tanggal_selesai2',0,0,'DD/MM/YYYY')"> <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy)</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Jurusan</td>
      <td><strong>:</strong></td>
      <td><select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku">
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
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>NPK Dosen</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="frm_s_kode" id="frm_s_kode" class="tekboxku"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nama</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="frm_s_nama" id="frm_s_nama" class="tekboxku"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Judul</td>
      <td><strong>:</strong></td>
      <td><input name="frm_s_judul" type="text" class="tekboxku" id="frm_s_judul" size="50"></td>
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

/*$sql="select penelitian.*, 
			 sumber_dana.nama as sumber_dana, 
			 master_karyawan.kode as kode,
			 master_karyawan.nama as nama,
			 jurusan.jurusan as jrsan 
	  from penelitian, sumber_dana, master_karyawan, jurusan 
	  where master_karyawan.id=penelitian.id_karyawan and 
	        penelitian.id_sumber_dana=sumber_dana.id and
			master_karyawan.jurusan=jurusan.id";*/

$sql="SELECT tugas_lembaga.id,
			 tugas_lembaga.kode,
			 tugas_lembaga.no_legalitas,
			 tugas_lembaga.nama_institusi,
			 tugas_lembaga.id_jenis,
			 tugas_lembaga.id_tipe,
			 tugas_lembaga.kode_dosen,
			 tugas_lembaga.jabatan,
			 tugas_lembaga.judul,
			 DATE_FORMAT(tugas_lembaga.mulai,\"%d/%m/%Y\") as tanggal_mulai,
			 DATE_FORMAT(tugas_lembaga.selesai,\"%d/%m/%Y\") as tanggal_selesai,
			 tugas_lembaga.tempat,
			 tugas_lembaga.jumlah_staff,
			 tugas_lembaga.id_sumber_dana,
			 tugas_lembaga.jumlah_dana,
			 tugas_lembaga.up_date,
			 tugas_lembaga.jurusan
	    FROM tugas_lembaga, dosen
	   WHERE dosen.kode=tugas_lembaga.kode_dosen ";	
		 
if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_s_tanggal_mulai1!="" || $frm_s_tanggal_mulai2!="")
	{  
		if($frm_s_tanggal_mulai1!="" && $frm_s_tanggal_mulai2!="")
		{ $sql=$sql." and tugas_lembaga.mulai between '".datetomysql($frm_s_tanggal_mulai1)."' and '".datetomysql($frm_s_tanggal_mulai2)."'"; }
		else
		{
			if($frm_s_tanggal_mulai1!="")
			{ $sql=$sql." and tugas_lembaga.mulai>='".datetomysql($frm_s_tanggal_mulai1)."'"; }
			if($frm_s_tanggal_mulai2!="")
			{ $sql=$sql." and tugas_lembaga.mulai<='".datetomysql($frm_s_tanggal_mulai2)."'"; }
		}
	}	
	if ($frm_s_tanggal_selesai1!="" || $frm_s_tanggal_selesai2!="")
	{  
		if($frm_s_tanggal_selesai1!="" && $frm_s_tanggal_selesai2!="")
		{ $sql=$sql." and tugas_lembaga.selesai between '".datetomysql($frm_s_tanggal_selesai1)."' and '".datetomysql($frm_s_tanggal_selesai2)."'"; }
		else
		{
			if($frm_s_tanggal_selesai1!="")
			{ $sql=$sql." and tugas_lembaga.selesai>='".datetomysql($frm_s_tanggal_selesai1)."'"; }
			if($frm_s_tanggal_selesai2!="")
			{ $sql=$sql." and tugas_lembaga.selesai<='".datetomysql($frm_s_tanggal_selesai2)."'"; }
		}
	}
	
	if ($frm_s_jurusan != "all")
	{ $sql.=" and tugas_lembaga.jurusan=".$frm_s_jurusan;}	
	
	if ($frm_s_kode!="")
	{ $sql=$sql." and dosen.kode like '%".$frm_s_kode."%'"; } 
	if ($frm_s_nama!="")
	{ $sql=$sql." and dosen.nama like '%".$frm_s_nama."%'"; } 
	if ($frm_s_judul!="")
	{ $sql=$sql." and pengabdian.judul like '%".$frm_s_judul."%'"; }
	//if ($frm_s_sumber_dana!="all")
	//{ $sql=$sql." and sumber_dana.id=".$frm_s_sumber_dana; }
	//if ($frm_s_publikasi!="all")
	//{ $sql=$sql." and pengabdian.id_jenis=".$frm_s_publikasi; }
	//if ($frm_tipe_kerjasama!="all")
	//{ $sql=$sql." and pengabdian.id_tipe=".$frm_tipe_kerjasama; }
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
	//echo "SQL=".$sql;
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

$vlink="lap_tugas_lembaga.php";
$abc="?mode=2&frm_s_tanggal_mulai1=$frm_s_tanggal_mulai1&frm_s_tanggal_mulai2=$frm_s_tanggal_mulai2&frm_s_tanggal_selesai1=$frm_s_tanggal_selesai1&frm_s_tanggal_selesai2=$frm_s_tanggal_selesai2&frm_s_jurusan=$frm_s_jurusan&frm_s_kode=$frm_s_kode&frm_s_nama=$frm_s_nama&frm_s_judul=$frm_s_judul&frm_s_sumber_dana=$frm_s_sumber_dana&frm_s_publikasi=$frm_s_publikasi&frm_s_jum_data=$frm_s_jum_data";

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

// TAMPILAN LAPORAN HASIL QUERY
?>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN 
      ~</strong> TUGAS KELEMBAGAAN</font></font></td>
    <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">DOSEN</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<?
if ($frm_s_tanggal_mulai1!="" || $frm_s_tanggal_mulai2!="")
{?>
<div align="right"><b>TANGGAL : <? echo $frm_s_tanggal_mulai1; ?> s/d <? echo $frm_s_tanggal_mulai2; ?></b></div><br>
<?
}?>
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div><br>
<?
if (mysql_num_rows($result)==0) {
    echo "<br><font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=lap_tugas_lembaga.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}
if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="lap_tugas_lembaga_export.php">
<input type="hidden" name="mode" value="3">
<input type="hidden" name="frm_s_tanggal_mulai1" value="<?php echo $frm_s_tanggal_mulai1; ?>">
<input type="hidden" name="frm_s_tanggal_mulai2" value="<?php echo $frm_s_tanggal_mulai2; ?>">
<input type="hidden" name="frm_s_tanggal_selesai1" value="<?php echo $frm_s_tanggal_selesai1; ?>">
<input type="hidden" name="frm_s_tanggal_selesai2" value="<?php echo $frm_s_tanggal_selesai2; ?>">
<input type="hidden" name="frm_s_jurusan" value="<?php echo  $frm_s_jurusan;?>"> 
<input type="hidden" name="frm_s_kode" value="<?php echo  $frm_s_kode;?>"> 
<input type="hidden" name="frm_s_nama" value="<?php echo  $frm_s_nama;?>">
<input type="hidden" name="frm_s_judul" value="<?php echo $frm_s_judul;?>">
<input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<input type="hidden" name="frm_o1" value="<?php echo $frm_o1; ?>">
<input type="hidden" name="frm_o2" value="<?php echo $frm_o2; ?>">
<input type="hidden" name="frm_o3" value="<?php echo $frm_o3; ?>">
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
			<td nowrap><b>Jurusan</b></td>
			<td nowrap><b>No. Legalitas</b></td>
			<td nowrap><b>Kode</b></td>
			<td nowrap><b>Nama</b></td>
			<td nowrap><b>Kode Tugas </b></td>
			<td nowrap><b>Judul</b></td>
			<!--td nowrap><b>Publikasi</b></td>
			<td nowrap><b>Tipe Kerjasama</b></td>
			<td nowrap><b>Keanggotaan</b></td>
			<td nowrap><b>Status Jabatan</b></td>
			<td nowrap><b>Sumber Dana</b></td>
			<td nowrap><b>Jumlah Dana</b></td-->
			<td nowrap><b>Status Jabatan</b></td>
			<td nowrap><b>Tgl. Mulai</b></td>
			<td nowrap><b>Tgl. Selesai</b></td>
		    <td nowrap><b>Tempat</b></td>
		</tr>
<?
while(($row = mysql_fetch_array($result)))
{
?>
		<tr>
			<? if ($mode=="2"){
			?>
			<td nowrap align="right" valign="top">
				Edit <input name="edit" onClick="document.fexcel.action='tugas_lembaga_entry.php?frm_id=<?php echo $row["id"];?>'" type="image" src="../img/edit.png" width="16" height="16"><br>
				Hapus <input name="hapus"  onclick="if(confirm('Hapus ?')){this.form.action='tugas_lembaga_entry.php?act=2&frm_id=<?php echo $row["id"];?>';this.form.submit()} else{return false};" type="image" src="../img/hapus.png" width="11" height="13"> 
			</td>
			<? }?>
			<td nowrap valign="top">
				<?
				$sql_nama_jurusan="SELECT id
							       FROM jurusan
							       WHERE id='".$row["jurusan"]."'";
				$result_nama_jurusan = @mysql_query($sql_nama_jurusan);
				$row_nama_jurusan=@mysql_fetch_array($result_nama_jurusan);
				//echo $row_nama_jurusan["id"];
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
			</td>
			<td nowrap valign="top"><? echo $row["no_legalitas"]; ?></td>
			<td nowrap valign="top"><? echo $row["kode_dosen"]; ?></td>
			<td nowrap valign="top">
				<?
				$sql_nama_dosen="SELECT nama
							       FROM dosen
							       WHERE kode='".$row["kode_dosen"]."'";
				$result_nama_dosen = @mysql_query($sql_nama_dosen);
				$row_nama_dosen=@mysql_fetch_array($result_nama_dosen);
				echo $row_nama_dosen["nama"];
			   ?>
			</td>
			<td valign="top" nowrap><? echo $row["kode"]; ?></td>
			<td valign="top" nowrap><? echo $row["judul"]; ?></td>
			<!--td nowrap valign="top">
			   <?
					/*$sql_publikasi="SELECT nama
									  FROM jenis_kerjasama
									 WHERE id=".$row["id_jenis"];
					$result_publikasi = @mysql_query($sql_publikasi);
					$row_publikasi=@mysql_fetch_array($result_publikasi);
					echo $row_publikasi["nama"];*/
			   ?>
			</td-->
			<!--td nowrap valign="top">
			  <?
				/*$sql_tipe_kerjasama="SELECT nama
									   FROM tipe_kerjasama
									  WHERE id=".$row["id_tipe"];
				$result_tipe_kerjasama = @mysql_query($sql_tipe_kerjasama);
				$row_tipe_kerjasama=@mysql_fetch_array($result_tipe_kerjasama);
				echo $row_tipe_kerjasama["nama"];*/
			   ?>
			
			</td-->
			<!--td nowrap valign="top">
			   <? 
				/* switch ($row["man_kel"]) {
					case "Mandiri":
						$nama_keanggotaan='Mandiri';
						break;
					case "Kelompok":
						$nama_keanggotaan='Kelompok';
						break;
					}
					echo $nama_keanggotaan;*/
				 ?>
			</td-->
			<td nowrap valign="top">
				<? 
				 switch ($row["jabatan"]) {
					case 1:
						$nama_jabatan='Ketua';
						break;
					case 2:
						$nama_jabatan='Wakil Ketua';
						break;
					case 3:
						$nama_jabatan='Anggota';
						break;
					case 4:
						$nama_jabatan='Instruktur';
						break;
					}
					echo $nama_jabatan;
				 ?>
			</td>
			<!--td nowrap valign="top">
				<?
				/*sql_sumber_dana="SELECT nama
								    FROM sumber_dana
								   WHERE id=".$row["id_sumber_dana"];
				$result_sumber_dana = @mysql_query($sql_sumber_dana);
				$row_sumber_dana=@mysql_fetch_array($result_sumber_dana);
				echo $row_sumber_dana["nama"];*/
				?>
			</td-->
			<!--td nowrap valign="top"><? //echo $row["jumlah_dana"]; ?></td-->
		    <td nowrap align="left" valign="top"><? echo $row["tanggal_mulai"]; ?></td>
		    <td nowrap align="left" valign="top"><? echo $row["tanggal_selesai"]; ?></td>
	        <td nowrap align="left" valign="top"><? echo $row["tempat"]; ?></td>
          <?
	$a++;

?>		
		</tr>
<?
}
?><tr>
		<td colspan=17>
			<input name="excel" type="image" onClick="document.fexcel.action='lap_tugas_lembaga_export.php?t=excel'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
			Export ke File Excel
			<input name="printer" type="image"  onClick="document.fexcel.action='lap_tugas_lembaga_export.php?t=printer'" src="../img/print.gif" align="bottom" width="18" height="18"> 
			Print
		</td>
	</tr>
</table>
</FORM>
<?
}
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>		
</body>
</html>