<?php
/* 
   DATE CREATED : 01/08/07
   UPDATE       : 04/02/09 - penambahan jumlah mhs kp (total 6)
                  17/06/09 - penambahan jumlah mhs kp (total 8)
   KEGUNAAN     : ENTRY DATA PERMOHONAN KP
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ // simpan data
	// cek tanggal, apakah tanggal yang dimasukkan valid
		if ($frm_tgl_selesai_KP!='') 
		{
			if (datetomysql($frm_tgl_selesai_KP)) 
				{
					$frm_tgl_selesai_KP = datetomysql($frm_tgl_selesai_KP);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal selesai KP tidak valid";
				}
		}
	
		if ($frm_tgl_mulai_KP!='') 
		{
			if (datetomysql($frm_tgl_mulai_KP)) 
				{
					$frm_tgl_mulai_KP = datetomysql($frm_tgl_mulai_KP);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal mulai KP tidak valid";
				}
		}

		if ($frm_tgl_mohon_KP!='') 
		{
			if (datetomysql($frm_tgl_mohon_KP)) 
				{
					$frm_tgl_mohon_KP = datetomysql($frm_tgl_mohon_KP);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal surat permohonan KP tidak valid";
				}
		}
		
		if (strlen($frm_no_surat_pemohon)!=9) 
		{
			
					$error = 1;
					$pesan = $pesan."<br> Nomor surat permohonan KP harus 9 digit";
		}
		
		

// Form harus diisi  
		if (($frm_no_mohonKP_terakhir=='') or($frm_kode_KP=='pilih') or ($frm_no_surat_pemohon=='') or ($frm_tgl_mohon_KP=='') or ($frm_nrp1=='') or ($frm_kota_KP=='') or ($frm_nama_pershn=='') or ($frm_alamat_KP=='') or ($frm_tgl_mulai_KP=='') or ($frm_tgl_selesai_KP=='') or ($frm_kode_dobing==''))
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi data permohonan KP dengan lengkap. <br>Gagal menyimpan data."; 
		}

		if ($error !=1) // Jika semua isian form valid 
		{// data id tidak ada, berarti record baru
			if ($frm_exist!=1) 
				{
					
					
					/*echo "<br>frm_kode_KP=".$frm_kode_KP;
					echo "<br>frm_kode_dobing=".$frm_kode_dobing;
					echo "<br>frm_tgl_mohon_KP=".$frm_tgl_mohon_KP;
					echo "<br>frm_nrp1=".$frm_nrp1;
					echo "<br>frm_nrp2=".$frm_nrp2;
					echo "<br>frm_nrp3=".$frm_nrp3;
					echo "<br>frm_nrp4=".$frm_nrp4;
					echo "<br>frm_nrp5=".$frm_nrp5;
					echo "<br>frm_nrp6=".$frm_nrp6;
					echo "<br>frm_nama_pershn=".$frm_nama_pershn;
					echo "<br>frm_kota_KP=".$frm_kota_KP;
					echo "<br>frm_alamat_KP=".$frm_alamat_KP;
					echo "<br>frm_kode_KP=".$frm_kode_KP;
					echo "<br>frm_tgl_mulai_KP=".$frm_tgl_mulai_KP;
					echo "<br>frm_tgl_selesai_KP=".$frm_tgl_selesai_KP;*/
					
					$result = mysql_query("INSERT INTO daftar_kp (`UR_MOHON`,`NO_MOHON`,`KODE_KP`,`NRP_1`,`NRP_2`,`NRP_3`,`NRP_4`,`NRP_5`,`NRP_6`,`NRP_7`,`NRP_8`,`NA_PERUSH`,`JALAN`,`KOTA`,`TGL_AWAL`,`TGL_END`,`TGL_MOHON`,`DOSEN`) VALUES ( '".$frm_no_urut_mohonKP_terakhir."','".$frm_no_surat_pemohon."', '".$frm_kode_KP."', '".$frm_nrp1."', '".$frm_nrp2."', '".$frm_nrp3."', '".$frm_nrp4."', '".$frm_nrp5."', '".$frm_nrp6."', '".$frm_nrp7."', '".$frm_nrp8."', '".$frm_nama_pershn."', '".$frm_alamat_KP."', '".$frm_kota_KP."', '".$frm_tgl_mulai_KP."', '".$frm_tgl_selesai_KP."', '".$frm_tgl_mohon_KP."', '".$frm_kode_dobing."') " );
					if ($result) 
						{
							$pesan = $pesan."<br>Proses entry data BERHASIL";	
						}
					else
						{ 
							$pesan = $pesan."<br>Proses entry data GAGAL - ". mysql_error();
						}
				}
			else
				{
					$result = mysql_query("UPDATE daftar_kp set `KODE_KP`='$frm_kode_KP',
																`NRP_1`='$frm_nrp1',
																`NRP_2`='$frm_nrp2',
																`NRP_3`='$frm_nrp3',
																`NRP_4`='$frm_nrp4',
																`NRP_5`='$frm_nrp5',
																`NRP_6`='$frm_nrp6',
																`NRP_7`='$frm_nrp7',
																`NRP_8`='$frm_nrp8',
																`NA_PERUSH`='$frm_nama_pershn',
																`DOSEN`='$frm_kode_dobing',
																`KOTA`='$frm_kota_KP',
																`JALAN`='$frm_alamat_KP',
																`TGL_AWAL`='$frm_tgl_mulai_KP',
																`TGL_END`='$frm_tgl_selesai_KP',
																`TGL_MOHON`='$frm_tgl_mohon_KP'  
														  WHERE `NO_MOHON`=$frm_no_surat_pemohon");

					if ($result) 
						{
							$pesan = $pesan."<br>Proses update data BERHASIL";	
						}
					else
						{ 
							$pesan = $pesan."<br>Proses update data GAGAL - ". mysql_error();
						}
				}
		}
}


if ($act==2) { // hapus data
$result = mysql_query("DELETE FROM daftar_kp WHERE NO_MOHON = ".$frm_no_surat_pemohon);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data - ". mysql_error();}
}	
	
// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	//$frm_kode_KP = "";
	$frm_kode_dobing = "";
	$frm_tgl_mohon_KP = "";
	$frm_nrp1 = "";
	$frm_nrp2 = "";
	$frm_nrp3 = "";
	$frm_nrp4 = "";
	$frm_nrp5 = "";
	$frm_nrp6 = "";
	$frm_nrp7 = "";
	$frm_nrp8 = "";
	$frm_nama_pershn = "";
	$frm_kota_KP = "";
	$frm_alamat_KP = "";
	$frm_tgl_mulai_KP = "";
	$frm_tgl_selesai_KP = "";
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_no_surat_pemohon!='')  {
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
									`daftar_kp`.`TGL_NKP`,
									`daftar_kp`.`HONOR`,
									`daftar_kp`.`STATUS`
							   FROM `daftar_kp`
							  WHERE `daftar_kp`.`NO_MOHON` = '".$frm_no_surat_pemohon."'");

					if ($row = mysql_fetch_array($result)) {
						$frm_exist=1;
						$frm_kode_KP = $row["KODE_KP"];
						$frm_kode_dobing = $row["DOSEN"];
						$frm_no_surat_pemohon = $row["NO_MOHON"];
						$frm_nrp1 = $row["NRP_1"];
						$frm_nrp2 = $row["NRP_2"];
						$frm_nrp3 = $row["NRP_3"];
						$frm_nrp4 = $row["NRP_4"];
						$frm_nrp5 = $row["NRP_5"];
						$frm_nrp6 = $row["NRP_6"];
						$frm_nrp7 = $row["NRP_7"];
						$frm_nrp8 = $row["NRP_8"];
						$frm_kota_KP = $row["KOTA"];
						$frm_nama_pershn = $row["NA_PERUSH"];
						$frm_alamat_KP = $row["JALAN"];
						$frm_tgl_mulai_KP = $row["TGL_AWAL"];
						$frm_tgl_selesai_KP = $row["TGL_END"];
						
						$frm_tgl_mohon_KP =$row["TGL_MOHON"];
						if ($row["TGL_MOHON"]=="00/00/0000") {
						$frm_tgl_mohon_KP =""; }else {
						$frm_tgl_mohon_KP =$row["TGL_MOHON"];}
						
						$frm_tgl_ST_KP =$row["TGL_ST"];
						if ($row["TGL_ST"]=="00/00/0000") {
						$frm_tgl_ST_KP =""; }else {
						$frm_tgl_ST_KP =$row["TGL_ST"];}
						
					}else
					{
						$frm_exist=0; 
						$frm_kode_KP = "";
						$frm_kode_dobing = "";
						$frm_tgl_mohon_KP = "";
						$frm_nrp1 = "";
						$frm_nrp2 = "";
						$frm_nrp3 = "";
						$frm_nrp4 = "";
						$frm_nrp5 = "";
						$frm_nrp6 = "";
						$frm_nrp7 = "";
						$frm_nrp8 = "";
						$frm_nama_pershn = "";
						$frm_kota_KP = "";
						$frm_alamat_KP = "";
						$frm_tgl_mulai_KP = "";
						$frm_tgl_selesai_KP = "";
					}
					
					if ($frm_kode_dobing!='') {
						$result = mysql_query("Select nama from dosen where kode='$frm_kode_dobing'");
						$row = mysql_fetch_array($result);
						$frm_nama_dosen = $row["nama"];
					}
}
}
if ($sub==nrp1)
{
	//echo "<br>NRP 1";
	//echo "<br>NILAI= ".$nilai;
	$frm_nrp1 = $nilai;
	$frm_nrp2 = $_POST['frm_nrp2'];
	$frm_nrp3 = $_POST['frm_nrp3'];
	$frm_nrp4 = $_POST['frm_nrp4'];
	$frm_nrp5 = $_POST['frm_nrp5'];
	$frm_nrp6 = $_POST['frm_nrp6'];
	$frm_nrp7 = $_POST['frm_nrp7'];
	$frm_nrp8 = $_POST['frm_nrp8'];
	//echo "<br>frm_nrp1= ".$frm_nrp1;
}
else if ($sub==nrp2)
{
	$frm_nrp1 = $_POST['frm_nrp1'];
	$frm_nrp2 = $nilai;
	$frm_nrp3 = $_POST['frm_nrp3'];
	$frm_nrp4 = $_POST['frm_nrp4'];
	$frm_nrp5 = $_POST['frm_nrp5'];
	$frm_nrp6 = $_POST['frm_nrp6'];
	$frm_nrp7 = $_POST['frm_nrp7'];
	$frm_nrp8 = $_POST['frm_nrp8'];
}		
else if ($sub==nrp3)
{
	$frm_nrp1 = $_POST['frm_nrp1'];
	$frm_nrp2 = $_POST['frm_nrp2'];
	$frm_nrp3 = $nilai;
	$frm_nrp4 = $_POST['frm_nrp4'];
	$frm_nrp5 = $_POST['frm_nrp5'];
	$frm_nrp6 = $_POST['frm_nrp6'];
	$frm_nrp7 = $_POST['frm_nrp7'];
	$frm_nrp8 = $_POST['frm_nrp8'];
}
else if ($sub==nrp4)
{
	$frm_nrp1 = $_POST['frm_nrp1'];
	$frm_nrp2 = $_POST['frm_nrp2'];
	$frm_nrp3 = $_POST['frm_nrp3'];
	$frm_nrp4 = $nilai;
	$frm_nrp5 = $_POST['frm_nrp5'];
	$frm_nrp6 = $_POST['frm_nrp6'];
	$frm_nrp7 = $_POST['frm_nrp7'];
	$frm_nrp8 = $_POST['frm_nrp8'];
}	
else if ($sub==nrp5)
{
	$frm_nrp1 = $_POST['frm_nrp1'];
	$frm_nrp2 = $_POST['frm_nrp2'];
	$frm_nrp3 = $_POST['frm_nrp3'];
	$frm_nrp4 = $_POST['frm_nrp4'];
	$frm_nrp5 = $nilai;
	$frm_nrp6 = $_POST['frm_nrp6'];
	$frm_nrp7 = $_POST['frm_nrp7'];
	$frm_nrp8 = $_POST['frm_nrp8'];
}
else if ($sub==nrp6)
{
	$frm_nrp1 = $_POST['frm_nrp1'];
	$frm_nrp2 = $_POST['frm_nrp2'];
	$frm_nrp3 = $_POST['frm_nrp3'];
	$frm_nrp4 = $_POST['frm_nrp4'];
	$frm_nrp5 = $_POST['frm_nrp5'];
	$frm_nrp6 = $nilai;
	$frm_nrp7 = $_POST['frm_nrp7'];
	$frm_nrp8 = $_POST['frm_nrp8'];
}
else if ($sub==nrp7)
{
	$frm_nrp1 = $_POST['frm_nrp1'];
	$frm_nrp2 = $_POST['frm_nrp2'];
	$frm_nrp3 = $_POST['frm_nrp3'];
	$frm_nrp4 = $_POST['frm_nrp4'];
	$frm_nrp5 = $_POST['frm_nrp5'];
	$frm_nrp6 = $_POST['frm_nrp6'];
	$frm_nrp7 = $nilai;
	$frm_nrp8 = $_POST['frm_nrp8'];
}
else if ($sub==nrp8)
{
	$frm_nrp1 = $_POST['frm_nrp1'];
	$frm_nrp2 = $_POST['frm_nrp2'];
	$frm_nrp3 = $_POST['frm_nrp3'];
	$frm_nrp4 = $_POST['frm_nrp4'];
	$frm_nrp5 = $_POST['frm_nrp5'];
	$frm_nrp6 = $_POST['frm_nrp6'];
	$frm_nrp7 = $_POST['frm_nrp7'];
	$frm_nrp8 = $nilai;
}							
			
			if ($frm_nrp1!='') {
				$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp1'");
				$row = mysql_fetch_array($result);
				$frm_nama_1 = $row["nama"];
			}	
			if ($frm_nrp2!='') {
				$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp2'");
				$row = mysql_fetch_array($result);
				$frm_nama_2 = $row["nama"];
			}
			if ($frm_nrp3!='') {
				$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp3'");
				$row = mysql_fetch_array($result);
				$frm_nama_3 = $row["nama"];
			}
			if ($frm_nrp4!='') {
				$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp4'");
				$row = mysql_fetch_array($result);
				$frm_nama_4 = $row["nama"];
			}
			if ($frm_nrp5!='') {
				$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp5'");
				$row = mysql_fetch_array($result);
				$frm_nama_5 = $row["nama"];
			}
			if ($frm_nrp6!='') {
				$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp6'");
				$row = mysql_fetch_array($result);
				$frm_nama_6 = $row["nama"];
			}
			if ($frm_nrp7!='') {
				$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp7'");
				$row = mysql_fetch_array($result);
				$frm_nama_7 = $row["nama"];
			}
			if ($frm_nrp8!='') {
				$result = mysql_query("Select nama from master_mhs where nrp='$frm_nrp8'");
				$row = mysql_fetch_array($result);
				$frm_nama_8 = $row["nama"];
			}
						
						
//cari NO_MOHON, UR_MOHON
$result_no_surat_mohonKP_akhir = mysql_query("SELECT NO_MOHON, UR_MOHON FROM daftar_kp WHERE NO_MOHON<>'' ORDER BY UR_MOHON DESC LIMIT 1");
$row_no_surat_mohonKP_akhir = mysql_fetch_array($result_no_surat_mohonKP_akhir);
$frm_no_mohonKP_terakhir = $row_no_surat_mohonKP_akhir["NO_MOHON"];
$frm_no_urut_mohonKP_terakhir = $row_no_surat_mohonKP_akhir["UR_MOHON"];

$frm_no_urut_mohonKP_terakhir++;
?>
<html>
<head>
<meta http-equiv="Refresh" content="300; URL=mhs_mohon_KP.php">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<script language="JavaScript" src="../../include/tanggalan.js">
</script>

<SCRIPT language="JavaScript1.2" src="../../include/main.js" type="text/javascript"></SCRIPT>  
<body class="body">
<DIV id="TipLayer" style="visibility:hidden;position:absolute;z-index:1000;top:-100;"></DIV>
 <SCRIPT language="JavaScript1.2" src="../../include/style.js" type="text/javascript"></SCRIPT> 


<form name="mohon_KP" id="mohon_KP" action="mhs_mohon_KP.php" method="post">
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
              DATA ~</strong> PROSES PERMOHONAN KP</font></font></td>
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
      <td nowrap>Nomor Surat Permohonan KP terakhir </td>
      <td><strong>:</strong></td>
      <td>
		<? //echo "-> ".$frm_no_urut_mohonKP_terakhir;?>
		<input name="frm_no_mohonKP_terakhir" type="text" class="tekboxku" id="frm_no_mohonKP_terakhir"  value="<?php echo $frm_no_mohonKP_terakhir; ?>" size="10" maxlength="10" readonly="true">
		<input type="hidden" name="frm_no_urut_mohonKP_terakhir" id="frm_no_urut_mohonKP_terakhir" value="<? echo $frm_no_urut_mohonKP_terakhir;?>">
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Nomor Surat Permohonan KP </td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_surat_pemohon" type="text" onMouseOver="stm(Text[15],Style[12])" onMouseOut="htm()" class="tekboxku" id="frm_no_surat_pemohon" onBlur="document.mohon_KP.submit()" value="<?php echo $frm_no_surat_pemohon; ?>" size="10" maxlength="9" >
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Tgl. Surat Permohonan KP </td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_mohon_KP" type="text" class="tekboxku" id="frm_tgl_mohon_KP" value="<?php if ($frm_tgl_mohon_KP=='') { echo date('d/m/Y');} else {echo $frm_tgl_mohon_KP;} ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('mohon_KP.frm_tgl_mohon_KP',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
      </A>(dd/mm/yyyy)  <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>NRP 1 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp1" type="text" class="tekboxku" id="frm_nrp1" onBlur="this.form.action+='?sub=nrp1&nilai='+document.mohon_KP.frm_nrp1.value;this.form.submit();" value="<?php echo $frm_nrp1; ?>" size="10" maxlength="10" >
      <span class="style1">*
      <? if (isset($frm_nrp1)) echo $frm_nama_1;?></span>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>NRP 2 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp2" type="text" class="tekboxku" id="frm_nrp2" onBlur="this.form.action+='?sub=nrp2&nilai='+document.mohon_KP.frm_nrp2.value;this.form.submit();" value="<?php echo $frm_nrp2; ?>" size="10" maxlength="10" >
        <span class="style1">*
        <? if (isset($frm_nrp2)) echo $frm_nama_2;?>
        </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>NRP 3 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp3" type="text" class="tekboxku" id="frm_nrp3" onBlur="this.form.action+='?sub=nrp3&nilai='+document.mohon_KP.frm_nrp3.value;this.form.submit();" value="<?php echo $frm_nrp3; ?>" size="10" maxlength="10" >
        <span class="style1">*
        <? if (isset($frm_nrp3)) echo $frm_nama_3;?>
        </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>NRP 4 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp4" type="text" class="tekboxku" id="frm_nrp4" onBlur="this.form.action+='?sub=nrp4&nilai='+document.mohon_KP.frm_nrp4.value;this.form.submit();" value="<?php echo $frm_nrp4; ?>" size="10" maxlength="10" >
        <span class="style1">*
        <? if (isset($frm_nrp4)) echo $frm_nama_4;?>
        </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>NRP 5 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp5" type="text" class="tekboxku" id="frm_nrp5" onBlur="this.form.action+='?sub=nrp5&nilai='+document.mohon_KP.frm_nrp5.value;this.form.submit();" value="<?php echo $frm_nrp5; ?>" size="10" maxlength="10" >
        <span class="style1">*
        <? if (isset($frm_nama_5)) echo $frm_nama_5;?>
        </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>NRP 6 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp6" type="text" class="tekboxku" id="frm_nrp6" onBlur="this.form.action+='?sub=nrp6&nilai='+document.mohon_KP.frm_nrp6.value;this.form.submit();" value="<?php echo $frm_nrp6; ?>" size="10" maxlength="10" >
        <span class="style1">*
        <? if (isset($frm_nama_6)) echo $frm_nama_6;?>
        </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>NRP 7 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp7" type="text" class="tekboxku" id="frm_nrp7" onBlur="this.form.action+='?sub=nrp7&nilai='+document.mohon_KP.frm_nrp7.value;this.form.submit();" value="<?php echo $frm_nrp7; ?>" size="10" maxlength="10" >
        <span class="style1">*
        <? if (isset($frm_nama_7)) echo $frm_nama_7;?>
        </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>NRP 8 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp8" type="text" class="tekboxku" id="frm_nrp8" onBlur="this.form.action+='?sub=nrp8&nilai='+document.mohon_KP.frm_nrp8.value;this.form.submit();" value="<?php echo $frm_nrp8; ?>" size="10" maxlength="10" >
        <span class="style1">*
        <? if (isset($frm_nama_8)) echo $frm_nama_8;?>
        </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">Dosen Pembimbing </td>
      <td valign="top"><strong>:</strong></td>
      <td valign="top">
	  <select name="frm_kode_dobing" id="frm_kode_dobing" class="tekboxku">
        <option <?php if ($frm_kode_dobing==''){echo "selected";}?> value="">--- Pilih ---</option>
        <?php 
				$sqlDosen="SELECT kode, nama
						   FROM dosen  where (length(kode)=6) ORDER BY kode";
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
        <option value="<?php echo $row->kode; ?>" <?php if ($frm_kode_dobing==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
        <?php
				}
				
				?>
      </select>
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">Kerja Praktek di </td>
      <td valign="top"><strong>:</strong></td>
      <td valign="top"><textarea name="frm_nama_pershn" cols="50" rows="2" class="tekboxku" id="frm_nama_pershn"><?php echo $frm_nama_pershn; ?></textarea>
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td valign="top" nowrap>Jalan</td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><textarea name="frm_alamat_KP" cols="50" rows="2" class="tekboxku" id="frm_alamat_KP"><?php echo $frm_alamat_KP; ?></textarea>
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td nowrap>Kota</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_kota_KP" id="frm_kota_KP" type="text" class="tekboxku" value="<?php echo $frm_kota_KP; ?>" size="50" maxlength="50">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Kode KP</td>
      <td><strong>:</strong></td>
      <td><select name="frm_kode_KP" id="frm_kode_KP" class="tekboxku">
        <option value="pilih" <?php if ($frm_kode_KP==''){echo "selected";}?> >--- Pilih ---</option>
        <?php
  	             $result_kd_kp = mysql_query("SELECT * FROM master_kode_kp ORDER BY id ASC");
	             while(($row_kd_kp = mysql_fetch_object($result_kd_kp)))
	             {?>
        <option value="<?php echo $row_kd_kp->kode_kp; ?>" <?php if ($frm_kode_KP==$row_kd_kp->kode_kp) { echo "selected"; }?> > <?php echo $row_kd_kp->kode_kp; ?></option>
        <?php }?>
      </select>
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tgl. Mulai KP </td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_mulai_KP" type="text" class="tekboxku" id="frm_tgl_mulai_KP" value="<?php echo $frm_tgl_mulai_KP; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('mohon_KP.frm_tgl_mulai_KP',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
      </A>(dd/mm/yyyy)  <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tgl. Selesai KP </td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_selesai_KP" type="text" class="tekboxku" id="frm_tgl_selesai_KP" value="<?php echo $frm_tgl_selesai_KP; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('mohon_KP.frm_tgl_selesai_KP',0,0,'DD/MM/YYYY')"> 
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
        <?php if ($frm_kode_KP) { ?>
        <input type="button" name="Submit3" value="Hapus"  onclick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_kode_KP;?>';this.form.submit()};" class="tombol"> 
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