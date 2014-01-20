<?php
/* 
   DATE CREATED : 04/01/08
   KEGUNAAN     : EXPORT LAPORAN JADWAL KULIAH
   VARIABEL     : 
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

$sql="SELECT distinct
			 rekap_dosen.kode_MK,
			 rekap_dosen.nama_MK,
			 rekap_dosen.sks,
			 rekap_dosen.kp,
			 rekap_dosen.kode_dsn,
			 rekap_dosen.nama_dsn,
			 rekap_dosen.id_periode,
			 mksem.HARI_K,
			 mksem.HARI_K2,
			 mksem.RUANG_K,
			 mksem.RUANG_K2,
			 mksem.JAM_KM,
			 mksem.JAM_KS,
			 mksem.JAM_KM2,
			 mksem.JAM_KS2
	    FROM rekap_dosen,mksem
	   WHERE rekap_dosen.kode_MK=mksem.KODEMK ";

// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_id_tahun_ajar!="all")
		{ $sql=$sql." and (rekap_dosen.id_periode=".$frm_id_tahun_ajar.")"; }
		
	if ($frm_MK!="all")
		{ $sql=$sql." and (rekap_dosen.kode_MK='".$frm_MK."')"; }
		
	if ($frm_KP!="all")
		{ $sql=$sql." and (rekap_dosen.kp='".$frm_KP."')"; }
		
    if ($frm_SKS_MK!="all")
		{ $sql=$sql." and (rekap_dosen.sks=".$frm_SKS_MK.")"; }
		
	if ($frm_dosen!="all")
		{ $sql=$sql." and (rekap_dosen.kode_dsn='".$frm_dosen."')"; }
	
	if ($frm_hari_kuliah!="all")
		{ $sql=$sql." and (mksem.HARI_K=".$frm_hari_kuliah.") "; }
		
	//if ($frm_hari_kuliah!="all")
		//{ $sql=$sql." and (mksem.HARI_K=".$frm_hari_kuliah.") or (mksem.HARI_K2=".$frm_hari_kuliah.")"; }

//echo "<br>SQL= ".$sql;
	$sql=$sql." ORDER BY mksem.HARI_K,mksem.HARI_K2 ASC";

	
f_connecting();

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

$excel_export.="<b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b><br>
<b>LAPORAN JADWAL KULIAH</b><br><br>";
$excel_export.="<b>Tgl. Cetak : ".date("d-m-Y")."</b><br><br>";

	/*if ($frm_s_jurusan!="all")
	{ 
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id2='".$frm_s_jurusan."'";
		$result_jur = @mysql_query($sql_jur);
		$row_jur=@mysql_fetch_array($result_jur);
		$excel_export.="<b>".$row_jur["nama_jur"]."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
	} */

//$excel_export.="</b><br>";

if ($frm_hari_kuliah<>'all')
{
	switch ($frm_hari_kuliah) {
				case 1:
					$nama_hari_kul='Senin';
					break;
				case 2:
					$nama_hari_kul='Selasa';
					break;
				case 3:
					$nama_hari_kul='Rabu';
					break;
				case 4:
					$nama_hari_kul='Kamis';
					break;
				case 5:
					$nama_hari_kul='Jumat';
					break;
				case 6:
					$nama_hari_kul='Sabtu';
					break;
				}
		//echo "<i>Hari: ".$nama_hari_kul."</i><br>";
		$excel_export.="<b><i>Hari: ".$nama_hari_kul."</i></b><br>";
}

if ($frm_dosen<>'all')
{
	$sql_nama_dsn="SELECT kode, nama
				     FROM dosen
					 WHERE kode='".$frm_dosen."'";
					
					$res_nm_dsn= mysql_query($sql_nama_dsn);
					$row_nm_dsn = mysql_fetch_array($res_nm_dsn);
					
	//echo "<i>Dosen: ".$row_nm_dsn['nama']."($frm_dosen)</i><br>";
	$excel_export.="<b><i>Dosen: ".$row_nm_dsn['nama']."($frm_dosen)</i></b><br>";
}




$excel_export.="<table border=1 width=100%>";
$excel_export.="<tr>
					<td NOWRAP>HARI</td>
					<td NOWRAP>MINGGU ke-</td>
					<td NOWRAP>JAM</td>
					<td NOWRAP>KODE MK</td>
					<td NOWRAP>NAMA MK</td>
					<td NOWRAP>KP</td>
					<td NOWRAP>RUANG</td>
					<td NOWRAP>NPK DOSEN</td>
					<td NOWRAP>NAMA DOSEN</td>
				  </tr>";
//$a=0;
//minggu 1
while(($row = mysql_fetch_array($result)))
{
	switch ($row["HARI_K"]) {
				case 1:
					$nama_hari_kul_m1='Senin';
					break;
				case 2:
					$nama_hari_kul_m1='Selasa';
					break;
				case 3:
					$nama_hari_kul_m1='Rabu';
					break;
				case 4:
					$nama_hari_kul_m1='Kamis';
					break;
				case 5:
					$nama_hari_kul_m1='Jumat';
					break;
				case 6:
					$nama_hari_kul_m1='Sabtu';
					break;
				}
				//echo $nama_hari_kul_m1;
				if ($row["HARI_K2"]<>"")
				{
					$minggu='2';
				}
				else
				{
					$minggu='1';
				}
				
	//$a++;
	$excel_export.="<tr>
					  <td nowrap>".$nama_hari_kul_m1."</td>
					  <td nowrap>".$minggu."</td>
					  <td nowrap>".$row["JAM_KM"]." - ".$row["JAM_KS"]."</td>
					  <td nowrap>".$row["kode_MK"]."</td>
					  <td nowrap>".$row["nama_MK"]."</td>
					  
					  <td nowrap>".$row["kp"]."</td>
					  <td nowrap>".$row["RUANG_K"]."</td>
					  
					  <td nowrap>".$row["kode_dsn"]."</td>
					  <td nowrap>".$row["nama_dsn"]."</td>
				  </tr>";
}
//minggu 2
while(($row = mysql_fetch_array($result)))
{
	switch ($row["HARI_K2"]) {
				case 1:
					$nama_hari_kul_m2='Senin';
					break;
				case 2:
					$nama_hari_kul_m2='Selasa';
					break;
				case 3:
					$nama_hari_kul_m2='Rabu';
					break;
				case 4:
					$nama_hari_kul_m2='Kamis';
					break;
				case 5:
					$nama_hari_kul_m2='Jumat';
					break;
				case 6:
					$nama_hari_kul_m2='Sabtu';
					break;
				}
				//echo $nama_hari_kul_m1;
				if ($row["HARI_K2"]<>"")
				{
					$minggu='2';
				}
				else
				{
					$minggu='1';
				}
				
	//$a++;
	$excel_export.="<tr>
					  <td nowrap>".$nama_hari_kul_m2."</td>
					  <td nowrap>".$minggu."</td>
					  <td nowrap>".$row["JAM_KM2"]." - ".$row["JAM_KS2"]."</td>
					  <td nowrap>".$row["kode_MK"]."</td>
					  <td nowrap>".$row["nama_MK"]."</td>
					  
					  <td nowrap>".$row["kp"]."</td>
					  <td nowrap>".$row["RUANG_K2"]."</td>
					  
					  <td nowrap>".$row["kode_dsn"]."</td>
					  <td nowrap>".$row["nama_dsn"]."</td>
				  </tr>";
}


$excel_export.="</table>";

if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=LAP_jadwal_kuliah-".date("dmY").".xls");

echo ("$excel_export");
}
if ($t=='printer') {
?>
<html>
<link href="../style.css" rel="stylesheet" type="text/css">

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

<?php
echo ("$excel_export");
?>

</body>
</html>
<?php 
}
?>