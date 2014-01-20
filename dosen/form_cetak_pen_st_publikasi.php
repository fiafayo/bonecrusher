<? 
session_start();
//include("../include/js_function.js");
require("../include/global.php");
require("../include/fungsi.php");
?>
<html>
<head>
<title>: : CETAK SURAT TUGAS PUBLIKASI : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/cetak.css" rel="stylesheet" type="text/css" media="print">
<style type="text/css">
.style1 {font-weight: bold}
</style>
<script type="text/javascript">
function cetak() {
  window.print();
  }
</script>
</head>
<body>
<? 
f_connecting();
	mysql_select_db($DB);
	
$var_no_stp = $_GET['no_stp'];

$result = mysql_query("SELECT   dosen.kode,
							    dosen.nama,
								publikasi.no_legalitas,
                                publikasi.no_st_pub,
								publikasi.urut_st_pub,
								publikasi.jenis,
								publikasi.kode_kary,
								publikasi.kode_kary2,
								publikasi.kode_kary3,
								publikasi.kode_kary4,
								publikasi.kode_kary5,
								publikasi.`status`,
								publikasi.TET_sub,
								publikasi.TNET_sub,
								publikasi.tugas,
							    DATE_FORMAT(publikasi.tgl_publikasi,'%d/%m/%Y') as tgl_publikasi,
							    DATE_FORMAT(publikasi.tgl_publikasi2,'%d/%m/%Y') as tgl_publikasi2,
								publikasi.hari_go,
								DATE_FORMAT(publikasi.tgl_go,'%d/%m/%Y') as tgl_go,
								publikasi.pukul_go,
								publikasi.tempat_go,
								publikasi.transport_go,
								publikasi.hari_dtg,
								DATE_FORMAT(publikasi.tgl_dtg,'%d/%m/%Y') as tgl_dtg,
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
    				      FROM publikasi, dosen 
					     WHERE publikasi.kode_kary=dosen.kode AND
					   		   no_st_pub='".$var_no_stp."'");
								
							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$var_no_legalitas = $row["no_legalitas"];
								$var_no_st_pub = $row["no_st_pub"];
								
								$var_kode_kary_1 = $row["kode_kary"];
								$var_kode_kary_2 = $row["kode_kary2"];
								$var_kode_kary_3 = $row["kode_kary3"];
								$var_kode_kary_4 = $row["kode_kary4"];
								$var_kode_kary_5 = $row["kode_kary5"];
								$var_status = $row["status"];
								$var_jenis = $row["jenis"];
								
								$var_TET_sub = $row["TET_sub"];
								$var_TNET_sub = $row["TNET_sub"];
								$var_tugas = $row["tugas"];
								
								$var_tgl_pub_1 = $row["tgl_publikasi"];
								if ($row["tgl_publikasi"]=="00/00/0000") {
								$var_tgl_pub_1 = ""; }else {
								$var_tgl_pub_1 = $row["tgl_publikasi"];}
								
								$var_tgl_pub_2 = $row["tgl_publikasi2"];
								if ($row["tgl_publikasi2"]=="00/00/0000") {
								$var_tgl_pub_2 = ""; }else {
								$var_tgl_pub_2 = $row["tgl_publikasi2"];}
								
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
								$result = mysql_query("Select nip, nama from dosen where kode='$var_kodobing_2'");
								$row = mysql_fetch_array($result);
								$var_nip_dobing_2 = $row["nip"];
								$var_nama_dobing_2 = $row["nama"];
							}	*/
?>
<input type="button" name="Submit" value="PRINT" onClick="cetak();" style=" cursor:pointer; position:absolute; left:786px; top:49px; width:52px; height:18px; z-index:1; background-color: #CCCCCC; layer-background-color: #CCCCCC; border: 1px none #000000;" class="noPrint">
<div id="halamanprint">
<table width="80%"  border="0" align="center" cellpadding="1" cellspacing="0">
  <tr>
    <td>	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%" colspan="4" align="center"><span class="style4">FORM USULAN SURAT TUGAS <br>
          NON DEGREE TRAINING</span></td>
      </tr>
      <tr>
        <td colspan="4" align="center"><span class="style5">(SEMINAR, KONFERENSI, WORKSHOP, dll sejenis)</span></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%"  border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td><hr size="1"></td>
      </tr>
      <tr>
        <td><table width="85%"  border="0" align="center" cellpadding="5" cellspacing="0">
          <tr>
            <td colspan="4"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td colspan="5"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>No. Surat Tugas Publikasi <strong>:&nbsp; <? echo $var_no_st_pub; ?></strong></td>
                      <td><div align="right">No. Legalitas <strong>:&nbsp; <? echo $var_no_legalitas;?></strong> </div></td>
                    </tr>
                  </table></td>
                  </tr>
                <tr>
                  <td width="3%"><span class="style3">1.</span></td>
                  <td colspan="4"><span class="style3">Yang ditugaskan </span></td>
                  </tr>
                <tr>
                  <td><span class="style3"></span></td>
                  <td width="3%"><span class="style3">a.</span></td>
                  <td width="31%"><span class="style3">Nama</span></td>
                  <td width="2%"><div align="center" class="style3"><strong>:</strong></div></td>
                  <td width="61%"><span class="style3">
                    <? if ($var_jenis==1) {
							echo $var_nama_kary_1." (".$var_kode_kary_1.")";
						} else
						{
							echo "terlampir";
						}?>
                  </span></td>
                </tr>
                <tr>
                  <td><span class="style3"></span></td>
                  <td><span class="style3">b.</span></td>
                  <td><span class="style3">Unit kerja</span></td>
                  <td><div align="center" class="style3"><strong>:</strong></div></td>
                  <td>
				    <span class="style3">
				    <? 
					//$jurusan = substr($var_nrp, 3,1); 
					$sql_jur = "SELECT jurusan as nama_jurusan FROM jurusan WHERE id='$var_TET_sub'";
					$result_jur=mysql_query($sql_jur);
					if ($row = mysql_fetch_array($result_jur)) {
					echo $row["nama_jurusan"];
					}
				  ?>
				    </span>				  </td>
                </tr>
                <tr>
                  <td><span class="style3"></span></td>
                  <td><span class="style3">c.</span></td>
                  <td><span class="style3">Jabatan struktural</span></td>
                  <td><div align="center" class="style3"><strong>:</strong></div></td>
                  <td>
				    <span class="style3">
				    <? 
				  	if ($var_jenis==1) {
						$sql_jab_struk = "SELECT jab_struktural FROM dosen WHERE kode='$var_kode_kary_1'";
						$result_jab_struk=mysql_query($sql_jab_struk);
						if ($row = mysql_fetch_array($result_jab_struk)) {
						echo $row["jab_struktural"];
						} 
					}
					else
					{
						echo "terlampir";
					}
				  ?>
				    </span>				  </td>
                </tr>
                <tr>
                  <td><span class="style3"></span></td>
                  <td><span class="style3">d.</span></td>
                  <td nowrap><span class="style3">Jabatan Fungsional/Akademik</span></td>
                  <td><div align="center" class="style3"><strong>:</strong></div></td>
                  <td>
				    <span class="style3">
				    <? 
				  	if ($var_jenis==1) {
						$sql_jab_ak = "SELECT jab_akademik FROM dosen WHERE kode='$var_kode_kary_1'";
						$result_jab_ak=mysql_query($sql_jab_ak);
						if ($row = mysql_fetch_array($result_jab_ak)) {
						echo $row["jab_akademik"];
						}
					}
					else
					{
						echo "terlampir";
					}
				  ?>
				    </span>				  </td>
                </tr>
                          </table>              </td>
            </tr>
          <tr>
            <td colspan="4"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="3%"><span class="style2">2.</span></td>
                <td colspan="2" valign="top"><span class="style2">Tugas / Keperluan </span></td>
                <td width="2%" valign="top"><div align="center" class="style2"><strong>:</strong></div></td>
                <td width="61%" rowspan="2" valign="top"><span class="style2"><? echo $var_tugas;?></span></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td width="3%">&nbsp;</td>
                <td width="31%" nowrap>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="4" nowrap><table width="100%"  border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="3%"><span class="style3">3.</span></td>
                <td width="34%" colspan="2"><span class="style3">Tempat</span></td>
                <td width="2%"><div align="center" class="style3"><strong>:</strong></div></td>
                <td width="61%"><span class="style3"><? echo $var_tempat_go;?></span></td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td colspan="4" nowrap><table width="100%"  border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="3%"><span class="style3">4.</span></td>
                <td width="34%" colspan="2"><span class="style3">Status</span></td>
                <td width="2%"><div align="center" class="style3"><strong>:</strong></div></td>
                <td width="61%"><table width="100%"  border="0" cellspacing="0" cellpadding="3">
                  <tr>
                    <td width="5%" class="style3"><input name="rb_peserta" id="rb_peserta" type="radio" value="radiobutton" <? if ($var_status=="Peserta") echo "checked";?>></td>
                    <td width="46%" class="style3">Peserta</td>
                    <td width="5%" class="style3"><input name="rb_penyaji" id="rb_penyaji" type="radio" value="radiobutton" <? if ($var_status=="Penyaji") echo "checked";?>></td>
                    <td width="44%" class="style3">Penyaji</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td colspan="4" nowrap><table width="100%"  border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="3%"><span class="style3">5.</span></td>
                <td colspan="2"><span class="style3">Jadwal Pelaksanaan</span></td>
                <td width="2%"><div align="center" class="style3"><strong>:</strong></div></td>
                <td width="61%"><span class="style3">&nbsp;<? echo $var_tgl_pub_1;?>&nbsp; s/d &nbsp; <? echo $var_tgl_pub_2;?></span></td>
              </tr>
              <tr>
                <td><span class="style3"></span></td>
                <td width="3%"><span class="style3">a</span></td>
                <td width="31%" nowrap><span class="style3">Hari/Tanggal/Jam berangkat </span></td>
                <td><div align="center" class="style3"><strong>:</strong></div></td>
                <td><span class="style3"><? echo $var_hari_go.", ".$var_tgl_go.", ".$var_pukul_go;?></span></td>
              </tr>
              <tr>
                <td><span class="style3"></span></td>
                <td><span class="style3">b</span></td>
                <td nowrap><span class="style3">Hari/Tanggal/Jam kembali </span></td>
                <td><div align="center" class="style3"><strong>:</strong></div></td>
                <td><span class="style3"><? echo $var_hari_dtg.", ".$var_tgl_dtg.", ".$var_pukul_dtg;?></span></td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td colspan="4" nowrap><table width="100%"  border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="3%"><span class="style3">6.</span></td>
                <td colspan="4"><span class="style3">Pembiayaan yang diperlukan (berikan tanda cek pada kotak/lengkapi isian yang tersedia) </span></td>
                </tr>
              <tr>
                <td><span class="style3"></span></td>
                <td width="3%"><span class="style3">a.</span></td>
                <td width="31%" nowrap><span class="style3">Biaya program (Rp/US $) </span></td>
                <td width="2%"><div align="center" class="style3"><strong>:</strong></div></td>
                <td width="61%"><span class="style3"><? echo $frm_biaya;?></span></td>
              </tr>
              <tr>
                <td><span class="style3"></span></td>
                <td valign="top"><span class="style3">b.</span></td>
                <td valign="top" nowrap><span class="style3">Transportasi</span></td>
                <td valign="top"><div align="center" class="style3"><strong>:</strong></div></td>
                <td><span class="style3"><? echo $var_transport_go;?></span></td>
              </tr>
              <tr>
                <td><span class="style3"></span></td>
                <td valign="top"><span class="style3">c.</span></td>
                <td valign="top" nowrap><span class="style3">Lain - lain </span></td>
                <td valign="top"><span class="style3"><strong>:</strong></span></td>
                <td><table width="100%"  border="0" cellspacing="0" cellpadding="3">
                  <tr>
                    <td width="8%" valign="top" class="style3"><input type="checkbox" name="chk_airport" id="chk_airport" <? if ($chk_airport==1) echo "checked";?> disabled></td>
                    <td width="31%" valign="top" class="style3">Airport tax </td>
                    <td width="7%" valign="top" class="style3"><input type="checkbox" name="chk_fiskal" id="chk_fiskal" <? if ($chk_fiskal==1) echo "checked";?> disabled></td>
                    <td width="54%" valign="top" class="style3">Fiskal Luar Negeri </td>
                    </tr>
                  <tr>
                    <td valign="top" class="style3"><input type="checkbox" name="chk_visa" id="chk_visa" <? if ($chk_visa==1) echo "checked";?> disabled></td>
                    <td valign="top" class="style3">Visa</td>
                    <td valign="top" class="style3"><input type="checkbox" name="chk_uang_saku" id="chk_uang_saku" <? if ($chk_uang_saku==1) echo "checked";?> disabled></td>
                    <td valign="top" class="style3">Uang Saku (biaya hidup) </td>
                    </tr>
                  <tr>
                    <td valign="top" class="style3"><input type="checkbox" name="chk_akomodasi" id="chk_akomodasi" <? if ($chk_akomodasi==1) echo "checked";?> disabled></td>
                    <td valign="top" class="style3">Akomodasi</td>
                    <td valign="top" class="style3">
					<? if (isset($var_frm_lainnya)) {?>
					<input type="checkbox" name="chk_lainnya" <? if (isset($var_frm_lainnya)) echo "checked";?> disabled>
					<? }?>
					</td>
                    <td valign="top" class="style3"><? echo $var_frm_lainnya;?></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td colspan="4" nowrap><table width="100%"  border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td width="3%"><span class="style3">7.</span></td>
                <td width="34%" colspan="2"><span class="style3">Non degree training terakhir </span></td>
                <td width="2%"><div align="center" class="style3"><strong>:</strong></div></td>
                <td width="61%"><span class="style3"><? echo $frm_ndt;?></span></td>
              </tr>
            </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
        <td nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td width="66%">&nbsp;</td>
        <td width="34%" nowrap class="style5"><? 
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
        <td class="style5">&nbsp;</td>
      </tr>
      <tr>
        <td class="style5">Menyetujui,</td>
        <td class="style5">&nbsp;</td>
      </tr>
      <tr>
        <td class="style5">Pimpinan Unit Kerja </td>
        <td class="style5">Yang ditugaskan </td>
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
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>	<table width="95%"  border="1" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2"><font size="1"><u>Kelengkapan usulan surat tugas</u> :</font></td>
            </tr>
          <tr>
            <td width="3%" valign="top"><font size="1">a.</font></td>
            <td width="97%" nowrap><font size="1">Usulan dibuat oleh YBS dengan persetujuan pimpinan unit kerja dan usulan dikirim langsung ke Biro ADPESDAM 
              dilengkapi dokumen pendukung.</font></td>
            </tr>
          <tr>
            <td><font size="1">b.</font></td>
            <td><font size="1">Usulan surat tugas paling lambat disampaikan ke Universitas (Biro ADPESDAM) 5 (lima) hari sebelum hari H (keberangkatan).</font></td>
            </tr>
          <tr>
            <td><font size="1">c.</font></td>
            <td><font size="1">Usulan surat tugas yang kadaluwarsa tidak akan dilayani.</font></td>
            </tr>
        </table>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="95%"  border="1" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td><table width="98100%"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="100%" colspan="2"><b>Catatan Biro ADPESDAM :</b> </td>
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
    <td>
		  <!--form>
		 	 <input type='button' onclick='javascript:window.print();' name="button" value="PRINT">
		  </form-->
	</td>
  </tr>
</table>



<?

//untuk gabung variabel    ${"anggota".$i};   --> variable in variable
// http://id.php.net/variables.variable
// echo "<br>var_kode_kary_1=".$var_kode_kary_1;
	$jum=0;
	for ($i = 1; $i <= 5; $i++) {
		if (${"var_kode_kary_".$i} <>'')
		{
			$jum++; 
		}
	}
	//echo "<br>JUM=".$jum;

if ($var_jenis==2) {
?>
<table width="60%"  border="1" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td><strong>Kode</strong></td>
    <td><strong>Nama</strong></td>
    <td nowrap><strong>Jabatan Struktural </strong></td>
    <td nowrap><strong>Jabatan Akademik</strong></td>
    </tr>
	<? for ($i = 1; $i <= $jum; $i++) {?>
	  <tr>
		<td nowrap><? echo ${"var_kode_kary_".$i};?></td>
		<td nowrap>
			<? 
				$result = mysql_query("SELECT kode, nama, npk FROM dosen WHERE kode='".${"var_kode_kary_".$i}."'");
				$row = mysql_fetch_array($result);
				$var_nama_kary = $row["nama"];
				echo $var_nama_kary;
			?>
		</td>
		<td>
		   <? 
				$result = mysql_query("SELECT jab_struktural FROM dosen WHERE kode='".${"var_kode_kary_".$i}."'");
				$row = mysql_fetch_array($result);
				$var_jab_struk = $row["jab_struktural"];
				if ($var_jab_struk=='') {
					echo "Dosen";
				}
				else
				{
					echo $var_jab_struk;
				}
				
			?>
		</td>
		<td>
		   <? 
				$result = mysql_query("SELECT jab_akademik FROM dosen WHERE kode='".${"var_kode_kary_".$i}."'");
				$row = mysql_fetch_array($result);
				$var_jab_aka = $row["jab_akademik"];
				echo $var_jab_aka;
			?>
		</td>
	  </tr>
	<? 
	}?>
</table>

<?
}
?>
</div>
</body>
</html>