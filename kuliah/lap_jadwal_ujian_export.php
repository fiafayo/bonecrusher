<?php
/* 
   DATE CREATED : 04/01/08
   KEGUNAAN     : EXPORT LAPORAN JADWAL UJIAN
   VARIABEL     : 
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

$sql="SELECT	mksem.KODEMK,
				mksem.KP,
				mksem.RUANG_K,
				mksem.HARI_K,
				mksem.JAM_KM,
				mksem.JAM_KS,
				mksem.RUANG_K2,
				mksem.HARI_K2,
				mksem.JAM_KM2,
				mksem.JAM_KS2,
				mksem.RUANG_U,
				mksem.HARI_U,
				mksem.JAM_UM,
				mksem.JAM_US,
				mksem.KAPASITAS,
				mksem.ISI,
				mksem.CAD
		   FROM mksem
		  WHERE mksem.KODEMK <> 'NULL' ";

// PROSES UNTUK SEARCH (MODE=2)
if ($frm_ruang_ujian!="all")
		{ $sql=$sql." and (`mksem`.`RUANG_U`='".$frm_ruang_ujian."')"; }
		
	if ($frm_minggu!="all")
		{ 
			if ($frm_minggu=="1")
			{
				$sql=$sql." and ((`mksem`.`HARI_U` > 0) and (`mksem`.`HARI_U` <= 7))"; 
				//echo "<br>1. ";
				//exit();
			}
			if ($frm_minggu=="2")
			{
				$sql=$sql." and ((`mksem`.`HARI_U`>7) and (`mksem`.`HARI_U`<=14))"; 
				//echo "<br>2. ";
				//exit();
			}
			if ($frm_minggu=="3")
			{
				$sql=$sql." and ((`mksem`.`HARI_U`>14) and (`mksem`.`HARI_U`<=21))"; 
				//echo "<br>3. ";
				//exit();
			}
		}
		
	if ($frm_hari_ujian!="all")
		{ $sql=$sql." and (`mksem`.`HARI_U`=".$frm_hari_ujian.")"; }
		
    if ($frm_jam_UM!="all")
		{ $sql=$sql." and (`mksem`.`JAM_UM`='".$frm_jam_UM."')"; }
		
	if ($frm_jam_US!="all")
		{ $sql=$sql." and (`mksem`.`JAM_US`='".$frm_jam_US."')"; }
	
f_connecting();

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

$excel_export.="<b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b><br>
<b>LAPORAN JADWAL UJIAN</b><br><br>";

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
					<td nowrap><strong>RUANG UJIAN</strong></td>
					<td nowrap><strong>MINGGU KE-</strong></td>
					<td nowrap><strong>HARI UJIAN</strong></td>
					<td nowrap><strong>JAM UJIAN MASUK</strong></td>
					<td nowrap><strong>JAM UJIAN SELESAI</strong></td>
				</tr>";
$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
	$excel_export.="<tr>
					  <td nowrap>".$row["KODEMK"]."</td>
					  <td nowrap>".$row["RUANG_U"]."</td>";
						if (($row["HARI_U"]>0)&&($row["HARI_U"]<=7))
						{ $excel_export.="<td nowrap>1</td>";}
						else if (($row["HARI_U"]>7) && ($row["HARI_U"]<=14))
						{ $excel_export.="<td nowrap>2</td>";} 
						else if (($row["HARI_U"]>14) && ($row["HARI_U"]<=21))
						{ $excel_export.="<td nowrap>3</td>";} 
		
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
			 $excel_export.="<td nowrap>".$nama_hari."</td>";
			 $excel_export.="<td nowrap>".$row["JAM_UM"]."</td>
							 <td nowrap>".$row["JAM_US"]."</td>
			  </tr>";
}

$excel_export.="</table>";

if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=LAP_jadwal_ujian-".date("dmY").".xls");

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