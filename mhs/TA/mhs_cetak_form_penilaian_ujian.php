<?php
/* 
   DATE CREATED : 30/05/07
   KEGUNAAN     : buat PROPOSAL CETAK PROPOSAL
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");


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

	
	if ($frm_tanggal_keluar!='') 
		{
			if (datetomysql($frm_tanggal_keluar)) 
				{
					$frm_tanggal_keluar = datetomysql($frm_tanggal_keluar);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal keluar/transfer tidak valid";
				}
		}

// Kode dan nama harus diisi

	if (($frm_nrp=='') or ($frm_nama=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi nrp dan nama mahasiswa. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_exist!=1) 
				{
					$result = mysql_query("INSERT INTO master_mhs ( `nrp` ,`id_jalur_masuk_mhs` ,  `nama` , `alamat_asal` ,  `zip_asal` , `id_kota_asal` , `alamat_sekarang` , `zip_sby` , `sex` , `tempat_lahir` , `tanggal_lahir` , `email` , `telepon_asal` , `telepon_sekarang` , `hp` , `nama_ortu` , `alamat_ortu` , `zip_ortu` , `id_kota_ortu` , `telepon_ortu` ,`tanggal_keluar` , `id_smu`, `usm`, `id_status` ) VALUES ( '".$frm_nrp."', '".$frm_id_jalur_masuk_mhs."', '".$frm_nama."', '".$frm_alamat_asal."', '".$frm_zip_asal."', '".$frm_id_kota_asal."', '".$frm_alamat_sekarang."', '".$frm_zip_sby."', '".$frm_sex."', '".$frm_tempat_lahir."', '".$frm_tanggal_lahir."', '".$frm_email."', '".$frm_telepon_asal."', '".$frm_telepon_sekarang."', '".$frm_hp."', '".$frm_nama_ortu."', '".$frm_alamat_ortu."', '".$frm_zip_ortu."', '".$frm_id_kota_ortu."', '".$frm_telepon_ortu."', '".$frm_tanggal_keluar."', '".$frm_id_smu."', '".$frm_usm."', '".$frm_id_status."') " );

	
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

					$result = mysql_query("UPDATE master_mhs set `nama`='$frm_nama'  , `id_jalur_masuk_mhs`='$frm_id_jalur_masuk_mhs'  , `alamat_asal` ='$frm_alamat_asal' , `zip_asal` ='$frm_zip_asal' , `id_kota_asal` ='$frm_id_kota_asal' , `alamat_sekarang` ='$frm_alamat_sekarang', `zip_sby` ='$frm_zip_sby', `sex`='$frm_sex' , `tempat_lahir`='$frm_tempat_lahir' , `tanggal_lahir`='$frm_tanggal_lahir' , `email`='$frm_email' , `telepon_asal`='$frm_telepon_asal' , `telepon_sekarang`='$frm_telepon_sekarang' , `hp`='$frm_hp' , `nama_ortu`='$frm_nama_ortu', `alamat_ortu`='$frm_alamat_ortu', `zip_ortu`='$frm_zip_ortu', `telepon_ortu`='$frm_telepon_ortu', `id_kota_ortu`='$frm_id_kota_ortu', `tanggal_keluar`='$frm_tanggal_keluar' , `id_smu`='$frm_id_smu' , `usm`='$frm_usm', `id_status`='$frm_id_status'  where `nrp`=$frm_nrp");

	
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

$result = mysql_query("delete from master_mhs where nrp = ".$frm_nrp);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
	
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	$frm_nrp="";
	$frm_id_jalur_masuk_mhs="";
	
	$frm_nama = "";
	$frm_alamat_asal = "";
	$frm_id_kota_asal = "";
	$frm_zip_asal = "";
	$frm_alamat_sekarang ="";
	$frm_zip_sby = "";
	$frm_sex ="";
	$frm_tempat_lahir ="";
	$frm_tanggal_lahir ="";
	$frm_email ="";
	$frm_telepon_asal ="";
	$frm_telepon_sekarang = "";
	$frm_hp = "";
	
	$frm_nama_ortu = "";
	$frm_alamat_ortu = "";
	$frm_id_kota_ortu = "";
	$frm_telepon_ortu ="";
	$frm_zip_ortu="";
	
	$frm_tanggal_keluar = "";
	$frm_id_smu ="";
	$frm_usm ="";
	$frm_id_status ="";
	
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_nrp!='' and $frm_exist==0)  {
$result = mysql_query("Select nama, id_jalur_masuk_mhs,alamat_asal, zip_asal, id_kota_asal, alamat_sekarang, zip_sby, sex, tempat_lahir, DATE_FORMAT(tanggal_lahir,'%d/%m/%Y') as tanggal_lahir, email, telepon_asal, telepon_sekarang, hp, nama_ortu, alamat_ortu, zip_ortu, telepon_ortu, id_kota_ortu, DATE_FORMAT(tanggal_keluar,'%d/%m/%Y') as tanggal_keluar, id_smu, usm, id_status from master_mhs where nrp='$frm_nrp'");

if ($row = mysql_fetch_array($result)) {
	$frm_exist=1;
	$frm_nama = $row["nama"];
	$frm_id_jalur_masuk_mhs = $row["id_jalur_masuk_mhs"];
	$frm_alamat_asal =$row["alamat_asal"];
	$frm_zip_asal = $row["zip_asal"];
	$frm_id_kota_asal =$row["id_kota_asal"];
	$frm_alamat_sekarang =$row["alamat_sekarang"];
	$frm_zip_sby = $row["zip_sby"];
	
	$frm_sex =$row["sex"];
	$frm_tempat_lahir =$row["tempat_lahir"];
	if ($row["tanggal_lahir"]=="00/00/0000") {
	$frm_tanggal_lahir =""; }else {
	$frm_tanggal_lahir =$row["tanggal_lahir"];}
	$frm_email = $row["email"];
	$frm_telepon_asal = $row["telepon_asal"];
	$frm_telepon_sekarang = $row["telepon_sekarang"];
	$frm_telepon_hp = $row["hp"];
	
	
	$frm_nama_ortu = $row["nama_ortu"];
	$frm_alamat_ortu =$row["alamat_ortu"];
	$frm_id_kota_ortu =$row["id_kota_ortu"];
	$frm_telepon_ortu = $row["telepon_ortu"];
	$frm_zip_ortu = $row["zip_ortu"];
	
	if ($row["tanggal_keluar"]=="00/00/0000") {
	$frm_tanggal_keluar =""; }else {
	$frm_tanggal_keluar =$row["tanggal_keluar"]; }
	$frm_id_smu = $row["id_smu"];
	$frm_usm = $row["usm"];
	$frm_hp = $row["hp"];
	$frm_id_status = $row["id_status"];
	
}else
{$frm_exist=0; }
	
}

if ($frm_id_kota_asal!='') {
$result = mysql_query("Select kode_area from kota where id='$frm_id_kota_asal'");
$row = mysql_fetch_array($result);
$frm_kode_area_asal = $row["kode_area"];

}	

if ($frm_id_kota_ortu!='') {
$result = mysql_query("Select kode_area from kota where id='$frm_id_kota_ortu'");
$row = mysql_fetch_array($result);
$frm_kode_area_ortu = $row["kode_area"];

}	

}

?>
<html>
<head>
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<script language="JavaScript" src="../../include/tanggalan.js">
</script>
<body class="body">
<form name="mhs" action="mhs_1_8.php" method=post>
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
            <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>CETAK 
              ~</strong> FORM PENILAIAN UJIAN TA</font></font></td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr> 
      <td width="6%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="74%"><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" ></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>NRP yang akan dicetak</td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="7" > 
        <span class="style1">*</span></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>Ketua</td>
      <td><strong>:</strong></td>
      <td><input name="frm_nama2" type="text" class="tekboxku" id="frm_nama2" value="<?php echo $frm_nama; ?>" size="30" maxlength="50"></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>Sekretaris</td>
      <td><strong>:</strong></td>
      <td><input name="frm_nama" type="text" class="tekboxku" id="frm_nama" value="<?php echo $frm_nama; ?>" size="30" maxlength="50"></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>Anggota 1</td>
      <td><strong>:</strong></td>
      <td><input name="frm_nama3" type="text" class="tekboxku" id="frm_nama3" value="<?php echo $frm_nama; ?>" size="30" maxlength="50"></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>Anggota 2</td>
      <td><strong>:</strong></td>
      <td><input name="frm_nama4" type="text" class="tekboxku" id="frm_nama4" value="<?php echo $frm_nama; ?>" size="30" maxlength="50"></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>Anggota 3</td>
      <td width="2%"><strong>:</strong></td>
      <td><input name="frm_nama5" type="text" class="tekboxku" id="frm_nama5" value="<?php echo $frm_nama; ?>" size="30" maxlength="50"></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
      <td><input type="submit" name="Submit" value="Cetak" onclick="this.form.action+='?act=1';this.form.submit();" class="tombol"> 
        <input type="reset" name="Submit2" value="Batal" onclick="this.form.action+='?act=3';this.form.submit();" class="tombol"> 
        <?php if ($frm_id) { ?>
        <input type="button" name="Submit3" value="Hapus"  onclick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_id;?>';this.form.submit()};" class="tombol"> 
        <?php } ?>
      </td>
    </tr>
    <tr> 
      <td colspan="4"> </td>
    </tr>
    <tr> 
      <td colspan="4"><font size="1"><span class="style1">*</span> compulsory 
        / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>
