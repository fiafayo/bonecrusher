<?
/* 
   KETERANGAN 	: LAPORAN PENELTIAN TULISAN ILMIAH DOSEN

   DATE CREATED : 10/08/07
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

// CEK AUTHENTIFIKASI USER
//if (!f_authenticate_user($USERNAME,$PASSWORD,$LOGGED))
//{
//	header("Location:http://".$HOSTNAME."/login.htm");
//	exit();
//}

?>
<html>
<link href="../css/style2.css" rel="stylesheet" type="text/css">

<body class="body">
<?php

if ($mode=="" or $mode=="0") 
{
?>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN ~</strong> 
      TULISAN ILMIAH DOSEN</font></font> </td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">PENELITIAN</font></strong></div></td>
  </tr>
</table>
<strong><font color="#0099CC" size="1"></font></strong> 
<hr size="1" color="#FF9900">
<form>
  <table width="100%" class="body" >
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="14%">&nbsp;</td> 
      <td width="23%">Tanggal</td>
      <td width="1%"><strong>:</strong></td>
      <td width="62%"><input type="text" name="frm_s_tanggal1" id="frm_s_tanggal1" class="tekboxku">
        - 
        <input type="text" name="frm_s_tanggal2" id="frm_s_tanggal2" class="tekboxku"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Volume</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="frm_s_volume" id="frm_s_volume" class="tekboxku"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Jurusan</td>
      <td><strong>:</strong></td>
      <td><select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku">
          <option value="all">Semua 
          <?php
				 f_connecting();
				 mysql_select_db($DB);
				 $result3 = @mysql_query("SELECT * FROM jurusan");
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
      <td>Judul</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="frm_s_judul" id="frm_s_judul" class="tekboxku"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nama Media</td>
      <td><strong>:</strong></td>
      <td><input type="text" id="frm_s_media" name="frm_s_media" class="tekboxku"> </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Status Media</td>
      <td><strong>:</strong></td>
      <td> <select name="frm_s_status" id="frm_s_status" class="tekboxku">
          <option value="all">Semua</option>
          <?
/*
			$sql2="select * from status_media";
			if(!($result2=mysql_db_query($DB,$sql2)))
			{
				echo mysql_error();
        			return 0;
			}
			while(($row2 = mysql_fetch_array($result2)))
			{
				echo "<option value=".$row2["id"].">".$row2["nama"];
			} */
?>
        </select> </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td><i>Banyak Data yang ditampilkan</i></td>
      <td><strong>:</strong></td>
      <td><select name="frm_s_jum_data" id="frm_s_jum_data" class="tekboxku">
          <option value=10>10 
          <option value=15>15 
          <option value=20 selected>20 </select> </td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap><b>KRITERIA PENGURUTAN DATA</b></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Pengurutan 1</td>
      <td><strong>:</strong></td>
      <td><select name="frm_o1" id="frm_o1" class="tekboxku">
          <option value="tulisan_ilmiah.tanggal">Tanggal 
          <option value="tulisan_ilmiah.volume">Volume 
          <option value="master_karyawan.kode">NPK Dosen
          <option value="tulisan_ilmiah.judul">Judul 
          <option value="tulisan_ilmiah.nama_media">Nama Media 
          <option value="status_media.nama">Status Media </select> </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Pengurutan 2</td>
      <td><strong>:</strong></td>
      <td><select name="frm_o2" id="frm_o2" class="tekboxku">
          <option value="tulisan_ilmiah.tanggal">Tanggal 
          <option value="tulisan_ilmiah.volume">Volume 
          <option value="master_karyawan.kode">NPK Dosen
          <option value="tulisan_ilmiah.judul">Judul 
          <option value="tulisan_ilmiah.nama_media">Nama Media 
          <option value="status_media.nama">Status Media </select> </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Pengurutan 3</td>
      <td><strong>:</strong></td>
      <td><select name="frm_o3" id="frm_o3" class="tekboxku">
          <option value="tulisan_ilmiah.tanggal">Tanggal 
          <option value="tulisan_ilmiah.volume">Volume 
          <option value="master_karyawan.kode">NPK Dosen
          <option value="tulisan_ilmiah.judul">Judul 
          <option value="tulisan_ilmiah.nama_media">Nama Media 
          <option value="status_media.nama">Status Media </select> </td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td></td> 
      <td></td>
      <td></td>
      <td><input type="hidden" name="mode" id="mode" value="2"> <input type="submit" value="Proses" class="tombol"></td>
    </tr>
  </table>
</form>
<?
}
else
{
// JIKA MODE<>0 MAKSUDNYA JIKA FORM DI SUBMIT MAKA KELUAR LAPORAN
$sql="select tulisan_ilmiah.*, 
             master_karyawan.kode as kode, 
			 master_karyawan.nip as nip, 
			 master_karyawan.nama as nama,
			 status_media.nama as status,
			 master_karyawan.jurusan as jrsan,
			 jurusan.jurusan as nama_jur 
	  from tulisan_ilmiah, master_karyawan, status_media,jurusan 
	  where tulisan_ilmiah.id_karyawan=master_karyawan.id and  
			tulisan_ilmiah.id_status_media=status_media.id and
			master_karyawan.id=tulisan_ilmiah.id_karyawan and
			jurusan.id=master_karyawan.jurusan";

if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_s_tanggal1!="" || $frm_s_tanggal2!="")
	{  
		if($frm_s_tanggal1!="" && $frm_s_tanggal2!="")
		{ $sql=$sql." and tulisan_ilmiah.tanggal between '".datetomysql($frm_s_tanggal1)."' and '".datetomysql($frm_s_tanggal2)."'"; }
		else
		{
			if($frm_s_tanggal1!="")
			{ $sql=$sql." and tulisan_ilmiah.tanggal>='".datetomysql($frm_s_tanggal1)."'"; }
			if($frm_s_tanggal2!="")
			{ $sql=$sql." and tulisan_ilmiah.tanggal<='".datetomysql($frm_s_tanggal2)."'"; }
		}
	}	
	if ($frm_s_volume!="")
	{ $sql=$sql." and tulisan_ilmiah.volume like '%".$frm_s_volume."%'"; }
	if ($frm_s_jurusan!="all")
	{ $sql=$sql." and master_karyawan.jurusan=".$frm_s_jurusan; } 
	if ($frm_s_kode!="")
	{ $sql=$sql." and master_karyawan.kode like '%".$frm_s_kode."%'"; }
	if ($frm_s_judul!="")
	{ $sql=$sql." and tulisan_ilmiah.judul like '%".$frm_s_judul."%'"; } 
	if ($frm_s_media!="")
	{ $sql=$sql." and tulisan_ilmiah.nama_media like '%".$frm_s_media."%'"; } 	
	if ($frm_s_status!="all")
	{ $sql=$sql." and status_media.id=".$frm_s_status; } 

	$sql=$sql." order by ".$frm_o1." desc, ".$frm_o2." desc, ".$frm_o3." desc";
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

$vlink="lap_tulisan_ilmiah.php";
$abc="?mode=2&frm_s_tanggal1=$frm_s_tanggal1&frm_s_tanggal2=$frm_s_tanggal2&frm_s_volume=$frm_s_volume&frm_s_jurusan=$frm_s_jurusan&frm_s_kode=$frm_s_kode&frm_s_judul=$frm_s_judul&frm_s_media=$frm_s_media&frm_s_status=$frm_s_status&frm_s_jum_data=$frm_s_jum_data&frm_o1=$frm_o1&frm_o2=$frm_o2&frm_o3=$frm_o3";

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
<div align="center"><b><font color="#0000FF">FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</font></b></div>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN 
      ~</strong> TULISAN ILMIAH DOSEN</font></font> </td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">PENELITIAN</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<?
if ($frm_s_tanggal1!="" || $frm_s_tanggal2!="")
{
?>
<div align="right"><b>TANGGAL : <? echo $frm_s_tanggal1; ?> s/d <? echo $frm_s_tanggal2; ?></b></div><br>
<?
}
?>
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div><br>
<?

if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" ACTION="lap_tulisan_ilmiah_export.php">
<input type=hidden name="mode" value="3">
<input type=hidden name="frm_s_tanggal1" value="<?php echo $frm_s_tanggal1; ?>">
<input type=hidden name="frm_s_tanggal2" value="<?php echo $frm_s_tanggal2; ?>">
<input type=hidden name="frm_s_volume" value="<?php echo  $frm_s_volume;?>">
<input type=hidden name="frm_s_jurusan" value="<?php echo  $frm_s_jurusan;?>">
<input type=hidden name="frm_s_kode" value="<?php echo  $frm_s_kode;?>">
<input type=hidden name="frm_s_judul" value="<?php echo $frm_s_judul;?>">
<input type=hidden name="frm_s_media" value="<?php echo  $frm_s_media;?>">
<input type=hidden name="frm_s_status" value="<?php echo $frm_s_status;?>">
<input type=hidden name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<input type=hidden name="frm_o1" value="<?php echo $frm_o1; ?>">
<input type=hidden name="frm_o2" value="<?php echo $frm_o2; ?>">
<input type=hidden name="frm_o3" value="<?php echo $frm_o3; ?>">
<!--
<input name="excel" onClick="document.fexcel.action='penelitian_2_1_export.php?t=excel'"   type="image" src="../img/excel.gif" width="18" height="18"> Export ke File Excel
    <input name="printer"  onClick="document.fexcel.action='penelitian_2_1_export.php?t=printer'" type="image" src="../img/printer.gif" width="18" height="18"> Print
<br>
-->

<?
}
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
<table class="table" border="1" cellspacing="0" cellpadding="5">
		<tr bgcolor="#C6E2FF">
			<td nowrap><b>Tanggal</b></td>
			<td nowrap><b>Jurusan</b></td>
			<td nowrap><b>Vol.</b></td>
			<td nowrap><b>Kode</b></td>
			<td nowrap><b>NIP</b></td>
			<td nowrap><b>Nama Media</b></td>
			<td nowrap><b>ISBN</b></td>
			<td nowrap><b>Judul</b></td>
			<td nowrap><b>Status Media</b></td>
			<td nowrap><b>Edit/Hapus</b></td>
		</tr>
<?
while(($row = mysql_fetch_array($result)))
{
?>
		<tr>
			<td nowrap valign="top"><? if (datetoreport($row["tanggal"])=="00/00/0000") {echo "00/00/0000";} else {echo datetoreport($row["tanggal"]);} ?></td>
			<td nowrap valign="top"><? echo $row["nama_jur"]; ?></td>
			<td nowrap valign="top"><? echo $row["volume"]; ?></td>
			<td nowrap valign="top"><? echo $row["kode"]; ?></td>
			<td nowrap valign="top"><? echo $row["nip"]; ?></td>
			<td valign="top"><? echo $row["nama_media"]; ?></td>
			<td nowrap valign="top"><? echo $row["ISBN"]; ?></td>			
			<td valign="top"><? echo $row["judul"]; ?></td>
			<td nowrap valign="top"><? echo $row["status"]; ?></td>
			<td align="right" valign="top" nowrap>
			<?
if ($mode=="2")
{
?>
	Edit <input name="edit" onClick="document.fexcel.action='pen_tulisan_ilmiah_entry.php?frm_id=<?php echo $row["id"]; ?>'"   type="image" src="../img/edit.png" width="16" height="16"> 
    <br>Hapus <input name="hapus"  onclick="if(confirm('Hapus ?')){this.form.action='pen_tulisan_ilmiah_entry.php?act=2&frm_id=<?php echo $row["id"];?>';this.form.submit()} else {return false};" type="image" src="../img/hapus.png" width="16" height="16"> 
<?
}
?>
</td>
</tr>
<?
}
?>
<tr>
	<td colspan="10">
	&nbsp;<input name="excel"   type="image" onClick="document.fexcel.action='lap_tulisan_ilmiah_export.php?t=excel'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
	Export ke File Excel &nbsp;|&nbsp;
	<input name="printer" type="image"  onClick="document.fexcel.action='lap_tulisan_ilmiah_export.php?t=printer'" src="../img/print.gif" align="bottom" width="18" height="18"> 
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