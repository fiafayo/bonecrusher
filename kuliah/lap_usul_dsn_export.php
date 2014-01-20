<?php
/* 
   DATE CREATED : 04/01/08
   KEGUNAAN     : EXPORT LAPORAN USULAN DOSEN
   VARIABEL     : 
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

$sql="SELECT usulan.Kode_Mat,
			 usulan.KP,
			 usulan.Riil,
			 usulan.Kode_Dosen
		FROM usulan
	   WHERE usulan.Kode_Mat <> 'NULL'";

// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_MK!="all")
		{ $sql=$sql." and (usulan.Kode_Mat='".$frm_MK."')"; }
		
	if ($frm_KP!="all")
		{ $sql=$sql." and (usulan.KP='".$frm_KP."')"; }
		
    if ($frm_SKS_MK!="all")
		{ $sql=$sql." and (usulan.Riil=".$frm_SKS_MK.")"; }
		
	if ($frm_dosen!="all")
		{ $sql=$sql." and (usulan.Kode_Dosen='".$frm_dosen."')"; }
			
f_connecting();

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

$excel_export.="<b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b><br>
<b>LAPORAN USULAN DOSEN</b><br><br>";

	/*if ($frm_s_jurusan!="all")
	{ 
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id2='".$frm_s_jurusan."'";
		$result_jur = @mysql_query($sql_jur);
		$row_jur=@mysql_fetch_array($result_jur);
		$excel_export.="<b>".$row_jur["nama_jur"]."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
	} */

//$excel_export.="</b><br>";

$excel_export.="<b>Tgl. Cetak : ".date("d-m-Y")."</b><br><br>";
$excel_export.="<table border=1 width=100%>";
$excel_export.="<tr>
					<td nowrap><strong>KODE MK</strong></td>
					<td nowrap><strong>NAMA MK</strong></td>
					<td nowrap><strong>KP</strong></td>
					<td nowrap><strong>SKS Riil </strong></td>
					<td nowrap><strong>NPK Dosen </strong></td>
					<td nowrap><strong>NAMA DOSEN</strong></td>
				</tr>";
$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
	$excel_export.="<tr>
					  <td nowrap>".$row["Kode_Mat"]."</td>";
	
	$sql_MK="SELECT nama
			   FROM master_mk
			  WHERE kode_mk='".$row["Kode_Mat"]."'";
	$result_MK = @mysql_query($sql_MK);
	$row_MK=@mysql_fetch_array($result_MK);
	$excel_export.="<td nowrap>".$row_MK["nama"]."</td>
					<td nowrap>".$row["KP"]."</td>
		            <td nowrap>".$row["Riil"]."</td>
			        <td nowrap>".$row["Kode_Dosen"]."</td>";
					
	$sql_dosen_1="SELECT nama
				    FROM dosen
				   WHERE kode='".$row["Kode_Dosen"]."'";
	$result_dosen_1 = @mysql_query($sql_dosen_1);
	$row_dosen_1=@mysql_fetch_array($result_dosen_1);
	$excel_export.="<td nowrap>".$row_dosen_1["nama"]."</td>
			        </tr>";
}

$excel_export.="</table>";

if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=LAP_usul_dsn-".date("dmY").".xls");

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