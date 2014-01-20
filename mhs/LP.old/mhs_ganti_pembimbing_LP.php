<?php
/* 
   DATE CREATED : 01/06/07
   KEGUNAAN     : ENTRY GANTI DOSEN PEMBIMBING PENELITIAN
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
	if ($frm_tgl_ganti!='') 
		{
			if (datetomysql($frm_tgl_ganti)) 
				{
					$frm_tgl_ganti = datetomysql($frm_tgl_ganti);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal Ganti tidak valid";
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
					$pesan = $pesan."<br> Tanggal Pengajuan tidak valid";
				}
		}

// Kode dan nama harus diisi 
	if (($frm_nrp=='') or ($frm_tgl_ganti=='') or ($frm_tgl_aju=='') or ($frm_setuju=='') or ($frm_kode_dosen_baru=='') or ($frm_kode_dosen_lama=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data 'GANTI PEMBIMBING PENELITIAN' dengan lengkap. Gagal menyimpan data !";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_exist!=1) 
				{
					$result = mysql_query("INSERT INTO ganti_dobing_LP( `NRP` ,`kode_dobing_lama` ,  `kode_dobing_baru` , `tgl_ganti` ,  `tgl_aju` , `disetujui` ) VALUES ( '".$frm_nrp."', '".$frm_kode_dosen_lama."', '".$frm_kode_dosen_baru."', '".$frm_tgl_ganti."', '".$frm_tgl_aju."', '".$frm_setuju."') " );
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
					$result = mysql_query("UPDATE ganti_dobing_LP set `kode_dobing_lama`='$frm_kode_dosen_lama', `kode_dobing_baru`='$frm_kode_dosen_baru', `tgl_ganti` ='$frm_tgl_ganti' , `tgl_aju` ='$frm_tgl_aju' , `disetujui` ='$frm_setuju' where `nrp`=$frm_nrp");
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

$result = mysql_query("delete from ganti_dobing_LP where nrp = ".$frm_nrp);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
	
if (($act!=0)and($error!=1)) {
	$frm_exist = 0;
	$frm_nrp = "";
	$frm_nama = "";
	$frm_kode_dosen_lama = "";
	$frm_kode_dosen_baru = "";
	$frm_tgl_ganti = "";
	$frm_tgl_aju = "";
	$frm_setuju = "T";
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
								`ganti_dobing_LP`.`kode_dobing_lama`,
								`ganti_dobing_LP`.`kode_dobing_baru`,
								 DATE_FORMAT(`ganti_dobing_LP`.`tgl_aju`,'%d/%m/%Y') as tgl_aju,
								 DATE_FORMAT(`ganti_dobing_LP`.`tgl_ganti`,'%d/%m/%Y') as tgl_ganti,
								`ganti_dobing_LP`.`disetujui`
							FROM
								`master_mhs` LEFT JOIN `ganti_dobing_LP` ON `master_mhs`.`NRP` = `ganti_dobing_LP`.`NRP`
							WHERE master_mhs.NRP LIKE '6__2%' AND
								 `master_mhs`.`NRP` =  '".$frm_nrp."'");

							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_nama = $row["NAMA"];
								$frm_kode_dosen_lama = $row["kode_dobing_lama"];
								$frm_kode_dosen_baru = $row["kode_dobing_baru"];
								
								//echo "<br>nama=".$frm_nama;
								//echo "<br>kodobing_lama=".$frm_kode_dosen_lama;
								//echo "<br>kodobing_baru=".$frm_kode_dosen_baru;
									if ($frm_nama <>'')
									{
										$sql_dobing = "SELECT KODOS1 from master_lp where NRP='".$frm_nrp."'";
										$result_dobing = mysql_query($sql_dobing);
										if ($row_dobing = mysql_fetch_array($result_dobing))
										{
											$frm_kode_dosen_lama=$row_dobing["KODOS1"];
										}
									}
								
								$frm_tgl_ganti =$row["tgl_ganti"];
								if (($row["tgl_ganti"]=="00/00/0000") or ($row["tgl_ganti"]==""))
								{
									$frm_tgl_ganti = ""; 
									$frm_exist = 0;
								}
								else 
								{
									$frm_tgl_ganti =$row["tgl_ganti"];
								}
								
								$frm_tgl_aju = $row["tgl_aju"];
								if ($row["tgl_aju"]=="00/00/0000") {
								$frm_tgl_aju = ""; }else {
								$frm_tgl_aju = $row["tgl_aju"];}
							
								$frm_setuju = $row["disetujui"];
								
								/*if ($_POST['frm_nama']!='')
								{	
									$frm_kode_dosen_lama=$_POST['frm_kode_dosen_lama'];
									$frm_kode_dosen_baru=$_POST['frm_kode_dosen_baru'];
								}*/
								
							}else
							{$frm_exist=0; header("Location: mhs_ganti_pembimbing_LP.php"); }
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
<form name="mhs" id="mhs" action="mhs_ganti_pembimbing_LP.php" method="post">
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
              DATA ~</strong>  GANTI PEMBIMBING PENELITIAN</font></font> </td>
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
      <td nowrap>NPK Dosen Lama </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_kode_dosen_lama" id="frm_kode_dosen_lama" class="tekboxku">
          <option <?php if ($frm_kode_dosen_lama==''){echo "selected";}?> value="">--- Pilih ---</option>
          <?php 
				$sqlDosen="select kode, nama
						   from dosen where (length(kode)=6) ORDER BY kode";
				
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->kode; ?>" <?php if ($frm_kode_dosen_lama==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
          <?php }?>
        </select>
<span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>NPK Dosen Baru </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_kode_dosen_baru" id="frm_kode_dosen_baru" class="tekboxku">
          <option <?php if ($frm_kode_dosen_baru==''){echo "selected";}?> value="">--- Pilih ---</option>
          <?php 
				$sqlDosen="select kode, nama
						   from dosen where (length(kode)=6) ORDER BY kode";
				
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->kode; ?>" <?php if ($frm_kode_dosen_baru==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
          <?php
				}
				
				?>
        </select>
        <span class="style1">*</span> </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Tanggal Pengajuan </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_aju" type="text" class="tekboxku" id="frm_tgl_aju" value="<?php echo $frm_tgl_aju; ?>" size="10" maxlength="10">
	  <A Href="javascript:show_calendar('mhs.frm_tgl_aju',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)
      <span class="style1">*</span> </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Tanggal Mulai Ganti </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_ganti" type="text" class="tekboxku" id="frm_tgl_ganti" value="<?php echo $frm_tgl_ganti; ?>" size="10" maxlength="10">
	   <A Href="javascript:show_calendar('mhs.frm_tgl_ganti',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)	 <span class="style1">*</span> </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>Persetujuan (Y/T)</td>
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
        </select><span class="style1"> *</span>
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
        <?php if ($frm_kode_dosen_lama) { ?>
        <input type="button" name="Submit3" value="Hapus"  onclick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_kode_dosen_lama;?>';this.form.submit()};" class="tombol"> 
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