<?php
/* 
   HISTORY      : 01/04/03 - SELESAI
						   - KALO COBA RUN JANGAN LUPA ISI QUERYSTRING frm_o1 - frm_o3
				  11/04/03 - BIKIN SATU SQL PANJANG 
				  08/06/03 - CUKUP QUALIFIED      

   DATE CREATED : 01/04/03
   LAST UPDATE  : 08/06/03 - KENNY
   KEGUNAAN     : MENAMPILKAN LAPORAN MASTER ALUMNI
   VARIABEL     : $frm_tgl_awal - parameter(GET) tgl awal lulus yang ingin ditampilkan
				  $frm_tgl_akhir - parameter(GET) tgl akhir lulus yang ingin ditampilkan 
				  $frm_o1, $frm_o2, $frm_o3 - parameter(GET) untuk order by perintah SQL
		
				  $sql, $result, $row - "select master_alumni.*,master_mhs.nama as nama, master_mhs.sex as sex, master_mhs.email as email, kota.nama as kota from master_alumni, master_mhs,kota where master_alumni.nrp=master_mhs.nrp and master_alumni.id_kota_perusahaan=kota.id"
				  
				  $a - untuk counter nomor laporan

   KETERANGAN   : PROSES CEK AUTHENTIFIKASI DICOMMENT UNTUK COBA JALANKAN
				  ADA MASALAH !! KALO KOTA SQL DIPISAH TIDAK BOSA SORTING,
				  KALO GABUNG, DATA GA DIISI TIDAK AKAN TAMPIL
				  IDE !! ADA KOTA DENGAN VALUE "TIDAK ADA DATA"
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
// CEK AUTHENTIFIKASI USER
//if (!f_authenticate_user($USERNAME,$PASSWORD,$LOGGED))
//{
//	header("Location:http://".$HOSTNAME."/login.htm");
//	exit();
//}
?>

<html>
<script language="JavaScript" src="../../include/tanggalan.js">
</script>
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<body class="body">
<br>
<?php


if ($mode=="" || $mode=="0") 
{
f_connecting();
mysql_select_db($DB);
?>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN ~</strong> DAFTAR ALUMNI</font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form>
  <table align="center" class="body" >
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td width="201">NRP</td>
      <td width="17"><strong>:</strong></td>
      <td width="414"><input type="text" name="frm_s_nrp_awal" id="frm_s_nrp_awal" class="tekboxku">
        - 
        <input type="text" name="frm_s_nrp_akhir" id="frm_s_nrp_akhir" class="tekboxku"></td>
    </tr>
    <tr> 
      <td>Jurusan</td>
      <td><strong>:</strong></td>
      <td><select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku">
        <option value="all">Semua
        <?php
				 $result2 = @mysql_query("SELECT * FROM `jurusan` WHERE `jurusan`.id>0 AND `jurusan`.id<=8");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["id2"].">".$row2["jurusan"];
	             }
         	?>
            </select>
		
		</td>
    </tr>
    <tr> 
      <td>Nama</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="frm_s_nama" id="frm_s_nama" class="tekboxku"></td>
    </tr>
    <tr> 
      <td>Jenis Kelamin </td>
      <td><strong>:</strong></td>
      <td> <select name="frm_s_sex" id="frm_s_sex" class="tekboxku">
          <option value="all">Semua 
          <option value="1">Laki-laki 
          <option value="2">Perempuan </select> </td>
    </tr>
    <tr> 
      <td>Tanggal Lulus</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="frm_s_tanggal_lulus1" id="frm_s_tanggal_lulus1" class="tekboxku">
        - 
        <input type="text" name="frm_s_tanggal_lulus2" id="frm_s_tanggal_lulus2" class="tekboxku">
        (dd/mm/yyyy) </td>
    </tr>
    <tr> 
      <td>Nama Perusahaan</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="frm_s_nama_perusahaan" id="frm_s_nama_perusahaan" class="tekboxku"></td>
    </tr>
    <tr> 
      <td>Kota Perusahaan</td>
      <td><strong>:</strong></td>
      <td> <select name="frm_s_kota" id="frm_s_kota" class="tekboxku">
          <option value="all">Semua 
          <?
			f_connecting();
			$sql2="select * from kota";
			if(!($result2=mysql_db_query($DB,$sql2)))
			{
				echo mysql_error();
        			return 0;
			}
			while(($row2 = mysql_fetch_array($result2)))
			{
				echo "<option value=".$row2["id_kota"].">".$row2["nama_kota"];
			}
?>
        </select> </td>
    </tr>
    <tr> 
      <td>Tanggal Mulai Bekerja</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="frm_s_tanggal_kerja1" id="frm_s_tanggal_kerja1" class="tekboxku">
        - 
        <input type="text" name="frm_s_tanggal_kerja2" id="frm_s_tanggal_kerja2" class="tekboxku"></td>
    </tr>
    <tr> 
      <td>Gaji Pertama</td>
      <td><strong>:</strong></td>
      <td>
		  <select name="frm_s_gaji1" id="frm_s_gaji1" class="tekboxku">
			  <?php
				$result5 = @mysql_query("Select id, gaji from gaji order by id ASC");
				$c=0;
				while ($row5=@mysql_fetch_object($result5))  {
				$c=$c+1;
				?>
					  <option value="<?php echo $row5->id; ?>" <?php if ($frm_gaji_pertama==$row5->id) { echo "selected"; }?> ><?php echo $row5->gaji; ?></option>
					  <?php
				}
				
				?>
		  </select> 
			<?php		
/*
		<input type="text" name="frm_s_gaji1"> - <input type="text" name="frm_s_gaji2">
*/
?>
      </td>
    </tr>
    <tr> 
      <td nowrap><i>Banyak Data yang ditampilkan</i></td>
      <td><strong>:</strong></td>
      <td> <select name="frm_s_jum_data" id="frm_s_jum_data" class="tekboxku">
          <option value=10>10 
          <option value=20>20 
          <option value=50>50 </select> </td>
    </tr>
    <tr> 
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td nowrap><b>KRITERIA PENGURUTAN DATA</b></td>
      <td></td>
      <td></td>
    </tr>
    <tr> 
      <td>Pengurutan 1</td>
      <td><strong>:</strong></td>
      	  <td> 
	      <select name="frm_o1" id="frm_o1" class="tekboxku">
          <option value="master_alumni.nrp">NRP</option> 
          <option value="master_alumni.nama">Nama</option> 
          <option value="master_alumni.tanggal_lulus">Tanggal Lulus</option> 
          <option value="master_alumni.tanggal_mulai_kerja">Tanggal Kerja</option> 
          <option value="master_alumni.gaji_pertama">Gaji Pertama</option>
		  </select> 
		  </td>
    </tr>
    <tr> 
      <td>Pengurutan 2</td>
      <td><strong>:</strong></td>
      <td><select name="frm_o2" id="frm_o2" class="tekboxku">
          <option value="master_alumni.nrp">NRP</option> 
          <option value="master_alumni.nama">Nama</option> 
          <option value="master_alumni.tanggal_lulus">Tanggal Lulus</option> 
          <option value="master_alumni.tanggal_mulai_kerja">Tanggal Kerja</option> 
          <option value="master_alumni.gaji_pertama">Gaji Pertama</option> 
		  </select> </td>
    </tr>
    <tr> 
      <td>Pengurutan 3</td>
      <td><strong>:</strong></td>
      <td><select name="frm_o3" id="frm_o3" class="tekboxku">
          <option value="master_alumni.nrp">NRP</option>
          <option value="master_alumni.nama">Nama</option> 
          <option value="master_alumni.tanggal_lulus">Tanggal Lulus</option> 
          <option value="master_alumni.tanggal_mulai_kerja">Tanggal Kerja</option> 
          <option value="master_alumni.gaji_pertama">Gaji Pertama</option> 
		  </select> </td>
    </tr>
    <tr> 
      <td></td>
      <td><input type="hidden" name="mode" id="mode" value="2"></td>
      <td><input type="submit" value="Proses" class="tombol"></td>
    </tr>
  </table>
</form>
<?
}
else
{
// JIKA MODE<>0 MAKSUDNYA JIKA FORM DI SUBMIT MAKA KELUAR LAPORAN
$sql="SELECT master_alumni.*,
             master_mhs.nama as nama, 
			 master_mhs.kelamin as kelamin, 
			 master_mhs.email as email,
			 master_mhs.kelamin,
			 master_mhs.jurusan
	    FROM master_alumni, 
	         master_mhs
	   WHERE master_alumni.nrp=master_mhs.nrp";

if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_s_nrp_awal!="" || $frm_s_nrp_akhir!="")
	{
		if ($frm_s_nrp_awal!="" && $frm_s_nrp_akhir!="")
		{
			$sql=$sql." and master_alumni.nrp>='".$frm_s_nrp_awal."' and master_alumni.nrp<='".$frm_s_nrp_akhir."'";
		}
		if ($frm_s_nrp_awal=="" && $frm_s_nrp_akhir!="")
		{
			$sql=$sql." and master_alumni.nrp<='".$frm_s_nrp_akhir."'";
		}
		if ($frm_s_nrp_awal!="" && $frm_s_nrp_akhir=="")
		{
			$sql=$sql." and master_alumni.nrp>='".$frm_s_nrp_awal."'";
		}
	} 
	if ($frm_s_nama!="")
	{ $sql=$sql." and master_mhs.nama like '".$frm_s_nama."%'"; }
	if ($frm_s_jurusan!="all")
	{ $sql .= " and master_mhs.jurusan='".$frm_s_jurusan."'";}
	if ($frm_s_sex!="all")
	{ $sql=$sql." and master_mhs.kelamin='".$frm_s_sex."'"; }
	
	if ($frm_s_tanggal_lulus1!="" || $frm_s_tanggal_lulus2!="")
	{  
		if($frm_s_tanggal_lulus1!="" && $frm_s_tanggal_lulus2!="")
		{ $sql=$sql." and master_alumni.tanggal_lulus between '".datetomysql($frm_s_tanggal_lulus1)."' and '".datetomysql($frm_s_tanggal_lulus2)."'"; }
		else
		{
			if($frm_s_tanggal_lulus1!="")
			{ $sql=$sql." and master_alumni.tanggal_lulus>='".datetomysql($frm_s_tanggal_lulus1)."'"; }
			if($frm_s_tanggal_lulus2!="")
			{ $sql=$sql." and master_alumni.tanggal_lulus<='".datetomysql($frm_s_tanggal_lulus2)."'"; }
		}
	}

	if ($frm_s_nama_perusahaan!="")
	{ $sql=$sql." and master_alumni.nama_perusahaan like '%".$frm_s_nama_perusahaan."%'"; }

	if ($frm_s_tanggal_kerja1!="" || $frm_s_tanggal_kerja2!="")
	{  
		if($frm_s_tanggal_kerja1!="" && $frm_s_tanggal_kerja2!="")
		{ $sql=$sql." and master_alumni.tanggal_mulai_kerja between '".datetomysql($frm_s_tanggal_kerja1)."' and '".datetomysql($frm_s_tanggal_kerja2)."'"; }
		else
		{
			if($frm_s_tanggal_kerja1!="")
			{ $sql=$sql." and master_alumni.tanggal_mulai_kerja >='".datetomysql($frm_s_tanggal_kerja1)."'"; }
			if($frm_s_tanggal_kerja2!="")
			{ $sql=$sql." and master_alumni.tanggal_mulai_kerja <='".datetomysql($frm_s_tanggal_kerja2)."'"; }
		}
	}
	
	if ($frm_s_gaji1!="1")
	{
		if ($frm_s_gaji1!="")
		{
		    $sql=$sql." and master_alumni.gaji_pertama='".$frm_s_gaji1."'";
		}
	}
	
	/*if ($frm_s_gaji1!="1" || $frm_s_gaji2!="")
	{
		if ($frm_s_gaji1!="" && $frm_s_gaji2!="")
		{
		    $sql=$sql." and master_alumni.gaji_pertama='".$frm_s_gaji1."'";
//			$sql=$sql." and master_alumni.gaji_pertama>='".$frm_s_gaji1."' and master_alumni.nrp<='".$frm_s_gaji2."'";
		}
		if ($frm_s_gaji1=="" && $frm_s_gaji2!="")
		{
			$sql=$sql." and master_alumni.gaji_pertama<='".$frm_s_gaji2."'";
		}
		if ($frm_s_gaji1!="" && $frm_s_gaji2=="")
		{
			$sql=$sql." and master_alumni.gaji_pertama>='".$frm_s_gaji1."'";
		}
	}*/ 
	
	$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
}

f_connecting();

// UNTUK PAGING --------------------------------
if ($mode=="2")
{
//echo "SQL=<br>".$sql;
mysql_select_db($DB);
$result=@mysql_query($sql);
$maxrows=mysql_num_rows($result);				
if($hal=="") { $hal=1; }
$recke=(($hal-1)*$frm_s_jum_data);
$limit="$recke,$frm_s_jum_data";
$jumhal=ceil($maxrows/$frm_s_jum_data);
//echo $frm_tanggal_lulus1;
$vlink="lap_alumni.php";
$abc="?mode=2&frm_s_nrp_awal=$frm_s_nrp_awal&frm_s_jurusan=$frm_s_jurusan&frm_s_nrp_akhir=$frm_s_nrp_akhir&frm_s_nama=$frm_s_nama&frm_s_sex=$frm_s_sex&frm_s_tanggal_lulus1=$frm_s_tanggal_lulus1&frm_s_tanggal_lulus2=$frm_s_tanggal_lulus2&frm_s_kota=$frm_s_kota&frm_s_nama_perusahaan=$frm_s_nama_perusahaan&frm_s_tanggal_kerja1=$frm_s_tanggal_kerja1&frm_s_tanggal_kerja2=$frm_s_tanggal_kerja2&frm_s_gaji1=$frm_s_gaji1&frm_s_gaji2=$frm_s_gaji2&frm_s_jum_data=$frm_s_jum_data&frm_o1=$frm_o1&frm_o2=$frm_o2&frm_o3=$frm_o3";

$vlink=$vlink.$abc;

$fontface="Verdana,Arial,Helvetica,sans-serif";
$fontsize="2";
}
// SELESAI MBULETNYA PAGING ------------------------------
// JIKA MODE HASIL LAPORAN DI MONITOR MAKA PAGING IN ACTION
if ($mode=="2") { $sql=$sql." limit ".$limit; }
if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}
?>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN 
      ~</strong> ALUMNI 
	  <?
if (isset($frm_s_jurusan))
{
	switch ($frm_s_jurusan)
	{
		case 'all':
			echo "Semua Jurusan";
			break;
		case '6b':
			echo "Jurusan Teknik Elektro";
			break;
		case '6C':
			echo "Jurusan Teknik Kimia";
			break;
		case '6D':
			echo "Jurusan Teknik Industri";
			break;
		case '6E':
			echo "Jurusan Teknik Informatika";
			break;
		case '6F':
			echo "Jurusan Teknik Manufaktur";
			break;
		case '6G':
			echo "Desain Manajemen Produk";
			break;			
		case '6H':
			echo "Sistem Informasi";
			break;			
		case '6I':
			echo "Multimedia";
			break;			
		case '6J':
			echo "Dual Degree";
			break;			
		case '0':
			echo "Semua Jurusan";
			break;
		case '1':
			echo "Jurusan Teknik Elektro";
			break;
		case '2':
			echo "Jurusan Teknik Kimia";
			break;
		case '3':
			echo "Jurusan Teknik Industri";
			break;
		case '4':
			echo "Jurusan Teknik Informatika";
			break;
		case '5':
			echo "Jurusan Teknik Manufaktur";
			break;
		case '6':
			echo "Desain Manajemen Produk";
			break;			
		case '7':
			echo "Sistem Informasi";
			break;			
		case '8':
			echo "Multimedia";
			break;			
		case '9':
			echo "Dual Degree";
			break;			
	}
}
?>
	  </font></font> </td>
    <td width="11%"><div align="center"><strong></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<br>
<?
if ($frm_s_tanggal_lulus1!="" || $frm_s_tanggal_lulus2!="")
{
?>
	<b>TANGGAL LULUS : <? echo $frm_s_tanggal_lulus1; ?> s/d <? echo $frm_s_tanggal_lulus2; ?></b><br>
<?
}
?>
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div><br>
<?

if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="lap_alumni_export.php">
<input type="hidden" name="mode" value="3">
<input type="hidden" name="frm_s_nrp_awal" id="frm_s_nrp_awal" value="<?php echo  $frm_s_nrp_awal;?>">
<input type="hidden" name="frm_s_nrp_akhir" id="frm_s_nrp_akhir" value="<?php echo $frm_s_nrp_akhir;?>">
<input type="hidden" name="frm_s_nama" id="frm_s_nama" value="<?php echo $frm_s_nama; ?>">
<input type="hidden" name="frm_s_sex" id="frm_s_sex" value="<?php echo $frm_s_sex; ?>">
<input type="hidden" name="frm_s_tanggal_lulus1" id="frm_s_tanggal_lulus1" value="<?php echo $frm_s_tanggal_lulus1;?>">
<input type="hidden" name="frm_s_tanggal_lulus2" id="frm_s_tanggal_lulus2" value="<?php echo $frm_s_tanggal_lulus2;?>">
<input type="hidden" name="frm_s_kota" id="frm_s_kota" value="<?php echo $frm_s_kota; ?>">
<input type="hidden" name="frm_s_nama_perusahaan" id="frm_s_nama_perusahaan" value="<?php echo $frm_s_nama_perusahaan; ?>">
<input type="hidden" name="frm_s_tanggal_kerja1" id="frm_s_tanggal_kerja1" value="<?php echo $frm_s_tanggal_kerja1;?>">
<input type="hidden" name="frm_s_tanggal_kerja2" id="frm_s_tanggal_kerja2" value="<?php echo $frm_s_tanggal_kerja2;?>">
<input type="hidden" name="frm_s_gaji1" id="frm_s_gaji1" value="<?php echo $frm_s_gaji1;?>">
<input type="hidden" name="frm_s_jum_data" id="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<input type="hidden" name="frm_o1" id="frm_o1" value="<?php echo $frm_o1; ?>">
<input type="hidden" name="frm_o2" id="frm_o2" value="<?php echo $frm_o2; ?>">
<input type="hidden" name="frm_o3" id="frm_o3" value="<?php echo $frm_o3; ?>">
<input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">

<?
}
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
<table width="100%"  border="1" cellspacing="0" cellpadding="5" class="table">
		  <tr bgcolor="#C6E2FF">
		    <td>Edit</td>
			<td>Hapus</td>
			<td><strong>NRP</strong></td>
			<td nowrap><strong>Nama</strong></td>
			<td nowrap><strong>Jurusan</strong></td>
			<td nowrap><strong>Jenis Kelamin </strong></td>
			<td nowrap><strong>Tgl. Lulus </strong></td>
			<td nowrap><strong>Nama Perusahaan</strong></td>
			<td nowrap><strong>Alamat Perusahaan</strong></td>
			<td nowrap><strong>Telp. Perusahaan </strong></td>
			<td nowrap><strong>Jabatan</strong></td>
			<td nowrap><strong>Tgl. Mulai Kerja </strong></td>
		    <td nowrap><strong>Gaji Pertama </strong></td>
		  </tr>
<?
$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
?>
          <tr>
            <td align="center"><input name="edit"   type="image" onClick="document.fexcel.action='master_alumni.php?frm_nrp=<? echo $row["nrp"]; ?>'" src="../../img/edit.png" width="12" height="12"></td> 
            <td align="center"><input name="hapus"  onClick="if(confirm('Hapus ?')){this.form.action='master_alumni.php?act=2&frm_nrp=<? echo $row["nrp"]; ?>';this.form.submit()};" type="image" src="../../img/hapus.png" width="12" height="12"></td>
            <td><? echo $row["nrp"]; ?></td>
			<td nowrap><? echo $row["nama"]; ?></td>
			<td nowrap><? //echo $row["jurusan"];
					switch ($row["jurusan"])
					{
						case "6B":
							echo "Teknik Elektro";
							break;
						case "6C":
							echo "Teknik Kimia";
							break;
						case "6D":
							echo "Teknik Industri";
							break;
						case "6E":
							echo "Teknik Informatika";
							break;
						case "6F":
							echo "Teknik Manufaktur";
							break;
						case '6G':
							echo "Desain Manajemen Produk";
							break;			
						case '6H':
							echo "Sistem Informasi";
							break;			
						case '6I':
							echo "Multimedia";
							break;			
						case '6J':
							echo "Dual Degree";
							break;										
							
					}
				?></td>
			<td nowrap>
			<? 
			if ($row["kelamin"]==1)
			{ echo "Laki-laki"; }
			else if ($row["kelamin"]==2)
			{ echo "Perempuan"; }
			?>
			</td>
			<td nowrap><? echo datetoreport($row["tanggal_lulus"]); ?></td>
			<td nowrap><? echo $row["nama_perusahaan"]; ?></td>
			<td nowrap><? echo $row["alamat_perusahaan"]; ?></td>
            <td nowrap><? echo $row["telepon_perusahaan"]; ?> </td>
            <td nowrap><? echo $row["jabatan"]; ?></td>
            <td nowrap><? if ($row["tanggal_mulai_kerja"])
				       {
				         echo datetoreport($row["tanggal_mulai_kerja"]); 
				   	   } else
					   { echo "-";
					   } ?></td>
            <td nowrap><? 	
				  $sqlGaji= "select * from gaji where id=".$row["gaji_pertama"];
				  $hasil = @mysql_query($sqlGaji);
				  $baris = @mysql_fetch_array($hasil);
				  if ($baris["gaji"]!='')
				  {
                    echo $baris["gaji"]; 
				  }
				  else
				  { echo "-";
				  }?></td>
          </tr>
<?
}
?>
        </table>
  
   <input name="excel" onClick="document.fexcel.action='lap_alumni_export.php?t=excel'"   type="image" src="../../img/Mexcel.jpg" width="18" height="18"> Export ke File Excel
    <input name="printer"  onClick="document.fexcel.action='lap_alumni_export.php?t=printer'" type="image" src="../../img/print.gif" width="18" height="18"> Print
</FORM>
<?
}
?>
<?
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
</body>
</html>