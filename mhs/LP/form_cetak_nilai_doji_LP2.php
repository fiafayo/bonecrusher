<? 
session_start();
include("../../include/js_function.js");
require("../../include/global.php");
require("../../include/fungsi.php");
?>
<html>
<head>
<title>: : CETAK NILAI DOSEN PENGUJI 2 : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {font-size: 10px}
.style3 {font-size: 10px; font-weight: bold; }
.style5 {font-size: 9}
.style6 {font-size: 10}
-->
</style>
</head>
<body>
<? 
f_connecting();
	mysql_select_db($DB);
	
//$var_NRP=$_GET['nrp'];
$var_no_ST=$_GET['no_st'];
$var_periode=$_GET['periode'];
$var_thn_ajar=$_GET['thn_ajar'];
 
$sql_nilai_doji_2="SELECT DATE_FORMAT(`daftar_uji_lp`.`TGLUJI`,'%d/%m/%Y') as TGL_UJI,
						  daftar_uji_lp.`RUANG`,
						  daftar_uji_lp.`PEMBIMBING_1`,
						  daftar_uji_lp.`PEMBIMBING_2`,
						  daftar_uji_lp.`PENGUJI_1`,
						  daftar_uji_lp.`PENGUJI_2`,
						  master_lp.`JUDUL1`
				    FROM  master_lp, daftar_uji_lp,no_surat_lp
				    WHERE master_lp.NRP =  daftar_uji_lp.NRP AND
						  master_lp.NRP =  no_surat_lp.NRP AND
						  no_surat_lp.N_ST = '".$var_no_ST."'";
							   
			$result1 = mysql_query($sql_nilai_doji_2);
				if ($row = mysql_fetch_array($result1))
				{
					//$frm_nrp = $row["NRP"];
					//$frm_nama = $row["NAMA"];
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
<table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
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
        <td width="400%" colspan="4" align="center"><font size="3">N I L A I &nbsp;&nbsp;P E N E L I T I A N</font></td>
        </tr>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center"><table width="98%"  border="1" cellspacing="0" cellpadding="5">
          <tr>
            <td>
			<? 	$result2 = mysql_query("Select * from tahun_ajar where id='$var_thn_ajar'");
				$row2 = mysql_fetch_array($result2);
			?>
			<table width="100%"  border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="34%">PERIODE : <? echo $var_periode;?></td>
                <td width="32%"><div align="center">SEMESTER : <? echo $row2["semester"];?></div></td>
                <td width="34%" nowrap><div align="right">TAHUN AKADEMIK : <? echo $row2['tahun_ajaran'];?> / <? echo $row2['tahun_ajaran']+1;?></div></td>
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
        <td><table width="98%"  border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
            <td width="11%" nowrap>Judul Penelitian </td>
            <td width="1%"><strong>:</strong></td>
            <td width="88%" rowspan="2" valign="top"><? echo $frm_judul_LP;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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
        <td><table width="98%"  border="1" align="center" cellpadding="5" cellspacing="0">
          <tr>
            <td width="3%" rowspan="2"><div align="center" class="style1"><strong>NO</strong></div></td>
            <td width="30%" rowspan="2"><div align="center" class="style1"><strong>ITEM PENELITIAN </strong></div></td>
            <td width="33%"><div align="center" class="style1"><strong>NILAI (N)</strong></div></td>
            <td width="34%"><div align="center" class="style1"><strong>NILAI (N)</strong></div></td>
          </tr>
          <tr>
			  <? 
			  $sql_nilai_mhs_doji_2="SELECT  master_mhs.NRP,
			  								 master_mhs.NAMA
										FROM  master_mhs, no_surat_lp
										WHERE master_mhs.NRP =  no_surat_lp.NRP AND
											  no_surat_lp.N_ST = '".$var_no_ST."'";
						  
			 $result3 = mysql_query($sql_nilai_mhs_doji_2);
			  while($row3 = mysql_fetch_array($result3))
				{
				  ?>
				<td><div align="center"><span class="style3"><? echo $row3["NAMA"]."<br>(".$row3["NRP"].")";?>
				</span></div></td>
			<? }?>
            </tr>
          <tr>
            <td><div align="center">1.</div></td>
            <td>Materi (mudah=66|sedang=74|sulit=82) </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td><div align="center">2.</div></td>
            <td>Percobaan di Laboratorium </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td><div align="center">3.</div></td>
            <td>Penguasaan konsep pada landasan teori</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td><div align="center">4.</div></td>
            <td nowrap>Penggunaan Tools TK(ada=80 | tidak=60) </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td><div align="center">5.</div></td>
            <td>Kemandirian mahasiswa dalam Penelitian </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td><div align="center">6.</div></td>
            <td>Laporan (bahasa, sistematika) </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td><div align="center">7.</div></td>
            <td>Presentasi</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td><div align="center">8.</div></td>
            <td>Tanya Jawab </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td colspan="4">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="98%"  border="0" align="center" cellpadding="2" cellspacing="0">
      <tr>
        <td width="6%" nowrap>Catatan</td>
        <td width="1%"><strong>:</strong></td>
        <td width="93%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="1%">&nbsp;</td>
        <td width="43%" valign="top"><table width="60%"  border="1" cellspacing="0" cellpadding="5">
          <tr>
            <td nowrap><div align="center" class="style6">KELOMPOK</div></td>
            <td nowrap><div align="center" class="style6">NA</div></td>
            <td nowrap><div align="center" class="style6">NILAI MENTAH </div></td>
          </tr>
          <tr>
            <td><table width="100%"  border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td class="style6">Istimewa</td>
                </tr>
                <tr>
                  <td class="style6">Amat Baik </td>
                </tr>
                <tr>
                  <td class="style6">Baik</td>
                </tr>
                <tr>
                  <td nowrap class="style6">Cukup Baik </td>
                </tr>
                <tr>
                  <td class="style6">Sedang</td>
                </tr>
                <tr>
                  <td class="style6">Tidak Lulus </td>
                </tr>
            </table></td>
            <td><table width="100%"  border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td class="style6"><div align="center">A</div></td>
                </tr>
                <tr>
                  <td class="style6"><div align="center">AB</div></td>
                </tr>
                <tr>
                  <td class="style6"><div align="center">B</div></td>
                </tr>
                <tr>
                  <td nowrap class="style6"><div align="center">BC</div></td>
                </tr>
                <tr>
                  <td class="style6"><div align="center">C</div></td>
                </tr>
                <tr>
                  <td class="style6"><div align="center">-</div></td>
                </tr>
            </table></td>
            <td><table width="100%"  border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td class="style6">NM &gt;= 81</td>
                </tr>
                <tr>
                  <td class="style6">73 &lt;= NM  &lt; 81</td>
                </tr>
                <tr>
                  <td nowrap class="style6">66 &lt;= NM &lt; 73</td>
                </tr>
                <tr>
                  <td nowrap class="style6">60 &lt;= NM  &lt; 66</td>
                </tr>
                <tr>
                  <td class="style6">55 &lt;= NM  &lt; 60</td>
                </tr>
                <tr>
                  <td class="style6">NM &lt; 55</td>
                </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="16%" valign="top">&nbsp;</td>
        <td width="40%" valign="top"><table width="100%"  border="0" align="right" cellpadding="0" cellspacing="0">
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
			<?
				if ($frm_kodoji_2!='') {
				$result = mysql_query("Select nama from dosen where kode='$frm_kodoji_2'");
				$row = mysql_fetch_array($result);
				$var_nama_doji_2 = $row["nama"];
				echo $var_nama_doji_2;
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
    <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%">&nbsp;</td>
        <td width="99%"><span class="style5">Tools teknik kimia ada, jika : </span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><span class="style5">Pengolahan data menggunakan dasar-dasar perhitungan statistik, </span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><span class="style5">Penyelesaian persamaan menggunakan spreadsheet, Mathcad, Matlab, EnvironPro, dsb </span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>