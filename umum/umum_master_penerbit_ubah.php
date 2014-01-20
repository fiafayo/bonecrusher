<?php
/* 
   DATE CREATED : 13/12/07 - RAHADI
   KEGUNAAN     : MASTER PENERBIT UBAH
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

	if ($frm_edit_nama_penerbit=='') 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data master Penerbit dengan benar. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			//echo "<br>frm_edit_nama_penerbit =".$frm_edit_nama_penerbit;
			//exit();
			//echo "<br>frm_hari =".$frm_hari;
			//echo "<br>frm_nama_ruang =".$frm_nama_ruang;
			//echo "<br>frm_jenis_ruang =".$frm_jenis_ruang;
			//echo "<br>frm_kapasitas =".$frm_kapasitas;
			$result_cek = mysql_query(" SELECT penerbit.id,
											   penerbit.penerbit
										  FROM penerbit
										 WHERE penerbit.penerbit='$frm_edit_nama_penerbit'");
			
			if (mysql_num_rows($result_cek)<>0) 
			{
				$pesan = $pesan."<br>Data Sudah ada, silahkan masukkan data lain";
				//echo "----pesan=".$pesan;
				//exit();
				?>
				<script language="JavaScript">
				  	document.location="umum_master_penerbit_ubah.php?kd=<?=$id_data?>&pesan=<?=$pesan?>";
				</script>
				<? 
			}
			else
			{ 
					
					$result = mysql_query("UPDATE penerbit SET penerbit.penerbit='$frm_edit_nama_penerbit'
														 WHERE penerbit.id=$id_data");
			//echo "<br>frm_edit_nama_penerbit =".$frm_edit_nama_penerbit;
			//echo "<br>id_data =".$id_data;
			//exit();
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";
							//header("Location: umum_master_penerbit.php");
							?>
								<script language="JavaScript">
								  document.location="umum_master_penerbit_ubah.php?kd=<?=$id_data?>&pesan=<?=$pesan?>";
								</script>
						    <? 	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menyimpan data";
							?>
								<script language="JavaScript">
								  document.location="umum_master_penerbit_ubah.php?kd=<?=$id_data?>&pesan=<?=$pesan?>";
								</script>
						    <? 	
						}
			}
		}
	}


if ($act==2) { // hapus data
$idnya=$_GET['id'];
$result = mysql_query("delete from penerbit where id = ".$idnya);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
?>
	<script language="JavaScript">
		document.location="umum_master_penerbit.php?pesan=<?=$pesan?>";
	</script>
<?
}	
	
	
// Form dikosongkan siap untuk di isi data baru
if (($act!=0)and($error!=1)) {
	$frm_edit_nama_penerbit = "";
	$frm_hari = "";
	//$frm_jenis_ruang = "";
}

if ($act==3) { // BATAL
//header("Location: umum_master_penerbit.php");
?>
<script language="JavaScript">
	document.location="umum_master_penerbit.php";
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
		$result = mysql_query("SELECT penerbit.id,
									  penerbit.penerbit
								 FROM penerbit
								WHERE penerbit.id=$id_data");
		
		if ($row = mysql_fetch_array($result))		
		{  
			$frm_exist=1;
			$frm_edit_nama_penerbit = $row["penerbit"];
		}
?>
<form name="form_edit_penerbit" id="form_edit_penerbit" action="umum_master_penerbit_ubah.php" method="post">
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
            <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>SETTING ~</strong> UBAH MASTER PENERBIT</font></font> </td>
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
      <td nowrap>Nama Penerbit</td>
      <td><strong>:</strong></td>
      <td>     
		  <input type="text" class="tekboxku" id="frm_edit_nama_penerbit" name="frm_edit_nama_penerbit" value="<? echo $frm_edit_nama_penerbit;?>" size="50">
		  <span class="style1">*</span>
	  </td>
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