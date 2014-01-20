<?
include("include/session.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/layout.css" rel="stylesheet" type="text/css">
<title>GABSI- Lupa Password</title>
</head>
<body>
<div id="stylized" class="myform"> 
<?
/**
 * Forgot Password form has been submitted and no errors
 * were found with the form (the username is in the database)
 */
if(isset($_SESSION['forgotpass'])){
   /**
    * New password was generated for user and sent to user's
    * email address.
    */
   if($_SESSION['forgotpass']){
      echo "<h1>Password Baru Berhasil dikirimkan</h1>";
      echo "<p>Password baru Anda telah dibuatkan "
          ."dan dikirimkan ke alamat email Anda. "
          ."<a href=\"Login.php\">Kembali</a>.</p>";
   }
   /**
    * Email could not be sent, therefore password was not
    * edited in the database.
    */
   else{
      echo "<h1>Password Baru Gagal dikirimkan</h1>";
      echo "<p>Terjadi kesalahan saat mengirim email dengan password baru Anda, <br> sehingga password Anda belum berubah."
          ."<a href=\"login.php\">Kembali</a>.</p>";
   }
       
   unset($_SESSION['forgotpass']);
}
else{

/**
 * Forgot password form is displayed, if error found
 * it is displayed.
 */
?>
      <form action="process.php" method="POST">
	  <h1>Lupa Password</h1> 
      <p>Sebuah password baru akan dibuat untuk Anda dan dikirim ke alamat email
Anda, yang harus Anda lakukan sekarang adalah memasukkan username Anda.</p>
		<label>Username: <span class="small">ketik username Anda</span> </label> 
        <input type="text" name="user" maxlength="30" value="<? echo $form->value("user"); ?>">
        <input type="hidden" name="subforgot" value="1">
         <label><span class="small">klik tombol ini untuk mendapatkan password</span></label> 
		<input type="submit" value="Get New Password">
      </form>
	  <div class="spacer">
  </div> 
    <h3>
    <?
		echo "<b>Anggota Total:</b> ".$database->getNumMembers()."<br>";
		echo "Terdapat $database->num_active_users Anggota dan ";
		echo "$database->num_active_guests Tamu yang online.";
	?>
	</h3>
      <?
}
      echo $form->error("user"); 
echo "<br><a href=\"login.php\">Kembali</a></td></tr>
<tr><td align=\"center\">";
?>
</div>
</body>
</html>
