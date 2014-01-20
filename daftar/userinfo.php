<?
include("include/session.php");
if($session->logged_in){ 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/layout.css" rel="stylesheet" type="text/css">
<title>GABSI - Account</title>
</head>
<body>
<div id="content"> 
<table border="0" cellpadding="0" cellspacing="0" width="100%"> 
    <tr> 
      <td colspan="2"><font size="5"><b>Administrator</b></font> 
	  <?
        /* Logged in user viewing own account */
        if(strcmp($session->username,$req_user) == 0){
			echo "My Account";
        }
        /* Visitor not viewing own account */
        else{
			//echo "User Info";
			echo "My Account";
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
  </table> 
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
<?
/**
 * User not logged in, display the login form.
 * If user has already tried to login, but errors were
 * found, display the total number of errors.
 * If errors occurred, they will be displayed.
 */
if($form->num_errors > 0){
   echo "<font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font>";
}
?>
      <table align="left" width="500" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td colspan="4" align="left"><?
/* Requested Username error checking */
$req_user = trim($_GET['user']);
if(!$req_user || strlen($req_user) == 0 ||
   !preg_match("/^([0-9a-z])+$/i", $req_user) ||
   !$database->usernameTaken($req_user)){
   die("Username not registered");
}



/* Display requested user information */
$req_user_info = $database->getUserInfo($req_user);

/* Username */
echo "<b>Username: ".$req_user_info['username']."</b><br>";

/* Email */
echo "<b>Email:</b> ".$req_user_info['email']."<br>";

/**
 * Note: when you add your own fields to the users table
 * to hold more information, like homepage, location, etc.
 * they can be easily accessed by the user info array.
 *
 * $session->user_info['location']; (for logged in users)
 *
 * ..and for this page,
 *
 * $req_user_info['location']; (for any user)
 */

/* If logged in user viewing own account, give link to edit */
if(strcmp($session->username,$req_user) == 0){
   echo "<br><a href=\"useredit.php\">Edit Account</a><br>";
}

/* Link back to main */
//echo "<br>Back To [<a href=\"login.php\">Halaman Depan</a>]<br>";

?></td>
        </tr>
      </table>
      <?


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
<? }
else
{
header('Location: process.php');
}
?>