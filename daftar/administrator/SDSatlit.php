<?
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);
	
//echo "<br>frm_tgl_lahir=".$_POST['frm_tgl_lahir'];

$frm_no_induk_atlit = $_POST['frm_no_induk_atlit'];
$frm_nama = $_POST['frm_nama'];
$frm_jenis_kelamin = $_POST['frm_jenis_kelamin'];						
$frm_tempat_lahir = $_POST['frm_tempat_lahir'];
$frm_tgl_lahir = $_POST['frm_tgl_lahir'];

$frm_alamat = $_POST['frm_alamat'];
$frm_kota = $_POST['frm_kota'];
$frm_propinsi = $_POST['frm_propinsi'];
$frm_email = $_POST['frm_email'];

$frm_club = $_POST['frm_club'];
$frm_gabungan = $_POST['frm_gabungan'];
$frm_exist = $_POST['frm_exist'];
$act = $_GET['act'];

/*echo "<br>frm_jenis_kelamin=".$frm_jenis_kelamin;
echo "<br>frm_tempat_lahir=".$frm_tempat_lahir;
echo "<br>frm_tgl_lahir=".$frm_tgl_lahir;
echo "<br>act=".$act;
echo "<br>frm_exist=".$frm_exist;*/

if ($act==1)   // INSERT
{ // simpan data
	// validasi tanggal
	/*
	if ($frm_tgl_lahir!='') 
		{
			if (datetomysql($frm_tgl_lahir)) 
				{
					$frm_tgl_lahir = datetomysql($frm_tgl_lahir);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal lahir tidak valid";
				}
		}*/


// NRP dan NAMA harus diisi
	if (($frm_no_induk_atlit=='') or ($frm_nama=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi Data Atlit dengan lengkap. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
			
			$result_cek = mysql_query("SELECT nama, no_induk_atlit
						 				 FROM atlit 
										WHERE no_induk_atlit=".$_POST['frm_no_induk_atlit']);
						
			$jumlah_rows=mysql_num_rows($result_cek);
			//echo "<br>jumlah_rows=".$jumlah_rows;
			if ($jumlah_rows!=1) 
				{
			
		// data id tidak ada, berarti record baru
					$result = mysql_query("INSERT INTO atlit (no_induk_atlit, nama, kelamin, tempat_lahir, tanggal_lahir, alamat, kota_atlit, propinsi_atlit, email, club, gabungan)VALUES('".$frm_no_induk_atlit."', '".$frm_nama."', '".$frm_jenis_kelamin."', '".$frm_tempat_lahir."', '".datetomysql($frm_tgl_lahir)."', '".$frm_alamat."', '".$frm_kota."', '".$frm_propinsi."', '".$frm_email."', '".$frm_club."', '".$frm_gabungan."') " );
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
					$result = mysql_query(" UPDATE atlit SET `nama` = '$frm_nama', 
															 `kelamin` = '$frm_jenis_kelamin' , 
															 `tempat_lahir` = $frm_tempat_lahir , 
															 `tanggal_lahir` = '".datetomysql($frm_tgl_lahir)."' , 
															 `alamat` = '$frm_alamat',
															 `kota_atlit` = $frm_kota,
															 `propinsi_atlit` = $frm_propinsi, 
															 `email` = '$frm_email', 
															 `club` = $frm_club, 
															 `gabungan` = $frm_gabungan
													   WHERE `no_induk_atlit` ='$frm_no_induk_atlit'");
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";	
							$result_email = mysql_query(" UPDATE users SET `email` = '$frm_email' 
													                   WHERE `no_induk_atlit` ='$frm_no_induk_atlit'");
							if ($result_email) 
							{
								$pesan = $pesan."<br>email telah diubah";	
						    }
							else
							{ 
								$pesan = $pesan."<br>Gagal email - ". mysql_error();
							}
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal mengubah data - ". mysql_error();
						}
				}
		}
	}


if ($act==2) { // hapus data

$result = mysql_query("DELETE FROM atlit WHERE no_induk_atlit = ".$frm_no_induk_atlit);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	

if ($act==3) { // RESET FORM

	$frm_no_induk_atlit =  '';
	$frm_nama   =   '';
	$frm_jenis_kelamin   =  '';
	$frm_tempat_lahir   =  '';
	$frm_tgl_lahir = '';
	$frm_alamat   =  '';
	$frm_kota   =  '';
	$frm_propinsi   = '';
	$frm_email   =  '';
	$frm_club   = '';
	$frm_gabungan   =  '';
	$frm_exist=0;
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
//echo $_POST['frm_nama'];
$result = mysql_query("SELECT no_induk_atlit, 
					  		  nama, 
					    	  kelamin, 
							  tempat_lahir, 
							  tanggal_lahir, 
							  DATE_FORMAT(`tanggal_lahir`,'%d/%m/%Y') as tanggal_lahir,
							  alamat, 
							  kota_atlit, 
							  propinsi_atlit, 
							  email, 
							  club, 
							  gabungan
						 FROM atlit 
						WHERE nama='".$_POST['frm_nama']."'");

						if ($row = mysql_fetch_array($result)) {
							$frm_exist=1;
							
							$frm_no_induk_atlit =  $row["no_induk_atlit"];
							$frm_nama   =   $row["nama"];
							$frm_jenis_kelamin   =  $row["kelamin"];
							$frm_tempat_lahir   =  $row["tempat_lahir"];
							$frm_tgl_lahir = $row["tanggal_lahir"];
							
							
							/*
							if (($row["tanggal_lahir"]=="00/00/0000") or ($row["tanggal_lahir"]=="")){
							//echo "DISINI";
							$frm_tgl_lahir ="00/00/0000"; }else {
							$frm_tgl_lahir =$row["tanggal_lahir"];}*/
							
							$frm_alamat   =  $row["alamat"];
							$frm_kota   =  $row["kota_atlit"];
							$frm_propinsi   =  $row["propinsi_atlit"];
							$frm_email   =  $row["email"];
							$frm_club   =  $row["club"];
							$frm_gabungan   =  $row["gabungan"];
							
						}else
						{
							$frm_exist=0;
							$pesan = $pesan."Nama Atlit yang Anda masukkan tidak ada di database";
							
							/*$frm_no_induk_atlit = "";
							$frm_nama = "";
							$frm_jenis_kelamin = "";						
							$frm_tempat_lahir = "";
							$frm_tgl_lahir = "";
							
							$frm_alamat = "";
							$frm_kota = "";
							$frm_propinsi = "";
							$frm_email = "";
							
							$frm_club = "";
							$frm_gabungan = "";*/
						}
	
}


}

	
?>
<link type="text/css" href="../jquery/themes/base/ui.all.css" rel="stylesheet" />
<script language="javascript">
function proses()
{
	document.forms["form_atlit"].submit();
	}
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
    <form id="form_atlit" name="form_atlit" action="index.php?menu=atlit" method="post">
    <table width="95%" border="0" align="center">
      <tr>
        <td>No. Induk Atlit</td>
        <td>:<input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>"></td>
        <td>
          <input type="text" name="frm_no_induk_atlit" id="frm_no_induk_atlit" value="<?=$frm_no_induk_atlit;?>" onblur="proses();" />
        </td>
      </tr>
      <tr>
        <td>Nama Atlit</td>
        <td>:</td>
        <td><input type="text" name="frm_nama" id="frm_nama" value="<?=$frm_nama;?>" onblur="proses();"/></td>
      </tr>
      <tr>
        <td>Jenis kelamin</td>
        <td>:</td>
        <td>
          <label>
            <input type="radio" name="frm_jenis_kelamin" value="Pria" id="frm_jenis_kelamin" <? if ($frm_jenis_kelamin=="Pria") echo "checked";?>  />
            Pria</label>
          <label>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="frm_jenis_kelamin" value="Wanita" id="frm_jenis_kelamin" <? if ($frm_jenis_kelamin=="Wanita") echo "checked";?>  />
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
				$sql_kota="SELECT * FROM kota";
				$result = @mysql_query($sql_kota);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->id_kota; ?>" <?php if ($frm_tempat_lahir==$row->id_kota) { echo "selected"; }?>> <?php echo $row->nama; ?></option>
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
        <td>Nama Club</td>
        <td>:</td>
        <td>
        <select name="frm_club" id="frm_club" class="tekboxku">
	    <option <?php if ($frm_club==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sql_club="SELECT * FROM club";
				$result = @mysql_query($sql_club);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->id_club; ?>" <?php if ($frm_club==$row->id_club) { echo "selected"; }?>> <?php echo $row->nama; ?>			</option>
          <?php
				}
				?>
      </select>
        
	</td>
      </tr>
      <tr>
        <td>Nama Gabungan</td>
        <td>:</td>
        <td>
        <select name="frm_gabungan" id="frm_gabungan" class="tekboxku">
	    <option <?php if ($frm_gabungan==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sql_gabungan="SELECT * FROM gabungan";
				$result = @mysql_query($sql_gabungan);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->id_gabungan; ?>" <?php if ($frm_gabungan==$row->id_gabungan) { echo "selected"; }?>> <?php echo $row->nama; ?>			</option>
          <?php
				}
				?>
      </select>
      </td>
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
            <? if ($frm_no_induk_atlit) { ?>
            <input name="frm_hapus" id="frm_hapus" type="submit" onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_no_induk_atlit;?>';this.form.submit()};" value="Hapus">
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
//}
?>