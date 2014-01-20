<?php
/* 
   DATE CREATED : 30/05/07
   KEGUNAAN     : EDIT DATA MASTER RIWAYAT PENDIDIKAN
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
	/*if ($frm_tanggal_lahir!='') 
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
		}*/

// Kode dan nama harus diisi
	if (($frm_kode_dsn=='') or ($frm_nama=='') or ($frm_s_jurusan=='pilih') or ($frm_jenjang=='pilih') or ($frm_univ=='') or ($frm_prodi=='') or ($frm_sumber_dana=='') or ($frm_tahun_selesai=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data Riwayat Pendidikan dengan benar. Gagal menyimpan data.";
		}
		
	echo "<br>frm_kode_dsn=".$frm_kode_dsn;
					echo "<br>frm_nama=".$frm_nama;
					echo "<br>frm_s_jurusan=".$frm_s_jurusan;
					echo "<br>frm_jenjang=".$frm_jenjang;
					echo "<br>frm_univ=".$frm_univ;
					echo "<br>frm_prodi=".$frm_prodi;
					echo "<br>frm_sumber_dana=".$frm_sumber_dana;
					echo "<br>frm_tahun_selesai=".$frm_tahun_selesai;

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_nama!='') 
				{
					$result = mysql_query("INSERT INTO riwayat_pendidikan(`id_riwayat`, `kode_dosen`, `jurusan`, `jenjang`, `universitas`, `prodi`, `sumber_dana`, `tahun_selesai`) VALUES ( NULL, '".$frm_kode_dsn."', '".$frm_s_jurusan."', '".$frm_jenjang."', '".$frm_univ."','".$frm_prodi."', '".$frm_sumber_dana."', '".$frm_tahun_selesai."')");
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah ditambahkan";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data";
						}
				}
			else
				{
					$result = mysql_query("UPDATE riwayat_pendidikan set `kode_dosen`='$frm_kode_dsn', 
																		 `jurusan` = '$frm_s_jurusan',
																		 `jenjang` = '$frm_jenjang',
																		 `universitas` = '$frm_univ',
																		 `prodi` = '$frm_prodi',
																		 `sumber_dana` = '$frm_sumber_dana', 
																		 `tahun_selesai` ='$frm_tahun_selesai'
																   where `nrp`=$frm_nrp");
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
$result = mysql_query("DELETE FROM riwayat_pendidikan WHERE nrp = ".$frm_nrp);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	$frm_kode_dsn="";
	$frm_nama="";
	$frm_prodi="";
	$frm_s_jurusan="";
	$frm_jenjang="";
	$frm_univ="";
	$frm_sumber_dana="";
	$frm_tahun_selesai="";
}
else
{
// Jika user mengisi form NRP, di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_kode_dsn!='')  {
$result_dsn=mysql_query("SELECT kode, nama 
						 FROM dosen
						 WHERE kode='$frm_kode_dsn'");
if ($row_dsn = mysql_fetch_array($result_dsn)) {
$frm_nama=$row_dsn["nama"];

}
	 
$result = mysql_query(" SELECT	riwayat_pendidikan.id_riwayat,
								riwayat_pendidikan.kode_dosen,
								riwayat_pendidikan.jurusan,
								riwayat_pendidikan.jenjang,
								riwayat_pendidikan.universitas,
								riwayat_pendidikan.prodi,
								riwayat_pendidikan.sumber_dana,
								riwayat_pendidikan.tahun_selesai,
								dosen.nama
						FROM riwayat_pendidikan, dosen
						WHERE riwayat_pendidikan.kode_dosen=dosen.kode AND
						      riwayat_pendidikan.kode_dosen='$frm_kode_dsn' AND
						      riwayat_pendidikan.jenjang='$frm_jenjang'");

						if ($row = mysql_fetch_array($result)) {
							$frm_exist=1;
							$frm_kode_dsn=$row["kode_dosen"];
							$frm_nama=$row["nama"];
							$frm_s_jurusan=$row["jurusan"];
							$frm_jenjang=$row["jenjang"];
							$frm_univ=$row["universitas"];
							$frm_prodi=$row["prodi"];
							$frm_sumber_dana=$row["sumber_dana"];
							$frm_tahun_selesai=$row["tahun_selesai"];			
						}else
						{
							$frm_exist=0;
							$frm_s_jurusan="";
							$frm_prodi="";
							$frm_jenjang="";
							$frm_univ="";
							$frm_sumber_dana="";
							$frm_tahun_selesai="";
						 }
	
}

/*if ($frm_id_kota_asal!='') {
$result = mysql_query("Select kode_area from kota where id='$frm_id_kota_asal'");
$row = mysql_fetch_array($result);
$frm_kode_area_asal = $row["kode_area"];

}	*/

/*if ($frm_id_kota_ortu!='') {
$result = mysql_query("Select kode_area from kota where id_kota='$frm_id_kota_ortu'");
$row = mysql_fetch_array($result);
$frm_kode_area_ortu = $row["kode_area"];

}	*/

}

?>
<html>
<head>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<script language="JavaScript" src="../include/tanggalan.js">
</script>
<body class="body">
<form name="umum_riwayat_pendidikan_dosen" id="umum_riwayat_pendidikan_dosen" action="umum_master_riwayat_pendidikan.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><img src="spacer" height="1"></td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4"> <hr size="1" color="#FF9900"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>ENTRY 
              DATA ~</strong> MASTER RIWAYAT PENDIDIKAN DOSEN </font></font> </td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="15%">&nbsp;</td> 
      <td width="15%">&nbsp;</td>
      <td width="3%">&nbsp;</td>
      <td width="83%"><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Jenjang</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_jenjang" class="tekboxku" id="frm_jenjang">
        <option value="pilih" selected>--- pilih ---</option>
        <option value="s2" <? if ($frm_jenjang=='s2'){ echo "selected";}?>>S-2</option>
        <option value="s3" <? if ($frm_jenjang=='s3'){ echo "selected";}?>>S-3</option>
      </select>
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>NPK Dosen </td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td>
	  <input name="frm_kode_dsn" type="text" class="tekboxku" id="frm_kode_dsn" onBlur="document.umum_riwayat_pendidikan_dosen.submit()" value="<?php echo $frm_kode_dsn; ?>" size="10" maxlength="10">
      <span class="style1">* <? if (isset($frm_kode_dsn)) echo $frm_nama;?></span>
	  <input name="frm_nama" type="hidden" id="frm_nama"  value="<?php echo $frm_nama; ?>">
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Jurusan </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <? //echo "frm_s_jurusan=".$frm_s_jurusan;?>
	  <select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku">
	  <option <?php if ($frm_s_jurusan==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sql_jurusan="SELECT * FROM jurusan WHERE id>0 AND id<6";
				$result = @mysql_query($sql_jurusan);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->id; ?>" <?php if ($frm_s_jurusan==$row->id) { echo "selected"; }?> > <?php echo $row->jurusan; ?></option>
          <?php
				}
				?>
      </select>         <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Universitas</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_univ" id="frm_univ" type="text" class="tekboxku" size="50" maxlength="255" value="<? echo $frm_univ;?>">
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td> 
      <td valign="top">Program Studi </td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><textarea name="frm_prodi" id="frm_prodi" cols="50" rows="3" class="tekboxku"><? echo $frm_prodi;?></textarea>
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Sumber Dana </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_sumber_dana" id="frm_sumber_dana" type="text" class="tekboxku" size="50" maxlength="255" value="<? echo $frm_sumber_dana;?>">
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tahun Selesai </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tahun_selesai" id="frm_tahun_selesai" type="text" class="tekboxku" size="8" maxlength="4" value="<? echo $frm_tahun_selesai;?>">
      <span class="style1">*</span></td>
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
      <td><div align="center"></div></td>
      <td>
	    <input name="Submit" type="submit" class="tombol" onClick="this.form.action+='?act=1';this.form.submit();" value="Simpan">
        <input name="Submit2" type="reset" class="tombol" onClick="this.form.action+='?act=3';this.form.submit();" value="Batal">
        <?php if ($frm_id) { ?>
        <input name="Submit3" type="button" class="tombol"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_id;?>';this.form.submit()};" value="Hapus">
        <?php } ?>
	  </td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4"><font size="1"><span class="style1">*</span> compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>