<?php
/* 
   DATE CREATED : 01/11/07
   UPDATE       : 22/11/08 - RAHADI, tgl.lulus, tgl.awal ta 
   KEGUNAAN     : EXPORT MENAMPILKAN LAPORAN MAHASISWA YG LULUS TA NAMUN BELUM LULUS S1
   VARIABEL     : 

   KETERANGAN   : PROSES CEK AUTHENTIFIKASI DICOMMENT UNTUK COBA JALANKAN
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

$sql="SELECT master_mhs.NRP,
			 master_mhs.NAMA,
			 master_ta.JUDUL_TA,
			 lulus_ta.nilai_ujian,
			 master_ta.KODOS1,
			 master_ta.KODOS2,
			 DATE_FORMAT(`master_ta`.`TGL_TA`,'%d/%m/%Y') as TGL_AWAL,
			 DATE_FORMAT(`master_ta`.`AKHIR1`,'%d/%m/%Y') as TGL_AKHIR,
			 DATE_FORMAT(`master_ta`.`AKHIR2`,'%d/%m/%Y') as TGL_AKHIR2,
			 master_ta.kolus,
			 master_ta.status,
			 master_mhs.jurusan,
			 DATE_FORMAT(`lulus_ta`.`tgl_lulus`,'%d/%m/%Y') as tgl_lulus
        FROM master_ta,master_mhs, lulus_ta
		WHERE master_ta.NRP=master_mhs.NRP AND 
			  lulus_ta.NRP=master_ta.NRP AND
		      master_ta.KOLUS='L' AND master_ta.STATUS=''";

// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_s_jurusan!="all")
	{ $sql .= " and master_mhs.jurusan='".$frm_s_jurusan."'";}
	
	if($frm_tgl_periode!="")
	{ $sql=$sql." and lulus_ta.tgl_lulus >='".datetomysql($frm_tgl_periode)."'"; }
	
	if ($frm_kode_dobing!="all")
	{ $sql .= " and (master_ta.KODOS1='".$frm_kode_dobing."' or master_ta.KODOS2='".$frm_kode_dobing."')";}

		//echo "<br>frm_kode_dobing=".$frm_kode_dobing;
		//echo "<br>here3";
		//echo "<br>sql_1=".$sql;
		
		//exit();
	//$sql.= " ORDER BY lulus_ta.tgl_lulus ASC";

	
f_connecting();
mysql_select_db($DB);
$result=@mysql_query($sql);

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

$excel_export.="
    <div align=\"center\"><b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b></div>
    <div align=\"center\"><b>LAPORAN DAFTAR MAHASISWA LULUS TA BELUM LULUS S-1</b></div>
    <div align=\"center\"><b>Periode: ".$frm_tgl_periode." s/d tanggal sekarang</b></div>
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
					<td nowrap><strong>No.</strong></td>
					<td nowrap><strong>Jurusan</strong></td>
					<td nowrap><strong>NRP</strong></td>
					<td nowrap><strong>Nama</strong></td>
					<td nowrap><strong>Judul TA </strong></td>
					<td nowrap><strong>Pembimbing 1</strong></td>
					<td nowrap><strong>Pembimbing 2</strong></td>
					<td nowrap><strong>Nilai TA </strong></td>
					<td nowrap><strong>Tgl AWAL TA </strong></td>
					<td nowrap><strong>Tgl Akhir TA </strong></td>
					<td nowrap><strong>Tgl akhir perpanjangan TA</strong></td>
					<td nowrap><strong>Tgl LULUS TA </strong></td>
					<td nowrap><strong>Status TA </strong></td>
					<td nowrap><strong>Status Kuliah </strong></td>
				  </tr>";
$a=0;
while(($row_1 = mysql_fetch_array($result)))
{
	$a++;
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
	
	if ($row_1["status"]=='S')
	{ $status_kul="SELESAI";}
	else
	{ $status_kul="BELUM SELESAI";}
		
	if ($row_1["kolus"]=='L')
	{ $status_TA="LULUS TA";}
	else
	{ $status_TA="BELUM";}
	
$excel_export.="<tr>
					<td>".$a."</td>
					<td nowrap>".$jur_nama."</td>
					<td nowrap>".$row_1["NRP"]."</td>
					<td nowrap>".$row_1["NAMA"]."</td>
					<td nowrap>".$row_1["JUDUL_TA"]."</td>";
					
				$sql_dosen1="SELECT nama
							       FROM dosen
							       WHERE kode='".$row_1["KODOS1"]."'";
				$result_dosen1 = @mysql_query($sql_dosen1);
				$row_dosen1=@mysql_fetch_array($result_dosen1);
				//echo $row["KODOS1"]." - ".$row_dosen1["nama"];
	$excel_export.="<td nowrap>".$row_1["KODOS1"]." - ".$row_dosen1["nama"]."</td>";
					
				$sql_dosen2="SELECT nama
							       FROM dosen
							       WHERE kode='".$row_1["KODOS2"]."'";
				$result_dosen2 = @mysql_query($sql_dosen2);
				$row_dosen2=@mysql_fetch_array($result_dosen2);
				//echo $row["KODOS2"]." - ".$row_dosen2["nama"];
	$excel_export.="<td nowrap>".$row_1["KODOS2"]." - ".$row_dosen2["nama"]."</td>";
				
	$excel_export.="<td nowrap>".$row_1["nilai_ujian"]."</td>
	                <td nowrap>".$row_1["TGL_AWAL"]."</td>
					<td nowrap>".$row_1["TGL_AKHIR"]."</td>
					<td nowrap>".$row_1["TGL_AKHIR2"]."</td>
					<td nowrap>".$row_1["tgl_lulus"]."</td>
					<td nowrap>".$status_TA."</td>
					<td nowrap>".$status_kul."</td>
				  </tr>";
}

$excel_export.="</table>";
//}

//echo "excel_export= ".$excel_export;
//exit();

if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=LAP_lulus_TA_blm_S1-".date("dmY").".xls");

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
//$result_empty_temp = mysql_query("delete from temp_dalam where id_temp='".session_id()."'");
}
?>