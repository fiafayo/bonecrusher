<? include("include/session.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/layout.css" rel="stylesheet" type="text/css">
<title>GABSI</title>
</head>
<body>
<?
 if (($_POST['frm_proses_recaptcha'])=='PROSES')
 {        
		  require_once('include/recaptchalib.php');
		  $privatekey = "6LfpG8USAAAAAF9jpxhZ54gKQo3bvfh3-oPmIu6I";
		  $resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"],	$_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
		
		  if (!$resp->is_valid) {
			// What happens when the CAPTCHA was entered incorrectly
			/*die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
				 "(reCAPTCHA said: " . $resp->error . ")");*/
						$error = 1;
						$pesan = $pesan."Data yang Anda masukkan salah! <br> Silahkan ketik ulang form diatas dengan benar";
						?>
						<script language="javascript">//confirmRefresh();
							document.location="captcha.php?pesan=<?=$pesan;?>";    
						</script>
			<?
			} 
			else 
			{
			// Your code here to handle a successful verification
			?>
			            <script language="javascript">//confirmRefresh();
							document.location="register.php";    
						</script>
			<?
			}
						
}
else
{
?>
<div id="stylized" class="myform"> 
<form method="post" action="register.php">
	<h1>PENDAFTARAN</h1> 
	<p>Untuk bisa masuk ke halaman form Pendaftaran silahkan ketik tulisan yang terlihat dibawah ini</p> 
	<?php
	require_once('include/recaptchalib.php');
	$publickey = "6LfpG8USAAAAAGdBL6YhBOCeakPFp2rT8LHDy4p7"; // you got this from the signup page
	echo recaptcha_get_html($publickey);
	?><br>
	<input type="submit" id="frm_proses_recaptcha" name="frm_proses_recaptcha" value="PROSES" />
	<div class="spacer"></div> 
	
	<div style="color:#FF0000; font-weight:bold;"><? echo $_GET['pesan'];?> </div>
</form>
<?
} 
?>
</div>
</body>
</html>