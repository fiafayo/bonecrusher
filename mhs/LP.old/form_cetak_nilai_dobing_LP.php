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
					daftar_uji_lp.`PEMBIMBING_1`,
					daftar_uji_lp.`PEMBIMBING_2`,
					daftar_uji_lp.`PENGUJI_1`,
					daftar_uji_lp.`PENGUJI_2`,
					master_lp.`JUDUL1`
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
								$frm_kodobing_1 = $row["PEMBIMBING_1"];
								$frm_kodobing_2 = $row["PEMBIMBING_2"];
								$frm_kodoji_1 = $row["PENGUJI_1"];
								$frm_kodoji_2 = $row["PENGUJI_2"];
								
								$frm_tgl_uji_LP =$row["TGL_UJI"];
								if ($row["TGL_UJI"]=="00/00/0000") {
								$frm_tgl_uji_LP = ""; }else {
								$frm_tgl_uji_LP = $row["TGL_UJI"];}
								
							}else
							{$frm_exist=0;// header("Location: mhs_perpanjangan_ta.php"); 
							}
							
							if ($frm_kodoji_1!='') {
								$result = mysql_query("Select nama from dosen where kode='$frm_kodoji_1'");
								$row = mysql_fetch_array($result);
								$var_nama_doji_1 = $row["nama"];
							}	
							
							if ($frm_kodoji_2!='') {
								$result = mysql_query("Select nama from dosen where kode='$frm_kodoji_2'");
								$row = mysql_fetch_array($result);
								$var_nama_doji_2 = $row["nama"];
							}	
							
							if ($frm_kodobing_1!='') {
								$result = mysql_query("Select nama from dosen where kode='$frm_kodobing_1'");
								$row = mysql_fetch_array($result);
								$var_nama_dobing_1 = $row["nama"];
							}	
							
							if ($frm_kodobing_2!='') {
								$result = mysql_query("Select nama from dosen where kode='$frm_kodobing_2'");
								$row = mysql_fetch_array($result);
								$var_nama_dobing_2 = $row["nama"];
							}
?>
<table width="1500"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="4"><strong>FAKULTAS TEKNIK - UNIVESITAS SURABAYA<br>
          JURUSAN TEKNIK KIMIA </strong></td>
      </tr>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td width="400%" colspan="4" align="center">HASIL AKHIR NILAI  PENELITIAN MAHASISWA</td>
        </tr>
      <tr>
        <td colspan="4" align="center"><table width="100%"  border="1" cellspacing="0" cellpadding="5">
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
        <td><table width="100%"  border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td width="8%" nowrap>JUDUL PENELITIAN </td>
            <td width="1%"><strong>:</strong></td>
            <td width="91%" rowspan="2" valign="top"><? echo $frm_judul_LP;?></td>
          </tr>
          <tr>
            <td nowrap>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%"  border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td width="18%"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="8%">NAMA</td>
                <td width="2%"><strong>:</strong></td>
                <td width="90%"><? echo $frm_nama;?></td>
              </tr>
            </table></td>
            <td width="82%"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="2%">NRP</td>
                <td width="1%"><strong>:</strong></td>
                <td width="97%"><? echo $frm_nrp;?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%"  border="1" cellspacing="0" cellpadding="3">
          <tr>
            <td width="2%" rowspan="3"><div align="center" >NO</div></td>
            <td width="17%" rowspan="3"><div align="center" >ITEM PENELITIAN </div></td>
            <td colspan="3"><div align="center" >NILAI</div></td>
            <td width="6%" rowspan="2"><div align="center" >PROSENTASE</div></td>
            <td width="8%" rowspan="2"><div align="center" >PERBANDINGAN NILAI <br>
              BERTURUT-TURUT </div></td>
            <td width="5%" rowspan="2"><div align="center" >NILAI MENTAH </div></td>
          </tr>
          <tr>
            <td width="28%"><div align="center" >PEMBIMBING</div></td>
            <td colspan="2"><div align="center" >PENGUJI</div></td>
            </tr>
          <tr>
            <td nowrap><div align="center"><? echo $var_nama_dobing_1;?>
                <? if ($var_nama_dobing_2<>'') echo " +<br> ".$var_nama_dobing_2;?>
            </div></td>
            <td width="17%" nowrap><div align="center"><? echo $var_nama_doji_1;?></div></td>
            <td width="17%" nowrap><div align="center"><? echo $var_nama_doji_2;?></div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div align="center">1.</div></td>
            <td><span>Materi (mudah=66|sedang=74|sulit=82) </span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="center">5%</div></td>
            <td><div align="center">1:1:1</div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div align="center">2.</div></td>
            <td><span>Percobaan di Laboratorium </span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="center">10%</div></td>
            <td><div align="center">3:1:1</div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div align="center">3.</div></td>
            <td><span>Penguasaan konsep pada landasan teori</span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="center">35%</div></td>
            <td><div align="center">3:1:1</div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div align="center">4.</div></td>
            <td nowrap><span>Penggunaan Tools TK(ada=80 | tidak=60) </span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="center">5%</div></td>
            <td><div align="center">1:1:1</div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div align="center">5.</div></td>
            <td><span>Kemandirian mahasiswa dalam Penelitian </span></td>
            <td>&nbsp;</td>
            <td bgcolor="#CCCCCC">&nbsp;</td>
            <td bgcolor="#CCCCCC">&nbsp;</td>
            <td><div align="center">5%</div></td>
            <td><div align="center">1:0:0</div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div align="center">6.</div></td>
            <td><span>Laporan (bahasa, sistematika) </span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="center">10%</div></td>
            <td><div align="center">1:1:1</div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div align="center">7.</div></td>
            <td><span>Presentasi</span></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="center">5%</div></td>
            <td><div align="center">1:1:1</div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="33"><div align="center">8.</div></td>
            <td><span>Tanya Jawab </span></td>
            <td bgcolor="#CCCCCC">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="center">25%</div></td>
            <td><div align="center">0:1:1</div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="6" rowspan="2">&nbsp;</td>
            <td><span>Total (NM)</span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span>Nilai Akhir </span></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="60%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>Tools teknik kimia ada, jika : </td>
          </tr>
          <tr>
            <td>Pengolahan data menggunakan dasar-dasar statistik, </td>
          </tr>
          <tr>
            <td>Penyelesaian persamaan menggunakan spreadsheet, Mathcad, Matlab, Environpro, dsb </td>
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
        <td width="4%" nowrap>Catatan</td>
        <td width="1%"><strong>:</strong></td>
        <td width="95%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="1%">&nbsp;</td>
        <td width="28%"><table width="60%"  border="1" cellspacing="0" cellpadding="5">
          <tr>
            <td nowrap><div align="center">KELOMPOK</div></td>
            <td nowrap><div align="center">NA</div></td>
            <td nowrap><div align="center">NILAI MENTAH </div></td>
          </tr>
          <tr>
            <td><table width="100%"  border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td>Istimewa</td>
                </tr>
                <tr>
                  <td>Amat Baik </td>
                </tr>
                <tr>
                  <td>Baik</td>
                </tr>
                <tr>
                  <td nowrap>Cukup Baik </td>
                </tr>
                <tr>
                  <td>Sedang</td>
                </tr>
                <tr>
                  <td>Tidak Lulus </td>
                </tr>
            </table></td>
            <td><table width="100%"  border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td><div align="center">A</div></td>
                </tr>
                <tr>
                  <td nowrap><div align="center">AB</div></td>
                </tr>
                <tr>
                  <td><div align="center">B</div></td>
                </tr>
                <tr>
                  <td><div align="center">BC</div></td>
                </tr>
                <tr>
                  <td><div align="center">C</div></td>
                </tr>
                <tr>
                  <td><div align="center">-</div></td>
                </tr>
            </table></td>
            <td><table width="100%"  border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td nowrap><div align="center"> NM &gt;= 81</div></td>
                </tr>
                <tr>
                  <td><div align="center">73 &lt;= NM  &lt; 81</div></td>
                </tr>
                <tr>
                  <td nowrap><div align="center">66 &lt;= NM &lt; 73</div></td>
                </tr>
                <tr>
                  <td><div align="center">60 &lt;= NM  &lt; 66</div></td>
                </tr>
                <tr>
                  <td><div align="center">55 &lt;= NM  &lt; 60</div></td>
                </tr>
                <tr>
                  <td><div align="center">NM &lt; 55</div></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="24%">&nbsp;</td>
        <td width="47%" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td width="49%">Surabaya, </td>
            <td width="9%">&nbsp;</td>
            <td width="42%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Pembimbing 1 </td>
            <td>&nbsp;</td>
            <td>Pembimbing 2 </td>
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
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span ><? echo $var_nama_dobing_1;?></span></td>
            <td>&nbsp;</td>
            <td><span ><? echo $var_nama_dobing_2;?></span></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>          <input type="submit" name="Submit" value="PRINT" onClick="cetak();" style=" cursor:pointer; position:absolute; left:604px; top:32px; width:52px; height:18px; z-index:1; background-color: #CCCCCC; layer-background-color: #CCCCCC; border: 1px none #000000;" class="noPrint">
</td>
  </tr>
</table>
</body>
</html>