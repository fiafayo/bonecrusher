<? 
/* 
   DATE CREATED : 12/07/07
   KEGUNAAN     : CETAK ST TA
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
   
   PERUBAHAN    : 15/12/2009 - perubahan format ST TA 
   							 - dari  /STTA/Dek/FT/2009 menjadi 002810910/SK/DEK/FT/XII/2009 
							 - penghapusan tembusan kepada untuk point 2. Wakil Dekan Fakultas Teknik Univ. Surabaya
*/
session_start();
include("../../include/js_function.js");
require("../../include/global.php");
require("../../include/fungsi.php");
?>
<html>
<head>
<title>: : CETAK SURAT TUGAS MEMBIMBING TA : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
</head>
<body>
<? 
f_connecting();
mysql_select_db($DB);
	
$act= ( isset( $_REQUEST['act'] ) ) ? $_REQUEST['act'] : 0;
$frm_nrp= ( isset( $_REQUEST['frm_nrp'] ) ) ? $_REQUEST['frm_nrp'] : null;
$frm_judul_ta= ( isset( $_REQUEST['frm_judul_ta'] ) ) ? $_REQUEST['frm_judul_ta'] : '';
$frm_no_urut_ST_TA_terakhir= ( isset( $_REQUEST['frm_no_urut_ST_TA_terakhir'] ) ) ? $_REQUEST['frm_no_urut_ST_TA_terakhir'] : null;
$frm_kode_dosen_2= ( isset( $_REQUEST['frm_kode_dosen_2'] ) ) ? $_REQUEST['frm_kode_dosen_2'] : null;
$frm_tgl_ST_TA= ( isset( $_REQUEST['frm_tgl_ST_TA'] ) ) ? $_REQUEST['frm_tgl_ST_TA'] : null;
$frm_tgl_aju_TA= ( isset( $_REQUEST['frm_tgl_aju_TA'] ) ) ? $_REQUEST['frm_tgl_aju_TA'] : null;

$pesan= ( isset( $_REQUEST['pesan'] ) ) ? $_REQUEST['pesan'] : null;
$error= ( isset( $_REQUEST['error'] ) ) ? $_REQUEST['error'] : null;

$var_nrp=$_GET['nrp'];
$var_no_ST_TA=$_GET['no_ST_TA'];
$var_tgl_surat_dibuat=$_GET['tgl_surat'];
//$var_tgl_surat_dibuat=datetomysql($var_tgl_surat_dibuat);
//echo "<br>var_nrp".$var_nrp;
//echo "<br>var_no_ST_TA".$var_no_ST_TA;
//exit();
$result = mysql_query("SELECT   master_mhs.NRP,
								master_mhs.NAMA,
								DATE_FORMAT(`master_ta`.`tgl_ta`,'%d/%m/%Y') as tgl_ta_mhs,
								DATE_FORMAT(`master_ta`.`tgl_aju`,'%d/%m/%Y') as tgl_aju,
								master_ta. JUDUL_TA,
								master_ta. KODOS1,
								master_ta. KODOS2,
								no_surat.N_ST
					   FROM
								master_mhs, master_ta, no_surat
					   WHERE
								master_mhs.NRP =  master_ta.NRP AND
								master_mhs.NRP =  no_surat.NRP AND
								master_mhs.NRP =  '".$var_nrp."'");
								
							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$var_nama = $row["NAMA"];
								$var_judul_ta = $row["JUDUL_TA"];
								//$var_no_SP_TA = $row["N_ulur"];
								
								$var_tgl_aju = $row["tgl_aju"];
								if ($row["tgl_aju"]=="00/00/0000") {
								$var_tgl_aju = ""; }else {
								$var_tgl_aju = $row["tgl_aju"];}
								
								$var_tgl_ta = $row["tgl_ta_mhs"];
								if ($row["tgl_ta_mhs"]=="00/00/0000") {
								$var_tgl_ta = ""; }else {
								$var_tgl_ta = $row["tgl_ta_mhs"];}
								
								$var_kodobing_1 = $row["KODOS1"];
								$var_kodobing_2 = $row["KODOS2"];
								
							}else
							{
								$frm_exist=0;// header("Location: mhs_perpanjangan_ta.php"); 
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
        <td height="5" colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="5" colspan="4" align="center">
		<input type="submit" name="Submit" value="PRINT" onClick="cetak();" style=" cursor:pointer; position:absolute; left:604px; top:32px; width:52px; height:18px; z-index:1; background-color: #CCCCCC; layer-background-color: #CCCCCC; border: 1px none #000000;" class="noPrint">
		</td>
      </tr>
      <tr>
        <td height="5" colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="5" colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="5" colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="5" colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="5" colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center"><font size="3">S U R A T&nbsp;&nbsp; T U G A S</font></td>
        </tr>
      <tr>
        <td colspan="4" align="center">membimbing Tugas Akhir</td>
      </tr>
      <tr>
        <td colspan="4" align="center"><hr align="center" width="35%">
		
		<? 
		
		$thn_TA = substr($var_tgl_aju, 6,4); 
		$bln_TA = substr($var_tgl_aju, 3,2); 
		//echo "<br>var_tgl_aju=".$var_tgl_aju;
		switch ($bln_TA) {
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
		
           echo "Nomor  : ". $var_no_ST_TA ."/STTA/DEK/FT/".$bln_romawi."/".$thn_TA;?></td>
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
            <td nowrap>Tanggal</td>
            <td><strong>:</strong></td>
            <td nowrap>
			<?php 
				set_tanggal($var_tgl_aju);
				function set_tanggal($var_tgl_aju)
				{
				
				$bln_lahir = substr($var_tgl_aju, 3,2); 
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
							
						$bln_lahir_hps = substr($var_tgl_aju, 2,4);
						$newphrase = str_replace($bln_lahir_hps, $bln_nama, $var_tgl_aju);
						echo $newphrase;
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
        <td>dalam rangka pembuatan skripsi/Tugas Akhir dengan judul : </td>
        </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="70%"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td><? echo $var_judul_ta;?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>dan kesediaan dari dosen pembimbing skripsi/Tugas Akhir, dengan ini menugaskan kepada : </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="70%"  border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
            <td width="15%" nowrap><? echo "1.$var_kodobing_1";?>.</td>
            <td width="82%" nowrap><? echo $var_nama_dobing_1;?></td>
          </tr>
          <tr>
            <td><? echo "2.$var_kodobing_2";?>.</td>
            <td nowrap><? echo $var_nama_dobing_2;?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>sebagai dosen pembimbing skripsi/Tugas Akhir untuk mahasiswa tersebut di atas dalam waktu paling lambat 6 (enam) bulan dari tanggal Surat Tugas ini dibuat. </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Harap dilaksanakan sebaik-baiknya. </td>
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
		 <? $bln_surat_TA = substr($var_tgl_surat_dibuat, 5,2);
			  switch ($bln_surat_TA) {
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
			$tgl_TA = substr($var_tgl_surat_dibuat, 8,2);	
			$thn_TA = substr($var_tgl_surat_dibuat, 0,4);
			$date = "Surabaya, ".$tgl_TA." ".$bln_nama." ".$thn_TA;
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
        <td colspan="2" nowrap>1. Kepala Biro ADPESDAM</td>
        </tr>
      <tr>
        <td colspan="2" valign="top">2. Arsip</td>
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