<? 
/* 
   DATE CREATED : 30/05/07
   UPDATE       : 04/02/09 - penambahan jumlah mhs kp (total 6)
   				  18/06/09 - penambahan jumlah mhs kp (total 8)
				  19/05/10 - penggantian  dari "Kajur. Teknik Manufaktur" ke Ketua Jurusan Program Studi untuk DMP
   KEGUNAAN     : CETAK SURAT PERMOHONAN KP
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/
session_start();
include("../../include/js_function.js");
require("../../include/global.php");
require("../../include/fungsi.php");
?>
<html>
<head>
<title>: : CETAK SURAT PERMOHONAN KP : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
</head>
<body>
<? 
f_connecting();
	mysql_select_db($DB);
	
$var_no_mo_kp=$_GET['no_mo_kp'];
//echo "<br>var_no_mo_kp=".$var_no_mo_kp;

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
			  FROM  daftar_kp 
			 WHERE `daftar_kp`.`NO_MOHON`='".$var_no_mo_kp."'";
			  
$result = mysql_query($sql_ST_KP);
								
							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_kode_KP = $row["KODE_KP"];
								$frm_no_surat_pemohon = $row["NO_MOHON"];
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
								if ($row["TGL_AWAL"]=="00/00/0000") {
								$frm_tgl_mulai_KP =""; }else {
								$frm_tgl_mulai_KP =$row["TGL_AWAL"];}
								
								$frm_tgl_selesai_KP = $row["TGL_END"];
								if ($row["TGL_END"]=="00/00/0000") {
								$frm_tgl_selesai_KP =""; }else {
								$frm_tgl_selesai_KP =$row["TGL_END"];}
								
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
							
							if ($frm_kodobing!='') {
								$result = mysql_query("Select nama from dosen where kode='$frm_kodobing'");
								$row = mysql_fetch_array($result);
								$var_nama_dobing = $row["nama"];
							}	
							
							/*if ($var_kodobing_2!='') {
								$result = mysql_query("Select nama from master_karyawan where kode='$var_kodobing_2'");
								$row = mysql_fetch_array($result);
								$var_nama_dobing_2 = $row["nama"];
							}	*/
?>
<table width="80%"  border="0" align="center" cellpadding="0" cellspacing="0">
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
    <td><table width="100%"  border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="60%"  border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="12%" nowrap>Nomor</td>
            <td width="2%">:</td>
            <td width="86%">
					<? 
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
			$jur_nama="Teknik Manufaktur";
			$jur_kp_kode="DMP";
			break;
		case 'SI':
			$jur_nama="Teknik Informatika";
			$jur_kp_kode="SI";
			break;
		case 'MM':
			$jur_nama="Teknik Informatika";
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
			$jur_nama="Teknik Manufaktur";
			$jur_kp_kode="DMP";
			break;
		case '67':
			$jur_nama="Teknik Informatika";
			$jur_kp_kode="SI";
			break;
		case '68':
			$jur_nama="Teknik Informatika";
			$jur_kp_kode="MM";
			break;
	}
	 // echo "<br>jur_kp=".$jur_kp;
	  //echo "<br>jur_kp_kode=".$jur_kp_kode;
	  echo $frm_no_surat_pemohon ."/KP-".$jur_kp_kode."/KAJUR.".$jur_kp_kode."/FT/".$bln_romawi."/".date('Y');
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
            <td>Permohonan Kerja Praktik </td>
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
        <td><table width="60%"  border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td>Yang terhormat </td>
          </tr>
          <tr>
            <td>Bpk/Ibu. Pimpinan <? echo $frm_nama_pershn ;?> </td>
          </tr>
          <tr>
            <td><? echo "Jln.".$frm_alamat_KP;?></td>
          </tr>
          <tr>
            <td><? echo "di ".$frm_kota_KP;?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%"  border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td>Untuk memenuhi persyaratan kurikulum dalam memperoleh gelar Sarjana Teknik, kami mohon mahasiswa jurusan 
              			<?
						$jur_kp=substr($frm_kode_KP, 0,2);    
						switch ($jur_kp) {
						    case ($jur_kp=='TE' || $jur_kp=='61'):
								$jur='Teknik Elektro';
								break;
						    case ($jur_kp=='TK' || $jur_kp=='62'):
								$jur='Teknik Kimia';
								break;
						    case ($jur_kp=='TI' || $jur_kp=='63'):
								$jur='Teknik Industri';
								break;
						    case ($jur_kp=='IF' || $jur_kp=='64'):
								$jur='Teknik Informatika';
								break;
						    case ($jur_kp=='TM' || $jur_kp=='65'):
								$jur='Teknik Manufaktur';
								break;
						    case ($jur_kp=='DMP' || $jur_kp=='66'):
								$jur='Desain Manajemen Produk';
								break;
						    case ($jur_kp=='SI' || $jur_kp=='67'):
								$jur='Sistem Informasi';
								break;
						    case ($jur_kp=='MM' || $jur_kp=='68'):
								$jur='Multimedia';
								break;
/*
							case 'TK':
								$jur='Teknik Kimia';
								break;
							case 'TI':
								$jur='Teknik Industri';
								break;
							case 'IF':
								$jur='Teknik Informatika';
								break;
							case 'TM':
								$jur='Teknik Manufaktur';
								break;
							case 'DMP':
								$jur='Desain Manajemen Produk';
								break;
							case 'SI':
								$jur='Sistem Informasi';
								break;
							case 'MM':
								$jur='Multimedia';
								break;
							case '61':
								$jur='Teknik Elektro';
								break;
							case '62':
								$jur='Teknik Kimia';
								break;
							case '63':
								$jur='Teknik Industri';
								break;
							case '64':
								$jur='Teknik Informatika';
								break;
							case '65':
								$jur='Teknik Manufaktur';
								break;
							case '66':
								$jur='Desain Manajemen Produk';
								break;*/
						}
						echo $jur;
						?>
             di bawah ini: </td>
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
        <td><table width="10%"  border="1" cellpadding="2" cellspacing="0">
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
        </table></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="80%"  border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td>dapat diberikan kesempatan untuk melakukan Kerja Praktik pada instansi / perusahaan / pabrik yang Bapak/Ibu pimpin. </td>
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
        <td>Kerja Praktik tersebut direncanakan mulai: </td>
        </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="95%"  border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td nowrap>&nbsp;</td>
            <td nowrap><?
					$tgl_selesai=substr($frm_tgl_selesai_KP, 0,2); 
					$tgl_mulai=substr($frm_tgl_mulai_KP, 0,2); 
					$tgl_selisih=$tgl_selesai-$tgl_mulai;
					
					$bln_selesai=substr($frm_tgl_selesai_KP, 3,2); 
					$bln_mulai=substr($frm_tgl_mulai_KP, 3,2); 
					$bln_selisih=$bln_selesai-$bln_mulai;
					
					$thn_selesai=substr($frm_tgl_selesai_KP, 6,4); 
					$thn_mulai=substr($frm_tgl_mulai_KP, 6,4); 
					$thn_selisih=$thn_selesai-$thn_mulai;
					
					$jumlah_bulan = (($thn_selesai - $thn_mulai) * 12) + ($bln_selesai - $bln_mulai);
					//pembulatan bulan
					/*if ($tgl_selesai < $tgl_mulai) {
					$jumlah_bulan = $jumlah_bulan - 1;
					}*/

					/*echo "<br>tgl_selesai= ".$tgl_selesai;
					echo "<br>tgl_mulai= ".$tgl_mulai;
					echo "<br>tgl_selisih= ".$tgl_selisih;
					echo "<br>bln_selesai= ".$bln_selesai;
					echo "<br>bln_mulai= ".$bln_mulai;
					echo "<br>bln_selisih= ".$bln_selisih;
					echo "<br>thn_selesai= ".$thn_selesai;
					echo "<br>thn_mulai= ".$thn_mulai;
					echo "<br>thn_selisih= ".$thn_selisih;
					echo "<br>selisih= ".abs($jumlah_bulan);*/
				?>
  Tanggal :&nbsp; <? echo $frm_tgl_mulai_KP."&nbsp;&nbsp;<b>sampai dengan</b>&nbsp;&nbsp;".$frm_tgl_selesai_KP;?>&nbsp;&nbsp;<? echo "<b>(".abs($jumlah_bulan)." bulan)</b>";?>
			</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%"  border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td><div align="justify">Selanjutnya kami mengharapkan kesediaan salah seorang wakil/staf untuk membina dan membimbing mahasiswa tersebut dalam melaksanakan Kerja Praktik di perusahaan Bapak.
                  <br>
                  <br>
                Mohon surat persetujuan/balasan dapat dikirim kepada kami, dengan menyebutkan nama pembimbing dari perusahaan yang Bapak/Ibu tunjuk. </div></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Atas perhatian dan kerjasama yang Bapak/Ibu berikan, kami ucapkan terima kasih. </td>
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
		<table width="100%"  border="0" align="right" cellpadding="2" cellspacing="0">
          <tr>
            <td width="50%"><table width="100%"  border="0" align="left" cellpadding="2" cellspacing="0">
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
                <td width="59%" nowrap>
                  <? 
						if (($jur_kp=='TM') or ($jur_kp=='65'))
						{
							//echo "Kaprodi. ".$jur_nama;
							echo "Ketua Program Studi";
						}
						else if (($jur_kp=='DMP') or ($jur_kp=='66'))
						{
							echo "Ketua Program Studi";
						}
						else
						{
							echo "Kajur. ".$jur_nama;
						}
						?>
                  , </td>
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
					 
					 //disini
					 //echo "<br>jur_kp= ".$jur_kp;
						switch ($jur_kp) {
							case ("61"):
							case ("TE"):
								$kajur='6';
								break;
							case ("62"):
							case ("TK"):
								$kajur='7';
								break;
							case ("63"):
							case ("TI"):
								$kajur='8';
								break;
							case ("64"):
							case ("IF"):
								$kajur='9';
								break;
							case ("65"):
							case ("TM"):
								$kajur='10';
								break;
							case ("66"):
							case ("DMP"):
								$kajur='12';
								break;
							case ("67"):
							case ("SI"):
								$kajur='9';
								break;
							case ("68"):
							case ("MM"):
								$kajur='9';
								break;
						}
					$sql_kajur="SELECT nama FROM jabatan_struktural WHERE id=$kajur";
					$result_kajur = mysql_query($sql_kajur);
					if ($row_kajur = mysql_fetch_array($result_kajur)) {
					echo $row_kajur["nama"];
					}
					?>
                </td>
              </tr>
            </table></td>
            <td width="50%">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table>	
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td>
		  <!--form>
		 	 <input type='button' onclick='javascript:cetak();' name="button" value="PRINT">
		  </form-->
	</td>
  </tr>
</table>
</body>
</html>