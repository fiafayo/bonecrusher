<?
/*

	 
	 $query = $_DB->Query("SELECT * FROM atlit");
 
     //Counting the number of rows retrieved
     $count = $_DB->GetResultNumber($query);
 
     //Check if our query returned any rows to us!
     if($count == 0 )
     {
         echo "There query returned 0 rows!";
     }
 
     // if we have any rows returned:
     else
     {
         for($i=0; $i < $count; $i++)
         {
			  	 	 	 
             $row[$i]["no_induk_atlit"] =  $_DB->GetResultValue($query, $i, "no_induk_atlit");
             $row[$i]["nama_atlit"]   =  $_DB->GetResultValue($query, $i, "nama_atlit");
             $row[$i]["kelamin"]   =  $_DB->GetResultValue($query, $i, "kelamin");
			 $row[$i]["tempat_lahir"]   =  $_DB->GetResultValue($query, $i, "tempat_lahir");
         }
 
         //Printing out the rows retrieved
         echo "<pre>";
         print_r($row);
         echo"</pre>";
     }*/
include "../class/mysql.php";
// Initialaizing connection to database using CLS_MYSQL 
$DATABASE["server"] = "localhost";
$DATABASE["port"] = "3306";
$DATABASE["username"] = "root";
$DATABASE["password"] = "root";
$DATABASE["database"] = "gabsi";
     $_DB = new CLS_MYSQL($DATABASE);
     
     //Connecting to database
     $_DB->Connect();
echo "<br>act=".$act;
echo "<br>frm_exist=".$_POST['frm_exist'];
if ($act==1)   
{ // simpan data
	// validasi tanggal
	if ($frm_tanggal_lahir!='') 
		{
			if (datetomysql($frm_tanggal_lahir)) 
				{
					$frm_tanggal_lahir = datetomysql($frm_tanggal_lahir);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal lahir tidak valid";
				}
		}


// NRP dan NAMA harus diisi
	if (($frm_nrp=='') or ($frm_nama=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi NRP dan Nama Mahasiswa. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
			if ($frm_exist!=1) 
				{
						 $result = $_DB->Execute("INSERT INTO atlit (no_induk_atlit, nama, kelamin, tempat_lahir, tanggal_lahir, alamat, kota_atlit, propinsi_atlit, email, club, 	gabungan)VALUES('".$frm_no_induk_atlit."', '".$frm_nama."', '".$frm_jenis_kelamin."', '".$frm_tempat_lahir."', '".$frm_tgl_lahir."', '".$frm_alamat."', '".$frm_kota."', '".$frm_propinsi."', '".$frm_email."', '".$frm_club."', '".$frm_gabungan."')");
					//$result = mysql_query("INSERT INTO master_mhs (`NRP`, `NAMA`, `KELAMIN` ,  `TMPLAHIR` , `TGLLAHIR` , `ALAMAT_SBY` , `ZIP_SBY` , `EMAIL` , `TELEPON` , `NO_HP` , `NAMA_ORTU` , `ALAMAT_ORTU` , `ZIP_ORTU` , `TELEPON_ORTU`) VALUES ( '".$frm_nrp."', '".$frm_nama."', '".$frm_kelamin."', '".$frm_tempat_lahir."', '".$frm_tanggal_lahir."', '".$frm_alamat_sekarang."', '".$frm_zip_sekarang."', '".$frm_email."', '".$frm_telepon_sekarang."', '".$frm_hp."', '".$frm_nama_ortu."', '".$frm_alamat_ortu."', '".$frm_zip_ortu."', '".$frm_telepon_ortu."') " );
					// `NRP`, `SKSMAX`, `IPS`, `STATUS`, `JURUSAN`, `WALI`, `NAMA`, `ALAMAT_SBY`, `ZIP_SBY`, `EMAIL`, `NIRM`, `TGLLAHIR`, `TMPLAHIR`, `TOTBSS`,  `IPK`,  `SKSKUM`, `TELEPON`, `NO_HP`, `VALIDID`, `PASSWORD`, `ANGKATAN`, `NAMASMA`, `NAMA_ORTU`, `ALAMAT_ORTU`, `ZIP_ORTU`, `TELEPON_ORTU`, `KELAMIN``NAMA`='$frm_nama', 
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
					$result = mysql_query("UPDATE master_mhs set `NAMA`='$frm_nama', 
																 `KELAMIN`='$frm_kelamin' , 
																 `TMPLAHIR`='$frm_tempat_lahir' , 
																 `TGLLAHIR`='$frm_tanggal_lahir' , 
																 `ALAMAT_SBY` = '$frm_alamat_sekarang',
																 `ZIP_SBY` = '$frm_zip_sekarang',
																 `EMAIL`='$frm_email' , 
																 `TELEPON`='$frm_telepon_sekarang' , 
																 `NO_HP`='$frm_hp' , 
																 `NAMA_ORTU`='$frm_nama_ortu', 
																 `ALAMAT_ORTU`='$frm_alamat_ortu', 
																 `ZIP_ORTU`='$frm_zip_ortu', 
																 `TELEPON_ORTU`='$frm_telepon_ortu'
														where `NRP`='$frm_nrp'");
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menyimpan data - ". mysql_error();
						}
				}
		}
	}


if ($act==2) { // hapus data

$result = mysql_query("DELETE FROM master_mhs WHERE nrp = ".$frm_nrp);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	echo "HERE";
	exit();
	//$frm_nama = "";
	//$frm_kelamin = "";						
	//$frm_tempat_lahir = "";
	//$frm_tanggal_lahir = "";
	
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

/*if  ($frm_nama!="")  {
	echo "here";
	exit();*/

     $query  = $_DB->Query("SELECT * FROM atlit 
						            WHERE nama='".$_POST['frm_nama']."'");
	 //Counting the number of rows retrieved
     $count = $_DB->GetResultNumber($query);
 
     //Check if our query returned any rows to us!
     if($count == 0 )
     {
            echo "There query returned 0 rows!";
			$frm_exist=0;
			$pesan = $pesan."NIA yang Anda masukkan tidak ada di database";
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
 
     // if we have any rows returned:
     else
     {
			$frm_exist=1;
			$frm_no_induk_atlit =  $_DB->GetResultValue($query, 0, "no_induk_atlit");
			$frm_nama   =  $_DB->GetResultValue($query, 0, "nama");
			$frm_jenis_kelamin   =  $_DB->GetResultValue($query, 0, "kelamin");
			$frm_tempat_lahir   =  $_DB->GetResultValue($query, 0, "tempat_lahir");
			$frm_tgl_lahir   =  $_DB->GetResultValue($query, 0, "tanggal_lahir");
			$frm_alamat   =  $_DB->GetResultValue($query, 0, "alamat");
			$frm_kota   =  $_DB->GetResultValue($query, 0, "kota_atlit");
			$frm_propinsi   =  $_DB->GetResultValue($query, 0, "propinsi_atlit");
			$frm_email   =  $_DB->GetResultValue($query, 0, "email");
			$frm_club   =  $_DB->GetResultValue($query, 0, "club");
			$frm_gabungan   =  $_DB->GetResultValue($query, 0, "gabungan");
     }
	
//}


}

 
	
?>
<script language="javascript">
function proses()
{
	document.forms["form_atlit"].submit();
	}
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
        <td><? //echo $frm_jenis_kelamin; ?>
          <label>
            <input type="radio" name="frm_jenis_kelamin" value="pria" id="frm_jenis_kelamin" <? if ($frm_jenis_kelamin=="Pria") echo "checked";?>  />
            Pria</label>
          <label>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="frm_jenis_kelamin" value="wanita" id="frm_jenis_kelamin" <? if ($frm_jenis_kelamin=="Wanita") echo "checked";?>  />
            Wanita</label>
         </td>
      </tr>
      <tr>
        <td>Tempat Lahir</td>
        <td>:</td>
        <td>
          <select name="frm_tempat_lahir" id="frm_tempat_lahir" />
          <? 
		  $query = $_DB->Query("SELECT * FROM kota");
		  $count = $_DB->GetResultNumber($query);
 
			 //Check if our query returned any rows to us!
			 if($count == 0 )
			 {
				 echo "There query returned 0 rows!";
			 }
		 
			 // if we have any rows returned:
			 else
			 {
				 for($i=0; $i < $count; $i++)
				 {
					 $row[$i]["id_kota"] =  $_DB->GetResultValue($query, $i, "id_kota");
					 $row[$i]["nama"]   =  $_DB->GetResultValue($query, $i, "nama");
				  ?>
				  <option value="<?=$row[$i]["id_kota"];?>"><?=$row[$i]["nama"];?></option>
                 <? }
             }?>
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
        <select name="frm_kota" id="frm_kota">
          <? 
		  //$query_nama_kota = $_DB->Query("SELECT * FROM kota");
		  //$count = $_DB->GetResultNumber($query_nama_kota);
 
			 //Check if our query returned any rows to us!
			 if($count == 0 )
			 {
				 echo "There query returned 0 rows!";
			 }
		 
			 // if we have any rows returned:
			 else
			 {
				 for($i=0; $i < $count; $i++)
				 {
					 $row_kota[$i]["id_kota"] =  $_DB->GetResultValue($query, $i, "id_kota");
					 $row_kota[$i]["nama"]   =  $_DB->GetResultValue($query, $i, "nama");
				  ?>
				  <option value="<?=$row_kota[$i]["id_kota"];?>"><?=$row_kota[$i]["nama"];?></option>
                 <? }
             }?>
            
        </select></td>
      </tr>
      <tr>
        <td>Propinsi</td>
        <td>:</td>
        <td><select name="frm_propinsi" id="frm_propinsi">
        <? 
		  $query = $_DB->Query("SELECT * FROM propinsi");
		  $count = $_DB->GetResultNumber($query);
 
			 //Check if our query returned any rows to us!
			 if($count == 0 )
			 {
				 echo "There query returned 0 rows!";
			 }
		 
			 // if we have any rows returned:
			 else
			 {
				 for($i=0; $i < $count; $i++)
				 {
					 $row[$i]["id_propinsi"] =  $_DB->GetResultValue($query, $i, "id_propinsi");
					 $row[$i]["nama"]   =  $_DB->GetResultValue($query, $i, "nama");
				  ?>
				  <option value="<?=$row[$i]["id_propinsi"];?>"><?=$row[$i]["nama"];?></option>
                 <? }
             }?>
        </select></td>
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
        <select name="frm_club" id="frm_club">
        <? 
		  $query = $_DB->Query("SELECT * FROM club");
		  $count = $_DB->GetResultNumber($query);
 
			 //Check if our query returned any rows to us!
			 if($count == 0 )
			 {
				 echo "There query returned 0 rows!";
			 }
		 
			 // if we have any rows returned:
			 else
			 {
				 for($i=0; $i < $count; $i++)
				 {
					 $row[$i]["id_club"] =  $_DB->GetResultValue($query, $i, "id_club");
					 $row[$i]["nama"]   =  $_DB->GetResultValue($query, $i, "nama");
				  ?>
				  <option value="<?=$row[$i]["id_club"];?>"><?=$row[$i]["nama"];?></option>
                 <? }
             }?>
        </select></td>
      </tr>
      <tr>
        <td>Nama Gabungan</td>
        <td>:</td>
        <td>
        <select name="frm_gabungan" id="frm_gabungan">
        <? 
		  $query = $_DB->Query("SELECT * FROM gabungan");
		  $count = $_DB->GetResultNumber($query);
 
			 //Check if our query returned any rows to us!
			 if($count == 0 )
			 {
				 echo "There query returned 0 rows!";
			 }
		 
			 // if we have any rows returned:
			 else
			 {
				 for($i=0; $i < $count; $i++)
				 {
					 $row[$i]["id_gabungan"] =  $_DB->GetResultValue($query, $i, "id_gabungan");
					 $row[$i]["nama"]   =  $_DB->GetResultValue($query, $i, "nama");
				  ?>
				  <option value="<?=$row[$i]["id_gabungan"];?>"><?=$row[$i]["nama"];?></option>
                 <? }
             }?>
        </select></td>
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
            <input name="frm_simpan" id="frm_simpan" type="submit" onClick="this.form.action+='?act=1';this.form.submit();" value="Simpan">
            <input name="Submit2" type="reset" onClick="this.form.action+='?act=3';this.form.submit();" value="Batal">
            <?php if ($frm_no_induk_atlit) { ?>
            <input name="frm_hapus" id="frm_hapus" type="submit" type="button" class="tombol"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_no_induk_atlit;?>';this.form.submit()};" value="Hapus">
        <?php } ?>
          
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