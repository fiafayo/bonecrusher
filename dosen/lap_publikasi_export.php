<?
/* 
   KETERANGAN 	: EXPORT HASIL LAPORAN PUBLIKASI ke EXCEL


   DATE CREATED : 28/11/08
   LAST UPDATE  : 
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

//query lama sebelum tulisan ilmiah di hapuskan
/*$sql="SELECT publikasi.no_st_pub,
							  publikasi.urut_st_pub,
							  publikasi.kode_kary,
							  publikasi.kode_kary2,
							  publikasi.kode_kary3,
							  publikasi.kode_kary4,
							  publikasi.kode_kary5,
							  publikasi.status,
							  publikasi.jenis,
							  publikasi.TET_sub,
							  publikasi.TNET_sub,
							  publikasi.tugas,
							  publikasi.hari_go,
							  DATE_FORMAT(publikasi.tgl_go,'%d/%m/%Y') as tgl_go,
							  publikasi.pukul_go,
							  publikasi.tempat_go,
							  publikasi.transport_go,
							  publikasi.hari_dtg,
							  DATE_FORMAT(publikasi.tgl_dtg,'%d/%m/%Y') as tgl_dtg,
							  publikasi.pukul_dtg,
							  publikasi.transport_dtg,
							  publikasi.biaya,
							  publikasi.L_ap_tax,
							  publikasi.L_fiskal,
							  publikasi.L_visa,
							  publikasi.L_saku,
							  publikasi.L_akomo,
							  publikasi.L_other,
							  publikasi.ndt_terakhir,
							  tulisan_ilmiah.kode_dosen1,
							  tulisan_ilmiah.kode_dosen2,
							  tulisan_ilmiah.kode_dosen3,
							  tulisan_ilmiah.kode_dosen4,
							  tulisan_ilmiah.kode_dosen5,
							  tulisan_ilmiah.publikasi,
							  tulisan_ilmiah.jurn_pros,
							  tulisan_ilmiah.jurusan_id,
							  tulisan_ilmiah.man_kel,
							  tulisan_ilmiah.judul,
							  tulisan_ilmiah.pub_ISBN,
							  tulisan_ilmiah.pub_volume,
							  tulisan_ilmiah.pub_penyelenggara,
							  DATE_FORMAT(tulisan_ilmiah.pub_tanggal,'%d/%m/%Y') as pub_tanggal,
							  tulisan_ilmiah.no_paten,
							  tulisan_ilmiah.pemberi_paten,
							  DATE_FORMAT(tulisan_ilmiah.tanggal_terbit,'%d/%m/%Y') as tanggal_terbit,
							  tulisan_ilmiah.id_sumber_dana,
							  tulisan_ilmiah.dana,
							  tulisan_ilmiah.dana_asing,
							  tulisan_ilmiah.kode_dosen1,
							  tulisan_ilmiah.kode_dosen2,
							  tulisan_ilmiah.kode_dosen3,
							  tulisan_ilmiah.kode_dosen4,
							  tulisan_ilmiah.kode_dosen5
					     FROM tulisan_ilmiah
                    Left Join publikasi ON tulisan_ilmiah.no_st_pub = publikasi.no_st_pub
						WHERE tulisan_ilmiah.judul <>'' ";*/

                   $sql="SELECT publikasi.no_legalitas,
								publikasi.no_st_pub,
								publikasi.urut_st_pub,
								publikasi.jenis,
								publikasi.publikasi,
								DATE_FORMAT(publikasi.tgl_publikasi,'%d/%m/%Y') as tgl_publikasi,
								DATE_FORMAT(publikasi.tgl_publikasi2,'%d/%m/%Y') as tgl_publikasi2,
								publikasi.jurn_pros,
								publikasi.kode_kary,
								publikasi.kode_kary2,
								publikasi.kode_kary3,
								publikasi.kode_kary4,
								publikasi.kode_kary5,
								publikasi.status,
								publikasi.TET_sub,
								publikasi.TNET_sub,
								publikasi.judul,
								publikasi.tugas,
								publikasi.pub_ISBN,
								publikasi.pub_volume,
								publikasi.pub_penyelenggara,
								DATE_FORMAT(publikasi.pub_tgl_pub,'%d/%m/%Y') as pub_tgl_pub,
								publikasi.pub_no_paten,
								publikasi.pub_pemberi_paten,
								DATE_FORMAT(publikasi.pub_tgl_paten,'%d/%m/%Y') as pub_tgl_paten,
								publikasi.pub_id_sumber_dana,
								publikasi.pub_jum_dana_lokal,
								publikasi.pub_jum_dana_asing,
								publikasi.hari_go,
								DATE_FORMAT(publikasi.tgl_go,'%d/%m/%Y') as tgl_go,
								publikasi.pukul_go,
								publikasi.tempat_go,
								publikasi.transport_go,
								publikasi.hari_dtg,
								DATE_FORMAT(publikasi.tgl_dtg,'%d/%m/%Y') as tgl_dtg,
								publikasi.pukul_dtg,
								publikasi.transport_dtg,
								publikasi.biaya,
								publikasi.L_ap_tax,
								publikasi.L_fiskal,
								publikasi.L_visa,
								publikasi.L_saku,
								publikasi.L_akomo,
								publikasi.L_other,
								publikasi.ndt_terakhir,
								publikasi.last_update
					       FROM publikasi
						  WHERE publikasi.tugas <>'' ";

if ($frm_s_tgl_publikasi1!="" || $frm_s_tgl_publikasi2!="")
	{  
		if($frm_s_tgl_publikasi1!="" && $frm_s_tgl_publikasi2!="")
		{ $sql=$sql." and publikasi.tgl_publikasi between '".datetomysql($frm_s_tgl_publikasi1)."' and '".datetomysql($frm_s_tgl_publikasi2)."'"; }
		else
		{
			if($frm_s_tgl_publikasi1!="")
			{ $sql=$sql." and publikasi.tgl_publikasi >='".datetomysql($frm_s_tgl_publikasi1)."'"; }
			if($frm_s_tgl_publikasi2!="")
			{ $sql=$sql." and publikasi.tgl_publikasi <='".datetomysql($frm_s_tgl_publikasi2)."'"; }
		}
	}	
	
if ($frm_s_tgl_terbit1!="" || $frm_s_tgl_terbit2!="")
	{  
		if($frm_s_tgl_terbit1!="" && $frm_s_tgl_terbit2!="")
		{ $sql=$sql." and publikasi.pub_tgl_paten between '".datetomysql($frm_s_tgl_terbit1)."' and '".datetomysql($frm_s_tgl_terbit2)."'"; }
		else
		{
			if($frm_s_tgl_terbit1!="")
			{ $sql=$sql." and publikasi.pub_tgl_paten>='".datetomysql($frm_s_tgl_terbit1)."'"; }
			if($frm_s_tgl_terbit2!="")
			{ $sql=$sql." and publikasi.pub_tgl_paten<='".datetomysql($frm_s_tgl_terbit2)."'"; }
		}
	}
	
	if ($frm_s_jurusan != "all")
	{ $sql.=" and publikasi.TET_sub=".$frm_s_jurusan;}	
	
	if ($frm_s_no_st_pub!="")
	{ $sql=$sql." and publikasi.no_st_pub='".$frm_s_no_st_pub."'"; } 
	
	if ($frm_s_kode!="")
	{ $sql=$sql." and ((publikasi.kode_kary like '%".$frm_s_kode."%') or 
					   (publikasi.kode_kary2 like '%".$frm_s_kode."%') or
					   (publikasi.kode_kary3 like '%".$frm_s_kode."%') or
				       (publikasi.kode_kary4 like '%".$frm_s_kode."%') or
					   (publikasi.kode_kary5 like '%".$frm_s_kode."%'))"; } 
	if ($frm_s_nama!="")
	{ 
	  $sql_kode_dosen="SELECT kode
						 FROM dosen
					    WHERE nama LIKE '%".$frm_s_nama."%'";
	  //$result_kode_dosen = @mysql_query($sql_kode_dosen);
	  if(!($result_kode_dosen = mysql_db_query($DB,$sql_kode_dosen)))
			{
				echo mysql_error();
        			return 0;
			}
	  $row_kode_dosen = mysql_fetch_array($result_kode_dosen);
	  
	  //$row_kode_dosen = @mysql_fetch_object($result_kode_dosen);

	  //echo "<br>sql_kode_dosen=".$sql_kode_dosen;
	 // echo "<br>frm_s_nama=".$frm_s_nama;
	 // echo "<br>kodenya -=".$row_kode_dosen['kode'];
	 // exit();
	  
	  $sql=$sql." and ((publikasi.kode_kary like '%".$row_kode_dosen["kode"]."%') or 
					   (publikasi.kode_kary2 like '%".$row_kode_dosen["kode"]."%') or
					   (publikasi.kode_kary3 like '%".$row_kode_dosen["kode"]."%') or
				       (publikasi.kode_kary4 like '%".$row_kode_dosen["kode"]."%') or
					   (publikasi.kode_kary5 like '%".$row_kode_dosen["kode"]."%'))"; }
	if ($frm_s_judul!="")
	{ $sql=$sql." and publikasi.judul like '%".$frm_s_judul."%'"; }
	
	if ($frm_s_sumber_dana!="all")
	{ $sql=$sql." and publikasi.pub_id_sumber_dana=".$frm_s_sumber_dana; }
	
	if ($frm_tipe_publikasi!=0) // jurnal prosiding
	{ $sql=$sql." and publikasi.jurn_pros = ".$frm_tipe_publikasi; } 
	
	if ($frm_s_sifat_pen!="all") // mandiri/kelompok
	{ $sql=$sql." and publikasi.jenis = '".$frm_s_sifat_pen."'"; } 
	
	if ($frm_s_ska_publikasi!="0") // nasional, regional, international
	{ $sql=$sql." and publikasi.publikasi = ".$frm_s_ska_publikasi; } 
	
	$sql=$sql." order by tgl_publikasi DESC ";	
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
//echo $sql;
f_connecting();

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

$excel_export.="<b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b><br><br>";
$excel_export.="<b>LAPORAN PUBLIKASI</b><br>";

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
			<td nowrap><b>No.</b></td>
			<td nowrap><b>No.Surat</b></td>
			<td nowrap><b>Jurusan</b></td>
			<td nowrap><b>Dosen 1</b></td>
			<td nowrap><b>Dosen 2</b></td>
			<td nowrap><b>Dosen 3</b></td>
			<td nowrap><b>Dosen 4</b></td>
			<td nowrap><b>Dosen 5</b></td>
			<td nowrap><b>Judul</b></td>
			<td nowrap><b>Publikasi</b></td>
			<td nowrap><b>Tipe</b></td>
			<td nowrap><b>Mandiri/Kelompok</b></td>
			<td nowrap><b>ISBN/ISSN</b></td>
			<td nowrap><b>Volume</b></td>
			<td nowrap><b>Penyelenggara</b></td>
			<td nowrap><b>Tgl. Publikasi </b></td>
			<td nowrap><b>No. Hak Paten </b></td>
			<td nowrap><b>Pemberi Hak Paten </b></td>
			<td nowrap><b>Tgl. Terbit </b></td>
			<td nowrap><b>Sumber Dana </b></td>
			<td nowrap><b>Nominal Dana</b></td>
			<td nowrap><b>Nominal Dana Asing</b></td>
			<td nowrap><b>TET. sub sistem </b></td>
			<td nowrap><strong> TNET. <b>sub sistem</b></strong></td>
			<td nowrap><b>Status</b></td>
			<td nowrap><b>Tugas</b></td>
			<td nowrap><b>Hari Go </b></td>
			<td nowrap><b>Tgl. Go</b></td>
			<td nowrap><b>Pukul Go</b></td>
			<td nowrap><b>Tempat Go</b></td>
			<td nowrap><b>Transportasi Go</b></td>
			<td nowrap><b>Hari Dtg</b></td>
			<td nowrap><b>Tgl. Dtg</b></td>
			<td nowrap><b>Pukul Dtg</b></td>
			<td nowrap><b>Transportasi Dtg</b></td>
			<td nowrap><b>Biaya Program </b></td>
			<td nowrap><strong> Airport Tax </strong></td>
			<td nowrap><strong>Visa</strong></td>
			<td nowrap><strong> Akomodasi </strong></td>
			<td nowrap><strong> Fiskal Luar Negeri </strong></td>
		    <td nowrap><strong> Uang Saku (biaya hidup) </strong></td>
		    <td nowrap><strong>Lainnya</strong></td>
		    <td nowrap><strong> Non degree training terakhir </strong></td>
		</tr>";
$count=1;
while(($row = mysql_fetch_array($result)))
{
		$sql_nama_jurusan="SELECT id
						   FROM jurusan
						   WHERE id='".$row["TET_sub"]."'";
		$result_nama_jurusan = @mysql_query($sql_nama_jurusan);
		$row_nama_jurusan=@mysql_fetch_array($result_nama_jurusan);
		//echo $row_nama_jurusan["id"];
		//exit();
		switch ($row_nama_jurusan["id"]) {
			case 1:
				$nama_jur='TE';
				break;
			case 2:
				$nama_jur='TK';
				break;
			case 3:
				$nama_jur='TI';
				break;
			case 4:
				$nama_jur='IF';
				break;
			case 5:
				$nama_jur='TM';
				break;
			}
		
		         $sql_nm_publikasi="SELECT id_pub, 
				                           nama 
				 				      FROM status_publikasi
							         WHERE id_pub=".$row["publikasi"];
				 $result_nm_publikasi = @mysql_query($sql_nm_publikasi);
				 $row_nm_publikasi = @mysql_fetch_array($result_nm_publikasi);
				 //echo $row_nm_publikasi["nama"];
				 
				 switch ($row["jurn_pros"]) {
						case 0:
							$nama_tipe='Tidak ada data';
							break;
						case 1:
							$nama_tipe='Jurnal';
							break;
						case 2:
							$nama_tipe='Prosiding';
							break;
						}
						//echo $nama_tipe;
						
				$sql_sumber_dana="SELECT nama
							        FROM sumber_dana
							       WHERE id=".$row["pub_id_sumber_dana"];
				$result_sumber_dana = @mysql_query($sql_sumber_dana);
				$row_sumber_dana=@mysql_fetch_array($result_sumber_dana);
				//echo $row_sumber_dana["nama"];
				
				$sql_TET="SELECT id
							       FROM jurusan
							       WHERE id='".$row["TET_sub"]."'";
				$result_TET = @mysql_query($sql_TET);
				$row_TET=@mysql_fetch_array($result_TET);
				//echo $row_nama_jurusan["id"];
				switch ($row_TET["id"]) {
					case 1:
						$nama_jurusan_TET='TE';
						break;
					case 2:
						$nama_jurusan_TET='TK';
						break;
					case 3:
						$nama_jurusan_TET='TI';
						break;
					case 4:
						$nama_jurusan_TET='IF';
						break;
					case 5:
						$nama_jurusan_TET='TM';
						break;
					}
					//echo $nama_jurusan;
					
					$sql_TNET="SELECT id
							       FROM jurusan
							       WHERE id='".$row["TNET_sub"]."'";
				$result_TNET = @mysql_query($sql_TNET);
				$row_TNET=@mysql_fetch_array($result_TNET);
				//echo $row_nama_jurusan["id"];
				switch ($row_TNET["id"]) {
					case 1:
						$nama_jurusan_TNET='TE';
						break;
					case 2:
						$nama_jurusan_TNET='TK';
						break;
					case 3:
						$nama_jurusan_TNET='TI';
						break;
					case 4:
						$nama_jurusan_TNET='IF';
						break;
					case 5:
						$nama_jurusan_TNET='TM';
						break;
					}
					//echo $nama_jurusan;
					
					switch ($row["L_ap_tax"]) {
							case 0:
								$tax='TIDAK';
								break;
							case 1:
								$tax='YA';
								break;
					}
					//echo $tax; 
					
					switch ($row["L_visa"]) {
							case 0:
								$visa='TIDAK';
								break;
							case 1:
								$visa='YA';
								break;
					}
					//echo $visa; 
					
					switch ($row["L_akomo"]) {
							case 0:
								$ako='TIDAK';
								break;
							case 1:
								$ako='YA';
								break;
					}
					//echo $ako; 
					
					switch ($row["L_fiskal"]) {
							case 0:
								$fiskal='TIDAK';
								break;
							case 1:
								$fiskal='YA';
								break;
					}
					//echo $fiskal; 
					
					switch ($row["L_saku"]) {
							case 0:
								$saku='TIDAK';
								break;
							case 1:
								$saku='YA';
								break;
					}
					//echo $saku;
					
					switch ($row["L_other"]) {
							case 0:
								$lain='TIDAK';
								break;
							case 1:
								$lain='YA';
								break;
					}
					//echo $lain; 
					
			 if ($row["jenis"]==1) {
				$man_kel = "Mandiri";
				}
				else if ($row["jenis"]==2) {
				$man_kel = "Kelompok";
			}
			
				$sql_nama_dosen1="SELECT nama
							       FROM dosen
							       WHERE kode='".$row["kode_kary"]."'";
				$result_nama_dosen1 = @mysql_query($sql_nama_dosen1);
				$row_nama_dosen1=@mysql_fetch_array($result_nama_dosen1);
				//echo $row_nama_dosen1["nama"];
				$sql_nama_dosen2="SELECT nama
							       FROM dosen
							       WHERE kode='".$row["kode_kary2"]."'";
				$result_nama_dosen2 = @mysql_query($sql_nama_dosen2);
				$row_nama_dosen2=@mysql_fetch_array($result_nama_dosen2);
				//echo $row_nama_dosen1["nama"];
				$sql_nama_dosen3="SELECT nama
							       FROM dosen
							       WHERE kode='".$row["kode_kary3"]."'";
				$result_nama_dosen3 = @mysql_query($sql_nama_dosen3);
				$row_nama_dosen3=@mysql_fetch_array($result_nama_dosen3);
				//echo $row_nama_dosen1["nama"];
				$sql_nama_dosen4="SELECT nama
							       FROM dosen
							       WHERE kode='".$row["kode_kary4"]."'";
				$result_nama_dosen4 = @mysql_query($sql_nama_dosen4);
				$row_nama_dosen4=@mysql_fetch_array($result_nama_dosen4);
				//echo $row_nama_dosen1["nama"];
				$sql_nama_dosen5="SELECT nama
							       FROM dosen
							       WHERE kode='".$row["kode_kary5"]."'";
				$result_nama_dosen5 = @mysql_query($sql_nama_dosen5);
				$row_nama_dosen5=@mysql_fetch_array($result_nama_dosen5);
				//echo $row_nama_dosen1["nama"];
		
		$excel_export.="<tr>
							<td nowrap>".$count."</td>
							<td nowrap>".$row["no_st_pub"]."</td>
							<td nowrap>".$nama_jur."</td>
							<td nowrap>".$row["kode_kary"]." - ".$row_nama_dosen1["nama"]."</td>
							<td nowrap>".$row["kode_kary2"]." - ".$row_nama_dosen2["nama"]."</td>
							<td nowrap>".$row["kode_kary3"]." - ".$row_nama_dosen3["nama"]."</td>
							<td nowrap>".$row["kode_kary4"]." - ".$row_nama_dosen4["nama"]."</td>
							<td nowrap>".$row["kode_kary5"]." - ".$row_nama_dosen5["nama"]."</td>
							<td nowrap>".$row["judul"]."</td>
							<td nowrap>".$row_nm_publikasi["nama"]."</td>
							<td nowrap>".$nama_tipe."</td>
							<td nowrap>".$man_kel."</td>
							<td nowrap>".$row["pub_ISBN"]."</td>
							<td nowrap>".$row["pub_volume"]."</td>
							<td nowrap>".$row["pub_penyelenggara"]."</td>
							<td nowrap>".$row["pub_tgl_pub"]."</td>
							<td nowrap>".$row["no_paten"]."</td>
							<td nowrap>".$row["pemberi_paten"]."</td>
							<td nowrap>".$row["pub_tgl_paten"]."</td>
							<td nowrap>".$row_sumber_dana["nama"]."</td>
							<td nowrap>".$row["pub_jum_dana_lokal"]."</td>
							<td nowrap>".$row["pub_jum_dana_asing"]."</td>
							<td nowrap>".$nama_jurusan_TET."</td>
							<td nowrap>".$nama_jurusan_TNET."</td>
							<td nowrap>".$row["status"]."</td>
							<td nowrap>".$row["tugas"]."</td>
							<td nowrap>".$row["hari_go"]."</td>
							<td nowrap>".$row["tgl_go"]."</td>
							<td nowrap>".$row["pukul_go"]."</td>
							<td nowrap>".$row["tempat_go"]."</td>
							<td nowrap>".$row["transport_go"]."</td>
							<td nowrap>".$row["hari_dtg"]."</td>
							<td nowrap>".$row["tgl_dtg"]."</td>
							<td nowrap>".$row["pukul_dtg"]."</td>
							<td nowrap>".$row["transport_dtg"]."</td>
							<td nowrap>".$row["biaya"]."</td>
							<td nowrap>".$tax."</td>
							<td nowrap>".$visa."</td>
							<td nowrap>".$ako."</td>
							<td nowrap>".$fiskal."</td>
							<td nowrap>".$saku."</td>
							<td nowrap>".$lain."</td>
							<td nowrap>".$row["ndt_terakhir"]."</td>
						</tr>";
		
$count++;
}
	$excel_export.="</table>";


if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=publikasi_dosen-".date("dmY").".xls");

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
