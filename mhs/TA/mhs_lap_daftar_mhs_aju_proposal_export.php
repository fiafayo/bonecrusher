<?php
/* 
   DATE CREATED : 01/11/07
   KEGUNAAN     : MENAMPILKAN LAPORAN DAFTAR MAHASISWA YG MENGAJUKAN PROPOSAL
   VARIABEL     : 

   KETERANGAN   : PROSES CEK AUTHENTIFIKASI DICOMMENT UNTUK COBA JALANKAN
*/

session_start();
require("../../include/global.php");
require("../../include/fungsi.php");

$sql="SELECT master_mhs.NRP,
			 master_mhs.NAMA,
			 master_ta.JUDUL_TA,
			 master_ta.KODOS1,
			 master_ta.KODOS2,
			 master_mhs.jurusan
        FROM master_ta,master_mhs
		WHERE master_ta.NRP=master_mhs.NRP AND master_ta.KOLUS='' ";

// PROSES UNTUK SEARCH (MODE=2)
	if ($frm_s_NRP!="")
	{
		 $sql .= " and (master_mhs.NRP='".$frm_s_NRP."')";
	}
	if ($frm_s_jurusan!="all")
	{ $sql .= " and master_mhs.jurusan='".$frm_s_jurusan."'";}
	
	if ($frm_s_kode_dosen1!="")
    {
					$sql8="select * from dosen where kode=".$frm_s_kode_dosen1;
					if(!($result8=mysql_db_query($DB,$sql8)))
					{
						echo "NPK Dosen Pembimbing 1 tidak terdaftar";
					}
					else
					{
						if ($row8 = mysql_fetch_array($result8)) $dsn1=$row8["kode"]; 
					}  	
	
	 $sql .= " and (master_ta.KODOS1=".$dsn1." or master_ta.KODOS1=".$frm_s_kode_dosen1.")"; } 
	
	if ($frm_s_kode_dosen2!="")
    {
					$sql8="select * from dosen where kode=".$frm_s_kode_dosen2;
					if(!($result8=mysql_db_query($DB,$sql8)))
					{
						echo "NPK Dosen Pembimbing 2 tidak terdaftar";
					}
					else
					{
						if ($row8 = mysql_fetch_array($result8)) $dsn2=$row8["kode"]; 
					}  
	$sql .= " and (master_ta.KODOS2=".$dsn2." or master_ta.KODOS2=".$frm_s_kode_dosen2.")"; }
	
f_connecting();

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}

$excel_export.="<b>FAKULTAS TEKNIK - UNIVERSITAS SURABAYA</b><br>
<b>LAPORAN DAFTAR MAHASISWA YANG MENGAJUKAN PROPOSAL</b><br><br>";

	if ($frm_s_jurusan!="all")
	{ 
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id2='".$frm_s_jurusan."'";
		$result_jur = @mysql_query($sql_jur);
		$row_jur=@mysql_fetch_array($result_jur);
		$excel_export.="<b>".$row_jur["nama_jur"]."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
	}

//$excel_export.="</b><br>";

$excel_export.="<b>Tgl. Cetak : ".date("d-m-Y")."</b><br><br>";
$excel_export.="<table border=1 width=100%>";
$excel_export.="<tr>
					<td nowrap><b>No.</b></td>
					<td nowrap><b>NRP</b></td>
					<td nowrap><b>NAMA</b></td>
					<td nowrap><b>JUDUL</b></td>
					<td nowrap><b>DOSEN PEMBIMBING 1</b></td>
					<td nowrap><b>DOSEN PEMBIMBING 2</b></td>
				  </tr>";
$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
	$sql_dobing1="SELECT nama
				  FROM dosen
				  WHERE kode='".$row["KODOS1"]."'";
	$result_dobing1 = @mysql_query($sql_dobing1);
	$row_dobing1=@mysql_fetch_array($result_dobing1);
   
    $sql_dobing2="SELECT nama
			      FROM dosen
			      WHERE kode='".$row["KODOS2"]."'";
    $result_dobing2 = @mysql_query($sql_dobing2);
    $row_dobing2=@mysql_fetch_array($result_dobing2);
	
		$excel_export.="<tr>
						<td>".$a."</td>
						<td>".$row["NRP"]."</td>
						<td>".$row["NAMA"]."</td>
						<td nowrap>".$row["JUDUL_TA"]."</td>
						<td nowrap>".$row["KODOS1"]."-".$row_dobing1["nama"]."</td>
						<td nowrap>".$row["KODOS2"]."-".$row_dobing2["nama"]."</td>
					  </tr>";
}

$excel_export.="</table>";

if ($t=='excel') {
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=LAP_aju_proposal-".date("dmY").".xls");

echo ("$excel_export");
}
if ($t=='printer') {
?>
<html>
<link href="../style.css" rel="stylesheet" type="text/css">

<script language="Javascript1.2">
<!--
function printpage() {
window.print();  
}

//-->
</script>

<body onload="printpage()" class="print">
<script language="Javascript1.2">
<!--
function printpage() {
window.print();  
}
//-->
</script>

<?php
echo ("$excel_export");
?>

</body>
</html>
<?php 
}
?>