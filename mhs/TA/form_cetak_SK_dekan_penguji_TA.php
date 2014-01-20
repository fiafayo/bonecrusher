<? 
/* 
   DATE CREATED : 12/07/07
   KEGUNAAN     : CETAK SK DEKAN PENGUJI TA
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
   
   PERUBAHAN    : 15/12/2009 - perubahan format SK DEKAN 
   							 - dari  002810910/SK/DK/TA/2009 menjadi 002810910/SK/DEK/FT/XII/2009 
*/

session_start();
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
$var_tgl_ujian=$_GET['tgl_ujian'];
/*echo "<br>var_no_SK=".$var_no_SK;
echo "<br>var_periode=".$var_periode;
echo "<br>var_thn_ajar=".$var_thn_ajar;*/
//echo "<br>var_tgl_ujian=".$var_tgl_ujian;
?>
<table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="4">
		<div align="center"><strong>K E P U T U S A N
		  <input type="submit" name="Submit" value="PRINT" onClick="cetak();" style=" cursor:pointer; position:absolute; left:604px; top:12px; width:52px; height:18px; z-index:1; background-color: #CCCCCC; layer-background-color: #CCCCCC; border: 1px none #000000;" class="noPrint">
		</strong></div>
		</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4"><div align="center"><strong>DEKAN FAKULTAS TEKNIK UNIVERSITAS SURABAYA </strong></div></td>
      </tr>
      <tr>
        <td width="400%" colspan="4"><div align="center"><strong>NOMOR :
                <? 
		 //$jur_kp=substr($frm_kode_KP, 0,2);     
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
			}

		  //echo  $var_no_SK ."/SK/DK/TA/".date('Y');
		  echo  $var_no_SK ."/SK/DEK/FT/".$bln_romawi."/".date('Y');
		  ?> 
          </strong></div></td>
        </tr>
      <tr>
        <td colspan="4" align="center">tentang</td>
      </tr>
      <tr>
        <td colspan="4" align="center"><strong>PENGANGKATAN TIM PENGUJI TUGAS AKHIR </strong></td>
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
        <td colspan="4" align="center"><table width="98%"  border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
            <td width="11%" valign="top">MENIMBANG</td>
            <td width="3%" valign="top">:</td>
            <td width="86%">Perlu dibentuk tim penguji Tugas Akhir bagi mahasiswa Fakultas Teknik Universitas Surabaya tersebut di atas. </td>
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
            <td colspan="3"><div align="center"><strong>M E M U T U S K A N</strong></div></td>
            </tr>
          <tr>
            <td valign="top">MENETAPKAN</td>
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">Pertama</td>
            <td valign="top">:</td>
            <td> <div align="justify">Mengangkat tim penguji Tugas Akhir bagi mahasiswa tersebut di atas dengan susunan sesuai terlampir. </div></td>
          </tr>
          <tr>
            <td valign="top">Kedua</td>
            <td valign="top">:</td>
            <td><div align="justify">Ujian Tugas Akhir tersebut hanya dapat dilangsungkan apabila dihadiri oleh paling banyak 4 (empat) orang dengan paling sedikit 3 (tiga) orang sebagai tim inti. Penguji dapat dimasukkan sebagai tim inti bila mempunyai kepangkatan Kopertis paling rendah Lektor untuk S1, atau kepangkatan Kopertis paling rendah Asisten Ahli untuk S2 . Konsep Tugas Akhir dikirim paling lambat 1 (satu) minggu sebelum pelaksanaan ujian.</div></td>
          </tr>
          <tr>
            <td valign="top">Ketiga</td>
            <td valign="top">:</td>
            <td><div align="justify">Ujian Tugas Akhir sah apabila dihadiri oleh 2 (dua) orang dosen penguji (bukan pembimbing) ditambah 1 (satu) atau 2 (dua) orang pembimbing dan semuanya memenuhi kriteria tim inti. </div></td>
          </tr>
          <tr>
            <td valign="top">Keempat</td>
            <td valign="top">:</td>
            <td><div align="justify">Apabila di kemudian hari terdapat kekeliruan pada keputusan ini atau terjadi perubahan keadaan, maka akan diadakan perbaikan atau perubahan seperlunya. </div></td>
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
              <td nowrap>
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
              <td nowrap>Oleh Dekan,</td>
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
                <td nowrap>
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
            <td width="100%" colspan="2">Tembusan kepada : </td>
          </tr>
          <tr>
            <td colspan="2" nowrap>1. Kepala Biro ADPESDAM.</td>
            </tr>
          <tr>
            <td colspan="2" valign="top">2. Ketua Jurusan yang bersangkutan.</td>
          </tr>
          <tr>
            <td colspan="2" valign="top">3. Dosen penguji Tugas Akhir. </td>
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