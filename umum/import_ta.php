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
						$result1=mysql_query("select * from ta where no_surat_tugas='".$row["f_nst"]."'");
						if (mysql_num_rows($result1)>0){
					
					$result2=mysql_query("select id from master_karyawan where kode='".$row["kodos1"]."'");
						
						$row2 = mysql_fetch_array($result2);
						$kodos1=$row2["id"];
						
						$result2=mysql_query("select id from master_karyawan where kode='".$row["kodos2"]."'");
						
						$row2 = mysql_fetch_array($result2);
						$kodos2=$row2["id"];
					$result1=mysql_query("update ta set id_dosen1='".$kodos1."',id_dosen2='".$kodos2."' where no_surat_tugas='".$row["f_nst"]."'");
						echo "update ta set id_dosen1='".$kodos1."',id_dosen2='".$kodos2."' where no_surat_tugas='".$row["f_nst"]."' - updating ".$row["no_surat_tugas"]."<br>";
						
						//$result1=mysql_query("update ta set no_surat_tugas=".$row["f_nst"].", judul='".$row["f_judul1"].$row["f_judul2"].$row["f_judul3"].$row["f_judul4"]."', tanggal_mulai='".$row["tglta"]."', tanggal_selesai='".$row["tglakhir"]."',id_status_ta_kp=1,id_dosen1='".$kodos1."',id_dosen2='".$kodos2."' where no_surat_tugas='".$row["f_nst"]."'");
					//	echo "update ta set no_surat_tugas=".$row["f_nst"].", judul='".$row["f_judul1"].$row["f_judul2"].$row["f_judul3"].$row["f_judul4"]."', tanggal_mulai='".$row["tglta"]."', tanggal_selesai='".$row["tglakhir"]."',id_status_ta_kp=1,id_dosen1='".$kodos1."',id_dosen2='".$kodos2."' where no_surat_tugas='".$row["f_nst"]."' - updating ".$row["no_surat_tugas"]."<br>";
						
						}
						else
						{
						$result2=mysql_query("select id from master_karyawan where kode='".$row["kodos1"]."'");
						
						$row2 = mysql_fetch_array($result2);
						$kodos1=$row2["id"];
						
						$result2=mysql_query("select id from master_karyawan where kode='".$row["kodos2"]."'");
						
						$row2 = mysql_fetch_array($result2);
						$kodos2=$row2["id"];
						
						$result1=mysql_query("insert into ta (no_surat_tugas,jenis,judul,tanggal_mulai,tanggal_selesai,id_status_ta_kp, id_dosen1, id_dosen2) values ('".$row["f_nst"]."','TA','".$row["f_judul1"].$row["f_judul2"].$row["f_judul3"].$row["f_judul4"]."','".$row["tglta"]."','".$row["tglakhir"]."',1,'".$kodos1."','".$kodos2."')");
						echo "insert into ta (no_surat_tugas,jenis,judul,tanggal_mulai,tanggal_selesai,id_status_ta_kp, id_dosen1, id_dosen2) values ('".$row["f_nst"]."','TA','".$row["f_judul1"].$row["f_judul2"].$row["f_judul3"].$row["f_judul4"]."','".$row["tglta"]."','".$row["tglakhir"]."',1,'".$kodos1."','".$kodos2."') - ".mysql_affected_rows()." - inserting ".$row["kode"]."<br>";
						} 
					
					}

	
	
?>