<?php
session_start();
require("../include/global.php");
require("../include/sia_function.php");


f_connecting();
	mysql_select_db($DB);
?>


<html>
<head>
<title>Daftar Mata Kuliah</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table>
<tr><td colspan="2">Daftar Mata Kuliah</td></tr>
<tr><td></td><td></td></tr>

<?php
$result = mysql_query("Select kode_mk, nama from master_mk order by kode_mk");
while ($row = mysql_fetch_array($result))
{
?>
<tr><td><?php echo $row["kode_mk"];?></td><td><?php echo $row["nama"];?></td></tr>
<?php
}
 
?>
</table>
</body>
</html>
