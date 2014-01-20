<?php
/* 
   DATE CREATED : 12/04/10
   LAST UPDATE  : 
   
   KEGUNAAN     : EXPORT KELULUSAN MAHASISWA
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
      ~</strong> EXPORT KELULUSAN MAHASISWA</font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form name="lap_lulus_ta" id="lap_lulus_ta">
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
      <td width="414"><select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku">
          <option value="all">Semua 
          <?php
				 $result2 = @mysql_query("SELECT * FROM `jurusan` WHERE `jurusan`.id>0 AND `jurusan`.id<=8");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["id2"].">".$row2["jurusan"];
	             }
         	?>
        </select></td>
    </tr>
    <tr>
      <td nowrap>Periode Semester </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	<select name="frm_id_tahun_ajar" id="frm_id_tahun_ajar" class="tekboxku">
    <option value="all">Tahun Ajaran</option>
    <?php
	$result1 = @mysql_query("SELECT id, 
									tahun_ajaran, 
									semester, 
									DATE_FORMAT(awal,'%Y/%m/%d') as awal, 
									DATE_FORMAT(akhir,'%Y/%m/%d') as akhir 
							   FROM tahun_ajar 
						   ORDER BY awal DESC");
	$c=0;
	if ($frm_id_tahun_ajar=='') { $cek_id_tahun_ajar=$row1->id; }
	else { $cek_id_tahun_ajar=$frm_id_tahun_ajar; }
	
	while ($row1=@mysql_fetch_object($result1))  {
	$c=$c+1;
	?>
        <option value="<?php echo $row1->id; ?>" <?php 
		  if ($frm_id_tahun_ajar!='') 
		  { 
		    if ($row1->id==$cek_id_tahun_ajar)
		    { echo "selected"; }
		  }
		  /*else
		  { if ((date('Y/m/d')<=$row1->akhir) and (date('Y/m/d')>=$row1->awal))
		    { $current_semester=$row1->id; 
			  echo "selected";
			} 
		  }*/ ?> >SEMESTER <?php echo $row1->semester; ?> <?php echo $row1->tahun_ajaran; ?> - <?php echo $row1->tahun_ajaran+1; ?>
        <?php
	}
	?>
      </select></td>
    </tr>
    <tr>
      <td nowrap>Periode Tanggal Lulus S1 </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <?php //echo date('d/m/Y'); ?>
	  	<input name="frm_tgl_periode" type="text" class="tekboxku" id="frm_tgl_periode" value="" size="10" maxlength="10">
        <A Href="javascript:show_calendar('lap_lulus_ta.frm_tgl_periode',0,0,'DD/MM/YYYY')"> <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> </A>&nbsp;&nbsp;&nbsp;&nbsp;s/d&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="frm_tgl_periode2" type="text" class="tekboxku" id="frm_tgl_periode2" value="" size="10" maxlength="10">
        <A Href="javascript:show_calendar('lap_lulus_ta.frm_tgl_periode2',0,0,'DD/MM/YYYY')"> <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy) 
	  </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td nowrap><i>Banyak Data yang ditampilkan</i></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> 
	      <select name="frm_s_jum_data" id="frm_s_jum_data" class="tekboxku">
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
/*$sql="SELECT master_mhs.NRP,
			 master_mhs.NAMA,
			 master_ta.JUDUL_TA,
			 master_ta.KODOS1,
			 master_ta.KODOS2,
			 DATE_FORMAT(`master_ta`.`TGL_TA`,'%d/%m/%Y') as TGL_AWAL,
			 DATE_FORMAT(`master_ta`.`AKHIR1`,'%d/%m/%Y') as TGL_AKHIR,
			 DATE_FORMAT(`master_ta`.`AKHIR2`,'%d/%m/%Y') as TGL_AKHIR2,
			 DATE_FORMAT(`lulus_ta`.`tgl_lulus`,'%d/%m/%Y') as TGL_LULUS,
			 master_mhs.jurusan,
			 lulus_ta.nilai_ujian,
			 master_ta.status,
			 master_ta.KOLUS
        FROM master_ta,master_mhs,lulus_ta
	   WHERE master_ta.NRP=master_mhs.NRP AND 
			 master_ta.NRP=lulus_ta.NRP AND 
			 master_ta.KOLUS='L' AND master_ta.STATUS='S'";*/
			 
$sql="SELECT DATE_FORMAT(`lulus_ta`.`tgl_lulus`,'%d/%m/%Y') as TGL_LULUS_S1,
			 lulus_ta.NRP,
			 lulus_ta.tahun,
			 lulus_ta.semester,
			 lulus_ta.bidang_minat,
			 no_surat.N_SK_LULUS
        FROM lulus_ta, no_surat, master_ta, master_mhs
	   WHERE (lulus_ta.NRP=no_surat.NRP) AND 
			 (lulus_ta.NRP=master_ta.NRP) AND 
			 (master_mhs.NRP = lulus_ta.NRP) AND
			 master_ta.KOLUS='L' AND master_ta.STATUS='S'";

if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
	
	if ($frm_s_jurusan!="all")
	{ 
		$sql .= " and master_mhs.jurusan='".$frm_s_jurusan."'";
	}
	
	if($frm_id_tahun_ajar!="all")
	{ 
		$result_periode = @mysql_query("SELECT  id, 
												tahun_ajaran, 
												semester, 
												DATE_FORMAT(awal,'%Y/%m/%d') as awal, 
												DATE_FORMAT(akhir,'%Y/%m/%d') as akhir 
										   FROM tahun_ajar 
										  WHERE id=$frm_id_tahun_ajar ");
		$row_periode=@mysql_fetch_object($result_periode);   
		//$sql=$sql." and (`lulus_ta`.`tgl_lulus` between '".$row_periode->awal."' and '".$row_periode->akhir."')"; 
		$sql=$sql." and (`lulus_ta`.`semester`= '".$row_periode->semester."' and `lulus_ta`.`tahun`= '".$row_periode->tahun_ajaran."')"; 
	}
	
	
	/*switch($frm_urutkan)
	{
		case "jur" :
			$sql=$sql." order by master_mhs.jurusan ASC";
		break;

		case "nrp" :
			$sql=$sql." order by master_mhs.NRP ASC";
		break;

		case "awal" :
			$sql=$sql." order by `master_ta`.`TGL_TA` ASC";
		break;

		case "akhir" :
			$sql=$sql." order by `master_ta`.`AKHIR1` ASC";
		break;

		case "lulus" :
			$sql=$sql." order by `lulus_ta`.`tgl_lulus` ASC";
		break;

	}*/
	
	if($frm_tgl_periode!="" && $frm_tgl_periode2!="")
	{ 
		$sql=$sql." and (`lulus_ta`.`tgl_lulus` between '".datetomysql($frm_tgl_periode)."' and '".datetomysql($frm_tgl_periode2)."')"; 
	}
	else
	{
		if($frm_tgl_periode!="")
		{ 
			$sql=$sql." and (`lulus_ta`.`tgl_lulus` >='".datetomysql($frm_tgl_periode)."')"; 
		}
		if($frm_tgl_periode2!="")
		{ 
			$sql=$sql." and (`lulus_ta`.`tgl_lulus` <='".datetomysql($frm_tgl_periode2)."')"; 
		}
	}
	
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
	//echo "<br>.awal=".$row->awal;
	//echo "<br>.akhir=".$row->akhir;
	//echo "sql=".$sql;
    
}

//f_connecting();

// UNTUK PAGING --------------------------------
if ($mode=="2")
{
//mysql_select_db($DB);
$result=@mysql_query($sql);
//echo "H E R E";
//exit();
$maxrows=mysql_num_rows($result);				
if($hal=="") { $hal=1; }
$recke=(($hal-1)*$frm_s_jum_data);
$limit="$recke,$frm_s_jum_data";
$jumhal=ceil($maxrows/$frm_s_jum_data);
//echo $frm_tanggal_lulus1;
$vlink="mhs_lap_export_lulus.php";
$abc="?mode=2&frm_s_jurusan=$frm_s_jurusan&frm_tgl_periode=$frm_tgl_periode&frm_tgl_periode2=$frm_tgl_periode2&frm_id_tahun_ajar=$frm_id_tahun_ajar&frm_s_jum_data=$frm_s_jum_data&frm_urutkan=$frm_urutkan";

$vlink=$vlink.$abc;

$fontface="Verdana,Arial,Helvetica,sans-serif";
$fontsize="2";
}
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
      ~</strong> </font><font color="#006699"><font color="#0099CC" size="1">EXPORT KELULUSAN MAHASISWA</font></font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<div align="right">
   <font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y");?> </b></font>
</div><br><br>

<?

// Jurusan dan Periode			
echo "<table width=100%>"; 
if ($frm_s_jurusan!="all")
	{
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id2='".$frm_s_jurusan."'";
		$result_jur = @mysql_query($sql_jur);
		$row_jur = @mysql_fetch_array($result_jur);
		echo "<td width=90%><b>Jurusan: </b>".$row_jur["nama_jur"]."</td>";
	}
	else
	{
		echo "<td width=90%><b>Jurusan: </b>Semua";
	}
	
if ($frm_id_tahun_ajar!="all")
	{	
		$thn_next=$row_periode->tahun_ajaran + 1;
		echo "<td align=\"right\" width=10% nowrap><b>Periode Semester : </b>".$row_periode->semester." ".$row_periode->tahun_ajaran."<b>-</b> ".$thn_next."</td>";
	}
	else
	{
		echo "<td align=\"right\" width=10% nowrap><b>Periode Tgl.Lulus : </b>".$frm_tgl_periode."<b> - </b> ".$frm_tgl_periode2;
	}
echo "</tr>
	  </table>";
// Jurusan dan Periode END	

if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="mhs_lap_informasi_mhs_lulus_TA_export.php">
<input type="hidden" name="mode" id="mode" value="3">
<input type="hidden" name="frm_id_tahun_ajar" id="frm_id_tahun_ajar" value="<?php echo $frm_id_tahun_ajar;?>">
<input type="hidden" name="frm_s_jum_data" id="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<input type="hidden" name="frm_urutkan" id="frm_urutkan" value="<?php echo $frm_urutkan; ?>">
<input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
<input type="hidden" name="frm_tgl_periode" id="frm_tgl_periode" value="<?php echo $frm_tgl_periode; ?>">
<input type="hidden" name="frm_tgl_periode2" id="frm_tgl_periode2" value="<?php echo $frm_tgl_periode2; ?>">
<?
}

if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=mhs_lap_export_lulus.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}		 

	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
		<table width="100%"  border="1" cellspacing="0" cellpadding="5" class="table">
		  <tr bgcolor="#C6E2FF">
			<td><strong>No.</strong></td>
			<td nowrap><strong>NRP</strong></td>
			<td nowrap><strong>Tahun Lulus</strong></td>
			<td nowrap><strong>Semester Lulus</strong></td>
			<td nowrap><strong>No.SK</strong></td>
			<td nowrap><strong>Tgl. SK</strong></td>
			<td nowrap><strong>Bidang Minat </strong></td>
		  </tr>
<?
$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
?>
          <tr> 
            <td><? echo ($hal-1)*$frm_s_jum_data+$a; ?></td>
            <td nowrap><? echo $row["NRP"]; ?></td>
            <td nowrap><? echo $row["tahun"]; ?></td>
            <td nowrap><? echo $row["semester"]; ?></td>
            <td nowrap><? echo $row["N_SK_LULUS"]; ?></td>
            <td nowrap><? echo $row["TGL_LULUS_S1"]; ?></td>
            <td nowrap><? echo $row["bidang_minat"]; ?></td>
          </tr>
<?
}
?>
        </table>
	<input name="excel"   type="image" onClick="document.fexcel.action='mhs_lap_export_lulus_export.php?t=excel'" src="../../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
	Export ke File Excel &nbsp;
	<input name="printer"  onClick="document.fexcel.action='mhs_lap_export_lulus_export.php?t=printer'" type="image" src="../../img/print.gif" width="18" height="18"> 
	Print
</FORM>
<?
}
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
</body>
</html>