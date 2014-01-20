<?php
/* 
   DATE CREATED : 30/11/07
   UPDATE       : 04/02/09 - penambahan jumlah mhs kp (total 6)
                  17/06/09 - penambahan jumlah mhs kp (total 8)
   KEGUNAAN     : EXPORT LAPORAN MAHASISWA SELESAI KP
   VARIABEL     : 

   KETERANGAN   : PROSES CEK AUTHENTIFIKASI DICOMMENT UNTUK COBA JALANKAN
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
$sekarang=date("Y-m-d");  
$sql="SELECT  `daftar_kp`.`NO_MOHON`,
			  `daftar_kp`.`UR_MOHON`,
			  `daftar_kp`.`KODE_KP`,
			  `daftar_kp`.`NRP_1`,
			  `daftar_kp`.`NRP_2`,
			  `daftar_kp`.`NRP_3`,
			  `daftar_kp`.`NRP_4`,
			  `daftar_kp`.`NRP_5`,
			  `daftar_kp`.`NRP_6`,
			  `daftar_kp`.`NRP_7`,
			  `daftar_kp`.`NRP_8`,
			  `daftar_kp`.`NA_PERUSH`,
			  `daftar_kp`.`JALAN`,
			  `daftar_kp`.`KOTA`,
			   DATE_FORMAT(`daftar_kp`.`TGL_AWAL`,'%d/%m/%Y') as TGL_AWAL,
			   DATE_FORMAT(`daftar_kp`.`TGL_END`,'%d/%m/%Y') as TGL_END,
			   DATE_FORMAT(`daftar_kp`.`TGL_MOHON`,'%d/%m/%Y') as TGL_MOHON,
			  `daftar_kp`.`NO_ST`,
			  `daftar_kp`.`UR_ST`,
			  `daftar_kp`.`DOSEN`,
			  `daftar_kp`.`PEM_PERUS`,
			   DATE_FORMAT(`daftar_kp`.`TGL_ST`,'%d/%m/%Y') as TGL_ST,
			  `daftar_kp`.`NO_NKP`,
			  `daftar_kp`.`UR_NKP`,
			  `daftar_kp`.`TGL_NKP`,
			  `daftar_kp`.`HONOR`,
			  `daftar_kp`.`STATUS`
		FROM  daftar_kp 
		WHERE `daftar_kp`.`NO_MOHON` LIKE '".$frm_no_SP_KP."%'";

// PROSES UNTUK SEARCH (MODE=2)
	//if ($frm_s_jurusan!="all")
	//{ $sql .= " and master_mhs.jurusan='".$frm_s_jurusan."'";}
	
	//echo "<br>JURUSAN=".$frm_s_jurusan;
	/*switch ($frm_s_jurusan) {
			case '1':
				$jur_kode='TE';
				$jur_kode2='61';
				break;
			case '2':
				$jur_kode='TK';
				$jur_kode2='62';
				break;
			case '3':
				$jur_kode='TI';
				$jur_kode2='63';
				break;
			case '4':
				$jur_kode='IF';
				$jur_kode2='64';
				break;
			case '5':
				$jur_kode='TM';
				$jur_kode2='65';
				break;
		}
	if ($frm_s_jurusan!="all")
	{ $sql=$sql." and (`daftar_kp`.`KODE_KP` like '".$jur_kode."%' or `daftar_kp`.`KODE_KP` like '".$jur_kode2."%')"; }*/
	/*if($frm_tgl_periode!="")
	{ $sql=$sql." and lulus_ta.tgl_lulus<='".datetomysql($frm_tgl_periode)."'"; }*/
	
	/*if($frm_tgl_periode!="" && $frm_tgl_periode2!="")
	{ 
		$sql=$sql." and (`lulus_ta`.`tgl_lulus` between '".datetomysql($frm_tgl_periode)."' and '".datetomysql($frm_tgl_periode2)."')"; 
	}
	else
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
		//echo "<br>frm_kode_dobing=".$frm_kode_dobing;
		//echo "<br>here";
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

$excel_export.="<div align=\"left\"><b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b></div>
				<div align=\"left\"><b>LAPORAN DAFTAR MAHASISWA KP</b></div>
				<br><br>";
				
/*if ($frm_s_jurusan!="all")
	{
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id='".$frm_s_jurusan."'";
		$result_jur = @mysql_query($sql_jur);
		$row_jur=@mysql_fetch_array($result_jur);
		//echo "<b>Jurusan: </b>".$row_jur["nama_jur"];$frm_s_jurusan$row_jur["nama_jur"]
		$excel_export.="<b>Jurusan: </b>".$row_jur["nama_jur"];
	}
	else 
	{
		$excel_export.="<b>Jurusan: Semua</b>";
	}*/

//$excel_export.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$excel_export.="<b>Tgl. Cetak : ".date("d-m-Y")."</b><br><br>";

$excel_export.="<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
					<td><strong>No.</strong></td>
					<td nowrap><strong>Kode KP</strong></td>
					<td nowrap><strong>Jurusan</strong></td>
					<td nowrap><strong>No. Surat Permohonan KP</strong></td>
					<td nowrap><strong>Tgl Surat Permohonan KP</strong></td>
					<td nowrap><strong>Mahasiswa</strong></td>
					<td nowrap><strong>Kerja Praktek di</strong></td>
					<td nowrap><strong>Jalan</strong></td>
					<td nowrap><strong>Kota</strong></td>
					<td nowrap><strong>Dosen Pembimbing</strong></td>
					<td nowrap><strong>Pembimbing Perusahaan</strong></td>
					<td nowrap><strong>Tgl Mulai KP</strong></td>
					<td nowrap><strong>Tgl Selesai KP</strong></td>
					<td nowrap><strong>Tgl Surat Tugas KP</strong></td>
					<td nowrap><strong>No. Surat Tugas KP</strong></td>
				  </tr>";
$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
	if ($row["DOSEN"]<>"") 
	{
		$result_dsn = mysql_query("Select NAMA from dosen where kode='".$row["DOSEN"]."'");
		$row_dsn= mysql_fetch_array($result_dsn);
		$var_nama_dsn = $row_dsn["NAMA"];
		//echo $row["DOSEN"]."-".$var_nama_dsn;
	}
		
	$kodeKP=substr($row["KODE_KP"],0,2);
	switch ($kodeKP)
	{
		case 'TE':
			$jur_nama="Teknik Elektro";
			break;
		case 'TK':
			$jur_nama="Teknik Kimia";
			break;
		case 'TI':
			$jur_nama="Teknik Industri";
			break;
		case 'IF':
			$jur_nama="Teknik Informatika";
			break;
		case 'TM':
			$jur_nama="Teknik Manufaktur";
			break;
		case '61':
			$jur_nama="Teknik Elektro";
			break;
		case '62':
			$jur_nama="Teknik Kimia";
			break;
		case '63':
			$jur_nama="Teknik Industri";
			break;
		case '64':
			$jur_nama="Teknik Informatika";
			break;
		case '65':
			$jur_nama="Teknik Manufaktur";
			break;
		case '66':
			$jur_nama="Desain Manajemen Produk";
			break;
		case '67':
			$jur_nama="Sistem Informasi";
			break;
		case '68':
			$jur_nama="Multimedia";
			break;	
		case '69':
			$jur_nama="Dual Degree";
			break;	
	}
	
/*if ($frm_NRP<>"")
{
	$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$frm_NRP."'");
	$row_mhs= mysql_fetch_array($result_mhs);
	$var_nama_mhs = $row_mhs["NAMA"];
	//echo $frm_NRP."-".$var_nama_mhs;
}
else
{
	if ($row["NRP_1"]!='')
		{
			$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_1"]."'");
			$row_mhs= mysql_fetch_array($result_mhs);
			$var_nama_mhs1 = $row_mhs["NAMA"];
			//echo $row["NRP_1"]."-".$var_nama_mhs."<br>";
		}	
		
	if ($row["NRP_2"]!='')
		{
			$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_2"]."'");
			$row_mhs= mysql_fetch_array($result_mhs);
			$var_nama_mhs2 = $row_mhs["NAMA"];
			//echo $row["NRP_2"]."-".$var_nama_mhs."<br>";
		}	
		
	if ($row["NRP_3"]!='')
		{
			$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_3"]."'");
			$row_mhs= mysql_fetch_array($result_mhs);
			$var_nama_mhs3 = $row_mhs["NAMA"];
			//echo $row["NRP_3"]."-".$var_nama_mhs."<br>";
		}	
	
	if ($row["NRP_4"]!='')
		{
			$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_4"]."'");
			$row_mhs= mysql_fetch_array($result_mhs);
			$var_nama_mhs4 = $row_mhs["NAMA"];
			//echo $row["NRP_4"]."-".$var_nama_mhs."<br>";
		}
		
	if (($row["NRP_5"]<>'')or ($row["NRP_5"])<>NULL)
		{
			$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_5"]."'");
			$row_mhs= mysql_fetch_array($result_mhs);
			$var_nama_mhs5 = $row_mhs["NAMA"];
			//echo $row["NRP_5"]."-".$var_nama_mhs."<br>";
		}*/
//}		
$excel_export.="<tr>
					<td valign=top>".$a."</td>
					<td nowrap valign=top>".$row["KODE_KP"]."</td>
					<td nowrap valign=top>".$jur_nama."</td>
					<td nowrap valign=top>".$row["NO_MOHON"]."</td>
					<td nowrap valign=top>".$row["TGL_MOHON"]."</td>
					<td nowrap valign=top>";
					if ($row["NRP_1"]!='')
					{
						$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_1"]."'");
						$row_mhs= mysql_fetch_array($result_mhs);
						$var_nama_mhs = $row_mhs["NAMA"];
						$excel_export.=$row["NRP_1"]."-".$var_nama_mhs."<br>";
						//echo $row["NRP_1"]."-".$var_nama_mhs."<br>";
					}	
					
					if ($row["NRP_2"]!='')
					{
						$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_2"]."'");
						$row_mhs= mysql_fetch_array($result_mhs);
						$var_nama_mhs = $row_mhs["NAMA"];
						$excel_export.=$row["NRP_2"]."-".$var_nama_mhs."<br>";
						//echo $row["NRP_2"]."-".$var_nama_mhs."<br>";
					}	
					
					if ($row["NRP_3"]!='')
					{
						$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_3"]."'");
						$row_mhs= mysql_fetch_array($result_mhs);
						$var_nama_mhs = $row_mhs["NAMA"];
						$excel_export.=$row["NRP_3"]."-".$var_nama_mhs."<br>";
						//echo $row["NRP_3"]."-".$var_nama_mhs."<br>";
					}	
					
					if ($row["NRP_4"]!='')
					{
						$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_4"]."'");
						$row_mhs= mysql_fetch_array($result_mhs);
						$var_nama_mhs = $row_mhs["NAMA"];
						$excel_export.=$row["NRP_4"]."-".$var_nama_mhs."<br>";
						//echo $row["NRP_4"]."-".$var_nama_mhs."<br>";
					}
						
					if (($row["NRP_5"]<>'')or ($row["NRP_5"])<>NULL)
					{
						$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_5"]."'");
						$row_mhs= mysql_fetch_array($result_mhs);
						$var_nama_mhs = $row_mhs["NAMA"];
						$excel_export.=$row["NRP_5"]."-".$var_nama_mhs."<br>";
						//echo $row["NRP_5"]."-".$var_nama_mhs."<br>";
					}

					if (($row["NRP_6"]<>'')or ($row["NRP_6"])<>NULL)
					{
						$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_6"]."'");
						$row_mhs= mysql_fetch_array($result_mhs);
						$var_nama_mhs = $row_mhs["NAMA"];
						$excel_export.=$row["NRP_6"]."-".$var_nama_mhs."<br>";
						//echo $row["NRP_6"]."-".$var_nama_mhs."<br>";
					}

					if (($row["NRP_7"]<>'')or ($row["NRP_7"])<>NULL)
					{
						$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_7"]."'");
						$row_mhs= mysql_fetch_array($result_mhs);
						$var_nama_mhs = $row_mhs["NAMA"];
						$excel_export.=$row["NRP_7"]."-".$var_nama_mhs."<br>";
						//echo $row["NRP_7"]."-".$var_nama_mhs."<br>";
					}

					if (($row["NRP_8"]<>'')or ($row["NRP_8"])<>NULL)
					{
						$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_8"]."'");
						$row_mhs= mysql_fetch_array($result_mhs);
						$var_nama_mhs = $row_mhs["NAMA"];
						$excel_export.=$row["NRP_8"]."-".$var_nama_mhs."<br>";
						//echo $row["NRP_8"]."-".$var_nama_mhs."<br>";
					}

  $excel_export.="</td>
					<td nowrap valign=top>".$row["NA_PERUSH"]."</td>
					<td nowrap valign=top>".$row["JALAN"]."</td>
					<td nowrap valign=top>".$row["KOTA"]."</td>
					<td nowrap valign=top>".$row["DOSEN"]."-".$var_nama_dsn."</td>
					<td nowrap valign=top>".$row["PEM_PERUS"]."</td>
					<td nowrap valign=top>".$row["TGL_AWAL"]."</td>
					<td nowrap valign=top>".$row["TGL_END"]."</td>
					<td nowrap valign=top>".$row["TGL_ST"]."</td>
					<td nowrap valign=top>".$row["NO_ST"]."</td>
				  </tr>";

}

$excel_export.="</table>";
//}

 //excel_export= ".$excel_export;
//exit();

if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=LAP_mhs_cari_SP_KP-".date("dmY").".xls");

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