<?php
/* 
   DATE CREATED : 31/07/07
   LAST UPDATE  : 31/07/07 - RAHADI
   KEGUNAAN     : MENAMPILKAN LAPORAN MAHASISWA YG LULUS TA NAMUN BELUM LULUS S1
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
      ~</strong> DAFTAR MAHASISWA YANG LULUS TA BELUM LULUS S1</font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form name="lap_blum_lulus_s1" id="lap_blum_lulus_s1">
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
	  <select name="frm_s_jurusan" class="tekboxku">
          <option value="all">Semua 
          <?php
				 $result2 = mysql_query("SELECT * FROM jurusan WHERE id>0 AND id<=8");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["id2"].">".$row2["jurusan"];
	             }
         	?>
        </select></td>
    </tr>
    <tr> 
      <td>Tanggal Periode </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_periode" type="text" class="tekboxku" id="frm_tgl_periode" value="<?php echo date('d/m/Y'); ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('lap_blum_lulus_s1.frm_tgl_periode',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy) <span class="style1">* s/d tanggal sekarang </span></td>
    </tr>
    <tr>
      <td nowrap>Dosen</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_kode_dobing" id="frm_kode_dobing" class="tekboxku">
        <option <?php if ($frm_kode_dobing==''){echo "selected";}?> value="all">Semua</option>
        <?php 
				$sqlDosen="select kode, nama
						   from dosen 
						   where kode like '61%'";
				
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
			 lulus_ta.nilai_ujian,
			 master_ta.KODOS1,
			 master_ta.KODOS2,
			 DATE_FORMAT(`master_ta`.`TGL_TA`,'%d/%m/%Y') as TGL_AWAL,
			 DATE_FORMAT(`master_ta`.`AKHIR1`,'%d/%m/%Y') as TGL_AKHIR,
			 DATE_FORMAT(`master_ta`.`AKHIR2`,'%d/%m/%Y') as TGL_AKHIR2,
			 master_ta.kolus,
			 master_ta.status,
			 master_mhs.jurusan, 
			 DATE_FORMAT(`lulus_ta`.`tgl_lulus`,'%d/%m/%Y') as tgl_lulus
        FROM master_ta,master_mhs, lulus_ta
		WHERE master_ta.NRP=master_mhs.NRP AND 
			  lulus_ta.NRP=master_ta.NRP AND
		      master_ta.KOLUS='L' AND master_ta.STATUS=''";

if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
	
	if ($frm_s_jurusan!="all")
	{ $sql .= " and master_mhs.jurusan='".$frm_s_jurusan."'";}
	
	if($frm_tgl_periode!="")
	{ $sql=$sql." and lulus_ta.tgl_lulus >='".datetomysql($frm_tgl_periode)."'"; }
	
	if ($frm_kode_dobing!="all")
	{ $sql .= " and (master_ta.KODOS1='".$frm_kode_dobing."' or master_ta.KODOS2='".$frm_kode_dobing."')";}
	
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
	//echo "<br>sql=".$sql;
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
//echo $frm_tanggal_lulus1;
$vlink="mhs_lap_daftar_mhs_lulus_ta_blm_lulus_S1.php";
$abc="?mode=2&frm_s_jurusan=$frm_s_jurusan&frm_tgl_periode=$frm_tgl_periode&frm_s_jum_data=$frm_s_jum_data&frm_kode_dobing=$frm_kode_dobing";

$vlink=$vlink.$abc;

$fontface="Verdana,Arial,Helvetica,sans-serif";
$fontsize="2";
}
// SELESAI MBULETNYA PAGING ------------------------------
// JIKA MODE HASIL LAPORAN DI MONITOR MAKA PAGING IN ACTION
if ($mode=="2") { $sql=$sql." ORDER BY lulus_ta.tgl_lulus DESC limit ".$limit; }
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
      ~</strong> </font><font color="#006699"><font color="#0099CC" size="1">DAFTAR MAHASISWA YANG LULUS TA BELUM LULUS S1</font></font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
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
			<td align=\"right\"><b>Periode: </b>".$frm_tgl_periode." s/d tanggal sekarang</td>
		  </tr>
	  </table>";


if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" ACTION="mhs_lap_daftar_mhs_lulus_ta_blm_lulus_S1.php">
<input type="hidden" name="mode" value="3">
<input type="hidden" name="frm_tgl_periode" value="<?php echo $frm_tgl_periode;?>">
<input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<input type="hidden" name="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
<input type="hidden" name="frm_kode_dobing" value="<?php echo $frm_kode_dobing; ?>">
<?
}
	
if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=mhs_lap_daftar_mhs_lulus_ta_blm_lulus_S1.php class=menu_left>:: Kembali</a>";
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
			<th width="10%" class="td" nowrap><b>NAMA</b></th>
			<th width="9%" class="td" nowrap><b>JUDUL TA</b></th>
			<th width="9%" class="td" nowrap><b>PEMBIMBING 1</b></th>
			<th width="9%" class="td" nowrap><b>PEMBIMBING 2</b></th>
			<th width="9%" class="td" nowrap><b>NILAI TA</b></th>
			<th width="35%" class="td" nowrap>Tgl. AWAL TA </th>
			<th width="35%" class="td" nowrap><b>Tgl. AKHIR TA</b></th>
			<th width="35%" class="td" nowrap><b>Tgl. PERPANJANGAN TA</b></th>
			<th width="35%" class="td" nowrap>Tgl. LULUS TA </th>
			<th width="35%" class="td" nowrap><b>STATUS TA</b></th>
			<th width="35%" class="td" nowrap><b>STATUS KULIAH</b></th>
	      </tr>
<?
$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
?>
		<tr>
            <td nowrap><? echo ($hal-1)*$frm_s_jum_data+$a; ?></td>
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
					}
				?>
            </td>
            <td nowrap><? echo $row["NRP"]; ?></td>
            <td nowrap><? echo $row["NAMA"]; ?></td>
            <td nowrap><? echo $row["JUDUL_TA"]; ?></td>
            <td nowrap><?
				$sql_dosen1="SELECT nama
							       FROM dosen
							       WHERE kode='".$row["KODOS1"]."'";
				$result_dosen1 = @mysql_query($sql_dosen1);
				$row_dosen1=@mysql_fetch_array($result_dosen1);
				echo $row["KODOS1"]." - ".$row_dosen1["nama"];
			   ?>
			</td>
            <td nowrap>
			  <?
				$sql_dosen2="SELECT nama
							       FROM dosen
							       WHERE kode='".$row["KODOS2"]."'";
				$result_dosen2 = @mysql_query($sql_dosen2);
				$row_dosen2=@mysql_fetch_array($result_dosen2);
				echo $row["KODOS2"]." - ".$row_dosen2["nama"];
			   ?>
			</td>
            <td nowrap><? echo $row["nilai_ujian"]; ?></td>
            <td nowrap><? echo $row["TGL_AWAL"]; ?></td>
            <td nowrap><? echo $row["TGL_AKHIR"]; ?></td>
            <td nowrap><? echo $row["TGL_AKHIR2"]; ?></td>
            <td nowrap><? echo $row["tgl_lulus"]; ?></td>
			<td nowrap> 
              <? if ($row["kolus"]=='L')
			   		{ echo "LULUS TA";}
				 else
				    { echo "BELUM";}
			   ?>
            </td>
            <td nowrap> 
              <? if ($row["status"]=='S')
			   		{ echo "SELESAI";}
				 else
				    { echo "BELUM SELESAI";}
			   ?>
            </td>
          </tr>
<?
}
?>
</table>
<tr>
	<td>
   <input name="excel"   type="image" onClick="document.fexcel.action='mhs_lap_daftar_mhs_lulus_ta_blm_lulus_S1_export.php?t=excel'" src="../../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
   Export ke File Excel &nbsp;
   <input name="printer"  onClick="document.fexcel.action='mhs_lap_daftar_mhs_lulus_ta_blm_lulus_S1_export.php?t=printer'" type="image" src="../../img/print.gif" width="18" height="18"> 
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