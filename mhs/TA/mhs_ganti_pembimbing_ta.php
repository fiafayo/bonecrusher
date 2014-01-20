<?php
/* 
   DATE CREATED : 01/06/07
   KEGUNAAN     : ENTRY GANTI DOSEN PEMBIMBING TA
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
require("../../include/temp.php");

f_connecting();
mysql_select_db($DB);
$act= ( isset( $_REQUEST['act'] ) ) ? $_REQUEST['act'] : 0;
$frm_nrp= ( isset( $_REQUEST['frm_nrp'] ) ) ? $_REQUEST['frm_nrp'] : null;
$frm_pembimbing= ( isset( $_REQUEST['frm_pembimbing'] ) ) ? $_REQUEST['frm_pembimbing'] : '';
$frm_kode_dosen_lama= ( isset( $_REQUEST['frm_kode_dosen_lama'] ) ) ? $_REQUEST['frm_kode_dosen_lama'] : null;
$frm_kode_dosen_baru= ( isset( $_REQUEST['frm_kode_dosen_baru'] ) ) ? $_REQUEST['frm_kode_dosen_baru'] : null;

$frm_tgl_aju= ( isset( $_REQUEST['frm_tgl_aju'] ) ) ? $_REQUEST['frm_tgl_aju'] : null;
$frm_tgl_ganti= ( isset( $_REQUEST['frm_tgl_ganti'] ) ) ? $_REQUEST['frm_tgl_ganti'] : null;
$frm_setuju= ( isset( $_REQUEST['frm_setuju'] ) ) ? $_REQUEST['frm_setuju'] : null;

$frm_dsn1= ( isset( $_REQUEST['frm_dsn1'] ) ) ? $_REQUEST['frm_dsn1'] : null;
$frm_dsn2= ( isset( $_REQUEST['frm_dsn2'] ) ) ? $_REQUEST['frm_dsn2'] : null;
$frm_dsn_baru= ( isset( $_REQUEST['frm_dsn_baru'] ) ) ? $_REQUEST['frm_dsn_baru'] : null;


$pesan= ( isset( $_REQUEST['pesan'] ) ) ? $_REQUEST['pesan'] : null;
$error= ( isset( $_REQUEST['error'] ) ) ? $_REQUEST['error'] : null;
if ($act==1)   
{ // simpan data
	// Pemeriksaan validasi tanggal yang dimasukkan
	if ($frm_tgl_ganti!='') 
		{
			if (datetomysql($frm_tgl_ganti)) 
				{
					$frm_tgl_ganti = datetomysql($frm_tgl_ganti);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal Ganti tidak valid";
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
					$pesan = $pesan."<br> Tanggal Pengajuan tidak valid";
				}
		}

// Form harus diisi
	if (($frm_nrp=='') or ($frm_pembimbing=='') or ($frm_tgl_ganti=='') or ($frm_tgl_aju=='') or ($frm_setuju=='') or ($frm_kode_dosen_baru=='') or ($frm_kode_dosen_lama=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data 'GANTI PEMBIMBING TA' dengan lengkap. Gagal menyimpan data !";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data tidak ada, berarti record baru
		//echo "<br>frm_exist=".$frm_exist;
			if ($frm_exist!=1) 
				{
					/*echo "<br>frm_kode_dosen_lama=".$frm_kode_dosen_lama;
					echo "<br>frm_kode_dosen_baru=".$frm_kode_dosen_baru;
					echo "<br>frm_tgl_ganti=".$frm_tgl_ganti;
					echo "<br>frm_tgl_aju=".$frm_tgl_aju;
					echo "<br>frm_setuju=".$frm_setuju;
					echo "<br>frm_nrp=".$frm_nrp;*/
					//exit();
					$result = mysql_query("INSERT INTO ganti_dobing ( `NRP` ,`kode_dobing_lama` ,  `kode_dobing_baru` , `tgl_ganti` ,  `tgl_aju` , `disetujui` ) VALUES ( '".$frm_nrp."', '".$frm_kode_dosen_lama."', '".$frm_kode_dosen_baru."', '".$frm_tgl_ganti."', '".$frm_tgl_aju."', '".$frm_setuju."') " );
					if ($result) 
						{
							if ($frm_pembimbing=="1")
							{
								$result_update = mysql_query("UPDATE master_ta set `KODOS1`='$frm_kode_dosen_baru' where `NRP`='$frm_nrp'");
							}
							elseif ($frm_pembimbing=="2")
							{
								$result_update = mysql_query("UPDATE master_ta set `KODOS2`='$frm_kode_dosen_baru' where `NRP`='$frm_nrp'");
							}
							
							if ($result_update)
							{
								$pesan = $pesan."<br>Proses entry data BERHASIL";
							}
							else
							{
								$error = 1;
								$pesan = $pesan."<br>Proses entry data GAGAL ". mysql_error();
							}
						}
					else
						{ 
							$pesan = $pesan."<br>Proses entry data GAGAL ". mysql_error();;
						}
				}
			else
				{
					
					/*echo "<br>frm_kode_dosen_lama=".$frm_kode_dosen_lama;
					echo "<br>frm_kode_dosen_baru=".$frm_kode_dosen_baru;
					echo "<br>frm_tgl_ganti=".$frm_tgl_ganti;
					echo "<br>frm_tgl_aju=".$frm_tgl_aju;
					echo "<br>frm_setuju=".$frm_setuju;
					echo "<br>frm_nrp=".$frm_nrp;*/
					
					$result = mysql_query("UPDATE ganti_dobing set `kode_dobing_lama`='$frm_kode_dosen_lama', `kode_dobing_baru`='$frm_kode_dosen_baru', `tgl_ganti`='$frm_tgl_ganti', `tgl_aju`='$frm_tgl_aju', `disetujui`='$frm_setuju' WHERE `NRP`='$frm_nrp'");
				
					if ($result) 
						{
							//echo "<br>--frm_pembimbing=".$frm_pembimbing;
							if ($frm_pembimbing=="1")
							{
								$result_update = mysql_query("UPDATE master_ta set `KODOS1`='$frm_kode_dosen_baru' where `NRP`='$frm_nrp'");
							}
							elseif ($frm_pembimbing=="2")
							{
								$result_update = mysql_query("UPDATE master_ta set `KODOS2`='$frm_kode_dosen_baru' where `NRP`='$frm_nrp'");
							}

							if ($result_update)
							{
								$pesan = $pesan."<br>Proses Update data BERHASIL";
							}
							else
							{
								$error = 1;
								$pesan = $pesan."<br>Proses Update data GAGAL111 ". mysql_error();
							}
						}
					else
						{ 
							$pesan = $pesan."<br>Proses update data GAGAL ". mysql_error();;
						}
				}
		}
	}

if ($act==2) { // hapus data
$result = mysql_query("DELETE FROM ganti_dobing WHERE nrp = ".$frm_nrp);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	// Kalau data sudah masuk ke dalam database, form dikosongkan siap untuk diisi data baru
	
if (($act!=0)and($error!=1)) {
	$frm_exist = 0;
	$frm_nrp = "";
	$frm_nama = "";
	$frm_kode_dosen_lama = "";
	$frm_kode_dosen_baru = "";
	$frm_tgl_ganti = "";
	$frm_tgl_aju = "";
	$frm_setuju = "T";
}
else
{
// kalau user mengisi NRP, maka di cek apakah data NRP sudah ada, kalau sudah ada maka data ditampilkan
if ($frm_nrp!='')  {
$result = mysql_query("SELECT	master_mhs.NRP,
								master_mhs.NAMA,
								`ganti_dobing`.`kode_dobing_lama`,
								`ganti_dobing`.`kode_dobing_baru`,
								 DATE_FORMAT(`ganti_dobing`.`tgl_aju`,'%d/%m/%Y') as tgl_aju,
								 DATE_FORMAT(`ganti_dobing`.`tgl_ganti`,'%d/%m/%Y') as tgl_ganti,
								`ganti_dobing`.`disetujui`
							FROM
								`master_mhs` LEFT JOIN `ganti_dobing` ON `master_mhs`.`NRP` = `ganti_dobing`.`NRP`
							WHERE
								`master_mhs`.`NRP` =  '".$frm_nrp."'");

							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_nama = $row["NAMA"];
								$frm_kode_dosen_lama = $row["kode_dobing_lama"];
								$frm_kode_dosen_baru = $row["kode_dobing_baru"];
								
								//echo "<br>nama=".$frm_nama;
								//echo "<br>kodobing_lama=".$frm_kode_dosen_lama;
								//echo "<br>kodobing_baru=".$frm_kode_dosen_baru;
								
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
							
								$frm_setuju = $row["disetujui"];
							}else
							{$frm_exist=0; header("Location: mhs_ganti_pembimbing_ta.php"); }
}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<link href="../../css/style2.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<script type="text/javascript" language="javascript" src="../../include/tanggalan.js" >
</script>
<body class="body">
<form name="mhs" id="mhs" action="mhs_ganti_pembimbing_ta.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><img src="spacer" height="1" /></td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4"> <hr size="1" color="#FF9900" /> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>ENTRY 
              DATA ~</strong>  GANTI PEMBIMBING TA </font></font> </td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900" /> </td>
    </tr>
    <tr>
      <td width="15%">&nbsp;</td> 
      <td width="15%">&nbsp;</td>
      <td width="3%">&nbsp;</td>
      <td width="83%"><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" /></td>
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
      <td nowrap>Pembimbing ke - </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <?
	  	$res_pilih_dsn = mysql_query("SELECT ganti_dobing.NRP,
											 ganti_dobing.kode_dobing_lama,
											 ganti_dobing.kode_dobing_baru,
									         master_ta.KODOS1,
									         master_ta.KODOS2
										FROM ganti_dobing, master_ta
									   WHERE ganti_dobing.NRP=master_ta.NRP and
											 master_ta.NRP='".$frm_nrp."'");

							if ($row_pilih_dsn = mysql_fetch_array($res_pilih_dsn)) {
								$frm_dsn_baru = $row_pilih_dsn["kode_dobing_baru"];
								$frm_dsn1 = $row_pilih_dsn["KODOS1"];
								$frm_dsn2 = $row_pilih_dsn["KODOS2"];
								$frm_NRP = $row_pilih_dsn["NRP"];
							}
	  ?>
	  <input name="frm_pembimbing" id="frm_pembimbing" type="radio" value="1" <? if (($frm_dsn_baru==$frm_dsn1) and (isset($frm_dsn_baru))) echo "checked";?>>1&nbsp;
	  <input name="frm_pembimbing" id="frm_pembimbing" type="radio" value="2" <? if (($frm_dsn_baru==$frm_dsn2) and (isset($frm_dsn_baru)))  echo "checked";?>>2<br>
      <? //echo "<br>frm_pembimbing=".$frm_pembimbing;
	/*echo "<br>kode_dobing_baru=".$kode_dobing_baru;
	echo "<br>frm_dsn_baru=".$frm_dsn_baru;
	echo "<br>frm_dsn1=".$frm_dsn1;
	echo "<br>frm_dsn2=".$frm_dsn2;
	echo "<br>frm_pembimbing=".$frm_pembimbing; */
	 ?>
	 
	 </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>NPK Dosen Lama </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <select name="frm_kode_dosen_lama" id="frm_kode_dosen_lama" class="tekboxku">
          <option <?php if ($frm_kode_dosen_lama==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sqlDosen="select kode, nama
						   from dosen where (length(kode)=6) ORDER by kode";
				$result_cek = mysql_query("select NRP from ganti_dobing where ganti_dobing.NRP='$frm_nrp'");
				$row_result_cek = mysql_num_rows($result_cek);
				if ($row_result_cek!=0)
				{
					$sql_kodos1 ="select kode_dobing_lama as kode
						          from ganti_dobing
						          where ganti_dobing.NRP='$frm_nrp'";
				}
				else
				{
					//$sql_kodos1 ="select kode, nama
						       //   from dosen, master_ta
						       //   where master_ta.KODOS2=dosen.kode AND master_ta.NRP='$frm_nrp'";
				}		   
				
				$result = @mysql_query($sqlDosen);
				$result2 = @mysql_query($sql_kodos1);
				$row_result2=@mysql_fetch_object($result2);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
					$c=$c+1;
					?>
					<option value="<?php echo $row->kode; ?>" <?php if ($row && $row_result2 && ($row->kode==$row_result2->kode)) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
          <?php }?>
        </select>
	  <span class="style1"> *</span>
		</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>NPK Dosen Baru </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_kode_dosen_baru" id="frm_kode_dosen_baru" class="tekboxku">
          <option <?php if ($frm_kode_dosen_baru==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sqlDosen="select kode, nama
						     from dosen  where (length(kode)=6) ORDER BY kode";
				
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->kode; ?>" <?php if ($frm_kode_dosen_baru==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
          <?php }?>
        </select>
        <span class="style1">*</span> </td>
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
      <td>Tanggal Mulai Ganti </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_ganti" type="text" class="tekboxku" id="frm_tgl_ganti" value="<?php echo $frm_tgl_ganti; ?>" size="10" maxlength="10">
	   <A Href="javascript:show_calendar('mhs.frm_tgl_ganti',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)	 <span class="style1">*</span> </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>Persetujuan (Ya/Tidak)</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
        <select name="frm_setuju" id="frm_setuju" class="tekboxku">
			<? if (isset($frm_setuju)) {?>
			<option value="Y" <? if ($frm_setuju=="Y") echo "selected"?>>Ya</option>
			<option value="T" <? if ($frm_setuju=="T") echo "selected"?>>Tidak</option>
			<? } else {?>
			<option value="Y">Ya</option>
			<option value="T" selected>Tidak</option>
			<? }?>
        </select><span class="style1"> *</span>
	  </td>
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
        <?php if ($frm_kode_dosen_lama) { ?>
        <input type="button" name="Submit3" value="Hapus"  onclick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_kode_dosen_lama;?>';this.form.submit()};" class="tombol"> 
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