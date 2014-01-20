<?php
/* 
   DATE CREATED : 30/05/07
   KEGUNAAN     : CETAK SURAT PERPANJANGAN TA
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/
$sqlText="SQL KOSONG";
session_start();
$act= ( isset( $_REQUEST['act'] ) ) ? $_REQUEST['act'] : 0;
$frm_nrp= ( isset( $_REQUEST['frm_nrp'] ) ) ? $_REQUEST['frm_nrp'] : null;
$frm_nama= ( isset( $_REQUEST['frm_nama'] ) ) ? $_REQUEST['frm_nama'] : null;
 
$frm_no_ulur_ta_terakhir= ( isset( $_REQUEST['frm_no_ulur_ta_terakhir'] ) ) ? $_REQUEST['frm_no_ulur_ta_terakhir'] : null;
$frm_no_ulur_ta_now= ( isset( $_REQUEST['frm_no_ulur_ta_now'] ) ) ? $_REQUEST['frm_no_ulur_ta_now'] : null;
$frm_tgl_surat_dibuat= ( isset( $_REQUEST['frm_tgl_surat_dibuat'] ) ) ? $_REQUEST['frm_tgl_surat_dibuat'] : null;
 

$pesan= ( isset( $_REQUEST['pesan'] ) ) ? $_REQUEST['pesan'] : null;
$error= ( isset( $_REQUEST['error'] ) ) ? $_REQUEST['error'] : null; 
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
	
// validasi form dan nama harus diisi 
	if (($frm_nrp=='') or ($frm_nama=='') or ($frm_no_ulur_ta_terakhir=='') or ($frm_no_ulur_ta_now=='') or ($frm_tgl_surat_dibuat=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi data dengan benar. Gagal mencetak.";
		}
		
    
	if (strlen($frm_no_ulur_ta_now) < 9)
	{
		$error = 1;
		$pesan=$pesan."<br>Maaf, Anda harus mengisi No. surat perpanjangan TA dengan benar (harus 9 digit Angka). Gagal mencetak !";
	}
		
	if ($error !=1) // Jika semua isian form valid 
		{
					$sql_cek_mhs="SELECT `master_mhs`.`NRP`
								  FROM master_mhs 
								  WHERE `master_mhs`.`NRP`='".$frm_nrp."'";
					$result = mysql_query($sql_cek_mhs);
					if ($row = mysql_fetch_array($result)) 
					{
						//$pesan=$pesan."<br>ADA";
						?>
						<script language="JavaScript">
							//return popitup('form_cetak_mohon_KP.php?no_mo_kp='+document.mhs.frm_no_mohon.value);
							//function popitup(url)
							//{
								newwindow=window.open('form_cetak_perpanjangan_TA.php?tgl_surat=<? echo $frm_tgl_surat_dibuat;?>&nrp=<? echo $frm_nrp;?>&no_ST_TA=<? echo $frm_no_ulur_ta_now;?>','name','top=0,left=0,resizable=1,scrollbars=yes');
								if (window.focus) {newwindow.focus()}
								//return false;
							//}
							//return popitup('form_cetak_mohon_KP.php?no_mo_kp=<? //echo $frm_no_mohon;?>');
							//return popitup('form_cetak_berita_acara_LP.php?nrp='+document.mhs.frm_NRP.value+'&periode='+document.mhs.frm_periode.value+'&thn_ajar='+document.mhs.frm_id_tahun_ajar.value);
							
						</script>
						<?
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
	$frm_tgl_surat_dibuat = "";
    $frm_no_ulur_ta_now = "";
	$frm_no_ulur_ta_terakhir = "";
}
else
{
// kalau user mengisi NRP, maka di check apakah data NRP sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_nrp!='')  {
    $sqlText = "SELECT	master_mhs.NRP,
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
								`no_surat`.`N_ulur`
							FROM
								`master_mhs` LEFT JOIN `no_surat` ON `master_mhs`.`NRP` = `no_surat`.`NRP`
							WHERE
								`master_mhs`.`NRP` =  '".$frm_nrp."'";
$result = mysql_query($sqlText);
								
							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_nama = $row["NAMA"];
								$frm_no_ulur_ta_now = $row["N_ulur"];
								
								//if ($frm_id_kota_asal!='') {
								$result2 = mysql_query("SELECT n_ulur FROM no_surat WHERE n_ulur<>'' ORDER BY n_urut_ulur DESC LIMIT 1");
								$row2 = mysql_fetch_array($result2);
								$frm_no_ulur_ta_terakhir = $row2["n_ulur"];//}
							}else
							{$frm_exist=0; header("Location: mhs_cetak_surat_perpanjangan_ta.php"); }
}
}
//file_put_contents('/tmp/ta.sql', $sqlText);
//echo $sqlText;

?>

<html>
<head>
<meta http-equiv="Refresh" content="60; URL=mhs_cetak_surat_perpanjangan_ta.php">
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
<form name="mhs" id="mhs" action="mhs_cetak_surat_perpanjangan_ta.php" method="post">
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
              ~</strong> SURAT PERPANJANGAN TA</font></font></td>
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
      <td nowrap>No. surat perpanjangan TA terakhir </td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_ulur_ta_terakhir" type="text" class="tekboxku" id="frm_no_ulur_ta_terakhir" value="<?php echo $frm_no_ulur_ta_terakhir; ?>" size="15" maxlength="9"></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>No. surat perpanjangan TA</td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_ulur_ta_now" type="text" class="tekboxku" id="frm_no_ulur_ta_now" value="<?php echo $frm_no_ulur_ta_now; ?>" size="15" maxlength="9"></td>
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