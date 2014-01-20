<?php
/* 
   DATE CREATED : 01/11/07
   KEGUNAAN     : EXPORT LAPORAN DAFTAR DOSEN PEMBIMBING LUAR YANG AKTIF
   VARIABEL     : 

   KETERANGAN   : PROSES CEK AUTHENTIFIKASI DICOMMENT UNTUK COBA JALANKAN
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

$sql_1="insert into temp_luar (SELECT master_ta.KODOS1, '".session_id()."'
                          		 FROM master_ta, dosen, jurusan
                           		WHERE (master_ta.KODOS1 = dosen.kode) AND
									  (dosen.jurusan = jurusan.id) AND
									  (master_ta.KOLUS='' AND master_ta.STATUS='') AND
									  (master_ta.KODOS1 not like '61%')";					  
								  
$sql_2="insert into temp_luar (SELECT master_ta.KODOS2, '".session_id()."'
                          		 FROM master_ta, dosen, jurusan
                           		WHERE (master_ta.KODOS2 = dosen.kode) AND
									  (dosen.jurusan = jurusan.id) AND
									  (master_ta.KOLUS='' AND master_ta.STATUS='') AND
									  (master_ta.KODOS2 not like '61%')";			 
			 
$sql_dosen="SELECT distinct kode_dosen_temp,
                   id_temp
		    FROM temp_luar";

// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_s_jurusan!="pilih")
	{   
	    $sql_1 .= " AND (jurusan.id='".$frm_s_jurusan."')";
		$sql_2 .= " AND (jurusan.id='".$frm_s_jurusan."')";
	}
	
	if($frm_tgl_periode!="" && $frm_tgl_periode2!="")
	{ 
		$sql_1=$sql_1." and (master_ta.AKHIR1 between '".datetomysql($frm_tgl_periode)."' and '".datetomysql($frm_tgl_periode2)."')"; 
		$sql_2=$sql_2." and (master_ta.AKHIR1 between '".datetomysql($frm_tgl_periode)."' and '".datetomysql($frm_tgl_periode2)."')";
	}
	else
	{
		if($frm_tgl_periode!="")
		{ 
			$sql_1=$sql_1." and (master_ta.AKHIR1>='".datetomysql($frm_tgl_periode)."')"; 
			$sql_2=$sql_2." and (master_ta.AKHIR1>='".datetomysql($frm_tgl_periode)."')"; 
		}
		if($frm_tgl_periode2!="")
		{ 
			$sql_1=$sql_1." and (master_ta.AKHIR1<='".datetomysql($frm_tgl_periode2)."')"; 
			$sql_2=$sql_2." and (master_ta.AKHIR1<='".datetomysql($frm_tgl_periode2)."')"; 
		}
	}
	
	$sql_1=$sql_1." group by master_ta.KODOS1)";
	$sql_2=$sql_2." group by master_ta.KODOS2)";
		//echo "<br>here3";
		//echo "<br>sql_1=".$sql_1;
		
		//exit();

	
f_connecting();
mysql_select_db($DB);

$result=@mysql_query($sql_dosen);
$result_1=@mysql_query($sql_1);
$result_2=@mysql_query($sql_2);

if(!($result=mysql_db_query($DB,$sql_dosen)))
{
	echo mysql_error();
        return 0;
}


/*

echo "<br>frm_s_jurusan=".$frm_s_jurusan;
echo "<br>frm_tgl_periode=".datetomysql($frm_tgl_periode);
echo "<br>frm_tgl_periode2=".datetomysql($frm_tgl_periode2);
exit();
	
f_connecting();

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}*/
/*$excel_export.="
<table>
<tr><td colspan=5>
<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
  <tr>
    <td align=\"center\" nowrap><b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b></td>
  </tr>
  <tr>
    <td align=\"center\" nowrap><b>LAPORAN DAFTAR DOSEN PEMBIMBING LUAR YANG AKTIF</b></td>
  </tr>
  <tr>
    <td><b>Periode: ".$frm_tgl_periode." - ".$frm_tgl_periode2."</b></td>
  </tr>
</table>
</td>
</tr>
</table>
<br><br>";*/


$excel_export.="
    <div align=\"center\"><b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b></div>
    <div align=\"center\"><b>LAPORAN DAFTAR DOSEN PEMBIMBING LUAR YANG AKTIF</b></div>
    <div align=\"center\"><b>Periode: ".$frm_tgl_periode." - ".$frm_tgl_periode2."</b></div>
<br><br>";
if ($frm_s_jurusan!="all")
	{
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id='".$frm_s_jurusan."'";
		$result_jur = @mysql_query($sql_jur);
		$row_jur=@mysql_fetch_array($result_jur);
		//echo "<b>Jurusan: </b>".$row_jur["nama_jur"];
	}
$excel_export.="<b>Jurusan: </b>".$row_jur["nama_jur"];
//$excel_export.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//$excel_export.="<b>Tgl. Cetak : ".date("d-m-Y")."</b><br><br>";

$excel_export.="<table border=1 cellpadding=0 cellspacing=0>
				<tr>
					<td>
						<table border=1 cellspacing=2 cellpadding=0>
						  <tr>
								<td><strong>Kode</strong></td>
								<td><strong>Nama</strong></td>
								<td nowrap><strong>Jabatan Akademik</strong></td>
								<td><strong>Jumlah</strong></td>
								<td nowrap><strong>TglAkhir</strong></td>
								<td nowrap><strong>NRP</strong></td>
								<td nowrap><strong>Nama</strong></td>
						  </tr>";
$a=0;
while(($row_1 = mysql_fetch_array($result)))
{
	$a++;
	$excel_export.="<tr valign=top>
					<td width=16% align=left nowrap>".$row_1["kode_dosen_temp"]."</td>
					<td nowrap>";
					$sql_dosen_1="SELECT nama,jab_akademik,jurusan.jurusan as nama_jur
										   		 FROM dosen, jurusan
									            WHERE kode='".$row_1["kode_dosen_temp"]."' AND  dosen.jurusan = jurusan.id ";
					$result_dosen_1 = @mysql_query($sql_dosen_1);
					$row_dosen_1=@mysql_fetch_array($result_dosen_1);
					//echo $row_dosen_1["nama"];
	$excel_export.=$row_dosen_1["nama"];
    $excel_export.="</td>
					<td>".$row_dosen_1["jab_akademik"]."</td>
					<td width=5% align=center>";

					   $sql_total_bim_1="SELECT master_ta.NRP,
											    master_ta.KODOS1,
											    master_ta.KODOS2,
											    master_ta.AKHIR1,
											    master_mhs.NAMA
									     FROM   master_ta, master_mhs
									     WHERE (master_ta.NRP=master_mhs.NRP) AND 
										       (KODOS1='".$row_1["kode_dosen_temp"]."' OR KODOS2='".$row_1["kode_dosen_temp"]."') AND 
											   (master_ta.KOLUS=''AND master_ta.STATUS='')";
					if($frm_tgl_periode!="" && $frm_tgl_periode2!="")
					{ 
						$sql_total_bim_1=$sql_total_bim_1." and (master_ta.AKHIR1 between '".datetomysql($frm_tgl_periode)."' and '".datetomysql($frm_tgl_periode2)."')"; 
					}
///						   WHERE (master_ta.NRP=master_mhs.NRP) AND (KODOS1='".$row["KODOS1"]."' OR KODOS2='".$row["KODOS1"]."') AND KOLUS=''";

							$result7_1 = @mysql_query($sql_total_bim_1);
							$maxrows2_1 = mysql_num_rows($result7_1);	
							//echo $maxrows2_1;
	$excel_export.=$maxrows2_1;
							//$c=0;
							//while ($row=@mysql_fetch_object($result))
					   //}
						//}
	$excel_export.="</td>
					<td colspan=3 height=50>
						<table width=100% border=0 cellpadding=0 cellspacing=0>";
							while ($row_mhs_1=@mysql_fetch_array($result7_1))
							{
	$excel_export.="<tr>
					<td nowrap valign=top>";
									$tgl_akhir_bimbingan = $row_mhs_1["AKHIR1"];
									$tgl_akhir_bimbingan = datetoreport($tgl_akhir_bimbingan);
									//echo $tgl_akhir_bimbingan;
	$excel_export.=$tgl_akhir_bimbingan;
	$excel_export.="</td>
						<td nowrap valign=top>".$row_mhs_1["NRP"]."</td>		
								<td nowrap valign=top>".$row_mhs_1["NAMA"]."</td>	
							</tr>";
							} 
	$excel_export.="  </table>
					</td>
				  </tr>";
			}
			// NEXT ROW
			//echo "SESSION2=".session_id();
	//$result_empty_temp = mysql_query("delete from temp_dalam where id_temp='".session_id()."'");
    $excel_export.="</td>
				  </tr>
				  </table>";
//}

//echo "excel_export= ".$excel_export;

//exit();

if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=LAP_dobing_luar_periode-".date("dmY").".xls");

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