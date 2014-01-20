<? 
include("include/session.php");
if($session->logged_in){ 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/layout.css" rel="stylesheet" type="text/css">
<title>GABSI</title>
<script language="javascript">
function proses()
{
	document.forms["form_reg_user"].submit();
	}
</script>
</head>
<body>
<?
$rg_login_as=$_POST['rg_login_as'];

?>
<div id="content"> 
<table border="0" cellpadding="0" cellspacing="0" width="100%"> 
    <tr> 
      <td colspan="2"><font size="5"><b>Administrator</b></font> Biodata 
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
  </table> 
  
  <table cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td>
				
				<? if (!(isset($rg_login_as))) {?>
				 
				<div style="height:300px;">
					  <form name="form_reg_user" id="form_reg_user" method="post">
							<h1>Registrasi Sebagai</h1> 
							<p>Silahkan pilih data yang ingin di proses</p> 
							<input type="radio" name="rg_login_as" value="1" id="rg_login_as" onclick="proses();" <? if ($rg_login_as==1) echo "checked";?>   />
							<label>Atlit</label> 
							&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="rg_login_as" value="2" id="rg_login_as" onclick="proses();" <? if ($rg_login_as==2) echo "checked";?> />
							<label>Pelatih</label>
							&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="rg_login_as" value="3" id="rg_login_as" onclick="proses();" <? if ($rg_login_as==3) echo "checked";?>/>
							<label>Wasit</label>
						</form>
				 <div class="spacer"> </div>  
				 </div>
				 
			<? }
                if (isset($rg_login_as))
                {
                    switch($rg_login_as)
                    {
                        
                        case 1:
                            $top_header_text="ATLIT";
							include_once ('form_atlit.php');
                            break;
                        
                        case 2:
							include ('form_pelatih.php');
                            $top_header_text="PELATIH";
                            break;
                            
                        case 3:
							include ('form_wasit.php');
                            $top_header_text="WASIT";
                            break;
                        }
                    
                    }
            ?>
			
	  </td>
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
}
?>