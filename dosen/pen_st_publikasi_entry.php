<?
/* 
   DATE CREATED : 05/09/07
   LAST MODIFIED: 14/11/08 - rahadi
                  10/10/09 - rahadi (publikasi tidak harus ada penelitian)
				  10/10/09 - rahadi (publikasi tidak harus ada penelitian)
				  01/06/10 - rahadi (penambahan  frm_tgl_publikasi2)
   KEGUNAAN     : ENTRY SURAT TUGAS PUBLIKASI
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/
session_start();
include("../include/js_function.js");
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ // simpan data
// Pemeriksaan tanggal, apakah tanggal yang dimasukkan valid
//echo "<br>frm_tgl_go_A=".$frm_tgl_go;
	if ($frm_tgl_go!='') 
		{
			if (datetomysql($frm_tgl_go)) 
				{
					$frm_tgl_go = datetomysql($frm_tgl_go);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."Tanggal Berangkat tidak valid";
				}
		}
//echo "<br>frm_tgl_go_B=".$frm_tgl_go;
	if ($frm_tgl_dtg!='') 
		{
			if (datetomysql($frm_tgl_dtg)) 
				{
					$frm_tgl_dtg = datetomysql($frm_tgl_dtg);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."Tanggal Kembali tidak valid";
				}
		}


//echo "<br>frm_tgl_terbit=".$frm_tgl_terbit;		
	if ($frm_tgl_terbit!='') 
	{
		if (datetomysql($frm_tgl_terbit)) 
			{
				$frm_tgl_terbit = datetomysql($frm_tgl_terbit);
			}
		else
			{
				$error = 1;
				$pesan = $pesan."Tanggal terbit tidak valid";
			}
	}
//echo "<br>frm_tgl_terbit=".$frm_tgl_terbit;		
	
	
	if ($frm_tgl_publikasi!='') 
	{
		if (datetomysql($frm_tgl_publikasi)) 
			{
				$frm_tgl_publikasi = datetomysql($frm_tgl_publikasi);
			}
		else
			{
				$error = 1;
				$pesan = $pesan."Tanggal Publikasi Awal tidak valid";
			}
	}
	
	if ($frm_tgl_publikasi2!='') 
	{
		if (datetomysql($frm_tgl_publikasi2)) 
			{
				$frm_tgl_publikasi2 = datetomysql($frm_tgl_publikasi2);
			}
		else
			{
				$error = 1;
				$pesan = $pesan."Tanggal Publikasi Akhir tidak valid";
			}
	}
	
// Kode dan nama harus diisi 
	/*if (($frm_no_st_pub_now) or ($frm_jenis) or ($frm_kode_dsn1=='') or ($frm_judul=='') or  ($frm_TET=='') or ($frm_TNET=='') or ($frm_tugas=='') or ($frm_status=='') or ($frm_hari_go=='') or 
	($frm_tgl_go=='') or ($frm_pukul_go=='') or ($frm_tempat_go=='') or ($frm_transportasi_go=='') or ($frm_hari_dtg=='') or 
	($frm_tgl_dtg=='') or ($frm_pukul_dtg=='') or ($frm_transportasi_dtg=='')) */
	if ($frm_jenis==1) {
		$frm_sifat_pen="Mandiri";
	}
	else if ($frm_jenis==2) {
		$frm_sifat_pen="Kelompok";
	}
	//($frm_dana_lokal=='') or
	if (($frm_no_st_pub_now=='') or ($frm_jenis=='') or ($frm_kode_dsn1=='') or ($frm_ska_publikasi=='') or ($frm_tipe_publikasi=='') or ($frm_judul=='') or 
	($frm_id_sumber_dana=='') or  ($frm_TET=='') or ($frm_tugas=='') or ($frm_status=='') or ($frm_hari_go=='') or 
	($frm_tgl_go=='') or ($frm_pukul_go=='') or ($frm_tempat_go=='') or ($frm_transportasi_go=='') or ($frm_hari_dtg=='') or 
	($frm_tgl_dtg=='') or ($frm_pukul_dtg=='') or ($frm_transportasi_dtg==''))
		{
			$error = 1;
			$pesan=$pesan."Maaf, Anda harus mengisi data Surat Tugas Publikasi dengan lengkap. ";
		}

	if ($error==1) 
		{
			$pesan=$pesan."<br>Gagal menyimpan data - ". mysql_error();
		}
		
	if ($error !=1) // Jika semua isian form valid 
		{
		// data no_st_pub tidak ada, berarti record baru
					/*echo "<br>frm_no_st_pub_now= ".$frm_no_st_pub_now;
					echo "<br>frm_kode_dsn1= ".$frm_kode_dsn1;
					echo "<br>frm_kode_dsn2= ".$frm_kode_dsn2;
					echo "<br>frm_kode_dsn3= ".$frm_kode_dsn3;
					echo "<br>frm_kode_dsn4= ".$frm_kode_dsn4;
					echo "<br>frm_kode_dsn5= ".$frm_kode_dsn5;
					echo "<br>frm_status= ".$frm_status;
					echo "<br>frm_TET= ".$frm_TET;
					echo "<br>frm_TNET= ".$frm_TNET;
					echo "<br>frm_tugas= ".$frm_tugas;
					echo "<br>frm_hari_go= ".$frm_hari_go;
					echo "<br>frm_tgl_go= ".$frm_tgl_go;
					echo "<br>frm_pukul_go= ".$frm_pukul_go;
					echo "<br>frm_tempat_go= ".$frm_tempat_go;
					echo "<br>frm_transportasi_go= ".$frm_transportasi_go;
					echo "<br>frm_hari_dtg= ".$frm_hari_dtg;
					echo "<br>frm_tgl_dtg= ".$frm_tgl_dtg;
					echo "<br>frm_pukul_dtg= ".$frm_pukul_dtg;
					echo "<br><br>frm_biaya= ".$frm_biaya;
					echo "<br>chk_airport= ".$chk_airport;
					echo "<br>chk_fiskal= ".$chk_fiskal;
					echo "<br>chk_visa= ".$chk_visa;
					echo "<br>chk_uang_saku= ".$chk_uang_saku;
					echo "<br>chk_akomodasi= ".$chk_akomodasi;
					echo "<br>frm_lainnya= ".$frm_lainnya;
					echo "<br>frm_ndt= ".$frm_ndt;
					echo "<br>frm_jenis= ".$frm_jenis;
					/*/
					
					if ($chk_airport=='on'){
						$chk_airport=1;}
					else
					{   $chk_airport=0;}
					
					if ($chk_fiskal=='on'){
					$chk_fiskal=1;}
					else
					{   $chk_fiskal=0;}
				
					if ($chk_visa=='on'){
						$chk_visa=1;}
					else
					{   $chk_visa=0;}
					
					if ($chk_uang_saku=='on'){
						$chk_uang_saku=1;}
					else
					{   $chk_uang_saku=0;}
					
					if ($chk_akomodasi=='on'){
						$chk_akomodasi=1;}
					else
					{   $chk_akomodasi=0;}
					
					$jum=0;
					for ($i = 1; $i <= 5; $i++) {
						$kd_dsn="frm_kode_dsn".$i;
					    
						if ((isset($$kd_dsn)) and ($$kd_dsn <>''))
						{
							//echo "<br>$i.".$kd_dsn;
							$jum++;
						}
					}
					
					
// BEGIN UBAH TABEL #########################################################################################################					
					$res_cek_pub= mysql_query("SELECT publikasi.no_st_pub
					                             FROM publikasi
												WHERE publikasi.no_st_pub='".$frm_no_st_pub_now."'"); 
					$maxrows_pub=mysql_num_rows($res_cek_pub);
					
					if ($maxrows_pub >= 1)		
					{
							$result_1_1 = mysql_query("UPDATE publikasi SET `no_legalitas` = '$frm_no_legalitas_now',
																			`jenis` = $frm_jenis,
																			`publikasi` = '$frm_ska_publikasi',
																			`tgl_publikasi` = '$frm_tgl_publikasi',
																			`tgl_publikasi2` = '$frm_tgl_publikasi2',
																			`jurn_pros` = '$frm_tipe_publikasi',
							                                                `kode_kary` = '$frm_kode_dsn1',
																			`kode_kary2` = '$frm_kode_dsn2',
																			`kode_kary3` = '$frm_kode_dsn3',
																			`kode_kary4` = '$frm_kode_dsn4',
																			`kode_kary5` = '$frm_kode_dsn5',
																			`status` = '$frm_status',
																			`TET_sub` = '$frm_TET',
																			`TNET_sub` = '$frm_TNET',
																			`judul` = '$frm_judul',
																			`tugas` = '$frm_tugas',
																			`pub_ISBN` = '$frm_ISBN',
																			`pub_volume`= '$frm_volume',
																			`pub_penyelenggara` = '$frm_penyelenggara',
																			`pub_tgl_pub` = '$frm_tgl_publikasi',
																			`pub_no_paten` = '$frm_no_paten',
																			`pub_pemberi_paten` = '$frm_pemberi_paten',
																			`pub_tgl_paten` = '$frm_tgl_terbit',
																			`pub_id_sumber_dana` = '$frm_id_sumber_dana',
																			`pub_jum_dana_lokal` = '$frm_dana_lokal',
																			`pub_jum_dana_asing` = '$frm_dana_asing',
																			`hari_go` = '$frm_hari_go',
																			`tgl_go` = '$frm_tgl_go',
																			`pukul_go` = '$frm_pukul_go',
																			`tempat_go` = '$frm_tempat_go',
																			`transport_go` = '$frm_transportasi_go',
																			`hari_dtg` = '$frm_hari_dtg',
																			`tgl_dtg` = '$frm_tgl_dtg',
																			`pukul_dtg` = '$frm_pukul_dtg', 
																			`transport_dtg` = '$frm_transportasi_dtg',
																			`biaya` = '$frm_biaya',
																			`L_ap_tax` = $chk_airport,
																			`L_fiskal` = $chk_fiskal,
																			`L_visa` = $chk_visa,
																			`L_saku` = $chk_uang_saku,
																			`L_akomo` = $chk_akomodasi,
																			`L_other` = '$frm_lainnya',
																			`ndt_terakhir` = '$frm_ndt'
																	  WHERE `no_st_pub`='$frm_no_st_pub_now'");
							if ($result_1_1) 
							{
								$pesan = $pesan."<br>Data telah diubah";	
							}
							else
							{ 
								$pesan = $pesan."<br>Gagal mengubah data 1-1 - ". mysql_error();
							}
																  
					}			
					else
					{
							$result_1_2 = mysql_query("INSERT INTO publikasi ( `no_legalitas` , `no_st_pub` , `urut_st_pub` , `jenis`, `publikasi`, `tgl_publikasi`, `tgl_publikasi2`, `jurn_pros`, 
																			   `kode_kary`, `kode_kary2`, `kode_kary3`, `kode_kary4`, `kode_kary5`, `status`, `TET_sub`, `TNET_sub`, `judul`, `tugas`,
																			   `pub_ISBN`, `pub_volume`, `pub_penyelenggara`, `pub_tgl_pub`, `pub_no_paten`, `pub_pemberi_paten`, `pub_tgl_paten`,
																			   `pub_id_sumber_dana`, `pub_jum_dana_lokal`, `pub_jum_dana_asing`,  
																			   `hari_go` , `tgl_go` , `pukul_go` , `tempat_go` , `transport_go` , 
																			   `hari_dtg` , `tgl_dtg` , `pukul_dtg` , `transport_dtg` , `biaya` , 
																			   `L_ap_tax` , `L_fiskal` , `L_visa` , `L_saku` , `L_akomo` , `L_other` , `ndt_terakhir`) 
													  VALUES ( '".$frm_no_legalitas_now."', '".$frm_no_st_pub_now."', NULL, ".$frm_jenis.", '".$frm_ska_publikasi."', '".$frm_tgl_publikasi."', '".$frm_tgl_publikasi2."', '".$frm_tipe_publikasi."', 
															   '".$frm_kode_dsn1."', '".$frm_kode_dsn2."', '".$frm_kode_dsn3."', '".$frm_kode_dsn4."', '".$frm_kode_dsn5."', '".$frm_status."', '".$frm_TET."', '".$frm_TNET."', '".$frm_judul."', '".$frm_tugas."',
															   '".$frm_ISBN."', '".$frm_volume."', '".$frm_penyelenggara."', '".$frm_tgl_publikasi."', '".$frm_no_paten."', '".$frm_pemberi_paten."', '".$frm_tgl_terbit."',
															   '".$frm_id_sumber_dana."','".$frm_dana_lokal."', '".$frm_dana_asing."',	
															   '".$frm_hari_go."','".$frm_tgl_go."', '".$frm_pukul_go."', '".$frm_tempat_go."', '".$frm_transportasi_go."', 
															   '".$frm_hari_dtg."', '".$frm_tgl_dtg."', '".$frm_pukul_dtg."','".$frm_transportasi_dtg."', '".$frm_biaya."',
															   ".$chk_airport.", ".$chk_fiskal.", ".$chk_visa.", ".$chk_uang_saku.", ".$chk_akomodasi.", '".$frm_lainnya."', '".$frm_ndt."') " );
						if ($result_1_2) 
							{
								$pesan = $pesan."<br>Data telah ditambahkan";	
							}
							else
							{ 
								$pesan = $pesan."<br>Gagal menambahkan data 1-2 - ". mysql_error();
							}
					}
					
			//########################## CEK penelitian apa no ST_pub sudah ada..?		
					/*$res_cek_ti= mysql_query("SELECT penelitian.kode_pen
					                            FROM penelitian
											   WHERE penelitian.kode_pen='".$frm_no_st_pub_now."'"); 
					$maxrows_ti=mysql_num_rows($res_cek_ti);
					if ($maxrows_ti >= 1)		
					{
							$result = mysql_query("UPDATE penelitian SET `no_legalitas` = '$frm_no_legalitas_now',
																		 `publikasi` = $frm_ska_publikasi, 
																		 `jurn_pros` = $frm_tipe_publikasi, 
																		 `judul` ='$frm_judul',
																		 `tanggal_mulai`='$frm_tgl_go',
																		 `tanggal_selesai`='$frm_tgl_dtg',
																		 `jenis_pen`= '$frm_jenis',
																		 `pub_ISBN` = '$frm_ISBN',
																		 `pub_Volume`= '$frm_volume',
																		 `pub_tempat` = '$frm_tempat_go',
																		 `pub_penyelenggara` = '$frm_penyelenggara',
																		 `pub_tanggal` = '$frm_tgl_publikasi',
																		 `id_sumber_dana` ='$frm_id_sumber_dana',
																		 `dana` = '$frm_dana',
																		 `dana_asing` = '$frm_dana_asing',
																		 `no_paten` = '$frm_no_paten',
																		 `pemberi_paten` = '$frm_pemberi_paten'
																   WHERE `kode_pen`='$frm_no_st_pub_now'");
															   
																			
							if ($result_2_1) 
								{
									$pesan = $pesan."<br>Data telah diubah";	
								}
							else
								{ 
									$pesan = $pesan."<br>Gagal mengubah Penelitian - ". mysql_error();
								}
					}
					else
					{
								$pesan = $pesan."<br>Silahkan masukkan data penelitian terlebih dahulu!";	
					}			
			
			*/
			
			// TULISAN ILMIAH
					/*$res_cek_ti= mysql_query("SELECT tulisan_ilmiah.no_st_pub
					                            FROM tulisan_ilmiah
											   WHERE tulisan_ilmiah.no_st_pub='".$frm_no_st_pub_now."'"); 
					$maxrows_ti=mysql_num_rows($res_cek_ti);
					if ($maxrows_ti >= 1)		
					{
							$result_2_1= mysql_query("UPDATE tulisan_ilmiah SET `kode_dosen1` ='$frm_kode_dsn1',
																			    `kode_dosen2` ='$frm_kode_dsn2',
																			    `kode_dosen3` ='$frm_kode_dsn3',
																			    `kode_dosen4` ='$frm_kode_dsn4',
																			    `kode_dosen5` ='$frm_kode_dsn5',
																			    `publikasi` = $frm_ska_publikasi, 
																			    `jurn_pros` = $frm_tipe_publikasi, 
																			    `jurusan_id`= $frm_TET, 
																			    `judul` ='$frm_judul', 
																			    `tanggal_terbit` ='$frm_tgl_terbit', 
																			    `jumlah_peneliti`= $jum,
																			    `id_sumber_dana` ='$frm_id_sumber_dana',
																			    `dana` = '$frm_dana',
																			    `dana_asing` = '$frm_dana_asing',
																			    `kode_buku` = '$frm_kode_buku',
																			    `man_kel` = '$frm_sifat_pen',
																			    `pub_ISBN` = '$frm_ISBN',
																			    `pub_Volume`= '$frm_volume',
																			    `pub_tempat` = '$frm_tempat_publikasi',
																			    `pub_penyelenggara` = '$frm_penyelenggara',
																			    `pub_tanggal` = '$frm_tgl_publikasi',
																			    `no_paten` = '$frm_no_paten',
																			    `pemberi_paten` = '$frm_pemberi_paten'
																		  WHERE `no_st_pub` = '$frm_no_st_pub_now'");
																			
							if ($result_2_1) 
								{
									$pesan = $pesan."<br>Data telah diubah";	
								}
							else
								{ 
									$pesan = $pesan."<br>Gagal mengubah data 2-1 - ". mysql_error();
								}
					}
					else
					{
							$result_2_2 = mysql_query("INSERT INTO tulisan_ilmiah(`id_pen`, 
																				  `no_st_pub`,
																				  `kode_dosen1`, 
																				  `kode_dosen2`, 
																				  `kode_dosen3`,
																				  `kode_dosen4`,
																				  `kode_dosen5`,
																				  `publikasi`, 
																				  `jurn_pros`,
																				  `jurusan_id`, 
																				  `judul`,
																				  `tanggal_terbit`,
																				  `jumlah_peneliti`,
																				  `id_sumber_dana`, 
																				  `dana`, 
																				  `dana_asing`,
																				  `kode_buku`, 
																				  `man_kel`, 
																				  `pub_ISBN`, 
																				  `pub_Volume`, 
																				  `pub_tempat`, 
																				  `pub_penyelenggara`, 
																				  `pub_tanggal`, 
																				  `no_paten`, 
																				  `pemberi_paten`,
																				  `nama_media`,
																				  `id_status_media`) VALUES  
						    ( NULL, '".$frm_no_st_pub_now."', '".$frm_kode_dsn1."', '".$frm_kode_dsn2."', '".$frm_kode_dsn3."', '".$frm_kode_dsn4."', '".$frm_kode_dsn5."', ".$frm_ska_publikasi.", ".$frm_tipe_publikasi.", ".$frm_TET.", '".$frm_judul."', '".$frm_tgl_terbit."', ".$jum.", ".$frm_id_sumber_dana.", '".$frm_dana."', '".$frm_dana_asing."', '---', '".$frm_sifat_pen."', '".$frm_ISBN."', '".$frm_volume."', '".$frm_tempat_publikasi."', '".$frm_penyelenggara."', '".$frm_tgl_publikasi."', '".$frm_no_paten."', '".$frm_pemberi_paten."','---',0) " );
						
							if ($result_2_2) 
							{
								$pesan = $pesan."<br>Data telah ditambahkan";	
							}
							else
							{ 
								$pesan = $pesan."<br>Gagal menambahkan data 2-2 - ". mysql_error();
							}
					
					}*/
// END UBAH TABEL #########################################################################################################		
		}
	}


if ($act==2) { // hapus data
$result = mysql_query("DELETE FROM publikasi WHERE no_st_pub = '".$no_st."'");
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
	
$result = mysql_query("DELETE FROM tulisan_ilmiah WHERE no_st_pub = '".$no_st."'");
if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
	
//$result = mysql_query("DELETE FROM tulisan_ilmiah WHERE no_st_pub = '".$no_st."'");
//if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) 
{
    $frm_exist=0;
	$jum=0;
	
	$frm_jenis = "";
	$frm_no_st_pub_now = "";
	
	$frm_ska_publikasi = "";
	$frm_tipe_publikasi = "";
	$frm_judul = "";
	$frm_ISBN = "";
	$frm_volume = "";
	$frm_penyelenggara = "";
	
	
	$frm_tgl_publikasi="00/00/0000";
	$frm_tgl_publikasi2="00/00/0000";
	//echo "<br>frm_tgl_publikasi=".$frm_tgl_publikasi;
	//exit();
	$frm_tgl_terbit="00/00/0000";
	$frm_tgl_dtg="00/00/0000";
	$frm_tgl_go="00/00/0000";
	//echo "<br>frm_tgl_go_PPP=".$frm_tgl_go;
	
	$frm_kode_dsn1="";
	$frm_kode_dsn2="";
	$frm_kode_dsn3="";
	$frm_kode_dsn4="";
	$frm_kode_dsn5="";
	$frm_status="";
	$frm_TET="";
	$frm_TNET="";
	$frm_tugas="";

	$frm_no_paten = "";
	$frm_pemberi_paten = "";
	
	$frm_id_sumber_dana = "";
	$frm_dana = "";
	$frm_dana_asing = "";

	$frm_hari_go = "";
	$frm_pukul_go=""; 
	$frm_tempat_go="";
	$frm_transportasi_go="";
	$frm_hari_dtg="";
	$frm_tgl_dtg="";
	$frm_pukul_dtg=""; 
	$frm_transportasi_dtg="";
	$frm_biaya="";
	$chk_airport="";
	$chk_fiskal="";
	$chk_visa="";
	$chk_uang_saku="";
	$chk_akomodasi="";
	$frm_lainnya="";
	$frm_ndt="";
	
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_no_st_pub_now!='')  {
/*$result = mysql_query("Select dosen.kode,
							  dosen.nama,
                              publikasi.no_st_pub,
							  publikasi.urut_st_pub,
							  publikasi.kode_kary,
							  publikasi.kode_kary2,
							  publikasi.kode_kary3,
							  publikasi.kode_kary4,
							  publikasi.kode_kary5,
							  publikasi.status,
							  publikasi.jenis,
							  publikasi.TET_sub,
							  publikasi.TNET_sub,
							  publikasi.tugas,
							  publikasi.hari_go,
							  DATE_FORMAT(publikasi.tgl_go,'%d/%m/%Y') as tgl_go,
							  publikasi.pukul_go,
							  publikasi.tempat_go,
							  publikasi.transport_go,
							  publikasi.hari_dtg,
							  DATE_FORMAT(publikasi.tgl_dtg,'%d/%m/%Y') as tgl_dtg,
							  publikasi.pukul_dtg,
							  publikasi.transport_dtg,
							  publikasi.biaya,
							  publikasi.L_ap_tax,
							  publikasi.L_fiskal,
							  publikasi.L_visa,
							  publikasi.L_saku,
							  publikasi.L_akomo,
							  publikasi.L_other,
							  publikasi.ndt_terakhir,
							  tulisan_ilmiah.publikasi,
							  tulisan_ilmiah.jurn_pros,
							  tulisan_ilmiah.judul,
							  tulisan_ilmiah.pub_ISBN,
							  tulisan_ilmiah.pub_Volume,
							  tulisan_ilmiah.pub_penyelenggara,
							  DATE_FORMAT(tulisan_ilmiah.pub_tanggal,'%d/%m/%Y') as pub_tanggal,
							  tulisan_ilmiah.no_paten,
							  tulisan_ilmiah.pemberi_paten,
							  DATE_FORMAT(tulisan_ilmiah.tanggal_terbit,'%d/%m/%Y') as tanggal_terbit,
							  tulisan_ilmiah.id_sumber_dana,
							  tulisan_ilmiah.dana,
							  tulisan_ilmiah.dana_asing
					     FROM publikasi, dosen, tulisan_ilmiah 
					    WHERE publikasi.kode_kary=dosen.kode AND
						      publikasi.no_st_pub=tulisan_ilmiah.no_st_pub AND
					   		  publikasi.no_st_pub='".$frm_no_st_pub_now."'");*/
							  						  
$result = mysql_query("Select publikasi.no_legalitas,
                              publikasi.no_st_pub,
							  publikasi.urut_st_pub,
							  publikasi.jenis,
							  publikasi.publikasi AS skala_pub,
							  publikasi.jurn_pros AS tipe_pub,
							  publikasi.kode_kary,
							  publikasi.kode_kary2,
							  publikasi.kode_kary3,
							  publikasi.kode_kary4,
							  publikasi.kode_kary5,
							  publikasi.status,
							  publikasi.TET_sub,
							  publikasi.TNET_sub,
							  publikasi.judul AS judul_publikasi,
							  publikasi.tugas,
							  publikasi.pub_ISBN,
							  publikasi.pub_volume,
							  publikasi.pub_penyelenggara,
							  DATE_FORMAT(publikasi.pub_tgl_pub,'%d/%m/%Y') as pub_tgl_pub,
							  DATE_FORMAT(publikasi.tgl_publikasi,'%d/%m/%Y') as tgl_publikasi,
							  DATE_FORMAT(publikasi.tgl_publikasi2,'%d/%m/%Y') as tgl_publikasi2,
							  publikasi.pub_no_paten,
							  publikasi.pub_pemberi_paten,
							  publikasi.pub_tgl_paten,
							  publikasi.pub_id_sumber_dana,
							  publikasi.pub_jum_dana_lokal,
							  publikasi.pub_jum_dana_asing, 
							  publikasi.hari_go,
							  DATE_FORMAT(publikasi.tgl_go,'%d/%m/%Y') as tgl_go,
							  publikasi.pukul_go,
							  publikasi.tempat_go,
							  publikasi.transport_go,
							  publikasi.hari_dtg,
							  DATE_FORMAT(publikasi.tgl_dtg,'%d/%m/%Y') as tgl_dtg,
							  publikasi.pukul_dtg,
							  publikasi.transport_dtg,
							  publikasi.biaya,
							  publikasi.L_ap_tax,
							  publikasi.L_fiskal,
							  publikasi.L_visa,
							  publikasi.L_saku,
							  publikasi.L_akomo,
							  publikasi.L_other,
							  publikasi.ndt_terakhir
					     FROM publikasi
					    WHERE publikasi.no_st_pub='".$frm_no_st_pub_now."'");

						if ($row = mysql_fetch_array($result)) {
						    //echo "<br>HERE SATU";
							$frm_exist=1;
							$frm_no_legalitas_now = $row["no_legalitas"];
							$frm_no_st_pub_now = $row["no_st_pub"];
							$frm_jenis = $row["jenis"];
							$frm_ska_publikasi = $row["skala_pub"];
							$frm_tipe_publikasi = $row["tipe_pub"];
							
							$frm_kode_dsn1 = $row["kode_kary"];
							$frm_kode_dsn2 = $row["kode_kary2"];
							$frm_kode_dsn3 = $row["kode_kary3"];
							$frm_kode_dsn4 = $row["kode_kary4"];
							$frm_kode_dsn5 = $row["kode_kary5"];
							
							$frm_status = $row["status"];
							$frm_TET = $row["TET_sub"];
							$frm_TNET = $row["TNET_sub"];
							$frm_judul = $row["judul_publikasi"];
							$frm_tugas = $row["tugas"];
							
							$frm_ISBN = $row["pub_ISBN"];
							$frm_volume = $row["pub_Volume"];
							$frm_penyelenggara = $row["pub_penyelenggara"];
							$frm_tgl_publikasi = $row["frm_tgl_publikasi"];
							$frm_tgl_publikasi2 = $row["frm_tgl_publikasi2"];
							$frm_no_paten = $row["pub_no_paten"];
							$frm_pemberi_paten = $row["pub_pemberi_paten"];
							$frm_tgl_terbit = $row["pub_tgl_paten"];
							$frm_id_sumber_dana = $row["pub_id_sumber_dana"];
							$frm_dana_lokal = $row["pub_jum_dana_lokal"];
							$frm_dana_asing = $row["pub_jum_dana_asing"];
							
							$chk_airport = $row["L_ap_tax"];
							$chk_fiskal = $row["L_fiskal"];
							$chk_visa = $row["L_visa"];
							$chk_uang_saku = $row["L_saku"];
							$chk_akomodasi = $row["L_akomo"];
							$frm_lainnya = $row["L_other"];
							
							/*if (($row["pub_tgl_pub"]=="")or($row["pub_tgl_pub"]==NULL)or($row["pub_tgl_pub"]=="00/00/0000")) {
							$frm_tgl_publikasi ="00/00/0000"; }else {
							$frm_tgl_publikasi =$row["pub_tgl_pub"];}*/
							
							if (($row["tgl_publikasi"]=="")or($row["tgl_publikasi"]==NULL)or($row["tgl_publikasi"]=="00/00/0000")) {
							$frm_tgl_publikasi ="00/00/0000"; }else {
							$frm_tgl_publikasi =$row["tgl_publikasi"];}
							
							if (($row["tgl_publikasi2"]=="")or($row["tgl_publikasi2"]==NULL)or($row["tgl_publikasi2"]=="00/00/0000")) {
							$frm_tgl_publikasi2 ="00/00/0000"; }else {
							$frm_tgl_publikasi2 =$row["tgl_publikasi2"];}
							
							if (($row["tanggal_terbit"]=="")or($row["tanggal_terbit"]==NULL)or($row["tanggal_terbit"]=="00/00/0000")) {
							$frm_tgl_terbit ="00/00/0000"; }else {
							$frm_tgl_terbit =$row["tanggal_terbit"];}
														
							$frm_no_paten=$row["no_paten"];
							$frm_pemberi_paten=$row["pemberi_paten"];
														
							$frm_hari_go = $row["hari_go"];
							
							if (($row["tgl_go"]=="")or($row["tgl_go"]==NULL)or($row["tgl_go"]=="00/00/0000")) {
							$frm_tgl_go =""; }else {
							$frm_tgl_go =$row["tgl_go"];}
							
							
							$frm_pukul_go = $row["pukul_go"];
							$frm_tempat_go = $row["tempat_go"];
							$frm_transportasi_go = $row["transport_go"];
							$frm_hari_dtg = $row["hari_dtg"];
							
							if (($row["tgl_dtg"]=="")or($row["tgl_dtg"]==NULL)or($row["tgl_dtg"]=="00/00/0000")) {
							$frm_tgl_dtg =""; }else {
							$frm_tgl_dtg =$row["tgl_dtg"];}
							
							$frm_pukul_dtg = $row["pukul_dtg"]; 
							$frm_transportasi_dtg = $row["transport_dtg"];
							
							$frm_pukul_dtg = $row["pukul_dtg"];
							$frm_biaya = $row["biaya"]; 
							$frm_ndt = $row["ndt_terakhir"]; 
							 
							/*
							echo "<br>frm_no_st_pub_now= ".$frm_no_st_pub_now;
							echo "<br>frm_kode_dsn1= ".$frm_kode_dsn1;
							echo "<br>frm_kode_dsn2= ".$frm_kode_dsn2;
							echo "<br>frm_kode_dsn3= ".$frm_kode_dsn3;
							echo "<br>frm_kode_dsn4= ".$frm_kode_dsn4;
							echo "<br>frm_kode_dsn5= ".$frm_kode_dsn5;
							echo "<br>frm_status= ".$frm_status;
							echo "<br>frm_TET= ".$frm_TET;
							echo "<br>frm_TNET= ".$frm_TNET;
							echo "<br>frm_tugas= ".$frm_tugas;
							echo "<br>frm_hari_go= ".$frm_hari_go;
							echo "<br>frm_tgl_go= ".$frm_tgl_go;
							echo "<br>frm_pukul_go= ".$frm_pukul_go;
							echo "<br>frm_tempat_go= ".$frm_tempat_go;
							echo "<br>frm_transportasi_go= ".$frm_transportasi_go;
							echo "<br>frm_hari_dtg= ".$frm_hari_dtg;
							echo "<br>frm_tgl_dtg= ".$frm_tgl_dtg;
							echo "<br>frm_pukul_dtg= ".$frm_pukul_dtg;
							echo "<br>frm_transportasi_dtg= ".$frm_transportasi_dtg;*/
						}
						else
						{
							$frm_exist=0;
							//$frm_no_st_pub_now="";
							//echo "<br>H E R E dua<br>";
							//echo "<br>judul=".$row["judul"];
							//exit();
						   // if ($row["judul"]=='') {
						        $frm_no_legalitas_now = "";
								$chk_airport = "";
								$chk_fiskal = "";
								$chk_visa = "";
								$chk_uang_saku = "";
								$chk_akomodasi = "";
								$frm_lainnya = "";
															
								//$frm_jenis = "";
								//$frm_no_st_pub_now = "";
								$frm_ska_publikasi = "";
								$frm_tipe_publikasi = "";
								$frm_judul = "";
								$frm_ISBN = "";
								$frm_volume = "";
								$frm_penyelenggara = "";
								
								$frm_tgl_publikasi = "00/00/0000";
								$frm_tgl_publikasi2 = "00/00/0000";
								$frm_tgl_terbit = "00/00/0000"; 
															
								$frm_no_paten = "";
								$frm_pemberi_paten = "";
								
								$frm_id_sumber_dana = "";
								$frm_dana_lokal = "";
								$frm_dana_asing = "";
								
								$frm_kode_dsn1 = "";
								$frm_kode_dsn2 = "";
								$frm_kode_dsn3 = "";
								$frm_kode_dsn4 = "";
								$frm_kode_dsn5 = "";
								
								$frm_status = "";
								$frm_TET = "";
								$frm_TNET = "";
								$frm_tugas = "";
								$frm_hari_go = "";
								$frm_tgl_go = "";
								$frm_pukul_go = "";
								$frm_tempat_go = "";
								$frm_transportasi_go = "";
								$frm_hari_dtg = "";
								$frm_tgl_dtg = "";
								$frm_pukul_dtg = "";
								$frm_transportasi_dtg = "";
								$frm_pukul_dtg = "";
								$frm_biaya = "";
								$frm_ndt = "";
								//$frm_jenis="";
							//}
						}

}

}

?>
<html>
<head>
<meta http-equiv="Refresh" content="1420; URL=pen_st_publikasi_entry.php">
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../include/tanggalan.js">
</script>
<SCRIPT language=Javascript>
      <!--
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
      //-->
   </SCRIPT>
<style type="text/css">
<!--
.style1 {font-size: 10px}
-->
</style>
</head>
<body class="body">
<form name="publikasi" id="publikasi" action="pen_st_publikasi_entry.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><img src="spacer" height="1"></td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4"> <hr size="1" color="#FF9900">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="89%"><font color="#0099CC" size="1"><strong>ENTRY DATA ~ </strong>SURAT TUGAS PUBLIKASI</font></td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">DOSEN</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="93">&nbsp;</td> 
      <td width="212">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="646"><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" ></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Jenis Surat Tugas </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <select name="frm_jenis" id="frm_jenis" class="tekboxku" onChange="document.publikasi.submit()">
	  <!--select name="frm_jenis" id="frm_jenis" class="tekboxku" <? //if ($frm_no_st_pub_now =='') {?> onBlur="document.publikasi.submit();" <? // }?>-->
		<? if (isset($frm_jenis)) {?>
            <option value="1" <? if ($frm_jenis=="1") echo "selected"?>>satu orang</option>
            <option value="2" <? if ($frm_jenis=="2") echo "selected"?>>lebih dari satu</option>
            <? } else {?>
            <option value="">---Pilih---</option>
            <option value="1">satu orang</option>
            <option value="2">lebih dari satu</option>
        <? }?>
      </select>
	  <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>&nbsp;</td>
      <td><div align="center"></div></td>
      <td> 
	  <? 
	  	$result_ST_last = mysql_query("SELECT no_st_pub, urut_st_pub, no_legalitas FROM publikasi ORDER BY urut_st_pub DESC LIMIT 1");
		$row_ST_last = mysql_fetch_array($result_ST_last);
	  ?>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>No ST publikasi sebelumnya</td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_st_pub_lama" type="text" id="frm_no_st_pub_lama" size="25" maxlength="5" value="<?php echo $row_ST_last['no_st_pub']; ?>" class="tekboxku" readonly="true">
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>No ST publikasi sekarang </td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_st_pub_now" id="frm_no_st_pub_now" type="text" onBlur="document.publikasi.submit();" value="<?php echo $frm_no_st_pub_now; ?>" size="25" maxlength="25" class="tekboxku">
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>No Legalitas sebelumnya </td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_legalitas_lama" type="text" id="frm_no_legalitas_lama" size="25" maxlength="5" value="<?php echo $row_ST_last['no_legalitas']; ?>" class="tekboxku" readonly="true">
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>No Legalitas sekarang </td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_legalitas_now" id="frm_no_legalitas_now2" type="text" value="<?php echo $frm_no_legalitas_now; ?>" size="25" maxlength="25" class="tekboxku">
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Skala Publikasi</td>
      <td><strong>:</strong></td>
      <td><? //echo "<br>frm_ska_publikasi=".$frm_ska_publikasi;?>
	  <select name="frm_ska_publikasi" id="frm_ska_publikasi" class="tekboxku">
        <option value="0" <?php if ($frm_ska_publikasi==0){echo "selected";}?>>Tidak ada data</option>
        <option value="1" <?php if ($frm_ska_publikasi==1){echo "selected";}?>>Regional</option>
        <option value="2" <?php if ($frm_ska_publikasi==2){echo "selected";}?>>Nasional</option>
        <option value="3" <?php if ($frm_ska_publikasi==3){echo "selected";}?>>Internasional</option>
      </select>
      <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap> Tipe Publikasi </td>
      <td><strong>:</strong></td>
      <td><? //echo "pub=".$frm_tipe_publikasi;?>
        <select name="frm_tipe_publikasi" id="frm_tipe_publikasi" class="tekboxku">
          <option value="0" <?php if ($frm_tipe_publikasi==0){echo "selected";}?>>Tidak ada data</option>
          <option value="1" <?php if ($frm_tipe_publikasi==1){echo "selected";}?>>Jurnal</option>
          <option value="2" <?php if ($frm_tipe_publikasi==2){echo "selected";}?>>Prosiding</option>
        </select>
        <font color="#FF0000">*</font>        <font color="#FF0000" size="1"><em>Prosiding</em>: dipresentasikan <strong>|</strong> <em>Jurnal</em>: tanpa dipresentasikan</font> </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top" nowrap>Judul</td>
      <td valign="top"><strong>:</strong></td>
      <td><textarea name="frm_judul" id="frm_judul" cols="50" class="tekboxku" wrap="soft"><?php echo $frm_judul; ?></textarea>
      <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>ISBN/ISSN</td>
      <td><strong>:</strong></td>
      <td><input name="frm_ISBN" type="text" class="tekboxku" id="frm_ISBN" value="<?php echo $frm_ISBN; ?>" size="30" maxlength="50">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Volume</td>
      <td><strong>:</strong></td>
      <td><input name="frm_volume" type="text" class="tekboxku" id="frm_volume" value="<?php echo $frm_volume; ?>" size="30" maxlength="50"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap> Penyelenggara </td>
      <td><strong>:</strong></td>
      <td><input name="frm_penyelenggara" type="text" class="tekboxku" id="frm_penyelenggara" value="<?php echo $frm_penyelenggara; ?>" size="50" maxlength="50">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap> Tanggal Publikasi </td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_publikasi" type="text" class="tekboxku" id="frm_tgl_publikasi" value="<?php echo $frm_tgl_publikasi; ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('publikasi.frm_tgl_publikasi',0,0,'DD/MM/YYYY')"> <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>s/d</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="frm_tgl_publikasi2" type="text" class="tekboxku" id="frm_tgl_publikasi2" value="<?php echo $frm_tgl_publikasi2; ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('publikasi.frm_tgl_publikasi2',0,0,'DD/MM/YYYY')"> <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy)</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap> No. Hak Paten </td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_paten" type="text" class="tekboxku" id="frm_no_paten" value="<?php echo $frm_no_paten; ?>" size="50" maxlength="50"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap> Pemberi Hak Paten </td>
      <td><strong>:</strong></td>
      <td><input name="frm_pemberi_paten" type="text" class="tekboxku" id="frm_pemberi_paten" value="<?php echo $frm_pemberi_paten; ?>" size="50" maxlength="50"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap> Tanggal Terbit </td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_terbit" type="text" class="tekboxku" id="frm_tgl_terbit" value="<?php echo $frm_tgl_terbit; ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('publikasi.frm_tgl_terbit',0,0,'DD/MM/YYYY')"> <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy)</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Sumber Dana</td>
      <td><strong>:</strong></td>
      <td><? //echo "id_sumber_dana=".$frm_id_sumber_dana;?>
	  <select name="frm_id_sumber_dana" id="frm_id_sumber_dana" class="tekboxku">
        <option <?php if ($frm_id_sumber_dana==''){echo "selected";}?>>--- Pilih ---</option>
        <?php
			$result1 = @mysql_query("SELECT id, nama FROM sumber_dana ORDER BY nama ASC");
			$c=0;
			while ($row1=@mysql_fetch_object($result1))  {
			$c=$c+1;
			?>
        <option  value="<?php echo $row1->id; ?>" <?php if ($frm_id_sumber_dana==$row1->id) { echo "selected"; }?> ><?php echo $row1->nama; ?></option>
        <?php
			}
			?>
      </select>
	  <font color="#FF0000">*</font>	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Nominal Dana</td>
      <td><strong>:</strong></td>
      <td>Rp.
	  <? //onkeypress="return isNumberKey(event)"?>
      <input type="text" name="frm_dana_lokal" id="frm_dana_lokal"  value="<?php echo $frm_dana_lokal; ?>" class="tekboxku">
      <font color="#FF0000" size="1">misal : 3.000.000</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Nominal Dana (asing) </td>
      <td><strong>:</strong></td>
      <td><input type="text" name="frm_dana_asing" id="frm_dana_asing" value="<?php echo $frm_dana_asing; ?>" class="tekboxku">
      <font color="#FF0000" size="1">misal : US 800 | AUD 517 | JPY 1100</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Ketua</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
		   <select name="frm_kode_dsn1" id="frm_kode_dsn1" class="tekboxku">
					<option <?php if ($frm_kode_dsn1==''){echo "selected";}?> value="">-- NPK Dosen --</option>
					<?php
					$result1 = @mysql_query("Select kode, nama from dosen   where (length(kode)=6) ORDER BY kode");
					$c=0;
					while ($row1=@mysql_fetch_object($result1))  {
					$c=$c+1;
					?>
					<option value="<?php echo $row1->kode; ?>" <?php if ($frm_kode_dsn1==$row1->kode) { echo "selected"; }?> ><?php echo $row1->kode; ?> 
					- <?php echo $row1->nama; ?></option>
					<?php }?>
		</select> 
			<font color="#FF0000">*</font>
			<!--a href="#" onClick="return popitup('pen_st_publikasi_entry_cari_dosen.php')">C a r i</a-->
	  </td>
    </tr>
	 <? 
	  if (isset($frm_jenis) or ($frm_jenis!="")) //lebih dari satu orang
	  {
	  if ($frm_jenis=="2"){
	  ?>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Nama anggota 1 </td>
      <td><strong>:</strong></td>
      <td><select name="frm_kode_dsn2" id="frm_kode_dsn2" class="tekboxku">
        <option <?php if ($frm_kode_dsn2==''){echo "selected";}?> value="">-- NPK Dosen --</option>
        <?php
					$result1 = @mysql_query("SELECT kode, nama FROM dosen   order by kode ASC");
					$c=0;
					while ($row1=@mysql_fetch_object($result1))  {
					$c=$c+1;
					?>
        <option value="<?php echo $row1->kode; ?>" <?php if ($frm_kode_dsn2==$row1->kode) { echo "selected"; }?> ><?php echo $row1->kode; ?> - <?php echo $row1->nama; ?></option>
        <?php }?>
      </select>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Nama anggota 2 </td>
      <td><strong>:</strong></td>
      <td>
	  <select name="frm_kode_dsn3" id="frm_kode_dsn3" class="tekboxku">
        <option <?php if ($frm_kode_dsn3==''){echo "selected";}?> value="">-- NPK Dosen --</option>
        <?php
					$result1 = @mysql_query("Select kode, nama from dosen   order by kode ASC");
					$c=0;
					while ($row1=@mysql_fetch_object($result1))  {
					$c=$c+1;
					?>
        <option value="<?php echo $row1->kode; ?>" <?php if ($frm_kode_dsn3==$row1->kode) { echo "selected"; }?> ><?php echo $row1->kode; ?> - <?php echo $row1->nama; ?></option>
        <?php }?>
      </select>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Nama anggota 3 </td>
      <td><strong>:</strong></td>
      <td><select name="frm_kode_dsn4" id="frm_kode_dsn4" class="tekboxku">
        <option <?php if ($frm_kode_dsn4==''){echo "selected";}?> value="">-- NPK Dosen --</option>
        <?php
					$result1 = @mysql_query("Select kode, nama from dosen  order by kode ASC");
					$c=0;
					while ($row1=@mysql_fetch_object($result1))  {
					$c=$c+1;
					?>
        <option value="<?php echo $row1->kode; ?>" <?php if ($frm_kode_dsn4==$row1->kode) { echo "selected"; }?> ><?php echo $row1->kode; ?> - <?php echo $row1->nama; ?></option>
        <?php }?>
      </select>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Nama anggota 4 </td>
      <td><strong>:</strong></td>
      <td>
	   <select name="frm_kode_dsn5" id="frm_kode_dsn5" class="tekboxku">
        <option <?php if ($frm_kode_dsn5==''){echo "selected";}?> value="">-- NPK Dosen --</option>
        <?php
					$result1 = @mysql_query("Select kode, nama from dosen  order by kode ASC");
					$c=0;
					while ($row1=@mysql_fetch_object($result1))  {
					$c=$c+1;
					?>
        <option value="<?php echo $row1->kode; ?>" <?php if ($frm_kode_dsn5==$row1->kode) { echo "selected"; }?> ><?php echo $row1->kode; ?> - <?php echo $row1->nama; ?></option>
        <?php }?>
      </select>
	  </td>
    </tr>
	<? 
	//END
	}
	}?>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><? //echo "jum= ".$jum;?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="26%"><u>JABATAN</u></td>
          <td width="1%">&nbsp;</td>
          <td width="73%">&nbsp;</td>
        </tr>
        <tr>
          <td nowrap>Sebagai TET Sub. Sistem </td>
          <td><div align="center"><strong>:</strong></div></td>
          <td>
		  <select name="frm_TET" id="frm_TET" class="tekboxku">
            <option value="" <? if ($frm_TET=='') echo "selected";?>>---Pilih---</option>
            <?php
				 //f_connecting();
				 //mysql_select_db($DB);
				 $result3 = @mysql_query("SELECT id, jurusan FROM jurusan");
				 $c=0;
				 while(($row3 = mysql_fetch_object($result3)))
				 {
				 	$c=$c+1;
				    //echo "<option value=".$row3["id"].">".$row3["nama"];
					?>
            <option  value="<?php echo $row3->id; ?>" <?php if ($frm_TET==$row3->id) { echo "selected"; }?> ><?php echo $row3->jurusan; ?></option>
            <?
				 }
			?>
          </select>
            <font color="#FF0000">*</font></td>
        </tr>
        <tr>
          <td nowrap>Sebagai TNET Sub. Sistem </td>
          <td><div align="center"><strong>:</strong></div></td>
          <td>
		  <select name="frm_TNET" id="frm_TNET" class="tekboxku">
            <option value="" <? if ($frm_TNET=='') echo "selected";?>>---Pilih---</option>
            <?php
				 //f_connecting();
				 //mysql_select_db($DB);
				 $result3 = @mysql_query("SELECT id,jurusan FROM jurusan");
				 $c=0;
				 while(($row3 = mysql_fetch_object($result3)))
				 {
				 	$c=$c+1;
				    //echo "<option value=".$row3["id"].">".$row3["nama"];
					?>
            <option  value="<?php echo $row3->id; ?>" <?php if ($frm_TNET==$row3->id) { echo "selected"; }?> ><?php echo $row3->jurusan; ?></option>
            <? }?>
          </select>
            </td>
        </tr>
        <tr>
          <td>Status</td>
          <td><div align="center"><strong>:</strong></div></td>
          <td><select name="frm_status" id="frm_status" class="tekboxku">
            <? if (isset($frm_status)) {?>
			<option>Pilih</option>
            <option value="Penyaji" <? if ($frm_status=="Penyaji") echo "selected"?>>Penyaji</option>
            <option value="Peserta" <? if ($frm_status=="Peserta") echo "selected"?>>Peserta</option>
            <? } else {?>
            <option>Pilih</option>
            <option value="Penyaji">Penyaji</option>
            <option value="Peserta">Peserta</option>
            <? }?>
          </select>
            <font color="#FF0000">*</font></td>
        </tr>
        <tr>
          <td width="26%" valign="top" nowrap>Tugas</td>
          <td valign="top"><div align="center"><strong>:</strong></div></td>
          <td><textarea name="frm_tugas" id="textarea" cols="50" class="tekboxku"><?php echo $frm_tugas; ?></textarea>
            <font color="#FF0000">*</font> </td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td><u>BERANGKAT</u></td>
          <td width="1%">&nbsp;</td>
          <td width="79%">&nbsp;</td>
        </tr>
        <tr>
          <td>Hari</td>
          <td><strong>:</strong></td>
          <td>
		   <select name="frm_hari_go" id="frm_hari_go" class="tekboxku">
				<? if (isset($frm_hari_go)) {?>
				<option>--Pilih--</option>
				<option value="Senin" <? if ($frm_hari_go=="Senin") echo "selected"?>>Senin</option>
				<option value="Selasa" <? if ($frm_hari_go=="Selasa") echo "selected"?>>Selasa</option>
				<option value="Rabu" <? if ($frm_hari_go=="Rabu") echo "selected"?>>Rabu</option>
				<option value="Kamis" <? if ($frm_hari_go=="Kamis") echo "selected"?>>Kamis</option>
				<option value="Jumat" <? if ($frm_hari_go=="Jumat") echo "selected"?>>Jumat</option>
				<option value="Sabtu" <? if ($frm_hari_go=="Sabtu") echo "selected"?>>Sabtu</option>
				<option value="Minggu" <? if ($frm_hari_go=="Minggu") echo "selected"?>>Minggu</option>
				<? } else {?>
				<option>--Pilih--</option>
				<option value="Senin">Senin</option>
				<option value="Selasa">Selasa</option>
				<option value="Rabu">Rabu</option>
				<option value="Kamis">Kamis</option>
				<option value="Jumat">Jumat</option>
				<option value="Sabtu">Sabtu</option>
				<option value="Minggu">Minggu</option>
				<? }?>
          </select>
            <font color="#FF0000">*</font></td>
        </tr>
        <tr>
          <td>Tanggal</td>
          <td><strong>:</strong></td>
          <td><input name="frm_tgl_go" type="text" class="tekboxku" id="frm_tgl_go" value="<?php echo $frm_tgl_go; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('publikasi.frm_tgl_go',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)  <font color="#FF0000">*</font></td>
        </tr>
        <tr>
          <td>Pukul</td>
          <td><strong>:</strong></td>
          <td><input name="frm_pukul_go" type="text" class="tekboxku" id="frm_pukul_go" value="<?php echo $frm_pukul_go; ?>" size="6" maxlength="5">
            <font color="#FF0000">*<span class="style1">(format 24 jam, misal= 17:30)</span></font></td>
        </tr>
        <tr>
          <td>Tempat</td>
          <td><strong>:</strong></td>
          <td><input name="frm_tempat_go" type="text" class="tekboxku" id="frm_tempat_go" value="<?php echo $frm_tempat_go; ?>" size="50" maxlength="50">
            <font color="#FF0000">*<span class="style1"> tempat acara dilaksanakan</span></font></td>
        </tr>
        <tr>
          <td width="25%" valign="top" nowrap>Fasilitas Transportasi</td>
          <td valign="top"><strong>:</strong></td>
          <td><input name="frm_transportasi_go" type="text" class="tekboxku" id="frm_transportasi_go" size="50" maxlength="100" value="<?php echo $frm_transportasi_go; ?>">
            <font color="#FF0000">*</font></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td><u>KEMBALI</u></td>
          <td width="1%">&nbsp;</td>
          <td width="79%">&nbsp;</td>
        </tr>
        <tr>
          <td>Hari</td>
          <td><strong>:</strong></td>
          <td>
		  <select name="frm_hari_dtg" id="frm_hari_dtg" class="tekboxku">
				<? if (isset($frm_hari_dtg)) {?>
				<option>--Pilih--</option>
				<option value="Senin" <? if ($frm_hari_dtg=="Senin") echo "selected"?>>Senin</option>
				<option value="Selasa" <? if ($frm_hari_dtg=="Selasa") echo "selected"?>>Selasa</option>
				<option value="Rabu" <? if ($frm_hari_dtg=="Rabu") echo "selected"?>>Rabu</option>
				<option value="Kamis" <? if ($frm_hari_dtg=="Kamis") echo "selected"?>>Kamis</option>
				<option value="Jumat" <? if ($frm_hari_dtg=="Jumat") echo "selected"?>>Jumat</option>
				<option value="Sabtu" <? if ($frm_hari_dtg=="Sabtu") echo "selected"?>>Sabtu</option>
				<option value="Minggu" <? if ($frm_hari_dtg=="Minggu") echo "selected"?>>Minggu</option>
				<? } else {?>
				<option>--Pilih--</option>
				<option value="Senin">Senin</option>
				<option value="Selasa">Selasa</option>
				<option value="Rabu">Rabu</option>
				<option value="Kamis">Kamis</option>
				<option value="Jumat">Jumat</option>
				<option value="Sabtu">Sabtu</option>
				<option value="Minggu">Minggu</option>
				<? }?>
          </select>
            <font color="#FF0000">*</font></td>
        </tr>
        <tr>
          <td>Tanggal</td>
          <td><strong>:</strong></td>
          <td><input name="frm_tgl_dtg" type="text" class="tekboxku" id="frm_tgl_dtg" value="<?php echo $frm_tgl_dtg;?>" size="10" maxlength="10">
              <A Href="javascript:show_calendar('publikasi.frm_tgl_dtg',0,0,'DD/MM/YYYY')"> <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy) <font color="#FF0000">*</font></td>
        </tr>
        <tr>
          <td>Pukul</td>
          <td><strong>:</strong></td>
          <td><input name="frm_pukul_dtg" type="text" class="tekboxku" id="frm_pukul_dtg" value="<?php echo $frm_pukul_dtg; ?>" size="6" maxlength="5">
            <font color="#FF0000">*<span class="style1">(format 24 jam, misal= 17:30)</span></font></td>
        </tr>
        <tr>
          <td width="25%" nowrap>Fasilitas Transportasi</td>
          <td><strong>:</strong></td>
          <td> 
		  <input name="frm_transportasi_dtg" type="text" class="tekboxku" id="frm_transportasi_dtg" size="50" maxlength="100" value="<?php echo $frm_transportasi_dtg; ?>">
            <font color="#FF0000">*</font></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" valign="top"><u>Pembiayaan yang diperlukan (berikan tanda check pada kotak/lengkapi isian yang tersedia)</u></td>
          </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">Biaya program <br>
            (Rp. / Mata Uang Asing) </td>
          <td valign="top"><strong>:</strong></td>
		  <? //onKeyPress="return isNumberKey(event)" ?>
          <td valign="top"><input name="frm_biaya" id="frm_biaya" type="text"  class="tekboxku" size="20" maxlength="30" value="<?php echo $frm_biaya; ?>" >
            <font color="#FF0000" size="1">misal: Rp.700.000 | US 850 *</font></td>
        </tr>
        <tr>
          <td width="25%" valign="top">Lain-lain </td>
          <td width="1%" valign="top"><strong>:</strong></td>
          <td width="79%"><table width="90%"  border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td width="21%"><input type="checkbox" name="chk_airport" id="chk_airport" <? if ($chk_airport=='1') echo "checked";?>>
                Airport Tax </td>
              <td width="8%">&nbsp;</td>
              <td width="71%"><input type="checkbox" name="chk_fiskal" id="chk_fiskal" <? if ($chk_fiskal==1) echo "checked";?>>
                Fiskal Luar Negeri </td>
              </tr>
            <tr>
              <td><input type="checkbox" name="chk_visa" id="chk_visa" <? if ($chk_visa==1) echo "checked";?>>
                Visa</td>
              <td>&nbsp;</td>
              <td><input type="checkbox" name="chk_uang_saku" id="chk_uang_saku" <? if ($chk_uang_saku==1) echo "checked";?>>
                Uang Saku (biaya hidup) </td>
              </tr>
            <tr>
              <td nowrap><input type="checkbox" name="chk_akomodasi" id="chk_akomodasi" <? if ($chk_akomodasi==1) echo "checked";?>>
                Akomodasi</td>
              <td>&nbsp;</td>
              <td>
			  	<script language="javascript">
				function cek()
				{
					if (document.getElementById("chk_lainnya").checked==true)
					{
						document.getElementById("frm_lainnya").disabled=false;
					}
					else if (document.getElementById("chk_lainnya").checked==false)
					{
						document.getElementById("frm_lainnya").disabled=true;
					}
				}
				</script>
			    <input type="checkbox" name="chk_lainnya" id="chk_lainnya" onClick="cek();" <? if ($frm_lainnya <>'') echo "checked";?>>                  
                <input name="frm_lainnya" id="frm_lainnya" type="text" class="tekboxku" size="40" maxlength="255" value="<?php echo $frm_lainnya; ?>" disabled>
			  </td>
			  </tr>
          </table>
		  </td>
        </tr>
        <tr>
          <td nowrap>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="25%" valign="top" nowrap>Non degree training terakhir </td>
          <td valign="top"><strong>:</strong></td>
          <td>
            <textarea name="frm_ndt" id="frm_ndt" cols="50" class="tekboxku"><?php echo $frm_ndt; ?></textarea>
		  </td>
        </tr>
      </table></td>
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
      <td>
	    <input type="submit" name="Submit" id="Submit" value="Simpan" onClick="this.form.action+='?act=1&jum=<? echo $jum;?>';this.form.submit();" class="tombol">
        <input type="reset" name="Submit2" id="Submit2" value="Batal" onClick="this.form.action+='?act=3';this.form.submit();" class="tombol">
        <?php if ($frm_no_st_pub_now) { ?>
        <input type="button" name="Submit3" id="Submit3" value="Hapus"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&no_st=<?php echo $frm_no_st_pub_now;?>';this.form.submit()};" class="tombol">
        <input type="submit" name="submit1" id="submit1" value="PRINT" onClick="cetak();" class="tombol">
		<?php } ?></td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" size="1">*</font><font size="1"> = 
        compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>