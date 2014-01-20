<?php
/* 
   DATE CREATED : 21/11/07 - RAHADI
   KEGUNAAN     : ENTRY MASTER PENERBIT UJIAN
*/
session_start();
require("../include/global.php");
require("../include/fungsi.php");


f_connecting();
	mysql_select_db($DB);


if ($act==1)   
{ // simpan data
// validasi form

	if ($frm_add_penerbit=='')
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data Master Penerbit dengan benar. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data tidak ada, berarti record baru
			$result_cek = mysql_query(" SELECT penerbit.id,
											   penerbit.penerbit
										  FROM penerbit
										 WHERE penerbit.penerbit='$frm_add_penerbit'");
		    if (mysql_num_rows($result_cek)<>0) 
			{
				$pesan = $pesan."<br>Data Sudah ada, silahkan masukkan data lain";
				//echo "pesan=".$pesan;
				//exit();
				?>
				<script language="JavaScript">
				  //document.location="umum_master_penerbit_add.php";
				</script>
				<? 
			}
			else
			{
						//echo "<br>frm_add_penerbit=".$frm_add_penerbit;
						//echo "<br>frm_hari=".$frm_hari;
						//echo "<br>nama_hari=".$nama_hari;
					$result = mysql_query("INSERT INTO penerbit (`id`, `penerbit`) VALUES( NULL, '".$frm_add_penerbit."')");
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah ditambahkan";
							?>
							<script language="JavaScript">
							  //document.location="umum_master_penerbit_add.php";
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
	$frm_add_penerbit= "";
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
<form name="form_add_penerbit" id="form_add_penerbit" action="umum_master_penerbit_add.php" method="post">
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
            <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>ENTRY DATA ~</strong> MASTER PENERBIT</font></font> </td>
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
      <td width="83%"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Nama Penerbit </td>
      <td><strong>:</strong></td>
      <td>
	  <input type="text" name="frm_add_penerbit" id="frm_add_penerbit" size="50" class="tekboxku">
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