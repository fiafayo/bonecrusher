<?php
/* 
   DATE CREATED : 30/05/07
   KEGUNAAN     : buat PROPOSAL CETAK PROPOSAL
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
	if ($frm_tgl_aju!='') 
		{
			if (datetomysql($frm_tgl_aju)) 
				{
					$frm_tgl_aju = datetomysql($frm_tgl_aju);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal pengajuan tidak valid";
				}
		}

	/*
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
		}*/

// Kode dan nama harus diisi
	if (($frm_nrp=='') or ($frm_nama=='') or ($frm_judul_ta=='') or ($frm_kode_dosen_1=='') or ($frm_kode_dosen_2=='') or ($frm_tgl_aju=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data mahasiswa dengan lengkap. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_exist!=1) 
				{
					$result = mysql_query("INSERT INTO master_ta (`NRP`,`F_JUDUL1`,`F_KODOS1`,`F_KODOS2`,`F_ACC1`,`F_ACC2`,`F_TGLAJU`) VALUES ('".$frm_nrp."','".$frm_judul_ta."','".$frm_kode_dosen_1."','".$frm_kode_dosen_2."','".$frm_tgl_aju."') ");
	
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

					$result = mysql_query("UPDATE master_ta set `F_JUDUL1`='$frm_judul_ta'  , `F_KODOS1`='$frm_kode_dosen_1'  , `F_KODOS2` ='$frm_kode_dosen_2' , `F_TGLAJU` ='$frm_tgl_aju' where `NRP`=$frm_nrp");

	
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

$result = mysql_query("DELETE FROM master_ta WHERE NRP = ".$frm_nrp);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	$frm_nrp = "";
	$frm_nama = "";
	$frm_judul_ta = "";
	$frm_kode_dosen_1 = "";
	$frm_kode_dosen_2 = "";
	$frm_tgl_aju ="";
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_nrp!='')  {
//if ($frm_nrp!='')  {
/*	$result = mysql_query("SELECT   master_mhs.NRP as mhs_NRP,
									SKSMAX,
									IPS,
									STATUS,
									JURUSAN,
									WALI,
									NAMA,
									ALAMAT,
									NIRM,
									TGLLAHIR,
									TMPLAHIR,
									TOTBSS,
									IPK,
									SKSKUM,
									TELEPON,
									VALIDID,
									PASSWORD,
									ANGKATAN,
									NAMASMA,
									NAMAORTU,
									NRPKOP,
									KELAMIN,
									F_JUDUL1,
									F_KODOS1,
									F_KODOS2,
									DATE_FORMAT(master_ta.F_TGLAJU,'%d/%m/%Y') as TGL_AJU, 
							FROM
							        master_mhs LEFT JOIN master_ta ON master_mhs.NRP = master_ta.NRP
							WHERE
							        master_mhs.NRP = '".$frm_nrp."'");*/

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
									`master_ta`.`F_JUDUL1`,
									`master_ta`.`F_KODOS1`,
									`master_ta`.`F_KODOS2`,
									 DATE_FORMAT(F_TGLAJU,'%d/%m/%Y') as TGL_AJU
							FROM
							`master_mhs` LEFT JOIN `master_ta` ON `master_mhs`.`NRP` = `master_ta`.`NRP`
							WHERE
							`master_mhs`.`NRP` =  '".$frm_nrp."'");
								  //DATE_FORMAT(tanggal_lahir,'%d/%m/%Y') as tanggal_lahir, email, telepon_asal, telepon_sekarang, hp, nama_ortu, alamat_ortu, zip_ortu, telepon_ortu, id_kota_ortu, DATE_FORMAT(tanggal_keluar,'%d/%m/%Y') as tanggal_keluar, id_smu, usm, id_status from master_mhs where nrp='$frm_nrp'");
	
	if ($row = mysql_fetch_array($result)) {
		$frm_exist=1;
		$frm_nama = $row["NAMA"];
		$frm_judul_ta = $row["F_JUDUL1"];
		$frm_kode_dosen_1 = $row["F_KODOS1"];
		$frm_kode_dosen_2 = $row["F_KODOS2"];
		$frm_tgl_aju = $row["TGL_AJU"];
		
		if ($row["TGL_AJU"]=="00/00/0000") 
		{
			$frm_tgl_aju =""; 
		}
		else 
		{
			$frm_tgl_aju =$row["TGL_AJU"];
		}
		
	}
	else
	{
		$frm_exist=0; 
	}
	if ($frm_exist==0) {
		$frm_nama = "";
		$frm_judul_ta = "";
		$frm_kode_dosen_1 = "";
		$frm_kode_dosen_2 = "";
		$frm_tgl_aju ="";
	}
}

/*if ($frm_id_kota_asal!='') {
$result = mysql_query("Select kode_area from kota where id='$frm_id_kota_asal'");
$row = mysql_fetch_array($result);
$frm_kode_area_asal = $row["kode_area"];
}	

if ($frm_id_kota_ortu!='') {
$result = mysql_query("Select kode_area from kota where id='$frm_id_kota_ortu'");
$row = mysql_fetch_array($result);
$frm_kode_area_ortu = $row["kode_area"];
}*/	

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
<form name="mhs" action="mhs_proses_proposal.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><img src="spacer" height="1"></td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4"> <hr size="1" color="#0000FF"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>ENTRY 
              DATA ~</strong> PROSES PROPOSAL TA</font></font> </td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#0000FF"> </td>
    </tr>
    <tr>
      <td width="15%">&nbsp;</td> 
      <td width="15%">&nbsp;</td>
      <td width="3%">&nbsp;</td>
      <td width="83%"><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" ></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nrp</td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="10" >
        <span class="style1">*</span><font color="#FF0000"> (<em>setelah 
        memasukkan NRP, <strong>JANGAN TEKAN ENTER !</strong></em>)</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nama</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nama" type="text" class="tekboxku" id="frm_nama" value="<?php echo $frm_nama; ?>" size="50" maxlength="50">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td valign="top">Judul TA </td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><textarea name="frm_judul_ta" id="frm_judul_ta" cols="60" rows="2" class="tekboxku"><?php echo $frm_judul_ta; ?></textarea>
        <span class="style1">*</span>        </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>Kode Dosen 1</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_kode_dosen_1" id="frm_kode_dosen_1" type="text" class="tekboxku" value="<?php echo $frm_kode_dosen_1; ?>" size="10" maxlength="10">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Kode Dosen 2</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_kode_dosen_2" id="frm_kode_dosen_2" type="text" class="tekboxku" value="<?php echo $frm_kode_dosen_2; ?>" size="10" maxlength="10">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td nowrap>Tanggal Pengajuan </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_aju" type="text" class="tekboxku" id="frm_tgl_aju" value="<?php echo $frm_tgl_aju; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('mhs.frm_tgl_aju',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)  <span class="style1">*</span></td>
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
      <td><input type="submit" name="Submit" value="Simpan" onclick="this.form.action+='?act=1';this.form.submit();" class="tombol"> 
        <input type="reset" name="Submit2" value="Batal" onclick="this.form.action+='?act=3';this.form.submit();" class="tombol"> 
        <?php if ($frm_id) { ?>
        <input type="button" name="Submit3" value="Hapus"  onclick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_id;?>';this.form.submit()};" class="tombol"> 
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
