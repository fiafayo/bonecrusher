<?
/* 
   DATE CREATED : 03/04/08
   LAST UPDATE  : 
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

$sql="SELECT dosen.kode,
		     dosen.nama,
			 dosen.jurusan
		FROM dosen
	   WHERE dosen.jurusan<>''";			


if ($frm_s_jurusan != "all")
	{ $sql.=" and dosen.jurusan='".$frm_s_jurusan."'";}	
	if ($frm_s_kode!="")
	{ $sql=$sql." and dosen.kode like '%".$frm_s_kode."%'"; } 
	if ($frm_s_nama!="")
	{ $sql=$sql." and dosen.nama like '%".$frm_s_nama."%'"; }  

f_connecting();
//if ($mode=="2") { $sql=$sql." limit ".$limit; }
if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

$excel_export.="<b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b><br><br>";
$excel_export.="<b>LAPORAN SCORE CARD DOSEN</b><br>";

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
					<td nowrap><b>Jurusan</b></td>
					<td nowrap><b>Dosen</b></td>
					<td nowrap><b>Pengajaran</b></td>
					<td nowrap><b>Penelitian</b></td>
					<td nowrap><b>Pengabdian</b></td>
				</tr>";

while(($row = mysql_fetch_array($result)))
{
		
		 		$sql_nama_jurusan="SELECT id
							       FROM jurusan
							       WHERE id='".$row["jurusan"]."'";
				$result_nama_jurusan = @mysql_query($sql_nama_jurusan);
				$row_nama_jurusan=@mysql_fetch_array($result_nama_jurusan);
				//echo $row_nama_jurusan["id"];
				switch ($row_nama_jurusan["id"]) {
					case 1:
						$nama_jurusan='TE';
						break;
					case 2:
						$nama_jurusan='TK';
						break;
					case 3:
						$nama_jurusan='TI';
						break;
					case 4:
						$nama_jurusan='IF';
						break;
					case 5:
						$nama_jurusan='TM';
						break;
					}
					//echo $nama_jurusan;
		
		$excel_export.="<tr>
							<td nowrap valign=top>".$nama_jurusan."</td>
							<td nowrap valign=top>".$row["kode"]."-".$row["nama"]."</td>";
		
		// #### BEGIN PENGAJARAN
		$sql_ajar="SELECT distinct
						  rekap_dosen.kode_MK,
						  rekap_dosen.nama_MK,
						  rekap_dosen.kp
					 FROM rekap_dosen
					WHERE rekap_dosen.kode_dsn='".$row["kode"]."'";
		$result_ajar=@mysql_query($sql_ajar);
		$excel_export.="<td nowrap valign=top>";
		while($row_ajar = mysql_fetch_array($result_ajar))
		{
			//echo $row_ajar["kode_MK"]."-".$row_ajar["nama_MK"]."(".$row_ajar["kp"].")<br>";
			$excel_export.=$row_ajar["kode_MK"]."-".$row_ajar["nama_MK"]."(".$row_ajar["kp"].")<br>";
		}
		$excel_export.="</td>";
		// #### END PENGAJARAN
		
	    // #### BEGIN PENELITIAN
		  $sql_penelitian="SELECT distinct
								  penelitian.kode_dosen,
								  penelitian.kode_pen,
								  penelitian.judul,
								  jenis_kerjasama.nama
							 FROM penelitian, jenis_kerjasama
							WHERE penelitian.publikasi=jenis_kerjasama.id and
								  penelitian.kode_dosen='".$row["kode"]."'";
		  $result_penelitian=@mysql_query($sql_penelitian);
		  $excel_export.="<td nowrap valign=top>";
		  while($row_penel = mysql_fetch_array($result_penelitian))
		  {
			 //echo $row_penel["kode_pen"]."-".$row_penel["judul"]." (<i>".$row_penel["nama"]."</i>)<br>";
			 $excel_export.=$row_penel["kode_pen"]."-".$row_penel["judul"]." (<i>".$row_penel["nama"]."</i>)<br>";
		  }
		  $excel_export.="</td>";				
		// #### END PENELITIAN
		
		// #### BEGIN PENGABDIAN
			$sql_pengabdian="SELECT distinct
									profil_kerjasama.kode,
									profil_kerjasama.judul,
									jenis_kerjasama.nama
							   FROM profil_kerjasama,jenis_kerjasama
							  WHERE profil_kerjasama.id_jenis=jenis_kerjasama.id and
									profil_kerjasama.kode_dosen='".$row["kode"]."'";
			$result_pengabdian=@mysql_query($sql_pengabdian);
			$excel_export.="<td nowrap valign=top>";
			while($row_pengabdian = mysql_fetch_array($result_pengabdian))
			{
				//echo $row_pengabdian["kode"]."-".$row_pengabdian["judul"]." (<i>".$row_pengabdian["nama"]."</i>)<br>";
				$excel_export.=$row_pengabdian["kode"]."-".$row_pengabdian["judul"]." (<i>".$row_pengabdian["nama"]."</i>)<br>";
			}
			$excel_export.="</td>";
		// #### END PENGABDIAN
						
		$excel_export.="</tr>";
}
	$excel_export.="</table>";


if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=score_card_dosen-".date("dmY").".xls");

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
