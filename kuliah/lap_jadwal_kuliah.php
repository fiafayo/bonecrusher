<?php
/* 
   DATE CREATED : 11/12/07
   KEGUNAAN     : MENAMPILKAN LAPORAN JADWAL KULIAH
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

// CEK AUTHENTIFIKASI USER
//if (!f_authenticate_user($USERNAME,$PASSWORD,$LOGGED))
//{
//	header("Location:http://".$HOSTNAME."/login.htm");
//	exit();
//}

f_connecting();
mysql_select_db($DB);
?>
<html>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<body class="body">
<?php

if ($mode=="" || $mode=="0") 
{
?>
<br>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#0099CC" size="1"><strong>LAPORAN 
    ~</strong>JADWAL KULIAH</font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">PERKULIAHAN</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form>
  <table width="100%" align="center" class="body" >
    <tr>
      <td width="11%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="69%">&nbsp;</td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>Periode</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_id_tahun_ajar" id="frm_id_tahun_ajar" class="tekboxku">
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
		  } ?> ><?php echo $row1->id; ?>SEMESTER <?php echo $row1->semester; ?> <?php echo $row1->tahun_ajaran; ?> - <?php echo $row1->tahun_ajaran+1; ?> </option>
        <?php
	}?>
      </select></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>Mata Kuliah </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
		  <select name="frm_MK" id="frm_MK" class="tekboxku">
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
	  </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>Hari Kuliah </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
		  <select name="frm_hari_kuliah" id="frm_hari_kuliah" class="tekboxku">
			<option value="all">Semua</option>
			<option value="1">Senin</option>
			<option value="2">Selasa</option>
			<option value="3">Rabu</option>
			<option value="4">Kamis</option>
			<option value="5">Jum'at</option>
			<option value="6">Sabtu</option>
		  </select>
	  </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>KP</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
		  <select name="frm_KP" id="frm_KP" class="tekboxku">
			<option value="all">Semua</option>
			<?php 
			$sql_KP="select DISTINCT KP
					   from usulan 
					   where KP<>''
					   ORDER BY KP ASC ";
			
			$result = @mysql_query($sql_KP);
			$c=0;
			while ($row=@mysql_fetch_object($result))  {
			$c=$c+1;
			?>
			<option value="<?php echo $row->KP; ?>" <?php if ($frm_KP==$row->KP) { echo "selected"; }?> > <?php echo $row->KP; ?></option>
			<?php
			}
			?>
		  </select>
	  </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>SKS</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  	  <select name="frm_SKS_MK" id="frm_SKS_MK" class="tekboxku">
        	<option value="all">Semua</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
          </select>
	  </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>Dosen</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_dosen" id="frm_dosen" class="tekboxku">
        <option value="all">Semua</option>
        <?php 
					$sqlDosen="select kode, nama
							   from dosen";
					
					$result = @mysql_query($sqlDosen);
					$c=0;
					while ($row=@mysql_fetch_object($result))  {
					$c=$c+1;
					?>
        <option value="<?php echo $row->kode; ?>" <?php if ($frm_dosen==$row->kode) { echo "selected";}?> > <?php echo $row->kode." - ".$row->nama; ?></option>
        <?php
			}
			?>
      </select>
	  
	  </td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td></td> 
      <td></td>
      <td>
	      <input type="hidden" name="mode" id="mode" value="2">
	      <input type="hidden" name="frm_s_jum_data" id="frm_s_jum_data" value="20">
	  </td>
      <td><input type="submit" value="Proses"  class="tombol"></td>
    </tr>
  </table>
</form>
<?
}
else
{
$sekarang=date("Y-m-d");        

$sql="SELECT distinct
			 rekap_dosen.kode_MK,
			 rekap_dosen.nama_MK,
			 rekap_dosen.sks,
			 rekap_dosen.kp,
			 rekap_dosen.kode_dsn,
			 rekap_dosen.nama_dsn,
			 rekap_dosen.id_periode,
			 mksem.HARI_K,
			 mksem.HARI_K2,
			 mksem.RUANG_K,
			 mksem.RUANG_K2,
			 mksem.JAM_KM,
			 mksem.JAM_KS,
			 mksem.JAM_KM2,
			 mksem.JAM_KS2
	    FROM rekap_dosen,mksem
	   WHERE rekap_dosen.kode_MK=mksem.KODEMK ";

	  
if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_id_tahun_ajar!="all")
		{ $sql=$sql." and (rekap_dosen.id_periode=".$frm_id_tahun_ajar.")"; }
		
	if ($frm_MK!="all")
		{ $sql=$sql." and (rekap_dosen.kode_MK='".$frm_MK."')"; }
		
	if ($frm_KP!="all")
		{ $sql=$sql." and (rekap_dosen.kp='".$frm_KP."')"; }
		
    if ($frm_SKS_MK!="all")
		{ $sql=$sql." and (rekap_dosen.sks=".$frm_SKS_MK.")"; }
		
	if ($frm_dosen!="all")
		{ $sql=$sql." and (rekap_dosen.kode_dsn='".$frm_dosen."')"; }
	
	if ($frm_hari_kuliah!="all")
		{ $sql=$sql." and (mksem.HARI_K=".$frm_hari_kuliah.") "; }
		
	//if ($frm_hari_kuliah!="all")
		//{ $sql=$sql." and (mksem.HARI_K=".$frm_hari_kuliah.") or (mksem.HARI_K2=".$frm_hari_kuliah.")"; }

//echo "<br>SQL= ".$sql;
	$sql=$sql." ORDER BY mksem.HARI_K,mksem.HARI_K2 ASC";

	
//echo "<br>SQL= ".$sql;
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
//}

$result=@mysql_query($sql);
$frm_s_jum_data=20;
$maxrows=mysql_num_rows($result);				
if($hal=="") { $hal=1; }
$recke=(($hal-1)*$frm_s_jum_data);
$limit="$recke,$frm_s_jum_data";
$jumhal=ceil($maxrows/$frm_s_jum_data);


$vlink="lap_jadwal_kuliah.php";
$abc="?mode=2&frm_id_tahun_ajar=$frm_id_tahun_ajar&frm_MK=$frm_MK&frm_KP=$frm_KP&frm_SKS_MK=$frm_SKS_MK&frm_dosen=$frm_dosen&frm_hari_kuliah=$frm_hari_kuliah&frm_s_jum_data=$frm_s_jum_data";

$vlink=$vlink.$abc;
$fontface="Verdana,Arial,Helvetica,sans-serif";
$fontsize="2";

$sql=$sql." limit ".$limit;
if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}


}	
//---------------------------------
echo "<br>frm_id_tahun_ajar=".$frm_id_tahun_ajar;
echo "<br>frm_MK=".$frm_MK;
echo "<br>frm_KP=".$frm_KP;
echo "<br>frm_SKS_MK=".$frm_SKS_MK;
echo "<br>frm_dosen=".$frm_dosen;
echo "<br>frm_hari_kuliah=".$frm_hari_kuliah;
?>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#0099CC" size="1"><strong>LAPORAN 
    ~</strong>JADWAL KULIAH</font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">PERKULIAHAN</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div><br>
<? //echo "frm_MK=".$frm_MK;?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="lap_jadwal_kuliah_export.php">
<input type="hidden" name="mode" id="mode" value="3">
<input type="hidden" name="frm_id_tahun_ajar" id="frm_id_tahun_ajar" value="<? echo $frm_id_tahun_ajar;?>">
<input type="hidden" name="frm_MK" id="frm_MK" value="<? echo $frm_MK;?>">
<input type="hidden" name="frm_KP" id="frm_KP" value="<? echo $frm_KP;?>">
<input type="hidden" name="frm_SKS_MK" id="frm_SKS_MK" value="<? echo $frm_SKS_MK;?>">
<input type="hidden" name="frm_dosen" id="frm_dosen" value="<? echo $frm_dosen;?>">
<input type="hidden" name="frm_hari_kuliah" id="frm_hari_kuliah" value="<? echo $frm_hari_kuliah;?>">
<?
if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=lap_jadwal_kuliah.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}
if ($frm_hari_kuliah<>'all')
{
	switch ($frm_hari_kuliah) {
				case 1:
					$nama_hari_kul='Senin';
					break;
				case 2:
					$nama_hari_kul='Selasa';
					break;
				case 3:
					$nama_hari_kul='Rabu';
					break;
				case 4:
					$nama_hari_kul='Kamis';
					break;
				case 5:
					$nama_hari_kul='Jumat';
					break;
				case 6:
					$nama_hari_kul='Sabtu';
					break;
				}
		echo "<i>Hari: ".$nama_hari_kul."</i><br>";
}

if ($frm_dosen<>'all')
{
	$sql_nama_dsn="SELECT kode, nama
				     FROM dosen
					 WHERE kode='".$frm_dosen."'";
					
					$res_nm_dsn= mysql_query($sql_nama_dsn);
					$row_nm_dsn = mysql_fetch_array($res_nm_dsn);
					
	echo "<i>Dosen: ".$row_nm_dsn['nama']."($frm_dosen)</i><br>";
}
 f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); 
?>
	<table width="100%"  border="1" cellspacing="0" cellpadding="5" class="table">
		  <tr bgcolor="#C6E2FF">
		    <td width="7%" nowrap><strong>Hari</strong></td>
		    <td width="16%" nowrap><strong>Jam</strong></td>
			<td width="11%" nowrap><strong>Kode MK</strong></td>
			<td width="12%" nowrap><strong>Nama MK</strong></td>
			<td width="5%" nowrap><strong>KP</strong></td>
			
			<td width="9%" nowrap><strong>Ruang</strong></td>
			<td width="15%" nowrap><strong>NPK Dosen </strong></td>
			<td width="17%" nowrap><strong>Nama Dosen </strong></td>
		  </tr>
<?

while(($row_m1 = mysql_fetch_array($result)))
{
			 switch ($row_m1["HARI_K"]) {
				case 1:
					$nama_hari_kul_m1='Senin';
					break;
				case 2:
					$nama_hari_kul_m1='Selasa';
					break;
				case 3:
					$nama_hari_kul_m1='Rabu';
					break;
				case 4:
					$nama_hari_kul_m1='Kamis';
					break;
				case 5:
					$nama_hari_kul_m1='Jumat';
					break;
				case 6:
					$nama_hari_kul_m1='Sabtu';
					break;
				}
				//echo $nama_hari_kul_m1;
				if ($row_m1["HARI_K2"]<>"")
				{
					$minggu='2';
				}
				else
				{
					$minggu='1';
				}
				
?>
			<tr>
			  <td nowrap valign="top"><? echo $nama_hari_kul_m1;?></td>
			  <td nowrap valign="top"><? echo $row_m1["JAM_KM"];?> - <? echo $row_m1["JAM_KS"]; ?></td>
			  <td nowrap valign="top"><? echo $row_m1["kode_MK"]; ?></td>
			  <td nowrap valign="top"><? echo $row_m1["nama_MK"]; ?></td>
			  <td nowrap valign="top"><? echo $row_m1["kp"]; ?></td>
			  <td nowrap valign="top"><? echo $row_m1["RUANG_K"]; ?></td>
			  <td nowrap valign="top"><? echo $row_m1["kode_dsn"]; ?></td>
			  <td nowrap valign="top"><? echo $row_m1["nama_dsn"]; ?></td>
		  </tr>
<?
}


//$a=0;
//minggu 2
while(($row_m2 = mysql_fetch_array($result)))
{
	//$a++;
			switch ($row_m2["HARI_K2"]) {
				case 1:
					$nama_hari_kul_m2='Senin';
					break;
				case 2:
					$nama_hari_kul_m2='Selasa';
					break;
				case 3:
					$nama_hari_kul_m2='Rabu';
					break;
				case 4:
					$nama_hari_kul_m2='Kamis';
					break;
				case 5:
					$nama_hari_kul_m2='Jumat';
					break;
				case 6:
					$nama_hari_kul_m2='Sabtu';
					break;
				}
				
				if ($row_m2["HARI_K2"]<>"")
				{
					$minggu='2';
				}
				else
				{
					$minggu='1';
				}
?>
			<tr>
			  <td nowrap valign="top"><? echo $nama_hari_kul_m2;?></td>
			  <td nowrap valign="top"><? echo $row_m2["JAM_KM2"];?> - <? echo $row_m2["JAM_KS2"]; ?></td>
			  <td nowrap valign="top"><? echo $row_m2["kode_MK"]; ?></td>
			  <td nowrap valign="top"><? echo $row_m2["nama_MK"]; ?></td>
			  <td nowrap valign="top"><? echo $row_m2["kp"]; ?></td>
			  <td nowrap valign="top"><? echo $row_m2["RUANG_K2"]; ?></td>
			  <td nowrap valign="top"><? echo $row_m2["kode_dsn"]; ?></td>
			  <td nowrap valign="top"><? echo $row_m2["nama_dsn"]; ?></td>
		  </tr>
<?
}
?>
	</table>
	<input name="excel"   type="image" onClick="document.fexcel.action='lap_jadwal_kuliah_export.php?t=excel'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
	Export ke File Excel&nbsp;
	<input name="printer" type="image"  onClick="document.fexcel.action='lap_jadwal_kuliah_export.php?t=printer'" src="../img/print.gif" align="bottom" width="18" height="18"> 
	Print
</FORM>
<?
}
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
</body>
</html>