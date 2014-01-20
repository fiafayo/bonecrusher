<? 
session_start();
include("../../include/js_function.js");
require("../../include/global.php");
require("../../include/fungsi.php");
?>
<html>
<head>
<title>: : CETAK GANTI JUDUL TA : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
</head>
<body>
<? 
f_connecting();
	mysql_select_db($DB);
	
$var_nrp=$_GET['nrp'];
$var_kodobing_1='';
$var_kodobing_2='';
$var_no_gandul_TA='';

$result = mysql_query("SELECT   master_mhs.NRP,
								master_mhs.NAMA,
								DATE_FORMAT(`ganti_judul`.`tgl_aju`,'%d/%m/%Y') as tgl_aju,
								DATE_FORMAT(`ganti_judul`.`tgl_ganti`,'%d/%m/%Y') as tgl_ganti,
								ganti_judul.JUDUL_LAMA,
								ganti_judul.JUDUL_BARU,
								master_ta.KODOS1,
								master_ta.KODOS2,
								no_surat.N_gandul
					   FROM
								master_mhs, ganti_judul, master_ta, no_surat
					   WHERE
								master_mhs.NRP =  ganti_judul.NRP AND
								master_mhs.NRP =  master_ta.NRP AND
								master_mhs.NRP =  no_surat.NRP AND
								master_mhs.NRP =  '".$var_nrp."'");
								$row = mysql_fetch_array($result);
							if ($row) {
								$frm_exist=1;
								$var_nama = $row["NAMA"];
								$var_judul_lama = $row["JUDUL_LAMA"];
								$var_judul_baru = $row["JUDUL_BARU"];
								$var_no_gandul_TA = $row["N_gandul"];
								
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
                                                                
                                                                
$result=mysql_query("SELECT t.TGL_AJU, n.N_ST  FROM master_ta t, no_surat n where t.NRP='$var_nrp' AND t.NRP=n.NRP ORDER BY t.TGL_AJU DESC LIMIT 1");
$row=mysql_fetch_assoc($result);
$noSuratLama = '';
$tglAjuLama = '';
if ($row) {
    $noSuratLama = $row['N_ST'];
    $tglAjuLama = $row['TGL_AJU'];
      $bln=intval(substr($tglAjuLama, 5,2));
      $tgl=intval(substr($tglAjuLama, 8,2));  
      $thn=intval(substr($tglAjuLama, 0,4));      
      if (($bln<1) || ($bln>12)) $bln=1;
      $bulanNames=array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
      $romawiNumbers=array(1=>'I','II','III','IV','V','VI','VII','VIII','IX','X','XII');
      $tglAjuLama=$tgl.'-'.$bulanNames[$bln].'-'.$thn;
      $noSuratLama = $noSuratLama.'/STTA/DEK/FT/'.$romawiNumbers[$bln].'/'.$thn;
}
		
                                                                
								
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
        <td width="61%"><? echo $var_no_gandul_TA ."/Dek/FT/".date('Y');?></td>
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
        <td>Perubahan Judul Tugas Akhir</td>
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
        <td nowrap>Sdr/i. <? echo $var_nama;?></td>
      </tr>
      <tr>
        <td nowrap>NRP : <? echo $var_nrp;?></td>
      </tr>
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
        <td><div align="justify">Membalas surat Saudara/i tertanggal <? echo $var_tgl_aju; ?> perihal permohonan &quot;PERUBAHAN JUDUL TUGAS AKHIR&quot; dan sesuai dengan persetujuan KETUA JURUSAN, maka kami TIDAK KEBERATAN Saudara/i mengubah Judul Tugas Akhir DARI : </div></td>
      </tr>
      <tr>
        <td>
          <table width="70%"  border="0" align="center" cellpadding="5" cellspacing="0">
            <tr>
              <td><div align="center"><b><? echo $var_judul_lama; ?></b><br/>
                      Sesuai Surat Tugas Nomor <?php echo $noSuratLama;?> tertanggal <?php echo $tglAjuLama;?>
                  
                  </div></td>
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