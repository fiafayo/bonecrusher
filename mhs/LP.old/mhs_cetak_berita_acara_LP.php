<?php
/* 
   DATE CREATED : 18/08/07
   KEGUNAAN     : CETAK BERITA ACARA LP
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ // CEK data
// NRP harus diisi
	if ($frm_NRP=='')
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi NRP dengan benar. Gagal Mencetak.";
		}

	if ($error !=1) // Jika isian form valid 
		{
					$sql_cetak_berita_acara_LP="SELECT  `master_mhs`.`NRP`
								     			FROM master_mhs 
								     			WHERE `master_mhs`.`NRP`='".$frm_NRP."' and `master_mhs`.`NRP` LIKE '___2%'";
					$result = mysql_query($sql_cetak_berita_acara_LP);
					if ($row = mysql_fetch_array($result)) 
					{
						//$pesan=$pesan."<br>ADA";
						?>
						<script language="JavaScript">
							//return popitup('form_cetak_mohon_KP.php?no_mo_kp='+document.mhs.frm_no_mohon.value);
							//function popitup(url)
							//{
								newwindow=window.open('form_cetak_berita_acara_LP.php?nrp=<? echo $frm_NRP;?>&periode=<? echo $frm_periode;?>&thn_ajar=<? echo $frm_id_tahun_ajar;?>','name','top=0,left=510,scrollbars=yes');
								if (window.focus) {newwindow.focus()}
								//return false;
							//}
							//return popitup('form_cetak_mohon_KP.php?no_mo_kp=<? echo $frm_no_mohon;?>');
							//return popitup('form_cetak_berita_acara_LP.php?nrp='+document.mhs.frm_NRP.value+'&periode='+document.mhs.frm_periode.value+'&thn_ajar='+document.mhs.frm_id_tahun_ajar.value);
							
						</script>
						<?
					}
					else
					{
						$pesan=$pesan."<br>Maaf, NRP salah. Gagal Mencetak.";
					}
		}
			
			
			
}

		if (($act!=0)and($error!=1)) {
			$frm_exist = 0;
			$frm_NRP = "";
			$frm_nama = "";
		}
		else
		{
		// kalau user mengisi NRP, maka di cek apakah data NRP sudah ada, kalau sudah ada maka data ditampilkan
		if ($frm_NRP!='')  {
		$result = mysql_query("SELECT	master_mhs.NRP,
										master_mhs.NAMA,
										`no_surat_lp`.`N_ST`
									FROM
										`master_mhs` LEFT JOIN `no_surat_lp` ON `master_mhs`.`NRP` = `no_surat_lp`.`NRP`
									WHERE `master_mhs`.`NRP` LIKE '6__2%' AND
										  `master_mhs`.`NRP` =  '".$frm_NRP."'");
										
									if ($row = mysql_fetch_array($result)) {
										$frm_exist=1;
										$frm_nama = $row["NAMA"];
									}else
									{
										$frm_exist = 0; 
										$frm_NRP = "";
										$frm_nama = "";
									//header("Location: mhs_cetak_ST_LP.php"); 
									}
		}
		}
			





?>
<html>
<head>
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<script language="JavaScript" src="../../include/tanggalan.js">
</script>
<body class="body">
<form name="mhs" id="mhs" action="mhs_cetak_berita_acara_LP.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><img src="spacer" height="1"></td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4"> <hr size="1" color="#FF9900"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>CETAK 
              ~</strong> BERITA ACARA PENELITIAN</font></font></td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr> 
      <td width="14%">&nbsp;</td>
      <td width="5%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="80%">&nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>NRP</td>
      <td width="1%"><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_NRP" type="text" class="tekboxku" id="frm_NRP" onBlur="document.mhs.submit()" size="10" maxlength="10" value="<? echo $frm_NRP;?>" > 
        <span class="style1">*</span><? if (isset($frm_NRP)) echo $frm_nama;?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Periode Ujian </td>
      <td><strong>:</strong></td>
      <td>
	  <select name="frm_periode" id="frm_periode" class="tekboxku">
	  <option value="I (satu)">I</option>
	  <option value="II (dua)">II</option>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Tahun Akademik </td>
      <td><strong>:</strong></td>
      <td><select name="frm_id_tahun_ajar" id="frm_id_tahun_ajar" class="tekboxku">
        <option>Tahun Ajaran</option>
        <?php
	$result1 = @mysql_query("Select id, tahun_ajaran, semester, DATE_FORMAT(awal,'%Y/%m/%d') as awal, DATE_FORMAT(akhir,'%Y/%m/%d') as akhir from tahun_ajar order by tahun_ajaran, semester desc");
	$c=0;
	if ($frm_id_tahun_ajar=='') { $cek_id_tahun_ajar=$row1->id; }
	else { $cek_id_tahun_ajar=$frm_id_tahun_ajar; }
	
	while ($row1=@mysql_fetch_object($result1))  {
	$c=$c+1;
	?>
        <option value="<?php echo $row1->id; ?>" <?php 
		  if ($frm_id_tahun_ajar!='') 
		  { 
		    if ($row1->id==$cek_id_tahun_ajar)
		    { echo "selected"; }
		  }
		  else
		  { if ((date('Y/m/d')<=$row1->akhir) and (date('Y/m/d')>=$row1->awal))
		    { $current_semester=$row1->id; 
			  echo "selected";
			} 
		  } ?> >SEMESTER <?php echo $row1->semester; ?> <?php echo $row1->tahun_ajaran; ?> - <?php echo $row1->tahun_ajaran+1; ?>
        <?php
	}
	?>
      </select></td>
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
      <td><div align="center"></div></td>
      <td>
   	  	<input type="submit" name="Submit" value="Proses" onclick="this.form.action+='?act=1';this.form.submit();" class="tombol">
      </td>
    </tr>
    <tr> 
      <td colspan="4"> </td>
    </tr>
    <tr> 
      <td colspan="4"><font size="1"><span class="style1">*</span> compulsory 
        / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>