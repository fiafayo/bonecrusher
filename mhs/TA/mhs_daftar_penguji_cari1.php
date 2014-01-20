<?php
/* 
      
   DATE CREATED : 15/07/05- RAHADI
   UPDATE  		: 
   PROBLEM 		:
   KEGUNAAN     : Mencari Dosen FT
   VARIABEL     : 
  
   
*/
session_start();
require("../../include/global.php");
require("../../include/fungsi.php");


f_connecting();
	mysql_select_db($DB);
?>
<html>
<head>
<title>: : Daftar Nama Dosen Pengajar Fakultas Teknik : :</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
</head>

<body>
<!--window.parent.[nama_form].[nama_field].value=[nilai dari data yg di klik user tadi]
windows.openner.cek_id.value=[nama text_box].value;window.close();

onSubmit="javascript:window.opener.mk.nm_dosen.value=frmDaftarDosen.cek_id[].value;"
-->
  <table width="100%" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      
    <td><font color="#0066CC" size="3"><strong> Dosen Pengajar - Fakultas Teknik</strong></font> 
      <hr align="center" size="1" color="#3366CC"></td>
    </tr>
    <tr> 
      <td> 
	  <form name="frmCariDosen"  method="post" action="mhs_daftar_penguji_cari1.php?action=go">
        <table width="25%" border="0" cellpadding="5" cellspacing="0">
          <tr> 
            <td valign="top" nowrap>Cari&nbsp;</td>
            <td valign="top" nowrap><strong>:</strong></td>
            <td nowrap><label> 
              <input type="radio" name="radioCari" value="kode" checked>
              Kode Dosen</label> <br> <label> 
              <input type="radio" name="radioCari" value="nama">
              Nama Dosen</label> </td>
            <td nowrap>&nbsp;<? echo "nrp=".$nrp;?></td>
          </tr>
          <tr> 
            <td width="12%" nowrap>&nbsp;</td>
            <td width="12%" nowrap><input type="hidden" name="nrp" value="<? echo $nrp;?>">
			<input type="hidden" name="no_skkp_1" value="<? echo $no_skkp_1;?>">
			<input type="hidden" name="no_skkp_2" value="<? echo $no_skkp_2;?>"></td>
            <td width="85%" nowrap><input type="text" name="frm_cari_dosen" class="tekboxku"></td>
            <td width="85%" nowrap><input type="submit" name="Submit" value="Go !" class="tombol"></td>
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
	  	$sql_cari="SELECT kode, nama FROM dosen  where (length(kode)=6) ORDER by kode";
		if ($radioCari=='kode')
		{
			$frm_cari_dosen = $_POST['frm_cari_dosen'];
			$sql_cari=$sql_cari." WHERE kode LIKE '".$frm_cari_dosen."%'";
			echo "<font size=1 color=#0066CC>KODE DOSEN<b>: ".$frm_cari_dosen."</b></font>";
		}
		if ($radioCari=='nama')
		{
			$frm_cari_dosen = $_POST['frm_cari_dosen'];
			$sql_cari=$sql_cari." WHERE nama LIKE '%".$frm_cari_dosen."%'";
			echo "<font size=1 color=#0066CC>NAMA DOSEN<b>: ".$frm_cari_dosen."</b></font>";
		}
		$resultCari = @mysql_query($sql_cari);
        ?>

	  <table width="98%" border="1" cellpadding="2" cellspacing="0" bordercolor="#0099CC">
        <tr bgcolor="#DEEFFF"> 
          <td width="19%"><div align="center"><strong>Kode Dosen</strong></div></td>
          <td width="64%"><div align="center"><strong>Nama Dosen</strong></div></td>
          <td width="5%">&nbsp;</td>
        </tr>
        <script language="JavaScript">
			function konfirmasi(kd_dsn,nrp,no_skkp_1,no_skkp_2)
			{
				var stay=confirm("Pilih Dosen Pengajar Ini ?")
				if (stay)
				{
					opener.location.href = 'mhs_daftar_penguji.php?frm_kode_ketua='+kd_dsn+'&frm_nrp='+nrp+'&frm_no_sk_pertama='+no_skkp_1+'&frm_no_sk_akhir='+no_skkp_2+'';
					window.close();
				}
			}
		</script>
        <? while ($rowCari=@mysql_fetch_object($resultCari))  
			{?>
        <tr> 
          <td>&nbsp;<? echo $rowCari->kode;?></td>
          <td><? echo $rowCari->nama;?></td>
          <td bgcolor="#DEEFFF"><div align="center">
              <input type="radio" onClick="konfirmasi('<? echo $rowCari->kode; ?>','<? echo $nrp; ?>','<? echo $no_skkp_1; ?>'),'<? echo $no_skkp_2; ?>';" name="rad_pilih_dosen" value="<? echo $rowCari->kode; ?>">
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