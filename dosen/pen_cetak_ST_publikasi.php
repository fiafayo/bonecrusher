<?php
/* 
   DATE CREATED : 30/11/07
   KEGUNAAN     : CETAK SURAT TUGAS PUBLIKASI
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: Cetak; 3: batal;
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ 
// No. Surat Tugas Publikasi harus di isi
	if ($frm_ST_publikasi=='')  
		{
			$error = 1;
			$pesan=$pesan."Maaf, Anda harus mengisi No. Surat Tugas Publikasi dengan benar. Gagal Mencetak.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
					$sql_cek_mhs="SELECT `publikasi`.`no_st_pub`
								  FROM publikasi 
								  WHERE `publikasi`.`no_st_pub`='".$frm_ST_publikasi."'";
					$result = mysql_query($sql_cek_mhs);
					if ($row = mysql_fetch_array($result)) 
					{
						//$pesan=$pesan."<br>ADA";
						?>
						<script language="JavaScript">
							//return popitup('form_cetak_mohon_KP.php?no_mo_kp='+document.mhs.frm_no_mohon.value);
							//function popitup(url)
							//{
								newwindow=window.open('form_cetak_pen_st_publikasi.php?no_stp=<? echo $frm_ST_publikasi;?>','name','top=0,left=510,scrollbars=yes');
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
						$pesan=$pesan."Maaf, No. Surat Tugas Publikasi salah. Gagal Mencetak.";
					}			
		}
}

// form dikosongkan siap untuk input data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	$frm_ST_publikasi="";
}

?>
<html>
<head>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<script language="JavaScript" src="../include/tanggalan.js">
</script>
<body class="body">
<form name="form_ST_pub" id="form_ST_pub"  action="pen_cetak_ST_publikasi.php" method="post">
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
              ~</strong> SURAT TUGAS PUBLIKASI </font></font></td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">DOSEN</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr> 
      <td width="15%">&nbsp;</td>
      <td width="15%">&nbsp;</td>
      <td width="3%">&nbsp;</td>
      <td width="83%"><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" ></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>No. Surat Tugas</td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_ST_publikasi" type="text" class="tekboxku" id="frm_ST_publikasi" size="25" maxlength="25" > 
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
      <td colspan="4"><font size="1"><span class="style1">*</span> compulsory 
        / harus diisi</font></td>
    </tr>
  </table>
</form>
<br>
<?
/*
$aku2="mulyadi";

for ($i = 1; $i <= 2; $i++) {
		//if ($var_kode_kary_."$i"<>'')
		//{
		   
			echo ${"aku".$i} ;
		//}
	}

*/
?>
</body>
</html>