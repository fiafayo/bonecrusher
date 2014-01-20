<?php
/* 
   DATE CREATED : 25/01/08
   KEGUNAAN     : ENTRY REKAP KELULUSAN MK
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ // simpan data

     // Kode dan nama harus diisi 
	if (($frm_id_tahun_ajar=='') or ($frm_MK=='') or ($frm_KP=='') or ($frm_isi=='') or ($frm_a=='') or ($frm_ab=='') or ($frm_b=='') or ($frm_bc=='') or ($frm_c=='') or ($frm_d=='') or ($frm_e=='')) 
		{
			$error = 1; // isian ada yg tidak valid
			$pesan=$pesan."<br>Maaf, anda harus mengisi data 'KELULUSAN MATA KULIAH' dengan lengkap. Gagal menyimpan data !";
		}
			
	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_exist!=1) 
				{
					   $sql_MK="SELECT kode_mk, nama
							    FROM master_mk
								WHERE kode_mk='$frm_MK'";
					   $result_nama_MK = @mysql_query($sql_MK);
					   $row_nama_MK=@mysql_fetch_object($result_nama_MK);
						//$row_nama_MK->nama; 
					
					$result = mysql_query("INSERT INTO rekap_lulus_mk (`id_rlmk`,`id_periode`,`kode_mk`,`nama_mk`,`kp`,`isi`,`a`,`ab`,`b`,`bc`,`c`,`d`,`e`) 
					VALUES (NULL,".$frm_id_tahun_ajar.",'".$frm_MK."','".$row_nama_MK->nama."','".$frm_KP."',".$frm_isi.",".$frm_a.",".$frm_ab.",".$frm_b.",".$frm_bc.",".$frm_c.",".$frm_d.",".$frm_e.") ");
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
					$result = mysql_query("UPDATE rekap_lulus_mk 
										   set `id_periode`='$frm_id_tahun_ajar', 
											   `kode_mk`='$frm_MK', 
											   `nama_mk` ='".$row_nama_MK->nama."', 
											   `kp` ='$frm_KP',
											   `isi` ='$frm_isi',
											   `a` ='$frm_a',
											   `ab` ='$frm_ab',
											   `b` ='$frm_b',
											   `bc` ='$frm_bc',
											   `c` ='$frm_c',
											   `d` ='$frm_d',
											   `e` ='$frm_e' 
										   WHERE `id_rlmk`=$frm_id_rlmk");
					if ($result) 
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

$result = mysql_query("DELETE FROM rekap_lulus_mk WHERE id_rlmk = ".$frm_id_rlmk);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
// jika data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist = 0;
	//$frm_id_tahun_ajar = 0; 
	$frm_MK=""; 
	$frm_KP="";
	$frm_isi=0;
	$frm_a=0;
	$frm_ab=0;
	$frm_b=0;
	$frm_bc=0;
	$frm_c=0;
	$frm_d=0;
	$frm_e=0; 
	$frm_id_rlmk=0;
}
else
{
// jika user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
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
									 DATE_FORMAT(`master_ta`.`TGL_AJU`,'%d/%m/%Y') as TGL_AJU
							FROM
								`master_mhs` LEFT JOIN `master_ta` ON `master_mhs`.`NRP` = `master_ta`.`NRP`
							WHERE
								`master_mhs`.`NRP` =  '".$frm_nrp."'");
	
							if ($row = mysql_fetch_array($result)) {
								$frm_exist = 1;
								$frm_nama = $row["NAMA"];
								$frm_judul_ta = $row["JUDUL_TA"];
								$frm_kode_dosen_1 = $row["KODOS1"];
								$frm_kode_dosen_2 = $row["KODOS2"];
								$frm_tgl_aju = $row["TGL_AJU"];
								
								if (($row["TGL_AJU"]=="00/00/0000") or ($row["TGL_AJU"]==""))
								{
									$frm_tgl_aju = ""; 
									$frm_exist=0;
								}
								else 
								{
									$frm_tgl_aju =$row["TGL_AJU"];
								}
								
								/*if ($_POST['frm_judul_ta']!='')
								{	
									$frm_kode_dosen_1=$_POST['frm_kode_dosen_1'];
									$frm_kode_dosen_2=$_POST['frm_kode_dosen_2'];
									$frm_judul_ta=$_POST['frm_judul_ta'];
								}	*/
							}
							else
							{
								$frm_exist=0;
								header("Location: kul_rekap_lulus_mk.php"); 
							}
	
	if ($frm_kode_dosen_1!='') {
		$result = mysql_query("Select nama from master_karyawan where kode='$frm_kode_dosen_1'");
		$row = mysql_fetch_array($result);
		$frm_nama_dosen_1 = $row["nama"];
	}	
	
	if ($frm_kode_dosen_2!='') {
		$result = mysql_query("Select nama from master_karyawan where kode='$frm_kode_dosen_2'");
		$row = mysql_fetch_array($result);
		$frm_nama_dosen_2 = $row["nama"];
	}	
	
}
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
<script language="JavaScript" src="../include/tanggalan.js">
</script>
<body class="body">
<form name="form_kelulusan_MK" id="form_kelulusan_MK" action="kul_rekap_lulus_mk.php" method="post">
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
              DATA ~</strong> REKAP  KELULUSAN MATA KULIAH</font></font> </td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900">
	  </td>
    </tr>
    <tr>
      <td width="15%">&nbsp;</td> 
      <td width="15%">&nbsp;</td>
      <td width="3%">&nbsp;</td>
      <td width="83%"><input name="frm_exist" type="hidden" id="frm_exist"  value="<? echo $frm_exist;?>" ></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">Periode</td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_id_tahun_ajar" id="frm_id_tahun_ajar" class="tekboxku">
        <option>Tahun Ajaran</option>
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
		  } ?> ><?php echo $row1->id; ?>SEMESTER <?php echo $row1->semester; ?> <?php echo $row1->tahun_ajaran; ?> - <?php echo $row1->tahun_ajaran+1; ?>
        </option>
        <?php
	}
	
	?>
      </select>
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">Mata Kuliah </td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_MK" id="frm_MK" class="tekboxku">
        <option value="all">Semua</option>
        <?php 
			$sql_MK="select kode_mk, nama
					   from master_mk";
			
			$result = @mysql_query($sql_MK);
			$c=0;
			while ($row=@mysql_fetch_object($result))  {
			$c=$c+1;
			?>
        <option value="<?php echo $row->kode_mk; ?>" <?php if ($frm_MK==$row->kode_mk) { echo "selected"; }?> > <?php echo $row->kode_mk." - ".$row->nama; ?></option>
        <?php
				}
				?>
      </select>
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">KP</td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_KP" id="frm_KP" type="text" size="3" maxlength="3" class="tekboxku">
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">Jumlah</td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_isi" id="frm_isi" type="text" size="3" maxlength="3" class="tekboxku">
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>Nilai <strong>A</strong> </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_a" id="frm_a" type="text" size="3" maxlength="3" class="tekboxku">
        <span class="style1">*</span>
		</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Nilai <strong>AB</strong></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_ab" id="frm_ab" type="text" size="3" maxlength="3" class="tekboxku">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Nilai <strong>B</strong> </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_b" id="frm_b" type="text" size="3" maxlength="3" class="tekboxku">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Nilai <strong>BC</strong> </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_bc" id="frm_bc" type="text" size="3" maxlength="3" class="tekboxku">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Nilai <strong>C</strong> </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_c" id="frm_c" type="text" size="3" maxlength="3" class="tekboxku">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Nilai <strong>D</strong> </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_d" id="frm_d" type="text" size="3" maxlength="3" class="tekboxku">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Nilai <strong>E</strong> </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_e" id="frm_e" type="text" size="3" maxlength="3" class="tekboxku">
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
      <td><input type="submit" name="Submit" value="Simpan" onclick="this.form.action+='?act=1';this.form.submit();" class="tombol"> 
        <input type="reset" name="Submit2" value="Batal" onclick="this.form.action+='?act=3';this.form.submit();" class="tombol"> 
        <?php if ($frm_judul_ta) { ?>
        <input type="button" name="Submit3" value="Hapus"  onclick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_judul_ta;?>';this.form.submit()};" class="tombol"> 
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