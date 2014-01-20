<?php
/* 
   DATE CREATED : 16/06/08

   KEGUNAAN     : ENTRY MASTER ALUMNI
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/
session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);


if ($act==1)   
{ // simpan data
	// validasi tanggal
	if ($frm_tanggal_lulus!='') 
		{
			if (datetomysql($frm_tanggal_lulus)) 
				{
					$frm_tanggal_lulus = datetomysql($frm_tanggal_lulus);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal lulus tidak valid";
				}
		}

	
	if ($frm_tanggal_mulai_kerja!='') 
		{
			if (datetomysql($frm_tanggal_mulai_kerja)) 
				{
					$frm_tanggal_mulai_kerja = datetomysql($frm_tanggal_mulai_kerja);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal mulai kerja tidak valid";
				}
		}

	if (($frm_nrp!='') and ($frm_nama=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, mahasiswa dengan nrp tersebut tidak tercatat dalam database. ";
		}
	
	if (($frm_nrp=='') or ($frm_tanggal_lulus=='') or ($frm_IPK_lulus=='') or ($frm_masa_studi=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi NRP, Tanggal Lulus, IPK Lulus, dan Masa Studi mahasiswa. ";
		}
	if ($frm_jurusan=='') 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi Jurusan Mahasiswa. ";
		}
		
	if ($error==1) {
	$pesan=$pesan."<br>Gagal menyimpan data.";
	}	

	if ($error !=1) // Jika semua isian form valid 
		{
			if ($frm_exist2!=1)
				{  
				if ($frm_tanggal_mulai_kerja=='')
				{
					// echo "<br>kosong";
					 $frm_tanggal_mulai_kerja="0000-00-00";
					// echo "<br>frm_tanggal_mulai_kerja=".$frm_tanggal_mulai_kerja;
				}
				 
				    $sqlMasuk="INSERT INTO master_alumni ( `nrp` , 
				                                           `tanggal_lulus` , 
														   `IPK_lulus` , 
														   `masa_studi` ,
														   `nama_perusahaan`,  
														   `alamat_perusahaan` , 
														   `id_kota_perusahaan` , 
														   `telepon_perusahaan` , 
														   `jabatan` , 
														   `tanggal_mulai_kerja` , 
														   `gaji_pertama`) 
								VALUES ( '".$frm_nrp."', 
								         '".$frm_tanggal_lulus."', 
										 ".$frm_IPK_lulus.", 
										 ".$frm_masa_studi.", 
										 '".$frm_nama_perusahaan."', 
										 '".$frm_alamat_perusahaan."', 
										 ".$frm_id_kota_perusahaan.", 
										 '".$frm_telepon_perusahaan."', 
										 '".$frm_jabatan."', 
										 '".$frm_tanggal_mulai_kerja."', 
										 ".$frm_gaji_pertama.") ";
				   // echo $sqlMasuk;
					$result = mysql_query($sqlMasuk);
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah ditambahkan";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data - ".mysql_error();
						}
						
			}
			else
			{
					if ($frm_tanggal_mulai_kerja=='')
					{
						 //echo "<br>kosong";
						 $frm_tanggal_mulai_kerja="0000-00-00";
						// echo "<br>frm_tanggal_mulai_kerja=".$frm_tanggal_mulai_kerja;
					}
				 	 $result = mysql_query("UPDATE master_alumni SET `tanggal_lulus`='$frm_tanggal_lulus' , 
																	 `IPK_lulus`='$frm_IPK_lulus' , 
																	 `masa_studi`='$frm_masa_studi'  ,
																	 `nama_perusahaan`='$frm_nama_perusahaan'  , 
																	 `alamat_perusahaan`='$frm_alamat_perusahaan'  , 
																	 `id_kota_perusahaan`='$frm_id_kota_perusahaan'  , 
																	 `telepon_perusahaan`='$frm_telepon_perusahaan'  , 
																	 `jabatan`='$frm_jabatan', 
																	 `tanggal_mulai_kerja`='$frm_tanggal_mulai_kerja', 
																	 `gaji_pertama`='$frm_gaji_pertama' 
															   WHERE `nrp`='$frm_nrp'");
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal mengubah data - ".mysql_error();
						}
				}
		}
	}


if ($act==2) { // hapus data
$result = mysql_query("DELETE FROM master_alumni WHERE nrp = '".$frm_nrp."'");
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
// Jika data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_id="";
	$frm_nrp="";
	$frm_jurusan = "";
	$frm_nama="";
	
	$frm_IPK_lulus = "";
	$frm_tanggal_lulus = "";
	$frm_masa_studi= "";
	$frm_nama_perusahaan = "";
	$frm_alamat_perusahaan = "";
	$frm_id_kota_perusahaan="";
	$frm_telepon_perusahaan ="";
	$frm_jabatan ="";
	$frm_tanggal_mulai_kerja ="";
	$frm_gaji_pertama ="";
	
}
else
{
// Jika user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_nrp!='')  {
$result = mysql_query("SELECT master_mhs.NRP,
							  master_mhs.NAMA,
							  master_mhs.JURUSAN
						 FROM master_mhs
					    WHERE master_mhs.nrp='$frm_nrp'");
				
	if ($row = mysql_fetch_array($result)) {
		$frm_nrp = $row["NRP"];
		$frm_nama = $row["NAMA"];
		$frm_jurusan = $row["JURUSAN"];
		
		$result2 = mysql_query("SELECT master_alumni.nrp as alumni_nrp,
									   master_alumni.IPK_lulus,
									   DATE_FORMAT(master_alumni.tanggal_lulus,'%d/%m/%Y') as tanggal_lulus ,
									   master_alumni.masa_studi,
									   master_alumni.nama_perusahaan,
									   master_alumni.alamat_perusahaan,
									   master_alumni.id_kota_perusahaan,
									   master_alumni.telepon_perusahaan,
									   master_alumni.jabatan,
									   DATE_FORMAT(master_alumni.tanggal_mulai_kerja,'%d/%m/%Y') as tanggal_mulai_kerja,
									   master_alumni.gaji_pertama
								  FROM master_alumni
								 WHERE master_alumni.nrp='$frm_nrp'");
				
					if ($row = mysql_fetch_array($result2)) {
					    $frm_exist2=1;
						$frm_IPK_lulus= $row["IPK_lulus"];
						$frm_masa_studi = $row["masa_studi"];
						
						$frm_nama_perusahaan = $row["nama_perusahaan"];
						$frm_alamat_perusahaan = $row["alamat_perusahaan"];
						$frm_id_kota_perusahaan = $row["id_kota_perusahaan"];
						$frm_telepon_perusahaan = $row["telepon_perusahaan"];
						$frm_jabatan=$row["jabatan"];
					    
						//$frm_tanggal_lulus = $row["tanggal_lulus"];
						if ($row["tanggal_lulus"]=="00/00/0000") {
						$frm_tanggal_lulus = ""; }else {
						$frm_tanggal_lulus = $row["tanggal_lulus"];}
						
						$frm_tanggal_mulai_kerja = $row["tanggal_mulai_kerja"];
						if ($row["tanggal_mulai_kerja"]=="00/00/0000") {
						$frm_tanggal_mulai_kerja = ""; }else {
						$frm_tanggal_mulai_kerja = $row["tanggal_mulai_kerja"];}
						
						$frm_gaji_pertama = $row["gaji_pertama"];
				    } 
					else 
					{
						$frm_exist2 = 0;
						$frm_IPK_lulus = "";
						$frm_masa_studi = "";
						$frm_tanggal_lulus = "";
						$frm_nama_perusahaan = "";
						$frm_alamat_perusahaan = "";
						$frm_id_kota_perusahaan = "";
						$frm_telepon_perusahaan = "";
						$frm_jabatan = "";
						$frm_tanggal_mulai_kerja = "";
						$frm_gaji_pertama = "";
						$frm_jurusan = "";
					}		
     }

}
}
?>
<html>
<head>
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<script language="JavaScript" src="../../include/tanggalan.js">
</script>
<body class="body">
<form name="form_alumni" id="form_alumni" action="master_alumni.php"  method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4"> <hr size="1" color="#FF9900"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>ENTRY 
              DATA ~</strong> MASTER ALUMNI</font></font> </td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">SCORE CARD</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="7%">&nbsp;</td> 
      <td width="15%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="77%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>NRP</td>
      <td width="1%"><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nrp" type="text" id="frm_nrp" size="10" maxlength="10" value="<?php echo $frm_nrp; ?>" onBlur="document.form_alumni.submit()" class="tekboxku" > 
        <input name="frm_exist2" id="frm_exist2" type="hidden" value="<?php echo $frm_exist2; ?>">
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Jurusan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	    <select name="frm_jurusan" id="frm_jurusan" class="tekboxku">
          <option value="0" <?php if ($frm_jurusan=='') {echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sql_jurusan="SELECT * FROM jurusan WHERE id>0 AND id<=8";
				$result = @mysql_query($sql_jurusan);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
				  <option value="<?php echo $row->id2; ?>" <?php if ($frm_jurusan==$row->id2) { echo "selected"; }?>> <?php echo $row->jurusan; ?></option>
				  <?php
				}
				?>
        </select>
	    <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nama</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <? 
	  	$sql3="SELECT * FROM master_mhs WHERE nrp='$frm_nrp'";
		$result3=mysql_db_query($DB,$sql3);
		$row3=mysql_fetch_array($result3)
	  ?>
	  <input name="frm_nama" readonly type="text" id="frm_nama" value="<?php echo $frm_nama; ?>" size="50" maxlength="50" class="tekboxku">
	  <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal Lulus</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tanggal_lulus" type="text" id="frm_tanggal_lulus" size="10" maxlength="10" value="<?php echo $frm_tanggal_lulus; ?>" class="tekboxku"> 
        <A Href="javascript:show_calendar('form_alumni.frm_tanggal_lulus',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="bottom" border=0> 
        </A>(dd/mm/yyyy) <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>IPK Lulus</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_IPK_lulus" type="text" id="frm_IPK_lulus" value="<?php echo $frm_IPK_lulus; ?>" size="5" maxlength="5" class="tekboxku">
        (x.xx) <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>Masa Studi (semester)</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_masa_studi" type="text" id="frm_masa_studi" value="<?php echo $frm_masa_studi; ?>" size="2" maxlength="2" class="tekboxku">
      <font color="#FF0000">*</font>      </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nama Perusahaan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nama_perusahaan" type="text" id="frm_nama_perusahaan" value="<?php echo $frm_nama_perusahaan; ?>" size="50" maxlength="50" class="tekboxku"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Alamat Perusahaan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_alamat_perusahaan" type="text" value="<?php echo $frm_alamat_perusahaan; ?>" size="50" maxlength="100" class="tekboxku"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Kota Perusahaan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <select name="frm_id_kota_perusahaan" id="frm_id_kota_perusahaan" class="tekboxku">
		<?php
		// =============================================================== 
		//$result1 = @mysql_query("Select id, nama, kode_area from kota");
		// Harusnya kode area diambil dari setting kota asal
		// ===============================================================
	
			$result1 = @mysql_query("Select id, nama, kode_area from kota");
			$c=0;
			while ($row1=@mysql_fetch_object($result1))  {
			$c=$c+1;
	?>
          <option value="<?php echo $row1->id; ?>" <?php if ($frm_id_kota_perusahaan==$row1->id) { echo "selected"; $frm_kode_area_perusahaan=$row1->kode_area; }?> onChange="document.form_alumni.submit()" ><?php echo $row1->nama; ?></option>
          <?php
	}
	
	?>
        </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Telepon Perusahaan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><?php //echo $frm_kode_area_perusahaan." - "; ?> <input name="frm_telepon_perusahaan" type="text" id="frm_telepon_perusahaan" size="20" value="<?php echo $frm_telepon_perusahaan; ?>" class="tekboxku"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Jabatan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_jabatan" type="text" value="<?php echo $frm_jabatan; ?>" size="50" maxlength="100" class="tekboxku"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal Mulai Kerja</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tanggal_mulai_kerja" type="text" id="frm_tanggal_mulai_kerja" size="10" maxlength="10" value="<?php echo $frm_tanggal_mulai_kerja; ?>" class="tekboxku"> 
        <A Href="javascript:show_calendar('form_alumni.frm_tanggal_mulai_kerja',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="bottom" border=0> 
        </A>(dd/mm/yyyy) </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Gaji Pertama</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_gaji_pertama" id="frm_gaji_pertama" class="tekboxku">
          <?php
	$result1 = @mysql_query("Select id, gaji from gaji order by id");
	$c=0;
	while ($row1=@mysql_fetch_object($result1))  {
	$c=$c+1;
	?>
          <option value="<?php echo $row1->id; ?>" <?php if ($frm_gaji_pertama==$row1->id) { echo "selected"; }?> ><?php echo $row1->gaji; ?></option>
          <?php
	}
	
	?>
        </select></td>
    </tr><tr>
      <td>      
      </td><tr>
        <td>        
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
        <?php if ($frm_tanggal_lulus) { ?>
        <input name="Submit3" type="button" class="tombol"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_nrp;?>';this.form.submit()};" value="Hapus">
        <?php } ?></td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;      </td>
    </tr>
    <tr> 
      <td colspan="4"><font size="1"><span class="style1">*</span> compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>