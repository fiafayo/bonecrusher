<?php
/* 
   HISTORY      : 05/08/03 - Eko
   DATE CREATED : 05/08/03
   UPDATE  		: 
   PROBLEM 		:  
   KEGUNAAN     : ENTRY MASTER KOTA
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
  
   
*/
session_start();
require("../include/global.php");
require("../include/sia_function.php");


f_connecting();
	mysql_select_db($DB);


					$result = mysql_query("select * from import_ta" );
					while($row = mysql_fetch_array($result))
					{
						$result1=mysql_query("select id from ta where no_surat_tugas='".$row["f_nst"]."'");
						$row1 = mysql_fetch_array($result1);
				
						$result1=mysql_query("insert into detail_ta (id_ta,nrp) values ('".$row1["id"]."','".$row["f_nrp"]."')");
						echo "insert into detail_ta (id_ta,nrp) values ('".$row1["id"]."','".$row["f_nrp"]."') - ".mysql_affected_rows()." - inserting ".$row["kode"]."<br>";
					
					}

	
	
?>