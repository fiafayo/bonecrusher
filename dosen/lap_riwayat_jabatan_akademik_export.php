<?
session_start();
require("../include/global.php");
require("../include/fungsi.php");

if ($frm_s_jab_akademik=='lokal')
{	        
	$sql="SELECT riwayat_jabatan_lokal.urut_id,
				 riwayat_jabatan_lokal.kode,
				 riwayat_jabatan_lokal.NPK,
				 riwayat_jabatan_lokal.NAMA,
				 riwayat_jabatan_lokal.golongan,
				 riwayat_jabatan_lokal.jabatan_lokal,
				 riwayat_jabatan_lokal.tgl_terhitung,
				 riwayat_jabatan_lokal.LEGALITAS
			FROM riwayat_jabatan_lokal
		   WHERE riwayat_jabatan_lokal.jabatan_lokal<>''";
		   
	if ($mode=="2" || $mode=="3" || $mode=="4")
	{
		if ($frm_s_kode_dosen!="")
		{
			 $sql .= " and (riwayat_jabatan_lokal.kode='".$frm_s_kode_dosen."')";
		}
		if ($frm_s_nama!="")
		{
			 $sql .= " and (riwayat_jabatan_lokal.NAMA LIKE '%".$frm_s_nama."%')";
		}
	}
	
}
else if ($frm_s_jab_akademik=='kopertis')
{
	$sql="SELECT riwayat_jabatan_kopertis.urut_id,
				 riwayat_jabatan_kopertis.kode,
				 riwayat_jabatan_kopertis.NPK,
				 riwayat_jabatan_kopertis.NAMA,
				 riwayat_jabatan_kopertis.golongan,
				 riwayat_jabatan_kopertis.jabatan_kopertis,
				 riwayat_jabatan_kopertis.tgl_terhitung,
				 riwayat_jabatan_kopertis.LEGALITAS
			FROM riwayat_jabatan_kopertis
		   WHERE riwayat_jabatan_kopertis.jabatan_kopertis<>'' ";
	
	if ($mode=="2" || $mode=="3" || $mode=="4")
	{
		if ($frm_s_kode_dosen!="")
		{
			 $sql .= " and (riwayat_jabatan_kopertis.kode='".$frm_s_kode_dosen."')";
		}
		if ($frm_s_nama!="")
		{
			 $sql .= " and (riwayat_jabatan_kopertis.NAMA LIKE '%".$frm_s_nama."%')";
		}
	}
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
$excel_export.="<b>LAPORAN RIWAYAT JABATAN AKADEMIK DOSEN</b><br>";

$excel_export.="<b>Tgl. Cetak : ".date("d-m-Y")."</b><br><br>";
/*if ($frm_s_jurusan!="all")
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
*/

    $excel_export.="<table border=1>
					<tr>
					<td nowrap><strong>KODE</strong></td>
					<td nowrap><strong>NPK</strong></td>
					<td nowrap><strong>NAMA</strong></td>
					<td nowrap><strong>GOLONGAN</strong></td>";

if ($frm_s_jab_akademik=='lokal') {
	$excel_export.="<td nowrap><strong>JABATAN LOKAL</strong></td>";
} 
else if ($frm_s_jab_akademik=='kopertis')
{
	$excel_export.="<td nowrap><strong>JABATAN KOPERTIS</strong></td>";
}

	$excel_export.="<td nowrap><strong>TGL.TERHITUNG </strong></td>
					<td nowrap><strong>LEGALITAS</strong></td>
					</tr>";				
					

while(($row = mysql_fetch_array($result)))
{						
             $excel_export.="<tr>
								<td nowrap>".$row["kode"]."</td>
								<td nowrap>".$row["NPK"]."</td>
								<td nowrap>".$row["NAMA"]."</td>
								<td nowrap align=\"center\">".$row["golongan"]."</td>";
			if ($frm_s_jab_akademik=='lokal') {
				$excel_export.="<td nowrap><strong>".$row["jabatan_lokal"]."</strong></td>";
			} 
			else if ($frm_s_jab_akademik=='kopertis')
			{
				$excel_export.="<td nowrap><strong>".$row["jabatan_kopertis"]."</strong></td>";
			}
        
		$excel_export.="<td nowrap>".$row["tgl_terhitung"]."</td>
        				<td nowrap>".$row["LEGALITAS"]."</td>
      					</tr>";

		

}
	$excel_export.="</table>";


if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=riwayat_jbtn_akademik_dsn-".date("dmY").".xls");

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
