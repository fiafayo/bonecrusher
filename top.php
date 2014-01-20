<?php 
session_start();
require("include/global.php");
require("include/fungsi.php");
//background-color: #2061BB;
?>
<html>
<head>
<title>Sistem Informasi Administrasi Fakultas Teknik Universitas Surabaya</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	font-size: 12px;
	color: #FFCC00;
	position:absolute;
	left:580px;
	top:63px;
}
-->
</style>
</head>

<body leftmargin="0" topmargin="0">
<table width="100%" height="85" border="0" cellspacing="0" cellpadding="0" class="body">
        <tr> 
          <td> <div align="left"> 
        <TABLE WIDTH=100% height="85" style="background-repeat:no-repeat" BORDER=0 CELLPADDING=0 CELLSPACING=0 background="img/banner_atu2.jpg">
          <TR> 
            <TD>&nbsp; </TD>
            <TD>&nbsp; </TD>
            <TD COLSPAN=2>&nbsp; </TD>
            <TD ROWSPAN=3 WIDTH=307 HEIGHT=52 align="left"><a href="login.php?m=2" name="link3" target="_top" class="menu style1">LOGOUT</a></TD>
          </TR>
          <TR> 
            <TD>&nbsp; </TD>
            <TD>&nbsp; </TD>
            <TD COLSPAN=2>&nbsp; </TD>
          </TR>
          <TR> 
            <TD>&nbsp; </TD>
            <TD>&nbsp; </TD>
            <TD WIDTH=74 HEIGHT=24 background="images/sia_10.jpg"><div align="right"><font color="#FFFFFF"><a href="main_menu.php?menu=1" name="link1" target="menuFrame" class="menu" id="link1">Umum</a> 
                | </font></div></TD>
            <TD HEIGHT=24 COLSPAN=3 nowrap>
				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td width="70%"><div align="left"><font color="#FFFFFF">&nbsp;<a href="main_menu.php?menu=2" name="link2" target="menuFrame" class="menu" id="link2" onClick="parent.mainFrame.location.href='mhs/mhs_main.php';">Mahasiswa</a> 
                | <a href="main_menu.php?menu=3" name="link3" target="menuFrame" class="menu" id="link3" onClick="parent.mainFrame.location.href='dosen/dosen_main.php';">Dosen</a> | <a href="main_menu.php?menu=4" name="link4" target="menuFrame" class="menu" id="link4" onClick="parent.mainFrame.location.href='kuliah/kuliah_main.php';">Pengajaran</a>
                <!--| <a href="main_menu.php?menu=5" name="link5" target="menuFrame" class="menu" id="link5" onClick="parent.mainFrame.location.href='kerjasama/kerjasama_main.php';">Kerjasama</a-->
				| <a href="main_menu.php?menu=6" name="link6" target="menuFrame" class="menu" id="link6" onClick="parent.mainFrame.location.href='scard/scard_main.php';">S-card</a> 
                </font></div></td>
					<td width="30%">&nbsp;</td>
				  </tr>
				</table>
            </TD>
				<td HEIGHT=24 COLSPAN=4 nowrap width="20">&nbsp;</td>
          </TR>
          <TR> 
            <TD> <IMG SRC="images/spacer.gif" WIDTH=101 HEIGHT=1 ALT=""></TD>
            <TD> <IMG SRC="images/spacer.gif" WIDTH=114 HEIGHT=1 ALT=""></TD>
            <TD> <IMG SRC="images/spacer.gif" WIDTH=74 HEIGHT=1 ALT=""></TD>
            <TD width="495"> <IMG SRC="images/spacer.gif" WIDTH=188 HEIGHT=1 ALT=""></TD>
            <TD> <IMG SRC="images/spacer.gif" WIDTH=307 HEIGHT=1 ALT=""></TD>
          </TR>
        </TABLE>
      </div></td>
        </tr>
</table>
</body>
</html>