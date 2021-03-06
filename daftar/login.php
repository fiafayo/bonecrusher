<? 
include("include/session.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/layout.css" rel="stylesheet" type="text/css">
<title>GABSI - Registrasi</title>
</head>
<body> 

<? if($session->logged_in){?>
<div id="content"> 
  <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
    <tr> 
      <td colspan="2"><font size="5"><b>Administrator</b></font> 
	  <div style="float:right; z-index:2;">
			  <? echo "Selamat datang <b>$session->username</b>";?>
			  		<font color="#FF0000">	  			
					<?
						if($session->isAdmin()) { 
							echo " [<b>ADMIN</b>]";
						} elseif ($session->isLevel_kab()) {
							echo " [<b>Kab.</b>]";
						} elseif ($session->isLevel_prop()) {
							echo " [<b>Prop.</b>]";
						} elseif ($session->isLevel_pusat()) {
							echo " [<b>Pusat.</b>]";
						}
					?>
					</font>
					<?
				echo ", Anda saat ini sedang online. $session->email<br><br>";?>
      </div>
	  </td> 
    </tr> 
    <tr> 
      <td colspan="2"> 
	  <div id="footer"> 
          <div id="quickNavigation"> 
            <h2><span></span>quick navigation</h2> 
            <ul class="clearfix"> 
              <li> <a href="userinfo.php?user=<? echo $session->username;?>" title="Informasi Account Anda" class="main"><strong><span>My Account</span></strong></a> </li> 
              <li> <a href="useredit.php" class="main"><strong><span>Edit Account</span></strong></a> </li> 
              <li> <a href="registrasi.php" class="main"><strong><span>Biodata</span></strong></a> </li> 
			<? if(($session->isAdmin())||($session->isLevel_kab())||($session->isLevel_prop())||($session->isLevel_pusat())){?>  
              <li> <a href="administrator/index.php" title="Halaman Administrasi" class="main"><strong><span>Admin Center</span></strong></a> </li> 
              <? }?> 
              <li> <a href="process.php" title="Keluar halaman admin" class="main"><strong><span>Logout</span></strong></a> </li> 
            </ul> 
          </div> 
          <!-- endof #quickNavigation --> 
        </div> 
		</td> 
    </tr> 
    <tr> 
      <td height="300px" valign="top">&nbsp;
		</td> 
    </tr> 
  </table> 
  <?
     }
else{
/**
 * User belum login, tampilkan login form.
 * If user has already tried to login, but errors were
 * found, display the total number of errors.
 * If errors occurred, they will be displayed.
 */
?> 
  <div id="stylized" class="myform"> 
    <form action="process.php" method="POST"> 
      <h1>Login</h1> 
      <p>Silahkan Login dengan menggunakan username dan password Anda</p> 
      <label>Username <span class="small">ketik username Anda</span> </label> 
      <input type="text" name="user" maxlength="30" value="<? echo $form->value("user"); ?>" /> 
      <label>Password<span class="small">ketik password Anda</span> </label> 
      <input type="password" name="pass" maxlength="30" value="<? echo $form->value("pass"); ?>" /> 
      <label><span class="small">[<a href="forgotpass.php">Lupa Password?</a>]</span> </label> 
      <!--button type="submit">Cari</button--> 
      <!--input type="submit" value="Proses" class="button_submit"--> 
      <input type="hidden" name="sublogin" value="1"> 
      <input type="submit" value="Login"> 
    </form> 
    <div class="spacer"> </div>
	<label>Belum Registrasi?<br>&nbsp;<a href="register.php">Daftar sekarang!</a></label>  
	
    <h3> 
      <?
		echo "<b>Anggota Total:</b> ".$database->getNumMembers()."<br>";
		echo "Terdapat $database->num_active_users Anggota dan ";
		echo "$database->num_active_guests Tamu yang online.";
	?> 
    </h3> 
    <? 
if($form->num_errors > 0){
	echo "<br><font size=\"2\" color=\"#ff0000\">".$form->num_errors." kesalahan ditemukan<br>";
}
echo $form->error("user")."<br>"; 
echo $form->error("pass")."<br></font>"; 
?> 
  </div> 
  <? }?> 
</div> 
</body>
</html>
