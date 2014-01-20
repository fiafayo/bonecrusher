<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>internet sehat</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

body {
	background-image: url(images/background.jpg);
	background-repeat: repeat-x;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}

-->

</style>

<link href="styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a:link {
	color: #233937;
}

a:visited {
	color: #595E61;
}

a:hover {
	color: #595E61;
}

a:active {
	color: #990000;
}

h1,h2,h3,h4,h5,h6 {
	font-family: Georgia, Times New Roman, Times, serif;
}

h1 {
	font-size: 24px;
	color: #0C1514;
}

h2 {
	font-size: 18px;
	color: #2E4344;
}

h3 {
	font-size: 16px;
	color: #000000;
}
.style2 {font-size: 9px}
.style3 {color: #FF0000}
.style4 {
	font-size: 10px;
	color: #FF0000;
}

-->

</style>
</head>

<body><table width="758" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="257" colspan="2" valign="top"><div class="top"><br />
        <br />
          <br />
        </div>
      <div class="menu">

      <div class="menusystem"><ul class="themenu">

            <li><a href="index.php">Home</a></li>

            <li><a href="lomba_opini.php">Lomba Opini</a></li>

            <li><a href="talk_show.php">Talk Show</a></li>

            <li><a href="pendaftaran.php">Pendaftaran</a></li>

            <li><a href="contact.php">Contact us</a></li>

        </ul></div>

    </div></td>

  </tr>

  <tr>

    <td colspan="2" valign="top"></td>

  </tr>

  <tr>

    <td width="242" height="0" align="left" valign="top" bgcolor="#FFFFFF"><div class="side-top">

      Heading

    </div>

      <div class="side-center"> 
        <p>Pelejar berinternet ? Biasa !<br />
          Pelajar gak bisa pake internet ??? Udah gak jaman !</p>
        <p>Lomba Penulisan Opini <br />
          ‘Internet Sehat bagi Pelajar’<br />
          batas akhir penerimaan naskah <br />
          Sabtu, 21 Maret 2009</p>
        <p>Talk Show ‘Internet Sehat bagi Pelajar’<br />
          Sabtu, 28 Maret 2009<br />
          Di Ubaya Kampus Tenggilis<br />
          Pembicara utama :<br />
          Staf Khusus Menkominfo</p>
        <p><br />
          It’s Free<br />
        </p>
      </div>

      <div class="side-bot">      </div></td>

    <td width="516" valign="top"><table width="516" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">

      <tr>

        <td valign="top"><h1><font size="4"><strong><font color="#0033FF">Pendaftaran 
              :</font></strong></font></h1>
			 <form enctype="multipart/form-data" name="form_send_mail" id="form_send_mail" method="post">
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr> 
                <td width="17%"><font color="#0000FF"><strong><font color="#000000">Nama</font></strong></font></td>  
                <td width="3%"><strong>:</strong></td>
                <td width="80%"><input type="text" name="frm_nama" id="frm_nama" value="<? echo $frm_nama;?>" />
                  <span class="style3">*</span></td>
              </tr>
              <tr> 
                <td><strong><font color="#000000">Alamat</font></strong></td>  
                <td><strong>:</strong></td>
                <td><input type="text" name="frm_alamat" id="frm_alamat" value="<? echo $frm_alamat;?>" />
                  <span class="style3">*</span></td>
              </tr>
              <tr> 
                <td><strong><font color="#000000">Telp / HP</font></strong></td>  <td><strong>:</strong></td>
                <td><input type="text" name="frm_telp" id="frm_telp" value="<? echo $frm_telp;?>" />
                  <span class="style3">*</span></td>
              </tr>
              <tr> 
                <td><font color="#0000FF"><strong><font color="#000000">Email</font></strong></font>                </td>  <td><strong>:</strong></td>
                <td><input type="text" name="frm_email" id="frm_email" value="<? echo $frm_email;?>" />
                  <span class="style3">*</span></td>
              </tr>
              <tr> 
                <td nowrap="nowrap"><strong><font color="#000000">Nama Sekolah</font></strong></td>  <td><strong>:</strong></td>
                <td><input type="text" name="frm_nm_skol" id="frm_nm_skol" value="<? echo $frm_nm_skol;?>" />
                  <span class="style3">*</span></td>
              </tr>
              <tr>
                <td><font color="#0000FF"><strong><font color="#000000">Attach 
                  File</font></strong></font></td>  
                <td><strong>:</strong></td>  <td><input type="file" name="frm_nm_file" id="frm_nm_file"  value="<? echo $frm_nm_file;?>" />
                  <span class="style3">*</span>                  <span class="style2">(<span class="style3"> maks. 1MB, *.doc </span>)</span></td>
              </tr>
              <tr> 
                <td colspan="3"><span class="style4">tanda ` * ` harus di isi</span></td>
                </tr>
              <tr> 
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="submit" name="frm_kirim" id="frm_kirim" value="KIRIM" /></td>
              </tr>
            </table>
			</form>
			<?
			//######################################
			if (isset($frm_kirim))
			{
			
				include('Easy_Mail.class.php');
				function format_size($bytes)
				{
					$symbol = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
					
					$exp = 0;
					$converted_value = 0;
					if( $bytes > 0 )
					{
					$exp = floor( log($bytes)/log(1024) );
					$converted_value = ( $bytes/pow(1024,floor($exp)) );
					}
					
					return sprintf( '%.1f '.$symbol[$exp], $converted_value );
				}
				
					
				/*	$file   = "handbook.pdf" ;  // File name or path Example : file/image.gif
					$html   = "<b><i>Tes Mail.class.php</i></b>" ;
					$message= "Tes aja" ;
					$subject= "Recovery Easy_Email.class.php" ;
					$to     = "dolly.aswin@gmail.com" ;
					$from   = "Dolly Aswin Hrp <dolly.aswin@nusa.net.id>" ;
					$return = "dolly.aswin@nusa.net.id" ;
					$mail   = &new Easy_Email($from, $to, $subject, $return) ;
					$mail->simpleMail($message) ;   // Use this to send simple email
					$mail->htmlMail($html) ;        // Use this to send html email
					$mail->simpleAttachment($file,$message) ;   // Use this to send simple email with attachment
					$mail->htmlAttachment($file,$html) ;        // Use this to send html email with attachment
			 */
				$to      = 'isehat@ubaya.ac.id';
				
				$subject = 'PENDAFTARAN i-sehat';
				$frm_nama = $_POST['frm_nama'];
				$frm_alamat = $_POST['frm_alamat'];
				$frm_telp = $_POST['frm_telp'];
				$frm_email = $_POST['frm_email'];
				$frm_nm_skol = $_POST['frm_nm_skol'];
				$max_file = 1048577;
				
				$from = $frm_nama."<".$frm_email.">";
				$return = $frm_email;
				
				$attach_file_tmp = $_FILES['frm_nm_file']['tmp_name'];
				$attach_file_name = $_FILES['frm_nm_file']['name']; 
				$attach_file_size = $_FILES['frm_nm_file']['size']; 
				$attach_file_type = $_FILES['frm_nm_file']['type']; 
				
				
				
				$message .= "$frm_nama\n";
				$message .= "$frm_alamat\n";
				$message .= "$frm_telp\n";
				$message .= "$frm_email\n";
				$message .= "$frm_nm_skol\n";
				
				
				/*$headers = 'From: webmaster@example.com' . "\r\n" .
				'Reply-To: webmaster@example.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();*/
				
				//mail($to, $subject, $message, $headers);
			
				//echo "<br>attach_file_name = ".$attach_file_name; 
				
				if ($attach_file_type <> 'application/msword') 
				{
					$s_error=1;
					echo "<script>alert('Tipe File salah! Tipe yang diperbolehkan hanya file document (*.doc)');</script>";
				}
				else
				{
						if ($attach_file_size > 0) {
								if ($attach_file_size <= $max_file)
								{	
									$mail   = &new Easy_Email($from, $to, $subject, $return) ;
									//$mail->simpleAttachment($attach_file_name, $message) ;   // Use this to send simple email with attachment
									//$mail->htmlAttachment($file,$html) ;        // Use this to send html email with attachment
									if ($mail->simpleAttachment($attach_file_name, $message)) {
									echo "email anda telah terkirim";
									}
								}
								else
								{
									$s_error=1;
									echo "<script language=\"JavaScript\">alert('File terlalu besar! (Max. ".format_size($max_file).")');</script>";
								}
						}
						else
						{
							$s_error=1;
							echo "<script language=\"JavaScript\">alert('File tidak boleh kosong!');</script>";
						}
				}
			}
			//######################################
			?>
           </td>

      </tr>

    </table></td>

  </tr>

  <tr>

    <td colspan="2"><div class="bottom">

        <div class="bottom-menu"> 
          <ul class="thebmenu">
            <li><a href="index.php">Home</a></li>
            <li><a href="lomba_opini.php">Lomba Opini</a></li>
            <li><a href="talk_show.php">Talk Show</a></li>
            <li><a href="pendaftaran.php">Pendaftaran</a></li>
            <li><a href="contact.php">Contact us</a></li>
			
          </ul>
        </div>

    </div></td>

  </tr>

  <tr>

    <td colspan="2" bgcolor="#FFFFFF"><div align="center"></div></td>

  </tr>

</table>



<div style="text-align: center; font-size: 0.75em;"> Copyright © 2008 by cakra</div>
</body>

</html>

