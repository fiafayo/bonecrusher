<?php
/* 
   DATE CREATED : 26/07/07
   KEGUNAAN     : MENAMPILKAN DOSEN PEMBIMBING DALAM YG AKTIF PER PERIODE
   VARIABEL     : $frm_tgl_awal - parameter(GET) tgl awal yang ingin ditampilkan
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
include("../../include/temp.php");

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

$mode= ( isset( $_REQUEST['mode'] ) ) ? $_REQUEST['mode'] : 0;

if ($mode=="" || $mode=="0") 
{
?>
<br>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN 
      ~</strong> DAFTAR MAHASISWA BIMBINGAN DOSEN DALAM YANG AKTIF PER PERIODE </font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form name="lap_dobing_dalam" id="lap_dobing_dalam">
  <table width="80%" align="center" class="body" >
    <tr>
      <td nowrap>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="26%" nowrap>Jurusan</td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td width="69%">
	  <select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku">
            <option value="pilih" selected >--- Pilih ---</option>
            <?php
  	             $result2 = mysql_query("SELECT * FROM jurusan WHERE id>0 AND id<=8");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["id"].">".$row2["jurusan"];
	             }
         	?>
            </select>
	  </td>
    </tr>
    <tr>
      <td nowrap>Tanggal Periode </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_periode" type="text" class="tekboxku" id="frm_tgl_periode" value="<?php echo date('d/m/Y'); ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('lap_dobing_dalam.frm_tgl_periode',0,0,'DD/MM/YYYY')"> <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> </A>&nbsp;&nbsp;&nbsp;&nbsp;s/d&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="frm_tgl_periode2" type="text" class="tekboxku" id="frm_tgl_periode2" value="<?php echo date('d/m/Y'); ?>" size="10" maxlength="10">
        <A Href="javascript:show_calendar('lap_dobing_dalam.frm_tgl_periode2',0,0,'DD/MM/YYYY')"> <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> </A>(dd/mm/yyyy) </td>
    </tr>
    <tr> 
      <td nowrap><i>Banyak Data yang ditampilkan</i></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> <select name="frm_s_jum_data" class="tekboxku">
          <option value=2>2 
          <option value=10>10 
          <option value=15>15 
          <option value=20 selected>20 </select> </td>
    </tr>
    <tr> 
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td></td>
      <td><input type="hidden" name="mode" value="2"></td>
      <td><input type="submit" value="Proses"  class="tombol"></td>
    </tr>
  </table>
</form>
<?
}
else
{
$sekarang=date("Y-m-d");
/*
$sql="SELECT master_ta.NRP,
			 master_ta.KODOS1,
			 master_ta.KODOS2,
			 dosen.nama,
			 dosen.jurusan,
			 dosen.jab_akademik,
			 jurusan.jurusan as nama_jur
		FROM master_ta
			 Inner Join dosen ON master_ta.KODOS1 = dosen.kode 
			 Inner Join jurusan ON dosen.jurusan = jurusan.id
        WHERE  ((master_ta.KODOS1='".$frm_kode_dosen."' OR master_ta.KODOS2='".$frm_kode_dosen."') AND (master_ta.AKHIR1>= '".$sekarang."'))";			 

$sql_1="SELECT master_ta.NRP,
			 master_ta.KODOS1,
			 master_ta.KODOS2,
			 dosen.kode,
			 dosen.nama,
			 dosen.jurusan,
			 dosen.jab_akademik,
			 jurusan.jurusan as nama_jur
		FROM master_ta, dosen, jurusan
		WHERE (master_ta.KODOS1 = dosen.kode) AND
	       dosen.jurusan = jurusan.id AND
	      (master_ta.KOLUS='' AND master_ta.STATUS='')";	 
			 */
$sql_1="insert into temp_dalam (SELECT  master_ta.KODOS1, '".session_id()."'
                          FROM master_ta, dosen, jurusan
                           WHERE  (master_ta.KODOS1 = dosen.kode) AND
	                              (dosen.jurusan = jurusan.id) AND
	                              (master_ta.KOLUS='' AND master_ta.STATUS='') AND
								  (master_ta.KODOS1 like '61%')";


$sql_2="insert into temp_dalam (SELECT  master_ta.KODOS2, '".session_id()."'
                          FROM master_ta, dosen, jurusan
                           WHERE  (master_ta.KODOS2 = dosen.kode) AND
	                              (dosen.jurusan = jurusan.id) AND
	                              (master_ta.KOLUS='' AND master_ta.STATUS='')AND
								  (master_ta.KODOS2 like '61%')";
								  
$sql_dosen="SELECT distinct kode_dosen_temp,
                   id_temp
		    FROM temp_dalam";	 
			 
	  
if ($mode=="2" || $mode=="3" || $mode=="4")
{
	if ($frm_s_jurusan!="pilih")
	{   
	    $sql_1 .= " AND (jurusan.id='".$frm_s_jurusan."')";
		$sql_2 .= " AND (jurusan.id='".$frm_s_jurusan."')";
	}
	
	if($frm_tgl_periode!="" && $frm_tgl_periode2!="")
	{ 
		$sql_1=$sql_1." and (master_ta.AKHIR1 between '".datetomysql($frm_tgl_periode)."' and '".datetomysql($frm_tgl_periode2)."')"; 
		$sql_2=$sql_2." and (master_ta.AKHIR1 between '".datetomysql($frm_tgl_periode)."' and '".datetomysql($frm_tgl_periode2)."')";
	}
	else
	{
		if($frm_tgl_periode!="")
		{ 
			$sql_1=$sql_1." and (master_ta.AKHIR1>='".datetomysql($frm_tgl_periode)."')"; 
			$sql_2=$sql_2." and (master_ta.AKHIR1>='".datetomysql($frm_tgl_periode)."')"; 
		}
		if($frm_tgl_periode2!="")
		{ 
			$sql_1=$sql_1." and (master_ta.AKHIR1<='".datetomysql($frm_tgl_periode2)."')"; 
			$sql_2=$sql_2." and (master_ta.AKHIR1<='".datetomysql($frm_tgl_periode2)."')"; 
		}
	}
	
	$sql_1=$sql_1." group by master_ta.KODOS1)";
	$sql_2=$sql_2." group by master_ta.KODOS2)";
	/*if ($frm_s_jurusan!="all")
	{ 
		echo "<br>jurusan='".$frm_s_jurusan."'";
	$sql .= " AND dosen.jurusan='".$frm_s_jurusan."'";}*/
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
}

// UNTUK PAGING --------------------------------
if ($mode=="2")
{
//echo "<br>sql_1=".$sql_1;
//echo "<br>sql_2=".$sql_2;
$result=@mysql_query($sql_dosen);
$result_1=@mysql_query($sql_1);
$result_2=@mysql_query($sql_2);
$maxrows=mysql_num_rows($result);	
//$maxrows_2=mysql_num_rows($result_2);			
if($hal=="") { $hal=1; }
$recke=(($hal-1)*$frm_s_jum_data);
$limit="$recke,$frm_s_jum_data";
$jumhal=ceil($maxrows/$frm_s_jum_data);

$vlink="mhs_lap_daftar_dobing_dlm_yang_aktif.php";
$abc="?mode=2&frm_s_jurusan=$frm_s_jurusan&frm_s_jum_data=$frm_s_jum_data";

$vlink=$vlink.$abc;

$fontface="Verdana,Arial,Helvetica,sans-serif";
$fontsize="2";
}

// JIKA MODE HASIL LAPORAN DI MONITOR MAKA PAGING IN ACTION
if ($mode=="2") { 
//$sql_dosen=$sql_dosen." limit ".$limit;
}
//echo "<br>sql=".$sql;
//ORDER BY  master_ta.NRP DESC
if(!($result=mysql_db_query($DB,$sql_dosen)))
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
      ~</strong> DAFTAR MAHASISWA BIMBINGAN DOSEN DALAM YANG AKTIF PER PERIODE </font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<br>
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div><br>
<?
/*echo "<BR>session= ";
echo session_id();*/
if ($frm_s_jurusan!="all")
	{
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id='".$frm_s_jurusan."'";
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
<FORM METHOD="Post" name="fexcel" ACTION="mhs_lap_daftar_dobing_dlm_yang_aktif.php">

<input type="hidden" name="mode" value="3">
<input type="hidden" name="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
<input type="hidden" name="frm_tgl_periode" value="<?php echo $frm_tgl_periode; ?>">
<input type="hidden" name="frm_tgl_periode2" value="<?php echo $frm_tgl_periode2; ?>">
<input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<?
}
/*if (mysql_num_rows($result_1)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=mhs_lap_daftar_dobing_dlm_yang_aktif.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}

if (mysql_num_rows($result_2)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=mhs_lap_daftar_dobing_dlm_yang_aktif.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}*/

if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }

?>
	<table width="98%" border="0" cellpadding="0" cellspacing="0">
		<tr><td colspan="5">
		<table width="100%"  border="1" cellspacing="0" cellpadding="3" class="table">
		  <tr bgcolor="#C6E2FF">
				    <td height="25"><strong>Kode</strong></td>
				    <td><strong>Nama</strong></td>
				    <td nowrap><strong>Jabatan Akademik</strong></td>
				    <td><strong>Jumlah</strong></td>
				    <td width="14%" nowrap><strong>TglAkhir</strong></td>
					<td width="12%" nowrap><strong>NRP</strong></td>
					<td width="23%" nowrap><strong>Nama</strong></td>
	      </tr>
			<?
			$a=0;
			while(($row_1 = mysql_fetch_array($result)))
			{
			$a++;?>
				  <tr valign="top">
					<td width="16%" height="25" nowrap>
						<? //if ($a==1) { 
						echo $row_1["kode_dosen_temp"]; 
						//}?></td>
					<td width="12%" nowrap>
					<? // if ($a==1) { 
								$sql_dosen_1="SELECT nama,jab_akademik,jurusan.jurusan as nama_jur
										      FROM dosen, jurusan
									          WHERE kode='".$row_1["kode_dosen_temp"]."' AND  dosen.jurusan = jurusan.id ";
								$result_dosen_1 = @mysql_query($sql_dosen_1);
								$row_dosen_1=@mysql_fetch_array($result_dosen_1);
								 echo $row_dosen_1["nama"];
						  // }
						 ?></td>
					<td width="18%"><? // if ($a==1) 
					echo $row_dosen_1["jab_akademik"]; ?></td>
					<td width="5%" align="center">
					<? // if ($a==1) 
					   //{
					   $sql_total_bim_1="SELECT master_ta.NRP,
											    master_ta.KODOS1,
											    master_ta.KODOS2,
											    master_ta.AKHIR1,
											    master_mhs.NAMA
									     FROM   master_ta, master_mhs
									     WHERE (master_ta.NRP=master_mhs.NRP) AND 
										       (KODOS1='".$row_1["kode_dosen_temp"]."' OR KODOS2='".$row_1["kode_dosen_temp"]."') AND 
											   (master_ta.KOLUS=''AND master_ta.STATUS='')";
					if($frm_tgl_periode!="" && $frm_tgl_periode2!="")
					{ 
						$sql_total_bim_1=$sql_total_bim_1." and (master_ta.AKHIR1 between '".datetomysql($frm_tgl_periode)."' and '".datetomysql($frm_tgl_periode2)."')"; 
					}
///						   WHERE (master_ta.NRP=master_mhs.NRP) AND (KODOS1='".$row["KODOS1"]."' OR KODOS2='".$row["KODOS1"]."') AND KOLUS=''";

							$result7_1 = @mysql_query($sql_total_bim_1);
							$maxrows2_1 = mysql_num_rows($result7_1);	
							echo $maxrows2_1;
							//$c=0;
							//while ($row=@mysql_fetch_object($result))
					   //}
						//}
						?>
					</td>
					<td colspan="3">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<? 
							while ($row_mhs_1=@mysql_fetch_array($result7_1))
							{?>
							<tr>
								<td width="31%" nowrap>
								<? 
									$tgl_akhir_bimbingan = $row_mhs_1["AKHIR1"];
									$tgl_akhir_bimbingan = datetoreport($tgl_akhir_bimbingan);
									echo $tgl_akhir_bimbingan;
								?>							 
								</td>
								<td width="23%" nowrap>
									<? echo $row_mhs_1["NRP"]; ?>
								</td>		
								<td width="46%" nowrap>
									<? echo $row_mhs_1["NAMA"]; ?>							  
								</td>	
							</tr>	
							 <? 
							 }?>
					  </table>
					</td>
				  </tr>
			<?
			$result_empty_temp = mysql_query("delete from temp_dalam where id_temp='".session_id()."'");
			}
			// NEXT ROW
			//echo "SESSION2=".session_id();
	
			
			?>
			
        </table>		
		</td>
		</tr>

<tr><td>
  
   <input name="excel"   type="image" onClick="document.fexcel.action='mhs_lap_daftar_dobing_dlm_yang_aktif_export.php?t=excel'" src="../../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
   Export ke File Excel&nbsp;
    <input name="printer" type="image"  onClick="document.fexcel.action=mhs_lap_daftar_dobing_dlm_yang_aktif_export.php?t=printer'" src="../../img/print.gif" align="bottom" width="18" height="18"> 
    Print

</td></tr>
  </table>
</FORM>
<?
}
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize);}
	
?>
</body>
</html>