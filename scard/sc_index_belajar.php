<?
/* 
   DATE CREATED : 10/06/08
   UPDATE  		: 
   KEGUNAAN     : ENTRY RASIO DO MAHASISWA
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
	if ($frm_id_tahun_ajar=='') 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi Data dengan lengkap. ";
		}

	if ($error==1) 
		{
			$pesan=$pesan."<br>Gagal menyimpan data.";
		}
		
	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_exist!=1) 
				{
					/*echo "<br>INSERT";
					echo "<br>frm_exist=".$frm_exist;
					echo "<br>frm_id_tahun_ajar=".$frm_id_tahun_ajar;
					echo "<br>frm_ipk_dosen=".$frm_ipk_dosen;
					echo "<br>frm_jurusan=".$frm_jurusan;*/
					
					$result = mysql_query("INSERT INTO index_belajar_dosen (`id`, `semester`, `jurusan`, `kode_dosen`, `ipk_dsn`) VALUES ( NULL, ".$frm_id_tahun_ajar.", ".$frm_jurusan.", '".$frm_kode_dosen."', ".$frm_ipk_dosen.")");
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
					/*echo "<br>UPDATE";
					echo "<br>frm_id_idx_blj=".$frm_id_idx_blj;
					echo "<br>frm_id_tahun_ajar=".$frm_id_tahun_ajar;
					echo "<br>frm_ipk_dosen=".$frm_ipk_dosen;
					echo "<br>frm_jurusan=".$frm_jurusan;*/
					$result = mysql_query("UPDATE index_belajar_dosen SET `semester`=$frm_id_tahun_ajar, 
																		  `jurusan`=$frm_jurusan,
																		  `kode_dosen`='$frm_kode_dosen',
																		  `ipk_dsn`=$frm_ipk_dosen
																    WHERE `id`=$frm_id_idx_blj");
					
					if ($result) 
					{
						$pesan = $pesan."<br>Data telah diubah";	
					}
					else
					{ 
						$pesan = $pesan."<br>Gagal mengubah data-".mysql_error();
					}
				}
		}
	}


if ($act==2) { // hapus data

$result = mysql_query("DELETE FROM index_belajar_dosen WHERE id = ".$frm_id_idx_blj);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	

	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) 
{
	$frm_id_idx_blj = "";
	//$frm_jurusan=0;
	//$frm_id_tahun_ajar = 0;
	$frm_ipk_dosen = "";
	//$frm_id_tipe="";
	//$jum=0;
	if ($act==3) { 
		$frm_jurusan="";
		$frm_id_tahun_ajar = "0";
		$frm_ipk_dosen = "";
		$frm_kode_dosen = "";
	}
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
//echo "<br>frm_kode=".$frm_kode;
				if ((isset($frm_id_tahun_ajar)) and (isset($frm_jurusan))) 
				{
				if (($frm_id_tahun_ajar!=0) and ($frm_jurusan!=NULL)){
						$result = mysql_query("SELECT id, 
													  semester,
													  jurusan, 
													  kode_dosen, 
													  ipk_dsn
												 FROM index_belajar_dosen
												WHERE semester=".$frm_id_tahun_ajar." AND 
												      jurusan=".$frm_jurusan." AND
													  kode_dosen='".$frm_kode_dosen."'");
				
						if ($row = mysql_fetch_array($result)) {
							$frm_exist=1;
							$frm_id_idx_blj = $row["id"];
							$frm_id_tahun_ajar = $row["semester"];
							$frm_kode_dosen = $row["kode_dosen"];
							$frm_ipk_dosen = $row["ipk_dsn"];
							$frm_jurusan = $row["jurusan"];
						}
						else
						{
							$frm_exist=0;
							$frm_ipk_dosen ='';
						}
						$tahun=substr($frm_id_tahun_ajar, 0,4); 
						$semester=substr($frm_id_tahun_ajar, 4,1);
					}
			}
}
/*echo "<br>tahun=".$tahun; 
echo "<br>semester=".$semester; 
echo "<br>frm_id_tahun_ajar=".$frm_id_tahun_ajar; 
echo "<br>frm_jurusan=".$frm_jurusan; 
echo "<br>frm_id_idx_blj=".$frm_id_idx_blj;
echo "<br>frm_exist=".$frm_exist;*/
?>
<html>
<head>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../include/tanggalan.js">
</script>
</head>
<body class="body">
<form name="form_idx_blj" id="form_idx_blj" action="sc_index_belajar.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4"> <hr size="1" color="#FF9900">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="89%">
				<font color="#0099CC" size="1">
				<? if ($frm_id_idx_blj!=''){?>
					<strong>EDIT DATA ~ </strong>
				<? } else
				{?>
					<strong>ENTRY DATA ~ </strong>
				<? }?>
				INDEX PEMBELAJARAN DOSEN</font></td>
            <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">SCORE CARD</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="7%">&nbsp;</td> 
      <td width="13%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="79%">
		  <input type="hidden" name="frm_id_idx_blj" id="frm_id_idx_blj" value="<?php echo $frm_id_idx_blj;?>">
		  <input type="hidden" name="frm_exist" id="frm_exist" value="<?php echo $frm_exist;?>">
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Jurusan</td>
      <td><strong>:</strong></td>
      <td><select name="frm_jurusan" id="frm_jurusan" class="tekboxku">
        <option value="0" <?php if ($frm_jurusan==''){echo "selected";}?>>--- Pilih ---</option>
        <?php 
				$sql_jurusan="SELECT * FROM jurusan WHERE id>0 AND id<6";
				$result = @mysql_query($sql_jurusan);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
        <option value="<?php echo $row->id; ?>" <?php if ($frm_jurusan==$row->id) { echo "selected"; }?>> <?php echo $row->jurusan; ?></option>
        <?php
				}
				?>
      </select>
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Semester</td>
      <td><strong>:</strong></td>
      <td>
<select name="frm_id_tahun_ajar" id="frm_id_tahun_ajar" class="tekboxku">
  <option value="0">Tahun Ajaran</option>
  <?php
			$result1 = @mysql_query("Select id, tahun_ajaran, semester, DATE_FORMAT(awal,'%Y/%m/%d') as awal, DATE_FORMAT(akhir,'%Y/%m/%d') as akhir from tahun_ajar order by id DESC");
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
		    //if ($row1->id==$cek_id_tahun_ajar)
		   // { echo "selected"; }
			if (($row1->tahun_ajaran==$tahun) and ($id_semester==$semester))
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
<font color="#FF0000">*</font>	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Dosen</td>
      <td><strong>:</strong></td>
      <td><select name="frm_kode_dosen" id="frm_kode_dosen" class="tekboxku" onChange="document.form_idx_blj.submit()">
        <option <?php if ($frm_kode_dosen==''){echo "selected";}?>>--- Pilih ---</option>
        <?php 
				$sqlDosen="SELECT kode, nama
						   FROM dosen";
				
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
        <option value="<?php echo $row->kode; ?>" <?php if ($frm_kode_dosen==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
        <?php
				}
				
				?>
      </select>
      <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>IPK</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> <font color="#FF0000">
	  <? //onBlur="document.form_idx_blj.submit()" ?>
        <input name="frm_ipk_dosen" id="frm_ipk_dosen"  value="<? echo $frm_ipk_dosen;?>" type="text" class="tekboxku" size="4" maxlength="4" >
      *</font></td>
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
      <td>
		<input name="Submit" type="submit" class="tombol" onClick="this.form.action+='?act=1';this.form.submit();" value="Simpan">
		<input name="Submit2" type="reset" class="tombol" onClick="this.form.action+='?act=3';this.form.submit();" value="Batal">
		<?php if ($frm_id_idx_blj) { ?>
		<input name="Submit3" type="button" class="tombol"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&frm_id_idx_blj=<?php echo $frm_id_idx_blj;?>';this.form.submit()};" value="Hapus">
		<?php } ?>
	  </td>
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