<?php
/* 
       
   DATE CREATED : 28/05/07 
   UPDATE  		: 
   PROBLEM 		:
   KEGUNAAN     : GANTI PASSWORD
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
  
   
*/
session_start();
require("../include/global.php");
require("../include/fungsi.php");


f_connecting();
	mysql_select_db($DB);


if ($act==1)   
{ // simpan data

	
// Kode dan nama harus diisi

	if ($frm_password!=$password) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, password yang anda masukkan tidak cocok. Gagal menyimpan data.";
		}
		
		
	if ($frm_password1!=$frm_password2) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, password dan ulangi password yang anda masukkan tidak cocok. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			
	// mengubah data yang sudah ada --> login ada
					$result = mysql_query("UPDATE master_user set `password`='$frm_password1' where `login`='".$user_login."'");

	
					if ($result) 
						{
							$pesan = $pesan."<br>Password telah diubah";
							$password = $frm_password1;	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal mengubah password. Silahkan coba lagi. Apabila masih tidak berhasil silahkan hubungi administrator";
						}
			}
	}

?>
<html>
<head>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<?
//include ("../css/style2.css");
?>
<style type="text/css">
<!--
.style1 {font-weight: bold}
.style2 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>
<body class="body">

<form id="user"  name="user" action="umum_2.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><img src="spacer" height="1"></td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000"><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr>
      <td colspan="4"><hr size="1" color="#FF9900">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>USER ~</strong> GANTI PASSWORD</font></font> </td>
            <td width="9%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">UMUM</font></strong></div></td>
          </tr>
        </table>
      <hr size="1" color="#FF9900"></td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td width="13%">&nbsp;</td> 
      <td width="13%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="86%">&nbsp; </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Password Lama</td>
      <td><strong>:</strong></td>
      <td><input name="frm_password" type="password" id="frm_password" size="20" maxlength="20" class="tekboxku">
        <font size="1"><span class="style2">*</span></font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Password Baru</td>
      <td><strong>:</strong></td>
      <td><input name="frm_password1" type="password" id="frm_password1" size="20" maxlength="20" class="tekboxku">
        <font size="1"><span class="style2">*</span></font></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>Ulangi Password</td>
      <td><strong>:</strong></td>
      <td><input name="frm_password2" type="password" id="frm_password2" size="20" maxlength="20" class="tekboxku">
        <font size="1"><span class="style2">*</span></font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" id="Submit" name="Submit" value="Simpan" 
	  onClick="this.form.action+='?act=1';this.form.submit();" class="tombol"
	  ></td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><font size="1"><span class="style2">*</span> = compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>

</body>
</html>
