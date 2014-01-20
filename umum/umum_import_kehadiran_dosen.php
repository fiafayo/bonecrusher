<?php
/* 
   DATE CREATED : 21/01/08 - RAHADI
   KEGUNAAN     : IMPORT KEHADIRAN DOSEN(rekap_dosen)
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ // simpan data
// validasi form

	/*if ($frm_add_penerbit=='')
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi data Master Penerbit dengan benar. Gagal menyimpan data.";
		}*/
	/*function cek_tabel($tabel, $DB)
	{
		
		$tabel =  mysql_list_tables($DB);
		while (list($temp)= mysql_fetch_array($tabel))
		{
			if($temp==$tabel){
				return TRUE;
				echo "<br-DB=".$DB;
			}
		}
		return FALSE;
	}
	$tabel="rekap_dosen";
	$DB="a_teknik";
	if (cek_tabel($tabel,$DB))
	{
		echo "<br>ADA";
	}
	else
	{
		echo "<br>TIDAK ADA";
		
	}*/
	
	$result = mysql_query("SHOW TABLES LIKE 'rekap_dosen_temp'");
	if (mysql_num_rows($result)==0)
	{
		$pesan="Tabel tidak tersedia. Silahkan hubungi administrator";
		$error = 1;
	}

	if ($error !=1) // tabel rekap_dosen tersedia
		{
			//$result_2 = mysql_query("UPDATE rekap_dosen,master_mk SET rekap_dosen.nama_MK=master_mk.nama
															//WHERE rekap_dosen.Kode_MK=master_mk.kode_mk");
			if ($pilih=='imp')   
			{
					//$res_import_rekap = mysql_query("INSERT INTO rekap_dosen_temp ( SELECT absensi.Kode_Mat,'', absensi.Sks, absensi.Kp, absensi.Kode_Dosen, '', 0, 0 ,0,0
					 //FROM absensi)");
						//echo "<br>frm_id_tahun_ajar=".$frm_id_tahun_ajar;
						
					$res_import_rekap = mysql_query("INSERT INTO rekap_dosen_temp ( SELECT absensi.Kode_Mat, '', absensi.Sks, absensi.Kp, absensi.Kode_Dosen, '', 0, count(absensi.Keterangan) ,0,'$frm_id_tahun_ajar' FROM absensi 
											               WHERE absensi.Keterangan='masuk' or absensi.Keterangan='pengganti'
														GROUP BY absensi.Kode_Mat,
																 absensi.Kode_Dosen,
																 absensi.Kp,
																 absensi.Keterangan)");
					if ($res_import_rekap) 
					{
						$pesan="Proses import tabel berhasil";
					}
					else
					{
						$error = 1;
						$pesan="Proses import table gagal. Tidak ada data baru yang ditambahkan.-". mysql_error();
					}
			}
			
			if ($pilih=='mk')
			{
					$res_upd_nama_mk = mysql_query("UPDATE rekap_dosen_temp,master_mk 
					                                   SET rekap_dosen_temp.nama_MK=master_mk.nama
												     WHERE rekap_dosen_temp.Kode_MK=master_mk.kode_mk");
			
					if ($res_upd_nama_mk) 
					{
						$pesan="Proses update tabel berhasil";
					}
					else
					{
						$error = 1;
						$pesan="Proses update tabel gagal. Tidak ada data yang dirubah.";
					}
			}
			
			if ($pilih=='dsn')
			{
					$res_upd_nama_dosen = mysql_query("UPDATE rekap_dosen_temp, dosen
														  SET rekap_dosen_temp.nama_dsn=dosen.nama
														WHERE rekap_dosen_temp.kode_dsn=dosen.kode");
					if ($res_upd_nama_dosen) 
					{
						$pesan="Proses update tabel berhasil";
					}
					else
					{
						$error = 1;
						$pesan="Proses update tabel gagal. Tidak ada data yang dirubah.";
					}					
			}
			
			
			if ($pilih=='seharusnya')
			{
					$res_upd_col_seharusnya_14 = mysql_query("UPDATE rekap_dosen_temp, mksem
															     SET rekap_dosen_temp.seharusnya=14
															   WHERE rekap_dosen_temp.kode_MK=mksem.KODEMK and
															         mksem.HARI_K2=0 and mksem.KODEMK<>''");	
																	 
					$res_upd_col_seharusnya_28 = mysql_query("UPDATE rekap_dosen_temp, mksem
															     SET rekap_dosen_temp.seharusnya=28
															   WHERE rekap_dosen_temp.kode_MK=mksem.KODEMK and
															         mksem.HARI_K2<>0 and mksem.KODEMK<>''");	
					
					if ($res_upd_col_seharusnya_14) 
					{
						$pesan="Proses update tabel berhasil.(R-SE14)";
						// (R-SE14)-> rekap_dosen kolom jumlah kehadiran seharusnya 14
					}
					else
					{
						$error = 1;
						$pesan="Proses update tabel gagal (R-SE14). Tidak ada data yang dirubah.";
					} 
					
					if ($res_upd_col_seharusnya_28) 
					{
						$pesan="Proses update tabel berhasil. (R-SE28)";
					}
					else
					{
						$error = 1;
						$pesan="Proses update tabel gagal (R-SE28). Tidak ada data yang dirubah.";
					}
			}    
			
			
			if ($pilih=='persen')
			{
					//$res_upd_persentase = mysql_query("UPDATE rekap_dosen_temp
														// SET rekap_dosen_temp.kehadiran=rekap_dosen_temp.seharusnya
													//   WHERE rekap_dosen_temp.kehadiran > rekap_dosen_temp.seharusnya");	 

					$res_upd_persentase = mysql_query("UPDATE rekap_dosen_temp
														  SET rekap_dosen_temp.persentasi=rekap_dosen_temp.kehadiran/rekap_dosen_temp.seharusnya*100");	 
																	 
					if ($res_upd_persentase) 
					{
						$pesan="Proses update tabel berhasil";
					}
					else
					{
						$error = 1;
						$pesan="Proses update tabel gagal. Tidak ada data yang dirubah.";
					} 
			}
			
	}
}


/*if ($act==2) { // hapus data

$result = mysql_query("delete from hari_ujian where id_kota = ".$frm_id_kota);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	*/
	
	
// Form dikosongkan siap untuk di isi data baru
/*if (($act!=0)and($error!=1)) {
    $frm_id_kota = "";
	$frm_add_penerbit= "";
}*/
if ($act==3) { // BATAL
//header("Location: umum_master_penerbit.php"); 

?>
<script language="JavaScript">
	//document.location="umum_master_penerbit.php";
</script>
<?
}

?>
<html>
<head>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<!--script language="JavaScript" src="../include/tanggalan.js">
</script-->
<body class="body">
<form name="form_import_hadir" id="form_import_hadir" action="umum_import_kehadiran_dosen.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><img src="spacer" height="1"></td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr>
      <td colspan="4"><hr size="1" color="#FF9900">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>ENTRY DATA ~</strong> IMPORT KEHADIRAN DOSEN</font></font> </td>
            <td width="9%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">UMUM</font></strong></div></td>
          </tr>
        </table>
      <hr size="1" color="#FF9900"></td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td width="15%">&nbsp;</td> 
      <td width="15%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="83%"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>1. Import tabel (<em>per periode</em>) </td>
      <td><strong>:</strong></td>
      <td>
	  <select name="frm_id_tahun_ajar" id="frm_id_tahun_ajar" class="tekboxku">
        <option value="all">Semua</option>
        <?php
			$result1 = @mysql_query("Select id, tahun_ajaran, semester, DATE_FORMAT(awal,'%Y/%m/%d') as awal, DATE_FORMAT(akhir,'%Y/%m/%d') as akhir from tahun_ajar order by id asc");
			$c=0;
			if ($frm_id_tahun_ajar=='') { $cek_id_tahun_ajar=$row1->id; }
			else { $cek_id_tahun_ajar=$frm_id_tahun_ajar; }
			while ($row1=@mysql_fetch_object($result1))  {
			$c=$c+1;
			if ( $row1->semester=="GASAL")
			{ $id_semester="1";}
			else
			{ $id_semester="2";}
		?>
        <option value="<?php echo $row1->tahun_ajaran."".$id_semester; ?>" <?php 
		  if ($frm_id_tahun_ajar!='') 
		  { 
		    if ($row1->id==$cek_id_tahun_ajar)
		    { echo "selected"; }
		  }
		  else
		  { if ((date('Y/m/d')<=$row1->akhir) and (date('Y/m/d')>=$row1->awal))
		    { $current_semester=$row1->id; 
			  echo "selected";
			} 
		  } ?> ><?php //echo $row1->id; ?>SEMESTER <?php echo $row1->semester; ?> <?php echo $row1->tahun_ajaran; ?> - <?php echo $row1->tahun_ajaran+1; ?> </option>
        <?php
	}?>
      </select>
      <input name="frm_import" id="frm_import" type="submit" class="tombol" onClick="this.form.action+='?act=1&pilih=imp';this.form.submit();" value="Import">  
      </td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>2. Proses update data nama MK </td>
	  <td><strong>:</strong></td>
	  <td><input name="frm_upd_nm_MK" id="frm_upd_nm_MK" type="submit" class="tombol" onClick="this.form.action+='?act=1&pilih=mk';this.form.submit();" value="Proses"></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>3. Proses update data nama dosen</td>
	  <td><strong>:</strong></td>
	  <td><input name="frm_upd_nm_dsn" id="frm_upd_nm_dsn" type="submit" class="tombol" onClick="this.form.action+='?act=1&pilih=dsn';this.form.submit();" value="Proses"></td>
    </tr>
	<tr>
	  <td>&nbsp;</td> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;	  </td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td nowrap>4. Proses update kolom seharusnya </td>
	  <td><strong>:</strong></td>
	  <td><input name="frm_upd_col_seharusnya" id="frm_upd_col_seharusnya" type="submit" class="tombol" onClick="this.form.action+='?act=1&pilih=seharusnya';this.form.submit();" value="Proses"></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td nowrap>5. Proses persentasi kehadiran</td>
	  <td><strong>:</strong></td>
	  <td><input name="frm_upd_persen" id="frm_upd_persen" type="submit" class="tombol" onClick="this.form.action+='?act=1&pilih=persen';this.form.submit();" value="Proses"></td>
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
	  <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><font size="1"><span class="style1">*</span> compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>