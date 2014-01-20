<?
/* 
   DATE CREATED : 10/08/07
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

$sql="select tulisan_ilmiah.*, 
             master_karyawan.kode as kode, 
			 master_karyawan.nip as nip, 
			 master_karyawan.nama as nama,
			 status_media.nama as status,
			 jurusan.jurusan as nama_jur 
	  from tulisan_ilmiah, master_karyawan, status_media, jurusan 
	  where tulisan_ilmiah.id_karyawan=master_karyawan.id and  
			tulisan_ilmiah.id_status_media=status_media.id and
			jurusan.id=master_karyawan.jurusan";

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
	if ($frm_s_kode!="")
	{ $sql=$sql." and master_karyawan.kode like '%".$frm_s_kode."%'"; }
	if ($frm_s_judul!="")
	{ $sql=$sql." and tulisan_ilmiah.judul like '%".$frm_s_judul."%'"; } 
	if ($frm_s_media!="")
	{ $sql=$sql." and tulisan_ilmiah.nama_media like '%".$frm_s_media."%'"; } 
	if ($frm_s_status!="all")
	{ $sql=$sql." and status_media.id=".$frm_s_status; } 

	$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
//echo $sql;
f_connecting();

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

$excel_export.="<b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b><br><br>";
$excel_export.="<b>LAPORAN TULISAN ILMIAH DOSEN</b><br>";

$excel_export.="<b>Tgl. Cetak : ".date("d-m-Y")."</b><br><br>";

$excel_export.="<table border=1>
		<tr>
			<td>Tanggal</td>
			<td>Jurusan</td>
			<td>Volume</td>
			<td>Kode</td>
			<td>NIP</td>
			<td>Nama Media</td>
			<td>Judul</td>
			<td>Status Media</td>
		</tr>";

while(($row = mysql_fetch_array($result)))
{
		$excel_export.="<tr>
			<td>".datetoreport($row["tanggal"])."</td>
			<td>".$row["nama_jur"]."</td>
			<td>".$row["volume"]."</td>
			<td>".$row["kode"]."</td>
			<td>".$row["nip"]."</td>
			<td>".$row["nama_media"]."</td>
			<td>".$row["judul"]."</td>
			<td>".$row["status"]."</td>
		</tr>";
}
	$excel_export.="</table>";

if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=tulisan_ilmiah_dosen-".date("dmY").".xls");

echo ("$excel_export");
}
if ($t=='printer') {
?>
<html>
<link href="../css/style.css" rel="stylesheet" type="text/css">

<script language="Javascript1.2">
	<!--
	function printpage() {
	window.print();  
	}
    //-->
</script>
<body onload="printpage()" class="print">
<script language="Javascript1.2">
	<!--
	function printpage() {
	window.print();  
	}
	//-->
</script>
<?php echo ("$excel_export");?>
</body>
</html>
<?php }?>
