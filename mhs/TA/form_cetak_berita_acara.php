<? 
session_start();
include("../../include/js_function.js");
require("../../include/global.php");
require("../../include/fungsi.php");
?>
<html>
<head>
<title>: : CETAK BERITA ACARA UJIAN TA : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style3 {font-size: 9px}
-->
</style>
</head>
<body>
<? 
f_connecting();
	mysql_select_db($DB);
	
$var_NRP=$_GET['nrp'];
$var_periode=$_GET['periode'];
$var_thn_ajar=$_GET['thn_ajar'];
//echo "<br>var_NRP=".$var_NRP;
//echo "<br>var_periode=".$var_periode;
//echo "<br>var_NRP=".$var_NRP;

$sql_berita="SELECT master_mhs.NRP,
					master_mhs.NAMA,
					daftar_uji.`kode_ketua`,
					daftar_uji.`kode_sekre`,
					daftar_uji.`kode_dosen1`,
					daftar_uji.`kode_dosen2`,
					DATE_FORMAT(`daftar_uji`.`tgl_ujian`,'%d/%m/%Y') as TGL_UJI,
					daftar_uji.`ruang_ujian`,
					master_ta.`JUDUL_TA`,
					master_ta.`KODOS1`,
					master_ta.`KODOS2`
			  FROM  master_mhs, master_ta, daftar_uji 
			  WHERE master_mhs.NRP =  master_ta.NRP AND
					master_mhs.NRP =  daftar_uji.NRP AND
				    master_mhs.NRP = '".$var_NRP."'";
			  
$result = mysql_query($sql_berita);
							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_nrp = $row["NRP"];
								$frm_nama = $row["NAMA"];
								$frm_ruang = $row["ruang_ujian"];
								$frm_judul_LP = $row["JUDUL_TA"];
								$frm_kodos_1 = $row["KODOS1"];
								$frm_kodos_2 = $row["KODOS2"];
								
								$frm_ketua=$row["kode_ketua"];
								$frm_sekre=$row["kode_sekre"];
								$frm_anggota_1=$row["kode_dosen1"];
								$frm_anggota_2=$row["kode_dosen2"];
								
								$frm_tgl_uji_TA =$row["TGL_UJI"];
								if ($row["TGL_UJI"]=="00/00/0000") {
								$frm_tgl_uji_TA = ""; }else {
								$frm_tgl_uji_TA = $row["TGL_UJI"];}
								
							}else
							{$frm_exist=0;// header("Location: mhs_perpanjangan_ta.php"); 
							}
							
							if ($frm_kodos_1!='') {
								$result = mysql_query("Select nama from dosen where kode='$frm_kodos_1'");
								$row = mysql_fetch_array($result);
								$var_nama_dobing_1 = $row["nama"];
							}	
							
							if ($frm_kodos_2!='') {
								$result = mysql_query("Select nama from dosen where kode='$frm_kodos_2'");
								$row = mysql_fetch_array($result);
								$var_nama_dobing_2 = $row["nama"];
							}	
							
							if ($frm_ketua!='') {
								$result = mysql_query("Select nama from dosen where kode='$frm_ketua'");
								$row = mysql_fetch_array($result);
								$var_nama_ketua = $row["nama"];
							}	
							
							if ($frm_sekre!='') {
								$result = mysql_query("Select nama from dosen where kode='$frm_sekre'");
								$row = mysql_fetch_array($result);
								$var_nama_sekre = $row["nama"];
							}	
							
							if ($frm_anggota_1!='') {
								$result = mysql_query("Select nama from dosen where kode='$frm_anggota_1'");
								$row = mysql_fetch_array($result);
								$var_nama_anggota_1 = $row["nama"];
							}	
							
							if ($frm_anggota_2!='') {
								$result = mysql_query("Select nama from dosen where kode='$frm_anggota_2'");
								$row = mysql_fetch_array($result);
								$var_nama_anggota_2 = $row["nama"];
							}	
?>
<div id="halamanprint">
<table width="92%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td> <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td colspan="4" align="center">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="4" align="center"> <input type="submit" name="Submit" value="PRINT" onClick="cetak();" style=" cursor:pointer; position:absolute; left:690px; top:116px; width:52px; height:18px; z-index:1; background-color: #CCCCCC; layer-background-color: #CCCCCC; border: 1px none #000000;" class="noPrint"> 
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
          <td colspan="4" align="center">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="4" align="center">&nbsp;</td>
        </tr>
        <tr> 
          <td width="400%" colspan="4" align="center"><font size="3">BERITA ACARA 
            UJIAN TUGAS AKHIR</font></td>
        </tr>
        <tr> 
          <td colspan="4" align="center"></td>
        </tr>
        <tr> 
          <td colspan="4" align="center"> </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="100%"  border="0" align="right" cellpadding="0" cellspacing="0">
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td><table width="98%"  border="0" align="center" cellpadding="2" cellspacing="0">
              <tr> 
                <td width="13%">Nama</td>
                <td width="1%"><strong>:</strong></td>
                <td width="86%"><? echo $frm_nama;?></td>
              </tr>
              <tr> 
                <td>NRP</td>
                <td><strong>:</strong></td>
                <td><? echo $frm_nrp;?></td>
              </tr>
              <tr> 
                <td nowrap>Judul Tugas Akhir </td>
                <td><strong>:</strong></td>
                <td rowspan="3" valign="top"><? echo $frm_judul_LP;?></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td>Tanggal Ujian </td>
                <td><strong>:</strong></td>
                <td><? echo $frm_tgl_uji_TA;?></td>
              </tr>
              <tr> 
                <td>Ruang Ujian </td>
                <td><strong>:</strong></td>
                <td><? echo $frm_ruang;?></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td><table width="100%"  border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#000000">
              <tr> 
                <td width="18%" rowspan="2"><div align="center">NILAI UJIAN <br>
                    TUGAS AKHIR </div></td>
                <td width="26%" nowrap><div align="center">Jumlah Nilai Mentah 
                  </div></td>
                <td width="27%" nowrap><div align="center">Rata-rata Nilai Mentah</div></td>
                <td width="29%" nowrap><div align="center">Nilai Akhir </div></td>
              </tr>
              <tr> 
                <td><table width="100%"  border="0" cellspacing="0" cellpadding="5">
                    <tr> 
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
                <td><table width="100%"  border="0" cellspacing="0" cellpadding="5">
                    <tr> 
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
                <td><table width="100%"  border="0" cellspacing="0" cellpadding="5">
                    <tr> 
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            <br> <table width="100%"  border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#000000">
              <tr> 
                <td width="18%"><div align="center">HASIL UJIAN </div></td>
                <td width="82%"><table width="100%"  border="0" cellspacing="0" cellpadding="5">
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
          <td><table width="100%"  border="0" align="center" cellpadding="2" cellspacing="0">
              <tr> 
                <td width="14%" nowrap>Panitia Penguji </td>
                <td width="1%"><strong>:</strong></td>
                <td width="85%">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td><table width="100%"  border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#000000">
              <tr> 
                <td width="49%">&nbsp;Ketua,</td>
                <td width="51%">&nbsp;Sekretaris,</td>
              </tr>
              <tr> 
                <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td height="60">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td align="center" nowrap><? echo $var_nama_ketua;?></td>
                    </tr>
                  </table></td>
                <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td height="60">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td align="center" nowrap><? echo $var_nama_sekre;?></td>
                    </tr>
                  </table></td>
              </tr>
              <tr> 
                <td>&nbsp;Anggota,</td>
                <td>&nbsp;Anggota,</td>
              </tr>
              <tr> 
                <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td height="60">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td align="center" nowrap><? echo $var_nama_anggota_1;?></td>
                    </tr>
                  </table></td>
                <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td height="60">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td align="center" nowrap><? echo $var_nama_anggota_2;?></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><table width="100%"  border="0" align="center" cellpadding="2" cellspacing="0">
        <tr> 
          <td width="62%"><table width="100%"  border="0" align="right" cellpadding="0" cellspacing="0">
              <tr> 
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td>Mahasiswa yang diuji, </td>
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
                <td nowrap>(<u><? echo $frm_nama;?>)</u></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
              </tr>
            </table></td>
          <td width="38%"><table width="100%"  border="0" align="right" cellpadding="0" cellspacing="0">
              <tr> 
                <td> 
                  <? 
			  //echo "<br>frm_tgl_uji_TA=".$frm_tgl_uji_TA;
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
				/*$
				  Bulan=date('F');
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
					*/
				$date = "Surabaya, ".$tgl_TA." ".$bln_TA_nama." ".$thn_TA;
				echo $date;
			 ?>
                </td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td>Wakil Dekan,</td>
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
                  <? $sql_wadek="SELECT nama FROM jabatan_struktural WHERE jabatan='Wakil Dekan'";
			   $result_wadek = mysql_query($sql_wadek);
			  if ($row_wadek = mysql_fetch_array($result_wadek)) {
			  	echo "(<u>".$row_wadek["nama"]."</u>)";
			  }
			?>
                </td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
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
    <td><table width="50%"  border="0" cellspacing="0" cellpadding="2">
        <tr> 
          <td width="5%">&nbsp;</td>
          <td width="95%"><table width="60%"  border="1" cellpadding="2" cellspacing="0" bordercolor="#000000">
              <tr> 
                <td><div align="center" class="style3">KELOMPOK</div></td>
                <td><div align="center" class="style3">NA</div></td>
                <td><div align="center" class="style3">NILAI MENTAH </div></td>
              </tr>
              <tr> 
                <td><table width="100%"  border="0" cellspacing="0" cellpadding="3">
                    <tr> 
                      <td class="style3">Istimewa</td>
                    </tr>
                    <tr> 
                      <td class="style3">Amat Baik </td>
                    </tr>
                    <tr> 
                      <td class="style3">Baik</td>
                    </tr>
                    <tr> 
                      <td nowrap class="style3">Cukup Baik </td>
                    </tr>
                    <tr> 
                      <td class="style3">Sedang</td>
                    </tr>
                    <tr> 
                      <td class="style3">Tidak Lulus </td>
                    </tr>
                  </table></td>
                <td><table width="100%"  border="0" cellspacing="0" cellpadding="3">
                    <tr> 
                      <td class="style3"><div align="center">A</div></td>
                    </tr>
                    <tr> 
                      <td class="style3"><div align="center">AB</div></td>
                    </tr>
                    <tr> 
                      <td class="style3"><div align="center">B</div></td>
                    </tr>
                    <tr> 
                      <td nowrap class="style3"><div align="center">BC</div></td>
                    </tr>
                    <tr> 
                      <td class="style3"><div align="center">C</div></td>
                    </tr>
                    <tr> 
                      <td class="style3"><div align="center"></div></td>
                    </tr>
                  </table></td>
                <td><table width="100%"  border="0" cellspacing="0" cellpadding="3">
                    <tr> 
                      <td class="style3">NM &gt;= 81</td>
                    </tr>
                    <tr> 
                      <td nowrap class="style3">73 &lt;= NM &lt; 81</td>
                    </tr>
                    <tr> 
                      <td class="style3">66 &lt;= NM &lt; 73</td>
                    </tr>
                    <tr> 
                      <td nowrap class="style3">60 &lt;= NM &lt; 66</td>
                    </tr>
                    <tr> 
                      <td class="style3">55 &lt;= NM &lt; 60</td>
                    </tr>
                    <tr> 
                      <td class="style3">NM &lt; 55</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
