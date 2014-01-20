<?
/* 
   DATE CREATED : 05/09/07
   KEGUNAAN     : ENTRY SURAT TUGAS PUBLIKASI KERJASAMA
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/
session_start();
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ // simpan data
// Pemeriksaan tanggal, apakah tanggal yang dimasukkan valid
	if ($frm_tgl_go!='') 
		{
			if (datetomysql($frm_tgl_go)) 
				{
					$frm_tgl_go = datetomysql($frm_tgl_go);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal Berangkat tidak valid";
				}
		}
	if ($frm_tgl_dtg!='') 
			{
				if (datetomysql($frm_tgl_dtg)) 
					{
						$frm_tgl_dtg = datetomysql($frm_tgl_dtg);
					}
				else
					{
						$error = 1;
						$pesan = $pesan."<br> Tanggal Kembali tidak valid";
					}
			}

// Kode dan nama harus diisi 
	if (($frm_jenis=='') or ($frm_no_st_pub_now=='') or ($frm_id_karyawan=='') or ($frm_golongan=='') or ($frm_jabatan_struktural=='') or ($frm_TET=='') or ($frm_TNET=='') or ($frm_tugas=='') or ($frm_status=='')
	or ($frm_hari_go=='') or ($frm_tgl_go=='') or ($frm_pukul_go=='') or ($frm_tempat_go=='') or ($frm_transportasi_go=='') or ($frm_hari_dtg=='') or ($frm_tgl_dtg=='') or ($frm_pukul_dtg=='') or ($frm_transportasi_dtg=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi data Surat Tugas Publikasi dengan lengkap. ";
		}

	if ($error==1) 
		{
			$pesan=$pesan."<br>Gagal menyimpan data.";
		}
	if ($error !=1) // Jika semua isian form valid 
		{
		// data no_st_pub tidak ada, berarti record baru
					echo "<br>frm_no_st_pub_now= ".$frm_no_st_pub_now;
					echo "<br>frm_id_karyawan= ".$frm_id_karyawan;
					echo "<br>frm_golongan= ".$frm_golongan;
					echo "<br>frm_status= ".$frm_status;
					echo "<br>frm_jabatan_struktural= ".$frm_jabatan_struktural;
					echo "<br>frm_TET= ".$frm_TET;
					echo "<br>frm_TNET= ".$frm_TNET;
					echo "<br>frm_tugas= ".$frm_tugas;
					echo "<br>frm_hari_go= ".$frm_hari_go;
					echo "<br>frm_tgl_go= ".$frm_tgl_go;
					echo "<br>frm_pukul_go= ".$frm_pukul_go;
					echo "<br>frm_tempat_go= ".$frm_tempat_go;
					echo "<br>frm_transportasi_go= ".$frm_transportasi_go;
					echo "<br>frm_hari_dtg= ".$frm_hari_dtg;
					echo "<br>frm_tgl_dtg= ".$frm_tgl_dtg;
					echo "<br>frm_pukul_dtg= ".$frm_pukul_dtg;
					echo "<br><br>frm_biaya= ".$frm_biaya;
					echo "<br>chk_airport= ".$chk_airport;
					echo "<br>chk_fiskal= ".$chk_fiskal;
					echo "<br>chk_visa= ".$chk_visa;
					echo "<br>chk_uang_saku= ".$chk_uang_saku;
					echo "<br>chk_akomodasi= ".$chk_akomodasi;
					echo "<br>frm_lainnya= ".$frm_lainnya;
					echo "<br>frm_ndt= ".$frm_ndt;
					echo "<br>frm_jenis= ".$frm_jenis;
					
					if ($chk_airport=='on'){
						$chk_airport=1;}
					else
					{   $chk_airport=0;}
					
					if ($chk_fiskal=='on'){
					$chk_fiskal=1;}
					else
					{   $chk_fiskal=0;}
				
					if ($chk_visa=='on'){
						$chk_visa=1;}
					else
					{   $chk_visa=0;}
					
					if ($chk_uang_saku=='on'){
						$chk_uang_saku=1;}
					else
					{   $chk_uang_saku=0;}
					
					if ($chk_akomodasi=='on'){
						$chk_akomodasi=1;}
					else
					{   $chk_akomodasi=0;}
					
		
			if ($frm_exist!=1) 
				{
					$result = mysql_query("INSERT INTO publikasi ( `no_st_pub` , `urut_st_pub` , `jenis` , `kode_kary` , `golongan` , `status` , `jabatan_struktural` , `TET_sub` , `TNET_sub` , `tugas` , `hari_go` , `tgl_go` , `pukul_go` , `tempat_go` , `transport_go` , `hari_dtg` , `tgl_dtg` , `pukul_dtg` , `transport_dtg` , `biaya` , `L_ap_tax` , `L_fiskal` , `L_visa` , `L_saku` , `L_akomo` , `L_other` , `ndt_terakhir`) VALUES ( '".$frm_no_st_pub_now."', NULL, ".$frm_jenis.", '".$frm_id_karyawan."', '".$frm_golongan."', '".$frm_status."', '".$frm_jabatan_struktural."', '".$frm_TET."', '".$frm_TNET."', '".$frm_tugas."', '".$frm_hari_go."', '".$frm_tgl_go."', '".$frm_pukul_go."', '".$frm_tempat_go."', '".$frm_transportasi_go."', '".$frm_hari_dtg."', '".$frm_tgl_dtg."', '".$frm_pukul_dtg."','".$frm_transportasi_dtg."','".$frm_biaya."',".$chk_airport.",".$chk_fiskal.",".$chk_visa.",".$chk_uang_saku.",".$chk_akomodasi.",'".$frm_lainnya."','".$frm_ndt."') " );
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah ditambahkan";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data";
						}
				}
			else
				{
				
				
				echo "<br>frm_no_st_pub_now= ".$frm_no_st_pub_now;
					echo "<br>frm_id_karyawan= ".$frm_id_karyawan;
					echo "<br>frm_golongan= ".$frm_golongan;
					echo "<br>frm_status= ".$frm_status;
					echo "<br>frm_jabatan_struktural= ".$frm_jabatan_struktural;
					echo "<br>frm_TET= ".$frm_TET;
					echo "<br>frm_TNET= ".$frm_TNET;
					echo "<br>frm_tugas= ".$frm_tugas;
					echo "<br>frm_hari_go= ".$frm_hari_go;
					echo "<br>frm_tgl_go= ".$frm_tgl_go;
					echo "<br>frm_pukul_go= ".$frm_pukul_go;
					echo "<br>frm_tempat_go= ".$frm_tempat_go;
					echo "<br>frm_transportasi_go= ".$frm_transportasi_go;
					echo "<br>frm_hari_dtg= ".$frm_hari_dtg;
					echo "<br>frm_tgl_dtg= ".$frm_tgl_dtg;
					echo "<br>frm_pukul_dtg= ".$frm_pukul_dtg;
					echo "<br><br>frm_biaya= ".$frm_biaya;
					echo "<br>chk_airport= ".$chk_airport;
					echo "<br>chk_fiskal= ".$chk_fiskal;
					echo "<br>chk_visa= ".$chk_visa;
					echo "<br>chk_uang_saku= ".$chk_uang_saku;
					echo "<br>chk_akomodasi= ".$chk_akomodasi;
					echo "<br>frm_lainnya= ".$frm_lainnya;
					echo "<br>frm_ndt= ".$frm_ndt;
					echo "<br>frm_jenis= ".$frm_jenis;

$result = mysql_query("UPDATE publikasi set `kode_kary`='$frm_id_karyawan',
											`jenis`=$frm_jenis,
										    `golongan`='$frm_golongan',
											`status`='$frm_status',
											`jabatan_struktural`='$frm_jabatan_struktural',
											`TET_sub`='$frm_TET',
											`TNET_sub`='$frm_TNET',
											`tugas`='$frm_tugas',
											`hari_go`='$frm_hari_go',
											`tgl_go`='$frm_tgl_go',
											`pukul_go`='$frm_pukul_go',
											`tempat_go`='$frm_tempat_go',
											`transport_go`='$frm_transportasi_go',
											`hari_dtg`='$frm_hari_dtg',
											`tgl_dtg`='$frm_tgl_dtg',
											`pukul_dtg`='$frm_pukul_dtg', 
										    `transport_dtg`='$frm_transportasi_dtg',
											`biaya`='$frm_biaya',
										    `L_ap_tax`=$chk_airport,
										    `L_fiskal`=$chk_fiskal,
										    `L_visa`=$chk_visa,
										    `L_saku`=$chk_uang_saku,
										    `L_akomo`=$chk_akomodasi,
										    `L_other`='$frm_lainnya',
										    `ndt_terakhir`='$frm_ndt'
									  WHERE `no_st_pub`='$frm_no_st_pub_now'");
									  
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menyimpan data update";
						}
				}
		}
	}


if ($act==2) { // hapus data
$result = mysql_query("DELETE FROM publikasi WHERE no_st_pub = '".$frm_no_st_pub_now."'");
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) 
{
    $frm_exist=0;
	$frm_no_st_pub_now="";
	$frm_id_karyawan="";
	$frm_golongan="";
	$frm_status="";
	$frm_jabatan_struktural="";
	$frm_TET="";
	$frm_TNET="";
	$frm_tugas="";
	$frm_tgl_go="";
	$frm_pukul_go=""; 
	$frm_tempat_go="";
	$frm_transportasi_go="";
	$frm_hari_dtg="";
	$frm_tgl_dtg="";
	$frm_pukul_dtg=""; 
	$frm_transportasi_dtg="";
	$frm_biaya="";
	$chk_airport="";
	$chk_fiskal="";
	$chk_visa="";
	$chk_uang_saku="";
	$chk_akomodasi="";
	$frm_lainnya="";
	$frm_ndt="";
	$frm_jenis="";
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_no_st_pub_now!='')  {
$result = mysql_query("Select master_karyawan.kode,
							  master_karyawan.nama,
                              publikasi.no_st_pub,
							  publikasi.urut_st_pub,
							  publikasi.kode_kary,
							  publikasi.golongan,
							  publikasi.status,
							  publikasi.jenis,
							  publikasi.jabatan_struktural,
							  publikasi.TET_sub,
							  publikasi.TNET_sub,
							  publikasi.tugas,
							  publikasi.hari_go,
							  DATE_FORMAT(publikasi.tgl_go,'%d/%m/%Y') as tgl_go,
							  publikasi.pukul_go,
							  publikasi.tempat_go,
							  publikasi.transport_go,
							  publikasi.hari_dtg,
							  DATE_FORMAT(publikasi.tgl_dtg,'%d/%m/%Y') as tgl_dtg,
							  publikasi.pukul_dtg,
							  publikasi.transport_dtg,
							  publikasi.biaya,
							  publikasi.L_ap_tax,
							  publikasi.L_fiskal,
							  publikasi.L_visa,
							  publikasi.L_saku,
							  publikasi.L_akomo,
							  publikasi.L_other,
							  publikasi.ndt_terakhir
					     FROM publikasi, master_karyawan 
					    WHERE publikasi.kode_kary=master_karyawan.kode and
					   		  no_st_pub='".$frm_no_st_pub_now."'");

						if ($row = mysql_fetch_array($result)) {
						    $frm_exist=1;
							
							$chk_airport = $row["L_ap_tax"];
							$chk_fiskal = $row["L_fiskal"];
							$chk_visa = $row["L_visa"];
							$chk_uang_saku = $row["L_saku"];
							$chk_akomodasi = $row["L_akomo"];
							$frm_lainnya = $row["L_other"];
														
							$frm_jenis = $row["jenis"];
							$frm_no_st_pub_now = $row["no_st_pub"];
							$frm_id_karyawan = $row["kode_kary"];
							$frm_golongan = $row["golongan"];
							$frm_status = $row["status"];
							$frm_jabatan_struktural = $row["jabatan_struktural"];
							$frm_TET = $row["TET_sub"];
							$frm_TNET = $row["TNET_sub"];
							$frm_tugas = $row["tugas"];
							$frm_hari_go = $row["hari_go"];
							
							if ($row["tgl_go"]=="00/00/0000") {
							$frm_tgl_go =""; }else {
							$frm_tgl_go =$row["tgl_go"];}
							
							$frm_pukul_go = $row["pukul_go"];
							$frm_tempat_go = $row["tempat_go"];
							$frm_transportasi_go = $row["transport_go"];
							$frm_hari_dtg = $row["hari_dtg"];
							
							if ($row["tgl_dtg"]=="00/00/0000") {
							$frm_tgl_dtg =""; }else {
							$frm_tgl_dtg =$row["tgl_dtg"];}
							
							$frm_pukul_dtg = $row["pukul_dtg"]; 
							$frm_transportasi_dtg = $row["transport_dtg"];
							
							$frm_pukul_dtg = $row["pukul_dtg"];
							$frm_biaya = $row["biaya"]; 
							$frm_ndt = $row["ndt_terakhir"]; 
							 
							
							echo "<br>frm_no_st_pub_now= ".$frm_no_st_pub_now;
							echo "<br>frm_id_karyawan= ".$frm_id_karyawan;
							echo "<br>frm_golongan= ".$frm_golongan;
							echo "<br>frm_status= ".$frm_status;
							echo "<br>frm_jabatan_struktural= ".$frm_jabatan_struktural;
							echo "<br>frm_TET= ".$frm_TET;
							echo "<br>frm_TNET= ".$frm_TNET;
							echo "<br>frm_tugas= ".$frm_tugas;
							echo "<br>frm_hari_go= ".$frm_hari_go;
							echo "<br>frm_tgl_go= ".$frm_tgl_go;
							echo "<br>frm_pukul_go= ".$frm_pukul_go;
							echo "<br>frm_tempat_go= ".$frm_tempat_go;
							echo "<br>frm_transportasi_go= ".$frm_transportasi_go;
							echo "<br>frm_hari_dtg= ".$frm_hari_dtg;
							echo "<br>frm_tgl_dtg= ".$frm_tgl_dtg;
							echo "<br>frm_pukul_dtg= ".$frm_pukul_dtg;
							echo "<br>frm_transportasi_dtg= ".$frm_transportasi_dtg;
						}
						else
						{
							$frm_exist=0;
							//$frm_no_st_pub_now="";
							$frm_id_karyawan="";
							$frm_golongan="";
							$frm_status="";
							$frm_jabatan_struktural="";
							$frm_TET="";
							$frm_TNET="";
							$frm_tugas="";
							$frm_tgl_go="";
							$frm_pukul_go=""; 
							$frm_tempat_go="";
							$frm_transportasi_go="";
							$frm_hari_dtg="";
							$frm_tgl_dtg="";
							$frm_pukul_dtg=""; 
							$frm_transportasi_dtg="";
							$frm_biaya="";
							$chk_airport="";
							$chk_fiskal="";
							$chk_visa="";
							$chk_uang_saku="";
							$chk_akomodasi="";
							$frm_lainnya="";
							$frm_ndt="";
							$frm_jenis="";
						}

}

}

?>
<html>
<head>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
</head>
<script language="JavaScript" src="../include/tanggalan.js">
</script>
<body class="body">
<form name="publikasi" id="publikasi" action="pen_st_publikasi_entry.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><img src="spacer" height="1"></td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4"> <hr size="1" color="#FF9900">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="89%"><font color="#0099CC" size="1"><strong>ENTRY DATA ~ </strong>SURAT TUGAS PUBLIKASI</font></td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">PENELITIAN</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="93">&nbsp;</td> 
      <td width="212">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="646"><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" ></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Jenis Surat Tugas </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <!--select name="frm_jenis" id="frm_jenis" class="tekboxku" onChange="document.publikasi.submit()"-->
	  <select name="frm_jenis" id="frm_jenis" class="tekboxku">
		<? if (isset($frm_jenis)) {?>
            <option value="1" <? if ($frm_jenis=="1") echo "selected"?>>satu orang</option>
            <option value="2" <? if ($frm_jenis=="2") echo "selected"?>>lebih dari satu</option>
            <? } else {?>
            <option value="">Pilih</option>
            <option value="1">satu orang</option>
            <option value="2">lebih dari satu</option>
        <? }?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>&nbsp;</td>
      <td><div align="center"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Nama</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <? 
	  //if (isset($frm_jenis) or ($frm_jenis!=""))
	 // {?>
		   <select name="frm_id_karyawan" id="frm_id_karyawan" class="tekboxku">
					<option <?php if ($frm_id_karyawan==''){echo "selected";}?>>-- NPK Dosen --</option>
					<?php
					$result1 = @mysql_query("Select id, kode, nama from master_karyawan WHERE kode NOT LIKE '66%' order by kode");
					$c=0;
					while ($row1=@mysql_fetch_object($result1))  {
					$c=$c+1;
					?>
					<option value="<?php echo $row1->kode; ?>" <?php if ($frm_id_karyawan==$row1->kode) { echo "selected"; }?> ><?php echo $row1->kode; ?> 
					- <?php echo $row1->nama; ?></option>
					<?php }?>
			</select> 
			<font color="#FF0000">*</font>
			<!--a href="#" onClick="return popitup('pen_st_publikasi_entry_cari_dosen.php')">C a r i</a-->
			<? 
		//}else{
			//echo "belum dipilih";
		//}?>
		</td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td nowrap>No ST publikasi sebelumnya</td>
      <td><div align="center"><strong>:</strong></div></td>
	  <? 
	  	$result_ST_last = mysql_query("SELECT no_st_pub, urut_st_pub FROM publikasi ORDER BY urut_st_pub DESC LIMIT 1");
		$row_ST_last = mysql_fetch_array($result_ST_last);
	  ?>
      <td><input name="frm_no_st_pub_lama" type="text" id="frm_no_st_pub_lama" size="15" maxlength="15" value="<?php echo $row_ST_last['no_st_pub']; ?>" class="tekboxku"> <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td nowrap>No ST publikasi sekarang </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_no_st_pub_now" id="frm_no_st_pub_now" type="text" onBlur="document.publikasi.submit()" value="<?php echo $frm_no_st_pub_now; ?>" size="15" maxlength="15" class="tekboxku">
      <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="25%">Golongan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  
 <? //if (isset($frm_jenis) or ($frm_jenis!=""))
  	//{?>
	  <select name="frm_golongan" id="frm_golongan" class="tekboxku">
        <?php
				 //f_connecting();
				 //mysql_select_db($DB);
				 $result3 = @mysql_query("SELECT * FROM kepangkatan");
				 $c=0;
				 while(($row3 = mysql_fetch_object($result3)))
				 {
				 	$c=$c+1;
				    //echo "<option value=".$row3["id"].">".$row3["nama"];
					?>
        <option  value="<?php echo $row3->id; ?>" <?php if (($frm_golongan==$row3->id) or (($frm_golongan=='') and ($c==1))) { echo "selected"; }?> ><?php echo $row3->nama; ?></option>
        <? }?>
      </select>
      <font color="#FF0000">*</font>
	  <? 
		//}else{
			//echo "belum dipilih";
		//}?>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="26%"><u>JABATAN</u></td>
          <td width="1%">&nbsp;</td>
          <td width="73%">&nbsp;</td>
        </tr>
        <tr>
          <td>Struktural</td>
          <td><div align="center"><strong>:</strong></div></td>
          <td>
		  <? // if (isset($frm_jenis) or ($frm_jenis!=""))
  		     //{?>
            <select name="frm_jabatan_struktural" id="frm_jabatan_struktural" class="tekboxku">
              <option <?php if ($frm_jabatan_struktural==''){echo "selected";}?>>-- Pilih --</option>
					<?php
					$result_js = @mysql_query("SELECT jabatan_struktural.id,
													  jabatan_struktural.jabatan
												 FROM jabatan_struktural
											 ORDER BY jabatan_struktural.jabatan ASC");
					$c=0;
					while ($row_js=@mysql_fetch_object($result_js))  {
					$c=$c+1;
					?>
					<option value="<?php echo $row_js->id; ?>" <?php if ($frm_jabatan_struktural==$row_js->id) { echo "selected"; }?> ><?php echo $row_js->jabatan; ?></option>
					<?php }?>
            </select>
              <font color="#FF0000">*</font> 
			<? 
			//else{
				//echo "belum dipilih";
			//}?>
		</td>
        </tr>
        <tr>
          <td nowrap>Fungsional</td>
          <td><div align="center"><strong>:</strong></div></td>
          <td><? //if (isset($frm_jenis) or ($frm_jenis!=""))
  				//{?>
				<select name="frm_jab_fung" id="frm_jab_fung" class="tekboxku">
					<option <?php if ($frm_jab_fung==''){echo "selected";}?>>-- Pilih --</option>
					<?php
					$result_jf = @mysql_query("SELECT jabatan_akademik.id,
													  jabatan_akademik.nama
												 FROM jabatan_akademik
											 ORDER BY jabatan_akademik.nama ASC");
					$c=0;
					while ($row_jf=@mysql_fetch_object($result_jf))  {
					$c=$c+1;
					?>
					<option value="<?php echo $row_jf->id; ?>" <?php if ($frm_jab_fung==$row_jf->id) { echo "selected"; }?> ><?php echo $row_jf->nama; ?></option>
					<?php }?>
				</select>
            <font color="#FF0000">*</font>
            <? 
		//}else{
			//echo "belum dipilih";
		//}?></td>
        </tr>
        <tr>
          <td nowrap>Sebagai TET Sub. Sistem </td>
          <td><div align="center"><strong>:</strong></div></td>
          <td><select name="frm_TET" id="select4" class="tekboxku">
            <option value="-"> -
            <?php
				 //f_connecting();
				 //mysql_select_db($DB);
				 $result3 = @mysql_query("SELECT * FROM jurusan");
				 $c=0;
				 while(($row3 = mysql_fetch_object($result3)))
				 {
				 	$c=$c+1;
				    //echo "<option value=".$row3["id"].">".$row3["nama"];
					?>
            <option  value="<?php echo $row3->id; ?>" <?php if (($frm_s_jurusan==$row3->id) or (($frm_s_jurusan=='') and ($c==1))) { echo "selected"; }?> ><?php echo $row3->jurusan; ?></option>
            <?
				 }
			?>
          </select>
            <font color="#FF0000">*</font></td>
        </tr>
        <tr>
          <td nowrap>Sebagai TNET Sub. Sistem </td>
          <td><div align="center"><strong>:</strong></div></td>
          <td>
		  <select name="frm_TNET" id="select5" class="tekboxku">
            <option value="-"> -
            <?php
				 //f_connecting();
				 //mysql_select_db($DB);
				 $result3 = @mysql_query("SELECT * FROM jurusan");
				 $c=0;
				 while(($row3 = mysql_fetch_object($result3)))
				 {
				 	$c=$c+1;
				    //echo "<option value=".$row3["id"].">".$row3["nama"];
					?>
            <option  value="<?php echo $row3->id; ?>" <?php if (($frm_s_jurusan==$row3->id) or (($frm_s_jurusan=='') and ($c==1))) { echo "selected"; }?> ><?php echo $row3->jurusan; ?></option>
            <? }?>
          </select>
            <font color="#FF0000">*</font></td>
        </tr>
        <tr>
          <td>Status</td>
          <td><div align="center"><strong>:</strong></div></td>
          <td><select name="frm_status" id="select6" class="tekboxku">
            <? if (isset($frm_status)) {?>
            <option value="Penyaji" <? if ($frm_status=="Penyaji") echo "selected"?>>Penyaji</option>
            <option value="Peserta" <? if ($frm_status=="Peserta") echo "selected"?>>Peserta</option>
            <? } else {?>
            <option>Pilih</option>
            <option value="Penyaji">Penyaji</option>
            <option value="Peserta">Peserta</option>
            <? }?>
          </select>
            <font color="#FF0000">*</font></td>
        </tr>
        <tr>
          <td width="26%" valign="top" nowrap>Tugas</td>
          <td valign="top"><div align="center"><strong>:</strong></div></td>
          <td><textarea name="frm_tugas" id="textarea" cols="50" class="tekboxku"><?php echo $frm_tugas; ?></textarea>
            <font color="#FF0000">*</font> </td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td><u>BERANGKAT</u></td>
          <td width="1%">&nbsp;</td>
          <td width="79%">&nbsp;</td>
        </tr>
        <tr>
          <td>Hari</td>
          <td><strong>:</strong></td>
          <td>
		   <select name="frm_hari_go" id="frm_hari_go" class="tekboxku">
				<? if (isset($frm_hari_go)) {?>
				<option value="Senin" <? if ($frm_hari_go=="Senin") echo "selected"?>>Senin</option>
				<option value="Selasa" <? if ($frm_hari_go=="Selasa") echo "selected"?>>Selasa</option>
				<option value="Rabu" <? if ($frm_hari_go=="Rabu") echo "selected"?>>Rabu</option>
				<option value="Kamis" <? if ($frm_hari_go=="Kamis") echo "selected"?>>Kamis</option>
				<option value="Jumat" <? if ($frm_hari_go=="Jumat") echo "selected"?>>Jumat</option>
				<option value="Sabtu" <? if ($frm_hari_go=="Sabtu") echo "selected"?>>Sabtu</option>
				<option value="Minggu" <? if ($frm_hari_go=="Minggu") echo "selected"?>>Minggu</option>
				<? } else {?>
				<option>Pilih</option>
				<option value="Senin">Senin</option>
				<option value="Selasa">Selasa</option>
				<option value="Rabu">Rabu</option>
				<option value="Kamis">Kamis</option>
				<option value="Jumat">Jumat</option>
				<option value="Sabtu">Sabtu</option>
				<option value="Minggu">Minggu</option>
				<? }?>
          </select>
            <font color="#FF0000">*</font></td>
        </tr>
        <tr>
          <td>Tanggal</td>
          <td><strong>:</strong></td>
          <td><input name="frm_tgl_go" type="text" class="tekboxku" id="frm_tgl_go" value="<?php echo $frm_tgl_go; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('publikasi.frm_tgl_go',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)  <font color="#FF0000">*</font></td>
        </tr>
        <tr>
          <td>Pukul</td>
          <td><strong>:</strong></td>
          <td><input name="frm_pukul_go" type="text" class="tekboxku" id="frm_pukul_go" value="<?php echo $frm_pukul_go; ?>" size="5" maxlength="5"></td>
        </tr>
        <tr>
          <td>Tempat</td>
          <td><strong>:</strong></td>
          <td><input name="frm_tempat_go" type="text" class="tekboxku" id="frm_tempat_go" value="<?php echo $frm_tempat_go; ?>" size="50" maxlength="50"></td>
        </tr>
        <tr>
          <td width="25%" valign="top" nowrap>Fasilitas Transportasi</td>
          <td valign="top"><strong>:</strong></td>
          <td>
		  <script language="javascript">
		  	function goo()
			{
				if (document.getElementById("frm_transportasi_go").value=="lainnya")
				{
					document.getElementById("frm_kend_lain").type=text;
				}
			}
		  </script> 
            
			<table width="100%"  border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="4%"><input name="frm_transportasi_go" id="frm_transportasi_go" type="radio" value="Pesawat" <? if ($frm_transportasi_go=="Pesawat") echo "checked";?>></td>
                <td width="23%">Pesawat</td>
                <td width="4%"><input name="frm_transportasi_go" id="frm_transportasi_go" type="radio" value="Kereta Api" <? if ($frm_transportasi_go=="Kereta Api") echo "checked";?>></td>
                <td width="22%" nowrap>Kereta Api </td>
                <td width="4%"><input name="frm_transportasi_go" id="frm_transportasi_go" type="radio" value="Mobil Dinas" <? if ($frm_transportasi_go=="Mobil Dinas") echo "checked";?>></td>
                <td width="43%" nowrap>Mobil Dinas </td>
              </tr>
              <tr>
                <td><input name="frm_transportasi_go" id="frm_transportasi_go" type="radio" value="Kendaraan Pribadi" <? if ($frm_transportasi_go=="Kendaraan Pribadi") echo "checked";?>></td>
                <td nowrap>Kendaraan Pribadi </td>
                <td>
					<script language="javascript">
					function cek_kend_go()
					{
						if (document.getElementById("chk_lainnya").checked==true)
						{
							document.getElementById("frm_lainnya").disabled=false;
							
						}
						else if (document.getElementById("chk_lainnya").checked==false)
						{
							document.getElementById("frm_lainnya").disabled=true;
							
						}
					}
					</script>
					<input name="frm_transportasi_go" id="frm_transportasi_go" type="radio" onChange="cek_kend_go" <? if ($var_transport_go=="Penyaji") echo "checked";?>>
				</td>
                <td colspan="3">
				Lainnya: 
                  <input name="frm_kend_go_lain" id="frm_kend_go_lain" type="text" class="tekboxku" size="40" maxlength="255" disabled="disabled"></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td><u>KEMBALI</u></td>
          <td width="1%">&nbsp;</td>
          <td width="79%">&nbsp;</td>
        </tr>
        <tr>
          <td>Hari</td>
          <td><strong>:</strong></td>
          <td>
		  <select name="frm_hari_dtg" id="frm_hari_dtg" class="tekboxku">
				<? if (isset($frm_hari_dtg)) {?>
				<option value="Senin" <? if ($frm_hari_dtg=="Senin") echo "selected"?>>Senin</option>
				<option value="Selasa" <? if ($frm_hari_dtg=="Selasa") echo "selected"?>>Selasa</option>
				<option value="Rabu" <? if ($frm_hari_dtg=="Rabu") echo "selected"?>>Rabu</option>
				<option value="Kamis" <? if ($frm_hari_dtg=="Kamis") echo "selected"?>>Kamis</option>
				<option value="Jumat" <? if ($frm_hari_dtg=="Jumat") echo "selected"?>>Jumat</option>
				<option value="Sabtu" <? if ($frm_hari_dtg=="Sabtu") echo "selected"?>>Sabtu</option>
				<option value="Minggu" <? if ($frm_hari_dtg=="Minggu") echo "selected"?>>Minggu</option>
				<? } else {?>
				<option>Pilih</option>
				<option value="Senin">Senin</option>
				<option value="Selasa">Selasa</option>
				<option value="Rabu">Rabu</option>
				<option value="Kamis">Kamis</option>
				<option value="Jumat">Jumat</option>
				<option value="Sabtu">Sabtu</option>
				<option value="Minggu">Minggu</option>
				<? }?>
          </select>
            <font color="#FF0000">*</font></td>
        </tr>
        <tr>
          <td>Tanggal</td>
          <td><strong>:</strong></td>
          <td><input name="frm_tgl_dtg" type="text" class="tekboxku" id="frm_tgl_dtg" value="<?php echo $frm_tgl_dtg; ?>" size="10" maxlength="10">
              <A Href="javascript:show_calendar('publikasi.frm_tgl_dtg',0,0,'DD/MM/YYYY')"> <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy) <font color="#FF0000">*</font></td>
        </tr>
        <tr>
          <td>Pukul</td>
          <td><strong>:</strong></td>
          <td><input name="frm_pukul_dtg" type="text" class="tekboxku" id="frm_pukul_dtg" value="<?php echo $frm_pukul_dtg; ?>" size="5" maxlength="5"></td>
        </tr>
        <tr>
          <td width="25%" nowrap>Fasilitas Transportasi</td>
          <td><strong>:</strong></td>
          <td>
		  
		  <select name="frm_transportasi_dtg" id="frm_transportasi_dtg" class="tekboxku">
				<? if (isset($frm_transportasi_dtg)) {?>
				<option value="Pesawat" <? if ($frm_transportasi_dtg=="Pesawat") echo "selected"?>>Pesawat</option>
				<option value="Mobil Universitas" <? if ($frm_transportasi_dtg=="Mobil Universitas") echo "selected"?>>Mobil Universitas</option>
				<option value="Mobil Fakultas" <? if ($frm_transportasi_dtg=="Mobil Fakultas") echo "selected"?>>Mobil Fakultas</option>
				<? } else {?>
				<option>Pilih</option>
				<option value="Pesawat">Pesawat</option>
				<option value="Mobil Universitas">Mobil Universitas</option>
				<option value="Mobil Fakultas">Mobil Fakultas</option>
				<? }?>
          </select>
            <font color="#FF0000">*</font></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" valign="top"><u>Pembiayaan yang diperlukan (berikan tanda check pada kotak/lengkapi isian yang tersedia)</u></td>
          </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">Biaya program (Rp/ US$) </td>
          <td valign="top"><strong>:</strong></td>
          <td><input name="frm_biaya" id="frm_biaya" type="text" class="tekboxku" size="20" maxlength="30" value="<?php echo $frm_biaya; ?>" ></td>
        </tr>
        <tr>
          <td width="25%" valign="top">Lain-lain </td>
          <td width="1%" valign="top"><strong>:</strong></td>
          <td width="79%"><table width="90%"  border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td width="21%"><input type="checkbox" name="chk_airport" id="chk_airport" <? if ($chk_airport=='on') echo "checked";?>>
                Airport Tax </td>
              <td width="8%">&nbsp;</td>
              <td width="71%"><input type="checkbox" name="chk_fiskal" id="chk_fiskal" <? if ($chk_fiskal==1) echo "checked";?>>
                Fiskal Luar Negeri </td>
              </tr>
            <tr>
              <td><input type="checkbox" name="chk_visa" id="chk_visa" <? if ($chk_visa==1) echo "checked";?>>
                Visa</td>
              <td>&nbsp;</td>
              <td><input type="checkbox" name="chk_uang_saku" id="chk_uang_saku" <? if ($chk_uang_saku==1) echo "checked";?>>
                Uang Saku (biaya hidup) </td>
              </tr>
            <tr>
              <td nowrap><input type="checkbox" name="chk_akomodasi" id="chk_akomodasi" <? if ($chk_akomodasi==1) echo "checked";?>>
                Akomodasi</td>
              <td>&nbsp;</td>
              <td>
			  	<script language="javascript">
				function cek()
				{
					if (document.getElementById("chk_lainnya").checked==true)
					{
						document.getElementById("frm_lainnya").disabled=false;
						
					}
					else if (document.getElementById("chk_lainnya").checked==false)
					{
						document.getElementById("frm_lainnya").disabled=true;
						
					}
				}
				</script>
			    <input type="checkbox" name="chk_lainnya" id="chk_lainnya" onClick="cek();">                  
                <input name="frm_lainnya" id="frm_lainnya" type="text" class="tekboxku" size="40" maxlength="255" disabled="disabled">
			  </td>
			  </tr>
          </table>
		  </td>
        </tr>
        <tr>
          <td nowrap>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="25%" valign="top" nowrap>Non degree training terakhir </td>
          <td valign="top"><strong>:</strong></td>
          <td>              <A Href="javascript:show_calendar('publikasi.frm_tgl_dtg',0,0,'DD/MM/YYYY')"> </A>
            <textarea name="frm_ndt" id="frm_ndt" cols="50" class="tekboxku"><?php echo $frm_ndt; ?></textarea></td>
        </tr>
      </table></td>
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
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" id="Submit" value="Simpan" onClick="this.form.action+='?act=1';this.form.submit();" class="tombol">
        <input type="reset" name="Submit2" id="Submit2" value="Batal" onClick="this.form.action+='?act=3';this.form.submit();" class="tombol">
        <?php if ($frm_no_st_pub_now) { ?>
        <input type="button" name="Submit3" id="Submit3" value="Hapus"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_no_st_pub_now;?>';this.form.submit()};" class="tombol">
        <?php } ?></td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" size="1">*</font><font size="1"> = 
        compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>