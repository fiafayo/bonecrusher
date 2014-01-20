<?
/* 
   DATE CREATED : 11/12/08
   UPDATE  		: 09/01/09 - penambahan field tahun untuk target per tahun 
   KEGUNAAN     : ENTRY target ScoreCard Personal
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");
require("../include/js_function.js");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ 
	if ($error==1) 
		{
			$pesan=$pesan."<br>Gagal menyimpan data.";
		}
		
	if ($error !=1) // Jika semua isian form valid 
		{
				if ($frm_exist!=1) 
				{
					$result = mysql_query("INSERT INTO sc_per (`id`, `tahun` , `LD1`, `LD2`, `LD3`, `LD4`, `LD5`, `LD6`) VALUES 
					( NULL, ".$frm_thn.", $frm_sc_lab_LD1, $frm_sc_lab_LD2, $frm_sc_lab_LD3, 
					$frm_sc_lab_LD4, $frm_sc_lab_LD5, $frm_sc_lab_LD6) " );
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah ditambahkan";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data - ". mysql_error();
						}
						
				}
			    else
				{
				/*
					echo "<br>UPDATE";
					echo "<br>id_sc_personal=".$id_sc_personal;
					echo "<br>frm_id_sc_personal=".$frm_id_sc_personal;
					echo "<br>frm_exist=".$frm_exist;
					echo "<br>frm_sc_personal_S1=".$frm_sc_personal_S1;
					echo "<br>frm_sc_personal_S2=".$frm_sc_personal_S2;
					echo "<br>frm_sc_personal_S3=".$frm_sc_personal_S3;
					echo "<br>frm_sc_personal_S4=".$frm_sc_personal_S4;
					echo "<br>frm_sc_personal_P1=".$frm_sc_personal_P1;
					echo "<br>frm_sc_personal_P2=".$frm_sc_personal_P2;
					echo "<br>frm_sc_personal_P3=".$frm_sc_personal_P3;
					echo "<br>frm_sc_personal_P4=".$frm_sc_personal_P4;
					echo "<br>frm_sc_personal_P5=".$frm_sc_personal_P5;
					echo "<br>frm_sc_personal_M1=".$frm_sc_personal_M1;
					echo "<br>frm_sc_personal_M2=".$frm_sc_personal_M2;
					echo "<br>frm_sc_personal_PN1=".$frm_sc_personal_PN1;*/
					$result = mysql_query("UPDATE sc_per SET `LD1` = $frm_sc_personal_LD1,
														     `LD2` = $frm_sc_personal_LD2, 
														     `LD3` = $frm_sc_personal_LD3, 
														     `LD4` = $frm_sc_personal_LD4, 
														     `LD5` = $frm_sc_personal_LD5, 
														     `LD6` = $frm_sc_personal_LD6
													   WHERE  tahun = $frm_thn");
	
					if ($result) 
					{
						$pesan = $pesan."<br>Data telah diubah.";	
					}
					else
					{ 
						$pesan = $pesan."<br>Gagal menyimpan data - ".mysql_error();
					}
				}
				
		}
}

/*if ($act==2) { // hapus data

$result = mysql_query("DELETE FROM sc_fak WHERE id = ".$id_sc_personal);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}*/
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) 
{
	//$frm_id_sc_personal="";
	//$frm_jurusan=0;
	//$frm_id_tahun_ajar=0;
	//$frm_angkatan ="";
	//$frm_jum_mhs_aktif="";
	//$frm_jum_mhs_do="";
	//$frm_id_tipe="";
	//$jum=0;
}
else
{
//echo "HERE";
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
		//echo "<br>frm_thn=".$frm_thn;
		if (isset($frm_thn)) 
		{						
		                $result = mysql_query("SELECT *
												 FROM sc_per
												WHERE tahun=$frm_thn");
				
						if ($row = mysql_fetch_array($result)) {
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
		}
}

?>
<html>
<head>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../include/tanggalan.js">
</script>
<style type="text/css">
<!--
.style1 {
	font-size: 9px;
	font-weight: bold;
}
-->
</style>
</head>
<body class="body">
<form name="form_sc_personal" id="form_sc_personal" action="sc_personal.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4"> <hr size="1" color="#FF9900">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="89%">
				<font color="#0099CC" size="1">
				<? if ($frm_id_sc_personal!=''){?>
					<strong>EDIT DATA ~ </strong>
				<? } else
				{?>
					<strong>ENTRY DATA ~ </strong>
				<? }?>
				TARGET SCORECARD PERSONAL </font></td>
            <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">SCORE CARD</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
	<td>
	<table width="80%"  border="0" align="center" cellpadding="3" cellspacing="1">
<tr bgcolor="dddddd">
  <td colspan="2" valign="top">Tahun</td>
  <td><div align="center"><strong>:</strong></div></td>
  <td>
	  <select name="frm_thn" id="frm_thn" class="tekboxku" onChange="document.form_sc_personal.submit();" >
		<option value="">--Pilih tahun--</option>
		<option value="2007" <? if ($frm_thn==2007) echo "selected"?> >2007</option>
		<option value="2008" <? if ($frm_thn==2008) echo "selected"?> >2008</option>
		<option value="2009" <? if ($frm_thn==2009) echo "selected"?> >2009</option>
		<option value="2010" <? if ($frm_thn==2010) echo "selected"?> >2010</option>
		<option value="2011" <? if ($frm_thn==2011) echo "selected"?> >2011</option>
		<option value="2012" <? if ($frm_thn==2012) echo "selected"?> >2012</option>
		<option value="2013" <? if ($frm_thn==2013) echo "selected"?> >2013</option>
		<option value="2014" <? if ($frm_thn==2014) echo "selected"?> >2014</option>
		<option value="2015" <? if ($frm_thn==2015) echo "selected"?> >2015</option>
	  </select>
  </td>
</tr>
<tr>
      <td width="3%" valign="top">&nbsp;</td> 
      <td width="53%"><? //echo "<br>frm_id_sc_personal=".$frm_id_sc_personal;?></td>
      <td width="5%"><div align="center"></div></td>
      <td width="39%">
		  <input type="hidden" name="frm_id_sc_personal" id="frm_id_sc_personal" value="<?php echo $frm_id_sc_personal;?>">
		  <input type="hidden" name="frm_exist" id="frm_exist" value="<?php echo $frm_exist;?>">
	  </td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td nowrap> <strong>Isu Strategis: Learning &amp; Discovery </strong> </td>
      <td><div align="center"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">1.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD1]</span> Jumlah penelitian dosen</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_personal_LD1" id="frm_sc_personal_LD1" onKeyPress="return cek_digit(event)" value="<? echo $frm_sc_personal_LD1;?>" type="text" class="tekboxku" size="10" maxlength="10" >
      </font>
        <font color="#FF0000">*</font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">2.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD2]</span> Jumlah publikasi jurnal nasional terakreditasi</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_personal_LD2" id="frm_sc_personal_LD2" onKeyPress="return cek_digit(event)" value="<? echo $frm_sc_personal_LD2;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">3.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD3]</span> Jumlah publikasi prosiding nasional</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_personal_LD3" id="frm_sc_personal_LD3" onKeyPress="return cek_digit(event)" value="<? echo $frm_sc_personal_LD3;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">4.</td>
      <td nowrap bgcolor="dddddd"> <span class="style1">[LD4]</span> Jumlah layanan industri </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_personal_LD4" id="frm_sc_personal_LD4" onKeyPress="return cek_digit(event)" value="<? echo $frm_sc_personal_LD4;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">5.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD5]</span> Jumlah grant yang diterima</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_personal_LD5" id="frm_sc_personal_LD5" onKeyPress="return cek_digit(event)" value="<? echo $frm_sc_personal_LD5;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">6.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD6]</span> Rata-rata Indeks Pembelajaran per Jurusan (dosen tetap)</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_personal_LD6" id="frm_sc_personal_LD6"  value="<? echo $frm_sc_personal_LD6;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td nowrap>&nbsp;</td>
      <td><div align="center"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td> 
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
      <td>
		<input name="Submit" type="submit" class="tombol" onClick="this.form.action+='?act=1';this.form.submit();" value="Simpan">
		<input name="Submit2" type="reset" class="tombol" disabled onClick="this.form.action+='?act=3';this.form.submit();" value="Batal">
		<?php if ($frm_id_do) { ?>
		<input name="Submit3" type="button" class="tombol"   disabled  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id_sc_personal=<?php echo $frm_id_sc_personal;?>';this.form.submit()};" value="Hapus">
		<?php } ?>
	  </td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" size="1">*</font><font size="1"> = 
        compulsory / harus diisi</font></td>
    </tr>
	</table>

	</td>
	</tr>
  </table>
</form>
</body>
</html>