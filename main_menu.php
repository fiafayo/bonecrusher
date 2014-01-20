<?php
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");                                                      // always modified
header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");                          // HTTP/1.0


require("include/fungsi.php");
require("include/global.php");
include("include/temp.php");
$menu=  filterInput('menu',0);
$pilih=  filterInput('pilih',0);

$logged_status=$_SESSION['logged_status'];
$hak=$_SESSION['hak'];

//echo "LOG=".$logged_status;
//exit;
if ($logged_status!=1) {
    header("Location: login.php"); /* Redirect browser */
    exit;                 
}
?>

<html>
<head>
<title>SIA Teknik Menu</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css">
<!--
a:link {
	color: #0000FF;
	text-decoration: none;
}
a:visited {
	color: #0000FF;
	text-decoration: none;
}
a:hover {
	color: #FF9900;
	text-decoration: underline;
}
a:active {
	color: #0000FF;
	text-decoration: none;
}
-->
</style>

<link href="css/style2.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.style6 {
	font-size: 10px;
	color: #FFFFFF;
	font-weight: bold;
}
.style7 {
	font-size: 10px;
	font-weight: bold;
}
-->
</style>
</head>

<body topmargin="0" leftmargin="0" class="menu_left" bgcolor="#ECF5FF">
<?php
switch ($menu) {
case 0 :
case 1 :
?>
<table width="100%" border="0" cellpadding="0" cellspacing="2"  class="menu_left">
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2">
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">USER</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table>	</td>
  </tr>
  <tr> 
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="umum/umum_2.php" target="mainFrame">Ganti Password</a></td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <!--tr> 
    <td colspan="2" bgcolor="#003366"><font color="#FFFFFF"><strong>Setting</strong></font></td>
  </tr>
  <?php if ($hak==100) { ?>
  <tr> 
    <td valign="top"><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="umum/umum_5.php" target="mainFrame">Jurusan</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="umum/umum_6.php" target="mainFrame">Tahun Ajaran</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="umum/umum_8.php" target="mainFrame">Propinsi</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="mhs/mhs_1_1.php" target="mainFrame">Kota</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="mhs/mhs_1_2.php" target="mainFrame">Nama SMU</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="mhs/mhs_1_17.php" target="mainFrame">Status Mahasiswa</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="mhs/mhs_1_3.php" target="mainFrame">Pembina MK</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="mhs/mhs_1_4.php" target="mainFrame">Kelompok MK</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="mhs/mhs_1_5.php" target="mainFrame">Jenis MK</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="mhs/mhs_1_6.php" target="mainFrame">Jam Kuliah</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="mhs/mhs_1_7.php" target="mainFrame">Range Gaji Pertama</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="mhs/mhs_1_20.php" target="mainFrame">Jalur Masuk Mahasiswa</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="karyawan/karyawan_1_1.php" target="mainFrame">Pendidikan</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="karyawan/karyawan_1_2.php" target="mainFrame">Jabatan Akademik</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="karyawan/karyawan_1_3.php" target="mainFrame">Kepangkatan</a> 
    </td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="karyawan/karyawan_1_4.php" target="mainFrame">Jenis Karyawan</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="karyawan/karyawan_1_5.php" target="mainFrame">Jenis Penghargaan</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="karyawan/karyawan_1_6.php" target="mainFrame">Tingkat Penghargaan</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="karyawan/karyawan_1_7.php" target="mainFrame">Kegiatan Dosen</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="karyawan/karyawan_1_8.php" target="mainFrame">Tingkat Rapat</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="penelitian/penelitian_1_10.php" target="mainFrame">Jenis Kerjasama</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="penelitian/penelitian_1_11.php" target="mainFrame">Tipe Kerjasama</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="penelitian/penelitian_1_1.php" target="mainFrame">Status Media 
      Tulisan Ilmiah</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="penelitian/penelitian_1_2.php" target="mainFrame">Sumber Dana</a></td>
  </tr>
  <?php } ?>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="penelitian/penelitian_1_3.php" target="mainFrame">Penerbit</a></td-->
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php if ($hak==100) { ?>
  <tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">DATA MASTER</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="umum/master_user.php" target="mainFrame">Master User</a></td>
  </tr>
  
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="umum/master_mhs.php" target="mainFrame">Master Mahasiswa</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="umum/umum_master_bidang_minat.php" target="mainFrame">Master Bidang Minat</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/lain/master_alumni.php" target="mainFrame">Master Alumni</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="umum/umum_master_mk.php" target="mainFrame">Master Mata Kuliah</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="umum/umum_master_kode_kp.php" target="mainFrame">Master Kode KP</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="umum/umum_mhs_aktif.php" target="mainFrame">Master Mahasiswa Aktif</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="umum/import_master_mhs.php" target="mainFrame">Import Master Mahasiswa</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="umum/umum_master_ruang.php" target="mainFrame">Master Ruang</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="umum/umum_jam_ujian.php" target="mainFrame">Master Jam Ujian</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="umum/umum_master_hari_ujian.php" target="mainFrame">Master Hari Ujian</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="umum/umum_master_penerbit.php" target="mainFrame">Master Penerbit</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="umum/umum_master_tahun_ajaran.php" target="mainFrame">Master Tahun Ajaran</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php } ?>
  <?php if ($hak==100) { ?>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="umum/master_dosen.php" target="mainFrame">Master Dosen</a></td>
  </tr>
  
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td valign="top"><a href="umum/umum_master_riwayat_pendidikan.php" target="mainFrame">Riwayat Pendidikan Dosen</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="umum/umum_propinsi.php" target="mainFrame">Master Propinsi</a> </td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="umum/umum_kota.php" target="mainFrame">Master Kota</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="umum/import_perkuliahan.php" target="mainFrame">Import perkuliahan</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="umum/umum_import_kehadiran_dosen.php" target="mainFrame">Import Rekap Kehadiran</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
  <? }?>
    <!--td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="lab/lab_1_2.php" target="mainFrame">Master Ruang / Lab.</a></td>
  </tr>
  
  <!--
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="penelitian/penelitian_1_8.php" target="mainFrame">Master Pihak Ketiga</a></td>
  </tr>  
 -->
  
  
 
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<?php break;
case 2:
if ($hak>=10)
{
		if (!isset($pilih)) {
		?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F0F9FF"  class="menu_left">
		  <tr>
		    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
                <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=ta" class="menu_left"><font color="#FFFFFF">TA</font></a></font></b></td>
                <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
              </tr>
            </table></td>
	      </tr>
		  <tr>
		    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
                <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=kp" class="menu_left"><font color="#FFFFFF">KP</font></a></font></b></td>
                <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
              </tr>
            </table></td>
	      </tr>
		  <tr>
		    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
                <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=lp" class="menu_left"><font color="#FFFFFF">LP</font></a></font></b></td>
                <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
              </tr>
            </table></td>
	      </tr>
		  <tr>
		    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
                <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=pr" class="menu_left"><font color="#FFFFFF">PRESTASI</font></a></font></b></td>
                <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
              </tr>
            </table></td>
	      </tr>
		  <tr>
		    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
                <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=ln" class="menu_left"><font color="#FFFFFF">LAINNYA</font></a></font></b></td>
                <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
              </tr>
            </table></td>
	      </tr>
		</table>
		<? }?>
<!--###### T A-->
<?php
$pilih = isset( $_GET['pilih'] ) ?  $_GET['pilih'] :  'ta';
 if ($pilih=='ta') { ?>
<table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#F0F9FF"  class="menu_left">
  <tr>
    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
        <td width="171" background="img/main_menu_02.gif"><div align="right"><b><font color="#FFFF00">::: <a href="main_menu.php?menu=2&pilih=ta" class="menu_left"><font color="#FFFF00">TA</font></a></font></b></div></td>
        <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
      </tr>
    </table></td>
  </tr>
  <!-- DETAIL MENU TA -->
  <? if ($hak>=50) {?>
  <tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">ENTRY DATA</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_proses_proposal.php" target="mainFrame">proses proposal</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_proses_kesediaan_pembimbing.php" target="mainFrame">kesedian 
      pembimbing </a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_daftar_penguji.php" target="mainFrame">daftar penguji</a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_input_nilaiTA.php" target="mainFrame">nilai ujian TA </a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_sk_lulus.php" target="mainFrame">SK Lulus S1</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_perpanjangan_ta.php" target="mainFrame">perpanjangan 
      TA</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_ganti_pembimbing_ta.php" target="mainFrame">ganti 
      dosen pembimbing</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_ganti_judul_ta.php" target="mainFrame">ganti judul 
      TA</a></td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <!--LAPORAN-->
  <tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">CETAK</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table>	</td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_cetak_ST_TA.php" target="mainFrame">surat tugas TA</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_cetak_KBim1.php" target="mainFrame">kartu 
      bimbingan 1</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td> <a href="mhs/TA/mhs_cetak_KBim2.php" target="mainFrame">kartu 
      bimbingan 2</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_cetak_SK_dekan_penguji_TA.php" target="mainFrame">SK dekan penguji TA</a> </td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_cetak_lampiran_sk_dekan.php" target="mainFrame">lampiran 
      SK dekan</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_cetak_berita_acara_ujian.php" target="mainFrame">berita 
      acara ujian</a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_cetak_nilai_doji_TA1.php" target="mainFrame">nilai Dosen Penguji TA</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_cetak_surat_ganti_dobing.php" target="mainFrame">surat 
      ganti dosen pembimbing</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_cetak_surat_perpanjangan_ta.php" target="mainFrame">surat 
      perpanjangan TA</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_cetak_surat_gandul_TA.php" target="mainFrame">surat 
      ganti judul TA</a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_cetak_sk_lulus_s1_siska.php" target="mainFrame">sk lulus s1 baru</a></td>
  </tr>
  <!--tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_cetak_sk_lulus_s1_new.php" target="mainFrame">sk lulus s1 baru</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_cetak_sk_lulus_s1_lama.php" target="mainFrame"> sk lulus 
      s1</a>(lama tidak berlaku)</td>
  </tr-->
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <? }?>
  <tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">LAPORAN</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table>	</td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_lap_daftar_mhs_aju_proposal.php" target="mainFrame">mhs yang mengajukan proposal</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_lap_daftar_dobing_dlm_yang_aktif.php" target="mainFrame">mhs bimbingan  dosen dalam per periode</a></td>
  </tr>
  <!--tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_lap_daftar_dobing_dlm_yang_nonaktif.php" target="mainFrame">daftar dosen pembimbing dalam yang non aktif</a></td>
  </tr-->
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_lap_daftar_dobing_luar_yang_aktif.php" target="mainFrame">mhs bimbingan dosen luar per periode</a></td>
  </tr>
  <!--tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_lap_daftar_dobing_luar_yang_nonaktif.php" target="mainFrame">daftar dosen pembimbing luar yang non aktif</a></td>
  </tr-->
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_lap_daftar_dobing_dlm_yang_aktif_dsn.php" target="mainFrame">mhs bimbingan dosen dalam per dosen </a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_lap_daftar_dobing_luar_yang_aktif_dsn.php" target="mainFrame"> mhs bimbingan dosen luar per dosen </a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_lap_daftar_mhs_lulus_ta_blm_lulus_S1.php" target="mainFrame">      mhs yang sudah lulus TA namun blm lulus S1</a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_lap_mhs_yang_TAnya_habis.php" target="mainFrame"> informasi mhs yang TA nya habis</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_lap_informasi_mhs_sedang_TA.php" target="mainFrame">      informasi mhs yang sedang TA</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_lap_informasi_mhs_lulus_TA.php" target="mainFrame">      informasi mhs yang lulus S1</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_lap_cari_TA.php" target="mainFrame">cari data TA mhs</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <!--tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_lap_skripsi.php" target="mainFrame">Export Skripsi </a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/TA/mhs_lap_export_lulus.php" target="mainFrame">Export Kelulusan</a></td>
  </tr-->
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <!--DETAIL MENU TA end-->
  <tr>
    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
        <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=kp" class="menu_left"><font color="#FFFFFF">KP</font></a></font></b></td>
        <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
        <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=lp" class="menu_left"><font color="#FFFFFF">LP</font></a></font></b></td>
        <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
      </tr>
    </table></td>
  </tr>
  		  <tr>
		    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
                <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=pr" class="menu_left"><font color="#FFFFFF">PRESTASI</font></a></font></b></td>
                <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
              </tr>
            </table></td>
	      </tr>
		  <tr>
		    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
                <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=ln" class="menu_left"><font color="#FFFFFF">LAINNYA</font></a></font></b></td>
                <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
              </tr>
            </table></td>
	      </tr>

</table>
<?php } ?>

<!-- ######### K P -->
<?php if ($pilih=='kp') { ?>
<table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#F0F9FF"  class="menu_left">
  <tr>
    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
        <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=ta" class="menu_left"><font color="#FFFFFF">TA</font></a></font></b></td>
        <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
        <td width="171" background="img/main_menu_02.gif"><div align="right"><b><font color="#FFFF00">::: <a href="main_menu.php?menu=2&pilih=kp" class="menu_left"><font color="#FFFF00">KP</font></a></font></b></div></td>
        <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
      </tr>
    </table></td>
  </tr>
  <!-- DETAIL MENU KP -->
  <? if ($hak>=50) {?>
  <tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">ENTRY DATA</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table>	</td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/KP/mhs_mohon_KP.php" target="mainFrame">Permohonan KP</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/KP/mhs_surat_tugas_KP.php" target="mainFrame">Surat Tugas 
      KP</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/KP/mhs_nilai_KP.php" target="mainFrame">Permintaan Nilai 
      KP</a></td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <!--LAPORAN-->
  <tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">CETAK</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table>	</td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/KP/mhs_cetak_mohon_KP.php" target="mainFrame">surat permohonan KP</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/KP/mhs_cetak_ST_KP.php" target="mainFrame">surat tugas KP</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/KP/mhs_cetak_SPENG_nilai_KP.php" target="mainFrame">surat pengantar nilai KP</a></td>
  </tr>
  <tr> 
    <td colspan="2" valign="top">&nbsp;</td>
  </tr>
  <? }?>
  <tr> 
    <td colspan="2" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">LAPORAN</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table>	</td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/KP/lap_mhs_sedang_KP.php" target="mainFrame">daftar mhs sedang KP</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/KP/lap_mhs_slesai_KP.php" target="mainFrame">daftar mhs selesai KP</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/KP/lap_mhs_belum_ada_ST_KP.php" target="mainFrame">mahasiswa yang belum ada surat 
      tugas KP</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/KP/lap_mhs_cari_SP_KP.php" target="mainFrame">Cari no. surat 
      permohonan KP</a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/KP/lap_rekap_KP.php" target="mainFrame">Rekap KP per Dosen</a></td>
  </tr>
  <tr> 
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
        <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=lp" class="menu_left"><font color="#FFFFFF">LP</font></a></font></b></td>
        <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
      </tr>
    </table></td>
  </tr>
  		  <tr>
		    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
                <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=pr" class="menu_left"><font color="#FFFFFF">PRESTASI</font></a></font></b></td>
                <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
              </tr>
            </table></td>
	      </tr>
		  <tr>
		    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
                <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=ln" class="menu_left"><font color="#FFFFFF">LAINNYA</font></a></font></b></td>
                <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
              </tr>
            </table></td>
	      </tr>


  <?php } ?>
  <!--DETAIL MENU KP end-->
</table>
<!--### K P end -->

<!--####### L P -->
<?php if ($pilih=='lp') { ?>
<table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#F0F9FF"  class="menu_left">
  <tr>
    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
        <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=ta" class="menu_left"><font color="#FFFFFF">TA</font></a></font></b></td>
        <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
        <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=kp" class="menu_left"><font color="#FFFFFF">KP</font></a></font></b></td>
        <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
        <td width="171" background="img/main_menu_02.gif"><div align="right"><b><font color="#FFFF00">::: <a href="main_menu.php?menu=2&pilih=lp" class="menu_left"><font color="#FFFF00">LP</font></a></font></b></div></td>
        <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
      </tr>
    </table></td>
  </tr>
  <!-- DETAIL MENU LP -->
  <? if ($hak>=50) {?>
  <tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">ENTRY DATA</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table
	></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/LP/mhs_surat_tugas_LP.php" target="mainFrame">surat tugas Pen.</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/LP/mhs_daftar_penguji_LP.php" target="mainFrame">daftar penguji Pen.</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/LP/mhs_perpanjangan_LP.php" target="mainFrame">perpanjangan Pen.</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/LP/mhs_ganti_pembimbing_LP.php" target="mainFrame">ganti dosen Pen.</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/LP/mhs_ganti_judul_LP.php" target="mainFrame">ganti judul Pen.</a></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <!--LAPORAN-->
  <tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">CETAK</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/LP/mhs_cetak_ST_LP.php" target="mainFrame">surat tugas Pen. </a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/LP/mhs_cetak_SK_dekan_penelitian.php" target="mainFrame">SK Pen. </a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/LP/mhs_cetak_SK_LP.php" target="mainFrame">lampiran SK Pen. </a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/LP/mhs_cetak_berita_acara_LP.php" target="mainFrame">berita acara Pen.</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/LP/mhs_cetak_nilai_dobing_LP.php" target="mainFrame">nilai pembimbing Pen.</a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/LP/mhs_cetak_nilai_doji_LP.php" target="mainFrame">nilai dosen penguji 1 </a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/LP/mhs_cetak_nilai_doji_LP2.php" target="mainFrame">nilai dosen penguji 2</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/LP/mhs_cetak_surat_gandul_LP.php" target="mainFrame">surat 
      ganti judul LP</a></td>
  </tr>  
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/LP/mhs_cetak_surat_ganti_dobing.php" target="mainFrame">surat 
      ganti dosen pembimbing</a></td>
  </tr>
  
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <? }?>
  <tr>
    <td colspan="2" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">LAPORAN</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/LP/mhs_lap_informasi_mhs_sedang_LP.php" target="mainFrame">daftar mhs sedang LP</a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/LP/mhs_lap_informasi_mhs_selesai_LP.php" target="mainFrame">daftar mhs selesai LP</a></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  		  <tr>
		    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
                <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=pr" class="menu_left"><font color="#FFFFFF">PRESTASI</font></a></font></b></td>
                <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
              </tr>
            </table></td>
	      </tr>
		  <tr>
		    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
                <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=ln" class="menu_left"><font color="#FFFFFF">LAINNYA</font></a></font></b></td>
                <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
              </tr>
            </table></td>
	      </tr>


  <?php } ?>
  <!--DETAIL MENU LP end -->
</table>
<!--##### L P end-->

<!--##### PRESTASI begin-->
<?php if ($pilih=='pr') { ?>
<table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#F0F9FF"  class="menu_left">
  <tr>
    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
        <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=ta" class="menu_left"><font color="#FFFFFF">TA</font></a></font></b></td>
        <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
        <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=kp" class="menu_left"><font color="#FFFFFF">KP</font></a></font></b></td>
        <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
        <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=lp" class="menu_left"><font color="#FFFFFF">LP</font></a></font></b></td>
        <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
      </tr>
    </table></td>
  </tr>
    <tr>
    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
        <td width="171" background="img/main_menu_02.gif"><div align="right"><b><font color="#FFFF00">::: <a href="main_menu.php?menu=2&pilih=pr" class="menu_left"><font color="#FFFF00">PRESTASI</font></a></font></b></div></td>
        <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
      </tr>
    </table></td>
  </tr>

  <!-- DETAIL MENU PRESTASI -->
  <? if ($hak>=50) {?>
  <tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">ENTRY DATA</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/Prestasi/prestasi_entry.php" target="mainFrame">Prestasi Mahasiswa</a></td>
  </tr>
  <tr> 
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <? }?>
  <!--LAPORAN-->
  <tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">LAPORAN</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/Prestasi/lap_prestasi_mhs.php" target="mainFrame">Prestasi Mahasiswa</a></td>
  </tr>
  <tr>
		    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
                <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=ln" class="menu_left"><font color="#FFFFFF">LAINNYA</font></a></font></b></td>
                <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
              </tr>
            </table></td>
  </tr>


  <?php } ?>
  <!--DETAIL MENU PRESTASI end -->
</table>
<!--##### PRESTASI end-->

<?php if ($pilih=='ln') { ?>
<table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#F0F9FF"  class="menu_left">
  <tr>
    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
        <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=ta" class="menu_left"><font color="#FFFFFF">TA</font></a></font></b></td>
        <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
        <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=kp" class="menu_left"><font color="#FFFFFF">KP</font></a></font></b></td>
        <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
        <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=lp" class="menu_left"><font color="#FFFFFF">LP</font></a></font></b></td>
        <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
      </tr>
    </table></td>
  </tr>
    <tr>
    <td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
        <td width="171" background="img/main_menu_02.gif"><b><font color="#FFFFFF">:::: <a href="main_menu.php?menu=2&pilih=pr" class="menu_left"><font color="#FFFFFF">PRESTASI</font></a></font></b></td>
        <td><img src="img/main_menu_03.gif" width="14" height="25"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
		<td colspan="2"><table width="100%" height="25"  border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td align="right"><img src="img/main_menu_01.gif" width="15" height="25"></td>
			<td width="171" background="img/main_menu_02.gif"><div align="right"><b><font color="#FFFF00">:::<a href="main_menu.php?menu=2&pilih=ln" class="menu_left"><font color="#FFFF00">LAINNYA</font></a></font></b></div></td>
			<td><img src="img/main_menu_03.gif" width="14" height="25"></td>
		  </tr>
		</table></td>
  </tr>

  <!-- DETAIL MENU PRESTASI -->
  <tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">ENTRY DATA</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table
	></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/lain/master_alumni.php" target="mainFrame">Master Alumni</a></td>
  </tr>
  <tr> 
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/lain/jum_maharu.php" target="mainFrame">Master Maharu </a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/lain/rasio_do_mhs.php" target="mainFrame">Master Mhs DO </a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/lain/rasio_po_mhs.php" target="mainFrame">Master Mhs PO</a></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <!--LAPORAN-->
  <tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">LAPORAN</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/lain/lap_alumni.php" target="mainFrame">Laporan Alumni</a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/lain/lap_maharu.php" target="mainFrame">Laporan Maharu</a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/lain/lap_mhs_do.php" target="mainFrame">Laporan Mhs DO </a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="mhs/lain/lap_mhs_po.php" target="mainFrame">Laporan Mhs PO </a></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <?php } ?>
  <!--DETAIL MENU PRESTASI end -->
</table>


<?php
}
break;
case 3 :
?>
<table width="100%" border="0" cellpadding="0" cellspacing="2"  class="menu_left">
 
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>

 <?php if ($hak>=50) { ?>
 
  <tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif" class="style6">ENTRY DATA </td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table>	</td>
  </tr>

  <tr> 
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="dosen/penelitian_dosen_entry.php" target="mainFrame">Penelitian Dosen</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="dosen/pengabdian_entry.php" target="mainFrame">Pengabdian Masyarakat</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="dosen/tugas_lembaga_entry.php" target="mainFrame">Tugas Kelembagaan</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="dosen/pen_st_publikasi_entry.php" target="mainFrame">Surat Tugas Publikasi</a></td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
 <?php } ?>
 
 <tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">LAPORAN</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table>	</td>
  </tr>

  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="dosen/lap_penelitian_dosen.php" target="mainFrame">Penelitian Dosen</a></td>
  </tr>
  <!--tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="mhs/mhs_2_5.php" target="mainFrame">Lesson Plan</a></td>
  </tr-->
  <tr>
	<td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="dosen/lap_pengabdian.php" target="mainFrame">Pengabdian Masyarakat</a></td>  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="dosen/lap_tugas_lembaga.php" target="mainFrame">Tugas Kelembagaan</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="dosen/lap_riwayat_didik_dosen.php" target="mainFrame">Riwayat Pendidikan</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="dosen/lap_publikasi.php" target="mainFrame">Publikasi</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="dosen/lap_profil_dosen.php" target="mainFrame">Profil Dosen</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="dosen/lap_riwayat_jabatan_akademik.php" target="mainFrame">Jabatan Akademik</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="dosen/score_card_dosen.php" target="mainFrame">Score Card</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php if ($hak>=50) { ?>
   <tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">CETAK</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="dosen/pen_cetak_ST_publikasi.php" target="mainFrame">Surat Tugas Publikasi</a></td>
  </tr>
  <? }?>
</table>

<?php
break;
//case 0 :
case 4 :
?>
<table width="100%" border="0" cellpadding="0" cellspacing="2"  class="menu_left">
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php if ($hak>=50) { ?>
  		<tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">ENTRY DATA</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table>	</td>
  </tr>

  <tr> 
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="kuliah/kul_rekap_lulus_mk.php" target="mainFrame">Rekap Kelulusan MK</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php } ?>
  <tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">LAPORAN</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table>	</td>
  </tr>
  <tr> 
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="kuliah/lap_jadwal_kuliah.php" target="mainFrame">Jadwal Kuliah</a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="kuliah/lap_jadwal_ujian.php" target="mainFrame">Jadwal Ujian</a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="kuliah/lap_hadir_dsn.php" target="mainFrame">Kehadiran Dosen</a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="kuliah/lap_usul_dsn.php" target="mainFrame">Usulan Dosen</a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="kuliah/lap_fas_ruang.php" target="mainFrame">Fasilitas Ruang</a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="kuliah/lap_rekap_dsn.php" target="mainFrame">Rekap Dosen </a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="kuliah/lap_rekap_lulus_mk.php" target="mainFrame">Rekap Kelulusan MK</a></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php break;
case 5:
?>
<table width="100%" border="0" cellpadding="0" cellspacing="2"  class="menu_left">
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php if ($hak>=50) { ?>
  		<tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">ENTRY DATA</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table>	</td>
  </tr>

  <tr> 
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="kerjasama/profil_kerjasama_entry.php" target="mainFrame">Profil Kerjasama</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php } ?>
  <tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">LAPORAN</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table>	</td>
  </tr>
  <tr> 
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="kerjasama/lap_profil_kerjasama.php" target="mainFrame">Profil kerjasama</a></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
break;

case 6:
?>
<table width="100%" border="0" cellpadding="0" cellspacing="2"  class="menu_left">
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php if ($hak>=50) { ?>
  		<tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">ENTRY DATA</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table>	</td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="scard/grant_prodi.php" target="mainFrame">Grant Prodi</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="scard/sc_fak.php" target="mainFrame">Target scard Fakultas</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="scard/sc_jur.php" target="mainFrame">Target scard Jurusan</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="scard/sc_lab.php" target="mainFrame">Target scard Laboratorium </a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="scard/sc_personal.php" target="mainFrame">Target scard Personal </a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="scard/sc_index_belajar.php" target="mainFrame">Index Pembelajaran</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="scard/sc_revenue.php" target="mainFrame">Revenue</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="scard/sc_dr_cost.php" target="mainFrame">Direct Cost</a></td>
  </tr>
  <tr>
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="scard/sc_revenue_3darma.php" target="mainFrame">revenue tri-dharma</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php } ?>
  <tr> 
    <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><img src="img/head_menu_01.gif" width="7" height="21"></td>
        <td width="85%" nowrap background="img/head_menu_02.gif"><span class="style6">LAPORAN</span></td>
        <td width="14%" nowrap><img src="img/head_menu_03.gif" width="7" height="21"></td>
      </tr>
    </table>	</td>
  </tr>
  <tr> 
    <td><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="scard/view_scard_fakultas.php" target="mainFrame">Score card Fakultas</a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="scard/view_scard_jurusan.php" target="mainFrame">Score card Jurusan</a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="scard/view_scard_lab.php" target="mainFrame">Score card Laboratorium</a></td>
  </tr>
  <tr>
    <td valign="top"><img src="img/0200_small%20arrow%20in%20box.png" width="12" height="12"></td>
    <td><a href="scard/view_scard_personal.php" target="mainFrame">Score card Personal</a></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?php
break;

case 7:
?>
<table width="100%" border="0" cellpadding="0" cellspacing="2"  class="menu_left">
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
   <?php if ($hak>=50) { ?>
  <tr> 
    <td colspan="2" bgcolor="#003366"><font color="#FFFFFF"><strong>Entry Data</strong></font></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="lab/lab_1_3.php" target="mainFrame">Master Type Alat</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="lab/lab_1_4.php" target="mainFrame">Alat Laboratorium</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="lab/lab_1_5.php" target="mainFrame">Koreksi&amp;Hapus Alat</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="lab/lab_1_6.php" target="mainFrame">Perbaikan Alat</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="lab/lab_1_7.php" target="mainFrame">Pemindahan Alat</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="lab/lab_1_8.php" target="mainFrame">Pemakaian Lab</a></td>
  </tr>
  <!--
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td>Pemakaian Alat</td>
  </tr>
  -->
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php } ?>
  <tr> 
    <td colspan="2" bgcolor="#003366"><font color="#FFFFFF"><strong>Laporan</strong></font></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="lab/lab_2_1.php" target="mainFrame">Master Ruang / Lab.</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="lab/lab_2_3.php" target="mainFrame">Alat Laboratorium</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="lab/lab_2_4.php" target="mainFrame">Perbaikan Alat</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="lab/lab_2_5.php" target="mainFrame">Pemindahan Alat</a></td>
  </tr>
  <tr> 
    <td><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="lab/lab_2_6.php" target="mainFrame">Pemakaian Alat</a></td>
  </tr>
  <tr> 
    <td valign="top"><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="lab/lab_2_7.php" target="mainFrame">Pemakaian Lab Tidak Rutin</a></td>
  </tr>
  <!--
  <tr> 
    <td valign="top"><img src="img/menu.gif" width="9" height="12"></td>
    <td><a href="lab/lab_2_8.php" target="mainFrame">Pemakaian Lab Rutin</a></td>
  </tr>
	  -->
</table>
<?php
break;
 } ?>
</body>
</html>
