<?php
/* 
   DATE CREATED : 30/05/07
   KEGUNAAN     : ENTRY GANTI JUDUL TA
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
require("../../include/temp.php");

f_connecting();
mysql_select_db($DB);
$act=isset( $_REQUEST['act'] ) ?  $_REQUEST['act'] : 0;     
$error=isset( $_REQUEST['error'] ) ?  $_REQUEST['error'] : 0;     
$pesan=isset( $_REQUEST['pesan'] ) ?  $_REQUEST['pesan'] : '';    
$frm_nrp=isset( $_REQUEST['frm_nrp'] ) ?  $_REQUEST['frm_nrp'] : '';    
$frm_nama=isset( $_REQUEST['frm_nama'] ) ?  $_REQUEST['frm_nama'] : '';    
$frm_judul_semula=isset( $_REQUEST['frm_judul_semula'] ) ?  $_REQUEST['frm_judul_semula'] : '';    
$frm_judul_baru=isset( $_REQUEST['frm_judul_baru'] ) ?  $_REQUEST['frm_judul_baru'] : '';    
$frm_tgl_aju=isset( $_REQUEST['frm_tgl_aju'] ) ?  $_REQUEST['frm_tgl_aju'] : '';    
$frm_tgl_ganti=isset( $_REQUEST['frm_tgl_ganti'] ) ?  $_REQUEST['frm_tgl_ganti'] : '';    

if ($act==1)   
{ // simpan data
	// Pemeriksaan tanggal, apakah tanggal yang dimasukkan valid
	if ($frm_tgl_ganti!='') 
		{
			if (datetomysql($frm_tgl_ganti)) 
				{
					$frm_tgl_ganti = datetomysql($frm_tgl_ganti);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal Ganti Judul TA tidak valid";
				}
		}

	if ($frm_tgl_aju!='') 
		{
			if (datetomysql($frm_tgl_aju)) 
				{
					$frm_tgl_aju = datetomysql($frm_tgl_aju);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal Pengajuan Ganti Judul TA tidak valid";
				}
		}

// form harus diisi
	if (($frm_nrp=='') or ($frm_judul_semula=='') or ($frm_judul_baru=='') or ($frm_tgl_ganti=='') or ($frm_tgl_aju=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data 'GANTI JUDUL TA' dengan lengkap. Gagal menyimpan data!";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_exist!=1) 
				{
					$result = mysql_query("INSERT INTO ganti_judul ( `nrp`, `judul_lama`, `judul_baru`, `tgl_aju`, `tgl_ganti`) VALUES ( '".$frm_nrp."', '".$frm_judul_semula."', '".$frm_judul_baru."', '".$frm_tgl_aju."', '".$frm_tgl_ganti."') " );

					if ($result) 
						{
							$result_update_master_ta = mysql_query("UPDATE master_ta set `JUDUL_TA`='$frm_judul_baru' where `NRP`=$frm_nrp");
							if ($result_update_master_ta) 
								{
									$pesan = $pesan."<br>Proses entry data BERHASIL";	
								}
							else
								{ 
									$pesan = $pesan."<br>Proses entry data GAGAL";
								}	
						}
					else
						{ 
							$pesan = $pesan."<br>Proses entry data GAGAL";
						}
				}
			else
				{
					$result = mysql_query("UPDATE ganti_judul set `judul_lama`='$frm_judul_semula', `judul_baru`='$frm_judul_baru', `tgl_aju` ='$frm_tgl_aju' , `tgl_ganti` ='$frm_tgl_ganti' where `nrp`=$frm_nrp");
					if ($result) 
						{
							$result_update_master_ta = mysql_query("UPDATE master_ta set `JUDUL_TA`='$frm_judul_baru' where `NRP`=$frm_nrp");
							if ($result_update_master_ta) 
								{
									$pesan = $pesan."<br>Proses update data BERHASIL";	
								}
							else
								{ 
									$pesan = $pesan."<br>Proses update data GAGAL";
								}	
						}
					else
						{ 
							$pesan = $pesan."<br>Proses update data GAGAL";
						}
				}
		}
	}


if ($act==2) { // hapus data

$result = mysql_query("delete from ganti_judul where nrp = ".$frm_nrp);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
	// Jika data sudah masuk ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	$frm_nrp = "";
	$frm_nama = "";
	$frm_judul_semula = "";
	$frm_judul_baru = "";
	$frm_tgl_ganti = "";
	$frm_tgl_aju = "";
}
else
{
// Jika user mengisi NRP, maka di cek apakah data NRP sudah ada, kalau sudah ada maka data ditampilkan
if ($frm_nrp!='')  {
$result = mysql_query("SELECT	master_mhs.NRP,
								master_mhs.SKSMAX,
								master_mhs.IPS,
								master_mhs.`STATUS`,
								master_mhs.JURUSAN,
								master_mhs.WALI,
								master_mhs.NAMA,
								master_mhs.ALAMAT_SBY,
								master_mhs.ZIP_SBY,
								master_mhs.EMAIL,
								master_mhs.NIRM,
								DATE_FORMAT(`master_mhs`.`TGLLAHIR`,'%d/%m/%Y') as TGLLAHIR,
								master_mhs.TMPLAHIR,
								master_mhs.TOTBSS,
								master_mhs.IPK,
								master_mhs.SKSKUM,
								master_mhs.TELEPON,
								master_mhs.NO_HP,
								master_mhs.VALIDID,
								master_mhs.`PASSWORD`,
								master_mhs.ANGKATAN,
								master_mhs.NAMASMA,
								master_mhs.NAMA_ORTU,
								master_mhs.ALAMAT_ORTU,
								master_mhs.ZIP_ORTU,
								master_mhs.TELEPON_ORTU,
								master_mhs.KELAMIN,
								`ganti_judul`.`judul_lama`,
								`ganti_judul`.`judul_baru`,
								 DATE_FORMAT(`ganti_judul`.`tgl_aju`,'%d/%m/%Y') as tgl_aju,
								 DATE_FORMAT(`ganti_judul`.`tgl_ganti`,'%d/%m/%Y') as tgl_ganti
							FROM
								`master_mhs` LEFT JOIN `ganti_judul` ON `master_mhs`.`NRP` = `ganti_judul`.`NRP`
							WHERE
								`master_mhs`.`NRP` =  '".$frm_nrp."'");

							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_nama = $row["NAMA"];
								$frm_judul_semula = $row["judul_lama"];
								$frm_judul_baru =$row["judul_baru"];
								
								$frm_tgl_ganti =$row["tgl_ganti"];
								if (($row["tgl_ganti"]=="00/00/0000") or ($row["tgl_ganti"]==""))
								{
									$frm_tgl_ganti = ""; 
									$frm_exist = 0;
								}
								else 
								{
									$frm_tgl_ganti =$row["tgl_ganti"];
								}
								
								$frm_tgl_aju = $row["tgl_aju"];
								if ($row["tgl_aju"]=="00/00/0000") {
								$frm_tgl_aju = ""; }else {
								$frm_tgl_aju = $row["tgl_aju"];}
								
							}else
							{$frm_exist=0; header("Location: mhs_ganti_judul_ta.php"); }
}
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
<body class="body">
<form name="mhs" action="mhs_ganti_judul_ta.php" method="post">
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
              DATA ~</strong>  GANTI JUDUL TA </font></font> </td>
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
        <span class="style1">* <? if (isset($frm_nrp)) echo $frm_nama;?> </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">Judul Semula</td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td>
	     <?php 
		 if ($frm_nrp!='')
		 {
				$result_judul_lama = mysql_query("SELECT `master_ta`.`JUDUL_TA`
												 FROM `master_mhs`,`master_ta`
												WHERE `master_mhs`.`NRP` = `master_ta`.`NRP` AND
													  `master_mhs`.`NRP` =  '".$frm_nrp."'");
				
				if ($row_judul_lama = mysql_fetch_array($result_judul_lama)) {
					$judul_lama=$row_judul_lama['JUDUL_TA']; 
				}
				if ($frm_judul_semula=='')
				{
					$frm_judul_semula=$judul_lama;
				}
		 }
		 ?>
		 <textarea name="frm_judul_semula" cols="60" rows="2" class="tekboxku" id="frm_judul_semula"><? echo $frm_judul_semula;?></textarea>
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">Judul Baru</td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><textarea name="frm_judul_baru" cols="60" rows="2" class="tekboxku" id="frm_judul_baru"><?php echo $frm_judul_baru; ?></textarea>
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Tanggal Pengajuan </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_aju" type="text" class="tekboxku" id="frm_tgl_aju" value="<?php echo $frm_tgl_aju; ?>" size="10" maxlength="10">
	  <A Href="javascript:show_calendar('mhs.frm_tgl_aju',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)
      <span class="style1">*</span> </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Tanggal Mulai Ganti </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_ganti" type="text" class="tekboxku" id="frm_tgl_ganti" value="<?php echo $frm_tgl_ganti; ?>" size="10" maxlength="10">
	   <A Href="javascript:show_calendar('mhs.frm_tgl_ganti',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)	 <span class="style1">*</span> </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
      <td>        </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
      <td><input type="submit" name="Submit" value="Simpan" onclick="this.form.action+='?act=1';this.form.submit();" class="tombol"> 
        <input type="reset" name="Submit2" value="Batal" onclick="this.form.action+='?act=3';this.form.submit();" class="tombol"> 
        <?php if ($frm_judul_semula) { ?>
        <input type="button" name="Submit3" value="Hapus"  onclick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_judul_semula;?>';this.form.submit()};" class="tombol"> 
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
