<? 
session_start();
include("../../include/js_function.js");
require("../../include/global.php");
require("../../include/fungsi.php");
?>
<html>
<head>
<title>: : CETAK GANTI DOSEN PEMBIMBING PENELITIAN : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
</head>
<body>
<? 
f_connecting();
	mysql_select_db($DB);
	
$var_nrp=$_GET['nrp'];
$var_tgl_surat=$_GET['tgl_surat'];
//echo "<br>var_nrp=".$var_nrp;
$sqlText="SELECT   master_mhs.NRP,
								master_mhs.NAMA,
								DATE_FORMAT(`ganti_dobing_lp`.`tgl_aju`,'%d/%m/%Y') as tgl_aju,
								DATE_FORMAT(`ganti_dobing_lp`.`tgl_ganti`,'%d/%m/%Y') as tgl_ganti,
								ganti_dobing_lp.kode_dobing_lama,
								ganti_dobing_lp.kode_dobing_baru,
								master_lp.KODOS1,
								master_lp.KODOS2,
								no_surat_lp.N_GANDOS
					   FROM
								master_mhs, ganti_dobing_lp, master_lp, no_surat_lp
					   WHERE
								master_mhs.NRP =  ganti_dobing_lp.NRP AND
								master_mhs.NRP =  master_lp.NRP AND
								master_mhs.NRP =  no_surat_lp.NRP AND
								master_mhs.NRP =  '".$var_nrp."'";
//echo $sqlText;
$result = mysql_query($sqlText);
								$row = mysql_fetch_array($result);
							if ($row) {
								$frm_exist=1;
								$var_nama = $row["NAMA"];
								$var_kode_dobing_lama = $row["kode_dobing_lama"];
								$var_kode_dobing_baru = $row["kode_dobing_baru"];
								$var_no_ganti_dobing_TA = $row["N_GANDOS"];
								
								$var_tgl_aju = $row["tgl_aju"];
								if ($row["tgl_aju"]=="00/00/0000") {
								$var_tgl_aju = ""; } else {
								$var_tgl_aju = $row["tgl_aju"];}
								
								$var_tgl_ganti = $row["tgl_ganti"];
								if ($row["tgl_ganti"]=="00/00/0000") {
								$var_tgl_ganti = ""; } else {
								$var_tgl_ganti = $row["tgl_ganti"];}
								
								$var_kodobing_1 = $row["KODOS1"];
								$var_kodobing_2 = $row["KODOS2"];
                                                                
$result=mysql_query("SELECT t.TGL_AJU, n.N_ST  FROM master_lp t, no_surat_lp n where t.NRP='$var_nrp' AND t.NRP=n.NRP ORDER BY t.TGL_AJU DESC LIMIT 1");
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
      $romawiNumbers=array(1=>'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII');
      $tglAjuLama=$tgl.'-'.$bulanNames[$bln].'-'.$thn;
      $noSuratLama = $noSuratLama.'/STTA/DEK/FT/'.$romawiNumbers[$bln].'/'.$thn;
}
										
							}else
							{$frm_exist=0;// header("Location: mhs_perpanjangan_ta.php"); 
							}
							
							if ($var_kode_dobing_lama!='') {
								$result = mysql_query("Select nama from dosen where kode='$var_kode_dobing_lama'");
								$row = mysql_fetch_array($result);
								$var_nama_dobing_lama = $row["nama"];
							}	
							
							if ($var_kode_dobing_baru!='') {
								$result = mysql_query("Select nama from dosen where kode='$var_kode_dobing_baru'");
								$row = mysql_fetch_array($result);
								$var_nama_dobing_baru = $row["nama"];
							}	
							
							if ($var_kodobing_1!='') {
								$result = mysql_query("Select nama from dosen where kode='$var_kodobing_1'");
								$row = mysql_fetch_array($result);
								$var_nama_kodobing_1 = $row["nama"];
							}	
							
							if ($var_kodobing_2!='') {
								$result = mysql_query("Select nama from dosen where kode='$var_kodobing_2'");
								$row = mysql_fetch_array($result);
								$var_nama_kodobing_2 = $row["nama"];
							} else {
                                                            $var_nama_kodobing_2 = '';
                                                        }	
?>
<table width="80%"  border="0" align="center" cellpadding="2" cellspacing="0">
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>
  <input type="submit" name="Submit" value="PRINT" onClick="cetak();" style="cursor:pointer; position:absolute; left:604px; top:32px; width:52px; height:18px; z-index:1; background-color: #CCCCCC; layer-background-color: #CCCCCC; border: 1px none #000000;" class="noPrint">
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
        <td width="8%">Nomor</td>
        <td width="1%"><strong>:</strong></td>
        <td width="51%"><? echo $var_no_ganti_dobing_TA ."/Dek/FT/".date('Y');?></td>
        <td width="40%">
		<? $bln_surat_ganti_dobing = substr($var_tgl_surat, 3,2);
		//echo "var_tgl_surat=".$var_tgl_surat;
		//echo "bln_surat_ganti_dobing=".$bln_surat_ganti_dobing;
		
			  switch ($bln_surat_ganti_dobing) {
				case '01':
					$bln_nama=' Januari ';
					break;
				case '02':
					$bln_nama=' Februari ';
					break;
				case '03':
					$bln_nama=' Maret ';
					break;
				case '04':
					$bln_nama=' April ';
					break;
				case '05':
					$bln_nama=' Mei ';
					break;
				case '06':
					$bln_nama=' Juni ';
					break;
				case '07':
					$bln_nama=' Juli ';
					break;
				case '08':
					$bln_nama=' Agustus ';
					break;
				case '09':
					$bln_nama=' September ';
					break;
				case '10':
					$bln_nama=' Oktober ';
					break;
				case '11':
					$bln_nama=' November ';
					break;	
				case '12':
					$bln_nama=' Desember ';
					break;
				}
			$tgl_surat_ganti_dobing = substr($var_tgl_surat, 0,2);	
			$thn_surat_ganti_dobing = substr($var_tgl_surat, 6,4);
			$tanggalnya = "Surabaya, ".$tgl_surat_ganti_dobing." ".$bln_nama." ".$thn_surat_ganti_dobing;
		 	echo $tanggalnya;
		 ?>
		 
		</td>
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
        <td>Pindah Dosen Pembimbing Penelitian</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%"  border="0" align="center" cellpadding="2" cellspacing="0">
      <tr>
        <td width="60%">&nbsp;</td>
        <td width="40%">Kepada Yth. </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Sdr/i. <? echo $var_nama;?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>NRP : <? echo $var_nrp;?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>di - SURABAYA </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="85%"  border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="justify">Membalas surat Saudara/i tertanggal <? echo $var_tgl_aju; ?> perihal permohonan &quot;PINDAH DOSEN PEMBIMBING PENELITIAN&quot; dan sesuai dengan persetujuan KETUA JURUSAN, maka kami TIDAK KEBERATAN Saudara/i mengganti dosen pembimbing DARI : </div></td>
      </tr>
      <tr>
        <td>
          <table width="70%"  border="0" align="center" cellpadding="5" cellspacing="0">
            <tr>
              <td width="39%" nowrap>DOSEN PEMBIMBING LAMA </td>
              <td width="3%">:</td>
              <td width="6%" nowrap><b><? echo $var_kode_dobing_lama; ?></b></td>
              <td width="52%" nowrap> <? echo $var_nama_dobing_lama;?></td>
            </tr>
            <tr>
                <td colspan="4" align="left"><div align="left">Sesuai Surat Tugas Nomor <?php echo $noSuratLama;?> tertanggal <?php echo $tglAjuLama;?></div></td>
            </tr>
            <tr>
              <td nowrap>DOSEN PEMBIMBING BARU </td>
              <td>:</td>
              <td nowrap><b><? echo $var_kode_dobing_baru; ?></b></td>
              <td nowrap> <? echo $var_nama_dobing_baru;?></td>
            </tr>
          </table>        </td>
      </tr>
      <tr>
        <td>Sehingga dosen pembimbing Saudara/i menjadi : </td>
      </tr>
      <tr>
        <td><table width="70%"  border="0" align="center" cellpadding="5" cellspacing="0">
          <tr>
            <td width="34%" nowrap>DOSEN PEMBIMBING  </td>
            <td width="3%">:</td>
            <td width="6%" nowrap><b><? echo $var_kode_dobing_baru; ?></b></td>
            <td width="57%" nowrap> <? echo $var_nama_dobing_baru; ?></td>
          </tr>
          
          <tr>
            <td nowrap>DOSEN PEMBIMBING II </td>
            <td>:</td>
            <td nowrap><b><? echo $var_kodobing_2; ?></b></td>
            <td nowrap> <? echo $var_nama_kodobing_2; ?></td>
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
        <td>
		<? 
			  $sql_dek="SELECT nama FROM jabatan_struktural WHERE jabatan='Dekan'";
			  $result_dek = mysql_query($sql_dek);
			  if ($row_dek = mysql_fetch_array($result_dek)) {
			  	echo $row_dek["nama"];
			  }
			  ?>
		</td>
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
    <td><table width="90%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2">Tembusan kepada : </td>
        </tr>
      <tr>
        <td colspan="2" nowrap>1. Wakil Dekan </td>
        </tr>
      <tr>
        <td colspan="2">2. Ketua Jurusan</td>
        </tr>
      <tr>
        <td width="21%" valign="top" nowrap>3. Dosen Pembimbing : </td>
        <td width="79%"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td width="5%" nowrap><? echo "1. $var_kode_dobing_baru";?></td>
            <td width="95%" nowrap><? echo "- ".$var_nama_dobing_baru;?></td>
          </tr>
          <tr>
            <td nowrap><? echo "2. $var_kodobing_2";?></td>
            <td nowrap><? echo "- ".$var_nama_kodobing_2;?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td width="21%" valign="top" nowrap><br/>4. Dosen Pembimbing Lama : </td>
        <td width="79%"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td width="5%" nowrap><br/><? echo " $var_kode_dobing_lama";?></td>
            <td width="95%" nowrap><br/><? echo "- ".$var_nama_dobing_lama;?></td>
          </tr>
          
        </table></td>
      </tr>
      
<!--      <tr>
        <td colspan="2">4. ARSIP</td>
        </tr>-->
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