<?php 
/* 
   HISTORY      : 09/12/03 - Penambahan copy ke database 
   DATE CREATED : 07/07/03 - EKO
   UPDATE  		: 
   PROBLEM 		:
   KEGUNAAN     : QUERY BEBAS
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
  <title>Import Data Mahasiswa</title>
<link href="../css/style2.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {color: #0000FF}
-->
</style>
</head>
<body>
<?php 

//$pesan.=$frm_nama_file_name ;
if ($up==1) { 
   
   if ($frm_nama_filenya_name != "")
   {
     echo "<br>H E R E XQ ".$frm_nama_filenya_name;
	 echo "<br>frm_angkatan--- ".$frm_angkatan;
	 echo "<br>frm_nama_filenya--- ".$_POST["frm_nama_filenya"];
	 
	 if (@copy($frm_nama_filenya, "../upload/alumni_$frm_nama_file_name")) 
	 {
	 	$pesan.="<br>File database telah berhasil diupload";
	 
	 
		echo "<br>H E R E XXX- ".$frm_nama_filenya;
   exit();
		
 $perintah="./dbf2mysql -h localhost -d a_teknik -t import_mahasiswa -c -f -P root -U root ../upload/$frm_nama_file_name";
 // $perintah="./dbf2mysql -h localhost -d teknik -t import_mahasiswa -c -f -P -U teknik ../upload/$frm_nama_file_name";

 // $perintah="./dbf2mysql -h sia.ubaya.ac.id -d teknik -t import_mahasiswa -c -f -P eko1nfotech -U teknik ../upload/BIO.DBF";
  
   $pesan.= "<br>".$perintah ;
   exec($perintah);

if ($frm_angkatan!="") { $sql_import_add=" and substring(nrp,2,2)='$frm_angkatan'";  }
$result=@mysql_query("replace into master_mhs (nrp, nama,alamat_asal,tempat_lahir,tanggal_lahir,telepon_asal,nama_ortu,sex) select nrp,nama,alamat,tmplahir,tgllahir,telepon,namaortu,'L' from import_mahasiswa where kelamin='1' $sql_import_add ");
$affect=@mysql_affected_rows();

$result=@mysql_query("replace into master_mhs (nrp, nama,alamat_asal,tempat_lahir,tanggal_lahir,telepon_asal,nama_ortu,sex) select nrp,nama,alamat,tmplahir,tgllahir,telepon,namaortu,'P' from import_mahasiswa where kelamin='2' $sql_import_add ");
$affect=$affect+@mysql_affected_rows();

$pesan.="<br>".$affect." rows affected";   
   
	 }
	 else
	 {
	 	$pesan.="<br>Maaf, tidak bisa upload file. Silahkan hubungi administrator apabila anda masih tidak bisa mengimport data mahasiswa.";
	 } 
  } 
   else
   {
      $pesan.="<br>Tidak ada file yang di-upload...";
   }
   
  
  
 // $result=@mysql_query("insert into master_mhs (nrp, nama,alamat_asal,tempat_lahir,tanggal_lahir,telepon_asal,nama_ortu,sex) select nrp,nama,alamat,tmplahir,tgllahir,telepon,namaortu,'P' from import_mahasiswa where kelamin='2'");
//$affect=$affect+@mysql_affected_rows();

//$pesan.="<br>".$affect." rows affected"; 
  

   
   
 }?>
<form method="post" action="umum_7.php?up=1" enctype="multipart/form-data">
  
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0">
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
            <td width="91%"><font color="#006699"><font color="#0099CC" size="1"><strong>DATA MASTER ~</strong> IMPORT MASTER MAHASISWA</font></font></td>
            <td width="9%" nowrap bgcolor="#0099CC"><div align="center"><strong><font color="#FFFFFF">UMUM</font></strong></div></td>
          </tr>
        </table>
      <hr size="1" color="#FF9900"></td>
    </tr>
 
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>

  
  <tr>
    <td width="28%" nowrap>File database yang akan diimport <span class="style2">@</span></td>
    <td width="2%"><strong>:</strong></td>
    <td width="70%"><input name="frm_nama_filenya" type="file" size="30">
      <span class="style1">*</span></td>
  </tr>
 <tr>
    <td>Angkatan (Digit 2-3 dari Nrp) </td>
    <td><strong>:</strong></td>
    <td><input name="frm_angkatan" id="frm_angkatan" type="text" size="7">
      <span class="style1">*</span></td>
  </tr>
 
  <tr><td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit"  value="Upload File">
  </td></tr>
  <tr><td colspan="3">&nbsp;</td></tr>
 <tr><td colspan="3">
 <table width="100%">
          <tr>
            <td align="right" valign="top"># </td>
            <td><strong class="style3"><font color="#FF0000">Apabila data yang lama sudah 
        ada, maka data akan disesuaikan dengan data baru !!!</font></strong></td></tr><tr>
            <td align="right" valign="top"><span class="style2"> @</span></td>
            <td><span class="style3"> Format file database adalah &quot; <em>*.dbf</em> &quot;, dengan struktur database sesuai dengan struktur ADSIM tertanggal Agustus 2003
		    </span></td>
        </tr>
		<tr><td align="right"><span class="style1">*</span></td><td><span class="style3"> compulsory / harus diisi</span></td>
  </tr>
  </table>
  </td>
  </tr>
</table>
</form>
</body>
</html>