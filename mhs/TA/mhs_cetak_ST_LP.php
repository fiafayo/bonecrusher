<?
/* 
   DATE CREATED : 30/05/07
   KEGUNAAN     : CETAK SURAT TUGAS LP
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/
session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

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
$tahun = substr($frm_tgl_surat_dibuat, 0,4); 
$tahun++;
//echo "<br>tahun= ".$tahun;
$tanggal_akhir= substr_replace($frm_tgl_surat_dibuat,$tahun,0,4);
//echo "<br>tanggal_akhir= ".$tanggal_akhir;
//exit();
// Form harus diisi
/*
echo "<br>frm_nrp=".$frm_nrp;
echo "<br>frm_nama=".$frm_nama;
echo "<br>frm_no_ST_LP_terakhir=".$frm_no_ST_LP_terakhir;
echo "<br>frm_no_ST_LP_now=".$frm_no_ST_LP_now;*/

	if (($frm_nrp=='') or ($frm_nama=='') or ($frm_no_ST_LP_terakhir=='') or ($frm_no_ST_LP_now=='') or ($frm_tgl_surat_dibuat=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi data dengan benar. Gagal mencetak.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
					$sql_cek_mhs="SELECT `master_mhs`.`NRP`
								  FROM master_mhs 
								  WHERE `master_mhs`.`NRP`='".$frm_nrp."'";
					$result = mysql_query($sql_cek_mhs);
					if ($row2 = mysql_fetch_array($result)) 
					{
						$result_update_tgl_akhir_ta= mysql_query("UPDATE master_ta set `TGL_MULAI`='$frm_tgl_surat_dibuat', `TGL_SELESAI`='$tanggal_akhir' where `NRP`=$frm_nrp");

						if ($result_update_tgl_akhir_ta) 
							{
									$result_cek = mysql_query("SELECT `no_surat_lp`.`NRP` FROM no_surat_lp WHERE `no_surat_lp`.`NRP`='".$frm_nrp."'");
									$row_result_cek = mysql_num_rows($result_cek);
									$frm_no_urut_ST_LP_terakhir++;
									echo "<br>row_result_cek=".$row_result_cek;
									echo "<br>frm_no_urut_ST_LP_terakhir=".$frm_no_urut_ST_LP_terakhir;
									//exit();
									if ($row_result_cek!=1)
									{
										$result_insert1= mysql_query("INSERT INTO no_surat_lp (`NRP`,`N_ST`,`N_SK`,`URUT_ST`,`URUT_SK`) VALUES ( '".$frm_nrp."', '".$frm_no_ST_LP_now."', '',".$frm_no_urut_ST_LP_terakhir.",NULL)");
										if ($result_insert1)
										{
											?>
											<script language="JavaScript">
												//return popitup('form_cetak_mohon_KP.php?no_mo_kp='+document.mhs.frm_no_mohon.value);
												//function popitup(url)
												//{
													newwindow=window.open('form_cetak_ST_LP.php?nrp=<? echo $frm_nrp;?>&no_ST_LP=<? echo $frm_no_ST_LP_now;?>','name','top=0,left=510,scrollbars=yes');
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
										 $result_update1 = mysql_query("UPDATE no_surat_lp set `N_ST`='$frm_no_ST_LP_now', `URUT_ST`=$frm_no_urut_ST_LP_terakhir WHERE `NRP`='$frm_nrp'");
										 
										 if ($result_update1)
										{
											?>
											<script language="JavaScript">
												//return popitup('form_cetak_mohon_KP.php?no_mo_kp='+document.mhs.frm_no_mohon.value);
												//function popitup(url)
												//{
													newwindow=window.open('form_cetak_ST_LP.php?nrp=<? echo $frm_nrp;?>&no_ST_LP=<? echo $frm_no_ST_LP_now;?>','name','top=0,left=510,scrollbars=yes');
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
						else
							{ 
								$pesan = $pesan."<br>Proses Cetak data GAGAL. Segera hubungi administrator";
							}
						
					}
					else
					{
						$pesan=$pesan."<br>Maaf, NRP salah. Gagal Mencetak.";
					}			
		}
		
}

// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
    $frm_exist = 0;
	$frm_nrp = "";
	$frm_nama = "";
    $frm_no_ST_LP_now = "";
	$frm_no_ST_LP_terakhir = "";
}
else
{
// kalau user mengisi NRP, maka di cek apakah data NRP sudah ada, kalau sudah ada maka data ditampilkan
if ($frm_nrp!='')  {
$result = mysql_query("SELECT	`master_mhs`.`NRP`,
								`master_mhs`.`SKSMAX`,
								`master_mhs`.`IPS`,
								`master_mhs`.`STATUS`,
								`master_mhs`.`JURUSAN`,
								`master_mhs`.`WALI`,
								`master_mhs`.`NAMA`,
								`master_mhs`.`ALAMAT`,
								`master_mhs`.`NIRM`,
								`master_mhs`.`TGLLAHIR`,
								`master_mhs`.`TMPLAHIR`,
								`master_mhs`.`TOTBSS`,
								`master_mhs`.`IPK`,
								`master_mhs`.`SKSKUM`,
								`master_mhs`.`TELEPON`,
								`master_mhs`.`VALIDID`,
								`master_mhs`.`PASSWORD`,
								`master_mhs`.`ANGKATAN`,
								`master_mhs`.`NAMASMA`,
								`master_mhs`.`NAMAORTU`,
								`master_mhs`.`NRPKOP`,
								`master_mhs`.`KELAMIN`,
								`no_surat_lp`.`N_ST`
							FROM
								`master_mhs` LEFT JOIN `no_surat_lp` ON `master_mhs`.`NRP` = `no_surat_lp`.`NRP`
							WHERE
								`master_mhs`.`NRP` =  '".$frm_nrp."'");
								
							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_nama = $row["NAMA"];
								$frm_no_ST_LP_now = $row["N_ST"];
								
								
								//if ($frm_id_kota_asal!='') {
								$result2 = mysql_query("SELECT N_ST, URUT_ST FROM no_surat_lp WHERE N_ST<>'' ORDER BY URUT_ST DESC LIMIT 1");
								$row2 = mysql_fetch_array($result2);
								$frm_no_ST_LP_terakhir = $row2["N_ST"];
								$frm_no_urut_ST_LP_terakhir = $row2["URUT_ST"];//}
							}else
							{$frm_exist=0; header("Location: mhs_cetak_ST_LP.php"); }
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
<form name="mhs" id="mhs" action="mhs_cetak_ST_LP.php" method="post">
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
      <td width="68%"><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" ></td>
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
      <td nowrap>No. surat tugas Pen. terakhir </td>
      <td><strong>:</strong></td>
      <td><? echo "frm_no_urut_ST_LP_terakhir = ".$frm_no_urut_ST_LP_terakhir;
								?>
	    <input type="hidden" name="frm_no_urut_ST_LP_terakhir" id="frm_no_urut_ST_LP_terakhir" value="<? echo $frm_no_urut_ST_LP_terakhir;?>">
		<input name="frm_no_ST_LP_terakhir" type="text" class="tekboxku" id="frm_no_ST_LP_terakhir" value="<?php echo $frm_no_ST_LP_terakhir; ?>" size="30" maxlength="50"></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>No. surat tugas Pen. sekarang</td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_ST_LP_now" type="text" class="tekboxku" id="frm_no_ST_LP_now" value="<?php echo $frm_no_ST_LP_now; ?>" size="30" maxlength="50"></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>Tanggal surat dibuat</td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_surat_dibuat" type="text" class="tekboxku" id="frm_tgl_surat_dibuat" value="<?php echo date("d/m/Y"); ?>" size="10" maxlength="10"> 
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