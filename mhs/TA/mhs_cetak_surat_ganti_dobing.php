<?php
/* 
   DATE CREATED : 16/07/07
   KEGUNAAN     : CETAK SURAT GANTI DOBING
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: proses cetak; 2: hapus; 3:batal;
*/
session_start();
$act= ( isset( $_REQUEST['act'] ) ) ? $_REQUEST['act'] : 0;
$frm_nrp= ( isset( $_REQUEST['frm_nrp'] ) ) ? $_REQUEST['frm_nrp'] : null;
$frm_nama= ( isset( $_REQUEST['frm_nama'] ) ) ? $_REQUEST['frm_nama'] : null;
 
$frm_no_surat_ganti_dobing_terakhir= ( isset( $_REQUEST['frm_no_surat_ganti_dobing_terakhir'] ) ) ? $_REQUEST['frm_no_surat_ganti_dobing_terakhir'] : null;
$frm_no_surat_ganti_dobing_baru= ( isset( $_REQUEST['frm_no_surat_ganti_dobing_baru'] ) ) ? $_REQUEST['frm_no_surat_ganti_dobing_baru'] : null;
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
// Form harus diisi
	if (($frm_nrp=='') or ($frm_nama=='') or ($frm_no_surat_ganti_dobing_terakhir=='') or ($frm_no_surat_ganti_dobing_baru=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi data dengan benar. Gagal mencetak.";
		}
	if (strlen($frm_no_surat_ganti_dobing_baru) < 9)
	{
		$error = 1;
		$pesan=$pesan."<br>Maaf, Anda harus mengisi Surat Ganti Dosen Pembimbing dengan benar (harus 9 digit Angka). Gagal menyimpan data !";
	}

	if ($error !=1) // Jika semua isian form valid 
		{
					$sql_cek_mhs="SELECT `no_surat`.`NRP`
								  FROM no_surat 
								  WHERE `no_surat`.`NRP`='".$frm_nrp."'";
					$result = mysql_query($sql_cek_mhs);
					if ($row = mysql_fetch_array($result)) 
					{
						//$pesan=$pesan."<br>ADA";
						$result_cek = mysql_query("SELECT `NRP`, `N_GANDOS`, `N_urut_gandos` FROM no_surat WHERE `no_surat`.`NRP`='".$frm_nrp."'");
						$row_urut_gandos = mysql_fetch_array($result_cek);
						$row_result_cek = mysql_num_rows($result_cek);
						
						if ($row_result_cek >= 1)
						{
							if ($row_urut_gandos["N_urut_gandos"]<>0)
							{
								$result_update1 = mysql_query("UPDATE no_surat set `N_GANDOS`='$frm_no_surat_ganti_dobing_baru' WHERE `NRP`='$frm_nrp'");
							}
							else
							{
								$result_update1 = mysql_query("UPDATE no_surat set `N_GANDOS`='$frm_no_surat_ganti_dobing_baru', `N_urut_gandos`='$frm_no_urut_surat_ganti_dobing_terakhir' WHERE `NRP`='$frm_nrp'");
							}
							
							$result_update2 = mysql_query("UPDATE ganti_dobing set `NO_GANTI`='$frm_no_surat_ganti_dobing_baru' WHERE `NRP`='$frm_nrp'");
							if ($result_update1)
							{
									?>
									<script language="JavaScript">
											newwindow=window.open('form_cetak_ganti_dobing_TA.php?nrp=<? echo $frm_nrp;?>&tgl_surat=<? echo $frm_tgl_surat_dibuat;?>','name','top=0,left=510,scrollbars=yes');
											if (window.focus) {newwindow.focus()}
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
							$pesan = $pesan."<br>Maaf, Mahasiswa belum pernah mengajukan TA. Gagal Mencetak 1.". mysql_error();
						}
					}
					else
					{
						$pesan=$pesan."<br>Maaf, Mahasiswa belum pernah mengajukan TA. Gagal Mencetak 2.";
					}			
		}
	}

	
// form dikosongkan setelah tombol proses diklik dan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	$frm_nrp="";
	$frm_nama = "";
	$frm_no_surat_ganti_dobing_terakhir= "";
	$frm_no_surat_ganti_dobing_baru = "";
}
else
{
// kalau user mengisi NRP, maka di cek apakah data NRP sudah ada, kalau sudah ada maka data ditampilkan
if ($frm_nrp!='')  {
$result = mysql_query("SELECT  master_mhs.NRP,
							   master_mhs.NAMA,
							  `no_surat`.`N_gandos`
						FROM  `master_mhs` LEFT JOIN `no_surat` ON `master_mhs`.`NRP` = `no_surat`.`NRP`
						WHERE `master_mhs`.`NRP` =  '".$frm_nrp."'");

							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_nama = $row["NAMA"];
								$frm_no_surat_ganti_dobing_baru = $row["N_gandos"];
								/*if ($frm_no_surat_ganti_dobing_baru=='')
								{
									$pesan=$pesan."Silahkan masukkan data ganti dosen. Mahasiswa tersebut tidak pernah ganti dosen";
									$error=1;
								}*/
								
								$result2 = mysql_query("SELECT N_gandos, N_urut_gandos FROM no_surat WHERE N_gandos<>'' ORDER BY n_urut_gandos DESC LIMIT 1");
								$row2 = mysql_fetch_array($result2);
								$frm_no_surat_ganti_dobing_terakhir = $row2["N_gandos"];
								$frm_no_urut_surat_ganti_dobing_terakhir = $row2["N_urut_gandos"];
								$frm_no_urut_surat_ganti_dobing_terakhir++;
								
							}else
							{$frm_exist=0; header("Location: mhs_cetak_surat_ganti_dobing.php"); }		
}
}

?>

<html>
<head>
<meta http-equiv="Refresh" content="60; URL=mhs_cetak_surat_ganti_dobing.php">

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
<form name="mhs" id="mhs" action="mhs_cetak_surat_ganti_dobing.php" method="post">
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
              ~</strong> SURAT GANTI DOSEN PEMBIMBING</font></font></td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr> 
      <td width="7%">&nbsp;</td>
      <td width="29%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="63%">
	  <input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" >
	  <input name="frm_no_urut_surat_ganti_dobing_terakhir" type="hidden" id="frm_no_urut_surat_ganti_dobing_terakhir"  value="<?php echo $frm_no_urut_surat_ganti_dobing_terakhir; ?>" >
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>NRP yg akan dicetak</td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="10" >
      <span class="style1">* 
      <? if (isset($frm_nrp)) echo $frm_nama;?>
      </span>
	  <input name="frm_nama" type="hidden" id="frm_nama"  value="<?php echo $frm_nama; ?>" >
	  </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>No. surat ganti dosen pembimbing terakhir</td>
      <td width="1%"><strong>:</strong></td>
      <td><input name="frm_no_surat_ganti_dobing_terakhir" type="text" class="tekboxku" id="frm_no_surat_ganti_dobing_terakhir" onBlur="document.mhs.submit()" value="<?php echo $frm_no_surat_ganti_dobing_terakhir; ?>" size="10" maxlength="9" > 
        <span class="style1">*</span></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>No. surat ganti dosen pembimbing</td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_surat_ganti_dobing_baru" type="text" class="tekboxku" id="frm_no_surat_ganti_dobing_baru" value="<?php echo $frm_no_surat_ganti_dobing_baru; ?>" size="10" maxlength="9" >
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tanggal surat dibuat </td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_surat_dibuat" type="text" class="tekboxku" id="frm_tgl_surat_dibuat" value="<? echo date("d/m/Y"); ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('mhs.frm_tgl_surat_dibuat',0,0,'DD/MM/YYYY')"> <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy) <span class="style1">*</span></td>
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