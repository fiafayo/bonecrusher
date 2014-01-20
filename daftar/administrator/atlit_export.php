<?php
/* 
   DATE CREATED : 25/05/11
   KEGUNAAN     : EXPORT ATLIT 
   VARIABEL     : 
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

   $sql="SELECT `id_pelatih`, 
			    `no_induk_pelatih`, 
			    `nama`, 
			    `kelamin`, 
			    `tempat_lahir`, 
			     DATE_FORMAT(`tanggal_lahir`,'%d/%m/%Y') as tanggal_lahir,
			    `alamat`, 
			    `kota_pelatih`, 
			    `propinsi_pelatih`, 
			    `email`
		    FROM pelatih 
		   WHERE nama='".$_POST['frm_s_nama']."'";

// PROSES UNTUK SEARCH (MODE=2)
	/*
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
	*/
	/*
	
	if($frm_tgl_periode!="" && $frm_tgl_periode2!="")
	{ 
		$sql=$sql." and (`lulus_ta`.`tgl_lulus` between '".datetomysql($frm_tgl_periode)."' and '".datetomysql($frm_tgl_periode2)."')"; 
	}*/
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
	$excel_export.="<div align=\"center\"><b>GABSI</b></div>
					<div align=\"center\"><b>EXPORT DATA PELATIH</b></div>
					<br><br>";
}
else
{
	$excel_export.="<div align=\"center\"><b>GABSI</b></div>
					<div align=\"center\"><b>EXPORT DATA PELATIH</b></div>
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
					<td nowrap><strong>NIA</strong></td>
					<td nowrap><strong>Nama</strong></td>
					<td nowrap><strong>Kelamin</strong></td>
					<td nowrap><strong>Tempat Lahir</strong></td>
					<td nowrap><strong>Tanggal Lahir</strong></td>
					<td nowrap><strong>Alamat</strong></td>
					<td nowrap><strong>Kota</strong></td>
					<td nowrap><strong>Propinsi</strong></td>
					<td nowrap><strong>Email</strong></td>
				  </tr>";
$a=0;
while(($row_1 = mysql_fetch_array($result)))
{
	$a++;
	$sql_kota="SELECT * FROM kota WHERE id_kota='".$row_1["kota_pelatih"]."'";
	$result_kota = @mysql_query($sql_kota);
	$row_kota = @mysql_fetch_array($result_kota);
	
	$sql_kota_lahir="SELECT * FROM kota WHERE id_kota='".$row_1["tempat_lahir"]."'";
	$result_kota_lahir = @mysql_query($sql_kota_lahir);
	$row_kota_lahir = @mysql_fetch_array($result_kota_lahir);
   
    $sql_propinsi="SELECT * FROM propinsi WHERE id_propinsi='".$row_1["propinsi_pelatih"]."'";
    $result_propinsi = @mysql_query($sql_propinsi);
    $row_propinsi = @mysql_fetch_array($result_propinsi);
	
	/*
   $sql_ulur="SELECT NRP,
					 DATE_FORMAT(tgl_ulur,'%d/%m/%Y') as tgl_ulur
				 ROM perpanjang_ta
			   WHERE NRP='".$row_1["NRP"]."'";
   $result_ulur = @mysql_query($sql_ulur);
   $row_ulur=@mysql_fetch_array($result_ulur);*/

$excel_export.="<tr>
					<td>".$a."</td>
					<td nowrap>".$row_1["no_induk_pelatih"]."</td>
					<td nowrap>".$row_1["nama"]."</td>
					<td nowrap>".$row_1["kelamin"]."</td>
					<td nowrap>".$row_kota_lahir["nama"]."</td>
					<td nowrap>".$row_1["tanggal_lahir"]."</td>
					<td nowrap>".$row_1["alamat"]."</td>
					<td nowrap>".$row_kota["nama"]."</td>
					<td nowrap>".$row_propinsi["nama"]."</td>
					<td nowrap>".$row_1["email"]."</td>
				  </tr>";
}

$excel_export.="</table>";
//}

//echo "excel_export= ".$excel_export;
//exit();

if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=Export_atlit-".date("dmY").".xls");

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