<?php
/* 
   DATE CREATED : 13/11/08
   LAST UPDATE  : 
   KEGUNAAN     : cari data TA berdasarkan judul TA
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
require("../../include/temp.php");
?>

<html>
<head>
<script language="JavaScript" src="../../include/tanggalan.js"></script>
<script type="text/javascript" src="../../js/jquery-1.4.3.min.js"></script>
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<link href="../../css/autocomplete.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	function lookup(frm_s_nama) {
		if(frm_s_nama.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
			$.post("rpc.php", {queryString: ""+frm_s_nama+""}, function(data){
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
				}
			});
		}
	} // lookup
	
	function fill(thisValue) {
		$('#frm_s_nama').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);
	}
</script>
</head>
<body class="body">
<br>
<?php
$mode= ( isset( $_REQUEST['mode'] ) ) ? $_REQUEST['mode'] : 0;

if ($mode=="" || $mode=="0") 
{
f_connecting();
mysql_select_db($DB);
?>

<hr size="1" color="#FF9900">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>LAPORAN 
      ~</strong> DATA TA MAHASISWA</font></font></td>
    <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
  </tr>
</table>
<hr size="1" color="#FF9900">
<form name="lap_cari_data_ta" id="lap_cari_data_ta">
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
      <td>NRP</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_s_nrp" type="text" class="tekboxku" id="frm_s_nrp" size="10" maxlength="10"></td>
    </tr>
    <tr>
      <td>Nama</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
			<div>
				<div>
					<input type="text" size="30" value="" id="frm_s_nama" name="frm_s_nama" onkeyup="lookup(this.value);" onblur="fill();" />
				</div>
				
				<div class="suggestionsBox" id="suggestions" style="display: none;">
					<img src="../../img/upArrow.png" style="position: relative; top: -9px; left: 10px;" alt="upArrow" />
					<div class="suggestionList" id="autoSuggestionsList">
						&nbsp;
					</div>
				</div>
	        </div>
	  </td>
    </tr>
    <tr> 
      <td width="201">Jurusan</td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td width="414"><select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku">
          <option value="all">Semua 
          <?php
				 $result2 = @mysql_query("SELECT * FROM `jurusan` WHERE `jurusan`.id>0 AND `jurusan`.id<9");
	             while(($row2 = mysql_fetch_array($result2)))
	             {
		              echo "<option value=".$row2["id2"].">".$row2["jurusan"];
	             }
         	?>
        </select></td>
    </tr>
    <tr>
      <td nowrap>Judul TA </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_judul" type="text" class="tekboxku" id="frm_judul" size="50"></td>
    </tr>
    <tr>
      <td nowrap>Dosen Pembimbing 1</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <select name="frm_s_kode_dobing1" id="frm_s_kode_dobing1" class="tekboxku">
        <option <?php if ($frm_s_kode_dobing1==''){echo "selected";}?> value="all">--- Semua ---</option>
        <?php 
				$sqlDosen="select kode, nama
						   from dosen 
						    where (length(kode)=6) ORDER BY kode";
				
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
        <option value="<?php echo $row->kode; ?>" <?php if ($frm_s_kode_dobing1==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
        <?php
		}?>
      </select></td>
    </tr>
    <tr>
      <td nowrap> Dosen Pembimbing 2 </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_s_kode_dobing2" id="frm_s_kode_dobing2" class="tekboxku">
        <option <?php if ($frm_s_kode_dobing1==''){echo "selected";}?> value="all">--- Semua ---</option>
        <?php 
				$sqlDosen="select kode, nama
						   from dosen 
						    where (length(kode)=6) ORDER BY kode";
				
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
        <option value="<?php echo $row->kode; ?>" <?php if ($frm_s_kode_dobing2==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
        <?php
		}?>
      </select></td>
    </tr>
    <tr>
      <td nowrap>Urut berdasarkan</td>
      <td><div align="center"><strong>:</strong></div></td>
	  <td>
	  <select name="frm_urutkan" id="frm_urutkan" class="tekboxku">
		  <option value="jur">Jurusan</option>
		  <option value="nrp">NRP</option>
		  <option value="awal">Tgl.Awal TA</option>
		  <option value="akhir">Tgl.Akhir TA</option>
		  <option value="lulus">Tgl.Lulus TA</option>
      </select>
	  </td>
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
      <td><input type="hidden" name="mode" value="2"></td>
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
			 
$sql="SELECT master_mhs.NRP,
			 master_mhs.NAMA,
			 master_ta.JUDUL_TA,
			 master_ta.KODOS1,
			 master_ta.KODOS2,
			 DATE_FORMAT(`master_ta`.`TGL_TA`,'%d/%m/%Y') as TGL_AWAL,
			 DATE_FORMAT(`master_ta`.`AKHIR1`,'%d/%m/%Y') as TGL_AKHIR,
			 DATE_FORMAT(`master_ta`.`AKHIR2`,'%d/%m/%Y') as TGL_AKHIR2,
			 DATE_FORMAT(`lulus_ta`.`tgl_ujian`,'%d/%m/%Y') as TGL_LULUS_TA,
			 DATE_FORMAT(`lulus_ta`.`tgl_lulus`,'%d/%m/%Y') as TGL_LULUS_S1,
			 master_mhs.jurusan,
			 lulus_ta.nilai_ujian,
			 lulus_ta.sks,
			 lulus_ta.ipk,
			 master_ta.status,
			 master_ta.KOLUS
        FROM master_ta,master_mhs,lulus_ta
	   WHERE master_ta.NRP=master_mhs.NRP AND
	         master_ta.NRP=lulus_ta.NRP";

if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)
	
	if ($frm_s_nrp!="")
	{ 
		$sql .= " and master_mhs.NRP LIKE '%".$frm_s_nrp."%'";
	}
	
	if ($frm_s_nama!="")
	{ 
		$sql .= " and master_mhs.nama LIKE '%".$frm_s_nama."%'";
	}
	
	if ($frm_s_jurusan!="all")
	{ 
		$sql .= " and master_mhs.jurusan='".$frm_s_jurusan."'";
	}
	
	/*if($frm_id_tahun_ajar!="all")
	{ 
		$result_periode = @mysql_query("SELECT  id, 
												tahun_ajaran, 
												semester, 
												DATE_FORMAT(awal,'%Y/%m/%d') as awal, 
												DATE_FORMAT(akhir,'%Y/%m/%d') as akhir 
										   FROM tahun_ajar 
										  WHERE id=$frm_id_tahun_ajar ");
		$row_periode=@mysql_fetch_object($result_periode);   
		//$sql=$sql." and (`lulus_ta`.`tgl_lulus` between '".$row_periode->awal."' and '".$row_periode->akhir."')"; 
		$sql=$sql." and (`lulus_ta`.`semester`= '".$row_periode->semester."' and `lulus_ta`.`tahun`= '".$row_periode->tahun_ajaran."')"; 
	}*/
	
	if ($frm_judul!="")
	{ 
		$sql .= " and master_ta.JUDUL_TA LIKE '%".$frm_judul."%'";
	}
	
	if ($frm_s_kode_dobing1!="all")
	{ 
		$sql .= " and master_ta.KODOS1 = '".$frm_s_kode_dobing1."'";
	}
	
	if ($frm_s_kode_dobing2!="all")
	{ 
		$sql .= " and master_ta.KODOS2 = '".$frm_s_kode_dobing2."'";
	}

	/*switch($frm_urutkan)
	{
		case "jur" :
			$sql=$sql." order by master_mhs.jurusan ASC";
		break;

		case "nrp" :
			$sql=$sql." order by master_mhs.NRP ASC";
		break;

		case "awal" :
			$sql=$sql." order by `master_ta`.`TGL_TA` ASC";
		break;

		case "akhir" :
			$sql=$sql." order by `master_ta`.`AKHIR1` ASC";
		break;

		case "lulus" :
			$sql=$sql." order by `lulus_ta`.`tgl_lulus` ASC";
		break;

	}*/
	
	/*if($frm_tgl_periode!="" && $frm_tgl_periode2!="")
	{ 
		$sql=$sql." and (`lulus_ta`.`tgl_lulus` between '".datetomysql($frm_tgl_periode)."' and '".datetomysql($frm_tgl_periode2)."')"; 
	}
	else
	{
		if($frm_tgl_periode!="")
		{ 
			$sql=$sql." and (`lulus_ta`.`tgl_lulus` >='".datetomysql($frm_tgl_periode)."')"; 
		}
		if($frm_tgl_periode2!="")
		{ 
			$sql=$sql." and (`lulus_ta`.`tgl_lulus` <='".datetomysql($frm_tgl_periode2)."')"; 
		}
	}*/
	
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
	//echo "<br>.awal=".$row->awal;
	//echo "<br>.akhir=".$row->akhir;
	//echo "sql=".$sql;
    
}

//f_connecting();

// UNTUK PAGING --------------------------------
if ($mode=="2")
{
//mysql_select_db($DB);
$result=@mysql_query($sql);
//echo "H E R E";
//exit();
$maxrows=mysql_num_rows($result);				
if($hal=="") { $hal=1; }
$recke=(($hal-1)*$frm_s_jum_data);
$limit="$recke,$frm_s_jum_data";
$jumhal=ceil($maxrows/$frm_s_jum_data);
//echo $frm_tanggal_lulus1;
$vlink="mhs_lap_cari_TA.php";
$abc="?mode=2&frm_s_nrp=$frm_s_nrp&frm_s_nama=$frm_s_nama&frm_s_jurusan=$frm_s_jurusan&frm_judul=$frm_judul&frm_s_kode_dobing1=$frm_s_kode_dobing1&frm_s_kode_dobing2=$frm_s_kode_dobing2&frm_s_jum_data=$frm_s_jum_data&frm_urutkan=$frm_urutkan";

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
      ~</strong> DAFTAR MAHASISWA YANG LULUS TA</font></font></td>
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
				   WHERE id2='".$frm_s_jurusan."'";
		$result_jur = @mysql_query($sql_jur);
		$row_jur = @mysql_fetch_array($result_jur);
		echo "<td width=90%><b>Jurusan: </b>".$row_jur["nama_jur"]."</td>";
	}
	else
	{
		echo "<td width=90%><b>Jurusan: </b>Semua";
	}
	
if ($frm_id_tahun_ajar!="all")
	{	
		$thn_next=$row_periode->tahun_ajaran + 1;
		echo "<td align=\"right\" width=10% nowrap><b>Periode: </b>".$row_periode->semester." ".$row_periode->tahun_ajaran."<b>-</b> ".$thn_next."</td>";
	}
	else
	{
		echo "<td align=\"right\" width=10% nowrap><b>Periode: </b>Semua";
	}
echo "</tr>
	  </table>";
// Jurusan dan Periode END	

if ($mode=="2")
{
?>
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="mhs_lap_cari_TA_export.php">
<input type="hidden" name="mode" id="mode" value="3">
<input type="hidden" name="frm_id_tahun_ajar" id="frm_id_tahun_ajar" value="<?php echo $frm_id_tahun_ajar;?>">
<input type="hidden" name="frm_s_nrp" id="frm_s_nrp" value="<?php echo $frm_s_nrp; ?>">
<input type="hidden" name="frm_s_nama" id="frm_s_nama" value="<?php echo $frm_s_nama; ?>">
<input type="hidden" name="frm_judul" id="frm_judul" value="<?php echo $frm_judul; ?>">
<input type="hidden" name="frm_urutkan" id="frm_urutkan" value="<?php echo $frm_urutkan; ?>">
<input type="hidden" name="frm_s_jurusan" id="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>">
<input type="hidden" name="frm_s_kode_dobing1" id="frm_s_kode_dobing1" value="<?php echo $frm_s_kode_dobing1; ?>">
<input type="hidden" name="frm_s_kode_dobing2" id="frm_s_kode_dobing2" value="<?php echo $frm_s_kode_dobing2; ?>">
<?
}

if (mysql_num_rows($result)==0) {
    echo "<font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=mhs_lap_cari_TA.php class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}		 

	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
		<table width="100%"  border="1" cellspacing="0" cellpadding="5" class="table">
		  <tr bgcolor="#C6E2FF">
			<td><strong>No.</strong></td>
			<td nowrap><strong>Jurusan</strong></td>
			<td nowrap><strong>NRP</strong></td>
			<td nowrap><strong>Nama</strong></td>
			<td nowrap><strong>Judul TA </strong></td>
			<td nowrap><strong>Nilai TA </strong></td>
			<td nowrap><strong>IPK</strong></td>
			<td nowrap><strong>SKS</strong></td>
			<td nowrap><strong>Dosen Pembimbing 1</strong></td>
			<td nowrap><strong>Dosen Pembimbing 2</strong></td>
			<td nowrap><strong>Tgl. AWAL TA</strong></td>
			<td nowrap><strong>Tgl. AKHIR TA</strong></td>
			<td nowrap><b>Tgl. PERPANJANGAN TA</b></td>
			<td nowrap><strong>Tgl Lulus TA </strong></td>
			<td nowrap><strong>Tgl Lulus S1 </strong></td>
			<td nowrap><strong>Status TA</strong></td>
			<td nowrap><strong>Status Kuliah</strong></td>
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
					switch ($row["jurusan"])
					{
						case '6B':
							echo "Teknik Elektro";
							break;
						case '6C':
							echo "Teknik Kimia";
							break;
						case '6D':
							echo "Teknik Industri";
							break;
						case '6E':
							echo "Teknik Informatika";
							break;
						case '6F':
							echo "Teknik Manufaktur";
							break;
                        case '6G':
							echo "DMP";
							break;
                        case '6H':
							echo "Sistem Informasi";
							break;
                        case '6I':
							echo "Multimedia";
							break;
					}
				?>
            </td>
            <td nowrap><? echo $row["NRP"]; ?></td>
            <td nowrap><? echo $row["NAMA"]; ?></td>
            <td valign="top" nowrap><? echo $row["JUDUL_TA"]; ?></td>
            <td nowrap><? echo $row["nilai_ujian"]; ?></td>
            <td nowrap><? echo $row["ipk"]; ?></td>
            <td nowrap><? echo $row["sks"]; ?></td>
            <td nowrap>
              <? $sql_dobing1="SELECT nama
							   FROM dosen
							   WHERE kode='".$row["KODOS1"]."'";
				   $result_dobing1 = @mysql_query($sql_dobing1);
				   $row_dobing1=@mysql_fetch_array($result_dobing1);
				   echo $row["KODOS1"]."-".$row_dobing1["nama"];?>
            </td>
            <td nowrap>
              <? $sql_dobing2="SELECT nama
							   FROM dosen
							   WHERE kode='".$row["KODOS2"]."'";
				   $result_dobing2 = @mysql_query($sql_dobing2);
				   $row_dobing2=@mysql_fetch_array($result_dobing2);
				   echo $row["KODOS2"]."-".$row_dobing2["nama"];?>
            </td>
            <td nowrap><? echo $row["TGL_AWAL"]; ?></td>
            <td nowrap><? echo $row["TGL_AKHIR"]; ?></td>
            <td nowrap>
				<? 
				//echo $row["TGL_AKHIR2"];
				   $sql_ulur="SELECT NRP,
				   					 DATE_FORMAT(tgl_ulur,'%d/%m/%Y') as tgl_ulur
							    FROM perpanjang_ta
							   WHERE NRP='".$row["NRP"]."'";
				   $result_ulur = @mysql_query($sql_ulur);
				   $row_ulur=@mysql_fetch_array($result_ulur);
				   echo $row_ulur["tgl_ulur"]; 
				
				?>
			</td>
			<td nowrap><? echo $row["TGL_LULUS_TA"]; ?></td>
            <td nowrap><? echo $row["TGL_LULUS_S1"]; ?></td>
            <td nowrap> 
              <? if ($row["KOLUS"]=='L')
			   		{ echo "LULUS TA";}
				 else
				    { echo "BELUM LULUS TA";}
			    ?>
            </td>
            <td nowrap> 
              <? if ($row["status"]=='S')
			   		{ echo "SELESAI";}
				 else
				    { echo "BELUM SELESAI KULIAH";}
			   ?>
            </td>
          </tr>
<?
}
?>
        </table>
	<input name="excel"   type="image" onClick="document.fexcel.action='mhs_lap_cari_TA_export.php?t=excel'" src="../../img/Mexcel.jpg" align="bottom" width="18" height="18"> 
	Export ke File Excel &nbsp;
	<input name="printer"  onClick="document.fexcel.action='mhs_lap_cari_TA_export.php?t=printer'" type="image" src="../../img/print.gif" width="18" height="18"> 
	Print
</FORM>
<?
}
	if ($mode=="2") { f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); }
?>
</body>
</html>