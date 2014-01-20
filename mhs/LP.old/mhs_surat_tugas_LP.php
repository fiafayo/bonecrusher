<?php
/* 
   DATE CREATED : 01/08/07
   KEGUNAAN     : ENTRY DATA SURAT TUGAS LP
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
	if ($frm_tgl_pengajuan!='') 
		{
			if (datetomysql($frm_tgl_pengajuan)) 
				{
					$frm_tgl_pengajuan = datetomysql($frm_tgl_pengajuan);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal surat pengajuan LP tidak valid";
				}
		}

	
	if ($frm_tgl_mulai!='') 
		{
			if (datetomysql($frm_tgl_mulai)) 
				{
					$frm_tgl_mulai = datetomysql($frm_tgl_mulai);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal surat mulai LP tidak valid";
				}
		}
		
	if ($frm_tgl_selesai!='') 
		{
			if (datetomysql($frm_tgl_selesai)) 
				{
					$frm_tgl_selesai = datetomysql($frm_tgl_selesai);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal surat selesai LP tidak valid";
				}
		}

// Kode dan nama harus diisi
	//if (($frm_nrp=='') or ($frm_judul_LP=='') or ($frm_dobing1=='') or ($frm_dobing2=='') or ($frm_tgl_pengajuan=='') or ($frm_tgl_mulai=='') or ($frm_tgl_selesai=='') or ($frm_no_ST_LP_now=='') or ($frm_no_ST_LP_last=='')) 
      if (($frm_nrp=='') or ($frm_judul_LP=='') or ($frm_dobing1=='') or ($frm_tgl_pengajuan=='') or ($frm_no_ST_LP_now=='') or ($frm_no_ST_LP_terakhir=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data 'PENELITIAN' dengan lengkap. Gagal menyimpan data.";
		}
//echo "<br>frm_no_urut_ST_LP_terakhir awal=".$frm_no_urut_ST_LP_terakhir;
	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_exist2!=1) 
				{
					/*$result_cek_LP = mysql_query("SELECT `master_lp`.`NRP`
												  FROM  `master_lp`
												  WHERE `master_lp`.`NRP` =  '".$frm_nrp."'");

					if ($row = mysql_fetch_array($result_cek_LP)) `
					{
					*/
							$frm_no_urut_ST_LP_terakhir = $frm_no_urut_ST_LP_terakhir + 1;
							echo "<br>frm_no_urut_ST_LP_terakhir=".$frm_no_urut_ST_LP_terakhir;
							$result = mysql_query("INSERT INTO master_lp (`NRP`,`JUDUL1`,`KODOS1`,`KODOS2`,`TGL_AJU`,`TGL_MULAI`,`TGL_SELESAI`) VALUES ( '".$frm_nrp."', '".$frm_judul_LP."', '".$frm_dobing1."', '".$frm_dobing2."', '".$frm_tgl_pengajuan."','".$frm_tgl_mulai."','".$frm_tgl_selesai."') " );
							if ($result) 
								{
									if ($frm_exist3!=1) 
									{
										$result_insert1= mysql_query("INSERT INTO no_surat_lp (`NRP`,`N_ST`,`N_SK`,`URUT_ST`,`URUT_SK`) VALUES ( '".$frm_nrp."', '".$frm_no_ST_LP_now."', '',".$frm_no_urut_ST_LP_terakhir.",NULL)");
										if ($result_insert1) 
										{
											$pesan = $pesan."<br>Data telah ditambahkan";	
										}
										else
										{ 
											$pesan = $pesan."<br>Gagal menambahkan data";
										}
									}
								}
							else
								{ 
									$pesan = $pesan."<br>Gagal menambahkan data";
								}
					}
				    else
					{
					
					//echo "<br>frm_judul_LP=".$frm_judul_LP;
					//echo "<br>frm_dobing1=".$frm_dobing1;
					//echo "<br>frm_dobing2=".$frm_dobing2;
					//echo "<br>frm_tgl_pengajuan=".$frm_tgl_pengajuan;
					//echo "<br>frm_tgl_mulai=".$frm_tgl_mulai;
					//echo "<br>frm_tgl_selesai=".$frm_tgl_selesai;
					
					$result = mysql_query("UPDATE master_lp set `JUDUL1`='$frm_judul_LP', 
																`KODOS1`='$frm_dobing1',
																`KODOS2` ='$frm_dobing2',
																`TGL_AJU` ='$frm_tgl_pengajuan',
																`TGL_MULAI` ='$frm_tgl_mulai',
																`TGL_SELESAI` ='$frm_tgl_selesai'
														  where `nrp`=$frm_nrp");
	
					if ($result) 
						{
							//echo "<br>frm_no_urut_ST_LP_terakhir=".$frm_no_urut_ST_LP_terakhir;
							//$result_update1 = mysql_query("UPDATE no_surat_lp set `N_ST`='$frm_no_ST_LP_now', `URUT_ST`=$frm_no_urut_ST_LP_terakhir WHERE `NRP`='$frm_nrp'");
							$result_update1 = mysql_query("UPDATE no_surat_lp set `N_ST`='$frm_no_ST_LP_now' WHERE `NRP`='$frm_nrp'");
							if ($result_update1) 
							{
								$pesan = $pesan."<br>Data telah diubah";	
							}
							else
							{ 
								$pesan = $pesan."<br>Gagal mengubah data";
							}	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal mengubah data2";
						}
				}
		}
	}


if ($act==2) { // hapus data

$result = mysql_query("UPDATE no_surat_lp set `N_ST`='', `URUT_ST`=0 WHERE `NRP`='$frm_nrp'");
	if ($result) 
	{
		$pesan = "data telah dihapus";
			
	}else
	{ 
		$pesan = "gagal menghapus data";
	}
}	
	
// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	$frm_exist2=0;
	$frm_exist3=0;
	$frm_nrp= "";
	$frm_nama = "";
	$frm_judul_LP= "";
	$frm_tgl_pengajuan = "";
	$frm_tgl_mulai = "";
	$frm_tgl_selesai = "";
	
	$frm_no_ST_LP_now = "";
	$frm_no_ST_LP_terakhir="";
	$frm_dobing1 = "";
	$frm_dobing2 = "";
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_nrp!='')  {
/*
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
									`master_lp`.`JUDUL1`,
									`master_lp`.`KODOS1`,
									`master_lp`.`KODOS2`,
									`master_lp`.`NILAI`,
									 DATE_FORMAT(`master_lp`.`TGL_AJU`,'%d/%m/%Y') as TGL_AJU,
									 DATE_FORMAT(`master_lp`.`TGL_MULAI`,'%d/%m/%Y') as TGL_MULAI,
									 DATE_FORMAT(`master_lp`.`TGL_SELESAI`,'%d/%m/%Y') as TGL_SELESAI,
									`no_surat_lp`.`N_ST`,
									`no_surat_lp`.`URUT_ST`
							FROM 	`master_mhs`,`master_lp`, no_surat_lp  
							WHERE   `master_mhs`.`NRP` = `master_lp`.`NRP` AND
							        `master_mhs`.`NRP` = `no_surat_lp`.`NRP` AND
									`master_mhs`.`NRP` =  '".$frm_nrp."'");
*/
//echo "frm_nrp=".$frm_nrp;
	$result = mysql_query("SELECT	master_mhs.NRP,
									master_mhs.JURUSAN,
									master_mhs.NAMA
							FROM  `master_mhs`
							WHERE `master_mhs`.`NRP` LIKE  '6__2%' AND
							      `master_mhs`.`NRP` =  '".$frm_nrp."'");

					if ($row = mysql_fetch_array($result)) {
						$frm_exist=1;
						$frm_nama = $row["NAMA"];
						$result_master_LP = mysql_query("SELECT `master_lp`.`JUDUL1`,
															    `master_lp`.`KODOS1`,
															    `master_lp`.`KODOS2`,
															    `master_lp`.`NILAI`,
															     DATE_FORMAT(`master_lp`.`TGL_AJU`,'%d/%m/%Y') as TGL_AJU,
															     DATE_FORMAT(`master_lp`.`TGL_MULAI`,'%d/%m/%Y') as TGL_MULAI,
															     DATE_FORMAT(`master_lp`.`TGL_SELESAI`,'%d/%m/%Y') as TGL_SELESAI
														 FROM master_lp
														 WHERE master_lp.NRP='".$frm_nrp."'");
												
						if ($row_master_LP = mysql_fetch_array($result_master_LP)) {
								$frm_exist2=1;
								//exit();
								//echo "<br>frm_exist1=".$frm_exist1;
								//echo "<br>frm_exist2=".$frm_exist2;
								$frm_judul_LP= $row_master_LP["JUDUL1"];
								
								$frm_dobing1 = $row_master_LP["KODOS1"];
								$frm_dobing2 = $row_master_LP["KODOS2"];
								
								if ($row_master_LP["TGL_AJU"]=="00/00/0000") {
								$frm_tgl_pengajuan =""; }else {
								$frm_tgl_pengajuan =$row_master_LP["TGL_AJU"];}
								
								if ($row_master_LP["TGL_MULAI"]=="00/00/0000") {
								$frm_tgl_mulai =""; }else {
								$frm_tgl_mulai =$row_master_LP["TGL_MULAI"];}
								
								if (($row_master_LP["TGL_SELESAI"]=="00/00/0000") or ($row_master_LP["TGL_SELESAI"]==""))
								{
									$frm_tgl_selesai =""; 
									$frm_exist2=0; 
								}
								else 
								{
									$frm_tgl_selesai =$row_master_LP["TGL_SELESAI"];
								}
								
								$result_no_surat_LP_now = mysql_query("SELECT `no_surat_lp`.`N_ST`,
																		      `no_surat_lp`.`URUT_ST`
																       FROM no_surat_lp
																       WHERE no_surat_lp.NRP='".$frm_nrp."'");
												
								if ($row_no_surat_LP_now = mysql_fetch_array($result_no_surat_LP_now)) {
									$frm_exist3=1;
									// cari N_ST, URUT_ST sekarang
									$frm_no_ST_LP_now =$row_no_surat_LP_now["N_ST"];
									$frm_no_urut_ST_LP_now =$row_no_surat_LP_now["URUT_ST"];
									//echo "frm_no_ST_LP_now=".$frm_no_ST_LP_now;
									//exit();
									// cari N_ST, URUT_ST terakhir
									$result_no_surat_LP_akhir = mysql_query("SELECT N_ST, URUT_ST FROM no_surat_lp WHERE N_ST<>'' ORDER BY URUT_ST DESC LIMIT 1");
									$row_no_surat_LP_akhir = mysql_fetch_array($result_no_surat_LP_akhir);
									$frm_no_ST_LP_terakhir = $row_no_surat_LP_akhir["N_ST"];
									$frm_no_urut_ST_LP_terakhir = $row_no_surat_LP_akhir["URUT_ST"];
									
									$frm_no_urut_ST_LP_terakhir++;
								}
								else
								{
									$frm_exist3=0; 
									$frm_no_ST_LP_now="";									
									//header("Location: mhs_surat_tugas_LP.php"); 
								}
								
						}
						else
						{
							$frm_exist=0; 
							$frm_judul_LP= "";
							$frm_tgl_pengajuan = "";
							$frm_tgl_mulai = "";
							$frm_tgl_selesai = "";
							
							$frm_no_ST_LP_now = "";
							$frm_no_ST_LP_terakhir="";
							$frm_dobing1 = "";
							$frm_dobing2 = "";
							
							//header("Location: mhs_surat_tugas_LP.php"); 
						}
						
						//$frm_judul_LP= $row["JUDUL1"];
						//$frm_no_ST_LP_now =$row["N_ST"];
						
						//$frm_dobing1 = $row["KODOS1"];
						//$frm_dobing2 = $row["KODOS2"];
						
						//if ($row["TGL_AJU"]=="00/00/0000") {
						//$frm_tgl_pengajuan =""; }else {
						//$frm_tgl_pengajuan =$row["TGL_AJU"];}
						
					    //if ($row["TGL_MULAI"]=="00/00/0000") {
						//$frm_tgl_mulai =""; }else {
						//$frm_tgl_mulai =$row["TGL_MULAI"];}
						
						/*if (($row["TGL_SELESAI"]=="00/00/0000") or ($row["TGL_SELESAI"]==""))
						{
							$frm_tgl_selesai =""; 
							$frm_exist=0; 
						}
						else 
						{
							$frm_tgl_selesai =$row["TGL_SELESAI"];
						}*/
						
					}else
					{
						$frm_exist=0; 
						$frm_nrp= "";
						//header("Location: mhs_surat_tugas_LP.php"); 
					}

}
}
//echo "<br>frm_exist1=".$frm_exist1;
//echo "<br>frm_exist2=".$frm_exist2;
//echo "<br>frm_exist3=".$frm_exist3;
//echo "<br>frm_no_urut_ST_LP_terakhir=".$frm_no_urut_ST_LP_terakhir;
?>
<html>
<head>
<meta http-equiv="Refresh" content="60; URL=mhs_surat_tugas_LP.php">
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
<? //echo "<br>frm_no_urut_ST_LP_terakhir awal=".$frm_no_urut_ST_LP_terakhir;?>
<form name="mhs" id="mhs" action="mhs_surat_tugas_LP.php" method="post">
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
              DATA ~</strong> SURAT TUGAS PENELITIAN</font></font></td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="11%">&nbsp;</td> 
      <td width="18%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="70%">
	    <input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" >
	    <input name="frm_exist2" type="hidden" id="frm_exist2"  value="<?php echo $frm_exist2; ?>" >
		<input name="frm_exist3" type="hidden" id="frm_exist3"  value="<?php echo $frm_exist3; ?>" >
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>NRP</td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="10" >
        <span class="style1">*
        <? if (isset($frm_nrp)) echo $frm_nama;?>
      </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top" nowrap> Judul Penelitian</td>
      <td valign="top"><strong>:</strong></td>
      <td valign="top"><textarea name="frm_judul_LP" cols="60" class="tekboxku" id="frm_judul_LP"><?php echo $frm_judul_LP; ?></textarea>
      <span class="style1">* </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Dosen Pembimbing 1 </td>
      <td><strong>:</strong></td>
      <td>
      <select name="frm_dobing1" id="frm_dobing1" class="tekboxku">
        <option <?php if ($frm_dobing1==''){echo "selected";}?>>--- Pilih ---</option>
        <?php 
				$sqlDosen="select kode, nama
						   from dosen  where (length(kode)=6) ORDER BY kode";
				
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
        <option value="<?php echo $row->kode; ?>" <?php if ($frm_dobing1==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
        <?php } ?>
      </select>
        <span class="style1">*</span></td>
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
				
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
        <option value="<?php echo $row->kode; ?>" <?php if ($frm_dobing2==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
        <?php }?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tgl. Pengajuan </td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_pengajuan" type="text" class="tekboxku" id="frm_tgl_pengajuan" value="<?php echo $frm_tgl_pengajuan; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('mhs.frm_tgl_pengajuan',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
      </A>(dd/mm/yyyy)  <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tgl. Mulai</td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_mulai" type="text" class="tekboxku" id="frm_tgl_mulai" value="<?php echo $frm_tgl_mulai; ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('mhs.frm_tgl_mulai',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tgl. Selesai</td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_selesai" type="text" class="tekboxku" id="frm_tgl_selesai" value="<?php echo $frm_tgl_selesai; ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('mhs.frm_tgl_selesai',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)</td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>No. ST Penelitian terakhir </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <? 
	  	$result_ST_last = mysql_query("SELECT N_ST, URUT_ST from no_surat_lp ORDER BY URUT_ST DESC LIMIT 1");
		$row_ST_last = mysql_fetch_array($result_ST_last);
		//echo "frm_no_urut_ST_LP_terakhir= ".$frm_no_urut_ST_LP_terakhir;
	  ?>
	  <input name="frm_no_ST_LP_terakhir" id="frm_no_ST_LP_terakhir" type="text" class="tekboxku" value="<?php echo $row_ST_last['N_ST']; ?>" size="10" maxlength="9" readonly="true">	  </td>
      <input type="hidden" name="frm_no_urut_ST_LP_terakhir" id="frm_no_urut_ST_LP_terakhir" value="<? echo $row_ST_last['URUT_ST'];?>">
	</tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>No. ST Penelitian</td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_ST_LP_now" id="frm_no_ST_LP_now" type="text" class="tekboxku" value="<?php echo $frm_no_ST_LP_now; ?>" size="10" maxlength="9">
        <span class="style1">*</span> </td>
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
			<input type="submit" name="Submit" id="Submit" value="Simpan" onclick="this.form.action+='?act=1';this.form.submit();" class="tombol"> 
			<input type="reset" name="Submit2" id="Submit2" value="Batal" onclick="this.form.action+='?act=3';this.form.submit();" class="tombol"> 
			<?php if ($frm_nama) { ?>
			<input type="button" name="Submit3" id="Submit3" value="Hapus"  onclick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_nama;?>';this.form.submit()};" class="tombol"> 
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