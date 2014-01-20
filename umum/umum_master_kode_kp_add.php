<?php
/* 
   DATE CREATED : 14/04/08 - RAHADI
   KEGUNAAN     : ENTRY MASTER KODE KP
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
	if (($frm_kode_kp=='') or ($frm_nama=='') or ($frm_jurusan=='')) 
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
										 WHERE (master_kode_kp.nama='$frm_nama') AND (master_kode_kp.kode_kp='$frm_kode_kp') ");
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
					$result = mysql_query("INSERT INTO master_kode_kp (`id`, `nama`, `kode_kp`, `jurusan`) VALUES( NULL, '".$frm_nama."', '".$frm_kode_kp."', ".$frm_jurusan.")");
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
							$pesan = $pesan."<br>Gagal menambahkan data-". mysql_error();
							$error = 1;
						}
			}
			
		}
}


// Form dikosongkan siap untuk di isi data baru
if (($act!=0)and($error!=1)) {
	$frm_kode_kp= "";
	$frm_nama = "";
	$frm_jurusan = "";
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
//echo "<br># frm_nama=".$frm_exist;
//echo "<br># frm_jurusan=".$frm_jurusan;
//echo "<br># frm_kode_kp=".$frm_kode_kp;

?>
<form name="form_kode_kp_add" id="form_kode_kp_add" action="umum_master_kode_kp_add.php" method="post">
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
            <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>ENTRY DATA ~</strong> MASTER KODE KERJA PRAKTEK</font></font> </td>
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
      <td width="83%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Jurusan</td>
      <td><strong>:</strong></td>
      <td>
<select name="frm_jurusan" id="frm_jurusan" class="tekboxku">
  <option value="pilih" selected >--- Pilih ---</option>
  <?php
  	             $result2 = mysql_query("SELECT * FROM jurusan WHERE id>0 and id<>9");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["id"].">".$row2["jurusan"];
	             }
         	?>
</select>	  
<span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Nama</td>
      <td><strong>:</strong></td>
      <td>
<input type="text" name="frm_nama" id="frm_nama" class="tekboxku">      
<span class="style1">*</span></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>Kode KP </td>
	  <td><strong>:</strong>      </td>
	  <td><input name="frm_kode_kp" id="frm_kode_kp" type="text" class="tekboxku" size="7" maxlength="6">
      <span class="style1">*</span></td>
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