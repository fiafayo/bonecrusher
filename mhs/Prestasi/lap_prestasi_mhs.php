<?php
/* 
   DATE CREATED : 06/05/08
   KEGUNAAN     : MENAMPILKAN PRESTASI MAHASISWA
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
require("../../include/temp.php");

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
      ~</strong> PRESTASI MAHASISWA</font></font> </td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form name="form_lap_prestasi" id="form_lap_prestasi">
  <table width="80%" align="center" class="body" >
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
      <td>Tanggal Kegiatan </td>
      <td>&nbsp;</td>
      <td><input name="frm_tgl_periode" type="text" class="tekboxku" id="frm_tgl_periode" value="<?php echo date('d/m/Y'); ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('form_lap_prestasi.frm_tgl_periode',0,0,'DD/MM/YYYY')"> <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> </A>&nbsp;&nbsp;&nbsp;&nbsp;s/d&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="frm_tgl_periode2" type="text" class="tekboxku" id="frm_tgl_periode2" value="<?php echo date('d/m/Y'); ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('form_lap_prestasi.frm_tgl_periode2',0,0,'DD/MM/YYYY')"> <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy)</td>
    </tr>
    <tr> 
      <td width="26%">Jurusan</td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td width="69%">
	    
		<select name="frm_s_jurusan" class="tekboxku">
          <option value="all">Semua 
          <?php
  	             $result2 = @mysql_query("SELECT * FROM `jurusan` WHERE jurusan.id <>0 and jurusan.id <> 9 ORDER BY id ASC");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["id"].">".$row2["jurusan"];
	             }
         	?>
        </select></td>
    </tr>
    <tr> 
      <td>NRP</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_s_NRP" type="text" class="tekboxku" id="frm_s_NRP" size="10" maxlength="7"></td>
    </tr>
    <tr> 
      <td>Nama</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input type="text" name="frm_s_nama" id="frm_s_nama" class="tekboxku"></td>
    </tr>
    <tr> 
      <td nowrap><i>Banyak Data yang ditampilkan</i></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_s_jum_data" id="frm_s_jum_data" class="tekboxku">
			  <option value="2">2</option>
			  <option value="10">10</option> 
			  <option value="15">15</option> 
			  <option value="20" selected>20</option> 
		  </select>
	  </td>
    </tr>
    <tr> 
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td></td>
      <td><input type="hidden" name="mode" value="2"></td>
      <td><input type="submit" value="Proses"  class="tombol"></td>
    </tr>
  </table>
</form>
<?
}
else
{
// JIKA MODE<>0 MAKSUDNYA JIKA FORM DI SUBMIT (proses cari) MAKA KELUAR LAPORAN
	        
$sql="SELECT prestasi.id,
			 prestasi.nrp,
			 prestasi.kegiatan,
			 DATE_FORMAT(prestasi.tgl_kegiatan,\"%d/%m/%Y\") as tgl_kegiatan,
			 prestasi.tempat,
			 prestasi.hasil,
			 prestasi.jurusan,
			 prestasi.tingkat,
			 master_mhs.NAMA
        FROM prestasi,master_mhs
	   WHERE prestasi.nrp=master_mhs.NRP ";
	  
if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)

	if($frm_tgl_periode!="" && $frm_tgl_periode2!="")
	{ 
		$sql=$sql." and (prestasi.tgl_kegiatan between '".datetomysql($frm_tgl_periode)."' and '".datetomysql($frm_tgl_periode2)."')"; 
	}
	else
	{
		if($frm_tgl_periode!="")
		{ 
			$sql=$sql." and (restasi.tgl_kegiatan >='".datetomysql($frm_tgl_periode)."')"; 
		}
		if($frm_tgl_periode2!="")
		{ 
			$sql=$sql." and (restasi.tgl_kegiatan <='".datetomysql($frm_tgl_periode2)."')"; 
		}
	}
	
	
	if ($frm_s_NRP!="")
	{ 	 $sql .= " and (prestasi.nrp='".$frm_s_NRP."')";}
	
	if ($frm_s_jurusan!="all")
	{    $sql .= " and (prestasi.jurusan='".$frm_s_jurusan."')";}
	
	if ($frm_s_nama!="")
    {  	 $sql .= " and (master_mhs.NAMA LIKE '%".$frm_s_nama."%')"; } 
	
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

$vlink="lap_prestasi_mhs.php";
$abc="?mode=2&frm_s_jurusan=$frm_s_jurusan&frm_s_NRP=$frm_s_NRP&frm_s_nama=$frm_s_nama&frm_s_kode_dosen2=$frm_s_kode_dosen2&frm_s_jum_data=$frm_s_jum_data";

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
      ~</strong> PRESTASI MAHASISWA</font></font></td>
    <td width="11%"><div align="center"></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<br>
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div>
<?

if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="lap_prestasi_mhs_export.php">
<input type="hidden" name="mode" value="3">
<input type="hidden" name="frm_s_judul" value="<?php echo $frm_s_judul; ?>">
<input type="hidden" name="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
<input type="hidden" name="frm_s_NRP" value="<?php echo $frm_s_NRP; ?>">
<input type="hidden" name="frm_s_nama" value="<?php echo $frm_s_nama; ?>">
<input type="hidden" name="frm_s_kode_dosen2" value="<?php echo $frm_s_kode_dosen2; ?>">
<input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<?
}
   if ($frm_s_jurusan!="all")
	{
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id='".$frm_s_jurusan."'";
		$result_jur = @mysql_query($sql_jur);
		$row_jur=@mysql_fetch_array($result_jur);
		echo "<b>Jurusan: </b>".$row_jur["nama_jur"]."<br>";
	}
	

if (mysql_num_rows($result)==0) {
    echo "<br><font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=lap_prestasi_mhs.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}
if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>

	<table width="100%" border="1" cellpadding="3" cellspacing="0" class="table">
	   <tr bgcolor="#C6E2FF">
			<th nowrap class="td"><b>No.</b></th>
			<th nowrap class="td"><b>NRP</b></th>
			<th nowrap class="td"><b>NAMA</b></th>
			<th nowrap class="td"><b>KEGIATAN</b></th>
			<th nowrap class="td"><b>TANGGAL</b></th>
			<th nowrap class="td"><b>TEMPAT</b></th>
	        <th nowrap class="td">TINGKAT</th>
	        <th nowrap class="td">PRESTASI</th>
      </tr>
<?

$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
?>
		<tr>
			<td nowrap><? echo ($hal-1)*$frm_s_jum_data+$a; ?></td>
			<td nowrap><? echo $row["nrp"]; ?></td>
			<td nowrap><? echo $row["NAMA"]; ?></td>
			<td nowrap><? echo $row["kegiatan"]; ?></td>
			<td nowrap><? echo $row["tgl_kegiatan"]; ?></td>
			<td nowrap><? echo $row["tempat"]; ?></td>
		    <td nowrap>
			<?  
				$sql_tingkat="SELECT * FROM status_publikasi WHERE status_publikasi.id_pub=".$row['tingkat'];
				$result_tingkat = @mysql_query($sql_tingkat);
				$row_tingkat=@mysql_fetch_array($result_tingkat);
				echo $row_tingkat["nama"];
			?>
			</td>
			<td nowrap><? echo $row["hasil"]; ?></td>
		</tr>
<?
}
?>
  </table>
   <input name="excel"   type="image" onClick="document.fexcel.action='lap_prestasi_mhs_export.php?t=excel'" src="../../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
   Export ke File Excel&nbsp;
    <input name="printer" type="image"  onClick="document.fexcel.action='lap_prestasi_mhs_export.php?t=printer'" src="../../img/print.gif" align="bottom" width="18" height="18"> 
    Print
</FORM>
<?
}
?>
<?
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
</body>
</html>