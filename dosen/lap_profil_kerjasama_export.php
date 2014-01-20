<?
/* 
   KETERANGAN 	: EXPORT PROFIL KERJASAMA
   DATE CREATED : 06/02/08
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

/*echo "<br>frm_kode_dsn= ".$frm_kode_dsn;
	echo "<br>frm_s_publikasi= ".$frm_s_publikasi;
	echo "<br>frm_s_tanggal_mulai1= ".$frm_s_tanggal_mulai1;
	echo "<br>frm_s_tanggal_mulai2= ".$frm_s_tanggal_mulai2;
	echo "<br>frm_s_tanggal_selesai1= ".$frm_s_tanggal_selesai1;
	echo "<br>frm_s_tanggal_selesai2= ".$frm_s_tanggal_selesai2;
	echo "<br>frm_s_kode= ".$frm_s_kode;
	
	echo "<br>frm_s_judul= ".$frm_s_judul;
	
	echo "<br>frm_s_sumber_dana= ".$frm_s_sumber_dana;
	
	echo "<br>frm_s_jum_data= ".$frm_s_jum_data;
	
	echo "<br>frm_dana= ".$frm_dana;
	echo "<br>frm_kode_buku= ".$frm_kode_buku;
	echo "<br>frm_jenis_pen= ".$frm_jenis_pen;
	echo "<br>frm_sifat_pen= ".$frm_sifat_pen;*/

$sql="SELECT profil_kerjasama.id,
			 profil_kerjasama.kode,
			 profil_kerjasama.nama_institusi,
			 profil_kerjasama.id_jenis,
			 profil_kerjasama.id_tipe,
			 profil_kerjasama.kode_dosen,
			 profil_kerjasama.jabatan,
			 profil_kerjasama.judul,
			 DATE_FORMAT(profil_kerjasama.mulai,\"%d/%m/%Y\") as tanggal_mulai,
			 DATE_FORMAT(profil_kerjasama.selesai,\"%d/%m/%Y\") as tanggal_selesai,
			 profil_kerjasama.jumlah_staff,
			 profil_kerjasama.id_sumber_dana,
			 profil_kerjasama.jumlah_dana,
			 profil_kerjasama.jurusan,
			 profil_kerjasama.tempat,
			 profil_kerjasama.man_kel
	    FROM profil_kerjasama, sumber_dana, dosen, jurusan, jenis_kerjasama, tipe_kerjasama 
	   WHERE dosen.kode=profil_kerjasama.kode_dosen and 
	         profil_kerjasama.id_sumber_dana=sumber_dana.id and
			 profil_kerjasama.jurusan=jurusan.id and
			 profil_kerjasama.id_jenis=jenis_kerjasama.id and
			 profil_kerjasama.id_tipe=tipe_kerjasama.id";		


	if ($frm_s_tanggal_mulai1!="" || $frm_s_tanggal_mulai2!="")
	{  
		if($frm_s_tanggal_mulai1!="" && $frm_s_tanggal_mulai2!="")
		{ $sql=$sql." and profil_kerjasama.mulai between '".datetomysql($frm_s_tanggal_mulai1)."' and '".datetomysql($frm_s_tanggal_mulai2)."'"; }
		else
		{
			if($frm_s_tanggal_mulai1!="")
			{ $sql=$sql." and profil_kerjasama.mulai>='".datetomysql($frm_s_tanggal_mulai1)."'"; }
			if($frm_s_tanggal_mulai2!="")
			{ $sql=$sql." and profil_kerjasama.mulai<='".datetomysql($frm_s_tanggal_mulai2)."'"; }
		}
	}	
	if ($frm_s_tanggal_selesai1!="" || $frm_s_tanggal_selesai2!="")
	{  
		if($frm_s_tanggal_selesai1!="" && $frm_s_tanggal_selesai2!="")
		{ $sql=$sql." and profil_kerjasama.selesai between '".datetomysql($frm_s_tanggal_selesai1)."' and '".datetomysql($frm_s_tanggal_selesai2)."'"; }
		else
		{
			if($frm_s_tanggal_selesai1!="")
			{ $sql=$sql." and profil_kerjasama.selesai>='".datetomysql($frm_s_tanggal_selesai1)."'"; }
			if($frm_s_tanggal_selesai2!="")
			{ $sql=$sql." and profil_kerjasama.selesai<='".datetomysql($frm_s_tanggal_selesai2)."'"; }
		}
	}
	if ($frm_s_jurusan != "all")
	{ $sql.=" and profil_kerjasama.jurusan=".$frm_s_jurusan;}	
	if ($frm_s_kode!="")
	{ $sql=$sql." and dosen.kode like '%".$frm_s_kode."%'"; } 
	if ($frm_s_nama!="")
	{ $sql=$sql." and dosen.nama like '%".$frm_s_nama."%'"; } 
	if ($frm_s_judul!="")
	{ $sql=$sql." and profil_kerjasama.judul like '%".$frm_s_judul."%'"; }
	if ($frm_s_sumber_dana!="all")
	{ $sql=$sql." and sumber_dana.id=".$frm_s_sumber_dana; }
	if ($frm_s_publikasi!="all")
	{ $sql=$sql." and profil_kerjasama.id_jenis=".$frm_s_publikasi; }
	if ($frm_tipe_kerjasama!="all")
	{ $sql=$sql." and profil_kerjasama.id_tipe=".$frm_tipe_kerjasama; }
	
//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
//echo $sql;
f_connecting();

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

$excel_export.="<b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b><br><br>";
$excel_export.="<b>LAPORAN PROFIL KERJASAMA</b><br>";

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
			<td nowrap><b>Jurusan</b></td>
			<td nowrap><b>Kode</b></td>
			<td nowrap><b>Nama</b></td>
			<td nowrap><b>Judul</b></td>
			<td nowrap><b>Publikasi</b></td>
			<td nowrap><b>Tipe Kerjasama</b></td>
			<td nowrap><b>Keanggotaan</b></td>
			<td nowrap><b>Status Jabatan</b></td>
			<td nowrap><b>Sumber Dana</b></td>
			<td nowrap><b>Jumlah Dana</b></td>
			<td nowrap><b>Tgl. Mulai</b></td>
			<td nowrap><b>Tgl. Selesai</b></td>
		    <td nowrap><b>Tempat</b></td>
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
			
			$sql_publikasi="SELECT nama
							  FROM jenis_kerjasama
							 WHERE id=".$row["id_jenis"];
			$result_publikasi = @mysql_query($sql_publikasi);
			$row_publikasi=@mysql_fetch_array($result_publikasi);
			//echo $row_publikasi["nama"];
			
			 $sql_tipe_kerjasama="SELECT nama
							        FROM tipe_kerjasama
							       WHERE id=".$row["id_tipe"];
			$result_tipe_kerjasama = @mysql_query($sql_tipe_kerjasama);
			$row_tipe_kerjasama=@mysql_fetch_array($result_tipe_kerjasama);
			//echo $row_tipe_kerjasama["nama"];
			
		switch ($row["jabatan"]) {
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
							<td nowrap>".$row["judul"]."</td>
							<td nowrap>".$row_publikasi["nama"]."</td>
							<td nowrap>".$row_tipe_kerjasama["nama"]."</td>
							<td nowrap>".$row["man_kel"]."</td>
							<td nowrap>".$nama_jabatan."</td>
							<td nowrap>".$row_sumber_dana["nama"]."</td>
							<td nowrap>".$row["jumlah_dana"]."</td>
							<td nowrap>".$row["tanggal_mulai"]."</td>
							<td nowrap>".$row["tanggal_selesai"]."</td>
							<td nowrap>".$row["tempat"]."</td>
						</tr>";
		

}
	$excel_export.="</table>";


if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=profil_kerjasama-".date("dmY").".xls");

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