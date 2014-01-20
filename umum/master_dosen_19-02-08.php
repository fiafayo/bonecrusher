<?php
/* 
   HISTORY      : 
       
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
	if (($frm_kode=='') or ($frm_nama=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi kode dan nama dosen/karyawan. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// kodetidak ada, berarti tambah baru
			if ($frm_id=='') 
				{
					$result = mysql_query("INSERT INTO master_karyawan ( `id` , `kode` , `nip` , `jurusan` ,`nama` , `alamat` , `sex` , `id_tempat_lahir` , `tanggal_lahir` , `tanggal_masuk` , `tanggal_keluar` , `pendidikan` , `id_jabatan` , `id_pangkat` , `tanggal_pengangkatan` ,`id_jabatan_kopertis` , `id_pangkat_kopertis` , `tanggal_pengangkatan_kopertis` , `id_jenis` , `bidang_keahlian` , `status_pernikahan` , `jumlah_anak` ) VALUES ( '', '".$frm_kode."', '".$frm_nip."', '".$frm_jurusan."', '".$frm_nama."', '".$frm_alamat."', '".$frm_sex."', '', '".$frm_tanggal_lahir."', '".$frm_tanggal_masuk."', '".$frm_tanggal_keluar."', '".$frm_pendidikan."', '".$frm_id_jabatan."', '".$frm_id_pangkat."', '".$frm_tanggal_pengangkatan."', '".$frm_id_jabatan_kopertis."', '".$frm_id_pangkat_kopertis."', '".$frm_tanggal_pengangkatan_kopertis."', '".$frm_id_jenis."', '".$frm_bidang_keahlian."', '".$frm_status_pernikahan."', '".$frm_jumlah_anak."') " );
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah ditambahkan";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data";
						}
						$id_karyawan=mysql_insert_id();
$result = mysql_query("INSERT INTO histori_pangkat( `id` ,`id_karyawan` , `tanggal_pengangkatan` , `id_jabatan` , `id_pangkat` ) VALUES ( '', '".$id_karyawan."', '".$frm_tanggal_pengangkatan."', '".$frm_id_jabatan."', '".$frm_id_pangkat."') " );
					if ($result) 
						{
							$pesan = $pesan."$id<br>Data kepangkatan lokal telah ditambahkan";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data kepangkatan lokal";
						}
$result = mysql_query("INSERT INTO histori_pangkat_kopertis( `id` ,`id_karyawan` , `tanggal_pengangkatan` , `id_jabatan` , `id_pangkat` ) VALUES ( '', '".$id_karyawan."', '".$frm_tanggal_pengangkatan_kopertis."', '".$frm_id_jabatan_kopertis."', '".$frm_id_pangkat_kopertis."') " );
					if ($result) 
						{
							$pesan = $pesan."$id<br>Data kepangkatan kopertis telah ditambahkan";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data kepangkatan kopertis";
						}
						
						
				}
			else
				{

	// mengubah data yang sudah ada --> id ada
	//				$result = mysql_query("UPDATE master_karyawan set `kode`='$frm_kode' , `nip`='$frm_nip' , `nama`='$frm_nama' , `jurusan`='$frm_jurusan' , `alamat`='$frm_alamat' , `sex`='$frm_sex' , `id_tempat_lahir`='' , `tanggal_lahir`='$frm_tanggal_lahir' , `tanggal_masuk`='$frm_tanggal_masuk' , `tanggal_keluar`='$frm_tanggal_keluar' , `pendidikan`='$frm_pendidikan' , `id_jabatan`='$frm_id_jabatan' , `id_pangkat`='$frm_id_pangkat' , `tanggal_pengangkatan`='$frm_tanggal_pengangkatan' , `id_jenis`='$frm_id_jenis' , `bidang_keahlian`='$frm_bidang_keahlian' , `status_pernikahan`='$frm_status_pernikahan' , `jumlah_anak`='$frm_jumlah_anak' where `id`=$frm_id");
					$result = mysql_query("UPDATE master_karyawan set `kode`='$frm_kode' , `nip`='$frm_nip' , `nama`='$frm_nama' , `jurusan`='$frm_jurusan' , `alamat`='$frm_alamat' , `sex`='$frm_sex' , `id_tempat_lahir`='' , `tanggal_lahir`='$frm_tanggal_lahir' , `tanggal_masuk`='$frm_tanggal_masuk' , `tanggal_keluar`='$frm_tanggal_keluar' , `pendidikan`='$frm_pendidikan' , `id_jabatan`='$frm_id_jabatan' , `id_pangkat`='$frm_id_pangkat' , `id_jenis`='$frm_id_jenis' , `bidang_keahlian`='$frm_bidang_keahlian' , `status_pernikahan`='$frm_status_pernikahan' , `jumlah_anak`='$frm_jumlah_anak' where `id`=$frm_id");

	
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menyimpan data";
						}
				}
		}
	}


if ($act==2) { // hapus data

$result = mysql_query("delete from master_karyawan where id = ".$frm_id);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
	
if (($act!=0)and($error!=1)) {
	$frm_id="";
	$frm_kode = "";
	$frm_nip = "";
	$frm_jurusan = "0";
	$frm_nama = "";
	$frm_alamat ="";
	$frm_sex ="";
	$frm_id_tempat_lahir ="";
	$frm_tanggal_lahir ="";
	$frm_tanggal_masuk ="";
	$frm_tanggal_keluar ="";
	$frm_pendidikan = "";
	$frm_id_jabatan = "";
	$frm_id_pangkat = "";
	$frm_tanggal_pengangkatan ="";
	
	$frm_id_jabatan_kopertis = "";
	$frm_id_pangkat_kopertis = "";
	$frm_tanggal_pengangkatan_kopertis ="";
	$frm_id_jenis = "";
	$frm_bidang_keahlian="";
	$frm_status_pernikahan = "";
	$frm_jumlah_anak="";

}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_kode!='')  {
$result = mysql_query("Select id, 
							  kode, 
							  nip, 
							  jurusan, 
							  nama, 
							  alamat, 
							  sex, 
							  id_tempat_lahir, 
							  DATE_FORMAT(tanggal_lahir,'%d/%m/%Y') as tanggal_lahir, 
							  DATE_FORMAT(tanggal_masuk,'%d/%m/%Y') as tanggal_masuk, 
							  DATE_FORMAT(tanggal_keluar,'%d/%m/%Y') as tanggal_keluar,
							  pendidikan,
							  id_jabatan, 
							  id_pangkat, 
							  DATE_FORMAT(tanggal_pengangkatan,'%d/%m/%Y') as tanggal_pengangkatan,
							  id_jabatan_kopertis, 
							  id_pangkat_kopertis, 
							  DATE_FORMAT(tanggal_pengangkatan_kopertis,'%d/%m/%Y') as tanggal_pengangkatan_kopertis, 
							  id_jenis, 
							  bidang_keahlian, 
							  status_pernikahan, 
							  jumlah_anak 
					  from master_karyawan where kode='$frm_kode'");

$row = mysql_fetch_array($result);
	$frm_id = $row["id"];
	$frm_nip = $row["nip"];
	$frm_jurusan = $row["jurusan"];
	
	$frm_nama = $row["nama"];
	$frm_alamat =$row["alamat"];
	$frm_sex =$row["sex"];
	$frm_id_tempat_lahir =$row["id_tempat_lahir"];
	
	if ($row["tanggal_lahir"]=="00/00/0000") {
	$frm_tanggal_lahir =""; }else {
	$frm_tanggal_lahir =$row["tanggal_lahir"];}
	
	if ($row["tanggal_masuk"]=="00/00/0000") {
	$frm_tanggal_masuk =""; }else {
	$frm_tanggal_masuk =$row["tanggal_masuk"]; }
	
	if ($row["tanggal_keluar"]=="00/00/0000") {
	$frm_tanggal_keluar =""; }else {
	$frm_tanggal_keluar =$row["tanggal_keluar"]; }
	
	$frm_pendidikan = $row["pendidikan"];
	$frm_id_jabatan = $row["id_jabatan"];
	$frm_id_pangkat = $row["id_pangkat"];
	
	if ($row["tanggal_pengangkatan"]=="00/00/0000") {
	$frm_tanggal_pengangkatan =""; }else {
	$frm_tanggal_pengangkatan =$row["tanggal_pengangkatan"]; }
	
	
	$frm_id_jabatan_kopertis = $row["id_jabatan_kopertis"];
	$frm_id_pangkat_kopertis = $row["id_pangkat_kopertis"];
	
	if ($row["tanggal_pengangkatan_kopertis"]=="00/00/0000") {
	$frm_tanggal_pengangkatan_kopertis =""; }else {
	$frm_tanggal_pengangkatan_kopertis =$row["tanggal_pengangkatan_kopertis"]; }
	
	
	$frm_id_jenis = $row["id_jenis"];
	$frm_bidang_keahlian=$row["bidang_keahlian"];
	$frm_status_pernikahan = $row["status_pernikahan"];
	$frm_jumlah_anak=$row["jumlah_anak"];


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
<form name="karyawan" id="karyawan" action="master_dosen.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="3"><img src="spacer" height="1"></td>
    </tr>
    <tr> 
      <td colspan="3"><font color="#FF0000"><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="3"> 
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
      <td width="2%">&nbsp;</td>
      <td width="73%">&nbsp; <input type="hidden" name="frm_id" value="<?php echo $frm_id;?>"></td>
    </tr>
    <tr> 
      <td>Kode Karyawan <span class="style1">*</span></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_kode" type="text" class="tekboxku" id="frm_kode" size="10" maxlength="10" value="<?php echo $frm_kode; ?>" onBlur="document.karyawan.submit()" ></td>
    </tr>
    <tr> 
      <td>NIP </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nip" type="text" class="tekboxku" id="frm_nip" value="<?php echo $frm_nip; ?>" size="10" maxlength="10"></td>
    </tr>
    <tr> 
      <td>Jurusan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_jurusan" id="frm_jurusan" class="tekboxku">
	  <option <?php if ($frm_jurusan==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sql_jurusan="SELECT * FROM jurusan WHERE id>0 AND id<6";
				$result = @mysql_query($sql_jurusan);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->id; ?>" <?php if ($frm_jurusan==$row->id) { echo "selected"; }?> > <?php echo $row->jurusan; ?></option>
          <?php
				}
				?>
      </select> 
	  </td>
    </tr>
    <tr> 
      <td>Nama Karyawan <span class="style1">*</span></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nama" type="text" class="tekboxku" id="frm_nama" value="<?php echo $frm_nama; ?>" size="50" maxlength="50"></td>
    </tr>
    <tr>
      <td>Jenis Kelamin</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_sex" id="frm_sex" class="tekboxku" type="radio" value="L" <?php if ($frm_sex=='L') { echo "checked"; }?>>
Laki-laki
  <input type="radio" name="frm_sex" id="frm_sex" class="tekboxku" value="P" <?php if (($frm_sex=='P')or($frm_sex=='')) { echo "checked"; }?>>
Perempuan</td>
    </tr>
    <tr> 
      <td>Alamat</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_alamat" id="frm_alamat" type="text" class="tekboxku" value="<?php echo $frm_alamat; ?>" size="50" maxlength="100"></td>
    </tr>
    <tr>
      <td>No. Telepon</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_telp" id="frm_telp" type="text" class="tekboxku" value="<?php echo $frm_telp; ?>" size="50" maxlength="100"></td>
    </tr>
    <tr> 
      <td>No. KTP </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_no_ktp" id="frm_no_ktp" type="text" class="tekboxku" value="<?php echo $frm_no_ktp; ?>" size="50" maxlength="100"></td>
    </tr>
    <tr> 
      <td>Status Pernikahan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input type="radio" name="frm_status_pernikahan" id="frm_status_pernikahan" class="tekboxku" value="M" <?php if ($frm_status_pernikahan=='M') { echo "checked"; }?>>
        Menikah 
        <input type="radio" name="frm_status_pernikahan" id="frm_status_pernikahan" class="tekboxku" value="B" <?php if (($frm_status_pernikahan=='B') || ($frm_status_pernikahan=='')) { echo "checked"; }?>>
        Belum/Tidak Menikah</td>
    </tr>
    <tr> 
      <td>Jumlah Anak</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_jumlah_anak" type="text" id="frm_jumlah_anak" class="tekboxku" size="2" maxlength="2"value="<?php echo $frm_jumlah_anak; ?>"></td>
    </tr>
    <tr>
      <td>Tempat Lahir</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tempat_lahir" type="text" class="tekboxku" id="frm_tempat_lahir" value="<?php echo $frm_tempat_lahir; ?>" size="30" maxlength="50"></td>
    </tr>
    <tr> 
      <td>Tanggal Lahir </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tanggal_lahir" type="text" id="frm_tanggal_lahir" size="10" maxlength="10" value="<?php echo $frm_tanggal_lahir; ?>" class="tekboxku"> 
        <A Href="javascript:show_calendar('karyawan.frm_tanggal_lahir',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="bottom" border=0> 
        </A>(dd/mm/yyyy) </td>
    </tr>
    <tr> 
      <td>Tanggal Masuk </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tanggal_masuk" type="text" id="frm_tanggal_masuk" size="10" maxlength="10" value="<?php echo $frm_tanggal_masuk; ?>" class="tekboxku"> 
        <A Href="javascript:show_calendar('karyawan.frm_tanggal_masuk',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="bottom" border=0> 
        </A>(dd/mm/yyyy) </td>
    </tr>
    <tr> 
      <td>Pendidikan Terakhir</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_pendidikan" id="frm_pendidikan" class="tekboxku" >
			<?php
			$result1 = @mysql_query("SELECT id, nama FROM pendidikan");
			$c=0;
				while ($row1=@mysql_fetch_object($result1))  {
				$c=$c+1;
				?>
				<option value="<?php echo $row1->id; ?>" <?php if (($frm_pendidikan==$row1->id) or (($frm_pendidikan=='') and ($c==1))) { echo "selected"; }?> ><?php echo $row1->nama; ?></option>
			<?php
			}
			?>
        </select></td>
    </tr>
    <tr> 
      <td>Jabatan Akademik Lokal Terakhir <span class="style1">*</span></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> 
        <?php if ($frm_id!='') { 
	  
	  //$result1 = @mysql_query("Select id, nama from jabatan_akademik where id='".$frm_id_jabatan."'");
		///if ($row1=@mysql_fetch_object($result1)) {
		//	echo $row1->nama;
		//	}
		?>
        <?php 
		//}else{ 
			?>
        <select name="frm_id_jabatan" id="frm_id_jabatan" class="tekboxku">
          <?php
			$result1 = @mysql_query("Select id, nama from jabatan_akademik");
			$c=0;
			while ($row1=@mysql_fetch_object($result1))  {
			$c=$c+1;
			?>
          <option value="<?php echo $row1->id; ?>" <?php if (($frm_id_jabatan==$row1->id) or (($frm_id_jabatan=='')and($c==1)) ) { echo "selected"; }?>  ><?php echo $row1->nama; ?></option>
          <?php
		}
	?>
        </select> 
        <?php } ?>
      </td>
    </tr>
    <tr> 
      <td>Pangkat Lokal Terakhir</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> 
        <?php if ($frm_id!='') { 
	  
	 //$result1 = @mysql_query("Select id, nama from kepangkatan where id='".$frm_id_pangkat."'");
		//if ($row1=@mysql_fetch_object($result1)) {
		//echo $row1->nama; }
	  ?>
        <?php //}else{ 
	  ?>
        <select name="frm_id_pangkat" id="frm_id_pangkat" class="tekboxku">
          <?php
			$result1 = @mysql_query("Select id, nama from kepangkatan");
			$c=0;
			while ($row1=@mysql_fetch_object($result1))  {
			$c=$c+1;
			?>
          <option value="<?php echo $row1->id; ?>" <?php if (($frm_id_pangkat==$row1->id)or (($frm_id_pangkat=='') and ($c==1))) { echo "selected"; }?>  ><?php echo $row1->nama; ?></option>
          <?php
			}
	?>
        </select> 
        <?php } ?>
      </td>
    </tr>
    <tr> 
      <td>Tgl Pengangkatan Lokal Terakhir</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> 
        <?php if ($frm_id!='') { 
	  echo $frm_tanggal_pengangkatan; ?>
        <?php }else{ 
	  ?>
        <input type="text" name="frm_tanggal_pengangkatan" id="frm_tanggal_pengangkatan" size="10" maxlength="10" class="tekboxku"> 
        <A Href="javascript:show_calendar('karyawan.frm_tanggal_pengangkatan',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="bottom" border=0> 
        </A>(dd/mm/yyyy) 
        <?php } ?>
      </td>
    </tr>
    <tr> 
      <td nowrap>Jabatan Akademik Kopertis Terakhir</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> 
        <?php if ($frm_id!='') { 
	  
	  $result1 = @mysql_query("Select id, nama from jabatan_akademik where id='".$frm_id_jabatan_kopertis."'");
		if ($row1=@mysql_fetch_object($result1)) {
		echo $row1->nama;
		}
	  ?>
        <?php }else{ 
	  ?>
        <select name="frm_id_jabatan_kopertis" id="frm_id_jabatan_kopertis" class="tekboxku" >
          <?php
	$result1 = @mysql_query("Select id, nama from jabatan_akademik");
	$c=0;
	while ($row1=@mysql_fetch_object($result1))  {
	$c=$c+1;
	?>
          <option value="<?php echo $row1->id; ?>" <?php if (($frm_id_jabatan_kopertis==$row1->id) or (($frm_id_jabatan_kopertis=='')and($c==1)) ) { echo "selected"; }?>  ><?php echo $row1->nama; ?></option>
          <?php
	}
	?>
        </select> 
        <?php } ?>
      </td>
    </tr>
    <tr> 
      <td>Pangkat Kopertis Terakhir</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> 
        <?php if ($frm_id!='') { 
	  
	  $result1 = @mysql_query("Select id, nama from kepangkatan where id='".$frm_id_pangkat_kopertis."'");
		if ($row1=@mysql_fetch_object($result1)) {
		echo $row1->nama; }
	  ?>
        <?php }else{ 
	  ?>
        <select name="frm_id_pangkat_kopertis" id="frm_id_pangkat_kopertis" class="tekboxku">
          <?php
	$result1 = @mysql_query("Select id, nama from kepangkatan");
	$c=0;
	while ($row1=@mysql_fetch_object($result1))  {
	$c=$c+1;
	?>
          <option value="<?php echo $row1->id; ?>" <?php if (($frm_id_pangkat_kopertis==$row1->id)or (($frm_id_pangkat_kopertis=='') and ($c==1))) { echo "selected"; }?>  ><?php echo $row1->nama; ?></option>
          <?php
	}
	
	
	?>
        </select> 
        <?php } ?>
      </td>
    </tr>
    <tr> 
      <td nowrap>Tgl Pengangkatan Kopertis Terakhir</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> 
        <?php if ($frm_id!='') { 
	  echo $frm_tanggal_pengangkatan_kopertis; ?>
        <?php }else{ 
	  ?>
        <input type="text" name="frm_tanggal_pengangkatan_kopertis" id="frm_tanggal_pengangkatan_kopertis" class="tekboxku" size="10" maxlength="10" > 
        <A Href="javascript:show_calendar('karyawan.frm_tanggal_pengangkatan_kopertis',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="bottom" border=0> 
        </A>(dd/mm/yyyy) 
        <?php } ?>
      </td>
    </tr>
    <tr> 
      <td>Jenis Karyawan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_id_jenis" id="frm_id_jenis" class="tekboxku">
          <?php
		  $c=0;
	$result1 = @mysql_query("Select id, nama, kategori from karyawan_jenis_karyawan");
	while ($row1=@mysql_fetch_object($result1))  {
	$c=$c+1;
	?>
          <option value="<?php echo $row1->id; ?>" <?php if (($frm_id_jenis==$row1->id)or(($frm_id_jenis=='')and($c==1))) { echo "selected"; }?> ><?php echo $row1->kategori; ?> 
          - <?php echo $row1->nama; ?></option>
          <?php
	}
	?>
        </select></td>
    </tr>
    <tr> 
      <td valign="top">Bidang Keahlian</td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td valign="top"><textarea name="frm_bidang_keahlian" cols="60" rows="2" class="tekboxku" id="frm_bidang_keahlian"><?php echo $frm_bidang_keahlian; ?></textarea></td>
    </tr>
    <tr> 
      <td>Tanggal Keluar</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input type="text" name="frm_tanggal_keluar" id="frm_tanggal_keluar" class="tekboxku" size="10" maxlength="10" value="<?php echo $frm_tanggal_keluar; ?>"> 
        <A Href="javascript:show_calendar('karyawan.frm_tanggal_keluar',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="bottom" border=0> 
        </A>(dd/mm/yyyy) </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
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
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="3"><font size="1"><span class="style1">*</span> = compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>