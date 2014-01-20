<?php
session_start();
require("../include/global.php");
require("../include/fungsi.php");


f_connecting();
	mysql_select_db($DB);


if ($act==1)   
{ // simpan data

// Kode MK dan nama MK harus diisi
	if (($frm_kode_mk=='')||($frm_nama=='')||($frm_sks=='')||($frm_semester_ke=='')||($frm_id_kelompok=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi kode, nama mata kuliah, sks, semester, dan kelompok mata kuliah."; 
		}
		
	if ($error ==1) {
			$pesan=$pesan."<br>Gagal menyimpan data.";
					}
					
	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru		
			if ($frm_id=='') 
				{
					$result = mysql_query("INSERT INTO master_mk (`id`, `kode_mk`, `nama`, `jurusan`, `tahun_kur`, `sks`, `id_jenis`, `id_pembina`, `id_kelompok`, `status_kur`, `semester_ke`, `nilai_minimum`, `tujuan`, `id_belajar` ) VALUES ( NULL,'".$frm_kode_mk."', '".$frm_nama."', '".$frm_jurusan."', '".$frm_tahun_kur."', '".$frm_sks."', '".$frm_id_jenis."', '".$frm_id_pembina."', '".$frm_id_kelompok."', '".$frm_status_kur."', '".$frm_semester_ke."', '".$frm_nilai_minimum."', '".$frm_tujuan."',1) " );

	
					if ($result) 
						{
							$pesan = $pesan."<br>MK baru: ".$frm_nama." telah ditambahkan.";
							$master_mk_insert_id = mysql_insert_id();	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data ya ...";
							$master_mk_insert_id = 0;
						}
				}
			else
				{
					$result = mysql_query("UPDATE master_mk SET kode_mk='".$frm_kode_mk."',
					                                            nama='".$frm_nama."',
																jurusan='".$frm_jurusan."',
																tahun_kur='".$frm_tahun_kur."',
																sks='".$frm_sks."',
																id_jenis='".$frm_id_jenis."',
																id_pembina='".$frm_id_pembina."',
																id_kelompok='".$frm_id_kelompok."',
																status_kur='".$frm_status_kur."',
																nilai_minimum='".$frm_nilai_minimum."',
																semester_ke='".$frm_semester_ke."',
																tujuan='".$frm_tujuan."' 
														  WHERE id='".$frm_id."'");
					$master_mk_insert_id = $frm_id;	
				
					if ($result) 
					{
						$pesan = $pesan."<br>Data telah diubah";
					}
					else
					{ 
						$pesan = $pesan."<br>Gagal mengubah data";
					}

				}
/*$cekjml=0;
if (!empty( $frm_isbn ) or $master_mk_insert_id == 0) 
		{    
			foreach ($frm_isbn as $a => $value)
			{  //echo "Select count(*) as jumlah from mk_pemakai_buku, master_buku where mk_pemakai_buku.id_buku = master_buku.id and mk_pemakai_buku.id_master_mk='".$master_mk_insert_id."' and master_buku.isbn='".$frm_isbn[$a]."'";
				$result = mysql_query("Select count(*) as jumlah from mk_pemakai_buku, master_buku where mk_pemakai_buku.id_buku = master_buku.id and mk_pemakai_buku.id_master_mk='".$master_mk_insert_id."' and master_buku.isbn='".$frm_isbn[$a]."'");
				$row=mysql_fetch_array($result) ;
				
				$result1=mysql_query("Select id, kode_buku, judul from master_buku where isbn='".$frm_isbn[$a]."'");
				$row1=mysql_fetch_array($result1);
	
				if (($row["jumlah"]==0) and $row1["id"]!="") { 
				
					$resultBK = @mysql_query("INSERT INTO mk_pemakai_buku ( `id` , `id_master_mk`, `id_buku`, `tingkat_kepentingan` ) VALUES ( '', '".$master_mk_insert_id."', '".$row1["id"]."', '".$frm_tingkat_kepentingan[$a]."') " );
					
					if ($resultBK) 
						{
							$pesan .= "<br>".$row1["judul"]." telah ditambahkan pada database";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan buku ".$row1["judul"];
						}
				} //if ($row["jumlah"]==0) { 
				else
				{			$cekjml++;
							if ($cekjml > 1) 
							{
							$pesan .="<br>Buku ".$row1["judul"]." sudah ada pada buku referensi.";
							}
				}
				
			} // for each
		}
		else
		{
			$pesan = $pesan."<br>Gagal menambahkan data buku referensi";
		
		}
			
		}
	}

*/
}

}
if ($act==2) { // hapus data


if ($mhs!=1) {
$result = mysql_query("DELETE FROM master_mk WHERE id = ".$frm_id);

			if ($result) 
				{
					$pesan .= "<br>Data Master Mata Kuliah telah dihapus";	
				}
			else
				{ 
					$pesan .= "<br>Gagal menghapus data Master Mata Kuliah ";
				}
			
		/*	$result = mysql_query("delete from mk_pemakai_buku where id_master_mk = ".$frm_id);
			if ($result) 
				{
					$pesan .= "<br>Data buku referensi Mata Kuliah telah dihapus";	
				}
			else
				{ 
					$pesan .= "<br>Gagal menghapus data buku referensi Mata Kuliah ";
				}*/
 
  		}
		/*else // yang dihapus cuma mahasiswa tertentu
		{
		
		
			$result = mysql_query("delete from mk_pemakai_buku where id_master_mk='".$id_mk."' and  id_buku='".$id_buku."'");
			if ($result) 
				{
					$pesan .= "<br>Data buku referensi mata kuliah telah dihapus";	
				}
			else
				{ 
					$pesan .= "<br>Gagal menghapus data buku referensi mata kuliah";
				}
		}*/
}	
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
	
//if (($act!=0)and($error!=1)) {
	if (($act==3) or (($act==2) and ($mhs!=1)))
	{
		$frm_id="";
		$frm_kode_mk = "";
		$frm_nama = "";
		$frm_jurusan = "";
		$frm_tahun_kur = "";
		$frm_sks ="";
		$frm_id_jenis="";
		$frm_id_pembina="";
		$frm_id_kelompok ="";
		$frm_status_kur="";
		$frm_nilai_minimum="";
		$frm_semester_ke ="";
		$frm_tujuan = "";	
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
		if ($frm_kode_mk!='')  {
		  $sql = "SELECT master_mk.id,
						 master_mk.kode_mk,
						 master_mk.nama,
						 master_mk.jurusan,
						 master_mk.tahun_kur,
						 master_mk.sks,
						 master_mk.id_jenis,
						 master_mk.id_pembina,
						 master_mk.id_kelompok,
						 master_mk.status_kur,
						 master_mk.semester_ke,
						 master_mk.nilai_minimum,
						 master_mk.tujuan,
						 master_mk.id_belajar 
					FROM master_mk 
				   WHERE kode_mk='$frm_kode_mk'";
				  // if ($frm_jurusan!='') {
					// $sql .= " and jurusan='$frm_jurusan'"; }
		
					$result = mysql_query($sql);
				
					$row = mysql_fetch_array($result);
					$frm_id = $row["id"];
					$frm_nama = $row["nama"];
					$frm_jurusan = $row["jurusan"];
					$frm_tahun_kur = $row["tahun_kur"];
					$frm_sks = $row["sks"];
					$frm_id_jenis = $row["id_jenis"];
					$frm_id_pembina = $row["id_pembina"];
					$frm_id_kelompok = $row["id_kelompok"];
					$frm_status_kur = $row["status_kur"];
					$frm_semester_ke = $row["semester_ke"];
					$frm_nilai_minimum = $row["nilai_minimum"];
					$frm_tujuan = $row["tujuan"];
					//echo "<br>JUR= ".$row["jurusan"];
					/*echo "<br>frm_id= ".$frm_id;
					echo "<br>frm_nama= ".$frm_nama;
					echo "<br>frm_jurusan= ".$frm_jurusan;
					echo "<br>frm_tahun_kur= ".$frm_tahun_kur;
					echo "<br>frm_sks= ".$frm_sks;
					echo "<br>frm_id_jenis= ".$frm_id_jenis;
					echo "<br>frm_id_pembina= ".$frm_id_pembina;
					echo "<br>frm_id_kelompok= ".$frm_id_kelompok;
					echo "<br>frm_status_kur= ".$frm_status_kur;
					echo "<br>frm_semester_ke= ".$frm_semester_ke;
					echo "<br>frm_nilai_minimum= ".$frm_nilai_minimum;
					echo "<br>frm_tujuan= ".$frm_tujuan;*/
		}
}

?>
<html>
<head>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {
	font-size: 10px;
	font-weight: bold;
}
-->
</style>
</head>
<script language="JavaScript" src="../include/tanggalan.js">
</script>
<!--script language="JavaScript" src="../include/js_morefield.js">
</script-->
<body class="body">
<form name="formMK" id="formMK" action="umum_master_mk.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4"> <hr size="1" color="#FF9900"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>ENTRY 
              DATA ~</strong> MASTER MATA KULIAH</font></font> </td>
            <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MATA 
                KULIAH </font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="7%">&nbsp;</td> 
      <td width="16%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="76%">&nbsp; <input name="frm_id" type="hidden" id="frm_id"  value="<?php echo $frm_id; ?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Kode Mata Kuliah</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_kode_mk" type="text" id="frm_kode_mk" size="10" maxlength="10" value="<?php echo $frm_kode_mk; ?>" onBlur="document.formMK.submit()" class="tekboxku">
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nama Mata Kuliah</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nama" type="text" id="frm_nama" value="<?php echo $frm_nama; ?>" size="50" maxlength="50" class="tekboxku">
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>SKS</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_sks" type="text" id="frm_sks" value="<?php echo $frm_sks; ?>" size="2" maxlength="2" class="tekboxku">
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Jurusan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_jurusan" id="frm_jurusan" class="tekboxku">
          <option value="" >--Jurusan--</option>
          <?php
			$result1 = @mysql_query("Select id, jurusan from jurusan ORDER BY id ASC");
			while ($row1=@mysql_fetch_object($result1))  {
			?>
          <option value="<?php echo $row1->id; ?>" <?php if ($frm_jurusan==$row1->id) { echo "selected"; }?>    ><?php echo $row1->jurusan; echo $row1->id2; ?></option>
          <?php
			}
			
			?>
        </select>
        <span class="style1">*</span>        <u><span class="style2"><font color="#FF0000">PERHATIKAN JURUSANNYA !</font></span></u> 
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Jenis Mata Kuliah</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <select name="frm_id_jenis" id="frm_id_jenis" class="tekboxku">
          <option>--Jenis Mata Kuliah--</option>
          <?php
	
	$result1 = @mysql_query("Select id, nama from jenis_mk");
	$c=0;
	while ($row1=@mysql_fetch_object($result1))  {
	$c=$c+1;
	?>
          <option value="<?php echo $row1->id; ?>" <?php if ($frm_id_jenis==$row1->id)  { echo "selected"; }?> ><?php echo $row1->nama; ?></option>
          <?php
	}
	
	?>
        </select>
	  <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Pembina Mata Kuliah</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	    <select name="frm_id_pembina" id="frm_id_pembina" class="tekboxku">
          <option value="0">--Pembina Mata Kuliah--</option>
			<?php
			$result1 = @mysql_query("Select id, nama from pembina_mk");
			$c=0;
			while ($row1=@mysql_fetch_object($result1))  {
			$c=$c+1;
			?>
			<option value="<?php echo $row1->id; ?>" <?php if ($frm_id_pembina==$row1->id)  { echo "selected"; }?> ><?php echo $row1->nama; ?></option>
			<?php
			}
			?>
        </select>
      <span class="style1">*</span>	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tahun Kurikulum</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tahun_kur" class="tekboxku" type="text" id="frm_tahun_kur" value="<?php echo $frm_tahun_kur; ?>" size="4" maxlength="4"></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>Kelompok Mata Kuliah</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_id_kelompok" id="frm_id_kelompok" class="tekboxku">
          <option value="">--Kelompok Mata Kuliah--</option>
          <?php
			$result1 = @mysql_query("Select id, nama from kelompok_mk");
			$c=0;
			while ($row1=@mysql_fetch_object($result1))  {
			$c=$c+1;
			?>
          <option value="<?php echo $row1->id; ?>" <?php if ($frm_id_kelompok==$row1->id)  { echo "selected"; }?> ><?php echo $row1->nama; ?></option>
          <?php 
			}
			
			?>
        </select>
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Status Kurikulum </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_status_kur" id="frm_status_kur" type="radio" value="L" <?php if ($frm_status_kur=='L') { echo "checked"; }?>>
        Lokal 
        <input type="radio" name="frm_status_kur" id="frm_status_kur" value="N" <?php if (($frm_status_kur=='N')or($frm_status_kur=='')) { echo "checked"; }?>>
        Nasional</td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Semester</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_semester_ke" id="frm_semester_ke" type="text" value="<?php echo $frm_semester_ke; ?>" size="2" maxlength="2" class="tekboxku">
      <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nilai Minimum Lulus</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <select name="frm_nilai_minimum" id="frm_nilai_minimum" class="tekboxku">
          <option>Huruf</option>
		  <option value="C"  <?php if ($frm_nilai_minimum=='C'){ echo "selected";}?>>C</option>
          <option value="D" <?php if ($frm_nilai_minimum=='D'){ echo "selected";}?>>D</option>
      </select> </td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td> 
      <td valign="top">Tujuan</td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><textarea name="frm_tujuan" id="frm_tujuan" cols="50" rows="5" class="tekboxku"><?php echo $frm_tujuan; ?></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Simpan" onClick="this.form.action+='?act=1';this.form.submit();">
        <input type="reset" name="Submit2" value="Batal" onClick="this.form.action+='?act=3';this.form.submit();">
        <?php if ($frm_id) { ?>
        <input type="button" name="Submit3" value="Hapus"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_id;?>';this.form.submit()};">
        <?php } ?></td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;      </td>
    </tr>
    <tr> 
      <td colspan="4"><font size="1"><span class="style1">*</span> compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>