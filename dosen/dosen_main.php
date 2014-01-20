<?php
/* 
   HISTORY      : 15/05/03- Masih ada yang bisa ditambahkan ?
       
   DATE CREATED : 15/05/03
   UPDATE  		: 15/05/03 - EKO
   	  		  
   PROBLEM 		:
   KEGUNAAN     : PETA KONDISI KARYAWAN
   VARIABEL     : 
  
   
*/
session_start();
require("../include/global.php");
require("../include/fungsi.php");


f_connecting();
	mysql_select_db($DB);
	$result=mysql_query("Select Count(*) as jumlah from master_karyawan");
	$row=mysql_fetch_array($result);
	$jumlah_karyawan=$row["jumlah"]; 

$result = @mysql_query("Select Count(*) as jumlah from master_karyawan, karyawan_jenis_karyawan where karyawan_jenis_karyawan.id=master_karyawan.id_jenis and karyawan_jenis_karyawan.kategori='D'");
$row=@mysql_fetch_array($result);
	$jumlah_dosen = $row["jumlah"];

	$result=mysql_query("Select Count(*) as jumlah from master_karyawan where sex='L'"); 
$row = mysql_fetch_array($result);
$jumlah_pria = $row["jumlah"];
$result=mysql_query("Select Count(*) as jumlah from master_karyawan where sex='P'"); 
$row = mysql_fetch_array($result);
$jumlah_wanita = $row["jumlah"];

$result=mysql_query("Select Count(*) as jumlah from master_karyawan where status_pernikahan='M'"); 
$row = mysql_fetch_array($result);
$jumlah_menikah = $row["jumlah"];
$result=mysql_query("Select Count(*) as jumlah from master_karyawan where status_pernikahan='B'"); 
$row = mysql_fetch_array($result);
$jumlah_belum_menikah = $row["jumlah"];




?>
<html>
<head>
<title>Halaman Utama Karyawan</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style8 {color: #333333; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="34%"  border="0" cellpadding="3" cellspacing="0" >
  <tr> 
    <td colspan=5 nowrap> <strong><font color="#003399">Jumlah Karyawan</font></strong> 
    </td>
  </tr>
  <tr> 
    <td colspan=5 nowrap> <font color="#FF9900"><strong>&raquo;</strong></font> 
      <font color="#0099CC">Jumlah karyawan <font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $jumlah_karyawan; ?></font> 
      orang </font> </td>
  </tr>
  <tr> 
    <td colspan=5 nowrap> <font color="#FF9900"><strong>&raquo;</strong></font> 
      <font color="#0099CC">Jumlah karyawan (non dosen) <font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $jumlah_karyawan-$jumlah_dosen; ?></font> 
      orang </font> </td>
  </tr>
  <tr> 
    <td colspan=5 nowrap> <font color="#FF9900"><strong>&raquo;</strong></font> 
      <font color="#0099CC">Jumlah dosen <font  face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $jumlah_dosen; ?></font> 
      orang </font> </td>
  </tr>
  <tr> 
    <td colspan=5 nowrap>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan=5 nowrap> <strong><font color="#003399">Karyawan Berdasar Jenis 
      Kelamin</font></strong> </td>
  </tr>
  <tr> 
    <td width="4%" nowrap>&nbsp;</td>
    <td colspan="4" nowrap><table width="100%" border="1" cellpadding="3" cellspacing="0" class="table_data_mhs">
        <tr bgcolor="#C6E2FF"> 
          <td width="42%"><span class="style8">Jenis Kelamin</span></td>
          <td width="23%"><span class="style8">Jumlah</span></td>
          <td colspan="2"><span class="style8">Prosentase</span></td>
        </tr>
        <tr> 
          <td nowrap>Pria</td>
          <td nowrap><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $jumlah_pria; ?></font></td>
          <td width="8%" nowrap><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo (string)round($jumlah_pria/$jumlah_karyawan*100)."%"; ?></font></td>
          <td width="27%" nowrap> 
            <?php
	if (($jumlah_karyawan>0)and($jumlah_pria>0)) { 
	echo "<img border='1' style='background-color: #000000' src='../img/poll1.gif' height=10 width=".(string)round($jumlah_pria/$jumlah_karyawan*60).">"; 
	}else { echo "&nbsp;";} ?>
          </td>
        </tr>
        <tr> 
          <td nowrap>Wanita</td>
          <td nowrap><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $jumlah_wanita; ?></font></td>
          <td nowrap><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo (string)round($jumlah_wanita/($jumlah_karyawan)*100)."%"; ?></font></td>
          <td nowrap> 
            <?php
	if (($jumlah_karyawan>0)and($jumlah_wanita>0)) { 
	echo "<img border='1' style='background-color: #000000' src='../img/poll2.gif' height=10 width=".(string)round($jumlah_wanita/($jumlah_karyawan)*60).">"; 
	}else { echo "&nbsp;";} ?>
          </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td colspan=5 nowrap>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan=5 nowrap> <strong><font color="#003399">Karyawan Berdasar Status 
      Pernikahan</font></strong> </td>
  </tr>
  <tr> 
    <td nowrap>&nbsp;</td>
    <td colspan="4" nowrap><table width="100%" border="1" cellpadding="3" cellspacing="0" class="table_data_mhs">
        <tr bgcolor="#C6E2FF"> 
          <td width="50%"><span class="style8">Status</span></td>
          <td width="20%"><span class="style8">Jumlah</span></td>
          <td colspan="2"><span class="style8">Prosentase</span></td>
        </tr>
        <tr> 
          <td nowrap>Menikah</td>
          <td nowrap><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $jumlah_menikah; ?></font></td>
          <td width="8%" nowrap><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo (string)round($jumlah_menikah/($jumlah_karyawan)*100)."%"; ?></font></td>
          <td width="22%" nowrap> 
            <?php
	if (($jumlah_karyawan>0)and($jumlah_menikah>0)) { 
	echo "<img border='1' style='background-color: #000000' src='../img/poll1.gif' height=10 width=".(string)round($jumlah_menikah/$jumlah_karyawan*60).">"; 
	}else { echo "&nbsp;";} ?>
          </td>
        </tr>
        <tr> 
          <td nowrap>Belum/Tidak Menikah</td>
          <td nowrap><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $jumlah_belum_menikah; ?></font></td>
          <td nowrap><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo (string)round($jumlah_belum_menikah/$jumlah_karyawan*100)."%"; ?></font></td>
          <td nowrap> 
            <?php
	if (($jumlah_karyawan>0)and($jumlah_belum_menikah>0)) { 
	echo "<img border='1' style='background-color: #000000' src='../img/poll2.gif' height=10 width=".(string)round($jumlah_belum_menikah/$jumlah_karyawan*60).">"; 
	}else { echo "&nbsp;";} ?>
          </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td colspan=5 nowrap>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan=4 nowrap> <strong><font color="#003399">Karyawan Berdasar Pendidikan</font></strong> 
    </td>
  </tr>
  <tr> 
    <td nowrap>&nbsp;</td>
    <td colspan="4" nowrap><table width="100%" border="1" cellpadding="3" cellspacing="0" class="table_data_mhs">
        <tr bgcolor="#C6E2FF"> 
          <td width="37%"><span class="style8"><strong>Pendidikan</strong></span></td>
          <td width="26%"><span class="style8">Jumlah</span></td>
          <td colspan="2"><span class="style8">Prosentase</span></td>
        </tr>
        <?php

		$result1 = @mysql_query("Select id, nama from pendidikan");
		$c=0;
		while ($row1=@mysql_fetch_array($result1))  {
		$c=$c+1;
		?>
        <tr> 
          <td nowrap><?php echo $row1["nama"]; ?></td>
          <?php $result2 = @mysql_query("Select Count(*) as jumlah from master_karyawan where pendidikan='".$row1["id"]."'"); 
		  $row2=@mysql_fetch_array($result2);?>
          <td nowrap><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $row2["jumlah"]; ?></font></td>
          <td width="6%" nowrap><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo (string)round($row2["jumlah"]/$jumlah_karyawan*100)."%"; ?></font></td>
          <td width="31%" nowrap> 
            <?php
	if (($jumlah_karyawan>0)and($row2["jumlah"]>0)) { 
	echo "<img border='1' style='background-color: #000000' src='../img/poll".$c.".gif' height=10 width=".(string)round($row2["jumlah"]/$jumlah_karyawan*60).">"; 
	}else { echo "&nbsp;";} ?>
          </td>
        </tr>
        <?php
			}
			
			?>
      </table></td>
  </tr>
  <?php

	$result1 = @mysql_query("Select id, nama from pendidikan");
	$c=0;
	while ($row1=@mysql_fetch_array($result1))  {
	$c=$c+1;
	?>
  <?php
	}
	
	?>
  <tr> 
    <td colspan=5 nowrap>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan=5 nowrap> <strong><font color="#003399">Dosen Berdasar Jabatan 
      Akademik</font></strong> </td>
  </tr>
  <tr> 
    <td nowrap>&nbsp;</td>
    <td colspan="4" nowrap><table width="100%" border="1" cellpadding="3" cellspacing="0" class="table_data_mhs">
        <tr bgcolor="#C6E2FF"> 
          <td width="48%" nowrap><span class="style8">Jabatan Akademik</span></td>
          <td width="21%"><span class="style8">Jumlah</span></td>
          <td colspan="2"><span class="style8">Prosentase</span></td>
        </tr>
        <?php
		$result1 = @mysql_query("Select id, nama from jabatan_akademik");
		
		//echo "Select Count(*) as jumlah from master_karyawan, karyawan_jenis_karyawan where karyawan_jenis_karyawan.id=master_karyawan.id_jenis and karyawan_jenis_karyawan.kategori='D' and id_jabatan='".$row1["id"]."'";
		
		$c=0;
		while ($row1=@mysql_fetch_array($result1))  {
		$c=$c+1;
		?>
        <tr> 
          <td nowrap><?php echo $row1["nama"]; ?></td>
          <?php $result2 = @mysql_query("Select Count(*) as jumlah from master_karyawan, karyawan_jenis_karyawan where karyawan_jenis_karyawan.id=master_karyawan.id_jenis and karyawan_jenis_karyawan.kategori='D' and id_jabatan='".$row1["id"]."'"); 
		  $row2=@mysql_fetch_array($result2);?>
          <td nowrap><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $row2["jumlah"]; ?></font></td>
          <td width="8%" nowrap><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo (string)round($row2["jumlah"]/$jumlah_dosen*100)."%"; ?></font></td>
          <td width="23%" nowrap> 
            <?php
	if (($jumlah_dosen>0)and($row2["jumlah"]>0)) { 
	echo "<img border='1' style='background-color: #000000' src='../img/poll".$c.".gif' height=10 width=".(string)round($row2["jumlah"]/$jumlah_dosen*60).">"; 
	}else { echo "&nbsp;";} ?>
          </td>
        </tr>
        <?php
			}
			
			?>
      </table></td>
  </tr>
  <?php
	$result1 = @mysql_query("Select id, nama from jabatan_akademik");

	//echo "Select Count(*) as jumlah from master_karyawan, karyawan_jenis_karyawan where karyawan_jenis_karyawan.id=master_karyawan.id_jenis and karyawan_jenis_karyawan.kategori='D' and id_jabatan='".$row1["id"]."'";

	$c=0;
	while ($row1=@mysql_fetch_array($result1))  {
	$c=$c+1;
	?>
  <?php
	}
	
	?>
  <tr> 
    <td colspan=5 nowrap>&nbsp;</td>
  </tr>
  <tr> 
    <td colspan=5 nowrap> <strong><font color="#003399">Dosen Berdasar Kepangkatan 
      Terakhir</font></strong> </td>
  </tr>
  <tr> 
    <td nowrap>&nbsp;</td>
    <td colspan="4" nowrap><table width="100%" border="1" cellpadding="3" cellspacing="0" class="table_data_mhs">
        <tr bgcolor="#C6E2FF"> 
          <td width="40%" nowrap><span class="style8">Kepangkatan</span></td>
          <td width="24%"><span class="style8">Jumlah</span></td>
          <td colspan="2"><span class="style8">Prosentase</span></td>
        </tr>
        <?php
		$result1 = @mysql_query("Select id, nama from kepangkatan");
		
		
		$c=0;
		while ($row1=@mysql_fetch_array($result1))  {
		
		?>
        <?php $result2 = @mysql_query("Select Count(*) as jumlah from master_karyawan, karyawan_jenis_karyawan where karyawan_jenis_karyawan.id=master_karyawan.id_jenis and karyawan_jenis_karyawan.kategori='D' and id_pangkat='".$row1["id"]."'"); 
		$row2=@mysql_fetch_array($result2);
		if ($row2["jumlah"]>0) {$c=$c+1;
		?>
        <tr> 
          <td nowrap><?php echo $row1["nama"]; ?></td>
          <td nowrap><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo $row2["jumlah"]; ?></font></td>
          <td width="8%" nowrap><font face="Georgia, Times New Roman, Times, serif" color="#FF0000"><?php echo (string)round($row2["jumlah"]/$jumlah_dosen*100)."%"; ?></font></td>
          <td width="28%" nowrap> 
            <?php
	if (($jumlah_dosen>0)and($row2["jumlah"]>0)) { 
	echo "<img border='1' style='background-color: #000000' src='../img/poll".$c.".gif' height=10 width=".(string)round($row2["jumlah"]/$jumlah_dosen*60).">"; 
	}else { echo "&nbsp;";} ?>
          </td>
        </tr>
        <?php
		  } // jika jumlah > 0
	}
	
	?>
      </table></td>
  </tr>
  <tr> 
    <td nowrap>&nbsp;</td>
    <td width="33%" nowrap>&nbsp;</td>
    <td width="29%" nowrap>&nbsp;</td>
    <td width="68%" colspan=2 nowrap>&nbsp;</td>
  </tr>
  <?php
	$result1 = @mysql_query("Select id, nama from kepangkatan");


	$c=0;
	while ($row1=@mysql_fetch_array($result1))  {
	
	?>
  <?php $result2 = @mysql_query("Select Count(*) as jumlah from master_karyawan, karyawan_jenis_karyawan where karyawan_jenis_karyawan.id=master_karyawan.id_jenis and karyawan_jenis_karyawan.kategori='D' and id_pangkat='".$row1["id"]."'"); 
		  $row2=@mysql_fetch_array($result2);
		  if ($row2["jumlah"]>0) {$c=$c+1;
		  ?>
  <?php
		  } // jika jumlah > 0
	}
	
	?>
</table>
</body>
</html>