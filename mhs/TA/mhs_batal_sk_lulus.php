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
	if ($frm_tgl_ujian!='') 
		{
			if (datetomysql($frm_tgl_ujian)) 
				{
					$frm_tgl_ujian = datetomysql($frm_tgl_ujian);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal Ujian tidak valid";
				}
		}

	
	if ($frm_tgl_lulus!='') 
		{
			if (datetomysql($frm_tgl_lulus)) 
				{
					$frm_tgl_lulus = datetomysql($frm_tgl_lulus);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal Lulus Ujian TA tidak valid";
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
if ($frm_nrp!='')  {
$result = mysql_query("SELECT	`master_mhs`.`NRP`,
								`master_mhs`.`SKSMAX`,
								`master_mhs`.`IPS`,
								`master_mhs`.`STATUS`,
								`master_mhs`.`JURUSAN`,
								`master_mhs`.`WALI`,
								`master_mhs`.`NAMA`,
								`master_mhs`.`ALAMAT`,
								`master_mhs`.`NIRM`,
								`master_mhs`.`TGLLAHIR`,
								`master_mhs`.`TMPLAHIR`,
								`master_mhs`.`TOTBSS`,
								`master_mhs`.`IPK`,
								`master_mhs`.`SKSKUM`,
								`master_mhs`.`TELEPON`,
								`master_mhs`.`VALIDID`,
								`master_mhs`.`PASSWORD`,
								`master_mhs`.`ANGKATAN`,
								`master_mhs`.`NAMASMA`,
								`master_mhs`.`NAMAORTU`,
								`master_mhs`.`NRPKOP`,
								`master_mhs`.`KELAMIN`,
								`lulus_ta`.`sks`,
								`lulus_ta`.`ipk`,
								 DATE_FORMAT(`lulus_ta`.`tgl_ujian`,'%d/%m/%Y') as tgl_ujian,
								 DATE_FORMAT(`lulus_ta`.`tgl_lulus`,'%d/%m/%Y') as tgl_lulus,
								`lulus_ta`.`nilai_ujian`,
								`lulus_ta`.`status`
							FROM
								`master_mhs` LEFT JOIN `lulus_ta` ON `master_mhs`.`NRP` = `lulus_ta`.`NRP`
							WHERE
								`master_mhs`.`NRP` =  '".$frm_nrp."'");
								
							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_nama = $row["NAMA"];
								$frm_nilai_ujian_ta = $row["nilai_ujian"];
								$frm_sks_kum = $row["sks"];
								$frm_ip_kum = $row["ipk"];
								
								$frm_tgl_ujian_ta =$row["tgl_ujian"];
								if ($row["tgl_ujian"]=="00/00/0000") {
								$frm_tgl_ujian =""; }else {
								$frm_tgl_ujian =$row["tgl_ujian"];}
											
								$frm_tgl_lulus =$row["tgl_lulus"];
								if ($row["tgl_lulus"]=="00/00/0000") {
								$frm_tgl_lulus =""; }else {
								$frm_tgl_lulus =$row["tgl_lulus"]; }
								
							}else
							{$frm_exist=0; header("Location: mhs_batal_sk_lulus.php"); }
	
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
<form name="mhs" action="mhs_batal_sk_lulus.php" method="post">
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
              DATA ~</strong> PROSES PEMBATALAN SK LULUS</font></font></td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="15%">&nbsp;</td> 
      <td width="15%">&nbsp;</td>
      <td width="3%">&nbsp;</td>
      <td width="83%"><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" ></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>NRP</td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="10" >
        <span class="style1">* <? if (isset($frm_nrp)) echo $frm_nama;?> </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Tanggal Ujian TA</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_ujian_ta" type="text" class="tekboxku" id="frm_tgl_ujian_ta" value="<?php echo $frm_tgl_ujian_ta; ?>" size="10" maxlength="10">
	  <A Href="javascript:show_calendar('mhs.frm_tgl_ujian_ta',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)	 <span class="style1">*</span> </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Nilai Ujian TA</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nilai_ujian_ta" id="frm_nilai_ujian_ta" type="text" class="tekboxku" value="<?php echo $frm_nilai_ujian_ta; ?>" size="10" maxlength="10">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>SKS Kumulatif </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_sks_kum" id="frm_sks_kum" type="text" class="tekboxku" value="<?php echo $frm_sks_kum; ?>" size="10" maxlength="10">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>IP Kumulatif </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_ip_kum" id="frm_ip_kum" type="text" class="tekboxku" value="<?php echo $frm_ip_kum; ?>" size="10" maxlength="10">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tanggal Lulus </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_lulus" type="text" class="tekboxku" id="frm_tgl_lulus" value="<?php echo $frm_tgl_lulus; ?>" size="10" maxlength="10">
	  <A Href="javascript:show_calendar('mhs.frm_tgl_lulus',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)
      <span class="style1">*</span> </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">Judul TA </td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><textarea name="frm_judul_ta" cols="60" rows="2" class="tekboxku" id="frm_judul_ta"><?php echo $frm_judul_ta; ?></textarea>
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
      <td>	   	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
      <td><input type="submit" name="Submit" value="Simpan" onclick="this.form.action+='?act=1';this.form.submit();" class="tombol"> 
        <input type="reset" name="Submit2" value="Batal" onclick="this.form.action+='?act=3';this.form.submit();" class="tombol"> 
        <?php if ($frm_nama) { ?>
        <input type="button" name="Submit3" value="Hapus"  onclick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_nama;?>';this.form.submit()};" class="tombol"> 
        <?php } ?></td>
    </tr>
    <tr> 
      <td colspan="4">
      </td>
    </tr>
    <tr> 
      <td colspan="4"><font size="1"><span class="style1">*</span> compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>
