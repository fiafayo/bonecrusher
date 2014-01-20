<?php
/* 
   DATE CREATED : 12/12/07
   KEGUNAAN     : MENAMPILKAN LAPORAN JADWAL UJIAN
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");
f_connecting();
mysql_select_db($DB);
?>
<html>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<body class="body">
<br>
<?		  
/*	  
if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)

	if ($frm_ruang_ujian!="all")
		{ $sql=$sql." and (`mksem`.`RUANG_U`='".$frm_ruang_ujian."')"; }
		
	if ($frm_minggu!="all")
		{ 
			if ($frm_minggu=="1")
			{
				$sql=$sql." and ((`mksem`.`HARI_U` > 0) and (`mksem`.`HARI_U` <= 7))"; 
				//echo "<br>1. ";
				//exit();
			}
			if ($frm_minggu=="2")
			{
				$sql=$sql." and ((`mksem`.`HARI_U`>7) and (`mksem`.`HARI_U`<=14))"; 
				//echo "<br>2. ";
				//exit();
			}
			if ($frm_minggu=="3")
			{
				$sql=$sql." and ((`mksem`.`HARI_U`>14) and (`mksem`.`HARI_U`<=21))"; 
				//echo "<br>3. ";
				//exit();
			}
		}
		
	if ($frm_hari_ujian!="all")
		{ $sql=$sql." and (`mksem`.`HARI_U`=".$frm_hari_ujian.")"; }
		
    if ($frm_jam_UM!="all")
		{ $sql=$sql." and (`mksem`.`JAM_UM`='".$frm_jam_UM."')"; }
		
	if ($frm_jam_US!="all")
		{ $sql=$sql." and (`mksem`.`JAM_US`='".$frm_jam_US."')"; }

	
//echo "<br>SQL= ".$sql;
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
	echo "<br>frm_hari_ujian= ".$frm_hari_ujian;
}

// UNTUK PAGING --------------------------------
if ($mode=="2")
{

$result=@mysql_query($sql);
//$frm_s_jum_data=20;
$maxrows=mysql_num_rows($result);				
if($hal=="") { $hal=1; }
$recke=(($hal-1)*$frm_s_jum_data);
$limit="$recke,$frm_s_jum_data";
$jumhal=ceil($maxrows/$frm_s_jum_data);


$vlink="lap_jadwal_ujian.php";
$abc="?mode=2&frm_s_jum_data=$frm_s_jum_data&frm_ruang_ujian=$frm_ruang_ujian&frm_minggu=$frm_minggu&frm_hari_ujian=$frm_hari_ujian&frm_jam_UM=$frm_jam_UM&frm_jam_US=$frm_jam_US";

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
}*/
//---------------------------------
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
<?
/*if ($frm_s_jurusan!="all")
	{
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id='".$frm_s_jurusan."'";
		$result_jur = @mysql_query($sql_jur);
		$row_jur=@mysql_fetch_array($result_jur);
		echo "<b>Jurusan: </b>".$row_jur["nama_jur"];
	}
	else
	{
		echo "<b>Jurusan: </b>Semua";
	}*/

if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="lap_jadwal_ujian.php">
<input type="hidden" name="mode" id="mode" value="3">
<input type="hidden" name="frm_ruang_ujian" id="frm_ruang_ujian" value="<? echo $frm_ruang_ujian;?>">
<input type="hidden" name="frm_minggu" id="frm_minggu" value="<? echo $frm_minggu;?>">
<input type="hidden" name="frm_hari_ujian" id="frm_hari_ujian" value="<? echo $frm_hari_ujian;?>">
<input type="hidden" name="frm_jam_UM" id="frm_jam_UM" value="<? echo $frm_jam_UM;?>">
<input type="hidden" name="frm_jam_US" id="frm_jam_US" value="<? echo $frm_jam_US;?>">
<?
}
/*if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=lap_jadwal_ujian.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}*/
if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
	Minggu ke -1
	<table width="100%"  border="1" cellspacing="0" cellpadding="5" class="table_ujian">
      <tr bgcolor="#C6E2FF">
        <td width="12%" nowrap>JAM&nbsp; \ HARI</td>
        <td width="15%" nowrap><strong>Senin</strong></td>
        <td width="17%" nowrap><strong>Selasa</strong></td>
        <td width="15%" nowrap><strong>Rabu</strong></td>
        <td width="14%" nowrap><strong>Kamis</strong></td>
        <td width="15%" nowrap><strong>Jumat</strong></td>
        <td width="12%" nowrap><strong>Sabtu</strong></td>
      </tr>
      
	  <tr>
        <td nowrap valign="top"><strong>ke-1</strong> (07.30)</td>
		<td valign="top" nowrap>
		<? //JAM ke - 1 senin
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=7.3 and mksem.HARI_U=1";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
			 echo "- ";
			 echo $row["nama_MK"]."<br>";
		
		 }?>
		</td>
        <td nowrap valign="top">
		<? //JAM ke - 1 selasa
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=7.3 and mksem.HARI_U=2";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				 echo "- ";
				 echo $row["nama_MK"]."<br>";
		
		 }?>
		</td>
		<td nowrap valign="top">
		<? //JAM ke - 1 rabu
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=7.3 and mksem.HARI_U=3";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?>
		</td>
        <td nowrap valign="top">
			<? //JAM ke - 1 kamis
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=7.3 and mksem.HARI_U=4";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?>
		</td>
		<td nowrap valign="top">
		<? //JAM ke - 1 jumat
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=7.3 and mksem.HARI_U=5";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?>
		</td>
		<td nowrap valign="top">
		<? //JAM ke - 1 sabtu
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=7.3 and mksem.HARI_U=6";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?>
		</td>       
      </tr>
	  <tr>
	    <td nowrap valign="top"><strong>ke-2</strong> (10.30)</td>
	    <td nowrap>
		<? //JAM ke - 2 senin
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=10.3 and mksem.HARI_U=1";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
	    <td nowrap valign="top">
		<? //JAM ke - 2 selasa
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=10.3 and mksem.HARI_U=2";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
	    <td nowrap valign="top">
		<? //JAM ke - 2 rabu
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=10.3 and mksem.HARI_U=3";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
	    <td nowrap valign="top">
		<? //JAM ke - 2 kamis
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=10.3 and mksem.HARI_U=4";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
	    <td nowrap valign="top">
		<? //JAM ke - 2 jumat
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=10.3 and mksem.HARI_U=5";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
	    <td nowrap valign="top">
		<? //JAM ke - 2 sabtu
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=10.3 and mksem.HARI_U=6";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
      </tr>
	  <tr>
	    <td nowrap valign="top"><strong>ke-3</strong> (13.30)</td>
	    <td nowrap>
		<? //JAM ke - 3 senin
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=13.3 and mksem.HARI_U=1";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				
			 echo $row["nama_MK"]."<br>";
		
		 }?></td>
	    <td nowrap valign="top">
		<? //JAM ke - 3 selasa
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=13.3 and mksem.HARI_U=2";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				
			 echo $row["nama_MK"]."<br>";
		
		 }?></td>
	    <td nowrap valign="top">
		<? //JAM ke - 3 rabu 
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=13.3 and mksem.HARI_U=3";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
	    <td nowrap valign="top">
		<? //JAM ke - 3 kamis
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=13.3 and mksem.HARI_U=4";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
	    <td nowrap valign="top">
		<? //JAM ke - 3 jumat
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=13.3 and mksem.HARI_U=5";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
	    <td nowrap valign="top">
		<? //JAM ke - 3 sabtu
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=13.3 and mksem.HARI_U=6";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
      </tr>
	  <tr>
	    <td nowrap valign="top"><strong>ke-4</strong> (16.00)</td>
	    <td nowrap>
		<? //JAM ke - 4 senin
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=16 and mksem.HARI_U=1";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				
			 echo $row["nama_MK"]."<br>";
		
		 }?></td>
	    <td nowrap valign="top">
		<? //JAM ke - 4 selasa
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=16 and mksem.HARI_U=2";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				
			 echo $row["nama_MK"]."<br>";
		
		 }?></td>
	    <td nowrap valign="top">
		<? //JAM ke - 4 rabu
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=16 and mksem.HARI_U=3";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
	    <td nowrap valign="top">
		<? //JAM ke - 4 kamis
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=16 and mksem.HARI_U=4";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
	    <td nowrap valign="top">
		<? //JAM ke - 4 jumat
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=16 and mksem.HARI_U=5";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
	    <td nowrap valign="top">
		<? //JAM ke - 4 sabtu
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=16 and mksem.HARI_U=6";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
      </tr>
    </table>
	
	<br><br>
	Minggu ke -2
	<table width="100%"  border="1" cellspacing="0" cellpadding="5" class="table_ujian">
      <tr bgcolor="#C6E2FF">
        <td width="12%" nowrap>JAM&nbsp; \ HARI</td>
        <td width="15%" nowrap><strong>Senin</strong></td>
        <td width="17%" nowrap><strong>Selasa</strong></td>
        <td width="15%" nowrap><strong>Rabu</strong></td>
        <td width="14%" nowrap><strong>Kamis</strong></td>
        <td width="15%" nowrap><strong>Jumat</strong></td>
        <td width="12%" nowrap><strong>Sabtu</strong></td>
      </tr>
      <tr>
        <td nowrap valign="top"><strong>ke-1</strong> (07.30)</td>
        <td valign="top" nowrap>
          <? //JAM ke - 1 senin
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=7.3 and mksem.HARI_U=8";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
			 echo "- ";
			 echo $row["nama_MK"]."<br>";
		
		 }?>
        </td>
        <td nowrap valign="top">
          <? //JAM ke - 1 selasa
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=7.3 and mksem.HARI_U=9";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				 echo "- ";
				 echo $row["nama_MK"]."<br>";
		
		 }?>
        </td>
        <td nowrap valign="top">
          <? //JAM ke - 1 rabu
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=7.3 and mksem.HARI_U=10";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?>
        </td>
        <td nowrap valign="top">
          <? //JAM ke - 1 kamis
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=7.3 and mksem.HARI_U=11";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?>
        </td>
        <td nowrap valign="top">
          <? //JAM ke - 1 jumat
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=7.3 and mksem.HARI_U=12";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?>
        </td>
        <td nowrap valign="top">
          <? //JAM ke - 1 sabtu
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=7.3 and mksem.HARI_U=13";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?>
        </td>
      </tr>
      <tr>
        <td nowrap valign="top"><strong>ke-2</strong> (10.30)</td>
        <td nowrap>
          <? //JAM ke - 2 senin
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=10.3 and mksem.HARI_U=8";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
        <td nowrap valign="top">
          <? //JAM ke - 2 selasa
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=10.3 and mksem.HARI_U=9";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
        <td nowrap valign="top">
          <? //JAM ke - 2 rabu
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=10.3 and mksem.HARI_U=10";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
        <td nowrap valign="top">
          <? //JAM ke - 2 kamis
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=10.3 and mksem.HARI_U=11";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
        <td nowrap valign="top">
          <? //JAM ke - 2 jumat
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=10.3 and mksem.HARI_U=12";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
        <td nowrap valign="top">
          <? //JAM ke - 2 sabtu
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=10.3 and mksem.HARI_U=13";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
      </tr>
      <tr>
        <td nowrap valign="top"><strong>ke-3</strong> (13.30)</td>
        <td nowrap>
          <? //JAM ke - 3 senin
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=13.3 and mksem.HARI_U=8";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				
			 echo $row["nama_MK"]."<br>";
		
		 }?></td>
        <td nowrap valign="top">
          <? //JAM ke - 3 selasa
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=13.3 and mksem.HARI_U=9";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				
			 echo $row["nama_MK"]."<br>";
		
		 }?></td>
        <td nowrap valign="top">
          <? //JAM ke - 3 rabu 
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=13.3 and mksem.HARI_U=10";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
        <td nowrap valign="top">
          <? //JAM ke - 3 kamis
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=13.3 and mksem.HARI_U=11";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
        <td nowrap valign="top">
          <? //JAM ke - 3 jumat
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=13.3 and mksem.HARI_U=12";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
        <td nowrap valign="top">
          <? //JAM ke - 3 sabtu
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=13.3 and mksem.HARI_U=13";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
      </tr>
      <tr>
        <td nowrap valign="top"><strong>ke-4</strong> (16.00)</td>
        <td nowrap>
          <? //JAM ke - 4 senin
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=16 and mksem.HARI_U=8";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				
			 echo $row["nama_MK"]."<br>";
		
		 }?></td>
        <td nowrap valign="top">
          <? //JAM ke - 4 selasa
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=16 and mksem.HARI_U=9";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				
			 echo $row["nama_MK"]."<br>";
		
		 }?></td>
        <td nowrap valign="top">
          <? //JAM ke - 4 rabu
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=16 and mksem.HARI_U=10";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
        <td nowrap valign="top">
          <? //JAM ke - 4 kamis
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=16 and mksem.HARI_U=11";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
        <td nowrap valign="top">
          <? //JAM ke - 4 jumat
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=16 and mksem.HARI_U=12";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
        <td nowrap valign="top">
          <? //JAM ke - 4 sabtu
			$sql="SELECT distinct
						 rekap_dosen.nama_MK
					FROM mksem
			  INNER JOIN rekap_dosen ON rekap_dosen.kode_MK = mksem.KODEMK and 
			             mksem.JAM_UM=16 and mksem.HARI_U=13";

		$result=mysql_query($sql);
		while(($row = mysql_fetch_array($result)))
		{
			 switch ($row["HARI_U"]) {
				case 1:
					$nama_hari='Senin';
					break;
				case 2:
					$nama_hari='Selasa';
					break;
				case 3:
					$nama_hari='Rabu';
					break;
				case 4:
					$nama_hari='Kamis';
					break;
				case 5:
					$nama_hari='Jumat';
					break;
				case 6:
					$nama_hari='Sabtu';
					break;
				}
				//echo $nama_hari;
				//$a=strval($row["JAM_UM"]);
				echo "- ";
			    echo $row["nama_MK"]."<br>";
		
		 }?></td>
      </tr>
    </table>
	<br><br>
	<input name="excel"   type="image" onClick="document.fexcel.action='lap_jadwal_ujian_export.php?t=excel'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
   Export ke File Excel&nbsp;
    <input name="printer" type="image"  onClick="document.fexcel.action='lap_jadwal_ujian_export.php?t=printer'" src="../img/print.gif" align="bottom" width="18" height="18"> 
    Print
</FORM>
<?

	//if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
</body>
</html>