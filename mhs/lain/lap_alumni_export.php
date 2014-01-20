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

$excel_export.="<div align=\"center\"><b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b></div>
				<div align=\"center\"><b>LAPORAN DAFTAR ALUMNI</b></div>
				<br><br>";
if ($frm_s_jurusan!="all")
	{
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id2='".$frm_s_jurusan."'";
		$result_jur = @mysql_query($sql_jur);
		$row_jur=@mysql_fetch_array($result_jur);
		$excel_export.="<b>Jurusan: </b>".$row_jur["nama_jur"];
	}
	else 
	{
		$excel_export.="<b>Jurusan: Semua</b>";
	}

$excel_export.="<b>Tgl. Cetak : ".date("d-m-Y")."</b><br><br>";

$excel_export.="<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
					<td nowrap><strong>No.</strong></td>
					<td nowrap><strong>NRP</strong></td>
					<td nowrap><strong>Nama</strong></td>
					<td nowrap><strong>Jurusan</strong></td>
					<td nowrap><strong>Jenis Kelamin</strong></td>
					<td nowrap><strong>Tgl Lulus S1</strong></td>
					<td nowrap><strong>e-mail</strong></td>
					<td nowrap><strong>Nama Perusahaan</strong></td>
					<td nowrap><strong>Alamat Perusahaan</strong></td>
					<td nowrap><strong>Kota Perusahaan</strong></td>
					<td nowrap><strong>Telp. Perusahaan</strong></td>
					<td nowrap><strong>Jabatan</strong></td>
					<td nowrap><strong>Tgl. mulai kerja</strong></td>
					<td nowrap><strong>Gaji pertama</strong></td>
				  </tr>";

$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
	
	if ($row["kelamin"]=='1'){
	$sex="Laki-laki";
	} 
	else if ($row["kelamin"]=='2'){
	$sex="Perempuan";
	}
	
    switch ($row["jurusan"])
	{
		case '6B':
			$jur_nama="Teknik Elektro";
			break;
		case '6C':
			$jur_nama="Teknik Kimia";
			break;
		case '6D':
			$jur_nama="Teknik Industri";
			break;
		case '6E':
			$jur_nama="Teknik Informatika";
			break;
		case '6F':
			$jur_nama="Teknik Manufaktur";
			break;
		case '6G':
			$jur_nama="Desain Manajemen Produk";
			break;
		case '6H':
			$jur_nama="Sistem Informasi";
			break;			
		case '6I':
			$jur_nama="Multimedia";
			break;
		case '6J':
			$jur_nama="Dual Degree";
			break;			
	}
	
	$sqlGaji= "select * from gaji where id=".$row["gaji_pertama"];
	$hasil = @mysql_query($sqlGaji);
	$baris = @mysql_fetch_array($hasil);
	if ($baris["gaji"]!='')
	{
		$gaji=$baris["gaji"];
	}
	else
	{ 
		$gaji="-";
    }
	
	
	
	$excel_export.="<tr>
					<td>".$a."</td>
					<td nowrap>".$row["nrp"]."</td>
					<td nowrap>".$row["nama"]."</td>
					<td nowrap>".$jur_nama."</td>
					<td nowrap>".$sex."</td>
					<td nowrap>".datetoreport($row["tanggal_lulus"])."</td>
					<td nowrap>".$row["email"]."</td>
					<td nowrap>".$row["nama_perusahaan"]."</td>
					<td nowrap>".$row["alamat_perusahaan"]."</td>
					<td nowrap>".$row["kota"]."</td>
					<td nowrap>".$row["telepon_perusahaan"]."</td>
					<td nowrap>".$row["jabatan"]."</td>
					<td nowrap>".datetoreport($row["tanggal_mulai_kerja"])."</td>
					<td nowrap>".$gaji."</td>";
					

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
