<? 
include("../include/session.php");
 if($session->logged_in){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Administrator</title>
<link href="../css/layout.css" rel="stylesheet" type="text/css">
</head>
<body> 
<div id="content"> 
  <table border="0" cellpadding="0" cellspacing="0"> 
    <tr bordercolor="#FFFFFF"> 
			<td colspan="2"><font size="5"><b>Administrator</b></font> Admin Center
			<div style="float:right; z-index:2;">
			<? echo "Selamat datang <b>$session->username</b>, 
			Anda saat ini sedang online. $session->email<br><br>";?>
			</div>
			</td> 
	      </tr> 
    <tr> 
      <td colspan="2"> 
	  <div id="footer"> 
          <div id="quickNavigation"> 
            <h2><span></span>quick navigation</h2> 
            <ul class="clearfix">
			<? if($session->logged_in){?> 
              <li> <a href="../userinfo.php?user=<? echo $session->username;?>" title="Informasi Account Anda" class="main"><strong><span>My Account</span></strong></a> </li> 
              <li> <a href="../useredit.php" class="main"><strong><span>Edit Account</span></strong></a> </li> 
              <li> <a href="../registrasi.php" class="main"><strong><span>Biodata</span></strong></a> </li> 
			<? if($session->isAdmin()){?> 
			  <li> <a href="index.php" title="Halaman Administrasi" class="main"><strong><span>Admin Center</span></strong></a> </li> 
             <? }?> 
			  <li> <a href="../process.php" title="Keluar halaman admin" class="main"><strong><span>Logout</span></strong></a> </li> 
            </ul> 
          </div> 
          <!-- endof #quickNavigation --> 
        </div> 
        <?
     }
else{
/**
 * User not logged in, display the login form.
 * If user has already tried to login, but errors were
 * found, display the total number of errors.
 * If errors occurred, they will be displayed.
 */
if($form->num_errors > 0){
   echo "<font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font>";
}
}
?> </td> 
    </tr> 
    <tr> 
      <td valign="top" width="13%" rowspan="2"><? include ('menu_kiri.php');?></td> 
      <td width="87%"> <?
		$menu=$_GET['menu'];
    	if (isset($menu))
		{
			switch($menu)
			{
				
				case 'atlit':
					$top_header_text="ATLIT";
					break;
				
				case 'pelatih':
					$top_header_text="PELATIH";
					break;
					
				case 'wasit':
					$top_header_text="WASIT";
					break;
					
				case 'kota':
					$top_header_text="KOTA";
					break;
					
				case 'propinsi':
					$top_header_text="PROPINSI";
					break;
					
				case 'club':
					$top_header_text="CLUB";
					break;
					
				case 'gabungan':
					$top_header_text="GABUNGAN";
					break;
				
				}
			
			}
			echo $top_header_text;
	?> </td> 
    </tr> 
    <tr> 
      <td align="center"><?
		
    	if (isset($menu))
		{
			switch($menu)
			{
				
				case 'atlit':
					include ('atlit.php');
					break;
				
				case 'pelatih':
					include ('pelatih.php');
					break;
					
				case 'wasit':
					include ('wasit.php');
					break;
					
				case 'kota':
					include ('kota.php');	
					break;
					
				case 'propinsi':
					include ('propinsi.php');	
					break;
					
				case 'club':
					include ('club.php');
					break;
					
				case 'gabungan':
					include ('gabungan.php');
					break;
				
			default;
				}
			
			}
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
	header('Location: ../process.php');
}?>