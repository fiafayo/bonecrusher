<?php
/* 
   DATE CREATED : 01/08/07
   KEGUNAAN     : ENTRY DATA SURAT TUGAS KP
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ // simpan data
	// cek validasi tanggal
	if ($frm_tgl_surat_pemohon!='') 
		{
			if (datetomysql($frm_tgl_surat_pemohon)) 
				{
					$frm_tgl_surat_pemohon = datetomysql($frm_tgl_surat_pemohon);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal surat permohonan KP tidak valid";
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
					$pesan = $pesan."<br> Tanggal surat tugas KP tidak valid";  
				}
		}

// Form harus diisi 
/*echo "<br>frm_no_mohonKP_terakhir= ".$frm_no_mohonKP_terakhir;
echo "<br>frm_no_surat_pemohon= ".$frm_no_surat_pemohon;
echo "<br>frm_nrp1= ".$frm_nrp1;
echo "<br>frm_nama_1= ".$frm_nama_1;
echo "<br>frm_tgl_surat_pemohon= ".$frm_tgl_surat_pemohon;
echo "<br>frm_no_ST_KP_terakhir= ".$frm_no_ST_KP_terakhir;
echo "<br>frm_no_ST_KP= ".$frm_no_ST_KP;
echo "<br>frm_tgl_ST_KP= ".$frm_tgl_ST_KP;
echo "<br>frm_kode_dobing= ".$frm_kode_dobing;
echo "<br>frm_bing_persh= ".$frm_bing_persh;
*/


	if (($frm_no_mohonKP_terakhir=='') or ($frm_no_surat_pemohon=='') or ($frm_nrp1=='') or ($frm_tgl_surat_pemohon=='') or ($frm_no_ST_KP_terakhir=='') or ($frm_no_ST_KP=='') or ($frm_tgl_ST_KP=='') or ($frm_kode_dobing=='') or ($frm_bing_persh=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi data dengan lengkap. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		
		//echo"<br>form valid";
		//echo"<br>frm_exist= ".$frm_exist;
		
			if ($frm_exist==1) // update tabel daftar_KP untuk ST KP
				{
					//echo"<br>MASUK"; exit();
					/*$result = mysql_query("INSERT INTO daftar_kp (`NO_MOHON`,`KODE_KP`,`NRP_1`,`NRP_2`,`NRP_3`,`NRP_4`,`NRP_5`,`NA_PERUSH` , `JALAN` , `KOTA` , 
					`tanggal_lahir` , `email` , `telepon_asal` , `telepon_sekarang` , `hp` , `nama_ortu` , `alamat_ortu` , `zip_ortu` , 
					`id_kota_ortu` , `telepon_ortu` ,`tanggal_keluar` , `id_smu`, `usm`, `id_status` ) VALUES ( '".$frm_nrp."', '".$frm_id_jalur_masuk_mhs."', '".$frm_nama."', '".$frm_alamat_asal."', '".$frm_zip_asal."', '".$frm_id_kota_asal."', '".$frm_alamat_sekarang."', '".$frm_zip_sby."', '".$frm_sex."', '".$frm_tempat_lahir."', '".$frm_tanggal_lahir."', '".$frm_email."', '".$frm_telepon_asal."', '".$frm_telepon_sekarang."', '".$frm_hp."', '".$frm_nama_ortu."', '".$frm_alamat_ortu."', '".$frm_zip_ortu."', '".$frm_id_kota_ortu."', '".$frm_telepon_ortu."', '".$frm_tanggal_keluar."', '".$frm_id_smu."', '".$frm_usm."', '".$frm_id_status."') " );
					if ($result) 
						{
							$pesan = $pesan."<br>Proses entry data BERHASIL";	
						}
					else
						{ 
							$pesan = $pesan."<br>Proses entry data GAGAL";
						}*/
				
							$result = mysql_query("UPDATE daftar_kp set `NO_ST`='$frm_no_ST_KP',
																		`UR_ST`='$frm_no_urut_ST_KP_terakhir',
																		`TGL_ST`='$frm_tgl_ST_KP',
																		`NRP_1`='$frm_nrp1',
																        `NRP_2` ='$frm_nrp2',
																        `NRP_3`='$frm_nrp3',
																        `NRP_4`='$frm_nrp4',
																        `NRP_5`='$frm_nrp5',
																		`DOSEN`='$frm_kode_dobing',
																		`PEM_PERUS`='$frm_bing_persh'
																  where `NO_MOHON`=$frm_no_surat_pemohon");
							if ($result) 
								{
									$pesan = $pesan."<br>Proses update data BERHASIL";	
								}
							else
								{ 
									$pesan = $pesan."<br>Proses update data GAGAL";
								}
				}
				else
				{ // data mahasiswa belum ada di permohonan KP 
					$pesan = $pesan."<br>Silahkan Masukkan Permohonan KP dulu. Gagal menyimpan data";	
				}
		}
	}


if ($act==2) { // hapus data
//$result = mysql_query("delete from daftar_kp WHERE NO_MOHON = ".$frm_no_surat_pemohon);
$result = mysql_query("UPDATE daftar_kp set `NO_ST`='',
										    `UR_ST`=0,
										    `TGL_ST`='',
										    `DOSEN`='',
										    `PEM_PERUS`=''
					                  where `NO_MOHON`=$frm_no_surat_pemohon");
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	
	$frm_no_ST_KP = "";
	$frm_tgl_ST_KP = "";
	
	$frm_kode_dobing = "";
	$frm_bing_persh = "";
	
	$frm_tgl_surat_pemohon = "";
	
	//$frm_no_ST_KP_terakhir=0; 
	
	$frm_nrp1 = "";
	$frm_nrp2 = "";
	$frm_nrp3 = "";
	$frm_nrp4 = "";
	$frm_nrp5 = "";
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
							WHERE `daftar_kp`.`NO_MOHON`='".$frm_no_surat_pemohon."'");

					if ($row = mysql_fetch_array($result)) {
						$frm_exist=1;
						$frm_no_surat_pemohon = $row["NO_MOHON"];
						$frm_no_ST_KP =$row["NO_ST"];
						
						$frm_tgl_ST_KP = $row["TGL_ST"];
						$frm_kode_dobing =$row["DOSEN"];
						$frm_bing_persh =$row["PEM_PERUS"];
						
						$frm_nrp1 = $row["NRP_1"];
						$frm_nrp2 = $row["NRP_2"];
						$frm_nrp3 = $row["NRP_3"];
						$frm_nrp4 = $row["NRP_4"];
						$frm_nrp5 = $row["NRP_5"];
						
						$frm_tgl_surat_pemohon =$row["TGL_MOHON"];
						if ($row["TGL_MOHON"]=="00/00/0000") {
						$frm_tgl_surat_pemohon =""; }else {
						$frm_tgl_surat_pemohon =$row["TGL_MOHON"];}
						
						$frm_tgl_ST_KP =$row["TGL_ST"];
						if ($row["TGL_ST"]=="00/00/0000") {
						$frm_tgl_ST_KP =""; }else {
						$frm_tgl_ST_KP =$row["TGL_ST"];}
						
								//nomer urut
								//cari N_ST, URUT_ST terakhir
									$result_no_surat_KP_akhir = mysql_query("SELECT NO_ST, UR_ST FROM daftar_kp WHERE NO_ST<>'' ORDER BY UR_ST DESC LIMIT 1");
									$row_no_surat_KP_akhir = mysql_fetch_array($result_no_surat_KP_akhir);
									$frm_no_ST_KP_terakhir = $row_no_surat_KP_akhir["NO_ST"];
									$frm_no_urut_ST_KP_terakhir = $row_no_surat_KP_akhir["UR_ST"];
									if (frm_no_urut_ST_KP_terakhir=='')
									{$frm_no_urut_ST_KP_terakhir++;}
									else
								    {$frm_no_urut_ST_KP_terakhir;}
									
									
									//cari NO_MOHON, UR_MOHON
									/*$result_no_surat_mohonKP_akhir = mysql_query("SELECT NO_MOHON, UR_MOHON FROM daftar_kp WHERE NO_MOHON<>'' ORDER BY UR_MOHON DESC LIMIT 1");
									$row_no_surat_mohonKP_akhir = mysql_fetch_array($result_no_surat_mohonKP_akhir);
									$frm_no_mohonKP_terakhir = $row_no_surat_mohonKP_akhir["NO_MOHON"];
									$frm_no_urut_mohonKP_terakhir = $row_no_surat_mohonKP_akhir["UR_MOHON"];*/
									if (frm_no_urut_mohonKP_terakhir=='')
									{$frm_no_urut_mohonKP_terakhir++;}
									else
								    {$frm_no_urut_mohonKP_terakhir;}
								
						
					}else
					{
						//cek untuk validasi permohonan KP sudah dibuat atau belum
						$frm_exist=0; 
						header("Location: mhs_surat_tugas_KP.php"); 
						
						/*$frm_no_ST_KP = "";
						$frm_tgl_ST_KP = "";
						
						$frm_kode_dobing = "";
						$frm_bing_persh = "";
						
						$frm_tgl_surat_pemohon = "";
						
						$frm_nrp1 = "";
						$frm_nrp2 = "";
						$frm_nrp3 = "";
						$frm_nrp4 = "";
						$frm_nrp5 = "";*/
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
	echo "<br>NRP 1";
	echo "<br>NILAI= ".$nilai;
	$frm_nrp1 = $nilai;
	$frm_nrp2 = $_POST['frm_nrp2'];
	$frm_nrp3 = $_POST['frm_nrp3'];
	$frm_nrp4 = $_POST['frm_nrp4'];
	$frm_nrp5 = $_POST['frm_nrp5'];
	echo "<br>frm_nrp1= ".$frm_nrp1;
}
else if ($sub==nrp2)
{
	$frm_nrp1 = $_POST['frm_nrp1'];
	$frm_nrp2 = $nilai;
	$frm_nrp3 = $_POST['frm_nrp3'];
	$frm_nrp4 = $_POST['frm_nrp4'];
	$frm_nrp5 = $_POST['frm_nrp5'];
}		
else if ($sub==nrp3)
{
	$frm_nrp1 = $_POST['frm_nrp1'];
	$frm_nrp2 = $_POST['frm_nrp2'];
	$frm_nrp3=$nilai;
	$frm_nrp4 = $_POST['frm_nrp4'];
	$frm_nrp5 = $_POST['frm_nrp5'];
}
else if ($sub==nrp4)
{
	$frm_nrp1 = $_POST['frm_nrp1'];
	$frm_nrp2 = $_POST['frm_nrp2'];
	$frm_nrp3 = $_POST['frm_nrp3'];
	$frm_nrp4=$nilai;
	$frm_nrp5 = $_POST['frm_nrp5'];
}	
else if ($sub==nrp5)
{
	$frm_nrp1 = $_POST['frm_nrp1'];
	$frm_nrp2 = $_POST['frm_nrp2'];
	$frm_nrp3 = $_POST['frm_nrp3'];
	$frm_nrp4 = $_POST['frm_nrp4'];
	$frm_nrp5=$nilai;
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
<form name="mhs_ST" id="mhs_ST" action="mhs_surat_tugas_KP.php" method="post">
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
              DATA ~</strong> PROSES SURAT TUGAS KP</font></font></td>
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
      <td nowrap>No. Surat Permohonan terakhir </td>
      <td><strong>:</strong></td>
      <td>
	  <? 
			$result_no_surat_mohonKP_akhir = mysql_query("SELECT NO_MOHON, UR_MOHON FROM daftar_kp WHERE NO_MOHON<>'' ORDER BY UR_MOHON DESC LIMIT 1");
			$row_no_surat_mohonKP_akhir = mysql_fetch_array($result_no_surat_mohonKP_akhir);
			$frm_no_mohonKP_terakhir = $row_no_surat_mohonKP_akhir["NO_MOHON"];
			$frm_no_urut_mohonKP_terakhir = $row_no_surat_mohonKP_akhir["UR_MOHON"];
			
			
	  
	  
	  //echo "-> ".$frm_no_urut_mohonKP_terakhir;?>
	  <input name="frm_no_mohonKP_terakhir" type="text" class="tekboxku" id="frm_no_mohonKP_terakhir"  value="<?php echo $frm_no_mohonKP_terakhir; ?>" size="10" maxlength="10" readonly="true">
	  <span class="style1">*</span></td>
      <input type="hidden" name="frm_no_urut_mohonKP_terakhir" id="frm_no_urut_mohonKP_terakhir" value="<? echo $frm_no_urut_mohonKP_terakhir;?>">
	</tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap> No. Surat Permohonan</td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_surat_pemohon" type="text" class="tekboxku" id="frm_no_surat_pemohon" onBlur="document.mhs_ST.submit()" value="<?php echo $frm_no_surat_pemohon; ?>" size="10" maxlength="10" >
        <span class="style1">* </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>NRP 1 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp1" type="text" class="tekboxku" id="frm_nrp1" onBlur="this.form.action+='?sub=nrp1&nilai='+document.mhs_ST.frm_nrp1.value;this.form.submit();" value="<?php echo $frm_nrp1; ?>" size="10" maxlength="10" >
        <span class="style1">*
        <? if (isset($frm_nrp1)) echo $frm_nama_1;?>
      </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>NRP 2 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp2" type="text" class="tekboxku" id="frm_nrp2" onBlur="this.form.action+='?sub=nrp2&nilai='+document.mhs_ST.frm_nrp2.value;this.form.submit();" value="<?php echo $frm_nrp2; ?>" size="10" maxlength="10" >
        <span class="style1"><? if (isset($frm_nrp2)) echo $frm_nama_2;?>
      </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>NRP 3 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp3" type="text" class="tekboxku" id="frm_nrp3" onBlur="this.form.action+='?sub=nrp3&nilai='+document.mhs_ST.frm_nrp3.value;this.form.submit();" value="<?php echo $frm_nrp3; ?>" size="10" maxlength="10" >
        <span class="style1"><? if (isset($frm_nrp3)) echo $frm_nama_3;?>
        </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>NRP 4 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp4" type="text" class="tekboxku" id="frm_nrp4" onBlur="this.form.action+='?sub=nrp4&nilai='+document.mhs_ST.frm_nrp4.value;this.form.submit();" value="<?php echo $frm_nrp4; ?>" size="10" maxlength="10" >
        <span class="style1"><? if (isset($frm_nrp4)) echo $frm_nama_4;?>
        </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>NRP 5 </td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp5" type="text" class="tekboxku" id="frm_nrp5" onBlur="this.form.action+='?sub=nrp5&nilai='+document.mhs_ST.frm_nrp5.value;this.form.submit();" value="<?php echo $frm_nrp5; ?>" size="10" maxlength="10" >
        <span class="style1"><? if (isset($frm_nama_5)) echo $frm_nama_5;?>
        </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tgl. Surat Permohonan </td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_surat_pemohon" type="text" class="tekboxku" id="frm_tgl_surat_pemohon" value="<?php echo $frm_tgl_surat_pemohon; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('mhs_ST.frm_tgl_surat_pemohon',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
      </A>(dd/mm/yyyy)  <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>No. Surat Tugas terakhir </td>
      <td><strong>:</strong></td>
      <td>
	  	<? //echo "-> ".$frm_no_urut_ST_KP_terakhir;
			$result_no_ST_KP_terakhir = mysql_query("SELECT NO_ST, UR_ST FROM daftar_kp WHERE NO_ST<>'' ORDER BY UR_ST DESC LIMIT 1");
			$row_no_ST_KP_terakhir = mysql_fetch_array($result_no_ST_KP_terakhir);
			$frm_no_ST_KP_terakhir = $row_no_ST_KP_terakhir["NO_ST"];
			$frm_no_urut_ST_KP_terakhir = $row_no_ST_KP_terakhir["UR_ST"];
			$frm_no_urut_ST_KP_terakhir++;
		?>
	  <input name="frm_no_ST_KP_terakhir" type="text" class="tekboxku" id="frm_no_ST_KP_terakhir" value="<?php echo $frm_no_ST_KP_terakhir; ?>" size="10" maxlength="10" readonly="true">
	  <span class="style1">*</span></td>
      <input type="hidden" name="frm_no_urut_ST_KP_terakhir" id="frm_no_urut_ST_KP_terakhir" value="<? echo $frm_no_urut_ST_KP_terakhir;?>">
	</tr>
    <tr>
      <td>&nbsp;</td>
      <td>No. Surat Tugas </td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_ST_KP" type="text" class="tekboxku" id="frm_no_ST_KP" value="<?php echo $frm_no_ST_KP; ?>" size="10" maxlength="10" >
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tgl. Surat Tugas </td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_ST_KP" type="text" class="tekboxku" id="frm_tgl_ST_KP" value="<?php echo $frm_tgl_ST_KP; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('mhs_ST.frm_tgl_ST_KP',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
      </A>(dd/mm/yyyy)  <span class="style1">*</span></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>NPK Dosen Pembimbing</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <select name="frm_kode_dobing" id="frm_kode_dobing" class="tekboxku">
           <option <?php if ($frm_kode_dobing==''){echo "selected";}?> value="">--- Pilih ---</option>
          <?php 
				$sqlDosen="select kode, nama
						   from dosen";
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
      <td nowrap>Nama Pembimbing Perusahaan</td>
      <td><div align="center"><strong>:</strong></div></td> 
      <td><input name="frm_bing_persh" id="frm_bing_persh" type="text" class="tekboxku" value="<?php echo $frm_bing_persh; ?>" size="30" maxlength="50">
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
			<?php if ($frm_nama) { ?>
			<input type="button" name="Submit3" value="Hapus"  onclick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_nama;?>';this.form.submit()};" class="tombol"> 
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