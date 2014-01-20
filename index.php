<?php

session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
                                                     // always modified
header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");                          // HTTP/1.0


require("include/fungsi.php");
require("include/global.php");
$logged_status = $_SESSION['logged_status'];
if ($logged_status!=1) {
header("Location: login.php"); /* Redirect browser */
exit;
}?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>Sistem Informasi Administrasi</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<frameset rows="80,*,15" cols="*" framespacing="0" frameborder="NO" border="0">
  <frame src="top.php" name="topFrame" scrolling="NO" noresize>
  <frameset rows="*" cols="199,*">
    <frame src="main_menu.php" name="menuFrame" >
    <frame src="main.php" name="mainFrame">
  </frameset>
  <frame src="bottom.php" name="bottomFrame" scrolling="NO" noresize>
</frameset>
<noframes><body>
</body></noframes>
</html>