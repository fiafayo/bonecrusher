<?
/* 
   DATE CREATED : 10/06/08
   UPDATE  		: 
   KEGUNAAN     : ENTRY RASIO PO MAHASISWA
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ // simpan data
 // Kode dan nama harus diisi
	if ($frm_id_tahun_ajar=='') 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi Data dengan lengkap. ";
		}

	if ($error==1) 
		{
			$pesan=$pesan."<br>Gagal menyimpan data.";
		}
		
	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_exist!=1) 
				{
					echo "<br>INSERT";
					echo "<br>frm_exist=".$frm_exist;
					echo "<br>frm_id_tahun_ajar=".$frm_id_tahun_ajar;
					echo "<br>frm_angkatan=".$frm_angkatan;
					echo "<br>frm_jurusan=".$frm_jurusan;
					echo "<br>jum_mhs_aktif=".$frm_jum_mhs_aktif;
					echo "<br>jum_mhs_PO=".$frm_jum_mhs_po;
					
					$result = mysql_query("INSERT INTO po (`id_po`, `semester`, `angkatan`, `jurusan_id`, `jum_mhs_aktif`, `jum_mhs_PO`) VALUES ( NULL, ".$frm_id_tahun_ajar.", ".$frm_angkatan.", ".$frm_jurusan.", ".$frm_jum_mhs_aktif.", ".$frm_jum_mhs_po.")");
					if ($result) 
					{
						$pesan = $pesan."<br>Data telah ditambahkan";	
					}
					else
					{ 
						$pesan = $pesan."<br>Gagal menambahkan data";
					}
				}
			else
				{
					echo "<br>UPDATE";
					echo "<br>frm_id_po=".$frm_id_po;
					echo "<br>frm_id_tahun_ajar=".$frm_id_tahun_ajar;
					echo "<br>frm_angkatan=".$frm_angkatan;
					echo "<br>frm_jurusan=".$frm_jurusan;
					echo "<br>jum_mhs_aktif=".$frm_jum_mhs_aktif;
					echo "<br>jum_mhs_do=".$frm_jum_mhs_po;
					$result = mysql_query("UPDATE po SET `semester`=$frm_id_tahun_ajar, 
														 `angkatan`=$frm_angkatan,
														 `jurusan_id`=$frm_jurusan,
														 `jum_mhs_aktif`=$frm_jum_mhs_aktif, 
														 `jum_mhs_PO`=$frm_jum_mhs_po
												   WHERE `id_po`=$frm_id_po");
	
					if ($result) 
					{
						$pesan = $pesan."<br>Data telah diubah";	
					}
					else
					{ 
						$pesan = $pesan."<br>Gagal menyimpan data-".mysql_error();
					}
				}
		}
	}


if ($act==2) { // hapus data

$result = mysql_query("DELETE FROM po WHERE id_po = ".$frm_id_po);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) 
{
	$frm_id_po="";
	$frm_jurusan=0;
	$frm_id_tahun_ajar=0;
	$frm_angkatan ="";
	$frm_jum_mhs_aktif="";
	$frm_jum_mhs_po="";
	//$frm_id_tipe="";
	//$jum=0;
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
//echo "<br>frm_kode=".$frm_kode;
				if ((isset($frm_id_tahun_ajar)) and (isset($frm_jurusan)) and (isset($frm_angkatan))) 
				{
				if (($frm_id_tahun_ajar!=0) and ($frm_jurusan!=NULL) and ($frm_angkatan!=NULL)){
						$result = mysql_query("SELECT id_po, 
													  semester,
													  angkatan, 
													  jurusan_id, 
													  jum_mhs_aktif, 
													  jum_mhs_PO
												 FROM po
												WHERE semester=".$frm_id_tahun_ajar." and 
													  angkatan=".$frm_angkatan." and 
													  jurusan_id=".$frm_jurusan );
				
						if ($row = mysql_fetch_array($result)) {
							$frm_exist=1;
							$frm_id_po=$row["id_po"];
							$frm_id_tahun_ajar = $row["semester"];
							$frm_angkatan = $row["angkatan"];
							$frm_jurusan = $row["jurusan_id"];
							$frm_jum_mhs_aktif = $row["jum_mhs_aktif"];
							$frm_jum_mhs_po = $row["jum_mhs_PO"];
						}
						else
						{
							$frm_exist=0;
							//$frm_jum_mhs_aktif="";
							//$frm_jum_mhs_po="";
						}
						$tahun=substr($frm_id_tahun_ajar, 0,4); 
						$semester=substr($frm_id_tahun_ajar, 4,1);
					}
			}
}
/*
echo "<br>frm_id_tahun_ajar=".$frm_id_tahun_ajar; 
echo "<br>frm_jurusan=".$frm_jurusan; 
echo "<br>frm_id_po=".$frm_id_po;
echo "<br>frm_exist=".$frm_exist;
*/
?>
<html>
<head>
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../../include/tanggalan.js">
</script>
</head>
<body class="body">
<form name="form_po" id="form_po" action="rasio_po_mhs.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4"> <hr size="1" color="#FF9900">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="89%">
				<font color="#0099CC" size="1">
				<? if ($frm_id_po!=''){?>
					<strong>EDIT DATA ~ </strong>
				<? } else
				{?>
					<strong>ENTRY DATA ~ </strong>
				<? }?>
				RASIO PO MAHASISWA</font></td>
            <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">SCORE CARD</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="7%">&nbsp;</td> 
      <td width="13%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="79%">
		  <input type="hidden" name="frm_id_po" id="frm_id_po" value="<?php echo $frm_id_po;?>">
		  <input type="hidden" name="frm_exist" id="frm_exist" value="<?php echo $frm_exist;?>">
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Jurusan</td>
      <td><strong>:</strong></td>
      <td><select name="frm_jurusan" id="frm_jurusan" class="tekboxku">
        <option value="0" <?php if ($frm_jurusan==''){echo "selected";}?>>--- Pilih ---</option>
        <?php 
				$sql_jurusan="SELECT * FROM jurusan WHERE id>0 AND id<=8";
				$result = @mysql_query($sql_jurusan);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
        <option value="<?php echo $row->id; ?>" <?php if ($frm_jurusan==$row->id) { echo "selected"; }?>> <?php echo $row->jurusan; ?></option>
        <?php
				}
				?>
      </select>
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Semester</td>
      <td><strong>:</strong></td>
      <td>
<select name="frm_id_tahun_ajar" id="frm_id_tahun_ajar" class="tekboxku">
  <option value="0">Tahun Ajaran</option>
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
			if (($row1->tahun_ajaran==$tahun) and ($id_semester==$semester))
		    { echo "selected"; }
		  }
		  else
		  { if ((date('Y/m/d')<=$row1->akhir) and (date('Y/m/d')>=$row1->awal))
		    { $current_semester=$row1->id; 
			  echo "selected";
			} 
		  } ?> ><?php echo $row1->id; ?>SEMESTER <?php echo $row1->semester; ?> <?php echo $row1->tahun_ajaran; ?> - <?php echo $row1->tahun_ajaran+1; ?>
 
  </option>
  <?php
	}
	?>
</select>      
<font color="#FF0000">*</font>	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Angkatan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> <font color="#FF0000">
        <input name="frm_angkatan" id="frm_angkatan" onBlur="document.form_po.submit()" value="<? echo $frm_angkatan;?>" type="text" class="tekboxku" size="10" maxlength="10" >
      *</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Jumlah Mhs Aktif </td>
      <td><strong>:</strong></td>
      <td><input name="frm_jum_mhs_aktif" type="text" class="tekboxku" id="frm_jum_mhs_aktif" value="<?php echo $frm_jum_mhs_aktif; ?>" size="10" maxlength="10" >
      <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Jumlah Mhs PO </td>
      <td><strong>:</strong></td>
      <td><input name="frm_jum_mhs_po" type="text" class="tekboxku" id="frm_jum_mhs_po" value="<?php echo $frm_jum_mhs_po; ?>" size="10" maxlength="10" >
      <font color="#FF0000">*</font></td>
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
      <td>
		<input name="Submit" type="submit" class="tombol" onClick="this.form.action+='?act=1';this.form.submit();" value="Simpan">
		<input name="Submit2" type="reset" class="tombol" onClick="this.form.action+='?act=3';this.form.submit();" value="Batal">
		<?php if ($frm_id_po) { ?>
		<input name="Submit3" type="button" class="tombol"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&frm_id_po=<?php echo $frm_id_po;?>';this.form.submit()};" value="Hapus">
		<?php } ?>
	  </td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" size="1">*</font><font size="1"> = 
        compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>