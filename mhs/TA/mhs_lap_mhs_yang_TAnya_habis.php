<?php
/* 
   DATE CREATED : 26/07/07
   LAST UPDATE  : 09/11/07 - RAHADI
   KEGUNAAN     : MENAMPILKAN LAPORAN MAHASISWA YG HABIS MASA TA-NYA
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
      ~</strong> DAFTAR MAHASISWA YANG PERIODE TA-NYA HABIS </font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form name="lap_ta_habis" id="lap_ta_habis">
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
      <td width="414">
		  <select name="frm_s_jurusan" class="tekboxku" id="frm_s_jurusan">
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
      <td>NRP</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><label>
        <input name="frm_s_nrp" type="text" class="tekboxku" id="frm_s_nrp" size="11" maxlength="7" >
      </label></td>
    </tr>
    <tr> 
      <td>Tanggal Periode </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_periode" type="text" class="tekboxku" id="frm_tgl_periode" value="<?php echo date('d/m/Y'); ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('lap_ta_habis.frm_tgl_periode',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>&nbsp;&nbsp;&nbsp;&nbsp;s/d&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="frm_tgl_periode2" type="text" class="tekboxku" id="frm_tgl_periode2" value="<?php echo date('d/m/Y'); ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('lap_ta_habis.frm_tgl_periode2',0,0,'DD/MM/YYYY')"> <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy)
		</td>
    </tr>
    <tr> 
      <td nowrap><i>Banyak Data yang ditampilkan</i></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> <select name="frm_s_jum_data" class="tekboxku">
           <option value=2>2</option> 
           <option value=10>10</option>
           <option value=15>15</option>
           <option value=20 selected>20</option>
		   </select>
	  </td>
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
			 DATE_FORMAT(`master_ta`.`AKHIR2`,'%d/%m/%Y') as TGL_AKHIR2,
			 jurusan.jurusan as nama_jur
        FROM master_ta,master_mhs, jurusan
	   WHERE master_ta.NRP=master_mhs.NRP AND master_ta.KOLUS='' 
		     AND master_mhs.jurusan=jurusan.id2 ";

if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
	
	if ($frm_s_jurusan!="all")
	{ $sql .= " and master_mhs.jurusan='".$frm_s_jurusan."'";} 
	
	if ($frm_s_nrp!="all")
	{ $sql .= " and master_mhs.NRP LIKE '".$frm_s_nrp."%'";}
	
	if($frm_tgl_periode!="" && $frm_tgl_periode2!="")
	{ $sql=$sql." and master_ta.AKHIR1 between '".datetomysql($frm_tgl_periode)."' and '".datetomysql($frm_tgl_periode2)."'"; }
	else
	{
		if($frm_tgl_periode!="")
		{ $sql=$sql." and master_ta.AKHIR1>='".datetomysql($frm_tgl_periode)."'"; }
		if($frm_tgl_periode2!="")
		{ $sql=$sql." and master_ta.AKHIR1<='".datetomysql($frm_tgl_periode2)."'"; }
	}
	
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
}

f_connecting();

// UNTUK PAGING --------------------------------
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
$vlink="mhs_lap_mhs_yang_TAnya_habis.php";
$abc="?mode=2&frm_s_jurusan=$frm_s_jurusan&frm_tgl_periode=$frm_tgl_periode&frm_tgl_periode2=$frm_tgl_periode2&frm_s_jum_data=$frm_s_jum_data";

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
      ~</strong> DAFTAR MAHASISWA YANG PERIODE TA-NYA HABIS </font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table><hr size="1" color="#FF9900">
<div align="right">
   <font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y");?> </b></font>
</div><br><br>
<?
if ($frm_s_jurusan!="all")
	{
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id2='".$frm_s_jurusan."'";
		$result_jur = @mysql_query($sql_jur);
		$row_jur=@mysql_fetch_array($result_jur);
		//echo "<b>Jurusan: </b>".$row_jur["nama_jur"];
	}
echo "<table width=\"98%\"  border=0 cellspacing=0 cellpadding=0>
		  <tr>
			<td><b>Jurusan: </b>".$row_jur["nama_jur"]."</td>
			<td align=\"right\"><b>Periode: </b>".$frm_tgl_periode." <b>-</b> ".$frm_tgl_periode2."</td>
		  </tr>
	  </table>";
if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" ACTION="mhs_lap_mhs_yang_TAnya_habis_export.php">
<input type="hidden" name="mode" value="3">
<input type="hidden" name="frm_tgl_periode" value="<?php echo $frm_tgl_periode;?>">
<input type="hidden" name="frm_tgl_periode2" value="<?php echo $frm_tgl_periode2;?>">
<input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<input type="hidden" name="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
<input type="hidden" name="frm_s_nrp" value="<?php echo $frm_s_nrp; ?>">
<?
}
if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=mhs_lap_mhs_yang_TAnya_habis.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}		 
	 
	 if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }


?>
	<table width="80%" border="1" cellpadding="5" cellspacing="0" class="table">
		  <tr bgcolor="#C6E2FF">
			<th width="2%" class="td"><b>No.</b></th>
			<th width="9%" class="td" nowrap><b>JURUSAN</b></th>
			<th width="9%" class="td" nowrap><b>NRP</b></th>
			<th width="10%" nowrap bgcolor="#C6E2FF" class="td"><b>NAMA</b></th>
			<th width="9%" class="td" nowrap><b>JUDUL TA</b></th>
			<th width="9%" class="td" nowrap><b>DOSEN PEMBIMBING 1</b></th>
			<th width="9%" class="td" nowrap><b>DOSEN PEMBIMBING 2</b></th>
			<th width="35%" class="td" nowrap><b>TGL AKHIR TA</b></th>
			<th width="35%" class="td" nowrap><b>TGL PERPANJANGAN TA</b></th>
	      </tr>
<?
$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
?>
          <tr> 
            <td><? echo ($hal-1)*$frm_s_jum_data+$a; ?></td>
            <td nowrap><? echo $row["nama_jur"];
					/*switch ($row["jurusan"])
					{
						case 1:
							echo "Teknik Elektro";
							break;
						case 2:
							echo "Teknik Kimia";
							break;
						case 3:
							echo "Teknik Industri";
							break;
						case 4:
							echo "Teknik Informatika";
							break;
						case 5:
							echo "Teknik Manufaktur";
							break;
					}*/
				?></td>
            <td nowrap><? echo $row["NRP"]; ?></td>
            <td nowrap><? echo $row["NAMA"]; ?></td>
            <td nowrap><? echo $row["JUDUL_TA"]; ?></td>
            <td nowrap><? $sql_dobing1="SELECT nama
							   FROM dosen
							   WHERE kode='".$row["KODOS1"]."'";
				   $result_dobing1 = @mysql_query($sql_dobing1);
				   $row_dobing1=@mysql_fetch_array($result_dobing1);
				   echo $row["KODOS1"]."-".$row_dobing1["nama"];?>
			</td>
            <td nowrap><? $sql_dobing2="SELECT nama
							   FROM dosen
							   WHERE kode='".$row["KODOS2"]."'";
				   $result_dobing2 = @mysql_query($sql_dobing2);
				   $row_dobing2=@mysql_fetch_array($result_dobing2);
				   echo $row["KODOS2"]."-".$row_dobing2["nama"];?>
			</td>
            <td nowrap><? echo $row["TGL_AKHIR"]; ?></td>
            <td nowrap><? $sql_ulur="SELECT DATE_FORMAT(`perpanjang_ta`.`tgl_ulur`,'%d/%m/%Y') as tgl_ulur
							   FROM perpanjang_ta
							   WHERE NRP='".$row["NRP"]."'";
				   $result_ulur = @mysql_query($sql_ulur);
				   $row_ulur=@mysql_fetch_array($result_ulur);
				   echo $row_ulur["tgl_ulur"];?>
			</td>
          </tr>
<?
}
?>
     </table>
<tr>
  <td>
   <input name="excel"   type="image" onClick="document.fexcel.action='mhs_lap_mhs_yang_TAnya_habis_export.php?t=excel'" src="../../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
   Export ke File Excel &nbsp;
    <input name="printer"  onClick="document.fexcel.action='mhs_lap_mhs_yang_TAnya_habis_export.php?t=printer'" type="image" src="../../img/print.gif" width="18" height="18"> 
    Print
  </td>
</tr>
	</table>
	</FORM>
<?
}
?>
<?
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
</body>
</html>