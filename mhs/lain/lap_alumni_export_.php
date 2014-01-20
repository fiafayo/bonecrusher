<?php
/* 
   HISTORY      : 01/04/03 - SELESAI
						   - KALO COBA RUN JANGAN LUPA ISI QUERYSTRING frm_o1 - frm_o3
				  11/04/03 - BIKIN SATU SQL PANJANG 
				  08/06/03 - CUKUP QUALIFIED      

   DATE CREATED : 01/04/03
   LAST UPDATE  : 08/06/03 - KENNY
   KEGUNAAN     : MENAMPILKAN LAPORAN MASTER ALUMNI
   VARIABEL     : $frm_tgl_awal - parameter(GET) tgl awal lulus yang ingin ditampilkan
		  $frm_tgl_akhir - parameter(GET) tgl akhir lulus yang ingin ditampilkan 
		  $frm_o1, $frm_o2, $frm_o3 - parameter(GET) untuk order by perintah SQL

		  $sql, $result, $row - "select master_alumni.*,master_mhs.nama as nama, master_mhs.sex as sex, master_mhs.email as email, kota.nama as kota from master_alumni, master_mhs,kota where master_alumni.nrp=master_mhs.nrp and master_alumni.id_kota_perusahaan=kota.id"
		  
		  $a - untuk counter nomor laporan

   KETERANGAN   : PROSES CEK AUTHENTIFIKASI DICOMMENT UNTUK COBA JALANKAN
		  ADA MASALAH !! KALO KOTA SQL DIPISAH TIDAK BOSA SORTING,
 		  KALO GABUNG, DATA GA DIISI TIDAK AKAN TAMPIL
		  IDE !! ADA KOTA DENGAN VALUE "TIDAK ADA DATA"
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
			
$sql="SELECT master_alumni.*,
             master_mhs.nama as nama, 
			 master_mhs.kelamin as kelamin, 
			 master_mhs.email as email,
			 master_mhs.kelamin,
			 master_mhs.jurusan
	    FROM master_alumni, 
	         master_mhs
	   WHERE master_alumni.nrp=master_mhs.nrp";


// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_s_nrp_awal!="" || $frm_s_nrp_akhir!="")
	{
		if ($frm_s_nrp_awal!="" && $frm_s_nrp_akhir!="")
		{
			$sql=$sql." and master_alumni.nrp>='".$frm_s_nrp_awal."' and master_alumni.nrp<='".$frm_s_nrp_akhir."'";
		}
		if ($frm_s_nrp_awal=="" && $frm_s_nrp_akhir!="")
		{
			$sql=$sql." and master_alumni.nrp<='".$frm_s_nrp_akhir."'";
		}
		if ($frm_s_nrp_awal!="" && $frm_s_nrp_akhir=="")
		{
			$sql=$sql." and master_alumni.nrp>='".$frm_s_nrp_awal."'";
		}
	} 
	if ($frm_s_nama!="")
	{ $sql=$sql." and master_mhs.nama like '".$frm_s_nama."%'"; }
	if ($frm_s_jurusan!="all")
	{ $sql .= " and master_mhs.jurusan='".$frm_s_jurusan."'";}
	if ($frm_s_sex!="all")
	{ $sql=$sql." and master_mhs.kelamin='".$frm_s_sex."'"; }
	
	if ($frm_s_tanggal_lulus1!="" || $frm_s_tanggal_lulus2!="")
	{  
		if($frm_s_tanggal_lulus1!="" && $frm_s_tanggal_lulus2!="")
		{ $sql=$sql." and master_alumni.tanggal_lulus between '".datetomysql($frm_s_tanggal_lulus1)."' and '".datetomysql($frm_s_tanggal_lulus2)."'"; }
		else
		{
			if($frm_s_tanggal_lulus1!="")
			{ $sql=$sql." and master_alumni.tanggal_lulus>='".datetomysql($frm_s_tanggal_lulus1)."'"; }
			if($frm_s_tanggal_lulus2!="")
			{ $sql=$sql." and master_alumni.tanggal_lulus<='".datetomysql($frm_s_tanggal_lulus2)."'"; }
		}
	}

	if ($frm_s_nama_perusahaan!="")
	{ $sql=$sql." and master_alumni.nama_perusahaan like '%".$frm_s_nama_perusahaan."%'"; }

	if ($frm_s_tanggal_kerja1!="" || $frm_s_tanggal_kerja2!="")
	{  
		if($frm_s_tanggal_kerja1!="" && $frm_s_tanggal_kerja2!="")
		{ $sql=$sql." and master_alumni.tanggal_mulai_kerja between '".datetomysql($frm_s_tanggal_kerja1)."' and '".datetomysql($frm_s_tanggal_kerja2)."'"; }
		else
		{
			if($frm_s_tanggal_kerja1!="")
			{ $sql=$sql." and master_alumni.tanggal_mulai_kerja>='".datetomysql($frm_s_tanggal_kerja1)."'"; }
			if($frm_s_tanggal_kerja2!="")
			{ $sql=$sql." and master_alumni.tanggal_mulai_kerja<='".datetomysql($frm_s_tanggal_kerja2)."'"; }
		}
	}
	
	if ($frm_s_gaji1!="1")
	{
		if ($frm_s_gaji1!="")
		{
		    $sql=$sql." and master_alumni.gaji_pertama='".$frm_s_gaji1."'";
		}
	} 
	
	$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;


f_connecting();

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

$excel_export.="<b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b><br><br>
<b>LAPORAN DAFTAR ALUMNI</b><br><br>";

$excel_export.="<b>Tgl. Cetak : ".date("d-m-Y")."</b><br><br>";

$excel_export.="<table border=1>";

$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
		$excel_export.="<tr><td>
		<table>
			<tr>
				<td>No.</td>
				<td>:</td>
				<td>".$a."</td>
			</tr>
			<tr>
				<td>NRP</td>
				<td>:</td>
				<td>".$row["nrp"]."</td>
			</tr>
			<tr>
				<td>NAMA</td>
				<td>:</td>
				<td>".$row["nama"]."</td>
			</tr>
			<tr>
				<td>JENIS KELAMIN</td>
				<td>:</td>
				<td>".$row["sex"]."</td>
			</tr>
			<tr>
				<td>EMAIL</td>
				<td>:</td>
				<td>".$row["email"]."</td>
			</tr>
			<tr>
				<td>TANGGAL LULUS</td>
				<td>:</td>
				<td>".datetoreport($row["tanggal_lulus"])."</td>
			</tr>
			<tr>
				<td>NAMA PERUSAHAAN</td>
				<td>:</td>
				<td>".$row["nama_perusahaan"]."</td>
			</tr>
			<tr>
				<td>ALAMAT PERUSAHAAN</td>
				<td>:</td>
				<td>".$row["alamat_perusahaan"]."</td>
			</tr>
			<tr>
				<td>KOTA PERUSAHAAN</td>
				<td>:</td>
				<td>".$row["kota"]."</td>
			</tr>
			<tr>
				<td>TELEPON PERUSAHAAN</td>
				<td>:</td>
				<td>".$row["telepon_perusahaan"]."</td>
			</tr>
			<tr>
				<td>JABATAN</td>
				<td>:</td>
				<td>".$row["jabatan"]."</td>
			</tr>
			<tr>
				<td>TANGGAL MULAI BEKERJA</td>
				<td>:</td>
				<td>".datetoreport($row["tanggal_mulai_kerja"])."</td>
			</tr>
			<tr>
					<td>GAJI PERTAMA</td>
					<td>:</td>
			";
			


$excel_export.=" </tr>
			</table>
	
			</td>
			</tr>";
}



$excel_export.="</table>";

if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=alumni-".date("dmY").".xls");

echo ("$excel_export");
}
if ($t=='printer') {
?>
<html>
<link href="../../style.css" rel="stylesheet" type="text/css">

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
<?php }

?>
