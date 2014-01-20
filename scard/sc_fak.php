<?
/* 
   DATE CREATED : 08/11/08
   UPDATE  		: 08/01/09 - penambahan field tahun untuk target per tahun  
   KEGUNAAN     : ENTRY target scorecard fakultas
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
		// data USER tidak ada, berarti tambah baru
			if ($frm_exist!=1) 
				{
					$result = mysql_query("INSERT INTO sc_fak (`id`, `tahun` , `LD1`, `SUS1`, `SUS2`, `SUS3`, `SUS4`, `PRO1`, 
					`PRO2`, `PRO3`, `PRO4`, `PRO5`, `MAN1`,`MAN2`, `PN1`) VALUES 
					( NULL, ".$frm_thn.", $frm_sc_fak_LD1, $frm_sc_fak_S1, $frm_sc_fak_S2, $frm_sc_fak_S3, $frm_sc_fak_S4, $frm_sc_fak_P1, 
					$frm_sc_fak_P2, $frm_sc_fak_P3, $frm_sc_fak_P4, $frm_sc_fak_P5, $frm_sc_fak_M1, $frm_sc_fak_M2, $frm_sc_fak_PN1) " );
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah ditambahkan";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data". mysql_error();
						}
						
				}
			else
				{
				/*
					echo "<br>UPDATE";
					echo "<br>id_sc_fak=".$id_sc_fak;
					echo "<br>frm_id_sc_fak=".$frm_id_sc_fak;
					echo "<br>frm_exist=".$frm_exist;
					echo "<br>frm_sc_fak_S1=".$frm_sc_fak_S1;
					echo "<br>frm_sc_fak_S2=".$frm_sc_fak_S2;
					echo "<br>frm_sc_fak_S3=".$frm_sc_fak_S3;
					echo "<br>frm_sc_fak_S4=".$frm_sc_fak_S4;
					echo "<br>frm_sc_fak_P1=".$frm_sc_fak_P1;
					echo "<br>frm_sc_fak_P2=".$frm_sc_fak_P2;
					echo "<br>frm_sc_fak_P3=".$frm_sc_fak_P3;
					echo "<br>frm_sc_fak_P4=".$frm_sc_fak_P4;
					echo "<br>frm_sc_fak_P5=".$frm_sc_fak_P5;
					echo "<br>frm_sc_fak_M1=".$frm_sc_fak_M1;
					echo "<br>frm_sc_fak_M2=".$frm_sc_fak_M2;
					echo "<br>frm_sc_fak_PN1=".$frm_sc_fak_PN1;*/
					$result = mysql_query("UPDATE sc_fak SET `LD1` = $frm_sc_fak_LD1, 
															 `SUS1` = $frm_sc_fak_S1, 
															 `SUS2` = $frm_sc_fak_S2, 
															 `SUS3` = $frm_sc_fak_S3, 
															 `SUS4` = $frm_sc_fak_S4, 
															 `PRO1` = $frm_sc_fak_P1, 
															 `PRO2` = $frm_sc_fak_P2, 
															 `PRO3` = $frm_sc_fak_P3, 
															 `PRO4` = $frm_sc_fak_P4, 
															 `PRO5` = $frm_sc_fak_P5, 
															 `MAN1` = $frm_sc_fak_M1,
															 `MAN2` = $frm_sc_fak_M2, 
															 `PN1` = $frm_sc_fak_PN1 
													   WHERE  tahun = $frm_thn");
	
					if ($result) 
					{
						$pesan = $pesan."<br>Data telah diubah.";	
					}
					else
					{ 
						$pesan = $pesan."<br>Gagal menyimpan data-".mysql_error();
					}
			}
				
		}
}

/*if ($act==2) { // hapus data

$result = mysql_query("DELETE FROM sc_fak WHERE id = ".$id_sc_fak);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}*/
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) 
{
	//$frm_id_sc_fak="";
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
//echo "<br>frm_kode=".$frm_kode;
				//if (($frm_id_tahun_ajar!=0) and ($frm_jurusan!=NULL) and ($frm_angkatan!=NULL)){
	   // echo "<br>frm_thn=".$frm_thn;
		if (isset($frm_thn)) {
						$result = mysql_query("SELECT *
												 FROM sc_fak
												WHERE tahun=$frm_thn");
				
						if ($row = mysql_fetch_array($result)) {
							$frm_exist=1;
							$frm_sc_fak_LD1=$row["LD1"];
							$frm_sc_fak_S1=$row["SUS1"];
							$frm_sc_fak_S2=$row["SUS2"];
							$frm_sc_fak_S3=$row["SUS3"];
							$frm_sc_fak_S4=$row["SUS4"];
							$frm_sc_fak_P1=$row["PRO1"];
							$frm_sc_fak_P2=$row["PRO2"];
							$frm_sc_fak_P3=$row["PRO3"];
							$frm_sc_fak_P4=$row["PRO4"];
							$frm_sc_fak_P5=$row["PRO5"];
							$frm_sc_fak_M1=$row["MAN1"];
							$frm_sc_fak_M2=$row["MAN2"];
							$frm_sc_fak_PN1=$row["PN1"];
							echo "<br>H E R E";
						}
						else
						{
							$frm_exist=0;
							$frm_id_sc_fak=1;
							$frm_sc_fak_LD1=0;
							$frm_sc_fak_S1=0;
							$frm_sc_fak_S2=0;
							$frm_sc_fak_S3=0;
							$frm_sc_fak_S4=0;
							$frm_sc_fak_P1=0;
							$frm_sc_fak_P2=0;
							$frm_sc_fak_P3=0;
							$frm_sc_fak_P4=0;
							$frm_sc_fak_P5=0;
							$frm_sc_fak_M1=0;
							$frm_sc_fak_M2=0;
							$frm_sc_fak_PN1=0;
							//$frm_jum_mhs_aktif="";
							//$frm_jum_mhs_do="";
						}
		}
						//$tahun=substr($frm_id_tahun_ajar, 0,4); 
						//$semester=substr($frm_id_tahun_ajar, 4,1);
					//}
}
//echo "<br>frm_id_tahun_ajar=".$frm_id_tahun_ajar; 
//echo "<br>frm_jurusan=".$frm_jurusan; 
//echo "<br>frm_id_do=".$frm_id_do;
//echo "<br>frm_exist=".$frm_exist;

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
<form name="form_sc_fak" id="form_sc_fak" action="sc_fak.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="body">
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4"> <hr size="1" color="#FF9900">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="89%">
				<font color="#0099CC" size="1">
				<? if ($frm_id_sc_fak!=''){?>
					<strong>EDIT DATA ~ </strong>
				<? } else
				{?>
					<strong>ENTRY DATA ~ </strong>
				<? }?>
				TARGET SCORECARD FAKULTAS</font></td>
            <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">SCORE CARD</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
	<td>
	
	<table width="80%"  border="0" align="center" cellpadding="3" cellspacing="1">
<tr>
  <td colspan="2" bgcolor="dddddd">Tahun</td>
  <td bgcolor="dddddd"><div align="center"><strong>:</strong></div></td>
  <td bgcolor="dddddd">
  <select name="frm_thn" id="frm_thn" class="tekboxku" onChange="document.form_sc_fak.submit();" >
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
  </select></td>
</tr>
<tr>
      <td width="3%">&nbsp;</td> 
      <td width="52%"><? //echo "<br>frm_id_sc_fak=".$frm_id_sc_fak;?></td>
      <td width="8%">&nbsp;</td>
      <td width="36%">
		  <input type="hidden" name="frm_id_sc_fak" id="frm_id_sc_fak" value="<?php echo $frm_id_sc_fak;?>">
		  <input type="hidden" name="frm_exist" id="frm_exist" value="<?php echo $frm_exist;?>">
	  </td>
    </tr>
    <tr>
	<td valign="top">&nbsp;</td>
      <td> <strong>Isu Strategis: Learning &amp; Discovery </strong> </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" bgcolor="dddddd">1.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD1]</span> Rata-rata indeks pembelajaran per jurusan(dosen tetap) </td>
      <td bgcolor="dddddd"><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_fak_LD1" id="frm_sc_fak_LD1" value="<? echo $frm_sc_fak_LD1;?>" type="text" class="tekboxku" size="10" maxlength="10" >
      </font>
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td nowrap>&nbsp;</td>
      <td><div align="center"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
	  <td valign="top">&nbsp;</td>
      <td> <strong>Isu Strategis: Sustainability </strong> </td>
      <td><div align="center"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" bgcolor="dddddd">2.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[S1]</span> Jumlah dana penelitian dari pihak eksternal </td>
      <td bgcolor="dddddd"><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd">
<font color="#FF0000">
<input name="frm_sc_fak_S1" id="frm_sc_fak_S1" onKeyPress="return cek_digit(event)"  value="<? echo $frm_sc_fak_S1;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*</font>	  </td>
    </tr>
    <tr>
      <td valign="top" bgcolor="dddddd">3.</td> 
      <td bgcolor="dddddd"> <span class="style1">[S2]</span> Produktivitas dana = income (revenue – direct cost) / S direct employee</td>
      <td bgcolor="dddddd"><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"> <font color="#FF0000">
        <input name="frm_sc_fak_S2" id="frm_sc_fak_S2" onKeyPress="return cek_digit(event)" value="<? echo $frm_sc_fak_S2;?>" type="text" class="tekboxku" size="10" maxlength="10" >
      *</font></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="dddddd">4.</td>
      <td bgcolor="dddddd"> <span class="style1">[S3]</span> % non-tuition fee = revenue berbasis kegiatan tri-dharma di luar tuition fee / S revenue total </td>
      <td bgcolor="dddddd"><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><input name="frm_sc_fak_S3" type="text" onKeyPress="return cek_digit(event)" class="tekboxku" id="frm_sc_fak_S3" value="<?php echo $frm_sc_fak_S3; ?>" size="10" maxlength="10" >
      <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="dddddd">5.</td>
      <td bgcolor="dddddd"> <span class="style1">[S4]</span> Jumlah mahasiswa baru </td>
      <td bgcolor="dddddd"><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><input name="frm_sc_fak_S4" type="text" onKeyPress="return cek_digit(event)" class="tekboxku" id="frm_sc_fak_S4" value="<?php echo $frm_sc_fak_S4; ?>" size="10" maxlength="10" >
      <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
	  <td valign="top">&nbsp;</td>
      <td colspan="2"> <strong>Isu Strategis: Promotion </strong> </td>
      <td>&nbsp;</td>
      <td width="1%">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" bgcolor="dddddd">6.</td>
      <td bgcolor="dddddd"> <span class="style1">[P1]</span> Partisipasi mahasiswa dalam kegiatan ilmiah nasional </td>
      <td bgcolor="dddddd"><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><input name="frm_sc_fak_P1" type="text" onKeyPress="return cek_digit(event)" class="tekboxku" id="frm_sc_fak_P1" value="<?php echo $frm_sc_fak_P1; ?>" size="10" maxlength="10" >
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="dddddd">7.</td>
      <td bgcolor="dddddd"> <span class="style1">[P2]</span> Partisipasi mahasiswa dalam kegiatan ilmiah internasional </td>
      <td bgcolor="dddddd"><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><input name="frm_sc_fak_P2" type="text" onKeyPress="return cek_digit(event)" class="tekboxku" id="frm_sc_fak_P2" value="<?php echo $frm_sc_fak_P2; ?>" size="10" maxlength="10" >
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="dddddd">8.</td>
      <td bgcolor="dddddd"> <span class="style1">[P3] </span>Prestasi mahasiswa dalam kegiatan ilmiah nasional </td>
      <td bgcolor="dddddd"><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><input name="frm_sc_fak_P3" type="text" onKeyPress="return cek_digit(event)" class="tekboxku" id="frm_sc_fak_P3" value="<?php echo $frm_sc_fak_P3; ?>" size="10" maxlength="10" >
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="dddddd">9.</td>
      <td bgcolor="dddddd"> <span class="style1">[P4]</span> Prestasi mahasiswa dalam kegiatan ilmiah internasional </td>
      <td bgcolor="dddddd"><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><input name="frm_sc_fak_P4" type="text" onKeyPress="return cek_digit(event)" class="tekboxku" id="frm_sc_fak_P4" value="<?php echo $frm_sc_fak_P4; ?>" size="10" maxlength="10" >
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="dddddd">10.</td>
      <td bgcolor="dddddd"> <span class="style1">[P5]</span> Jumlah buku yang ditulis dosen dan diterbitkan </td>
      <td bgcolor="dddddd"><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><input name="frm_sc_fak_P5" type="text" onKeyPress="return cek_digit(event)" class="tekboxku" id="frm_sc_fak_P5" value="<?php echo $frm_sc_fak_P5; ?>" size="10" maxlength="10" >
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
	  <td valign="top">&nbsp;</td>
      <td> <strong>Isu Strategis: Management </strong> </td>
      <td><div align="center"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" bgcolor="dddddd">11.</td>
      <td bgcolor="dddddd"> <span class="style1">[M1]</span> <img src="../img/sigma.gif" width="10" height="12" align="absbottom"> dosen S3 : <img src="../img/sigma.gif" width="10" height="12" align="absbottom"> dosen </td>
      <td bgcolor="dddddd"><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><input name="frm_sc_fak_M1" type="text" class="tekboxku" id="frm_sc_fak_M1" value="<?php echo $frm_sc_fak_M1; ?>" size="10" maxlength="10" >
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="dddddd">12.</td>
      <td bgcolor="dddddd"> <span class="style1">[M2]</span> Tingkat kepuasan layanan administrasi </td>
      <td bgcolor="dddddd"><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><input name="frm_sc_fak_M2" type="text" class="tekboxku" id="frm_sc_fak_M2" value="<?php echo $frm_sc_fak_M2; ?>" size="10" maxlength="10" >
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
	  <td valign="top">&nbsp;</td>
      <td> <strong>Isu Strategis: Partnership &amp; Networking </strong> </td>
      <td><div align="center"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" bgcolor="dddddd">13.</td>
      <td bgcolor="dddddd"> <span class="style1">[PN1]</span> Jumlah kerjasama </td>
      <td bgcolor="dddddd"><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><input name="frm_sc_fak_PN1" type="text" onKeyPress="return cek_digit(event)" class="tekboxku" id="frm_sc_fak_PN1" value="<?php echo $frm_sc_fak_PN1; ?>" size="10" maxlength="10" >
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
		<input name="Submit" type="submit" class="tombol" onClick="this.form.action+='?act=1';this.form.submit();" value="Simpan">
		<input name="Submit2" type="reset" class="tombol" disabled onClick="this.form.action+='?act=3';this.form.submit();" value="Batal">
		<?php if ($frm_id_do) { ?>
		<input name="Submit3" type="button" class="tombol"   disabled  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id_sc_fak=<?php echo $frm_id_sc_fak;?>';this.form.submit()};" value="Hapus">
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