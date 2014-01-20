<?php
/* 
   DATE CREATED : 30/05/07
   UPDATE       : 04/02/09 - penambahan jumlah mhs kp (total 6)
   				  17/06/09 - penambahan jumlah mhs kp (total 8)
   KEGUNAAN     : ENTRY PERMINTAAN NILAI KP
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ // simpan data
	// VALIDASI tanggal yang dimasukkan
	if ($frm_tgl_surat_mohon!='') 
		{
			if (datetomysql($frm_tgl_surat_mohon)) 
				{
					$frm_tgl_surat_mohon = datetomysql($frm_tgl_surat_mohon);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal Surat Permohonan tidak valid";
				}
		}

	if ($frm_tgl_SPN!='') 
		{
			if (datetomysql($frm_tgl_SPN)) 
				{
					$frm_tgl_SPN = datetomysql($frm_tgl_SPN);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal Surat Pengantar Nilai tidak valid";
				}
		}
		
	if ($frm_tgl_ST_KP!='') 
		{
			if (datetomysql($frm_tgl_ST_KP)) 
				{
					$frm_tgl_ST_KP = datetomysql($frm_tgl_ST_KP);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal Surat Tugas KP tidak valid";
				}
		}

// Form harus diisi 
/*echo "<br>frm_nrp= ".$frm_nrp;
echo "<br>frm_no_ST_KP= ".$frm_no_ST_KP;
echo "<br>frm_tgl_ST_KP= ".$frm_tgl_ST_KP;
echo "<br>frm_no_surat_mohon= ".$frm_no_surat_mohon;
echo "<br>frm_tgl_surat_mohon= ".$frm_tgl_surat_mohon;
echo "<br>frm_no_SPN= ".$frm_no_SPN;
echo "<br>frm_tgl_SPN= ".$frm_tgl_SPN;
echo "<br>frm_kode_dobing= ".$frm_kode_dobing;
echo "<br>frm_nama_bingUsaha= ".$frm_nama_bingUsaha;*/

	if (($frm_nrp=='') or ($frm_no_ST_KP=='') or ($frm_tgl_ST_KP=='') or ($frm_no_surat_mohon=='') or ($frm_tgl_surat_mohon=='') or ($frm_no_SPN=='') or ($frm_tgl_SPN=='') or ($frm_kode_dobing=='') or ($frm_nama_bingUsaha=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi data dengan lengkap. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
				$result = mysql_query("UPDATE daftar_kp set `NO_NKP`='$frm_no_SPN',
															`UR_NKP`='$frm_no_urut_NKP_terakhir',
															`TGL_NKP`='$frm_tgl_SPN',
															`STATUS`='S1'
													  where `NO_ST`=$frm_no_ST_KP");
				if ($result) 
					{
						$pesan = $pesan."<br>Proses entry data BERHASIL";	
					}
				else
					{ 
						$pesan = $pesan."<br>Proses entry data GAGAL";
					}
	
		}
	}


if ($act==2) { // hapus data

				$result = mysql_query("UPDATE daftar_kp set `NO_NKP`='',
															`TGL_NKP`='',
															`STATUS`=''
													  where `NO_ST`=$frm_no_ST_KP");
				if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
	
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	$frm_nrp='';
	$frm_nrp2='';
	$frm_nrp3='';
	$frm_nrp4='';
	$frm_nrp5='';
	$frm_nrp6='';
	$frm_nrp7='';
	$frm_nrp8='';
	$frm_nama_mhs='';
	$frm_nama_mhs2='';
	$frm_nama_mhs3='';
	$frm_nama_mhs4='';
	$frm_nama_mhs5='';
	$frm_nama_mhs6='';
	$frm_nama_mhs7='';
	$frm_nama_mhs8='';
	
	//$frm_no_ST_KP = "";
	$frm_tgl_ST_KP ="";
	
	$frm_no_surat_mohon = "";
	$frm_tgl_surat_mohon = "";
	
	$frm_no_SPN = "";
	$frm_tgl_SPN = "";
	
	$frm_kode_dobing = "";
	$frm_nama_bingUsaha =""; 
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_no_ST_KP!='')  {
$result = mysql_query("SELECT	`daftar_kp`.`NO_MOHON`,
								`daftar_kp`.`UR_MOHON`,
								`daftar_kp`.`KODE_KP`,
								`daftar_kp`.`NRP_1`,
								`daftar_kp`.`NRP_2`,
								`daftar_kp`.`NRP_3`,
								`daftar_kp`.`NRP_4`,
								`daftar_kp`.`NRP_5`,
								`daftar_kp`.`NRP_6`,
								`daftar_kp`.`NRP_7`,
								`daftar_kp`.`NRP_8`,
								`daftar_kp`.`NA_PERUSH`,
								`daftar_kp`.`JALAN`,
								`daftar_kp`.`KOTA`,
								 DATE_FORMAT(`daftar_kp`.`TGL_AWAL`,'%d/%m/%Y') as TGL_AWAL,
								 DATE_FORMAT(`daftar_kp`.`TGL_END`,'%d/%m/%Y') as TGL_END,
								 DATE_FORMAT(`daftar_kp`.`TGL_MOHON`,'%d/%m/%Y') as TGL_MOHON,
								`daftar_kp`.`NO_ST`,
								`daftar_kp`.`UR_ST`,
								`daftar_kp`.`DOSEN`,
								`daftar_kp`.`PEM_PERUS`,
								 DATE_FORMAT(`daftar_kp`.`TGL_ST`,'%d/%m/%Y') as TGL_ST,
								`daftar_kp`.`NO_NKP`,
								`daftar_kp`.`UR_NKP`,
								 DATE_FORMAT(`daftar_kp`.`TGL_NKP`,'%d/%m/%Y') as TGL_NKP,
								`daftar_kp`.`HONOR`,
								`daftar_kp`.`STATUS`
							FROM daftar_kp 
							WHERE `daftar_kp`.`NO_ST` = '".$frm_no_ST_KP."'");
				
							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1; 
								$frm_nrp  = $row["NRP_1"];
								$frm_nrp2 = $row["NRP_2"];
								$frm_nrp3 = $row["NRP_3"];
								$frm_nrp4 = $row["NRP_4"];
								$frm_nrp5 = $row["NRP_5"];
								$frm_nrp6 = $row["NRP_6"];
								$frm_nrp7 = $row["NRP_7"];
								$frm_nrp8 = $row["NRP_8"];
								
								$frm_no_ST_KP = $row["NO_ST"];
								$frm_no_surat_mohon = $row["NO_MOHON"];
								$frm_no_SPN = $row["NO_NKP"];
								$frm_urut_no_SPN = $row["UR_NKP"];

								$frm_kode_dobing = $row["DOSEN"];
								$frm_nama_bingUsaha = $row["PEM_PERUS"];
								
								if ($row["TGL_ST"]=="00/00/0000") {
								$frm_tgl_ST_KP =""; }else {
								$frm_tgl_ST_KP =$row["TGL_ST"];}
								
								if ($row["TGL_MOHON"]=="00/00/0000") {
								$frm_tgl_surat_mohon =""; }else {
								$frm_tgl_surat_mohon =$row["TGL_MOHON"]; }
								
								if ($row["TGL_NKP"]=="00/00/0000") {
								$frm_tgl_SPN =""; }else {
								$frm_tgl_SPN =$row["TGL_NKP"]; }
								
								// cari URUT NO_NKP, UR_NKP
								$result_no_NKP_akhir = mysql_query("SELECT NO_NKP, UR_NKP FROM daftar_kp WHERE NO_NKP<>'' ORDER BY UR_NKP DESC LIMIT 1");
								$row_no_NKP_akhir = mysql_fetch_array($result_no_NKP_akhir);
								$frm_no_NKP_terakhir = $row_no_NKP_akhir["NO_NKP"];
								$frm_no_urut_NKP_terakhir = $row_no_NKP_akhir["UR_NKP"];
								
								if ($frm_urut_no_SPN==0) {$frm_no_urut_NKP_terakhir++;} else{$frm_no_urut_NKP_terakhir;}
									
							}else
							{
								$frm_exist=0; 
								$frm_nrp='';
								$frm_nrp2='';
								$frm_nrp3='';
								$frm_nrp4='';
								$frm_nrp5='';
								$frm_nrp6='';
								$frm_nrp7='';
								$frm_nrp8='';
								$frm_nama_mhs='';
								$frm_nama_mhs2='';
								$frm_nama_mhs3='';
								$frm_nama_mhs4='';
								$frm_nama_mhs5='';
								$frm_nama_mhs6='';
								$frm_nama_mhs7='';
								$frm_nama_mhs8='';
								//$frm_no_ST_KP = "";
								$frm_tgl_ST_KP ="";
								$frm_no_surat_mohon = "";
								$frm_tgl_surat_mohon = "";
								$frm_no_SPN = "";
								$frm_tgl_SPN = "";
								$frm_kode_dobing = "";
								$frm_nama_bingUsaha =""; 
							}
}

							if ($frm_nrp!='') {
									$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp'");
									$row = mysql_fetch_array($result);
									$frm_nama_mhs = $row["nama"];
							}	
							
							if ($frm_nrp2!='') {
									$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp2'");
									$row = mysql_fetch_array($result);
									$frm_nama_mhs2 = $row["nama"];
							}	
							
							if ($frm_nrp3!='') {
									$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp3'");
									$row = mysql_fetch_array($result);
									$frm_nama_mhs3 = $row["nama"];
							}	
							
							if ($frm_nrp4!='') {
									$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp4'");
									$row = mysql_fetch_array($result);
									$frm_nama_mhs4 = $row["nama"];
							}	
							
							if ($frm_nrp5!='') {
									$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp5'");
									$row = mysql_fetch_array($result);
									$frm_nama_mhs5 = $row["nama"];
							}	

							if ($frm_nrp6!='') {
									$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp6'");
									$row = mysql_fetch_array($result);
									$frm_nama_mhs6 = $row["nama"];
							}	

							if ($frm_nrp7!='') {
									$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp7'");
									$row = mysql_fetch_array($result);
									$frm_nama_mhs7 = $row["nama"];
							}	

							if ($frm_nrp8!='') {
									$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp8'");
									$row = mysql_fetch_array($result);
									$frm_nama_mhs8 = $row["nama"];
							}	
							if ($frm_kode_dobing!='') {
									$result = mysql_query("Select nama from dosen where kode='$frm_kode_dobing'");
									$row = mysql_fetch_array($result);
									$frm_nama_dosen = $row["nama"];
							}

}

?>
<html>
<head>
<meta http-equiv="Refresh" content="300; URL=mhs_nilai_KP.php">
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

var no_spn_filter=/^\d{9}$/

function cek_SPN(e){
var returnval=no_spn_filter.test(e.value)
if (returnval==false){
alert("Nomor SP Nilai, harus 9 digit")
e.select()
e.focus()
}
return returnval
}

</script>
<SCRIPT language="JavaScript1.2" src="../../include/main.js" type="text/javascript"></SCRIPT>  
</head>
<body class="body">
<DIV id="TipLayer" style="visibility:hidden;position:absolute;z-index:1000;top:-100;"></DIV>
 <SCRIPT language="JavaScript1.2" src="../../include/style.js" type="text/javascript"></SCRIPT> 
 
<form name="mhs" action="mhs_nilai_KP.php" method="post">
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
              DATA ~</strong> PROSES PERMINTAAN NILAI KP</font></font></td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="11%">&nbsp;</td> 
      <td width="17%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="71%"><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" ></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap> No. 


 Surat Tugas</td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_ST_KP" type="text" class="tekboxku" id="frm_no_ST_KP" onBlur="document.mhs.submit()" value="<?php echo $frm_no_ST_KP;?>" size="10" maxlength="10">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tgl. Surat Tugas</td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_ST_KP" type="text" class="tekboxku" id="frm_tgl_ST_KP" value="<?php echo $frm_tgl_ST_KP; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('mhs.frm_tgl_ST_KP',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
      </A>(dd/mm/yyyy)  <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>No. Surat Permohonan</td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_surat_mohon" type="text" class="tekboxku" id="frm_no_surat_mohon" onBlur="document.mhs.submit()" value="<?php echo $frm_no_surat_mohon; ?>" size="10" maxlength="10" >
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tgl. Surat Permohonan</td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_surat_mohon" type="text" class="tekboxku" id="frm_tgl_surat_mohon" value="<?php echo $frm_tgl_surat_mohon; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('mhs.frm_tgl_surat_mohon',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
      </A>(dd/mm/yyyy)  <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>No. Surat Pengantar Nilai terakhir </td>
      <td><strong>:</strong></td>
      <td>
	  <?
			$result_no_NKP_akhir = mysql_query("SELECT NO_NKP, UR_NKP FROM daftar_kp WHERE NO_NKP<>'' ORDER BY UR_NKP DESC LIMIT 1");
			$row_no_NKP_akhir = mysql_fetch_array($result_no_NKP_akhir);
			$frm_no_NKP_terakhir = $row_no_NKP_akhir["NO_NKP"];
			$frm_no_urut_NKP_terakhir = $row_no_NKP_akhir["UR_NKP"];
			
			if ($frm_urut_no_SPN==0) {$frm_no_urut_NKP_terakhir++;} else{$frm_no_urut_NKP_terakhir;}
	  
	  ?>
	  <input name="frm_no_NKP_terakhir" type="text" class="tekboxku" id="frm_no_NKP_terakhir" value="<?php echo $frm_no_NKP_terakhir; ?>" size="10" maxlength="10" readonly="true">
        <span class="style1">*</span>
	      <input type="hidden" name="frm_no_urut_NKP_terakhir" id="frm_no_urut_NKP_terakhir" value="<? echo $frm_no_urut_NKP_terakhir;?>">
		</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>No. Surat Pengantar Nilai</td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_SPN" type="text" class="tekboxku" onBlur="return cek_SPN(this.form.frm_no_SPN)" onMouseOver="stm(Text[12],Style[12])" onMouseOut="htm()" id="frm_no_SPN" value="<?php echo $frm_no_SPN; ?>" size="10" maxlength="9" >
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tgl. Surat Pengantar Nilai</td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_SPN" type="text" class="tekboxku" id="frm_tgl_SPN" value="<?php echo $frm_tgl_SPN; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('mhs.frm_tgl_SPN',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
      </A>(dd/mm/yyyy)  <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>NRP 1 </td>
      <td width="1%"><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="10" >
        <span class="style1">* <? if (isset($frm_nrp)) echo $frm_nama_mhs;?></span></td>
    </tr>
	<? if ($frm_nrp2<>"") {?>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>NRP 2 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp2" type="text" class="tekboxku" id="frm_nrp2" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp2; ?>" size="10" maxlength="10" >
        <span class="style1">*
        <? if (isset($frm_nrp2)) echo $frm_nama_mhs2;?>
      </span></td>
    </tr>
	<? }
	if ($frm_nrp3<>"") {?>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>NRP 3 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp3" type="text" class="tekboxku" id="frm_nrp3" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp3; ?>" size="10" maxlength="10" >
        <span class="style1">*
        <? if (isset($frm_nrp3)) echo $frm_nama_mhs3;?>
      </span></td>
    </tr>
	<? }
	if ($frm_nrp4<>"") {?>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>NRP 4 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp4" type="text" class="tekboxku" id="frm_nrp4" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp4; ?>" size="10" maxlength="10" >
        <span class="style1">*
        <? if (isset($frm_nrp4)) echo $frm_nama_mhs4;?>
      </span></td>
    </tr>
	<? }
	if ($frm_nrp5<>"") {?>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>NRP 5 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp5" type="text" class="tekboxku" id="frm_nrp5" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp5; ?>" size="10" maxlength="10" >
        <span class="style1">*
        <? if (isset($frm_nrp5)) echo $frm_nama_mhs5;?>
      </span></td>
    </tr>
	<? }
	if ($frm_nrp6<>"") {?>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>NRP 6 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp6" type="text" class="tekboxku" id="frm_nrp6" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp6; ?>" size="10" maxlength="10" >
        <span class="style1">*
        <? if (isset($frm_nrp6)) echo $frm_nama_mhs6;?>
      </span></td>
    </tr>
	<? }
	if ($frm_nrp7<>"") {?>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>NRP 7 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp7" type="text" class="tekboxku" id="frm_nrp7" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp7; ?>" size="10" maxlength="10" >
        <span class="style1">*
        <? if (isset($frm_nrp7)) echo $frm_nama_mhs7;?>
      </span></td>
    </tr>
	<? }
	if ($frm_nrp8<>"") {?>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>NRP 8 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp8" type="text" class="tekboxku" id="frm_nrp8" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp8; ?>" size="10" maxlength="10" >
        <span class="style1">*
        <? if (isset($frm_nrp8)) echo $frm_nama_mhs8;?>
      </span></td>
    </tr>
	<? }?>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>NPK Dosen Pembimbing</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_kode_dobing" id="frm_kode_dobing" type="text" class="tekboxku" value="<?php echo $frm_kode_dobing; ?>" size="10" maxlength="10">
        <span class="style1">* 
        <? if (isset($frm_kode_dobing)) echo $frm_nama_dosen;?>
        </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td nowrap>Nama Pembimbing Perusahaan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nama_bingUsaha" id="frm_nama_bingUsaha" type="text" class="tekboxku" value="<?php echo $frm_nama_bingUsaha; ?>" size="50" maxlength="50">
        <span class="style1">*</span></td>
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
        <?php if ($frm_no_ST_KP) { ?>
        <input type="button" name="Submit3" value="Hapus"  onclick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_no_ST_KP;?>';this.form.submit()};" class="tombol"> 
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