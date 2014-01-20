<?php
/* 
   DATE CREATED : 02/06/09
   KEGUNAAN     : EXPORT SCARD JURUSAN 1
   VARIABEL     : 

   KETERANGAN   :
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
mysql_select_db($DB);
				
if ($frm_s_jurusan!="")
	{
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id='".$frm_s_jurusan."'";
		$result_jur = @mysql_query($sql_jur);
		$row_jur = @mysql_fetch_array($result_jur);
		$frm_expt_jurusan = $row_jur['nama_jur'];
		//echo "<b>Jurusan: </b>".$row_jur["nama_jur"];
		$excel_export.="<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
						  <tr>
							<td align=\"center\"><b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b></td>
						  </tr>
						  <tr>
							<td align=\"center\"><b>SCORE CARD</b></td>
						  </tr>
						  <tr>
							<td align=\"center\"><b>JURUSAN ".$frm_expt_jurusan."</b></td>
						  </tr>
						  <tr>
							<td align=\"center\"><b>TAHUN AKADEMIK ".$frm_thn;"</b></td>
						  </tr>
						  <tr>
							<td>&nbsp;</td>
						  </tr>
						  <tr>
							<td>&nbsp;</td>
						  </tr>
						  <tr>
							<td><b>Tgl. Cetak : ".date("d-m-Y")."</b></td>
						  </tr>
						</table>";
	}
	/*else 
	{
		$excel_export.="<b>Jurusan: Semua</b>";
	}*/
	
$excel_export.="
<table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
      <tr>
        <td bgcolor=\"#FFFFE8\"><table width=\"80%\"  border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\">
          <tr>
            <td>AKREDITASI</td>
            <td><strong>:</strong></td>
            <td align=\"left\">".$frm_akredit_jur."</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td nowrap>NAMA KETUA JURUSAN </td>
            <td><strong>:</strong></td>
            <td align=\"left\">".$nama_kajur."</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>JUMLAH DOSEN S1 | S2 | S3 </td>
            <td><strong>:</strong></td>
            <td>".$jum_dsn_s1." | ".$jum_dsn_s2." | ".$jum_dsn_s3."</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td nowrap>DISTRIBUSI KEPANGKATAN DOSEN</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Guru besar </td>
            <td><strong>:</strong></td>
            <td align=\"left\">".$jum_dsn_GB."</td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Lektor Kepala </td>
            <td><strong>:</strong></td>
            <td align=\"left\">".$jum_dsn_LK."</td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Lektor</td>
            <td><strong>:</strong></td>
            <td align=\"left\">".$jum_dsn_LE."</td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Asisten Ahli </td>
            <td><strong>:</strong></td>
            <td align=\"left\">".$jum_dsn_AA."</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td nowrap>JUMLAH PROGRAM DIBAWAH PRODI </td>
            <td><strong>:</strong></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>JUMLAH MAHASISWA AKTIF</td>
            <td><strong>:</strong></td>
            <td align=\"left\">".$jum_mhs_aktif."</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>JUMLAH LABORATORIUM </td>
            <td><strong>:</strong></td>
            <td align=\"left\">".$jum_lab_jur."</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>";
           $sql_lab = mysql_query ("SELECT master_lab.nama 
		                              FROM master_lab
					                 WHERE master_lab.id_jurusan=$frm_s_jurusan ORDER BY id ASC") or die ("Error in query: $sql_lab".mysql_error()); 
$excel_export.="<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"5\">";
                while($row_nama_lab=mysql_fetch_array($sql_lab)) {
$excel_export.="<tr>
                  <td align=\"left\">&#8226;".$row_nama_lab["nama"]."</td>
                </tr>";
                }
$excel_export.="</table>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>JUMLAH KONSENTRASI </td>
            <td><strong>:</strong></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>KONSENTRASI ... </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>KONSENTRASI ... </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>KONSENTRASI ... </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>JUMLAH KARYAWAN</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Tenaga Akademik </td>
            <td><strong>:</strong></td>
            <td align=\"left\">".$jum_tng_akademik."</td>
          </tr>
          <tr>
            <td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;Tenaga Penunjang Akademik </td>
            <td><strong>:</strong></td>
            <td align=\"left\">".$jum_tng_PNJ_akademik."</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>LUAS RUANG</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Kelas</td>
            <td><strong>:</strong></td>
            <td align=\"left\">".$total_luas_r_kul."<span class=\"style3\">m2</span></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Dosen</td>
            <td><strong>:</strong></td>
            <td align=\"left\">".$total_luas_r_dos."<span class=\"style3\">m2</span></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Tata Usaha</td>
            <td><strong>:</strong></td>
            <td align=\"left\">".$total_luas_r_tu."<span class=\"style3\">m2</span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>";
		
if ($t=='excel') {
switch ($frm_s_jurusan) {
	case '1': $jurkode="TE";
 		       break;
	case '2': $jurkode="TK";
 		       break;
	case '3': $jurkode="TI";
 		       break;
	case '4': $jurkode="IF";
 		       break;
}
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=SCARD_".$jurkode."-".date("dmY").".xls");

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