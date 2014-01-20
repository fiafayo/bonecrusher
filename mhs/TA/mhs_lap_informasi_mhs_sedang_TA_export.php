<?php
/* 
   DATE CREATED : 01/04/06
   LAST UPDATE  : 08/11/07 - RAHADI
   KEGUNAAN     : EXPORT LAPORAN MAHASISWA YANG SEDANG-TA
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
			 DATE_FORMAT(`master_ta`.`AKHIR2`,'%d/%m/%Y') as TGL_AKHIR2,
			 master_mhs.jurusan
        FROM master_ta,master_mhs
		WHERE master_ta.NRP=master_mhs.NRP AND master_ta.KOLUS=''";


// PROSES UNTUK AMBIL DATA SESUAI PILIHAN
if ($frm_s_jurusan!="all")
	{ $sql .= " and master_mhs.jurusan='".$frm_s_jurusan."'";}
	
if ($frm_tgl_periode!="")
	{ $sql=$sql." and master_ta.AKHIR1>='".datetomysql($frm_tgl_periode)."'"; }
	
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;

f_connecting();

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

$excel_export.="<div align=\"center\"><b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b></div>
				<div align=\"center\"><b>LAPORAN MAHASISWA YANG SEDANG TA</b></div>
				<div align=\"center\"><b>Periode: ".$frm_tgl_periode."</b></div>
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
					<td height=\"19\"><strong>No.</strong></td>
					<td><strong>Jurusan</strong></td>
					<td><strong>NRP</strong></td>
					<td><strong>Nama</strong></td>
					<td><strong>Judul TA </strong></td>
					<td><strong>Dosen Pembimbing 1</strong></td>
					<td><strong>Dosen Pembimbing 2</strong></td>
					<td align=center><strong>Batas akhir TA</strong></td>
				  </tr>";

$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
	$sql_dobing1="SELECT kode, nama
				  FROM dosen
				  WHERE kode='".$row["KODOS1"]."'";
	$result_dobing1 = @mysql_query($sql_dobing1);
	$row_dobing1=@mysql_fetch_array($result_dobing1);
   
    $sql_dobing2="SELECT kode, nama
			      FROM dosen
			      WHERE kode='".$row["KODOS2"]."'";
    $result_dobing2 = @mysql_query($sql_dobing2);
    $row_dobing2=@mysql_fetch_array($result_dobing2);
	
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
	}
		
		//echo "<br>TGL 1=".$row["TGL_AKHIR"];
		//echo "<br>TGL 2=".$row["TGL_AKHIR2"];
		//if ($row["TGL_AKHIR2"]<>"00/00/0000")
		//{
			//$batas_akhir=$row["TGL_AKHIR2"];
		//}
		//else
		//{
			$batas_akhir=$row["TGL_AKHIR"];
		//}
		//echo "<br>BATAS akhir".$batas_akhir;
	$excel_export.="<tr>
						<td>".$a."</td>
						<td nowrap>".$jur_nama."</td>
						<td nowrap>".$row["NRP"]."</td>
						<td nowrap>".$row["NAMA"]."</td>
						<td nowrap>".$row["JUDUL_TA"]."</td>
						<td nowrap>".$row_dobing1["kode"]." - ".$row_dobing1["nama"]."</td>
						<td nowrap>".$row_dobing2["kode"]." - ".$row_dobing2["nama"]."</td>
						<td nowrap>".$batas_akhir."</td>
					</tr>";
}
		$excel_export.="</table>";
//echo $excel_export;
//exit();
if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=LAP_sedang_TA-".date("dmY").".xls");

echo ("$excel_export");
}
if ($t=='printer') {
?>
<html>
<link href="../../css/style2.css" rel="stylesheet" type="text/css">

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