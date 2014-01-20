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
						/**
						 * The user is already logged in, not allowed to register.
						 */
						if($session->logged_in){
						   echo "<p>Maaf <b>$session->username</b>, Anda sudah terdaftar. "
							   ."<a href=\"login.php\">Halaman Depan</a>.</p>";
						}
						/**
						 * The user has submitted the registration form and the
						 * results have been processed.
						 */
						else if(isset($_SESSION['regsuccess'])){
						   /* Registration was successful */
						   if($_SESSION['regsuccess']){
							  echo "<h1>Registrasi Sukses!</h1>";
							  echo "<p>Terima kasih <b>".$_SESSION['reguname']."</b>, Informasi Registrasi Account Anda telah berhasil disimpan, "
								  ."Silahkan <a href=\"login.php\">log in</a>.</p>";
						   }
						   /* Registration failed */
						   else{
							  echo "<h1>Registrasi Gagal</h1>";
							  echo "<p>Kami Mohon maaf, kesalahan telah terjadi dan pendaftaran Anda untuk username <b>".$_SESSION['reguname']."</b>, tidak dapat diselesaikan. <br>Silakan coba lagi di lain waktu.</p>";
						   }
						   unset($_SESSION['regsuccess']);
						   unset($_SESSION['reguname']);
						
						?>
						
						<?
						}
						else{
						?>
						<div id="stylized" class="myform"> 
						<!--form action="process.php" method="POST"-->
						<form action="process.php" method="POST">
							<h1>Registrasi</h1> 
							<p>Silahkan melakukan registrasi pada form berikut</p> 
							<label>Username <span class="small">ketik username Anda</span> </label>
							<input type="text" name="user" maxlength="30" value="<? echo $form->value("user"); ?>">
							<label>Password <span class="small">ketik password Anda</span> </label>
							<input type="password" name="pass" maxlength="30" value="<? echo $form->value("pass"); ?>">
							<label>Email<span class="small">ketik alamat email Anda</span> </label>
							<input type="text" name="email" maxlength="50" value="<? echo $form->value("email"); ?>">
							<label>&nbsp;<span class="small"></span></label>
							<input type="hidden" name="subjoin" value="1">
							<input type="submit" value="Join!">
						</form>
						
						<div class="spacer">
						  </div> 
							<h3>
								<?
								echo "<b>Anggota Total:</b>".$database->getNumMembers()."<br>";
								echo "Terdapat $database->num_active_users Anggota dan ";
								echo "$database->num_active_guests Tamu yang online.";
								?>
							</h3>
						<?
						if($form->num_errors > 0){
						   echo "<font size=\"2\" color=\"#ff0000\">terdapat ".$form->num_errors." kesalahan</font><br>";
						}
						echo "<font size=\"2\" color=\"#ff0000\">".$form->error("user")."<br>"; 
						echo $form->error("pass")."<br>";  
						echo $form->error("email")."<br></font>"; 
						}
						?>
						<a href="login.php">Kembali</a>
						</div> 
									
</div>
</body>
</html>