<?php
/* 
   DATE CREATED : 07/09/07- RAHADI
   UPDATE  		: 
   PROBLEM 		:
   KEGUNAAN     : Mencari Dosen Publikasi
   VARIABEL     :  
*/

session_start();
require("../include/global.php");
require("../include/fungsi.php");


f_connecting();
	mysql_select_db($DB);
?>
<html>
<head>
<title>: : Daftar Nama Dosen Fakultas Teknik : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css2/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<!--window.parent.[nama_form].[nama_field].value=[nilai dari data yg di klik user tadi]
windows.openner.cek_id.value=[nama text_box].value;window.close();

onSubmit="javascript:window.opener.mk.nm_dosen.value=frmDaftarDosen.cek_id[].value;"
-->

  <table width="100%" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      
    <td><font color="#0066CC" size="+1"><strong> Dosen Pembimbing - Fakultas Teknik</strong></font> 
      <hr align="center" size="1" color="#3366CC"></td>
    </tr>
    <tr> 
      <td> 
	  <form name="frmCariDosen"  method="post" action="pen_st_publikasi_entry_cari_dosen.php?action=go">
        <table width="25%" border="0" cellpadding="5" cellspacing="0">
          <tr> 
            <td valign="top" nowrap>Cari&nbsp;</td>
            <td valign="top" nowrap><strong>:</strong></td>
            <td nowrap><label> 
              <input type="radio" name="radioCari" value="kode" checked>
              NPK Dosen</label> <br> <label>
              <input type="radio" name="radioCari" value="nama">
              Nama Dosen</label> </td>
            <td nowrap>&nbsp;</td>
          </tr>
          <tr> 
            <td width="12%" nowrap>&nbsp;</td>
            <td width="12%" nowrap>&nbsp;</td>
            <td width="85%" nowrap><input type="text" name="frm_cari_dosen"></td>
            <td width="85%" nowrap><input type="submit" name="Submit" value="Go !"></td>
          </tr>
        </table>
      </form>
	  </td>
	 </tr>
	<tr> 
      <td> 
	  <?
if ($action=='go')
{		
	  	$sql_cari="SELECT id, kode, nama FROM master_karyawan WHERE kode NOT LIKE '66%'";
		if ($radioCari=='kode')
		{
			$sql_cari=$sql_cari." AND master_karyawan.kode LIKE '".$frm_cari_dosen."%'";
			echo "<font size=1 color=#0066CC>NPK Dosen<b>: ".$frm_cari_dosen."</b></font>";
		}
		if ($radioCari=='nama')
		{
			$sql_cari=$sql_cari." AND master_karyawan.nama LIKE '%".$frm_cari_dosen."%'";
			echo "<font size=1 color=#0066CC>NAMA DOSEN<b>: ".$frm_cari_dosen."</b></font>";
		}
		$resultCari = @mysql_query($sql_cari);
	  ?>

	  <table width="98%" border="1" cellpadding="2" cellspacing="0" bordercolor="#0099CC">
        <tr bgcolor="#DEEFFF"> 
          <td width="19%"><div align="center"><strong>NPK Dosen</strong></div></td>
          <td width="64%"><div align="center"><strong>Nama Dosen</strong></div></td>
          <td width="5%">&nbsp;</td>
        </tr>
        <script language="JavaScript">
			function konfirmasi(id_ds)
			{
				var say=confirm("Pilih Dosen Ini ?")
				if (say)
				{
					opener.location.href = 'pen_st_publikasi_entry.php?frm_id_karyawan='+id_ds;
					window.close();
				}
			}
		</script>
        <? while ($rowCari=@mysql_fetch_object($resultCari))  
			{?>
        <tr> 
          <td><? echo $rowCari->kode;?></td>
          <td><? echo $rowCari->nama;?></td>
          <td bgcolor="#DEEFFF"><? echo $_GET['jdl'];?><div align="center">
              <input type="radio" onClick="konfirmasi('<? echo $rowCari->id; ?>');" name="rad_pilih_dosen" value="<? echo $rowCari->id; ?>">
            </div></td>
        </tr>
        <?
			}
			?>
      </table>
<?
}
?>
		</td>
    </tr>
    <tr> 
      <td><hr align="center" size="1" color="#3366CC">
		</td>
    </tr>
  </table>
</body>
</html>