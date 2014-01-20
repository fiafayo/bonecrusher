<?
/* 
   DATE CREATED : 09/08/07
    
   KEGUNAAN     : ENTRY PENELITIAN DOSEN
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
					$pesan = $pesan."<br> Tanggal Selesai tidak valid";
				}
		}

// Kode dan nama harus diisi

	if (($frm_kode=='') or ($frm_nama=='') or ($frm_judul=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi Kode, Nama Dosen/Karyawan dan Judul. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_id=='') 
				{
					$result = mysql_query("INSERT INTO penelitian ( `id` , `id_karyawan` , `judul` , `tanggal_mulai` , `tanggal_selesai` , `jumlah_peneliti`, `id_sumber_dana`, `dana` , `kode_buku` ) VALUES ( '', '".$frm_id_karyawan."', '".$frm_judul."', '".$frm_tgl_mulai."', '".$frm_tgl_selesai."', '".$frm_jumlah_peneliti."', '".$frm_id_sumber_dana."', '".$frm_dana."', '".$frm_kode_buku."') " );

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

					$result = mysql_query("UPDATE penelitian set `id_karyawan` ='$frm_id_karyawan', `judul` ='$frm_judul', `tanggal_mulai`='$frm_tgl_mulai' , `tanggal_selesai`='$frm_tgl_selesai' , `jumlah_peneliti`='$frm_jumlah_peneliti', `id_sumber_dana`='$frm_id_sumber_dana', `dana`='$frm_dana' , `kode_buku`= '$frm_kode_buku' where `id`='$frm_id'");
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

$result = mysql_query("delete from penelitian where id = ".$frm_id);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
	
if (($act!=0)and($error!=1)) {
$frm_id="";
$frm_id_karyawan="";
$frm_judul="";
$frm_tgl_mulai="";
$frm_tgl_selesai="";
$frm_jumlah_peneliti="";
$frm_id_sumber_dana="1";
$frm_dana="";
$frm_kode_buku="";
	
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_kode!='')  {
$sql= "select id,nama from master_karyawan where kode='$frm_kode'";
$hasil=@mysql_query($sql);
$baris=@mysql_fetch_array($hasil);
$frm_nama=$baris["nama"];
$frm_id_karyawan = $baris["id"];
$sql = "select penelitian.*, 
			   DATE_FORMAT(penelitian.tanggal_mulai,\"%d/%m/%Y\") as mulai,
			   DATE_FORMAT(penelitian.tanggal_selesai,\"%d/%m/%Y\") as selesai,
               master_karyawan.id as id_karyawan,
			   master_karyawan.kode as kode_karyawan,
			   master_karyawan.nama as nama_karyawan
		from penelitian, master_karyawan
		where penelitian.id_karyawan=master_karyawan.id and ";
if ($frm_id !='')
{
   $sql .= " penelitian.id='$frm_id'";
}		
else
{
   $sql .= " master_karyawan.kode='$frm_kode'";
}
//$result = mysql_query("Select id, kode, nama from master_karyawan where kode='$frm_kode'");
$result=mysql_query($sql);
$row = mysql_fetch_array($result);
    $frm_id=$row["id"];
//	$frm_id_karyawan = $row["id_karyawan"];
//	$frm_nama = $row["nama_karyawan"];
$frm_jurusan=$row["judul"];// ??????????
$frm_judul=$row["judul"];
$frm_tgl_mulai=$row["mulai"];
$frm_tgl_selesai=$row["selesai"];
$frm_jumlah_peneliti=$row["jumlah_peneliti"];
$frm_id_sumber_dana=$row["id_sumber_dana"];
$frm_dana=$row["dana"];
$frm_kode_buku=$row["kode_buku"];
	
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
<form name="penelitian" id="penelitian" action="pen_dosen_entry.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><img src="spacer" height="1"></td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4">
	  <hr size="1" color="#FF9900">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="89%"><font color="#0099CC" size="1"><strong>ENTRY DATA ~ </strong>PENELITIAN 
              DOSEN</font></td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">PENELITIAN</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900">
	  </td>
    </tr>
    <tr>
      <td width="15%">&nbsp;</td> 
      <td width="15%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="83%">&nbsp; <input type="hidden" name="frm_id_karyawan" id="frm_id_karyawan" value="<?php echo $frm_id_karyawan;?>"> 
        <input type="hidden" name="frm_id" id="frm_id" value="<?php echo $frm_id;?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Kode Karyawan </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_kode" type="text" id="frm_kode" size="10" maxlength="10" value="<?php echo $frm_kode; ?>" onBlur="document.penelitian.submit()" class="tekboxku"> <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nama Karyawan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nama" type="text" id="frm_nama" value="<?php echo $frm_nama; ?>" size="50" maxlength="50" class="tekboxku">
      <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td> 
      <td valign="top">Judul</td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><textarea name="frm_judul" id="frm_judul" cols="50" class="tekboxku"><?php echo $frm_judul; ?></textarea>
      <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal Mulai</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_mulai" type="text" class="tekboxku" id="frm_tgl_mulai" value="<?php echo $frm_tgl_mulai; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('penelitian.frm_tgl_mulai',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)  <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal Selesai</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_selesai" type="text" class="tekboxku" id="frm_tgl_selesai" value="<?php echo $frm_tgl_selesai; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('penelitian.frm_tgl_selesai',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)  <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Jumlah Peneliti</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input type="text" name="frm_jumlah_peneliti" id="frm_jumlah_peneliti" value="<?php echo $frm_jumlah_peneliti; ?>" class="tekboxku"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Sumber Dana</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_id_sumber_dana" id="frm_id_sumber_dana" class="tekboxku">
          <?php

	$result1 = @mysql_query("Select id, nama from sumber_dana order by nama asc");
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
      <td><input type="text" name="frm_dana" id="frm_dana" value="<?php echo $frm_dana; ?>" class="tekboxku"></td>
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
