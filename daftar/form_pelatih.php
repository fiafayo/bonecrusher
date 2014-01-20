<?
require("include/global.php");
require("include/fungsi.php");

f_connecting();
	mysql_select_db($DB);
	
//echo "<br>frm_tgl_lahir=".$_POST['frm_tgl_lahir'];
$rg_login_as = $_POST['rg_login_as'];
$frm_no_induk_pelatih = $_POST['frm_no_induk_pelatih'];
$frm_nama = $_POST['frm_nama'];
$frm_jenis_kelamin = $_POST['frm_jenis_kelamin'];						
$frm_tempat_lahir = $_POST['frm_tempat_lahir'];
$frm_tgl_lahir = $_POST['frm_tgl_lahir'];

$frm_alamat = $_POST['frm_alamat'];
$frm_kota = $_POST['frm_kota'];
$frm_propinsi = $_POST['frm_propinsi'];
$frm_email = $_POST['frm_email'];

//$frm_reg_password = $_POST['frm_reg_password'];
//$frm_konf_reg_password = $_POST['frm_konf_reg_password'];

$frm_exist = $_POST['frm_exist'];
$act = $_POST['act'];
$frm_simpan = $_POST['frm_simpan'];


if ($act=="simpan")
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
	if (($frm_no_induk_pelatih=='') or ($frm_nama=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi NIP dan Nama Pelatih. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		
			$result_cek = mysql_query("SELECT nama, no_induk_pelatih
						 				 FROM pelatih 
										WHERE no_induk_pelatih='".$_POST['frm_no_induk_pelatih']."'");
			
			$jumlah_rows=mysql_num_rows($result_cek);	
			
			if ($jumlah_rows==1) 
				{
					$frm_exist=1;
					$pesan = $pesan."<br>Data Pelatih sudah ada";
					$result = mysql_query(" UPDATE pelatih SET `nama` = '$frm_nama', 
															   `kelamin` = '$frm_jenis_kelamin' , 
															   `tempat_lahir` = $frm_tempat_lahir , 
															   `tanggal_lahir` = '".datetomysql($frm_tgl_lahir)."' , 
														       `alamat` = '$frm_alamat',
															   `kota_pelatih` = $frm_kota,
														       `propinsi_pelatih` = $frm_propinsi , 
															   `email` = '$frm_email'
														 WHERE `no_induk_pelatih` ='$frm_no_induk_pelatih'");
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";
							$result_email = mysql_query(" UPDATE users SET `email` = '$frm_email' 
													                   WHERE `username` ='$session->username'");
							if ($result_email) 
							{
								$pesan = $pesan."<br>email telah diubah";	
						    }
							else
							{ 
								$pesan = $pesan."<br>Gagal ubah email - ". mysql_error();
							}
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal mengubah data - ". mysql_error();
						}
				}
				else
				{
					$frm_exist=0;
				
					// data id tidak ada, berarti record baru
					/* $result = mysql_query("INSERT INTO pelatih (no_induk_pelatih, nama, kelamin, tempat_lahir, tanggal_lahir, alamat, kota_pelatih, propinsi_pelatih, email, password_pelatih)VALUES('".$frm_no_induk_pelatih."', '".$frm_nama."', '".$frm_jenis_kelamin."', '".$frm_tempat_lahir."', '".$frm_tgl_lahir."', '".$frm_alamat."', '".$frm_kota."', '".$frm_propinsi."', '".$frm_email."', '".$frm_reg_password."') " );
  				    if ($result)  */
					
					$result = mysql_query("INSERT INTO pelatih (no_induk_pelatih, nama, kelamin, tempat_lahir, tanggal_lahir, alamat, kota_pelatih, propinsi_pelatih, email)VALUES('".$frm_no_induk_pelatih."', '".$frm_nama."', '".$frm_jenis_kelamin."', '".$frm_tempat_lahir."', '".$frm_tgl_lahir."', '".$frm_alamat."', '".$frm_kota."', '".$frm_propinsi."', '".$frm_email."') " );
  				    if ($result) 
						{
							$pesan = $pesan."<br>Data telah ditambahkan";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data". mysql_error();
						}
			}
		}
}
else
{

// Jika user mengisi form, di check apakah data sudah ada, kalau sudah ada maka data akan ditampilkan

$result = mysql_query("SELECT id_pelatih,
							  no_induk_pelatih, 
					  		  nama, 
					    	  kelamin, 
							  tempat_lahir, 
							  tanggal_lahir, 
							  DATE_FORMAT(`tanggal_lahir`,'%d/%m/%Y') as tanggal_lahir,
							  alamat, 
							  kota_pelatih, 
							  propinsi_pelatih, 
							  email
						 FROM pelatih 
						WHERE email='".$session->userinfo['email']."' OR nama='".$_POST['frm_nama']."'");

						if ($row = mysql_fetch_array($result)) {
							$frm_exist=1;
							$frm_id_pelatih =  $row["id_pelatih"];
							$frm_no_induk_pelatih =  $row["no_induk_pelatih"];
							$frm_nama   =   $row["nama"];
							$frm_jenis_kelamin   =  $row["kelamin"];
							$frm_tempat_lahir   =  $row["tempat_lahir"];
							$frm_tgl_lahir = $row["tanggal_lahir"];
							$frm_alamat   =  $row["alamat"];
							$frm_kota   =  $row["kota_pelatih"];
							$frm_propinsi   =  $row["propinsi_pelatih"];
							$frm_email   =  $row["email"];
							
						}else
						{
							$frm_exist=0;
							//$pesan = $pesan."Nomor Induk Atlit yang Anda masukkan tidak ada di database";
							
							/*$frm_no_induk_pelatih = "";
							$frm_nama = "";
							$frm_jenis_kelamin = "";						
							$frm_tempat_lahir = "";
							$frm_tgl_lahir = "";
							
							$frm_alamat = "";
							$frm_kota = "";
							$frm_propinsi = "";
							$frm_email = "";*/
						}
}
?>
<link type="text/css" href="jquery/themes/base/ui.all.css" rel="stylesheet" />
<!--link rel="stylesheet" type="text/css" media="screen" href="stylesheet.css" /-->
<link rel="stylesheet" type="text/css" href="css/jval.css">
        <style>
               .error {
					display: block;
					color: red;
					font-style: italic;
					font-weight: normal;
				}
 
        </style>

<script type="text/javascript" src="jquery/jquery-1.4.4.js"></script>
<script type="text/javascript" src="jquery/ui/jquery.ui.core.js"></script>
<script  type="text/javascript" src="jquery/ui/jquery.ui.datepicker.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery/jVal.js"></script>

 <script language="text/javascript">
function proses()
{
	document.forms["form_pelatih"].submit();
	}
</script>       
		
  
  
        
<script type="text/javascript">
	$(document).ready(function() {
			$("#frm_tgl_lahir").datepicker( {
										   dateFormat : "dd/mm/yy",
										   changeMonth: true,
										   changeYear: true
										   });
							   });
</script>



<div align="center">
<table border="1" align="center">
  <tr>
    <th scope="col"><h1>Form Registrasi Pelatih</h1> 
<p>Silahkan isi form berikut sesuai dengan data yang valid milik Anda</p></th>
  </tr>
  <tr>
    <td>
    <form id="form_pelatih" name="form_pelatih" action="registrasi.php" method="post">
    <table width="100%" border="0" align="center">
      <tr>
        <td colspan="3"><div class="error"><? echo $pesan;?> </div></td>
        </tr>
      <tr>
        <td nowrap>No. Induk Pelatih</td>
        <td>:<input name="frm_exist" id="frm_exist" type="hidden" value="<?=$frm_exist?>"/>
        <input name="rg_login_as" id="rg_login_as" type="hidden" value="2" /></td>
        <td><input type="hidden" id="frm_id_pelatih" name="frm_id_pelatih" value="<?=$frm_id_atlit;?>">
          <input type="text" name="frm_no_induk_pelatih" id="frm_no_induk_pelatih" value="<?=$frm_no_induk_pelatih;?>" jVal="{valid:function (val) { if (val.length < 3) return 'Masukkan No.Induk Pelatih Anda'; else return ''; }}" jValKey="{valid:/[a-zA-Z0-9]/, message:'&quot;%c&quot; karakter tidak dikenal', cFunc:'$(\'#submitButton\').click();'}"/>
          * </td>
      </tr>
      <tr>
        <td>Nama Pelatih</td>
        <td>:</td>
        <td><input type="text" name="frm_nama" id="frm_nama" value="<?=$frm_nama;?>" jVal="{valid:function (val) { if (val.length < 3) return 'Masukkan Nama Lengkap Anda'; else return ''; }}" jValKey="{valid:/[a-zA-Z]/, message:'&quot;%c&quot; Masukkan huruf saja', cFunc:'$(\'#submitButton\').click();'}"/>
          *</td>
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
         *</td>
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
        <td><input type="text" name="frm_tgl_lahir" id="frm_tgl_lahir"  value="<?=$frm_tgl_lahir;?>"/>
          *</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><input type="text" name="frm_alamat" id="frm_alamat" value="<?=$frm_alamat;?>" />
          *</td>
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
        *</td>
      </tr>
      <tr>
        <td>Propinsi</td>
        <td>:</td>
        <td nowrap> 
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
          *</td>
      </tr>
      <tr>
        <td>E-mail</td>
        <td>:</td>
        <td><input type="text" name="frm_email" id="frm_email" value="<?=$frm_email;?>" jVal="{valid:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/, message:'Invalid Email Address'}" jValKey="{valid:/[a-zA-Z0-9._%+-@]/, cFunc:'alert', cArgs:['Email Address: '+$(this).val()]}" />
          *</td>
      </tr>
      <tr>
        <td nowrap>Tanda ' * ' harus di isi.</td>
        <td>&nbsp;</td>
        <td><input type="hidden" name="act" id="act" value="simpan" />
          <input type="button" name="frm_simpan" id="frm_simpan" value="Simpan" onClick="if ( $('#form_pelatih').jVal({style:'cover',padding:3,border:1,wrap:true}) ) this.form.submit();"/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;
        </td>
      </tr>
    </table>
    </form>
    </td>
  </tr>
</table>
</div>
<p align="center"><a href="registrasi.php">Kembali</a></p>
<?
//}
?>