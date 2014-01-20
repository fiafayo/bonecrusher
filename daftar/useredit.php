<?
include("include/session.php");
 if($session->logged_in){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>GABSI - edit account </title>
<link href="css/layout.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="content"> 
<table border="0" cellpadding="0" cellspacing="0" width="100%">
 <tr> 
      <td colspan="2"><font size="5"><b>Administrator</b></font> 
		<?
		if($session->logged_in){
			 echo "Edit Account : <b>".$session->username."</b>"; 
		}?>
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
 <tr> 
      <td colspan="2"> <div id="footer"> 
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
<td>
<?
/**
 * User has submitted form without errors and user's
 * account has been edited successfully.
 */
if(isset($_SESSION['useredit'])){
   unset($_SESSION['useredit']);
   echo "<h1>User Account Edit Berhasil!</h1>";
   echo "<p><b>$session->username</b>, Account Anda berhasil di update. "
       ."<a href=\"login.php\">Kembali</a>.</p>";
}
else{

if($session->logged_in){
?>
<div id="stylized" class="myform"> 
<form action="process.php" method="POST">
	<label>Password Lama<span class="small">ketik password lama Anda</span> </label> 
	<input type="password" name="curpass" id="curpass" maxlength="30" value="<? echo $form->value("curpass");?>">
	<label>Password Baru<span class="small">ketik password baru Anda</span> </label>
	<input type="password" name="newpass" id="newpass" maxlength="30" value="<? echo $form->value("newpass"); ?>">
<label>Email<span class="small">ketik alamat email Anda</span> </label>
<input readonly="readonly" type="text" name="email" maxlength="50" value="
<?
if($form->value("email") == ""){
   echo $session->userinfo['email'];
}else{
   echo $form->value("email");
}
?>">
<input type="hidden" name="subedit" value="1">
<label><span class="small">klik tombol ini untuk merubah password Anda</span> </label> 
<input type="submit" value="Edit Account">
<div class="spacer"> </div> 
    <h3> 
      <?
		echo "<b>Anggota Total:</b> ".$database->getNumMembers()."<br>";
		echo "Terdapat $database->num_active_users Anggota dan ";
		echo "$database->num_active_guests Tamu yang online.";
	?> 
    </h3> 
    <? 
if($form->num_errors > 0){
	echo "<font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found<br>";
}
echo $form->error("curpass")."<br>"; 
echo $form->error("newpass")."<br>"; 
echo $form->error("email")."<br></font>"; 
?> 
  </div> 


</form>

<?
}
}




/**
 * Just a little page footer, tells how many registered members
 * there are, how many users currently logged in and viewing site,
 * and how many guests viewing site. Active users are displayed,
 * with link to their user information.
 */
echo "</td></tr><tr><td align=\"center\">";
echo "<b>Anggota Total:</b> ".$database->getNumMembers()."<br>";
echo "Terdapat $database->num_active_users Anggota dan ";
echo "$database->num_active_guests Tamu yang online.";

//include("include/view_active.php");

?></td>
  </tr>
</table>
</div> 
</body>
</html>
<?
}
else
{
	header('Location: process.php');
}?>