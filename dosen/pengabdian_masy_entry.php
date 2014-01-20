<?
/* 
   HISTORY      : 02/08/03 - BELUM SELESAI
       
   DATE CREATED : 02/08/03
   UPDATE  		: 26/03/08 - RAHADI
   	  		  
   PROBLEM 		: 07/10/05 - penambahan filter jurusan
   KEGUNAAN     : ENTRY PENGABDIAN MASYARAKAT
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

	if (($frm_kode=='') or ($frm_nama_institusi=='') or ($frm_judul=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi Kode, Nama Institusi dan Judul. ";
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
					$result = mysql_query("INSERT INTO profil_kerjasama ( `id`, `kode`, `jurusan`, `nama_institusi`, `id_jenis`, `id_tipe`, `judul`, `mulai`, `selesai`, `jumlah_staff`, `id_sumber_dana`, `jumlah_dana` ) VALUES ( '', '".$frm_kode."', '".$frm_s_jurusan."', '".$frm_nama_institusi."', '".$frm_id_jenis."', '".$frm_id_tipe."', '".$frm_judul."', '".$frm_mulai."', '".$frm_selesai."', '".$frm_jumlah_staff."', '".$frm_id_sumber_dana."', '".$frm_jumlah_dana."') " );

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

$result = mysql_query("UPDATE profil_kerjasama set `kode` ='$frm_kode', `jurusan` ='$frm_s_jurusan', `nama_institusi` ='$frm_nama_institusi', `id_jenis` ='$frm_id_jenis', `id_tipe`='$frm_id_tipe' , `judul`='$frm_judul' , `mulai`='$frm_mulai', `selesai`='$frm_selesai', `jumlah_staff`='$frm_jumlah_staff' , `id_sumber_dana`= '$frm_id_sumber_dana', `jumlah_dana`= '$frm_jumlah_dana' where `id`='$frm_id'");

	
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
	$frm_s_jurusan="";
	$frm_nama_institusi="";
	$frm_id_jenis="";
	$frm_id_tipe="";
	$frm_judul="";
	$frm_mulai="";
	$frm_selesai="";
	$frm_jumlah_staff="";
	$frm_id_sumber_dana="";
	$frm_dana="";

}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_kode!='')  {
$result = mysql_query("SELECT id, 
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
					     FROM profil_kerjasama 
					    WHERE kode='$frm_kode'");

if ($row = mysql_fetch_array($result)) {
	$frm_id = $row["id"];
	$frm_kode = $row["kode"];
	$frm_s_jurusan = $row["jurusan"];
	$frm_nama_institusi = $row["nama_institusi"];
	$frm_id_jenis = $row["id_jenis"];
	$frm_id_tipe = $row["id_tipe"];
	$frm_judul = $row["judul"];
	$frm_mulai = $row["mulai"];
	$frm_selesai = $row["selesai"];
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
<script language="JavaScript" src="../include/tanggalan.js">
</script>
</head>
<body class="body">
<form name="form_abdi" id="form_abdi" action="pengabdian_masy_entry.php" method="post">
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
				PROFIL KERJASAMA</font>
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
      <td width="79%">&nbsp; <input type="hidden" name="frm_id" value="<?php echo $frm_id;?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Jurusan</td>
      <td><strong>:</strong></td>
      <td><? echo "<br>frm_s_jurusan=".$frm_s_jurusan; ?>
	  <select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku" onChange="document.form_abdi.submit()">
        <option value="" <?php if ($frm_s_jurusan==''){echo "selected";}?>>--- Pilih ---</option>
        <?php
				 //f_connecting();
				 //mysql_select_db($DB);
				 $result3 = @mysql_query("SELECT * FROM jurusan WHERE id>0 ORDER BY id ASC");
				 $c=0;
				 while(($row3 = mysql_fetch_object($result3)))
				 {
				 	$c=$c+1;
				    //echo "<option value=".$row3["id"].">".$row3["nama"];
					?>
        <option  value="<?php echo $row3->id; ?>" <?php if ($frm_s_jurusan==$row3->id) { echo "selected"; }?> ><?php echo $row3->jurusan; ?></option>
        <?
				 }
			?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Kode Profil terakhir </td>
      <td><strong>:</strong></td>
      <td>
	  <?
	  	$sql="SELECT kode 
				FROM profil_kerjasama 
			   WHERE kode <>'' ";
				 
		if (($frm_s_jurusan!="") or ($frm_s_jurusan!=NULL))
		{ $sql=$sql." and jurusan =".$frm_s_jurusan; }
		
		$sql=$sql." ORDER BY kode DESC LIMIT 1";
		
		$result_kode_terakhir = mysql_query($sql);
		$row_kode_terakhir = mysql_fetch_array($result_kode_terakhir);
		$frm_kode_last = $row_kode_terakhir["kode"];
	  ?>
	  <input name="frm_kode_last" type="text" class="tekboxku" id="frm_kode_last" onBlur="document.form_abdi.submit()" value="<?php echo $frm_kode_last; ?>" size="10" maxlength="10">
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Kode Profil <font color="#FF0000">*</font></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_kode" type="text" class="tekboxku" id="frm_kode" onBlur="document.form_abdi.submit()" value="<?php echo $frm_kode; ?>" size="10" maxlength="10" ></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nama Institusi <font color="#FF0000">*</font></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nama_institusi" type="text" class="tekboxku" id="frm_nama" value="<?php echo $frm_nama_institusi; ?>" size="50" maxlength="75"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Jenis Kerjasama</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_id_jenis" class="tekboxku">
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
      <td>&nbsp;</td> 
      <td>Tipe Kerjasama</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_id_tipe" class="tekboxku">
          <?php

	$result1 = @mysql_query("Select id, nama from tipe_kerjasama");
	$c=0;
	while ($row1=@mysql_fetch_object($result1))  {
	$c=$c+1;
	?>
          <option  onBlur="document.form_abdi.submit()" value="<?php echo $row1->id; ?>" <?php if (($frm_id_tipe==$row1->id) or (($frm_id_tipe=='') and ($c==1))) { echo "selected"; }?> ><?php echo $row1->nama; ?></option>
          <?php
	}
	
	?>
        </select></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td> 
      <td valign="top">Judul <font color="#FF0000">*</font></td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><textarea name="frm_judul" cols="50" class="tekboxku"><?php echo $frm_judul; ?></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal Mulai</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_mulai" type="text" class="tekboxku" id="frm_mulai" value="<?php echo $frm_mulai; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('form_abdi.frm_mulai',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="bottom" border=0> 
        </A>(dd/mm/yyyy) </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal Selesai</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_selesai" type="text" class="tekboxku" id="frm_selesai" value="<?php echo $frm_selesai; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('form_abdi.frm_selesai',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="bottom" border=0> 
        </A>(dd/mm/yyyy) </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td nowrap>Jumlah Anggota Tim</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_jumlah_staff" type="text" class="tekboxku" value="<?php echo $frm_jumlah_staff; ?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Sumber Dana</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_id_sumber_dana" class="tekboxku">
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
      <td><input name="frm_jumlah_dana" type="text" class="tekboxku" value="<?php echo $frm_jumlah_dana; ?>"></td>
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
        <?php if ($frm_id) { ?>
        <input name="Submit3" type="button" class="tombol"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_id;?>';this.form.submit()};" value="Hapus">
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
