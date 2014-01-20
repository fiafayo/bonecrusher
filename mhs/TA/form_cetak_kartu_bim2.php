<?
/* 
   DATE CREATED : 30/05/07
   KEGUNAAN     : FORM CETAK KARTU BIMBINGAN UNTUK DOSEN PEMBIMBING 2
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
   UPDATE       : 24/05/2011 - tanggal mulai TA berdasarkan tanggal tanggal ST TA, sebelumnya berdasarkan tanggal pengajuan TA
*/

session_start();
include("../../include/js_function.js");
require("../../include/global.php");
require("../../include/fungsi.php");
?>
<html>
<head>
<title>: : CETAK KARTU BIMBINGAN 2 : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
/*.style2 {font-family: "Times New Roman", Times, serif}*/
-->
</style>
</head>
<body>
<? 
f_connecting();
	mysql_select_db($DB);
	
$var_nrp = $_GET['nrp'];
$var_no_SK_S1 = $_GET['no_SK_S1'];

$result = mysql_query("SELECT   master_mhs.NRP,
								master_mhs.NAMA,
								master_mhs.NIRM,
								DATE_FORMAT(`master_ta`.`TGL_AJU`,'%d/%m/%Y') as TGL_AJU,
								DATE_FORMAT(`master_ta`.`AKHIR1`,'%d/%m/%Y') as TGL_AKHIR,
								DATE_FORMAT(`master_ta`.`TGL_TA`,'%d/%m/%Y') as TGL_TA,
								master_ta.JUDUL_TA,
								master_ta.KODOS1,
								master_ta.KODOS2
					   FROM
								master_mhs, master_ta
					   WHERE
								master_mhs.NRP = master_ta.NRP AND
								master_mhs.NRP = '".$var_nrp."'");
								
							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$var_nama = $row["NAMA"];
								$var_NIRM = $row["NIRM"];
								$var_judul_ta = $row["JUDUL_TA"];
								
								$var_tgl_ST_TA = $row["TGL_TA"];
								if ($row["TGL_TA"]=="00/00/0000") {
								$var_tgl_ST_TA = ""; }else {
								$var_tgl_ST_TA = $row["TGL_TA"];}
								/*
								$var_tgl_aju = $row["TGL_AJU"];
								if ($row["TGL_AJU"]=="00/00/0000") {
								$var_tgl_aju = ""; }else {
								$var_tgl_aju = $row["TGL_AJU"];}*/
								
								$var_tgl_akhir = $row["TGL_AKHIR"];
								if ($row["TGL_AKHIR"]=="00/00/0000") {
								$var_tgl_akhir = ""; }else {
								$var_tgl_akhir = $row["TGL_AKHIR"];}
								
								$var_kodobing_1 = $row["KODOS1"];
								$var_kodobing_2 = $row["KODOS2"];
							}else
							{$frm_exist=0;// header("Location: mhs_perpanjangan_ta.php"); 
							}
							
							if ($var_kodobing_1!='') {
								$result = mysql_query("Select NPK, nama from dosen where kode='$var_kodobing_1'");
								$row = mysql_fetch_array($result);
								$var_nip_dobing_1 = $row["nip"];
								$var_nama_dobing_1 = $row["nama"];
							}	
							
							if ($var_kodobing_2!='') {
								$result = mysql_query("Select NPK, nama from dosen where kode='$var_kodobing_2'");
								$row = mysql_fetch_array($result);
								$var_nip_dobing_2 = $row["nip"];
								$var_nama_dobing_2 = $row["nama"];
							}	
?>
<table width="80%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="400%" colspan="4" align="center"><strong><font size="3">KARTU BIMBINGAN SKRIPSI/TUGAS AKHIR</font></strong></td>
        </tr>
      <tr>
        <td colspan="4" align="center"><font size="+2"><b><u>FAKULTAS TEKNIK UNIVERSITAS SURABAYA</u></b></font></td>
      </tr>
      <tr>
        <td colspan="4" align="center">
		<input type="submit" name="Submit" value="PRINT" onClick="cetak();" style=" cursor:pointer; position:absolute; left:704px; top:20px; width:52px; height:18px; z-index:1; background-color: #CCCCCC; layer-background-color: #CCCCCC; border: 1px none #000000;" class="noPrint">
		</td>
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
        <td><table width="80%"  border="0" align="center" cellpadding="10" cellspacing="0">
          <tr>
            <td width="3%">1.</td>
            <td width="25%">Nama Mahasiswa </td>
            <td width="1%"><strong>:</strong></td>
            <td width="71%"><? echo $var_nama;?></td>
          </tr>
          <tr>
            <td>2.</td>
            <td>Nomor Pokok </td>
            <td><strong>:</strong></td>
            <td><? echo $var_nrp;?></td>
          </tr>
          <tr>
            <td nowrap>4.</td>
            <td nowrap>Jurusan</td>
            <td><strong>:</strong></td>
            <td>
				<? 
					$jurusan = substr($var_nrp, 3,1); 
					$sql_jur = "SELECT jurusan as nama_jurusan FROM jurusan WHERE id='$jurusan'";
					$result_jur=mysql_query($sql_jur);
					if ($row = mysql_fetch_array($result_jur)) {
					echo $row["nama_jurusan"];
					}
				?>
			</td>
          </tr>
          <tr>
            <td nowrap>5.</td>
            <td nowrap>Judul Skripsi/Tugas Akhir </td>
            <td><strong>:</strong></td>
            <td rowspan="2" valign="top"><? echo $var_judul_ta;?></td>
          </tr>
          <tr>
            <td nowrap>&nbsp;</td>
            <td nowrap>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td nowrap>6.</td>
            <td nowrap>Tanggal mengajukan Tugas Akhir </td>
            <td><strong>:</strong></td>
            <td>
              <?php 
			set_tanggal($var_tgl_ST_TA);
			function set_tanggal($var_tgl)
			{
			
			$bln_lahir = substr($var_tgl, 3,2); 
				  switch ($bln_lahir) {
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
						
					$bln_lahir_hps = substr($var_tgl, 2,4);
					$newphrase = str_replace($bln_lahir_hps, $bln_nama, $var_tgl);
					echo $newphrase;
			}
				  /*$bln_lahir = substr($var_tgl_lahir, 3,2); 
				  switch ($bln_lahir) {
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
						
					$bln_lahir_hps = substr($var_tgl_lahir, 2,4);
					$newphrase = str_replace($bln_lahir_hps, $bln_nama, $var_tgl_lahir);
					echo $newphrase;*/
				?>
            </td>
          </tr>
          <tr>
            <td nowrap>7.</td>
            <td nowrap>Selesai menulis Tugas Akhir </td>
            <td><strong>:</strong></td>
            <td><? set_tanggal($var_tgl_akhir);?></td>
          </tr>
          <tr>
            <td nowrap>8.</td>
            <td nowrap>Pembimbing</td>
            <td><strong>:</strong></td>
            <td>1. <? echo $var_kodobing_1;?> - <? echo $var_nama_dobing_1;?></td>
          </tr>
          <tr>
            <td nowrap>&nbsp;</td>
            <td nowrap>&nbsp;</td>
            <td>&nbsp;</td>
            <td>2. <? echo $var_kodobing_2;?> - <? echo $var_nama_dobing_2;?></td>
          </tr>
          <tr>
            <td nowrap>9.</td>
            <td nowrap>Keterangan</td>
            <td><strong>:</strong></td>
            <td>________________________________________</td>
          </tr>
          <tr>
            <td nowrap>&nbsp;</td>
            <td nowrap>&nbsp;</td>
            <td>&nbsp;</td>
            <td>________________________________________</td>
          </tr>
          <tr>
            <td nowrap>&nbsp;</td>
            <td nowrap>&nbsp;</td>
            <td>&nbsp;</td>
            <td>________________________________________</td>
          </tr>
          <tr>
            <td nowrap>&nbsp;</td>
            <td nowrap>&nbsp;</td>
            <td>&nbsp;</td>
            <td>________________________________________</td>
          </tr>
          <tr>
            <td nowrap>&nbsp;</td>
            <td nowrap>&nbsp;</td>
            <td>&nbsp;</td>
            <td>________________________________________</td>
          </tr>
          <tr>
            <td nowrap>&nbsp;</td>
            <td nowrap>&nbsp;</td>
            <td>&nbsp;</td>
            <td>________________________________________</td>
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
    <td><table width="40%"  border="0" align="right" cellpadding="0" cellspacing="0">
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
        <td>Tanda Tangan Pembimbing,</td>
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
        <td>(<u><? echo $var_nama_dobing_2;?></u>)</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
	</td>
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