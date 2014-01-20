<?
/* 
   DATE CREATED : 02/05/08
   UPDATE  		: 
   KEGUNAAN     : ENTRY PRESTASI MAHASISWA(perorangan)
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
	if ($frm_tgl_kegiatan!='') 
		{
			if (datetomysql($frm_tgl_kegiatan)) 
				{
					$frm_tgl_kegiatan = datetomysql($frm_tgl_kegiatan);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal Kegiatan tidak valid";
				}
		}
	

// NRP dan nama harus diisi
	if (($frm_nrp=='') or ($frm_jurusan=='') or ($frm_kegiatan=='') or ($frm_tgl_kegiatan=='') or ($frm_tempat=='')or ($frm_tingkat=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Pastikan Anda sudah mengisi semua Data prestasi dengan lengkap.";
		}

	if ($error==1) 
		{
			$pesan=$pesan."<br>Gagal menyimpan data.";
		}
	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
		echo "HERE";
			if ($frm_id=='') 
				{
					$result = mysql_query("INSERT INTO prestasi (`id`, `nrp`, `kegiatan`, `tgl_kegiatan`, `tempat`, `hasil`, `jurusan`, `tingkat`) VALUES ( NULL, '".$frm_nrp."', '".$frm_kegiatan."', '".$frm_tgl_kegiatan."', '".$frm_tempat."', '".$frm_prestasi."', ".$frm_jurusan.", '".$frm_tingkat."') " );
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
					
					echo "<br>frm_tgl_kegiatan=".$frm_tgl_kegiatan;
					echo "<br>frm_selesai=".$frm_selesai;
					$result = mysql_query("UPDATE prestasi SET `nrp`='$frm_nrp', 
															   `kegiatan`='$frm_kegiatan', 
															   `tgl_kegiatan`='$frm_tgl_kegiatan',
															   `tempat`='$frm_tempat',
															   `hasil`='$frm_prestasi' , 
															   `jurusan`= $frm_jurusan, 
															   `tingkat`= '$frm_tingkat'
														 WHERE `id`=$frm_id");
	
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menyimpan data-".mysql_error();
						}
				}
		}
	}


if ($act==2) { // hapus data

$result = mysql_query("DELETE FROM prestasi WHERE id = ".$frm_id);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
	
if (($act!=0)and($error!=1)) 
{
	$frm_nrp="";
	$frm_kegiatan="";
	$frm_tgl_kegiatan="";
	$frm_tempat="";
	$frm_prestasi="";
	$frm_jurusan="";
	$frm_tingkat="";
	//$jum=0;

}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
//echo "<br>frm_kode=".$frm_kode;
if ($frm_nrp!='')  {

$result = mysql_query("SELECT prestasi.id,
							  prestasi.nrp,
							  prestasi.kegiatan,
							  DATE_FORMAT(prestasi.tgl_kegiatan,\"%d/%m/%Y\") as tgl_kegiatan,
							  prestasi.tempat,
							  prestasi.hasil,
							  prestasi.jurusan,
							  prestasi.tingkat
					     FROM prestasi 
					    WHERE nrp='$frm_nrp'");
						//DATE_FORMAT(mulai,'%d/%m/%Y') as mulai,
							  //DATE_FORMAT(selesai,'%d/%m/%Y') as selesai,

					if ($row = mysql_fetch_array($result)) {
						$frm_id = $row["id"];
						$frm_nrp = $row["nrp"];
						$frm_jurusan = $row["jurusan"];
						$frm_kegiatan = $row["kegiatan"];
						$frm_tempat = $row["tempat"];
						$frm_tingkat = $row["tingkat"];
						$frm_prestasi = $row["hasil"];
												
						$frm_tgl_kegiatan = $row["tgl_kegiatan"];
						if ($frm_tgl_kegiatan=="00/00/0000") {
						$frm_tgl_kegiatan = ""; }else {
						$frm_tgl_kegiatan = $row["tgl_kegiatan"];}
						
						echo "<br>frm_tgl_kegiatan=".$frm_tgl_kegiatan;
						echo "<br>frm_selesai=".$frm_selesai;
					//exit();
						/*echo $frm_id;
						echo $frm_kode ;
						echo $frm_jurusan;
						echo $frm_nama_institusi;
						echo $frm_id_jenis;
						echo $frm_id_tipe ;
						echo $frm_judul;
						echo $frm_mulai ;
						echo $frm_kode_dsn;
						echo $frm_status_jabatan ;
						echo $frm_selesai;
						echo $frm_tempat ;
						echo $frm_jumlah_staff;
						echo $frm_id_sumber_dana ;
						echo $frm_jumlah_dana;*/
					}
					else
					{
						//$frm_nrp="";
						$frm_kegiatan="";
						$frm_tgl_kegiatan="";
						$frm_tempat="";
						$frm_prestasi="";
						$frm_jurusan="";
						$frm_tingkat="";
					}
}

}

?>
<html>
<head>
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../../include/tanggalan.js">
</script>
</head>
<body class="body">
<form name="form_prestasi" id="form_prestasi" action="prestasi_entry.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4"> <hr size="1" color="#FF9900">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="89%">
				<font color="#0099CC" size="1">
				<? if ($frm_kode!=''){?>
					<strong>EDIT DATA ~ </strong>
				<? } else
				{?>
					<strong>ENTRY DATA ~ </strong>
				<? }?>
				PRESTASI MAHASISWA</font>
			</td>
            <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="19%">&nbsp;</td> 
      <td width="10%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="69%">&nbsp; <input type="hidden" name="frm_id" id="frm_id" value="<?php echo $frm_id;?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>NRP</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  
	  <input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" value="<?php echo $frm_nrp; ?>" size="10" maxlength="10" onBlur="document.form_prestasi.submit();">
	  <font color="#FF0000">* <? $sql_nama_mhs="SELECT NAMA FROM master_mhs WHERE master_mhs.nrp='$frm_nrp'";
				$result_mhs = @mysql_query($sql_nama_mhs);
				$row_mhs=@mysql_fetch_object($result_mhs);
				echo $row_mhs->NAMA;
				?></font> </td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">Jurusan</td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_jurusan" id="frm_jurusan" class="tekboxku">
        <option <?php if ($frm_jurusan==''){echo "selected";}?>>--- Pilih ---</option>
        <?php 
				$sql_jurusan="SELECT * FROM jurusan ORDER BY id ASC";
				$result = @mysql_query($sql_jurusan);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
        <option value="<?php echo $row->id; ?>" <?php if ($frm_jurusan==$row->id) { echo "selected"; }?>> <?php echo $row->jurusan; ?></option>
        <?php
				}
				?>
      </select>
      <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td> 
      <td valign="top">Kegiatan</td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><textarea name="frm_kegiatan" id="frm_kegiatan" cols="50" class="tekboxku"><?php echo $frm_kegiatan; ?></textarea>
      <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_kegiatan" type="text" class="tekboxku" id="frm_tgl_kegiatan" value="<?php echo $frm_tgl_kegiatan; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('form_prestasi.frm_tgl_kegiatan',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="bottom" border=0> 
        </A>(dd/mm/yyyy) <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top" nowrap>Tempat/Lokasi</td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><textarea name="frm_tempat" id="frm_tempat" cols="50" class="tekboxku"><?php echo $frm_tempat; ?></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top" nowrap>Tingkat</td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td>
	    <select name="frm_tingkat" id="frm_tingkat" class="tekboxku">
            <option <?php if ($frm_tingkat==''){echo "selected";}?> value="">--- Pilih ---</option>
            <?php 
				$sql_tingkat="SELECT * FROM status_publikasi";
				$result = @mysql_query($sql_tingkat);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
            <option value="<?php echo $row->id_pub; ?>" <?php if ($frm_tingkat==$row->id_pub) { echo "selected"; }?>> <?php echo $row->nama; ?></option>
            <?php
				}
				?>
        </select>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top" nowrap>Prestasi</td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><textarea name="frm_prestasi" id="frm_prestasi" cols="50" class="tekboxku"><?php echo $frm_prestasi; ?></textarea></td>
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
      <td>&nbsp;</td>
      <td>
		<input name="Submit" type="submit" class="tombol" onClick="this.form.action+='?act=1&jum=<? echo $jum;?>';this.form.submit();" value="Simpan">
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
      <td colspan="4"><font color="#FF0000" size="1">*</font><font size="1"> = 
        compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>