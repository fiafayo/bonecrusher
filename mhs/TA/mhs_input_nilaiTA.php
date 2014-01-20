<?php
/* 
   DATE CREATED : 23/10/07
   KEGUNAAN     : ENTRY DATA NILAI TA
   VARIABEL     : $act adalah untuk menentukan action yang akan dilakukan. 1: simpan; 2: hapus; 3:batal;
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");
include("../../include/temp.php");

f_connecting();
mysql_select_db($DB);
$act= ( isset( $_REQUEST['act'] ) ) ? $_REQUEST['act'] : 0;
$frm_nrp= ( isset( $_REQUEST['frm_nrp'] ) ) ? $_REQUEST['frm_nrp'] : null;
$frm_exist= ( isset( $_REQUEST['frm_exist'] ) ) ? $_REQUEST['frm_exist'] : null;
 
$frm_tahun= ( isset( $_REQUEST['frm_tahun'] ) ) ? $_REQUEST['frm_tahun'] : null;
$frm_semester= ( isset( $_REQUEST['frm_semester'] ) ) ? $_REQUEST['frm_semester'] : null;

$var_tgl_ujian = ( isset( $_REQUEST['frm_tgl_ujian'] ) ) ? $_REQUEST['frm_tgl_ujian'] : null;
$frm_tgl_ujian = ( isset( $_REQUEST['frm_tgl_ujian'] ) ) ? $_REQUEST['frm_tgl_ujian'] : null;
$frm_nilai_ujian = ( isset( $_REQUEST['frm_nilai_ujian'] ) ) ? $_REQUEST['frm_nilai_ujian'] : null;

$frm_nama = ( isset( $_REQUEST['frm_nama'] ) ) ? $_REQUEST['frm_nama'] : null;
$pesan= ( isset( $_REQUEST['pesan'] ) ) ? $_REQUEST['pesan'] : null;
$error= ( isset( $_REQUEST['error'] ) ) ? $_REQUEST['error'] : null;

if ($act==1)   
{ // simpan data
	// Pemeriksaan tanggal, apakah tanggal yang dimasukkan valid
	if ($frm_tgl_ujian!='') 
		{
			if (datetomysql($frm_tgl_ujian)) 
				{
					$frm_tgl_ujian = datetomysql($frm_tgl_ujian);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."<br> Tanggal Ujian TA tidak valid";
				}
		}

// validasi form isian
/*echo "<br>frm_nrp=".$frm_nrp;
echo "<br>frm_nama=".$frm_nama;
echo "<br>frm_tgl_ujian=".$frm_tgl_ujian;
echo "<br>frm_nilai_ujian=".$frm_nilai_ujian;
echo "<br>frm_semester=".$frm_semester;
echo "<br>frm_tahun=".$frm_tahun;
echo "<br>frm_exist=".$frm_exist;*/
//or ($frm_tgl_ujian=='') or ($frm_nilai_ujian=='') or ($frm_semester=='') or ($frm_tahun=='')
	if (($frm_nrp=='') or ($frm_tgl_ujian=='') or ($frm_nilai_ujian=='') or ($frm_semester=='') or ($frm_tahun==''))
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi data NILAI UJIAN TA dengan benar. Gagal menyimpan data !";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_exist!=1) 
				{
					$result = mysql_query("INSERT INTO lulus_ta (`NRP`,`tgl_ujian`,`nilai_ujian`,`semester`,`tahun`) VALUES ( '".$frm_nrp."', '".$frm_tgl_ujian."', '".$frm_nilai_ujian."', '".$frm_semester."', '".$frm_tahun."')" );
					//$result = mysql_query("INSERT INTO lulus_ta (`NRP`) VALUES('".$frm_nrp."')");
					if ($result) 
						{
							// L=LULUS S1   S= LULUS TA
							$result = mysql_query("UPDATE master_ta set `KOLUS` ='L' where `NRP`=$frm_nrp");
							$pesan = $pesan."<br>Proses entry data BERHASIL";	
						}
					else
						{ 
							$pesan = $pesan."<br>Proses entry data GAGAL";
						}
				}
			else
				{
					$result_update1 = mysql_query("UPDATE lulus_ta SET `tgl_ujian`='$frm_tgl_ujian', `nilai_ujian`='$frm_nilai_ujian', `semester`='$frm_semester', `tahun`='$frm_tahun'  where `nrp`=$frm_nrp");
					if ($result_update1) 
						{
							$result_master_ta = mysql_query("UPDATE master_ta set `KOLUS` ='L' where `NRP`=$frm_nrp");
							$pesan = $pesan."<br>Proses update data BERHASIL";	
						}
					else
						{ 
							$pesan = $pesan."<br>Proses update data GAGAL";
						}
				}
		}
	}


if ($act==2) { // hapus data
$result_del = mysql_query("delete from lulus_ta where nrp = ".$frm_nrp);
$result_del2 = mysql_query("UPDATE master_ta set `KOLUS` ='' where `NRP`=$frm_nrp");
	if ($result_del AND $result_del2) {$pesan = "Data telah dihapus";	}else{ $pesan = "Gagal menghapus data";}
}	
	
// jika data sudah masuk ke dalam database, form dikosongkan siap isi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	$frm_nrp="";
	$frm_nama="";
	$frm_tgl_ujian = "";
	$frm_nilai_ujian = "";
	$frm_tahun = "";
	$frm_semester = "";
}
else
{
// jika user mengisi NRP, maka di cek apakah data NRP sudah ada, kalau sudah ada maka data ditampilkan
if ($frm_nrp!='')  {
//echo "EXIST=".$frm_exist;

$result = mysql_query("SELECT	master_mhs.NRP,
								master_mhs.JURUSAN,
								master_mhs.NAMA,
								master_mhs.NIRM,
								master_mhs.TGLLAHIR,
								master_mhs.TMPLAHIR,
								master_mhs.TOTBSS,
								master_mhs.IPK,
								master_mhs.SKSKUM,
								`lulus_ta`.`sks`,
								`lulus_ta`.`ipk`,
								 DATE_FORMAT(`lulus_ta`.`tgl_ujian`,'%d/%m/%Y') as tgl_ujian,
								 DATE_FORMAT(`lulus_ta`.`tgl_lulus`,'%d/%m/%Y') as tgl_lulus,
								`lulus_ta`.`nilai_ujian`,
								`lulus_ta`.`tahun`,
								`lulus_ta`.`status`,
								`lulus_ta`.`semester`
							FROM `master_mhs`,`lulus_ta`
							WHERE 
								(`master_mhs`.`NRP` = `lulus_ta`.`NRP`) AND
								`master_mhs`.`NRP` =  '".$frm_nrp."'");
								
							/* FROM `master_mhs` LEFT JOIN `lulus_ta` ON `master_mhs`.`NRP` = `lulus_ta`.`NRP`	
						   WHERE `master_mhs`.`NRP` =  '".$frm_nrp."'");*/
						   
						   
							

						if ($row = mysql_fetch_array($result)) {
							$frm_exist=1;
							$frm_nama = $row["NAMA"];
							$frm_nilai_ujian = $row["nilai_ujian"];
							//$frm_sks_kum = $row["sks"];
							//$frm_ip_kum = $row["ipk"];
							$frm_tahun = $row["tahun"];
							$frm_semester = $row["semester"];
							
							$frm_tgl_ujian =$row["tgl_ujian"];
							if ($row["tgl_ujian"]=="00/00/0000") {
							$frm_tgl_ujian =""; }else {
							$frm_tgl_ujian =$row["tgl_ujian"];}
						}else
						{
							$frm_exist=0; 
							//$frm_nrp="";
							$frm_nama="";
							$frm_tgl_ujian = "";
							$frm_nilai_ujian = "";
							$frm_tahun = "";
							$frm_semester = "";
						//header("Location: mhs_input_nilaiTA.php"); 
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
<script language="JavaScript" src="../../include/tanggalan.js" type="text/javascript">
</script>
<body class="body">
<form name="mhs" id="mhs" action="mhs_input_nilaiTA.php" method="post">
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
            <td width="89%"><font color="#006699"><font color="#0099CC" size="1"><strong>ENTRY 
              DATA ~</strong>  INPUT NILAI TA </font></font> </td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">MAHASISWA</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900"> </td>
    </tr>
    <tr>
      <td width="15%">&nbsp;</td> 
      <td width="15%">&nbsp;</td>
      <td width="3%">&nbsp;</td>
      <td width="83%"><input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist; ?>" ></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>NRP</td>
      <td width="3%"><div align="center"><strong>:</strong></div></td>
      <td>
	 <?  $res_nm_mhs = mysql_query("SELECT	NAMA FROM master_mhs WHERE NRP='".$frm_nrp."'");
	 	 if ($row_nm_mhs = mysql_fetch_array($res_nm_mhs)) {
			 $frm_nama = $row_nm_mhs["NAMA"];
		 }
	 ?>
	  <input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="document.mhs.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="10" >
        <span class="style1">*<? if (isset($frm_nrp)) echo $frm_nama;?></span>
		<input name="frm_nama" type="hidden" id="frm_nama"  value="<?php echo $frm_nama; ?>" >
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tanggal Ujian TA </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <?  if ($frm_nrp<>'')
	      { 
				  $sql_tgl_ujian="SELECT DATE_FORMAT(`daftar_uji`.`tgl_ujian`,'%d/%m/%Y') as tgl_ujian
									FROM daftar_uji
								   WHERE daftar_uji.NRP='".$frm_nrp."'";
				  $result = @mysql_query($sql_tgl_ujian);
				  if ($row = mysql_fetch_array($result)) {
					 $var_tgl_ujian = $row["tgl_ujian"];
				  }
		  }
	  ?>
	  <input name="frm_tgl_ujian" type="text" class="tekboxku" id="frm_tgl_ujian" value="<?php echo $var_tgl_ujian; ?>" size="10" maxlength="10">
	  <A Href="javascript:show_calendar('mhs.frm_tgl_ujian',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)
      <span class="style1">*</span> </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nilai TA </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_nilai_ujian" id="frm_nilai_ujian" type="text" class="tekboxku" value="<?php echo $frm_nilai_ujian; ?>" size="6" maxlength="2">
        <span class="style1">*</span>        </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Periode Ujian TA </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><? //echo $frm_semester;?>
			<select name="frm_semester" id="frm_semester" class="tekboxku">
				<? if (isset($frm_semester)) {?>
				<option value="gasal" <? if ($frm_semester=="gasal") echo "selected"?>>GASAL</option>
				<option value="genap" <? if ($frm_semester=="genap") echo "selected"?>>GENAP</option>
				<? } else {?>
				<option value="gasal">GASAL</option>
				<option value="genap">GENAP</option>
				<? }?>
			</select>
				<? //echo $frm_tahun;?>
			<select name="frm_tahun" id="frm_tahun" class="tekboxku">
			<? if (isset($frm_tahun)) {
			for ( $counter = 1990; $counter <= 2020; $counter += 1) { $counter2= $counter+1; ?>
			<option value="<? echo $counter;?>" <? if ($counter==$frm_tahun) {echo "selected";}?>><? echo $counter." - ".$counter2;?></option>
			<? }?>
			<? } else {
				for ( $counter = 1990; $counter <= 2020; $counter += 1) { $counter2= $counter+1; ?>
					<option value="<? echo $counter;?>" <? if ($counter==date('Y')) {echo "selected";}?>><? echo $counter." - ".$counter2;?></option>
				<? }?>
			<? }?>
			</select>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
      <td><input type="submit" name="Submit" value="Simpan" onclick="this.form.action+='?act=1';this.form.submit();" class="tombol"> 
        <input type="reset" name="Submit2" value="Batal" onclick="this.form.action+='?act=3';this.form.submit();" class="tombol"> 
        <?php if ($frm_nama) { ?>
        <input type="button" name="Submit3" value="Hapus"  onclick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_nama;?>';this.form.submit()};" class="tombol"> 
        <?php } ?></td>
    </tr>
    <tr> 
      <td colspan="4">
      </td>
    </tr>
    <tr> 
      <td colspan="4"><font size="1"><span class="style1">*</span> compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>