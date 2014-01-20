<?
/* 
   DATE CREATED : 12/08/07
   KEGUNAAN     : ENTRY PROFIL KERJASAMA
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
	if ($frm_tgl_mulai!='') 
		{
			if (datetomysql($frm_tgl_mulai)) 
				{
					$frm_tgl_mulai = datetomysql($frm_tgl_mulai);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal mulai tidak valid";
				}
		}
if ($frm_tgl_selesai!='') 
		{
			if (datetomysql($frm_tgl_selesai)) 
				{
					$frm_tgl_selesai = datetomysql($frm_tgl_selesai);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal selesai tidak valid";
				}
		}

// Kode dan nama harus diisi

	if (($frm_kode=='') or ($frm_nama_institusi=='') or ($frm_judul=='') or ($frm_s_jurusan=='') or ($frm_id_tipe=='') or ($frm_id_jenis=='') or ($frm_tgl_mulai=='') or ($frm_tgl_selesai=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi data profil kerjasama dengan lengkap. ";
		}

	if ($error==1) 
		{
			$pesan=$pesan."<br>Gagal menyimpan data.";
		}
	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_id=='') 
				{
					$result = mysql_query("INSERT INTO profil_kerjasama ( `id`, `kode`, `jurusan`, `nama_institusi`, `id_jenis`, `id_tipe`, `judul`, `mulai`, `selesai`, `jumlah_staff`, `id_sumber_dana`, `jumlah_dana` ) VALUES ( '', '".$frm_kode."', '".$frm_s_jurusan."', '".$frm_nama_institusi."', '".$frm_id_jenis."', '".$frm_id_tipe."', '".$frm_judul."', '".$frm_tgl_mulai."', '".$frm_tgl_selesai."', '".$frm_jumlah_staff."', '".$frm_id_sumber_dana."', '".$frm_jumlah_dana."') " );

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

$result = mysql_query("UPDATE profil_kerjasama set `kode` ='$frm_kode', `jurusan` ='$frm_s_jurusan', `nama_institusi` ='$frm_nama_institusi', `id_jenis` ='$frm_id_jenis', `id_tipe`='$frm_id_tipe' , `judul`='$frm_judul' , `mulai`='$frm_tgl_mulai', `selesai`='$frm_tgl_selesai', `jumlah_staff`='$frm_jumlah_staff' , `id_sumber_dana`= '$frm_id_sumber_dana', `jumlah_dana`= '$frm_jumlah_dana' where `id`='$frm_id'");

	
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menyimpan data";
						}
				}
		}
	}


if ($act==2) { // hapus data

$result = mysql_query("delete from profil_kerjasama where id = ".$frm_id);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
	
if (($act!=0)and($error!=1)) 
{
	$frm_id="";
	$frm_kode="";
	$frm_s_jurusan="0";
	$frm_nama_institusi="";
	$frm_id_jenis="1";
	$frm_id_tipe="1";
	$frm_judul="";
	$frm_tgl_mulai="";
	$frm_tgl_selesai="";
	$frm_jumlah_staff="";
	$frm_id_sumber_dana="1";
	$frm_jumlah_dana = "";
	//$frm_dana="";

}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_kode!='')  {
$result = mysql_query("Select id, 
							  kode,
							  jurusan, 
							  nama_institusi, 
							  id_jenis, 
							  id_tipe, 
							  judul, 
							  DATE_FORMAT(mulai,\"%d/%m/%Y\") as mulai,
							  DATE_FORMAT(selesai,\"%d/%m/%Y\") as selesai,
							  jumlah_staff, 
							  id_sumber_dana, 
							  jumlah_dana 
					   from profil_kerjasama 
					   where kode='$frm_kode'");

						if ($row = mysql_fetch_array($result)) {
							$frm_id = $row["id"];
							$frm_kode = $row["kode"];
							$frm_s_jurusan = $row["jurusan"];
							$frm_nama_institusi = $row["nama_institusi"];
							$frm_id_jenis = $row["id_jenis"];
							$frm_id_tipe = $row["id_tipe"];
							$frm_judul = $row["judul"];
							$frm_tgl_mulai = $row["mulai"];
							$frm_tgl_selesai = $row["selesai"];
							$frm_jumlah_staff = $row["jumlah_staff"];
							$frm_id_sumber_dana = $row["id_sumber_dana"];
							$frm_jumlah_dana = $row["jumlah_dana"];
						}

}

}

?>
<html>
<head>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
</head>
<script language="JavaScript" src="../include/tanggalan.js">
</script>
<body class="body">
<form name="profil_kerjasama" id="profil_kerjasama" action="pen_profil_kerjasama_entry.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><img src="spacer" height="1"></td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4"> <hr size="1" color="#FF9900">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="89%"><font color="#0099CC" size="1"><strong>ENTRY DATA ~ </strong>PROFIL 
              KERJASAMA</font></td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">PENELITIAN</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="11%">&nbsp;</td> 
      <td width="15%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="72%">&nbsp; <input type="hidden" name="frm_id" id="frm_id" value="<?php echo $frm_id;?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Kode Profil</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_kode" type="text" id="frm_kode" size="10" maxlength="10" value="<?php echo $frm_kode; ?>" onBlur="document.profil_kerjasama.submit()" class="tekboxku"> <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nama Institusi</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nama_institusi" id="frm_nama_institusi" type="text" value="<?php echo $frm_nama_institusi; ?>" size="50" maxlength="75" class="tekboxku">
      <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Jurusan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku">
          <option value="all">Semua 
          <?php
				 //f_connecting();
				 //mysql_select_db($DB);
				 $result3 = @mysql_query("SELECT * FROM `jurusan` WHERE `jurusan`.id>0 AND `jurusan`.id<6");
				 $c=0;
				 while(($row3 = mysql_fetch_object($result3)))
				 {
				 	$c=$c+1;
				    //echo "<option value=".$row3["id"].">".$row3["nama"];
					?>
          <option  value="<?php echo $row3->id; ?>" <?php if (($frm_s_jurusan==$row3->id) or (($frm_s_jurusan=='') and ($c==1))) { echo "selected"; }?> ><?php echo $row3->jurusan; ?></option>
          <?
				 }
			?>
        </select>
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Jenis Kerjasama</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_id_jenis" id="frm_id_jenis" class="tekboxku">
          <?php

	$result1 = @mysql_query("Select id, nama from jenis_kerjasama");
	$c=0;
	while ($row1=@mysql_fetch_object($result1))  {
	$c=$c+1;
	?>
          <option  onBlur="document.profil_kerjasama.submit()" value="<?php echo $row1->id; ?>" <?php if (($frm_id_jenis==$row1->id) or (($frm_id_jenis=='') and ($c==1))) { echo "selected"; }?> ><?php echo $row1->nama; ?></option>
          <?php
	}
	
	?>
        </select> <font color="#FF0000">*</font> </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tipe Kerjasama</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_id_tipe" id="frm_id_tipe" class="tekboxku">
          <?php

	$result1 = @mysql_query("Select id, nama from tipe_kerjasama");
	$c=0;
	while ($row1=@mysql_fetch_object($result1))  {
	$c=$c+1;
	?>
          <option  onBlur="document.profil_kerjasama.submit()" value="<?php echo $row1->id; ?>" <?php if (($frm_id_tipe==$row1->id) or (($frm_id_tipe=='') and ($c==1))) { echo "selected"; }?> ><?php echo $row1->nama; ?></option>
          <?php
	}
	
	?>
        </select>
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td> 
      <td valign="top">Judul</td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><textarea name="frm_judul" id="frm_judul" cols="50" class="tekboxku"><?php echo $frm_judul; ?></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal Mulai</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_mulai" type="text" class="tekboxku" id="frm_tgl_mulai" value="<?php echo $frm_tgl_mulai; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('profil_kerjasama.frm_tgl_mulai',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)  <font color="#FF0000">*</font> </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal Selesai</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_selesai" type="text" class="tekboxku" id="frm_tgl_selesai" value="<?php echo $frm_tgl_selesai; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('profil_kerjasama.frm_tgl_selesai',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)  <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td nowrap>Jumlah Anggota Tim</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input type="text" name="frm_jumlah_staff" id="frm_jumlah_staff" value="<?php echo $frm_jumlah_staff; ?>" class="tekboxku"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Sumber Dana</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_id_sumber_dana" id="frm_id_sumber_dana" class="tekboxku">
          <?php

	$result1 = @mysql_query("Select id, nama from sumber_dana");
	$c=0;
	while ($row1=@mysql_fetch_object($result1))  {
	$c=$c+1;
	?>
          <option  value="<?php echo $row1->id; ?>" <?php if (($frm_id_sumber_dana==$row1->id) or (($frm_id_sumber_dana=='') and ($c==1))) { echo "selected"; }?> ><?php echo $row1->nama; ?></option>
          <?php
	}
	
	?>
        </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nominal Dana</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input type="text" name="frm_jumlah_dana" id="frm_jumlah_dana" value="<?php echo $frm_jumlah_dana; ?>" class="tekboxku"></td>
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
      <td><input type="submit" name="Submit" id="Submit" value="Simpan" onClick="this.form.action+='?act=1';this.form.submit();" class="tombol">
        <input type="reset" name="Submit2" id="Submit2" value="Batal" onClick="this.form.action+='?act=3';this.form.submit();" class="tombol">
        <?php if ($frm_id) { ?>
        <input type="button" name="Submit3" id="Submit3" value="Hapus"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_id;?>';this.form.submit()};" class="tombol">
        <?php } ?></td>
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
