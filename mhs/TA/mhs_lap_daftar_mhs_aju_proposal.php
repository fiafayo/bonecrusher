<?php
/* 
   DATE CREATED : 26/07/07
   KEGUNAAN     : MENAMPILKAN MAHASISWA YG MENGAJUKAN PROPOSAL TA
   VARIABEL     : $frm_tgl_awal - parameter(GET) tgl awal yang ingin ditampilkan
		  $frm_tgl_akhir - parameter(GET) tgl akhir yang ingin ditampilkan 
		  $frm_o1, $frm_o2, $frm_o3 - parameter(GET) untuk order by perintah SQL
		  $frm_jenis - 0=ta; 1=lp

		  $sql, $result, $row - "select ta.*,dosen.kode as kode_dosen1,dosen.nama as nama_dosen1 from ta,dosen where jenis=".$frm_jenis." and ta.id_dosen1=dosen.id"

		  $sql2, $result2, $row2 - select * from dosen where id=$row["id_dosen2"]
		  $sql3, $result3, $row3 - select * from master_mhs where id_ta='$row["id"]'
		  
		  $a - untuk counter nomor laporan TA/LP
		  $b - untuk counter nomor tabel laporan mahasiswa kerja TA/LP

   KETERANGAN   : PROSES CEK AUTHENTIFIKASI DICOMMENT UNTUK COBA JALANKAN
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
require("../../include/temp.php");

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
      ~</strong> MAHASISWA YG MENGAJUKAN PROPOSAL TA </font></font> </td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form>
  <table width="80%" align="center" class="body" >
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
      <td width="26%">Jurusan</td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td width="69%">
	    
		<select name="frm_s_jurusan" class="tekboxku">
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
      <td>NRP</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_s_NRP" id="frm_s_NRP" type="text" size="20" class="tekboxku"></td>
    </tr>
    <tr> 
      <td>Kode Dosen Pembimbing 1</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input type="text" name="frm_s_kode_dosen1" id="frm_s_kode_dosen1" class="tekboxku"></td>
    </tr>
    <tr> 
      <td>Kode Dosen Pembimbing 2 </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input type="text" name="frm_s_kode_dosen2" id="frm_s_kode_dosen2" class="tekboxku"></td>
    </tr>
    <tr> 
      <td nowrap><i>Banyak Data yang ditampilkan</i></td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_s_jum_data" id="frm_s_jum_data" class="tekboxku">
			  <option value="2">2</option>
			  <option value="10">10</option> 
			  <option value="15">15</option> 
			  <option value="20" selected>20</option> 
		  </select>
	  </td>
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
// JIKA MODE<>0 MAKSUDNYA JIKA FORM DI SUBMIT MAKA KELUAR LAPORAN
/*$sql="select ta.*,
			 dosen.id as id_karyawan
	  from ta, dosen
	  where (ta.id_dosen1=dosen.id or ta.id_dosen1=dosen.kode) ";*/
	        
$sql="SELECT master_mhs.NRP,
			 master_mhs.NAMA,
			 master_ta.JUDUL_TA,
			 master_ta.KODOS1,
			 master_ta.KODOS2,
			 master_mhs.jurusan
        FROM master_ta,master_mhs
		WHERE master_ta.NRP=master_mhs.NRP AND master_ta.KOLUS=''";
	  
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
	}
	
	if ($frm_s_nomor_surat!="")
	{ $sql=$sql." and ta.no_surat_tugas like '%".$frm_s_nomor_surat."%'"; } 
	if ($frm_s_judul!="")
	{ $sql=$sql." and ta.judul like '%".$frm_s_judul."%'"; } */
	if ($frm_s_NRP!="")
	{
		 $sql .= " and (master_mhs.NRP='".$frm_s_NRP."')";
	}
	if ($frm_s_jurusan!="all")
	{ $sql .= " and master_mhs.jurusan='".$frm_s_jurusan."'";}
	
	if ($frm_s_kode_dosen1!="")
    {
					$sql8="select * from dosen where kode=".$frm_s_kode_dosen1;
					if(!($result8=mysql_db_query($DB,$sql8)))
					{
						echo "Kode Dosen Pembimbing 1 tidak terdaftar";
					}
					else
					{
						if ($row8 = mysql_fetch_array($result8)) $dsn1=$row8["kode"]; 
					}  	
	
	 $sql .= " and (master_ta.KODOS1=".$dsn1." or master_ta.KODOS1=".$frm_s_kode_dosen1.")"; } 
	
	if ($frm_s_kode_dosen2!="")
    {
					$sql8="select * from dosen where kode=".$frm_s_kode_dosen2;
					if(!($result8=mysql_db_query($DB,$sql8)))
					{
						echo "Kode Dosen Pembimbing 2 tidak terdaftar";
					}
					else
					{
						if ($row8 = mysql_fetch_array($result8)) $dsn2=$row8["kode"]; 
					}  
	$sql .= " and (master_ta.KODOS2=".$dsn2." or master_ta.KODOS2=".$frm_s_kode_dosen2.")"; }
	
	
	
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

$vlink="mhs_lap_daftar_mhs_aju_proposal.php";
$abc="?mode=2&frm_s_jurusan=$frm_s_jurusan&frm_s_NRP=$frm_s_NRP&frm_s_kode_dosen1=$frm_s_kode_dosen1&frm_s_kode_dosen2=$frm_s_kode_dosen2&frm_s_jum_data=$frm_s_jum_data";

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
      ~</strong> </font><font color="#006699"><font color="#0099CC" size="1">MAHASISWA YG MENGAJUKAN PROPOSAL TA</font></font><font color="#0099CC" size="1">	  </font></font> </td>
    <td width="11%"><div align="center"></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<br>
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div>
<?

if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="mhs_lap_daftar_mhs_aju_proposal.php">
<input type="hidden" name="mode" value="3">
<input type="hidden" name="frm_s_judul" value="<?php echo $frm_s_judul; ?>">
<input type="hidden" name="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
<input type="hidden" name="frm_s_NRP" value="<?php echo $frm_s_NRP; ?>">
<input type="hidden" name="frm_s_kode_dosen1" value="<?php echo $frm_s_kode_dosen1; ?>">
<input type="hidden" name="frm_s_kode_dosen2" value="<?php echo $frm_s_kode_dosen2; ?>">
<input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>">
<?
}
   if ($frm_s_jurusan!="all")
	{
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id2='".$frm_s_jurusan."'";
		$result_jur = @mysql_query($sql_jur);
		$row_jur=@mysql_fetch_array($result_jur);
		echo "<b>Jurusan: </b>".$row_jur["nama_jur"];
	}
	

if (mysql_num_rows($result)==0) {
    echo "<br><font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=mhs_lap_daftar_mhs_aju_proposal.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}
if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>

	<table width="100%" border="1" cellpadding="3" cellspacing="0" class="table">
	   <tr bgcolor="#C6E2FF">
			<th width="2%" class="td"><b>No.</b></th>
			<th width="9%" class="td"><b>NRP</b></th>
			<th width="10%" class="td"><b>NAMA</b></th>
			<th width="9%" class="td"><b>JUDUL</b></th>
			<th width="35%" class="td"><b>DOSEN PEMBIMBING 1</b></th>
			<th width="35%" class="td"><b>DOSEN PEMBIMBING 2</b></th>
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
			<td nowrap><? echo $row["NAMA"]; ?></td>
			<td nowrap><? echo $row["JUDUL_TA"]; ?></td>
			<td nowrap><? //echo $row["kode_dosen1"]." - ".$row["nama_dosen1"] ; 
			$sql2="select * from dosen where kode='".$row["KODOS1"]."'";
			if(!($result2=mysql_db_query($DB,$sql2)))
			{
				// echo mysql_error();
				// return 0;
				//						echo "Kode dosen tidak terdaftar";
				echo "Kode - ";
			}
			else
			{
				if ($row2 = mysql_fetch_array($result2)) echo $row2["kode"]." - "; 
			}  
			echo $row2["nama"];				
			?>			
			</td>
			<td nowrap>
			<? 
			$sql2="select * from dosen where kode='".$row["KODOS2"]."'";
			if(!($result2=mysql_db_query($DB,$sql2)))
			{
				// echo mysql_error();
				// return 0;
				//						echo "Kode dosen tidak terdaftar";
				echo "Kode - ";
			}
			else
			{
				if ($row2 = mysql_fetch_array($result2)) echo $row2["kode"]." - "; 
			}  
			echo $row2["nama"];
			?>				
			</td>
		</tr>
<?
}
?>
  </table>
   <input name="excel"   type="image" onClick="document.fexcel.action='mhs_lap_daftar_mhs_aju_proposal_export.php?t=excel'" src="../../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
   Export ke File Excel&nbsp;
    <input name="printer" type="image"  onClick="document.fexcel.action='mhs_lap_daftar_mhs_aju_proposal_export.php?t=printer'" src="../../img/print.gif" align="bottom" width="18" height="18"> 
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