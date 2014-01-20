<?php
/* 
   DATE CREATED : 30/05/07
   KEGUNAAN     : CETAK SURAT PERMOHONAN KP
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ // CEK data
// No. Surat Permohonan KP harus diisi
	if ($frm_no_mohon=='')
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi No. Surat Permohonan KP dengan benar. Gagal mencetak.";
		}

	if ($error !=1) // Jika isian form valid 
		{
					$sql_mohon_KP="SELECT  `daftar_kp`.`NO_MOHON`
								   FROM daftar_kp 
								   WHERE `daftar_kp`.`NO_MOHON`='".$frm_no_mohon."'";
					$result = mysql_query($sql_mohon_KP);
					if ($row = mysql_fetch_array($result)) 
					{
						//$pesan=$pesan."<br>ADA";
						?>
						<script language="JavaScript">
							//return popitup('form_cetak_mohon_KP.php?no_mo_kp='+document.mhs.frm_no_mohon.value);
							//function popitup(url)
							//{
								newwindow=window.open('form_cetak_mohon_KP.php?no_mo_kp=<? echo $frm_no_mohon;?>','name','top=0,left=510,resizable=1,width=800,height=600,scrollbars=yes');
								if (window.focus) {newwindow.focus()}
								//return false;
							//}
							//return popitup('form_cetak_mohon_KP.php?no_mo_kp=<? echo $frm_no_mohon;?>');
							//return popitup('form_cetak_mohon_KP.php?no_mo_kp='+document.mhs.frm_no_mohon.value);
							
						</script>
						<?
					}
					else
					{
						$pesan=$pesan."<br>Maaf, No.Surat Permohonan KP salah. Gagal Mencetak.";
					}
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
<form name="mhs" id="mhs" action="mhs_cetak_mohon_KP.php" method="post">
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
              ~</strong> SURAT PERMOHONAN KP</font></font></td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr> 
      <td width="11%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="70%">&nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>No. Surat Permohonan KP </td>
      <td width="1%"><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_no_mohon" type="text" class="tekboxku" id="frm_no_mohon" value="<?php echo $frm_no_mohon; ?>" size="10" maxlength="9" > 
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