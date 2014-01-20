<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
/* 
   DATE CREATED : 30/05/07
   KEGUNAAN     : buat PROPOSAL CETAK PROPOSAL
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
include("../../include/temp.php");

f_connecting();
mysql_select_db($DB,$LINK);
        
$act=filterInput('act',0);     
$error=  filterInput( 'error', 0);     
$pesan=  filterInput( 'pesan');    
$frm_nrp=filterInput( 'frm_nrp');    
$frm_nama=filterInput( 'frm_nama');    
$frm_judul_ta=filterInput( 'frm_judul_ta');    
$frm_tgl_aju=filterInput( 'frm_tgl_aju', date('Y-m-d') );     
 
$frm_kode_dosen_1=filterInput( 'frm_kode_dosen_1');    
$frm_kode_dosen_2=filterInput( 'frm_kode_dosen_2');  
$frm_exist=filterInput( 'frm_exist');  

$n=strpos($frm_kode_dosen_2, 'Pilih');
if ( $n ){
    $frm_kode_dosen_2="";
}
 
 


if ($frm_nrp) {
    $mhsBaak = ambilDataMahasiswaDariSiska($frm_nrp);
} else {
    $mhsBaak=array(
        'KodeStatus'=>'',
        'IPKTanpaE'=>0,
        'SKSKumTanpaE'=>0
    );
}
 
$frm_sks_kum = $mhsBaak['SKSKumTanpaE'];
$kodeStatus = $mhsBaak['KodeStatus'];
if (( $kodeStatus!='A' ) && ( $frm_nrp ) && ($kodeErr!=1) ) {
    $pesan="Mahasiswa dengan nrp $frm_nrp statusnya tidak aktif, yaitu $kodeStatus";
    header("Location: mhs_proses_proposal.php?kodeErr=1&pesan=$pesan"); 
    exit();
}

if ($act==1)   
{ // simpan data
 

     // Kode dan nama harus diisi
	if (($frm_nrp=='') or ($frm_judul_ta=='') or ($frm_kode_dosen_1=='')  or ($frm_tgl_aju=='')) 
		{
			$error = 1; // isian ada yg tidak valid
			$pesan=$pesan."<br>Maaf, Anda harus mengisi data 'PROSES PROPOSAL TA' dengan lengkap. Gagal menyimpan data !";
		}
			
	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_exist!=1) 
				{
					$result = mysql_query("INSERT INTO master_ta (`NRP`,`JUDUL_TA`,`KODOS1`,`KODOS2`,`TGL_AJU`) VALUES ('".$frm_nrp."','".$frm_judul_ta."','".$frm_kode_dosen_1."','".$frm_kode_dosen_2."','".$frm_tgl_aju."') ",$LINK);
					if ($result) 
						{
							$pesan = $pesan."<br>Proses entry data baru, BERHASIL";	
						}
					else
						{ 
							$pesan = $pesan."<br>Proses entry data baru, GAGAL";
						}
				}
			else
				{
					$result = mysql_query("UPDATE master_ta set `JUDUL_TA`='$frm_judul_ta', 
												  `KODOS1`='$frm_kode_dosen_1', 
												  `KODOS2`='$frm_kode_dosen_2', 
												  `TGL_AJU` ='$frm_tgl_aju' 
										    WHERE `NRP`=$frm_nrp",$LINK);
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
	$result = mysql_query("DELETE FROM master_ta WHERE NRP = ".$frm_nrp,$LINK);
	if ($result) {$pesan = "Data telah dihapus";	}else{ $pesan = "Gagal menghapus data";}
}	
	
// jika data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist = 0;
	$frm_nrp = "";
	$frm_nama = "";
	$frm_judul_ta = "";
	$frm_kode_dosen_1 = "";
	$frm_kode_dosen_2 = "";
	$frm_tgl_aju =date("Y-m-d");
}
else
{
// jika user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_nrp!='')  {
        $sqlText = "SELECT	master_mhs.NRP,
									master_mhs.JURUSAN,
									master_mhs.NAMA,
									`master_ta`.`JUDUL_TA`,
									`master_ta`.`KODOS1`,
									`master_ta`.`KODOS2`,
									`master_ta`.`TGL_AJU` 
							   FROM `master_mhs` 
						  LEFT JOIN `master_ta` ON `master_mhs`.`NRP` = `master_ta`.`NRP`
							  WHERE `master_mhs`.`NRP` = '".$frm_nrp."'";
        //echo "<pre>$sqlText</pre>";
	$result = mysql_query($sqlText,$LINK);
	$row = mysql_fetch_array($result);
							if ($row) {
								$frm_exist = 1;
								$frm_nama = $row["NAMA"];
								$frm_judul_ta = $row["JUDUL_TA"];
								$frm_kode_dosen_1 = $row["KODOS1"];
								$frm_kode_dosen_2 = $row["KODOS2"];
								$frm_tgl_aju = $row["TGL_AJU"];
								
								if (($row["TGL_AJU"]=="0000-00-00") or ($row["TGL_AJU"]==""))
								{
									$frm_tgl_aju =date('Y-m-d');
									 
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
								//header("Location: mhs_proses_proposal.php"); 
							}
	
	if ($frm_kode_dosen_1!='') {
		$result = mysql_query("SELECT nama FROM master_karyawan WHERE kode='$frm_kode_dosen_1'",$LINK);
		$row = mysql_fetch_array($result);
		$frm_nama_dosen_1 = $row["nama"];
	}	
	
	if ($frm_kode_dosen_2!='') {
		$result = mysql_query("SELECT nama FROM master_karyawan WHERE kode='$frm_kode_dosen_2'",$LINK);
		$row = mysql_fetch_array($result);
		$frm_nama_dosen_2 = $row["nama"];
	}	
	
}
}

?>

<head>
<link href="../../css/style2.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<script language="JavaScript" src="../../include/tanggalan.js">
</script>
<body class="body">
<form name="mhs" id="mhs" action="mhs_proses_proposal.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><img src="spacer" height="1" /></td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4"> <hr size="1" color="#FF9900" /> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>ENTRY 
              DATA ~</strong> PROSES PROPOSAL TA</font></font> </td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900" />
	  </td>
    </tr>
    <tr>
      <td width="15%">&nbsp;</td> 
      <td width="15%">&nbsp;</td>
      <td width="3%">&nbsp;</td>
      <td width="83%"><input name="frm_exist" type="hidden" id="frm_exist"  value="<? echo $frm_exist;?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>NRP</td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="this.form.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="10" />
        <span class="style1">*
        <? if (isset($frm_nrp)) echo $frm_nama;?>
        </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td valign="top">Judul TA </td>
      <td valign="top"><div align="center"><strong>:</strong></div></td>
      <td><textarea name="frm_judul_ta" id="frm_judul_ta" cols="60" rows="2" class="tekboxku"><?php echo $frm_judul_ta; ?></textarea>
        <span class="style1">*</span>        </td>
    </tr>
    <tr>
      <td nowrap="true">&nbsp;</td> 
      <td nowrap="true">NPK Dosen 1</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
        	<select name="frm_kode_dosen_1" id="frm_kode_dosen_1" class="tekboxku">
           <option <?php if ($frm_kode_dosen_1==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sqlDosen="select kode, nama
						   from dosen  where (length(kode)=6) ORDER BY kode";
				
				$result = @mysql_query($sqlDosen,$LINK);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->kode; ?>" <?php if ($frm_kode_dosen_1==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
          <?php
				}
				
				?>
        </select>
		<span class="style1">*</span>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>NPK Dosen 2</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <select name="frm_kode_dosen_2" id="frm_kode_dosen_2" class="tekboxku">
           <option <?php if ($frm_kode_dosen_2==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sqlDosen="select kode, nama
						   from dosen  where (length(kode)=6) ORDER BY kode";
				
				$result = @mysql_query($sqlDosen,$LINK);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->kode; ?>" <?php if ($frm_kode_dosen_2==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
          <?php
				}
				
				?>
        </select>
		<span class="style1">*</span>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td nowrap="true">Tanggal Pengajuan </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_aju" type="hidden"   id="frm_tgl_aju" value="<?php echo $frm_tgl_aju; ?>"   /> 
          <?php echo dateToTanggalIndonesia($frm_tgl_aju); ?>
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
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
      <td><input type="submit" name="Submit" value="Simpan" onclick="this.form.action+='?act=1';this.form.submit();" class="tombol" /> 
        <input type="reset" name="Submit2" value="Batal" onclick="this.form.action+='?act=3';this.form.submit();" class="tombol" /> 
        <?php if ($frm_judul_ta) { ?>
        <input type="button" name="Submit3" value="Hapus"  onclick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_judul_ta;?>';this.form.submit()};" class="tombol" /> 
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