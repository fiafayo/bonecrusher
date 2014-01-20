<? 
include("include/session.php");
//if($session->logged_in){ 
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

	   <div id="footer"> 
          
          <!-- endof #quickNavigation --> 
        </div> 

</div>
</body>
</html>
<? 
/*
}
else
{
	header('Location: process.php');
}
*/
?>