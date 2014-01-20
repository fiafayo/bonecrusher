<? 
session_start();

// CEK AUTHENTIFIKASI USER
//if (!f_authenticate_user($USERNAME,$PASSWORD,$LOGGED))
//{
//	header("Location:http://".$HOSTNAME."/login.htm");
//	exit();
//}
f_connecting();
mysql_select_db($DB);
$result_empty_temp = mysql_query("delete from temp_dalam where id_temp='".session_id()."'");
$result_empty_temp = mysql_query("delete from temp_luar where id_temp='".session_id()."'");
?>