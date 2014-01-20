<?php
/* 
   DATE CREATED : 12/11/07 - RAHADI
   KEGUNAAN     : ENTRY DATA MASTER PROPINSI
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
echo "<br>frm_nama_propinsi=".$frm_nama_propinsi;
echo "<br>frm_jawa=".$frm_jawa;
echo "<br>frm_indo_timur=".$frm_indo_timur;

	if ($frm_nama_propinsi=='') 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi data propinsi dengan benar. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id_propinsi tidak ada, berarti record baru
			if ($frm_id_propinsi=='') 
				{
					$result = mysql_query("INSERT INTO propinsi(`id_propinsi`, `nama_propinsi`, `jawa`, `indo_timur`) VALUES ( NULL, '".$frm_nama_propinsi."', '".$frm_jawa."', '".$frm_indo_timur."') " );
//$pesan=$pesan."INSERT INTO master_ruang ( `id` , `kode` , `nama` , `tipe` , `kapasitas` , `luas` ) VALUES ( '', '".$frm_kode."', '".$frm_nama_propinsi."', '".$frm_tipe."', '".$frm_kapasitas."', '".$frm_luas."') " ;
	
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah ditambahkan";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data";
						}
						
				}
			else
				{

					$result = mysql_query("UPDATE propinsi set `nama_propinsi`='$frm_nama_propinsi' ,  `jawa`='$frm_jawa' , `indo_timur`='$frm_indo_timur'  where `id_propinsi`=$frm_id_propinsi");
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menyimpan data";
						}
				}
		}
	}


if ($act==2) { // hapus data

$result = mysql_query("delete from propinsi where id_propinsi = ".$frm_id_propinsi);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
	
if (($act!=0)and($error!=1)) {
	$frm_id_propinsi="";
	$frm_nama_propinsi = "";
	$frm_jawa="";
	$frm_indo_timur="";
	
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_nama_propinsi!='')  {
$result = mysql_query("Select id_propinsi, nama_propinsi, jawa, indo_timur from propinsi where nama_propinsi='".$frm_nama_propinsi."'");

$row = @mysql_fetch_array($result);
	$frm_id_propinsi = $row["id_propinsi"];
	$frm_nama_propinsi = $row["nama_propinsi"];
	$frm_jawa = $row["jawa"];
	$frm_indo_timur =$row["indo_timur"];
}
}

?>
<html>
<head>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style2 {color: #FF0000}
-->
</style>
</head>
<script language="JavaScript" src="../include/tanggalan.js">
</script>
<body class="body">
<form name="umum_propinsi" id="umum_propinsi" action="umum_propinsi.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><img src="spacer" height="1"></td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000"><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr>
      <td colspan="4">
	  <hr size="1" color="#FF9900">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>ENTRY DATA ~</strong> MASTER PROPINSI</font></font> </td>
            <td width="9%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">UMUM</font></strong></div></td>
          </tr>
        </table>
		<hr size="1" color="#FF9900">	  
		</td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td width="127">&nbsp;</td> 
      <td width="122">&nbsp;</td>
      <td width="6">&nbsp;</td>
      <td width="718">&nbsp; <input type="hidden" name="frm_id_propinsi" id="frm_id_propinsi" value="<?php echo $frm_id_propinsi;?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td nowrap>Nama Propinsi</td>
      <td><strong>:</strong></td>
      <td><input name="frm_nama_propinsi" type="text" class="tekboxku" id="frm_nama_propinsi" onBlur="document.umum_propinsi.submit()" value="<?php echo $frm_nama_propinsi; ?>" size="50" maxlength="50">
        <span class="style2">*</span> </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Pulau</td>
      <td><strong>:</strong></td>
      <td><input name="frm_jawa" type="radio" value="Y" <?php if (($frm_jawa=='') or ($frm_jawa=='Y')) { echo  "checked"; }?> >
        Jawa 
		 <!--input name="frm_tipe" type="radio" value="N" <?php //if ($frm_tipe=='N') { echo  "checked"; }?>-->
        <input name="frm_jawa" type="radio" value="N" <?php if ($frm_jawa=='N') { echo  "checked"; }?>>
        Luar Jawa <span class="style2">*</span></td>
    </tr>
	
    <tr>
      <td>&nbsp;</td> 
      <td>Bagian</td>
      <td><strong>:</strong></td>
      <td><input name="frm_indo_timur" id="frm_indo_timur" type="radio" value="N" <?php if (($frm_indo_timur=='') or ($frm_indo_timur=='N')) { echo  "checked"; }?> >
        Indonesia Bagian Barat 
        <input name="frm_indo_timur" id="frm_indo_timur" type="radio" value="Y" <?php if ($frm_indo_timur=='Y') { echo  "checked"; }?>>
        Indonesia Bagian Timur <span class="style2">*</span></td>
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
      <td><input name="Submit" type="submit" class="tombol" onClick="this.form.action+='?act=1';this.form.submit();" value="Simpan">
        <input name="Submit2" type="reset" class="tombol" onClick="this.form.action+='?act=3';this.form.submit();" value="Batal">
        <?php if ($frm_id_propinsi) { ?>
        <input name="Submit3" type="button" class="tombol"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_id_propinsi;?>';this.form.submit()};" value="Hapus">
        <?php } ?></td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;      </td>
    </tr>
    <tr>
      <td colspan="4"><font size="1"><span class="style2">*</span> compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>