<?php
/* 
   DATE CREATED : 26/07/07
   LAST UPDATE  : 14/10/08 - RAHADI
   KEGUNAAN     : EXPORT LAPORAN MAHASISWA BARU
   VARIABEL     : 
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

$sql="SELECT maharu.id_mhu,
			 maharu.angkatan,
			 maharu.jurusan_id,
			 maharu.jum_mhs,
			 DATE_FORMAT(maharu.tgl_masuk,'%d/%m/%Y') as tgl_masuk
        FROM maharu,jurusan
	   WHERE maharu.jurusan_id=jurusan.id";

// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_s_jurusan!="all")
	{ 
		$sql .= " and maharu.jurusan_id='".$frm_s_jurusan."'";
	}
	if ($frm_angkatan!="")
	{ 
		$sql .= " and maharu.angkatan='".$frm_angkatan."'";
	}

	
f_connecting();
mysql_select_db($DB);
$result=@mysql_query($sql);

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

$excel_export.="<div align=\"center\"><b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b></div>
				<div align=\"center\"><b>LAPORAN DAFTAR MAHASISWA BARU</b></div>
				<div align=\"center\"><b>JURUSAN: ".$row_periode->awal." - ".$row_periode->akhir."</b></div>
				<div align=\"center\"><b>ANGKATAN: ".$row_periode->awal." - ".$row_periode->akhir."</b></div>
				<br><br>";
				
if ($frm_s_jurusan!="all")
	{
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id2='".$frm_s_jurusan."'";
		$result_jur = @mysql_query($sql_jur);
		$row_jur=@mysql_fetch_array($result_jur);
		//echo "<b>Jurusan: </b>".$row_jur["nama_jur"];
		$excel_export.="<b>Jurusan: </b>".$row_jur["nama_jur"];
	}
	else 
	{
		$excel_export.="<b>Jurusan: Semua</b>";
	}

$excel_export.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$excel_export.="<b>Tgl. Cetak : ".date("d-m-Y")."</b><br><br>";

$excel_export.="<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
					<td><strong>No.</strong></td>
					<td><strong>Jurusan</strong></td>
					<td><strong>NRP</strong></td>
					<td><strong>Nama</strong></td>
					<td><strong>Judul TA </strong></td>
					<td><strong>Nilai TA </strong></td>
					<td><strong>Dosen Pembimbing 1</strong></td>
					<td><strong>Dosen Pembimbing 2</strong></td>
					<td><strong>Tgl Lulus TA </strong></td>
					<td><strong>Status Kuliah </strong></td>
					<td nowrap><strong>Status TA </strong></td>
				  </tr>";
$a=0;
while(($row_1 = mysql_fetch_array($result)))
{
	$a++;
	$sql_dobing1="SELECT kode, nama
				  FROM dosen
				  WHERE kode='".$row_1["KODOS1"]."'";
	$result_dobing1 = @mysql_query($sql_dobing1);
	$row_dobing1=@mysql_fetch_array($result_dobing1);
   
    $sql_dobing2="SELECT kode, nama
			      FROM dosen
			      WHERE kode='".$row_1["KODOS2"]."'";
    $result_dobing2 = @mysql_query($sql_dobing2);
    $row_dobing2=@mysql_fetch_array($result_dobing2);
	
	switch ($row_1["jurusan"])
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
			break;
		case '6G':
			$jur_nama="Desain Manajemen Produk";
			break;
			break;
		case '6H':
			$jur_nama="Sistem Informasi";
			break;
			break;
		case '6I':
			$jur_nama="Multimedia";
			break;
			break;
		case '6J':
			$jur_nama="Dual Degree";
			break;			
	}
	
	if ($row_1["STATUS"]=='S')
	{ $status_kul="SELESAI";}
	else
	{ $status_kul="BELUM";}
		
	if ($row_1["KOLUS"]=='L')
	{ $status_TA="LULUS TA";}
	else
	{ $status_TA="BELUM";}
	
$excel_export.="<tr>
					<td>".$a."</td>
					<td nowrap>".$jur_nama."</td>
					<td nowrap>".$row_1["NRP"]."</td>
					<td nowrap>".$row_1["NAMA"]."</td>
					<td nowrap>".$row_1["JUDUL_TA"]."</td>
					<td nowrap>".$row_1["nilai_ujian"]."</td>
					<td nowrap>".$row_dobing1["kode"]." - ".$row_dobing1["nama"]."</td>
					<td nowrap>".$row_dobing2["kode"]." - ".$row_dobing2["nama"]."</td>
					<td nowrap>".$row_1["TGL_LULUS"]."</td>
					<td nowrap>".$status_kul."</td>
					<td nowrap>".$status_TA."</td>
				  </tr>";

}

$excel_export.="</table>";
//}

//echo "excel_export= ".$excel_export;
//exit();

if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=LAP_lulus_TA-S1-".date("dmY").".xls");

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
<?php 
}
?>