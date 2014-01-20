<?
/* 
   DATE CREATED : 08/11/08
   UPDATE  		: 09/01/09 - penambahan field tahun untuk target per tahun 
   KEGUNAAN     : ENTRY target ScoreCard Jurusan
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
					$result = mysql_query("INSERT INTO sc_jur (`id`, `tahun` , `jurusan`, `LD1`, `LD2`, `LD3`, `LD4`, `LD5`, `LD6`, `LD7`, `LD8`, `LD9`,
					`LD10`, `LD11`, `LD12`, `LD13`, `LD14`, `LD15`, `LD16`, `LD17`, 
					`SUS1`, `SUS2`, `SUS3`, `SUS4`, 
					`PRO1`, `PRO2`, `PRO3`, `PRO4`, `PRO5`, `PRO6`,
					`MAN1`,`MAN2`, 
					`PN1`) VALUES ( NULL, ".$frm_thn.", $frm_jurusan, $frm_sc_jur_LD1, $frm_sc_jur_LD2, $frm_sc_jur_LD3, $frm_sc_jur_LD4, $frm_sc_jur_LD5,
					 $frm_sc_jur_LD6, $frm_sc_jur_LD7, $frm_sc_jur_LD8, $frm_sc_jur_LD9, $frm_sc_jur_LD10, $frm_sc_jur_LD11, $frm_sc_jur_LD12,
					 $frm_sc_jur_LD13, $frm_sc_jur_LD14, $frm_sc_jur_LD15, $frm_sc_jur_LD16, $frm_sc_jur_LD17,
					 $frm_sc_jur_S1, $frm_sc_jur_S2, $frm_sc_jur_S3, $frm_sc_jur_S4, 
					 $frm_sc_jur_P1, $frm_sc_jur_P2, $frm_sc_jur_P3, $frm_sc_jur_P4, $frm_sc_jur_P5, $frm_sc_jur_P6,
					 $frm_sc_jur_M1, $frm_sc_jur_M2, 
					 $frm_sc_jur_PN1) " );
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
					echo "<br>id_sc_jur=".$id_sc_jur;
					echo "<br>frm_id_sc_jur=".$frm_id_sc_jur;
					echo "<br>frm_exist=".$frm_exist;
					echo "<br>frm_sc_jur_S1=".$frm_sc_jur_S1;
					echo "<br>frm_sc_jur_S2=".$frm_sc_jur_S2;
					echo "<br>frm_sc_jur_S3=".$frm_sc_jur_S3;
					echo "<br>frm_sc_jur_S4=".$frm_sc_jur_S4;
					echo "<br>frm_sc_jur_P1=".$frm_sc_jur_P1;
					echo "<br>frm_sc_jur_P2=".$frm_sc_jur_P2;
					echo "<br>frm_sc_jur_P3=".$frm_sc_jur_P3;
					echo "<br>frm_sc_jur_P4=".$frm_sc_jur_P4;
					echo "<br>frm_sc_jur_P5=".$frm_sc_jur_P5;
					echo "<br>frm_sc_jur_M1=".$frm_sc_jur_M1;
					echo "<br>frm_sc_jur_M2=".$frm_sc_jur_M2;
					echo "<br>frm_sc_jur_PN1=".$frm_sc_jur_PN1;*/
					$result = mysql_query("UPDATE sc_jur SET `LD1` = $frm_sc_jur_LD1,
															 `LD2` = $frm_sc_jur_LD2, 
															 `LD3` = $frm_sc_jur_LD3, 
															 `LD4` = $frm_sc_jur_LD4, 
															 `LD5` = $frm_sc_jur_LD5, 
															 `LD6` = $frm_sc_jur_LD6, 
															 `LD7` = $frm_sc_jur_LD7, 
															 `LD8` = $frm_sc_jur_LD8, 
															 `LD9` = $frm_sc_jur_LD9, 
															 `LD10` = $frm_sc_jur_LD10, 
															 `LD11` = $frm_sc_jur_LD11, 
															 `LD12` = $frm_sc_jur_LD12, 
															 `LD13` = $frm_sc_jur_LD13, 
															 `LD14` = $frm_sc_jur_LD14, 
															 `LD15` = $frm_sc_jur_LD15, 
															 `LD16` = $frm_sc_jur_LD16, 
															 `LD17` = $frm_sc_jur_LD17,
															 `SUS1` = $frm_sc_jur_S1, 
															 `SUS2` = $frm_sc_jur_S2, 
															 `SUS3` = $frm_sc_jur_S3, 
															 `SUS4` = $frm_sc_jur_S4, 
															 `PRO1` = $frm_sc_jur_P1, 
															 `PRO2` = $frm_sc_jur_P2, 
															 `PRO3` = $frm_sc_jur_P3, 
															 `PRO4` = $frm_sc_jur_P4, 
															 `PRO5` = $frm_sc_jur_P5, 
															 `PRO6` = $frm_sc_jur_P6, 
															 `MAN1` = $frm_sc_jur_M1,
															 `MAN2` = $frm_sc_jur_M2, 
															 `PN1` = $frm_sc_jur_PN1 
													   WHERE tahun = $frm_thn AND jurusan=$frm_jurusan");
	
					if ($result) 
					{
						$pesan = $pesan."<br>Data telah diubah.";	
					}
					else
					{ 
						$pesan = $pesan."<br>Gagal mengubah data-".mysql_error();
					}
			 }
				
		}
}

/*if ($act==2) { // hapus data

$result = mysql_query("DELETE FROM sc_fak WHERE id = ".$id_sc_jur);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}*/
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) 
{
	//$frm_id_sc_jur="";
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
	    //echo "<br>frm_thn=".$frm_thn;
		if (isset($frm_thn)) 
		{
						$result = mysql_query("SELECT *
												 FROM sc_jur
												WHERE tahun=$frm_thn AND jurusan=$frm_jurusan");
				
						if ($row = mysql_fetch_array($result)) {
							$frm_exist=1;
							$frm_id_sc_jur=1;
							$frm_sc_jur_LD1=$row["LD1"];
							$frm_sc_jur_LD2=$row["LD2"];
							$frm_sc_jur_LD3=$row["LD3"];
							$frm_sc_jur_LD4=$row["LD4"];
							$frm_sc_jur_LD5=$row["LD5"];
							$frm_sc_jur_LD6=$row["LD6"];
							$frm_sc_jur_LD7=$row["LD7"];
							$frm_sc_jur_LD8=$row["LD8"];
							$frm_sc_jur_LD9=$row["LD9"];
							$frm_sc_jur_LD10=$row["LD10"];
							$frm_sc_jur_LD11=$row["LD11"];
							$frm_sc_jur_LD12=$row["LD12"];
							$frm_sc_jur_LD13=$row["LD13"];
							$frm_sc_jur_LD14=$row["LD14"];
							$frm_sc_jur_LD15=$row["LD15"];
							$frm_sc_jur_LD16=$row["LD16"];
							$frm_sc_jur_LD17=$row["LD17"];
							
							$frm_sc_jur_S1=$row["SUS1"];
							$frm_sc_jur_S2=$row["SUS2"];
							$frm_sc_jur_S3=$row["SUS3"];
							$frm_sc_jur_S4=$row["SUS4"];
							
							$frm_sc_jur_P1=$row["PRO1"];
							$frm_sc_jur_P2=$row["PRO2"];
							$frm_sc_jur_P3=$row["PRO3"];
							$frm_sc_jur_P4=$row["PRO4"];
							$frm_sc_jur_P5=$row["PRO5"];
							$frm_sc_jur_P6=$row["PRO6"];
							$frm_sc_jur_M1=$row["MAN1"];
							$frm_sc_jur_M2=$row["MAN2"];
							$frm_sc_jur_PN1=$row["PN1"];
						}
						else
						{
							$frm_exist=0;
							$frm_sc_jur_LD1=0;
							$frm_sc_jur_LD2=0;
							$frm_sc_jur_LD3=0;
							$frm_sc_jur_LD4=0;
							$frm_sc_jur_LD5=0;
							$frm_sc_jur_LD6=0;
							$frm_sc_jur_LD7=0;
							$frm_sc_jur_LD8=0;
							$frm_sc_jur_LD9=0;
							$frm_sc_jur_LD10=0;
							$frm_sc_jur_LD11=0;
							$frm_sc_jur_LD12=0;
							$frm_sc_jur_LD13=0;
							$frm_sc_jur_LD14=0;
							$frm_sc_jur_LD15=0;
							$frm_sc_jur_LD16=0;
							$frm_sc_jur_LD17=0;
							
							$frm_sc_jur_S1=0;
							$frm_sc_jur_S2=0;
							$frm_sc_jur_S3=0;
							$frm_sc_jur_S4=0;
							
							$frm_sc_jur_P1=0;
							$frm_sc_jur_P2=0;
							$frm_sc_jur_P3=0;
							$frm_sc_jur_P4=0;
							$frm_sc_jur_P5=0;
							$frm_sc_jur_P6=0;
							$frm_sc_jur_M1=0;
							$frm_sc_jur_M2=0;
							$frm_sc_jur_PN1=0;
						}
						//$tahun=substr($frm_id_tahun_ajar, 0,4); 
						//$semester=substr($frm_id_tahun_ajar, 4,1);
		}
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
<form name="form_sc_jur" id="form_sc_jur" action="sc_jur.php" method="post">
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
				<? if ($frm_id_sc_jur!=''){?>
					<strong>EDIT DATA ~ </strong>
				<? } else
				{?>
					<strong>ENTRY DATA ~ </strong>
				<? }?>
				TARGET SCORECARD JURUSAN</font></td>
            <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">SCORE CARD</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
	<td>
	<table width="80%"  border="0" align="center" cellpadding="3" cellspacing="1">
<tr bgcolor="#DDDDDD">
  <td colspan="2" valign="top">Tahun</td>
  <td><div align="center"><strong>:</strong></div></td>
  <td><select name="frm_thn" id="frm_thn" class="tekboxku">
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
<tr bgcolor="#DDDDDD">
  <td colspan="2" valign="top">Jurusan</td>
  <td><div align="center"><strong>:</strong></div></td>
  <td><select name="frm_jurusan" id="frm_jurusan" class="tekboxku" onChange="document.form_sc_jur.submit();" >
    <option value="0" <?php if ($frm_jurusan==''){echo "selected";}?>>--- Pilih ---</option>
    <?php 
				$sql_jurusan="SELECT * FROM jurusan WHERE id>0 AND id<5";
				$result = @mysql_query($sql_jurusan);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
    <option value="<?php echo $row->id; ?>" <?php if ($frm_jurusan==$row->id) { echo "selected"; }?>> <?php echo $row->jurusan; ?></option>
    <?php
				}
				?>
  </select></td>
</tr>
<tr>
      <td width="3%" valign="top">&nbsp;</td> 
      <td width="53%"><? //echo "<br>frm_id_sc_jur=".$frm_id_sc_jur;?></td>
      <td width="5%"><div align="center"></div></td>
      <td width="39%">
		  <input type="hidden" name="frm_id_sc_jur" id="frm_id_sc_jur" value="<?php echo $frm_id_sc_jur;?>">
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
        <input name="frm_sc_jur_LD1" id="frm_sc_jur_LD1" onKeyPress="return cek_digit(event)" value="<? echo $frm_sc_jur_LD1;?>" type="text" class="tekboxku" size="10" maxlength="10" >
      </font>
        <font color="#FF0000">*</font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">2.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD2]</span> Jumlah publikasi jurnal nasional terakreditasi</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_jur_LD2" id="frm_sc_jur_LD2" onKeyPress="return cek_digit(event)" value="<? echo $frm_sc_jur_LD2;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">3.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD3]</span> Jumlah publikasi jurnal internasional</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_jur_LD3" id="frm_sc_jur_LD3" onKeyPress="return cek_digit(event)" value="<? echo $frm_sc_jur_LD3;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">4.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD4]</span> Jumlah publikasi prosiding nasional</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_jur_LD4" id="frm_sc_jur_LD4" onKeyPress="return cek_digit(event)" value="<? echo $frm_sc_jur_LD4;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">5.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD5]</span> Jumlah publikasi prosiding internasional</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_jur_LD5" id="frm_sc_jur_LD5" onKeyPress="return cek_digit(event)" value="<? echo $frm_sc_jur_LD5;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">6.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD6]</span> Jumlah paten</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_jur_LD6" id="frm_sc_jur_LD6" onKeyPress="return cek_digit(event)" value="<? echo $frm_sc_jur_LD6;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">7.</td>
      <td nowrap bgcolor="dddddd"> <span class="style1">[LD7]</span> Jumlah layanan industri </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_jur_LD7" id="frm_sc_jur_LD7" onKeyPress="return cek_digit(event)" value="<? echo $frm_sc_jur_LD7;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">8.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD8]</span> Rata-rata IPK lulusan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_jur_LD8" id="frm_sc_jur_LD8" value="<? echo $frm_sc_jur_LD8;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">9.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD9]</span> % lulusan dengan IPK = 3,00 </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_jur_LD9" id="frm_sc_jur_LD9" value="<? echo $frm_sc_jur_LD9;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">10.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD10]</span> Rasio DO : mhs aktif</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_jur_LD10" id="frm_sc_jur_LD10"  value="<? echo $frm_sc_jur_LD10;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">11.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD11]</span> Rasio PO : mhs aktif</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_jur_LD11" id="frm_sc_jur_LD11" value="<? echo $frm_sc_jur_LD11;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">12.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD12]</span> Rata-rata masa studi</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_jur_LD12" id="frm_sc_jur_LD12" value="<? echo $frm_sc_jur_LD12;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">13.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD13]</span> % lulusan dengan masa studi = 4 tahun </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_jur_LD13" id="frm_sc_jur_LD13" value="<? echo $frm_sc_jur_LD13;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">14.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD14]</span> Masa tunggu dapat kerja</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_jur_LD14" id="frm_sc_jur_LD14"  value="<? echo $frm_sc_jur_LD14;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">15.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD15]</span> Gaji pertama</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_jur_LD15" id="frm_sc_jur_LD15" onKeyPress="return cek_digit(event)" value="<? echo $frm_sc_jur_LD15;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">16.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD16]</span> Jumlah grant yang diterima</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_jur_LD16" id="frm_sc_jur_LD16" onKeyPress="return cek_digit(event)" value="<? echo $frm_sc_jur_LD16;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*      </font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top" bgcolor="dddddd">17.</td>
      <td nowrap bgcolor="dddddd"><span class="style1">[LD17]</span> Rata-rata Indeks Pembelajaran per Jurusan (dosen tetap)</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td bgcolor="dddddd"><font color="#FF0000">
        <input name="frm_sc_jur_LD17" id="frm_sc_jur_LD17"  value="<? echo $frm_sc_jur_LD17;?>" type="text" class="tekboxku" size="10" maxlength="10" >
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
      <td nowrap>&nbsp;</td>
      <td><div align="center"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td nowrap> <strong>Isu Strategis: Sustainability </strong> </td>
      <td><div align="center"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top">18.</td>
      <td nowrap><span class="style1">[S1]</span> Jumlah dana penelitian dari pihak eksternal </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
<font color="#FF0000">
<input name="frm_sc_jur_S1" id="frm_sc_jur_S1" onKeyPress="return cek_digit(event)"  value="<? echo $frm_sc_jur_S1;?>" type="text" class="tekboxku" size="10" maxlength="10" >
*</font>	  </td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top">19.</td> 
      <td> <span class="style1">[S2]</span> Produktivitas dana = income (revenue – direct cost) / S direct employee</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> <font color="#FF0000">
        <input name="frm_sc_jur_S2" id="frm_sc_jur_S2" onKeyPress="return cek_digit(event)" value="<? echo $frm_sc_jur_S2;?>" type="text" class="tekboxku" size="10" maxlength="10" >
      *</font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top">20.</td>
      <td> <span class="style1">[S3]</span> % non-tuition fee = revenue berbasis kegiatan tri-dharma di luar tuition fee / S revenue total </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_sc_jur_S3" type="text" onKeyPress="return cek_digit(event)" class="tekboxku" id="frm_sc_jur_S3" value="<?php echo $frm_sc_jur_S3; ?>" size="10" maxlength="10" >
      <font color="#FF0000">*</font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top">21.</td>
      <td> <span class="style1">[S4]</span> Jumlah mahasiswa baru </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_sc_jur_S4" type="text" onKeyPress="return cek_digit(event)" class="tekboxku" id="frm_sc_jur_S4" value="<?php echo $frm_sc_jur_S4; ?>" size="10" maxlength="10" >
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
      <td> <strong>Isu Strategis: Promotion </strong> </td>
      <td><div align="center"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top">22.</td>
      <td> <span class="style1">[P1]</span> Partisipasi mahasiswa dalam kegiatan ilmiah nasional </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_sc_jur_P1" type="text" onKeyPress="return cek_digit(event)" class="tekboxku" id="frm_sc_jur_P1" value="<?php echo $frm_sc_jur_P1; ?>" size="10" maxlength="10" >
        <font color="#FF0000">*</font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top">23.</td>
      <td> <span class="style1">[P2]</span> Partisipasi mahasiswa dalam kegiatan ilmiah internasional </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_sc_jur_P2" type="text" onKeyPress="return cek_digit(event)" class="tekboxku" id="frm_sc_jur_P2" value="<?php echo $frm_sc_jur_P2; ?>" size="10" maxlength="10" >
        <font color="#FF0000">*</font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top">24.</td>
      <td> <span class="style1">[P3] </span>Prestasi mahasiswa dalam kegiatan ilmiah nasional </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_sc_jur_P3" type="text" onKeyPress="return cek_digit(event)" class="tekboxku" id="frm_sc_jur_P3" value="<?php echo $frm_sc_jur_P3; ?>" size="10" maxlength="10" >
        <font color="#FF0000">*</font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top">25.</td>
      <td> <span class="style1">[P4]</span> Prestasi mahasiswa dalam kegiatan ilmiah internasional </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_sc_jur_P4" type="text" onKeyPress="return cek_digit(event)" class="tekboxku" id="frm_sc_jur_P4" value="<?php echo $frm_sc_jur_P4; ?>" size="10" maxlength="10" >
        <font color="#FF0000">*</font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top">26.</td>
      <td> <span class="style1">[P5]</span> Jumlah buku yang ditulis dosen dan diterbitkan </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_sc_jur_P5" type="text" onKeyPress="return cek_digit(event)" class="tekboxku" id="frm_sc_jur_P5" value="<?php echo $frm_sc_jur_P5; ?>" size="10" maxlength="10" >
        <font color="#FF0000">*</font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top">27.</td>
      <td><span class="style1">[P6]</span> Jumlah publikasi karya mahasiswa dan dosen di media massa</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_sc_jur_P6" type="text" onKeyPress="return cek_digit(event)" class="tekboxku" id="frm_sc_jur_P6" value="<?php echo $frm_sc_jur_P6; ?>" size="10" maxlength="10" >
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
    <tr bgcolor="dddddd">
      <td valign="top">28.</td>
      <td> <span class="style1">[M1]</span> <img src="../img/sigma.gif" width="10" height="12" align="absbottom"> dosen S3 : <img src="../img/sigma.gif" width="10" height="12" align="absbottom"> dosen</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_sc_jur_M1" type="text" class="tekboxku" id="frm_sc_jur_M1" value="<?php echo $frm_sc_jur_M1; ?>" size="10" maxlength="10" >
        <font color="#FF0000">*</font></td>
    </tr>
    <tr bgcolor="dddddd">
      <td valign="top">29.</td>
      <td> <span class="style1">[M2]</span> Tingkat kepuasan layanan administrasi </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_sc_jur_M2" type="text" class="tekboxku" id="frm_sc_jur_M2" value="<?php echo $frm_sc_jur_M2; ?>" size="10" maxlength="10" >
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
    <tr bgcolor="dddddd">
      <td valign="top">30.</td>
      <td> <span class="style1">[PN1]</span> Jumlah kerjasama </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_sc_jur_PN1" type="text" onKeyPress="return cek_digit(event)" class="tekboxku" id="frm_sc_jur_PN1" value="<?php echo $frm_sc_jur_PN1; ?>" size="10" maxlength="10" >
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
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
      <td>
		<input name="Submit" type="submit" class="tombol" onClick="this.form.action+='?act=1';this.form.submit();" value="Simpan">
		<input name="Submit2" type="reset" class="tombol" disabled onClick="this.form.action+='?act=3';this.form.submit();" value="Batal">
		<?php if ($frm_id_do) { ?>
		<input name="Submit3" type="button" class="tombol"   disabled  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id_sc_jur=<?php echo $frm_id_sc_jur;?>';this.form.submit()};" value="Hapus">
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