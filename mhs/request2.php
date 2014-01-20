<?php
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);
/*define( "DATABASE_SERVER", "localhost" );
define( "DATABASE_USERNAME", "root" );
define( "DATABASE_PASSWORD", "root" );
define( "DATABASE_NAME", "a_teknik" );

 
//menghubungkan dengan database

$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD);

mysql_select_db( DATABASE_NAME );*/

function quote_smart($value)

{

   // Stripslashes

   if (get_magic_quotes_gpc()) {

       $value = stripslashes($value);

   }

   if (!is_numeric($value)) {

       $value = "'" . mysql_real_escape_string($value) . "'";

   }

   return $value;

}

/*if( $_POST["emailaddress"] AND $_POST["username"] AND $_POST["userid"])
{
      //menambah user
      $Query = sprintf("INSERT INTO users VALUES ( %s, %s, %s)", quote_smart($_POST['userid']), quote_smart($_POST['username']),quote_smart($_POST['emailaddress']) );
      $Result = mysql_query( $Query );
}*/

//mengembalikan semua list MHS

//JUMLAH TOTAL MAHASISWA ELEKTRO
$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__1___'");
$row=@mysql_fetch_array($result);
      $jumlah_mhs_elektro = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA KIMIA
$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__2___'");
$row=@mysql_fetch_array($result);
	$jumlah_mhs_kimia = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA INDUSTRI
$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__3___'");
$row=@mysql_fetch_array($result);
	$jumlah_mhs_industri = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA INFORMATIKA
$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__4___'");
$row=@mysql_fetch_array($result);
	$jumlah_mhs_informatika = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA MANUFAKTUR
$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__5___'");
$row=@mysql_fetch_array($result);
$jumlah_mhs_manufaktur = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA DMP
$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__6___'");
$row=@mysql_fetch_array($result);
$jumlah_mhs_DMP = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA SI
$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__7___'");
$row=@mysql_fetch_array($result);
$jumlah_mhs_SI = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA MM
$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__8___'");
$row=@mysql_fetch_array($result);
$jumlah_mhs_MM = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA DUAL DEGREE
$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__9___'");
$row=@mysql_fetch_array($result);
$jumlah_mhs_DD = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA LAKI-LAKI
$result=mysql_query("Select Count(*) as jumlah from master_mhs where sex='L'"); 
//$row = mysql_fetch_array($result);
$jumlah_pria = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA PEREMPUAN
$result=mysql_query("Select Count(*) as jumlah from master_mhs where sex='P'"); 
//$row = mysql_fetch_array($result);
$jumlah_wanita = $row["jumlah"];

$Return = "<data>";
$Return .= "<row name='TE'>
                <jum_mhs>".$jumlah_mhs_elektro."</jum_mhs>
            </row>";
$Return .= "<row name='TK'>
                <jum_mhs>".$jumlah_mhs_kimia."</jum_mhs>
            </row>";
$Return .= "<row name='TI'>
				<jum_mhs>".$jumlah_mhs_industri."</jum_mhs>
			</row>";
$Return .= "<row name='IF'>
				<jum_mhs>".$jumlah_mhs_informatika."</jum_mhs>
			</row>";
$Return .= "<row name='TM'>
				<jum_mhs>".$jumlah_mhs_manufaktur."</jum_mhs>
			</row>";
$Return .= "<row name='DMP'>
				<jum_mhs>".$jumlah_mhs_DMP."</jum_mhs>
			</row>";
$Return .= "<row name='SI'>
				<jum_mhs>".$jumlah_mhs_SI."</jum_mhs>
			</row>";
$Return .= "<row name='MM'>
				<jum_mhs>".$jumlah_mhs_MM."</jum_mhs>
			</row>";
$Return .= "<row name='DD'>
				<jum_mhs>".$jumlah_mhs_DD."</jum_mhs>
			</row>";

$Return .= "</data>";

print ($Return)
?>