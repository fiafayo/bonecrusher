<?
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);
	
$frm_no_ID_club = $_POST['frm_no_ID_club'];
$frm_nama = $_POST['frm_nama'];
$frm_alamat = $_POST['frm_alamat'];
$frm_kota = $_POST['frm_kota'];
$frm_propinsi = $_POST['frm_propinsi'];						
$frm_exist = $_POST['frm_exist'];
$act = $_GET['act'];
/*
echo "<br>frm_no_ID_club=".$frm_no_ID_club;
echo "<br>frm_nama=".$frm_nama;
echo "<br>frm_kota=".$frm_kota;
echo "<br>frm_propinsi=".$frm_propinsi;
echo "<br>act=".$act;
echo "<br>frm_exist=".$frm_exist;
*/
if ($act==1)   // INSERT
{ // simpan data


// NRP dan NAMA harus diisi
	if (($frm_no_ID_club=='') or ($frm_nama=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi Data Club dengan lengkap. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
			$result_cek = mysql_query("SELECT *
						 				 FROM club 
										WHERE (nama='".$_POST['frm_nama']."' AND id_club=".$_POST['frm_no_ID_club'].")");
			if ($result_cek) 
				{
					$frm_exist=1;
					$pesan = $pesan."<br>Data Club sudah ada";
				}
				//else
				//{
					
					//}
			echo"<br>here :".$frm_exist;
		// data id tidak ada, berarti record baru
			if (($frm_exist!=1) AND ($frm_no_ID_club==""))
				{
					echo"inset";
					$result = mysql_query("INSERT INTO club (id_club, nama, alamat, kota_club, propinsi_club)VALUES(".$frm_no_ID_club.", '".$frm_nama."','".$frm_alamat."',".$frm_kota.", ".$frm_propinsi."')" );
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
					$result = mysql_query(" UPDATE club SET `nama` = '$frm_nama',
										  					`alamat` = '$frm_alamat', 
															`kota_club` = $frm_kota,
															`propinsi_club` = $frm_propinsi
													  WHERE `id_club` = $frm_no_ID_club");
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

$result = mysql_query("DELETE FROM club WHERE id_club = ".$frm_no_ID_club);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
	//header("Location: {$_SERVER['PHP_SELF']}");
	?>
    <script language="javascript">//confirmRefresh();
	    alert ('Data kota <? echo $frm_nama;?> telah di Hapus.');
		document.location="index.php?menu=kota";    
    </script>
    <?
}

if ($act==3) { // RESET FORM

	$frm_no_ID_club =  "";
	$frm_nama   =   "";
	$frm_alamat   =  "";
	$frm_kota   =  "";
	$frm_propinsi   =   "";
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
$result = mysql_query("SELECT *
						 FROM club 
						WHERE nama='".$_POST['frm_nama']."'");

						if ($row = mysql_fetch_array($result)) {
							$frm_exist=1;
							$frm_no_ID_club =  $row["id_club"];
							$frm_nama   =   $row["nama"];
							$frm_alamat   =   $row["alamat"];
							$frm_kota   =  $row["kota_club"];
							$frm_propinsi   =   $row["propinsi_club"];
														
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
	document.forms["form_club"].submit();
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

<table width="90%" border="1">
  <tr>
    <th scope="col"><? echo $pesan;?></th>
  </tr>
  <tr>
    <td>
    <form id="form_club" name="form_club" action="index.php?menu=club" method="post">
    <table width="95%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Nama Club</td>
        <td>:</td>
        <td><input type="text" name="frm_nama" id="frm_nama" value="<?=$frm_nama;?>" onblur="proses();"/></td>
      </tr>
      <tr>
        <td>No. ID Club</td>
        <td>:</td>
        <td><input name="frm_no_ID_club" type="text" id="frm_no_ID_club" value="<?=$frm_no_ID_club;?>" size="5" /></td>
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
      </select></td>
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
            <? if ($frm_no_ID_kota) { ?>
            <input name="frm_hapus" id="frm_hapus" type="submit" onClick="if(confirm('Hapus ?')){this.form.action+='&act=2&id=<?php echo $frm_no_ID_kota;?>';this.form.submit()};" value="Hapus">
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