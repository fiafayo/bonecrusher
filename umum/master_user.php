<?php
/* 
   DATE CREATED : 04/06/07 - EKO
   UPDATE  		: 07/11/07 - rahadi
   UPDATE  		: 03/01/09 - rahadi
   PROBLEM 		:
   KEGUNAAN     : ENTRY DATA MASTER USER (create pemakai baru)
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
  
   
*/
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
                                                     // always modified
header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");                          // HTTP/1.0


require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ // simpan data

	
// Kode dan nama harus diisi
	if ($user_exist!=1) {
	if (($frm_login=='') or ($frm_nama=='') or ($frm_hak=='') or ($frm_password=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi semua isian. Gagal menyimpan data.";
		}
		
		
	if ($frm_password!=$frm_password2) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, password dan ulangi password yang anda masukkan tidak cocok. Gagal menyimpan data.";
		}
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data USER tidak ada, berarti tambah baru
			if ($user_exist!=1) 
				{
					$result = mysql_query("INSERT INTO master_user (`login` , `nama` , `hak` , `password`) VALUES ( '".$frm_login."', '".$frm_nama."', '".$frm_hak."', '".$frm_password."') " );
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah ditambahkan";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data";
						}
						
				}
			else
				{
				

	// mengubah data yang sudah ada --> login ada
	//$pesan.="UPDATE master_user set `nama`='".$frm_nama."' `hak`='".$frm_hak."' where `login`='".$frm_login."'";
					$result = mysql_query("UPDATE master_user set `nama`='".$frm_nama."', `hak`='".$frm_hak."' where `login`='".$frm_login."'");

	
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menyimpan data";
						}
				}
		}
	}


if ($act==2) { // hapus data
$result = mysql_query("DELETE FROM master_user WHERE login = '".$frm_login."'");
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
	
if (($act!=0)and($error!=1)) {
	$frm_login="";
	$frm_nama = "";
	$frm_hak ="";
	$frm_password ="";
	$frm_password2 ="";
	$user_exist=0;
}
else
{
// jika user mengisi user login, cek apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_login!='')  {
$result = mysql_query("SELECT login, nama, hak FROM master_user WHERE login='".$frm_login."'");

$row = @mysql_fetch_array($result);
	$frm_nama = $row["nama"];
	$frm_hak = $row["hak"];
	if ($row["login"] != '' ) { 
	$user_exist=1; 
	$pesan = $pesan."<br>Nama User sudah digunakan. Perhatian Anda hanya bisa mengubah nama dan hak akses. "; }
}
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
<body class="body"  <?php if  ($frm_login!='') { ?>
	onload="user.frm_nama.focus();" <?php } ?>>

<form name="user" action="master_user.php" method="post">
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
            <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>DATA MASTER ~</strong> MASTER USER (TAMBAH / EDIT)</font></font> </td>
            <td width="9%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">UMUM</font></strong></div></td>
          </tr>
        </table>
      <hr size="1" color="#FF9900"></td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td width="15%">&nbsp;</td> 
      <td width="15%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="83%">&nbsp; <input type="hidden" name="user_exist" value="<?php echo $user_exist; ?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>User Login</td>
      <td><strong>:</strong></td>
      <td> <?php if ($user_exist) { 
	  				
					?>
		<input name="frm_login" type="text" id="frm_login" class="tekboxku" size="10" maxlength="10" value="<?php echo $frm_login; ?>" readonly> 			
					
					<?php } else { ?>
	  <input name="frm_login" type="text" id="frm_login" class="tekboxku" size="10" maxlength="10" value="<?php echo $frm_login; ?>" onBlur="document.user.submit()" ><?php } ?>	   <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nama User</td>
      <td><strong>:</strong></td>
      <td><input name="frm_nama" type="text" id="frm_nama" class="tekboxku" value="<?php echo $frm_nama; ?>" size="50" maxlength="50">
        <span class="style1">*</span> </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
		
      <td>Hak Akses</td>
		<td><strong>:</strong></td>
		<td><input name="frm_hak" type="radio" value="100" <?php if (($frm_hak=='') or ($frm_hak=='100')) { echo  "checked"; }?> >
        Administrator 
        <input name="frm_hak" type="radio" value="50" <?php if ($frm_hak=='50') { echo  "checked"; }?>>
        Operator 
        <input name="frm_hak" type="radio" value="10" <?php if ($frm_hak=='10') { echo  "checked"; }?>>
        User <span class="style1">*</span></td>
	</tr>
	<?php if (($user_exist!=1) and ($frm_login!='')) { ?>
	
	<tr>
	  <td>&nbsp;</td> 
      <td>Password</td>
      <td><strong>:</strong></td>
      <td><input name="frm_password" type="password" id="frm_password" size="20" maxlength="20" class="tekboxku">
        <span class="style1">*</span> </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Ulangi Password</td>
      <td><strong>:</strong></td>
      <td><input name="frm_password2" type="password" id="frm_password2"  size="20" maxlength="20" class="tekboxku">
        <span class="style1">*</span></td>
    </tr>
	<?php } ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
	  	<input type="submit" name="Submit" value="Simpan" onclick="this.form.action='master_user.php?act=1';this.form.submit();" class="tombol"> 
        <input type="reset" name="Submit2" value="Batal" onclick="this.form.action='master_user.php?act=3';this.form.submit();" class="tombol"> 
        <?php if ($user_exist) { ?>
        <input type="button" name="Submit3" value="Hapus"  onclick="if(confirm('Hapus data ini ?')){this.form.action='master_user.php?act=2&login=<?php echo $frm_login;?>';this.form.submit()};" class="tombol"> 
        <?php } ?>
	  </td>
    </tr>
    <tr> 
      <td colspan="4">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	<tr>
      <td colspan=4><font size="1"><span class="style1">*</span> = compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>