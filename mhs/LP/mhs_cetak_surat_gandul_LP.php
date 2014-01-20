<?php
/* 
   DATE CREATED : 30/05/07
   KEGUNAAN     : CETAK SURAT GANTI JUDUL LP
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
require("../../include/temp.php");

f_connecting();
mysql_select_db($DB);
$act= ( isset( $_REQUEST['act'] ) ) ? $_REQUEST['act'] : 0;
$frm_no_surat_gandul_terakhir= ( isset( $_REQUEST['frm_no_surat_gandul_terakhir'] ) ) ? $_REQUEST['frm_no_surat_gandul_terakhir'] : null;
$frm_no_surat_gandul_baru= ( isset( $_REQUEST['frm_no_surat_gandul_baru'] ) ) ? $_REQUEST['frm_no_surat_gandul_baru'] : null;
$frm_nrp= ( isset( $_REQUEST['frm_nrp'] ) ) ? $_REQUEST['frm_nrp'] : null;
$frm_periode = ( isset( $_REQUEST['frm_periode'] ) ) ? $_REQUEST['frm_periode'] : null;
$frm_id_tahun_ajar= ( isset( $_REQUEST['frm_id_tahun_ajar'] ) ) ? $_REQUEST['frm_id_tahun_ajar'] : null;
 
$frm_exist= ( isset( $_REQUEST['frm_exist'] ) ) ? $_REQUEST['frm_exist'] : null;
$frm_nama= ( isset( $_REQUEST['frm_nama'] ) ) ? $_REQUEST['frm_nama'] : null;

$pesan= ( isset( $_REQUEST['pesan'] ) ) ? $_REQUEST['pesan'] : null;
$error= ( isset( $_REQUEST['error'] ) ) ? $_REQUEST['error'] : null; 

if ($act==1)   
{ // simpan data
// Form harus diisi
	if (($frm_nrp=='') or ($frm_nama=='') or ($frm_no_surat_gandul_terakhir=='') or ($frm_no_surat_gandul_baru=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi data dengan benar. Gagal mencetak.";
		}
	
	if (strlen($frm_no_surat_gandul_baru) < 9)
	{
		$error = 1;
		$pesan=$pesan."<br>Maaf, Anda harus mengisi No. surat ganti judul LP dengan benar (harus 9 digit Angka). Gagal mencetak !";
	}
	
	if ($error != 1) // Jika semua isian form valid 
		{
					$sql_cek_mhs="SELECT `no_surat`.`NRP`
								    FROM `no_surat` 
								   WHERE `no_surat`.`NRP`='".$frm_nrp."'";
					$result = mysql_query($sql_cek_mhs);
                                        $row = mysql_fetch_array($result);
					if ($row) 
					{
						//$pesan=$pesan."<br>ADA";
						$result_cek = mysql_query("SELECT `NRP`, 
														  `N_GANDUL`, 
														  `N_urut_gandul` 
												     FROM `no_surat`
												    WHERE `no_surat`.`N_GANDUL`='".$frm_no_surat_gandul_baru."'");
						$row_urut_gandul = mysql_fetch_array($result_cek);
						$row_result_cek = mysql_num_rows($result_cek);

								if ($row_result_cek ==0) // belum penah ganti judul
								{
									$result_update1 = mysql_query("UPDATE no_surat set `N_GANDUL`='$frm_no_surat_gandul_baru', `N_urut_gandul`='$frm_no_urut_surat_gandul_terakhir' WHERE `NRP`='$frm_nrp'");

									if ($result_update1)
									{
											?>
											<script language="JavaScript">
													newwindow=window.open('form_cetak_gandul_LP.php?nrp=<? echo $frm_nrp;?>&no_gandul_LP=<? echo $frm_no_surat_gandul_baru;?>','name','top=0,left=510,scrollbars=yes');
													if (window.focus) {newwindow.focus()}
											</script>
											<?
									}
									else
									{
										$error = 1;
										$pesan = $pesan."<br>Proses Cetak data GAGAL. Segera hubungi administrator". mysql_error();
									}								
								}
								else
								{
									
											?>
											<script language="JavaScript">
													newwindow=window.open('form_cetak_gandul_LP.php?nrp=<? echo $frm_nrp;?>&no_gandul_LP=<? echo $frm_no_surat_gandul_baru;?>','name','top=0,left=510,scrollbars=yes');
													if (window.focus) {newwindow.focus()}
											</script>
											<?
									
								}
					}
					else
					{
						//$pesan=$pesan."<br>Maaf, Mahasiswa belum pernah mengajukan Ganti Judul LP. Gagal Mencetak.11111";
						/*$result_insert1= mysql_query("INSERT INTO no_surat (`NRP`,`N_SKDP`,`N_ST`,`N_SK`,`N_ULUR`,`N_GANDOS`,`N_GANDUL`,`N_urut_SK`,`N_undangan`,`N_urut_ST`,`N_urut_gandul`,`N_urut_gandos`,`N_urut_ulur`,`N_urut_undangan`) VALUES ( '".$frm_nrp."', '', '', '', '', '', '".$frm_no_surat_gandul_baru."',NULL,NULL,NULL,".$frm_no_urut_surat_gandul_terakhir.",NULL,NULL,NULL)");
						if ($result_insert1)
						{
								?>
								<script language="JavaScript">
										newwindow=window.open('form_cetak_gandul_LP.php?nrp=<? echo $frm_nrp;?>&no_gandul_LP=<? echo $frm_no_surat_gandul_baru;?>','name','top=0,left=510,scrollbars=yes');
										if (window.focus) {newwindow.focus()}
								</script>
								<?
						}
						else
						{
							$error = 1;
							$pesan = $pesan."<br>Proses Cetak data GAGAL. Segera hubungi administrator". mysql_error();
						}*/
					$error = 1;
					$pesan = $pesan."<br>Mahasiswa belum pernah mengajukan LP. Gagal mencetak data.". mysql_error();

					}			
		}
	}


// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	$frm_nrp="";
	$frm_nama="";
	$frm_no_surat_gandul_terakhir = "";
	$frm_no_surat_gandul_baru = "";
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_nrp!='')  {
$result = mysql_query("SELECT master_mhs.NRP,
							  master_mhs.NAMA,
							  `no_surat`.`N_gandul`
						FROM `master_mhs` LEFT JOIN `no_surat` ON `master_mhs`.`NRP` = `no_surat`.`NRP`
					   WHERE `master_mhs`.`NRP` =  '".$frm_nrp."'");

							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_nama = $row["NAMA"];
								$frm_no_surat_gandul_baru = $row["N_gandul"];
								//if ($frm_id_kota_asal!='') {
								$result2 = mysql_query("SELECT N_GANDUL, N_urut_gandul FROM no_surat WHERE N_GANDUL <>'' ORDER BY N_urut_gandul DESC LIMIT 1");
								$row2 = mysql_fetch_array($result2);
								$frm_no_surat_gandul_terakhir = $row2["N_GANDUL"];//}
								$frm_no_urut_surat_gandul_terakhir = $row2["N_urut_gandul"];
								$frm_no_urut_surat_gandul_terakhir++;
							}else
							{$frm_exist=0; header("Location: mhs_cetak_surat_gandul_LP.php"); }		
}

}

?>

<html>
<head>
<meta http-equiv="Refresh" content="120; URL=mhs_cetak_surat_gandul_LP.php">
<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style><script language="JavaScript" src="../../include/tanggalan.js" >
</script>
</head>
<body class="body">
<form name="mhs" id="mhs" action="mhs_cetak_surat_gandul_LP.php" method="post">
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
              ~</strong> SURAT GANTI JUDUL LP</font></font></td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr> 
      <td width="7%">&nbsp;</td>
      <td width="23%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="69%">
	  <input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" >
	  <input name="frm_no_urut_surat_gandul_terakhir" type="hidden" id="frm_no_urut_surat_gandul_terakhir"  value="<?php echo $frm_no_urut_surat_gandul_terakhir; ?>" >
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>NRP yg akan dicetak</td>
      <td><strong>:</strong></td>
      <td><input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="10" >
      <span class="style1">*
      <? if (isset($frm_nrp)) echo $frm_nama;?>
      </span>
	  <input name="frm_nama" type="hidden" id="frm_nama"  value="<?php echo $frm_nama; ?>" >
	  </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td nowrap>No. surat ganti judul LP terakhir</td>
      <td width="1%"><strong>:</strong></td>
      <td><input name="frm_no_surat_gandul_terakhir" type="text" class="tekboxku" id="frm_no_surat_gandul_terakhir" onBlur="document.mhs.submit()" value="<?php echo $frm_no_surat_gandul_terakhir; ?>" size="15" maxlength="9" > 
        <span class="style1">*</span></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>No. surat ganti judul LP</td>
      <td><strong>:</strong></td>
      <td><input name="frm_no_surat_gandul_baru" type="text" class="tekboxku" id="frm_no_surat_gandul_baru" value="<?php echo $frm_no_surat_gandul_baru; ?>" size="15" maxlength="9" >
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
		<input type="reset" name="Submit2" value="Batal" onclick="this.form.action+='?act=3';this.form.submit();" class="tombol"> 
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