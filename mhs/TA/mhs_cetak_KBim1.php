<?php
/* 
   DATE CREATED : 30/05/07
   KEGUNAAN     : CETAK KARTU BIMBINGAN UNTUK DOSEN PEMBIMBING 1
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
$act= ( isset( $_REQUEST['act'] ) ) ? $_REQUEST['act'] : 0;
$frm_nrp= ( isset( $_REQUEST['frm_nrp'] ) ) ? $_REQUEST['frm_nrp'] : null;
$frm_nama= ( isset( $_REQUEST['frm_nama'] ) ) ? $_REQUEST['frm_nama'] : null;
 
$pesan= ( isset( $_REQUEST['pesan'] ) ) ? $_REQUEST['pesan'] : null;
$error= ( isset( $_REQUEST['error'] ) ) ? $_REQUEST['error'] : null;
require("../../include/global.php");
require("../../include/fungsi.php");
require("../../include/temp.php");


f_connecting();
	mysql_select_db($DB);
	
if ($act==1)   
{ 
// NRP dan nama harus diisi
	if ((!$frm_nrp) or (!$frm_nama)) 
		{
			$error = 1;
			//$pesan=$pesan."<br>Maaf, anda harus mengisi nrp dan nama mahasiswa. Gagal menyimpan data.";
			$pesan=$pesan."<br>Maaf, Anda harus mengisi NRP dengan benar. Gagal Mencetak.";
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
								newwindow=window.open('form_cetak_kartu_bim1.php?nrp=<? echo $frm_nrp;?>','name','top=0,left=510,scrollbars=yes');
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
						$pesan=$pesan."<br>Maaf, NRP salah. Gagal Mencetak.";
					}			
		}
}

// form dikosongkan siap untuk input data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	$frm_NRP="";
	$frm_nama = "";
}
else
{
// jika user mengisi NRP, maka di cek apakah data NRP sudah ada, kalau sudah ada maka data ditampilkan
if ($frm_nrp)  {
$result = mysql_query("SELECT  master_mhs.NRP,
							   master_mhs.NAMA
						 FROM  master_mhs
						 WHERE master_mhs.NRP = '".$frm_nrp."'");

	if ($row = mysql_fetch_array($result)) {
		$frm_exist=1;
		$frm_nrp = $row["NRP"];	
		$frm_nama = $row["NAMA"];	
	}else
	{$frm_exist=0; header("Location: mhs_cetak_KBim1.php");}
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
<form name="mhs" id="mhs" action="mhs_cetak_KBim1.php" method="post">
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
              ~</strong> KARTU BIMBINGAN 1</font></font></td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr> 
      <td width="11%">&nbsp;</td>
      <td width="14%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="74%"><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" ></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>NRP yg akan dicetak</td>
      <td width="1%"><strong>:</strong></td>
      <td><input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="10" > 
        <span class="style1">*<? if (isset($frm_nrp)) echo $frm_nama;?></span>
		<input name="frm_nama" type="hidden" id="frm_nama"  value="<?php echo $frm_nama; ?>" >
		</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>&nbsp;</td>
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
      <td colspan="4"><font size="1"><span class="style1">*</span> compulsory 
        / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>