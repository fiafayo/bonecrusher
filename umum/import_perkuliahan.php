<html>
<head>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	font-size: 9px;
	color: #FF0000;
}
.style3 {color: #FF0000}
-->
</style>
</head>
<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><font color="#FF0000" ><b><?php echo $pesan; ?></b></font></td>
  </tr>
  <tr>
    <td><hr size="1" color="#FF9900"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>SETTING ~</strong> IMPORT PERKULIAHAN </font></font> </td>
          <td width="9%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">UMUM</font></strong></div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><hr size="1" color="#FF9900"></td>
  </tr>
</table>
<form method="post" action="import_perkuliahan.php?imp=1" enctype="multipart/form-data">
		<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0">
		  <tr>
		    <td nowrap>&nbsp;</td>
		    <td nowrap>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td nowrap>&nbsp;</td>
		    <td nowrap>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td width="11%" nowrap>&nbsp;</td>
			<td width="32%" nowrap>Nama file database yang akan di import</td>
			<td width="3%"><strong>:</strong></td>
			<td width="54%"><input name="frm_nama_file" type="file" size="50" class="tekboxku">
			  <span class="style1">*</span></td>
		  </tr>

		  <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input type="submit" name="submit"  value="Upload File" class="tombol">
		  </td></tr>
		  <tr><td colspan="4">&nbsp;</td></tr>
		 <tr><td colspan="4">
		 <table width="100%">
				  <tr>
					<td align="right" valign="top"># </td>
					<td><strong><font color="#FF0000">Apabila data yang lama sudah 
				ada, maka data yang ada akan disesuaikan dengan data baru !</font></strong></td>
			    </tr><tr>
					<td align="right" valign="top"> @</td>
					<td> Format file database adalah &quot; <em>*.sql</em> &quot;, dengan struktur database sesuai dengan struktur ADSIM tertanggal Agustus 2003 </td>
				</tr>
				<tr><td align="right"><span class="style3">*</span></td><td> compulsory / harus diisi</td>
		  </tr>
		  </table>
		  </td>
		  </tr>
		</table>
</form>
</body>
</html>

<?php
if ($imp==1)
{
/*
* Restore MySQL dump using PHP
* (c) 2006 Daniel15
* Last Update: 9th December 2006
* Version: 0.1
*
* Please feel free to use any part of this, but please give me some credit :-)
*/
echo "<br>import = ".$imp;
echo "<br>frm_nama_file=".$_FILES['frm_nama_file']['name'];
//exit();
// Name of the file
$filename = $_FILES['frm_nama_file']['name'];
// MySQL host
$mysql_host = 'localhost';
// MySQL username
$mysql_username = 'root';
// MySQL password
$mysql_password = 'root';
// Database name
$mysql_database = 'test';
 
//////////////////////////////////////////////////////////////////////////////////////////////
 
// Connect to MySQL server
mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
// Select database
mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());
 
// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$lines = file($filename);
// Loop through each line
foreach ($lines as $line_num => $line) {
  // Only continue if it's not a comment
  if (substr($line, 0, 2) != '--' && $line != '') {
    // Add this line to the current segment
    $templine .= $line;
    // If it has a semicolon at the end, it's the end of the query
    if (substr(trim($line), -1, 1) == ';') {
      // Perform the query
      mysql_query($templine) or print('Error performing query \'<b>' . $templine . '</b>\': ' . mysql_error() . '<br /><br />');
      // Reset temp variable to empty
      $templine = '';
    }
  }
}


} //end if
?>