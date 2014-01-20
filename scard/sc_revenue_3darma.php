<?
/* 
   DATE CREATED : 28/05/09
   UPDATE  		: 
   KEGUNAAN     : ENTRY jumlah revenue berbasis tri-darma diluar tuition fee per jurusan
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
	if (($frm_thn=='') or ($frm_jurusan=='') or ($frm_jum_tot_grant=='') or ($frm_jum_tot_dana_penil=='') or ($frm_jum_tot_dana_abdi=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi data dengan lengkap";
		}
	if ($error==1) 
		{
			$pesan=$pesan."<br>Gagal menyimpan data.";
		}
		
	if ($error !=1) // Jika semua isian form valid 
		{
				if ($frm_exist!=1) 
				{
					echo "<br>INSERT";
					$result = mysql_query("INSERT INTO revenue_3darma (`id`, `tahun` , `jurusan`, `total_grant`, `total_dana_penelitian`, `total_dana_abdi_masy`) VALUES 
					( NULL, ".$frm_thn.", $frm_jurusan, $frm_jum_tot_grant, $frm_jum_tot_dana_penil, $frm_jum_tot_dana_abdi) " );
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
				
					echo "<br>UPDATE";
					/*echo "<br>id_sc_personal=".$id_sc_personal;
					echo "<br>frm_id_revenue_3darma=".$frm_id_revenue_3darma;
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
					$result = mysql_query("UPDATE revenue_3darma SET `tahun` = $frm_thn,
																     `jurusan` = $frm_jurusan, 
																     `total_grant` = $frm_jum_tot_grant,
																     `total_dana_penelitian` = $frm_jum_tot_dana_penil,
																     `total_dana_abdi_masy` = $frm_jum_tot_dana_abdi
													          WHERE  id = $frm_id_revenue_3darma");
	
					if ($result) 
					{
						$pesan = $pesan."<br>Data telah diubah.";	
					}
					else
					{ 
						$pesan = $pesan."<br>Gagal mengubah data - ".mysql_error();
					}
				}
				
		}
}

if ($act==2) { // hapus data

$result = mysql_query("DELETE FROM revenue_3darma WHERE id = ".$id_rev_3d);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}
	
	// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) 
{
	//$frm_id_revenue_3darma="";
	$frm_jurusan=0;
	$frm_id_revenue_3darma=$row["id"];
	$frm_thn=$row["tahun"];
	$frm_jurusan=$row["jurusan"];
	$frm_jum_tot_grant=$row["revenue"];
}
else
{
//echo "HERE";
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
		//echo "<br>frm_thn=".$frm_thn;
		if (isset($frm_thn) and ($frm_thn<>'')) 
		{						
		                $result = mysql_query("SELECT *
												 FROM revenue_3darma
												WHERE tahun=$frm_thn and
												      jurusan=$frm_jurusan");
				
						if ($row = mysql_fetch_array($result)) {
							$frm_exist=1;
							$frm_id_revenue_3darma=$row["id"];
							$frm_thn=$row["tahun"];
							$frm_jurusan=$row["jurusan"];
							$frm_jum_tot_grant=$row["total_grant"];
							$frm_jum_tot_dana_penil=$row["total_dana_penelitian"];
							$frm_jum_tot_dana_abdi=$row["total_dana_abdi_masy"];
						}
						else
						{
							$frm_exist=0;
							//$frm_sc_personal_LD1=0;
							//$frm_jurusan=0;
							$frm_jum_tot_grant=0;
							$frm_jum_tot_dana_penil=0;
							$frm_jum_tot_dana_abdi=0;
						}
		}
}

?>
<html>
<head>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../include/tanggalan.js">
</script>
</head>
<body class="body">
<form name="form_sc_revenue_3darma" id="form_sc_revenue_3darma" action="sc_revenue_3darma.php" method="post">
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
				<? if ($frm_id_revenue_3darma!=''){?>
					<strong>EDIT DATA ~ </strong>
				<? } else
				{?>
					<strong>ENTRY DATA ~ </strong>
				<? }?>
				REVENUE  BERBASIS TRI-DHARMA DI LUAR TUITION FEE </font></td>
            <td width="11%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">SCORE CARD</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
	<td>
	<table width="80%"  border="0" align="center" cellpadding="3" cellspacing="1">
<tr>
  <td valign="top">Tahun</td>
  <td><div align="center"><strong>:</strong></div></td>
  <td>
	  <select name="frm_thn" id="frm_thn" class="tekboxku">
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
	  <font color="#FF0000">*</font>  </td>
</tr>
<tr>
      <td width="16%"><? //echo "<br>frm_id_revenue_3darma=".$frm_id_revenue_3darma;?></td>
      <td width="2%"><div align="center"></div></td>
      <td width="82%">
		  <input type="hidden" name="frm_id_revenue_3darma" id="frm_id_revenue_3darma" value="<?php echo $frm_id_revenue_3darma;?>">
		  <input type="hidden" name="frm_exist" id="frm_exist" value="<?php echo $frm_exist;?>">
	  </td>
    </tr>
    <tr>
      <td nowrap>Jurusan</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td nowrap>
	  <select name="frm_jurusan" id="frm_jurusan" class="tekboxku" onChange="document.form_sc_revenue_3darma.submit();">
	    <option <?php if ($frm_jurusan==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
				$sql_jurusan="SELECT * FROM jurusan WHERE `jurusan`.id >0 and `jurusan`.id <6 ORDER BY id ASC";
				$result = @mysql_query($sql_jurusan);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->id; ?>" <?php if ($frm_jurusan==$row->id) { echo "selected"; }?>> <?php echo $row->jurusan; ?></option>
          <?php
				}
				?>
      </select> 
        <font color="#FF0000">*</font></td>
    </tr>
    <tr>
      <td nowrap>Jumlah Total Grant Prodi </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><font color="#FF0000">
        <input name="frm_jum_tot_grant" id="frm_jum_tot_grant" onKeyPress="return cek_digit(event)" value="<? echo $frm_jum_tot_grant;?>" type="text" class="tekboxku" size="30" maxlength="50" >
*      </font></td>
    </tr>
    <tr>
      <td nowrap>Jumlah Total dana Penelitian</td>
      <td><strong>:</strong></td>
      <td><font color="#FF0000">
        <input name="frm_jum_tot_dana_penil" id="frm_jum_tot_dana_penil" onKeyPress="return cek_digit(event)" value="<? echo $frm_jum_tot_dana_penil;?>" type="text" class="tekboxku" size="30" maxlength="50" >
* </font></td>
    </tr>
    <tr>
      <td nowrap>Jumlah Total dana Pengabdian Masyarakat</td>
      <td><strong>:</strong></td>
      <td><font color="#FF0000">
        <input name="frm_jum_tot_dana_abdi" id="frm_jum_tot_dana_abdi" onKeyPress="return cek_digit(event)" value="<? echo $frm_jum_tot_dana_abdi;?>" type="text" class="tekboxku" size="30" maxlength="50" >
* </font></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td><div align="center"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
      <td>
		<input name="Submit" type="submit" class="tombol" onClick="this.form.action+='?act=1';this.form.submit();" value="Simpan">
		<input name="Submit2" type="reset" class="tombol"  onClick="this.form.action+='?act=3';this.form.submit();" value="Batal">
		<?php if ($frm_id_revenue_3darma) { ?>
		<input name="Submit3" type="button" class="tombol"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id_rev_3d=<?php echo $frm_id_revenue_3darma;?>';this.form.submit()};" value="Hapus">
		<?php } ?>
	  </td>
    </tr>
    <tr> 
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="3"><font color="#FF0000" size="1">*</font><font size="1"> = 
        compulsory / harus diisi</font></td>
    </tr>
	</table>

	</td>
	</tr>
  </table>
</form>
</body>
</html>