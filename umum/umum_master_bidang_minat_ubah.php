<?php
/* 
   DATE CREATED : 21/08/10 - RAHADI
   KEGUNAAN     : MASTER BIDANG MINAT EDIT
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
	if (($frm_edit_jurusan=='') or ($frm_edit_bidang_minat=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi data Master Bidang Minat Mahasiswa dengan benar. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			$result_cek = mysql_query(" SELECT id,
											   jurusan,
											   minat
										  FROM bidang_minat
										 WHERE (minat='$frm_edit_bidang_minat')");
			if (mysql_num_rows($result_cek)<>0) 
			{
				$pesan = $pesan."<br>Data Sudah ada, silahkan masukkan data lain";
				//echo "----pesan=".$pesan;
				//exit();
				?>
				<script language="JavaScript">
				  	document.location="umum_master_bidang_minat_ubah.php?kd=<?=$id_data?>&pesan=<?=$pesan?>";
				</script>
				<? 
			}
			else
			{ 
					$result = mysql_query("UPDATE bidang_minat SET  minat='$frm_edit_bidang_minat',
																    jurusan=$frm_edit_jurusan
															  WHERE id=$id_data");
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";
							?>
								<script language="JavaScript">
								  document.location="umum_master_bidang_minat_ubah.php?kd=<?=$id_data?>&pesan=<?=$pesan?>";
								</script>
						    <? 	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menyimpan data";
							?>
								<script language="JavaScript">
								  document.location="umum_master_bidang_minat_ubah.php?kd=<?=$id_data?>&pesan=<?=$pesan?>";
								</script>
						    <? 	
						}
			}
		}
	}


if ($act==2) { // hapus data
$idnya=$_GET['id'];
$result = mysql_query("DELETE FROM bidang_minat WHERE id = ".$idnya);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
?>
	<script language="JavaScript">
		document.location="umum_master_bidang_minat.php?pesan=<?=$pesan?>";
	</script>
<?
}	
	
	
// Form dikosongkan siap untuk di isi data baru
if (($act!=0)and($error!=1)) {
	$frm_edit_jurusan = "";
	$frm_edit_bidang_minat = "";
}

if ($act==3) { // BATAL
//header("Location: umum_master_bidang_minat.php");
?>
<script language="JavaScript">
	document.location="umum_master_bidang_minat.php";
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
		$result = mysql_query("SELECT id,
									  jurusan,
									  minat
								 FROM bidang_minat
								WHERE id=$id_data");
		
		if ($row = mysql_fetch_array($result))		
		{  
			$frm_exist=1;
			$frm_edit_jurusan = $row["jurusan"];
			$frm_edit_bidang_minat = $row["minat"];
		}
?>
<form name="form_edit_bidang_minat" id="form_edit_bidang_minat" action="umum_master_bidang_minat_ubah.php" method="post">
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
            <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>SETTING ~</strong> EDIT MASTER BIDANG MINAT</font></font> </td>
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
      <input name="frm_edit_bidang_minat" type="text" class="tekboxku" id="frm_edit_bidang_minat" value="<? echo $frm_edit_bidang_minat;?>" size="60" maxlength="250">
      *</span></td>
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
	<tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
	<tr> 
        <td colspan="4">
			<div align="center">
				<font size="1">
					<a href="umum_master_bidang_minat.php">Lihat Daftar Bidang Minat Mahasiswa</a>&nbsp;
				</font>
			</div>
		</td>
    </tr>
  </table>
</form>
</body>
</html>
<? }?>