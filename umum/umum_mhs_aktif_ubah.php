<?php
/* 
   DATE CREATED : 15/11/07 - RAHADI
   KEGUNAAN     : ENTRY MASTER MAHASISWA AKTIF
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
//echo "<br>frm_id_tahun_ajar=".$frm_id_tahun_ajar;
	if (($frm_s_jurusan=='pilih') or ($frm_angkatan=='') or ($frm_id_tahun_ajar=='') or ($frm_jumlah_mhs=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data Mahasiswa Aktif dengan benar. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
		//echo "<br>id_data=".$id_data;
			
					$result = mysql_query("UPDATE mhs_aktif SET  mhs_aktif.id_jurusan=$frm_s_jurusan,
																 mhs_aktif.angkatan='$frm_angkatan',
																 mhs_aktif.jum_mhs=$frm_jumlah_mhs,
																 mhs_aktif.periode=$frm_id_tahun_ajar
														   where mhs_aktif.idnya=$id_data");
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";
							header("Location: umum_mhs_aktif.php");
							?>
							<script language="JavaScript">
							  document.location="umum_mhs_aktif.php";
							</script>
						    <? 	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menyimpan data";
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
	/*if ($frm_nama_kota!='')  {
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
				echo "<br>@ frm_exist=".$frm_exist;
				echo "<br>@ frm_id_kota=".$frm_id_kota;
				echo "<br>@ frm_nama_kota=".$frm_nama_kota;
				echo "<br>@ frm_id_propinsi=".$frm_id_propinsi;
				echo "<br>@ frm_kode_area=".$frm_kode_area;
				echo "<br>@ frm_id_propinsi2=".$frm_id_propinsi2;
			}
			else
			{
				echo "<BR>H E R E ";
				$frm_exist = 0;
				$frm_id_kota = "";
			    $frm_kode_area = "";
				$frm_id_propinsi = "";
			}
	}*/
}
if ($act==3) { 
header("Location: umum_mhs_aktif.php");
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
$id_data=$_GET["kd"];
//echo "<br>kode= ".$id_data;
if ($id_data<>"")
{
			$result = mysql_query("SELECT mhs_aktif.idnya,
										  mhs_aktif.id_jurusan,
										  mhs_aktif.angkatan,
										  mhs_aktif.jum_mhs,
										  mhs_aktif.periode
								     FROM mhs_aktif
									WHERE mhs_aktif.idnya=$id_data");
			
			if ($row = mysql_fetch_array($result))		
			{  
			    $frm_exist=1;
				$frm_s_jurusan = $row["id_jurusan"];
				$frm_angkatan = $row["angkatan"];
				$frm_id_tahun_ajar = $row["periode"];
				$frm_jumlah_mhs = $row["jum_mhs"];
				//echo "<br>@ frm_s_jurusan=".$frm_s_jurusan;
				//echo "<br>@ frm_angkatan=".$frm_angkatan;
				//echo "<br>@ frm_id_tahun_ajar=".$frm_id_tahun_ajar;
				//echo "<br>@ frm_jumlah_mhs=".$frm_jumlah_mhs;
				
				$tahun=substr($frm_id_tahun_ajar, 0,4); 
				$semester=substr($frm_id_tahun_ajar, 4,1); 
				
				//echo "<br> tahun=".$tahun;
				//echo "<br> semester=".$semester;
				
				switch ($semester) {
				case '1':
					$semester='GASAL';
					break;
				case '2':
					$semester='GENAP';
					break;
				}
				
				//echo "<br> tahun=".$tahun;
				//echo "<br> semester=".$semester;
				}
			
?>
<form name="umum_mhs_aktif" id="umum_mhs_aktif" action="umum_mhs_aktif_ubah.php" method="post">
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
            <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>ENTRY DATA ~</strong> MAHASISWA AKTIF </font></font> </td>
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
      <td width="83%"><input type="hidden" name="id_data" id="id_data" value="<? echo $id_data;?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Jurusan</td>
      <td><strong>:</strong></td>
      <td>
	  <select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku">
	  <option <?php if ($frm_s_jurusan==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sql_jurusan="SELECT * FROM jurusan WHERE id>0 AND id<6";
				$result = @mysql_query($sql_jurusan);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->id; ?>" <?php if ($frm_s_jurusan==$row->id) { echo "selected"; }?> > <?php echo $row->jurusan; ?></option>
          <?php
				}
				?>
      </select>
	  <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Angkatan</td>
      <td><strong>:</strong></td>
      <td><input name="frm_angkatan" type="text" class="tekboxku" id="frm_angkatan" value="<?php echo $frm_angkatan; ?>" size="8" maxlength="4" >
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Semester</td>
      <td><strong>:</strong></td>
      <td>
	  <select name="frm_id_tahun_ajar" id="frm_id_tahun_ajar" class="tekboxku">
        <option>Tahun Ajaran</option>
        <?php
			$result1 = @mysql_query("Select id, tahun_ajaran, semester, DATE_FORMAT(awal,'%Y/%m/%d') as awal, DATE_FORMAT(akhir,'%Y/%m/%d') as akhir from tahun_ajar order by id asc");
			$c=0;
			if ($frm_id_tahun_ajar=='') { $cek_id_tahun_ajar=$row1->id; }
			else { $cek_id_tahun_ajar=$frm_id_tahun_ajar; }
			while ($row1=@mysql_fetch_object($result1))  {
			$c=$c+1;
			if ( $row1->semester=="GASAL")
			{ $id_semester="1";}
			else
			{ $id_semester="2";}
		?>
      
	    <option value="<?php echo $row1->tahun_ajaran."".$id_semester; ?>" <?php 
		  if ($frm_id_tahun_ajar!='') 
		  { 
		    //if ($row1->id==$cek_id_tahun_ajar)
		   // { echo "selected"; }
			if (($row1->tahun_ajaran==$tahun) and ($row1->semester==$semester))
		    { echo "selected"; }
		  }
		  else
		  { if ((date('Y/m/d')<=$row1->akhir) and (date('Y/m/d')>=$row1->awal))
		    { $current_semester=$row1->id; 
			  echo "selected";
			} 
		  } ?> ><?php //echo $row1->id; ?>SEMESTER <?php echo $row1->semester; ?> <?php echo $row1->tahun_ajaran; ?> - <?php echo $row1->tahun_ajaran+1; ?>
        <?php
		//echo date('Y/m/d');
		//echo ">=";
		//echo $row1->awal;
		//echo "=";
		//echo date('Y/m/d')>=$row1->awal;
		?>
        <?php
		//echo date('Y/m/d');
		//echo "<=";
		//echo $row1->akhir;
		//echo "=";
		//echo date('Y/m/d')<=$row1->akhir;
		?>
        </option>
        <?php
	}
	
	?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td nowrap>Jumlah Mahasiswa </td>
      <td><strong>:</strong></td>
      <td><input name="frm_jumlah_mhs" type="text" class="tekboxku" id="frm_jumlah_mhs" value="<?php echo $frm_jumlah_mhs; ?>" size="8" maxlength="8" >
      <span class="style1">*</span></td>
    </tr>
	<tr>
	  <td>&nbsp;</td> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;	  </td>
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
        <?php } ?>
	  </td>
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
<? }?>