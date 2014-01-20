<?php
/*
===========================================================================================

Date Created 		: 18 Maret 2003
Last Update 		: 24 Maret 2003
Comment 			: File ini berisi aturan pemrograman, variabel global (session) dsb... 
	
Revision History 	:
* 18 Maret 2003 	: Pembuatan Pertama (Any addition ?)
  24 Maret 2003		: Penambahan variabel global (di bag bawah setelah aturan) - Kenny

===========================================================================================



Aturan Pembuatan Sebuah File Baru :
===========================================================================================
1. File baru akan diletakkan di direktori terkait dan nama file seperti di bawah ini :
	Modul I 	- Umum 						: direktori /umum/ 
	Modul II 	- Mahasiswa dan Mata Kuliah : direktori /mhs/  	
	Modul III 	- Karyawan 					: direktori /karyawan/
	Modul IV   	- Penelitian				: direktori /penelitian/
	Modul V		- Lab dan Peralatn			: direktori /lab/
	
	File fungsi & variabel global dll		: diretori /include/	
2. Penamaan File Baru 
	File baru akan diberi nama sesuai dengan nomer subbab yang terdapat pada proposal
	Contoh : 
		Bab 2.1.2 = Modul I subbab 1.2 -> Nama File: umum_1_2.php
		Bab 3.1.1 = Modul II subbab 1.1 -> Nama File: mhs_1_1.php
		Bab 4.3.1 = Modul III subbab 3.1 -> Nama File: kry_3_1.php
		Bab 5.4.1 = Modul IV subbab 4.1 -> Nama File: penil_4_1.php
		Bab 6.3.5 = Modul V subbab 3.5 -> Nama File: lab_3_5.php
3. File Baru yang tidak diambil subbab tertentu :
		Terkait dengan Bab 2.1.2 -> Nama File: umum_1_2_xxx.php
		xxx bisa diisi dengan kata yang berkaitan dengan fungsi file
4. Fungsi global
		sia_function.php, diletakkan dalam direktori /include/
		nama fungsi f_NAMA_FUNGSI() -> f_hitung()		

Penamaan Variabel
=========================================================================================
* Semua nama variabel menggunakan huruf kecil, kecuali session / global
* Form pada halaman web :
	frm_NAMAFIELDDATABASE -> contoh: frm_id
* Loop :
	a - z
* Kondisional, Check, dsb :
	chk_DESKRIPSI
* Database :
	row
	row2
	row3
	:
	rown
* Sql String :
	sql
	sql2
	sql3
	:
	sqln
* Switch / Menu (pada querystring): 
	m
* Session / Global :
	LOGGED  -> berisi 1 kalau sudah login, kalau logoff diset 0
	LOGIN 	-> Nama Login
	PASS	-> password
	LEVEL	-> Disesuaikan dengan isi database account (?)
	

Completion 
===========================================================================================

Nama File -> Nomer Subbab yang terkait
++++++++++++++++++++++++++++++++++++++
/include/global.php  -> Subbab : none


Nomer Subbab, Halaman -> Nama File 
++++++++++++++++++++++++++++++++++

2.1	MASTER USER	5
2.2	GANTI PASSWORD	5
3.1.1	Setting Kota	7
3.1.2	Setting Nama SMU	8
3.1.3	Setting Pembina Mata Kuliah	8
3.1.4	Setting Kelompok Mata Kuliah	9
3.1.5	Setting Jenis Mata Kuliah	10
3.1.6	Setting Jam Kuliah	10
3.1.7	Setting Range Gaji Pertama	11
3.1.8	Master Mahasiswa	12
3.1.9	Master Buku Referensi	14
3.1.10	Master Mata Kuliah	15
3.1.11	Prasyarat Mata Kuliah	19
3.1.12	Mata Kuliah Buka	20
3.1.13	Nilai Mahasiswa	22
3.1.14	Tugas Akhir / Latihan Penelitian	24
3.1.15	Kerja Praktek	25
3.1.16	Master Alumni	27
3.2.1	Laporan Master Mahasiswa	29
3.2.2	Laporan Buku Referensi	31
3.2.3	Laporan Master Mata Kuliah	31
3.2.4	Laporan Mata Kuliah Pemakai Buku Referensi	32
3.2.5	Laporan Lesson Plan	33
3.2.6	Laporan Prasyarat Mata Kuliah	35
3.2.7	Laporan Mata Kuliah Buka	35
3.2.8	Laporan Mata Kuliah Buka Per Hari	36
3.2.9	Jadwal Ujian	38
3.2.10	Jadwal Ujian Per Minggu	40
3.2.11	Laporan Dosen Pengajar Mata Kuliah Buka	40
3.2.12	Laporan Nilai Mahasiswa	41
3.2.13	Laporan Tugas Akhir	42
3.2.14	Laporan Latihan Penelitian	43
3.2.15	Laporan Abstrak	44
3.2.16	Laporan Kerja Praktek	44
3.2.17	Laporan Alumni	46
4.1.1	Setting Pendidikan	47
4.1.2	Setting Jabatan Akademik	48
4.1.3	Setting Kepangkatan Karyawan	48
4.1.4	Setting Jenis Karyawan	49
4.1.5	Setting Jenis Penghargaan	50
4.1.6	Setting Tingkat Penghargaan	51
4.1.7	Setting Kegiatan Dosen	52
4.1.8	Setting Tingkat Rapat	53
4.1.9	Master Karyawan	54
4.1.10	Kenaikan Pangkat	56
4.1.11	Penghargaan Yang Diperoleh Karyawan	57
4.1.12	Kegiatan Dosen	58
4.1.13	Rapat	60
4.2.1	Laporan Master Karyawan	61
4.2.2	Laporan Rekap Kepangkatan Karyawan	63
4.2.3	Laporan Penghargaan Yang Diperoleh Dosen	63
4.2.4	Laporan Kegiatan Dosen	64
4.2.5	Laporan Rapat	65
5.1.1	Setting Status Media Tulisan Ilmiah	67
5.1.2	Setting Sumber Dana	67
5.1.3	Setting Penerbit	68
5.1.4	Master Media Tulisan Ilmiah	69
5.1.5	Tulisan Ilmiah	69
5.1.6	Penelitian	71
5.1.7	Buku Karya Dosen	72
5.1.8	Master Pihak Ketiga	73
5.1.9	Profil Kerjasama Dengan Pihak Ketiga (Institusional Collaboration Profile)	73
5.2.1	Laporan Tulisan Ilmiah Dosen	75
5.2.2	Laporan Penelitian Dosen	75
5.2.3	Laporan Buku Karya Dosen	76
5.2.4	Laporan Profil Kerjasama Dengan Pihak Ketiga	76
6.1.1	Master Laboratorium	79
6.1.2	Master Ruang	80
6.1.3	Master Type Alat	80
6.1.4	Input Alat Di Laboratorium	81
6.1.5	Koreksi Dan Hapus Alat Di Laboratorium	82
6.1.6	Perbaikan Alat	83
6.1.7	Perpindahan Alat	84
6.1.8	Pemakaian Laboratorium	85
6.1.9	Pemakaian Alat	86
6.2.1	Laporan Master Laboratorium	86
6.2.2	Laporan Master Ruang	87
6.2.3	Laporan Alat Di Laboratorium	87
6.2.4	Laporan Perbaikan Alat	88
6.2.5	Laporan Perpindahan Barang	88
6.2.6	Laporan Pemakaian Alat	89
6.2.7	Laporan Pemakaian Lab Tidak Rutin	89
6.2.8	Laporan Pemakaian Lab Rutin	90


*/


// =========================================================================================================

// $USER_DB untuk user database
// $PASS_DB untuk password database
// $LINK untuk link connect ke database
// $DB adalah nama database
// $HOSTNAME adalah nama host server

$USER_DB="s14";
$PASS_DB="s1smik0208";
$LINK;
$DB="s14_teknik_npk";
$HOSTNAME="localhost";

$USER_DB_SISKA="s14";
$PASS_DB_SISKA="s1smik0208";
$LINK_SISKA;
$DB_SISKA="s14_teknik_npk";
$HOSTNAME_SISKA="localhost";

//$USER_DB_SISKA="teknik";
//$PASS_DB_SISKA="prnfuFyBaHvV3dT5";
//$LINK_SISKA;
//$DB_SISKA="baak";
//$HOSTNAME_SISKA="neon.ubaya.ac.id";


// ========================================================================================================

$bulanNames=array(1=>'Januari','Pebruari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
function tanggalIndonesia($tglAsli) {
    global $bulanNames;
    $tgl=1;
    $bln=1;
    $thn=2013;
    $pecah=explode('/', $tglAsli);
    
    if (is_array($pecah) && (count($pecah)==3) ) {
        $tgl=$pecah[0];
        $bln=intval($pecah[1]);
        $thn=$pecah[2];        
    } else {
        $pecah=explode('-', $tglAsli);
        if (is_array($pecah) && (count($pecah)==3) ) {
            $tgl=$pecah[2];
            $bln=intval($pecah[1]);
            $thn=$pecah[0];            
        }        
    }
    $result=$tgl.' '.$bulanNames[$bln].' '.$thn;
    return $result;
}

?>
