<?
/* 
   DATE CREATED : 26/04/08
   KEGUNAAN: MENAMPILKAN PROFIL DOSEN
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
      PROFIL DOSEN</font></font></td>
    <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">DOSEN</font></strong></div></td>
  </tr>
</table>
<strong><font color="#0099CC" size="1"></font></strong> 
<hr size="1" color="#FF9900">
<form name="form_lap_profil_dsn" id="form_lap_profil_dsn">
  <table width="100%" class="body">
    <tr>
      <td width="9%">&nbsp;</td>
      <td width="19%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="70%">&nbsp;</td>
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
			 dosen.id_jenis,
			 dosen.NPK,
			 dosen.nama,
			 dosen.kelamin,
			 dosen.jurusan,
			 dosen.pangkat,
			 dosen.pangkat_kopertis,
			 DATE_FORMAT(dosen.tanggal_masuk,\"%d/%m/%Y\") as tanggal_masuk,
			 dosen.jab_struktural,
			 dosen.jab_akademik,
			 dosen.jab_kopertis,
			 DATE_FORMAT(dosen.tanggal_pengangkatan_kopertis,\"%d/%m/%Y\") as tanggal_pengangkatan_kopertis,
			 DATE_FORMAT(dosen.tanggal_pengangkatan,\"%d/%m/%Y\") as tanggal_pengangkatan,
			 dosen.`status`,
			 dosen.tempat_lahir,
			 DATE_FORMAT(dosen.tanggal_lahir,\"%d/%m/%Y\") as tanggal_lahir,
			 dosen.alamat,
			 dosen.telepon,
			 dosen.no_hp,
			 dosen.no_ktp,
			 dosen.pendidikan_terakhir,
			 dosen.bidang_keahlian
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

$vlink="lap_profil_dosen.php";
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
      ~</strong> PROFIL DOSEN</font></font></td>
    <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">DOSEN</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div><br>
<?
if (mysql_num_rows($result)==0) {
    echo "<br><font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=lap_profil_dosen.php class=menu_left>:: Kembali</a>";
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
$a=1;
}
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
<table class="table"  border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="#C6E2FF">
		    <td nowrap><b>No.</b></td>
   			<td nowrap><b>Jurusan</b></td>
			<td nowrap><b>Kode</b></td>
			<td nowrap><b>Nama</b></td>
			<td nowrap><b>Jab. Akademik</b></td>
			<td nowrap><b>Tempat Lahir</b></td>
			<td nowrap><b>Tgl. Lahir </b></td>
			<td nowrap><b>Alamat</b></td>
			<td nowrap><b>Telpon</b></td>
			<td nowrap><b>No.HP</b></td>
		    <td nowrap><b>Pend.Terakhir</b></td>
		    <td nowrap><b>Keahlian</b></td>
		</tr>
<?

while(($row = mysql_fetch_array($result)))
{
?>
		<tr>
		    <td nowrap><? echo ($hal-1)*$frm_s_jum_data+$a; ?></td>
			<td nowrap>
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
			<td nowrap><? echo $row["kode"]; ?></td>
			<td nowrap><? echo $row["nama"]; ?></td>
			<td nowrap><? echo $row["jab_akademik"];?></td>
			<td nowrap><? echo $row["tempat_lahir"];?></td>
			<td nowrap><? echo $row["tanggal_lahir"];?></td>
		    <td nowrap><? echo $row["alamat"];?></td>
		    <td nowrap><? echo $row["telepon"];?></td>
		    <td nowrap><? echo $row["no_hp"];?></td>
		    <td nowrap><? 
				$sql_didik_akhir="SELECT id, nama
							        FROM pendidikan
							       WHERE id=".$row["pendidikan_terakhir"];
				$result_didik_akhir = @mysql_query($sql_didik_akhir);
				$row_didik_akhir=@mysql_fetch_array($result_didik_akhir);
				echo $row_didik_akhir["nama"];?>
			</td>
		    <td nowrap><? echo $row["bidang_keahlian"];?></td>
	      <?
	$a++;

?>		
		</tr>
<?
}
?><tr>
		<td colspan=12>
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