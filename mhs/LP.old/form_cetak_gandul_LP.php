<? 
session_start();
include("../../include/js_function.js");
require("../../include/global.php");
require("../../include/fungsi.php");
?>
<html>
<head>
<title>: : CETAK GANTI JUDUL LP : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
</head>
<body>
<? 
                                                            $namaPartner = '';
                                                            $nrpPartner = '';

f_connecting();
	mysql_select_db($DB);
	
$var_nrp=$_GET['nrp'];
$sqlText="SELECT   master_mhs.NRP,
								master_mhs.NAMA,
								DATE_FORMAT(`ganti_judul_lp`.`tgl_aju`,'%d/%m/%Y') as tgl_aju,
								DATE_FORMAT(`ganti_judul_lp`.`tgl_ganti`,'%d/%m/%Y') as tgl_ganti,
								ganti_judul_lp.JUDUL_LAMA,
								ganti_judul_lp.JUDUL_BARU,
								master_lp.KODOS1,
								master_lp.KODOS2,
                                                                
                                                                master_lp.ST_LP,
								no_surat.N_gandul
					   FROM
								master_mhs, ganti_judul_lp, master_lp, no_surat
					   WHERE
								master_mhs.NRP =  ganti_judul_lp.NRP AND
								master_mhs.NRP =  master_lp.NRP AND
								master_mhs.NRP =  no_surat.NRP AND
								master_mhs.NRP =  '".$var_nrp."'";

$result = mysql_query($sqlText);
								
							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$var_nama = $row["NAMA"];
								$var_judul_lama = $row["JUDUL_LAMA"];
								$var_judul_baru = $row["JUDUL_BARU"];
								$var_no_gandul_LP = $row["N_gandul"];
								
								$var_tgl_aju = $row["tgl_aju"];
								if ($row["tgl_aju"]=="00/00/0000") {
								$var_tgl_aju = ""; }else {
								$var_tgl_aju = $row["tgl_aju"];}
								
								$var_tgl_ganti = $row["tgl_ganti"];
								if ($row["tgl_ganti"]=="00/00/0000") {
								$var_tgl_ganti = ""; }else {
								$var_tgl_ganti = $row["tgl_ganti"];}
								
								$var_kodobing_1 = $row["KODOS1"];
								$var_kodobing_2 = $row["KODOS2"];
								
							}else
							{$frm_exist=0;// header("Location: mhs_perpanjangan_ta.php"); 
							}
							
							if ($var_kodobing_1!='') {
								$result = mysql_query("Select nama from dosen where kode='$var_kodobing_1'");
								$row = mysql_fetch_array($result);
								$var_nama_dobing_1 = $row["nama"];
							}	
							
							if ($var_kodobing_2!='') {
								$result = mysql_query("Select nama from dosen where kode='$var_kodobing_2'");
								$row = mysql_fetch_array($result);
								$var_nama_dobing_2 = $row["nama"];
							}	
                                                        
                                                        $sqlMasterLp = "SELECT ST_LP FROM master_lp WHERE NRP='$var_nrp' ORDER BY TGL_AJU DESC LIMIT 1 ";
                                                        //file_put_contents('/tmp/sia1.sql', $sqlMasterLp);
                                                        $rsMasterLp = mysql_query($sqlMasterLp);
                                                        $rowMasterLp = mysql_fetch_assoc($rsMasterLp);
                                                        $noST='0';
                                                        if ($rowMasterLp) {
                                                            $noST = $rowMasterLp['ST_LP'];
                                                            $sqlMasterLpPartner="SELECT l.NRP,m.NAMA FROM master_lp l, master_mhs m WHERE l.ST_LP='$noST' AND l.NRP<>'$var_nrp' AND l.NRP=m.NRP";
                                                            $rsMasterLpPartner=mysql_query($sqlMasterLpPartner);
                                                            $rowMasterLpPartner = mysql_fetch_assoc($rsMasterLpPartner);
                                                            $namaPartner = $rowMasterLpPartner['NAMA'];
                                                            $nrpPartner = $rowMasterLpPartner['NRP'];
                                                            //file_put_contents('/tmp/sia2.sql', $sqlMasterLpPartner);
                                                        }
                                                        $tglAjuArr=explode('/',$var_tgl_aju);
                                                        $thnAju = $tglAjuArr[2];
                                                        $blnAju = intval($tglAjuArr[1]);
                                                        $romawis = array('0', 'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII' );
                                                        $bulanNames = array('0', 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember' );
                                                        $blnRomawi = $romawis[$blnAju];
                                                        $blnName = $bulanNames[$blnAju];
                                                        $nomorAju = $noST."/STLP/DEK/FT/$blnRomawi/$thnAju";
                                                        $tanggalAju = $tglAjuArr[0].' '.$blnName.' '.$thnAju;
?>
<table width="98%"  border="0" align="center" cellpadding="2" cellspacing="0">
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>
  <input type="submit" name="Submit" value="PRINT" onClick="cetak();" style=" cursor:pointer; position:absolute; left:604px; top:32px; width:52px; height:18px; z-index:1; background-color: #CCCCCC; layer-background-color: #CCCCCC; border: 1px none #000000;" class="noPrint">
  </td>
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
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr><td>&nbsp;</td></tr>
  <tr>
    <td>
	<table width="100%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="6%">Nomor</td>
        <td width="1%"><strong>:</strong></td>
        <td width="61%"><? echo $var_no_gandul_LP ."/Dek/FT/".date('Y');?></td>
        <td width="32%"><? 
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
        <td nowrap>Lampiran</td>
        <td><strong>:</strong></td>
        <td> - </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Perihal</td>
        <td><strong>:</strong></td>
        <td>Perubahan Judul Latihan Penelitian</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="40%"  border="0" align="right" cellpadding="2" cellspacing="0">
      <tr>
        <td nowrap>Kepada Yth. </td>
      </tr>
      <tr>
        <td nowrap>Sdr/i. - <? echo $var_nama;?> (<? echo $var_nrp;?>)</td>
      </tr>
      <?php
      if ($nrpPartner) :
      ?>
      <tr>
        <td nowrap> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <? echo $namaPartner;?> (<? echo $nrpPartner;?>)  </td>
      </tr>
      <?php endif; ?>
      <tr>
        <td nowrap>di - SURABAYA </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="95%"  border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="justify">Membalas surat Saudara/i tertanggal <? echo $var_tgl_aju; ?> perihal permohonan &quot;PERUBAHAN JUDUL LATIHAN PENELITIAN&quot; dan sesuai dengan persetujuan KETUA JURUSAN, maka kami TIDAK KEBERATAN Saudara/i mengubah Judul Latihan Penelitian DARI : </div></td>
      </tr>
      <tr>
        <td>
          <table width="70%"  border="0" align="center" cellpadding="5" cellspacing="0">
            <tr>
              <td><div align="center"><b><? echo $var_judul_lama; ?></b></div></td>
            </tr>
            <tr>
                <td>
                    <div align="center">Sesuai Surat Tugas Nomor <?php echo $nomorAju;?> tertanggal <?php echo $tanggalAju; ?></div>
                </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>MENJADI : </td>
      </tr>
      <tr>
        <td><table width="70%"  border="0" align="center" cellpadding="5" cellspacing="0">
          <tr>
            <td><div align="center"><b><? echo $var_judul_baru; ?></b></div></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>Atas perhatian Saudara/Saudari, kami sampaikan terima kasih. </td>
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
    <td><table width="40%"  border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td>Dekan,</td>
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
        <td nowrap><? 
			  $sql_dek="SELECT nama FROM jabatan_struktural WHERE jabatan='Dekan'";
			  $result_dek = mysql_query($sql_dek);
			  if ($row_dek = mysql_fetch_array($result_dek)) {
			  	echo $row_dek["nama"];
			  }
			  ?> </td>
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
    <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="3">Tembusan kepada : </td>
        </tr>
      <tr>
        <td colspan="3" nowrap>1. Wakil Dekan </td>
        </tr>
      <tr>
        <td colspan="3">2. Ketua Jurusan</td>
        </tr>
      <tr>
        <td colspan="2" valign="top" nowrap>3. Dosen Pembimbing : </td>
        <td width="86%"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td width="3%" nowrap><? echo "1. $var_kodobing_1";?></td>
            <td width="97%" nowrap><? echo " - ".$var_nama_dobing_1;?></td>
          </tr>
          <tr>
            <td nowrap><? echo "2. $var_kodobing_2";?></td>
            <td nowrap><? echo " - ".$var_nama_dobing_2;?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td width="1%">&nbsp;</td>
        <td width="13%">&nbsp;</td>
        <td>&nbsp;</td>
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
</body>
</html>