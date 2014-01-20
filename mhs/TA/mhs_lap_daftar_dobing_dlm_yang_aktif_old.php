<?php
/* 
   DATE CREATED : 26/07/07
   KEGUNAAN     : MENAMPILKAN DOSEN PEMBIMBING DALAM YG AKTIF
   VARIABEL     : $frm_tgl_awal - parameter(GET) tgl awal yang ingin ditampilkan
		  $frm_tgl_akhir - parameter(GET) tgl akhir yang ingin ditampilkan 
		  $frm_o1, $frm_o2, $frm_o3 - parameter(GET) untuk order by perintah SQL

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
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
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
      ~</strong> DAFTAR DOSEN PEMBIMBING DALAM YANG AKTIF</font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form>
  <table width="80%" align="center" class="body" >
    <tr> 
      <td width="26%">Jurusan</td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td width="69%">
	  <select name="frm_s_jurusan" class="tekboxku">
          <option value="all">Semua 
          <?php
  	             $result2 = @mysql_query("SELECT * FROM `jurusan` WHERE `jurusan`.id>0 AND `jurusan`.id<9");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["id"].">".$row2["jurusan"];
	             }
         	?>
        </select>
	   </td>
    </tr>
    <tr>
      <td nowrap>NPK Dosen </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  	<select name="frm_kode_dosen" id="frm_kode_dosen" class="tekboxku">
           <option <?php if ($frm_kode_dosen==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sqlDosen="select kode, nama
						   from dosen";
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->kode; ?>" <?php if ($frm_kode_dosen==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
          <?php
				}
				
				?>
        </select>        
		<span class="style1">*</span>
	  </td>
    </tr>
    <tr> 
      <td nowrap><i>Banyak Data yang ditampilkan</i></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> <select name="frm_s_jum_data" class="tekboxku">
          <option value=2>2 
          <option value=10>10 
          <option value=15>15 
          <option value=20 selected>20 </select> </td>
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
	        
/*$sql="SELECT dosen.kode,
			 dosen.nama,
			 jurusan.jurusan as nama_jur,
			 dosen.jab_akademik,
			 dosen.status
        FROM dosen,jurusan
		WHERE dosen.jurusan=jurusan.id and dosen.status='1' AND kode LIKE '61%'";*/

$sekarang=date("Y-m-d");
/*$sql="SELECT master_ta.NRP,
             master_ta. KODOS1,
             master_ta. KODOS2,
	         dosen.nama,	     
             dosen.jurusan,
			 dosen.jab_akademik,
             jurusan.jurusan as nama_jur
      FROM   master_ta, dosen, jurusan
       WHERE master_ta.KODOS1= dosen.kode AND
             master_ta.AKHIR1 >= '".$sekarang."'";
			 
			 
$sql="SELECT master_ta.NRP,
			 master_ta.KODOS1,
			 master_ta.KODOS2,
			 dosen.nama,
			 dosen.jurusan,
			 dosen.jab_akademik,
			 jurusan.jurusan as nama_jur
		FROM master_ta
			 Inner Join dosen ON master_ta.KODOS1 = dosen.kode 
			 Inner Join jurusan ON dosen.jurusan = jurusan.id
        WHERE  ((master_ta.KODOS1='".$frm_kode_dosen."' OR master_ta.KODOS2='".$frm_kode_dosen."') AND (master_ta.AKHIR1>= '".$sekarang."'))";			 
			 
			 */
			 
$sql="SELECT master_ta.NRP,
			 master_ta.KODOS1,
			 master_ta.KODOS2,
			 dosen.nama,
			 dosen.jurusan,
			 dosen.jab_akademik,
			 jurusan.jurusan as nama_jur
		FROM master_ta
			 Inner Join dosen ON master_ta.KODOS1 = dosen.kode 
			 Inner Join jurusan ON dosen.jurusan = jurusan.id
        WHERE  master_ta.AKHIR1>= '".$sekarang."'";			 
	  
if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_kode_dosen!="--- Pilih ---")
	{ $sql .= " AND (master_ta.KODOS1='".$frm_kode_dosen."' OR master_ta.KODOS2='".$frm_kode_dosen."')";}


	if ($frm_s_jurusan!="all")
	{ 
		echo "<br>jurusan='".$frm_s_jurusan."'";
	//exit();
	$sql .= " AND dosen.jurusan='".$frm_s_jurusan."'";}
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

$vlink="mhs_lap_daftar_dobing_dlm_yang_aktif.php";
$abc="?mode=2&frm_s_jurusan=$frm_s_jurusan&frm_s_jum_data=$frm_s_jum_data&frm_kode_dosen=$frm_kode_dosen";

$vlink=$vlink.$abc;

$fontface="Verdana,Arial,Helvetica,sans-serif";
$fontsize="2";
}
// SELESAI MBULETNYA PAGING ------------------------------
// JIKA MODE HASIL LAPORAN DI MONITOR MAKA PAGING IN ACTION
if ($mode=="2") { $sql=$sql." limit ".$limit; }
echo "<br>sql=".$sql;
//ORDER BY  master_ta.NRP DESC
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
      ~</strong> </font><font color="#006699"><font color="#0099CC" size="1">DAFTAR DOSEN PEMBIMBING DALAM YANG AKTIF</font></font><font color="#0099CC" size="1">	  </font></font> </td>
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
<FORM METHOD="Post" name="fexcel" ACTION="mhs_lap_daftar_dobing_dlm_yang_aktif.php">

<input type=hidden name="mode" value="3">
<input type=hidden name="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
<input type=hidden name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<?
}
if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=mhs_lap_daftar_dobing_dlm_yang_aktif.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}
if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>

	<table width="98%" border="1" cellpadding="0" cellspacing="0">
		<tr><td>
		<table width="100%"  border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td colspan="5"></td>
          </tr>
		  <tr>
				    <td height="25"><strong>Kode</strong></td>
				    <td><strong>Nama</strong></td>
				    <td><strong>Jurusan</strong></td>
				    <td><strong>Jabatan Akademik</strong></td>
				    <td><strong>Jumlah</strong></td>
				    <td><strong>NRP</strong></td>
	      </tr>
			<?
			$a=0;
			while(($row = mysql_fetch_array($result)))
			{
			$a++;
			?>
				  <tr>
					<td width="10%" height="25"><? if ($a==1) echo $row["KODOS1"]; ?></td>
					<td width="35%"><?  if ($a==1) echo $row["nama"]; ?></td>
					<td width="21%"><? if ($a==1) echo $row["nama_jur"]; ?></td>
					<td width="21%"><? if ($a==1) echo $row["jab_akademik"]; ?></td>
					<td width="13%"><? //if ($row["status"]=='1') echo "aktif"; ?><? if ($a==1) echo $maxrows;?></td>
					<td width="21%"><? echo $row["NRP"]; ?></td>
				  </tr>
			<?
			}
			?>
        </table>		
		<br>
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