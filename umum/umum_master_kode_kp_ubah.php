<?php
/* 
   DATE CREATED : 14/04/08 - RAHADI
   KEGUNAAN     : MASTER KODE PRAKTEK EDIT
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
	if (($frm_edit_jurusan=='') or ($frm_edit_nama=='') or ($frm_edit_kode_kp=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data Master Kode Kerja Praktek dengan benar. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			$result_cek = mysql_query(" SELECT master_kode_kp.id,
											   master_kode_kp.nama,
											   master_kode_kp.kode_kp
										  FROM master_kode_kp
										 WHERE (master_kode_kp.nama='$frm_edit_nama') AND (master_kode_kp.kode_kp='$frm_edit_kode_kp') ");
			if (mysql_num_rows($result_cek)<>0) 
			{
				$pesan = $pesan."<br>Data Sudah ada, silahkan masukkan data lain";
				//echo "----pesan=".$pesan;
				//exit();
				?>
				<script language="JavaScript">
				  	document.location="umum_master_kode_kp_ubah.php?kd=<?=$id_data?>&pesan=<?=$pesan?>";
				</script>
				<? 
			}
			else
			{ 
					$result = mysql_query("UPDATE master_kode_kp SET  master_kode_kp.nama='$frm_edit_nama',
															          master_kode_kp.kode_kp='$frm_edit_kode_kp',
																      master_kode_kp.jurusan=$frm_edit_jurusan
															    WHERE master_kode_kp.id=$id_data");
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";
							?>
								<script language="JavaScript">
								  document.location="umum_master_kode_kp_ubah.php?kd=<?=$id_data?>&pesan=<?=$pesan?>";
								</script>
						    <? 	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menyimpan data";
							?>
								<script language="JavaScript">
								  document.location="umum_master_kode_kp_ubah.php?kd=<?=$id_data?>&pesan=<?=$pesan?>";
								</script>
						    <? 	
						}
			}
		}
	}


if ($act==2) { // hapus data
$idnya=$_GET['id'];
$result = mysql_query("DELETE from master_kode_kp WHERE id = ".$idnya);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
?>
	<script language="JavaScript">
		document.location="umum_master_kode_kp.php?pesan=<?=$pesan?>";
	</script>
<?
}	
	
	
// Form dikosongkan siap untuk di isi data baru
if (($act!=0)and($error!=1)) {
	$frm_edit_jurusan = "";
	$frm_edit_nama = "";
	$frm_edit_kode_kp = "";
}

if ($act==3) { // BATAL
//header("Location: umum_master_kode_kp.php");
?>
<script language="JavaScript">
	document.location="umum_master_kode_kp.php";
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
//echo "id_data=".$id_data;

if ($id_data<>"")
{
		$result = mysql_query("SELECT master_kode_kp.id,
									  master_kode_kp.nama,
									  master_kode_kp.kode_kp,
									  master_kode_kp.jurusan
								 FROM master_kode_kp
								WHERE master_kode_kp.id=$id_data");
		
		if ($row = mysql_fetch_array($result))		
		{  
			$frm_exist=1;
			$frm_edit_jurusan = $row["jurusan"];
			$frm_edit_nama = $row["nama"];
			$frm_edit_kode_kp = $row["kode_kp"];
		}
?>
<form name="form_edit_kode_kp" id="form_edit_kode_kp" action="umum_master_kode_kp_ubah.php" method="post">
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
            <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>SETTING ~</strong> EDIT MASTER KODE PRAKTEK</font></font> </td>
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
      <td nowrap>Jurusan</td>
      <td><strong>:</strong></td>
      <td>
	  <select name="frm_edit_jurusan" id="frm_edit_jurusan" class="tekboxku">
	  <option <?php if ($frm_edit_jurusan==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sql_jurusan="SELECT * FROM jurusan WHERE id>0 AND id<>9";
				$result = @mysql_query($sql_jurusan);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->id; ?>" <?php if ($frm_edit_jurusan==$row->id) { echo "selected"; }?> > <?php echo $row->jurusan; ?></option>
          <?php
				}
				?>
      </select>
	  <span class="style1">*</span>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Nama</td>
      <td><strong>:</strong></td>
      <td>
      <span class="style1">
      <input type="text" name="frm_edit_nama" id="frm_edit_nama" class="tekboxku" value="<? echo $frm_edit_nama;?>">
      *</span></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>Kode KP </td>
	  <td><strong>:</strong></td>
	  <td><input name="frm_edit_kode_kp" id="frm_edit_kode_kp" type="text" class="tekboxku" size="7" maxlength="6" value="<? echo $frm_edit_kode_kp;?>"></td>
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