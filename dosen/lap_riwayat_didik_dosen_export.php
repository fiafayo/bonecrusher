<?
session_start();
require("../include/global.php");
require("../include/fungsi.php");

$sql="SELECT riwayat_pendidikan.id_riwayat,
			 riwayat_pendidikan.kode_dosen,
			 riwayat_pendidikan.jurusan,
			 riwayat_pendidikan.jenjang,
			 riwayat_pendidikan.universitas,
			 riwayat_pendidikan.prodi,
			 riwayat_pendidikan.sumber_dana,
			 riwayat_pendidikan.tahun_selesai,
			 jurusan.jurusan as nama_jur,
			 dosen.nama
	    FROM riwayat_pendidikan,jurusan,dosen
		WHERE riwayat_pendidikan.jurusan=jurusan.id AND
		      riwayat_pendidikan.kode_dosen=dosen.kode ";	


if ($frm_s_kode_dosen!="")
	{
		 $sql .= " and (riwayat_pendidikan.kode_dosen='".$frm_s_kode_dosen."')";
	}
	if ($frm_s_jurusan!="all")
	{ 
		 $sql .= " and (riwayat_pendidikan.jurusan='".$frm_s_jurusan."')";
	}
	
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
//echo $sql;
f_connecting();

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

$excel_export.="<b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b><br><br>";
$excel_export.="<b>LAPORAN RIWAYAT PENDIDIKAN DOSEN</b><br>";

$excel_export.="<b>Tgl. Cetak : ".date("d-m-Y")."</b><br><br>";
if ($frm_s_jurusan!="all")
	{
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id=".$frm_s_jurusan;
		$result_jur = @mysql_query($sql_jur);
		$row_jur=@mysql_fetch_array($result_jur);
		//echo "<b>Jurusan: </b>".$row_jur["nama_jur"];
		$excel_export.="<b>Jurusan: </b>".$row_jur["nama_jur"];
	}
	else 
	{
		$excel_export.="<b>Jurusan: Semua</b>";
	}
$excel_export.="<table border=1>
				<tr>
					<td nowrap><strong>Jurusan</strong></td>
					<td nowrap><strong>Kode</strong></td>
					<td nowrap><strong>Nama</strong></td>
					<td nowrap><strong>Jenjang</strong></td>
					<td nowrap><strong>Universitas</strong></td>
					<td nowrap><strong>Program Studi</strong></td>
					<td nowrap><strong>Sumber dana </strong></td>
					<td nowrap><strong>Tahun Selesai</strong></td>
				</tr>";

while(($row = mysql_fetch_array($result)))
{
		
			
		$sql_nama_jurusan="SELECT id
						   FROM jurusan
						   WHERE id='".$row["jurusan"]."'";
		$result_nama_jurusan = @mysql_query($sql_nama_jurusan);
		$row_nama_jurusan=@mysql_fetch_array($result_nama_jurusan);
		//echo $row_nama_jurusan["id"];
		switch ($row_nama_jurusan["id"]) {
			case 1:
				$nama_jurusan='TE';
				break;
			case 2:
				$nama_jurusan='TK';
				break;
			case 3:
				$nama_jurusan='TI';
				break;
			case 4:
				$nama_jurusan='IF';
				break;
			case 5:
				$nama_jurusan='TM';
				break;
			}
		
			$sql_nama_dosen="SELECT nama
							   FROM dosen
							  WHERE kode='".$row["kode_dosen"]."'";
			$result_nama_dosen = @mysql_query($sql_nama_dosen);
			$row_nama_dosen=@mysql_fetch_array($result_nama_dosen);
			//echo $row_nama_dosen["nama"];
			
			switch ($row["publikasi"]) {
			case 1:
				$nama_publikasi='Regional';
				break;
			case 2:
				$nama_publikasi='Nasional';
				break;
			case 3:
				$nama_publikasi='Internasional';
				break;
			}
			//echo $nama_publikasi;
			
		switch ($row["status_jabatan"]) {
		case 1:
			$nama_jabatan='Ketua';
			break;
		case 2:
			$nama_jabatan='Wakil Ketua';
			break;
		case 3:
			$nama_jabatan='Anggota';
			break;
		case 4:
			$nama_jabatan='Instruktur';
			break;
		}
		//echo $nama_jabatan;
		
		$sql_sumber_dana="SELECT nama
						    FROM sumber_dana
						   WHERE id=".$row["id_sumber_dana"];
		$result_sumber_dana = @mysql_query($sql_sumber_dana);
		$row_sumber_dana=@mysql_fetch_array($result_sumber_dana);
		//echo $row_sumber_dana["nama"];
		
		$excel_export.="<tr>
							<td nowrap>".$nama_jurusan."</td>
							<td nowrap>".$row["kode_dosen"]."</td>
							<td nowrap>".$row_nama_dosen["nama"]."</td>
							<td nowrap>".$row["jenjang"]."</td>
							<td nowrap>".$row["universitas"]."</td>
							<td nowrap>".$row["prodi"]."</td>
							<td nowrap>".$row["sumber_dana"]."</td>
							<td nowrap>".$row["tahun_selesai"]."</td>
						</tr>";
		

}
	$excel_export.="</table>";


if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=riwayat_didik_dosen-".date("dmY").".xls");

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

<?php
echo ("$excel_export");
?>
</body>
</html>
<?php }?>
