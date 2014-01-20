<? session_start();
include("../../include/js_function.js");
require("../../include/global.php");
require("../../include/fungsi.php");
?>
<html>
<head>
<title>: : CETAK SK DEKAN TA : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
</head>
<body>
<? 
f_connecting();
	mysql_select_db($DB);
	
//$var_NRP=$_GET['nrp'];
$var_no_SK=$_GET['no_sk'];
$var_periode=$_GET['periode'];
$var_thn_ajar=$_GET['thn_ajar'];
/*echo "<br>var_no_SK=".$var_no_SK;
echo "<br>var_periode=".$var_periode;
echo "<br>var_thn_ajar=".$var_thn_ajar;*/

 
/*$sql_Lampiran_SK_dek="SELECT master_mhs.NRP,
							 master_mhs.NAMA,
							 DATE_FORMAT(`daftar_uji`.`tgl_ujian`,'%d/%m/%Y') as TGL_UJI,
							 daftar_uji.`ruang_ujian`,
							 daftar_uji.`kode_ketua`,
							 daftar_uji.`kode_sekre`,
							 daftar_uji.`kode_dosen1`,
							 daftar_uji.`kode_dosen2`,
							 daftar_uji.`kode_dosen3`,
							 master_ta.`JUDUL_TA`
					   FROM  master_mhs, master_ta, daftar_uji 
					  WHERE  master_mhs.NRP =  master_ta.NRP AND
							 master_mhs.NRP =  daftar_uji.NRP AND
							 daftar_uji.no_sk_awal = '".$var_no_SK."'";
$result = mysql_query($sql_Lampiran_SK_dek);*/
?>
<table width="80%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="4">         
		 <input type="submit" name="Submit" value="PRINT" onClick="cetak();" style=" cursor:pointer; position:absolute; left:604px; top:32px; width:52px; height:18px; z-index:1; background-color: #CCCCCC; layer-background-color: #CCCCCC; border: 1px none #000000;" class="noPrint">
		</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4"><div align="center">K E P U T U S A N</div></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4"><div align="center">DEKAN FAKULTAS TEKNIK UNIVERSITAS SURABAYA </div></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td width="400%" colspan="4"><div align="center"><strong>NOMOR :
                <? 
		 /* $jur_kp=substr($frm_kode_KP, 0,2);     
		  $bln= date('m');
		  switch ($bln) {
			case '01':
				$bln_romawi='I';
				break;
			case '02':
				$bln_romawi='II';
				break;
			case '03':
				$bln_romawi='III';
				break;
			case '04':
				$bln_romawi='IV';
				break;
			case '05':
				$bln_romawi='V';
				break;
			case '06':
				$bln_romawi='VI';
				break;
			case '07':
				$bln_romawi='VII';
				break;
			case '08':
				$bln_romawi='VIII';
				break;
			case '09':
				$bln_romawi='IX';
				break;
			case '10':
				$bln_romawi='X';
				break;
			case '11':
				$bln_romawi='XI';
				break;	
			case '12':
				$bln_romawi='XII';
				break;
			}*/

		  echo  $var_no_SK ."/SK/DK/TA/".date('Y');
		  ?> 
          </strong></div></td>
        </tr>
      <tr>
        <td colspan="4" align="center">tentang</td>
      </tr>
      <tr>
        <td colspan="4" align="center">PENGANGKATAN TIM PENGUJI PENELITIAN</td>
      </tr>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center">bagi Sdr. &nbsp;terlampir&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NRP. &nbsp;terlampir </td>
      </tr>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center"><table width="90%"  border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
            <td width="11%" valign="top">MENIMBANG</td>
            <td width="3%" valign="top">:</td>
            <td width="86%">Perlu dibentuk tim penguji PENELITIAN bagi mahasiswa Fakultas Teknik Universitas Surabaya tersebut di atas. </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">MENGINGAT</td>
            <td valign="top">:</td>
            <td><table width="100%"  border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="2%">1.</td>
                <td width="98%"><div align="justify">STATUTA Universitas Surabaya 2012 </div></td>
              </tr>
              <tr>
                <td valign="top">2.</td>
                <td>
				     <? 
					  $sql_dek="SELECT nama FROM jabatan_struktural WHERE jabatan='Rektor'";
					  $result_dek = mysql_query($sql_dek);
					  
					  ?>
				<div align="justify">Keputusan Yayasan Universitas Surabaya<br>
                    No. 013/SK/YUS/III/2011 ; tentang Pengangkatan<br>
                    Sdr. <? if ($row_dek = mysql_fetch_array($result_dek)) {
						echo $row_dek["nama"];
					  }?> Sebagai Rektor Universitas Surabaya Masa Bhakti 2011-2015
					  </div></td>
              </tr>
              <tr>
                <td valign="top">3.</td>
                <td><div align="justify">Keputusan Rektor Universitas Surabaya No. 221 Tahun 2011 tentang Pengangkatan Dekan Fakultas dan Direktur di lingkungan Universitas Surabaya masa bakti 2011-2015</div></td>
              </tr>
              <tr>
                <td valign="top">4.</td>
                <td><div align="justify">Keputusan Dekan Fakultas Teknik  Universitas Surabaya Nomor 012/SK/DEK/FT/XI/2007 tentang Pembimbing dan Penguji Tugas Akhir </div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3"><div align="center">M E M U T U S K A N</div></td>
            </tr>
          <tr>
            <td valign="top">MENETAPKAN</td>
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">Pertama</td>
            <td valign="top">:</td>
            <td> Mengangkat tim penguji PENELITIAN bagi mahasiswa tersebut di atas dengan susunan sesuai terlampir. </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">Kedua</td>
            <td valign="top">:</td>
            <td>Ujian PENELITIAN tersebut hanya dapat dilangsungkan apabila dihadiri oleh tim penguji PENELITIAN sekurang-kurangnya terdiri dari 2 (dua) orang anggota, termasuk di dalamnya pembimbing mahasiswa. Konsep PENELITIAN telah dikirim kepada tim penguji paling lambat 1 (satu) minggu sebelum pelaksanaan ujian.</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">Ketiga</td>
            <td valign="top">:</td>
            <td>Keputusan ini mulai berlaku sejak tanggal ditetapkan. </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">Keempat</td>
            <td valign="top">:</td>
            <td>Apabila di kemudian hari terdapat kekeliruan pada keputusan ini atau terjadi perubahan keadaan, maka akan diadakan perbaikan atau perubahan seperlunya. </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center"><div align="right">
          <table width="40%"  border="0" align="right" cellpadding="0" cellspacing="0">
            <tr>
              <td>
                <? 
			$Bulan=date('F');
			if($Bulan == "January")
				$Bulan = "Januari";
			else if($Bulan == "February")
				$Bulan = "Februari";
			else if($Bulan == "March")
				$Bulan = "Maret";	
			else if($Bulan == "May")
				$Bulan = "Mei";
			else if($Bulan == "June")
				$Bulan = "Juni";
			else if($Bulan == "July")
				$Bulan = "Juli";
			else if($Bulan == "August")
				$Bulan = "Agustus";
			else if($Bulan == "October")
				$Bulan = "Oktober";
			else if($Bulan == "December")
				$Bulan = "Desember";
				
			$date = "Ditetapkan di Surabaya <br>Pada, ".date('d')." ".$Bulan." ".date('Y');
		 	echo $date;
		 ?>
              </td>
            </tr>
            <tr>
              <td>Oleh Dekan,</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
					  <? 
					  $sql_dek="SELECT nama FROM jabatan_struktural WHERE jabatan='Dekan'";
					  $result_dek = mysql_query($sql_dek);
					  if ($row_dek = mysql_fetch_array($result_dek)) {
						echo $row_dek["nama"];
					  }
					  ?>
				</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
        </div></td>
      </tr>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center">          </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%"  border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="90%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2">Tembusan kepada : </td>
          </tr>
          <tr>
            <td colspan="2" nowrap>1. Kepala Biro ADPESDAM.</td>
            </tr>
          <tr>
            <td colspan="2">2. Wakil Dekan Fakultas Teknik Univ. Surabaya.</td>
            </tr>
          <tr>
            <td colspan="2" valign="top">3. Ketua Jurusan Program Studi Teknik Kimia.</td>
          </tr>
          <tr>
            <td colspan="2" valign="top">4. Dosen penguji PENELITIAN. </td>
          </tr>
          <tr>
            <td width="6%">&nbsp;</td>
            <td width="94%">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>