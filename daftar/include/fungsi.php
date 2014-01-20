<?php
/*
    CREATED : 28/05/07 - RAHADI
*/    

// function f_connecting() untuk connect ke database 
// function f_authenticate_user($user,$password,$logged) untuk authentifikasi user dengan return 0=password salah, 1=benar
// function f_kerjakan($sql) untuk execute sql insert, update, delete 
// function f_paging
// function datetoreport
// function datetomysql
// function timetomysql


//require ("global.php") ;
require("waktu.php");

function f_connecting()
{
	global $USER_DB;
	global $PASS_DB;
	global $HOSTNAME;

    	if (!($LINK=mysql_connect($HOSTNAME,$USER_DB,$PASS_DB)))
    	{
		echo mysql_error();
		return 0;
    	}
}


function f_login_user($user,$password,&$level)
{
	global $USER_DB;
	global $PASS_DB;
	global $HOSTNAME;
	global $DB;
		
    	if (!($LINK=mysql_connect($HOSTNAME,$USER_DB,$PASS_DB)))
    	{
		echo mysql_error();
		return 0;
    	}

	if (!($result = mysql_db_query("$DB", "select * from master_user where login='$user'")))
	{
		echo mysql_error();
		return 0;
    	}
	if (($row=mysql_fetch_array($result)) && ($password==$row["password"] && $password!="" ))
	{
		$level=$row["hak"];
		$hak=$row["hak"];
		
		return 1;
	}
	else
	{	return 0; }
}

function f_authenticate_user($user,$password,$logged)
{
	global $USER_DB;
	global $PASS_DB;
	global $HOSTNAME;
	global $DB;
	

    	if (!($LINK=mysql_connect($HOSTNAME,$USER_DB,$PASS_DB)))
    	{
		echo mysql_error();
		return 0;
    	}

	if (!($result = mysql_db_query("$DB", "select * from master_user where login='$user'")))
	{
		echo mysql_error();
		return 0;
    }
	if (($row=mysql_fetch_array($result)) && ($password==$row["password"] && $password!="" && $logged==1))
		return 1;
	else
		return 0;
}

function f_kerjakan($sql)
{

	global $DB;	
	if(!($result=mysql_db_query($DB,$sql)))
	{
		echo mysql_error();
		return 0;
	}
}

function datetomysql($datecheck)
{

list($Day,$Month,$Year) = explode("/",$datecheck);

$stampeddate = adodb_mktime(12,0,0,$Month, $Day, $Year);
//return checkdate($Month, $day, $Year);
if (checkdate($Month, $Day, $Year)) {
//return "ok";
return date("Y-m-d",$stampeddate);
}
else
{
return "not ok";

return 0;

}
}



function timetomysql($datecheck)
{
list($Hour,$Minute,$Secs) = split(":",$datecheck);
$stampeddate = mktime($Hour,$Minute,$Secs,8,29,72);
return date("H:i:s",$stampeddate);
}

function f_paging($hal,$jumhal,$vP,$fontface="Verdana",$fontsize="1") 
{
if ($hal >= 1 ) {
print "
<font face=\"$fontface\" size=$fontsize >
";
if (floor(($hal-1)/10) >0){
	$page = (floor($hal/10)-1)*10+1 ;
	$v = $vP."&hal=".$page;
	print "[ <a href=\"$v\">Prev</a> ]";
}else {
	print "&nbsp;";
	}

$start=floor(($hal-1)/10)*10+1;

if (floor(($jumhal-1)/10)-floor(($hal-1)/10) > 0) {$end=$start+9;}else{$end=$jumhal;}
 echo " [ ";
for ($i=$start; $i<=$end;$i++) {
if ($jumhal > 0) {
	if($i <> $hal) {
		$v = $vP."&hal=".$i;
		print " <a href=\"$v\">$i</a> ";
		}else {
		  print " <b>$i</b> ";
		  }
	}
}

print " ]
	";

if (floor(($hal-1)/10) < floor($jumhal/10)) {
	$page = (floor(($hal-1)/10)+1)*10+1;
	$v = $vP."&hal=".$page;
	print "[ <a href=\"$v\">Next</a> ]";
	} else {
		print "&nbsp;";
	};

//print "	<b>Page : $hal </b>/ $jumhal";
print "	</font>";
};
}

function datetoreport($datecheck)
{

list($Year,$Month,$Day) = split("-",$datecheck);

$stampeddate = mktime(12,0,0,$Month, $Day, $Year);
if (checkdate($Month, floor($Day), $Year)) 
{ return date("d-m-Y",$stampeddate); }
else
{ return 0; }

}
function datetoreport2($datecheck)
{

list($Year,$Month,$Day) = split("-",$datecheck);

$stampeddate = mktime(12,0,0,$Month, $Day, $Year);
if (checkdate($Month, floor($Day), $Year)) 
{ return date("d/m/Y",$stampeddate); }
else
{ return 0; }

}


function datetomysql2($datecheck)
{

list($Day,$Month,$Year) = split("/",$datecheck);

$stampeddate = adodb_mktime(12,0,0,$Month, $Day, $Year);
//return checkdate($Month, $day, $Year);
echo "<br>a. Input tanggal: " . $datecheck;
echo "<br>b. Hasil fungsi mktime: " . $stampeddate;
echo "<br>c. Hasil fungsi date(Y-m-d): " . date("Y-m-d",$stampeddate);
if (checkdate($Month, $Day, $Year)) {
//return "ok";

echo "<br>d. Hasil fungsi date(Y-m-d): " . date("Y-m-d",$stampeddate);
echo "<br>e. Isi variable stamppeddate: " . $stampeddate;
return date("Y/m/d",$stampeddate);
}
else
{
return "not ok";

return 0;

}
}
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
?>