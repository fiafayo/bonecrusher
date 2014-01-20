<?
/* 
   DATE CREATED : 10/08/07
   LAST UPDATE  : 
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
      BUKU KARYA DOSEN</font></font> </td>
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
      <td width="10%">&nbsp;</td> 
      <td width="21%">Tanggal</td>
      <td width="2%"><strong>:</strong></td>
      <td width="66%"><input type="text" name="frm_s_tanggal_terbit1" id="frm_s_tanggal_terbit1" class="tekboxku">
        - 
        <input type="text" name="frm_s_tanggal_terbit2" id="frm_s_tanggal_terbit2" class="tekboxku"></td>
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
      <td>Kode Dosen</td>
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
      <td>ISBN</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="frm_s_isbn" id="frm_s_isbn" class="tekboxku"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Penerbit</td>
      <td><strong>:</strong></td>
      <td> <select name="frm_s_penerbit" id="frm_s_penerbit" class="tekboxku">
          <option value="all">Semua 
          <?
			f_connecting();
			$sql2="select * from penerbit";
			if(!($result2=mysql_db_query($DB,$sql2)))
			{
				echo mysql_error();
        			return 0;
			}
			while(($row2 = mysql_fetch_array($result2)))
			{
				echo "<option value=".$row2["id"].">".$row2["penerbit"];
			}
?>
        </select> </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td><i>Banyak Data yang ditampilkan</i></td>
      <td><strong>:</strong></td>
      <td> <select name="frm_s_jum_data" id="frm_s_jum_data" class="tekboxku">
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
          <option value="buku_karya_dosen.tanggal_terbit">Tanggal Terbit 
          <option value="master_karyawan.kode">NPK Dosen
          <option value="buku_karya_dosen.judul">Judul 
          <option value="buku_karya_dosen.isbn">ISBN 
          <option value="penerbit.penerbit">Penerbit </select> </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Pengurutan 2</td>
      <td><strong>:</strong></td>
      <td><select name="frm_o2" id="frm_o2" class="tekboxku">
          <option value="buku_karya_dosen.tanggal_terbit">Tanggal Terbit 
          <option value="master_karyawan.kode">NPK Dosen
          <option value="buku_karya_dosen.judul">Judul 
          <option value="buku_karya_dosen.isbn">ISBN 
          <option value="penerbit.penerbit">Penerbit </select> </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Pengurutan 3</td>
      <td><strong>:</strong></td>
      <td><select name="frm_o3" id="frm_o3" class="tekboxku">
          <option value="buku_karya_dosen.tanggal_terbit">Tanggal Terbit 
          <option value="master_karyawan.kode">NPK Dosen
          <option value="buku_karya_dosen.judul">Judul 
          <option value="buku_karya_dosen.isbn">ISBN 
          <option value="penerbit.penerbit">Penerbit </select> </td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
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
$sql="SELECT buku_karya_dosen.*, 
			 master_karyawan.kode as kode, 
			 master_karyawan.nama as nama, 
			 penerbit.penerbit as penerbit,
			 jurusan.jurusan as nama_jur
      FROM buku_karya_dosen, master_karyawan, penerbit, jurusan 
	  WHERE buku_karya_dosen.id_karyawan=master_karyawan.id AND 
	  		buku_karya_dosen.kode_penerbit=penerbit.id AND
			master_karyawan.jurusan=jurusan.id";

if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_s_tanggal_terbit1!="" || $frm_s_tanggal_terbit2!="")
	{  
		if($frm_s_tanggal_terbit1!="" && $frm_s_tanggal_terbit2!="")
		{ $sql=$sql." and buku_karya_dosen.tanggal_terbit between '".datetomysql($frm_s_tanggal_terbit1)."' and '".datetomysql($frm_s_tanggal_terbit2)."'"; }
		else
		{
			if($frm_s_tanggal_terbit1!="")
			{ $sql=$sql." and buku_karya_dosen.tanggal_terbit>='".datetomysql($frm_s_tanggal_terbit1)."'"; }
			if($frm_s_tanggal_terbit2!="")
			{ $sql=$sql." and buku_karya_dosen.tanggal_terbit<='".datetomysql($frm_s_tanggal_terbit2)."'"; }
		}
	}
	if ($frm_s_jurusan!="all")
	{ $sql=$sql." and master_karyawan.jurusan=".$frm_s_jurusan; }	
	if ($frm_s_kode!="")
	{ $sql=$sql." and master_karyawan.kode like '%".$frm_s_kode."%'"; } 
	if ($frm_s_judul!="")
	{ $sql=$sql." and buku_karya_dosen.judul like '%".$frm_s_judul."%'"; }
	if ($frm_s_isbn!="")
	{ $sql=$sql." and buku_karya_dosen.isbn like '%".$frm_s_isbn."%'"; } 
	if ($frm_s_penerbit!="all")
	{ $sql=$sql." and penerbit.id=".$frm_s_penerbit; } 	
	
	$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
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

$vlink="lap_buku_karya_dosen.php";
$abc="?mode=2&frm_s_tanggal_terbit1=$frm_s_tanggal_terbit1&frm_s_tanggal_terbit2=$frm_s_tanggal_terbit2&frm_s_jurusan=$frm_s_jurusan&frm_s_kode=$frm_s_kode&frm_s_judul=$frm_s_judul&frm_s_isbn=$frm_s_isbn&frm_s_penerbit=$frm_s_penerbit&frm_s_jum_data=$frm_s_jum_data&frm_o1=$frm_o1&frm_o2=$frm_o2&frm_o3=$frm_o3";

$vlink=$vlink.$abc;

$fontface="Verdana,Arial,Helvetica,sans-serif";
$fontsize="2";
}

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
      ~</strong> BUKU KARYA DOSEN</font></font> </td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">PENELITIAN</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<?
if ($frm_s_tanggal_terbit1!="" || $frm_s_tanggal_terbit2!="")
{
?>
<div align="right"><b>TANGGAL : <? echo $frm_s_tanggal_terbit1; ?> s/d <? echo $frm_s_tanggal_terbit2; ?></b></div><br>
<?
}
?>
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div><br>
<?

if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="lap_buku_karya_dosen_export.php">

<input type="hidden" name="mode" value="3">
<input type="hidden" name="frm_s_tanggal_terbit1" id="frm_s_tanggal_terbit1" value="<?php echo $frm_s_tanggal_terbit1; ?>">
<input type="hidden" name="frm_s_tanggal_terbit2" id="frm_s_tanggal_terbit2" value="<?php echo $frm_s_tanggal_terbit2; ?>">
<input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<?php echo  $frm_s_jurusan;?>">
<input type="hidden" name="frm_s_kode" id="frm_s_kode" value="<?php echo  $frm_s_kode;?>">
<input type="hidden" name="frm_s_judul" id="frm_s_judul" value="<?php echo $frm_s_judul;?>">
<input type="hidden" name="frm_s_isbn" id="frm_s_isbn" value="<?php echo  $frm_s_isbn;?>">
<input type="hidden" name="frm_s_penerbit" id="frm_s_penerbit" value="<?php echo $frm_s_penerbit;?>">
<input type="hidden" name="frm_s_jum_data" id="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<input type="hidden" name="frm_o1" id="frm_o1" value="<?php echo $frm_o1; ?>">
<input type="hidden" name="frm_o2" id="frm_o2" value="<?php echo $frm_o2; ?>">
<input type="hidden" name="frm_o3" id="frm_o3" value="<?php echo $frm_o3; ?>">
<!--
<input name="excel" onClick="document.fexcel.action='lap_buku_karya_dosen_export.php?t=excel'"   type="image" src="../img/excel.gif" width="18" height="18"> Export ke File Excel
    <input name="printer"  onClick="document.fexcel.action='lap_buku_karya_dosen_export.php?t=printer'" type="image" src="../img/printer.gif" width="18" height="18"> Print
<br>
-->

<?
}
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
<table class="table" border="1" cellspacing="0" cellpadding="5">
		<tr bgcolor="#C6E2FF">
			<td nowrap><b>Tgl. Terbit</b></td>
			<td nowrap><b>Jurusan</b></td>
			<td nowrap><b>Kode</b></td>
			<td nowrap><b>Nama</b></td>
			<td nowrap><b>Judul</b></td>
			<td nowrap><b>ISBN</b></td>
			<td nowrap><b>Penerbit</b></td>
			<td nowrap><b>Edit/Hapus</b></td>
		</tr>
<?
while(($row = mysql_fetch_array($result)))
{
?>
		<tr>
			<td nowrap valign="top"><? echo datetoreport($row["tanggal_terbit"]); ?></td>
			<td nowrap valign="top"><? echo $row["nama_jur"]; ?></td>
			<td nowrap valign="top"><? echo $row["kode"]; ?></td>
			<td nowrap valign="top"><? echo $row["nama"]; ?></td>
			<td nowrap valign="top"><? echo $row["judul_buku"]; ?></td>
			<td nowrap valign="top"><? echo $row["isbn"]; ?></td>
			<td nowrap valign="top"><? echo $row["penerbit"]; ?></td>
<?
	$a++;

		if ($mode=="2")
{?>
			<td nowrap align="right">
				Edit <input name="edit" onClick="document.fexcel.action='pen_buku_karya_dosen_entry.php?frm_id=<?php echo $row["id"];?>&frm_kode=<?php echo $row["kode"];?>'"   type="image" src="../img/edit.png" width="16" height="16"> 
   				<br>Hapus <input name="hapus"  onclick="if(confirm('Hapus ?')){this.form.action='pen_buku_karya_dosen_entry.php?act=2&frm_id=<?php echo $row["id"];?>';this.form.submit()} else {return false};" type="image" src="../img/hapus.png" width="11" height="13"> 
			</td>
<?
}
?>		
		</tr>
<?
}
?>
	<tr>
		<td colspan=8>
			<input name="excel"   type="image" onClick="document.fexcel.action='lap_buku_karya_dosen_export.php?t=excel'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
			Export ke File Excel
			<input name="printer" type="image"  onClick="document.fexcel.action='lap_buku_karya_dosen_export.php?t=printer'" src="../img/print.gif" align="bottom" width="18" height="18"> 
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