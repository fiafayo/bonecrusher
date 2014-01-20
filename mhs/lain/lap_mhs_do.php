<?php
/* 
   DATE CREATED : 04/12/08
   LAST UPDATE  : 04/12/08 - RAHADI
   KEGUNAAN     : MENAMPILKAN LAPORAN MAHASISWA DO
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
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
      ~</strong> DAFTAR MAHASISWA DO</font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form name="form_mhs_do" id="form_mhs_do">
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
      <td>Jurusan</td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td width="414"><select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku">
          <option value="all">Semua 
          <?php
				 $result2 = @mysql_query("SELECT * FROM `jurusan` WHERE `jurusan`.id>0 AND `jurusan`.id<=8");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["id"].">".$row2["jurusan"];
	             }
         	?>
        </select></td>
    </tr>
    <tr>
      <td nowrap>Angkatan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>	<font color="#FF0000">
        <input name="frm_angkatan" id="frm_angkatan" value="<? echo $frm_angkatan;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*</font></td>
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
			 
$sql="SELECT do.id_do,
			 do.angkatan,
			 do.jurusan_id,
			 do.jum_mhs_aktif,
			 do.jum_mhs_DO,
			 do.semester
        FROM do,jurusan
	   WHERE do.jurusan_id=jurusan.id";

if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
	
	if ($frm_s_jurusan!="all")
	{ 
		$sql .= " and do.jurusan_id='".$frm_s_jurusan."'";
	}
	if ($frm_angkatan!="")
	{ 
		$sql .= " and do.angkatan='".$frm_angkatan."'";
	}
	
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
	//echo "<br>.awal=".$row->awal;
	//echo "<br>.akhir=".$row->akhir;
	//echo "sql=".$sql;
    
}

f_connecting();

// UNTUK PAGING --------------------------------
if ($mode=="2")
{
mysql_select_db($DB);
$result=mysql_query($sql);

$maxrows=mysql_num_rows($result);	
//echo "maxrows=".$maxrows;
//exit();		
if($hal=="") { $hal=1; }
$recke=(($hal-1)*$frm_s_jum_data);
$limit="$recke,$frm_s_jum_data";
$jumhal=ceil($maxrows/$frm_s_jum_data);
//echo $frm_tanggal_lulus1;
$vlink="lap_mhs_do.php";
$abc="?mode=2&frm_s_jurusan=$frm_s_jurusan&frm_angkatan=$frm_angkatan&frm_s_jum_data=$frm_s_jum_data&frm_urutkan=$frm_urutkan";

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
      ~</strong> DAFTAR MAHASISWA DO </font></font></td>
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
				   WHERE id='".$frm_s_jurusan."'";
		$result_jur = @mysql_query($sql_jur);
		$row_jur = @mysql_fetch_array($result_jur);
		echo "<td width=90%><b>Jurusan: </b>".$row_jur["nama_jur"]."</td>";
	}
	else
	{
		echo "<td width=90%><b>Jurusan: </b>Semua";
	}
	
if ($frm_angkatan!="")
	{	
		echo "<td align=\"right\" width=10% nowrap><b>Angkatan: </b>".$frm_angkatan."</td>";
	}
	else
	{
		echo "<td align=\"right\" width=10% nowrap><b>Angkatan: </b>Semua";
	}
echo "</tr>
	  </table>";
// Jurusan dan Periode END	

if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="lap_mhs_do_export.php">
<input type="hidden" name="mode" id="mode" value="3">
<input type="hidden" name="frm_angkatan" id="frm_angkatan" value="<?php echo $frm_angkatan;?>">
<input type="hidden" name="frm_s_jum_data" id="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<input type="hidden" name="frm_urutkan" id="frm_urutkan" value="<?php echo $frm_urutkan; ?>">
<input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
<?
}

if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=lap_mhs_do.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}		 

	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
		<table width="100%"  border="1" cellspacing="0" cellpadding="5" class="table">
		  <tr bgcolor="#C6E2FF">
			<td><strong>No.</strong></td>
			<td nowrap><strong>Semester</strong></td>
			<td nowrap><strong>Angkatan</strong></td>
			<td nowrap><strong>Jurusan</strong></td>
			<td nowrap><strong>Jumlah Mhs Aktif </strong></td>
			<td nowrap><strong>Jumlah Mhs DO</strong></td>
		  </tr>
<?
$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
?>
          <tr> 
            <td><? echo ($hal-1)*$frm_s_jum_data+$a; ?></td>
			<td nowrap>
					<? 
					$semester=substr($row["semester"],4,1);
					$tahun=substr($row["semester"],0,4);
					$thn_next=$tahun+1;
					if ($semester==1)
					{
						 echo "GASAL ".$tahun."-".$thn_next;
					}
					else
					{
						 echo "GENAP ".$tahun."-".$thn_next;
					}
					?>
			</td>
			<td nowrap><? echo $row["angkatan"]; ?></td>
            <td nowrap> <? //echo $row["jurusan_id"]; ?>
              <? 
					switch ($row["jurusan_id"])
					{
						case '1':
							echo "Teknik Elektro";
							break;
						case '2':
							echo "Teknik Kimia";
							break;
						case '3':
							echo "Teknik Industri";
							break;
						case '4':
							echo "Teknik Informatika";
							break;
						case '5':
							echo "Teknik Manufaktur";
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
				?>
            </td>
            <td nowrap><? echo $row["jum_mhs_aktif"]; ?></td>
            <td nowrap><? echo $row["jum_mhs_DO"]; ?></td>
          </tr>
<?
}
?>
        </table>
	<input name="excel"   type="image" onClick="document.fexcel.action='lap_mhs_do_export.php?t=excel'" src="../../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
	Export ke File Excel &nbsp;
	<input name="printer"  onClick="document.fexcel.action='lap_mhs_do_export.php?t=printer'" type="image" src="../../img/print.gif" width="18" height="18"> 
	Print
</FORM>
<?
}
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
</body>
</html>