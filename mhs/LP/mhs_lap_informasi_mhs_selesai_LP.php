<?php
/* 
   DATE CREATED : 29/04/08
   LAST UPDATE  : 29/04/08 - RAHADI
   KEGUNAAN     : MENAMPILKAN LAPORAN MAHASISWA YG SELESAI LP
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
//require("../../include/temp.php");
$mode= ( isset( $_REQUEST['mode'] ) ) ? $_REQUEST['mode'] : 0;
$frm_tgl_periode= ( isset( $_REQUEST['frm_tgl_periode'] ) ) ? $_REQUEST['frm_tgl_periode'] : null;
$frm_tgl_periode2= ( isset( $_REQUEST['frm_tgl_periode2'] ) ) ? $_REQUEST['frm_tgl_periode2'] : null;
$frm_kode_dobing= ( isset( $_REQUEST['frm_kode_dobing'] ) ) ? $_REQUEST['frm_kode_dobing'] : null;
$hal= ( isset( $_REQUEST['hal'] ) ) ? $_REQUEST['hal'] : 1;
$frm_s_jum_data= ( isset( $_REQUEST['frm_s_jum_data'] ) ) ? $_REQUEST['frm_s_jum_data'] : 20;
$frm_nrp= ( isset( $_REQUEST['frm_nrp'] ) ) ? $_REQUEST['frm_nrp'] : null;
$frm_nama= ( isset( $_REQUEST['frm_nama'] ) ) ? $_REQUEST['frm_nama'] : null;
$pesan= ( isset( $_REQUEST['pesan'] ) ) ? $_REQUEST['pesan'] : null;
$error= ( isset( $_REQUEST['error'] ) ) ? $_REQUEST['error'] : null; 
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
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN 
      ~</strong> DAFTAR MAHASISWA YANG SELESAI LP</font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form name="lap_selesai_lp" id="lap_selesai_lp">
  <table align="center" class="body" >
    <tr>
      <td width="201">&nbsp;</td>
      <td width="3%">&nbsp;</td>
      <td width="414">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>Tanggal Periode </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_periode" type="text" class="tekboxku" id="frm_tgl_periode" value="<?php echo date('d/m/Y'); ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('lap_selesai_lp.frm_tgl_periode',0,0,'DD/MM/YYYY')"> <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> </A>&nbsp;&nbsp;&nbsp;&nbsp;s/d&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="frm_tgl_periode2" type="text" class="tekboxku" id="frm_tgl_periode2" value="<?php echo date('d/m/Y'); ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('lap_selesai_lp.frm_tgl_periode2',0,0,'DD/MM/YYYY')"> <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy) </td>
    </tr>
    <tr>
      <td nowrap>Dosen Pembimbing </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <select name="frm_kode_dobing" id="frm_kode_dobing" class="tekboxku">
        <option <?php if ($frm_kode_dobing==''){echo "selected";}?> value="all">Semua</option>
        <?php 
				$sqlDosen="select kode, nama
						   from dosen 
						    where (length(kode)=6) ORDER BY kode";
				
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
        <option value="<?php echo $row->kode; ?>" <?php if ($frm_kode_dobing==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
        <?php
		}?>
      </select></td>
    </tr>
    <tr>
      <td nowrap>NRP</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_NRP" type="text" class="tekboxku" id="frm_NRP" size="10" maxlength="7"></td>
    </tr>
    <tr>
      <td nowrap>Nama Mahasiswa </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nama" type="text" class="tekboxku" id="frm_nama" size="20" maxlength="30"></td>
    </tr>
    <tr> 
      <td nowrap><i>Banyak Data yang ditampilkan</i></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> <select name="frm_s_jum_data" class="tekboxku">
          <option value=2>2</option>
          <option value=10>10</option>
          <option value=15>15</option>
          <option value=20 selected>20</option>
		  </select> </td>
    </tr>
    <tr> 
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td></td>
      <td><input type="hidden" name="mode" value="2"></td>
      <td><input type="submit" value="Proses" class="tombol"></td>
    </tr>
  </table>
</form>
<?
}
else
{
// JIKA MODE<>0 MAKSUDNYA JIKA FORM DI SUBMIT MAKA KELUAR LAPORAN
$sql="SELECT master_mhs.NRP,
			 master_mhs.NAMA,
			 master_lp.JUDUL1,
			 master_lp.KODOS1,
			 master_lp.KODOS2,
			 DATE_FORMAT(`master_lp`.`TGL_SELESAI`,'%d/%m/%Y') as TGL_SELESAI,
			 master_mhs.jurusan
        FROM master_lp,master_mhs
		WHERE master_lp.NRP=master_mhs.NRP";

if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
	if($frm_tgl_periode!="" && $frm_tgl_periode2!="")
	{ 
		$sql=$sql." and (master_lp.TGL_SELESAI between '".datetomysql($frm_tgl_periode)."' and '".datetomysql($frm_tgl_periode2)."')"; 
	}
	else
	{
		if($frm_tgl_periode!="")
		{ 
			$sql=$sql." and (master_lp.TGL_SELESAI>='".datetomysql($frm_tgl_periode)."')"; 
		}
		if($frm_tgl_periode2!="")
		{ 
			$sql=$sql." and (master_lp.TGL_SELESAI<='".datetomysql($frm_tgl_periode2)."')"; 
		}
	}

	/*if ($frm_s_jurusan!="all")
	{ $sql .= " and master_mhs.jurusan='".$frm_s_jurusan."'";}*/
	
	if ($frm_kode_dobing!="all")
	{ $sql=$sql." and (master_lp.KODOS1 = '".$frm_kode_dobing."' or master_lp.KODOS2 = '".$frm_kode_dobing."')"; }
	
	if($frm_NRP!="")
	{ $sql=$sql." and master_mhs.NRP LIKE '".$frm_NRP."%'"; }
	
	if($frm_nama!="")
	{ $sql=$sql." and master_mhs.NAMA LIKE '".$frm_nama."%'"; }
	//echo "<br>sql=".$sql;
}

f_connecting();

//paging
if ($mode=="2")
{
mysql_select_db($DB);
$result=@mysql_query($sql);
$maxrows=mysql_num_rows($result);				
if($hal=="") { $hal=1; }
$recke=(($hal-1)*$frm_s_jum_data);
$limit="$recke,$frm_s_jum_data";
$jumhal=ceil($maxrows/$frm_s_jum_data);
 
$vlink="mhs_lap_informasi_mhs_selesai_LP.php";
$abc="?mode=2&frm_tgl_periode=$frm_tgl_periode&frm_tgl_periode2=$frm_tgl_periode2&frm_kode_dobing=$frm_kode_dobing&frm_NRP=$frm_NRP&frm_nama=$frm_nama&frm_s_jum_data=$frm_s_jum_data";

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
      ~</strong> DAFTAR MAHASISWA YANG SELESAI LP</font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<div align="right">
   <font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y");?> </b></font>
</div><br><br>
<table>
  <tr>
	  <td nowrap><font size="1">PERIODE PER TANGGAL:</font>&nbsp;<b><? echo $frm_tgl_periode." - ".$frm_tgl_periode2;?></b></td>
  </tr>
</table>
<?

if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="mhs_lap_informasi_mhs_selesai_LP.php">
<input type="hidden" name="mode" value="3">
<input type="hidden" name="frm_tgl_periode" value="<?php echo $frm_tgl_periode;?>">
<input type="hidden" name="frm_tgl_periode2" value="<?php echo $frm_tgl_periode2;?>">
<input type="hidden" name="frm_kode_dobing" value="<?php echo $frm_kode_dobing;?>">
<input type="hidden" name="frm_NRP" value="<?php echo $frm_NRP;?>">
<input type="hidden" name="frm_nama" value="<?php echo $frm_nama;?>">
<input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<?
}

if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=mhs_lap_informasi_mhs_selesai_LP.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}		 

	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
	  <table width="100%"  border="1" cellspacing="0" cellpadding="5" class="table">
		  <tr bgcolor="#C6E2FF">
			<th><strong>No.</strong></th>
			<th><strong>NRP</strong></th>
			<th><strong>Nama</strong></th>
			<th><strong>Judul LP </strong></th>
			<th nowrap><strong>Dosen Pembimbing 1</strong></th>
			<th nowrap><strong>Dosen Pembimbing 2</strong></th>
			<th nowrap><strong>Tanggal Selesai</strong></th>
		  </tr>
<?
$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
?>
            <td><? echo ($hal-1)*$frm_s_jum_data+$a; ?></td>
            <td nowrap><? echo $row["NRP"]; ?></td>
            <td nowrap><? echo $row["NAMA"]; ?></td>
            <td nowrap><? echo $row["JUDUL1"]; ?></td>
            <td nowrap>
              <? $sql_dobing1="SELECT nama
							   FROM dosen
							   WHERE kode='".$row["KODOS1"]."'";
				   $result_dobing1 = @mysql_query($sql_dobing1);
				   $row_dobing1=@mysql_fetch_array($result_dobing1);
				   echo $row["KODOS1"]."-".$row_dobing1["nama"];?>
            </td>
            <td nowrap>
              <? $sql_dobing2="SELECT nama
							   FROM dosen
							   WHERE kode='".$row["KODOS2"]."'";
				   $result_dobing2 = @mysql_query($sql_dobing2);
				   $row_dobing2=@mysql_fetch_array($result_dobing2);
				   echo $row["KODOS2"]."-".$row_dobing2["nama"];?>
            </td>
            <td nowrap><? echo $row["TGL_SELESAI"]; ?></td>
          </tr>
<?
}
?>
  </table>
   <input name="excel"   type="image" onClick="document.fexcel.action='mhs_lap_informasi_mhs_selesai_LP_export.php?t=excel'" src="../../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
   Export ke File Excel &nbsp;
    <input name="printer"  onClick="document.fexcel.action='mhs_lap_informasi_mhs_selesai_LP_export.php?t=printer'" type="image" src="../../img/print.gif" width="18" height="18"> 
    Print
</FORM>
<?
}
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
</body>
</html>