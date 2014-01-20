<?
/* 
   DATE CREATED : 09/08/07
   KEGUNAAN     : ENTRY TULISAN ILMIAH DOSEN
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ 
// simpan data
// cek apakah ISBN sudah pernah ada
	if ($frm_ISBN <>'')  {
		$result = mysql_query("Select id, judul from tulisan_ilmiah where ISBN='$frm_ISBN'");
		$row = mysql_fetch_array($result);
		if ($row)
		{
			$error=1;
			$pesan=$pesan."<br>Maaf, Data yang Anda masukkan sudah ada. Gagal menyimpan data.";
		}
	}
	

	// cek tanggal, apakah tanggal yang dimasukkan valid
	if ($frm_tgl_terbit!='') 
		{
			if (datetomysql($frm_tgl_terbit)) 
				{
					$frm_tgl_terbit = datetomysql($frm_tgl_terbit);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal tidak valid";
				}
		}

// Kode dan nama harus diisi

	if (($frm_ISBN=='')or ($frm_id_karyawan=='') or ($frm_judul=='') or ($frm_nama_media=='') or ($frm_tgl_terbit=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi Data Tulisan Ilmiah dengan lengkap. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_ISBN=='') 
				{   $sql_tulis="INSERT INTO 
								    tulisan_ilmiah ( `id` , 
													 `id_karyawan` , 
													 `judul` , 
													 `nama_media` ,
													 `ISBN`,
													 `id_status_media`,
													 `tanggal` , 
													 `volume` ) 
								 VALUES ( '', 
								          '".$frm_id_karyawan."',
										  '".$frm_judul."', 
										  '".$frm_nama_media."',
										  '".$frm_ISBN."',
										  ".$frm_id_status_media.",
										  '".$frm_tgl_terbit."', 
										  '".$frm_volume."')";
										 // echo $sql_tulis;
					$result = mysql_query($sql_tulis);

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

//update
					if ($frm_ISBN <> "")
					{
					$result = mysql_query("UPDATE tulisan_ilmiah 
										   set `id_karyawan`='$frm_id_karyawan' , 
											   `judul`='$frm_judul' , 
											   `nama_media`='$frm_nama_media' , 
											   `ISBN`='$frm_ISBN',
											   `id_status_media`='$frm_id_status_media' ,
											   `tanggal`='$frm_tgl_terbit' , 
											   `volume`='$frm_volume'  
										   where `ISBN`='$frm_ISBN'");
					
										
					}
					else
					{
						$result = mysql_query("UPDATE tulisan_ilmiah 
											   set `id_karyawan`='$frm_id_karyawan' , 
												   `judul`='$frm_judul' , 
												   `nama_media`='$frm_nama_media' , 
												   `id_status_media`='$frm_id_status_media' ,
												   `tanggal`='$frm_tgl_terbit' , 
												   `volume`='$frm_volume'  
											   where `ISBN`='$frm_ISBN'");
					}
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
	$result = mysql_query("delete from tulisan_ilmiah where ISBN = ".$frm_ISBN);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_id="";
	$frm_kode="";
	$frm_id_karyawan="";
	$frm_judul="";
	$frm_nama_media="";
	$frm_ISBN="";
	$frm_id_status_media="1";
	$frm_tgl_terbit="";
	$frm_volume="";
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_id_karyawan!='')  {
	/*$sqlAmbil="select tulisan_ilmiah.*, 
					  master_karyawan.kode as kode, 
					  master_karyawan.nip as nip, 
					  master_karyawan.nama as nama, 
					  status_media.nama as status 
				from tulisan_ilmiah, master_karyawan, status_media 
				where tulisan_ilmiah.id_karyawan=master_karyawan.id and
					  tulisan_ilmiah.id_status_media=status_media.id and 
					  tulisan_ilmiah.id=$frm_id";			*/
	$sqlAmbil="select tulisan_ilmiah.id,
					  tulisan_ilmiah.id_karyawan,
					  tulisan_ilmiah.judul,
					  tulisan_ilmiah.nama_media,
					  tulisan_ilmiah.ISBN,
					  tulisan_ilmiah.id_status_media,
					  DATE_FORMAT(tulisan_ilmiah.tanggal,'%d/%m/%Y') as tanggal,
					  tulisan_ilmiah.volume,
					  tulisan_ilmiah.up_date,
					  master_karyawan.kode as kode_kar, 
					  master_karyawan.nip as nip_kar, 
					  master_karyawan.nama as nama_kar, 
					  status_media.nama as status_med
				from tulisan_ilmiah, master_karyawan, status_media 
				where tulisan_ilmiah.id_karyawan=master_karyawan.id and
					  tulisan_ilmiah.id_status_media=status_media.id and 
					  tulisan_ilmiah.ISBN='$frm_ISBN'";
					 // tulisan_ilmiah.ISBN=$frm_ISBN";	
					 
	
	$result = mysql_query($sqlAmbil);
	$row = mysql_fetch_array($result);
	
	//$frm_id=$row["id"];
	$frm_id_karyawan=$row["id_karyawan"];
	$frm_kode=$row["kode_kar"]; 
	$frm_nama=$row["nama_kar"];
	$frm_judul=$row["judul"];
	$frm_nama_media=$row["nama_media"];
	$frm_ISBN=$row["ISBN"];
	$frm_volume=$row["volume"];
	$frm_id_status_media=$row["id_status_media"];
	
	$frm_tgl_terbit =$row["tanggal"];
	if ($row["tanggal"]=="00/00/0000") {
	$frm_tgl_terbit =""; }else {
	$frm_tgl_terbit =$row["tanggal"];}
	
	/*$frm_tgl_terbit=datetoreport($row["tanggal"]);
		 if ($frm_tgl_terbit=="00/00/0000") 
		 {	$frm_tgl_terbit ="00/00/0000"; }*/
 }

	if ($frm_kode!='')  {
		$result = mysql_query("Select id, kode, nama from master_karyawan where kode='$frm_kode'");
		$row = mysql_fetch_array($result);
		$frm_id_karyawan = $row["id"];
		$frm_nama = $row["nama"];
	}

	if ($frm_id_media!='')  {
		$result = mysql_query("Select id, nama from status_media where id='$frm_id_media'");
		$row = mysql_fetch_array($result);
		$frm_status_media = $row["nama"];
	}

}
echo "<br>frm_id_karyawan=".$frm_id_karyawan;
echo "<br>frm_kode=".$frm_kode; 
echo "<br>frm_nama=".$frm_nama;
echo "<br>frm_judul=".$frm_judul;
echo "<br>frm_nama_media=".$frm_nama_media;
echo "<br>frm_ISBN=".$frm_ISBN;
echo "<br>frm_volume=".$frm_volume;
echo "<br>frm_id_status_media=".$frm_id_status_media;
echo "<br>frm_tgl_terbit=".$frm_tgl_terbit;
?>
<html>
<head>
<script language="JavaScript" src="../include/tanggalan.js">
</script>
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
	<!--
	function popitup(url)
	{
			newwindow=window.open(url,'name','top=0,left=510,height=400,width=500,scrollbars=yes');
			if (window.focus) {newwindow.focus()}
			return false;
	}
	// -->
</SCRIPT> 
<link href="../css/style2.css" rel="stylesheet" type="text/css">
</head>
<body class="body">
<form name="tulisan_ilmiah" id="tulisan_ilmiah" action="pen_tulisan_ilmiah_entry.php" method="post">
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
            <td width="89%"><font color="#0099CC" size="1"><strong>ENTRY DATA ~ </strong>TULISAN 
              ILMIAH DOSEN</font> </td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">PENELITIAN</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"></td>
    </tr>
    <tr>
      <td width="9%">&nbsp;</td> 
      <td width="11%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="79%">&nbsp;</td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>ISBN</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="frm_ISBN" id="frm_ISBN" value="<? echo $frm_ISBN; ?>" onBlur="document.tulisan_ilmiah.submit()"  size="20" maxlength="20" class="tekboxku">
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>NPK Dosen</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_id_karyawan" id="frm_id_karyawan" class="tekboxku">
          <option <?php if ($frm_id_karyawan==''){echo "selected";}?>>-- Kode 
          Dosen --</option>
          <?php
			$result1 = @mysql_query("SELECT kode, nama FROM dosen ORDER BY kode");
		
			$c=0;
			while ($row1=@mysql_fetch_object($result1))  {
			$c=$c+1;
			?>
				  <option value="<?php echo $row1->id; ?>" <?php if ($frm_id_karyawan==$row1->id) { echo "selected"; }?> ><?php echo $row1->kode; ?> 
				  - <?php echo $row1->nama; ?></option>
				  <?php
			}
			?>
        </select> 
		<font color="#FF0000">*</font>
		<input type="hidden" name="frm_id" id="frm_id" value="<? echo $frm_id; ?>">
        <!--a href="#" onClick="return popitup('pen_tulisan_ilmiah_cari_dsn.php')">C a r i</a></td-->
    </tr>
    <tr>
      <td valign="top">&nbsp;</td> 
      <td valign="top">Judul</td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><textarea name="frm_judul" id="frm_judul" cols="60" class="tekboxku"><?php echo $frm_judul; ?></textarea>
      <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td> 
      <td valign="top">Nama Media</td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td valign="top"><textarea name="frm_nama_media" id="frm_nama_media" cols="60" class="tekboxku"><? echo $frm_nama_media; ?></textarea> 
      </td>
    </tr>
    <!-- status media -->
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>Status Media</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_id_status_media" id="frm_id_status_media" class="tekboxku">
          <?php
	$result1 = @mysql_query("Select id, nama from status_media");
	$c=0;
	while ($row1=@mysql_fetch_object($result1))  {
	$c=$c+1;
	?>
          <option value="<?php echo $row1->id; ?>" <?php if (($frm_id_status_media==$row1->id) or (($frm_id_status_media=='') and ($c==1))) { echo "selected"; }?> ><?php echo $row1->nama; ?></option>
          <?php
	}
	?>
        </select></td>
    </tr>
    <!-- status media -->
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_terbit" type="text" class="tekboxku" id="frm_tgl_terbit" value="<?php echo $frm_tgl_terbit; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('tulisan_ilmiah.frm_tgl_terbit',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)  <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Volume</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input type="text" name="frm_volume" id="frm_volume" value="<?php echo $frm_volume; ?>" class="tekboxku"></td>
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
        <?php if ($frm_ISBN) { ?>
        <input type="button" name="Submit3" value="Hapus"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_ISBN;?>';this.form.submit()};" class="tombol">
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