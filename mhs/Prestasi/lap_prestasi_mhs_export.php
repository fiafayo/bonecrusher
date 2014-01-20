<?php
/* 
   DATE CREATED : 06/05/08
   KEGUNAAN     : MENAMPILKAN LAPORAN PRESTASI MAHASISWA
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

$sql="SELECT prestasi.id,
			 prestasi.nrp,
			 prestasi.kegiatan,
			 DATE_FORMAT(prestasi.tgl_kegiatan,\"%d/%m/%Y\") as tgl_kegiatan,
			 prestasi.tempat,
			 prestasi.hasil,
			 prestasi.jurusan,
			 prestasi.tingkat,
			 master_mhs.NAMA
        FROM prestasi,master_mhs
	   WHERE prestasi.nrp=master_mhs.NRP ";

// PROSES UNTUK SEARCH (MODE=2)
	if($frm_tgl_periode!="" && $frm_tgl_periode2!="")
	{ 
		$sql=$sql." and (prestasi.tgl_kegiatan between '".datetomysql($frm_tgl_periode)."' and '".datetomysql($frm_tgl_periode2)."')"; 
	}
	else
	{
		if($frm_tgl_periode!="")
		{ 
			$sql=$sql." and (restasi.tgl_kegiatan >='".datetomysql($frm_tgl_periode)."')"; 
		}
		if($frm_tgl_periode2!="")
		{ 
			$sql=$sql." and (restasi.tgl_kegiatan <='".datetomysql($frm_tgl_periode2)."')"; 
		}
	}
	
	
	if ($frm_s_NRP!="")
	{ 	 $sql .= " and (prestasi.nrp='".$frm_s_NRP."')";}
	
	if ($frm_s_jurusan!="all")
	{    $sql .= " and (prestasi.jurusan='".$frm_s_jurusan."')";}
	
	if ($frm_s_nama!="")
    {  	 $sql .= " and (master_mhs.NAMA LIKE '%".$frm_s_nama."%')"; }
	
	
f_connecting();

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

$excel_export.="<b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b><br>
<b>LAPORAN DAFTAR PRESTASI MAHASISWA</b><br><br>";

	if ($frm_s_jurusan!="all")
	{ 
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id='".$frm_s_jurusan."'";
		$result_jur = @mysql_query($sql_jur);
		$row_jur=@mysql_fetch_array($result_jur);
		$excel_export.="<b>".$row_jur["nama_jur"]."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
	}

//$excel_export.="</b><br>";

$excel_export.="<b>Tgl. Cetak : ".date("d-m-Y")."</b><br><br>";
$excel_export.="<table border=1 width=100%>";
$excel_export.="<tr>
					<th nowrap><b>NRP</b></th>
					<th nowrap><b>NAMA</b></th>
					<th nowrap><b>KEGIATAN</b></th>
					<th nowrap><b>TANGGAL</b></th>
					<th nowrap><b>TEMPAT</b></th>
					<th nowrap><b>TINGKAT</b></th>
					<th nowrap><b>PRESTASI</b></th>
			    </tr>";
//$a=0;
while(($row = mysql_fetch_array($result)))
{
	//$a++;
	
		$excel_export.="<tr>
							<td nowrap>".$row["nrp"]."</td>
							<td nowrap>".$row["NAMA"]."</td>
							<td nowrap>".$row["kegiatan"]."</td>
							<td nowrap>".$row["tgl_kegiatan"]."</td>
							<td nowrap>".$row["tempat"]."</td>";
							
		$sql_tingkat="SELECT * FROM status_publikasi WHERE status_publikasi.id_pub=".$row['tingkat'];
		$result_tingkat = @mysql_query($sql_tingkat);
		$row_tingkat=@mysql_fetch_array($result_tingkat);
		//echo $row_tingkat["nama"];

		$excel_export.="<td nowrap>".$row_tingkat["nama"]."</td>
					    <td nowrap>".$row["hasil"]."</td>
					    </tr>";
}

$excel_export.="</table>";

if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=LAP_prestasi_mhs-".date("dmY").".xls");

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