<?
/* 
   HISTORY      : 08/08/03- Masih ada yang bisa ditambahkan ?
       
   DATE CREATED : 08/08/03
   UPDATE  		: 08/08/03 - EKO
   	  		  
   PROBLEM 		:
   KEGUNAAN     : PETA KONDISI MAHASISWA
   VARIABEL     : 
*/
session_start();
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);
	$result=mysql_query("Select Count(*) as jumlah from master_mhs");
	$row=mysql_fetch_array($result);
	$jumlah_mhs=$row["jumlah"]; 

$result_TE = @mysql_query("SELECT	mhs_aktif.idnya,
									mhs_aktif.id_jurusan,
									mhs_aktif.angkatan,
									mhs_aktif.jum_mhs,
									mhs_aktif.periode
							   FROM mhs_aktif
							  WHERE mhs_aktif.id_jurusan=1
						   ORDER BY mhs_aktif.angkatan DESC");
						   
$result_TK = @mysql_query("SELECT	mhs_aktif.idnya,
									mhs_aktif.id_jurusan,
									mhs_aktif.angkatan,
									mhs_aktif.jum_mhs,
									mhs_aktif.periode
							   FROM mhs_aktif
							  WHERE mhs_aktif.id_jurusan=2
						   ORDER BY mhs_aktif.angkatan DESC");
						   
$result_TI = @mysql_query("SELECT	mhs_aktif.idnya,
									mhs_aktif.id_jurusan,
									mhs_aktif.angkatan,
									mhs_aktif.jum_mhs,
									mhs_aktif.periode
							   FROM mhs_aktif
							  WHERE mhs_aktif.id_jurusan=3
						   ORDER BY mhs_aktif.angkatan DESC");
						   						   						   
$result_IF = @mysql_query("SELECT	mhs_aktif.idnya,
									mhs_aktif.id_jurusan,
									mhs_aktif.angkatan,
									mhs_aktif.jum_mhs,
									mhs_aktif.periode
							   FROM mhs_aktif
							  WHERE mhs_aktif.id_jurusan=4
						   ORDER BY mhs_aktif.angkatan DESC");
						   
						   
$result_TM = @mysql_query("SELECT	mhs_aktif.idnya,
									mhs_aktif.id_jurusan,
									mhs_aktif.angkatan,
									mhs_aktif.jum_mhs,
									mhs_aktif.periode
							   FROM mhs_aktif
							  WHERE mhs_aktif.id_jurusan=5
						   ORDER BY mhs_aktif.angkatan DESC");			

//$result_Jurusan = @mysql_query("SELECT * FROM `jurusan` WHERE `jurusan`.id<>0 ORDER BY id ASC");		   
						   
//$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__1___'");
//$row=@mysql_fetch_array($result);
	//$jumlah_mhs_elektro = $row["jumlah"];
	
//JUMLAH TOTAL MAHASISWA ELEKTRO
$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__1___'");
$row=@mysql_fetch_array($result);
    $jumlah_mhs_elektro = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA KIMIA
$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__2___'");
$row=@mysql_fetch_array($result);
	$jumlah_mhs_kimia = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA INDUSTRI
$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__3___'");
$row=@mysql_fetch_array($result);
	$jumlah_mhs_industri = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA INFORMATIKA
$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__4___'");
$row=@mysql_fetch_array($result);
	$jumlah_mhs_informatika = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA MANUFAKTUR
$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__5___'");
$row=@mysql_fetch_array($result);
$jumlah_mhs_manufaktur = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA DMP
$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__6___'");
$row=@mysql_fetch_array($result);
$jumlah_mhs_DMP = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA SI
$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__7___'");
$row=@mysql_fetch_array($result);
$jumlah_mhs_SI = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA MM
$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__8___'");
$row=@mysql_fetch_array($result);
$jumlah_mhs_MM = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA DUAL DEGREE
$result = @mysql_query("Select Count(*) as jumlah from master_mhs where nrp LIKE '6__9___'");
$row=@mysql_fetch_array($result);
$jumlah_mhs_DD = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA LAKI-LAKI
$result=mysql_query("Select Count(*) as jumlah from master_mhs where sex='L'"); 
//$row = mysql_fetch_array($result);
$jumlah_pria = $row["jumlah"];

//JUMLAH TOTAL MAHASISWA PEREMPUAN
$result=mysql_query("Select Count(*) as jumlah from master_mhs where sex='P'"); 
//$row = mysql_fetch_array($result);
$jumlah_wanita = $row["jumlah"];
?>
<html>
<head>
<title>Halaman Utama Mahasiswa</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	font-size: 12px;
	font-weight: bold;
}
.style3 {font-size: 12px}
-->
</style>
</head>
<body>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><span class="style1"><font color="#003399">Jumlah Mahasiswa mulai tahun 1986 :</font> </span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><span class="style3"><font color="#0099CC">Jumlah total mahasiswa fakultas teknik <font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $jumlah_mhs; ?></font> orang </font></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="49%" valign="top">
		<table width="100%"  border="1" cellpadding="4" cellspacing="2" class="table_data_mhs" >
          <tr bgcolor="#C6E2FF">
            <td align="center"><strong>Jurusan/Program Studi </strong></td>
            <td align="center"><strong>Jumlah</strong></td>
          </tr>
          <tr>
            <td><span class="style3">Jurusan Teknik Elektro </span></td>
            <td nowrap> <span class="style3"><font color="#0099CC"><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $jumlah_mhs_elektro; ?></font></font></span> </td>
          </tr>
          <tr>
            <td><span class="style3">Jurusan Teknik Kimia </span></td>
            <td nowrap><span class="style3"><font color="#0099CC"><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $jumlah_mhs_kimia; ?></font></font></span></td>
          </tr>
          <tr>
            <td><span class="style3">Jurusan Teknik Industri </span></td>
            <td nowrap><span class="style3"><font color="#0099CC"><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $jumlah_mhs_industri; ?></font></font></span></td>
          </tr>
          <tr>
            <td><span class="style3">Jurusan Teknik Informatika </span></td>
            <td nowrap><span class="style3"><font color="#0099CC"><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $jumlah_mhs_informatika; ?></font></font></span></td>
          </tr>
          <tr>
            <td><span class="style3">Program Studi Manufaktur</span></td>
            <td nowrap><span class="style3"><font color="#0099CC"><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $jumlah_mhs_manufaktur; ?></font></font></span></td>
          </tr>
          <tr>
            <td nowrap><span class="style3">Program Studi Desain Manajemen Produk </span></td>
            <td nowrap><span class="style3"><font color="#0099CC"><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $jumlah_mhs_DMP; ?></font></font></span></td>
          </tr>
          <tr>
            <td><span class="style3">Program Studi Sistem Informasi </span></td>
            <td nowrap><span class="style3"><font color="#0099CC"><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $jumlah_mhs_SI; ?></font></font></span></td>
          </tr>
          <tr>
            <td><span class="style3">Program Studi Multimedia </span></td>
            <td nowrap><span class="style3"><font color="#0099CC"><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $jumlah_mhs_MM; ?></font></font></span></td>
          </tr>
          <tr>
            <td><span class="style3">Program Studi Dual Degree </span></td>
            <td nowrap><span class="style3"><font color="#0099CC"><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $jumlah_mhs_DD; ?></font></font></span></td>
          </tr>
        </table></td>
        <td width="51%" valign="top"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="343" height="270">
            <param name="movie" value="/chart/test3.swf">
            <param name="quality" value="high">
            <embed src="chart/test3.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="343" height="270"></embed>
          </object>          &nbsp;</td>
      </tr>
    </table></td>
    
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><span class="style1"><font color="#003399">Jumlah Mahasiswa Fakultas Teknik per Angkatan : </font></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="30%" align="left" valign="top"><table width="100"  border="0" cellpadding="3" cellspacing="0" >
      <tr>
        <td colspan=5><span class="style3"><font color="#0099CC">Teknik Elektro</font></span></td>
      </tr>
      <tr>
        <td colspan=5><table width="95%"  border="1" cellpadding="2" cellspacing="2" class="table_data_mhs" >
            <tr bgcolor="#C6E2FF">
              <td align="center"><strong>Angkatan</strong></td>
              <td align="center"><strong>Periode</strong></td>
              <td align="center"><strong>Jumlah</strong></td>
            </tr>
            <?
	  while ($row_TE=@mysql_fetch_array($result_TE))
	  {
	   //$jumlah_mhs_elektro = $row_TE["jumlah"];
	  ?>
            <tr>
              <td><? echo $row_TE["angkatan"];?></td>
              <td nowrap>
                <? 
			 $periode_semester=substr($row_TE["periode"], 4,1); 
			 $periode_tahun=substr($row_TE["periode"], 0,4); 
			 $periode_tahun2=$periode_tahun+1;
			 switch ($periode_semester) {
				case '1':
					$periode_text='GASAL';
					break;
				case '2':
					$periode_text='GENAP';
					break;
			}
			 echo $periode_text." ".$periode_tahun."-".$periode_tahun2;
		?>
              </td>
              <td><? echo $row_TE["jum_mhs"];?></td>
            </tr>
            <?
	  }
	  ?>
        </table></td>
      </tr>
      <tr>
        <td colspan=5>&nbsp;</td>
      </tr>
      <tr>
        <td colspan=5><span class="style3"><font color="#0099CC">Teknik Informatika</font></span></td>
      </tr>
      <tr>
        <td colspan=5><table width="95%"  border="1" cellpadding="2" cellspacing="2" class="table_data_mhs" >
            <tr bgcolor="#C6E2FF">
              <td align="center"><strong>Angkatan</strong></td>
              <td align="center"><strong>Periode</strong></td>
              <td align="center"><strong>Jumlah</strong></td>
            </tr>
            <?
	  while ($row_IF=@mysql_fetch_array($result_IF))
	  {
	   //$jumlah_mhs_elektro = $row_TE["jumlah"];
	  ?>
            <tr>
              <td><? echo $row_IF["angkatan"];?></td>
              <td nowrap>
                <? 
			 $periode_semester=substr($row_IF["periode"], 4,1); 
			 $periode_tahun=substr($row_IF["periode"], 0,4); 
			 $periode_tahun2=$periode_tahun+1;
			 switch ($periode_semester) {
				case '1':
					$periode_text='GASAL';
					break;
				case '2':
					$periode_text='GENAP';
					break;
			}
			 echo $periode_text." ".$periode_tahun."-".$periode_tahun2;
		?>
              </td>
              <td><? echo $row_IF["jum_mhs"];?></td>
            </tr>
            <?
	  }
	  ?>
        </table></td>
      </tr>
    </table></td>
    <td width="40%" align="center" valign="top"><table width="90%"  border="0" cellpadding="3" cellspacing="0" >
      <tr>
        <td colspan=5><span class="style3"><font color="#0099CC">Teknik Kimia</font></span></td>
      </tr>
      <tr>
        <td colspan=5><table width="100%"  border="1" align="center" cellpadding="2" cellspacing="2" class="table_data_mhs" >
            <tr bgcolor="#C6E2FF">
              <td align="center"><strong>Angkatan</strong></td>
              <td align="center"><strong>Periode</strong></td>
              <td align="center"><strong>Jumlah</strong></td>
            </tr>
            <?
	  while ($row_TK=@mysql_fetch_array($result_TK))
	  {
	   //$jumlah_mhs_elektro = $row_TE["jumlah"];
	  ?>
            <tr>
              <td><? echo $row_TK["angkatan"];?></td>
              <td nowrap>
                <? 
			 $periode_semester=substr($row_TK["periode"], 4,1); 
			 $periode_tahun=substr($row_TK["periode"], 0,4); 
			 $periode_tahun2=$periode_tahun+1;
			 switch ($periode_semester) {
				case '1':
					$periode_text='GASAL';
					break;
				case '2':
					$periode_text='GENAP';
					break;
			}
			 echo $periode_text." ".$periode_tahun."-".$periode_tahun2;
		?>
              </td>
              <td><? echo $row_TK["jum_mhs"];?></td>
            </tr>
            <?
	  }
	  ?>
        </table></td>
      </tr>
      <tr>
        <td colspan=5>&nbsp;</td>
      </tr>
      <tr>
        <td colspan=5><span class="style3"><font color="#0099CC">Teknik Manufaktur</font></span></td>
      </tr>
      <tr>
        <td colspan=5><table width="100%"  border="1" align="center" cellpadding="2" cellspacing="2" class="table_data_mhs" >
            <tr bgcolor="#C6E2FF">
              <td align="center"><strong>Angkatan</strong></td>
              <td align="center"><strong>Periode</strong></td>
              <td align="center"><strong>Jumlah</strong></td>
            </tr>
            <?
	  while ($row_TM=@mysql_fetch_array($result_TM))
	  {
	   //$jumlah_mhs_elektro = $row_TE["jumlah"];
	  ?>
            <tr>
              <td><? echo $row_TM["angkatan"];?></td>
              <td nowrap>
                <? 
			 $periode_semester=substr($row_TM["periode"], 4,1); 
			 $periode_tahun=substr($row_TM["periode"], 0,4); 
			 $periode_tahun2=$periode_tahun+1;
			 switch ($periode_semester) {
				case '1':
					$periode_text='GASAL';
					break;
				case '2':
					$periode_text='GENAP';
					break;
			}
			 echo $periode_text." ".$periode_tahun."-".$periode_tahun2;
		?>
              </td>
              <td><? echo $row_TM["jum_mhs"];?></td>
            </tr>
            <?
	  }
	  ?>
        </table></td>
      </tr>
    </table></td>
    <td width="30%" align="right" valign="top"><table width="100"  border="0" cellpadding="3" cellspacing="0" >
      <tr>
        <td colspan=5><span class="style3"><font color="#0099CC">Teknik Industri</font></span></td>
      </tr>
      <tr>
        <td colspan=5><table width="95%"  border="1" cellpadding="2" cellspacing="2" class="table_data_mhs" >
            <tr bgcolor="#C6E2FF">
              <td align="center"><strong>Angkatan</strong></td>
              <td align="center"><strong>Periode</strong></td>
              <td align="center"><strong>Jumlah</strong></td>
            </tr>
            <?
	  while ($row_TI=@mysql_fetch_array($result_TI))
	  {
	   //$jumlah_mhs_elektro = $row_TE["jumlah"];
	  ?>
            <tr>
              <td><? echo $row_TI["angkatan"];?></td>
              <td nowrap>
                <? 
			 $periode_semester=substr($row_TI["periode"], 4,1); 
			 $periode_tahun=substr($row_TI["periode"], 0,4); 
			 $periode_tahun2=$periode_tahun+1;
			 switch ($periode_semester) {
				case '1':
					$periode_text='GASAL';
					break;
				case '2':
					$periode_text='GENAP';
					break;
			}
			 echo $periode_text." ".$periode_tahun."-".$periode_tahun2;
		?>
              </td>
              <td><? echo $row_TI["jum_mhs"];?></td>
            </tr>
            <?
	  }
	  ?>
        </table></td>
      </tr>
    </table></td>
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
</table>
</body>
</html>