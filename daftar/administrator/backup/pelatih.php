<?
/* 
   DATE CREATED : 04/05/11
   KEGUNAAN     : MENAMPILKAN DATA PELATIH
   VARIABEL     : 
*/
if($session->logged_in){
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);
	

$frm_no_induk_pelatih =  $_POST["frm_no_induk_pelatih"];
$frm_nama   =   $_POST["frm_nama"];
$frm_jenis_kelamin =  $_POST["frm_jenis_kelamin"];
$frm_tempat_lahir =  $_POST["frm_tempat_lahir"];
$frm_tgl_lahir = $_POST["frm_tgl_lahir"];
$frm_alamat   =   $_POST["frm_alamat"];
$frm_kota   =  $_POST["frm_kota"];
$frm_propinsi   =   $_POST["frm_propinsi"];
$frm_email   =   $_POST["frm_email"];
$frm_exist = $_POST['frm_exist'];
$act = $_GET['act'];

/*
echo "<br>frm_no_induk_pelatih=".$frm_no_induk_pelatih;
echo "<br>frm_nama=".$frm_nama;
echo "<br>frm_jenis_kelamin=".$frm_jenis_kelamin;
echo "<br>frm_tempat_lahir=".$frm_tempat_lahir;
echo "<br>frm_tgl_lahir=".$frm_tgl_lahir;
echo "<br>frm_alamat=".$frm_alamat;

echo "<br>frm_kota=".$frm_kota;
echo "<br>frm_propinsi=".$frm_propinsi;
echo "<br>frm_email=".$frm_email;

echo "<br>act=".$act;
echo "<br>frm_exist=".$frm_exist;
*/
if ($act==1)   // INSERT
{ // simpan data


// NRP dan NAMA harus diisi
	if (($frm_no_induk_pelatih=='') or ($frm_nama=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi Data Pelatih dengan lengkap . Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
			$result_cek = mysql_query("SELECT nama, no_induk_pelatih
						 				 FROM pelatih 
										WHERE no_induk_pelatih='".$_POST['frm_no_induk_pelatih']."'");
						
			$jumlah_rows=mysql_num_rows($result_cek);
			//echo "<br>jumlah_rows=".$jumlah_rows;
			if ($jumlah_rows!=1) 
				{
			
		// data id tidak ada, berarti record baru
					$result = mysql_query("INSERT INTO pelatih (no_induk_pelatih, nama, kelamin, tempat_lahir, tanggal_lahir, alamat, kota_pelatih, propinsi_pelatih, email)VALUES('".$frm_no_induk_pelatih."', '".$frm_nama."', '".$frm_jenis_kelamin."', '".$frm_tempat_lahir."', '".datetomysql($frm_tgl_lahir)."', '".$frm_alamat."', '".$frm_kota."', '".$frm_propinsi."', '".$frm_email."')" );
  				    if ($result) 
						{
							$pesan = $pesan."<br>Data telah ditambahkan";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data". mysql_error();
						}
				}
			else
				{
					$result = mysql_query(" UPDATE pelatih SET  `nama` = '$frm_nama',
																`kelamin` = '$frm_jenis_kelamin',
																`tempat_lahir` = $frm_tempat_lahir,
																`tanggal_lahir` = '".datetomysql($frm_tgl_lahir)."',
																`alamat` = '$frm_alamat', 
																`kota_pelatih` = $frm_kota,
																`propinsi_pelatih` = $frm_propinsi,
																`email`= '$frm_email'
													      WHERE `no_induk_pelatih` = '$frm_no_induk_pelatih'");
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal mengubah data - ". mysql_error();
						}
				}
		}
	}


if ($act==2) { // hapus data

$result = mysql_query("DELETE FROM pelatih WHERE no_induk_pelatih = '".$frm_no_induk_pelatih."'");
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
	//header("Location: {$_SERVER['PHP_SELF']}");
	?>
    <script language="javascript">//confirmRefresh();
	    alert ('Data Pelatih <? echo $frm_nama;?> telah di Hapus.');
		document.location="index.php?menu=pelatih";    
    </script>
    <?
}

if ($act==3) { // RESET FORM
	
	$frm_no_induk_pelatih = "";
	$frm_nama = "";
	$frm_jenis_kelamin =  "";
	$frm_tempat_lahir =  "";
	$frm_tgl_lahir =  "";
	$frm_alamat =  "";
	$frm_kota =  "";
	$frm_propinsi =  "";
	$frm_email =  "";
	$frm_exist = 0;
							
}
	
// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	//$frm_nama = "";
	//$frm_kelamin = "";						
	//$frm_tempat_lahir = "";
	//$frm_tgl_lahir = "";
	
	//$frm_alamat_sekarang = "";
	//$frm_zip_sekarang = "";
	
	//$frm_telepon_sekarang = "";
	//$frm_hp = "";
	//$frm_email = "";
	
	//$frm_nama_ortu = "";
	//$frm_alamat_ortu = "";
	//$frm_telepon_ortu = "";
	//$frm_zip_ortu = "";
}
else
{
// Jika user mengisi form NRP, di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
//echo "<br>frm_nama=".$_POST['frm_nama'];
if ($frm_nama!='')  {
  $result = mysql_query("SELECT `no_induk_pelatih`,
								`nama`,
								`kelamin`,
								`tempat_lahir`,
	   						    DATE_FORMAT(`tanggal_lahir`,'%d/%m/%Y') as tanggal_lahir,
								`alamat`, 
								`kota_pelatih`,
								`propinsi_pelatih`,
								`email`
						 FROM pelatih 
						WHERE nama='".$_POST['frm_nama']."'");

						if ($row = mysql_fetch_array($result)) {
							$frm_exist=1;
							$frm_no_induk_pelatih =  $row["no_induk_pelatih"];
							$frm_nama   =   $row["nama"];
							$frm_jenis_kelamin =  $row["kelamin"];
							$frm_tempat_lahir =  $row["tempat_lahir"];
							$frm_tgl_lahir =  $row["tanggal_lahir"];
							$frm_alamat   =   $row["alamat"];
							$frm_kota   =  $row["kota_pelatih"];
							$frm_propinsi   =   $row["propinsi_pelatih"];
							$frm_email   =   $row["email"];
							
							
														
						}else
						{
							//$frm_exist=0;
							//$pesan = $pesan."Nomor ID Kota yang Anda masukkan tidak ada di database";
							
							//$frm_no_ID_kota = "";
							//$frm_propinsi = "";
						}
	
}


}

	
?>
<link type="text/css" href="../jquery/themes/base/ui.all.css" rel="stylesheet" />
<script language="javascript">
function proses()
{
	document.forms["form_pelatih"].submit();
	}
</script>

<script language="javascript" type="text/javascript" >
<!--
function confirmRefresh() {
var okToRefresh = confirm("Do you really want to refresh the page?");
if (okToRefresh)
	{
			setTimeout("location.reload(true);",1500);
	}
}
// -->
</script>
<script type="text/javascript" src="../jquery/jquery-1.4.4.js"></script>
<script type="text/javascript" src="../jquery/ui/jquery.ui.core.js"></script>
<script  type="text/javascript" src="../jquery/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
			$("#frm_tgl_lahir").datepicker( {
										   dateFormat : "dd/mm/yy",
										   changeMonth: true,
										   changeYear: true
										   });
							   });
</script>



<table width="90%" border="1">
  <tr>
    <th scope="col"><? echo $pesan;?></th>
  </tr>
  <tr>
    <td>
    <form id="form_pelatih" name="form_pelatih" action="index.php?menu=pelatih" method="post">
    <table width="95%" border="0" align="center">
      <tr>
        <td>Nama Pelatih</td>
        <td>:</td>
        <td><input type="text" name="frm_nama" id="frm_nama" value="<?=$frm_nama;?>" onchange="proses();"/></td>
      </tr>
      <tr>
        <td>No. Induk Pelatih</td>
        <td>:</td>
        <td>
          <input type="text" name="frm_no_induk_pelatih" id="frm_no_induk_pelatih" value="<?=$frm_no_induk_pelatih;?>" />
          </td>
      </tr>
      <tr>
        <td>Jenis kelamin</td>
        <td>:</td>
        <td>
          <label>
            <input type="radio" name="frm_jenis_kelamin" value="Pria" id="frm_jenis_kelamin" <? if ($frm_jenis_kelamin=="Pria") echo "checked";?> />
            Pria</label>
          <label>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="frm_jenis_kelamin" value="Wanita" id="frm_jenis_kelamin" <? if ($frm_jenis_kelamin=="Wanita") echo "checked";?> />
            Wanita</label>
          </td>
      </tr>
      <tr>
        <td>Tempat Lahir</td>
        <td>:</td>
        <td>
          <select name="frm_tempat_lahir" id="frm_tempat_lahir" class="tekboxku">
	    <option <?php if ($frm_tempat_lahir==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sql_tmpt_lahir="SELECT * FROM kota";
				$result = @mysql_query($sql_tmpt_lahir);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->id_kota; ?>" <?php if ($frm_kota==$row->id_kota) { echo "selected"; }?>> <?php echo $row->nama; ?></option>
          <?php
				}
				?>
      	</select>
        </td>
      </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td><input type="text" name="frm_tgl_lahir" id="frm_tgl_lahir"  value="<?=$frm_tgl_lahir;?>"/></td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><input type="text" name="frm_alamat" id="frm_alamat" value="<?=$frm_alamat;?>" /></td>
      </tr>
      <tr>
        <td>Kota</td>
        <td>:</td>
        <td>
        	<select name="frm_kota" id="frm_kota" class="tekboxku">
	    <option <?php if ($frm_kota==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sql_kota="SELECT * FROM kota";
				$result = @mysql_query($sql_kota);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->id_kota; ?>" <?php if ($frm_kota==$row->id_kota) { echo "selected"; }?>> <?php echo $row->nama; ?></option>
          <?php
				}
				?>
      	</select>
        </td>
      </tr>
      <tr>
        <td>Propinsi</td>
        <td>:</td>
        <td>
        	<select name="frm_propinsi" id="frm_propinsi" class="tekboxku">
            <option <?php if ($frm_propinsi==''){echo "selected";}?>>--- Pilih ---</option>
              <?php 
                    $sql_propinsi="SELECT * FROM propinsi";
                    $result = @mysql_query($sql_propinsi);
                    $c=0;
                    while ($row=@mysql_fetch_object($result))  {
                    $c=$c+1;
                    ?>
              <option value="<?php echo $row->id_propinsi; ?>" <?php if ($frm_propinsi==$row->id_propinsi) { echo "selected"; }?>> <?php echo $row->nama; ?>			</option>
              <?php
                    }
                    ?>
          </select>
        </td>
      </tr>
      <tr>
        <td>E-mail</td>
        <td>:</td>
        <td><input type="text" name="frm_email" id="frm_email" value="<?=$frm_email;?>" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>
            <input name="frm_simpan" id="frm_simpan" type="submit" onClick="this.form.action+='&act=1';this.form.submit();" value="Simpan">
            <input name="Submit2" type="reset" onClick="this.form.action+='&act=3';this.form.submit();" value="Batal">
            <? if ($frm_no_induk_pelatih) { ?>
            <input name="frm_hapus" id="frm_hapus" type="submit" onClick="if(confirm('Hapus ?')){this.form.action+='&act=2&id=<?php echo $frm_no_induk_pelatih;?>';this.form.submit()};" value="Hapus">
        <? } ?>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </form>
    </td>
  </tr>
</table>
<?
}
else
{
	header('Location: ../process.php');
}?>
