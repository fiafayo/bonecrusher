<?php
/* 
   DATE CREATED : 21/11/07 - RAHADI
   KEGUNAAN     : ENTRY MASTER HARI UJIAN
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/
session_start();
require("../include/global.php");
require("../include/fungsi.php");


f_connecting();
	mysql_select_db($DB);


if ($act==1)   
{ // simpan data
// validasi form
echo "<br>frm_hari=".$frm_hari;
echo "<br>frm_mingggu=".$frm_minggu;

	if (($frm_hari=='') or ($frm_minggu=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data Hari Ujian dengan benar. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			$result_cek = mysql_query(" SELECT hari_ujian.id,
											   hari_ujian.minggu_ke,
											   hari_ujian.hari_kode,
											   hari_ujian.hari_nama
										  FROM hari_ujian
										 WHERE (hari_ujian.minggu_ke='$frm_minggu') AND (hari_ujian.hari_kode='$frm_hari') ");
		    if (mysql_num_rows($result_cek)<>0) 
			{
				$pesan = $pesan."<br>Data Sudah ada, silahkan masukkan data lain";
				//echo "pesan=".$pesan;
				//exit();
				?>
				<script language="JavaScript">
				  //document.location="umum_master_hari_ujian_add.php";
				</script>
				<? 
			}
			else
			{
					switch ($frm_hari) {
						case 1:
							$nama_hari='Senin';
							break;
						case 2:
							$nama_hari='Selasa';
							break;
						case 3:
							$nama_hari='Rabu';
							break;
						case 4:
							$nama_hari='Kamis';
							break;
						case 5:
							$nama_hari='Jumat';
							break;
						case 6:
							$nama_hari='Sabtu';
							break;
						}
						//echo "<br>frm_minggu=".$frm_minggu;
						//echo "<br>frm_hari=".$frm_hari;
						//echo "<br>nama_hari=".$nama_hari;
					$result = mysql_query("INSERT INTO hari_ujian (`id`, `minggu_ke`, `hari_kode`, `hari_nama`) VALUES( NULL, ".$frm_minggu.", ".$frm_hari.", '".$nama_hari."')");
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah ditambahkan";
							?>
							<script language="JavaScript">
							  //document.location="umum_master_hari_ujian_add.php";
							</script>
						    <? 		
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data";
							$error = 1;
						}
			}
			
		}
}


/*if ($act==2) { // hapus data

$result = mysql_query("delete from hari_ujian where id_kota = ".$frm_id_kota);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	*/
	
	
// Form dikosongkan siap untuk di isi data baru
if (($act!=0)and($error!=1)) {
    //$frm_id_kota = "";
	$frm_minggu= "";
	$frm_hari = "";
	$nama_hari = "";
}
if ($act==3) { // BATAL
//header("Location: umum_master_hari_ujian.php");
?>
<script language="JavaScript">
	document.location="umum_master_hari_ujian.php";
</script>
<?
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
<? 
/*echo "<br># frm_exist=".$frm_exist;
echo "<br># frm_s_jurusan=".$frm_s_jurusan;
echo "<br># frm_angkatan=".$frm_angkatan;
echo "<br># frm_id_tahun_ajar=".$frm_id_tahun_ajar;
echo "<br># frm_jumlah_mhs=".$frm_jumlah_mhs;
*/
?>
<form name="form_hari_ujian" id="form_hari_ujian" action="umum_master_hari_ujian_add.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><img src="spacer" height="1"></td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr>
      <td colspan="4"><hr size="1" color="#FF9900">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>ENTRY DATA ~</strong> MASTER HARI UJIAN</font></font> </td>
            <td width="9%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">UMUM</font></strong></div></td>
          </tr>
        </table>
      <hr size="1" color="#FF9900"></td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td width="15%">&nbsp;</td> 
      <td width="15%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="83%"><input type="hidden" name="frm_id_kota" id="frm_id_kota" value="<? echo $frm_id_kota;?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Minggu ke- </td>
      <td><strong>:</strong></td>
      <td>
	  <select name="frm_minggu" id="frm_minggu" class="tekboxku">
        <option>--- Pilih ---</option>\
		<option value="1">1</option>
		<option value="2" >2</option> 
		<option value="3" >3</option>            
      </select>
	  <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Hari</td>
      <td><strong>:</strong></td>
      <td>
	  <select name="frm_hari" id="frm_hari" class="tekboxku">
        <option>--- Pilih ---</option>
		<option value="1">Senin</option>
		<option value="2">Selasa</option>
		<option value="3">Rabu</option>
		<option value="4">Kamis</option>
		<option value="5">Jumat</option>
		<option value="6">Sabtu</option>
      </select>
      <span class="style1">*</span></td>
    </tr>
	<tr>
	  <td>&nbsp;</td> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;	  </td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>
	    <input name="Submit" type="submit" class="tombol" onClick="this.form.action+='?act=1';this.form.submit();" value="Simpan">
        <input name="Submit2" type="reset" class="tombol" onClick="this.form.action+='?act=3';this.form.submit();" value="Batal">
        <?php if ($frm_id_kota) { ?>
        <input name="Submit3" type="button" class="tombol"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_id_kota;?>';this.form.submit()};" value="Hapus">
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