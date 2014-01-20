<?php
/* 
   DATE CREATED : 29/06/07
   KEGUNAAN     : ENTRY DATA PERPANJANG TA
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
require("../../include/temp.php");

f_connecting();
	mysql_select_db($DB);

$act= ( isset( $_REQUEST['act'] ) ) ? $_REQUEST['act'] : 0;
$frm_nama= ( isset( $_REQUEST['frm_nama'] ) ) ? $_REQUEST['frm_nama'] : null;
$frm_nrp= ( isset( $_REQUEST['frm_nrp'] ) ) ? $_REQUEST['frm_nrp'] : null;
$frm_no_urut_ulur_ta_terakhir= ( isset( $_REQUEST['frm_no_urut_ulur_ta_terakhir'] ) ) ? $_REQUEST['frm_no_urut_ulur_ta_terakhir'] : '';
$frm_no_ulur_ta_terakhir= ( isset( $_REQUEST['frm_no_ulur_ta_terakhir'] ) ) ? $_REQUEST['frm_no_ulur_ta_terakhir'] : null;
$frm_no_ulur_ta_now= ( isset( $_REQUEST['frm_no_ulur_ta_now'] ) ) ? $_REQUEST['frm_no_ulur_ta_now'] : null;
$frm_tgl_berakhir= ( isset( $_REQUEST['frm_tgl_berakhir'] ) ) ? $_REQUEST['frm_tgl_berakhir'] : null;
$frm_tgl_aju= ( isset( $_REQUEST['frm_tgl_aju'] ) ) ? $_REQUEST['frm_tgl_aju'] : null;
$frm_tgl_ulur = ( isset( $_REQUEST['frm_tgl_ulur'] ) ) ? $_REQUEST['frm_tgl_ulur'] : null;
$frm_setuju = ( isset( $_REQUEST['frm_setuju'] ) ) ? $_REQUEST['frm_setuju'] : null;
$pesan= ( isset( $_REQUEST['pesan'] ) ) ? $_REQUEST['pesan'] : null;
$error= ( isset( $_REQUEST['error'] ) ) ? $_REQUEST['error'] : null;
        
        
if ($act==1)   
{ // simpan data
	// Pemeriksaan validasi  tanggal yang dimasukkan
	if ($frm_tgl_berakhir!='') 
		{
			if (datetomysql($frm_tgl_berakhir)) 
				{
					$frm_tgl_berakhir = datetomysql($frm_tgl_berakhir);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal masa berakhir TA tidak valid";
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
					$pesan = $pesan."<br> Tanggal pengajuan TA tidak valid";
				}
		}
		
	if ($frm_tgl_ulur!='') 
		{
			if (datetomysql($frm_tgl_ulur)) 
				{
					$frm_tgl_ulur = datetomysql($frm_tgl_ulur);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal perpanjangan TA tidak valid";
				}
		}

// Kode dan nama harus diisi 
	if (($frm_nrp=='') or ($frm_no_ulur_ta_terakhir=='') or ($frm_no_ulur_ta_now=='') or ($frm_setuju=='') or ($frm_tgl_berakhir=='') or ($frm_tgl_aju=='') or ($frm_tgl_ulur=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data 'PERPANJANG TA' dengan lengkap. Gagal menyimpan data !";
			
		}
	
	if (strlen($frm_no_ulur_ta_now) < 9)
	{
		$error = 1;
		$pesan=$pesan."<br>Maaf, Anda harus mengisi No. surat perpanjangan TA dengan benar(harus 9 digit Angka). Gagal menyimpan data !";
	}


	if ($error !=1) // Jika semua isian form valid 
		{
			// data id tidak ada, berarti record baru
			/*echo "insert";
			
			echo "<br>frm_exist=".$frm_exist;
			echo "<br>error=".$error;
			echo "<br>frm_no_urut_ulur_ta_terakhir=".$frm_no_urut_ulur_ta_terakhir;
			echo "<br>frm_tgl_berakhir=".$frm_tgl_berakhir;
			echo "<br>frm_tgl_aju=".$frm_tgl_aju;
			echo "<br>frm_tgl_ulur=".$frm_tgl_ulur;
			echo "<br>frm_no_ulur_ta_now=".$frm_no_ulur_ta_now;*/
			
			//begin
			if ($frm_exist!=1) 
				{
					//echo "HERE INSERT";
					//exit();
					$result_cek_perpanjangTA = mysql_query("SELECT `perpanjang_ta`.`NRP` FROM perpanjang_ta WHERE `perpanjang_ta`.`NRP`='".$frm_nrp."'");
					$row_result_cek_perpanjangTA = mysql_num_rows($result_cek_perpanjangTA);
					
					//begin tttttt
					if ($row_result_cek_perpanjangTA <1)
					{
					
								//begin xxxx
								$result = mysql_query("INSERT INTO perpanjang_ta (`nrp`, `tgl_berakhir`, `tgl_aju` ,`tgl_ulur`, `disetujui`, `no_ulur_ta`) VALUES ( '".$frm_nrp."', '".$frm_tgl_berakhir."', '".$frm_tgl_aju."', '".$frm_tgl_ulur."', '".$frm_setuju."', '".$frm_no_ulur_ta_now."') " );
								if ($result) 
								{
												$result_cek = mysql_query("SELECT `no_surat`.`NRP` FROM no_surat WHERE `no_surat`.`NRP`='".$frm_nrp."'");
												$row_result_cek = mysql_num_rows($result_cek);
												$frm_no_urut_ulur_ta_terakhir++;
												//echo "<br>row_result_cek=".$row_result_cek;
												//echo "<br>frm_no_urut_ulur_ta_terakhir=".$frm_no_urut_ulur_ta_terakhir;
												//exit();
									
												//begin qqqqq
												if ($row_result_cek <1)
												{
													$result_insert1= mysql_query("INSERT INTO no_surat (`NRP`,`N_SKDP`,`N_ST`,`N_SK`,`N_ULUR`,`N_GANDOS`,`N_GANDUL`,`N_urut_SK`,`N_undangan`,`N_urut_ST`,`N_urut_gandul`,`N_urut_gandos`,`N_urut_ulur`,`N_urut_undangan`) VALUES ( '".$frm_nrp."', '', '', '', '".$frm_no_ulur_ta_now."', '', '',NULL,'',NULL,NULL,NULL,".$frm_no_urut_ulur_ta_terakhir.",NULL)");
													if ($result_insert1)
													{
														$pesan = $pesan."<br>Proses entry data BERHASIL 1";
													}
													else
													{
														$error = 1;
														$pesan = $pesan."<br>Proses entry data GAGAL". mysql_error();
													}
												}
												else
												{
													$result_update1 = mysql_query("UPDATE no_surat set `N_ULUR`='$frm_no_ulur_ta_now', `N_urut_ulur`='$frm_no_urut_ulur_ta_terakhir' WHERE `NRP`='$frm_nrp'");
													if ($result_update1)
													{
														$pesan = $pesan."<br>Proses update data BERHASIL";
													}
													else
													{
														$error = 1;
														$pesan = $pesan."<br>Proses update data GAGAL";
													}
												}
												// end qqqqq
									
							
									}
									else
									{ 
										$error = 1;
										$pesan = $pesan."<br>Proses entry data GAGAL";
									}
									// end xxxxx
							
					
						}
					else
						{
						//echo "<br> #### HERE UPDATE 1";
						//exit();
							$result = mysql_query("UPDATE perpanjang_ta set `tgl_berakhir`='$frm_tgl_berakhir', `tgl_aju`='$frm_tgl_aju', `tgl_ulur` ='$frm_tgl_ulur', `disetujui`='$frm_setuju', `no_ulur_ta`='$frm_no_ulur_ta_now' WHERE `NRP`='$frm_nrp'");
							$result = mysql_query("UPDATE no_surat set `n_ulur`='$frm_no_ulur_ta_now' WHERE `NRP`='$frm_nrp'");
							if ($result) 
								{
									$pesan = $pesan."<br>Proses update data BERHASIL";	
								}
							else
								{ 
									$error = 1;
									$pesan = $pesan."<br>Proses update data GAGAL";
								}
						}
					//end ttttt 
			
			}
			else
			{
			//echo "<br> #### HERE UPDATE 2";
			//exit();
				$result = mysql_query("UPDATE perpanjang_ta set `tgl_berakhir`='$frm_tgl_berakhir', `tgl_aju`='$frm_tgl_aju', `tgl_ulur` ='$frm_tgl_ulur', `disetujui`='$frm_setuju', `no_ulur_ta`='$frm_no_ulur_ta_now' WHERE `NRP`='$frm_nrp'");
				$result = mysql_query("UPDATE no_surat set `n_ulur`='$frm_no_ulur_ta_now' WHERE `NRP`='$frm_nrp'");
				if ($result) 
				{
					$pesan = $pesan."<br>Proses update data BERHASIL";	
				}
				else
				{ 
					$error = 1;
					$pesan = $pesan."<br>Proses update data GAGAL";
				}
			}
			
		}
		
}


if ($act==2) { // hapus data
$result_delete = mysql_query("delete from perpanjang_ta where nrp = ".$frm_nrp);
$result_delete = mysql_query("UPDATE no_surat set `N_ULUR`='', N_urut_ulur=0 WHERE `NRP`='$frm_nrp'");

	if ($result_delete) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
// Jika data sudah dimasukan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	//$frm_exist = 0;
	$frm_nrp = "";
	$frm_nama = "";
	$frm_setuju = "";
	$frm_tgl_berakhir = "";
	$frm_tgl_aju = "";
	$frm_tgl_ulur = "";
	$frm_no_ulur_ta_terakhir = "";
	$frm_no_ulur_ta_now = "";
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_nrp!='')  {
//echo "<br>frm_nrp=".$frm_nrp;
/*$result = mysql_query("SELECT	master_mhs.NRP,
								master_mhs.NAMA,
								 DATE_FORMAT(`perpanjang_ta`.`tgl_berakhir`,'%d/%m/%Y') as tgl_berakhir,
								 DATE_FORMAT(`perpanjang_ta`.`tgl_aju`,'%d/%m/%Y') as tgl_aju,
								 DATE_FORMAT(`perpanjang_ta`.`tgl_ulur`,'%d/%m/%Y') as tgl_ulur,
								`perpanjang_ta`.`disetujui`
							FROM
								`master_mhs` LEFT JOIN `perpanjang_ta` ON `master_mhs`.`NRP` = `perpanjang_ta`.`NRP`
							WHERE
								`master_mhs`.`NRP` =  '".$frm_nrp."'");*/

$result = mysql_query("SELECT master_mhs.NRP,
							  master_mhs.NAMA,
							  DATE_FORMAT(`perpanjang_ta`.`tgl_berakhir`,'%d/%m/%Y') as tgl_berakhir,
							  DATE_FORMAT(`perpanjang_ta`.`tgl_aju`,'%d/%m/%Y') as tgl_aju,
							  DATE_FORMAT(`perpanjang_ta`.`tgl_ulur`,'%d/%m/%Y') as tgl_ulur,
							  `perpanjang_ta`.`disetujui`
						 FROM `master_mhs`, `perpanjang_ta` 
						WHERE (`master_mhs`.`NRP` = `perpanjang_ta`.`NRP`) AND
							  (`master_mhs`.`NRP` =  '".$frm_nrp."')");
								
							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_nama = $row["NAMA"];
								$frm_setuju = $row["disetujui"];
								/*
								$result_ulur_akhir = mysql_query("SELECT N_ULUR as ulur_akhir, N_urut_ulur FROM no_surat WHERE N_ULUR<>'' ORDER BY N_urut_ulur DESC LIMIT 1");
								$row_ulur_akhir = mysql_fetch_array($result_ulur_akhir);
								$frm_no_ulur_ta_terakhir = $row_ulur_akhir["ulur_akhir"];
								$frm_no_urut_ulur_ta_terakhir = $row_ulur_akhir["N_urut_ulur"];
								*/
								
								//echo "frm_no_urut_ulur_ta_terakhir=".$frm_no_urut_ulur_ta_terakhir;
								//exit();
								
								$result_ulur_now = mysql_query("SELECT n_ulur as ulur_now FROM no_surat WHERE `no_surat`.`NRP`='".$frm_nrp."'");
								$row_ulur_now = mysql_fetch_array($result_ulur_now);
								$frm_no_ulur_ta_now = $row_ulur_now["ulur_now"];
								
								$frm_tgl_berakhir = $row["tgl_berakhir"];
								if ($row["tgl_berakhir"]=="00/00/0000") {
								$frm_tgl_berakhir = ""; }else {
								$frm_tgl_berakhir = $row["tgl_berakhir"];}
								
								$frm_tgl_aju = $row["tgl_aju"];
								if ($row["tgl_aju"]=="00/00/0000") {
								$frm_tgl_aju = ""; }else {
								$frm_tgl_aju = $row["tgl_aju"];}
								
								$frm_tgl_ulur = $row["tgl_ulur"];
								if (($row["tgl_ulur"]=="00/00/0000") or ($row["tgl_ulur"]=="")) 
								{
									$frm_tgl_ulur = ""; 
									$frm_exist = 0;
								}
								else 
								{
									$frm_tgl_ulur = $row["tgl_ulur"];
								}
								
									/*echo "<br>2.frm_exist=".$frm_exist;
									echo "<br>2.error=".$error;
									echo "<br>2.frm_no_urut_ulur_ta_terakhir=".$frm_no_urut_ulur_ta_terakhir;
									echo "<br>2.frm_tgl_berakhir=".$frm_tgl_berakhir;
									echo "<br>2.frm_tgl_aju=".$frm_tgl_aju;
									echo "<br>2.frm_tgl_ulur=".$frm_tgl_ulur;
									echo "<br>frm_no_ulur_ta_now=".$frm_no_ulur_ta_now;*/
									
							}
							else
							{ 
								$frm_exist=0; //header("Location: mhs_perpanjangan_ta.php"); 
							}
}
}

?>
<html>
<head>
<meta http-equiv="RefreshDisabled" content="60; URL=mhs_perpanjangan_ta.php">

<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<script language="JavaScript" src="../../include/tanggalan.js">
</script>
<script language="javascript">

var no_ulur_filter=/^\d{9}$/

function cek_no_ULUR(e){
var returnval=no_ulur_filter.test(e.value)
if (returnval==false){
alert("Silahkan, Masukkan No Perpanjangan TA dengan benar(harus 9 digit Angka).")
e.select()
e.focus()
}
return returnval
}

</script>
<SCRIPT language="JavaScript1.2" src="../../include/main.js" type="text/javascript"></SCRIPT>
<body class="body">
<DIV id="TipLayer" style="visibility:hidden;position:absolute;z-index:1000;top:-100;"></DIV>
 <SCRIPT language="JavaScript1.2" src="../../include/style.js" type="text/javascript"></SCRIPT> 

<form name="mhs_perpanjang_ta" id="mhs_perpanjang_ta" action="mhs_perpanjangan_ta.php" method="post">
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
              DATA ~</strong>  PERPANJANGAN TA</font></font> </td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="15%">&nbsp;</td> 
      <td width="15%">&nbsp;</td>
      <td width="3%">&nbsp;</td>
      <td width="83%"><?php //echo "frm_exist=".$frm_exist; ?><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" ></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>NRP</td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="document.mhs_perpanjang_ta.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="10" >
        <span class="style1" id="nama">*
        <? if (isset($frm_nrp)) echo $frm_nama;?>
        </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>No. surat perpanjangan TA terakhir</td>
      <td><strong>:</strong></td>
      <td><? //echo "frm_no_urut_ulur_ta_terakhir=".$frm_no_urut_ulur_ta_terakhir;
			$result_ulur_akhir = mysql_query("SELECT N_ULUR as ulur_akhir, N_urut_ulur FROM no_surat WHERE N_ULUR<>'' ORDER BY N_urut_ulur DESC LIMIT 1");
			$row_ulur_akhir = mysql_fetch_array($result_ulur_akhir);
			$frm_no_ulur_ta_terakhir = $row_ulur_akhir["ulur_akhir"];
			$frm_no_urut_ulur_ta_terakhir = $row_ulur_akhir["N_urut_ulur"];
	  ?>
	  <input type="hidden" name="frm_no_urut_ulur_ta_terakhir" id="frm_no_urut_ulur_ta_terakhir" value="<? echo $frm_no_urut_ulur_ta_terakhir;?>">
	  <input name="frm_no_ulur_ta_terakhir" type="text" class="tekboxku" id="frm_no_ulur_ta_terakhir" value="<?php echo $frm_no_ulur_ta_terakhir; ?>" size="15" maxlength="9">
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>No. surat perpanjangan TA </td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_ulur_ta_now" onBlur="return cek_no_ULUR(this.form.frm_no_ulur_ta_now)" onMouseOver="stm(Text[1],Style[12])" onMouseOut="htm()" type="text" class="tekboxku" id="frm_no_ulur_ta_now" value="<?php echo $frm_no_ulur_ta_now; ?>" size="15" maxlength="9">
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tanggal Berakhir </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <?
			$result_akhir_ta = mysql_query("SELECT DATE_FORMAT(`master_ta`.`AKHIR1`,'%d/%m/%Y') as TGL_AKHIR
											  FROM master_ta 
											 WHERE master_ta.NRP='".$frm_nrp."'");
			$row_akhir_ta = mysql_fetch_array($result_akhir_ta);
			$frm_tgl_berakhir = $row_akhir_ta["TGL_AKHIR"];
	  ?>
	  <input name="frm_tgl_berakhir" type="text" class="tekboxku" id="frm_tgl_berakhir" value="<?php echo $frm_tgl_berakhir; ?>" size="10" maxlength="10">
	  <A Href="javascript:show_calendar('mhs_perpanjang_ta.frm_tgl_berakhir',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)
      <span class="style1">*</span> </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>Tanggal Mengajukan </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_aju" type="text" class="tekboxku" id="frm_tgl_aju" value="<?php echo $frm_tgl_aju; ?>" size="10" maxlength="10">
	   <A Href="javascript:show_calendar('mhs_perpanjang_ta.frm_tgl_aju',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)	 <span class="style1">*</span> </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Diperpanjang sampai dengan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_ulur" type="text" class="tekboxku" id="frm_tgl_ulur" value="<?php echo $frm_tgl_ulur; ?>" size="10" maxlength="10">
	  <A Href="javascript:show_calendar('mhs_perpanjang_ta.frm_tgl_ulur',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)
      <span class="style1">*</span> </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>Persetujuan(Ya/Tidak)</td>
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
        </select> <span class="style1">*</span>
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
        <?php if ($frm_tgl_berakhir) { ?>
        <input type="button" name="Submit3" value="Hapus"  onclick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_tgl_berakhir;?>';this.form.submit()};" class="tombol"> 
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