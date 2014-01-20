<?
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);
	
$frm_id_propinsi = $_POST['frm_id_propinsi'];
$frm_kode_bps = $_POST['frm_kode_bps'];
$frm_nama = $_POST['frm_nama'];
$frm_exist = $_POST['frm_exist'];
$act = $_GET['act'];
$frm_simpan = $_POST['frm_simpan'];

/* echo "<br>frm_kode_bps=".$frm_kode_bps;
echo "<br>frm_nama=".$frm_nama;
echo "<br>act=".$act;
echo "<br>frm_exist=".$frm_exist;
 */
//if ($act==1)   // INSERT
if ($frm_simpan == 'Simpan')
{ // simpan data


// NRP dan NAMA harus diisi
	if (($frm_kode_bps=='') or ($frm_nama=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi Nama Kota dan ID Propinsi. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
			$result_cek = mysql_query("SELECT *
						 				 FROM propinsi 
										WHERE (nama='".$_POST['frm_nama']."' OR kode_bps=".$_POST['frm_kode_bps'].")");
			
			$jumlah_rows=mysql_num_rows($result_cek);	
			//echo "<br>jumlah_rows=".$jumlah_rows;
			if ($jumlah_rows==1) 
				{
					$frm_exist=1;
					$pesan = $pesan."<br>Data Kota sudah ada";
				}
				else
				{
					$frm_exist=0;
				}
			
			// data id tidak ada, berarti record baru
		/*echo "<br>frm_id_propinsi=".$frm_id_propinsi;
			echo "<br>1frm_kode_bps=".$frm_kode_bps;
			echo "<br>1frm_nama=".$frm_nama;
			echo "<br>1frm_exist=".$frm_exist;*/
 
			if ($frm_exist!=1)
				{
					//echo "<br>2frm_kode_bps=".$frm_kode_bps;
//echo "<br>2frm_nama=".$frm_nama;

					$result = mysql_query("INSERT INTO propinsi (kode_bps, nama) VALUES(".$frm_kode_bps.", '".$frm_nama."')" );
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
					$result = mysql_query(" UPDATE propinsi SET `nama` = '$frm_nama',
										  						`kode_bps` = $frm_kode_bps
													      WHERE `id_propinsi` = $frm_id_propinsi");
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
		$result = mysql_query("DELETE FROM propinsi WHERE id_propinsi = ".$frm_id_propinsi);
			if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
			//header("Location: {$_SERVER['PHP_SELF']}");
			?>
			<script language="javascript">//confirmRefresh();
				alert ('Data kota <? echo $frm_nama;?> telah di Hapus.');
				document.location="index.php?menu=propinsi";    
			</script>
			<?
}

if ($act==3) { // RESET FORM

	$frm_nama = "";
	$frm_kode_bps = "";	
	$frm_id_propinsi = "";
}
	
			// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
			if (($act!=0)and($error!=1)) {
				$frm_exist=0;
				$frm_nama = "";
				$frm_kode_bps = "";
				$frm_id_propinsi = "";
			}
			else
			{
						// Jika user mengisi form NRP, di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
						//echo "<br>frm_nama=".$_POST['frm_nama'];
						if ($frm_nama!='')  {
									$result = mysql_query("SELECT *
															 FROM propinsi 
															WHERE nama='".$_POST['frm_nama']."'");
						
									if ($row = mysql_fetch_array($result)) {
										$frm_exist=1;
										$frm_id_propinsi = $row["id_propinsi"];
										$frm_kode_bps =  $row["kode_bps"];
										$frm_nama   =   $row["nama"];
																	
									}
									else
									{
										$frm_exist=0;
										//$pesan = $pesan."Nomor ID Kota yang Anda masukkan tidak ada di database";
										
										//$frm_no_ID_kota = "";
										//$frm_propinsi = "";
									}
				
						}
			
			
			}

	
?>
<link type="text/css" href="../jquery/themes/base/ui.all.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="../css/val.css">
<script language="javascript">
function proses()
{
	//document.forms["form_propinsi"].submit();
//	document.forms["form_propinsi"].element["frm_id_propinsi"].focus();
	}
</script>

<script type="text/javascript" src="../jquery/jquery-1.4.4.js"></script>
<script type="text/javascript" src="../jquery/jquery.validate.js"></script>
<script type="text/javascript">
		$(document).ready(function() {
			$("#form_propinsi").validate({
				rules: {
				  frm_nama: "required",
				  frm_kode_bps: {
          	 required: true,
					   number: true
          },		
					username: "required",
				  password: {
          	 required: true,
					   minlength: 5
          },		
			     cpassword:
			     {
				      required: true,
				      equalTo: "#password"
			     },
					email: {				
						required: true,
						email: true
					},
					website: {
        	  required: true,
						url: true
					}
				},
			
      	messages: { 
			    frm_nama: {
				    required: '. Nama Propinsi harus di isi'
			    },
		      frm_kode_bps: {
				    required: '. Kode Propinsi harus di isi',
				    number  : '. Hanya boleh di isi Angka'
			    },
				  username: {
				    required: '. Username harus di isi'
			    },
			    password: {
				    required : '. Password harus di isi',
				    minlength: '. Password minimal 5 karakter'
			    },
			    cpassword: {
				    required: '. Ulangi Password harus di isi',
				    equalTo : '. Isinya harus sama dengan Password'
			    },
			    email: {
				    required: '. Email harus di isi',
				    email   : '. Email harus valid'
			    },
			    website: {
				    required: '. Website harus di isi',
				    url     : '. Alamat website harus valid'
			    }
			   },
         
         success: function(label) {
            label.text('OK!').addClass('valid');
         }
			});
		});
	</script>

<div class="form-div">
<div class="pesan"><? echo $pesan;?></div>
    <form id="form_propinsi" name="form_propinsi" action="index.php?menu=propinsi" method="post">
            <input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist;?>">
            <input name="frm_id_propinsi" type="hidden" id="frm_id_propinsi"  value="<?php echo $frm_id_propinsi;?>">
  		  <div class="form-row">
          <span class="label">Nama Propinsi *</span>
              <input type="text" name="frm_nama" id="frm_nama" value="<?=$frm_nama;?>"  tabindex="1"/>
  		  </div>
  		  <div class="form-row">
          <span class="label">Kode Propinsi(BPS) *</span>
				<input name="frm_kode_bps" type="text" id="frm_kode_bps" value="<?=$frm_kode_bps;?>" size="3" maxlength="3" tabindex="2" />  		  </div>
  		  <div class="form-row">
  		  <div class="form-tombol">
            <input name="frm_simpan" id="frm_simpan" type="submit"  value="Simpan" tabindex="3" >
            <input name="Submit2" type="reset" onClick="this.form.action+='&act=3';this.form.submit();" value="Batal">
            <? if ($frm_exist) { ?>
            <input name="frm_hapus" id="frm_hapus" type="submit" onClick="if(confirm('Hapus ?')){this.form.action+='&act=2&id=<?php echo $frm_exist;?>';this.form.submit()};" value="Hapus">
        <? } ?>
  		  </div>
  		  <br /><br />
 	    </form>
    </div>
<?
//}
?>