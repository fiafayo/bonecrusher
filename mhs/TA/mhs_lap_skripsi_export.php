<?php
/* 
   DATE CREATED : 30/11/07
   KEGUNAAN     : EXPORT LAPORAN MAHASISWA YG LULUS TA - LULUS S1
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
			 DATE_FORMAT(`master_ta`.`TGL_TA`,'%d/%m/%Y') as TGL_AWAL,
			 DATE_FORMAT(`master_ta`.`AKHIR1`,'%d/%m/%Y') as TGL_AKHIR,
			 DATE_FORMAT(`master_ta`.`AKHIR2`,'%d/%m/%Y') as TGL_AKHIR2,
			 DATE_FORMAT(`lulus_ta`.`tgl_ujian`,'%d/%m/%Y') as TGL_LULUS_TA,
			 DATE_FORMAT(`lulus_ta`.`tgl_lulus`,'%d/%m/%Y') as TGL_LULUS_S1,
			 master_mhs.jurusan,
			 lulus_ta.nilai_ujian,
			 lulus_ta.sks,
			 lulus_ta.ipk,
			 lulus_ta.bidang_minat,
			 master_ta.STATUS,
			 master_ta.KOLUS
        FROM master_ta,master_mhs,lulus_ta
	   WHERE master_ta.NRP=master_mhs.NRP AND 
			 master_ta.NRP=lulus_ta.NRP AND 
			 master_ta.KOLUS='L' AND master_ta.STATUS='S'";

// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_s_jurusan!="all")
	{ $sql .= " and master_mhs.jurusan='".$frm_s_jurusan."'";}
	
	if($frm_id_tahun_ajar!="all")
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
		//$sql=$sql." and (`lulus_ta`.`tgl_lulus` between '".$row_periode->awal."' and '".$row_periode->akhir."')"; 
		$sql=$sql." and (`lulus_ta`.`semester`= '".$row_periode->semester."' and `lulus_ta`.`tahun`= '".$row_periode->tahun_ajaran."')"; 

		//echo "<br>frm_id_tahun_ajar=".$frm_id_tahun_ajar;
		//echo "<br>tahun_ajar=".$row_periode->tahun_ajaran;
		//echo "<br>semester=".$row_periode->semester;
	}
	
	if($frm_tgl_periode!="" && $frm_tgl_periode2!="")
	{ 
		$sql=$sql." and (`lulus_ta`.`tgl_lulus` between '".datetomysql($frm_tgl_periode)."' and '".datetomysql($frm_tgl_periode2)."')"; 
	}
	/*else
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
if ($frm_id_tahun_ajar !='all')
{
$excel_export.="<div align=\"center\"><b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b></div>
				<div align=\"center\"><b>LAPORAN DAFTAR SKRIPSI</b></div>
				<div align=\"center\"><b>Periode Semester : ".$row_periode->awal." - ".$row_periode->akhir."</b></div>
				<br><br>";
}
else
{
$excel_export.="<div align=\"center\"><b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b></div>
				<div align=\"center\"><b>LAPORAN DAFTAR SKRIPSI</b></div>
				<div align=\"center\"><b>Periode Tgl.Lulus : ".$frm_tgl_periode." - ".$frm_tgl_periode2."</b></div>
				<br><br>";
}	
				
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
					<td nowrap><strong>No.</strong></td>
					<td nowrap><strong>NRP</strong></td>
					<td nowrap><strong>Judul Skripsi </strong></td>
					<td nowrap><strong>Tgl. AWAL Skripsi</strong></td>
					<td nowrap><strong>Tgl. AKHIR Skripsi</strong></td>
					<td nowrap><strong>Dosen Pembimbing 1</strong></td>
					<td nowrap><strong>Dosen Pembimbing 2</strong></td>
				  </tr>";
$a=0;
while(($row_1 = mysql_fetch_array($result)))
{
	$a++;
	$sql_dobing1="SELECT kode, nama, NPK
				  FROM dosen
				  WHERE kode='".$row_1["KODOS1"]."'";
	$result_dobing1 = @mysql_query($sql_dobing1);
	$row_dobing1=@mysql_fetch_array($result_dobing1);
   
    $sql_dobing2="SELECT kode, nama, NPK
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
	
   $sql_ulur="SELECT NRP,
					 DATE_FORMAT(tgl_ulur,'%d/%m/%Y') as tgl_ulur
				 ROM perpanjang_ta
			   WHERE NRP='".$row_1["NRP"]."'";
   $result_ulur = @mysql_query($sql_ulur);
   $row_ulur=@mysql_fetch_array($result_ulur);
				
	
$excel_export.="<tr>
					<td>".$a."</td>
					<td nowrap>".$row_1["NRP"]."</td>
					<td nowrap>".$row_1["JUDUL_TA"]."</td>
					<td nowrap>".$row_1["TGL_AWAL"]."</td>
					<td nowrap>".$row_1["TGL_AKHIR"]."</td>
					<td nowrap>".$row_dobing1["NPK"]."</td>
					<td nowrap>".$row_dobing2["NPK"]."</td>
				  </tr>";
}

$excel_export.="</table>";
//}

//echo "excel_export= ".$excel_export;
//exit();

if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=EXP_SKRIPSI-".date("dmY").".xls");

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