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


					$result = mysql_query("select * from import_master_karyawan" );
					while($row = mysql_fetch_array($result))
					{
						$result1=mysql_query("select * from master_karyawan where nip='".$row["npk"]."'");
						if (mysql_num_rows($result1)>0){
						
						$result2=mysql_query("select id from pendidikan where nama='".trim($row["pendidikan"])."'");
						$row2 = mysql_fetch_array($result2);
						
						$result1=mysql_query("update master_karyawan set jurusan=".$row["bagian"].", id_pangkat=".$row["pangkat_lo"].", tanggal_pengangkatan='".$row["tmt_pangka"]."', pendidikan=".$row2["id"]."    where nip='".$row["npk"]."'");
						
						echo "update master_karyawan set jurusan=".$row["bagian"].", id_pangkat=".$row["pangkat_lo"].", tanggal_pengangkatan='".$row["tmt_pangka"]."', pendidikan=".$row2["id"]."    where nip='".$row["npk"]."' - ".mysql_affected_rows()." - updating ".$row["kode"]."<br>";
						
						}
						else
						{
						$result2=mysql_query("select id from pendidikan where nama='".trim($row["pendidikan"])."'");
						$row2 = mysql_fetch_array($result2);
						
						$result1=mysql_query("insert into master_karyawan (nip,nama,jurusan,alamat,sex, tanggal_lahir, id_pangkat, tanggal_pengangkatan,pendidikan) values ('".$row["npk"]."','".$row["nama"]."',".$row["bagian"].",'".$row["alamat"]."','".$row["kelamin"]."','".$row["tgl_lahir"]."','".$row["pangkat_lo"]."','".$row["tmt_pangka"]."','".$row2["id"]."')");
						echo "insert into master_karyawan (nip,nama,jurusan,alamat,sex, tanggal_lahir, id_pangkat, tanggal_pengangkatan,pendidikan) values ('".$row["npk"]."','".$row["nama"]."',".$row["bagian"].",'".$row["alamat"]."','".$row["kelamin"]."','".$row["tgl_lahir"]."','".$row["pangkat_lok"]."','".$row["tmt_pangkat"]."','".$row2["id"]."') - ".mysql_affected_rows()." - inserting ".$row["kode"]."<br>";
						} 
					
					}

	
	
?>