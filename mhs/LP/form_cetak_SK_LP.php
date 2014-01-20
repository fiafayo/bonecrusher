<? 
session_start();
include("../../include/js_function.js");
require("../../include/global.php");
require("../../include/fungsi.php");
?>
<html>
<head>
<title>: : CETAK LAMPIRAN SK DEKAN : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
</head>
<body>
<? 
f_connecting();
	mysql_select_db($DB);
	
//$var_NRP=$_GET['nrp'];
$var_no_SK=$_GET['no_sk'];
$var_periode=$_GET['periode'];
$var_thn_ajar=$_GET['thn_ajar'];
/*echo "<br>var_no_SK=".$var_no_SK;
echo "<br>var_periode=".$var_periode;
echo "<br>var_thn_ajar=".$var_thn_ajar;*/

 
$sql_berita="SELECT DISTINCT master_mhs.NRP,
							 master_mhs.NAMA,
							 DATE_FORMAT(`daftar_uji_lp`.`TGLUJI`,'%d/%m/%Y') as TGL_UJI,
							 daftar_uji_lp.`RUANG`,
							 daftar_uji_lp.`PEMBIMBING_1`,
							 daftar_uji_lp.`PEMBIMBING_2`,
							 daftar_uji_lp.`PENGUJI_1`,
							 daftar_uji_lp.`PENGUJI_2`,
							 master_lp.`JUDUL1`
					   FROM  master_mhs, master_lp, daftar_uji_lp 
					  WHERE  master_mhs.NRP =  master_lp.NRP AND
							 master_mhs.NRP =  daftar_uji_lp.NRP AND
							 daftar_uji_lp.NO_SK = '".$var_no_SK."'";
							   
$result = mysql_query($sql_berita);
			
?>
<table width="80%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">          
		<input type="submit" name="Submit" value="PRINT" onClick="cetak();" style=" cursor:pointer; position:absolute; left:604px; top:32px; width:52px; height:18px; z-index:1; background-color: #CCCCCC; layer-background-color: #CCCCCC; border: 1px none #000000;" class="noPrint">
		</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td width="400%" colspan="4"><strong>Lampiran SK Dekan no:
            <? 
		 /* $jur_kp=substr($frm_kode_KP, 0,2);     
		  $bln= date('m');
		  switch ($bln) {
			case '01':
				$bln_romawi='I';
				break;
			case '02':
				$bln_romawi='II';
				break;
			case '03':
				$bln_romawi='III';
				break;
			case '04':
				$bln_romawi='IV';
				break;
			case '05':
				$bln_romawi='V';
				break;
			case '06':
				$bln_romawi='VI';
				break;
			case '07':
				$bln_romawi='VII';
				break;
			case '08':
				$bln_romawi='VIII';
				break;
			case '09':
				$bln_romawi='IX';
				break;
			case '10':
				$bln_romawi='X';
				break;
			case '11':
				$bln_romawi='XI';
				break;	
			case '12':
				$bln_romawi='XII';
				break;
			}*/

		  echo  $var_no_SK ."/SK/DK/FT/".date('Y');
		  ?> 
          </strong></td>
        </tr>
      <tr>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center">          </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%"  border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%"  border="1" cellspacing="0" cellpadding="2">
          <tr>
            <td width="3%"><strong>No.</strong></td>
            <td width="12%"><strong>NRP</strong></td>
            <td width="20%"><strong>NAMA</strong></td>
            <td width="39%"><strong>PANITIA</strong></td>
            <td width="17%"><strong>TGL.UJIAN</strong></td>
            <td width="9%"><strong>RUANG</strong></td>
          </tr>
		  <? $nomor=1;
			while($row = mysql_fetch_array($result))
	        {
		  ?>
          <tr valign="top">
            <td><? echo "$nomor.";?></td>
            <td><? echo $row["NRP"];?></td>
            <td><? echo $row["NAMA"];?></td>
            <td>
				<table width="100%"  border="0" cellspacing="0" cellpadding="2">
				  <tr>
					<td width="26%" nowrap>Pembimbing 1 </td>
					<td width="3%"><strong>:</strong></td>
					<td width="71%" nowrap>
					<? if ($row["PEMBIMBING_1"]!='') {
						$result2 = mysql_query("Select nama as nama_dobing_1 from dosen where kode='".$row['PEMBIMBING_1']."'");
						$row2 = mysql_fetch_array($result2);
						echo $row2["nama_dobing_1"];
					}?>
					</td>
				  </tr>
				  <? if ($row["PEMBIMBING_2"]!='') {?>
				  <tr>
				    <td nowrap>Pembimbing 2 </td>
				    <td><strong>:</strong></td>
				    <td nowrap>
					<?
						$result2 = mysql_query("Select nama as nama_dobing_2 from dosen where kode='".$row['PEMBIMBING_2']."'");
						$row2 = mysql_fetch_array($result2);
						echo $row2["nama_dobing_2"];
					?>
					</td>
				  </tr>
				  <? }?>
				  <tr>
					<td>Penguji 1</td>
					<td><strong>:</strong></td>
					<td nowrap>
					<? if ($row["PENGUJI_1"]!='') {
						$result2 = mysql_query("Select nama as nama_doji_1 from dosen where kode='".$row['PENGUJI_1']."'");
						$row2 = mysql_fetch_array($result2);
						echo $row2["nama_doji_1"];
					}?>
					</td>
				  </tr>
				  <tr>
					<td>Penguji 2</td>
					<td><strong>:</strong></td>
					<td nowrap>
					<? if ($row["PENGUJI_2"]!='') {
						$result2 = mysql_query("Select nama as nama_doji_2 from dosen where kode='".$row['PENGUJI_2']."'");
						$row2 = mysql_fetch_array($result2);
						echo $row2["nama_doji_2"];
					}?>
					</td>
				  </tr>
				</table>			</td>
            <td><? if ($row["TGL_UJI"]=="00/00/0000") {
					$frm_tgl_uji_LP = ""; }else {
					$frm_tgl_uji_LP = $row["TGL_UJI"];}
					echo $frm_tgl_uji_LP;
			?></td>
            <td><? echo $row["RUANG"];?></td>
			 <? 
					//$frm_judul_LP = $row["JUDUL1"];
					
			?>
		 	
          </tr>
		  <? $nomor++;
		  } ?>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
<tr>
            <td>Dekan,</td>
            
        </tr>
        <tr>
            <td>
                <br/><br/><br/><br/><br/>
                Dr. Amelia Santoso</td>
            
        </tr>  
</table>
</body>
</html>