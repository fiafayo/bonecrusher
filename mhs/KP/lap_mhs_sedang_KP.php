<?php
/* 
   DATE CREATED : 26/07/07
   UPDATE       : 04/02/09 - penambahan jumlah mhs kp (total 6)
                  17/06/09 - penambahan jumlah mhs kp (total 8)
   KEGUNAAN     : MENAMPILKAN DAFTAR SURAT PERMOHONAN KP
   KETERANGAN   : PROSES MENAMPILKAN SURAT PERMOHONAN KP
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
{ ?>
<br>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN 
    ~</strong> MAHASISWA SEDANG KP</font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form name="form_mhs_sedang_kp" id="form_mhs_sedang_kp">
  <table width="100%" align="center" class="body" >
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>Periode</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_periode" type="text" class="tekboxku" id="frm_tgl_periode" value="<?php echo date('d/m/Y'); ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('form_mhs_sedang_kp.frm_tgl_periode',0,0,'DD/MM/YYYY')"> <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> </A>&nbsp;&nbsp;&nbsp;&nbsp;s/d&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="frm_tgl_periode2" type="text" class="tekboxku" id="frm_tgl_periode2" value="<?php echo date('d/m/Y'); ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('form_mhs_sedang_kp.frm_tgl_periode2',0,0,'DD/MM/YYYY')"> <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy) </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>Jurusan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku">
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
      <td width="11%" nowrap>&nbsp;</td> 
      <td width="18%" nowrap>NRP </td>
      <td width="2%"><div align="center"><strong>:</strong></div></td>
      <td width="69%"><input name="frm_NRP" type="text" class="tekboxku" id="frm_NRP" size="10" maxlength="7"></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>Dosen</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_kode_dobing" id="frm_kode_dobing" class="tekboxku">
        <option <?php if ($frm_kode_dobing==''){echo "selected";}?> value="">--- Pilih ---</option>
        <?php 
				/*$sqlDosen="select kode, nama
						   from dosen 
						   where kode like '61%'";*/

				$sqlDosen="select kode, nama
						   from dosen  where (length(kode)=6) ORDER BY kode";
						   				
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
      <td nowrap>&nbsp;</td>
      <td nowrap>Urutkan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
		  <select name="frm_urut" id="frm_urut" class="tekboxku">
				<option value="`daftar_kp`.`TGL_MOHON`">Tgl. Permohonan KP</option>
		  </select>
	  </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td nowrap>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
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
	 if ($frm_s_jurusan!="all")
	 { echo $frm_s_jurusan;
		switch ($frm_s_jurusan) {
			case '6B':
				$jur_kode='TE';
				$jur_kode2='61';
				break;
			case '6C':
				$jur_kode='TK';
				$jur_kode2='62';
				break;
			case '6D':
				$jur_kode='TI';
				$jur_kode2='63';
				break;
			case '6E':
				$jur_kode='IF';
				$jur_kode2='64';
				break;
			case '6F':
				$jur_kode='TM';
				$jur_kode2='65';
				break;
			case '6G':
				$jur_kode="DMP";
				$jur_kode2="66";
				break;
			case '6H':
				$jur_kode="SI";
				$jur_kode2="67";
				break;
			case '6I':
				$jur_kode="MM";
				$jur_kode2="68";
				break;	
		}
	}
$sekarang=date("Y-m-d");   
//echo "sekarang=" .$sekarang;    
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
		FROM  `daftar_kp` 
		WHERE (`daftar_kp`.`NRP_1` LIKE '".$frm_NRP."%' or `daftar_kp`.`NRP_2` LIKE '".$frm_NRP."%' or
		       `daftar_kp`.`NRP_3` LIKE '".$frm_NRP."%' or `daftar_kp`.`NRP_4` LIKE '".$frm_NRP."%' or
			   `daftar_kp`.`NRP_5` LIKE '".$frm_NRP."%' or `daftar_kp`.`NRP_6` LIKE '".$frm_NRP."%' or
			   `daftar_kp`.`NRP_7` LIKE '".$frm_NRP."%' or `daftar_kp`.`NRP_8` LIKE '".$frm_NRP."%'
			  ) and `daftar_kp`.`status`<>'S1'"; 
			   //and `daftar_kp`.`TGL_END`>='".$sekarang."'";
		//WHERE `daftar_kp`.`NO_MOHON`='".$frm_no_SP_KP."')";
	  //echo "<br>sql=".$sql;
if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)

	if($frm_tgl_periode!="" && $frm_tgl_periode2!="")
	{ 
		$sql=$sql." and (daftar_kp.TGL_END between '".datetomysql($frm_tgl_periode)."' and '".datetomysql($frm_tgl_periode2)."')"; 
	}
	else
	{
		if($frm_tgl_periode!="")
		{ 
			$sql=$sql." and (daftar_kp.TGL_END>='".datetomysql($frm_tgl_periode)."')"; 
		}
		if($frm_tgl_periode2!="")
		{ 
			$sql=$sql." and (daftar_kp.TGL_END<='".datetomysql($frm_tgl_periode2)."')"; 
		}
	}
	
	
	if ($frm_s_jurusan!="all")
	{ $sql=$sql." and (`daftar_kp`.`KODE_KP` like '".$jur_kode."%' or `daftar_kp`.`KODE_KP` like '".$jur_kode2."%')"; }
	
	if ($frm_kode_dobing!="")
	{ $sql=$sql." and daftar_kp.DOSEN = '".$frm_kode_dobing."'"; }
	
	
	if ($frm_urut!="")
	{ $sql=$sql." ORDER BY ".$frm_urut." ASC"; }
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


$vlink="lap_mhs_sedang_KP.php";
$abc="?mode=2&frm_urut=$frm_urut&frm_s_jurusan=$frm_s_jurusan&frm_s_jum_data=$frm_s_jum_data&frm_NRP=$frm_NRP&frm_kode_dobing=$frm_kode_dobing&frm_tgl_periode=$frm_tgl_periode&frm_tgl_periode2=$frm_tgl_periode2";

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
    ~</strong> MAHASISWA SEDANG KP</font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<br>
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div><br>
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
			<td align=\"right\">&nbsp;</td>
		  </tr>
	  </table>";


if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="lap_mhs_sedang_KP.php">
<input type="hidden" name="mode" id="mode" value="3">
<input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<? echo $frm_s_jurusan;?>">
<input type="hidden" name="frm_NRP" id="frm_NRP" value="<?php echo $frm_NRP; ?>">
<input type="hidden" name="frm_kode_dobing" id="frm_kode_dobing" value="<?php echo $frm_kode_dobing; ?>">
<input type="hidden" name="frm_tgl_periode" id="frm_tgl_periode" value="<?php echo $frm_tgl_periode; ?>">
<input type="hidden" name="frm_tgl_periode2" id="frm_tgl_periode2" value="<?php echo $frm_tgl_periode2; ?>">
<input type="hidden" name="frm_urut" id="frm_urut" value="<?php echo $frm_urut; ?>">
<?
}
if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=lap_mhs_sedang_KP.php class=menu_left>:: Kembali</a>";
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
		<td nowrap><strong>Kode Dobing</strong></td>
		<td nowrap><strong>Nama Dobing</strong></td>
		<td nowrap><strong>Pembimbing Perusahaan</strong></td>
		<td nowrap><strong>Tgl Mulai KP</strong></td>
		<td nowrap><strong>Tgl Selesai KP</strong></td>
		<td nowrap><strong>STATUS KP </strong></td>
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
				$jur_kp_kode="TE";
				break;
			case 'TK':
				$jur_nama="Teknik Kimia";
				$jur_kp_kode="TK";
				break;
			case 'TI':
				$jur_nama="Teknik Industri";
				$jur_kp_kode="TI";
				break;
			case 'IF':
				$jur_nama="Teknik Informatika";
				$jur_kp_kode="IF";
				break;
			case 'TM':
				$jur_nama="Teknik Manufaktur";
				$jur_kp_kode="TM";
				break;
			case '61':
				$jur_nama="Teknik Elektro";
				$jur_kp_kode="TE";
				break;
			case '62':
				$jur_nama="Teknik Kimia";
				$jur_kp_kode="TK";
				break;
			case '63':
				$jur_nama="Teknik Industri";
				$jur_kp_kode="TI";
				break;
			case '64':
				$jur_nama="Teknik Informatika";
				$jur_kp_kode="IF";
				break;
			case '65':
				$jur_nama="Teknik Manufaktur";
				$jur_kp_kode="TM";
				break;
			//case '66'||'DMP':
			case '66':
				$jur_nama="Desain Manajemen Produk";
				$jur_kp_kode="DMP";
				break;
			case '67':
				$jur_nama="Sistem Informasi";
				$jur_kp_kode="SI";
				break;
			case '68':
				$jur_nama="Multimedia";
				$jur_kp_kode="MM";
				break;	
	}
?>
			<tr>
			  <td nowrap valign=top><? echo ($hal-1)*$frm_s_jum_data+$a; ?></td>
			  <td nowrap valign=top><? echo $row["KODE_KP"]; ?></td>
			  <td nowrap valign=top><? echo $jur_nama; ?></td>
			  <td nowrap valign=top><? echo $row["NO_MOHON"]; ?></td>
			  <td nowrap valign=top><? echo $row["TGL_MOHON"]; ?></td>
			  <td nowrap valign=top>
					<? 
					   /*if ($frm_NRP<>"")
					   {
							$result_mhs = mysql_query("Select NAMA from master_mhs where NRP='".$frm_NRP."'");
							$row_mhs= mysql_fetch_array($result_mhs);
							$var_nama_mhs = $row_mhs["NAMA"];
							echo $frm_NRP."-".$var_nama_mhs;
					   }
					   else
					   {*/
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
								}						//}	
					 ?>
				</td>
				<td nowrap valign=top><? echo $row["NA_PERUSH"];?></td>
			    <td nowrap valign=top><? echo $row["JALAN"]; ?></td>
			    <td nowrap valign=top><? echo $row["KOTA"]; ?></td>
				<? if ($row["DOSEN"]<>"") 
					{
						$result_dsn = mysql_query("SELECT nama FROM dosen WHERE kode='".$row["DOSEN"]."'");
						$row_dsn= mysql_fetch_array($result_dsn);
						$var_nama_dsn = $row_dsn["nama"];
					}
				?>
			  <td nowrap valign=top><? echo $row["DOSEN"]; ?></td>
			  <td nowrap valign=top><? echo $var_nama_dsn; ?></td>
			  <td nowrap valign=top><? echo $row["PEM_PERUS"]; ?></td>
			  <td nowrap valign=top><? echo $row["TGL_AWAL"]; ?></td>
			  <td nowrap valign=top><? echo $row["TGL_END"]; ?></td>
			  <td nowrap valign=top>
				  <? if ($row["STATUS"]=='S1')
				  { echo "LULUS"; }
				  else
				  { echo "BELUM"; }?>
			  </td>
			  <td nowrap valign=top><? echo $row["NO_ST"]; ?></td>
			  <td nowrap valign=top><? echo $row["TGL_ST"]; ?></td>
		  </tr>
<?
}
?>
		</table>
   <input name="excel"   type="image" onClick="document.fexcel.action='lap_mhs_sedang_KP_export.php?t=excel'" src="../../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
   Export ke File Excel&nbsp;
    <input name="printer" type="image"  onClick="document.fexcel.action='lap_mhs_sedang_KP_export.php?t=printer'" src="../../img/print.gif" align="bottom" width="18" height="18"> 
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