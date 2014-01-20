<?php
/* 
   DATE CREATED : 19/11/07 - RAHADI
   UPDATE  		: 
   KEGUNAAN     : ENTRY DATA KARYAWAN
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);


if ($act==1)   
{ // simpan data
	// Pemeriksaan tanggal, apakah tanggal yang dimasukkan valid
	if ($frm_tanggal_lahir!='') 
		{
			if (datetomysql($frm_tanggal_lahir)) 
				{
					$frm_tanggal_lahir = datetomysql($frm_tanggal_lahir);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal lahir tidak valid";
				}
		}
		

	if ($frm_tanggal_masuk!='') 
		{
			if (datetomysql($frm_tanggal_masuk)) 
				{
					$frm_tanggal_masuk = datetomysql($frm_tanggal_masuk);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal masuk tidak valid";
				}
		}
		
	if ($frm_tanggal_pengangkatan!='') 
		{
			if (datetomysql($frm_tanggal_pengangkatan)) 
				{
					$frm_tanggal_pengangkatan = datetomysql($frm_tanggal_pengangkatan);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal pengangkatan lokal tidak valid";
				}
		}
		
	if ($frm_tanggal_pengangkatan_kopertis!='') 
		{
			if (datetomysql($frm_tanggal_pengangkatan_kopertis)) 
				{
					$frm_tanggal_pengangkatan_kopertis = datetomysql($frm_tanggal_pengangkatan_kopertis);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal pengangkatan kopertis tidak valid";
				}
		}
		
	if ($frm_tanggal_keluar!='') 
		{
			if (datetomysql($frm_tanggal_keluar)) 
				{
					$frm_tanggal_keluar = datetomysql($frm_tanggal_keluar);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal keluar tidak valid";
				}
		}

// Kode dan nama harus diisi 
	if (($frm_kode=='') or ($frm_nama=='') or ($frm_kelamin=='') or ($frm_jurusan=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi kode, nama, jenis kelamin dosen/karyawan. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// kode tidak ada, berarti tambah baru
		echo "<br>frm_exist=".$frm_exist;
			if ($frm_exist!=1) 
				{
    				echo "<br>INSERT !";
					$result = mysql_query("INSERT INTO dosen (`kode`,`NPK`,`nama`,`kelamin`,`jurusan`,`pangkat`,`pangkat_kopertis`,`tanggal_masuk`,`jab_struktural`,`jab_akademik`,`jab_kopertis`,`tanggal_pengangkatan_kopertis`,`tanggal_pengangkatan`,`status`,`tempat_lahir`,`tanggal_lahir`,`alamat`,`nama_kota`,`kode_pos`,`telepon`,`no_hp`,`no_ktp`,`pendidikan_terakhir`,`bidang_keahlian`) VALUES('".$frm_kode."', '".$frm_NPK."', '".$frm_nama."', '".$frm_kelamin."', '".$frm_jurusan."', '".$frm_pangkat_lokal."', '".$frm_pangkat_kopertis."', '".$frm_tanggal_masuk."', '".$frm_jab_struktural."', '".$frm_jab_akademik."', '".$frm_pangkat_kopertis."', '".$frm_tanggal_pengangkatan_kopertis."', '".$frm_tanggal_pengangkatan."',NULL, '".$frm_tempat_lahir."', '".$frm_tanggal_lahir."', '".$frm_alamat."', '".$frm_kota."', '".$frm_kode_pos."', '".$frm_telp."', '".$frm_HP."', '".$frm_no_ktp."',  '".$frm_pendidikan."', '".$frm_bidang_keahlian."')");
					//$result = mysql_query("INSERT INTO dosen (`kode`,`NPK`,`nama`,`kelamin`) VALUES('".$frm_kode."', '".$frm_NPK."', '".$frm_nama."', '".$frm_kelamin."')");
// INSERT INTO `dosen` ( `kode` , `NPK` , `nama` , `kelamin` , `jurusan` , `pangkat`,`pangkat_kopertis` , `tanggal_masuk` , `jab_struktural` , `jab_akademik` , `jab_kopertis` , `tanggal_pengangkatan_kopertis` , `tanggal_pengangkatan` , `status` , `tempat_lahir` , `tanggal_lahir` , `alamat` , `nama_kota` , `kode_pos` , `telepon` , `no_hp` , `no_ktp` , `pendidikan_terakhir` , `bidang_keahlian` )                                                                                                                                                  
//VALUES (
					if ($result) 
						{
							//$pesan = $pesan."<br>Data telah ditambahkan";	
							// cek riwayat_jabatan_lokal ada data sama or tidak
							$result_cek = mysql_query("SELECT kode, LEGALITAS, tgl_terhitung FROM riwayat_jabatan_lokal WHERE kode='$frm_kode' and LEGALITAS='".$frm_legal_akademik."'");
							$row_akademik = mysql_fetch_array($result_cek);
							$jum_akademik = mysql_num_rows($result_cek);
							if ($jum_akademik >= 1)
							{
							   echo "ada";
							}
							else
							{
							   echo "tidak ada";
							}
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data - ". mysql_error();
						}
						$id_karyawan=mysql_insert_id();
/*$result = mysql_query("INSERT INTO histori_pangkat( `id` ,`id_karyawan` , `tanggal_pengangkatan` , `id_jabatan` , `id_pangkat` ) VALUES ( '', '".$id_karyawan."', '".$frm_tanggal_pengangkatan."', '".$frm_jab_akademik."', '".$frm_pangkat_lokal."') " );
					if ($result) 
						{
							$pesan = $pesan."$id<br>Data kepangkatan lokal telah ditambahkan";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data kepangkatan lokal";
						}
$result = mysql_query("INSERT INTO histori_pangkat_kopertis( `id` ,`id_karyawan` , `tanggal_pengangkatan` , `id_jabatan` , `id_pangkat` ) VALUES ( '', '".$id_karyawan."', '".$frm_tanggal_pengangkatan_kopertis."', '".$frm_id_jabatan_kopertis."', '".$frm_pangkat_kopertis."') " );
					if ($result) 
						{
							$pesan = $pesan."$id<br>Data kepangkatan kopertis telah ditambahkan";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data kepangkatan kopertis";
						}
						*/
						
				}
			else
				{
				echo "<br>data telah di-UPDATE !";
				/*echo "<br>frm_kode=".$frm_kode;
				echo "<br>frm_NPK=".$frm_NPK;
				echo "<br>frm_nama=".$frm_nama;
				echo "<br>frm_kelamin=".$frm_kelamin;
				echo "<br>frm_jurusan=".$frm_jurusan;
				echo "<br>frm_pangkat_lokal=".$frm_pangkat_lokal;
				echo "<br>frm_tanggal_masuk=".$frm_tanggal_masuk;
				echo "<br>frm_jab_struktural=".$frm_jab_struktural;
				echo "<br>frm_jab_akademik=".$frm_jab_akademik;
				echo "<br>frm_pangkat_kopertis=".$frm_pangkat_kopertis;
				echo "<br>frm_tanggal_pengangkatan=".$frm_tanggal_pengangkatan; 
				echo "<br>frm_tanggal_pengangkatan_kopertis=".$frm_tanggal_pengangkatan_kopertis;
				echo "<br>frm_tempat_lahir=".$frm_tempat_lahir;
				echo "<br>frm_tanggal_lahir=".$frm_tanggal_lahir; 
				echo "<br>frm_alamat=".$frm_alamat;
				echo "<br>frm_telp=".$frm_telp;
				echo "<br>frm_HP=".$frm_HP;
				echo "<br>frm_no_ktp=".$frm_no_ktp;
				echo "<br>frm_pendidikan=".$frm_pendidikan;
				echo "<br>frm_bidang_keahlian=".$frm_bidang_keahlian;*/

	// mengubah data yang sudah ada --> id ada
//				$result = mysql_query("UPDATE master_karyawan set `kode`='$frm_kode' , `nip`='$frm_NPK' , `nama`='$frm_nama' , `jurusan`='$frm_jurusan' , `alamat`='$frm_alamat' , `sex`='$frm_sex' , `id_tempat_lahir`='' , `tanggal_lahir`='$frm_tanggal_lahir' , `tanggal_masuk`='$frm_tanggal_masuk' , `tanggal_keluar`='$frm_tanggal_keluar' , `pendidikan`='$frm_pendidikan' , `id_jabatan`='$frm_jab_akademik' , `id_pangkat`='$frm_pangkat_lokal' , `tanggal_pengangkatan`='$frm_tanggal_pengangkatan' , `id_jenis`='$frm_id_jenis' , `bidang_keahlian`='$frm_bidang_keahlian' , `status_pernikahan`='$frm_status_pernikahan' , `jumlah_anak`='$frm_jumlah_anak' where `id`=$frm_id");
				
				/*if ($frm_tanggal_pengangkatan =="") {
						$frm_tanggal_pengangkatan ="00/00/0000"; }
						
				if ($frm_tanggal_pengangkatan_kopertis=="") {
				$frm_tanggal_pengangkatan_kopertis ="00/00/0000"; }*/
				
				if ($frm_tanggal_pengangkatan=='')
				{
					 $frm_tanggal_pengangkatan="0000-00-00";
				}
				if ($frm_tanggal_masuk=='')
				{
					 $frm_tanggal_masuk="0000-00-00";
				}
				if ($frm_tanggal_pengangkatan_kopertis=='')
				{
					 $frm_tanggal_pengangkatan_kopertis="0000-00-00";
				}
				
				$result = mysql_query("UPDATE  dosen
										 SET  `NPK`='$frm_NPK',
											  `nama`='$frm_nama', 
											  `kelamin`='$frm_kelamin',
											  `jurusan`='$frm_jurusan',
											  `pangkat`='$frm_pangkat_lokal',
											  `pangkat_kopertis`='$frm_pangkat_kopertis',
											  `tanggal_masuk`='$frm_tanggal_masuk',
											  `jab_struktural`='$frm_jab_struktural',
											  `jab_akademik`='$frm_jab_akademik',
											  `jab_kopertis`='$frm_jab_kopertis',
											  `tanggal_pengangkatan_kopertis`='$frm_tanggal_pengangkatan_kopertis', 
											  `tanggal_pengangkatan`='$frm_tanggal_pengangkatan',
											  `tempat_lahir`='$frm_tempat_lahir',
											  `tanggal_lahir`='$frm_tanggal_lahir', 
											  `alamat`='$frm_alamat',
											  `nama_kota`='$frm_kota',
											  `kode_pos`='$frm_kode_pos',
											  `telepon`='$frm_telp',
											  `no_hp`='$frm_HP',
											  `no_ktp`='$frm_no_ktp',
											  `pendidikan_terakhir`='$frm_pendidikan',
											  `bidang_keahlian`='$frm_bidang_keahlian'
									    where `kode`='$frm_kode'");
											
	
					if ($result) 
						{
							//$pesan = $pesan."<br>Data telah diubah";	
							$result_cek = mysql_query("SELECT urut_id, kode, LEGALITAS, tgl_terhitung FROM riwayat_jabatan_lokal WHERE kode='$frm_kode' and LEGALITAS='".$frm_legal_akademik."'");
							$row_akademik = mysql_fetch_array($result_cek);
							$jum_akademik = mysql_num_rows($result_cek);
							if ($frm_legal_akademik!='')
							{
									if ($jum_akademik >= 1)
									{
										   echo "<br>update akademik- ada";
										   echo "<br>frm_kode=".$frm_kode;
										   echo "<br>frm_NPK=".$frm_NPK;
										   echo "<br>frm_nama=".$frm_nama;
										   echo "<br>frm_pangkat_lokal=".$frm_pangkat_lokal;
										   echo "<br>frm_jab_akademik=".$frm_jab_akademik;
										   echo "<br>frm_tanggal_pengangkatan_akademik****=".$frm_tanggal_pengangkatan;
										   echo "<br>frm_legal_akademik=".$frm_legal_akademik;
										   $res_jab_aka = mysql_query("UPDATE riwayat_jabatan_lokal SET `kode`='$frm_kode',
																										`NPK`='$frm_NPK',
																										`NAMA`='$frm_nama',
																										`golongan`='$frm_pangkat_lokal',
																										`jabatan_lokal`='$frm_jab_akademik',
																										`tgl_terhitung`='$frm_tanggal_pengangkatan',
																										`LEGALITAS`='$frm_legal_akademik'
																								  WHERE `urut_id`='".$row_akademik["urut_id"]."'");
											if ($res_jab_aka) {
											echo "<br>frm_pangkat_akademik=".$frm_pangkat_akademik;
										   echo "<br>frm_jab_akademik=".$frm_jab_akademik;
										   echo "<br>frm_tanggal_pengangkatan=".$frm_tanggal_pengangkatan;
												 $result = mysql_query("UPDATE  dosen set `pangkat_kopertis`='$frm_pangkat_akademik',
																						  `jab_akademik`='$frm_jab_akademik',
																						  `tanggal_pengangkatan`='$frm_tanggal_pengangkatan'
																					where `kode`='$frm_kode'");
											}
											else
											{
												$pesan = $pesan."<br>Gagal Update data akademik - ". mysql_error();
											}
									}
									else
									{
									   echo "<br>INSERT akademik tidak ada";
									   $res_jab_kop = mysql_query("INSERT riwayat_jabatan_lokal (`kode`,`NPK`,`NAMA`,`golongan`,`jabatan_lokal`,`tgl_terhitung`,`LEGALITAS`) VALUES('".$frm_kode."', '".$frm_NPK."', '".$frm_nama."', '".$frm_pangkat_kopertis."', '".$frm_jab_kopertis."','".$frm_tanggal_pengangkatan."', '".$frm_legal_akademik."')");
										if ($res_jab_kop)
										{
											$pesan = $pesan."<br>Data telah ditambahkan.";
										}
										else
										{
											$pesan = $pesan."<br>Gagal menambahkan data akademik - ". mysql_error();
										}
									}
							}
							
							
							
							$result_cek2 = mysql_query("SELECT urut_id, kode, LEGALITAS, tgl_terhitung FROM riwayat_jabatan_kopertis WHERE kode='$frm_kode' and LEGALITAS='".$frm_legal_kopertis."'");
							$row_kopertis = mysql_fetch_array($result_cek2);
							$jum_kopertis = mysql_num_rows($result_cek2);
							
							if ($frm_legal_kopertis!='')
							{
										if ($jum_kopertis >= 1)
										{
											   echo "<br>update kopertis - ada";
											   echo "<br>frm_kode=".$frm_kode;
											   echo "<br>frm_NPK=".$frm_NPK;
											   echo "<br>frm_nama=".$frm_nama;
											   echo "<br>frm_kode=".$frm_kode;
											   echo "<br>frm_pangkat_kopertis=".$frm_pangkat_kopertis;
											   echo "<br>frm_jab_kopertis=".$frm_jab_kopertis;
											   echo "<br>frm_tanggal_pengangkatan_kopertis=".$frm_tanggal_pengangkatan_kopertis;
											   echo "<br>frm_legal_kopertis=".$frm_legal_kopertis;
											   
											   $res_jab_kop = mysql_query("UPDATE riwayat_jabatan_kopertis SET `kode`='$frm_kode',
																											   `NPK`='$frm_NPK',
																											   `NAMA`='$frm_nama',
																											   `golongan`='$frm_pangkat_kopertis',
																											   `jabatan_kopertis`='$frm_jab_kopertis',
																											   `tgl_terhitung`='$frm_tanggal_pengangkatan_kopertis',
																											   `LEGALITAS`='$frm_legal_kopertis'
																										 WHERE `urut_id`='".$row_kopertis["urut_id"]."'");
												if ($res_jab_kop) {
												echo "<br>frm_pangkat_kopertis=".$frm_pangkat_kopertis;
											   echo "<br>frm_jab_kopertis=".$frm_jab_kopertis;
											   echo "<br>frm_tanggal_pengangkatan_kopertis=".$frm_tanggal_pengangkatan_kopertis;
											   echo "<br>frm_kode=".$frm_kode;
												
													 $result = mysql_query("UPDATE  dosen set `pangkat_kopertis`='$frm_pangkat_kopertis',
																							  `jab_kopertis`='$frm_jab_kopertis',
																							  `tanggal_pengangkatan_kopertis`='$frm_tanggal_pengangkatan_kopertis'
																						where `kode`='$frm_kode'");
												}
												else
												{
													$pesan = $pesan."<br>Gagal Update data kopertis - ". mysql_error();
												}
										}
										else
										{
										   echo "<br>INSERT kopertis tidak ada";
										   $res_jab_kop = mysql_query("INSERT riwayat_jabatan_kopertis (`kode`,`NPK`,`NAMA`,`golongan`,`jabatan_kopertis`,`tgl_terhitung`,`LEGALITAS`) VALUES('".$frm_kode."', '".$frm_NPK."', '".$frm_nama."', '".$frm_pangkat_kopertis."', '".$frm_jab_kopertis."','".$frm_tanggal_pengangkatan_kopertis."', '".$frm_legal_kopertis."')");
											if ($res_jab_kop)
											{
												$pesan = $pesan."<br>Data telah ditambahkan.";
											}
											else
											{
												$pesan = $pesan."<br>Gagal menambahkan data kopertis- ". mysql_error();
											}
										}
							}																									
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal Update data - ". mysql_error();
						}
				}
		}
	}


if ($act==2) { // hapus data

$result = mysql_query("delete from dosen where kode = '".$frm_kode."'");
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
	
if (($act!=0)and($error!=1)) {
	$frm_id = "";
	$frm_NPK =  "";
	$frm_nama = "";
	$frm_kelamin = "";
	$frm_jurusan = "";
	$frm_pangkat_lokal = "";
	$frm_tanggal_masuk ="";
	$frm_jab_struktural = "";
	$frm_jab_akademik = "";
	$frm_pangkat_kopertis = "";
	$frm_tanggal_pengangkatan =""; 
	$frm_tanggal_pengangkatan_kopertis ="";
	$frm_tempat_lahir = "";
	$frm_tanggal_lahir =""; 
	$frm_alamat = "";
	$frm_kota = "";
	$frm_kode_pos = "";
	$frm_telp = "";
	$frm_HP = "";
	$frm_no_ktp = "";
	$frm_pendidikan = "";
	$frm_bidang_keahlian = "";
	$frm_legal_akademik = "";
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_kode!='')  {
$result = mysql_query("Select dosen.kode,
							  dosen.NPK,
							  dosen.nama,
							  dosen.kelamin,
							  dosen.jurusan,
							  dosen.pangkat,
							  dosen.pangkat_kopertis,
							  DATE_FORMAT(dosen.tanggal_masuk,'%d/%m/%Y') as tanggal_masuk, 
							  dosen.jab_struktural,
							  dosen.jab_akademik,
							  dosen.jab_kopertis,
							  DATE_FORMAT(dosen.tanggal_pengangkatan_kopertis,'%d/%m/%Y') as tanggal_pengangkatan_kopertis, 
							  DATE_FORMAT(dosen.tanggal_pengangkatan,'%d/%m/%Y') as tanggal_pengangkatan, 
							  dosen.`status`,
							  dosen.tempat_lahir,
							  DATE_FORMAT(dosen.tanggal_masuk,'%d/%m/%Y') as tanggal_masuk, 
							  DATE_FORMAT(dosen.tanggal_lahir,'%d/%m/%Y') as tanggal_lahir, 
							  dosen.alamat,
							  dosen.nama_kota,
							  dosen.kode_pos,
							  dosen.telepon,
							  dosen.no_hp,
							  dosen.no_ktp,
							  dosen.pendidikan_terakhir,
							  dosen.bidang_keahlian
					     FROM dosen 
						WHERE dosen.kode='$frm_kode'");
						
						if ($row = mysql_fetch_array($result)) {			
							    $frm_exist=1;			
								$frm_NPK = $row["NPK"];
								$frm_nama = $row["nama"];
								$frm_kelamin = $row["kelamin"];
								$frm_jurusan = $row["jurusan"];
								$frm_pangkat_lokal = $row["pangkat"];
								
								$frm_tanggal_masuk = $row["tanggal_masuk"];
								if ($row["tanggal_masuk"]=="00/00/0000") {
								$frm_tanggal_masuk = ""; }else {
								$frm_tanggal_masuk = $row["tanggal_masuk"];}
								
								$frm_tanggal_pengangkatan_kopertis = $row["tanggal_pengangkatan_kopertis"];
								if ($row["tanggal_pengangkatan_kopertis"]=="00/00/0000") {
								$frm_tanggal_pengangkatan_kopertis =""; }else {
								$frm_tanggal_pengangkatan_kopertis =$row["tanggal_pengangkatan_kopertis"]; }
								
								//if (($row["TGLLAHIR"]=="00/00/0000") or ($row["TGLLAHIR"]=="")){
							   //echo "DISINI";
							   // $frm_tanggal_lahir ="00/00/0000"; }else {
							   // $frm_tanggal_lahir =$row["TGLLAHIR"];}
								
								//if ($row["tanggal_masuk"]=="00/00/0000") {
								//$frm_tanggal_masuk = ""; }else {
								//$frm_tanggal_masuk = $row["tanggal_masuk"]; 
								
								
								$frm_jab_struktural = $row["jab_struktural"];
								$frm_jab_akademik = $row["jab_akademik"];
								$frm_jab_kopertis = $row["jab_kopertis"];
								$frm_pangkat_kopertis = $row["pangkat_kopertis"];
								
								if ($row["tanggal_pengangkatan"]=="00/00/0000") {
								$frm_tanggal_pengangkatan =""; }else {
								$frm_tanggal_pengangkatan =$row["tanggal_pengangkatan"]; }
								
								
								
								$frm_tempat_lahir = $row["tempat_lahir"];
								
								if ($row["tanggal_lahir"]=="00/00/0000") {
								$frm_tanggal_lahir =""; }else {
								$frm_tanggal_lahir =$row["tanggal_lahir"];}
								
								$frm_alamat = $row["alamat"];
								$frm_kota = $row["nama_kota"];
								$frm_kode_pos = $row["kode_pos"];
								$frm_telp = $row["telepon"];
								$frm_HP = $row["no_hp"];
								$frm_no_ktp = $row["no_ktp"]; 
								
								$frm_pendidikan = $row["pendidikan_terakhir"]; 
								$frm_bidang_keahlian = $row["bidang_keahlian"];
						}
						else
						{
							$frm_exist=0;
							$pesan = $pesan."NPK Dosen yang Anda masukkan tidak ada di database";
							$frm_id = "";
							$frm_NPK =  "";
							$frm_nama = "";
							$frm_kelamin = "";
							$frm_jurusan = "";
							$frm_pangkat_lokal = "";
							$frm_tanggal_masuk ="";
							$frm_jab_struktural = "";
							$frm_jab_akademik = "";
							$frm_pangkat_kopertis = "";
							$frm_tanggal_pengangkatan =""; 
							$frm_tanggal_pengangkatan_kopertis ="";
							$frm_tempat_lahir = "";
							$frm_tanggal_lahir =""; 
							$frm_alamat = "";
							$frm_kota = "";
							$frm_kode_pos = "";
							$frm_telp = "";
							$frm_HP = "";
							$frm_no_ktp = "";
							$frm_pendidikan = "";
							$frm_bidang_keahlian = "";
							$frm_legal_akademik = "";
						}
}
}

?>
<html>
<head>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../include/tanggalan.js">
</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<body class="body">
<form name="form_dosen" id="form_dosen" action="master_dosen.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><img src="spacer" height="1"></td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000"><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4"> 
	  <hr size="1" color="#FF9900"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="89%"><font color="#0099CC" size="1"><strong>ENTRY DATA 
              ~ </strong>MASTER DOSEN</font> </td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">KARYAWAN</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="25%">&nbsp;</td> 
      <td width="25%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="73%"><!--input type="hidden" name="frm_id" value="<?php //echo $frm_id;?>"></td-->
	      <input name="frm_exist" id="frm_exist" type="hidden" value="<?php echo $frm_exist; ?>">
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Kode Karyawan <span class="style1">*</span></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_kode" type="text" class="tekboxku" id="frm_kode" size="10" maxlength="6" value="<?php echo $frm_kode; ?>" onBlur="document.form_dosen.submit()"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>NIP </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_NPK" type="text" class="tekboxku" id="frm_NPK" value="<?php echo $frm_NPK; ?>" size="10" maxlength="7"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Kelamin<span class="style1">*</span></td>
      <td><strong>:</strong></td>
      <td>
		  <select name="frm_kelamin" id="frm_kelamin" class="tekboxku" >
			<option value="" selected>--- pilih ---</option>
			<option value="L" <? if ($frm_kelamin=='L'){ echo "selected";}?>>Laki-laki</option>
			<option value="P" <? if ($frm_kelamin=='P'){ echo "selected";}?>>Perempuan</option>
		  </select>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Jurusan<span class="style1">*</span></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <select name="frm_jurusan" id="frm_jurusan" class="tekboxku">
	    <option <?php if ($frm_jurusan==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sql_jurusan="SELECT * FROM jurusan WHERE `jurusan`.id<>0 ORDER BY id ASC";
				$result = @mysql_query($sql_jurusan);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->id; ?>" <?php if ($frm_jurusan==$row->id) { echo "selected"; }?>> <?php echo $row->jurusan; ?></option>
          <?php
				}
				?>
      </select> 
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nama Karyawan <span class="style1">*</span></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nama" type="text" class="tekboxku" id="frm_nama" value="<?php echo $frm_nama; ?>" size="50" maxlength="100"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Alamat</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_alamat" id="frm_alamat" type="text" class="tekboxku" value="<?php echo $frm_alamat; ?>" size="50" maxlength="200"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Kota</td>
      <td><strong>:</strong></td>
      <td>	  <input name="frm_kota" id="frm_kota" type="text" class="tekboxku" value="<?php echo $frm_kota; ?>" size="50" maxlength="200"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Kode Pos </td>
      <td><strong>:</strong></td>
      <td><input name="frm_kode_pos" id="frm_kode_pos" type="text" class="tekboxku" value="<?php echo $frm_kode_pos; ?>" size="10" maxlength="5"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>No. HP </td>
      <td><strong>:</strong></td>
      <td><input name="frm_HP" id="frm_HP" type="text" class="tekboxku" value="<?php echo $frm_HP; ?>" size="30" maxlength="15"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>No. Telepon</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_telp" id="frm_telp" type="text" class="tekboxku" value="<?php echo $frm_telp; ?>" size="30" maxlength="15"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>No. KTP </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_no_ktp" id="frm_no_ktp" type="text" class="tekboxku" value="<?php echo $frm_no_ktp; ?>" size="30" maxlength="20"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tempat Lahir</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tempat_lahir" type="text" class="tekboxku" id="frm_tempat_lahir" value="<?php echo $frm_tempat_lahir; ?>" size="30" maxlength="50"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal Lahir </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tanggal_lahir" type="text" id="frm_tanggal_lahir" size="10" maxlength="10" value="<?php echo $frm_tanggal_lahir; ?>" class="tekboxku"> 
        <A Href="javascript:show_calendar('form_dosen.frm_tanggal_lahir',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="bottom" border=0> 
        </A>(dd/mm/yyyy) </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal Masuk </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tanggal_masuk" type="text" id="frm_tanggal_masuk" size="10" maxlength="10" value="<?php if (!isset($frm_tanggal_masuk)) { echo "00/00/0000"; }else{ echo $frm_tanggal_masuk;} ?>" class="tekboxku"> 
        <A Href="javascript:show_calendar('form_dosen.frm_tanggal_masuk',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="bottom" border=0> 
        </A>(dd/mm/yyyy) </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Pendidikan Terakhir</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_pendidikan" id="frm_pendidikan" class="tekboxku" >
			<option value="tidak ada data" selected>--Pilih--</option>
			<option value="S1" <? if ($frm_pendidikan=='S1'){ echo "selected";}?>>S-1</option>
			<option value="S2" <? if ($frm_pendidikan=='S2'){ echo "selected";}?>>S-2</option>
			<option value="S3" <? if ($frm_pendidikan=='S3'){ echo "selected";}?>>S-3</option>
        </select>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><hr></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Jabatan Akademik  Terakhir </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> <? // echo "frm_jab_akademik=".$frm_jab_akademik;?>
        <select name="frm_jab_akademik" id="frm_jab_akademik" class="tekboxku">
		   <option value="tidak ada data">--Pilih--</option>
           <?php
			$result1 = @mysql_query("Select id, nama from jabatan_akademik");
			$c=0;
			while ($row1=@mysql_fetch_object($result1))  {
			$c=$c+1;
			?>
          <option value="<?php echo $row1->nama; ?>" <?php if ($frm_jab_akademik==$row1->nama) { echo "selected"; }?>><?php echo $row1->nama; ?></option>
          <?php } ?>
		</select> 
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Legalitas</td>
      <td><strong>:</strong></td>
      <td>
		<? 
		//echo "<br>jab aka=".$frm_jab_akademik;
		 if (($frm_kode!='') and ($frm_jab_akademik!='tidak ada data') ) {
			$result1 = @mysql_query("Select LEGALITAS from riwayat_jabatan_lokal WHERE kode='$frm_kode' ORDER BY urut_id DESC ");
			$row1=@mysql_fetch_object($result1);
			}
		?>
	  	<input name="frm_legal_akademik" id="frm_legal_akademik" type="text" class="tekboxku" value="<?php if ($frm_jab_akademik!='') { echo $row1->LEGALITAS;} else { echo "";} ?>" size="30" maxlength="20">
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Jabatan Struktural  Terakhir </td>
      <td><strong>:</strong></td>
      <td><? //echo "frm_jab_struktural=".$frm_jab_struktural;?>
        <select name="frm_jab_struktural" id="frm_jab_struktural" class="tekboxku">
          <option value="tidak ada data">--Pilih--</option>
		  <?php
			$result1 = @mysql_query("Select id, jabatan from jabatan_struktural");
			$c=0;
			while ($row1=@mysql_fetch_object($result1))  {
			$c=$c+1;
			?>
          <option value="<?php echo $row1->jabatan; ?>" <?php if ($frm_jab_struktural==$row1->jabatan) { echo "selected"; }?>><?php echo $row1->jabatan; ?></option>
         <?php } ?>
		</select>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Pangkat Lokal Terakhir</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> 
        <?php //if ($frm_kode!='') { 
	  
	 //$result1 = @mysql_query("Select id, nama from kepangkatan where id='".$frm_pangkat_lokal."'");
		//if ($row1=@mysql_fetch_object($result1)) {
		//echo $row1->nama; }
	  ?>
        <?php //}else{ 
	  ?>
        <select name="frm_pangkat_lokal" id="frm_pangkat_lokal" class="tekboxku">
          <?php
			$result1 = @mysql_query("Select id, nama from kepangkatan");
			$c=0;
			while ($row1=@mysql_fetch_object($result1))  {
			$c=$c+1;
			?>
          <option value="<?php echo $row1->nama; ?>" <?php if (($frm_pangkat_lokal==$row1->nama)or (($frm_pangkat_lokal=='') and ($c==1))) { echo "selected"; }?>  ><?php echo $row1->nama; ?></option>
          <?php
			}
	?>
        </select> 
        <?php //} ?>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td nowrap>Tgl Pengangkatan Pangkat Lokal Terakhir</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> 
        <?php if ($frm_id!='') { 
	  echo $frm_tanggal_pengangkatan; ?>
        <?php }else{ 
	  ?>
        <input type="text" name="frm_tanggal_pengangkatan" id="frm_tanggal_pengangkatan" value="<?php echo $frm_tanggal_pengangkatan; ?>" size="10" maxlength="10" class="tekboxku"> 
        <A Href="javascript:show_calendar('form_dosen.frm_tanggal_pengangkatan',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="bottom" border=0> 
        </A>(dd/mm/yyyy) 
        <?php } ?>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><hr></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Jabatan  Kopertis Terakhir </td>
      <td><strong>:</strong></td>
      <td><? // echo "frm_jab_akademik=".$frm_jab_akademik;?>
        <select name="frm_jab_kopertis" id="frm_jab_kopertis" class="tekboxku">
          <option value="tidak ada data">--Pilih--</option>
          <?php
			$result1 = @mysql_query("Select id, nama from jabatan_akademik");
			$c=0;
			while ($row1=@mysql_fetch_object($result1))  {
			$c=$c+1;
			?>
          <option value="<?php echo $row1->nama; ?>" <?php if ($frm_jab_kopertis==$row1->nama) { echo "selected"; }?>><?php echo $row1->nama; ?></option>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Legalitas</td>
      <td><strong>:</strong></td>
      <td>
	  	<? if ($frm_kode!='') {
			$result1 = @mysql_query("Select LEGALITAS FROM riwayat_jabatan_kopertis WHERE kode='$frm_kode' ORDER BY tgl_terhitung DESC ");
			$row1=@mysql_fetch_object($result1);
			}
		?>
	    <input name="frm_legal_kopertis" id="frm_legal_kopertis" type="text" class="tekboxku" value="<?php echo $row1->LEGALITAS; ?>" size="30" maxlength="20">
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Pangkat Kopertis Terakhir</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> 
	  
        <?php //echo "<br>frm_pangkat_kopertis=".$frm_pangkat_kopertis ;
		/*if ($frm_kode!='') { 
	  
	  $result1 = @mysql_query("Select id, nama from kepangkatan where nama='".$frm_pangkat_kopertis."'");
		if ($row1=@mysql_fetch_object($result1)) {
		echo $row1->nama; }
	  ?>
        <?php }else{ */
	  ?>
        <select name="frm_pangkat_kopertis" id="frm_pangkat_kopertis" class="tekboxku">
			<?php
			$result1 = @mysql_query("Select id, nama from kepangkatan");
			$c=0;
			while ($row1=@mysql_fetch_object($result1))  {
			$c=$c+1;
			?>
			<option value="<?php echo $row1->nama; ?>" <?php if ($frm_pangkat_kopertis==$row1->nama) { echo "selected"; }?>><?php echo $row1->nama; ?></option>
			<?php
			}?>
        </select> 
        <?php //} ?>
      </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>Tgl Pengangkatan Pangkat Kopertis Terakhir</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> 
        <?php if ($frm_id!='') { 
	  echo $frm_tanggal_pengangkatan_kopertis; ?>
        <?php }else{ 
	  ?>
        <input type="text" name="frm_tanggal_pengangkatan_kopertis" id="frm_tanggal_pengangkatan_kopertis" value="<?php echo $frm_tanggal_pengangkatan_kopertis; ?>" class="tekboxku" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('form_dosen.frm_tanggal_pengangkatan_kopertis',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="bottom" border=0> 
        </A>(dd/mm/yyyy) 
        <?php } ?>
      </td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td> 
      <td valign="top">Bidang Keahlian</td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td valign="top"><textarea name="frm_bidang_keahlian" cols="60" rows="2" class="tekboxku" id="frm_bidang_keahlian"><?php echo $frm_bidang_keahlian; ?></textarea></td>
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
      <td> <input type="submit" name="Submit" value="Simpan" onclick="this.form.action+='?act=1';this.form.submit();" class="tombol"> 
        <input type="reset" name="Submit2" value="Batal" class="tombol" onclick="this.form.action+='?act=3';this.form.submit();"> 
        <?php if ($frm_id) { ?>
        <input type="button" name="Submit3" value="Hapus" onclick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_id;?>';this.form.submit()};" class="tombol"> 
        <?php } ?>
      </td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4"><font size="1"><span class="style1">*</span> = compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>