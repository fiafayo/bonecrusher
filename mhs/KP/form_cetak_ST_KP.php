<? 
/* 
   DATE CREATED : 28/09/07
   UPDATE       : 04/02/09 - penambahan jumlah mhs kp (total 6)
   				  18/06/09 - penambahan jumlah mhs kp (total 8)
   KEGUNAAN     : CETAK SURAT TUGAS KP
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
<title>: : CETAK SURAT TUGAS KP : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>
<body>

<? 
f_connecting();
	mysql_select_db($DB);
	
$var_no_st_kp=$_GET['no_ST_KP'];
$var_tgl_surat_dibuat=$_GET['tgl_surat'];
//echo "<br>var_tgl_surat_dibuat:".$var_tgl_surat_dibuat;
//echo "<br>var_no_st_kp=".$var_no_st_kp;

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
			   FROM daftar_kp 
			  WHERE`daftar_kp`.`NO_ST`='".$var_no_st_kp."'";
			  
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
								//echo "<br>frm_nrp1=".$frm_nrp1;
								//echo "<br>frm_nrp2=".$frm_nrp2;
								//echo "<br>frm_nrp3=".$frm_nrp3;
								//echo "<br>frm_nrp4=".$frm_nrp4;
								//echo "<br>frm_nrp5=".$frm_nrp5;
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
<table width="80%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="4" align="center"><input type="submit" name="Submit" value="PRINT" onClick="cetak();" style=" cursor:pointer; position:absolute; left:604px; top:32px; width:52px; height:18px; z-index:1; background-color: #CCCCCC; layer-background-color: #CCCCCC; border: 1px none #000000;" class="noPrint">
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
        <td width="400%" colspan="4" align="center"><font size="3">S U R A T&nbsp;&nbsp; T U G A S</font></td>
        </tr>
      <tr>
        <td colspan="4" align="center">Membimbing Kerja Praktek</td>
      </tr>
      <tr>
        <td colspan="4" align="center"><hr align="center" width="35%">
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
		 // echo "<br>jur_kp=".$jur_kp;
		  //echo "<br>jur_kp_kode=".$jur_kp_kode;
		  echo "Nomor  : ". $var_no_st_kp ."/ST/KP-".$jur_kp_kode."/Dek/FT/".$bln_romawi."/".date('Y');
		  ?></td>
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
        <td>Dekan Fakultas Teknik Universitas Surabaya setelah memperhatikan permohonan dari : </td>
        </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="30%"  border="1" align="center" cellpadding="2" cellspacing="0">
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
        <td>dalam rangka kerja praktek di : </td>
        </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="70%"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="27%">&nbsp;</td>
            <td width="73%">
			<? 
				echo $frm_nama_pershn;
				echo "<br>Jln.".$frm_alamat_KP;
				echo "<br>".$frm_kota_KP;
			?>
			</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>dan kesediaan dari  pembimbing Kerja Praktek, dengan ini menugaskan kepada : </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><? 
			if ($frm_kodobing!='') {
				$result = mysql_query("Select nama from dosen where kode='$frm_kodobing'");
				$row = mysql_fetch_array($result);
				$frm_nama_dobing = $row["nama"];
			}
		?></td>
      </tr>
      <tr>
        <td><table width="70%"  border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
            <td width="14%" nowrap><? //echo "1.$frm_kodobing";?>1. Bpk/Ibu</td>
            <td width="86%" nowrap><? echo $frm_nama_dobing;?></td>
          </tr>
          <tr>
            <td width="14%" nowrap>2. Bpk/Ibu</td>
            <td width="86%" nowrap><? echo $frm_nabing_pershn;?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>sebagai  pembimbing kerja praktek untuk mahasiswa tersebut di atas.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Mahasiswa yang bersangkutan diharapkan menyelesaikan laporan tertulis yang dinilai oleh pembimbing dalam waktu paling lama 60 hari setelah kerja praktek tersebut selesai.</td>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="40%"  border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td>
              <? $bln_surat_tugas_KP = substr($var_tgl_surat_dibuat, 3,2);
			  switch ($bln_surat_tugas_KP) {
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
			$tgl_ST_KP = substr($var_tgl_surat_dibuat, 0,2);	
			$thn_ST_KP = substr($var_tgl_surat_dibuat, 6,4);
			$date = "Surabaya, ".$tgl_ST_KP." ".$bln_nama." ".$thn_ST_KP;
		 	echo $date;
		 ?>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
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
            <td nowrap>
              <? 
			  $sql_dek="SELECT nama FROM jabatan_struktural WHERE jabatan='Dekan'";
			  $result_dek = mysql_query($sql_dek);
			  if ($row_dek = mysql_fetch_array($result_dek)) {
			  	echo $row_dek["nama"];
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
        <td>&nbsp;</td>
      </tr>
    </table></td>
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
        <td colspan="2" nowrap>1. Kepala Biro ADPESDAM</td>
        </tr>
      <tr>
        <td colspan="2">2. Wakil Dekan Fakultas Teknik Univ. Surabaya</td>
        </tr>
		<?
		switch ($jur_kp) {
			case 'TE':
				$kajur='TEKNIK ELEKTRO';
				break;
			case 'TK':
				$kajur='TEKNIK KIMIA';
				break;
			case 'TI':
				$kajur='TEKNIK INDUSTRI';
				break;
			case 'IF':
				$kajur='TEKNIK INFORMATIKA';
				break;
			case 'TM':
				$kajur='TEKNIK MANUFAKTUR';
				break;
		}
		
		?>
      <tr>
        <td colspan="2" valign="top">3. Ketua Jurusan <? echo $kajur;?></td>
        </tr>
      <tr>
        <td width="6%">&nbsp;</td>
        <td width="94%">&nbsp;</td>
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