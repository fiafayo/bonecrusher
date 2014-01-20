<?php
/* 
   DATE CREATED : 13/12/07 - RAHADI
   KEGUNAAN     : MASTER JAM UJIAN UBAH
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

	if (($frm_urutan=='') or ($frm_jam=='')) 
		{
			$error = 1;
			if ($jenis=="out")
			{
				$pesan=$pesan."<br>Maaf, anda harus mengisi data jam ujian keluar dengan benar. Gagal menyimpan data.";
			}
			else
			{
				$pesan=$pesan."<br>Maaf, anda harus mengisi data jam ujian masuk dengan benar. Gagal menyimpan data.";
			}
			
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			/*echo "<br>id_data update=".$id_data;
			echo "<br>frm_kode_ruang =".$frm_kode_ruang;
			echo "<br>frm_nama_ruang =".$frm_nama_ruang;
			echo "<br>frm_jenis_ruang =".$frm_jenis_ruang;
			echo "<br>frm_kapasitas =".$frm_kapasitas;*/
			if ($jenis=="out")
		    {
				$result = mysql_query("UPDATE jam_ujian_keluar SET jam_ujian_keluar.jam='$frm_jam',
																   jam_ujian_keluar.nama='$frm_urutan'
															 WHERE jam_ujian_keluar.id=$id_data");
			}
			else
			{
				$result = mysql_query("UPDATE jam_ujian_masuk SET jam_ujian_masuk.jam='$frm_jam',
																  jam_ujian_masuk.nama='$frm_urutan'
															WHERE jam_ujian_masuk.id=$id_data");
			}
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";
							//header("Location: umum_master_ruang.php");
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menyimpan data";
						}
					
					if ($jenis=="out")
					{
					?>
						<script language="JavaScript">
						  document.location="umum_jam_ujian_ubah.php?jns=out&kd=<?=$id_data?>&pesan=<?=$pesan?>";
						</script>
					<? 	
					}
					else
					{
						?>
						<script language="JavaScript">
						  document.location="umum_jam_ujian_ubah.php?kd=<?=$id_data?>&pesan=<?=$pesan?>";
						</script>
						<? 	
					}
		}
	}


if ($act==2) { // hapus data
$idnya=$_GET['id'];
		if ($jenis=="out")
		{
			$result = mysql_query("delete from jam_ujian_keluar where id = ".$idnya);
		}
		else
		{
			$result = mysql_query("delete from jam_ujian_masuk where id = ".$idnya);
		}
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
?>
<script language="JavaScript">
	document.location="umum_jam_ujian.php";
</script>
<?
}	
	
	
// Form dikosongkan siap untuk di isi data baru
if (($act!=0)and($error!=1)) {
	$frm_urutan = "";
	$frm_jam = "";
}

if ($act==3) { 
//header("Location: umum_master_ruang.php");
?>
<script language="JavaScript">
	document.location="umum_jam_ujian.php";
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
		
		$jenis=$_GET['jns'];
		if ($jenis=="out")
		{
			$result = mysql_query("SELECT jam_ujian_keluar.jam,
										  jam_ujian_keluar.nama
									 FROM jam_ujian_keluar
									WHERE jam_ujian_keluar.id=$id_data");
		}
		else
		{
			$result = mysql_query("SELECT jam_ujian_masuk.jam,
										  jam_ujian_masuk.nama
									 FROM jam_ujian_masuk
									WHERE jam_ujian_masuk.id=$id_data");
		}
		
		if ($row = mysql_fetch_array($result))		
		{  
			$frm_exist=1;
			$frm_urutan = $row["nama"];
			$frm_jam = $row["jam"];
			//echo "<br>frm_urutan=".$frm_urutan;
			//echo "<br>frm_jam=".$frm_jam;
		}
?>
<form name="frm_ubah_jam" id="frm_ubah_jam" action="umum_jam_ujian_ubah.php" method="post">
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
            <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>SETTING ~</strong> MASTER JAM UJIAN</font></font> </td>
            <td width="9%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">UMUM</font></strong></div></td>
          </tr>
        </table>
      <hr size="1" color="#FF9900"></td>
    </tr>
    <tr> 
      <td colspan="4" align="center">
	     <font color="#0099CC" size="1"><strong>
	  		<? if ($jenis=="out")
			   { echo "Jam Ujian Keluar";}
			   else
			   { echo "Jam Ujian Masuk";}
			?>
		  </strong></font>   
	  </td>
    </tr>
    <tr>
      <td width="19%">&nbsp;</td> 
      <td width="7%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="73%"><input type="hidden" name="id_data" id="id_data" value="<? echo $id_data;?>">
	  				  <input type="hidden" name="jenis" id="jenis" value="<? echo $jenis;?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Urutan</td>
      <td><strong>:</strong></td>
      <td><?php /*echo "<br>frm_urutan=".$frm_urutan;
	  echo "<br>kd=".$kd;
	  echo "<br>jenis=".$jenis;*/ ?> 
	   <select name="frm_urutan" id="frm_urutan" class="tekboxku">
			<option <?php if ($frm_urutan==''){echo "selected";}?>>--- Pilih ---</option>
			<?php 
			if ($jenis=="out")
			{
				$sqlDosen="select nama
						 	 from jam_ujian_keluar";
			}
			else
			{
				$sqlDosen="select nama
						 	 from jam_ujian_masuk";
			}
			
			$result = @mysql_query($sqlDosen);
			$c=0;
			while ($row=@mysql_fetch_object($result))  {
			$c=$c+1;
			?>
			<option value="<?php echo $row->nama; ?>" <?php if ($frm_urutan==$row->nama) { echo "selected"; }?> > <?php echo $row->nama; ?></option>
			<?php
			}
			?>
        </select>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td nowrap>Pukul</td>
      <td><strong>:</strong></td>
      <td><input name="frm_jam" type="text" class="tekboxku" id="frm_jam" value="<?php echo $frm_jam; ?>" size="5" maxlength="5" >
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