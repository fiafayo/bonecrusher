<?php
/* 
   DATE CREATED : 13/12/07 - RAHADI
   KEGUNAAN     : MASTER HARI UJIAN UBAH
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
//echo "<br>frm_id_tahun_ajar=".$frm_id_tahun_ajar;

	if (($frm_minggu=='') or ($frm_hari=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data master Hari Ujian dengan benar. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			echo "<br>frm_minggu =".$frm_minggu;
			echo "<br>frm_hari =".$frm_hari;
			//echo "<br>frm_nama_ruang =".$frm_nama_ruang;
			//echo "<br>frm_jenis_ruang =".$frm_jenis_ruang;
			//echo "<br>frm_kapasitas =".$frm_kapasitas;
			$result_cek = mysql_query(" SELECT hari_ujian.id,
											   hari_ujian.minggu_ke,
											   hari_ujian.hari_kode,
											   hari_ujian.hari_nama
										  FROM hari_ujian
										 WHERE (hari_ujian.minggu_ke='$frm_minggu') AND (hari_ujian.hari_kode='$frm_hari') ");
			
			if (mysql_num_rows($result_cek)<>0) 
			{
				$pesan = $pesan."<br>Data Sudah ada, silahkan masukkan data lain";
				//echo "----pesan=".$pesan;
				//exit();
				?>
				<script language="JavaScript">
				  	document.location="umum_master_hari_ujian_ubah.php?kd=<?=$id_data?>&pesan=<?=$pesan?>";
				</script>
				<? 
			}
			else
			{ 
					echo "<br>h E R E";
					//exit();
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
					
					
					$result = mysql_query("UPDATE hari_ujian SET  hari_ujian.minggu_ke=$frm_minggu,
															      hari_ujian.hari_nama='$nama_hari',
																  hari_ujian.hari_kode=$frm_hari
															WHERE hari_ujian.id=$id_data");
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";
							//header("Location: umum_master_hari_ujian.php");
							?>
								<script language="JavaScript">
								  document.location="umum_master_hari_ujian_ubah.php?kd=<?=$id_data?>&pesan=<?=$pesan?>";
								</script>
						    <? 	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menyimpan data";
							?>
								<script language="JavaScript">
								  document.location="umum_master_hari_ujian_ubah.php?kd=<?=$id_data?>&pesan=<?=$pesan?>";
								</script>
						    <? 	
						}
			}
		}
	}


if ($act==2) { // hapus data
$idnya=$_GET['id'];
$result = mysql_query("delete from hari_ujian where id = ".$idnya);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
?>
	<script language="JavaScript">
		document.location="umum_master_hari_ujian.php?pesan=<?=$pesan?>";
	</script>
<?
}	
	
	
// Form dikosongkan siap untuk di isi data baru
if (($act!=0)and($error!=1)) {
	$frm_minggu = "";
	$frm_hari = "";
	//$frm_jenis_ruang = "";
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
$id_data=$_GET["kd"];

if ($id_data<>"")
{
		$result = mysql_query("SELECT hari_ujian.id,
									  hari_ujian.minggu_ke,
									  hari_ujian.hari_kode,
									  hari_ujian.hari_nama
								 FROM hari_ujian
								WHERE hari_ujian.id=$id_data");
		
		if ($row = mysql_fetch_array($result))		
		{  
			$frm_exist=1;
			$frm_minggu = $row["minggu_ke"];
			$frm_hari = $row["hari_nama"];
		}
?>
<form name="form_hari_ujian" id="form_hari_ujian" action="umum_master_hari_ujian_ubah.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><img src="spacer" height="1"></td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000"><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr>
      <td colspan="4"><hr size="1" color="#FF9900">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>SETTING ~</strong> MASTER HARI UJIAN</font></font> </td>
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
      <td width="83%"><input type="hidden" name="id_data" id="id_data" value="<? echo $id_data;?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Minggu ke-</td>
      <td><strong>:</strong></td>
      <td>      
			<select name="frm_minggu" id="frm_minggu" class="tekboxku">
				  <option <?php if ($frm_minggu==''){echo "selected";}?>>--- Pilih ---</option>
				  <?php 
					
					$sqlDosen="select distinct minggu_ke
								 from hari_ujian";
					
					$result = @mysql_query($sqlDosen);
					$c=0;
					while ($row=@mysql_fetch_object($result))  {
					$c=$c+1;
					?>
				  <option value="<?php echo $row->minggu_ke; ?>" <?php if ($frm_minggu==$row->minggu_ke) { echo "selected"; }?> > <?php echo $row->minggu_ke; ?></option>
					<?php
					}
					?>
			</select><span class="style1">*</span>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Hari</td>
      <td><strong>:</strong></td>
      <td>
			<select name="frm_hari" id="frm_hari" class="tekboxku">
				  <option <?php if ($frm_hari==''){echo "selected";}?>>--- Pilih ---</option>
				  <?php 
					
					$sqlDosen="select distinct hari_nama, hari_kode
								 from hari_ujian";
					
					$result = @mysql_query($sqlDosen);
					$c=0;
					while ($row=@mysql_fetch_object($result))  {
					$c=$c+1;
					?>
				  <option value="<?php echo $row->hari_kode; ?>" <?php if ($frm_hari==$row->hari_nama) { echo "selected"; }?> > <?php echo $row->hari_nama; ?></option>
				  <?php
					}
					?>
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
        <?php if ($id_data) { ?>
        <input name="Submit3" type="button" class="tombol"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $id_data;?>';this.form.submit()};" value="Hapus">
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
<? }?>