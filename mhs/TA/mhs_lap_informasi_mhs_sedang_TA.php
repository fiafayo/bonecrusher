<?php
/* 
   DATE CREATED : 26/07/07
   LAST UPDATE  : 26/07/07 - RAHADI
   KEGUNAAN     : MENAMPILKAN LAPORAN MAHASISWA YG SEDANG TA
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
require("../../include/temp.php");
?>

<html>
<script language="JavaScript" src="../../include/tanggalan.js">
</script>
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
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
      ~</strong> DAFTAR MAHASISWA YANG SEDANG TA</font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form name="lap_sedang_ta" id="lap_sedang_ta">
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
      <td width="201">Jurusan</td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td width="414"><select name="frm_s_jurusan" class="tekboxku">
          <option value="all">Semua 
          <?php
				 $result2 = @mysql_query("SELECT * FROM `jurusan` WHERE `jurusan`.id>0 AND `jurusan`.id<=8");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["id2"].">".$row2["jurusan"];
	             }
         	?>
        </select>
        <span class="style1">*</span></td>
    </tr>
    <tr> 
      <td>Batas Akhir TA, mulai tanggal </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_periode" type="text" class="tekboxku" id="frm_tgl_periode" value="<?php echo date('d/m/Y'); ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('lap_sedang_ta.frm_tgl_periode',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy) <span class="style1">*</span></td>
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
			 master_ta.JUDUL_TA,
			 master_ta.KODOS1,
			 master_ta.KODOS2,
			 DATE_FORMAT(`master_ta`.`AKHIR1`,'%d/%m/%Y') as TGL_AKHIR,
			 master_mhs.jurusan,
			 master_ta.KOLUS
        FROM master_ta,master_mhs
		WHERE master_ta.NRP=master_mhs.NRP AND master_ta.KOLUS=''";

if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_s_jurusan!="all")
	{ $sql .= " and master_mhs.jurusan='".$frm_s_jurusan."'";}
	
	if($frm_tgl_periode!="")
	{ $sql=$sql." and master_ta.AKHIR1>='".datetomysql($frm_tgl_periode)."'"; }
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
echo $frm_tanggal_lulus1;
$vlink="mhs_lap_informasi_mhs_sedang_TA.php";
$abc="?mode=2&frm_s_jurusan=$frm_s_jurusan&frm_tgl_periode=$frm_tgl_periode&frm_s_jum_data=$frm_s_jum_data";

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
      ~</strong> DAFTAR MAHASISWA YANG SEDANG TA</font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<div align="right">
   <font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y");?> </b></font>
</div><br><br>
<table>
  <tr>
	  <td nowrap>Batas Akhir TA, mulai tanggal:&nbsp;<b><? echo $frm_tgl_periode;?></b></td>
  </tr>
</table>
<?

if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="mhs_lap_informasi_mhs_sedang_TA.php">
<input type="hidden" name="mode" value="3">
<input type="hidden" name="frm_tgl_periode" value="<?php echo $frm_tgl_periode;?>">
<input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<input type="hidden" name="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
<?
}

if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=mhs_lap_informasi_mhs_sedang_TA.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}		 

	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
	  <table width="100%"  border="1" cellspacing="0" cellpadding="5" class="table">
		  <tr bgcolor="#C6E2FF">
			<th><strong>No.</strong></th>
			<th><strong>Jurusan</strong></th>
			<th><strong>NRP</strong></th>
			<th><strong>Nama</strong></th>
			<th><strong>Judul TA </strong></th>
			<th><strong>Dosen Pembimbing 1</strong></th>
			<th><strong>Dosen Pembimbing 2</strong></th>
			<th nowrap><strong>Batas akhir TA</strong></th>
		    <th nowrap>Status TA </th>
		  </tr>
<?
$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
?>
            <tr><td><? echo ($hal-1)*$frm_s_jum_data+$a; ?></td>
            <td nowrap> 
              <? 
					switch ($row["jurusan"])
					{
						case '6B':
							echo "Teknik Elektro";
							break;
						case '6C':
							echo "Teknik Kimia";
							break;
						case '6D':
							echo "Teknik Industri";
							break;
						case '6E':
							echo "Teknik Informatika";
							break;
						case '6F':
							echo "Teknik Manufaktur";
							break;
                        case '6G':
							echo "DMP";
							break;
                        case '6H':
							echo "Sistem Informasi";
							break;
                        case '6I':
							echo "Multimedia";
							break;
					}
				?>
            </td>
            <td nowrap><? echo $row["NRP"]; ?></td>
            <td nowrap><? echo $row["NAMA"]; ?></td>
            <td nowrap><? echo $row["JUDUL_TA"]; ?></td>
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
            <td nowrap><? echo $row["TGL_AKHIR"]; ?></td>
            <td nowrap>Sedang TA</td>
          </tr>
<?
}
?>
  </table>
   <input name="excel"   type="image" onClick="document.fexcel.action='mhs_lap_informasi_mhs_sedang_TA_export.php?t=excel'" src="../../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
   Export ke File Excel &nbsp;
    <input name="printer"  onClick="document.fexcel.action='mhs_lap_informasi_mhs_sedang_TA_export.php?t=printer'" type="image" src="../../img/print.gif" width="18" height="18"> 
    Print
</FORM>
<?
}
?>
<?
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
</body>
</html>