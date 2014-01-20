<?
/* 
   DATE CREATED : 12/06/08
   UPDATE  		: 
   KEGUNAAN     : ENTRY JUMLAH MAHARU
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ // simpan data

	if ($frm_tgl_masuk!='') 
		{
			if (datetomysql($frm_tgl_masuk)) 
				{
					$frm_tgl_masuk = datetomysql($frm_tgl_masuk);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal Masuk tidak valid";
				}
		}
 // Kode dan nama harus diisi
	if ($frm_jurusan==0) 
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
					echo "<br>frm_angkatan=".$frm_angkatan;
					echo "<br>frm_jurusan=".$frm_jurusan;
					echo "<br>jum_mhs=".$frm_jum_mhs;
					echo "<br>frm_tgl_masuk=".$frm_tgl_masuk;
					
					$result = mysql_query("INSERT INTO maharu (`id_mhu`, `angkatan`, `jurusan_id`, `jum_mhs`, `tgl_masuk`) VALUES ( NULL, ".$frm_angkatan.", ".$frm_jurusan.", ".$frm_jum_mhs.", '".$frm_tgl_masuk."')");
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
					echo "<br>frm_id_mhu=".$frm_id_mhu;
					echo "<br>frm_angkatan=".$frm_angkatan;
					echo "<br>frm_jurusan=".$frm_jurusan;
					echo "<br>jum_mhs=".$frm_jum_mhs;
					$result = mysql_query("UPDATE maharu SET `angkatan`=$frm_angkatan,
														     `jurusan_id`=$frm_jurusan,
														     `jum_mhs`=$frm_jum_mhs, 
														     `tgl_masuk`='$frm_tgl_masuk'
												       WHERE `id_mhu`=$frm_id_mhu");
	
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

$result = mysql_query("DELETE FROM maharu WHERE id_mhu = ".$frm_id_mhu);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) 
{
	$frm_id_mhu="";
	$frm_jurusan=0;
	$frm_angkatan = "";
	$frm_jum_mhs = "";
	$frm_tgl_masuk="";
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
//echo "<br>frm_kode=".$frm_kode;
				if ((isset($frm_jurusan)) and (isset($frm_angkatan))) 
				{
				   echo "<br>IN if->1";
				   echo "<br>frm_jurusan=".$frm_jurusan;
				   if (($frm_jurusan!=NULL) and ($frm_angkatan!=NULL)){
				   echo "<br>IN if->2";
				   echo "<br>frm_jurusan=".$frm_jurusan;
						$result = mysql_query("SELECT id_mhu,
													  angkatan,
													  jurusan_id,
													  jum_mhs,
													  DATE_FORMAT(tgl_masuk,'%d/%m/%Y') as tgl_masuk
												 FROM maharu
												WHERE angkatan=".$frm_angkatan." and 
													  jurusan_id=".$frm_jurusan );
				
						if ($row = mysql_fetch_array($result)) {
							$frm_exist=1;
							$frm_id_mhu=$row["id_mhu"];
							$frm_angkatan = $row["angkatan"];
							$frm_jurusan = $row["jurusan_id"];
							$frm_jum_mhs = $row["jum_mhs"];
							
							$frm_tgl_masuk = $row["tgl_masuk"];
							if ($row["tgl_masuk"]=="00/00/0000") {
							$frm_tgl_masuk = ""; }else {
							$frm_tgl_masuk = $row["tgl_masuk"];}
						}
						else
						{
							$frm_exist=0;
							echo "<br>ELSE=".$frm_jurusan;
							//$frm_jum_mhs="";
							//$frm_jum_mhs_po="";
						}
					}
			   }
}
/*echo "<br>frm_id_mhu=".$frm_id_mhu; 
echo "<br>frm_angkatan=".$frm_angkatan; 
echo "<br>frm_jurusan=".$frm_jurusan;
echo "<br>frm_jum_mhs=".$frm_jum_mhs;
echo "<br>frm_exist=".$frm_exist;*/
?>
<html>
<head>
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../../include/tanggalan.js">
</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<body class="body">
<form name="form_maharu" id="form_maharu" action="jum_maharu.php" method="post">
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
				<? if ($frm_id_mhu!=''){?>
					<strong>EDIT DATA ~ </strong>
				<? } else
				{?>
					<strong>ENTRY DATA ~ </strong>
				<? }?>
				JUMLAH MAHASISWA BARU</font></td>
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
		  <input type="hidden" name="frm_id_mhu" id="frm_id_mhu" value="<?php echo $frm_id_mhu;?>">
		  <input type="hidden" name="frm_exist" id="frm_exist" value="<?php echo $frm_exist;?>">
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Jurusan</td>
      <td><strong>:</strong></td>
      <td>
	  <select name="frm_jurusan" id="frm_jurusan" class="tekboxku">
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
      <td>Angkatan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> <font color="#FF0000">
        <input name="frm_angkatan" id="frm_angkatan" onBlur="document.form_maharu.submit()" value="<? echo $frm_angkatan;?>" type="text" class="tekboxku" size="10" maxlength="10" >
      *</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Jumlah Mhs </td>
      <td><strong>:</strong></td>
      <td><input name="frm_jum_mhs" type="text" class="tekboxku" id="frm_jum_mhs" value="<?php echo $frm_jum_mhs; ?>" size="10" maxlength="10" >
      <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tanggal Masuk </td>
      <td>&nbsp;</td>
      <td><input name="frm_tgl_masuk" type="text" class="tekboxku" id="frm_tgl_masuk" value="<?php echo $frm_tgl_masuk; ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('form_maharu.frm_tgl_masuk',0,0,'DD/MM/YYYY')"> <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy) <span class="style1">*</span></td>
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
		<?php if ($frm_id_mhu) { ?>
		<input name="Submit3" type="button" class="tombol"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&frm_id_mhu=<?php echo $frm_id_mhu;?>';this.form.submit()};" value="Hapus">
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