<? 
session_start();
include("../../include/js_function.js");
require("../../include/global.php");
require("../../include/fungsi.php");
?>
<html>
<head>
<title>: : CETAK BERITA ACARA PENELITIAN : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style4 {font-size: 10px}
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
/*echo "<br>var_NRP=".$var_NRP;
echo "<br>var_periode=".$var_periode;
echo "<br>var_thn_ajar=".$var_thn_ajar;*/

$sql_berita="SELECT master_mhs.NRP,
					master_mhs.NAMA,
					DATE_FORMAT(`daftar_uji_lp`.`TGLUJI`,'%d/%m/%Y') as TGL_UJI,
					daftar_uji_lp.`RUANG`,
					master_lp.`JUDUL1`,
					master_lp.`KODOS1`,
					master_lp.`KODOS2`, 
					daftar_uji_lp.PENGUJI_1,
					daftar_uji_lp.PENGUJI_2
			  FROM  master_mhs, master_lp, daftar_uji_lp 
			  WHERE master_mhs.NRP =  master_lp.NRP AND
					master_mhs.NRP =  daftar_uji_lp.NRP AND
				    master_mhs.NRP = '".$var_NRP."'";
			  
$result = mysql_query($sql_berita);
							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_nrp = $row["NRP"];
								$frm_nama = $row["NAMA"];
								$frm_ruang = $row["RUANG"];
								$frm_judul_LP = $row["JUDUL1"];
								$frm_kodos_1 = $row["KODOS1"];
								$frm_kodos_2 = $row["KODOS2"];
								$frm_kodos_UJI1 = $row["PENGUJI_1"];
								$frm_kodos_UJI2 = $row["PENGUJI_2"];
								
								$frm_tgl_uji_LP =$row["TGL_UJI"];
								if ($row["TGL_UJI"]=="00/00/0000") {
								$frm_tgl_uji_LP = ""; }else {
								$frm_tgl_uji_LP = $row["TGL_UJI"];}
								
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
							
							if ($frm_kodos_UJI1!='') {
								$result = mysql_query("Select nama from dosen where kode='$frm_kodos_UJI1'");
								$row = mysql_fetch_array($result);
								$var_nama_doji_1 = $row["nama"];
							}	
							
							if ($frm_kodos_UJI2!='') {
								$result = mysql_query("Select nama from dosen where kode='$frm_kodos_UJI2'");
								$row = mysql_fetch_array($result);
								$var_nama_doji_2 = $row["nama"];
							}	
?>
<table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">          <input type="submit" name="Submit" value="PRINT" onClick="cetak();" style=" cursor:pointer; position:absolute; left:604px; top:32px; width:52px; height:18px; z-index:1; background-color: #CCCCCC; layer-background-color: #CCCCCC; border: 1px none #000000;" class="noPrint">
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
        <td width="400%" colspan="4" align="center"><font size="3">BERITA ACARA UJIAN PENELITIAN</font></td>
        </tr>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center"><table width="95%"  border="1" cellspacing="0" cellpadding="5">
          <tr>
            <td>
			<? 	$result = mysql_query("Select * from tahun_ajar where id='$var_thn_ajar'");
				$row = mysql_fetch_array($result);
			?>
			<table width="100%"  border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="32%">PERIODE : <? echo $var_periode;?></td>
                <td width="32%"><div align="center">SEMESTER : <? echo $row["semester"];?></div></td>
                <td width="36%" nowrap><div align="right">TAHUN AKADEMIK : <? echo $row['tahun_ajaran'];?> / <? echo $row['tahun_ajaran']+1;?></div></td>
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
            <td width="16%">Nama</td>
            <td width="1%"><strong>:</strong></td>
            <td width="80%" nowrap><? echo $frm_nama;?></td>
          </tr>
          <tr>
            <td>NRP</td>
            <td><strong>:</strong></td>
            <td><? echo $frm_nrp;?></td>
          </tr>
          <tr>
            <td>Judul Penelitian </td>
            <td><strong>:</strong></td>
            <td rowspan="2" valign="top"><? echo $frm_judul_LP;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td nowrap>Nama Pembimbing </td>
            <td><strong>:</strong></td>
            <td>1. <? echo $frm_kodos_1." - ".$var_nama_dobing_1;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>2.  <? echo $frm_kodos_2." - ".$var_nama_dobing_2;?></td>
          </tr>
          <tr>
            <td>Tanggal Ujian </td>
            <td><strong>:</strong></td>
            <td><? echo $frm_tgl_uji_LP;?></td>
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
        <td><table width="95%"  border="1" align="center" cellpadding="5" cellspacing="0">
          <tr>
            <td width="26%" rowspan="2"><div align="center">NILAI UJIAN </div></td>
            <td width="36%"><div align="center">Nilai Mentah (NM) </div></td>
            <td width="38%"><div align="center">Nilai Akhir (NA) </div></td>
          </tr>
          <tr>
            <td><table width="100%"  border="0" cellspacing="0" cellpadding="15">
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td><table width="100%"  border="0" cellspacing="0" cellpadding="15">
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><div align="center">HASIL UJIAN </div></td>
            <td><table width="100%"  border="0" cellspacing="0" cellpadding="20">
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td><table width="100%"  border="0" cellspacing="0" cellpadding="15">
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
        <td><table width="95%"  border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
            <td width="12%" nowrap>Panitia Penguji </td>
            <td width="1%"><strong>:</strong></td>
            <td width="87%">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="95%"  border="1" align="center" cellpadding="2" cellspacing="0">
          <tr>
            <td>&nbsp;Ketua,</td>
            <td>&nbsp;Anggota,</td>
          </tr>
          <tr>
            <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th height="60" scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th scope="col"><? echo $var_nama_dobing_1;?></th>
              </tr>
            </table></td>
            <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th height="60" scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th scope="col"><? echo $var_nama_dobing_2;?></th>
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
                <th height="60" scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th scope="col"><? echo $var_nama_doji_1;?></th>
              </tr>
            </table></td>
            <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th height="60" scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th scope="col"><? echo $var_nama_doji_2;?></th>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="95%"  border="0" align="center" cellpadding="2" cellspacing="0">
      <tr>
        <td width="51%"><table width="100%"  border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Mahasiswa yang diuji,</td>
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
            <td><? echo $frm_nama;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        <td width="49%"><table width="100%"  border="0" align="right" cellpadding="0" cellspacing="0">
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
				
			$date = "Surabaya, ".date('d')." ".$Bulan." ".date('Y');
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
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td nowrap> 
				<? 
					$sql_wadek="SELECT nama FROM jabatan_struktural WHERE jabatan='Wakil Dekan'";
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
    <td><table width="90%"  border="0" align="center" cellpadding="2" cellspacing="0">
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
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
