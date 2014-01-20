<?php
/* 
   DATE CREATED : 21/08/10 - RAHADI
   KEGUNAAN     : ENTRY MASTER BIDANG MINAT MAHASISWA
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
	if (($frm_bidang_minat=='') or ($frm_jurusan=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data Master Bidang Minat Mahasiswa dengan benar. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			$result_cek = mysql_query(" SELECT id,
											   jurusan,
											   minat
										  FROM bidang_minat
										 WHERE (minat='$frm_bidang_minat') AND (jurusan=$frm_jurusan) ");
		    if (mysql_num_rows($result_cek)<>0) 
			{
				$pesan = $pesan."<br>Data Sudah ada, silahkan masukkan data lain";
				//echo "pesan=".$pesan;
				//exit();
				?>
				<script language="JavaScript">
				  //document.location="umum_master_bidang_minat_add.php";
				</script>
				<? 
			}
			else
			{
					$result = mysql_query("INSERT INTO bidang_minat (`id`, `jurusan`, `minat`) VALUES( NULL, ".$frm_jurusan.", '".$frm_bidang_minat."')");
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah ditambahkan";
							?>
							<script language="JavaScript">
							  //document.location="umum_master_bidang_minat_add.php";
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
	$frm_bidang_minat = "";
	$frm_jurusan = "";
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
//echo "<br># frm_bidang_minat=".$frm_exist;
//echo "<br># frm_jurusan=".$frm_jurusan;
//echo "<br># frm_kode_kp=".$frm_kode_kp;

?>
<form name="form_bidang_minat_add" id="form_bidang_minat_add" action="umum_master_bidang_minat_add.php" method="post">
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
            <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>ENTRY DATA ~</strong>MASTER BIDANG MINAT MAHASISWA</font></font> </td>
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
      <td nowrap>Bidang Minat </td>
      <td><strong>:</strong></td>
      <td>
<input name="frm_bidang_minat" type="text" class="tekboxku" id="frm_bidang_minat" size="60" maxlength="250">      
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