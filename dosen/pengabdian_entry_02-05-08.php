<?
/* 
   DATE CREATED : 05/04/08
   UPDATE  		: 19/04/08 - RAHADI
   KEGUNAAN     : ENTRY PENGABDIAN MASYARAKAT (perorangan)
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/
session_start();
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ // simpan data
	// Pemeriksaan tanggal, apakah tanggal yang dimasukkan valid
	if ($frm_mulai!='') 
		{
			if (datetomysql($frm_mulai)) 
				{
					$frm_mulai = datetomysql($frm_mulai);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal mulai tidak valid";
				}
		}
	
	if ($frm_selesai!='') 
		{
			if (datetomysql($frm_selesai)) 
				{
					$frm_selesai = datetomysql($frm_selesai);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal selesai tidak valid";
				}
		}

// Kode dan nama harus diisi
	if (($frm_kode=='') or ($frm_nama_institusi=='') or ($frm_judul=='') or ($frm_mulai=='') or ($frm_selesai=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi Kode profil, Dosen, Nama Institusi, Judul, Tanggal mulai dan Tanggal selesai. ";
		}

	if ($error==1) 
		{
			$pesan=$pesan."<br>Gagal menyimpan data.";
		}
	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
		//echo "<br>$frm_kode=".$frm_kode;
			if ($frm_id=='') 
				{
					$result = mysql_query("INSERT INTO pengabdian (`id`, `kode`, `jurusan`, `nama_institusi`, `id_jenis`, `kode_dosen`, `jabatan`, `judul`, `mulai`, `selesai`, `tempat`, `jumlah_staff`, `id_sumber_dana`, `jumlah_dana`) VALUES ( NULL, '".$frm_kode."', '".$frm_jurusan."', '".$frm_nama_institusi."', '".$frm_id_jenis."', '".$frm_kode_dsn."', '".$frm_status_jabatan."', '".$frm_judul."', '".$frm_mulai."', '".$frm_selesai."', '".$frm_tempat."', '".$frm_jumlah_staff."', '".$frm_id_sumber_dana."', '".$frm_jumlah_dana."') " );
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah ditambahkan";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data-". mysql_error();
						}
				}
			else
				{
					
					//echo "<br>frm_mulai=".$frm_mulai;
					//echo "<br>frm_selesai=".$frm_selesai;
					$result = mysql_query("UPDATE pengabdian SET `kode` ='$frm_kode', 
																 `jurusan` =$frm_jurusan, 
																 `nama_institusi` ='$frm_nama_institusi', 
																 `id_jenis` ='$frm_id_jenis', 
																 `kode_dosen`='$frm_kode_dsn' ,
																 `jabatan`='$frm_status_jabatan' ,
																 `judul`='$frm_judul' , 
																 `mulai`='$frm_mulai', 
																 `selesai`='$frm_selesai',
																 `tempat`='$frm_tempat',
																 `jumlah_staff`='$frm_jumlah_staff' , 
																 `id_sumber_dana`= '$frm_id_sumber_dana', 
																 `jumlah_dana`= '$frm_jumlah_dana',
																 `tempat`= '$frm_tempat'
														   WHERE `kode`='$frm_kode'");
	
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

$result = mysql_query("DELETE FROM pengabdian WHERE id = ".$frm_id);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
	
if (($act!=0)and($error!=1))
{
	$frm_id="";
	$frm_kode="";
	$frm_jurusan="";
	$frm_nama_institusi="";
	$frm_id_jenis="";
	//$frm_id_tipe="";
	$frm_judul="";
	$frm_mulai="";
	$frm_selesai="";
	$frm_kode_dsn="";
	$frm_status_jabatan="";
	$frm_tempat="";
	$frm_jumlah_staff="";
	$frm_id_sumber_dana="";
	$frm_dana="";
	$jum=0;
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
//echo "<br>frm_kode=".$frm_kode;
if ($frm_kode!='')  {

$result = mysql_query("SELECT id, 
							  kode,
							  jurusan, 
							  nama_institusi, 
							  id_jenis, 
							  kode_dosen,
							  jabatan,
							  judul, 
							  DATE_FORMAT(mulai,'%d/%m/%Y') as mulai,
							  DATE_FORMAT(selesai,'%d/%m/%Y') as selesai,
							  tempat,
							  jumlah_staff, 
							  id_sumber_dana, 
							  jumlah_dana
					     FROM pengabdian 
					    WHERE kode='$frm_kode'");
						//DATE_FORMAT(mulai,'%d/%m/%Y') as mulai,
							  //DATE_FORMAT(selesai,'%d/%m/%Y') as selesai,

					if ($row = mysql_fetch_array($result)) {
						$exist=1;
						$frm_id = $row["id"];
						$frm_kode = $row["kode"];
						$frm_jurusan = $row["jurusan"];
						$frm_nama_institusi = $row["nama_institusi"];
						$frm_id_jenis = $row["id_jenis"];
						//$frm_id_tipe = $row["id_tipe"];
						$frm_judul = $row["judul"];
						$frm_kode_dsn = $row["kode_dosen"];
						$frm_status_jabatan = $row["jabatan"];
						$frm_tempat = $row["tempat"];
						$frm_jumlah_staff = $row["jumlah_staff"];
						$frm_id_sumber_dana = $row["id_sumber_dana"];
						$frm_jumlah_dana = $row["jumlah_dana"];
						
						$frm_mulai = $row["mulai"];
						if ($frm_mulai=="00/00/0000") {
						$frm_mulai = ""; }else {
						$frm_mulai = $row["mulai"];}
						
						$frm_selesai = $row["mulai"];
						if ($frm_selesai=="00/00/0000") {
						$frm_selesai = ""; }else {
						$frm_selesai = $row["selesai"];}
						
						echo "<br>frm_mulai=".$frm_mulai;
						echo "<br>frm_selesai=".$frm_selesai;
					//exit();
						/*echo $frm_id;
						echo $frm_kode ;
						echo $frm_jurusan;
						echo $frm_nama_institusi;
						echo $frm_id_jenis;
						echo $frm_id_tipe ;
						echo $frm_judul;
						echo $frm_mulai ;
						echo $frm_kode_dsn;
						echo $frm_status_jabatan ;
						echo $frm_selesai;
						echo $frm_tempat ;
						echo $frm_jumlah_staff;
						echo $frm_id_sumber_dana ;
						echo $frm_jumlah_dana;*/
					}
					else
					{
						//$frm_id="";
						//$frm_kode="";
						//$frm_jurusan="";
						$frm_nama_institusi="";
						$frm_id_jenis="";
						//$frm_id_tipe="";
						$frm_judul="";
						$frm_mulai="";
						$frm_selesai="";
						$frm_kode_dsn="";
						$frm_status_jabatan="";
						$frm_tempat="";
						$frm_jumlah_staff="";
						$frm_id_sumber_dana="";
						$frm_dana="";
						$jum=0;
					}
}
else
{
		//$frm_id="";
		//$frm_jurusan="";
		$frm_nama_institusi="";
		$frm_id_jenis="";
		$frm_judul="";
		$frm_mulai="";
		$frm_selesai="";
		$frm_kode_dsn="";
		$frm_status_jabatan="";
		$frm_tempat="";
		$frm_jumlah_staff="";
		$frm_id_sumber_dana="";
		$frm_dana="";
		$jum=0;
}

}

?>
<html>
<head>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../include/tanggalan.js">
</script>
</head>
<body class="body">
<form name="form_abdi" id="form_abdi" action="pengabdian_entry.php" method="post">
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
				<? if ($frm_kode!=''){?>
					<strong>EDIT DATA ~ </strong>
				<? } else
				{?>
					<strong>ENTRY DATA ~ </strong>
				<? }?>
				PENGABDIAN MASYARAKAT</font>
			</td>
            <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">DOSEN</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="7%">&nbsp;</td> 
      <td width="13%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="79%">&nbsp; <input type="hidden" name="frm_id" id="frm_id" value="<?php echo $frm_id;?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Jurusan</td>
      <td><strong>:</strong></td>
      <td><? //echo "<br>frm_jurusan=".$frm_jurusan; ?>
	  <select name="frm_jurusan" id="frm_jurusan" class="tekboxku" onChange="document.form_abdi.submit()">
        <option value="" <?php if ($frm_jurusan==''){echo "selected";}?>>--- Pilih ---</option>
        <?php
				 $result3 = @mysql_query("SELECT * FROM jurusan WHERE id>0 ORDER BY id ASC");
				 $c=0;
				 while(($row3 = mysql_fetch_object($result3)))
				 {
				 	$c=$c+1;
					?>
        <option  value="<?php echo $row3->id; ?>" <?php if ($frm_jurusan==$row3->id) { echo "selected"; }?> ><?php echo $row3->jurusan; ?></option>
        <? }?>
      </select>
	  <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Kode Pengabdian terakhir </td>
      <td><strong>:</strong></td>
      <td>
	  <?
	  	$sql="SELECT kode 
				FROM pengabdian 
			   WHERE kode <>'' ";
				 
		if (($frm_jurusan!="") or ($frm_jurusan!=NULL))
		{ $sql=$sql." and jurusan =".$frm_jurusan; }
		
		$sql=$sql." ORDER BY kode DESC LIMIT 1";
		
		$result_kode_terakhir = mysql_query($sql);
		$row_kode_terakhir = mysql_fetch_array($result_kode_terakhir);
		$frm_kode_last = $row_kode_terakhir["kode"];
	  ?>
	  <input name="frm_kode_last" type="text" class="tekboxku" id="frm_kode_last" value="<?php echo $frm_kode_last; ?>" size="10" maxlength="10">
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Kode Pengabdian</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_kode" type="text" class="tekboxku" id="frm_kode" onBlur="document.form_abdi.submit()" value="<?php echo $frm_kode; ?>" size="10" maxlength="10" >
      <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nama Institusi </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nama_institusi" type="text" class="tekboxku" id="frm_nama" value="<?php echo $frm_nama_institusi; ?>" size="50" maxlength="75">
      <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Dosen</td>
      <td><strong>:</strong></td>
      <td>
	  	<select name="frm_kode_dsn" id="frm_kode_dsn" class="tekboxku" >
           <option value="" <?php if ($frm_kode_dsn==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sqlDosen="select kode, nama
						   from dosen
						   where kode like '61%'";
				
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->kode; ?>" <?php if ($frm_kode_dsn==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
          <?php }?>
        </select>
  	  <? 
	  if ($frm_kode_dsn<>'') {
	  $jum++;
	 // echo "OK, ".$jum;
	  }
	  ?>
	  , jabatan : 
  	  <select name="frm_status_jabatan" id="frm_status_jabatan" class="tekboxku">
        <option value="0" <?php if ($frm_status_jabatan==''){echo "selected";}?>>--- Pilih ---</option>
        <option value="1" <?php if ($frm_status_jabatan=='1'){echo "selected";}?>>Ketua</option>
        <option value="2" <?php if ($frm_status_jabatan=='2'){echo "selected";}?>>Wakil Ketua</option>
        <option value="3" <?php if ($frm_status_jabatan=='3'){echo "selected";}?>>Anggota</option>
		<option value="4" <?php if ($frm_status_jabatan=='4'){echo "selected";}?>>Instruktur</option>
      </select> 
      <font color="#FF0000">*</font> </td>
    </tr>
	
    <tr>
      <td>&nbsp;</td> 
      <td>Jenis Publikasi</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_id_jenis" id="frm_id_jenis" class="tekboxku">
          <?php

	$result1 = @mysql_query("Select id, nama from jenis_kerjasama");
	$c=0;
	while ($row1=@mysql_fetch_object($result1))  {
	$c=$c+1;
	?>
          <option  onBlur="document.form_abdi.submit()" value="<?php echo $row1->id; ?>" <?php if (($frm_id_jenis==$row1->id) or (($frm_id_jenis=='') and ($c==1))) { echo "selected"; }?> ><?php echo $row1->nama; ?></option>
          <?php
	}
	
	?>
        </select></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td> 
      <td valign="top">Judul </td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td valign="top"><textarea name="frm_judul" id="frm_judul" cols="50" class="tekboxku"><?php echo $frm_judul; ?></textarea>
      <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal Mulai</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_mulai" type="text" class="tekboxku" id="frm_mulai" value="<?php echo $frm_mulai; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('form_abdi.frm_mulai',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="bottom" border=0> 
        </A>(dd/mm/yyyy) <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal Selesai</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_selesai" type="text" class="tekboxku" id="frm_selesai" value="<?php echo $frm_selesai; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('form_abdi.frm_selesai',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="bottom" border=0> 
        </A>(dd/mm/yyyy) <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top" nowrap>Tempat/Lokasi</td>
      <td valign="top"><strong>:</strong></td>
      <td><textarea name="frm_tempat" id="frm_tempat" cols="50" class="tekboxku"><?php echo $frm_tempat; ?></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td nowrap>Jumlah Anggota Tim</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_jumlah_staff" id="frm_jumlah_staff" type="text" class="tekboxku" value="<?php echo $frm_jumlah_staff; ?>"></td>
    </tr>
    <tr>
		  <td>&nbsp;</td> 
		  <td>Sumber Dana</td>
		  <td><div align="center"><strong>:</strong></div></td>
		  <td>
			<select name="frm_id_sumber_dana" id="frm_id_sumber_dana" class="tekboxku">
				<?php
				$result1 = @mysql_query("Select id, nama from sumber_dana");
				$c=0;
				while ($row1=@mysql_fetch_object($result1))  {
				$c=$c+1;
				?>
			<option value="<?php echo $row1->id; ?>" <?php if (($frm_id_sumber_dana==$row1->id) or (($frm_id_sumber_dana=='') and ($c==1))) { echo "selected"; }?> ><?php echo $row1->nama; ?></option>
			<?php }?>
			</select>
		  </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nominal Dana</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_jumlah_dana" id="frm_jumlah_dana" type="text" class="tekboxku" value="<?php echo $frm_jumlah_dana; ?>"></td>
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
		<input name="Submit" type="submit" class="tombol" onClick="this.form.action+='?act=1&jum=<? echo $jum;?>';this.form.submit();" value="Simpan">
		<input name="Submit2" type="reset" class="tombol" onClick="this.form.action+='?act=3';this.form.submit();" value="Batal">
		<?php if ($frm_id) { ?>
		<input name="Submit3" type="button" class="tombol"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_id;?>';this.form.submit()};" value="Hapus">
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