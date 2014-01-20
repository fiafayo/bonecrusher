<?php
/* 
   DATE CREATED : 30/05/07
   KEGUNAAN     : EDIT DATA MASTER MAHASISWA
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/
session_start();
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ // simpan data
	// validasi tanggal
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

// NRP dan NAMA harus diisi
	if (($frm_nrp=='') or ($frm_nama=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi NRP dan Nama Mahasiswa. Gagal menyimpan data.";
		}
	
	if ($frm_tempat_lahir=='')
	{
			$error = 1;
	}

	if ($error !=1) // Jika semua isian form valid 
		{
			/*echo "<br>frm_exist= ".$frm_exist;
			echo "<br>frm_nama= ".$frm_nama;
			echo "<br>frm_kelamin= ".$frm_kelamin;						
			echo "<br>frm_tempat_lahir= ".$frm_tempat_lahir;
			echo "<br>frm_tanggal_lahir= ".$frm_tanggal_lahir;
			
			echo "<br>frm_alamat_sekarang= ".$frm_alamat_sekarang;
			echo "<br>frm_zip_sekarang= ".$frm_zip_sekarang;
			
			echo "<br>frm_telepon_sekarang= ".$frm_telepon_sekarang;
			echo "<br>frm_hp= ".$frm_hp;
			echo "<br>frm_email= ".$frm_email;
			
			echo "<br>frm_nama_ortu= ".$frm_nama_ortu;
			echo "<br>frm_alamat_ortu= ".$frm_alamat_ortu;
			echo "<br>frm_telepon_ortu= ".$frm_telepon_ortu;
			echo "<br>frm_zip_ortu= ".$frm_zip_ortu;*/
		// data id tidak ada, berarti record baru
			if ($frm_exist!=1) 
				{
					/*
						`NRP` 
						`SKSMAX` 
						`IPS` 
						`STATUS` 
						`JURUSAN`
						`WALI`
						`NAMA`
						`ALAMAT_SBY` 
						`ZIP_SBY` 
						`EMAIL` 
						`NIRM` 
						`TGLLAHIR` 
						`TMPLAHIR` 
						`TOTBSS` 
						`IPK` 
						`SKSKUM` 
						`TELEPON`
						`NO_HP` 
						`VALIDID`
						`PASSWORD` 
						`ANGKATAN` 
						`NAMASMA` 
						`NAMA_ORTU` 
						`ALAMAT_ORTU` 
						`ZIP_ORTU` 
						`TELEPON_ORTU` 
						`KELAMIN` 
					*/
					/*echo "<br>NAMA=".$frm_nama;
					echo "<br>frm_kelamin=".$frm_kelamin;
					echo "<br>frm_tanggal_lahir=".$frm_tanggal_lahir;
					echo "<br>frm_alamat_sekarang=".$frm_alamat_sekarang;
					echo "<br>frm_email=".$frm_email;
					echo "<br>frm_telepon_sekarang=".$frm_telepon_sekarang;
					echo "<br>frm_hp=".$frm_hp;
					echo "<br>frm_nama_ortu=".$frm_nama_ortu;
					echo "<br>frm_zip_ortu=".$frm_zip_ortu;
					echo "<br>frm_telepon_ortu=".$frm_telepon_ortu;*/
					$result = mysql_query("INSERT INTO master_mhs (`NRP`, `NAMA`, `KELAMIN` ,  `TMPLAHIR` , `TGLLAHIR` , `ALAMAT_SBY` , `ZIP_SBY` , `EMAIL` , `TELEPON` , `NO_HP` , `NAMA_ORTU` , `ALAMAT_ORTU` , `ZIP_ORTU` , `TELEPON_ORTU`) VALUES ( '".$frm_nrp."', '".$frm_nama."', '".$frm_kelamin."', '".$frm_tempat_lahir."', '".$frm_tanggal_lahir."', '".$frm_alamat_sekarang."', '".$frm_zip_sekarang."', '".$frm_email."', '".$frm_telepon_sekarang."', '".$frm_hp."', '".$frm_nama_ortu."', '".$frm_alamat_ortu."', '".$frm_zip_ortu."', '".$frm_telepon_ortu."') " );
					// `NRP`, `SKSMAX`, `IPS`, `STATUS`, `JURUSAN`, `WALI`, `NAMA`, `ALAMAT_SBY`, `ZIP_SBY`, `EMAIL`, `NIRM`, `TGLLAHIR`, `TMPLAHIR`, `TOTBSS`,  `IPK`,  `SKSKUM`, `TELEPON`, `NO_HP`, `VALIDID`, `PASSWORD`, `ANGKATAN`, `NAMASMA`, `NAMA_ORTU`, `ALAMAT_ORTU`, `ZIP_ORTU`, `TELEPON_ORTU`, `KELAMIN``NAMA`='$frm_nama', 
  				    if ($result) 
						{
							$pesan = $pesan."<br>Data telah ditambahkan";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data". mysql_error();
						}
				}
			else
				{
					$result = mysql_query("UPDATE master_mhs set `NAMA`='$frm_nama', 
																 `KELAMIN`='$frm_kelamin' , 
																 `TMPLAHIR`='$frm_tempat_lahir' , 
																 `TGLLAHIR`='$frm_tanggal_lahir' , 
																 `ALAMAT_SBY` = '$frm_alamat_sekarang',
																 `ZIP_SBY` = '$frm_zip_sekarang',
																 `EMAIL`='$frm_email' , 
																 `TELEPON`='$frm_telepon_sekarang' , 
																 `NO_HP`='$frm_hp' , 
																 `NAMA_ORTU`='$frm_nama_ortu', 
																 `ALAMAT_ORTU`='$frm_alamat_ortu', 
																 `ZIP_ORTU`='$frm_zip_ortu', 
																 `TELEPON_ORTU`='$frm_telepon_ortu'
														where `NRP`='$frm_nrp'");
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menyimpan data - ". mysql_error();
						}
				}
		}
	}


if ($act==2) { // hapus data

$result = mysql_query("DELETE FROM master_mhs WHERE nrp = ".$frm_nrp);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	//$frm_nama = "";
	//$frm_kelamin = "";						
	//$frm_tempat_lahir = "";
	//$frm_tanggal_lahir = "";
	
	//$frm_alamat_sekarang = "";
	//$frm_zip_sekarang = "";
	
	//$frm_telepon_sekarang = "";
	//$frm_hp = "";
	//$frm_email = "";
	
	//$frm_nama_ortu = "";
	//$frm_alamat_ortu = "";
	//$frm_telepon_ortu = "";
	//$frm_zip_ortu = "";
}
else
{
// Jika user mengisi form NRP, di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_nrp!='')  {

$result = mysql_query("SELECT	master_mhs.NRP,
								master_mhs.SKSMAX,
								master_mhs.IPS,
								master_mhs.`STATUS`,
								master_mhs.JURUSAN,
								master_mhs.WALI,
								master_mhs.NAMA,
								master_mhs.ALAMAT_SBY,
								master_mhs.ZIP_SBY,
								master_mhs.EMAIL,
								master_mhs.NIRM,
								DATE_FORMAT(master_mhs.TGLLAHIR,'%d/%m/%Y') as TGLLAHIR, 
								master_mhs.TMPLAHIR,
								master_mhs.TOTBSS,
								master_mhs.IPK,
								master_mhs.SKSKUM,
								master_mhs.TELEPON,
								master_mhs.NO_HP,
								master_mhs.VALIDID,
								master_mhs.`PASSWORD`,
								master_mhs.ANGKATAN,
								master_mhs.NAMASMA,
								master_mhs.NAMA_ORTU,
								master_mhs.ALAMAT_ORTU,
								master_mhs.ZIP_ORTU,
								master_mhs.TELEPON_ORTU,
								master_mhs.KELAMIN
						FROM 	master_mhs
						WHERE master_mhs.NRP='$frm_nrp'");

						if ($row = mysql_fetch_array($result)) {
							$frm_exist=1;
							$frm_nama = $row["NAMA"];
							$frm_kelamin =$row["KELAMIN"];						
							$frm_tempat_lahir =$row["TMPLAHIR"];
							$frm_tanggal_lahir =$row["TGLLAHIR"];
							if (($row["TGLLAHIR"]=="00/00/0000") or ($row["TGLLAHIR"]=="")){
							//echo "DISINI";
							$frm_tanggal_lahir ="00/00/0000"; }else {
							$frm_tanggal_lahir =$row["TGLLAHIR"];}
							
							$frm_alamat_sekarang =$row["ALAMAT_SBY"];
							$frm_zip_sekarang = $row["ZIP_SBY"];
							
							$frm_telepon_sekarang = $row["TELEPON"];
							$frm_hp = $row["NO_HP"];
							$frm_email = $row["EMAIL"];
							
							$frm_nama_ortu = $row["NAMA_ORTU"];
							$frm_alamat_ortu =$row["ALAMAT_ORTU"];
							$frm_telepon_ortu = $row["TELEPON_ORTU"];
							$frm_zip_ortu = $row["ZIP_ORTU"];
						}else
						{
							$frm_exist=0;
							$pesan = $pesan."NRP yang Anda masukkan tidak ada di database";
							$frm_nama = "";
							$frm_kelamin = "";						
							$frm_tempat_lahir = "";
							$frm_tanggal_lahir = "";
							
							$frm_alamat_sekarang = "";
							$frm_zip_sekarang = "";
							
							$frm_telepon_sekarang = "";
							$frm_hp = "";
							$frm_email = "";
							
							$frm_nama_ortu = "";
							$frm_alamat_ortu = "";
							$frm_telepon_ortu = "";
							$frm_zip_ortu = "";
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
<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css" media="screen" />
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
<script src="../include/jquery.js" type="text/javascript"></script>
<script src="../include/jquery.validationEngine-id.js" type="text/javascript"></script>
<script src="../include/jquery.validationEngine.js" type="text/javascript"></script>
<script src="../js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
<script language="javascript">
$(document).ready(function() {			
			$("#master_mhs").validationEngine();
			$("#frm_nrp").mask("9999999");
			$("#frm_tanggal_lahir").mask("99/99/9999");
			
		});
		

   

</script>
</head>
<script language="JavaScript" src="../include/tanggalan.js">
</script>
<body class="body">
<form name="master_mhs" id="master_mhs" action="master_mhs.php" method="post">
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
            <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>EDIT 
              DATA ~</strong> MASTER MAHASISWA</font></font> </td>
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
      <td>NRP</td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="document.master_mhs.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="10">
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nama </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nama" type="text" class="tekboxku" id="frm_nama" value="<?php echo $frm_nama; ?>" size="50" maxlength="50">
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Jenis Kelamin</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_kelamin" id="frm_kelamin" type="radio" value="1" <?php if ($frm_kelamin=='1') { echo "checked"; }?>>
        Laki-laki 
        <input type="radio" name="frm_kelamin" id="frm_kelamin" value="2" <?php if (($frm_kelamin=='2')or($frm_kelamin=='')) { echo "checked"; }?>>
        Perempuan <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tempat Lahir </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tempat_lahir" id="frm_tempat_lahir" type="text" class="validate[required,custom[onlyLetter],length[0,100]] text-input" value="<?php echo $frm_tempat_lahir; ?>" size="20">
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tanggal Lahir</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tanggal_lahir" type="text" class="tekboxku" id="frm_tanggal_lahir" value="<?php echo $frm_tanggal_lahir; ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('master_mhs.frm_tanggal_lahir',0,0,'DD/MM/YYYY')"> <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy) <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Alamat Surabaya</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_alamat_sekarang" type="text" class="tekboxku" value="<?php echo $frm_alamat_sekarang; ?>" size="50" maxlength="100">
        , Surabaya<span class="style1">*</span></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>Kode Pos Surabaya</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_zip_sekarang" id="frm_zip_sekarang" type="text" class="tekboxku" value="<?php echo $frm_zip_sekarang; ?>" size="7" maxlength="7"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Telepon Surabaya</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>+62-031-
        <input name="frm_telepon_sekarang" type="text" class="tekboxku" id="frm_telepon_sekarang" value="<?php echo $frm_telepon_sekarang; ?>" size="10"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>HP</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> <input name="frm_hp" id="frm_hp" type="text" class="tekboxku" value="<?php echo $frm_hp; ?>" size="20"> <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Email</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_email" class="validate[required,custom[email]] text-input" type="text" id="frm_email" value="<?php echo $frm_email; ?>" size="40" maxsize=100>
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nama Orang Tua</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nama_ortu" type="text" class="tekboxku" id="frm_nama_ortu3" value="<?php echo $frm_nama_ortu; ?>" size="50" maxlength="50"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Alamat Orang tua </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_alamat_ortu" type="text" class="tekboxku" id="frm_alamat_ortu" value="<?php echo $frm_alamat_ortu; ?>" size="50" maxlength="50"></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>Kode Pos Orang Tua </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_zip_ortu" id="frm_zip_ortu" type="text" class="validate[required,custom[onlyNumber],length[0,10]] text-input" value="<?php echo $frm_zip_ortu; ?>" size="7" maxlength="7"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Telepon Orang Tua</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_telepon_ortu" type="text" class="validate[required,custom[telephone]] text-input" id="frm_telepon_ortu" value="<?php echo $frm_telepon_ortu; ?>" size="50" maxlength="50"></td>
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