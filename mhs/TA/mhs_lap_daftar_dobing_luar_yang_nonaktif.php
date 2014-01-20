<?php
/* 
   DATE CREATED : 26/07/07
   KEGUNAAN     : MENAMPILKAN DOSEN PEMBIMBING DALAM YG AKTIF
   VARIABEL     : $frm_tgl_awal - parameter(GET) tgl awal yang ingin ditampilkan
		  $frm_tgl_akhir - parameter(GET) tgl akhir yang ingin ditampilkan 
		  $frm_o1, $frm_o2, $frm_o3 - parameter(GET) untuk order by perintah SQL
		  $frm_jenis - 0=ta; 1=lp

		  $sql, $result, $row - "select ta.*,master_karyawan.kode as kode_dosen1,master_karyawan.nama as nama_dosen1 from ta,master_karyawan where jenis=".$frm_jenis." and ta.id_dosen1=master_karyawan.id"

		  $sql2, $result2, $row2 - select * from master_karyawan where id=$row["id_dosen2"]
		  $sql3, $result3, $row3 - select * from master_mhs where id_ta='$row["id"]'
		  
		  $a - untuk counter nomor laporan TA/LP
		  $b - untuk counter nomor tabel laporan mahasiswa kerja TA/LP

   KETERANGAN   : PROSES CEK AUTHENTIFIKASI DICOMMENT UNTUK COBA JALANKAN
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
      ~</strong> DAFTAR DOSEN PEMBIMBING LUAR YANG NON-AKTIF</font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form>
  <table width="80%" align="center" class="body" >
    <tr> 
      <td width="26%">Jurusan</td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td width="69%"><select name="frm_s_jurusan" class="tekboxku">
          <option value="all">Semua 
          <?php
  	             $result2 = @mysql_query("SELECT * FROM `jurusan`");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["id"].">".$row2["jurusan"];
	             }
         	?>
        </select></td>
    </tr>
    <tr> 
      <td nowrap><i>Banyak Data yang ditampilkan</i></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> <select name="frm_s_jum_data" class="tekboxku">
          <option value=2>2 
          <option value=10>10 
          <option value=15>15 
          <option value=20>20 </select> </td>
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
// JIKA MODE<>0 MAKSUDNYA JIKA FORM DI SUBMIT MAKA KELUAR LAPORAN
/*$sql="select ta.*,
			 master_karyawan.id as id_karyawan
	  from ta, master_karyawan
	  where (ta.id_dosen1=master_karyawan.id or ta.id_dosen1=master_karyawan.kode) ";*/
	        
$sql="SELECT dosen.kode,
			 dosen.nama,
			 jurusan.jurusan,
			 dosen.jab_akademik,
			 dosen.status
        FROM dosen,jurusan
		WHERE dosen.jurusan=jurusan.id and dosen.status='0' AND kode NOT LIKE '61%'";
	  
if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)

	if ($frm_s_jurusan!="all")
	{ $sql .= " and dosen.jurusan='".$frm_s_jurusan."'";}
	
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

$vlink="mhs_lap_daftar_dobing_luar_yang_nonaktif.php";
$abc="?mode=2&frm_s_jurusan=$frm_s_jurusan&frm_s_jum_data=$frm_s_jum_data";

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
      ~</strong> </font><font color="#006699"><font color="#0099CC" size="1">DAFTAR DOSEN PEMBIMBING LUAR YANG NON-AKTIF</font></font><font color="#0099CC" size="1">	  </font></font> </td>
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
<FORM METHOD="Post" name="fexcel" ACTION="mhs_lap_daftar_dobing_luar_yang_nonaktif.php">

<input type=hidden name="mode" value="3">
<input type=hidden name="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
<input type=hidden name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<?
}
if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=mhs_lap_daftar_dobing_luar_yang_nonaktif.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}
if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>

	<table width="98%" border="1" cellpadding="0" cellspacing="0">
		<tr><td>
		<table width="100%"  border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td colspan="5"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10%"><strong>Kode</strong></td>
                <td width="35%"><strong>Nama</strong></td>
                <td width="21%"><strong>Jurusan</strong></td>
                <td width="21%"><strong>Jabatan Akademik </strong></td>
                <td width="13%"><strong>Status</strong></td>
              </tr>
            </table></td>
          </tr>
			<?
			$a=0;
			while(($row = mysql_fetch_array($result)))
			{
			$a++;
			?>
          <tr>
            <td width="10%" height="25"><? echo $row["kode"]; ?></td>
            <td width="35%"><? echo $row["nama"]; ?></td>
            <td width="21%"><? echo $row["jurusan"]; ?></td>
            <td width="21%"><? echo $row["jab_akademik"]; ?></td>
            <td width="13%"><? if ($row["status"]=='0') echo "non aktif"; ?></td>
          </tr>
			<?
			}
			?>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>		<br>
		</td>
		</tr>

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