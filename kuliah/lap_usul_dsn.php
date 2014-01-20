<?php
/* 
   DATE CREATED : 12/12/07
   KEGUNAAN     : MENAMPILKAN LAPORAN USULAN MENGAJAR DOSEN
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
    ~</strong>USULAN DOSEN</font></td>
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
        <option value="<?php echo $row->kode; ?>" <?php if ($frm_dosen==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
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
      <td><input type="hidden" name="mode" id="mode" value="2">
	      <input type="hidden" name="frm_s_jum_data" id="frm_s_jum_data" value="20"></td>
      <td><input type="submit" value="Proses"  class="tombol"></td>
    </tr>
  </table>
</form>
<?
}
else
{
// JIKA MODE<>0 MAKSUDNYA JIKA FORM DI SUBMIT MAKA KELUAR LAPORAN
$sekarang=date("Y-m-d");     
   
/*$sql="SELECT  `daftar_kp`.`NO_MOHON`,
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
		FROM  daftar_kp 
		WHERE `daftar_kp`.`NO_ST`=''";*/
		//WHERE `daftar_kp`.`NO_MOHON`='".$frm_no_SP_KP."')";
		
$sql="SELECT usulan.Kode_Mat,
			 usulan.KP,
			 usulan.Riil,
			 usulan.Kode_Dosen
		FROM usulan
	   WHERE usulan.Kode_Mat <> 'NULL' ";
	  
if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_MK!="all")
		{ $sql=$sql." and (usulan.Kode_Mat='".$frm_MK."')"; }
		
	if ($frm_KP!="all")
		{ $sql=$sql." and (usulan.KP='".$frm_KP."')"; }
		
    if ($frm_SKS_MK!="all")
		{ $sql=$sql." and (usulan.Riil=".$frm_SKS_MK.")"; }
		
	if ($frm_dosen!="all")
		{ $sql=$sql." and (usulan.Kode_Dosen='".$frm_dosen."')"; }

//echo "<br>SQL= ".$sql;
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
}

// UNTUK PAGING --------------------------------
if ($mode=="2")
{
$result=@mysql_query($sql);
$maxrows=mysql_num_rows($result);				
if($hal=="") { $hal=1; }
$recke=(($hal-1)*$frm_s_jum_data);
$limit="$recke,$frm_s_jum_data";
$jumhal=ceil($maxrows/$frm_s_jum_data);


$vlink="lap_usul_dsn.php";
$abc="?mode=2&frm_MK=$frm_MK&frm_KP=$frm_KP&frm_SKS_MK=$frm_SKS_MK&frm_dosen=$frm_dosen&frm_s_jum_data=$frm_s_jum_data";

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
//---------------------------------
?>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#0099CC" size="1"><strong>LAPORAN 
    ~</strong>USULAN DOSEN</font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">PERKULIAHAN</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div><br>
<?
if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="lap_usul_dsn.php">
<input type="hidden" name="mode" id="mode" value="3">
<input type="hidden" name="frm_MK" id="frm_MK" value="<? echo $frm_MK?>">
<input type="hidden" name="frm_KP" id="frm_KP" value="<?php echo $frm_KP; ?>">
<input type="hidden" name="frm_SKS_MK" id="frm_SKS_MK" value="<?php echo $frm_SKS_MK; ?>">
<input type="hidden" name="frm_dosen" id="frm_dosen" value="<?php echo $frm_dosen; ?>">
<input type="hidden" name="frm_s_jum_data" id="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">

<?
}
if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=lap_usul_dsn.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}
if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
	<table width="100%"  border="1" cellspacing="0" cellpadding="5" class="table">
      <tr bgcolor="#C6E2FF">
        <td nowrap><strong>Kode MK</strong></td>
        <td nowrap><strong>Nama MK</strong></td>
        <td nowrap><strong>KP</strong></td>
        <td nowrap><strong>SKS Riil </strong></td>
        <td nowrap><strong>NPK Dosen </strong></td>
        <td nowrap><strong>Nama Dosen</strong></td>
      </tr>
      <?

$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
?>
      <tr>
        <td nowrap valign="top"><? echo $row["Kode_Mat"]; ?></td>
        <td nowrap valign="top">
			<?
				$sql_MK="SELECT nama
						   FROM master_mk
					      WHERE kode_mk='".$row["Kode_Mat"]."'";
				$result_MK = @mysql_query($sql_MK);
				$row_MK=@mysql_fetch_array($result_MK);
				echo $row_MK["nama"];
			?>
		</td>
        <td nowrap valign="top"><? echo $row["KP"]; ?></td>
        <td nowrap valign="top"><? echo $row["Riil"]; ?></td>
        <td nowrap valign="top"><? echo $row["Kode_Dosen"]; ?></td>
        <td nowrap valign="top">
			<?
				$sql_dosen_1="SELECT nama
							  FROM dosen
							  WHERE kode='".$row["Kode_Dosen"]."'";
				$result_dosen_1 = @mysql_query($sql_dosen_1);
				$row_dosen_1=@mysql_fetch_array($result_dosen_1);
				echo $row_dosen_1["nama"];
			?>
		</td>
      </tr>
      <?
}
?>
    </table>
	<input name="excel"   type="image" onClick="document.fexcel.action='lap_usul_dsn_export.php?t=excel'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18">   
	Export ke File Excel&nbsp;
	<input name="printer" type="image"  onClick="document.fexcel.action='lap_usul_dsn_export.php?t=printer'" src="../img/print.gif" align="bottom" width="18" height="18"> 
	Print
</FORM>
<?
}
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
</body>
</html>