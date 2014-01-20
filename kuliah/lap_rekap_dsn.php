<?php
/* 
   DATE CREATED : 12/12/07
   KEGUNAAN     : MENAMPILKAN LAPORAN REKAP KEHADIRAN DOSEN
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
mysql_select_db($DB);
?>
<html>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../include/tanggalan.js">
</script>
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
    ~</strong>REKAP KEHADIRAN DOSEN</font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">PERKULIAHAN</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form name="form_rekap_hadir_dsn" id="form_rekap_hadir_dsn">
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
      <td nowrap>&nbsp;</td>
      <td nowrap>Mata Kuliah</td>
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
      <td><select name="frm_KP" id="frm_KP" class="tekboxku">
                <option value="all">Semua</option>
				<?php 
							$sql_KP="SELECT distinct kp 
							         FROM rekap_dosen 
									 ORDER BY kp ASC";
							
							$result = @mysql_query($sql_KP);
							$c=0;
							while ($row=@mysql_fetch_object($result))  {
							$c=$c+1;
							?>
				<option value="<?php echo $row->kp; ?>" <?php if ($frm_KP==$row->kp) { echo "selected"; }?> > <?php echo $row->kp; ?></option>
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
   
$sql="SELECT rekap_dosen.kode_MK,
			 rekap_dosen.nama_MK,
			 rekap_dosen.sks,
		     rekap_dosen.kp,
			 rekap_dosen.kode_dsn,
			 rekap_dosen.nama_dsn,
			 rekap_dosen.seharusnya,
			 rekap_dosen.kehadiran,
			 rekap_dosen.persentasi,
			 rekap_dosen.id_periode
	    FROM rekap_dosen

	   WHERE (rekap_dosen.kode_MK <> '' OR rekap_dosen.nama_dsn <> '')";
	  
if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
//echo "<br>frm_tgl=".$frm_tgl;
//echo "<br>frm_dosen=".$frm_dosen;
//echo "<br>frm_MK=".$frm_MK;
//echo "<br>frm_KP=".$frm_KP;
//exit();
	if ($frm_dosen!="all")
		{ $sql=$sql." and (rekap_dosen.kode_dsn='".$frm_dosen."')"; }
		
	if ($frm_MK!="all")
		{ $sql=$sql." and (rekap_dosen.kode_MK='".$frm_MK."')"; }
		
	if ($frm_KP!="all")
		{ $sql=$sql." and (rekap_dosen.kp='".$frm_KP."')"; }
	
	if ($frm_id_tahun_ajar!="all")
		{ $sql=$sql." and (rekap_dosen.id_periode=".$frm_id_tahun_ajar.")"; }
		

	/*if ($frm_s_tgl_mulai1!="" || $frm_s_tgl_mulai2!="")
	{  
		if($frm_s_tgl_mulai1!="" && $frm_s_tgl_mulai2!="")
		{ $sql=$sql." and ta.tanggal_mulai between '".datetomysql($frm_s_tgl_mulai1)."' and '".datetomysql($frm_s_tgl_mulai2)."'"; }
		else
		{
			if($frm_s_tgl_mulai1!="")
			{ $sql=$sql." and ta.tanggal_mulai>='".datetomysql($frm_s_tgl_mulai1)."'"; }
			if($frm_s_tgl_mulai2!="")
			{ $sql=$sql." and ta.tanggal_mulai<='".datetomysql($frm_s_tgl_mulai2)."'"; }
		}
	}
	if ($frm_s_tgl_selesai1!="" || $frm_s_tgl_selesai2!="")
	{  
		if($frm_s_tgl_selesai1!="" && $frm_s_tgl_selesai2!="")
		{ $sql=$sql." and ta.tanggal_selesai between '".datetomysql($frm_s_tgl_selesai1)."' and '".datetomysql($frm_s_tgl_selesai2)."'"; }
		else
		{
			if($frm_s_tgl_selesai1!="")
			{ $sql=$sql." and ta.tanggal_selesai>='".datetomysql($frm_s_tgl_selesai1)."'"; }
			if($frm_s_tgl_selesai2!="")
			{ $sql=$sql." and ta.tanggal_selesai<='".datetomysql($frm_s_tgl_selesai2)."'"; }
		}
	}*/
	
	/*if ($frm_s_judul!="")
	{ $sql=$sql." and ta.judul like '%".$frm_s_judul."%'"; } */
	
	
//echo "<br>SQL= ".$sql;
//exit();
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


$vlink="lap_rekap_dsn.php";
$abc="?mode=2&frm_id_tahun_ajar=$frm_id_tahun_ajar&frm_dosen=$frm_dosen&frm_MK=$frm_MK&frm_KP=$frm_KP&frm_s_jum_data=$frm_s_jum_data";

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
    ~</strong>KEHADIRAN DOSEN</font></td>
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
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="lap_rekap_dsn.php">
<input type="hidden" name="mode" id="mode" value="3">
<input type="hidden" name="frm_tgl" id="frm_tgl" value="<? echo $frm_tgl?>">
<input type="hidden" name="frm_dosen" id="frm_dosen" value="<?php echo $frm_dosen; ?>">
<input type="hidden" name="frm_MK" id="frm_MK" value="<?php echo $frm_MK; ?>">
<input type="hidden" name="frm_KP" id="frm_KP" value="<?php echo $frm_KP; ?>">
<input type="hidden" name="frm_s_jum_data" id="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">

<?
}
if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=lap_rekap_dsn.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}
if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
	<table width="100%"  border="1" cellspacing="0" cellpadding="5" class="table">
      <tr bgcolor="#C6E2FF">
        <td nowrap><strong>Kode MK </strong></td>
        <td nowrap><strong>Nama MK</strong></td>
        <td nowrap><strong>SKS</strong></td>
		<td nowrap><strong>KP</strong></td>
        <td nowrap><strong>NPK Dosen</strong></td>
        <td nowrap><strong>Nama Dosen</strong></td>
        <td nowrap><strong>Seharusnya</strong></td>
        <td nowrap><strong>Kehadiran</strong></td>
        <td nowrap><strong>Persentase</strong></td>
      </tr>
      <?

$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
?>
      <tr>
        <td nowrap valign="top"><? echo $row["kode_MK"]; ?></td>
        <td nowrap valign="top">
			<?
				$sql_MK="SELECT nama
						   FROM master_mk
					      WHERE kode_mk='".$row["kode_MK"]."'";
				$result_MK = @mysql_query($sql_MK);
				$row_MK=@mysql_fetch_array($result_MK);
				echo $row_MK["nama"];
			?>
		</td>
		<td nowrap valign="top"><? echo $row["sks"]; ?></td>
		<td nowrap valign="top"><? echo $row["kp"];?></td>
        <td nowrap valign="top"><? echo $row["kode_dsn"]; ?></td>
        <td nowrap valign="top">
			<?
				$sql_dosen_1="SELECT nama
							  FROM dosen
							  WHERE kode='".$row["kode_dsn"]."'";
				$result_dosen_1 = @mysql_query($sql_dosen_1);
				$row_dosen_1=@mysql_fetch_array($result_dosen_1);
				echo $row_dosen_1["nama"];
			?>
		</td>
        <td nowrap valign="top"><? echo $row["seharusnya"]; ?></td>
        <td nowrap valign="top"><? echo $row["kehadiran"]; ?></td>
        <td nowrap valign="top"><? if ($row["persentasi"]!="") { echo number_format($row["persentasi"], 2,'.','')."%";} ?></td>
      </tr>
      <?
}
?>
    </table>
	<input name="excel"   type="image" onClick="document.fexcel.action='lap_rekap_dsn_export.php?t=excel'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
	Export ke File Excel&nbsp;
	<input name="printer" type="image" onClick="document.fexcel.action='lap_rekap_dsn_export.php?t=printer'" src="../img/print.gif" align="bottom" width="18" height="18"> 
	Print
</FORM>
<?
}
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
</body>
</html>