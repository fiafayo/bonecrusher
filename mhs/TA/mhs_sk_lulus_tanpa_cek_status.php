<?php
/* 
   DATE CREATED : 30/06/07
   UPDATE       : 30/03/2009 - tambah field bidang minat
   KEGUNAAN     : ENTRY DATA SK LULUS TA
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
include("../../include/temp.php");

f_connecting();
mysql_select_db($DB);
$act= ( isset( $_REQUEST['act'] ) ) ? $_REQUEST['act'] : 0;
$frm_nrp= ( isset( $_REQUEST['frm_nrp'] ) ) ? $_REQUEST['frm_nrp'] : '';
$frm_exist= ( isset( $_REQUEST['frm_exist'] ) ) ? $_REQUEST['frm_exist'] : null;
 
$frm_judul_TA= ( isset( $_REQUEST['frm_judul_TA'] ) ) ? $_REQUEST['frm_judul_TA'] : null;
$frm_sks_kum= ( isset( $_REQUEST['frm_sks_kum'] ) ) ? $_REQUEST['frm_sks_kum'] : null;
$frm_ip_kum= ( isset( $_REQUEST['frm_ip_kum'] ) ) ? $_REQUEST['frm_ip_kum'] : null;
$frm_tempat_lahir= ( isset( $_REQUEST['frm_tempat_lahir'] ) ) ? $_REQUEST['frm_tempat_lahir'] : null;
$frm_tgl_lahir= ( isset( $_REQUEST['frm_tgl_lahir'] ) ) ? $_REQUEST['frm_tgl_lahir'] : null;
$frm_bidang_minat= ( isset( $_REQUEST['frm_bidang_minat'] ) ) ? $_REQUEST['frm_bidang_minat'] : null;

 
$frm_tgl_lulus = ( isset( $_REQUEST['frm_tgl_lulus'] ) ) ? $_REQUEST['frm_tgl_lulus'] : null;
 
$frm_nama = ( isset( $_REQUEST['frm_nama'] ) ) ? $_REQUEST['frm_nama'] : null;
$pesan= ( isset( $_REQUEST['pesan'] ) ) ? $_REQUEST['pesan'] : null;
$error= ( isset( $_REQUEST['error'] ) ) ? $_REQUEST['error'] : null;



if ($act==1)   
{ // simpan data
	// Pemeriksaan tanggal, apakah tanggal yang dimasukkan valid
	if ($frm_tgl_lulus!='') 
		{
			if (datetomysql($frm_tgl_lulus)) 
				{
					$frm_tgl_lulus = datetomysql($frm_tgl_lulus);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal Lulus Ujian TA tidak valid";
				}
		} 
		
	if ($frm_tgl_lahir!='') 
		{
			if (datetomysql($frm_tgl_lahir)) 
				{
					$frm_tgl_lahir = datetomysql($frm_tgl_lahir);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal Lahir tidak valid"; 
				}
		}

// Kode dan nama harus diisi 
	if (($frm_nrp=='') or ($frm_nama=='') or ($frm_tgl_lulus=='') or ($frm_sks_kum=='') or ($frm_ip_kum=='') or ($frm_judul_TA=='') or ($frm_tempat_lahir=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data 'SK LULUS TA' dengan lengkap. Gagal menyimpan data !";
		}
	
	/*if ($frm_bidang_minat=='') 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, data 'BIDANG MINAT' tidak boleh kosong. Gagal menyimpan data !";
		}*/

	if ($error !=1) // Jika semua isian form valid 
		{
			$result_periode = @mysql_query("SELECT  id, 
													tahun_ajaran, 
													semester, 
													DATE_FORMAT(awal,'%Y/%m/%d') as awal, 
													DATE_FORMAT(akhir,'%Y/%m/%d') as akhir 
											   FROM tahun_ajar 
											  WHERE tahun_ajar.awal  <= '".$frm_tgl_lulus."' AND
													tahun_ajar.akhir >='".$frm_tgl_lulus."'");
			$row_periode=@mysql_fetch_object($result_periode);  
			$upt_semester = $row_periode->semester;
			$upt_tahun = $row_periode->tahun_ajaran;
		
		// data id tidak ada, berarti record baru
			if ($frm_exist!=1) 
				{
					//$sql=$sql." and (`lulus_ta`.`tgl_lulus` between '".$row_periode->awal."' and '".$row_periode->akhir."')"; 
					$result = mysql_query("UPDATE lulus_ta set `sks`='".$frm_sks_kum."', 
					                                           `ipk`='".$frm_ip_kum."', 
															   `tgl_lulus`='".$frm_tgl_lulus."',
															   `semester`='".$upt_semester."',
															   `tahun`='".$upt_tahun."',
															   `bidang_minat`='".$frm_bidang_minat."'
														 where `nrp`=$frm_nrp");
					//$result = mysql_query("INSERT INTO lulus_ta ( `NRP`, `sks`, `ipk`, `tgl_lulus`, `tahun`) VALUES ( '".$frm_nrp."', '".$frm_tgl_ujian."', '".$frm_nilai_ujian."', '".$frm_semester."', '".$frm_tahun."') " );

					if ($result) 
						{
							// L=LULUS S1   S= LULUS TA
							$result_update_status = mysql_query("UPDATE master_ta set `STATUS` ='S', JUDUL_TA='$frm_judul_TA' where `nrp`=$frm_nrp");
							if ($result_update_status) 
							{
								$result_update_master_mhs = mysql_query("UPDATE master_mhs set `TGLLAHIR` ='$frm_tgl_lahir', TMPLAHIR='$frm_tempat_lahir' where `nrp`=$frm_nrp");
								if ($result_update_master_mhs) 
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
							$pesan = $pesan."<br>Proses entry data GAGAL";
						}
				}
			else
				{
					
					echo "<br>semster= ".$row_periode->semester;
					echo "<br>thn= ".$row_periode->tahun_ajaran;
					$result_update1 = mysql_query("UPDATE lulus_ta SET `sks` ='".$frm_sks_kum."', 
																	   `ipk` ='".$frm_ip_kum."', 
																	   `tgl_lulus` ='".$frm_tgl_lulus."', 
																	   `semester`='".$upt_semester."', 
																	   `tahun`='".$upt_tahun."', 
																	   `bidang_minat` ='".$frm_bidang_minat."' 
												                 WHERE `nrp`=$frm_nrp");
					if ($result_update1) 
						{
							$result_update_status = mysql_query("UPDATE master_ta set `STATUS` ='S', JUDUL_TA='$frm_judul_TA' where `nrp`=$frm_nrp");
							if ($result_update_status) 
							{
								$result_update_master_mhs = mysql_query("UPDATE master_mhs set `TGLLAHIR` ='$frm_tgl_lahir', TMPLAHIR='$frm_tempat_lahir' where `nrp`=$frm_nrp");
								if ($result_update_master_mhs) 
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
					else
						{ 
							$pesan = $pesan."<br>Proses update data GAGAL updaTe";
						}
				}
		}
	}


if ($act==2) { // hapus data
$result_del = mysql_query("delete from lulus_ta where nrp = ".$frm_nrp);
$result_del2 = mysql_query("UPDATE master_ta set `STATUS`='' where `NRP`=$frm_nrp");
	if ($result_del AND $result_del2) {$pesan = "Data telah dihapus";	}else{ $pesan = "Gagal menghapus data";}
}	
	
// jika data sudah masuk ke dalam database, form dikosongkan siap isi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	$frm_nrp="";
	$frm_nama="";
	$frm_tgl_lulus = "";
	$frm_sks_kum = "";
	$frm_ip_kum = "";
	$frm_judul_TA = "";
	$frm_tempat_lahir = "";
	$frm_tgl_lahir = "";
}
else
{
    
// jika user mengisi NRP, maka di cek apakah data NRP sudah ada, kalau sudah ada maka data ditampilkan
if ($frm_nrp!='')  {
//echo "EXIST=".$frm_exist;
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
								DATE_FORMAT(master_mhs.TGLLAHIR,'%d/%m/%Y') as TGLLAHIR,
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
								`lulus_ta`.`sks`,
								`lulus_ta`.`ipk`,
								 DATE_FORMAT(`lulus_ta`.`tgl_ujian`,'%d/%m/%Y') as tgl_ujian,
								 DATE_FORMAT(`lulus_ta`.`tgl_lulus`,'%d/%m/%Y') as tgl_lulus,
								`lulus_ta`.`nilai_ujian`,
								`lulus_ta`.`tahun`,
								`lulus_ta`.`status`,
								`lulus_ta`.`semester`,
								`lulus_ta`.`bidang_minat`,
								`master_ta`.`JUDUL_TA`
							FROM
								`master_mhs` LEFT JOIN `lulus_ta` ON `master_mhs`.`NRP` = `lulus_ta`.`NRP`
								 LEFT JOIN `master_ta` ON `master_mhs`.`NRP` = `master_ta`.`NRP`
							WHERE
								`master_mhs`.`NRP` =  '".$frm_nrp."'");
$row = mysql_fetch_array($result);
						if ($row) {
							$frm_exist=1;
							$frm_nama = $row["NAMA"];
							$frm_judul_TA = $row["JUDUL_TA"];
							$frm_sks_kum = $row["sks"];
							$frm_ip_kum = $row["ipk"];
							$frm_bidang_minat = $row["bidang_minat"];
							$frm_tempat_lahir = $row["TMPLAHIR"];
							
							$frm_tgl_lulus =$row["tgl_lulus"];
							if (($row["tgl_lulus"]=="00/00/0000")or($row["tgl_lulus"]=="") ) 
							{
								$frm_tgl_lulus ="";
								$frm_exist = 0;
							}
							else 
							{
								$frm_tgl_lulus =$row["tgl_lulus"]; 
							}
							
							$frm_tgl_lahir =$row["TGLLAHIR"];
							if (($row["TGLLAHIR"]=="00/00/0000")or($row["TGLLAHIR"]=="") ) 
							{
								$frm_tgl_lahir ="";
								$frm_exist = 0;
							}
							else 
							{
								$frm_tgl_lahir =$row["TGLLAHIR"]; 
							}
							
						}else
						{
                                                    $frm_exist=0; 
                                                    header("Location: mhs_sk_lulus.php"); 
                                                    exit;
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
<script type="text/javascript" lang="javascript" src="../../include/tanggalan.js" > </script>
</head>
 
<body class="body">
<form name="mhs" id="mhs" action="mhs_sk_lulus.php" method="post">
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
              DATA ~</strong>  SK LULUS S1 </font></font> </td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="12%">&nbsp;</td> 
      <td width="12%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="74%"><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" ></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>NRP</td>
      <td width="2%"><strong>:</strong></td>
      <td><input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="10" >
        <span class="style1">*<? if (isset($frm_nrp)) echo $frm_nama;?></span>
	  	<input name="frm_nama" type="hidden" id="frm_nama"  value="<?php echo $frm_nama; ?>" >
	  </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td valign="top" nowrap>Judul TA </td>
      <td valign="top"><strong>:</strong></td>
      <td valign="top"><textarea name="frm_judul_TA" cols="60" rows="2" class="tekboxku" id="frm_judul_TA"><?php echo $frm_judul_TA; ?></textarea>
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>SKS Kumulatif</td>
      <td><strong>:</strong></td>
      <td><input name="frm_sks_kum" id="frm_sks_kum" type="text" class="tekboxku" value="<?php echo $frm_sks_kum; ?>" size="10" maxlength="10">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>IP Kumulatif</td>
      <td><strong>:</strong></td>
      <td><input name="frm_ip_kum" id="frm_ip_kum" type="text" class="tekboxku" value="<?php echo $frm_ip_kum; ?>" size="10" maxlength="10">
        <span class="style1">*(x . xx)</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal Lulus</td>
      <td><strong>:</strong></td>
      <?php if (!$frm_tgl_lulus) {
          $frm_tgl_lulus=date('d/m/Y'); //jika kosong, maka defaultnya adalah hari ini
      }
          ?>
      <td><input name="frm_tgl_lulus" type="hidden" class="tekboxku" id="frm_tgl_lulus" value="<?php echo $frm_tgl_lulus; ?>" size="10" maxlength="10"> 
          <?php echo $frm_tgl_lulus; ?>
        <A Href="javascript:show_calendar('mhs.frm_tgl_lulus',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)  <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tempat Lahir </td>
      <td><strong>:</strong></td>
      <td><input name="frm_tempat_lahir" type="text" class="tekboxku" id="frm_tempat_lahir" value="<?php echo $frm_tempat_lahir; ?>" size="30" maxlength="50" >
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tanggal Lahir </td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_lahir" type="text" class="tekboxku" id="frm_tgl_lahir" value="<?php echo $frm_tgl_lahir; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('mhs.frm_tgl_lahir',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
      </A>(dd/mm/yyyy)  <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Bidang Minat </td>
      <td><strong>:</strong></td>
      <td><select name="frm_bidang_minat" id="frm_bidang_minat" class="tekboxku">
				<option value="" <?php if ($frm_bidang_minat==''){echo "selected";}?>>Tidak Ada Bidang Minat</option>
				<?php 
						$jur_id=substr($frm_nrp, 3, 1);
						//echo "<br>JUR=".$jur_id;
						
						$sql_minat="SELECT id, 
										   jurusan,
										   minat
								      FROM bidang_minat 
									 WHERE jurusan=$jur_id";
						
						$result = @mysql_query($sql_minat);
						$c=0;
						while ($row=@mysql_fetch_object($result))  {
						$c=$c+1;
						//echo "<br>minat=".$row->minat;
						?>
					<option value="<?php echo $row->minat; ?>" <?php if ($frm_bidang_minat==$row->minat) { echo "selected"; }?> > <?php echo $row->minat; ?></option>
				<?php }?>
			  </select>
			  <? //echo "<br>JUR=".$jur_id;?>
			        <span class="style1">*</span> <? //echo "<br>minat= ".$frm_bidang_minat;?></td>
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