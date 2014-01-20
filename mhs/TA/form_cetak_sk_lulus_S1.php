<?
/* 
   DATE CREATED : 12/07/07
   KEGUNAAN     : CETAK SK DEKAN PENGUJI TA
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
   
   PERUBAHAN    : 17/12/2009 - perubahan format SK DEKAN 
   							 - dari  002810910/SK/DK/TA/2009 menjadi 002810910/SK/DEK/FT/XII/2009 
							 - perubahan tembusan kepada untuk point 4. Kepala BAAK Universitas Surabaya menjadi Kepala Biro Admik Universitas Surabaya
*/ 
session_start();
include("../../include/js_function.js");
require("../../include/global.php");
require("../../include/fungsi.php");
?>
<html>
<head>
<title>: : CETAK SK LULUS S-1 : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
</head>
<body>
<? 
f_connecting();
	mysql_select_db($DB);
	
$var_nrp = $_GET['nrp'];
$var_no_SK_S1 = $_GET['no_SK_S1'];
$var_tgl_surat_dibuat = $_GET['tgl_surat']; 
//echo "<br>var_tgl_surat_dibuat".$var_tgl_surat_dibuat;

$result = mysql_query("SELECT   master_mhs.NRP,
								master_mhs.NAMA,
								master_mhs.TMPLAHIR,
								DATE_FORMAT(`master_mhs`.`TGLLAHIR`,'%d/%m/%Y') as tgl_lahir,
								DATE_FORMAT(`lulus_ta`.`tgl_lulus`,'%d/%m/%Y') as tgl_lulus,
								master_ta. JUDUL_TA,
								master_ta. KODOS1,
								master_ta. KODOS2,
								lulus_ta.bidang_minat
					   FROM
								master_mhs, master_ta, lulus_ta
					   WHERE
								master_mhs.NRP =  master_ta.NRP AND
								master_mhs.NRP =  lulus_ta.NRP AND
								master_mhs.NRP =  '".$var_nrp."'");
								
							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$var_nama = $row["NAMA"];
								$var_judul_ta = $row["JUDUL_TA"];
								$var_tmp_lahir = $row["TMPLAHIR"];
								
								$var_tgl_lahir = $row["tgl_lahir"];
								if ($row["tgl_lahir"]=="00/00/0000") {
								$var_tgl_lahir = ""; }else {
								$var_tgl_lahir = $row["tgl_lahir"];}
								
								$var_tgl_lulus = $row["tgl_lulus"];
								if ($row["tgl_lulus"]=="00/00/0000") {
								$var_tgl_lulus = ""; }else {
								$var_tgl_lulus = $row["tgl_lulus"];}
								
								$var_kodobing_1 = $row["KODOS1"];
								$var_kodobing_2 = $row["KODOS2"];
								
								$var_bidang_minat = $row["bidang_minat"];
								
							}else
							{$frm_exist=0;// header("Location: mhs_perpanjangan_ta.php"); 
							}
							
							if ($var_kodobing_1!='') {
								$result = mysql_query("Select NPK, nama from dosen where kode='$var_kodobing_1'");
								$row = mysql_fetch_array($result);
								$var_nip_dobing_1 = $row["NPK"];
								$var_nama_dobing_1 = $row["nama"];
							}	
							
							if ($var_kodobing_2!='') {
								$result = mysql_query("Select NPK, nama from dosen where kode='$var_kodobing_2'");
								$row = mysql_fetch_array($result);
								$var_nip_dobing_2 = $row["NPK"];
								$var_nama_dobing_2 = $row["nama"];
							}	
							
//insert No_surat_SK_lulus_S1
//echo "<br>var_no_SK_S1=".$var_no_SK_S1;
//echo "<br>var_nrp=".$var_nrp;
			/*
			$result_cek = mysql_query("SELECT no_surat.N_urut_SK_LULUS FROM no_surat ORDER BY no_surat.N_urut_SK DESC");
			$row_result_cek = mysql_fetch_array($result_cek);
			$frm_no_urut_SK_S1_terakhir = $row_result_cek["N_urut_SK"];
			//echo "<br>frm_no_urut_SK_S1_terakhir1=".$frm_no_urut_SK_S1_terakhir;
			$frm_no_urut_SK_S1_terakhir++;
			//echo "<br>frm_no_urut_SK_S1_terakhir2=".$frm_no_urut_SK_S1_terakhir;
			
			$result_cek_urut_SK = mysql_query("SELECT no_surat.N_urut_SK FROM no_surat WHERE no_surat.NRP='$var_nrp'");
			$row_result_cek_urut_SK = mysql_fetch_array($result_cek_urut_SK);
			if ($row_result_cek_urut_SK["N_urut_SK"]==0)
			{
			  $result_update1 = mysql_query("UPDATE no_surat SET no_surat.N_SK='$var_no_SK_S1', no_surat.N_urut_SK=$frm_no_urut_SK_S1_terakhir WHERE no_surat.NRP='$var_nrp'");
			}
			else
			{
			  $result_update1 = mysql_query("UPDATE no_surat SET no_surat.N_SK='$var_no_SK_S1' WHERE no_surat.NRP='$var_nrp'");
			}
			//if ($result_update1)
			//{
				//echo "SIP updated";
			//}
			if (!($result_update1))
			{
				$error = 1;
				$pesan = $pesan."<br>GAGAL menyimpan nomor SK lulus S1. Segera hubungi administrator". mysql_error();
				echo $pesan;
			}
*/
?>

<table width="80%"  border="0" align="center" cellpadding="0" cellspacing="0">
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
        <td width="400%" colspan="4" align="center"><font size="3">KETERANGAN SELESAI PROGRAM SARJANA STRATA SATU</font></td>
        </tr>
      <tr>
        <td colspan="4" align="center"><hr align="center" width="82%">
          <? 
		  $jur_kp=substr($frm_kode_KP, 0,2);     
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
		  echo "Nomor  : ". $var_no_SK_S1 ."/S1S/DEK/FT/".$bln_romawi."/".date('Y'); ?></td>
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
        <td>Dekan Fakultas Teknik Universitas Surabaya, menerangkan bahwa :</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="50%"  border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
            <td width="21%">Nama</td>
            <td width="2%"><strong>:</strong></td>
            <td width="77%" nowrap><? echo $var_nama;?></td>
          </tr>
          <tr>
            <td>NRP</td>
            <td><strong>:</strong></td>
            <td nowrap><? echo $var_nrp;?></td>
          </tr>
          <tr>
            <td nowrap>Lahir di </td>
            <td><strong>:</strong></td>
            <td nowrap><? echo $var_tmp_lahir;?></td>
          </tr>
          <tr>
            <td nowrap>Tanggal</td>
            <td><strong>:</strong></td>
            <td nowrap>
			<?php 
			set_tanggal($var_tgl_lahir);
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
        </table></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="70%"  border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
            <td colspan="4" nowrap>Dosen pembimbing : </td>
            </tr>
          <tr>
            <td width="6%" nowrap>&nbsp;</td>
            <td width="4%" nowrap><? echo "1";?>.</td>
            <td width="70%" nowrap><? echo $var_nama_dobing_1;?></td>
            <td width="20%" nowrap><? echo "(".$var_nip_dobing_1.")";?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><? echo "2";?>.</td>
            <td nowrap><? echo $var_nama_dobing_2;?></td>
            <td nowrap><? echo "(".$var_nip_dobing_2.")";?></td>
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
        <td><table width="80%"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2">Judul Tugas Akhir : </td>
            </tr>
          <tr>
            <td width="4%">&nbsp;</td>
            <td width="96%"><? echo $var_judul_ta;?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>telah menyelesaikan Program Pendidikan Sarjana Strata Satu pada :</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="50%"  border="0" align="center" cellpadding="2" cellspacing="0">
          <tr valign="top">
            <td width="21%">Fakultas</td>
            <td width="2%"><strong>:</strong></td>
            <td width="77%">T E K N I K</td>
          </tr>
          <tr valign="top">
            <td>Jurusan</td>
            <td><strong>:</strong></td>
            <td nowrap>
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
          <tr valign="top">
            <td nowrap>Program Studi </td>
            <td><strong>:</strong></td>
            <td>S-1</td>
          </tr>
          <tr valign="top">
            <td nowrap>Bidang Minat </td>
            <td><strong>:</strong></td>
            <td nowrap><? echo $var_bidang_minat;?></td>
          </tr>
          <tr valign="top">
            <td nowrap>Tanggal</td>
            <td><strong>:</strong></td>
            <td nowrap><?php set_tanggal($var_tgl_lulus); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Mahasiswa tersebut di atas tinggal menunggu ijasah Sarjana S1 yang masih dalam proses. </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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
		 // echo "<br>var_tgl_surat=".$var_tgl_surat;
		  $tgl=substr($var_tgl_surat_dibuat, 0,2);  
		  $bln=substr($var_tgl_surat_dibuat, 3,2);
		  $thn=substr($var_tgl_surat_dibuat, 6,4);  
		  
		 // echo "<br>bln=".$bln."<br>";   
		 // echo "<br>tgl=".$tgl."<br>"; 
		 // echo "<br>thn=".$thn."<br>"; 
		  	  
			switch ($bln) {
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
				
			$date = "Surabaya, ".$tgl." ".$bln_nama." ".$thn;
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
      <tr>
        <td>&nbsp;</td>
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
    <td><table width="90%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2">Tembusan kepada : </td>
        </tr>
      <tr>
        <td colspan="2" nowrap>1. Ketua Jurusan
          <? 
				$jurusan = substr($var_nrp, 3,1); 
				$sql_jur = "SELECT jurusan as nama_jurusan FROM jurusan WHERE id='$jurusan'";
				$result_jur=mysql_query($sql_jur);
				if ($row = mysql_fetch_array($result_jur)) {
				echo $row["nama_jurusan"];
				}
			?></td>
        </tr>
      <tr>
        <td colspan="2">2. Direktur Keuangan Universitas Surabaya</td>
        </tr>
      <tr>
        <td colspan="2" valign="top">3. Kepala Biro Adpesdam Universitas Surabaya </td>
      </tr>
      <tr>
        <td colspan="2" valign="top">4. Kepala  Biro Admik Universitas Surabaya </td>
      </tr>
      <tr>
        <td width="7%">&nbsp;</td>
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