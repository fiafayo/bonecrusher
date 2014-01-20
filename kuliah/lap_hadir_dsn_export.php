<?php
/* 
   DATE CREATED : 04/01/08
   KEGUNAAN     : EXPORT LAPORAN KEHADIRAN DOSEN
   VARIABEL     : 
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();

$sql="SELECT DATE_FORMAT(absensi.Tgl,'%d/%m/%Y') as Tgl,
			 absensi.Kode_Dosen,
			 absensi.Kode_Mat,
			 absensi.Kp,
			 absensi.Sks,
			 absensi.Keterangan
	    FROM absensi
	   WHERE (absensi.Keterangan <> '' OR absensi.Kode_Dosen<> '' OR absensi.Kode_Dosen <> '0')";

// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_tgl!="" || $frm_tgl2!="")
	{  
		if($frm_tgl!="" && $frm_tgl2!="")
		{ $sql=$sql." and absensi.Tgl between '".datetomysql($frm_tgl)."' and '".datetomysql($frm_tgl2)."'"; }
		else
		{
			if($frm_tgl!="")
			{ $sql=$sql." and absensi.Tgl>='".datetomysql($frm_tgl)."'"; }
			if($frm_tgl2!="")
			{ $sql=$sql." and absensi.Tgl<='".datetomysql($frm_tgl2)."'"; }
		}
	}
	
	if ($frm_dosen!="all")
		{ $sql=$sql." and (absensi.Kode_Dosen='".$frm_dosen."')"; }
		
	if ($frm_MK!="all")
		{ $sql=$sql." and (absensi.Kode_Mat='".$frm_MK."')"; }
		
	if ($frm_status!="all")
		{ $sql=$sql." and (absensi.Keterangan='".$frm_status."')"; }
			


if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

$excel_export.="<b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b><br>
<b>LAPORAN KEHADIRAN DOSEN</b><br><br>";

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
					<td nowrap><strong>TANGGAL</strong></td>
					<td nowrap><strong>NPK DOSEN</strong></td>
					<td nowrap><strong>NAMA DOSEN</strong></td>
					<td nowrap><strong>KODE MK</strong></td>
					<td nowrap><strong>NAMA MK</strong></td>
					<td nowrap><strong>KP</strong></td>
					<td nowrap><strong>SKS</strong></td>
					<td nowrap><strong>KETERANGAN</strong></td>
				</tr>";
$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
	$excel_export.="<tr>
					  <td nowrap>".$row["Tgl"]."</td>
					  <td nowrap>".$row["Kode_Dosen"]."</td>";
	$sql_dosen_1="SELECT nama
					FROM dosen
					WHERE kode='".$row["Kode_Dosen"]."'";
	$result_dosen_1 = @mysql_query($sql_dosen_1);
	$row_dosen_1=@mysql_fetch_array($result_dosen_1);
	
	$excel_export.="<td nowrap>".$row_dosen_1["nama"]."</td>
					<td nowrap>".$row["Kode_Mat"]."</td>";
					
	$sql_MK="SELECT nama
			   FROM master_mk
			  WHERE kode_mk='".$row["Kode_Mat"]."'";
	$result_MK = @mysql_query($sql_MK);
	$row_MK=@mysql_fetch_array($result_MK);
	$excel_export.="<td nowrap>".$row_MK["nama"]."</td>
					<td nowrap>".$row["Kp"]."</td>
		            <td nowrap>".$row["Sks"]."</td>
			        <td nowrap>".$row["Keterangan"]."</td>
			  </tr>";
}

$excel_export.="</table>";

if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=LAP_hadir_dsn-".date("dmY").".xls");

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