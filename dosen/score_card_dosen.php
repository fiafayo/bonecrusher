<?
/* 
   DATE CREATED : 03/04/08
   KEGUNAAN: MENAMPILKAN SCORE CARD
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

?>
<html>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../include/tanggalan.js">
</script>
<body class="body">
<?php
f_connecting();
mysql_select_db($DB);
if ($mode=="" || $mode=="0") 
{
?>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN ~</strong> 
      SCORE CARD</font></font></td>
    <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">DOSEN</font></strong></div></td>
  </tr>
</table>
<strong><font color="#0099CC" size="1"></font></strong> 
<hr size="1" color="#FF9900">
<form name="form_penelitian" id="form_penelitian">
  <table width="100%" class="body">
    <tr>
      <td width="9%">&nbsp;</td>
      <td width="19%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="70%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Periode</td>
      <td><strong>:</strong></td>
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
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Jurusan</td>
      <td><strong>:</strong></td>
      <td> 
	     <select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku">
          <option value="all">Semua 
          <?php
				 mysql_select_db($DB);
				 $result3 = @mysql_query("SELECT * FROM jurusan WHERE `jurusan`.id<>0 ORDER BY id ASC");
				 while(($row3 = mysql_fetch_array($result3)))
				 {
				    echo "<option value=".$row3["id"].">".$row3["jurusan"];
				 }
			?>
          </select>
		</td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>NPK Dosen</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="frm_s_kode" id="frm_s_kode" class="tekboxku"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nama</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="frm_s_nama" id="frm_s_nama" class="tekboxku"></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td nowrap><i>Banyak Data yang ditampilkan</i></td>
      <td><strong>:</strong></td>
      <td> <select name="frm_s_jum_data" id="frm_s_jum_data" class="tekboxku">
          <option value=10>10 
          <option value=15>15 
          <option value=20 selected>20 </select> </td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td></td> 
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
$sql="SELECT dosen.kode,
		     dosen.nama,
			 dosen.jurusan
		FROM dosen
	   WHERE dosen.jurusan<>'' ";			
if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_s_jurusan != "all")
	{ $sql.=" and dosen.jurusan='".$frm_s_jurusan."'";}	
	if ($frm_s_kode!="")
	{ $sql=$sql." and dosen.kode like '%".$frm_s_kode."%'"; } 
	if ($frm_s_nama!="")
	{ $sql=$sql." and dosen.nama like '%".$frm_s_nama."%'"; } 
	
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
	//echo "SQL=".$sql;
	//exit();
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

$vlink="score_card_dosen.php";
$abc="?mode=2&frm_s_jurusan=$frm_s_jurusan&frm_s_kode=$frm_s_kode&frm_s_nama=$frm_s_nama&frm_s_jum_data=$frm_s_jum_data";

$vlink=$vlink.$abc;

$fontface="Verdana,Arial,Helvetica,sans-serif";
$fontsize="2";
}

//halaman
if ($mode=="2") { $sql=$sql." limit ".$limit; }
if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

// LAPORAN YANG DIHASILKAN
?>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN 
      ~</strong> SCORE CARD</font></font></td>
    <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">DOSEN</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div><br>
<?
if (mysql_num_rows($result)==0) {
    echo "<br><font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=score_card_dosen.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}

if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="score_card_dosen_export.php">
<input type="hidden" name="mode" value="3">
<input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
<input type="hidden" name="frm_s_kode" id="frm_s_kode" value="<?php echo  $frm_s_kode;?>">
<input type="hidden" name="frm_s_nama" id="frm_s_nama" value="<?php echo  $frm_s_nama;?>">
<input type="hidden" name="frm_s_jum_data" id="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<input type="hidden" name="frm_o1" id="frm_o1" value="<?php echo $frm_o1; ?>">
<input type="hidden" name="frm_o2" id="frm_o2" value="<?php echo $frm_o2; ?>">
<input type="hidden" name="frm_o3" id="frm_o3" value="<?php echo $frm_o3; ?>">
<?
}
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
<table class="table"  border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="#C6E2FF">
   			<td nowrap><b>Jurusan</b></td>
			<td nowrap><b>Dosen</b></td>
			<td nowrap bgcolor="#C6E2FF"><b>Pengajaran</b></td>
			<td nowrap><b>Penelitian</b></td>
			<td nowrap><b>Pengabdian</b></td>
		</tr>
<?
while(($row = mysql_fetch_array($result)))
{
?>
		<tr>
			<td nowrap valign="top">
				<?
				$sql_nama_jurusan="SELECT id
							       FROM jurusan
							       WHERE id='".$row["jurusan"]."'";
				$result_nama_jurusan = @mysql_query($sql_nama_jurusan);
				$row_nama_jurusan=@mysql_fetch_array($result_nama_jurusan);
				//echo $row_nama_jurusan["id"];
				switch ($row_nama_jurusan["id"]) {
					case 1:
						$nama_jurusan='TE';
						break;
					case 2:
						$nama_jurusan='TK';
						break;
					case 3:
						$nama_jurusan='TI';
						break;
					case 4:
						$nama_jurusan='IF';
						break;
					case 5:
						$nama_jurusan='TM';
						break;
					}
					echo $nama_jurusan;
			   ?>
			</td>
			<td nowrap valign="top"><? echo $row["kode"]."-".$row["nama"]; ?></td>
			
			
			<td valign="top" nowrap>
			<? 
				$sql_ajar="SELECT distinct
								  rekap_dosen.kode_MK,
								  rekap_dosen.nama_MK,
								  rekap_dosen.kp
							 FROM rekap_dosen
							WHERE rekap_dosen.kode_dsn='".$row["kode"]."'";
				$result_ajar=@mysql_query($sql_ajar);
				//$row_ajar=@mysql_fetch_array($result_ajar);
				while($row_ajar = mysql_fetch_array($result_ajar))
				{
					echo $row_ajar["kode_MK"]."-".$row_ajar["nama_MK"]."(".$row_ajar["kp"].")<br>";
				}
			?>
			</td>
			
			<td nowrap valign="top">
				 <? 
				  $sql_penelitian="SELECT distinct
										  penelitian.kode_dosen,
										  penelitian.kode_pen,
										  penelitian.judul,
										  jenis_kerjasama.nama
									 FROM penelitian, jenis_kerjasama
									WHERE penelitian.publikasi=jenis_kerjasama.id and
									      penelitian.kode_dosen='".$row["kode"]."'";
						
						
						/*$sql_penelitian="SELECT distinct
												penelitian.kode_dosen,
												penelitian.kode_pen,
												penelitian.judul,
												jenis_kerjasama.nama
										   FROM penelitian, jenis_kerjasama
										  WHERE penelitian.kode_dosen='".$row["kode"]."'";*/
											
											
						$result_penelitian=@mysql_query($sql_penelitian);
						//$row_ajar=@mysql_fetch_array($result_ajar);
						while($row_penel = mysql_fetch_array($result_penelitian))
						{
							echo $row_penel["kode_pen"]."-".$row_penel["judul"]." (<i>".$row_penel["nama"]."</i>)<br>";
						}
			     ?>
			</td>
			<td valign="top" nowrap>
				<? 
					$sql_pengabdian="SELECT distinct
											pengabdian.kode,
											pengabdian.judul,
											jenis_kerjasama.nama
									   FROM pengabdian,jenis_kerjasama
								      WHERE pengabdian.id_jenis=jenis_kerjasama.id and
									        pengabdian.kode_dosen='".$row["kode"]."'";
					$result_pengabdian=@mysql_query($sql_pengabdian);
					//$row_ajar=@mysql_fetch_array($result_ajar);
					while($row_pengabdian = mysql_fetch_array($result_pengabdian))
					{
						echo $row_pengabdian["kode"]."-".$row_pengabdian["judul"]." (<i>".$row_pengabdian["nama"]."</i>)<br>";
					}
			     ?>
			</td>
		  <?
	$a++;

?>		
		</tr>
<?
}
?><tr>
		<td colspan=6>
			<input name="excel" type="image" onClick="document.fexcel.action='score_card_dosen_export.php?t=excel'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
			Export ke File Excel
			<input name="printer" type="image"  onClick="document.fexcel.action='score_card_dosen_export.php?t=printer'" src="../img/print.gif" align="bottom" width="18" height="18"> 
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