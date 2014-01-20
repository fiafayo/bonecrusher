<?php
/* 
   DATE CREATED : 29/06/07
   KEGUNAAN     : ENTRY DATA PERPANJANG LP
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
	if ($frm_tgl_berakhir!='') 
		{
			if (datetomysql($frm_tgl_berakhir)) 
				{
					$frm_tgl_berakhir = datetomysql($frm_tgl_berakhir);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal masa berakhir LP tidak valid";
				}
		}

	
	if ($frm_tgl_aju!='') 
		{
			if (datetomysql($frm_tgl_aju)) 
				{
					$frm_tgl_aju = datetomysql($frm_tgl_aju);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal pengajuan LP tidak valid";
				}
		}
		
	if ($frm_tgl_ulur!='') 
		{
			if (datetomysql($frm_tgl_ulur)) 
				{
					$frm_tgl_ulur = datetomysql($frm_tgl_ulur);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal perpanjangan LP tidak valid";
				}
		}

// Kode dan nama harus diisi
	if (($frm_nrp=='') or ($frm_setuju=='') or ($frm_tgl_berakhir=='') or ($frm_tgl_aju=='') or ($frm_tgl_ulur=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data 'PERPANJANG LP' dengan lengkap. Gagal menyimpan data !";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_exist!=1) 
				{
					$result = mysql_query("INSERT INTO perpanjang_LP (`nrp`, `tgl_berakhir`, `tgl_aju` ,`tgl_ulur`, `disetujui`) VALUES ( '".$frm_nrp."', '".$frm_tgl_berakhir."', '".$frm_tgl_aju."', '".$frm_tgl_ulur."', '".$frm_setuju."') " );
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
					$result = mysql_query("UPDATE perpanjang_LP set `tgl_berakhir`='$frm_tgl_berakhir', `tgl_aju`='$frm_tgl_aju', `tgl_ulur` ='$frm_tgl_ulur', `disetujui` ='$frm_setuju' where `nrp`=$frm_nrp");

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

$result = mysql_query("delete from perpanjang_LP where nrp = ".$frm_nrp);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist = 0;
	$frm_nrp = "";
	$frm_nama = "";
	$frm_setuju = "";
	$frm_tgl_berakhir = "";
	$frm_tgl_aju = "";
	$frm_tgl_ulur = "";
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
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
								master_mhs.KELAMIN,
								 DATE_FORMAT(`perpanjang_LP`.`tgl_berakhir`,'%d/%m/%Y') as tgl_berakhir,
								 DATE_FORMAT(`perpanjang_LP`.`tgl_aju`,'%d/%m/%Y') as tgl_aju,
								 DATE_FORMAT(`perpanjang_LP`.`tgl_ulur`,'%d/%m/%Y') as tgl_ulur,
								`perpanjang_LP`.`disetujui`
							FROM
								`master_mhs` LEFT JOIN `perpanjang_LP` ON `master_mhs`.`NRP` = `perpanjang_LP`.`NRP`
							WHERE master_mhs.NRP LIKE '6__2%' AND
								 `master_mhs`.`NRP` =  '".$frm_nrp."'");
								
							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_nama = $row["NAMA"];
								$frm_setuju = $row["disetujui"];
								
								$frm_tgl_berakhir = $row["tgl_berakhir"];
								if ($row["tgl_berakhir"]=="00/00/0000") {
								$frm_tgl_berakhir = ""; }else {
								$frm_tgl_berakhir = $row["tgl_berakhir"];}
								
								$frm_tgl_aju = $row["tgl_aju"];
								if ($row["tgl_aju"]=="00/00/0000") {
								$frm_tgl_aju = ""; }else {
								$frm_tgl_aju = $row["tgl_aju"];}
								
								$frm_tgl_ulur = $row["tgl_ulur"];
								if (($row["tgl_ulur"]=="00/00/0000") or ($row["tgl_ulur"]=="")) 
								{
									$frm_tgl_ulur = ""; 
									$frm_exist = 0;
								}
								else 
								{
									$frm_tgl_ulur = $row["tgl_ulur"];
								}
								
							}else
							{$frm_exist=0; header("Location: mhs_perpanjangan_LP.php"); }
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
<form name="mhs" id="mhs" action="mhs_perpanjangan_LP.php" method="post">
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
              DATA ~</strong>  MAHASISWA PERPANJANGAN PENELITIAN </font></font></td>
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
        <span class="style1">*
        <? if (isset($frm_nrp)) echo $frm_nama;?>
        </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tanggal Berakhir </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_berakhir" type="text" class="tekboxku" id="frm_tgl_berakhir" value="<?php echo $frm_tgl_berakhir; ?>" size="10" maxlength="10">
	  <A Href="javascript:show_calendar('mhs.frm_tgl_berakhir',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)
      <span class="style1">*</span> </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>Tanggal Mengajukan </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_aju" type="text" class="tekboxku" id="frm_tgl_aju" value="<?php echo $frm_tgl_aju; ?>" size="10" maxlength="10">
	   <A Href="javascript:show_calendar('mhs.frm_tgl_aju',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)	 <span class="style1">*</span> </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Diperpanjang s/d </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_ulur" type="text" class="tekboxku" id="frm_tgl_ulur" value="<?php echo $frm_tgl_ulur; ?>" size="10" maxlength="10">
	  <A Href="javascript:show_calendar('mhs.frm_tgl_ulur',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)
      <span class="style1">*</span> </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>Persetujuan(y/t)</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
        <select name="frm_setuju" id="frm_setuju" class="tekboxku">
			<? if (isset($frm_setuju)) {?>
			<option value="Y" <? if ($frm_setuju=="Y") echo "selected"?>>Ya</option>
			<option value="T" <? if ($frm_setuju=="T") echo "selected"?>>Tidak</option>
			<? } else {?>
			<option value="Y">Ya</option>
			<option value="T" selected>Tidak</option>
			<? }?>
        </select> <span class="style1">*</span>
        </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
      <td>        </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
      <td><input type="submit" name="Submit" value="Simpan" onclick="this.form.action+='?act=1';this.form.submit();" class="tombol"> 
        <input type="reset" name="Submit2" value="Batal" onclick="this.form.action+='?act=3';this.form.submit();" class="tombol"> 
        <?php if ($frm_tgl_berakhir) { ?>
        <input type="button" name="Submit3" value="Hapus"  onclick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_tgl_berakhir;?>';this.form.submit()};" class="tombol"> 
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