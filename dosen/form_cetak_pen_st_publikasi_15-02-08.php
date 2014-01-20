<? session_start();?>
<html>
<head>
<title>: : CETAK SURAT TUGAS PUBLIKASI : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
 
<style type="text/css">
<!--
.style1 {font-size: 9px}
-->
</style>
</head>
<body>
<div id="contentarea">
<script language="JavaScript" src="../include/js_function.js">
</script>
<? 
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);
	
$var_no_stp = $_GET['no_stp'];

$result = mysql_query("SELECT   master_karyawan.kode,
							    master_karyawan.nama,
                                publikasi.no_st_pub,
								publikasi.urut_st_pub,
								publikasi.jenis,
								publikasi.kode_kary,
								publikasi.kode_kary2,
								publikasi.kode_kary3,
								publikasi.kode_kary4,
								publikasi.kode_kary5,
								publikasi.golongan,
								publikasi.`status`,
								publikasi.jabatan_struktural,
								publikasi.jabatan_fungsional,
								publikasi.TET_sub,
								publikasi.TNET_sub,
								publikasi.tugas,
								publikasi.hari_go,
								publikasi.tgl_go,
								publikasi.pukul_go,
								publikasi.tempat_go,
								publikasi.transport_go,
								publikasi.hari_dtg,
								publikasi.tgl_dtg,
								publikasi.pukul_dtg,
								publikasi.transport_dtg,
								publikasi.biaya,
								publikasi.L_ap_tax,
								publikasi.L_fiskal,
								publikasi.L_visa,
								publikasi.L_saku,
								publikasi.L_akomo,
								publikasi.L_other,
								publikasi.ndt_terakhir
    				      FROM publikasi, master_karyawan 
					     WHERE publikasi.kode_kary=master_karyawan.kode and
					   		   no_st_pub='".$var_no_stp."'");
								
							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$var_kode_kary_1 = $row["kode_kary"];
								$var_golongan = $row["golongan"];
								$var_status = $row["status"];
								
								$var_jab_struktural = $row["jabatan_struktural"];
								$var_jab_fungsional = $row["jabatan_fungsional"];
								$var_TET_sub = $row["TET_sub"];
								$var_TNET_sub = $row["TNET_sub"];
								$var_tugas = $row["tugas"];
								
								$var_tgl_go = $row["tgl_go"];
								if ($row["tgl_go"]=="00/00/0000") {
								$var_tgl_go = ""; }else {
								$var_tgl_go = $row["tgl_go"];}
								
								$var_hari_go = $row["hari_go"];
								$var_pukul_go = $row["pukul_go"];
								$var_tempat_go = $row["tempat_go"];
								$var_transport_go = $row["transport_go"];
								
								$var_tgl_dtg = $row["tgl_dtg"];
								if ($row["tgl_dtg"]=="00/00/0000") {
								$var_tgl_dtg = ""; }else {
								$var_tgl_dtg = $row["tgl_dtg"];}
								
								$var_hari_dtg = $row["hari_dtg"];
								$var_pukul_dtg = $row["pukul_dtg"];
								$var_transport_dtg = $row["transport_dtg"];
								
								$chk_airport = $row["L_ap_tax"];
								$chk_fiskal = $row["L_fiskal"];
								$chk_visa = $row["L_visa"];
								$chk_uang_saku = $row["L_saku"];
								$chk_akomodasi = $row["L_akomo"];
								$var_frm_lainnya = $row["L_other"];
								$frm_biaya = $row["biaya"]; 
							    $frm_ndt = $row["ndt_terakhir"];
								
							}else
							{$frm_exist=0;// header("Location: mhs_perpanjangan_ta.php"); 
							}
							
							if ($var_kode_kary_1!='') {
								$result = mysql_query("SELECT kode, nama, npk FROM dosen WHERE kode='$var_kode_kary_1'");
								$row = mysql_fetch_array($result);
								$var_nip_kary_1 = $row["npk"];
								$var_nama_kary_1 = $row["nama"];
							}	
							
							/*if ($var_kodobing_2!='') {
								$result = mysql_query("Select nip, nama from master_karyawan where kode='$var_kodobing_2'");
								$row = mysql_fetch_array($result);
								$var_nip_dobing_2 = $row["nip"];
								$var_nama_dobing_2 = $row["nama"];
							}	*/
?>
<table width="80%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1600%" colspan="4" align="center"><font size="+1"><b>FORM USULAN SURAT TUGAS <br>
          NON DEGREE TRAINING</b></font></td>
      </tr>
      <tr>
        <td colspan="4" align="center">(SEMINAR, KONFERENSI, WORKSHOP, dll sejenis)</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%"  border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="85%"  border="0" align="center" cellpadding="10" cellspacing="0">
          <tr>
            <td colspan="4"><table width="100%"  border="0" cellspacing="0" cellpadding="5">
                <tr>
                  <td width="3%">1.</td>
                  <td colspan="4">Yang ditugaskan </td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td width="3%">a.</td>
                  <td width="31%">Nama</td>
                  <td width="2%"><div align="center"><strong>:</strong></div></td>
                  <td width="61%"><? echo $var_kode_kary_1." - ".$var_nama_kary_1;?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>b.</td>
                  <td>Unit kerja</td>
                  <td><div align="center"><strong>:</strong></div></td>
                  <td>
				  <? 
					//$jurusan = substr($var_nrp, 3,1); 
					$sql_jur = "SELECT jurusan as nama_jurusan FROM jurusan WHERE id='$var_TET_sub'";
					$result_jur=mysql_query($sql_jur);
					if ($row = mysql_fetch_array($result_jur)) {
					echo $row["nama_jurusan"];
					}
				  ?>
				  </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>c.</td>
                  <td>Jabatan struktural</td>
                  <td><div align="center"><strong>:</strong></div></td>
                  <td>
				  <? 
					$sql_jur = "SELECT jabatan as nama_jabatan FROM jabatan_struktural WHERE id='$var_jab_struktural'";
					$result_jur=mysql_query($sql_jur);
					if ($row = mysql_fetch_array($result_jur)) {
					echo $row["nama_jabatan"];
					}
				  ?>
				  </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>d.</td>
                  <td nowrap>Jabatan Fungsional/Akademik</td>
                  <td><div align="center"><strong>:</strong></div></td>
                  <td>
				  <? 
					$sql_jab_ak = "SELECT jab_akademik FROM dosen WHERE kode='$var_kode_kary_1'";
					$result_jab_ak=mysql_query($sql_jab_ak);
					if ($row = mysql_fetch_array($result_jab_ak)) {
					echo $row["jab_akademik"];
					}
				  ?>
				  </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td nowrap>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                          </table>              </td>
            </tr>
          <tr>
            <td colspan="4"><table width="100%"  border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="3%">2.</td>
                <td colspan="2">Tugas / Keperluan </td>
                <td width="2%"><div align="center"><strong>:</strong></div></td>
                <td width="61%"><? echo $var_tugas;?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td width="3%">&nbsp;</td>
                <td width="31%" nowrap>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td nowrap>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="4" nowrap><table width="100%"  border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="3%">3.</td>
                <td colspan="2">Tempat</td>
                <td width="2%"><div align="center"><strong>:</strong></div></td>
                <td width="61%"><? echo $var_tempat_go;?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td width="3%">&nbsp;</td>
                <td width="31%" nowrap>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td colspan="4" nowrap><table width="100%"  border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="3%">4.</td>
                <td colspan="2">Status</td>
                <td width="2%"><div align="center"><strong>:</strong></div></td>
                <td width="61%"><table width="100%"  border="0" cellspacing="0" cellpadding="3">
                  <tr>
                    <td width="5%"><input name="rb_peserta" id="rb_peserta" type="radio" value="radiobutton" <? if ($var_status=="Peserta") echo "checked";?>></td>
                    <td width="46%">Peserta</td>
                    <td width="5%"><input name="rb_penyaji" id="rb_penyaji" type="radio" value="radiobutton" <? if ($var_status=="Penyaji") echo "checked";?>></td>
                    <td width="44%">Penyaji</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td width="3%">&nbsp;</td>
                <td width="31%" nowrap>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td colspan="4" nowrap><table width="100%"  border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="3%">5.</td>
                <td colspan="2">Jadwal Pelaksanaan</td>
                <td width="2%"><div align="center"><strong>:</strong></div></td>
                <td width="61%">&nbsp;<? echo $var_tgl_go;?>&nbsp; s/d &nbsp; <? echo $var_tgl_dtg;?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td width="3%">a</td>
                <td width="31%" nowrap>Hari/Tanggal/Jam berangkat </td>
                <td><div align="center"><strong>:</strong></div></td>
                <td><? echo $var_hari_go.", ".$var_tgl_go.", ".$var_pukul_go;?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>b</td>
                <td nowrap>Hari/Tanggal/Jam kembali </td>
                <td><div align="center"><strong>:</strong></div></td>
                <td><? echo $var_hari_dtg.", ".$var_tgl_dtg.", ".$var_pukul_dtg;?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td nowrap>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td colspan="4" nowrap><table width="100%"  border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="3%">6.</td>
                <td colspan="4">Pembiayaan yang diperlukan (berikan tanda cek pada kotak/lengkapi isian yang tersedia) </td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td width="3%">a.</td>
                <td width="31%" nowrap>Biaya program (Rp/US $) </td>
                <td width="2%"><div align="center"><strong>:</strong></div></td>
                <td width="61%"><? echo $frm_biaya;?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td valign="top">b.</td>
                <td valign="top" nowrap>Transportasi</td>
                <td valign="top"><div align="center"><strong>:</strong></div></td>
                <td><table width="100%"  border="0" cellspacing="0" cellpadding="5">
                  <tr>
                    <td><input name="radiobutton" type="radio" value="radiobutton" <? if ($var_transport_go=="Pesawat") echo "checked";?>></td>
                    <td>Pesawat</td>
                    <td><input name="radiobutton" type="radio" value="radiobutton" <? if ($var_transport_go=="Kereta Api") echo "checked";?>></td>
                    <td nowrap>Kereta Api </td>
                    <td><input name="radiobutton" type="radio" value="radiobutton" <? if ($var_transport_go=="Mobil Dinas") echo "checked";?>></td>
                    <td nowrap>Mobil Dinas </td>
                  </tr>
                  <tr>
                    <td><input name="radiobutton" type="radio" value="radiobutton" <? if ($var_transport_go=="Kendaraan Pribadi") echo "checked";?>></td>
                    <td nowrap>Kendaraan Pribadi </td>
                    <td><input name="radiobutton" type="radio" value="radiobutton" <? if ($var_transport_go=="Penyaji") echo "checked";?>></td>
                    <td colspan="3">Lainnya:................</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td nowrap>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td valign="top">c.</td>
                <td valign="top" nowrap>Lain - lain </td>
                <td valign="top"><strong>:</strong></td>
                <td><table width="100%"  border="0" cellspacing="0" cellpadding="5">
                  <tr>
                    <td width="8%" valign="top"><input type="checkbox" name="chk_airport" id="chk_airport" <? if ($chk_airport==1) echo "checked";?> disabled></td>
                    <td width="31%" valign="top">Airport tax </td>
                    <td width="7%" valign="top"><input type="checkbox" name="chk_fiskal" id="chk_fiskal" <? if ($chk_fiskal==1) echo "checked";?> disabled></td>
                    <td width="54%" valign="top">Fiskal Luar Negeri </td>
                    </tr>
                  <tr>
                    <td valign="top"><input type="checkbox" name="chk_visa" id="chk_visa" <? if ($chk_visa==1) echo "checked";?> disabled></td>
                    <td valign="top">Visa</td>
                    <td valign="top"><input type="checkbox" name="chk_uang_saku" id="chk_uang_saku" <? if ($chk_uang_saku==1) echo "checked";?> disabled></td>
                    <td valign="top">Uang Saku (biaya hidup) </td>
                    </tr>
                  <tr>
                    <td valign="top"><input type="checkbox" name="chk_akomodasi" id="chk_akomodasi" <? if ($chk_akomodasi==1) echo "checked";?> disabled></td>
                    <td valign="top">Akomodasi</td>
                    <td valign="top"><input type="checkbox" name="chk_lainnya" <? if (isset($var_frm_lainnya)) echo "checked";?> disabled></td>
                    <td valign="top"><? echo $var_frm_lainnya;?></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td nowrap>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td nowrap>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td colspan="4" nowrap><table width="100%"  border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="3%">7.</td>
                <td colspan="2">Non degre training terakhir </td>
                <td width="2%"><div align="center"><strong>:</strong></div></td>
                <td width="61%"><? echo $frm_ndt;?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td width="3%">&nbsp;</td>
                <td width="31%" nowrap>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="66%">&nbsp;</td>
        <td width="34%" nowrap><? 
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
		 ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Menyetujui,</td>
        <td>Yang ditugaskan </td>
      </tr>
      <tr>
        <td>Pimpinan Unit Kerja </td>
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td>(..............................................)</td>
        <td nowrap>(..............................................)</td>
      </tr>
      <tr>
        <td><span class="style1">Tandatangan, Nama Terang &amp; Stempel Unit </span></td>
        <td><span class="style1">Tandatangan, Nama Terang</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="95%"  border="1" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td><table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2"><span class="style1"><u>Kelengkapan usulan surat tugas</u> : </span></td>
            </tr>
          <tr>
            <td width="3%"><span class="style1">a.</span></td>
            <td width="97%" nowrap><span class="style1">Usulan dibuat oleh YBS dengan persetujuan pimpinan unit kerja dan usulan dikirim langsung ke Biro ADPESDAM dilengkapi dokumen pendukung. </span></td>
            </tr>
          <tr>
            <td><span class="style1">b.</span></td>
            <td><span class="style1">Usulan surat tugas paling lambat disampaikan ke Universitas (Biro ADPESDAM) 5 (lima) hari sebelum hari H (keberangkatan). </span></td>
            </tr>
          <tr>
            <td><span class="style1">c.</span></td>
            <td><span class="style1">Usulan surat tugas yang kadaluwarsa tidak akan dilayani. </span></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="95%"  border="1" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td><table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="100%" colspan="2"><b>Catatan Biro ADPESDAM :</b> </td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
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
  <tr>
    <td>
		  <form>
		 	 <input type='button' onclick='javascript:window.print();' name="button" value="PRINT">
		  </form>
	</td>
  </tr>
</table>
</div>
</body>
</html>
