<?php
/* 
   DATE CREATED : 30/05/07
   KEGUNAAN     : CETAK SL LULUS S-1
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
require("../../include/temp.php");


f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ 
// NRP dan nama harus diisi
	if (($frm_nrp=='') or ($frm_nama=='')) 
		{
			$error = 1;
			//$pesan=$pesan."<br>Maaf, anda harus mengisi nrp dan nama mahasiswa. Gagal menyimpan data.";
			$pesan=$pesan."<br>Maaf, Anda harus mengisi NRP dengan benar. Gagal Mencetak.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
					$sql_cek_mhs="SELECT `no_surat`.`NRP`
								  FROM no_surat 
								  WHERE `no_surat`.`NRP`='".$frm_nrp."'";
					$result = mysql_query($sql_cek_mhs);
					if ($row = mysql_fetch_array($result)) 
					{
						$result_cek = mysql_query("SELECT `NRP`, `N_SK`, `N_urut_SK` FROM no_surat WHERE `no_surat`.`NRP`='".$frm_nrp."'");
						$row_urut_SK = mysql_fetch_array($result_cek);
						$row_result_cek = mysql_num_rows($result_cek);

								if ($row_result_cek >= 1)
								{
									if ($row_urut_SK["N_urut_SK"]<>0)
									{
										$result_update1 = mysql_query("UPDATE no_surat set `N_SK`='$frm_no_SK_s1_baru' WHERE `NRP`='$frm_nrp'");
									}
									else
									{
										$result_update1 = mysql_query("UPDATE no_surat set `N_SK`='$frm_no_SK_s1_baru', `N_urut_SK`='$frm_no_urut_SK_s1_terakhir' WHERE `NRP`='$frm_nrp'");
									}
									
									if ($result_update1)
									{
										?>
										<script language="JavaScript">
											//return popitup('form_cetak_mohon_KP.php?no_mo_kp='+document.mhs.frm_no_mohon.value);
											//function popitup(url)
											//{
												newwindow=window.open('form_cetak_sk_lulus_S1.php?nrp=<? echo $frm_nrp;?>&nama=<? echo $frm_nama;?>&no_SK_S1=<? echo $frm_no_SK_s1_baru;?>','name','top=0,left=510,resizable=1,width=800,height=600, scrollbars=yes');
												if (window.focus) {newwindow.focus()}
												//return false;
											//}
											//return popitup('form_cetak_mohon_KP.php?no_mo_kp=<? echo $frm_no_mohon;?>');
											//return popitup('form_cetak_berita_acara_LP.php?nrp='+document.mhs.frm_NRP.value+'&periode='+document.mhs.frm_periode.value+'&thn_ajar='+document.mhs.frm_id_tahun_ajar.value);
											
										</script>
										<?
									}
									else
									{
										$error = 1;
										$pesan = $pesan."<br>Proses Cetak data GAGAL. Segera hubungi administrator". mysql_error();
									}
								}
								else
								{
									$error = 1;
									$pesan = $pesan."<br>Maaf, Silahkan masukkan data SK S-1. Gagal Mencetak.". mysql_error();
								}		
				    }
					else
					{
						//$pesan=$pesan."<br>Maaf, Mahasiswa belum pernah mengajukan Ganti Judul TA. Gagal Mencetak.11111";
						/*$result_insert1= mysql_query("INSERT INTO no_surat (`NRP`,`N_SKDP`,`N_ST`,`N_SK`,`N_ULUR`,`N_GANDOS`,`N_GANDUL`,`N_urut_SK`,`N_undangan`,`N_urut_ST`,`N_urut_gandul`,`N_urut_gandos`,`N_urut_ulur`,`N_urut_undangan`) VALUES ( '".$frm_nrp."', '', '', '".$frm_no_SK_s1_baru."', '', '', '',".$frm_no_urut_SK_s1_terakhir.",NULL,NULL,NULL,NULL,NULL,NULL)");
						if ($result_insert1)
						{
								?>
								<script language="JavaScript">
								newwindow=window.open('form_cetak_sk_lulus_S1.php?nrp=<? echo $frm_nrp;?>&nama=<? echo $frm_nama;?>&no_SK_S1=<? echo $frm_no_SK_s1_baru;?>','name','top=0,left=510,scrollbars=yes');
								if (window.focus) {newwindow.focus()}
								</script>
								<?
						}
						else
						{
							$error = 1;
							$pesan = $pesan."<br>Proses Cetak data GAGAL. Segera hubungi administrator". mysql_error();
						}*/
						$error = 1;
						$pesan = $pesan."<br>Proses Cetak data GAGAL. Segera hubungi administrator". mysql_error();
					}		
								
								
								
		}
	}
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	$frm_nrp="";
	$frm_nama="";
	$frm_no_SK_s1_terakhir= "";
	$frm_no_SK_s1_baru = "";
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_nrp!='')  {
$result = mysql_query("SELECT	master_mhs.NRP,
								master_mhs.SKSMAX,
								master_mhs.IPS,
								master_mhs.`STATUS`,
								master_mhs.JURUSAN,
								master_mhs.WALI,
								master_mhs.NAMA,
								master_mhs.ALAMAT_SBY,
								master_mhs.ZIP_SBY,
								master_mhs.EMAIL,
								master_mhs.NIRM,
								DATE_FORMAT(master_mhs.TGLLAHIR,'%d/%m/%Y') as TGLLAHIR,
								master_mhs.TMPLAHIR,
								master_mhs.TOTBSS,
								master_mhs.IPK,
								master_mhs.SKSKUM,
								master_mhs.TELEPON,
								master_mhs.NO_HP,
								master_mhs.VALIDID,
								master_mhs.`PASSWORD`,
								master_mhs.ANGKATAN,
								master_mhs.NAMASMA,
								master_mhs.NAMA_ORTU,
								master_mhs.ALAMAT_ORTU,
								master_mhs.ZIP_ORTU,
								master_mhs.TELEPON_ORTU,
								master_mhs.KELAMIN,
								`no_surat`.`N_SK`
							FROM
								`master_mhs` LEFT JOIN `no_surat` ON `master_mhs`.`NRP` = `no_surat`.`NRP`
							WHERE
								`master_mhs`.`NRP` =  '".$frm_nrp."'");

							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_nama = $row["NAMA"];
								$frm_no_SK_s1_baru = $row["N_SK"];
								
								$result2 = mysql_query("SELECT N_SK, N_urut_SK FROM no_surat WHERE N_SK <>'' ORDER BY N_urut_SK DESC LIMIT 1");
								$row2 = mysql_fetch_array($result2);
								$frm_no_SK_s1_terakhir = $row2["N_SK"];//}
								$frm_no_urut_SK_s1_terakhir = $row2["N_urut_SK"];
								$frm_no_urut_SK_s1_terakhir++;
							}else
							{$frm_exist=0; header("Location: mhs_cetak_sk_lulus_s1.php"); }		
	
}
}

?>

<html>
<head>
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<script language="JavaScript" src="../../include/tanggalan.js">
</script>
<body class="body">
<form name="mhs" id="mhs" action="mhs_cetak_sk_lulus_s1.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><img src="spacer" height="1"></td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4"> <hr size="1" color="#FF9900"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>CETAK 
              ~</strong> SK LULUS S1</font></font></td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr> 
      <td width="7%">&nbsp;</td>
      <td width="29%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="62%">
	      <input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" >
	      <input name="frm_no_urut_SK_s1_terakhir" type="hidden" id="frm_no_urut_SK_s1_terakhir"  value="<?php echo $frm_no_urut_SK_s1_terakhir; ?>" >
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>NRP yg akan dicetak</td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="10" >
      <span class="style1">*
      <? if (isset($frm_nrp)) echo $frm_nama;?>
	  <input name="frm_nama" type="hidden" id="frm_nama"  value="<?php echo $frm_nama; ?>" >
      </span></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>No. SK lulus S1 terakhir</td>
      <td width="2%"><strong>:</strong></td>
      <td><input name="frm_no_SK_s1_terakhir" type="text" class="tekboxku" id="frm_no_SK_s1_terakhir" onBlur="document.mhs.submit()" value="<?php echo $frm_no_SK_s1_terakhir; ?>" size="10" maxlength="10" > 
        <span class="style1">*</span></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>No. SK lulus S1</td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_SK_s1_baru" type="text" class="tekboxku" id="frm_no_SK_s1_baru" value="<?php echo $frm_no_SK_s1_baru; ?>" size="10" maxlength="10" >
      <span class="style1">*</span></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
      <td>
	  	<input type="submit" name="Submit" value="Proses" onclick="this.form.action+='?act=1';this.form.submit();" class="tombol">
        <input type="reset" name="Submit2" value="Batal" onclick="this.form.action+='?act=3';this.form.submit();" class="tombol"> 
      </td>
    </tr>
    <tr> 
      <td colspan="4"> </td>
    </tr>
    <tr> 
      <td colspan="4"><font size="1"><span class="style1">*</span> compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>