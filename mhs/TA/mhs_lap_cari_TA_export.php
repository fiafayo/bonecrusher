<?php
/* 
   DATE CREATED : 13/11/08
   KEGUNAAN     : EXPORT LAPORAN DATA MAHASISWA
   VARIABEL     : 

   KETERANGAN   : PROSES CEK AUTHENTIFIKASI DICOMMENT UNTUK COBA JALANKAN
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

$sql="SELECT master_mhs.NRP,
			 master_mhs.NAMA,
			 master_ta.JUDUL_TA,
			 master_ta.KODOS1,
			 master_ta.KODOS2,
			 DATE_FORMAT(`master_ta`.`AKHIR1`,'%d/%m/%Y') as TGL_AKHIR,
			 DATE_FORMAT(`lulus_ta`.`tgl_lulus`,'%d/%m/%Y') as TGL_LULUS,
			 master_mhs.jurusan,
			 lulus_ta.nilai_ujian,
			 master_ta.STATUS,
			 master_ta.KOLUS
        FROM master_ta,master_mhs,lulus_ta
	   WHERE master_ta.NRP=master_mhs.NRP AND 
			 master_ta.NRP=lulus_ta.NRP";

// PROSES UNTUK SEARCH (MODE=2)
	
	if ($frm_s_nrp!="")
	{ 
		$sql .= " and master_mhs.NRP LIKE '%".$frm_s_nrp."%'";
	}
	
	if ($frm_s_nama!="")
	{ 
		$sql .= " and master_mhs.nama LIKE '%".$frm_s_nama."%'";
	}
	
	if ($frm_s_jurusan!="all")
	{   
		$sql .= " and master_mhs.jurusan='".$frm_s_jurusan."'";
	}
	
	
	if ($frm_judul!="")
	{ 
		$sql .= " and master_ta.JUDUL_TA LIKE '%".$frm_judul."%'";
	}
	
	if ($frm_s_kode_dobing1!="all")
	{ 
		$sql .= " and master_ta.KODOS1 = '".$frm_s_kode_dobing1."'";
	}
	
	if ($frm_s_kode_dobing2!="all")
	{ 
		$sql .= " and master_ta.KODOS2 = '".$frm_s_kode_dobing2."'";
	}
	
	/*if($frm_id_tahun_ajar!="all")
	{ 
		f_connecting();
		mysql_select_db($DB);
		$sql_periode = ("SELECT  id, 
								 tahun_ajaran, 
								 semester, 
								 DATE_FORMAT(awal,'%Y/%m/%d') as awal, 
								 DATE_FORMAT(akhir,'%Y/%m/%d') as akhir 
						    FROM tahun_ajar 
						   WHERE id=$frm_id_tahun_ajar");
		$result_periode=@mysql_query($sql_periode);
		$row_periode=@mysql_fetch_object($result_periode);   
		
		$sql=$sql." and (`lulus_ta`.`tgl_lulus` between '".$row_periode->awal."' and '".$row_periode->akhir."')"; 
		//echo "<br>frm_id_tahun_ajar=".$frm_id_tahun_ajar;
		//echo "<br>tahun_ajar=".$row_periode->tahun_ajaran;
		//echo "<br>semester=".$row_periode->semester;
	}*/
	/*
	if($frm_tgl_periode!="" && $frm_tgl_periode2!="")
	{ 
		$sql=$sql." and (`lulus_ta`.`tgl_lulus` between '".datetomysql($frm_tgl_periode)."' and '".datetomysql($frm_tgl_periode2)."')"; 
	}
	else
	{
		if($frm_tgl_periode!="")
		{ 
			$sql=$sql." and (`lulus_ta`.`tgl_lulus` >='".datetomysql($frm_tgl_periode)."')"; 
		}
		if($frm_tgl_periode2!="")
		{ 
			$sql=$sql." and (`lulus_ta`.`tgl_lulus` <='".datetomysql($frm_tgl_periode2)."')"; 
		}
	}*/
		//echo "<br>frm_id_tahun_ajar=".$frm_id_tahun_ajar;
		//echo "<br>here3";
		//echo "<br>sql=".$sql;
		//exit();

	
f_connecting();
mysql_select_db($DB);
$result=@mysql_query($sql);

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

$excel_export.="<div align=\"center\"><b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b></div>
				<div align=\"center\"><b>LAPORAN DAFTAR DATA TA MAHASISWA</b></div>
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