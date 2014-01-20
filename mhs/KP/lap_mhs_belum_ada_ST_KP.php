<?php
/* 
   DATE CREATED : 05/10/07
   UPDATE       : 04/02/09 - penambahan jumlah mhs kp (total 6)
                  17/06/09 - penambahan jumlah mhs kp (total 8)
   KEGUNAAN     : MENAMPILKAN MAHASISWA YANG BELEUM ADA SURAT TUGAS KP
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

// CEK AUTHENTIFIKASI USER
//if (!f_authenticate_user($USERNAME,$PASSWORD,$LOGGED))
//{
//	header("Location:http://".$HOSTNAME."/login.htm");
//	exit();
//}
f_connecting();
mysql_select_db($DB);
?>
<html>
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<body class="body">
<?php

if ($mode=="" || $mode=="0") 
{
?>
<br>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN 
    ~</strong> MAHASISWA BELUM ADA SURAT TUGAS KP</font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form>
  <table width="100%" align="center" class="body" >
    <tr>
      <td width="11%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="69%">&nbsp;</td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>Jurusan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_s_jurusan" class="tekboxku">
        <option value="all">Semua
        <?php
  	             $result2 = mysql_query("SELECT * FROM jurusan WHERE id>0 AND id<=8");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["id"].">".$row2["jurusan"];
	             }
         	?>
      </select></td>
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
/*$sql="select ta.*,
			 master_karyawan.id as id_karyawan
	  from ta, master_karyawan
	  where (ta.id_dosen1=master_karyawan.id or ta.id_dosen1=master_karyawan.kode) ";*/
	  
	  echo "<br>jurusan=".$frm_s_jurusan;
		switch ($frm_s_jurusan) {
			case '1':
				$jur_kode='TE';
				$jur_kode2='61';
				break;
			case '2':
				$jur_kode='TK';
				$jur_kode2='62';
				break;
			case '3':
				$jur_kode='TI';
				$jur_kode2='63';
				break;
			case '4':
				$jur_kode='IF';
				$jur_kode2='64';
				break;
			case '5':
				$jur_kode='TM';
				$jur_kode2='65';
				break;
			case '6':
				$jur_kode='DMP';
				$jur_kode2='66';
				break;		
			case '7':
				$jur_kode='SI';
				$jur_kode2='67';
				break;		
			case '8':
				$jur_kode='MM';
				$jur_kode2='68';
				break;		
			case '9':
				$jur_kode='DD';
				$jur_kode2='69';
				break;		
		}
$sekarang=date("Y-m-d");        
$sql="SELECT  `daftar_kp`.`NO_MOHON`,
			  `daftar_kp`.`UR_MOHON`,
			  `daftar_kp`.`KODE_KP`,
			  `daftar_kp`.`NRP_1`,
			  `daftar_kp`.`NRP_2`,
			  `daftar_kp`.`NRP_3`,
			  `daftar_kp`.`NRP_4`,
			  `daftar_kp`.`NRP_5`,
			  `daftar_kp`.`NRP_6`,
			  `daftar_kp`.`NRP_7`,
			  `daftar_kp`.`NRP_8`,
			  `daftar_kp`.`NA_PERUSH`,
			  `daftar_kp`.`JALAN`,
			  `daftar_kp`.`KOTA`,
			   DATE_FORMAT(`daftar_kp`.`TGL_AWAL`,'%d/%m/%Y') as TGL_AWAL,
			   DATE_FORMAT(`daftar_kp`.`TGL_END`,'%d/%m/%Y') as TGL_END,
			   DATE_FORMAT(`daftar_kp`.`TGL_MOHON`,'%d/%m/%Y') as TGL_MOHON,
			  `daftar_kp`.`NO_ST`,
			  `daftar_kp`.`UR_ST`,
			  `daftar_kp`.`DOSEN`,
			  `daftar_kp`.`PEM_PERUS`,
			   DATE_FORMAT(`daftar_kp`.`TGL_ST`,'%d/%m/%Y') as TGL_ST,
			  `daftar_kp`.`NO_NKP`,
			  `daftar_kp`.`UR_NKP`,
			  `daftar_kp`.`TGL_NKP`,
			  `daftar_kp`.`HONOR`,
			  `daftar_kp`.`STATUS`
		FROM  daftar_kp 
		WHERE `daftar_kp`.`NO_ST`=''";
		//WHERE `daftar_kp`.`NO_MOHON`='".$frm_no_SP_KP."')";
	  
if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)

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
	
	if ($frm_s_jurusan!="all")
	{ $sql=$sql." and (`daftar_kp`.`KODE_KP` like '".$jur_kode."%' or `daftar_kp`.`KODE_KP` like '".$jur_kode2."%')"; }
	/*if ($frm_s_judul!="")
	{ $sql=$sql." and ta.judul like '%".$frm_s_judul."%'"; } */
	
	
//echo "<br>SQL= ".$sql;
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


$vlink="lap_mhs_belum_ada_ST_KP.php";
$abc="?mode=2&frm_s_jurusan=$frm_s_jurusan&frm_s_jum_data=$frm_s_jum_data";

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
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN 
      ~</strong> </font><font color="#006699"><font color="#0099CC" size="1">MAHASISWA </font><font color="#006699"><font color="#0099CC" size="1">BELUM ADA SURAT TUGAS KP</font></font></font></font> </td>
    <td width="11%"><div align="center"></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div><br>
<?

if ($frm_s_jurusan!="all")
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
	}

if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="lap_mhs_belum_ada_ST_KP.php">
<input type="hidden" name="mode" id="mode" value="3">
<input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<? echo $frm_s_jurusan?>">
<input type="hidden" name="frm_NRP" id="frm_NRP" value="<?php echo $frm_NRP; ?>">

<?
}
if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=lap_mhs_belum_ada_ST_KP.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}
if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
	<table width="100%"  border="1" cellspacing="0" cellpadding="5" class="table">
		  <tr bgcolor="#C6E2FF">
			<td><strong>No.</strong></td>
			<td nowrap><strong>Kode KP</strong></td>
			<td nowrap><strong>Jurusan</strong></td>
			<td nowrap><strong>No. Surat Permohonan KP</strong></td>
			<td nowrap><strong>Tgl Surat Permohonan KP</strong></td>
			<td nowrap><strong>Mahasiswa</strong></td>
			<td nowrap><strong>Kerja Praktek di</strong></td>
			<td nowrap><strong>Jalan</strong></td>
			<td nowrap><strong>Kota</strong></td>
			<td nowrap><strong>Dosen Pembimbing</strong></td>
			<td nowrap><strong>Pembimbing Perusahaan</strong></td>
			<td nowrap><strong>Tgl Mulai KP</strong></td>
			<td nowrap><strong>Tgl Selesai KP</strong></td>
			<td nowrap><strong>No. Surat Tugas KP</strong></td>
			<td nowrap><strong>Tgl Surat Tugas KP</strong></td>
		  </tr>
<?

$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
	$kodeKP=substr($row["KODE_KP"],0,2);
	switch ($kodeKP)
	{
		case 'TE':
			$jur_nama="Teknik Elektro";
			break;
		case 'TK':
			$jur_nama="Teknik Kimia";
			break;
		case 'TI':
			$jur_nama="Teknik Industri";
			break;
		case 'IF':
			$jur_nama="Teknik Informatika";
			break;
		case 'TM':
			$jur_nama="Teknik Manufaktur";
			break;
		case 'DMP':
			$jur_nama="Desain Manajemen Produk";
			break;
		case 'SI':
			$jur_nama="Sistem Informasi";
			break;
		case 'MM':
			$jur_nama="Multimedia";
			break;
		case 'DD':
			$jur_nama="Dual Degree";
			break;
		case '61':
			$jur_nama="Teknik Elektro";
			break;
		case '62':
			$jur_nama="Teknik Kimia";
			break;
		case '63':
			$jur_nama="Teknik Industri";
			break;
		case '64':
			$jur_nama="Teknik Informatika";
			break;
		case '65':
			$jur_nama="Teknik Manufaktur";
			break;
		case '66':
			$jur_nama="Desain Manajemen Produk";
			break;
		case '67':
			$jur_nama="Sistem Informasi";
			break;
		case '68':
			$jur_nama="Multimedia";
			break;
		case '69':
			$jur_nama="Dual Degree";
			break;
	}
?>
			<tr>
			  <td nowrap valign="top"><? echo ($hal-1)*$frm_s_jum_data+$a; ?></td>
			  <td nowrap valign="top"><? echo $row["KODE_KP"]; ?></td>
			  <td nowrap valign="top"><? echo $jur_nama; ?></td>
			  <td nowrap valign="top"><? echo $row["NO_MOHON"]; ?></td>
			  <td nowrap valign="top"><? echo $row["TGL_MOHON"]; ?></td>
			  <td nowrap valign="top">
					<? 
					   if ($frm_NRP<>"")
					   {
							$result_mhs = mysql_query("Select NAMA from master_mhs WHERE NRP='".$frm_NRP."'");
							$row_mhs= mysql_fetch_array($result_mhs);
							$var_nama_mhs = $row_mhs["NAMA"];
							echo $frm_NRP."-".$var_nama_mhs;
					   }
					   else
					   {
							if ($row["NRP_1"]!='')
								{
									$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_1"]."'");
									$row_mhs= mysql_fetch_array($result_mhs);
									$var_nama_mhs = $row_mhs["NAMA"];
									echo $row["NRP_1"]."-".$var_nama_mhs."<br>";
								}	
								
							if ($row["NRP_2"]!='')
								{
									$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_2"]."'");
									$row_mhs= mysql_fetch_array($result_mhs);
									$var_nama_mhs = $row_mhs["NAMA"];
									echo $row["NRP_2"]."-".$var_nama_mhs."<br>";
								}	
								
							if ($row["NRP_3"]!='')
								{
									$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_3"]."'");
									$row_mhs= mysql_fetch_array($result_mhs);
									$var_nama_mhs = $row_mhs["NAMA"];
									echo $row["NRP_3"]."-".$var_nama_mhs."<br>";
								}	
							
							if ($row["NRP_4"]!='')
								{
									$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_4"]."'");
									$row_mhs= mysql_fetch_array($result_mhs);
									$var_nama_mhs = $row_mhs["NAMA"];
									echo $row["NRP_4"]."-".$var_nama_mhs."<br>";
								}
								
							if ($row["NRP_5"]!='')
								{
									$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_5"]."'");
									$row_mhs= mysql_fetch_array($result_mhs);
									$var_nama_mhs = $row_mhs["NAMA"];
									echo $row["NRP_5"]."-".$var_nama_mhs."<br>";
								}
								
							if ($row["NRP_6"]!='')
								{
									$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_6"]."'");
									$row_mhs= mysql_fetch_array($result_mhs);
									$var_nama_mhs = $row_mhs["NAMA"];
									echo $row["NRP_6"]."-".$var_nama_mhs."<br>";
								}
								
							if ($row["NRP_7"]!='')
								{
									$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_7"]."'");
									$row_mhs= mysql_fetch_array($result_mhs);
									$var_nama_mhs = $row_mhs["NAMA"];
									echo $row["NRP_7"]."-".$var_nama_mhs."<br>";
								}
								
							if ($row["NRP_8"]!='')
								{
									$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$row["NRP_8"]."'");
									$row_mhs= mysql_fetch_array($result_mhs);
									$var_nama_mhs = $row_mhs["NAMA"];
									echo $row["NRP_8"]."-".$var_nama_mhs."<br>";
								}
								
								
								
						}	
					 ?>
			  </td>
			  <td nowrap valign="top"><? echo $row["NA_PERUSH"];?></td>
			  <td nowrap valign="top"><? echo $row["JALAN"]; ?></td>
			  <td nowrap valign="top"><? echo $row["KOTA"]; ?></td>
			  <td nowrap valign="top">
			  <? if (($row["DOSEN"]<>"") or ($row["DOSEN"]<>NULL)) 
			     {
					$result_dsn = mysql_query("Select nama from dosen where kode='".$row["DOSEN"]."'");
					$row_dsn= mysql_fetch_array($result_dsn);
					$var_nama_dsn = $row_dsn["nama"];
					echo $row["DOSEN"]."-".$var_nama_dsn;
			     }
			  ?>
			  </td>
			  <td nowrap valign="top"><? echo $row["PEM_PERUS"]; ?></td>
			  <td nowrap valign="top"><? echo $row["TGL_AWAL"]; ?></td>
			  <td nowrap valign="top"><? echo $row["TGL_END"]; ?></td>
			  <td nowrap valign="top"><? echo $row["NO_ST"]; ?></td>
			  <td nowrap valign="top"><? echo $row["TGL_ST"]; ?></td>
		  </tr>
<?
}
?>
	</table>
  
   <input name="excel"   type="image" onClick="document.fexcel.action='lap_mhs_belum_ada_ST_KP_export.php?t=excel'" src="../../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
   Export ke File Excel&nbsp;
    <input name="printer" type="image"  onClick="document.fexcel.action='lap_mhs_belum_ada_ST_KP_export.php?t=printer'" src="../../img/print.gif" align="bottom" width="18" height="18"> 
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