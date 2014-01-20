<?
/* 
   KETERANGAN 	: EXPORT HASIL view_scard_personal ke EXCEL

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
$excel_export.="<b>LAPORAN SCORE CARD PERSONAL (b)</b><br><br>";
$excel_export.="<b>Dosen : ".$row_dosen['kode']." - ".$row_dosen['nama']."</b><br>";

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


//BEGIN JUMLAH LAYANAN INDUSTRI
		$result1 = mysql_query("SELECT count(*) as jum
								  FROM pengabdian
								 WHERE pengabdian.mulai between '".$tgl_1."' and '".$tgl_2."'");
		if ($row1 = mysql_fetch_array($result1)) {
		  $jum_layanan_industri=$row1["jum"];
		  //echo "thn_layanan_industri=".$thn_layanan_industri;
		}
//END JUMLAH LAYANAN INDUSTRI


// TARGET SCARD PERSONAL
		$result_target = mysql_query("SELECT * 
										FROM sc_per");
								
		if ($row_target = mysql_fetch_array($result_target)) {
		  $target_LD1=$row_target["LD1"];
		  $target_LD2=$row_target["LD2"];
		  $target_LD3=$row_target["LD3"];
		  $target_LD4=$row_target["LD4"];
		  $target_LD5=$row_target["LD5"];
		  $target_LD6=$row_target["LD6"];
		}
//END TARGET SCARD PERSONAL

if ($frm_s_jurusan!="")
	{
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id=".$frm_s_jurusan;
		$result_jur = @mysql_query($sql_jur);
		$row_jur=@mysql_fetch_array($result_jur);
		//echo "<b>Jurusan: </b>".$row_jur["nama_jur"];
	}
	
$excel_export.="
<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td colspan=\"3\" align=\"left\"><b>Jurusan: </b>".$row_jur["nama_jur"]."</td>
    <td colspan=\"3\" align=\"right\"><b>Tgl. Cetak : ".date("d-m-Y")."</b></td>
  </tr>
</table>";
	
$excel_export.="
<table width=\"100%\" border=\"1\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\">
      <tr bgcolor=\"#C6E2FF\">
        <td width=\"4%\" nowrap><strong>No</strong></td>
        <td width=\"52%\" nowrap><b>Nama KPI </b></td>
        <td width=\"11%\" nowrap><div align=\"center\"><strong>Target</strong></div></td>
        <td width=\"10%\" nowrap><div align=\"center\"><strong>Capaian</strong></div></td>
        <td width=\"12%\" nowrap><div align=\"center\"><strong>% capaian</strong></div></td>
        <td width=\"11%\" nowrap><div align=\"center\"><strong>Rata-rata<br>
            % capaian </strong></div></td>
      </tr>
      <tr bgcolor=\"#CCCCCC\">
        <td colspan=\"6\" valign=\"top\" nowrap><em>Isu Strategis:</em> <strong>Learning &amp; Discovery </strong></td>
      </tr>
      <tr>
        <td nowrap valign=\"top\">1</td>
        <td nowrap valign=\"top\"> Jumlah Penelitian Dosen </td>
        <td align=\"center\" nowrap>".$target_LD1."</td>
        <td align=\"center\" nowrap>".$jum_penil."</td>
        <td align=\"center\" nowrap>".$capaianLD1."</td>
        <td rowspan=\"6\" align=\"center\" nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td nowrap valign=\"top\">2</td>
        <td nowrap valign=\"top\">Jumlah publikasi jurnal nasional terakreditasi </td>
        <td align=\"center\" nowrap>".$target_LD2."</td>
        <td align=\"center\" nowrap>". $jum_pub_jurnal_nas."</td>
        <td align=\"center\" nowrap>".$capaianLD2."</td>
        </tr>
      <tr>
        <td nowrap valign=\"top\">3</td>
        <td nowrap valign=\"top\">Jumlah publikasi prosiding nasional</td>
        <td align=\"center\" nowrap>".$target_LD3."</td>
        <td align=\"center\" nowrap>".$jum_pub_prosiding_nas."</td>
        <td align=\"center\" nowrap>".$capaianLD3."</td>
        </tr>
      <tr>
        <td nowrap valign=\"top\">4</td>
        <td nowrap valign=\"top\">Jumlah Layanan Industri </td>
        <td align=\"center\" nowrap>".$target_LD4."</td>
        <td align=\"center\" nowrap>".$jum_layanan_industri."</td>
        <td align=\"center\" nowrap>".$capaianLD4."</td>
        </tr>
      <tr>
        <td nowrap valign=\"top\">5</td>
        <td nowrap valign=\"top\">Jumlah grant yang diterima </td>
        <td align=\"center\" nowrap>".$target_LD5."</td>
        <td align=\"center\" nowrap>".$jum_grant_prodi."</td>
        <td align=\"center\" nowrap>".$capaianLD5."</td>
        </tr>
      <tr>
        <td nowrap valign=\"top\">6</td>
        <td nowrap valign=\"top\">Rata-rata indeks pembelajaran per jurusan (dosen tetap) </td>
        <td align=\"center\" nowrap>".$target_LD6."</td>
        <td align=\"center\" nowrap>".$rata_IPK_dosen."</td>
        <td align=\"center\" nowrap>".$capaianLD6."</td>
        </tr>
      <tr>
        <td nowrap valign=\"top\">&nbsp;</td>
        <td nowrap valign=\"top\">&nbsp;</td>
        <td valign=\"top\" nowrap>&nbsp;</td>
        <td valign=\"top\" nowrap>&nbsp;</td>
        <td valign=\"top\" nowrap>&nbsp;</td>
        <td valign=\"top\" nowrap>".$rata2_persen_capaian."</td>
      </tr>
      <tr>
        <td colspan=\"2\" valign=\"top\" nowrap>Rata-rata % pencapaian keseluruhan </td>
        <td align=\"center\" nowrap>".$rata2_target."</td>
        <td align=\"center\" nowrap>".$rata2_capaian."</td>
        <td align=\"center\" nowrap>".$rata2_capaian_all."</td>
        <td align=\"center\" nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td nowrap align=\"center\">&nbsp;</td>
        <td nowrap align=\"center\">&nbsp;</td>
        <td align=\"center\" nowrap>&nbsp;</td>
        <td align=\"center\" nowrap>&nbsp;</td>
        <td align=\"center\" nowrap>&nbsp;</td>
        <td align=\"center\" nowrap>&nbsp;</td>
      </tr>
    </table>
";

	//$excel_export.="</table>";


if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=scard_personal-b-".date("dmY").".xls");

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
