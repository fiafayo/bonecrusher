<?php
/* 
   DATE CREATED : 13/12/07 - RAHADI
   KEGUNAAN     : MASTER RUANG UBAH
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

	if (($frm_kode_ruang=='') or ($frm_nama_ruang=='') or ($frm_jenis_ruang=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi Data Master Ruang dengan benar. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			echo "<br>id_data update =".$id_data;
			echo "<br>frm_kode_ruang =".$frm_kode_ruang;
			echo "<br>frm_nama_ruang =".$frm_nama_ruang;
			echo "<br>frm_jenis_ruang =".$frm_jenis_ruang;
			echo "<br>frm_kapasitas =".$frm_kapasitas;
			echo "<br>frm_projector =".$frm_projector;
			echo "<br>frm_computer =".$frm_computer;
			echo "<br>frm_mic =".$frm_mic;
			echo "<br>frm_speaker =".$frm_speaker;
			//exit();
			if ($frm_kapasitas == "") {
				$frm_kapasitas = 0;
			}
					$result = mysql_query("UPDATE master_ruang SET  master_ruang.kode='$frm_kode_ruang',
																	master_ruang.nama='$frm_nama_ruang',
																	master_ruang.tipe='$frm_jenis_ruang',
																	master_ruang.kapasitas=$frm_kapasitas,
																	master_ruang.LCD='$frm_projector',
																	master_ruang.komputer='$frm_computer',
																	master_ruang.mic='$frm_mic',
																	master_ruang.speaker='$frm_speaker'
															  WHERE master_ruang.id=$id_data");
			  
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";
							//header("Location: umum_master_ruang.php");
							?>
								<script language="JavaScript">
								  document.location="umum_master_ruang_ubah.php?kd=<?=$id_data?>&pesan=<?=$pesan?>";
								</script>
						    <? 	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menyimpan data";
							$error = 1;
							?>
								<script language="JavaScript">
								  document.location="umum_master_ruang_ubah.php?kd=<?=$id_data?>&pesan=<?=$pesan?>";
								</script>
						    <? 	
						}
		}
	}


if ($act==2) { // hapus data
//$id_data=$_GET['id'];
$result = mysql_query("delete from master_ruang where  id = ".$id_data);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
	
// Form dikosongkan siap untuk di isi data baru
if (($act!=0)and($error!=1)) {
	$frm_kode_ruang = "";
	$frm_nama_ruang = "";
	$frm_jenis_ruang = "";
	$frm_kapasitas = "";
	$frm_projector = "";
	$frm_computer = "";
	$frm_mic = "";
	$frm_speaker = "";
}

if ($act==3) { 
//header("Location: umum_master_ruang.php");
?>
<script language="JavaScript">
	document.location="umum_master_ruang.php";
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
//echo "<br>kode= ".$id_data;

if ($id_data<>"")
{
		$result = mysql_query("SELECT master_ruang.kode,
									  master_ruang.nama,
									  master_ruang.tipe,
									  master_ruang.kapasitas,
									  master_ruang.luas,
									  master_ruang.LCD,
									  master_ruang.komputer,
									  master_ruang.mic,
									  master_ruang.speaker
								 FROM master_ruang
								WHERE master_ruang.id=$id_data");
		
		if ($row = mysql_fetch_array($result))		
		{  
			$frm_exist=1;
			$frm_kode_ruang = $row["kode"];
			$frm_nama_ruang = $row["nama"];
			$frm_jenis_ruang = $row["tipe"];
			$frm_kapasitas = $row["kapasitas"];
			$frm_projector = $row["LCD"];
			$frm_computer = $row["komputer"];
			$frm_mic = $row["mic"];
			$frm_speaker = $row["speaker"];
		}
?>
<form name="frm_master_ruang" id="frm_master_ruang" action="umum_master_ruang_ubah.php" method="post">
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
            <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>SETTING ~</strong> MASTER RUANG</font></font> </td>
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
      <td>Kode Ruang </td>
      <td><strong>:</strong></td>
      <td>
        <input name="frm_kode_ruang" type="text" class="tekboxku" id="frm_kode_ruang" value="<?php echo $frm_kode_ruang; ?>" size="12" maxlength="10" >
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Nama Ruang </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nama_ruang" type="text" class="tekboxku" id="frm_nama_ruang" value="<?php echo $frm_nama_ruang; ?>" size="60" maxlength="254" >
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Jenis Ruang </td>
      <td><strong>:</strong></td>
      <td>
	  <select name="frm_jenis_ruang" id="frm_jenis_ruang" class="tekboxku">
        <option value="R" <? if ($frm_jenis_ruang=='R'){ echo "selected";}?>>Ruang</option>
        <option value="L" <? if ($frm_jenis_ruang=='L'){ echo "selected";}?>>Laboratorium</option>
      </select>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td nowrap>Kapasitas Ruang</td>
      <td><strong>:</strong></td>
      <td><input name="frm_kapasitas" type="text" class="tekboxku" id="frm_kapasitas" value="<?php echo $frm_kapasitas; ?>" size="5" maxlength="3" >
      <span class="style1">*</span></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>Projector</td>
	  <td><strong>:</strong></td>
	  <td>
		  <select name="frm_projector" id="frm_projector" class="tekboxku">
		  	<option value="T" <? if ($frm_projector=="T") echo "Selected";?>>Tidak Ada</option>
			<option value="Y" <? if ($frm_projector=="Y") echo "Selected";?>>Ada</option>
		  </select>
	  </td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>Computer</td>
	  <td><strong>:</strong></td>
	  <td>
	  	  <select name="frm_computer" id="frm_computer" class="tekboxku">
		  	<option value="T" <? if ($frm_computer=="T") echo "Selected";?>>Tidak Ada</option>
			<option value="Y" <? if ($frm_computer=="Y") echo "Selected";?>>Ada</option>
		  </select>
	  </td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>Microphone</td>
	  <td><strong>:</strong></td>
	  <td>
	      <select name="frm_mic" id="frm_mic" class="tekboxku">
		  	<option value="T" <? if ($frm_mic=="T") echo "Selected";?>>Tidak Ada</option>
			<option value="Y" <? if ($frm_mic=="Y") echo "Selected";?>>Ada</option>
		  </select>
	  </td>
    </tr>
	<tr>
	  <td>&nbsp;</td> 
      <td>Speaker</td>
      <td><strong>:</strong></td>
      <td>
	      <select name="frm_speaker" id="frm_speaker" class="tekboxku">
		  	<option value="T" <? if ($frm_speaker=="T") echo "Selected";?>>Tidak Ada</option>
			<option value="Y" <? if ($frm_speaker=="Y") echo "Selected";?>>Ada</option>
		  </select>
	  </td>
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
        <?php if ($id_data) { ?>
        <input name="Submit3" type="button" class="tombol" onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&kd=<?php echo $id_data;?>';this.form.submit()};" value="Hapus">
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