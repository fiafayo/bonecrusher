<?php
/* 
   DATE CREATED : 08/01/08
   KEGUNAAN     : EXPORT LAPORAN FASILITAS RUANG
   VARIABEL     : 
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

$sql="SELECT master_ruang.id,
			 master_ruang.kode,
			 master_ruang.nama,
			 master_ruang.tipe,
			 master_ruang.kapasitas,
			 master_ruang.luas, 
			 master_ruang.LCD,
			 master_ruang.komputer,
			 master_ruang.mic,
			 master_ruang.speaker
	    FROM master_ruang
	   WHERE master_ruang.kode <> 'NULL'";

// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_ruang!="all")
		{ $sql=$sql." and (master_ruang.kode='".$frm_ruang."')"; }
		
	if ($frm_kapasitas!="")
		{ $sql=$sql." and (master_ruang.kapasitas <= ".$frm_kapasitas.")"; }
	
	if ($frm_LCD!="all")
		{ $sql=$sql." and (master_ruang.LCD='".$frm_LCD."')"; }
	
	if ($frm_kom!="all")
		{ $sql=$sql." and (master_ruang.komputer='".$frm_kom."')"; }
		
	if ($frm_mic!="all")
		{ $sql=$sql." and (master_ruang.mic='".$frm_mic."')"; }
		
	if ($frm_speaker!="all")
		{ $sql=$sql." and (master_ruang.speaker='".$frm_speaker."')"; }
			
f_connecting();

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

$excel_export.="<b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b><br>
<b>LAPORAN FASILITAS RUANG</b><br><br>";

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
					<td nowrap><strong>KODE RUANG</strong></td>
					<td nowrap><strong>NAMA RUANG</strong></td>
					<td nowrap><strong>KAPASITAS</strong></td>
					<td nowrap><strong>LUAS</strong></td>
					<td nowrap><strong>LCD</strong></td>
					<td nowrap><strong>KOMPUTER</strong></td>
					<td nowrap><strong>MICROPHONE</strong></td>
					<td nowrap><strong>SPEAKER</strong></td>
				</tr>";
$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
	$excel_export.="<tr>
						<td nowrap>".$row["kode"]."</td>
						<td nowrap>".$row["nama"]."</td>
						<td nowrap>".$row["kapasitas"]."</td>
						<td nowrap>".$row["luas"]."</td>
						<td nowrap>".$row["LCD"]."</td>
						<td nowrap>".$row["komputer"]."</td>
						<td nowrap>".$row["mic"]."</td>
						<td nowrap>".$row["speaker"]."</td>
			        </tr>";
}

$excel_export.="</table>";

if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=LAP_fasil_ruang-".date("dmY").".xls");

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