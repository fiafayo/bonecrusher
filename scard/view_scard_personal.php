<?
/* 
   DATE CREATED : 02/05/09
   KEGUNAAN     : MENAMPILKAN HASIL SCORE CARD PERSONAL
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");

?>
<html>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../include/tanggalan.js">
</script>
<style type="text/css">
<!--
.style1 {
	font-size: 16px;
	font-weight: bold;
}
.style2 {font-size: 12px}
a:link {
	color: #0000FF;
	text-decoration: none;
}
a:visited {
	color: #0000FF;
	text-decoration: none;
}
a:hover {
	color: #FF9900;
	text-decoration: underline;
}
a:active {
	color: #0000FF;
	text-decoration: none;
}
-->
</style>
<script language="javascript">
function Form(theForm)
{
	if(theForm.frm_thn.value=="")
	{
		alert("Silahkan masukkan Tahun Akademik!");
		theForm.frm_thn.focus()
		return(false);
	}
	
	if(theForm.frm_s_jurusan.value=="")
	{
		alert("Silahkan masukkan Jurusan!");
		theForm.frm_s_jurusan.focus();
		return(false);
	}
	
	if(theForm.frm_s_dosen.value=="")
	{
		alert("Silahkan masukkan Dosen!");
		theForm.frm_s_dosen.focus();
		return(false);
	}
	
return(true);
}
</script>
<body>
<?php
f_connecting();
mysql_select_db($DB);
//echo "<br>mode=".$mode;
if ($mode=="" || $mode=="0") 
{
?>
<font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font>
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN ~</strong> 
      SCORE CARD PERSONAL </font></font></td>
    <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">SCORE CARD</font></strong></div></td>
  </tr>
</table>
<strong><font color="#0099CC" size="1"></font></strong> 
<hr size="1" color="#FF9900">
<form name="form_sc_personal" id="form_sc_personal" onSubmit="return Form(this)">
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
	  <select name="frm_thn" id="frm_thn" class="tekboxku">
	    <option value="2001">2001</option>
		<option value="2002">2002</option>
		<option value="2003">2003</option>
		<option value="2004">2004</option>
		<option value="2005">2005</option>
		<option value="2006">2006</option>
	  	<option value="2007">2007</option>
		<option value="2008">2008</option>
		<option value="2009">2009</option>
		<option value="2010">2010</option>
		<option value="2011">2011</option>
		<option value="2012">2012</option>
		<option value="2013">2013</option>
		<option value="2014">2014</option>
		<option value="2015">2015</option>
      </select>
	  <font color="#FF0000">*</font>	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Jurusan</td>
      <td><strong>:</strong></td>
      <td><select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku">
			<option value="">Pilih
			<?php
				 $result2 = @mysql_query("SELECT * FROM `jurusan` WHERE `jurusan`.id>0 AND `jurusan`.id<6");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["id"].">".$row2["jurusan"];
	             }
         	?>
          </select>
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Dosen</td>
      <td><strong>:</strong></td>
      <td><select name="frm_s_dosen" id="frm_s_dosen" class="tekboxku">
               <option value="">Pilih
           <?php
				 $result2 = @mysql_query("SELECT * FROM `dosen` WHERE kode like '61%' ORDER BY kode ASC");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["kode"].">".$row2["kode"]." - ".$row2["nama"];
	             }
         	?>
          </select>
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" size="1">*</font><font size="1"> = compulsory / harus diisi</font></td>
    </tr>
    <tr>
      <td></td> 
      <td></td>
      <td><input type="hidden" name="mode" id="mode" value="1"></td>
      <td><input type="submit" value="Proses" class="tombol"></td>
    </tr>
  </table>
</form>
<?
}
else if ($mode=="1") 
{ 

    if ($frm_s_jurusan=='')  
	{
		//$error = 1;
		$mode="";
		$pesan=$pesan."<br>Silahkan pilih jurusan terlebih dahulu !";
		?>
			<script language="JavaScript">
				document.location="view_scard_personal.php?mode0=&pesan=<? echo $pesan?>";
			</script>
		<?
	}?>
	<FORM METHOD="post" name="fexcel_1" id="fexcel_1" ACTION="view_scard_personal_1_export.php">
	    <input type="hidden" name="frm_thn" id="frm_thn" value="<?php echo $frm_thn;?>">
		<input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
		<input type="hidden" name="frm_s_kode" id="frm_s_kode" value="<?php echo  $frm_s_kode;?>">
		<input type="hidden" name="frm_s_dosen" id="frm_s_dosen" value="<? echo $frm_s_dosen;?>">
    
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN ~</strong> 
      SCORE CARD </font><font color="#006699"><font color="#0099CC" size="1">PERSONAL</font></font></font></td>
    <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">SCORE CARD</font></strong></div></td>
  </tr>
</table>
<strong><font color="#0099CC" size="1"></font></strong> 
<hr size="1" color="#FF9900">
<table width="95%"  border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td>
	<?
		   $sql_jur="SELECT jurusan as nama_jur
			           FROM jurusan
			          WHERE jurusan.id=$frm_s_jurusan";
		   $res_jur = @mysql_query($sql_jur);
		   $row_jur = @mysql_fetch_array($res_jur);
		   
		   $sql_dosen="SELECT * 
			             FROM dosen
			            WHERE kode='$frm_s_dosen'";
		   $res_dosen = @mysql_query($sql_dosen);
		   $row_dosen = @mysql_fetch_array($res_dosen);
		   
		   $thn1=$frm_thn;
		   $thn2=$frm_thn+1;
	?>
      <div align="center" class="style1">SCORE CARD<br>
        PERSONAL<br>
        JURUSAN TEKNIK <br><? echo $row_jur["nama_jur"];?><br>
        <span class="style2">Tahun Akademik <? echo $thn1." - ".$thn2;?></span> </div></td>
  </tr>
  <tr>
    <td><table width="100%"  border="1" cellspacing="0" cellpadding="5">
      <tr>
        <td bgcolor="#FFFFE8"><table width="90%"  border="0" align="center" cellpadding="3" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>NAMA DOSEN </td>
            <td><strong>:</strong></td>
            <td><? echo $row_dosen["kode"]." - ".$row_dosen["nama"];?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="31%">TANGGAL LAHIR </td>
            <td width="2%"><strong>:</strong></td>
            <td width="67%"><? echo datetoreport($row_dosen["tanggal_lahir"]);?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>PENDIDIKAN</td>
            <td><strong>:</strong></td>
            <td><? echo $row_dosen["pendidikan_terakhir"];?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>KEPANGKATAN</td>
            <td><strong>:</strong></td>
            <td><? echo $row_dosen["pangkat"];?></td>
          </tr>
          <tr>
            <td nowrap>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td nowrap>BIDANG KEAHLIAN </td>
            <td><strong>:</strong></td>
            <td><? echo $row_dosen["bidang_keahlian"];?></td>
          </tr>
          <tr>
            <td nowrap>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td nowrap>JUMLAH SKS RIIL</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;SEMESTER GASAL</td>
            <td><strong>:</strong></td>
            <td><? echo $jum_dsn_GB;?></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;SEMESTER GENAP</td>
            <td><strong>:</strong></td>
            <td><? echo $jum_dsn_LK;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">MATA KULIAH YANG DI ASUH </td>
            <td valign="top"><strong>:</strong></td>
            <td rowspan="2" valign="top">
              <table width="100%"  border="0" cellspacing="0" cellpadding="2" align="left">
                <tr valign="top">
                  <td><table width="100%"  border="1" cellspacing="0" cellpadding="2" class="table">
                      <tr bgcolor="#C6E2FF">
                        <td><div align="center">SEMESTER GASAL </div></td>
                      </tr>
                      <?
				$periode_MKA=$frm_thn."1";
				//echo "<br>periode_MKA=".$periode_MKA;
				$sql_MKA="SELECT rekap_dosen.nama_MK
							FROM rekap_dosen
						   WHERE (rekap_dosen.kode_MK <> '' AND rekap_dosen.id_periode='".$periode_MKA."'  AND rekap_dosen.kode_dsn='".$frm_s_dosen."')
						GROUP BY rekap_dosen.nama_MK ";
				$res_MKA = @mysql_query($sql_MKA);
				while(($row_MKA = @mysql_fetch_array($res_MKA)))
				{
			  ?>
                      <tr>
                        <td><? echo $row_MKA['nama_MK'];?></td>
                      </tr>
                      <? }?>
                  </table></td>
                  <td><table width="100%"  border="1" cellspacing="0" cellpadding="2" class="table">
                      <tr bgcolor="#C6E2FF">
                        <td><div align="center">SEMESTER GENAP </div></td>
                      </tr>
                      <?
				$periode_MKA=$frm_thn."2";
				//echo "<br>periode_MKA=".$periode_MKA;
				$sql_MKA="SELECT rekap_dosen.nama_MK
							FROM rekap_dosen
						   WHERE (rekap_dosen.kode_MK <> '' AND rekap_dosen.id_periode='".$periode_MKA."'  AND rekap_dosen.kode_dsn='6106')
						GROUP BY rekap_dosen.kode_MK ";
				$res_MKA = @mysql_query($sql_MKA);
				while(($row_MKA = @mysql_fetch_array($res_MKA)))
				{
			  ?>
                      <tr>
                        <td><? echo $row_MKA['nama_MK'];?></td>
                      </tr>
                      <? }?>
                  </table></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>JUMLAH BIMBINGAN </td>
            <td><strong>:</strong></td>
            <td>
              <? 
			//echo "<br>frm_thn= ".$frm_thn;
			switch ($frm_thn) {
					case '2001':
						$tgl_1="2001-01-01";
						$tgl_2="2001-12-31";
						break;
					case '2002':
						$tgl_1="2002-01-01";
						$tgl_2="2002-12-31";
						break;
					case '2003':
						$tgl_1="2003-01-01";
						$tgl_2="2003-12-31";
						break;
					case '2004':
						$tgl_1="2004-01-01";
						$tgl_2="2004-12-31";
						break;
					case '2005':
						$tgl_1="2005-01-01";
						$tgl_2="2005-12-31";
						break;
					case '2006':
						$tgl_1="2006-01-01";
						$tgl_2="2006-12-31";
						break;
					case '2007':
						$tgl_1="2007-01-01";
						$tgl_2="2007-12-31";
						break;
					case '2008':
						$tgl_1="2008-01-01";
						$tgl_2="2008-12-31";
						break;
					case '2009':
						$tgl_1="2009-01-01";
						$tgl_2="2009-12-31";
						break;
					case '2010':
						$tgl_1="2010-01-01";
						$tgl_2="2010-12-31";
						break;
					case '2011':
						$tgl_1="2011-01-01";
						$tgl_2="2011-12-31";
						break;
					case '2012':
						$tgl_1="2012-01-01";
						$tgl_2="2012-12-31";
						break;
					case '2013':
						$tgl_1="2013-01-01";
						$tgl_2="2013-12-31";
						break;
					case '2014':
						$tgl_1="2014-01-01";
						$tgl_2="2014-12-31";
						break;
					case '2015':
						$tgl_1="2015-01-01";
						$tgl_2="2015-12-31";
						break;
				}
					//echo "<br>tgl_1= ".$tgl_1;
					//echo "<br>tgl_2= ".$tgl_2;
					
//##############################################################################################################
//begin JUMLAH BIMBINGAN DOSEN PER PERIODE	
//##############################################################################################################					
					/*
					$sql_total_bim="SELECT master_ta.NRP,
											    master_ta.KODOS1,
											    master_ta.KODOS2,
											    master_ta.AKHIR1,
											    master_mhs.NAMA
									      FROM  master_ta, master_mhs
									     WHERE (master_ta.NRP=master_mhs.NRP) AND 
										       (KODOS1='".$frm_s_dosen."' OR KODOS2='".$frm_s_dosen."') AND 
											   (master_ta.KOLUS=''AND master_ta.STATUS='')";
					*/
					     $sql_total_bim="SELECT master_ta.NRP,
											    master_ta.KODOS1,
											    master_ta.KODOS2,
											    master_ta.AKHIR1,
											    master_mhs.NAMA
									      FROM  master_ta, master_mhs
									     WHERE (master_ta.NRP=master_mhs.NRP) AND 
										       (KODOS1='".$frm_s_dosen."' OR KODOS2='".$frm_s_dosen."')";
		                $sql_total_bim = $sql_total_bim." and (master_ta.AKHIR1 between '".$tgl_1."' and '".$tgl_2."')"; 
   					    $result_total_bim = @mysql_query($sql_total_bim);
						$jum_bim_dsn = mysql_num_rows($result_total_bim);	
						//echo "<br>sql_total_bim-->".$sql_total_bim;
						echo $jum_bim_dsn;
//##############################################################################################################
//end JUMLAH BIMBINGAN DOSEN PER PERIODE	
//##############################################################################################################				?>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td nowrap>KEANGGOTAAN ASOSIASI PROFESI</td>
            <td><strong>:</strong></td>
            <td><? //echo $jum_tng_PNJ_akademik;?>
              -</td>
          </tr>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan=7>
			<input type="hidden" name="jum_bim_dsn" id="jum_bim_dsn" value="<? echo $jum_bim_dsn;?>">
			<input name="excel_1" id="excel_1" type="image" onClick="document.fexcel_1.action='view_scard_personal_1_export.php?t=excel'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18">
      Export ke File Excel
      <input name="printer_1" id="printer_1" type="image"  onClick="document.fexcel_1.action='view_scard_personal_1_export.php?t=printer'" src="../img/print.gif" align="bottom" width="18" height="18">
      Print </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</FORM>
<br>
<table width="80%"  border="0" align="center" cellpadding="1" cellspacing="0">
  <tr>
    <td width="81%">&nbsp;</td>
    <td width="19%" align="right">
	<form name="form1" id="form1" method="post" action="view_scard_personal.php">
	  <input type="hidden" name="frm_thn" id="frm_thn" value="<? echo $frm_thn;?>">
	  <input type="hidden" name="frm_s_dosen" id="frm_s_dosen" value="<? echo $frm_s_dosen;?>">
	  <input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<? echo $frm_s_jurusan;?>">
	  <input type="hidden" name="mode" id="mode" value="2">
	  <input type="submit" name="Submit" id="Submit" value="Lanjut >>">
    </form>
	
	</td>
  </tr>
</table>
<br>
<br>
<br>
<? 
}
else if ($mode=="2") 
{
// LAPORAN YANG DIHASILKAN
?>
<FORM METHOD="Post" name="fexcel_2" id="fexcel_2" ACTION="view_scard_personal_2_export.php">
		<input type="hidden" name="frm_thn" id="frm_thn" value="<? echo $frm_thn;?>">
		<input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
		<input type="hidden" name="frm_s_kode" id="frm_s_kode" value="<?php echo  $frm_s_kode;?>">
		<input type="hidden" name="frm_s_dosen" id="frm_s_dosen" value="<? echo $frm_s_dosen;?>">
		
<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN 
      ~</strong> SCORE CARD LABORATORIUM </font></font></td>
    <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">SCORE CARD</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<div align="right"><font face="trebuchet MS" color="#FF0000"><b>Tgl. Cetak : <? echo date("d-m-Y"); ?></b></font><br></div><br>
<?
switch ($frm_thn) {
	case '2007':
		$tgl_1="2007-01-01";
		$tgl_2="2007-12-31";
		break;
	case '2008':
		$tgl_1="2008-01-01";
		$tgl_2="2008-12-31";
		break;
	case '2009':
		$tgl_1="2009-01-01";
		$tgl_2="2009-12-31";
		break;
	case '2010':
		$tgl_1="2010-01-01";
		$tgl_2="2010-12-31";
		break;
	case '2011':
		$tgl_1="2011-01-01";
		$tgl_2="2011-12-31";
		break;
	case '2012':
		$tgl_1="2012-01-01";
		$tgl_2="2012-12-31";
		break;
	case '2013':
		$tgl_1="2013-01-01";
		$tgl_2="2013-12-31";
		break;
	case '2014':
		$tgl_1="2014-01-01";
		$tgl_2="2014-12-31";
		break;
	case '2015':
		$tgl_1="2015-01-01";
		$tgl_2="2015-12-31";
		break;
	}

$result1 = mysql_query("SELECT count(*) as jum
						  FROM pengabdian
						 WHERE pengabdian.mulai between '".$tgl_1."' and '".$tgl_2."'");
if ($row1 = mysql_fetch_array($result1)) {
  $jum_layanan_industri=$row1["jum"];
  //echo "thn_layanan_industri=".$thn_layanan_industri;
}
//END JUMLAH LAYANAN INDUSTRI

// JUMLAH GRANT YG DITERIMA
$result = mysql_query("SELECT Sum(grant_prodi.jumlah) as tot_grant
						 FROM grant_prodi
						WHERE grant_prodi.tgl_awal between '".$tgl_1."' and '".$tgl_2."' AND
						      grant_prodi.jurusan_id=$frm_s_jurusan");
if ($row_grant = mysql_fetch_array($result)) {
 $jum_grant_prodi=$row_grant["tot_grant"];
  //echo "<br>jum_grant_prodi=".$jum_grant_prodi;
}
//END JUMLAH GRANT YG DITERIMA

$result = mysql_query("SELECT avg(IPK_lulus) as rata
						  FROM master_alumni
						 WHERE master_alumni.tanggal_lulus between '".$tgl_1."' and '".$tgl_2."'");
if ($row = mysql_fetch_array($result)) {
  $rata_IPK_lulusan=$row["rata"];
  //echo "rata_IPK_lulusan=".$rata_IPK_lulusan;
}

//END RATA-RATA IPK LULUSAN berdasarkan tahun


// JUMLAH PENELITIAN PER TAHUN
$result_penil = mysql_query("SELECT count(*) as jum_penelitian
						 FROM penelitian
						WHERE penelitian.tanggal_mulai between '".$tgl_1."' and '".$tgl_2."'AND
							  penelitian.jurusan_id=$frm_s_jurusan AND
							  penelitian.kode_dosen='".$frm_s_dosen."'");
						
if ($row_penil = mysql_fetch_array($result_penil)) {
  $jum_penil=$row_penil["jum_penelitian"];
  //echo "<br>jum_penil=".$jum_penil;
}
//END JUMLAH PENELITIAN PER TAHUN

// JUMLAH PUBLIKASI JURNAL NASIONAL TERAKREDITASI PER TAHUN
$result_pub_status = mysql_query("SELECT id_pub, nama
						            FROM status_publikasi
								   WHERE status_publikasi.nama='Nasional'");
						
if ($row_pub_status = mysql_fetch_array($result_pub_status)) {
   $status_pub1=$row_pub_status["id_pub"];
   //echo "<br>status_pub1=".$status_pub1;
}

$result_pub_jurnal_nas = mysql_query("SELECT count(*) as jum_jurnal_nasional
						                FROM penelitian
						               WHERE penelitian.pub_tanggal between '".$tgl_1."' and '".$tgl_2."' AND
									   		 penelitian.jurusan_id=$frm_s_jurusan AND
						                     penelitian.publikasi=$status_pub1");
						
if ($row_pub_jurnal_nas = mysql_fetch_array($result_pub_jurnal_nas)) {
  $jum_pub_jurnal_nas=$row_pub_jurnal_nas["jum_jurnal_nasional"];
  //echo "<br>jum_pub_jurnal_nas=".$jum_pub_jurnal_nas;
}
//END JUMLAH PUBLIKASI JURNAL NASIONAL TERAKREDITASI PER TAHUN


// JUMLAH PUBLIKASI JURNAL INTERNASIONAL TERAKREDITASI PER TAHUN
$result_pub_status = mysql_query("SELECT id_pub, nama
						            FROM status_publikasi
								   WHERE status_publikasi.nama='Internasional'");
						
if ($row_pub_status = mysql_fetch_array($result_pub_status)) {
   $status_pub1=$row_pub_status["id_pub"];
 
}

$result_pub_jurnal_inter = mysql_query("SELECT count(*) as jum_jurnal_internasional
						                FROM penelitian
						               WHERE penelitian.pub_tanggal between '".$tgl_1."' and '".$tgl_2."' AND
									         penelitian.jurusan_id=$frm_s_jurusan AND
						                     penelitian.publikasi=$status_pub1");
						
if ($row_pub_jurnal_inter = mysql_fetch_array($result_pub_jurnal_inter)) {
  $jum_pub_jurnal_inter=$row_pub_jurnal_inter["jum_jurnal_internasional"];
  //echo "<br>jum_pub_jurnal_inter=".$jum_pub_jurnal_inter;
}
//END JUMLAH PUBLIKASI JURNAL INTERNASIONAL TERAKREDITASI PER TAHUN


// JUMLAH PUBLIKASI PROSIDING NASIONAL TERAKREDITASI PER TAHUN
$result_pub_status = mysql_query("SELECT id_pub, nama
						            FROM status_publikasi
								   WHERE status_publikasi.nama='Nasional'");
						
if ($row_pub_status = mysql_fetch_array($result_pub_status)) {
   $status_pub1=$row_pub_status["id_pub"];
 
}

$result_pub_prosiding_nas = mysql_query("SELECT count(*) as jum_prosiding_nasional
						                   FROM penelitian
						                  WHERE penelitian.pub_tanggal between '".$tgl_1."' and '".$tgl_2."' AND
										        penelitian.jurusan_id=$frm_s_jurusan AND
						                        penelitian.publikasi=$status_pub1 AND penelitian.pub_ISBN<>''");
						
if ($row_pub_prosiding_nas = mysql_fetch_array($result_pub_prosiding_nas)) {
  $jum_pub_prosiding_nas=$row_pub_prosiding_nas["jum_prosiding_nasional"];
  //echo "<br>jum_row_pub_prosiding_nas=".$jum_pub_prosiding_nas;
}
//END JUMLAH PUBLIKASI PROSIDING NASIONAL TERAKREDITASI PER TAHUN


// BEGIN TARGET SC PERSONAL
$res_target_sc_per = mysql_query("SELECT *
								    FROM sc_per
								   WHERE tahun=$frm_thn");
				
						if ($row = mysql_fetch_array($res_target_sc_per)) {
							$frm_exist=1;
							$frm_id_sc_personal=1;
							$frm_sc_personal_LD1=$row["LD1"];
							$frm_sc_personal_LD2=$row["LD2"];
							$frm_sc_personal_LD3=$row["LD3"];
							$frm_sc_personal_LD4=$row["LD4"];
							$frm_sc_personal_LD5=$row["LD5"];
							$frm_sc_personal_LD6=$row["LD6"];
						}
						else
						{
							$frm_exist=0;
							$frm_sc_personal_LD1=0;
							$frm_sc_personal_LD2=0;
							$frm_sc_personal_LD3=0;
							$frm_sc_personal_LD4=0;
							$frm_sc_personal_LD5=0;
							$frm_sc_personal_LD6=0;
						}
// END TARGET SC PERSONAL

// JUMLAH INDEX PEMBELAJARAN PER TAHUN/DOSEN/JURUSAN

//echo "<br>frm_s_dosen=".$frm_s_dosen;
//echo "<br>frm_thn=".$frm_thn;
//echo "<br>frm_s_jurusan=".$frm_s_jurusan;

$result_idx_blj = mysql_query("SELECT avg(ipk_dsn) as rata
							   FROM index_belajar_dosen
							  WHERE semester LIKE '".$frm_thn."%' AND 
									jurusan=".$frm_s_jurusan." AND
									kode_dosen='".$frm_s_dosen."'");

if ($row_idx_blj = mysql_fetch_array($result_idx_blj)) {
  $rata_IPK_dosen=$row_idx_blj["rata"];
  //echo "<br>rata_IPK_dosen=".$rata_IPK_dosen;
}
//END JUMLAH INDEX PEMBELAJARAN PER TAHUN/DOSEN/JURUSAN

           $sql_dosen = "SELECT * 
			             FROM dosen
			             WHERE kode='$frm_s_dosen'";
		   $res_dosen = @mysql_query($sql_dosen);
		   $row_dosen = @mysql_fetch_array($res_dosen);

?>
<strong><? echo "<br>Periode: ".$frm_thn." &nbsp;&nbsp; | &nbsp;&nbsp; Dosen: ".$row_dosen['kode']." - ".$row_dosen['nama'];?></strong>
<table width="95%"  border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><table width="85%"  border="1" align="center" cellpadding="3" cellspacing="0" class="table">
      <tr bgcolor="#C6E2FF">
        <td width="4%" nowrap><strong>No</strong></td>
        <td width="52%" nowrap><b>Nama KPI </b></td>
        <td width="11%" nowrap><div align="center"><strong>Target</strong></div></td>
        <td width="10%" nowrap><div align="center"><strong>Capaian</strong></div></td>
        <td width="12%" nowrap><div align="center"><strong>%<br>
            capaian</strong></div></td>
        <td width="11%" nowrap><div align="center"><strong>Rata-rata<br>
            % capaian </strong></div></td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td colspan="6" valign="top" nowrap><em>Isu Strategis:</em> <strong>Learning &amp; Discovery </strong></td>
      </tr>
      <tr>
        <td nowrap valign="top">1</td>
        <td nowrap valign="top"> Jumlah Penelitian Dosen </td>
        <td valign="top" nowrap><? echo $frm_sc_personal_LD1;?></td>
        <td valign="top" nowrap><? echo $jum_penil;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_personal_LD1<>0) {
			$capaianLD1 = number_format(($jum_penil/$frm_sc_personal_LD1)*100, 3,'.',''); 
			echo $capaianLD1; 
		}
		else
		{
		  echo "-";
		}
		?></td>
        <td rowspan="6" valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td nowrap valign="top">2</td>
        <td nowrap valign="top">Jumlah publikasi jurnal nasional terakreditasi </td>
        <td valign="top" nowrap><? echo $frm_sc_personal_LD2;?></td>
        <td valign="top" nowrap><? echo $jum_pub_jurnal_nas;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_personal_LD2<>0) {
			$capaianLD2 = number_format(($jum_pub_jurnal_nas/$frm_sc_personal_LD2)*100, 3,'.',''); 
			echo $capaianLD2; 
		}
		else
		{
		    echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">3</td>
        <td nowrap valign="top">Jumlah publikasi prosiding nasional</td>
        <td valign="top" nowrap><? echo $frm_sc_personal_LD3;?></td>
        <td valign="top" nowrap><? echo $jum_pub_prosiding_nas;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_personal_LD3<>0) {
			$capaianLD3 = number_format(($jum_pub_prosiding_nas/$frm_sc_personal_LD3)*100, 3,'.',''); 
			echo $capaianLD3; 
		}
		else
		{
		    echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">4</td>
        <td nowrap valign="top">Jumlah Layanan Industri </td>
        <td valign="top" nowrap><? echo $frm_sc_personal_LD4;?></td>
        <td valign="top" nowrap><? echo $jum_layanan_industri;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_personal_LD4<>0) {
			$capaianLD4 = number_format(($jum_layanan_industri/$frm_sc_personal_LD4)*100, 3,'.',''); 
			echo $capaianLD4;
		}
		else
		{
		    echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">5</td>
        <td nowrap valign="top">Jumlah grant yang diterima </td>
        <td valign="top" nowrap><? echo $frm_sc_personal_LD5;?></td>
        <td valign="top" nowrap><? echo $jum_grant_prodi;?></td>
        <td valign="top" nowrap><? 
		if ($frm_sc_personal_LD5<>0) {
			$capaianLD5 =  number_format(($jum_grant_prodi/$frm_sc_personal_LD5)*100, 3,'.',''); 
			echo $capaianLD5; 
		}
		else
		{
		    echo "-";
		}
		?></td>
        </tr>
      <tr>
        <td nowrap valign="top">6</td>
        <td nowrap valign="top">Rata-rata indeks pembelajaran per jurusan (dosen tetap)</td>
        <td valign="top" nowrap><? echo $frm_sc_personal_LD6;?></td>
        <td valign="top" nowrap><? echo $rata_IPK_dosen;?></td>
        <td valign="top" nowrap>
		<? 
			if ($frm_sc_personal_LD6<>0) {
				$capaianLD6 = number_format(($rata_IPK_dosen/$frm_sc_personal_LD6)*100, 3,'.','');
				echo $capaianLD6; 
			}
			else
			{
			    echo "-";
			}
		?>
		</td>
        </tr>
      <tr>
        <td nowrap valign="top">&nbsp;</td>
        <td nowrap valign="top">&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>
		  <?
				$total_persen_capaian = $capaianLD1 + $capaianLD2 + $capaianLD3 + $capaianLD4 + $capaianLD5 + $capaianLD6;
				$rata2_persen_capaian = $total_persen_capaian/6;
				if ($rata2_persen_capaian<>0) {
					$rata2_persen_capaian = number_format($rata2_persen_capaian, 3,'.',''); 
					echo $rata2_persen_capaian;
				}
				else
				{
					echo "-";
				}
		  ?>
		</td>
      </tr>
      <tr>
        <td colspan="2" valign="top" nowrap>Rata-rata % pencapaian keseluruhan </td>
        <td valign="top" nowrap>
		<?
				$total_target = $frm_sc_personal_LD1 + $frm_sc_personal_LD2 + $frm_sc_personal_LD3 + $frm_sc_personal_LD4 + $frm_sc_personal_LD5 + $frm_sc_personal_LD6;
				$rata2_target = $total_target/6;
				if ($rata2_target<>0) {
					$rata2_target= number_format($rata2_target, 3,'.',''); 
					echo $rata2_target; 
				}
				else
				{
					echo "-";
				}
		?>
		</td>
        <td valign="top" nowrap><?
				$total_capaian = $jum_penil + $jum_pub_jurnal_nas + $jum_pub_prosiding_nas + $jum_layanan_industri + $jum_grant_prodi + $rata_IPK_dosen;
				$rata2_capaian = $total_capaian/6;
				if ($rata2_capaian<>0) {
					$rata2_capaian = number_format($rata2_capaian, 3,'.',''); 
					echo $rata2_capaian;
				}
				else
				{
					echo "-";
				}
		?></td>
        <td valign="top" nowrap><? 
			if ($rata2_target<>0) {
				$rata2_capaian_all = number_format(($rata2_capaian/$rata2_target)*100, 3,'.',''); 
				echo $rata2_capaian_all;
			}
			else
			{
			    echo "-";
			}
		?></td>
        <td valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td nowrap valign="top">&nbsp;</td>
        <td nowrap valign="top">&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
        <td valign="top" nowrap>&nbsp;</td>
      </tr>
      <tr>
        <td colspan=7>
	  <input type="hidden" name="jum_penil" id="jum_penil" value="<? echo $jum_penil;?>">
	  <input type="hidden" name="capaianLD1" id="capaianLD1" value="<? echo $capaianLD1;?>">
	  <input type="hidden" name="capaianLD2" id="capaianLD2" value="<? echo $capaianLD2;?>">
	  <input type="hidden" name="capaianLD3" id="capaianLD3" value="<? echo $capaianLD3;?>">
	  <input type="hidden" name="capaianLD4" id="capaianLD4" value="<? echo $capaianLD4;?>">
	  <input type="hidden" name="capaianLD5" id="capaianLD5" value="<? echo $capaianLD5;?>">
	  <input type="hidden" name="capaianLD6" id="capaianLD6" value="<? echo $capaianLD6;?>">
	  <input type="hidden" name="jum_grant_prodi" id="jum_grant_prodi" value="<? echo $jum_grant_prodi;?>">
	  <input type="hidden" name="rata_IPK_dosen" id="rata_IPK_dosen" value="<? echo $rata_IPK_dosen;?>">
	  <input type="hidden" name="rata2_target" id="rata2_target" value="<? echo $rata2_target;?>">
	  <input type="hidden" name="rata2_capaian" id="rata2_capaian" value="<? echo $rata2_capaian;?>">
	  <input type="hidden" name="rata2_capaian_all" id="rata2_capaian_all" value="<? echo $rata2_capaian_all;?>">
      <input type="hidden" name="rata2_persen_capaian" id="rata2_persen_capaian" value="<? echo $rata2_persen_capaian;?>">
	  <input name="excel_2" id="excel_2" type="image" onClick="document.fexcel_2.action='view_scard_personal_2_export.php?t=excel&export=2'" src="../img/Mexcel.jpg" align="bottom" width="18" height="18">
      Export ke File Excel
      <input name="printer_2" id="printer_2" type="image"  onClick="document.fexcel_2.action='view_scard_personal_2_export.php?t=printer&print=2'" src="../img/print.gif" align="bottom" width="18" height="18">
      Print </td>
      </tr>
    </table></td>
  </tr>
</table>
    </FORM>
<table width="80%"  border="0" align="center" cellpadding="1" cellspacing="0">
  <tr>
    <td width="35%">
	  <form name="form1" id="form1" method="post" action="view_scard_personal.php">
	      <input type="hidden" name="frm_thn" id="frm_thn" value="<? echo $frm_thn;?>">
		  <input type="hidden" name="frm_s_dosen" id="frm_s_dosen" value="<? echo $frm_s_dosen;?>">
		  <input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<? echo $frm_s_jurusan;?>">
		  <input type="hidden" name="mode" id="mode" value="1">
 		  <input type="submit" name="Submit" id="Submit" value="<< Sebelumnya">
      </form>
	</td>
    <td width="65%">&nbsp;</td>
  </tr>
</table>
<br>
<br>
<br>
<?
	//if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
}
?>		
</body>
</html>