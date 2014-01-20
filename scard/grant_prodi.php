<?
/* 
   DATE CREATED : 12/06/08
   UPDATE  		: 
   KEGUNAAN     : ENTRY GRANT PRODI
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ // simpan data
	if ($frm_tgl_awal!='') 
		{
			if (datetomysql($frm_tgl_awal)) 
				{
					$frm_tgl_awal = datetomysql($frm_tgl_awal);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal Awal tidak valid";
				}
		}
		
	if ($frm_tgl_akhir!='') 
		{
			if (datetomysql($frm_tgl_akhir)) 
				{
					$frm_tgl_akhir = datetomysql($frm_tgl_akhir);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal Akhir tidak valid";
				}
		}
 // Jurusan, Nama Instansi, Jumlah prodi  harus diisi
	if (($frm_jurusan==0) or ($frm_nama_instansi=='') or ($frm_jumlah==''))
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi Data dengan lengkap. ";
		}

	if ($error==1) 
		{
			$pesan=$pesan."<br>Gagal menyimpan data.";
		}
		
	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_exist!=1) 
				{
					/*
					echo "<br>INSERT";
					echo "<br>frm_exist=".$frm_exist;
					echo "<br>frm_angkatan=".$frm_nama_instansi;
					echo "<br>frm_jurusan=".$frm_jurusan;
					echo "<br>jumlah=".$frm_jumlah;
					echo "<br>frm_tgl_awal=".$frm_tgl_awal;
					echo "<br>frm_tgl_akhir=".$frm_tgl_akhir;
					*/
					$result = mysql_query("INSERT INTO grant_prodi (`id_grant`, `nama_instansi`, `jurusan_id`, `jumlah`, `tgl_awal`, `tgl_akhir`) VALUES ( NULL, '".$frm_nama_instansi."', ".$frm_jurusan.", '".$frm_jumlah."', '".$frm_tgl_awal."', '".$frm_tgl_akhir."')");
					if ($result) 
					{
						$pesan = $pesan."<br>Data telah ditambahkan";	
					}
					else
					{ 
						$pesan = $pesan."<br>Gagal menambahkan data - ". mysql_error();
					}
				}
			else
				{
					/*
					echo "<br>UPDATE";
					echo "<br>frm_id_grant=".$frm_id_grant;
					echo "<br>frm_nama_instansi=".$frm_nama_instansi;
					echo "<br>frm_jurusan=".$frm_jurusan;
					echo "<br>frm_jumlah=".$frm_jumlah;
					echo "<br>frm_tgl_awal=".$frm_tgl_awal;
					echo "<br>frm_tgl_akhir=".$frm_tgl_akhir;
					*/
					$result = mysql_query("UPDATE grant_prodi SET `nama_instansi`=$frm_nama_instansi,
														          `jurusan_id`=$frm_jurusan,
														     	  `jumlah`='$frm_jumlah', 
														     	  `tgl_awal`='$frm_tgl_awal',
																  `tgl_akhir`='$frm_tgl_akhir'
												            WHERE `id_grant`=$frm_id_grant");
	
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

$result = mysql_query("DELETE FROM grant_prodi WHERE id_grant = ".$frm_id_grant);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) 
{
	$frm_id_grant="";
	$frm_nama_instansi="";
	$frm_jurusan=0;
	$frm_jumlah = 0;
	$frm_tgl_awal= "";
	$frm_tgl_akhir = "";
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
				//if (isset($frm_jurusan)) 
				if ((isset($frm_jurusan)) AND($frm_nama_instansi<>'')) 
				{
						$result = mysql_query("SELECT id_grant,
													  nama_instansi,
													  jurusan_id,
													  jumlah,
													  DATE_FORMAT(tgl_awal,'%d/%m/%Y') as tgl_awal,
													  DATE_FORMAT(tgl_akhir,'%d/%m/%Y') as tgl_akhir
												 FROM grant_prodi
												WHERE nama_instansi='".$frm_nama_instansi."' AND 
													  jurusan_id=".$frm_jurusan." AND
													  DATE_FORMAT(tgl_awal,'%d/%m/%Y')='".$frm_tgl_awal."' AND
													  DATE_FORMAT(tgl_akhir,'%d/%m/%Y')='".$frm_tgl_akhir."'");
				
						if ($row = mysql_fetch_array($result)) {
							$frm_exist=1;
							$frm_id_grant = $row["id_grant"];
							$frm_nama_instansi = $row["nama_instansi"];
							$frm_jurusan = $row["jurusan_id"];
							$frm_jumlah = $row["jumlah"];
							
							$frm_tgl_awal = $row["tgl_awal"];
							if ($row["tgl_awal"]=="00/00/0000") {
							$frm_tgl_awal = ""; }else {
							$frm_tgl_awal = $row["tgl_awal"];}
							
							$frm_tgl_akhir = $row["tgl_akhir"];
							if ($row["tgl_akhir"]=="00/00/0000") {
							$frm_tgl_akhir = ""; }else {
							$frm_tgl_akhir = $row["tgl_akhir"];}
						}
						else
						{
							$frm_exist=0;
							$frm_jumlah=0;
						}
			   }
}
/*
echo "<br>frm_id_grant=".$frm_id_grant; 
echo "<br>frm_nama_instansi=".$frm_nama_instansi; 
echo "<br>frm_jurusan=".$frm_jurusan;
echo "<br>frm_jumlah=".$frm_jumlah; 
echo "<br>frm_tgl_awal=".$frm_tgl_awal;
echo "<br>frm_tgl_akhir=".$frm_tgl_akhir;
echo "<br>frm_exist=".$frm_exist;
*/
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
<form name="form_grant" id="form_grant" action="grant_prodi.php" method="post">
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
				<? if ($frm_id_grant!=''){?>
					<strong>EDIT DATA ~ </strong>
				<? } else
				{?>
					<strong>ENTRY DATA ~ </strong>
				<? }?>
				GRANT PROGRAM STUDI</font></td>
            <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">SCORE CARD</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="7%">&nbsp;</td> 
      <td width="13%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="79%">
		  <input type="hidden" name="frm_id_grant" id="frm_id_grant" value="<?php echo $frm_id_grant;?>">
		  <input type="hidden" name="frm_exist" id="frm_exist" value="<?php echo $frm_exist;?>">
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Nama Instansi </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nama_instansi" type="text" class="tekboxku" id="frm_nama_instansi" value="<?php echo $frm_nama_instansi; ?>" size="50" maxlength="50" >
      <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Jurusan</td>
      <td><strong>:</strong></td>
      <td>
	  <select name="frm_jurusan" id="frm_jurusan" class="tekboxku">
        <option value="0" <?php if ($frm_jurusan==''){echo "selected";}?>>--- Pilih ---</option>
        <?php 
				$sql_jurusan="SELECT * FROM jurusan WHERE id>0 AND id<6";
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
      <td>&nbsp;</td>
      <td>Tanggal Awal </td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_awal" type="text" class="tekboxku" id="frm_tgl_awal" value="<?php echo $frm_tgl_awal; ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('form_grant.frm_tgl_awal',0,0,'DD/MM/YYYY')"> <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy) <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tanggal Akhir </td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_akhir" type="text" class="tekboxku" id="frm_tgl_akhir" value="<?php echo $frm_tgl_akhir; ?>" size="10" maxlength="10" onBlur="document.form_grant.submit()">
        <A Href="javascript:show_calendar('form_grant.frm_tgl_akhir',0,0,'DD/MM/YYYY')"> <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy) <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Jumlah</td>
      <td><strong>:</strong></td>
      <td><input name="frm_jumlah" type="text" class="tekboxku" id="frm_jumlah2" value="<?php echo $frm_jumlah; ?>" size="50" maxlength="50" >
        <font color="#FF0000">*</font></td>
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
		<input name="Submit" type="submit" class="tombol" onClick="this.form.action+='?act=1';this.form.submit();" value="Simpan">
		<input name="Submit2" type="reset" class="tombol" onClick="this.form.action+='?act=3';this.form.submit();" value="Batal">
		<?php if ($frm_id_grant) { ?>
		<input name="Submit3" type="button" class="tombol"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&frm_id_grant=<?php echo $frm_id_grant;?>';this.form.submit()};" value="Hapus">
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