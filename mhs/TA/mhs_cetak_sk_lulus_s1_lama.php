<?php
/* 
   DATE CREATED : 30/05/07
   KEGUNAAN     : CETAK SK LULUS S-1
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
			$pesan=$pesan."<br>Maaf, Anda harus mengisi NRP dengan benar. Gagal Mencetak!";
		}
		
	if (($frm_no_SK_s1_baru=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi No. SK lulus S1 sekarang dengan benar. Gagal Mencetak!";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
					$sql_cek_lulus_TA = "SELECT lulus_ta.nilai_ujian
									       FROM lulus_ta 
									      WHERE lulus_ta.NRP='".$frm_nrp."'";
					$result_cek_lulus_TA = mysql_query($sql_cek_lulus_TA);
					//$row_cek_lulus_TA = mysql_fetch_array($result_cek_lulus_TA);
					$res_row_cek_lulus_TA = mysql_num_rows($result_cek_lulus_TA);
					
					//echo "<br>res_row_cek_lulus_TA =".$res_row_cek_lulus_TA;
					//exit();
					//if (($result_cek_lulus_TA >= 1) or (isset($result_cek_lulus_TA)))
					if ($res_row_cek_lulus_TA >= 1) 
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
			
									//echo "<br>row_result_cek=".$row_result_cek;
									//echo "<br>row_urut_SK['N_SK']=".$row_urut_SK['N_SK'];
									//echo "<br>row_urut_SK['N_urut_SK']=".$row_urut_SK['N_urut_SK'];
			
											if (($row_result_cek >= 1)and($row_urut_SK['N_SK']!='')and(!empty($row_urut_SK['N_urut_SK'])))
											{
												$result_cek_LULUS = mysql_query("SELECT `NRP`, `N_SK`, `N_urut_SK`, `N_SK_LULUS`, `N_urut_SK_LULUS` 
																				   FROM no_surat 
																				 WHERE `no_surat`.`NRP`='".$frm_nrp."'");
												$row_urut_SK_LULUS= mysql_fetch_array($result_cek_LULUS);
												//$row_result_cek_LULUS = mysql_num_rows($result_cek_LULUS);
												//echo "URUT=".$frm_no_urut_SK_s1_terakhir; 
												//echo "<br>frm_nrp=".$frm_nrp; 
												//echo "<br>row_urut_SK_LULUSxxx=".$row_urut_SK_LULUS["N_urut_SK_LULUS"];
												//if (($row_urut_SK_LULUS["N_urut_SK_LULUS"]!=0) or ($row_urut_SK_LULUS["N_urut_SK_LULUS"]!=NULL) or ($row_urut_SK_LULUS["N_urut_SK_LULUS"]!=''))
												if (($row_urut_SK_LULUS["N_SK_LULUS"]!=0) and ($row_urut_SK_LULUS["N_urut_SK_LULUS"]!=0))
												{
													
													$result_cek_sk_s1 = mysql_query("SELECT `NRP`, `N_SK`, `N_urut_SK`, `N_SK_LULUS`, `N_urut_SK_LULUS` FROM no_surat WHERE `no_surat`.`N_SK_LULUS`='".$frm_no_SK_s1_baru."' and `no_surat`.NRP='".$frm_nrp."'");
													$row_urut_sk_s1 = mysql_fetch_array($result_cek_sk_s1);
													$row_result_cek_sk_s1 = mysql_num_rows($result_cek_sk_s1);
													//echo "<br>frm_nrp=".$frm_nrp;
													//echo "<br>row_urut_sk_s1[N_SK_LULUS]=".$row_urut_sk_s1["N_SK_LULUS"];
													//echo "<br>row_urut_sk_s1[N_urut_SK_LULUS]=".$row_urut_sk_s1["N_urut_SK_LULUS"];
													
													if (($row_urut_sk_s1["N_SK_LULUS"]!=0) and ($row_urut_sk_s1["N_urut_SK_LULUS"]!=0))
													{
														//$result_update1 = mysql_query("UPDATE no_surat set `N_SK_LULUS`='$frm_no_SK_s1_baru' WHERE `NRP`='$frm_nrp'");
														?>
														<script language="JavaScript">
															//return popitup('form_cetak_mohon_KP.php?no_mo_kp='+document.mhs.frm_no_mohon.value);
															//function popitup(url)
															//{
																newwindow=window.open('form_cetak_sk_lulus_S1.php?tgl_surat=<? echo $frm_tgl_surat_dibuat;?>&nrp=<? echo $frm_nrp;?>&nama=<? echo $frm_nama;?>&no_SK_S1=<? echo $frm_no_SK_s1_baru;?>','name','top=0,left=510,scrollbars=yes');
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
														//$error = 1;
														//$pesan = $pesan."<br>Proses Cetak data GAGAL. No SK Lulus sudah ada". mysql_error();
														//exit();
													}
												}
												else
												{
													$result_cek_sk_s1 = mysql_query("SELECT `NRP`, `N_SK`, `N_urut_SK`, `N_SK_LULUS`, `N_urut_SK_LULUS` FROM no_surat WHERE `no_surat`.`N_SK_LULUS`='".$frm_no_SK_s1_baru."'");
													$row_urut_sk_s1 = mysql_fetch_array($result_cek_sk_s1);
													$row_result_cek_sk_s1 = mysql_num_rows($result_cek_sk_s1);
													//echo "<br>frm_nrp=".$frm_nrp;
													//echo "<br>row_urut_sk_s1[NRP]=".$row_urut_sk_s1["NRP"];
													//echo "<br>row_urut_sk_s1[N_SK_LULUS]=".$row_urut_sk_s1["N_SK_LULUS"];
													//echo "<br>row_urut_sk_s1[N_urut_SK_LULUS]=".$row_urut_sk_s1["N_urut_SK_LULUS"];
													//exit();
													if ($row_urut_sk_s1["NRP"]!=0)
													{
													   // $error = 1;
														//$pesan = $pesan."<br>Proses Cetak data GAGAL. No SK Lulus sudah ada". mysql_error();
													}
													else
													{
														
														//echo "<br>sini ok";
														//exit();
														$result_update1 = mysql_query("UPDATE no_surat set `N_SK_LULUS`=$frm_no_SK_s1_baru, `N_urut_SK_LULUS`=$frm_no_urut_SK_s1_terakhir WHERE `NRP`='$frm_nrp'");
			
														//$error = 1;
													   // $pesan = $pesan."<br>Proses Cetak data GAGAL. No SK Lulus sudah ada". mysql_error();
														//exit();
													}
													
			//dsdsdsdsddd									
												}
												
												if ($result_update1)
												{
													?>
													<script language="JavaScript">
														//return popitup('form_cetak_mohon_KP.php?no_mo_kp='+document.mhs.frm_no_mohon.value);
														//function popitup(url)
														//{
															newwindow=window.open('form_cetak_sk_lulus_S1.php?tgl_surat=<? echo $frm_tgl_surat_dibuat;?>&nrp=<? echo $frm_nrp;?>&nama=<? echo $frm_nama;?>&no_SK_S1=<? echo $frm_no_SK_s1_baru;?>','name','top=0,left=510,scrollbars=yes');
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
													//$pesan = $pesan."<br>Proses Cetak data GAGAL. Segera hubungi administrator". mysql_error();
													//$pesan = $pesan."<br>Proses Cetak data GAGAL. No SK Lulus sudah ada". mysql_error();
												}
											}
											else
											{
												$error = 1;
												$pesan = $pesan."<br>Maaf, Silahkan masukkan data Daftar Penguji terlebih dahulu. Gagal Mencetak.". mysql_error();
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
									$pesan = $pesan."<br>Mahasiswa belum pernah mengajukan proposal TA, Silahkan masukkan data proposal TA terlebih dahulu. Gagal Mencetak.". mysql_error();
								}		
								
				}
				else //nilai LULUS TA belum di isi 
				{
					$error = 1;
					$pesan = $pesan."<br>Nilai Ujian TA belum di isi, Silahkan masukkan data INPUT NILAI TA dengan benar. Gagal Mencetak.". mysql_error();
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
								master_mhs.NAMA,
								`no_surat`.`N_SK_LULUS`
							FROM
								`master_mhs` LEFT JOIN `no_surat` ON `master_mhs`.`NRP` = `no_surat`.`NRP`
							WHERE
								`master_mhs`.`NRP` =  '".$frm_nrp."'");

							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_nama = $row["NAMA"];
								$frm_no_SK_s1_baru = $row["N_SK_LULUS"];
								
								$result2 = mysql_query("SELECT N_SK_LULUS, N_urut_SK_LULUS FROM no_surat WHERE N_SK_LULUS <>'' ORDER BY N_urut_SK_LULUS DESC LIMIT 1");
								$row2 = mysql_fetch_array($result2);
								$frm_no_SK_s1_terakhir = $row2["N_SK_LULUS"];//}
								$frm_no_urut_SK_s1_terakhir = $row2["N_urut_SK_LULUS"];
								$frm_no_urut_SK_s1_terakhir++;
							}else
							{$frm_exist=0; header("Location: mhs_cetak_sk_lulus_s1.php"); }		
	
}
}

?>

<html>
<head>
<meta http-equiv="Refresh" content="60; URL=mhs_cetak_sk_lulus_s1.php">
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
      <td colspan="3">Silahkan gunakan menu 

 
      <a href="/mhs/TA/mhs_cetak_sk_lulus_s1_new.php">sk lulus s1 baru </a> </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="29%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="62%">&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>