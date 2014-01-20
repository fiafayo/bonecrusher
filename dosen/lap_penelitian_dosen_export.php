<?
/* 
   KETERANGAN 	: 

   HISTORY      : 06/07/03 - SELESAI 

   DATE CREATED : 06/07/03
   LAST UPDATE  : 06/7/03 16:00:00 - KENNY
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");


/*$sql="select buku_karya_dosen.*, 
			 master_karyawan.kode as kode, 
			 master_karyawan.nama as nama, 
			 penerbit.penerbit as penerbit,
			 jurusan.jurusan as nama_jur 
	  from buku_karya_dosen, master_karyawan, penerbit, jurusan 
	  where buku_karya_dosen.id_karyawan=master_karyawan.id and 
	        buku_karya_dosen.kode_penerbit=penerbit.id and
			master_karyawan.jurusan=jurusan.id";*/

$sql="SELECT penelitian.id_pen,
			 penelitian.kode_pen,
			 penelitian.kode_dosen,
			 penelitian.status_jabatan,
			 penelitian.publikasi,
			 penelitian.jurusan_id,
			 penelitian.judul,
			 penelitian.pub_ISBN,
			 penelitian.pub_tempat,
			 penelitian.pub_penyelenggara,
			 DATE_FORMAT(penelitian.tanggal_terbit,\"%d/%m/%Y\") as tanggal_terbit,
			 DATE_FORMAT(penelitian.tanggal_mulai,\"%d/%m/%Y\") as tanggal_mulai,
			 DATE_FORMAT(penelitian.tanggal_selesai,\"%d/%m/%Y\") as tanggal_selesai,
			 penelitian.jumlah_peneliti,
			 penelitian.id_sumber_dana,
			 penelitian.dana,
			 penelitian.kode_buku,
			 penelitian.jenis_pen,
			 penelitian.man_kel,
			 penelitian.no_paten,
			 penelitian.pemberi_paten,
			 penelitian.up_date
	    FROM penelitian, sumber_dana, dosen, jurusan 
	   WHERE dosen.kode=penelitian.kode_dosen and 
	         penelitian.id_sumber_dana=sumber_dana.id and
			 penelitian.jurusan_id=jurusan.id";			


if ($frm_s_tanggal_mulai1!="" || $frm_s_tanggal_mulai2!="")
	{  
		if($frm_s_tanggal_mulai1!="" && $frm_s_tanggal_mulai2!="")
		{ $sql=$sql." and penelitian.tanggal_mulai between '".datetomysql($frm_s_tanggal_mulai1)."' and '".datetomysql($frm_s_tanggal_mulai2)."'"; }
		else
		{
			if($frm_s_tanggal_mulai1!="")
			{ $sql=$sql." and penelitian.tanggal_mulai>='".datetomysql($frm_s_tanggal_mulai1)."'"; }
			if($frm_s_tanggal_mulai2!="")
			{ $sql=$sql." and penelitian.tanggal_mulai<='".datetomysql($frm_s_tanggal_mulai2)."'"; }
		}
	}	
	if ($frm_s_tanggal_selesai1!="" || $frm_s_tanggal_selesai2!="")
	{  
		if($frm_s_tanggal_selesai1!="" && $frm_s_tanggal_selesai2!="")
		{ $sql=$sql." and penelitian.tanggal_selesai between '".datetomysql($frm_s_tanggal_selesai1)."' and '".datetomysql($frm_s_tanggal_selesai2)."'"; }
		else
		{
			if($frm_s_tanggal_selesai1!="")
			{ $sql=$sql." and penelitian.tanggal_selesai>='".datetomysql($frm_s_tanggal_selesai1)."'"; }
			if($frm_s_tanggal_selesai2!="")
			{ $sql=$sql." and penelitian.tanggal_selesai<='".datetomysql($frm_s_tanggal_selesai2)."'"; }
		}
	}
	if ($frm_s_jurusan != "all")
	{ $sql.=" and penelitian.jurusan_id='".$frm_s_jurusan."'";}	
	if ($frm_s_kode!="")
	{ $sql=$sql." and dosen.kode like '%".$frm_s_kode."%'"; } 
	if ($frm_s_nama!="")
	{ $sql=$sql." and dosen.nama like '%".$frm_s_nama."%'"; } 
	if ($frm_s_judul!="")
	{ $sql=$sql." and penelitian.judul like '%".$frm_s_judul."%'"; }
	if ($frm_s_sumber_dana!="all")
	{ $sql=$sql." and sumber_dana.id=".$frm_s_sumber_dana; }
	if ($frm_s_jenis_pen!="all")
	{ $sql=$sql." and penelitian.jenis_pen = ".$frm_s_jenis_pen; } 
	if ($frm_s_sifat_pen!="all")
	{ $sql=$sql." and penelitian.man_kel = '".$frm_s_sifat_pen."'"; } 
	if ($frm_s_publikasi!="all")
	{ $sql=$sql." and penelitian.publikasi = ".$frm_s_publikasi; } 
	
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
//echo $sql;
f_connecting();

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

$excel_export.="<b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b><br><br>";
$excel_export.="<b>LAPORAN PENELITIAN DOSEN</b><br>";

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
			<td nowrap><b>Jenis</b></td>
			<td nowrap><b>Jurusan</b></td>
			<td nowrap><b>No.Surat</b></td>
			<td nowrap><b>NPK Dosen</b></td>
			<td nowrap><b>Nama</b></td>
			<td nowrap><b>Judul</b></td>
			<td nowrap><b>ISBN</b></td>
			<td nowrap><b>Volume</b></td>
			<td nowrap><b>Publikasi</b></td>
			<td nowrap><b>Mandiri/Kelompok</b></td>
			<td nowrap><b>Tempat</b></td>
			<td nowrap><b>Penyelenggara</b></td>
			<td nowrap><b>Status Jabatan</b></td>
			<td nowrap><b>Sumber Dana</b></td>
			<td nowrap><b>Jumlah Dana</b></td>
			<td nowrap><b>Tgl. Terbit</b></td>
			<td nowrap><b>Tgl. Mulai</b></td>
			<td nowrap><b>Tgl. Selesai</b></td>
			<td nowrap><b>No. Paten</b></td>
			<td nowrap><b>Pemberi Paten</b></td>
		</tr>";

while(($row = mysql_fetch_array($result)))
{
		
		 switch ($row["jenis_pen"]) {
			case 1:
				$nama_pen='Tulisan Ilmiah';
				break;
			case 2:
				$nama_pen='Buku Karya Dosen';
				break;
			case 3:
				$nama_pen='Penelitian';
				break;
			}
			
		$sql_nama_jurusan="SELECT id
						   FROM jurusan
						   WHERE id='".$row["jurusan_id"]."'";
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
							<td nowrap>".$nama_pen."</td>
							<td nowrap>".$nama_jurusan."</td>
							<td nowrap>".$row["kode_pen"]."</td>
							<td nowrap>".$row["kode_dosen"]."</td>
							<td nowrap>".$row_nama_dosen["nama"]."</td>
							<td nowrap>".$row["judul"]."</td>
							<td nowrap>".$row["pub_ISBN"]."</td>
							<td nowrap>".$row["pub_volume"]."</td>
							<td nowrap>".$nama_publikasi."</td>
							<td nowrap>".$row["man_kel"]."</td
							<td nowrap>".$row["pub_tempat"]."</td
							<td nowrap>".$row["pub_penyelenggara"]."</td>
							<td nowrap>".$nama_jabatan."</td>
							<td nowrap>".$row_sumber_dana["nama"]."</td>
							<td nowrap>".$row["dana"]."</td>
							<td nowrap>".$row["tanggal_terbit"]."</td>
							<td nowrap>".$row["tanggal_mulai"]."</td>
							<td nowrap>".$row["tanggal_selesai"]."</td>
							<td nowrap>".$row["no_paten"]."</td>
							<td nowrap>".$row["pemberi_paten"]."</td>
						</tr>";
		

}
	$excel_export.="</table>";


if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=penelitian_dosen-".date("dmY").".xls");

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
