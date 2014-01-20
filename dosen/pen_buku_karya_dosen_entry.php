<?
/* 
   DATE CREATED : 09/08/07
    
   KEGUNAAN     : ENTRY BUKU KARYA DOSEN
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
	if ($frm_tanggal_terbit!='') 
		{
			if (datetomysql($frm_tanggal_terbit)) 
				{
					$frm_tanggal_terbit = datetomysql($frm_tanggal_terbit);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal terbit tidak valid";
				}
		}

// Kode dan nama harus diisi

	if (($frm_kode=='') or ($frm_judul=='') or ($frm_tanggal_terbit=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi data buku karya dosen dengan lengkap. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_id=='') 
				{
					echo "<br>ID kary".$frm_id_karyawan;
					echo "<br>JUDUL ".$frm_judul;
					echo "<br>ID kode terbit".$frm_kode_penerbit;
					echo "<br>ID ISBN".$frm_isbn;
					echo "<br>ID tgl".$frm_tanggal_terbit;
	exit();

					$result = mysql_query("INSERT INTO buku_karya_dosen(`id_karyawan` , `judul_buku` , `tanggal_terbit` , `kode_penerbit` , `isbn` ) VALUES ( '".$frm_id_karyawan."', '".$frm_judul."', '".$frm_tanggal_terbit."', '".$frm_kode_penerbit."', '".$frm_isbn."') " );

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

$result = mysql_query("UPDATE buku_karya_dosen set `id_karyawan`='$frm_id_karyawan' , `judul_buku`='$frm_judul' , `tanggal_terbit`='$frm_tanggal_terbit' , `kode_penerbit`='$frm_kode_penerbit' , `isbn`='$frm_isbn' where `id`='$frm_id'");

	
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

$result = mysql_query("delete from buku_karya_dosen where id = ".$frm_id);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
	
if (($act!=0)and($error!=1)) {
	$frm_id = "";
	$frm_kode = "";
	$frm_id_karyawan = "";
	$frm_nama = "";
	$frm_judul = "";
	$frm_tanggal_terbit = "";
	$frm_kode_penerbit = 1;
	$frm_isbn = "";
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_kode!='')  {
$result_DOSEN = mysql_query("Select id, kode, nama from master_karyawan where kode='$frm_kode'");
$row_dosen = mysql_fetch_array($result_DOSEN);
$frm_nama_dosen=$row_dosen['nama'];


/*$sql="select buku_karya_dosen.*,
			 DATE_FORMAT(buku_karya_dosen.tanggal_terbit,\"%d/%m/%Y\") as terbit,
             master_karyawan.id as id_karyawan,
			 master_karyawan.kode as kode_karyawan,
			 master_karyawan.nama as nama_karyawan
	   from buku_karya_dosen, master_karyawan
	   where buku_karya_dosen.id_karyawan=master_karyawan.id and ";*/
	   
$sql="select buku_karya_dosen.*,
             DATE_FORMAT(buku_karya_dosen.tanggal_terbit,\"%d/%m/%Y\") as terbit,
             master_karyawan.id as id_karyawan,
	         master_karyawan.kode as kode_karyawan,
	         master_karyawan.nama as nama_karyawan
	  from master_karyawan 
	  left join  buku_karya_dosen
			on master_karyawan.id=buku_karya_dosen.id_karyawan
			where ";


if ($frm_id!='')
{
   $sql .= " buku_karya_dosen.id='$frm_id'";
}
else
{
   $sql .= " master_karyawan.kode='$frm_kode'";

}	   
    $result=mysql_query($sql);
    $row = mysql_fetch_array($result);
	$frm_id_karyawan = $row["id_karyawan"];
	$frm_nama = $row["nama_karyawan"];
	$frm_judul=$row["judul_buku"];
	$frm_kode_penerbit=$row["kode_penerbit"];
	$frm_isbn=$row["isbn"];
	$frm_tanggal_terbit=$row["terbit"];
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
<form name="buku_dosen" id="buku_dosen" action="pen_buku_karya_dosen_entry.php" method="post">
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
            <td width="89%"><font color="#0099CC" size="1"><strong>ENTRY DATA ~ </strong>BUKU 
              KARYA DOSEN</font> </td>
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
      <td width="83%">&nbsp; <input type="hidden" name="frm_id" id="frm_id" value="<?php echo $frm_id;?>">
        <input type="hidden" name="frm_id_karyawan" id="frm_id_karyawan" value="<?php echo $frm_id_karyawan;?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Kode Karyawan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_kode" type="text" id="frm_kode" size="10" maxlength="10" value="<?php echo $frm_kode; ?>" onBlur="document.buku_dosen.submit()" class="tekboxku" >
	    <font color="#FF0000">*
	    <? if (isset($frm_kode)) echo $frm_nama_dosen;?>
		</font>
        </td>
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
      <td>Penerbit</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_kode_penerbit" id="frm_kode_penerbit" class="tekboxku">
			<?php
				$result1 = @mysql_query("Select id, penerbit from penerbit order by penerbit");
				$c=0;
				while ($row1=@mysql_fetch_object($result1))  {
				$c=$c+1;
				?>
			  <option  onBlur="document.buku_dosen.submit()" value="<?php echo $row1->id; ?>" <?php if (($frm_kode_penerbit==$row1->id) or (($frm_kode_penerbit=='') and ($c==1))) { echo "selected"; }?> ><?php echo $row1->penerbit; ?></option>
			  <?php
				}?>
        </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>ISBN</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input type="text" name="frm_isbn" id="frm_isbn" value="<?php echo $frm_isbn; ?>" class="tekboxku"></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>Tanggal Penerbitan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tanggal_terbit" type="text" class="tekboxku" id="frm_tanggal_terbit" value="<?php echo $frm_tanggal_terbit; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('buku_dosen.frm_tanggal_terbit',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)  <font color="#FF0000">*</font></td>
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
      <td><input type="submit" name="Submit" value="Simpan" onClick="this.form.action+='?act=1';this.form.submit();" class="tombol">
        <input type="reset" name="Submit2" value="Batal" onClick="this.form.action+='?act=3';this.form.submit();" class="tombol">
        <?php if ($frm_id) { ?>
        <input type="button" name="Submit3" value="Hapus"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_id;?>';this.form.submit()};" class="tombol">
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
