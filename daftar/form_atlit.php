<?
require("include/global.php");
require("include/fungsi.php");

f_connecting();
	mysql_select_db($DB);
	
//echo "<br>username =".$session->username;

$rg_login_as = $_POST['rg_login_as'];
$frm_id_atlit = $_POST['frm_id_atlit'];
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

//$frm_reg_password = $_POST['frm_reg_password'];
//$frm_konf_reg_password = $_POST['frm_konf_reg_password'];

$frm_exist = $_POST['frm_exist'];
$act = $_GET['act'];
$frm_simpan = $_POST['frm_simpan'];
//echo "<br>frm_id_atlit=".$frm_id_atlit;
/*echo "<br>frm_no_induk_atlit=".$frm_no_induk_atlit;
echo "<br>frm_nama=".$frm_nama;
echo "<br>frm_jenis_kelamin=".$frm_jenis_kelamin;
echo "<br>frm_tempat_lahir=".$frm_tempat_lahir;
echo "<br>frm_tgl_lahir=".$frm_tgl_lahir;
echo "<br>frm_alamat=".$frm_alamat;
echo "<br>frm_kota=".$frm_kota;
echo "<br>frm_propinsi=".$frm_propinsi;
echo "<br>frm_email=".$frm_email;
echo "<br>frm_club=".$frm_club;
echo "<br>frm_gabungan=".$frm_gabungan;*/
//echo "<br>frm_reg_password=".$frm_reg_password;
//echo "<br>frm_konf_reg_password=".$frm_konf_reg_password;



/*echo "<br>act=".$act;
echo "<br>frm_exist=".$frm_exist;
echo "<br>frm_simpan=".$frm_simpan;
echo "<br>rg_login_as=".$rg_login_as;*/

//if ($act==1)   // INSERT
if ($frm_simpan=="Simpan")
{ // simpan data
	// validasi tanggal
	
	if ($frm_id_atlit=='') 
		{
			$error = 1;
			$pesan = $pesan."<br> Masukkan data dengan benar";
		}


// NRP dan NAMA harus diisi

	if ($error !=1) // Jika semua isian form valid 
		{
		//echo "<br>ID ATLIT= ".$_POST['frm_id_atlit'];
		//exit();

		
			$result_cek = mysql_query("SELECT id_atlit, nama, no_induk_atlit
						 				 FROM atlit 
										WHERE id_atlit=".$_POST['frm_id_atlit']);
			
			//WHERE (nama='".$_POST['frm_nama']."' AND no_induk_atlit=".$_POST['frm_no_induk_atlit'].")");
			
			$jumlah_rows=mysql_num_rows($result_cek);	
			//echo "<br>jumlah_rows=".$jumlah_rows;
			if ($jumlah_rows==1) 
				{
					$frm_exist=1;
					$pesan = $pesan."<br>Data Atlit sudah ada";
					$result = mysql_query(" UPDATE atlit SET `nama` = '$frm_nama', 
															 `kelamin` = '$frm_jenis_kelamin' , 
															 `tempat_lahir` = $frm_tempat_lahir , 
															 `tanggal_lahir` = '".datetomysql($frm_tgl_lahir)."' , 
															 `alamat` = '$frm_alamat',
															 `kota_atlit` = $frm_kota,
															 `propinsi_atlit` = $frm_propinsi , 
															 `email` = '$frm_email' , 
															 `club` = $frm_club, 
															 `gabungan` = $frm_gabungan
													   WHERE `id_atlit` = $frm_id_atlit");
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
		// data id tidak ada, berarti record baru
			else 
			{					
					echo "INSERT";
		/* 			$result = mysql_query("INSERT INTO atlit (no_induk_atlit, nama, kelamin, tempat_lahir, tanggal_lahir, alamat, kota_atlit, propinsi_atlit, email, club, gabungan, password_atlit)VALUES('".$frm_no_induk_atlit."', '".$frm_nama."', '".$frm_jenis_kelamin."', '".$frm_tempat_lahir."', '".datetomysql($frm_tgl_lahir)."', '".$frm_alamat."', '".$frm_kota."', '".$frm_propinsi."', '".$frm_email."', '".$frm_club."', '".$frm_gabungan."','".$frm_reg_password."') " ); */
					$result = mysql_query("INSERT INTO atlit (id_atlit, nama, kelamin, tempat_lahir, tanggal_lahir, alamat, kota_atlit, propinsi_atlit, email, club, gabungan)VALUES(NULL, '".$frm_nama."', '".$frm_jenis_kelamin."', '".$frm_tempat_lahir."', '".datetomysql($frm_tgl_lahir)."', '".$frm_alamat."', ".$frm_kota.", ".$frm_propinsi.", '".$frm_email."', '".$frm_club."', '".$frm_gabungan."') " );
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

// Jika user mengisi form NRP, di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
//echo "<br>email=".$session->userinfo['email'];
//if ($frm_nama!='')  {
//echo "--> ".$_POST['frm_nama'];

$result = mysql_query("SELECT id_atlit,
							  no_induk_atlit, 
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
						WHERE email='".$session->userinfo['email']."' OR nama='".$_POST['frm_nama']."'");

						if ($row = mysql_fetch_array($result)) {
							$frm_exist=1;
							
							$frm_no_induk_atlit =  $row["no_induk_atlit"];
							$frm_id_atlit =  $row["id_atlit"];
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
							//$pesan = $pesan."Nomor Induk Atlit yang Anda masukkan tidak ada di database";
							
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
	
//}


//}


	
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
 <script  type="text/javascript">
function proses()
{
	document.forms["form_atlit"].submit();
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
    <th scope="col"><h1>Form Registrasi Atlit</h1> 
<p>Silahkan isi form berikut sesuai dengan data yang valid milik Anda</p></th>
  </tr>
  <tr>
    <td>

<form id="form_atlit" name="form_atlit"  action="registrasi.php" method="post">
	<div class="error"><? echo $pesan;?> </div>
	
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
      <tr>
        <td>No. Induk Atlit</td>
        <td>:<input name="frm_exist" id="frm_exist" type="hidden" value="<?=$frm_exist?>"/>
		<input name="rg_login_as" id="rg_login_as" type="hidden" value="1" /></td>
        <td><input type="hidden" id="frm_id_atlit" name="frm_id_atlit" value="<?=$frm_id_atlit;?>">
		<input type="text" name="frm_no_induk_atlit" id="frm_no_induk_atlit" value="<?=$frm_no_induk_atlit;?>"  jVal="{valid:function (val) { if (val.length < 3) return 'Masukkan No.Induk Atlit Anda'; else return ''; }}" jValKey="{valid:/[a-zA-Z0-9]/, message:'&quot;%c&quot; karakter tidak dikenal', cFunc:'$(\'#frm_simpan\').click();'}">
         *
        </td>
      </tr>
      <tr>
        <td>Nama Atlit</td>
        <td>:</td>
        <td><input type="text" name="frm_nama" id="frm_nama" onblur="proses();" value="<?=$frm_nama;?>" jVal="{valid:function (val) { if (val.length < 3) return 'Masukkan Nama Lengkap Anda'; else return ''; }}" jValKey="{valid:/[a-z A-Z]/, message:'&quot;%c&quot; Masukkan huruf saja', cFunc:'$(\'#frm_simpan\').click();'}"/>
          *</td>
      </tr>
      <tr>
        <td>Jenis kelamin</td>
        <td>:</td>
        <td>
		<input type="radio" name="frm_jenis_kelamin" value="Pria" id="radio" <? if ($frm_jenis_kelamin=="Pria") echo "checked";?>  />
Pria <input type="radio" name="frm_jenis_kelamin" value="Wanita" id="radio" <? if ($frm_jenis_kelamin=="Wanita") echo "checked";?>  />
Wanita *</td>
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
          * </td>
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
        <td>
        <select name="frm_propinsi" id="frm_propinsi" class="tekboxku">
	    <option <?php if ($frm_propinsi==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sql_propinsi="SELECT * FROM propinsi ORDER BY nama ASC";
				$result = @mysql_query($sql_propinsi);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->id_propinsi; ?>" <?php if ($frm_propinsi==$row->id_propinsi) { echo "selected"; }?>> <?php echo $row->nama; ?></option>
          <?php
				}
				?>
      </select>
      
          *</td>
      </tr>
      <tr>
        <td>E-mail</td>
        <td>:</td>
        <td><input type="text" name="frm_email" id="frm_email" value="<?=$frm_email;?>" 
        		jVal="{valid:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/, message:'Invalid Email Address'}"
                                        jValKey="{valid:/[a-zA-Z0-9._%+-@]/, cFunc:'alert', cArgs:['Email Address: '+$(this).val()]}"/>
          *</td>
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
        *</td>
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
        *</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Tanda ' * ' harus di isi.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>
          <input type="submit" name="frm_simpan" id="frm_simpan" value="Simpan" onClick="if ( $('#form_atlit').jVal({style:'cover',padding:3,border:1,wrap:true}) ) this.form.submit();"/>
          
          </td>
      </tr>
    </table>
    </form>
	</td>
  </tr>
</table>

	<!--script>$("#stylized").removeClass("myform");</script-->
    <p align="center"><a href="registrasi.php">Kembali</a></p>
</div>

<?
//}
?>