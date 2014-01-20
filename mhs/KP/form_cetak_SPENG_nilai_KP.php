<? 
/* 
   DATE CREATED : 28/09/07
   UPDATE       : 04/02/09 - penambahan jumlah mhs kp (total 6)
   				  18/06/09 - penambahan jumlah mhs kp (total 8)
   KEGUNAAN     : CETAK SURAT PENGANTAR NILAI KP
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
   PROBLEM      : seharus nya mahasiswa yg sudah lulus KP(status=S-1) tidak perlu ditampilkan --and `daftar_kp`.`status`<>'S1'---
*/
session_start();
include("../../include/js_function.js");
require("../../include/global.php");
require("../../include/fungsi.php");
?>

<html>
<head>
<title>: : CETAK SURAT PENGANTAR NILAI KP : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
</head>
<body>
<? 
f_connecting();
	mysql_select_db($DB);
	
$var_no_SPN=$_GET['no_SPN'];
//echo "<br>var_no_st_kp=".$var_no_SPN;
$sql_ST_KP="SELECT `daftar_kp`.`NO_MOHON`,
				   `daftar_kp`.`UR_MOHON`,
				   `daftar_kp`.`KODE_KP`,
				   `daftar_kp`.`NRP_1`,
				   `daftar_kp`.`NRP_2`,
				   `daftar_kp`.`NRP_3`,
				   `daftar_kp`.`NRP_4`,
				   `daftar_kp`.`NRP_5`,
				   `daftar_kp`.`NRP_6`,
				   `daftar_kp`.`NRP_7`,
				   `daftar_kp`.`NRP_8`,
				   `daftar_kp`.`NA_PERUSH`,
				   `daftar_kp`.`JALAN`,
				   `daftar_kp`.`KOTA`,
					DATE_FORMAT(`daftar_kp`.`TGL_AWAL`,'%d/%m/%Y') as TGL_AWAL,
					DATE_FORMAT(`daftar_kp`.`TGL_END`,'%d/%m/%Y') as TGL_END,
					DATE_FORMAT(`daftar_kp`.`TGL_MOHON`,'%d/%m/%Y') as TGL_MOHON,
				   `daftar_kp`.`NO_ST`,
				   `daftar_kp`.`UR_ST`,
				   `daftar_kp`.`DOSEN`,
				   `daftar_kp`.`PEM_PERUS`,
					DATE_FORMAT(`daftar_kp`.`TGL_ST`,'%d/%m/%Y') as TGL_ST,
				   `daftar_kp`.`NO_NKP`,
				   `daftar_kp`.`UR_NKP`,
				   `daftar_kp`.`TGL_NKP`,
				   `daftar_kp`.`HONOR`,
				   `daftar_kp`.`STATUS`
			FROM    daftar_kp 
			WHERE `daftar_kp`.`NO_NKP`='".$var_no_SPN."'";
				  //and `daftar_kp`.`STATUS`<>'S1'";
				  // apa mhs yg sudah kp bisa cetak surat penilaian KP juga

							$result = mysql_query($sql_ST_KP);
							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_kode_KP = $row["KODE_KP"];
								$frm_no_surat_pemohon = $row["NO_MOHON"];
								$frm_no_ST_KP = $row["NO_ST"];
								$frm_no_NKP = $row["NO_NKP"];
								//echo "<br><b>frm_no_ST_KP=</b>".$frm_no_ST_KP;
								//echo "<br><b>frm_kode_KP=</b>".$frm_kode_KP;
								$frm_nrp1 = $row["NRP_1"];
								$frm_nrp2 = $row["NRP_2"];
								$frm_nrp3 = $row["NRP_3"];
								$frm_nrp4 = $row["NRP_4"];
								$frm_nrp5 = $row["NRP_5"];
								$frm_nrp6 = $row["NRP_6"];
								$frm_nrp7 = $row["NRP_7"];
								$frm_nrp8 = $row["NRP_8"];
								$frm_kota_KP = $row["KOTA"];
								$frm_nama_pershn = $row["NA_PERUSH"];
								$frm_nabing_pershn = $row["PEM_PERUS"];
								$frm_kodobing = $row["DOSEN"];
								
								$frm_alamat_KP = $row["JALAN"];
								$frm_tgl_mulai_KP = $row["TGL_AWAL"];
								$frm_tgl_selesai_KP = $row["TGL_END"];
								
								$frm_tgl_surat_KP =$row["TGL_MOHON"];
								if ($row["TGL_MOHON"]=="00/00/0000") {
								$frm_tgl_surat_KP =""; }else {
								$frm_tgl_surat_KP =$row["TGL_MOHON"];}
								
								$frm_tgl_ST_KP =$row["TGL_ST"];
								if ($row["TGL_ST"]=="00/00/0000") {
								$frm_tgl_ST_KP =""; }else {
								$frm_tgl_ST_KP =$row["TGL_ST"];}
								
							}else
							{$frm_exist=0;// header("Location: mhs_perpanjangan_ta.php"); 
							}
							
							if ($var_nrp!='') {
								$result = mysql_query("Select NAMA from master_mhs where NRP='$var_nrp'");
								$row = mysql_fetch_array($result);
								$var_nama_mhs = $row["NAMA"];
							}	
							if ($frm_kodobing!='') {
								$result = mysql_query("Select NAMA from dosen where kode='$frm_kodobing'");
								$row = mysql_fetch_array($result);
								$var_nama_dobing = $row["NAMA"];
							}	
							
?>
<br/><br/>
<table width="80%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td width="25600%" colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">
			<input type="submit" name="Submit" value="PRINT" onClick="cetak();" style=" cursor:pointer; position:absolute; left:584px; top:91px; width:52px; height:18px; z-index:1; background-color: #CCCCCC; layer-background-color: #CCCCCC; border: 1px none #000000;" class="noPrint">
		</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4"><table width="60%"  border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="12%" nowrap>Nomor</td>
            <td width="2%">:</td>
            <td width="86%">
              <? 
					  $jur_kp=substr($frm_kode_KP, 0,2);   
					   switch ($jur_kp)
						{
							case 'TE':
								$jur_nama="Teknik Elektro";
								$jur_kp_kode="TE";
								break;
							case 'TK':
								$jur_nama="Teknik Kimia";
								$jur_kp_kode="TK";
								break;
							case 'TI':
								$jur_nama="Teknik Industri";
								$jur_kp_kode="TI";
								break;
							case 'IF':
								$jur_nama="Teknik Informatika";
								$jur_kp_kode="IF";
								break;
							case 'TM':
								$jur_nama="Teknik Manufaktur";
								$jur_kp_kode="TM";
								break;
							case 'DMP':
								$jur_nama="Desain Manajemen Produk";
								$jur_kp_kode="DMP";
								break;
							case 'SI':
								$jur_nama="Sistem Informasi";
								$jur_kp_kode="SI";
								break;
							case 'MM':
								$jur_nama="Multimedia";
								$jur_kp_kode="MM";
								break;
							case '61':
								$jur_nama="Teknik Elektro";
								$jur_kp_kode="TE";
								break;
							case '62':
								$jur_nama="Teknik Kimia";
								$jur_kp_kode="TK";
								break;
							case '63':
								$jur_nama="Teknik Industri";
								$jur_kp_kode="TI";
								break;
							case '64':
								$jur_nama="Teknik Informatika";
								$jur_kp_kode="IF";
								break;
							case '65':
								$jur_nama="Teknik Manufaktur";
								$jur_kp_kode="TM";
								break;
							case '66':
								$jur_nama="Desain Manajemen Produk";
								$jur_kp_kode="DMP";
								break;
							case '67':
								$jur_nama="Sistem Informasi";
								$jur_kp_kode="SI";
								break;
							case '68':
								$jur_nama="Multimedia";
								$jur_kp_kode="MM";
								break;	
						}  
					  $bln= date('m');
					  switch ($bln) {
						case '01':
							$bln_romawi='I';
							break;
						case '02':
							$bln_romawi='II';
							break;
						case '03':
							$bln_romawi='III';
							break;
						case '04':
							$bln_romawi='IV';
							break;
						case '05':
							$bln_romawi='V';
							break;
						case '06':
							$bln_romawi='VI';
							break;
						case '07':
							$bln_romawi='VII';
							break;
						case '08':
							$bln_romawi='VIII';
							break;
						case '09':
							$bln_romawi='IX';
							break;
						case '10':
							$bln_romawi='X';
							break;
						case '11':
							$bln_romawi='XI';
							break;	
						case '12':
							$bln_romawi='XII';
							break;
						}
			
					  echo $frm_no_NKP."/NKP/KP-".$jur_kp_kode."/WD-FT/".$bln_romawi."/".date('Y');
					  ?>
            </td>
          </tr>
          <tr>
            <td>Lamp.</td>
            <td>:</td>
            <td> - </td>
          </tr>
          <tr>
            <td>Hal</td>
            <td>:</td>
            <td>Permohonan Nilai Kerja Praktek </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%"  border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="90%"  border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td>Yang terhormat </td>
          </tr>
          <tr>
            <td>Pembimbing Kerja Praktek </td>
          </tr>
          <tr>
            <td><table width="90%"  border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="7%">&nbsp;</td>
                <td width="3%">1.</td>
                <td width="90%" nowrap>Bpk./Ibu <? echo $var_nama_dobing?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td nowrap>2.</td>
                <td nowrap>Bpk./Ibu <? echo $frm_nabing_pershn?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="70%"  border="0" cellspacing="0" cellpadding="1">
              <tr>
                <td width="12%"><div align="right">di &nbsp;</div></td>
                <td width="84%"><? echo $frm_nama_pershn;?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><? echo $frm_alamat_KP;?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><? echo $frm_kota_KP;?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>Dengan diselesaikannya pelaksanaan kerja praktek di : </td>
      </tr>
      <tr>
        <td><table width="70%"  border="0" cellspacing="0" cellpadding="1">
          <tr>
            <td width="12%"><div align="right">di &nbsp;</div></td>
            <td width="84%"><? echo $frm_nama_pershn;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><? echo $frm_alamat_KP;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><? echo $frm_kota_KP;?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Atas nama mahasiswa-mahasiswi : </td>
      </tr>
      <tr>
        <td><table width="70%"  border="0" cellspacing="0" cellpadding="1">
          <tr>
            <td width="12%"><div align="right">&nbsp;</div></td>
            <td width="84%">
						<?
						//echo "<br>KODE KP=".$frm_kode_KP;
						$jur_kp=substr($frm_kode_KP, 0,2);    
						switch ($jur_kp) {
							case 'TE':
								$jur='TEKNIK ELEKTRO';
								break;
							case 'TK':
								$jur='TEKNIK KIMIA';
								break;
							case 'TI':
								$jur='TEKNIK INDUSTRI';
								break;
							case 'IF':
								$jur='TEKNIK INFORMATIKA';
								break;
							case 'TM':
								$jur='TEKNIK MANUFAKTUR';
								break;
							case 'DMP':
								$jur='DESAIN MANAJEMEN PRODUK';
								break;
							case 'SI':
								$jur='SISTEM INFORMASI';
								break;
							case 'MM':
								$jur='MULTIMEDIA';
								break;
							case '61':
								$jur='TEKNIK ELEKTRO';
								break;
							case '62':
								$jur='TEKNIK KIMIA';
								break;
							case '63':
								$jur='TEKNIK INDUSTRI';
								break;
							case '64':
								$jur='TEKNIK INFORMATIKA';
								break;
							case '65':
								$jur='TEKNIK MANUFAKTUR';
								break;
							case '66':
								$jur='DESAIN MANAJEMEN PRODUK';
								break;
							case '67':
								$jur='SISTEM INFORMASI';
								break;
							case '68':
								$jur='MULTIMEDIA';
								break;
						}
						echo "FAKULTAS TEKNIK JURUSAN ".$jur." ,";
						?>
			</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>UNIVERSITAS SURABAYA </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>berdasarkan Surat Tugas No. 
          <? 
					  $bulan_ST_KP=substr($frm_tgl_ST_KP, 3,2); 
					  $tahun_ST_KP=substr($frm_tgl_ST_KP, 6,4); 
					 // echo "<br>frm_tgl_ST_KP=".$frm_tgl_ST_KP."<br>"; 
					  //echo "<br>bulan_ST_KP=".$bulan_ST_KP."<br>";    
					  switch ($bulan_ST_KP) {
						case '01':
							$bln_romawi_ST_KP='I';
							break;
						case '02':
							$bln_romawi_ST_KP='II';
							break;
						case '03':
							$bln_romawi_ST_KP='III';
							break;
						case '04':
							$bln_romawi_ST_KP='IV';
							break;
						case '05':
							$bln_romawi_ST_KP='V';
							break;
						case '06':
							$bln_romawi_ST_KP='VI';
							break;
						case '07':
							$bln_romawi_ST_KP='VII';
							break;
						case '08':
							$bln_romawi_ST_KP='VIII';
							break;
						case '09':
							$bln_romawi_ST_KP='IX';
							break;
						case '10':
							$bln_romawi_ST_KP='X';
							break;
						case '11':
							$bln_romawi_ST_KP='XI';
							break;	
						case '12':
							$bln_romawi_ST_KP='XII';
							break;
						}
			
					  echo $frm_no_ST_KP ."/ST/KP-".$jur_kp_kode."/DEK/".$bln_romawi_ST_KP."/".$tahun_ST_KP;
					  ?></td>
      </tr>
      <tr>
        <td><table width="10%"  border="1" cellpadding="1" cellspacing="0">
          <tr>
            <td><strong>No.</strong></td>
            <td width="22%"><strong>NRP</strong></td>
            <td width="73%"><strong>NAMA</strong></td>
          </tr>
          <? if ($frm_nrp1<>''){
				$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp1'");
				$row = mysql_fetch_array($result);
				$frm_nama_nrp1 = $row["nama"];
		  ?>
          <tr>
            <td width="5%">1.</td>
            <td nowrap><? echo $frm_nrp1;?></td>
            <td nowrap><? echo $frm_nama_nrp1;?></td>
          </tr>
          <? } if ($frm_nrp2<>''){
		  	    $result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp2'");
				$row = mysql_fetch_array($result);
				$frm_nama_nrp2 = $row["nama"];
		  ?>
          <tr>
            <td width="5%">2.</td>
            <td nowrap><? echo $frm_nrp2;?></td>
            <td nowrap><? echo $frm_nama_nrp2;?></td>
          </tr>
          <? } if ($frm_nrp3<>''){
		  	    $result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp3'");
				$row = mysql_fetch_array($result);
				$frm_nama_nrp3 = $row["nama"];
		  ?>
          <tr>
            <td width="5%">3.</td>
            <td nowrap><? echo $frm_nrp3;?></td>
            <td nowrap><? echo $frm_nama_nrp3;?></td>
          </tr>
          <? } if ($frm_nrp4<>''){
		  		$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp4'");
				$row = mysql_fetch_array($result);
				$frm_nama_nrp4 = $row["nama"];
		  ?>
          <tr>
            <td width="5%">4.</td>
            <td nowrap><? echo $frm_nrp4;?></td>
            <td nowrap><? echo $frm_nama_nrp4;?></td>
          </tr>
          <? } if ($frm_nrp5<>''){
		  		$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp5'");
				$row = mysql_fetch_array($result);
				$frm_nama_nrp5 = $row["nama"];
		  ?>
          <tr>
            <td width="5%">5.</td>
            <td nowrap><? echo $frm_nrp5;?></td>
            <td nowrap><? echo $frm_nama_nrp5;?></td>
          </tr>
		<? } if ($frm_nrp6<>''){
		  		$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp6'");
				$row = mysql_fetch_array($result);
				$frm_nama_nrp6 = $row["nama"];
		  ?>
          <tr>
            <td width="5%">6.</td>
            <td nowrap><? echo $frm_nrp6;?></td>
            <td nowrap><? echo $frm_nama_nrp6;?></td>
          </tr>
		  <? } if ($frm_nrp7<>''){
		  		$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp7'");
				$row = mysql_fetch_array($result);
				$frm_nama_nrp7 = $row["nama"];
		  ?>
          <tr>
            <td width="5%">7.</td>
            <td nowrap><? echo $frm_nrp7;?></td>
            <td nowrap><? echo $frm_nama_nrp7;?></td>
          </tr>
		  <? } if ($frm_nrp8<>''){
		  		$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp8'");
				$row = mysql_fetch_array($result);
				$frm_nama_nrp8 = $row["nama"];
		  ?>
          <tr>
            <td width="5%">8.</td>
            <td nowrap><? echo $frm_nrp8;?></td>
            <td nowrap><? echo $frm_nama_nrp8;?></td>
          </tr>
          <? } ?>           
		  </table>
		  </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%"  border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td>Sehubungan dengan hal diatas, maka bersama ini kami kirimkan lembar penilaian Kerja Praktek yang bersifat &quot;Rahasia&quot;. Selanjutnya mohon di isi dan dikembalikan kepada kami melalui post dengan amplop tertutup dialamatkan pada : </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="70%"  border="0" cellspacing="0" cellpadding="1">
          <tr>
            <td>Wakil Dekan Fakultas Teknik </td>
          </tr>
          <tr>
            <td>Universitas Surabaya </td>
          </tr>
          <tr>
            <td>Jln. Raya Kalirungkut. Surabaya </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Atas perhatian dan kerja sama yang baik, kami ucapkan terima kasih </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%"  border="0" align="right" cellpadding="2" cellspacing="0">
          <tr>
            <td><table width="100%"  border="0" align="right" cellpadding="2" cellspacing="0">
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
                <td width="59%">Wakil Dekan,</td>
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
						$sql_WD="SELECT nama FROM jabatan_struktural WHERE jabatan='Wakil Dekan'";
						$result_WD = mysql_query($sql_WD);
						if ($row_WD = mysql_fetch_array($result_WD)) {
						echo $row_WD["nama"];
					}
					?>
                </td>
              </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td></td>
        </tr>
    </table></td>
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