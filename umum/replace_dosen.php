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


					$result = mysql_query("select * from import_dosen" );
					while($row = mysql_fetch_array($result))
					{
						$result1=mysql_query("select * from master_karyawan where kode='".$row["kode"]."'");
						if (mysql_num_rows($result1)>0){
						
						$result2=mysql_query("select id from pendidikan where nama='".$row["ijasah"]."'");
						$row2 = mysql_fetch_array($result2);
						
						$result1=mysql_query("update master_karyawan set jurusan=".$row["jurusan"].", id_pangkat=".$row["gol_lokal"].", tanggal_pengangkatan='".$row["tmt_lokal"]."', pendidikan=".$row2["id"].", id_jenis=1    where kode='".$row["kode"]."'");
						
						echo "update master_karyawan set jurusan=".$row["jurusan"].", id_pangkat=".$row["gol_lokal"].", tanggal_pengangkatan='".$row["tmt_lokal"]."', pendidikan=".$row2["id"]."    where kode='".$row["kode"]."' - ".mysql_affected_rows()." - updating ".$row["kode"]."<br>";
						
						}
						else
						{
						$result1=mysql_query("insert into master_karyawan (kode,nip,nama,jurusan,alamat,sex, tanggal_lahir, id_pangkat, tanggal_pengangkatan) values ('".$row["kode"]."','".$row["npk"]."','".$row["nama"]."',".$row["jurusan"].",'".$row["alamat"]."','".$row["jeniskelam"]."','".$row["tgl_lahir"]."','".$row["gol_lokal"]."','".$row["tmt_lokal"]."')");
if ($result1) 
						{
							$pesan = $pesan."<br>Data telah diubah";
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menyimpan data";
							
						}
						echo "insert into master_karyawan (kode,nip,nama,jurusan,alamat,sex, tanggal_lahir, id_pangkat, tanggal_pengangkatan) values ('".$row["kode"]."','".$row["npk"]."','".$row["nama"]."',".$row["jurusan"].",'".$row["alamat"]."','".$row["jeniskelam"]."','".$row["tgl_lahir"]."','".$row["tmp_lahir"]."','".$row["gol_lokal"]."','".$row["tmt_lokal"]."') - ".mysql_affected_rows()." - inserting ".$row["kode"]."<br>";
						} 
					
					}

	
	
?>