<?
/* 
   DATE CREATED : 11/01/08
   KEGUNAAN     : ENTRY PENELITIAN DOSEN
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
	/*echo "<br>frm_kode_dsn= ".$frm_kode_dsn;
	echo "<br>frm_status_jabatan= ".$frm_status_jabatan;
	echo "<br>frm_publikasi= ".$frm_publikasi;
	echo "<br>frm_s_jurusan= ".$frm_s_jurusan;
	echo "<br>frm_judul= ".$frm_judul;
	echo "<br>frm_tgl_terbit= ".$frm_tgl_terbit;
	echo "<br>frm_tgl_mulai= ".$frm_tgl_mulai;
	echo "<br>frm_tgl_selesai= ".$frm_tgl_selesai;
	echo "<br>frm_jumlah_peneliti= ".$frm_jumlah_peneliti;
	echo "<br>frm_id_sumber_dana= ".$frm_id_sumber_dana;
	echo "<br>frm_dana= ".$frm_dana;
	echo "<br>frm_kode_buku= ".$frm_kode_buku;
	echo "<br>frm_jenis_pen= ".$frm_jenis_pen;
	echo "<br>frm_sifat_pen= ".$frm_sifat_pen;*/
	
	echo "<br>frm_publikasi= ".$frm_publikasi;
	
	
	if ($frm_jumlah_peneliti== '') 
	{
	  $frm_jumlah_peneliti=$jum;
	}
	
	if ($frm_tgl_terbit!='') 
		{
			if (datetomysql($frm_tgl_terbit)) 
				{
					$frm_tgl_terbit = datetomysql($frm_tgl_terbit);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."Tanggal terbit tidak valid";
				}
		}
		
	if ($frm_tgl_mulai!='') 
		{
			if (datetomysql($frm_tgl_mulai)) 
				{
					$frm_tgl_mulai = datetomysql($frm_tgl_mulai);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."Tanggal mulai tidak valid";
				}
		}
    if ($frm_tgl_selesai!='') 
		{
			if (datetomysql($frm_tgl_selesai)) 
				{
					$frm_tgl_selesai = datetomysql($frm_tgl_selesai);
				}
			else
				{
					$error = 1;
					$pesan = $pesan."Tanggal Selesai tidak valid";
				}
		}

		if (($frm_jenis_pen=='3') or ($frm_jenis_pen=='4') or ($frm_jenis_pen=='')) {
			$frm_tgl_terbit="00/00/0000";
		}
		
		if (($frm_jenis_pen=='1') or ($frm_jenis_pen=='2')) {
			$frm_tgl_mulai='00/00/0000';
		    $frm_tgl_selesai='00/00/0000';
			$frm_jumlah_peneliti=0;
			$frm_id_sumber_dana=1;
			$frm_sifat_pen="Mandiri";
		}
	
// Kode dan nama harus diisi
	if ($frm_jenis_pen=="3") //penelitian
	{
		//echo "<br>PENELITIAN";
		//echo "<br>jum=".$jum;
		if (($frm_kode_dsn1=='') or ($frm_judul=='') or ($frm_kode=='')) 
		{
			$error = 1;
			$jum=0;
			$pesan=$pesan."Maaf, Anda harus memilih Jenis Penelitian serta mengisi Dosen dan Judul. Gagal menyimpan data."; 
		}
	}
	else // tulisan ilmiah, buku dosen
	{
		//echo "<br>TULISAN";
		if (($frm_kode_dsn1=='') or ($frm_judul=='') or ($frm_jenis_pen=="0")) 
		{
			$error = 1;
			$jum=0;
			$pesan=$pesan."Maaf, Anda harus memilih Jenis Penelitian serta mengisi Dosen dan Judul. Gagal menyimpan data."; 
		}
	}
	
	

	if ($error !=1) // Jika semua isian form valid 
		{
		// data id tidak ada, berarti record baru
			if ($frm_id_pen=='') 
				{
					//$result = mysql_query("INSERT INTO penelitian(`id_pen`, `kode_dosen`, `status_jabatan`, `publikasi`, `jurusan_id`, `judul`, `tanggal_terbit`, `tanggal_mulai`, `tanggal_selesai` , `jumlah_peneliti`, `id_sumber_dana`, `dana`, `kode_buku`, `jenis_pen`, `man_kel` ) VALUES  (NULL, '".$frm_kode_dsn."', '".$frm_status_jabatan."', '".$frm_publikasi."', ".$frm_s_jurusan.", '".$frm_judul."', '".$frm_tgl_terbit."', '".$frm_tgl_mulai."', '".$frm_tgl_selesai."', ".$frm_jumlah_peneliti.", ".$frm_id_sumber_dana.", '".$frm_dana."', '".$frm_kode_buku."', ".$frm_jenis_pen.", '".$frm_sifat_pen."') " );
					//echo "<br>JUM=".$jum;
					//echo "<br>frm_tgl_terbit=".$frm_tgl_terbit;
					
					for ($i = 1; $i <= $jum; $i++) {
						$kd_dsn="frm_kode_dsn".$i;
						$status_jbtn="frm_status_jabatan".$i;
							//echo "<br>kd_dsn=".$$kd_dsn;
							//echo "<br>status_jbtn=$status_jbtn";
						$result = mysql_query("INSERT INTO penelitian(`id_pen`, `kode_pen`, `kode_dosen`, `status_jabatan`, `publikasi`, `jurusan_id`, `judul`, `tanggal_terbit`, `tanggal_mulai`, `tanggal_selesai`, `jumlah_peneliti`, `id_sumber_dana`, `dana`, `kode_buku`, `jenis_pen`, `man_kel`) VALUES  ( NULL, '".$frm_kode."', '".$$kd_dsn."', '".$$status_jbtn."', '".$frm_publikasi."', ".$frm_s_jurusan.", '".$frm_judul."', '".$frm_tgl_terbit."', '".$frm_tgl_mulai."', '".$frm_tgl_selesai."', ".$frm_jumlah_peneliti.", ".$frm_id_sumber_dana.", '".$frm_dana."', '".$frm_kode_buku."', ".$frm_jenis_pen.", '".$frm_sifat_pen."') " );
						if ($result) 
							{
								$pesan = $pesan."<br>Data telah ditambahkan";	
							}
						else
							{ 
								$pesan = $pesan."<br>Gagal menambahkan data". mysql_error();
							}
						}
					//exit();
				}
			else
				{
						//echo "<br>frm_kode_dsn=".$frm_kode_dsn1;
						//echo "<br>frm_status_jabatan=".$frm_status_jabatan1;
						$result = mysql_query("UPDATE penelitian SET `kode_dosen` ='$frm_kode_dsn1',
																	 `status_jabatan` ='$frm_status_jabatan1',
																	 `publikasi` ='$frm_publikasi', 
																	 `jurusan_id` ='$frm_s_jurusan', 
																	 `judul` ='$frm_judul', 
																	 `tanggal_terbit` ='$frm_tgl_terbit', 
																	 `tanggal_mulai`='$frm_tgl_mulai',
																	 `tanggal_selesai`='$frm_tgl_selesai',
																	 `jumlah_peneliti`='$frm_jumlah_peneliti',
																	 `id_sumber_dana`='$frm_id_sumber_dana',
																	 `dana`='$frm_dana',
																	 `kode_buku`= '$frm_kode_buku',
																	 `jenis_pen`= '$frm_jenis_pen',
																	 `man_kel`= '$frm_sifat_pen' 
															   WHERE `kode_pen`='$frm_kode'");
						
						if ($result) 
							{
								$pesan = $pesan."<br>Data telah diubah";	
							}
						else
							{ 
								$pesan = $pesan."<br>Gagal menyimpan data - ".mysql_error();;
							}
				}
		}
	}


if ($act==2) { // hapus data
	$result = mysql_query("DELETE FROM penelitian WHERE id_pen = ".$frm_id_pen);
		if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
}	
	
// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	//$frm_kode_pen="";
	$frm_id_pen="";
	$frm_kode_dsn1="";
	$frm_status_jabatan1="";
	$frm_publikasi="";
	$frm_s_jurusan=""; 
	$frm_judul="";
	$frm_tgl_terbit=""; 
	$frm_tgl_mulai="";
	$frm_tgl_selesai="";
	$frm_jumlah_peneliti="";
	$frm_id_sumber_dana="";
	$frm_dana="";
	$frm_kode_buku="";
	$frm_jenis_pen="";
	$frm_sifat_pen=""; 	
	$jum=0;
	//header("Location: penelitian_dosen_entry.php");
}
else
{
    // kalau user mengisi kode, kemudian pindah ke isian yang lain, maka di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
	if (($frm_kode!='')or ($frm_id_pen!=''))  {
	//echo "<br>frm_id_pen=".$frm_id_pen;
	//exit();
	if ($frm_kode!=''){
		$result = mysql_query( " SELECT penelitian.id_pen,
										penelitian.kode_pen,
										penelitian.kode_dosen,
										penelitian.status_jabatan,
										penelitian.publikasi,
										penelitian.jurusan_id,
										penelitian.judul,
										DATE_FORMAT(penelitian.tanggal_terbit,\"%d/%m/%Y\") as tanggal_terbit,
										DATE_FORMAT(penelitian.tanggal_mulai,\"%d/%m/%Y\") as tanggal_mulai,
										DATE_FORMAT(penelitian.tanggal_selesai,\"%d/%m/%Y\") as tanggal_selesai,
										penelitian.jumlah_peneliti,
										penelitian.id_sumber_dana,
										penelitian.dana,
										penelitian.kode_buku,
										penelitian.jenis_pen,
										penelitian.man_kel,
										penelitian.up_date
								   FROM penelitian
								  WHERE kode_pen='$frm_kode'");
		}
		else if ($frm_id_pen!=''){
		echo "<br>frm_id_pen=".$frm_id_pen;
		$result = mysql_query( " SELECT penelitian.id_pen,
										penelitian.kode_pen,
										penelitian.kode_dosen,
										penelitian.status_jabatan,
										penelitian.publikasi,
										penelitian.jurusan_id,
										penelitian.judul,
										DATE_FORMAT(penelitian.tanggal_terbit,\"%d/%m/%Y\") as tanggal_terbit,
										DATE_FORMAT(penelitian.tanggal_mulai,\"%d/%m/%Y\") as tanggal_mulai,
										DATE_FORMAT(penelitian.tanggal_selesai,\"%d/%m/%Y\") as tanggal_selesai,
										penelitian.jumlah_peneliti,
										penelitian.id_sumber_dana,
										penelitian.dana,
										penelitian.kode_buku,
										penelitian.jenis_pen,
										penelitian.man_kel,
										penelitian.up_date
								   FROM penelitian
								  WHERE id_pen=$frm_id_pen");
		}
								  
							
									if ($row = mysql_fetch_array($result)) {
										$frm_id_pen=$row["id_pen"];
										$frm_kode=$row["kode_pen"];
	
										$frm_kode_dsn1=$row["kode_dosen"];
										$frm_status_jabatan1=$row["status_jabatan"];
										
										$frm_publikasi=$row["publikasi"];
										$frm_s_jurusan=$row["jurusan_id"]; 
										$frm_judul=$row["judul"];
										$frm_tgl_terbit=$row["tanggal_terbit"]; 
										$frm_tgl_mulai=$row["tanggal_mulai"];
										$frm_tgl_selesai=$row["tanggal_selesai"];
										$frm_jumlah_peneliti=$row["jumlah_peneliti"];
										$frm_id_sumber_dana=$row["id_sumber_dana"];
										$frm_dana=$row["dana"];
										$frm_kode_buku=$row["kode_buku"];
										$frm_jenis_pen=$row["jenis_pen"];
										$frm_sifat_pen=$row["man_kel"]; 	
										//echo "<br>frm_kode=".$frm_kode;
										
										if ($frm_sifat_pen=='Kelompok')
										{
											
											//echo "<br>frm_sifat_pen=".$frm_sifat_pen;
											//echo "<br>OK frm_kode=".$frm_kode;
											
											$res_dsn = mysql_query( " SELECT penelitian.id_pen,
																			 penelitian.kode_pen,
																			 penelitian.kode_dosen,
																			 penelitian.status_jabatan,
																			 penelitian.man_kel,
																			 penelitian.up_date
																	    FROM penelitian
																	   WHERE kode_pen='$frm_kode'");
											$a=1;
											while($row_dsn = mysql_fetch_array($res_dsn))
											{
												//$frm_id_pen=$row["id_pen"];
												$frm_kode_dsn="frm_kode_dsn".$a;
												$$frm_kode_dsn=$row_dsn["kode_dosen"];
												echo "$$frm_kode_dsn=".$$frm_kode_dsn."--<br>";
												$frm_status_jabatan="frm_status_jabatan".$a;
												$$frm_status_jabatan=$row_dsn["status_jabatan"];
												$a++;
											}
										}
										//else
										//{
								
										
										
										
									}
									else
									{
									  $frm_exist = 0; 
									  //header("Location: mhs_daftar_penguji.php");
									}
							
					
	}

}
//echo "<br>frm_id_pen=".$frm_id_pen;
//echo "<br>frm_sifat_pen=".$frm_sifat_pen;
echo "<br>frm_publikasi= ".$frm_publikasi;
?>
<html>
<head>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../include/tanggalan.js">
</script>
</head>
<body class="body">
<form name="penelitian" id="penelitian" action="penelitian_dosen_entry.php" method="post">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="body">
    <tr> 
      <td colspan="4"><img src="spacer" height="1"></td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000"><strong><?php echo $pesan; ?></strong></font></td>
    </tr>
    <tr> 
      <td colspan="4">
	  <hr size="1" color="#FF9900">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="89%">
				<font color="#0099CC" size="1">
				<? if ($frm_id_pen!=''){?>
					<strong>EDIT DATA ~ </strong>
				<? } else
				{?>
					<strong>ENTRY DATA ~ </strong>
				<? }?>
				PENELITIAN DOSEN
				</font>
			</td>
            <td width="11%" bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">DOSEN</font></strong></div></td>
          </tr>
        </table>
        <hr size="1" color="#FF9900">
	  </td>
    </tr>
    <tr>
      <td width="4%">&nbsp;</td> 
      <td width="11%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      <td width="84%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Jenis Penelitian </td>
      <td><strong>:</strong></td>
      <td>
	  <select name="frm_jenis_pen" id="select" class="tekboxku" onChange="document.penelitian.submit()">
        <option value="0" <?php if ($frm_jenis_pen==''){echo "selected";}?>>--- Pilih ---</option>
        <option value="1" <?php if ($frm_jenis_pen=='1'){echo "selected";}?>>Tulisan Ilmiah</option>
        <option value="2" <?php if ($frm_jenis_pen=='2'){echo "selected";}?>>Buku Karya Dosen</option>
        <option value="3" <?php if ($frm_jenis_pen=='3'){echo "selected";}?>>Penelitian</option>
      </select>
        <font color="#FF0000">*</font> </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>Jurusan</td>
      <td><strong>:</strong></td>
      <td><select name="frm_s_jurusan" id="frm_s_jurusan" class="tekboxku" onChange="document.penelitian.submit()">
        <option value="" <?php if ($frm_s_jurusan==''){echo "selected";}?>>--- Pilih ---</option>
        <?php 
				$sqlJurusan="SELECT * FROM `jurusan` WHERE `jurusan`.id<>0 ORDER BY id ASC";
				
				$result = @mysql_query($sqlJurusan);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
        <option value="<?php echo $row->id; ?>" <?php if ($frm_s_jurusan==$row->id) { echo "selected"; }?> > <?php echo $row->jurusan; ?></option>
        <?php }?>
      </select>
      <font color="#FF0000">*</font></td>
    </tr>
	<?php if ($frm_jenis_pen=='3'){ ?>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>No. Surat Terakhir</td>
      <td><strong>:</strong></td>
      <td>
	  <?
	  	$sql="SELECT kode_pen 
				FROM penelitian 
			   WHERE kode_pen <>'' ";
				// echo "<br>frm_s_jurusan=".$frm_s_jurusan;
		if (($frm_s_jurusan!="") or ($frm_s_jurusan!=NULL))
		{ $sql=$sql." and jurusan_id =".$frm_s_jurusan; }
		
		$sql=$sql." ORDER BY id_pen DESC LIMIT 1";
		
		$result_kode_terakhir = mysql_query($sql);
		$row_kode_terakhir = mysql_fetch_array($result_kode_terakhir);
		$frm_kode_pen_akhir = $row_kode_terakhir["kode_pen"];
	  ?>
      <input name="frm_kode_pen_old" type="text" class="tekboxku" id="frm_kode_pen_old" value="<? echo $frm_kode_pen_akhir;?>" size="15" maxlength="15">
      <font color="#FF0000">*</font> </td>
    </tr>
	
	
    <tr>
      <td>&nbsp;</td>
      <td nowrap>No. Surat Sekarang</td>
      <td><strong>:</strong></td>
      <td><input name="frm_kode" type="text" class="tekboxku" id="frm_kode" value="<? echo $frm_kode;?>" size="15" maxlength="15" onBlur="document.penelitian.submit()">
      <font color="#FF0000"> *</font></td>
    </tr>
	
	<? }?>
    <tr>
      <td><input type="hidden" name="frm_id_pen" id="frm_id_pen" value="<?php echo $frm_id_pen; ?>"></td>
      <td nowrap>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;	  </td>
    </tr>
	<? if (($frm_jenis_pen=='3') or ($frm_jenis_pen=='4')) {?>
    <tr>
      <td>&nbsp;</td>
      <td>Sifat Penelitian </td>
      <td><strong>:</strong></td>
      <td>
	  <select name="frm_sifat_pen" id="frm_sifat_pen" class="tekboxku" onChange="document.penelitian.submit()">
        <option value="Mandiri" <?php if ($frm_sifat_pen=='Mandiri'){echo "selected";}?>>Mandiri</option>
        <option value="Kelompok" <?php if ($frm_sifat_pen=='Kelompok'){echo "selected";}?>>Kelompok</option>
      </select>
      <font color="#FF0000">*</font></td>
    </tr>
	<? }?>
	
    <tr>
      <td>&nbsp;</td>
      <td><? if (($frm_sifat_pen <>'Mandiri') AND isset($frm_sifat_pen))  echo "Dosen 1"; else echo "Dosen";?></td>
      <td><strong>:</strong></td>
      <td>
	  	<select name="frm_kode_dsn1" id="frm_kode_dsn1" class="tekboxku" onChange="document.penelitian.submit()" >
           <option value="" <?php if ($frm_kode_dsn1==''){echo "selected";}?>>--- Pilih ---</option>
          <?php 
		  //onChange="document.penelitian.submit()"
				$sqlDosen="select kode, nama
						   from dosen
						   where kode like '61%'";
				
				$result = @mysql_query($sqlDosen);
				$c=0;
				while ($row=@mysql_fetch_object($result))  {
				$c=$c+1;
				?>
          <option value="<?php echo $row->kode; ?>" <?php if ($frm_kode_dsn1==$row->kode) { echo "selected"; }?> > <?php echo $row->kode." - ".$row->nama; ?></option>
          <?php }?>
        </select>
  	  <? 
	  if ($frm_kode_dsn1<>'') {
	  $jum++;
	 // echo "OK, ".$jum;
	  }
	  if (($frm_jenis_pen=='3') or ($frm_jenis_pen=='4')) {?>
	  , jabatan : 
  	  <select name="frm_status_jabatan1" id="frm_status_jabatan1" class="tekboxku">
        <option value="0" <?php if ($frm_status_jabatan1==''){echo "selected";}?>>--- Pilih ---</option>
        <option value="1" <?php if ($frm_status_jabatan1=='1'){echo "selected";}?>>Ketua</option>
        <option value="2" <?php if ($frm_status_jabatan1=='2'){echo "selected";}?>>Wakil Ketua</option>
        <option value="3" <?php if ($frm_status_jabatan1=='3'){echo "selected";}?>>Anggota</option>
      </select> 
	  <? }?>
      <font color="#FF0000">*</font> </td>
    </tr>
	<? 
	//echo "<br>frm_sifat_pen=".$frm_sifat_pen;
	if (($frm_jenis_pen=='3') or ($frm_jenis_pen=='4')) {?>
	<? if (($frm_sifat_pen <>'Mandiri') AND ($frm_sifat_pen<>'')) {?>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">Dosen 2 </td>
      <td valign="top"><strong>:</strong></td>
      <td><select name="frm_kode_dsn2" id="frm_kode_dsn2" class="tekboxku" onChange="document.penelitian.submit()">
        <option <?php if ($frm_kode_dsn2==''){echo "selected";}?> value="">--- Pilih ---</option>
        <?php
					$result1 = @mysql_query("SELECT kode, nama FROM dosen WHERE kode LIKE '6%' order by kode ASC");
					$c=0;
					while ($row1=@mysql_fetch_object($result1))  {
					$c=$c+1;
					?>
        <option value="<?php echo $row1->kode; ?>" <?php if ($frm_kode_dsn2==$row1->kode) { echo "selected"; }?> ><?php echo $row1->kode; ?> - <?php echo $row1->nama; ?></option>
        <?php }?>
      </select> 
	  <?
	  
	  if ($frm_kode_dsn2<>'') {
	  $jum++;
	  //echo "OK2, ".$jum;
	  }
	  ?>
        , jabatan : 
        <select name="frm_status_jabatan2" id="frm_status_jabatan2" class="tekboxku">
          <option value="0" <?php if ($frm_status_jabatan2==''){echo "selected";}?>>--- Pilih ---</option>
          <option value="1" <?php if ($frm_status_jabatan2=='1'){echo "selected";}?>>Ketua</option>
          <option value="2" <?php if ($frm_status_jabatan2=='2'){echo "selected";}?>>Wakil Ketua</option>
          <option value="3" <?php if ($frm_status_jabatan2=='3'){echo "selected";}?>>Anggota</option>
        </select></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">Dosen 3 </td>
      <td valign="top"><strong>:</strong></td>
      <td><select name="frm_kode_dsn3" id="frm_kode_dsn3" class="tekboxku" onChange="document.penelitian.submit()">
        <option <?php if ($frm_kode_dsn3==''){echo "selected";}?> value="">--- Pilih ---</option>
        <?php
					$result1 = @mysql_query("Select kode, nama from dosen WHERE kode LIKE '6%' order by kode ASC");
					$c=0;
					while ($row1=@mysql_fetch_object($result1))  {
					$c=$c+1;
					?>
        <option value="<?php echo $row1->kode; ?>" <?php if ($frm_kode_dsn3==$row1->kode) { echo "selected"; }?> ><?php echo $row1->kode; ?> - <?php echo $row1->nama; ?></option>
        <?php }?>
      </select> 
	  <?
	  
	  if ($frm_kode_dsn3<>'') {
	  $jum++;
	  //echo "OK3, ".$jum;
	  }
	  ?>
        , jabatan : 
        <select name="frm_status_jabatan3" id="frm_status_jabatan3" class="tekboxku">
          <option value="0" <?php if ($frm_status_jabatan3==''){echo "selected";}?>>--- Pilih ---</option>
          <option value="1" <?php if ($frm_status_jabatan3=='1'){echo "selected";}?>>Ketua</option>
          <option value="2" <?php if ($frm_status_jabatan3=='2'){echo "selected";}?>>Wakil Ketua</option>
          <option value="3" <?php if ($frm_status_jabatan3=='3'){echo "selected";}?>>Anggota</option>
        </select></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">Dosen 4 </td>
      <td valign="top"><strong>:</strong></td>
      <td><select name="frm_kode_dsn4" id="frm_kode_dsn4" class="tekboxku" onChange="document.penelitian.submit()">
        <option <?php if ($frm_kode_dsn4==''){echo "selected";}?> value="">--- Pilih ---</option>
        <?php
					$result1 = @mysql_query("Select kode, nama from dosen WHERE kode LIKE '6%' order by kode ASC");
					$c=0;
					while ($row1=@mysql_fetch_object($result1))  {
					$c=$c+1;
					?>
        <option value="<?php echo $row1->kode; ?>" <?php if ($frm_kode_dsn4==$row1->kode) { echo "selected"; }?> ><?php echo $row1->kode; ?> - <?php echo $row1->nama; ?></option>
        <?php }?>
      </select> 
        <?
	  
	  if ($frm_kode_dsn4<>'') {
	  $jum++;
	  //echo "OK4, ".$jum;
	  }
	  ?>
		, jabatan : 
        <select name="frm_status_jabatan4" id="frm_status_jabatan4" class="tekboxku">
          <option value="0" <?php if ($frm_status_jabatan4==''){echo "selected";}?>>--- Pilih ---</option>
          <option value="1" <?php if ($frm_status_jabatan4=='1'){echo "selected";}?>>Ketua</option>
          <option value="2" <?php if ($frm_status_jabatan4=='2'){echo "selected";}?>>Wakil Ketua</option>
          <option value="3" <?php if ($frm_status_jabatan4=='3'){echo "selected";}?>>Anggota</option>
        </select></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">Dosen 5 </td>
      <td valign="top"><strong>:</strong></td>
      <td><select name="frm_kode_dsn5" id="frm_kode_dsn5" class="tekboxku" onChange="document.penelitian.submit()">
        <option <?php if ($frm_kode_dsn5==''){echo "selected";}?> value="">--- Pilih ---</option>
        <?php
					$result1 = @mysql_query("Select kode, nama from dosen WHERE kode LIKE '6%' order by kode ASC");
					$c=0;
					while ($row1=@mysql_fetch_object($result1))  {
					$c=$c+1;
					?>
        <option value="<?php echo $row1->kode; ?>" <?php if ($frm_kode_dsn5==$row1->kode) { echo "selected"; }?> ><?php echo $row1->kode; ?> - <?php echo $row1->nama; ?></option>
        <?php }?>
      </select> 
	  <?
	  
	  if ($frm_kode_dsn5<>'') {
	  $jum++;
	 // echo "OK5, ".$jum;
	  }
	  ?>
        , jabatan : 
        <select name="frm_status_jabatan5" id="frm_status_jabatan5" class="tekboxku">
          <option value="0" <?php if ($frm_status_jabatan5==''){echo "selected";}?>>--- Pilih ---</option>
          <option value="1" <?php if ($frm_status_jabatan5=='1'){echo "selected";}?>>Ketua</option>
          <option value="2" <?php if ($frm_status_jabatan5=='2'){echo "selected";}?>>Wakil Ketua</option>
          <option value="3" <?php if ($frm_status_jabatan5=='3'){echo "selected";}?>>Anggota</option>
        </select></td>
    </tr>
	<? }}?>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top"><?
	  
	  
	  //echo "TOTAL= ".$jum;
	  ?>
	  </td>
      <td valign="top">&nbsp;</td>
      <td>&nbsp;
	  </td>
    </tr> 
	<? if (($frm_jenis_pen=='3') or ($frm_jenis_pen=='4') or ($frm_jenis_pen=='')) {?>
	<? if ($frm_sifat_pen<>'Mandiri') {?>
    <tr>
      <td>&nbsp;</td> 
      <td>Jumlah Peneliti</td>
      <td><strong>:</strong></td>
      <td><input name="frm_jumlah_peneliti" type="text" class="tekboxku" id="frm_jumlah_peneliti" value="<?php if ($frm_jumlah_peneliti== '') echo $jum; else echo $frm_jumlah_peneliti; ?>" size="5" maxlength="3"></td>
    </tr>
	<? }?>
	<? }
	if (($frm_jenis_pen=='3') or ($frm_jenis_pen=='2') or ($frm_jenis_pen=='') or ($frm_jenis_pen=='1')) { ?>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">Jenis Publikasi</td>
      <td valign="top"><strong>:</strong></td>
      <td>
	  <select name="frm_publikasi" id="frm_publikasi" class="tekboxku">
        <option value="" <?php if ($frm_publikasi==''){echo "selected";}?>>--- Pilih ---</option>
        <option value="1" <?php if ($frm_publikasi=='1'){echo "selected";}?>>Regional</option>
        <option value="2" <?php if ($frm_publikasi=='2'){echo "selected";}?>>Nasional</option>
        <option value="3" <?php if ($frm_publikasi=='3'){echo "selected";}?>>Internasional</option>
      </select></td>
    </tr>
	<? }?>
    <tr>
      <td valign="top">&nbsp;</td> 
      <td valign="top">Judul</td>
      <td valign="top"><strong>:</strong></td>
      <td><textarea name="frm_judul" cols="50" rows="4" class="tekboxku" id="frm_judul"><?php echo $frm_judul; ?></textarea>
      <font color="#FF0000">*</font></td>
    </tr>
	
	<? if (($frm_jenis_pen=='1') or ($frm_jenis_pen=='2') or ($frm_jenis_pen=='')) {?>
    <tr>
      <td>&nbsp;</td>
      <td>Tanggal Terbit </td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_terbit" type="text" class="tekboxku" id="frm_tgl_terbit" value="<?php echo $frm_tgl_terbit; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('penelitian.frm_tgl_terbit',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)  
	  </td>
    </tr>
	<? }?>
    
	<? if (($frm_jenis_pen=='3') or ($frm_jenis_pen=='4') or ($frm_jenis_pen=='')) {?>
	<tr>
      <td>&nbsp;</td> 
      <td>Tanggal Mulai</td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_mulai" type="text" class="tekboxku" id="frm_tgl_mulai" value="<?php echo $frm_tgl_mulai; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('penelitian.frm_tgl_mulai',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)  </td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Tanggal Selesai</td>
      <td><strong>:</strong></td>
      <td><input name="frm_tgl_selesai" type="text" class="tekboxku" id="frm_tgl_selesai" value="<?php echo $frm_tgl_selesai; ?>" size="10" maxlength="10"> 
        <A Href="javascript:show_calendar('penelitian.frm_tgl_selesai',0,0,'DD/MM/YYYY')"> 
        <img src="../img/date.png" width="22" height="22" align="absbottom" border=0> 
        </A>(dd/mm/yyyy)  </td>
    </tr>
	
	<tr>
      <td>&nbsp;</td> 
      <td>Sumber Dana</td>
      <td><strong>:</strong></td>
      <td>
	   <select name="frm_id_sumber_dana" id="frm_id_sumber_dana" class="tekboxku">
	        <option <?php if ($frm_id_sumber_dana==''){echo "selected";}?>>--- Pilih ---</option>
			<?php
			$result1 = @mysql_query("SELECT id, nama FROM sumber_dana ORDER BY nama ASC");
			$c=0;
			while ($row1=@mysql_fetch_object($result1))  {
			$c=$c+1;
			?>
				  <option  value="<?php echo $row1->id; ?>" <?php if ($frm_id_sumber_dana==$row1->id) { echo "selected"; }?> ><?php echo $row1->nama; ?></option>
			<?php
			}
			?>
        </select>
		</td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td>Nominal Dana</td>
      <td><strong>:</strong></td>
      <td><input type="text" name="frm_dana" id="frm_dana" value="<?php echo $frm_dana; ?>" class="tekboxku"></td>
    </tr>
	<?
	}
	?>
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
      <td>
	  <? //echo "frm_id_pen=".$frm_id_pen;?>
	    <input type="submit" name="Submit" id="Submit" value="Simpan" onClick="this.form.action+='?act=1&jum=<? echo $jum;?>';this.form.submit();" class="tombol">
        <input type="reset" name="Submit2" id="Submit2" value="Batal" onClick="this.form.action+='?act=3';this.form.submit();" class="tombol">
        <?php if ($frm_id_pen) { ?>
        <input type="button" name="Submit3" id="Submit3" value="Hapus"  onClick="if(confirm('Hapus ?')){this.form.action+='?act=2&id=<?php echo $frm_id;?>';this.form.submit()};" class="tombol">
        <?php } ?>
	  </td>
    </tr>
    <tr> 
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4"><font color="#FF0000" size="1">*</font><font size="1"> = 
        compulsory / harus diisi</font></td>
    </tr>
  </table>
</form>
</body>
</html>