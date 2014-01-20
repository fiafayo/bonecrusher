<?
/* 
   DATE CREATED : 30/05/07
   KEGUNAAN     : CETAK SURAT TUGAS TA
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
require("../../include/temp.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ // simpan data
	// Pemeriksaan tanggal, apakah tanggal yang dimasukkan valid
	if ($frm_tgl_surat_dibuat!='') 
		{
			if (datetomysql($frm_tgl_surat_dibuat)) 
				{
					$frm_tgl_surat_dibuat = datetomysql($frm_tgl_surat_dibuat);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal surat dibuat tidak valid";
				}
		}
//echo "<br>frm_tgl_surat_dibuat= ".$frm_tgl_surat_dibuat;
$tahun = substr($frm_tgl_TA, 0,4); 
//echo "<br>tahunaw= ".$tahun;
$tahun++;
//echo "<br>tahunak= ".$tahun;
$tanggal_akhir= substr_replace($frm_tgl_TA,$tahun,0,4);
//echo "<br>tanggal_akhir= ".$tanggal_akhir;
//exit();
// Form harus diisi
/*
echo "<br>frm_nrp=".$frm_nrp;
echo "<br>frm_nama=".$frm_nama;
echo "<br>frm_no_ST_TA_terakhir=".$frm_no_ST_TA_terakhir;
echo "<br>frm_no_ST_TA_now=".$frm_no_ST_TA_now;*/
	/*if (strlen($frm_no_ST_TA_now) < 9)
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi Surat Tugas TA dengan benar (harus 9 digit Angka). Gagal menyimpan data !";
		}
*/
	if (($frm_nrp=='') or ($frm_nama=='') or ($frm_no_ST_TA_terakhir=='') or ($frm_no_ST_TA_now=='') or ($frm_tgl_surat_dibuat=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi data dengan benar. Gagal mencetak.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
					$sql_cek_mhs="SELECT `master_ta`.`NRP`
								  FROM master_ta 
								  WHERE `master_ta`.`NRP`='".$frm_nrp."'";
					$result = mysql_query($sql_cek_mhs);
					if ($row2 = mysql_fetch_array($result)) 
					{
								$result_update_tgl_akhir_ta= mysql_query("UPDATE master_ta set `AKHIR1`='$tanggal_akhir' where `NRP`=$frm_nrp");
								if ($result_update_tgl_akhir_ta) 
									{
											$result_cek = mysql_query("SELECT `no_surat`.`NRP`, `no_surat`.`N_ST` FROM no_surat WHERE `no_surat`.`NRP`='".$frm_nrp."'");
											$row_result_cek = mysql_num_rows($result_cek);
											$frm_no_urut_ST_TA_terakhir++;
											
											//echo "<br>row_result_cek=".$row_result_cek;
											//echo "<br>frm_no_urut_ST_TA_terakhir=".$frm_no_urut_ST_TA_terakhir;
											//exit();
											if ($row_result_cek >= 1)
											{
													/*$result_cek_update1 = mysql_query("SELECT `no_surat`.`NRP`, `no_surat`.`N_ST` FROM no_surat WHERE `no_surat`.`N_ST`='".$frm_no_ST_TA_now."'");
													$row_result_cek_update1 = mysql_num_rows($result_cek_update1);
													
													if ($row_result_cek_update1 >= 1)
													{
														    $pesan = $pesan."<br>Proses Cetak data GAGAL. Nomor Surat Tugas TA sudah ada";
													}
													else
													{*/
															$result_update1 = mysql_query("UPDATE no_surat set `N_ST`='$frm_no_ST_TA_now' WHERE `NRP`='$frm_nrp'");
															if ($result_update1)
															{
																?>
																<script language="JavaScript">
																		newwindow=window.open('form_cetak_ST_TA.php?nrp=<? echo $frm_nrp;?>&no_ST_TA=<? echo $frm_no_ST_TA_now;?>&tgl_surat=<? echo $frm_tgl_surat_dibuat;?>','name','top=0,left=510,scrollbars=yes');
																		if (window.focus) {newwindow.focus()}
																		//return false;
																</script>
																<?
															}
															else
															{
																$error = 1;
																$pesan = $pesan."<br>Proses Cetak data GAGAL. Segera hubungi administrator". mysql_error();
															}
													//}
											}
											else
											{
													$result_cek_update1 = mysql_query("SELECT `no_surat`.`NRP`, `no_surat`.`N_ST` FROM no_surat WHERE `no_surat`.`N_ST`='".$frm_no_ST_TA_now."'");
													$row_result_cek_update1 = mysql_num_rows($result_cek_update1);
													
													if ($row_result_cek_update1 >= 1)
													{
														    $pesan = $pesan."<br>Proses Cetak data GAGAL. Nomor Surat Tugas TA sudah ada";
													}
													else
													{
															echo "";
															$result_insert1= mysql_query("INSERT INTO no_surat (`NRP`,`N_SKDP`,`N_ST`,`N_SK`,`N_ULUR`,`N_GANDOS`,`N_GANDUL`,`N_urut_SK`,`N_undangan`,`N_urut_ST`,`N_urut_gandul`,`N_urut_gandos`,`N_urut_ulur`,`N_urut_undangan`) VALUES ( '".$frm_nrp."', '', '".$frm_no_ST_TA_now."', '', '', '', '',0,'',".$frm_no_urut_ST_TA_terakhir.",NULL,NULL,NULL,NULL)");
															//$result_update1 = mysql_query("UPDATE no_surat set `N_ST`='$frm_no_ST_TA_now', `N_urut_ST`=$frm_no_urut_ST_TA_terakhir WHERE `NRP`='$frm_nrp'");
															 
															if ($result_insert1)
															{
																?>
																<script language="JavaScript">
																	//return popitup('form_cetak_mohon_KP.php?no_mo_kp='+document.mhs.frm_no_mohon.value);
																	//function popitup(url)
																	//{
																		newwindow=window.open('form_cetak_ST_TA.php?nrp=<? echo $frm_nrp;?>&no_ST_TA=<? echo $frm_no_ST_TA_now;?>&tgl_surat=<? echo $frm_tgl_surat_dibuat;?>','name','top=0,left=510,scrollbars=yes');
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
											}
									}
								else
									{ 
										$pesan = $pesan."<br>Proses Cetak data GAGAL. Segera hubungi administrator AAA";
									}
						//}//end cek no ST
					}
					else
					{
						$pesan=$pesan."<br>Maaf, NRP tersebut belum mengajukan TA. Gagal Mencetak.";
					}			
		}
		
}

// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
    $frm_exist = 0;
	//$frm_nrp = "";
	$frm_nama = "";
    $frm_no_ST_TA_now = "";
	$frm_no_ST_TA_terakhir = "";
}
else
{
// kalau user mengisi NRP, maka di cek apakah data NRP sudah ada, kalau sudah ada maka data ditampilkan
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
								master_mhs.TGLLAHIR,
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
								`no_surat`.`N_ST`
							FROM
								`master_mhs` LEFT JOIN `no_surat` ON `master_mhs`.`NRP` = `no_surat`.`NRP`
							WHERE
								`master_mhs`.`NRP` =  '".$frm_nrp."'");
								
							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_nama = $row["NAMA"];
								$frm_no_ST_TA_now = $row["N_ST"];
								
								//if ($frm_id_kota_asal!='') {
								$result2 = mysql_query("SELECT N_ST, N_urut_ST FROM no_surat WHERE N_ST<>'' ORDER BY N_urut_ST DESC LIMIT 1");
								$row2 = mysql_fetch_array($result2);
								$frm_no_ST_TA_terakhir = $row2["N_ST"];
								$frm_no_urut_ST_TA_terakhir = $row2["N_urut_ST"];//}
								
								$result3 = mysql_query("SELECT TGL_AJU
								                          FROM master_ta WHERE master_ta.NRP='".$frm_nrp."'");
								$row3 = mysql_fetch_array($result3);
								$frm_tgl_TA = $row3["TGL_AJU"];
							}else
							{$frm_exist=0; header("Location: mhs_cetak_ST_TA.php"); }
}
}

?>
<html>
<head>
<meta http-equiv="Refresh" content="60; URL=mhs_cetak_ST_TA.php">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>

<script language="javascript">
var no_ST_TA_filter=/^\d{9}$/
function cek_ST_TA(e){
	var returnval=no_ST_TA_filter.test(e.value)
	if (returnval==false){
		alert("Silahkan, Masukkan No. surat tugas TA dengan benar (harus 9 digit Angka).")
		e.select()
		e.focus()
	}
	return returnval
}
</script>

</head>
<script language="JavaScript" src="../../include/tanggalan.js">
</script>
<body class="body">
<form name="mhs" id="mhs" action="mhs_cetak_ST_TA.php" method="post">
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
              ~</strong> SURAT TUGAS TA</font></font></td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr> 
      <td width="6%">&nbsp;</td>
      <td width="24%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="68%"><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" >
	  <input name="frm_tgl_TA" type="hidden" id="frm_tgl_TA"  value="<?php echo $frm_tgl_TA; ?>" ></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>NRP yang akan dicetak</td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="7" > 
        <span class="style1">* 
        <? if (isset($frm_nrp)) echo $frm_nama;?>
        </span>
	  	<input name="frm_nama" type="hidden" id="frm_nama"  value="<?php echo $frm_nama; ?>" >
	  </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>No. surat tugas TA terakhir </td>
      <td><strong>:</strong></td>
      <td><? //echo "frm_no_urut_ST_TA_terakhir = ".$frm_no_urut_ST_TA_terakhir;?>
	    <input type="hidden" name="frm_no_urut_ST_TA_terakhir" id="frm_no_urut_ST_TA_terakhir" value="<? echo $frm_no_urut_ST_TA_terakhir;?>">
		<input name="frm_no_ST_TA_terakhir" type="text" class="tekboxku" id="frm_no_ST_TA_terakhir" value="<?php echo $frm_no_ST_TA_terakhir; ?>" size="15" maxlength="9"></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>No. surat tugas TA sekarang</td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_ST_TA_now" type="text" class="tekboxku" id="frm_no_ST_TA_now" value="<?php echo $frm_no_ST_TA_now; ?>" size="15" maxlength="9"></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>Tanggal surat dibuat</td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_surat_dibuat" type="text" class="tekboxku" id="frm_tgl_surat_dibuat" value="<? echo date("d/m/Y"); ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('mhs.frm_tgl_surat_dibuat',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy) <span class="style1">*</span></td>
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