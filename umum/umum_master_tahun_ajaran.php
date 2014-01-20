<?php
/* 
   DATE CREATED : 12/12/07
  	  		  
   KEGUNAAN     : SETTING TAHUN AJARAN/ SEMESTER
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/
session_start();
require("../include/global.php");
require("../include/fungsi.php");


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
			$pesan=$pesan."<br>Maaf, Anda harus mengisi semua data isian.";
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
					$result = mysql_query("INSERT INTO tahun_ajar( `id` , `tahun_ajaran` , `semester` , `awal` , `akhir` ) VALUES (NULL, '".$frm_tahun_ajaran."', '".$frm_semester."', '".$frm_awal."', '".$frm_akhir."') " );

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

$result = mysql_query("UPDATE tahun_ajar 
						set `tahun_ajaran` ='$frm_tahun_ajaran', 
						    `semester` ='$frm_semester', 
							`awal` ='$frm_awal', 
							`akhir`='$frm_akhir' 
					  where `id`='$frm_id'");

	
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
// kalau user mengisi tahun ajaran dan semester, kemudian pindah ke isian yang lain, maka di check apakah data tahun ajaran dan semester sudah ada, kalau sudah ada maka data akan ditampilkan
if (($frm_tahun_ajaran!='') and ($frm_semester!=''))  {
$result = mysql_query("Select id, 
							  DATE_FORMAT(awal,'%d/%m/%Y') as awal, 
							  DATE_FORMAT(akhir,'%d/%m/%Y') as akhir,
							  semester,
							  tahun_ajaran  
						 FROM tahun_ajar 
						WHERE tahun_ajaran ='$frm_tahun_ajaran' and semester ='$frm_semester'");
						//$pesan=$pesan."Select id, DATEFORMAT(awal,'%d/%m/%Y') as awal, DATEFORMAT(akhir,'%d/%m/%Y') as akhir  from tahun_ajar where tahun_ajaran ='$frm_tahun_ajaran' and semester ='$frm_semester'";
						if ($row = mysql_fetch_array($result)) {
							$frm_id = $row["id"];
							$frm_awal= $row["awal"];
							$frm_akhir= $row["akhir"];
							$frm_semester= $row["semester"];
							$frm_tahun_ajaran= $row["tahun_ajaran"];
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
<form name="form_tahun_ajaran" id="form_tahun_ajaran" action="umum_master_tahun_ajaran.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr>
      <td colspan="4"><img src="spacer" height="1"></td>
    </tr>
    <tr>
      <td colspan="4"><font color="#FF0000" ><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr>
      <td colspan="4"><hr size="1" color="#FF9900">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>SETTING ~</strong> MASTER TAHUN AJARAN </font></font> </td>
              <td width="9%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">UMUM</font></strong></div></td>
            </tr>
          </table>
          <hr size="1" color="#FF9900"></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td width="15%">&nbsp;</td>
      <td width="15%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="83%">&nbsp;
          <input type="hidden" name="frm_id" value="<?php echo $frm_id;?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>id</td>
      <td><strong>:</strong></td>
      <td> <?php echo $frm_id;?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tahun Ajaran</td>
      <td><strong>:</strong></td>
      <td><input name="frm_tahun_ajaran" type="text" class="tekboxku" id="frm_tahun_ajaran" value="<?php echo $frm_tahun_ajaran; ?>" size="10" maxlength="10"  >
          <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Semester</td>
      <td><strong>:</strong></td>
      <td><select name="frm_semester" class="tekboxku" onChange="document.form_tahun_ajaran.submit()">
          <option>Semester</option>
          <option value="GASAL" <?php if ($frm_semester=="GASAL") { echo "selected"; }?>>Gasal</option>
          <option value="GENAP" <?php if ($frm_semester=="GENAP") { echo "selected"; }?>>Genap</option>
        </select>
          <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tanggal Awal</td>
      <td><strong>:</strong></td>
      <td><input name="frm_awal" type="text" class="tekboxku" value="<?php echo $frm_awal; ?>" size="10" maxlength="10">
          <a href="javascript:show_calendar('form_tahun_ajaran.frm_awal',0,0,'DD/MM/YYYY')"> <img src="../img/date.png" width="22" height="22" align="bottom" border=0> </a>(dd/mm/yyyy) <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tanggal Akhir</td>
      <td><strong>:</strong></td>
      <td><input name="frm_akhir" type="text" class="tekboxku" value="<?php echo $frm_akhir; ?>" size="10" maxlength="10">
          <a href="javascript:show_calendar('form_tahun_ajaran.frm_akhir',0,0,'DD/MM/YYYY')"> <img src="../img/date.png" width="22" height="22" align="bottom" border=0> </a>(dd/mm/yyyy) <span class="style1">*</span></td>
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
      <td><input name="Submit" type="submit" class="tombol" onClick="this.form.action+='?act=1';this.form.submit();" value="Simpan">
          <input name="Submit2" type="reset" class="tombol" onClick="this.form.action+='?act=3';this.form.submit();" value="Batal">
          <?php if ($frm_id) { ?>
          <input name="Submit3" type="button" class="tombol"  onClick="if(confirm('Hapus data ini?')){this.form.action+='?act=2&id=<?php echo $frm_id;?>';this.form.submit()};" value="Hapus">
          <?php } ?></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><font size="1"><span class="style1">*</span> = compulsory / harus diisi</font></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">
	  <?
	    $res_thn_ajar = @mysql_query("SELECT id, 
											 tahun_ajaran, 
											 semester, 
											 DATE_FORMAT(awal,'%d - %m - %Y') as tgl_awal, 
											 DATE_FORMAT(akhir,'%d - %m - %Y') as tgl_akhir 
									    FROM tahun_ajar 
								    ORDER BY awal DESC");
			/*if ($row_thn_ajar = mysql_fetch_array($res_thn_ajar)) {
				$frm_id = $row["id"];
				$frm_awal= $row["tgl_awal"];
				$frm_akhir= $row["tgl_akhir"];
				$frm_semester= $row["semester"];
				$frm_tahun_ajaran= $row["tahun_ajaran"];
			}*/
			
			
	  ?>
	  <table width="50%"  border="1" align="center" cellpadding="5" cellspacing="0" class="table">
          <tr bgcolor="#C6E2FF">
            <td><strong>Tahun Ajaran </strong></td>
            <td nowrap><strong>Semester</strong></td>
            <td nowrap><strong>Tgl. Awal </strong></td>
            <td nowrap><strong>Tgl. Akhir </strong></td>
          </tr>
          <?
//$a=0;
while ($row_thn_ajar=@mysql_fetch_object($res_thn_ajar))  {
	//$a++;
?>
          <tr>
            <td nowrap align="center"><? echo $row_thn_ajar->tahun_ajaran; ?></td>
            <td nowrap align="center"> <? echo $row_thn_ajar->semester;?></td>
            <td nowrap><? echo $row_thn_ajar->tgl_awal; ?></td>
            <td nowrap><? echo $row_thn_ajar->tgl_akhir; ?></td>
          </tr>
          <?
}
?>
      </table></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>