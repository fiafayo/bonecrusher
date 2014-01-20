<? 
session_start();
include("../../include/js_function.js");
require("../../include/global.php");
require("../../include/fungsi.php");
?>
<html>
<head>
<title>: : CETAK NILAI DOSEN PENGUJI TA : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {font-size: 10px}
-->
</style>
</head>
<body>
<? 

f_connecting();
	mysql_select_db($DB);
	
//$var_NRP=$_GET['nrp'];
$var_NRP=$_GET['nrp'];
$var_penguji=$_GET['penguji'];
//echo "<br>var_NRP=".$var_NRP;
//echo "<br>var_penguji=".$var_penguji;
$var_thn_ajar=$_GET['thn_ajar'];
//echo "<br>var_NRP=".$var_NRP;
//echo "<br>var_penguji=".$var_penguji;
//echo "<br>var_thn_ajar=".$var_thn_ajar;

/*$sql_nilai_doji_1="SELECT master_ta.JUDUL_TA,
						  daftar_uji.NRP,
						  master_mhs.NAMA,
						  daftar_uji.no_sk_awal,
						  daftar_uji.no_sk_akhir,
						  daftar_uji.kode_ketua,
						  daftar_uji.kode_sekre,
						  daftar_uji.kode_dosen1,
						  daftar_uji.kode_dosen2,
						  daftar_uji.kode_dosen3,
						  daftar_uji.tgl_ujian,
						  daftar_uji.ruang_ujian
                    FROM  daftar_uji, master_ta, master_mhs
                    WHERE daftar_uji.NRP=master_ta.NRP AND
                          daftar_uji.NRP=master_mhs.NRP AND
                          daftar_uji.NRP='".$var_NRP."'";*/

$sql_nilai_doji_1="SELECT master_ta.JUDUL_TA,
						  daftar_uji.NRP,
						  master_mhs.NAMA,
						  daftar_uji.kode_ketua,
						  daftar_uji.kode_sekre,
						  daftar_uji.kode_dosen1,
						  daftar_uji.kode_dosen2,
						  daftar_uji.kode_dosen3,
						  DATE_FORMAT(daftar_uji.tgl_ujian,\"%d/%m/%Y\") as tgl_ujian,
						  daftar_uji.ruang_ujian
                    FROM  daftar_uji, master_ta, master_mhs
                    WHERE daftar_uji.NRP=master_ta.NRP AND
                          daftar_uji.NRP=master_mhs.NRP AND
                          daftar_uji.NRP='".$var_NRP."'";
 
/*$sql_berita="SELECT DATE_FORMAT(`daftar_uji_lp`.`TGLUJI`,'%d/%m/%Y') as TGL_UJI,
				    daftar_uji_lp.`RUANG`,
				    daftar_uji_lp.`PEMBIMBING_1`,
				    daftar_uji_lp.`PEMBIMBING_2`,
				    daftar_uji_lp.`PENGUJI_1`,
				    daftar_uji_lp.`PENGUJI_2`,
				    master_lp.`JUDUL1`
			   FROM master_lp, daftar_uji_lp 
			  WHERE master_mhs.NRP =  master_lp.NRP AND
				    master_mhs.NRP =  daftar_uji_lp.NRP AND
				    master_lp.ST_LP = '".$var_NRP."'";*/
							   
			$result1 = mysql_query($sql_nilai_doji_1);
				if ($row = mysql_fetch_array($result1))
				{
					$frm_nrp = $row["NRP"];
					$frm_nama = $row["NAMA"];
					//$frm_ruang = $row["RUANG"];
					$frm_judul_TA = $row["JUDUL_TA"];
					$frm_penguji_1 = $row["kode_ketua"];
					$frm_penguji_2 = $row["kode_sekre"];
					$frm_penguji_3 = $row["kode_dosen1"];
					$frm_penguji_4 = $row["kode_dosen2"];
					
					$frm_tgl_uji_TA =$row["tgl_ujian"];
					if ($row["tgl_ujian"]=="00/00/0000") {
					$frm_tgl_uji_TA = ""; }else {
					$frm_tgl_uji_TA = $row["tgl_ujian"];}
					
					switch ($var_penguji) {
					case '1':
						$var_kode_penguji=$frm_penguji_1;
						break;
					case '2':
						$var_kode_penguji=$frm_penguji_2;
						break;
					case '3':
						$var_kode_penguji=$frm_penguji_3;
						break;
					case '4':
						$var_kode_penguji=$frm_penguji_4;
						break;
						}
			    }
			/*if ($frm_kodoji_1!='') {
				$result = mysql_query("Select nama from master_karyawan where kode='$frm_kodoji_1'");
				$row = mysql_fetch_array($result);
				$var_nama_doji_1 = $row["nama"];
			}	
			
			if ($frm_kodoji_2!='') {
				$result = mysql_query("Select nama from master_karyawan where kode='$frm_kodoji_2'");
				$row = mysql_fetch_array($result);
				$var_nama_doji_2 = $row["nama"];
			}	
			
			if ($frm_kodobing_1!='') {
				$result = mysql_query("Select nama from master_karyawan where kode='$frm_kodobing_1'");
				$row = mysql_fetch_array($result);
				$var_nama_dobing_1 = $row["nama"];
			}	
			
			if ($frm_kodobing_2!='') {
				$result = mysql_query("Select nama from master_karyawan where kode='$frm_kodobing_2'");
				$row = mysql_fetch_array($result);
				$var_nama_dobing_2 = $row["nama"];
			}*/
?>
<table width="80%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center">
		<input type="submit" name="Submit" value="PRINT" onClick="cetak();" style=" cursor:pointer; position:absolute; left:604px; top:32px; width:52px; height:18px; z-index:1; background-color: #CCCCCC; layer-background-color: #CCCCCC; border: 1px none #000000;" class="noPrint">
		</td>
      </tr>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td width="400%" colspan="4" align="center"><font size="3">NILAI UJIAN TUGAS AKHIR</font></td>
        </tr>
      <tr>
        <td colspan="4" align="center">(penilai oleh dosen penguji)</td>
      </tr>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center"><table width="100%"  border="1" cellspacing="0" cellpadding="5">
          <tr>
            <td>
			<? 	
			    $result2 = mysql_query("Select * from tahun_ajar where id='$var_thn_ajar'");
				$row2 = mysql_fetch_array($result2);
			?>
			<table width="100%"  border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="32%">SEMESTER : <? echo $row2["semester"];?></td>
                <td width="36%" nowrap><div align="right">TAHUN AKADEMIK : <? echo $row2['tahun_ajaran'];?> / <? echo $row2['tahun_ajaran']+1;?></div></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="4" align="center">          </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%"  border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="95%"  border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
            <td colspan="3">Mahasiswa yang di uji </td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td width="13%" nowrap>NRP</td>
            <td width="1%"><strong>:</strong></td>
            <td width="86%"><? echo $frm_nrp;?></td>
          </tr>
          <tr>
            <td>Nama</td>
            <td><strong>:</strong></td>
            <td><? echo $frm_nama;?></td>
          </tr>
          <tr>
            <td valign="top" nowrap>Judul Tugas Akhir </td>
            <td valign="top"><strong>:</strong></td>
            <td valign="top"><table width="80%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><? echo $frm_judul_TA;?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td nowrap>Nama Dosen Penguji </td>
            <td><strong>:</strong></td>
            <td nowrap>
				<? if ($var_kode_penguji<>'')
					{
						$result = mysql_query("Select nama from dosen where kode='$var_kode_penguji'");
						$row = mysql_fetch_array($result);
						$var_nama_penguji = $row["nama"];
						echo $var_nama_penguji;
					}
				?>
			</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Nilai</td>
            <td><strong>:</strong></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%"  border="1" align="center" cellpadding="5" cellspacing="0">
          <tr>
            <td width="4%"><div align="center" class="style1"><strong>NO</strong></div></td>
            <td width="41%"><div align="center" class="style1"><strong>ITEM TUGAS AKHIR </strong></div></td>
            <td colspan="2"><div align="center" class="style1"><strong>NILAI MENTAH<br>
                (1-100)
            </strong></div></td>
            <td width="15%"><div align="center" class="style1"><strong>BOBOT</strong></div></td>
            <td width="13%"><span class="style1"><strong>NILAI BOBOT</strong></span></td>
          </tr>
          <tr>
            <td height="40"><div align="center">1.</div></td>
            <td>Materi Tugas Akhir</td>
            <td width="13%">&nbsp;</td>
            <td width="14%" rowspan="2" valign="top"><div align="center" class="style1">RATA-RATA</div></td>
            <td rowspan="2"><div align="center">25%</div></td>
            <td rowspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td height="40"><div align="center">2.</div></td>
            <td nowrap>Sistematika &amp; bahasa penulisan Tugas Akhir</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td height="80"><div align="center">3.</div></td>
            <td>Mempertahankan Tugas Akhir</td>
            <td colspan="2">&nbsp;</td>
            <td><div align="center">60%</div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="80"><div align="center">4.</div></td>
            <td nowrap>Pengetahuan bidang studi</td>
            <td colspan="2">&nbsp;</td>
            <td><div align="center">15%</div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4">&nbsp;</td>
            <td height="60"><div align="center">Jumlah</div></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%"  border="0" align="center" cellpadding="2" cellspacing="0">
      <tr>
        <td width="9%" nowrap>Catatan</td>
        <td width="1%"><strong>:</strong></td>
        <td width="90%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="3%">&nbsp;</td>
        <td width="41%"><table width="100%"  border="1" cellspacing="0" cellpadding="10">
          <tr>
            <td><div align="center">KELOMPOK</div></td>
            <td><div align="center">NA</div></td>
            <td><div align="center">NILAI MENTAH </div></td>
          </tr>
          <tr>
            <td><table width="100%"  border="0" cellspacing="0" cellpadding="5">
                <tr>
                  <td nowrap>Istimewa</td>
                </tr>
                <tr>
                  <td nowrap>Amat Baik </td>
                </tr>
                <tr>
                  <td nowrap>Baik</td>
                </tr>
                <tr>
                  <td nowrap>Cukup Baik </td>
                </tr>
                <tr>
                  <td nowrap>Sedang</td>
                </tr>
                <tr>
                  <td nowrap>Tidak Lulus </td>
                </tr>
            </table></td>
            <td><table width="100%"  border="0" cellspacing="0" cellpadding="5">
                <tr>
                  <td><div align="center">A</div></td>
                </tr>
                <tr>
                  <td><div align="center">AB</div></td>
                </tr>
                <tr>
                  <td><div align="center">B</div></td>
                </tr>
                <tr>
                  <td nowrap><div align="center">BC</div></td>
                </tr>
                <tr>
                  <td><div align="center">C</div></td>
                </tr>
                <tr>
                  <td><div align="center">-</div></td>
                </tr>
            </table></td>
            <td><table width="100%"  border="0" cellspacing="0" cellpadding="5">
                <tr>
                  <td><div align="center">NM &gt;= 81</div></td>
                </tr>
                <tr>
                  <td><div align="center">73 &lt;= NM &lt; 81</div></td>
                </tr>
                <tr>
                  <td><div align="center">66 &lt;= NM &lt; 73</div></td>
                </tr>
                <tr>
                  <td nowrap><div align="center">60 &lt;= NM &lt; 66</div></td>
                </tr>
                <tr>
                  <td><div align="center">56 &lt;= NM &lt; 60</div></td>
                </tr>
                <tr>
                  <td><div align="center">NM &lt; 56</div></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="16%" valign="top">&nbsp;</td>
        <td width="40%" valign="top"><table width="100%"  border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td>
              <? 
			  $bln_TA=substr($frm_tgl_uji_TA, 3,2); 
			  $tgl_TA=substr($frm_tgl_uji_TA, 0,2);
			  $thn_TA=substr($frm_tgl_uji_TA, 6,4);
			  
			  switch ($bln_TA) {
						case '01':
							$bln_TA_nama='Januari';
							break;
						case '02':
							$bln_TA_nama='Februari';
							break;
						case '03':
							$bln_TA_nama='Maret';
							break;
						case '04':
							$bln_TA_nama='April';
							break;
						case '05':
							$bln_TA_nama='Mei';
							break;
						case '06':
							$bln_TA_nama='Juni';
							break;
						case '07':
							$bln_TA_nama='Juli';
							break;
						case '08':
							$bln_TA_nama='Agustus';
							break;
						case '09':
							$bln_TA_nama='September';
							break;
						case '10':
							$bln_TA_nama='Oktober';
							break;
						case '11':
							$bln_TA_nama='November';
							break;	
						case '12':
							$bln_TA_nama='Desember';
							break;
						}
				$date = "Surabaya, ".$tgl_TA." ".$bln_TA_nama." ".$thn_TA;
				echo $date;
		 ?>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Dosen Penguji,</td>
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
			<? echo $var_nama_penguji;?>
			</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>