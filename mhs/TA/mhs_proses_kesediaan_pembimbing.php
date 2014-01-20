<?php
/* 
   DATE CREATED : 30/05/07
   KEGUNAAN     : ENTRY KESEDIAAN PEMBIMBING TA
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
include("../../include/temp.php");

f_connecting();
mysql_select_db($DB);
$act= ( isset( $_REQUEST['act'] ) ) ? $_REQUEST['act'] : 0;
$frm_nrp= ( isset( $_REQUEST['frm_nrp'] ) ) ? $_REQUEST['frm_nrp'] : null;
$frm_judul_ta= ( isset( $_REQUEST['frm_judul_ta'] ) ) ? $_REQUEST['frm_judul_ta'] : '';
$frm_kode_dosen_1= ( isset( $_REQUEST['frm_kode_dosen_1'] ) ) ? $_REQUEST['frm_kode_dosen_1'] : null;
$frm_kode_dosen_2= ( isset( $_REQUEST['frm_kode_dosen_2'] ) ) ? $_REQUEST['frm_kode_dosen_2'] : null;
$frm_tgl_ST_TA= ( isset( $_REQUEST['frm_tgl_ST_TA'] ) ) ? $_REQUEST['frm_tgl_ST_TA'] : null;
$frm_tgl_aju_TA= ( isset( $_REQUEST['frm_tgl_aju_TA'] ) ) ? $_REQUEST['frm_tgl_aju_TA'] : null;

$pesan= ( isset( $_REQUEST['pesan'] ) ) ? $_REQUEST['pesan'] : null;
$error= ( isset( $_REQUEST['error'] ) ) ? $_REQUEST['error'] : null;


if ($act==1)   
{ // simpan data
// Kode dan nama harus diisi
	if (($frm_nrp=='') or ($frm_judul_ta=='') or ($frm_kode_dosen_1=='') or ($frm_kode_dosen_2=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data 'KESEDIAAN PEMBIMBING TA' dengan lengkap. Gagal menyimpan data !";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_exist!=1) 
				{
					$result = mysql_query("INSERT INTO master_ta (`NRP`,`JUDUL_TA`,`KODOS1`,`KODOS2`,`TGL_TA`,`TGL_AJU`) VALUES ('".$frm_nrp."','".$frm_judul_ta."','".$frm_kode_dosen_1."','".$frm_kode_dosen_2."','".$frm_tgl_ST_TA."','".$frm_tgl_aju_TA."') ");
					if ($result) 
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
					//echo "<br>frm_tgl_ST_TA=".$frm_tgl_ST_TA;
					//echo "<br>frm_tgl_aju_TA=".$frm_tgl_aju_TA;
					//exit();
					$frm_tgl_ST_TA = datetomysql($frm_tgl_ST_TA);
					$frm_tgl_aju_TA = datetomysql($frm_tgl_aju_TA);
					
					$result_ACC_bimbing = mysql_query("UPDATE master_ta SET `JUDUL_TA`='$frm_judul_ta', 
																			 `KODOS1`='$frm_kode_dosen_1', 
																			 `KODOS2` ='$frm_kode_dosen_2', 
																			 `ACC1`='Y',
																			 `ACC2`='Y',
																			 `TGL_TA`='".$frm_tgl_ST_TA."',
															                 `TGL_AJU`='".$frm_tgl_aju_TA."'
																	   WHERE `NRP`=$frm_nrp");
					if ($result_ACC_bimbing) 
						{
							$pesan = $pesan."<br>Proses update data BERHASIL";	
						}
					else
						{ 
							$pesan = $pesan."<br>Proses update data GAGAL";
						}
				}
		}
	}


if ($act==2) { // hapus data
$result = mysql_query("DELETE FROM master_ta WHERE nrp = ".$frm_nrp);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	

// jika data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist = 0;
	$frm_nrp = "";
	$frm_nama = "";
	$frm_judul_ta = "";
	$frm_kode_dosen_1 = "";
	$frm_kode_dosen_2 = "";	
	$frm_tgl_aju_TA = "";
	$frm_tgl_ST_TA = "";
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
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
									master_mhs.TGLLAHIR,
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
									`master_ta`.`JUDUL_TA`,
									`master_ta`.`KODOS1`,
									`master_ta`.`KODOS2`,
									DATE_FORMAT(`master_ta`.`TGL_TA`,'%d/%m/%Y') as TGL_TA,
									DATE_FORMAT(`master_ta`.`TGL_AJU`,'%d/%m/%Y') as TGL_AJU
									
							FROM
									`master_mhs` LEFT JOIN `master_ta` ON `master_mhs`.`NRP` = `master_ta`.`NRP`
							WHERE
									`master_mhs`.`NRP` =  '".$frm_nrp."'");

							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_nama = $row["NAMA"];
								$frm_judul_ta = $row["JUDUL_TA"];
								$frm_kode_dosen_1 = $row["KODOS1"];
								$frm_kode_dosen_2 = $row["KODOS2"];
								$frm_tgl_aju_TA =$row["TGL_AJU"];
								$frm_tgl_ST_TA =$row["TGL_TA"];
								if (($row["TGL_AJU"]=="00/00/0000")or($row["TGL_AJU"]=="") ) 
								{
									$frm_tgl_aju_TA ="";
									//$frm_exist = 0;
								}
								else 
								{
									$frm_tgl_aju_TA = $row["TGL_AJU"]; 
								}
								
								if (($row["TGL_TA"]=="00/00/0000")or($row["TGL_TA"]=="") ) 
								{
									$frm_tgl_ST_TA ="";
									//$frm_exist = 0;
								}
								else 
								{
									$frm_tgl_ST_TA = $row["TGL_TA"]; 
								}
								
								/*if ($_POST['frm_judul_ta']!='')
								//if ($frm_judul_ta!='')
								{	
									$frm_kode_dosen_1 = $_POST['frm_kode_dosen_1'];
									$frm_kode_dosen_2 = $_POST['frm_kode_dosen_2'];
									$frm_judul_ta = $_POST['frm_judul_ta'];
								}*/
							}else
							{$frm_exist=0; header("Location: mhs_proses_kesediaan_pembimbing.php");}
	
	if ($frm_kode_dosen_1!='') {
		$result = mysql_query("SELECT nama from dosen where kode='$frm_kode_dosen_1'");
		$row = mysql_fetch_array($result);
		$frm_nama_dosen_1 = $row["nama"];
	}	
	
	if ($frm_kode_dosen_2!='') {
		$result = mysql_query("SELECT nama from dosen where kode='$frm_kode_dosen_2'");
		$row = mysql_fetch_array($result);
		$frm_nama_dosen_2 = $row["nama"];
	}	
	
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
<form name="frm_kesediaan_pembimbing" id="frm_kesediaan_pembimbing" action="mhs_proses_kesediaan_pembimbing.php" method="post">
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
              DATA ~</strong>  KESEDIAAN PEMBIMBING</font></font></td>
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
      <td><input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="document.frm_kesediaan_pembimbing.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="10" >
        <span class="style1">*
        <? if (isset($frm_nrp)) echo $frm_nama;?>
        </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td valign="top">Judul TA </td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><textarea name="frm_judul_ta" cols="60" rows="2" class="tekboxku" id="frm_judul_ta"><?php echo $frm_judul_ta; ?></textarea>
        <span class="style1">*</span>        </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>NPK Dosen 1</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
		<select name="frm_kode_dosen_1" id="frm_kode_dosen_1" class="tekboxku">
           <option <?php if ($frm_kode_dosen_1==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sqlDosen="select kode, nama
						   from dosen  where (length(kode)=6) ORDER BY kode";
				
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->kode; ?>" <?php if ($frm_kode_dosen_1==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
          <?php
				}
				
				?>
        </select>
		<span class="style1">*</span>
		</td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>NPK Dosen 2</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
        <select name="frm_kode_dosen_2" id="frm_kode_dosen_2" class="tekboxku">
           <option <?php if ($frm_kode_dosen_2==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sqlDosen="select kode, nama
						   from dosen  where (length(kode)=6) ORDER BY kode";
				
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->kode; ?>" <?php if ($frm_kode_dosen_2==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
          <?php
				}
				
				?>
        </select>
		<span class="style1">*</span>
		</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Tgl Pengajuan TA </td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_aju_TA" type="text" class="tekboxku" id="frm_tgl_aju_TA" value="<?php if ($frm_tgl_aju_TA=='') {echo date("d/m/Y");} else { echo $frm_tgl_aju_TA;} ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('frm_kesediaan_pembimbing.frm_tgl_aju_TA',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)  <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Tgl. Surat Tugas TA</td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_ST_TA" type="text" class="tekboxku" id="frm_tgl_ST_TA" value="<?php if ($frm_tgl_ST_TA=='') {echo date("d/m/Y");} else { echo $frm_tgl_ST_TA;} ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('frm_kesediaan_pembimbing.frm_tgl_ujian',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)  <span class="style1">*</span></td>
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
      <td>
		<input type="submit" name="Submit" value="Simpan" onclick="this.form.action+='?act=1';this.form.submit();" class="tombol"> 
		<input type="reset" name="Submit2" value="Batal" onclick="this.form.action+='?act=3';this.form.submit();" class="tombol"> 
		<?php if ($frm_judul_ta) { ?>
		<input type="button" name="Submit3" value="Hapus" onclick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_judul_ta;?>';this.form.submit()};" class="tombol"> 
		<?php } ?>
	  </td>
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
