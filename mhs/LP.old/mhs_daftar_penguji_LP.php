<?php
/* 
   DATE CREATED : 01/08/07
   KEGUNAAN     : ENTRY DATA DAFTAR PENGUJI PENELITIAN
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
				$pesan = $pesan."<br> Tanggal Ujian Penelitian tidak valid";
			}
		}

// Kode dan nama harus diisi
	if (($frm_nrp=='') or ($frm_doji1=='') or ($frm_doji2=='') or ($frm_dobing1=='') or ($frm_tgl_ujian=='') or ($frm_ruang_ujian=='') or ($frm_no_SK_LP_now=='') or ($frm_no_SK_LP_terakhir=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data 'DAFTAR PENGUJI PENELITIAN' dengan lengkap. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_exist!=1) 
				{
				echo "<br>+INSERT";
				$frm_ok='INSERT!!!';
					$result = mysql_query("INSERT INTO daftar_uji_lp (`NRP`,`NO_SK`,`URUT_SK`,`PEMBIMBING_1`,`PEMBIMBING_2`,`PENGUJI_1`,`PENGUJI_2`,`TGLUJI`,`RUANG`) VALUES ( '".$frm_nrp."', '".$frm_no_SK_LP_now."', '".$frm_urut_sk_now."','".$frm_dobing1."', '".$frm_dobing2."', '".$frm_doji1."', '".$frm_doji2."', '".$frm_tgl_ujian."', '".$frm_ruang_ujian."') " );
					if ($result) 
						{
							//$result_insert1 = mysql_query("UPDATE no_surat_lp set `N_SK`='$frm_no_SK_LP_now', `URUT_SK`=$frm_no_urut_SK_LP_terakhir WHERE `NRP`='$frm_nrp'");
							$result_insert1 = mysql_query("UPDATE no_surat_lp set `N_SK`='$frm_no_SK_LP_now' WHERE `NRP`='$frm_nrp'");
							if ($result_insert1) 
							{
								$pesan = $pesan."<br>Data telah ditambahkan";	
							}
							else
							{ 
								$frm_exist=0; 
								$pesan = $pesan."<br>Gagal menambahkan data";
							}
						}
					else
						{ 
							$frm_exist=0; 
							$pesan = $pesan."<br>Gagal menambahkan data";
						}
				}
			else
				{
					echo "<br>+UPDATE";
					$frm_ok='UPDATE!!!';
					$frm_exist=0; 
					
					$result_cek_NRP = mysql_query("SELECT `daftar_uji_lp`.`PEMBIMBING_1`
												   FROM daftar_uji_lp
												   WHERE daftar_uji_lp.NRP='".$frm_nrp."'");
												   
					if ($row_cek_NRP = mysql_fetch_array($result_cek_NRP)) 
					{
						$result_update_daftar_uji_lp = mysql_query("UPDATE daftar_uji_lp set `NO_SK`='$frm_no_SK_LP_now', 
																							 `PEMBIMBING_1`='$frm_dobing1',
																							 `PEMBIMBING_2` ='$frm_dobing2',
																							 `PENGUJI_1` ='$frm_doji1',
																							 `PENGUJI_2` ='$frm_doji2',
																							 `TGLUJI` ='$frm_tgl_ujian',
																							 `RUANG` ='$frm_ruang_ujian'
																					   WHERE `nrp`=$frm_nrp");
						if ($result_update_daftar_uji_lp) 
							{
								//$pesan = $pesan."<br>Data telah diubah";	
							}
							else
							{ 
								$frm_exist=0; 
								$pesan = $pesan."<br>Gagal mengubah data 1- ". mysql_error();
							}	
					}
					else
					{
						$result_insert1 = mysql_query("INSERT INTO daftar_uji_lp (`NRP`,`D_ST`,`NO_SK`,`URUT_SK`,`PEMBIMBING_1`,`PEMBIMBING_2`,`PENGUJI_1`,`PENGUJI_2`,`TGLUJI`,`RUANG`) VALUES ( '".$frm_nrp."', '".$frm_no_ST_LP_mhs."', '".$frm_no_SK_LP_now."', '".$frm_no_urut_SK_LP_terakhir."','".$frm_dobing1."', '".$frm_dobing2."', '".$frm_doji1."', '".$frm_doji2."', '".$frm_tgl_ujian."', '".$frm_ruang_ujian."') " );
						if ($result_insert1) 
							{
								$pesan = $pesan."<br>Data telah diubah";	
							}
							else
							{ 
								$frm_exist=0; 
								$pesan = $pesan."<br>Gagal mengubah data 2- ". mysql_error();
							}
					}
					
	
					//if ($result) 
						//{
							$result_no_surat_LP_now = mysql_query("SELECT `no_surat_lp`.`N_SK`,
																		  `no_surat_lp`.`URUT_SK`
																      FROM no_surat_lp
																     WHERE no_surat_lp.NRP='".$frm_nrp."'");
												
								if ($row_no_surat_LP_now = mysql_fetch_array($result_no_surat_LP_now)) 
								{
										//echo"<br>frm_no_SK_LP_now=".$frm_no_SK_LP_now;
										//echo"<br>frm_no_urut_SK_LP_terakhir=".$frm_no_urut_SK_LP_terakhir;
										if (($row_no_surat_LP_now["URUT_SK"]==0) or ($row_no_surat_LP_now["URUT_SK"]==NULL)) 
										{
										    $result_update1 = mysql_query("UPDATE no_surat_lp set `N_SK`='$frm_no_SK_LP_now', `URUT_SK`=$frm_no_urut_SK_LP_terakhir WHERE `NRP`='$frm_nrp'");
										}
										else
										{
											$result_update1 = mysql_query("UPDATE no_surat_lp set `N_SK`='$frm_no_SK_LP_now' WHERE `NRP`='$frm_nrp'");
										}
										
										if ($result_update1) 
										{
											$pesan = $pesan."<br>Data telah diubah";	
										}
										else
										{ 
											$frm_exist=0; 
											$pesan = $pesan."<br>Gagal mengubah data - ". mysql_error();
										}	
								}
								else
								{
										//belum di update
										$result_update1= mysql_query("INSERT INTO no_surat_lp (`NRP`,`N_ST`,`N_SK`,`URUT_ST`,`URUT_SK`) VALUES ( '".$frm_nrp."', '', '".$frm_no_SK_LP_now."',NULL,".$frm_no_urut_SK_LP_terakhir.")");
										if ($result_update1) 
										{
											$pesan = $pesan."<br>Data telah diubah insert";	
										}
										else
										{ 
											$frm_exist=0; 
											$pesan = $pesan."<br>Gagal mengubah data - ". mysql_error();
										}
								}
						/*}
					else
						{ 
							$frm_exist=0; 
							$pesan = $pesan."<br>Gagal menyimpan data";
						}*/
				}
		}
	}

// HAPUS DATA
if ($act==2) { 
	$result = mysql_query("UPDATE no_surat_lp set `N_SK`='', `URUT_SK`=0 WHERE `NRP`='$frm_nrp'");
	if ($result) 
	{
		$pesan = "data telah dihapus";
			
	}
	else
	{ 
		$pesan = "gagal menghapus data";
	}
}	
	
// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	$frm_nrp = "";
	$frm_no_ST_LP_mhs = "";
	$frm_no_SK_LP_now= "";
	$frm_dobing1 = "";
	$frm_dobing2= "";
	$frm_doji1 = "";
	$frm_doji2 = "";
	$frm_tgl_ujian = "";
	$frm_ruang_ujian = "";
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_nrp!='')  {
	$result = mysql_query("SELECT	master_mhs.NRP,
									master_mhs.NAMA,
									`daftar_uji_lp`.`PEMBIMBING_1`,
									`daftar_uji_lp`.`PEMBIMBING_2`,
									`daftar_uji_lp`.`PENGUJI_1`,
									`daftar_uji_lp`.`PENGUJI_2`,
									 DATE_FORMAT(`daftar_uji_lp`.`TGLUJI`,'%d/%m/%Y') as TGLUJI,
									`daftar_uji_lp`.`RUANG`,
									`no_surat_lp`.N_SK
							 FROM `master_mhs` LEFT JOIN `daftar_uji_lp` ON `master_mhs`.`NRP` = `daftar_uji_lp`.`NRP` 
							       LEFT JOIN no_surat_lp ON daftar_uji_lp.NRP = no_surat_lp.NRP
							WHERE `master_mhs`.`NRP` LIKE '6__2%' AND
								  `master_mhs`.`NRP` =  '".$frm_nrp."'");

					if ($row = mysql_fetch_array($result)) {
						
						$frm_nama = $row["NAMA"];
						//$frm_no_ST_LP_mhs = $row["N_ST"];
						$frm_no_SK_LP_now = $row["N_SK"];
						$frm_dobing1 = $row["PEMBIMBING_1"];
						/*
						if (($frm_dobing1=='')or(!isset($frm_dobing1)))
						{
							$frm_exist=1;
						}
						else
						{
							$frm_exist=0;
						}*/
						$frm_dobing2 = $row["PEMBIMBING_2"];
						$frm_doji1 = $row["PENGUJI_1"];
						$frm_doji2 = $row["PENGUJI_2"];
						$frm_ruang_ujian = $row["RUANG"];

								if (($row["TGLUJI"]=="00/00/0000") or ($row["TGLUJI"]==""))
								{
									$frm_tgl_ujian =""; 
									$frm_exist=0; 
								}
								else 
								{
									$frm_tgl_ujian =$row["TGLUJI"];
								}
						
								$result_no_SK_LP_now = mysql_query("SELECT `no_surat_lp`.`N_ST`,
																		   `no_surat_lp`.`N_SK`,
																		   `no_surat_lp`.`URUT_SK`
																       FROM no_surat_lp
																      WHERE no_surat_lp.NRP='".$frm_nrp."'");
												
								if ($row_no_SK_LP_now = mysql_fetch_array($result_no_SK_LP_now)) {
									$frm_exist=1;
									// cari N_ST, URUT_ST sekarang
									$frm_no_ST_LP_mhs = $row_no_SK_LP_now["N_ST"];
									$frm_no_SK_LP_now =$row_no_SK_LP_now["N_SK"];
									$frm_no_urut_SK_LP_now =$row_no_SK_LP_now["URUT_SK"];
									//echo "frm_no_ST_LP_now=".$frm_no_SK_LP_now;
									//echo "<br>frm_no_ST_LP_mhs=".$frm_no_ST_LP_mhs;
									//exit();
									// cari N_ST, URUT_ST terakhir
									$result_no_SK_LP_akhir = mysql_query("SELECT N_SK, URUT_SK FROM no_surat_lp WHERE N_SK<>'' ORDER BY URUT_SK DESC LIMIT 1");
									$row_no_SK_LP_akhir = mysql_fetch_array($result_no_SK_LP_akhir);
									$frm_no_SK_LP_terakhir = $row_no_SK_LP_akhir["N_SK"];
									$frm_no_urut_SK_LP_terakhir = $row_no_SK_LP_akhir["URUT_SK"];
									
									$frm_no_urut_SK_LP_terakhir++;
								}
								else
								{
									$frm_exist=0; 
									$frm_no_SK_LP_now="";									
									//header("Location: mhs_surat_tugas_LP.php"); 
								}
						
					}
					else
					{
						$error=1;
					    $frm_exist = 0; 
						$frm_nrp = "";
						$frm_nama = "";
						$frm_no_ST_LP_mhs = "";
						$frm_no_SK_LP_now = "";
						$frm_dobing1 = "";
						$frm_dobing2= "";
						$frm_doji1 = "";
						$frm_doji2 = "";
						$frm_tgl_ujian = "";
						$frm_ruang_ujian = "";
						//header("Location: mhs_daftar_penguji_LP.php"); 
					}
}
}

?>
<html>
<head>
<meta http-equiv="Refresh" content="60; URL=mhs_daftar_penguji_LP.php">
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
<? // echo "<br>frm_ok=".$frm_ok;?>
<form name="mhs" id="mhs" action="mhs_daftar_penguji_LP.php" method="post">
  <table width=" 100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
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
              DATA ~</strong>  DAFTAR PENGUJI PENELITIAN</font></font></td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="11%">&nbsp;</td> 
      <td width="18%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="70%"><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" ></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>NRP</td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="7" >
        <span class="style1">*
        <? if (isset($frm_nrp)) echo $frm_nama;?>
      </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Dosen Pembimbing 1 </td>
      <td><strong>:</strong></td>
      <td>
      <select name="frm_dobing1" id="frm_dobing1" class="tekboxku">
        <option <?php if ($frm_dobing1==''){echo "selected";}?> value="">--- Pilih ---</option>
        <?php 
				$sqlDosen="select kode, nama
						   from dosen  where (length(kode)=6) ORDER BY kode ";
				$result_cek = mysql_query("select NRP from master_lp where master_lp.NRP='$frm_nrp'");
				if ($result_cek)
				{
					$sql_kodos1 ="select KODOS1 as kode
						          from master_lp
						          where master_lp.NRP='$frm_nrp'";
				}
				/*else
				{
					$sql_kodos1 ="select kode, nama
						          from dosen, master_ta
						          where master_ta.KODOS1=dosen.kode AND master_ta.NRP='$frm_nrp'";
				}	*/	   
				
				$result = @mysql_query($sqlDosen);
				$result2 = @mysql_query($sql_kodos1);
				$row_result2=@mysql_fetch_object($result2);
				
				//-----
				
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
        <option value="<?php echo $row->kode; ?>" <?php if ($row->kode==$row_result2->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
        <?php } ?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Dosen Pembimbing 2</td>
      <td><strong>:</strong></td>
      <td><select name="frm_dobing2" id="frm_dobing2" class="tekboxku">
        <option <?php if ($frm_dobing2==''){echo "selected";}?> value="">--- Pilih ---</option>
        <?php 
				$sqlDosen="select kode, nama
						   from dosen  where (length(kode)=6) ORDER BY kode";
				$result_cek = mysql_query("select NRP from master_lp where master_lp.NRP='$frm_nrp'");
				if ($result_cek)
				{
					$sql_kodos1 ="select KODOS2 as kode
						          from master_lp
						          where master_lp.NRP='$frm_nrp'";
				}
				
				$result = @mysql_query($sqlDosen);
				$result2 = @mysql_query($sql_kodos1);
				$row_result2=@mysql_fetch_object($result2);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
        <option value="<?php echo $row->kode; ?>" <?php if ($row->kode==$row_result2->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
        <?php }?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Dosen Penguji 1 </td>
      <td><strong>:</strong></td>
      <td><select name="frm_doji1" id="frm_doji1" class="tekboxku">
        <option <?php if ($frm_doji1==''){echo "selected";}?> value="">--- Pilih ---</option>
        <?php 
				$sqlDosen="select kode, nama
						   from dosen where (length(kode)=6) ORDER BY kode";
				
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
        <option value="<?php echo $row->kode; ?>" <?php if ($frm_doji1==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
        <?php }?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Dosen Penguji 2 </td>
      <td><strong>:</strong></td>
      <td><select name="frm_doji2" id="frm_doji2" class="tekboxku">
        <option <?php if ($frm_doji2==''){echo "selected";}?> value="">--- Pilih ---</option>
        <?php 
				$sqlDosen="select kode, nama
						   from dosen where (length(kode)=6) ORDER BY kode";
				
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
        <option value="<?php echo $row->kode; ?>" <?php if ($frm_doji2==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
        <?php }?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tgl. Ujian </td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_ujian" type="text" class="tekboxku" id="frm_tgl_ujian" value="<?php echo $frm_tgl_ujian; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('mhs.frm_tgl_ujian',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
      </A>(dd/mm/yyyy)  <span class="style1">*</span></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>Ruang Ujian </td>
      <td><strong>:</strong></td>
      <td><input name="frm_ruang_ujian" id="frm_ruang_ujian" type="text" class="tekboxku" value="<?php echo $frm_ruang_ujian; ?>" size="10" maxlength="10"></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>No. ST Penelitian</td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_ST_LP_mhs" id="frm_no_ST_LP_mhs" type="text" class="tekboxku" value="<?php echo $frm_no_ST_LP_mhs; ?>" size="10" maxlength="9"></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>No. SK Penguji akhir </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <? 
	  	/*$result_SK_last = mysql_query("SELECT N_SK, URUT_SK from no_surat_lp ORDER BY URUT_SK DESC LIMIT 1");
		$row_SK_last = mysql_fetch_array($result_SK_last);*/
		//echo "<br>frm_no_urut_SK_LP_terakhir=".$frm_no_urut_SK_LP_terakhir;
		//echo "<br>row_SK_last=".$row_SK_last["URUT_SK"];
		
	  ?>
	  <input name="frm_no_SK_LP_terakhir" id="frm_no_SK_LP_terakhir" type="text" class="tekboxku" value="<?php echo $frm_no_SK_LP_terakhir; ?>" size="10" maxlength="9">	  </td>
      <input type="hidden" name="frm_no_urut_SK_LP_terakhir" id="frm_no_urut_SK_LP_terakhir" value="<? echo $frm_no_urut_SK_LP_terakhir;?>">
	  <input type="hidden" name="frm_no_ST_LP_mhs" id="frm_no_ST_LP_mhs" value="<? echo $frm_no_ST_LP_mhs;?>">
	</tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>No. SK Penguji sekarang</td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_SK_LP_now" id="frm_no_SK_LP_now" type="text" class="tekboxku" value="<?php echo $frm_no_SK_LP_now; ?>" size="10" maxlength="9">      </td>
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