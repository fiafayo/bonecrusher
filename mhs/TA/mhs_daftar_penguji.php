<?php
/* 
   DATE CREATED : 29/06/07
   KEGUNAAN     : ENTRY DATA DAFTAR PENGUJI
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
$frm_judul_ta= ( isset( $_REQUEST['frm_judul_ta'] ) ) ? $_REQUEST['frm_judul_ta'] : '';
$frm_kode_ketua= ( isset( $_REQUEST['frm_kode_ketua'] ) ) ? $_REQUEST['frm_kode_ketua'] : null;
$frm_kode_sekre= ( isset( $_REQUEST['frm_kode_sekre'] ) ) ? $_REQUEST['frm_kode_sekre'] : null;
$frm_kode_dosen_1= ( isset( $_REQUEST['frm_kode_dosen_1'] ) ) ? $_REQUEST['frm_kode_dosen_1'] : null;
$frm_kode_dosen_2= ( isset( $_REQUEST['frm_kode_dosen_2'] ) ) ? $_REQUEST['frm_kode_dosen_2'] : null;
$frm_kode_dosen_3= ( isset( $_REQUEST['frm_kode_dosen_3'] ) ) ? $_REQUEST['frm_kode_dosen_3'] : null;
$frm_no_sk= ( isset( $_REQUEST['frm_no_sk'] ) ) ? $_REQUEST['frm_no_sk'] : null;
$frm_tgl_ujian = ( isset( $_REQUEST['frm_tgl_ujian'] ) ) ? $_REQUEST['frm_tgl_ujian'] : null;
$frm_ruang_ujian = ( isset( $_REQUEST['frm_ruang_ujian'] ) ) ? $_REQUEST['frm_ruang_ujian'] : null;
$frm_nama = ( isset( $_REQUEST['frm_nama'] ) ) ? $_REQUEST['frm_nama'] : null;
$pesan= ( isset( $_REQUEST['pesan'] ) ) ? $_REQUEST['pesan'] : null;
$error= ( isset( $_REQUEST['error'] ) ) ? $_REQUEST['error'] : null;


if ($act==1)   
{ // simpan data
	// cek apa sudah bikin SURAT TUGAS TA
	$result_cek_ST = mysql_query("SELECT N_ST FROM no_surat WHERE no_surat.NRP='$frm_nrp'");
	$row_cek_ST = mysql_fetch_array($result_cek_ST);
	if (($row_cek_ST["N_ST"]=='')or($row_cek_ST["N_ST"]==NULL))
	{
		   $error = 1;
		   $pesan = $pesan."<br>Surat Tugas TA mahasiswa tersebut belum dicetak.";
		   //echo "<br>Surat Tugas TA mahasiswa tersebut belum dicetak";
	}
	else
	{
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
		
		// Kode dan nama harus diisi  
			if (($frm_nrp=='') or ($frm_no_urut_SK_terakhir=='') or ($frm_no_sk_terakhir=='') or ($frm_no_sk=='') or ($frm_kode_ketua=='') or ($frm_kode_sekre=='') or ($frm_kode_dosen_1=='') or ($frm_kode_dosen_2=='')  or ($frm_tgl_ujian=='') or ($frm_ruang_ujian=='') ) 
				{
					$error = 1;
					$pesan=$pesan."<br>Maaf, Anda harus mengisi data 'DAFTAR PENGUJI' dengan lengkap. Gagal menyimpan data !";
				}
		/*		
		    if (strlen($frm_no_sk_row) < 9)
			{
				$error = 1;
				$pesan=$pesan."<br>Maaf, Anda harus mengisi No SK dengan benar(harus 9 digit Angka). Gagal menyimpan data !";
			}
			*/
//$cek_jum_huruf_sk = strlen(frm_no_sk);
//echo "<br>cek_jum_huruf_sk=".$cek_jum_huruf_sk;
//exit();
			if ($error !=1) // Jika semua isian form valid 
				{
				// data id tidak ada, berarti record baru
					if ($frm_exist!=1) 
						{
							$result_cek_ACC = mysql_query("SELECT * FROM master_ta WHERE master_ta.NRP='$frm_nrp'");
							$row_ACC = mysql_fetch_array($result_cek_ACC);
							if (($row_ACC["ACC1"]=='') and ($row_ACC["ACC2"]==''))
							{
								   $error = 1;
								   $pesan = $pesan."<br>Proses entry data GAGAL. Silahkan masukkan Kesediaan Pembimbing dulu";
							}
							else
							{
							//cek SK sudah dipakai apa belum
							/*$result_cek_NO_SK = mysql_query("SELECT NO_SK FROM daftar_uji WHERE daftar_uji.NO_SK='$frm_no_sk'");
							$jum_cek_NO_SK = mysql_num_rows($result_cek_NO_SK);
									
									if ($jum_cek_NO_SK==0)
									{*/
											
											$result = mysql_query("INSERT INTO daftar_uji ( `nrp` , `NO_SK` , `UR_NOSK` , `kode_ketua`, `kode_sekre` , `kode_dosen1` , `kode_dosen2` , `kode_dosen3` , `tgl_ujian` , `ruang_ujian` ) VALUES ( '".$frm_nrp."', '".$frm_no_sk."', '".$frm_no_urut_SK_terakhir."', '".$frm_kode_ketua."', '".$frm_kode_sekre."', '".$frm_kode_dosen_1."', '".$frm_kode_dosen_2."', '".$frm_kode_dosen_3."', '".$frm_tgl_ujian."', '".$frm_ruang_ujian."') " );
											if ($result) 
												{
													//$result_insert1= mysql_query("INSERT INTO no_surat (`NRP`,`N_SKDP`,`N_ST`,`N_SK`,`N_ULUR`,`N_GANDOS`,`N_GANDUL`,`N_urut_SK`,`N_undangan`,`N_urut_ST`,`N_urut_gandul`,`N_urut_gandos`,`N_urut_ulur`,`N_urut_undangan`) VALUES ('".$frm_nrp."', '', '', '".$frm_no_sk."', '', '', '',".$frm_no_urut_SK_terakhir.",'',NULL,NULL,NULL,NULL,NULL)");
													$result_update1 = mysql_query("UPDATE no_surat SET `N_SK`='$frm_no_sk', N_urut_SK='$frm_no_urut_SK_terakhir' WHERE `NRP`='$frm_nrp'");
													if ($result_update1)
													{
														$pesan = $pesan."<br>Proses entry data BERHASIL";
													}
													else
													{
														$error = 1;
														$pesan = $pesan."<br>Proses entry data GAGAL. Segera hubungi administrator - ". mysql_error();
													}
												}
											else
												{ 
													$error = 1;
													$pesan = $pesan."<br>Proses entry data GAGAL";
												}
									/*}
									else
									{
											$error = 1;
											$pesan = $pesan."<br>Proses entry data GAGAL. Nomor SK sudah ada, masukkan nomor yang lain.";
									}*/
							}
						}
					else
						{
							$result = mysql_query("UPDATE daftar_uji SET `NO_SK`='$frm_no_sk',
																		 `kode_ketua`='$frm_kode_ketua', 
																		 `kode_sekre`='$frm_kode_sekre', 
																		 `kode_dosen1`='$frm_kode_dosen_1', 
																		 `kode_dosen2`='$frm_kode_dosen_2', 
																		 `kode_dosen3`='$frm_kode_dosen_3', 
																		 `tgl_ujian`='$frm_tgl_ujian', 
																		 `ruang_ujian`='$frm_ruang_ujian'  
																   WHERE `nrp`='$frm_nrp'");
							if ($result) 
								{
								//echo "<br>frm_no_sk_row=".$frm_no_sk_terakhir;
								//echo "<br>frm_no_sk=".$frm_no_sk;
								//exit();
									if ($frm_no_sk==$frm_no_sk_terakhir)
									{
									    $result_update1 = mysql_query("UPDATE no_surat SET `N_SK`='$frm_no_sk' WHERE `NRP`='$frm_nrp'");
									}
									else
									{
										//$result_update1 = mysql_query("UPDATE no_surat SET `N_SK`='$frm_no_sk', N_urut_SK='$frm_no_urut_SK_terakhir' WHERE `NRP`='$frm_nrp'");
										$result_update1 = mysql_query("UPDATE no_surat SET `N_SK`='$frm_no_sk' WHERE `NRP`='$frm_nrp'");
									}
									if ($result_update1)
									{
										$pesan = $pesan."<br>Proses update data BERHASIL";
									}
									else
									{
										$error = 1;
										$pesan = $pesan."<br>Proses update data GAGAL. Segera hubungi administrator - ". mysql_error();
									}
								}
							else
								{ 
									$error = 1;
									$pesan = $pesan."<br>Proses update data GAGAL - ". mysql_error();
								}
						}
				}
			}
}

if ($act==2) { // hapus data

$result = mysql_query("DELETE FROM daftar_uji WHERE nrp = '".$frm_nrp."'");
if ($result)
{
	$result2 = mysql_query("UPDATE no_surat SET `N_SK`='', N_urut_SK=0  WHERE `NRP`='$frm_nrp'");
	if ($result2) {$pesan = "Data telah dihapus";	}else{ $pesan = "Gagal menghapus data";}
}	
else
{
    $pesan = "Gagal menghapus data";}
}

// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	$frm_nrp = "";
	$frm_no_sk_terakhir = "";
	$frm_no_sk = "";
	$frm_nama = "";
	$frm_kode_ketua = "";
	$frm_kode_sekre = "";
	$frm_kode_dosen_1 = "";
	$frm_kode_dosen_2 = "";
	$frm_kode_dosen_3 = "";
	$frm_tgl_ujian = "";
	$frm_ruang_ujian = "";
}
else
{
// kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
if ($frm_nrp!='')  {
$result = mysql_query("SELECT	master_mhs.NRP,
								master_mhs.NAMA,
								`daftar_uji`.`kode_ketua`,
								`daftar_uji`.`kode_sekre`,
								`daftar_uji`.`kode_dosen1`,
								`daftar_uji`.`kode_dosen2`,
								`daftar_uji`.`kode_dosen3`,
								 DATE_FORMAT(`daftar_uji`.`tgl_ujian`,'%d/%m/%Y') as tgl_ujian,
								`daftar_uji`.`ruang_ujian`
							FROM 
							    `master_mhs` LEFT JOIN `daftar_uji` ON `master_mhs`.`NRP` = `daftar_uji`.`NRP`
							WHERE
								`master_mhs`.`NRP` =  '".$frm_nrp."'");

							if ($row = mysql_fetch_array($result)) {
								$frm_exist=1;
								$frm_nama = $row["NAMA"];
								//$frm_no_sk = $row["no_sk_awal"];
								//$frm_no_sk_terakhir = $row["urut_no_sk"];
									$frm_kode_ketua = $row["kode_ketua"];
									$frm_kode_sekre = $row["kode_sekre"];
									$frm_kode_dosen_1 = $row["kode_dosen1"];
									$frm_kode_dosen_2 = $row["kode_dosen2"];
									$frm_kode_dosen_3 = $row["kode_dosen3"];
								
								$frm_tgl_ujian = $row["tgl_ujian"];
								if (($row["tgl_ujian"]=="00/00/0000") or ($row["tgl_ujian"]==""))
								{
									$frm_tgl_ujian = ""; 
									$frm_exist = 0;
								}
								else 
								{
									$frm_tgl_ujian = $row["tgl_ujian"];
								}
								$frm_ruang_ujian = $row["ruang_ujian"];
								
								$result_tampil_no_sk = mysql_query("SELECT N_SK, N_urut_SK FROM no_surat WHERE N_SK<>'' and NRP='".$frm_nrp."'");
								$row_tampil_no_sk = mysql_fetch_array($result_tampil_no_sk);
								$frm_no_sk = $row_tampil_no_sk["N_SK"];
								$frm_no_urut_SK_terakhir=$row_tampil_no_sk["N_urut_SK"];
								//echo "frm_no_sk= ".$frm_no_sk; 
								//$frm_no_urut_sk_terakhir = $row_tampil_no_sk["N_urut_ST"];
								
								
							}else
							{$frm_exist = 0; 
							//header("Location: mhs_daftar_penguji.php");
							}
}
	
	if ($frm_kode_ketua!='') {
		$result = mysql_query("Select nama from dosen where kode='$frm_kode_ketua'");
		$row = mysql_fetch_array($result);
		$frm_nama_ketua = $row["nama"];
	}	

	if ($frm_kode_sekre!='') {
		$result = mysql_query("Select nama from dosen where kode='$frm_kode_sekre'");
		$row = mysql_fetch_array($result);
		$frm_nama_sekre = $row["nama"];
	}	

	if ($frm_kode_dosen_1!='') {
		$result = mysql_query("Select nama from dosen where kode='$frm_kode_dosen_1'");
		$row = mysql_fetch_array($result);
		$frm_nama_dosen_1 = $row["nama"];
	}	
	
	if ($frm_kode_dosen_2!='') {
		$result = mysql_query("Select nama from dosen where kode='$frm_kode_dosen_2'");
		$row = mysql_fetch_array($result);
		$frm_nama_dosen_2 = $row["nama"];
	}	
	
	if ($frm_kode_dosen_3!='') {
		$result = mysql_query("Select nama from dosen where kode='$frm_kode_dosen_3'");
		$row = mysql_fetch_array($result);
		$frm_nama_dosen_3 = $row["nama"];
	}	
	//echo "<br>frm_kode_ketua= ".$frm_kode_ketua;
	//echo "<br>frm_nama_ketua= ".$_POST['frm_nama_ketua'];
}

?>
<html>
<head>
<meta http-equiv="Refresh" content="60; URL=mhs_daftar_penguji.php">

<link href="../../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {color: #00CC00}
-->
</style>

<script language="JavaScript" src="../../include/tanggalan.js">
</script>
<script language="javascript">

var no_sk_filter=/^\d{9}$/

function cek_SK(e){
var returnval=no_sk_filter.test(e.value)
if (returnval==false){
alert("Nomor SK harus 9 digit Angka")
e.select()
e.focus()
}
return returnval
}

</script>
<SCRIPT language="JavaScript1.2" src="../../include/main.js" type="text/javascript"></SCRIPT>  
</head>
<body class="body">
<DIV id="TipLayer" style="visibility:hidden;position:absolute;z-index:1000;top:-100;"></DIV>
 <SCRIPT language="JavaScript1.2" src="../../include/style.js" type="text/javascript"></SCRIPT> 
 
<form name="form_daftar_uji_ta" id="form_daftar_uji_ta" action="mhs_daftar_penguji.php" method="post">
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
              DATA ~</strong>  DAFTAR PENGUJI</font></font> </td>
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
      <td><input name="frm_nrp" type="text" class="tekboxku" id="frm_nrp" onBlur="document.form_daftar_uji_ta.submit()" value="<?php echo $frm_nrp; ?>" size="10" maxlength="10" >
        <span class="style1">* <? if (isset($frm_nrp)) echo $frm_nama;?></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>No SK Terakhir </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <? 
			$result_no_sk = mysql_query("SELECT N_SK, N_urut_SK FROM no_surat WHERE N_SK<>'' ORDER BY N_urut_SK DESC LIMIT 1");
			$row_no_sk = mysql_fetch_array($result_no_sk);
			$frm_no_sk_terakhir = $row_no_sk["N_SK"];
			$frm_no_urut_SK_terakhir = $row_no_sk["N_urut_SK"];
			$frm_no_urut_SK_terakhir++;
	  ?>
	  <? //echo $frm_no_urut_SK_terakhir;?>
	  <input name="frm_no_sk_terakhir" readonly="true" type="text" class="tekboxku" id="frm_no_sk_terakhir" value="<?php echo $frm_no_sk_terakhir; ?>" size="10" maxlength="9">
        <input type="hidden" name="frm_no_urut_SK_terakhir" id="frm_no_urut_SK_terakhir" value="<? echo $frm_no_urut_SK_terakhir;?>">
		<span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>No SK Sekarang </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
	  <input type="hidden" name="frm_no_sk_row" id="frm_no_sk_row" value="<?php echo $frm_no_sk_terakhir; ?>">
	  <input name="frm_no_sk"  onMouseOver="stm(Text[14],Style[12])" onMouseOut="htm()" type="text" class="tekboxku" id="frm_no_sk" value="<?php echo $frm_no_sk; ?>" size="10" maxlength="9">
        <span class="style1">*</span>
      </td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td> 
      <td nowrap>NPK Ketua</td>
      <td><div align="center"><strong>:</strong></div></td>
      <td> <select name="frm_kode_ketua" id="frm_kode_ketua" class="tekboxku">
           <option <?php if ($frm_kode_ketua==''){echo "selected";}?> value=''>--- Pilih ---</option>
          <?php 
				$sqlDosen="select kode, nama
						   from dosen  where (length(kode)=6) ORDER BY kode ASC";
				
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->kode; ?>" <?php if ($frm_kode_ketua==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
          <?php
				}
				
				?>
        </select>        
		<span class="style1">*</span>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>NPK Sekretaris </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
		<select name="frm_kode_sekre" id="frm_kode_sekre" class="tekboxku">
		  <option <?php if ($frm_kode_sekre==''){echo "selected";}?> value=''>--- Pilih ---</option>
		  <?php 
				$sqlDosen="select kode, nama
						   from dosen  where (length(kode)=6)  ORDER BY kode ASC";
						
						$result = @mysql_query($sqlDosen);
						$c=0;
						while ($row=@mysql_fetch_object($result))  {
						$c=$c+1;
						?>
		  <option value="<?php echo $row->kode; ?>" <?php if ($frm_kode_sekre==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
		  <?php } ?>
		</select>
		<span class="style1">*</span>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>NPK Dosen 1 </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
			<select name="frm_kode_dosen_1" id="frm_kode_dosen_1" class="tekboxku">
			  <option <?php if ($frm_kode_dosen_1==''){echo "selected";}?> value=''>--- Pilih ---</option>
			  <?php 
							$sqlDosen="select kode, nama
									   from dosen  where (length(kode)=6) ORDER BY kode ASC";
							
							$result = @mysql_query($sqlDosen);
							$c=0;
							while ($row=@mysql_fetch_object($result))  {
							$c=$c+1;
							?>
			  <option value="<?php echo $row->kode; ?>" <?php if ($frm_kode_dosen_1==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
			  <?php } ?>
			</select>
			<span class="style1">*</span>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>NPK Dosen 2 </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
			<select name="frm_kode_dosen_2" id="frm_kode_dosen_2" class="tekboxku">
			  <option <?php if ($frm_kode_dosen_2==''){echo "selected";}?> value=''>--- Pilih ---</option>
			  <?php 
							$sqlDosen="select kode, nama
									   from dosen  where (length(kode)=6) ORDER BY kode ASC";
							
							$result = @mysql_query($sqlDosen);
							$c=0;
							while ($row=@mysql_fetch_object($result))  {
							$c=$c+1;
							?>
			  <option value="<?php echo $row->kode; ?>" <?php if ($frm_kode_dosen_2==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
			  <?php }?>
			</select>
			 <span class="style1">*</span>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>NPK Dosen 3 </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td>
			<select name="frm_kode_dosen_3" id="frm_kode_dosen_3" class="tekboxku">
			  <option <?php if ($frm_kode_dosen_3==''){echo "selected";}?> value=''>--- Pilih ---</option>
			  <?php 
							$sqlDosen="select kode, nama
									   from dosen  where (length(kode)=6) ORDER BY kode ASC";
							
							$result = @mysql_query($sqlDosen);
							$c=0;
							while ($row=@mysql_fetch_object($result))  {
							$c=$c+1;
							?>
			  <option value="<?php echo $row->kode; ?>" <?php if ($frm_kode_dosen_3==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
			  <?php }?>
			</select>
	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal Ujian </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_tgl_ujian" type="text" class="tekboxku" id="frm_tgl_ujian" value="<?php if ($frm_tgl_ujian=='') {echo date("d/m/Y");} else { echo $frm_tgl_ujian;} ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('form_daftar_uji_ta.frm_tgl_ujian',0,0,'DD/MM/YYYY')"> 
        <img src="../../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)  <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Ruang Ujian </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><input name="frm_ruang_ujian" id="frm_ruang_ujian" type="text" class="tekboxku" value="<?php echo $frm_ruang_ujian; ?>" size="10" maxlength="10">
        <span class="style1">*</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <!--td>Status Kuliah </td>
      <td><div align="center"><strong>:</strong></div></td>
      <td><select name="frm_semester" class="tekboxku">
	  		<? /*if (isset($frm_semester)) {?>
			<option value="S" <? if ($frm_semester=="S") echo "selected"?>>SELESAI</option>
			<option value="" <? if ($frm_semester=="") echo "selected"?>>BELUM</option>
			<? } else {?>
			<option value="S">SELESAI</option>
			<option value="" selected>BELUM</option>
			<? }*/?>
      </select></td-->
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