<?php
/* 
   DATE CREATED : 29/06/07
   KEGUNAAN     : entry data daftar penguji
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ // simpan data

	// Pemeriksaan tanggal, apakah tanggal yang dimasukkan valid
	if ($frm_tgl_ujian!='') 
		{
			if (datetomysql($frm_tgl_ujian)) 
				{
					$frm_tgl_ujian = datetomysql($frm_tgl_ujian);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal Ujian tidak valid";
				}
		}


// Kode dan nama harus diisi
	if (($frm_nrp=='') or ($frm_no_sk_pertama=='') or ($frm_no_sk_akhir=='') or ($frm_kode_ketua=='') or ($frm_kode_sekre=='') or ($frm_kode_dosen_1=='') or ($frm_kode_dosen_2=='') or ($frm_kode_dosen_3=='') or ($frm_tgl_ujian=='') or ($frm_ruang_ujian=='') ) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data daftar penguji dengan lengkap. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_exist!=1) 
				{
					$result = mysql_query("INSERT INTO daftar_uji ( `nrp` ,`no_sk_awal`, `no_sk_akhir`, `kode_ketua`, `kode_sekre` , `kode_dosen1` , `kode_dosen2` , `kode_dosen3` , `tgl_ujian` , `ruang_ujian` ) VALUES ( '".$frm_nrp."', '".$frm_no_sk_pertama."', '".$frm_no_sk_akhir."', '".$frm_kode_ketua."', '".$frm_kode_sekre."', '".$frm_kode_dosen_1."', '".$frm_kode_dosen_2."', '".$frm_kode_dosen_3."', '".$frm_tgl_ujian."', '".$frm_ruang_ujian."') " );
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
					$result = mysql_query("UPDATE daftar_uji set `no_sk_awal`='$frm_no_sk_pertama', `no_sk_akhir` ='$frm_no_sk_akhir', `kode_ketua` ='$frm_kode_ketua', `kode_sekre` ='$frm_kode_sekre', `kode_dosen1` ='$frm_kode_dosen_1', `kode_dosen2` ='$frm_kode_dosen_2', `kode_dosen3`='$frm_kode_dosen_3', `tgl_ujian`='$frm_tgl_ujian', `ruang_ujian`='$frm_ruang_ujian'  where `nrp`=$frm_nrp");
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

$result = mysql_query("delete from daftar_uji where nrp = ".$frm_nrp);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	$frm_nrp= "";
	$frm_no_sk_pertama = "";
	$frm_no_sk_akhir = "";
	$frm_nama = "";
	$frm_kode_ketua = "";
	$frm_kode_sekre = "";
	$frm_kode_dosen_1 = "";
	$frm_kode_dosen_2 = "";
	$frm_kode_dosen_3 = "";
	$frm_tgl_ujian = "";
	$frm_ruang_ujian = "";
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_nrp!='')  {
$result = mysql_query("SELECT	`master_mhs`.`NRP`,
								`master_mhs`.`SKSMAX`,
								`master_mhs`.`IPS`,
								`master_mhs`.`STATUS`,
								`master_mhs`.`JURUSAN`,
								`master_mhs`.`WALI`,
								`master_mhs`.`NAMA`,
								`master_mhs`.`ALAMAT`,
								`master_mhs`.`NIRM`,
								`master_mhs`.`TGLLAHIR`,
								`master_mhs`.`TMPLAHIR`,
								`master_mhs`.`TOTBSS`,
								`master_mhs`.`IPK`,
								`master_mhs`.`SKSKUM`,
								`master_mhs`.`TELEPON`,
								`master_mhs`.`VALIDID`,
								`master_mhs`.`PASSWORD`,
								`master_mhs`.`ANGKATAN`,
								`master_mhs`.`NAMASMA`,
								`master_mhs`.`NAMAORTU`,
								`master_mhs`.`NRPKOP`,
								`master_mhs`.`KELAMIN`,
								`daftar_uji`.`no_sk_awal`,
								`daftar_uji`.`no_sk_akhir`,
								`daftar_uji`.`kode_ketua`,
								`daftar_uji`.`kode_sekre`,
								`daftar_uji`.`kode_dosen1`,
								`daftar_uji`.`kode_dosen2`,
								`daftar_uji`.`kode_dosen3`,
								 DATE_FORMAT(`daftar_uji`.`tgl_ujian`,'%d/%m/%Y') as tgl_ujian,
								`daftar_uji`.`ruang_ujian`
							FROM
								`master_mhs` LEFT JOIN `daftar_uji` ON `master_mhs`.`NRP` = `daftar_uji`.`NRP`
							WHERE
								`master_mhs`.`NRP` =  '".$frm_nrp."'");

							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_nama = $row["NAMA"];
								$frm_no_sk_pertama = $row["no_sk_awal"];
								$frm_no_sk_akhir = $row["no_sk_akhir"];
									
									$frm_kode_ketua = $row["kode_ketua"];
									$frm_kode_sekre = $row["kode_sekre"];
									$frm_kode_dosen_1 = $row["kode_dosen1"];
									$frm_kode_dosen_2 = $row["kode_dosen2"];
									$frm_kode_dosen_3 = $row["kode_dosen3"];
								
								$frm_tgl_ujian = $row["tgl_ujian"];
								if ($row["tgl_ujian"]=="00/00/0000") {
								$frm_tgl_ujian = ""; }else {
								$frm_tgl_ujian = $row["tgl_ujian"];}
								
								$frm_ruang_ujian = $row["ruang_ujian"];
							}else
							{$frm_exist = 0; 
							//header("Location: mhs_daftar_penguji.php");
							}
	
}



			/*if ($frm_no_sk_pertama=='')
				{
					$frm_kode_ketua = "";
					$frm_kode_sekre = "";
					$frm_kode_dosen_1 = "";
					$frm_kode_dosen_2 = "";
					$frm_kode_dosen_3 = "";
				}*/
				

	if ($frm_kode_ketua!='') {
		$result = mysql_query("Select nama from master_karyawan where kode='$frm_kode_ketua'");
		$row = mysql_fetch_array($result);
		$frm_nama_ketua = $row["nama"];
	}	

	if ($frm_kode_sekre!='') {
		$result = mysql_query("Select nama from master_karyawan where kode='$frm_kode_sekre'");
		$row = mysql_fetch_array($result);
		$frm_nama_sekre = $row["nama"];
	}	

	if ($frm_kode_dosen_1!='') {
		$result = mysql_query("Select nama from master_karyawan where kode='$frm_kode_dosen_1'");
		$row = mysql_fetch_array($result);
		$frm_nama_dosen_1 = $row["nama"];
	}	
	
	if ($frm_kode_dosen_2!='') {
		$result = mysql_query("Select nama from master_karyawan where kode='$frm_kode_dosen_2'");
		$row = mysql_fetch_array($result);
		$frm_nama_dosen_2 = $row["nama"];
	}	
	
	if ($frm_kode_dosen_3!='') {
		$result = mysql_query("Select nama from master_karyawan where kode='$frm_kode_dosen_3'");
		$row = mysql_fetch_array($result);
		$frm_nama_dosen_3 = $row["nama"];
	}	
	echo "<br>frm_kode_ketua= ".$frm_kode_ketua;
	echo "<br>frm_nama_ketua= ".$_POST['frm_nama_ketua'];
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
<script>
function popitup(url)
{
	/*if (document.mhs.frm_nrp.value=="")
	{
		alert("Silahkan masukkan NRP mahasiswa Terlebih Dahulu !");
		document.mhs.frm_nrp.focus();
		return false;
	}
	else
	{*/
		newwindow=window.open(url,'name','top=0,left=510,height=400,width=500,scrollbars=yes');
		if (window.focus) {newwindow.focus()}
		return false;
	//}
}
</script>
<body class="body">
<form name="mhs" action="mhs_daftar_penguji.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><img src="spacer" height="1"></td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4"> <hr size="1" color="#FF9900"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>ENTRY 
              DATA ~</strong> PROSES DAFTAR PENGUJI</font></font> </td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="15%">&nbsp;</td> 
      <td width="15%">&nbsp;</td>
      <td width="3%">&nbsp;</td>
      <td width="83%"><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" ></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>NRP</td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="10" >
        <span class="style1">* </span><? if (isset($frm_nrp)) echo $frm_nama;?></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>No SK Pertama</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_no_sk_pertama" type="text" class="tekboxku" id="frm_no_sk_pertama" value="<?php echo $frm_no_sk_pertama; ?>" size="50" maxlength="50">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>No SK Terakhir </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_no_sk_akhir" type="text" class="tekboxku" id="frm_no_sk_akhir" value="<?php echo $frm_no_sk_akhir; ?>" size="50" maxlength="100">
        <span class="style1">*</span>        </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>Kode Ketua</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> <select name="frm_kode_ketua" id="frm_kode_ketua" class="tekboxku">
          <option <?php if ($frm_kode_ketua==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sqlDosen="select kode, nama
						   from dosen";
				
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->kode; ?>" <?php if (($frm_kode_ketua==$row->kode) or (($frm_kode_ketua=='') and ($c==1))) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
          <?php
				}
				
				?>
        </select>        
		<span class="style1">*</span>
		
   	    <a href="#" onClick="return popitup('mhs_daftar_penguji_cari1.php?nrp=<?php echo $frm_nrp;?>&no_skkp_1=<?php echo $frm_no_sk_pertama;?>&no_skkp_2=<?php echo $frm_no_sk_akhir;?>')">C a r i</a>
        </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Kode Sekretaris </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_kode_sekre" id="frm_kode_sekre" type="text" class="tekboxku" onBlur="document.mhs.submit()" value="<?php echo $frm_kode_sekre; ?>" size="10" maxlength="10">
        <span class="style1">*</span>
        <? if (isset($frm_nrp)) echo $frm_nama_sekre;?>
        </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>NPK Dosen 1 </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_kode_dosen_1" id="frm_kode_dosen_1" type="text" class="tekboxku" onBlur="document.mhs.submit()" value="<?php echo $frm_kode_dosen_1; ?>" size="10" maxlength="10">
        <span class="style1">*</span>
        <? if (isset($frm_nrp)) echo $frm_nama_dosen_1;?>
        </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>NPK Dosen 2 </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_kode_dosen_2" id="frm_kode_dosen_2"  type="text" class="tekboxku" onBlur="document.mhs.submit()" value="<?php echo $frm_kode_dosen_2; ?>" size="10" maxlength="10">
        <span class="style1">*</span>
        <? if (isset($frm_nrp)) echo $frm_nama_dosen_2;?>
        </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>NPK Dosen 3 </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_kode_dosen_3" id="frm_kode_dosen_3" type="text" class="tekboxku" onBlur="document.mhs.submit()" value="<?php echo $frm_kode_dosen_3; ?>" size="10" maxlength="10">
        <span class="style1">*</span>
        <? if (isset($frm_nrp)) echo $frm_nama_dosen_3;?>
        </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal Ujian </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_ujian" type="text" class="tekboxku" id="frm_tgl_ujian" value="<?php echo $frm_tgl_ujian; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('mhs.frm_tgl_ujian',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)  <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Ruang Ujian </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_ruang_ujian" id="frm_ruang_ujian" type="text" class="tekboxku" value="<?php echo $frm_ruang_ujian; ?>" size="10" maxlength="10">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Status Kuliah </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_semester" class="tekboxku">
	  		<? if (isset($frm_semester)) {?>
			<option value="S" <? if ($frm_semester=="S") echo "selected"?>>SELESAI</option>
			<option value="" <? if ($frm_semester=="") echo "selected"?>>BELUM</option>
			<? } else {?>
			<option value="S">SELESAI</option>
			<option value="" selected>BELUM</option>
			<? }?>
      </select></td>
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
      <td><div align="center"></div></td>
      <td><input type="submit" name="Submit" value="Simpan" onclick="this.form.action+='?act=1';this.form.submit();" class="tombol"> 
        <input type="reset" name="Submit2" value="Batal" onclick="this.form.action+='?act=3';this.form.submit();" class="tombol"> 
        <?php if ($frm_nama) { ?>
        <input type="button" name="Submit3" value="Hapus"  onclick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_nama;?>';this.form.submit()};" class="tombol"> 
		<?php } ?></td>
    </tr>
    <tr> 
      <td colspan="4">
      </td>
    </tr>
    <tr> 
      <td colspan="4"><font size="1"><span class="style1">*</span> compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>
