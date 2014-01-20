<? 
session_start();
include("../../include/js_function.js");
require("../../include/global.php");
require("../../include/fungsi.php");
?>
<html>
<head>
<title>: : CETAK SURAT TUGAS LP : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
</head>
<body>
<? 
f_connecting();
	mysql_select_db($DB);
	
$var_no_st_lp=$_GET['no_ST_LP'];
//echo "<br>var_no_st_lp=".$var_no_st_lp;

/*
$result = mysql_query("SELECT   master_mhs.NRP,
								master_mhs.NAMA,
								DATE_FORMAT(`master_lp`.`tgl_mulai`,'%d/%m/%Y') as tgl_lp,
								DATE_FORMAT(`master_lp`.`tgl_aju`,'%d/%m/%Y') as tgl_aju,
								master_lp. JUDUL1,
								master_lp. KODOS1,
								master_lp. KODOS2,
								no_surat_lp.URUT_ST,
								no_surat_lp.N_ST
					       FROM
								master_mhs, master_lp, no_surat_lp
					       WHERE
								master_mhs.NRP =  master_lp.NRP AND
								master_mhs.NRP =  no_surat_lp.NRP AND
								no_surat_lp.N_ST = '".$var_no_st_lp."'");
*/

$result = mysql_query("SELECT   master_mhs.NRP,
								master_mhs.NAMA,
								no_surat_lp.URUT_ST,
								no_surat_lp.N_ST
					       FROM
								master_mhs, no_surat_lp
					       WHERE master_mhs.NRP =  no_surat_lp.NRP AND
								 no_surat_lp.N_ST = '".$var_no_st_lp."'");
								
							/*if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$var_nrp = $row["NRP"];
								$var_nama = $row["NAMA"];
								$var_judul_lp = $row["JUDUL1"];
								//echo "<br>NRP=".$var_nrp;
								//echo "<br>Nama=".$var_nama;
								$var_tgl_aju = $row["tgl_aju"];
								if ($row["tgl_aju"]=="00/00/0000") {
								$var_tgl_aju = ""; }else {
								$var_tgl_aju = $row["tgl_aju"];}
								
								$var_tgl_ta = $row["tgl_lp"];
								if ($row["tgl_lp"]=="00/00/0000") {
								$var_tgl_ta = ""; }else {
								$var_tgl_ta = $row["tgl_lp"];}
								
								$var_kodobing_1 = $row["KODOS1"];
								$var_kodobing_2 = $row["KODOS2"];
								
							}else
							{$frm_exist=0;// header("Location: mhs_perpanjangan_ta.php"); 
							}*/
							
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
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td width="400%" colspan="4" align="center"><font size="3">S U R A T&nbsp;&nbsp; T U G A S</font></td>
        </tr>
      <tr>
        <td colspan="4" align="center">Membimbing Penelitian</td>
      </tr>
      <tr>
        <td colspan="4" align="center"><hr align="center" width="35%">
          <? 
		  //$jur_kp=substr($frm_kode_KP, 0,2);     
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

		  echo "Nomor  : ". $var_no_st_lp ."/ST/LP/Dek/FT/".$bln_romawi."/".date('Y');
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
        <td><table width="60%"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td><table width="30%"  border="1" align="center" cellpadding="3" cellspacing="0">
              <tr>
                <td><strong>No.</strong></td>
                <td width="22%">&nbsp;<strong>NRP</strong></td>
                <td width="73%">&nbsp;<strong>NAMA</strong></td>
              </tr>
              <? $nomor=1;
			while($row = mysql_fetch_array($result))
	        {
		     ?>
              <tr>
                <td width="5%" nowrap><? echo $nomor;?>.</td>
                <td nowrap>&nbsp;<?  echo $row['NRP'];?></td>
                <td nowrap>&nbsp;<? echo $row['NAMA'];?></td>
              </tr>
              <?
			   $nomor++;
		     } ?> 
		  
		  <?
		  $result2 = mysql_query("SELECT  	DATE_FORMAT(`master_lp`.`tgl_mulai`,'%d/%m/%Y') as tgl_lp,
											DATE_FORMAT(`master_lp`.`tgl_aju`,'%d/%m/%Y') as tgl_aju,
											master_lp. JUDUL1,
											master_lp. KODOS1,
											master_lp. KODOS2,
											no_surat_lp.URUT_ST,
											no_surat_lp.N_ST
								 FROM master_lp, no_surat_lp
								 WHERE no_surat_lp.NRP =  master_lp.NRP AND
									   no_surat_lp.N_ST = '".$var_no_st_lp."'");
		 
		 while($row2 = mysql_fetch_array($result2))
	        {						 
			 $var_kodobing_1=$row2["KODOS1"];
			 $var_kodobing_2=$row2["KODOS2"];
			 $var_judul_lp=$row2["JUDUL1"];
			 // URGENDA.....?
			 //$var_no_urut_agenda=$row2["URGENDA"];
			 if ($row2["tgl_aju"]=="00/00/0000") {
			 $var_tgl_aju = ""; }else {
			 $var_tgl_aju = $row2["tgl_aju"];}
		 	 $nomor++;
		  } ?>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%"  border="0" cellspacing="0" cellpadding="2">
              <tr>
                
                <td align="right"><? echo "TANGGAL : ".$var_tgl_aju;?></td>
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
        <td>dalam rangka PENELITIAN dengan judul : </td>
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
				echo $var_judul_lp;
			?>
			</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>dan kesediaan dari  dosen pembimbing  PENELITIAN, dengan ini menugaskan kepada : </td>
      </tr>
      <tr>
        <td></td>
      </tr>
      <tr>
        <td><table width="70%"  border="0" align="center" cellpadding="2" cellspacing="0">
          <?
				
				if ($var_kodobing_1!='') {
					$result = mysql_query("Select nama from dosen where kode='$var_kodobing_1'");
					$row2 = mysql_fetch_array($result);
					$var_nama_dobing_1 = $row2["nama"];
				}	
				
				if ($var_kodobing_2!='') {
					$result = mysql_query("Select nama from dosen where kode='$var_kodobing_2'");
					$row2 = mysql_fetch_array($result);
					$var_nama_dobing_2 = $row2["nama"];
				}	
		  ?>
		  <tr>
            <td width="14%" nowrap><? echo "1.".$var_kodobing_1;?></td>
            <td width="86%" nowrap><? echo $var_nama_dobing_1;?></td>
          </tr>
		  <tr>
            <td width="14%" nowrap><? echo "2.".$var_kodobing_2;?></td>
            <td width="86%" nowrap><? echo $var_nama_dobing_2;?></td>
          </tr>
		  <?
		 // }
		  ?>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>sebagai  dosen pembimbing PENELITIAN untuk mahasiswa tersebut di atas dalam waktu paling lambat 12 (dua belas) bulan dari tanggal Surat Tugas ini dibuat </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Harap dilaksanakan sebaik-baiknya.</td>
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
					$sql_dekan="SELECT nama FROM jabatan_struktural WHERE jabatan='Dekan'";
					$result_dekan = mysql_query($sql_dekan);
					if ($row_dekan = mysql_fetch_array($result_dekan)) {
					echo "(<u>".$row_dekan["nama"]."</u>)";
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
        <td colspan="2">2. Wakil Dekan Fakultas Teknik Univ. Surabaya</td>
        </tr>
      <tr>
        <td colspan="2" valign="top">3. Arsip</td>
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