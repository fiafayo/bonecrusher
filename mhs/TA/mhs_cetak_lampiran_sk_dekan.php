<?php
/* 
   DATE CREATED : 12/07/07
   KEGUNAAN     : CETAK LAMPIRAN SK DEKAN TA
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
$act= ( isset( $_REQUEST['act'] ) ) ? $_REQUEST['act'] : 0;
$frm_nrp= ( isset( $_REQUEST['frm_nrp'] ) ) ? $_REQUEST['frm_nrp'] : null;
$frm_no_SK= ( isset( $_REQUEST['frm_no_SK'] ) ) ? $_REQUEST['frm_no_SK'] : null;
$frm_periode= ( isset( $_REQUEST['frm_periode'] ) ) ? $_REQUEST['frm_periode'] : null;
$frm_id_tahun_ajar= ( isset( $_REQUEST['frm_id_tahun_ajar'] ) ) ? $_REQUEST['frm_id_tahun_ajar'] : null;
 

$pesan= ( isset( $_REQUEST['pesan'] ) ) ? $_REQUEST['pesan'] : null;
$error= ( isset( $_REQUEST['error'] ) ) ? $_REQUEST['error'] : null;
require("../../include/global.php");
require("../../include/fungsi.php");
require("../../include/temp.php");

f_connecting();
	mysql_select_db($DB);


if ($act==1)   
{ 
// frm_no_SK harus diisi
	if ($frm_no_SK=='') 
		{
			$error = 1;
			//$pesan=$pesan."<br>Maaf, anda harus mengisi nrp dan nama mahasiswa. Gagal menyimpan data.";
			$pesan=$pesan."<br>Maaf, Anda harus mengisi No.SK dekan penguji TA dengan benar. Gagal mencetak.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
					$sql_cek_ST_TA="SELECT `daftar_uji`.`NO_SK`
								    FROM daftar_uji 
								    WHERE `daftar_uji`.`NO_SK`='".$frm_no_SK."'";
					$result = mysql_query($sql_cek_ST_TA);
					if ($row = mysql_fetch_array($result)) 
					{
						//$pesan=$pesan."<br>ADA";
						?>
						<script language="JavaScript">
							//return popitup('form_cetak_mohon_KP.php?no_mo_kp='+document.mhs.frm_no_mohon.value);
							//function popitup(url)
							//{
								newwindow=window.open('form_cetak_lampiran_SK_dekan.php?no_sk=<? echo $frm_no_SK;?>&nama=<? echo $frm_nama;?>&periode=<? echo $frm_periode;?>&thn_ajar=<? echo $frm_id_tahun_ajar;?>','name','top=0,left=510,scrollbars=yes');
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
						$pesan=$pesan."<br>Maaf, No.SK dekan penguji TA salah. Gagal Mencetak.";
					}			
		}
}



// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	$frm_no_SK="";
	$frm_NRP="";
	$frm_nama = "";
}
else
{
// kalau user mengisi NRP, maka di cek apakah data kode sudah ada, kalau sudah ada maka data ditampilkan
if ($frm_no_SK!='')  {
$result = mysql_query("SELECT daftar_uji.`ruang_ujian`,
					    FROM  daftar_uji 
					   WHERE  daftar_uji.NO_SK = '".$frm_no_SK."'");

	if ($row = mysql_fetch_array($result)) {
		$frm_exist=1;
		//$frm_NRP = $row["NRP"];	
		//$frm_nama = $row["NAMA"];	
	}else
	{$frm_exist=0; header("Location: mhs_cetak_lampiran_sk_dekan.php");  }
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
<form name="mhs" id="mhs" action="mhs_cetak_lampiran_sk_dekan.php" method="post">
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
              ~</strong> LAMPIRAN SK DEKAN</font></font></td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr> 
      <td width="14%">&nbsp;</td>
      <td width="5%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="80%"><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" ></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>No. SK</td>
      <td width="1%"><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_no_SK" type="text" class="tekboxku" id="frm_no_SK" size="15" maxlength="20">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Periode Ujian </td>
      <td><strong>:</strong></td>
      <td>
	  <select name="frm_periode" id="frm_periode" class="tekboxku">
	  <option value="I (satu)">I</option>
	  <option value="II (dua)">II</option>
	  <option value="III (tiga)">III</option>
	  <option value="IV (empat)">IV</option>
	  <option value="V (lima)">V</option>
	  <option value="VI (enam)">VI</option>
      </select>
      <span class="style1">*</span></td>
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
      </select>
      <span class="style1">*</span></td>
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