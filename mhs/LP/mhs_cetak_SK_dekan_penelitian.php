<?php
/* 
   DATE CREATED : 19/09/07
   KEGUNAAN     : CETAK SK DEKAN PENELITIAN
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

f_connecting();
mysql_select_db($DB);
        
$act= ( isset( $_REQUEST['act'] ) ) ? $_REQUEST['act'] : 0;
$frm_tgl_surat_dibuat= ( isset( $_REQUEST['frm_tgl_surat_dibuat'] ) ) ? $_REQUEST['frm_tgl_surat_dibuat'] : null;
$frm_nrp= ( isset( $_REQUEST['frm_nrp'] ) ) ? $_REQUEST['frm_nrp'] : null;
$frm_periode = ( isset( $_REQUEST['frm_periode'] ) ) ? $_REQUEST['frm_periode'] : null;
$frm_id_tahun_ajar= ( isset( $_REQUEST['frm_id_tahun_ajar'] ) ) ? $_REQUEST['frm_id_tahun_ajar'] : null;
 
$frm_exist= ( isset( $_REQUEST['frm_exist'] ) ) ? $_REQUEST['frm_exist'] : null;
$frm_nama= ( isset( $_REQUEST['frm_nama'] ) ) ? $_REQUEST['frm_nama'] : null;

$pesan= ( isset( $_REQUEST['pesan'] ) ) ? $_REQUEST['pesan'] : null;
$error= ( isset( $_REQUEST['error'] ) ) ? $_REQUEST['error'] : null;        
        

if ($act==1)   
{ // CEK data
// No.SK harus diisi
	if ($frm_no_SK=='')
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi No. SK Penelitian dengan benar. Gagal Mencetak.";
		}

	if ($error !=1) // Jika isian form valid 
		{
					$sql_cetak_SK_DEK_Pen="SELECT daftar_uji_lp.NO_SK
								     			FROM daftar_uji_lp 
								     			WHERE daftar_uji_lp.NO_SK='".$frm_no_SK."'";
					$result = mysql_query($sql_cetak_SK_DEK_Pen);
                                        $row = mysql_fetch_array($result);
					if ($row) 
					{
						//$pesan=$pesan."<br>ADA";
						?>
						<script language="JavaScript">
							//return popitup('form_cetak_mohon_KP.php?no_mo_kp='+document.mhs.frm_no_mohon.value);
							//function popitup(url)
							//{
								newwindow=window.open('form_cetak_SK_dekan_penelitian.php?no_sk=<? echo $frm_no_SK;?>&periode=<? echo $frm_periode;?>&thn_ajar=<? echo $frm_id_tahun_ajar;?>','name','top=0,left=200,scrollbars=yes');
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
						$pesan=$pesan."<br>Maaf, No. SK Penelitian salah. Gagal Mencetak.";
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
</style><script language="JavaScript" src="../../include/tanggalan.js">
</script>
</head>

<body class="body">
<form name="mhs" id="mhs" action="mhs_cetak_SK_dekan_penelitian.php" method="post">
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
              ~</strong>  SK DEKAN PENELITIAN</font></font></td>
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
      <td nowrap>No. SK</td>
      <td width="1%"><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_no_SK" type="text" class="tekboxku" id="frm_no_SK" size="15" maxlength="20">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Periode Ujian </td>
      <td><strong>:</strong></td>
      <td><select name="frm_periode" id="frm_periode" class="tekboxku">
	  <option>Pilih</option>
	  <option value="I">I</option>
	  <option value="II">II</option>
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