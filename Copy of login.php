<? 
ob_start();
session_start();
require("include/fungsi.php");
require("include/global.php");
require("include/temp.php");
if ($m!=2) {
session_register("logged_status");
session_register("user_login");
session_register("hak");
session_register("password");
}
else
if ($m==2) {
session_destroy();
}
if ($m==1) { //global $logged_status;
$logged_status=f_login_user($frm_login,$frm_password,$hak);
//echo "<br>log status=".$logged_status;
if ($logged_status==1) { 
$user_login = $frm_login;
$password = $frm_password;
// BEGIN logging time
$thn=date("Y");
$bln=date("m");
$hr=date("d");
$jam=date("H")-1;
$mnt=date("i");
$sec=date("s");
$sekarang=$thn."-".$bln."-".$hr." ".$jam.":".$mnt.":".$sec;
//echo "--now".$sekarang;
$res_updated = mysql_query("UPDATE master_user SET `log`='".$sekarang."' WHERE `login`='$user_login'");
// END logging time

//ob_end_clean();
ob_clean();
header();  
header("Location: index.php?logged_status=".$logged_status); /* Redirect browser */
header("Location: index.php"); /* Redirect browser */
} else { $pesan=$pesan."Maaf, nama login / password anda tidak valid";}
}
//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>Sistim Informasi Administrasi Fakultas Teknik Universitas Surabaya</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="document.form1.frm_login.focus();" topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="left"> <form name="Tick">
        <input type="text" size="10" name="Clock" class="jam">
      </form>
      <script class="jam">
				<!--
				/*By George Chiang (JK's JavaScript tutorial)
				http://javascriptkit.com
				Credit must stay intact for use*/
				function show(){
				var Digital=new Date()
				var hours=Digital.getHours()
				var minutes=Digital.getMinutes()
				var seconds=Digital.getSeconds()
				var dn="am"
				if (hours>12){
				dn="pm"
				hours=hours-12
				}
				if (hours==0)
				hours=12
				if (minutes<=9)
				minutes="0"+minutes
				if (seconds<=9)
				seconds="0"+seconds
				document.Tick.Clock.value=hours+":"+minutes+":"
				+seconds+" "+dn
				setTimeout("show()",1000)
				}
				show()
				//-->
				</script> 
	</td>
    <td align="right"> 
	<script>
		var mydate=new Date()
		var year=mydate.getYear()
		if (year < 1000)
		year+=1900
		var day=mydate.getDay()
		var month=mydate.getMonth()
		var daym=mydate.getDate()
		if (daym<10)
		daym="0"+daym
		var dayarray=new Array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu")
		var montharray=new Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember")
		document.write("<small><font color='#0080C0' face='arial'><b>"+dayarray[day]+", "+daym+" "+montharray[month]+" "+year+"</b></font></small>")
	</script> </td>
  </tr>
  <tr> 
    <td colspan="2">
<?php
if ( getenv(HTTP_X_FORWARDED_FOR) ) {
echo "Anda mengakses dengan proxy server<br>";
//echo "Real IP anda : <br>". $_SERVER['HTTP_X_FORWARDED_FOR'] ."<br>";
echo "Terkoneksi lewat engine : <br>". $_SERVER['HTTP_VIA'] ."<br>";
echo "Proxy IP : " . $_SERVER['REMOTE_ADDR'];
} else {
echo "Anda terkoneksi tanpa proxy<br>";
//echo "Real IP anda : ". $_SERVER['REMOTE_ADDR'];
}

function real_ip ()
{
if ($_ENV["HTTP_CLIENT_IP"]) $ip = $_ENV["HTTP_CLIENT_IP"];
elseif ($_ENV["HTTP_X_FORWARDED_FOR"]) $ip = $_ENV["HTTP_X_FORWARDED_FOR"];
elseif ($_ENV["HTTP_X_FORWARDED"]) $ip = $_ENV["HTTP_X_FORWARDED"];
elseif ($_ENV["HTTP_FORWARDED_FOR"]) $ip = $_ENV["HTTP_FORWARDED_FOR"];
elseif ($_ENV["HTTP_FORWARDED"]) $ip = $_ENV["HTTP_FORWARDED"];
elseif ($_SERVER['REMOTE_ADDR']) $ip = $_SERVER['REMOTE_ADDR'];
return $ip;
}
echo "<br>IP anda: ".real_ip ();
?>
	</td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2" align="center"><font size="1" color="#999999">
	<? require("include/js_function.js");?>
	<script language="javascript" >
	 last_visit()
	</script>
	</font>
	<hr width="800" size="1" noshade color="#FF0000"></td>
  </tr>
  <tr> 
    <td colspan="2">
		<table width="800" height="120"  border="0" align="center" cellpadding="2" cellspacing="0">
		<tr>
		<td background="img/background2.jpg">
			<table width="21%" height="80"  border="1" align="center" cellpadding="2" cellspacing="0" class="login">
		<tr>
			<td>
			<form action="login.php?m=1" method="post" name="form1" id="form1">
                    <table border=0 align="center" cellpadding="2" cellspacing="0">
                      <tr> 
                        <td colspan="2"></td>
                      </tr>
                      <tr> 
                        <td><div align="right"><font color="#0099CC"><strong>Username 
                            :</strong></font></div></td>
                        <td> <input id="frm_login" name="frm_login" type="text" size="12" class="textLogin"> 
                        </td>
                      </tr>
                      <tr> 
                        <td nowrap><div align="right"><font color="#0099CC"><strong>Password 
                            :</strong></font></div>
                        <td> <input id="frm_password" name="frm_password" type="password" size="12" class="textLogin"> 
                        </td>
                      </tr>
                      <tr> 
                        <td> 
                        <td><input id="Login" name="Login" type="submit" value="Login" class="tombol_login">
						</td>
                      </tr>
                    </table>
              </form>
			</td>
		</tr>
	  </table>		</td>
		</tr>
	  </table>
	</td>
  </tr>
  <tr> 
    <td colspan="2"><div align="center"> 
      </div></td>
  </tr>
  <tr> 
    <td colspan="2"><hr width="800" size="1" noshade color="#FF0000"> 
		<SCRIPT LANGUAGE="JavaScript">
		today=new Date();
		y0=today.getFullYear();
		</SCRIPT>
	</td>
  </tr>
  <tr>
    <td colspan="2"><div align="center"><font color="#FF0000" size="1"><? echo $pesan;?></font></div></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
		<center>
		  <font size="1">
		  Copyright © 2007 -
			<SCRIPT LANGUAGE="JavaScript">
			document.write(y0);
			</SCRIPT> <a href="mailto:joenk23@yahoo.com">Fakultas Teknik UBAYA</a>
		</font>
		</center>
	</td>
  </tr>
</table>
</body>
</html>
<? // echo ob_flush();?>