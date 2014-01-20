<?php
/* 
   DATE CREATED : 25/01/08
   KEGUNAAN     : MENAMPILKAN LAPORAN REKAP KELULUSAN MK
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
    <td width="89%"><font color="#0099CC" size="1"><strong>LAPORAN ~</strong>KELULUSAN MATA KULIAH</font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">PERKULIAHAN</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form name="form_lap_lulus_mk" id="form_lap_lulus_mk">
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
      <td>
	  <select name="frm_id_tahun_ajar" id="frm_id_tahun_ajar" class="tekboxku">
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
							$sql_MK="SELECT kode_mk, nama
									   FROM master_mk";
							
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
      <td><input name="frm_KP" id="frm_KP" type="text" size="3" maxlength="3" class="tekboxku"></td>
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
   
$sql="SELECT rekap_lulus_mk.id_rlmk,
			 rekap_lulus_mk.id_periode,
			 rekap_lulus_mk.kode_mk,
			 rekap_lulus_mk.nama_mk,
			 rekap_lulus_mk.kp,
			 rekap_lulus_mk.isi,
			 rekap_lulus_mk.a,
			 rekap_lulus_mk.ab,
			 rekap_lulus_mk.b,
			 rekap_lulus_mk.bc,
			 rekap_lulus_mk.c,
			 rekap_lulus_mk.d,
			 rekap_lulus_mk.e
	    FROM rekap_lulus_mk
	   WHERE (rekap_lulus_mk.isi <> '' OR rekap_lulus_mk.isi <> 0)";
	  
if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
//echo "<br>frm_id_tahun_ajar=".$frm_id_tahun_ajar;
//echo "<br>frm_MK=".$frm_MK;
//echo "<br>frm_KP=".$frm_KP;
//echo "<br>frm_status=".$frm_status;
//exit();
	if ($frm_id_tahun_ajar!="all")
		{ $sql=$sql." and (rekap_lulus_mk.id_periode=".$frm_id_tahun_ajar.")"; }
		
	if ($frm_MK!="all")
		{ $sql=$sql." and (rekap_lulus_mk.kode_mk='".$frm_MK."')"; }
		
	if ($frm_KP!="")
		{ $sql=$sql." and (rekap_lulus_mk.kp='".$frm_KP."')"; }
		

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


$vlink="lap_rekap_lulus_mk.php";
$abc="?mode=2&frm_id_tahun_ajar=$frm_id_tahun_ajar&frm_MK=$frm_MK&frm_KP=$frm_KP&frm_s_jum_data=$frm_s_jum_data";

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
    ~</strong>KELULUSAN MATA KULIAH</font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">PERKULIAHAN</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div>
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
	
echo "<b>Periode: </b>";
$gasgen = substr($frm_id_tahun_ajar,4,1);	
$thn_ajar = substr($frm_id_tahun_ajar,0,4);
$thn_plus= intval($thn_ajar)+1;

if ($gasgen==1)
{
	echo "GASAL ".$thn_ajar."-".$thn_plus;
}
else if($gasgen==2)
{
	 echo "GENAP ".$thn_ajar."-".$thn_plus;
}


if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="lap_rekap_lulus_mk.php">
<input type="hidden" name="mode" id="mode" value="3">
<input type="hidden" name="frm_id_tahun_ajar" id="frm_id_tahun_ajar" value="<? echo $frm_id_tahun_ajar?>">
<input type="hidden" name="frm_MK" id="frm_MK" value="<?php echo $frm_MK; ?>">
<input type="hidden" name="frm_KP" id="frm_KP" value="<?php echo $frm_KP; ?>">
<input type="hidden" name="frm_s_jum_data" id="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">

<?
}
if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=lap_rekap_lulus_mk.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}
if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
	<table border="1" cellspacing="0" cellpadding="3" class="table">
      <tr bgcolor="#C6E2FF">
        <td nowrap><strong>KODE MK </strong></td>
        <td nowrap><strong>NAMA MK</strong></td>
        <td nowrap><strong>KP</strong></td>
        <td nowrap><strong>ISI</strong></td>
        <td nowrap>
		<table width="300"  border="1" align="center" cellpadding="0" cellspacing="0" class="table">
          <tr>
            <td colspan="7"><div align="center"><strong>JUMLAH NILAI </strong></div></td>
          </tr>
          <tr>
            <td width="30" align="center"><strong>A</strong></td>
            <td width="30" align="center" bgcolor="#E5E5E5"><strong>AB</strong></td>
            <td width="30" align="center"><strong>B</strong></td>
            <td width="30" align="center" bgcolor="#E5E5E5"><strong>BC</strong></td>
            <td width="30" align="center"><strong>C</strong></td>
            <td width="30" align="center" bgcolor="#E5E5E5"><strong>D</strong></td>
            <td width="30" align="center"><strong>E</strong></td>
          </tr>
        </table></td>
        <td nowrap>
		<table width="405"  border="1" align="center" cellpadding="0" cellspacing="0" class="table">
          <tr>
            <td colspan="7"><div align="center"><strong>PERSENTASE NILAI </strong></div></td>
          </tr>
          <tr>
            <td width="50" bgcolor="#E5E5E5"><div align="center"><strong>A</strong></div></td>
            <td width="50"><div align="center"><strong>AB</strong></div></td>
            <td width="50" bgcolor="#E5E5E5"><div align="center"><strong>B</strong></div></td>
            <td width="50"><div align="center"><strong>BC</strong></div></td>
            <td width="50" bgcolor="#E5E5E5"><div align="center"><strong>C</strong></div></td>
            <td width="50"><div align="center"><strong>D</strong></div></td>
            <td width="50" bgcolor="#E5E5E5"><div align="center"><strong>E</strong></div></td>
          </tr>
        </table></td>
      </tr>
      <?

$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
?>
      <tr>
        <td nowrap valign="top"><? echo $row["kode_mk"];?></td>
        <td nowrap valign="top">
			<?
				$sql_MK="SELECT nama
							  FROM master_mk
							  WHERE kode_mk='".$row["kode_mk"]."'";
				$result_MK = @mysql_query($sql_MK);
				$row_MK=@mysql_fetch_array($result_MK);
				echo $row_MK["nama"];
			?>
		</td>
        
        <td nowrap valign="top"><? echo $row["kp"];?></td>
        <td nowrap valign="top"><? echo $row["isi"]; ?></td>
		<td nowrap valign="top">		
		<table width="300"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="30" align="center" bgcolor="#C6E2FF" ><? echo $row["a"]; ?></td>
            <td width="30" align="center" bgcolor="#E5E5E5"><? echo $row["ab"]; ?></td>
            <td width="30" align="center" bgcolor="#C6E2FF"><? echo $row["b"]; ?></td>
            <td width="30" align="center" bgcolor="#E5E5E5"><? echo $row["bc"]; ?></td>
            <td width="30" align="center" bgcolor="#C6E2FF"><? echo $row["c"]; ?></td>
            <td width="30" align="center" bgcolor="#E5E5E5"><? echo $row["d"]; ?></td>
            <td width="30" align="center" bgcolor="#C6E2FF"><? echo $row["e"]; ?></td>
          </tr>
        </table></td>
        <td nowrap valign="top">
		<table width="400"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td bgcolor="#E5E5E5" width="50" align="center">
				<? 
				   if ($row["a"] <> 0) {
				   $persen_a=($row["a"]/$row["isi"])*100;
				   echo number_format($persen_a,1)."%";
				   }
				 ?>
			
			</td>
            <td width="50" align="center" bgcolor="#C6E2FF">
				<? 
				   if ($row["ab"] <> 0) {
				   $persen_ab=($row["ab"]/$row["isi"])*100;
				   echo number_format($persen_ab,1)."%";
				   }
				 ?>
			</td>
            <td bgcolor="#E5E5E5" width="50" align="center">
			<? 
				   if ($row["b"] <> 0) {
				   $persen_b=($row["b"]/$row["isi"])*100;
				   echo number_format($persen_b,1)."%";
				   }
				 ?>			</td>
            <td width="50" align="center" bgcolor="#C6E2FF">
			<? 
				   if ($row["bc"] <> 0) {
				   $persen_bc=($row["bc"]/$row["isi"])*100;
				   echo number_format($persen_bc,1)."%";
				   }
				 ?>			</td>
            <td bgcolor="#E5E5E5" width="50" align="center">
			<? 
				   if ($row["c"] <> 0) {
				   $persen_c=($row["c"]/$row["isi"])*100;
				   echo number_format($persen_c,1)."%";
				   }
				 ?>			</td>
            <td width="50" align="center" bgcolor="#C6E2FF">
			<? 
				   if ($row["d"] <> 0) {
				   $persen_d=($row["d"]/$row["isi"])*100;
				   echo number_format($persen_d,1)."%";
				   }
				 ?>			</td>
            <td bgcolor="#E5E5E5" width="50" align="center">
			<? 
				   if ($row["e"] <> 0) {
				   $persen_e=($row["e"]/$row["isi"])*100;
				   echo number_format($persen_e,1)."%";
				   }
				 ?>			</td>
          </tr>
        </table></td>
      </tr>
      <?
}
?>
    </table>
	<input name="excel"   type="image" onClick="document.fexcel.action='lap_rekap_lulus_mk_export.php?t=excel'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
	Export ke File Excel&nbsp;
	<input name="printer" type="image" onClick="document.fexcel.action='lap_rekap_lulus_mk_export.php?t=printer'" src="../img/print.gif" align="bottom" width="18" height="18"> 
	Print
</FORM>
<?
}
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
</body>
</html>