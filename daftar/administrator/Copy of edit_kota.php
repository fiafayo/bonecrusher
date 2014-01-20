<?

require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);
	
$frm_no_ID_kota = $_POST['frm_no_ID_kota'];
$frm_nama = $_POST['frm_nama'];
$frm_propinsi = $_POST['frm_propinsi'];						
$frm_exist = $_POST['frm_exist'];
$act = $_GET['act'];

/*
echo "<br>frm_no_ID_kota=".$frm_no_ID_kota;
echo "<br>frm_nama=".$frm_nama;
echo "<br>frm_propinsi=".$frm_propinsi;
echo "<br>act=".$act;
echo "<br>frm_exist=".$frm_exist;*/

if ($act==1)   // INSERT
{ // simpan data


// NRP dan NAMA harus diisi
	if (($frm_propinsi=='') or ($frm_nama=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi Nama Kota dan Nama Propinsi. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
			$result_cek = mysql_query("SELECT *
						 				 FROM kota 
										WHERE (nama='".$_POST['frm_nama']."' AND id_propinsi_kota=".$_POST['frm_propinsi'].")");
			if ($result_cek) 
				{
					$frm_exist=1;
					$pesan = $pesan."<br>Data Kota sudah ada";
				}
				//else
				//{
					
					//}
			
		// data id tidak ada, berarti record baru
			if (($frm_exist!=1) AND ($frm_no_ID_kota==""))
				{
					$result = mysql_query("INSERT INTO kota (nama, id_propinsi_kota)VALUES('".$frm_nama."', ".$frm_propinsi.")" );
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
					$result = mysql_query(" UPDATE kota SET `nama` = '$frm_nama', 
															`id_propinsi_kota` = $frm_propinsi
													  WHERE `id_kota` = $frm_no_ID_kota");
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

$result = mysql_query("DELETE FROM kota WHERE id_kota = ".$frm_no_ID_kota);
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

	$frm_nama = "";
	$frm_no_ID_kota = "";						
	$frm_propinsi = "";
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
						 FROM kota 
						WHERE nama='".$_POST['frm_nama']."'");

						if ($row = mysql_fetch_array($result)) {
							$frm_exist=1;
							$frm_no_ID_kota =  $row["id_kota"];
							$frm_nama   =   $row["nama"];
							$frm_propinsi   =  $row["id_propinsi_kota"];
						}
						else
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
	document.forms["form_kota"].submit();
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
<!--p><a href="javascript:confirmRefresh();">Refresh Page</a></p-->


<table width="90%" border="1">
  <tr>
    <th scope="col"><? echo $pesan;?></th>
  </tr>
  <tr>
    <td>
    <form id="form_kota" name="form_kota" action="index.php?menu=kota" method="post">
    <table width="95%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist;?>"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Nama Kota</td>
        <td>:</td>
        <td><input type="text" name="frm_nama" id="frm_nama" value="<?=$frm_nama;?>" onblur="proses();"/></td>
      </tr>
      <tr>
        <td>No. ID Kota</td>
        <td>:</td>
        <td><input name="frm_no_ID_kota" type="text" id="frm_no_ID_kota" value="<?=$frm_no_ID_kota;?>" size="3" maxlength="3" readonly="readonly" /></td>
      </tr>
      <tr>
        <td>Nama Propinsi</td>
        <td>:</td>
        <td><select name="frm_propinsi" id="frm_propinsi" class="tekboxku">
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
<?
/*}
else
{
	header('Location: ../process.php');
}
*/
?>