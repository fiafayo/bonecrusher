<?php
/* 
   DATE CREATED : 26/07/07
   KEGUNAAN     : MENAMPILKAN DOSEN PEMBIMBING DALAM YG AKTIF
   VARIABEL     : $frm_tgl_awal - parameter(GET) tgl awal yang ingin ditampilkan
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
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
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
      ~</strong> DAFTAR DOSEN PEMBIMBING DALAM YANG AKTIF</font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form>
  <table width="80%" align="center" class="body" >
    <tr>
      <td width="26%" nowrap>Jurusan</td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td width="69%"><select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku">
        <option value="pilih" selected>--- Pilih ---
        <?php
  	             $result2 = mysql_query("SELECT * FROM jurusan WHERE id>0 AND id<6");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["id"].">".$row2["jurusan"];
	             }
         	?>
            </select></td>
    </tr>
    <tr> 
      <td nowrap><i>Banyak Data yang ditampilkan</i></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> <select name="frm_s_jum_data" class="tekboxku">
          <option value=2>2 
          <option value=10>10 
          <option value=15>15 
          <option value=500 selected>20 </select> </td>
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
			 
$sql_dosen="SELECT kode_dosen_temp,
                   id_temp
		    FROM temp";	 
			 
$sql_1="insert into temp (SELECT  master_ta.KODOS1, '".session_id()."'
                          FROM master_ta, dosen, jurusan
                           WHERE  (master_ta.KODOS1 = dosen.kode) AND
	                              (dosen.jurusan = jurusan.id) AND
	                              (master_ta.KOLUS='' AND master_ta.STATUS='')";
		  
		  		
		  
$sql_2="insert into temp (SELECT  master_ta.KODOS2, '".session_id()."'
                          FROM master_ta, dosen, jurusan
                           WHERE (master_ta.KODOS2 = dosen.kode) AND
	                             (dosen.jurusan = jurusan.id) AND
	                             (master_ta.KOLUS='' AND master_ta.STATUS='')";			 
	  
if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
	/*if ($frm_kode_dosen!="--- Pilih ---")
	{ $sql .= " AND (master_ta.KODOS1='".$frm_kode_dosen."' OR master_ta.KODOS2='".$frm_kode_dosen."')";}*/

	if ($frm_s_jurusan!="all")
	{   
	    $sql_1 .= " AND (jurusan.id='".$frm_s_jurusan."')";
		$sql_2 .= " AND (jurusan.id='".$frm_s_jurusan."')";
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
echo "<br>SQL_1=".$sql_1;
echo "<br>SQL_2=".$sql_2;
echo "<br>sql_dosen=".$sql_dosen;
$result=@mysql_query($sql_dosen);
//$result_1=@mysql_query($sql_1);
//$result_2=@mysql_query($sql_2);
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
if(!($result_1=mysql_db_query($DB,$sql_1)))
{
	echo mysql_error();
        return 0;
}

if(!($result_2=mysql_db_query($DB,$sql_2)))
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
      ~</strong> </font><font color="#006699"><font color="#0099CC" size="1">DAFTAR DOSEN PEMBIMBING DALAM YANG AKTIF</font></font><font color="#0099CC" size="1">	  </font></font> </td>
    <td width="11%"><div align="center"></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<br>
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div><br>
<?
echo "<BR>session= ";
echo session_id();

if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" ACTION="mhs_lap_daftar_dobing_dlm_yang_aktif.php">

<input type="hidden" name="mode" value="3">
<input type="hidden" name="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
<input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<?
}
if (mysql_num_rows($result_1)==0) {
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
}

if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>

	<table width="98%" border="1" cellpadding="0" cellspacing="0">
		<tr><td>
		<table width="100%"  border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td colspan="5"></td>
          </tr>
		  <tr>
				    <td height="25"><strong>Kode</strong></td>
				    <td><strong>Nama</strong></td>
				    <td><strong>Jurusan</strong></td>
				    <td nowrap><strong>Jabatan Akademik</strong></td>
				    <td><strong>Jumlah</strong></td>
				    <td><strong>NRP</strong></td>
	      </tr>
			<?
			$a=0;
			while(($row_1 = mysql_fetch_array($result)))
			{
			$a++;
			?>
				  <tr valign="top">
					<td width="5%" height="25" nowrap>
						<? //if ($a==1) { 
						echo $row_1["kode_dosen_temp"]; 
						//}?>
					</td>
					<td width="24%" nowrap>
					<? // if ($a==1) { 
								$sql_dosen_1="SELECT nama,jab_akademik
										      FROM dosen
									          WHERE kode='".$row_1["kode_dosen_temp"]."'";
								$result_dosen_1 = @mysql_query($sql_dosen_1);
								$row_dosen_1=@mysql_fetch_array($result_dosen_1);
								 echo $row_dosen_1["nama"];
						  // }
						 ?></td>
					
					<td width="21%"><? // if ($a==1)
					// echo $row_1["nama_jur"]; ?>
					 </td>
					<td width="20%"><? // if ($a==1) 
					//echo $row_dosen_1["jab_akademik"]; ?>
					</td>
					<td width="10%">
					<? // if ($a==1) 
					   //{
					   $sql_total_bim_1="SELECT master_ta.NRP,
											  master_ta.KODOS1,
											  master_ta.KODOS2,
											  master_ta.AKHIR1,
											  master_mhs.NAMA
									   FROM   master_ta, master_mhs
									   WHERE (master_ta.NRP=master_mhs.NRP) AND (KODOS1='".$row_1["kode_dosen_temp"]."' OR KODOS2='".$row_1["kode_dosen_temp"]."') AND KOLUS=''";
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
					<td width="20%" nowrap>
						<? 
							 while ($row_mhs_1=@mysql_fetch_array($result7_1))
							 {
								echo $row_mhs_1["NRP"]." - ".$row_mhs_1["NAMA"]."<br>"; 
							 }
						?>
					</td>
				  </tr>
			<?
			}
			// NEXT ROW
			?>
			
        </table>		
		<br>
		</td>
		</tr>

<tr><td>
  
   <input name="excel"   type="image" onClick="document.fexcel.action='mhs_2_13_export.php?t=excel'" src="../../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
   Export ke File Excel&nbsp;
    <input name="printer" type="image"  onClick="document.fexcel.action='mhs_2_13_export.php?t=printer'" src="../../img/print.gif" align="bottom" width="18" height="18"> 
    Print

</td></tr>
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