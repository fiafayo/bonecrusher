<?php
/* 
   DATE CREATED : 03/11/07 - RAHADI
   KEGUNAAN     : SETTING TAHUN AJARAN
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/
session_start();
require("../include/global.php");
require("../include/sia_function.php");

f_connecting();
	mysql_select_db($DB);

if ($act==1)   
{ // simpan data
	// Pemeriksaan tanggal, apakah tanggal yang dimasukkan valid
	if ($frm_awal!='') 
		{
			if (datetomysql($frm_awal)) 
				{
					$frm_awal = datetomysql($frm_awal);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal awal tidak valid";
				}
		}
if ($frm_akhir!='') 
		{
			if (datetomysql($frm_akhir)) 
				{
					$frm_akhir = datetomysql($frm_akhir);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal akhir tidak valid";
				}
		}

// Kode dan nama harus diisi

	if (($frm_tahun_ajaran=='') or ($frm_semester=='') or ($frm_awal=='') or ($frm_akhir=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, anda harus mengisi semua isian. ";
		}

	if ($error==1) 
		{
			$pesan=$pesan."<br>Gagal menyimpan data.";
		}
	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_id=='') 
				{
					$result = mysql_query("INSERT INTO tahun_ajar( `id` , `tahun_ajaran` , `semester` , `awal` , `akhir` ) VALUES ( '', '".$frm_tahun_ajaran."', '".$frm_semester."', '".$frm_awal."', '".$frm_akhir."') " );

					if ($result) 
						{
							$pesan = $pesan."<br>Data telah ditambahkan";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data";
						}
				}
			else
				{

$result = mysql_query("UPDATE tahun_ajar set `tahun_ajaran` ='$frm_tahun_ajaran', `semester` ='$frm_semester', `awal` ='$frm_awal', `akhir`='$frm_akhir' where `id`='$frm_id'");
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menyimpan data";
						}
				}
		}
	}


if ($act==2) { // hapus data
$result = mysql_query("delete from tahun_ajar where id = ".$frm_id);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) 
{
	$frm_id="";
	$frm_tahun_ajaran="";
	$frm_semester="";
	$frm_awal="";
	$frm_akhir="";
}
else
{
// Jika user mengisi tahun ajaran dan semester, maka di check apakah data tahun ajaran dan semester sudah ada, kalau sudah ada maka data akan ditampilkan
if (($frm_tahun_ajaran!='') and ($frm_semester!=''))  {
$result = mysql_query("Select id, 
                              DATE_FORMAT(awal,'%d/%m/%Y') as awal, 
							  DATE_FORMAT(akhir,'%d/%m/%Y') as akhir  
					   from tahun_ajar 
					   where tahun_ajaran ='$frm_tahun_ajaran' and semester ='$frm_semester'");
//$pesan=$pesan."Select id, DATEFORMAT(awal,'%d/%m/%Y') as awal, DATEFORMAT(akhir,'%d/%m/%Y') as akhir  from tahun_ajar where tahun_ajaran ='$frm_tahun_ajaran' and semester ='$frm_semester'";
if ($row = mysql_fetch_array($result)) {
	$frm_id = $row["id"];
	$frm_awal= $row["awal"];
	$frm_akhir= $row["akhir"];
}

}

}

?>
<html>
<head>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<script language="JavaScript" src="../include/tanggalan.js">
</script>
<body class="body">
<form name="umum_thn_ajar" id="umum_thn_ajar" action="umum_6.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="3"><img src="spacer" height="1"></td>
    </tr>
    <tr> 
      <td colspan="3"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr>
      <td colspan="3"><hr size="1" color="#FF9900">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>SETTING ~</strong> TAHUN AJARAN </font></font> </td>
            <td width="9%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">UMUM</font></strong></div></td>
          </tr>
        </table>
      <hr size="1" color="#FF9900"></td>
    </tr>
    <tr> 
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td width="15%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="83%">&nbsp; <input type="hidden" name="frm_id" id="frm_id" value="<?php echo $frm_id;?>"></td>
    </tr>
    <tr> 
      <td>Tahun Ajaran</td>
      <td><strong>:</strong></td>
      <td><input name="frm_tahun_ajaran" type="text" class="tekboxku" id="frm_tahun_ajaran" value="<?php echo $frm_tahun_ajaran; ?>" size="10" maxlength="10"  >
      <span class="style1">*</span></td>
    </tr> 
    <tr> 
      <td>Semester</td>
      <td><strong>:</strong></td>
      <td><select name="frm_semester" id="frm_semester" class="tekboxku" onChange="document.umum.submit()">
	 	  <option>Semester</option>
          <option value="GASAL" <?php if ($frm_semester=="GASAL") { echo "selected"; }?>>Gasal</option>
          <option value="GENAP" <?php if ($frm_semester=="GENAP") { echo "selected"; }?>>Genap</option>
        </select>
        <span class="style1">*</span></td>
    </tr>
	
    <tr> 
      <td>Tanggal Awal</td>
      <td><strong>:</strong></td>
      <td><input name="frm_awal" type="text" class="tekboxku" value="<?php echo $frm_awal; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('umum_thn_ajar.frm_awal',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="bottom" border=0> 
        </A>(dd/mm/yyyy) <span class="style1">*</span></td>
    </tr>
    <tr> 
      <td>Tanggal Akhir</td>
      <td><strong>:</strong></td>
      <td><input name="frm_akhir" type="text" class="tekboxku" value="<?php echo $frm_akhir; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('umum_thn_ajar.frm_akhir',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="bottom" border=0> 
        </A>(dd/mm/yyyy) <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Simpan" onClick="this.form.action+='?act=1';this.form.submit();">
        <input type="reset" name="Submit2" value="Batal" onClick="this.form.action+='?act=3';this.form.submit();">
        <?php if ($frm_id) { ?>
        <input type="button" name="Submit3" value="Hapus"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_id;?>';this.form.submit()};">
        <?php } ?></td>
    </tr>
    <tr> 
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="3"><font size="1"><span class="style1">*</span> = compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>