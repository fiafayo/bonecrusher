<?
/* 
   KETERANGAN 	: EXPORT HASIL view_scard_personal 1 ke EXCEL

   DATE CREATED : 15/12/08 - RAHADI
   LAST UPDATE  : 
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
mysql_select_db($DB);
/*if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}*/
$sql_dosen ="SELECT * 
			   FROM dosen
			  WHERE kode='$frm_s_dosen'";
$res_dosen = @mysql_query($sql_dosen);
$row_dosen = @mysql_fetch_array($res_dosen);

$excel_export.="<b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b><br>";
$excel_export.="<b>LAPORAN SCORE CARD PERSONAL (a)</b><br>";

             switch ($frm_s_thn) {
					case '2001':
						$tgl_1="2001-01-01";
						$tgl_2="2001-12-31";
						break;
					case '2002':
						$tgl_1="2002-01-01";
						$tgl_2="2002-12-31";
						break;
					case '2003':
						$tgl_1="2003-01-01";
						$tgl_2="2003-12-31";
						break;
					case '2004':
						$tgl_1="2004-01-01";
						$tgl_2="2004-12-31";
						break;
					case '2005':
						$tgl_1="2005-01-01";
						$tgl_2="2005-12-31";
						break;
					case '2006':
						$tgl_1="2006-01-01";
						$tgl_2="2006-12-31";
						break;
					case '2007':
						$tgl_1="2007-01-01";
						$tgl_2="2007-12-31";
						break;
					case '2008':
						$tgl_1="2008-01-01";
						$tgl_2="2008-12-31";
						break;
					case '2009':
						$tgl_1="2009-01-01";
						$tgl_2="2009-12-31";
						break;
					case '2010':
						$tgl_1="2010-01-01";
						$tgl_2="2010-12-31";
						break;
					case '2011':
						$tgl_1="2011-01-01";
						$tgl_2="2011-12-31";
						break;
					case '2012':
						$tgl_1="2012-01-01";
						$tgl_2="2012-12-31";
						break;
					case '2013':
						$tgl_1="2013-01-01";
						$tgl_2="2013-12-31";
						break;
					case '2014':
						$tgl_1="2014-01-01";
						$tgl_2="2014-12-31";
						break;
					case '2015':
						$tgl_1="2015-01-01";
						$tgl_2="2015-12-31";
						break;
				}
				
				
$result1 = mysql_query("SELECT count(*) as jum
						  FROM pengabdian
						 WHERE pengabdian.mulai between '".$tgl_1."' and '".$tgl_2."'");
if ($row1 = mysql_fetch_array($result1)) {
  $jum_layanan_industri=$row1["jum"];
  //echo "thn_layanan_industri=".$thn_layanan_industri;
}

//END JUMLAH LAYANAN INDUSTRI

// JUMLAH GRANT YG DITERIMA
$result = mysql_query("SELECT Sum(grant_prodi.jumlah) as tot_grant
						 FROM grant_prodi
						WHERE grant_prodi.tgl_awal between '".$tgl_1."' and '".$tgl_2."' AND
						      grant_prodi.jurusan_id=$frm_s_jurusan");
if ($row_grant = mysql_fetch_array($result)) {
 $jum_grant_prodi=$row_grant["tot_grant"];
 // echo "<br>jum_grant_prodi=".$jum_grant_prodi;
}
//END JUMLAH GRANT YG DITERIMA

$result = mysql_query("SELECT avg(IPK_lulus) as rata
						  FROM master_alumni
						 WHERE master_alumni.tanggal_lulus between '".$tgl_1."' and '".$tgl_2."'");
if ($row = mysql_fetch_array($result)) {
  $rata_IPK_lulusan=$row["rata"];
  //echo "rata_IPK_lulusan=".$rata_IPK_lulusan;
}

//END RATA-RATA IPK LULUSAN berdasarkan tahun


// JUMLAH PENELITIAN PER TAHUN
$result_penil = mysql_query("SELECT count(*) as jum_penelitian
						 FROM penelitian
						WHERE penelitian.tanggal_mulai between '".$tgl_1."' and '".$tgl_2."'AND
							  penelitian.jurusan_id=$frm_s_jurusan");
						
if ($row_penil = mysql_fetch_array($result_penil)) {
  $jum_penil=$row_penil["jum_penelitian"];
  //echo "<br>jum_penil=".$jum_penil;
}
//END JUMLAH PENELITIAN PER TAHUN

// JUMLAH PUBLIKASI JURNAL NASIONAL TERAKREDITASI PER TAHUN
$result_pub_status = mysql_query("SELECT id_pub, nama
						            FROM status_publikasi
								   WHERE status_publikasi.nama='Nasional'");
						
if ($row_pub_status = mysql_fetch_array($result_pub_status)) {
   $status_pub1=$row_pub_status["id_pub"];
   //echo "<br>status_pub1=".$status_pub1;
}

$result_pub_jurnal_nas = mysql_query("SELECT count(*) as jum_jurnal_nasional
						                FROM penelitian
						               WHERE penelitian.pub_tanggal between '".$tgl_1."' and '".$tgl_2."' AND
									   		 penelitian.jurusan_id=$frm_s_jurusan AND
						                     penelitian.publikasi=$status_pub1");
						
if ($row_pub_jurnal_nas = mysql_fetch_array($result_pub_jurnal_nas)) {
  $jum_pub_jurnal_nas=$row_pub_jurnal_nas["jum_jurnal_nasional"];
  //echo "<br>jum_pub_jurnal_nas=".$jum_pub_jurnal_nas;
}
//END JUMLAH PUBLIKASI JURNAL NASIONAL TERAKREDITASI PER TAHUN


// JUMLAH PUBLIKASI JURNAL INTERNASIONAL TERAKREDITASI PER TAHUN
$result_pub_status = mysql_query("SELECT id_pub, nama
						            FROM status_publikasi
								   WHERE status_publikasi.nama='Internasional'");
						
if ($row_pub_status = mysql_fetch_array($result_pub_status)) {
   $status_pub1=$row_pub_status["id_pub"];
 
}

$result_pub_jurnal_inter = mysql_query("SELECT count(*) as jum_jurnal_internasional
						                FROM penelitian
						               WHERE penelitian.pub_tanggal between '".$tgl_1."' and '".$tgl_2."' AND
									         penelitian.jurusan_id=$frm_s_jurusan AND
						                     penelitian.publikasi=$status_pub1");
						
if ($row_pub_jurnal_inter = mysql_fetch_array($result_pub_jurnal_inter)) {
  $jum_pub_jurnal_inter=$row_pub_jurnal_inter["jum_jurnal_internasional"];
  //echo "<br>jum_pub_jurnal_inter=".$jum_pub_jurnal_inter;
}
//END JUMLAH PUBLIKASI JURNAL INTERNASIONAL TERAKREDITASI PER TAHUN


// JUMLAH PUBLIKASI PROSIDING NASIONAL TERAKREDITASI PER TAHUN
$result_pub_status = mysql_query("SELECT id_pub, nama
						            FROM status_publikasi
								   WHERE status_publikasi.nama='Nasional'");
						
if ($row_pub_status = mysql_fetch_array($result_pub_status)) {
   $status_pub1=$row_pub_status["id_pub"];
 
}

$result_pub_prosiding_nas = mysql_query("SELECT count(*) as jum_prosiding_nasional
						                   FROM penelitian
						                  WHERE penelitian.pub_tanggal between '".$tgl_1."' and '".$tgl_2."' AND
										        penelitian.jurusan_id=$frm_s_jurusan AND
						                        penelitian.publikasi=$status_pub1 AND penelitian.pub_ISBN<>''");
						
if ($row_pub_prosiding_nas = mysql_fetch_array($result_pub_prosiding_nas)) {
  $jum_pub_prosiding_nas=$row_pub_prosiding_nas["jum_prosiding_nasional"];
  //echo "<br>jum_row_pub_prosiding_nas=".$jum_pub_prosiding_nas;
}
//END JUMLAH PUBLIKASI PROSIDING NASIONAL TERAKREDITASI PER TAHUN



if ($frm_s_jurusan!="all")
	{
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id=".$frm_s_jurusan;
		$result_jur = @mysql_query($sql_jur);
		$row_jur=@mysql_fetch_array($result_jur);
		//echo "<b>Jurusan: </b>".$row_jur["nama_jur"];
		//$excel_export.="<b>Jurusan: </b>".$row_jur["nama_jur"];
	}
	
$excel_export.="
<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td colspan=\"3\" align=\"left\"><b>Jurusan: </b>".$row_jur["nama_jur"]."</td>
    <td colspan=\"3\" align=\"right\"><b>Tgl. Cetak : ".date("d-m-Y")."</b></td>
  </tr>
</table>";


$excel_export.="
<table width=\"95%\"  border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>NAMA DOSEN </td>
        <td><strong>:</strong></td>
        <td align=\"left\">".$row_dosen["kode"]." - ".$row_dosen["nama"]."</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>TANGGAL LAHIR </td>
        <td><strong>:</strong></td>
        <td align=\"left\">".datetoreport($row_dosen["tanggal_lahir"])."</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>PENDIDIKAN</td>
        <td><strong>:</strong></td>
        <td align=\"left\">".$row_dosen["pendidikan_terakhir"]."</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>KEPANGKATAN</td>
        <td><strong>:</strong></td>
        <td align=\"left\">".$row_dosen["pangkat"]."</td>
      </tr>
      <tr>
        <td nowrap>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td nowrap>BIDANG KEAHLIAN </td>
        <td><strong>:</strong></td>
        <td align=\"left\">".$row_dosen["bidang_keahlian"]."</td>
      </tr>
      <tr>
        <td nowrap>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td nowrap>JUMLAH SKS RIIL</td>
        <td>&nbsp;</td>
        <td align=\"left\">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;SEMESTER GASAL</td>
        <td><strong>:</strong></td>
        <td align=\"left\">".$jum_dsn_GB."</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;SEMESTER GENAP</td>
        <td><strong>:</strong></td>
        <td align=\"left\">".$jum_dsn_LK."</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td valign=\"top\">MATA KULIAH YANG DI ASUH </td>
        <td valign=\"top\"><strong>:</strong></td>
        <td rowspan=\"2\" valign=\"top\">		
		<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"2\" align=\"left\">
          <tr valign=\"top\">
            <td><table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"2\" class=\"table\">
              <tr bgcolor=\"#C6E2FF\">
                <td><div align=\"center\">SEMESTER GASAL</div></td>
              </tr>";
				
				$periode_MKA=$frm_s_thn."1";
				//echo "<br>periode_MKA=".$periode_MKA;
				$sql_MKA="SELECT rekap_dosen.nama_MK
							FROM rekap_dosen
						   WHERE (rekap_dosen.kode_MK <> '' AND rekap_dosen.id_periode='".$periode_MKA."'  AND rekap_dosen.kode_dsn='".$frm_s_dosen."')
						GROUP BY rekap_dosen.nama_MK ";
				$res_MKA = @mysql_query($sql_MKA);
				while(($row_MKA = @mysql_fetch_array($res_MKA)))
				{
$excel_export.="
              <tr>
                <td>".$row_MKA['nama_MK']."</td>
              </tr>";
                }
$excel_export.="
            </table></td>
            <td><table width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"2\" class=\"table\">
              <tr bgcolor=\"#C6E2FF\">
                <td><div align=\"center\">SEMESTER GENAP </div></td>
              </tr>";
             
				$periode_MKA=$frm_s_thn."2";
				//echo "<br>periode_MKA=".$periode_MKA;
				$sql_MKA="SELECT rekap_dosen.nama_MK
							FROM rekap_dosen
						   WHERE (rekap_dosen.kode_MK <> '' AND rekap_dosen.id_periode='".$periode_MKA."' AND rekap_dosen.kode_dsn='".$frm_s_dosen."')
						GROUP BY rekap_dosen.kode_MK ";
				$res_MKA = @mysql_query($sql_MKA);
				while(($row_MKA = @mysql_fetch_array($res_MKA)))
				{
$excel_export.="
              <tr>
                <td>".$row_MKA['nama_MK']."</td>
              </tr>";
                }
$excel_export.="
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>JUMLAH BIMBINGAN </td>
        <td><strong>:</strong></td>
        <td align=\"left\">".$jum_bim_dsn."</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td nowrap>KEANGGOTAAN ASOSIASI PROFESI</td>
        <td><strong>:</strong></td>
        <td>-</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
";

	//$excel_export.="</table>";


if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=scard_personal-a-".date("dmY").".xls");

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