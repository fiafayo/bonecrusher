<?php
/* 
   DATE CREATED : 05/08/03 - RAHADI
   KEGUNAAN     : ENTRY MASTER KOTA
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
	if (($frm_nama_kota=='') or ($frm_id_propinsi=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data kota dengan benar. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
		echo "<br>ID KOTA=".$frm_id_kota;
			if ($frm_id_kota=='')  
				{
					$result = mysql_query("INSERT INTO kota (`nama_kota`, `kode_area`, `id_propinsi`) VALUES( '".$frm_nama_kota."', '".$frm_kode_area."', '".$frm_id_propinsi."')");
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
					echo "<br>disini";
					echo "<br>frm_id_kota-->".$frm_id_kota;
					//exit();
					$result = mysql_query("UPDATE kota SET `nama_kota`='$frm_nama_kota', `kode_area`='$frm_kode_area', `id_propinsi` ='$frm_id_propinsi' where `id_kota`=$frm_id_kota");
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

$result = mysql_query("delete from kota where id_kota = ".$frm_id_kota);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
	
// Form dikosongkan siap untuk di isi data baru
if (($act!=0)and($error!=1)) {
    //$frm_id_kota = "";
	
	$frm_nama_kota= "";
	$frm_id_propinsi = "";
	$frm_kode_area = "";
}
else
{
// jika user mengisi nama kota, check apakah nama kota sudah ada, kalau sudah ada maka data akan ditampilkan
	if ($frm_nama_kota!='')  {
			$result = mysql_query("Select id_kota, 
										  nama_kota, 
										  kode_area, 
										  id_propinsi 
									from kota 
									where nama_kota='$frm_nama_kota'");
			
			if ($row = mysql_fetch_array($result))		
			{   echo "<br>ada";
			    $frm_exist=1;
				$frm_id_kota = $row["id_kota"];
				$frm_nama_kota = $row["nama_kota"];
				$frm_id_propinsi = $row["id_propinsi"];
				$frm_kode_area = $row["kode_area"];
				$frm_id_propinsi2 = $frm_id_propinsi;
				/*echo "<br>@ frm_exist=".$frm_exist;
				echo "<br>@ frm_id_kota=".$frm_id_kota;
				echo "<br>@ frm_nama_kota=".$frm_nama_kota;
				echo "<br>@ frm_id_propinsi=".$frm_id_propinsi;
				echo "<br>@ frm_kode_area=".$frm_kode_area;
				echo "<br>@ frm_id_propinsi2=".$frm_id_propinsi2;*/
			}
			else
			{
				//echo "<BR>H E R E ";
				$frm_exist = 0;
				$frm_id_kota = "";
			    $frm_kode_area = "";
				$frm_id_propinsi = "";
			}
	}
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
/*
echo "<br># frm_exist=".$frm_exist;
echo "<br># frm_id_kota=".$frm_id_kota;
echo "<br># frm_nama_kota=".$frm_nama_kota;
echo "<br># frm_id_propinsi=".$frm_id_propinsi;
echo "<br># frm_kode_area=".$frm_kode_area;
*/
?>
<form name="umum_kota" id="umum_kota" action="umum_kota.php" method="post">
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
            <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>ENTRY DATA ~</strong> MASTER KOTA </font></font> </td>
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
      <td width="83%"><input type="hidden" name="frm_id_kota" id="frm_id_kota" value="<? echo $frm_id_kota;?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nama</td>
      <td><strong>:</strong></td>
      <td><input name="frm_nama_kota" type="text" class="tekboxku" id="frm_nama_kota" onBlur="document.umum_kota.submit()" value="<?php echo $frm_nama_kota; ?>" size="50" maxlength="100" >
      <span class="style1">*</span></td>
    </tr>
	<tr>
	  <td>&nbsp;</td> 
      <td>Propinsi</td>
      <td><strong>:</strong></td>
      <td>
	  <select name="frm_id_propinsi" id="frm_id_propinsi" class="tekboxku">
		  <?php
			$result1 = @mysql_query("Select id_propinsi, nama_propinsi from propinsi");
			$c=0;
			while ($row1=@mysql_fetch_object($result1))  {
			$c=$c+1;
			?>
				  <option value="<?php echo $row1->id_propinsi; ?>" <?php if (($frm_id_propinsi2==$row1->id_propinsi) or (($frm_id_propinsi='') and ($c==1))) { echo "selected"; }?> ><?php echo $row1->nama_propinsi ?></option>
		    <?php
			}
			?>
        </select>
        <span class="style1">*</span></td>
    </tr>
	
    <tr>
      <td>&nbsp;</td> 
      <td>Kode Area</td>
      <td><strong>:</strong></td>
      <td><input name="frm_kode_area" type="text" class="tekboxku" id="frm_kode_area" value="<?php echo $frm_kode_area; ?>" size="50" maxlength="50"> 
        <span class="style1">*</span> </td>
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
        <?php if ($frm_id_kota) { ?>
        <input name="Submit3" type="button" class="tombol"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_id_kota;?>';this.form.submit()};" value="Hapus">
        <?php } ?></td>
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