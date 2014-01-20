<? 
/* 
   DATE CREATED : 12/07/07
   KEGUNAAN     : CETAK SK DEKAN PENGUJI TA
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
   
   PERUBAHAN    : 15/12/2009 - perubahan format SK DEKAN 
   							 - dari  002810910/SK/DK/TA/2009 menjadi 002810910/SK/DEK/FT/XII/2009 
*/

session_start();
include("../../include/js_function.js");
require("../../include/global.php");
require("../../include/fungsi.php");
?>
<html>
<head>
<title>: : CETAK LAMPIRAN SK DEKAN TA : :</title>
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

 
$sql_Lampiran_SK_dek="SELECT master_mhs.NRP,
							 master_mhs.NAMA,
							 DATE_FORMAT(`daftar_uji`.`tgl_ujian`,'%d/%m/%Y') as TGL_UJI,
							 daftar_uji.`ruang_ujian`,
							 daftar_uji.`kode_ketua`,
							 daftar_uji.`kode_sekre`,
							 daftar_uji.`kode_dosen1`,
							 daftar_uji.`kode_dosen2`,
							 daftar_uji.`kode_dosen3`,
							 master_ta.`JUDUL_TA`
					   FROM  master_mhs, master_ta, daftar_uji 
					  WHERE  master_mhs.NRP =  master_ta.NRP AND
							 master_mhs.NRP =  daftar_uji.NRP AND
							 daftar_uji.NO_SK = '".$var_no_SK."' AND
							 daftar_uji.UR_NOSK <> 0 ";
$result = mysql_query($sql_Lampiran_SK_dek);
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
        <td width="400%" colspan="4"><strong>Lampiran SK Dekan no:
            <? 
		 // $jur_kp=substr($frm_kode_KP, 0,2);     
		  $bln= date('m');
		  //echo "<br>bln=".$bln;
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
			}

		  //echo  $var_no_SK ."/SK/DK/FT/".date('Y');
		  echo  $var_no_SK ."/SK/DEK/FT/".$bln_romawi."/".date('Y');
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
            <td nowrap><? echo "$nomor.";?></td>
            <td nowrap><? echo $row["NRP"];?></td>
            <td><? echo $row["NAMA"];?></td>
            <td>
				<table width="100%"  border="0" cellspacing="0" cellpadding="2">
				  <tr>
					<td width="26%" nowrap>Ketua</td>
					<td width="3%"><strong>:</strong></td>
					<td width="71%" nowrap>
					<? if ($row["kode_ketua"]!='') {
						$result2 = mysql_query("Select nama as nama_ketua from dosen where kode='".$row['kode_ketua']."'");
						$row2 = mysql_fetch_array($result2);
						echo $row2["nama_ketua"];
					}?>
					</td>
				  </tr>
				  <? if ($row["kode_sekre"]!='') {?>
				  <tr>
				    <td nowrap>Sekretaris</td>
				    <td><strong>:</strong></td>
				    <td nowrap>
					<?
						$result2 = mysql_query("Select nama as nama_sekre from dosen where kode='".$row['kode_sekre']."'");
						$row2 = mysql_fetch_array($result2);
						echo $row2["nama_sekre"];
					?>
					</td>
				  </tr>
				  <? }?>
				  <tr>
					<td>Anggota</td>
					<td><strong>:</strong></td>
					<td nowrap>
					<? if ($row["kode_dosen1"]!='') {
						$result2 = mysql_query("Select nama as nama_anggota_1 from dosen where kode='".$row['kode_dosen1']."'");
						$row2 = mysql_fetch_array($result2);
						echo $row2["nama_anggota_1"];
					}?>
					</td>
				  </tr>
				  <tr>
					<td>Anggota</td>
					<td><strong>:</strong></td>
					<td nowrap>
					<? if ($row["kode_dosen2"]!='') {
						$result2 = mysql_query("Select nama as nama_anggota_2 from dosen where kode='".$row['kode_dosen2']."'");
						$row2 = mysql_fetch_array($result2);
						echo $row2["nama_anggota_2"];
					}?>
					</td>
				  </tr>
				  <tr>
				    <td>Anggota </td>
				    <td><strong>:</strong></td>
				    <td nowrap><? if ($row["kode_dosen3"]!='') {
						$result2 = mysql_query("Select nama as nama_anggota_3 from dosen where kode='".$row['kode_dosen3']."'");
						$row2 = mysql_fetch_array($result2);
						echo $row2["nama_anggota_3"];
					}?></td>
				    </tr>
				</table>			</td>
            <td nowrap>
				<? if ($row["TGL_UJI"]=="00/00/0000") {
						$frm_tgl_uji_LP = ""; }else {
						$frm_tgl_uji_LP = $row["TGL_UJI"];}
						echo $frm_tgl_uji_LP;
				?>
			</td>
            <td nowrap><? echo $row["ruang_ujian"];?></td>
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
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
    
    
    <table border="0" style="margin-left: 10cm">
        <tr>
            <td>Surabaya, <?php 

		 // echo "<br>var_tgl_surat=".$var_tgl_surat;
		  $tgl=date('d') ; 
		  $bln=intval(date('m'));
		  $thn=date('Y');  
		  
		 // echo "<br>bln=".$bln."<br>";   
		 // echo "<br>tgl=".$tgl."<br>"; 
		 // echo "<br>thn=".$thn."<br>"; 
		  	  
			switch ($bln) {
						case '1':
							$bln_nama=' Januari ';
							break;
						case '2':
							$bln_nama=' Februari ';
							break;
						case '3':
							$bln_nama=' Maret ';
							break;
						case '4':
							$bln_nama=' April ';
							break;
						case '5':
							$bln_nama=' Mei ';
							break;
						case '6':
							$bln_nama=' Juni ';
							break;
						case '7':
							$bln_nama=' Juli ';
							break;
						case '8':
							$bln_nama=' Agustus ';
							break;
						case '9':
							$bln_nama=' September ';
							break;
						case '10':
							$bln_nama=' Oktober ';
							break;
						case '11':
							$bln_nama=' November ';
							break;	
						case '12':
							$bln_nama=' Desember ';
							break;
						}
				
			$date = $tgl." ".$bln_nama." ".$thn;
		 	echo $date;
		 ?>            
            
            </td>
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