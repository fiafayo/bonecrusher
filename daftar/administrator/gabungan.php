<?
if($session->logged_in){
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);
	
$frm_no_ID_gab = $_POST['frm_no_ID_gab'];
$frm_nama_gab = $_POST['frm_nama_gab'];
$frm_alamat = $_POST['frm_alamat'];
$frm_kota = $_POST['frm_kota'];
$frm_propinsi = $_POST['frm_propinsi'];						
$frm_exist = $_POST['frm_exist'];
$act = $_GET['act'];
/*
echo "<br>frm_no_ID_gab=".$frm_no_ID_gab;
echo "<br>frm_nama_gab=".$frm_nama_gab;
echo "<br>frm_kota=".$frm_kota;
echo "<br>frm_propinsi=".$frm_propinsi;
echo "<br>act=".$act;
echo "<br>frm_exist=".$frm_exist;
*/
if ($act==1)   // INSERT
{ // simpan data


// NRP dan NAMA harus diisi
	if (($frm_no_ID_gab=='') or ($frm_nama_gab=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Anda harus mengisi Data Gabungan dengan lengkap. Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
			$result_cek = mysql_query("SELECT *
						 				 FROM gabungan 
										WHERE (nama='".$_POST['frm_nama_gab']."' AND id_gabungan=".$_POST['frm_no_ID_gab'].")");
			if ($result_cek) 
				{
					$frm_exist=1;
					$pesan = $pesan."<br>Data Gabungan sudah ada";
				}
				//else
				//{
					
					//}
			echo"<br>here :".$frm_exist;
		// data id tidak ada, berarti record baru
			if (($frm_exist!=1) AND ($frm_no_ID_gab==""))
				{
					echo"inset";
					$result = mysql_query("INSERT INTO gabungan (id_gabungan, nama, alamat, kota_gabungan, propinsi_gabungan)VALUES(".$frm_no_ID_gab.", '".$frm_nama_gab."','".$frm_alamat."',".$frm_kota.", ".$frm_propinsi."')" );
  				    if ($result) 
						{
							$pesan = $pesan."<br>Data Gabungan telah ditambahkan";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal menambahkan data Gabungan". mysql_error();
						}
				}
			else
				{
					$result = mysql_query(" UPDATE gabungan SET `nama` = '$frm_nama_gab',
																`alamat` = '$frm_alamat', 
																`kota_gabungan` = $frm_kota,
																`propinsi_gabungan` = $frm_propinsi
														  WHERE `id_gabungan` = $frm_no_ID_gab");
					if ($result) 
						{
							$pesan = $pesan."<br>Data telah diubah";	
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal mengubah data - ". mysql_error();
						}
				}
		}
	}


if ($act==2) { // hapus data

$result = mysql_query("DELETE FROM gabungan WHERE id_gabungan = ".$frm_no_ID_gab);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
	//header("Location: {$_SERVER['PHP_SELF']}");
	?>
    <script language="javascript">//confirmRefresh();
	    alert ('Data kota <? echo $frm_nama_gab;?> telah di Hapus.');
		document.location="index.php?menu=kota";    
    </script>
    <?
}

if ($act==3) { // RESET FORM

	$frm_no_ID_gab =  "";
	$frm_nama_gab   =   "";
	$frm_alamat   =  "";
	$frm_kota   =  "";
	$frm_propinsi   =   "";
}
	
// Kalau data sudah ditambahkan ke dalam database, form dikosongkan siap untuk diisi data baru
if (($act!=0)and($error!=1)) {
	$frm_exist=0;
	//$frm_nama_gab = "";
	//$frm_kelamin = "";						
	//$frm_tempat_lahir = "";
	//$frm_tgl_lahir = "";
	
	//$frm_alamat_sekarang = "";
	//$frm_zip_sekarang = "";
	
	//$frm_telepon_sekarang = "";
	//$frm_hp = "";
	//$frm_email = "";
	
	//$frm_nama_gab_ortu = "";
	//$frm_alamat_ortu = "";
	//$frm_telepon_ortu = "";
	//$frm_zip_ortu = "";
}
else
{
// Jika user mengisi form NRP, di check apakah data kode sudah ada, kalau sudah ada maka data akan ditampilkan
//echo "<br>frm_nama_gab=".$_POST['frm_nama_gab'];
if ($frm_nama_gab!='')  {
$result = mysql_query("SELECT *
						 FROM gabungan 
						WHERE nama='".$_POST['frm_nama_gab']."'");

						if ($row = mysql_fetch_array($result)) {
							$frm_exist=1;
							$frm_no_ID_gab =  $row["id_gabungan"];
							$frm_nama_gab   =   $row["nama"];
							$frm_alamat   =   $row["alamat"];
							$frm_kota   =  $row["kota_gabungan"];
							$frm_propinsi   =   $row["propinsi_gabungan"];
														
						}else
						{
							//$frm_exist=0;
							//$pesan = $pesan."Nomor ID Kota yang Anda masukkan tidak ada di database";
							
							//$frm_no_ID_kota = "";
							//$frm_propinsi = "";
						}
	
}


}

	
?>
<link type="text/css" href="../jquery/themes/base/ui.all.css" rel="stylesheet" />

<link href="../css/layout.css" rel="stylesheet" type="text/css">
<link href="../css/colorbox.css" rel="stylesheet" media="screen"  />
<script src="../jquery/jquery-1.4.4.js"></script>
<script src="../include/jquery.colorbox.js"></script>
<script>
		$(document).ready(function(){
			//Examples of how to assign the ColorBox event to elements
			$("a[rel='example1']").colorbox();
			$("a[rel='example2']").colorbox({transition:"fade"});
			$("a[rel='example3']").colorbox({transition:"none", width:"75%", height:"75%"});
			$("a[rel='example4']").colorbox({slideshow:true});
			$(".example5").colorbox();
			$(".example6").colorbox({iframe:true, innerWidth:425, innerHeight:344});
			$(".example7").colorbox({width:"50%", innerHeight:370, iframe:true});
			$(".example8").colorbox({width:"50%", inline:true, href:"#inline_example1"});
			$(".example9").colorbox({
				onOpen:function(){ alert('onOpen: colorbox is about to open'); },
				onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
				onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
				onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
				onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
			});
			
			//Example of preserving a JavaScript event for inline calls.
			$("#click").click(function(){ 
				$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
				return false;
			});
			
		});
	</script>

<script language="javascript">
function proses()
{
	document.forms["form_gabungan"].submit();
	}
</script>

<script language="javascript" type="text/javascript" >
<!--
function confirmRefresh() {
var okToRefresh = confirm("Do you really want to refresh the page?");
if (okToRefresh)
	{
			setTimeout("location.reload(true);",1500);
	}
}
// -->
</script>
<!-- BEGIN CLUB -->
<?php
if ($mode=="" || $mode=="0") 
{ ?> 
<font color="#FF0000"><strong><?php echo $pesan; ?></strong></font> 
<div id="stylized" class="myform"> 
  <form id="form" name="form"> 
    <h1>Cari Data Gabungan</h1> 
    <p>Gunakan form dibawah ini untuk mencari Data Gabungan</p> 
    <label>Nama <span class="small">ketik nama gabungan</span> </label> 
    <input name="frm_s_nama" id="frm_s_nama" type="text"> 
    <label>Banyak Data<span class="small">data yang ditampilkan</span> </label> 
    <select name="frm_s_jum_data" id="frm_s_jum_data"> 
      <option value="2">2</option> 
      <option value="10">10</option> 
      <option value="15">15</option> 
      <option value="20" selected>20</option> 
    </select> 
    <!--label>fd<span class="small">fds</span> </label--> 
    <button type="submit">Cari</button> 
    <!--input type="submit" value="Proses" class="button_submit"--> 
    <input type="hidden" name="mode" value="2"> 
    <input type="hidden" name="menu" value="gabungan"> 
    <div class="spacer"></div> 
  </form> 
</div> 
<br>
<?
}
else
{
// JIKA MODE<>0 MAKSUDNYA JIKA FORM DI SUBMIT MAKA KELUAR DAFTAR ATLIT
				 $sql="SELECT `id_gabungan`, 
							  `nama`, 
							  `alamat`, 
							  `kota_gabungan`, 
							  `propinsi_gabungan`
						 FROM gabungan 
						WHERE nama <>''";
	  
if ($mode=="2" || $mode=="3" || $mode=="4")
{
// PROSES UNTUK SEARCH (MODE=2)

	/*if ($frm_s_tgl_mulai1!="" || $frm_s_tgl_mulai2!="")
	{  
		if($frm_s_tgl_mulai1!="" && $frm_s_tgl_mulai2!="")
		{ $sql=$sql." and ta.tanggal_mulai between '".datetomysql($frm_s_tgl_mulai1)."' and '".datetomysql($frm_s_tgl_mulai2)."'"; }
		else
		{
			if($frm_s_tgl_mulai1!="")
			{ $sql=$sql." and ta.tanggal_mulai>='".datetomysql($frm_s_tgl_mulai1)."'"; }
			if($frm_s_tgl_mulai2!="")
			{ $sql=$sql." and ta.tanggal_mulai<='".datetomysql($frm_s_tgl_mulai2)."'"; }
		}
	}
	if ($frm_s_tgl_selesai1!="" || $frm_s_tgl_selesai2!="")
	{  
		if($frm_s_tgl_selesai1!="" && $frm_s_tgl_selesai2!="")
		{ $sql=$sql." and ta.tanggal_selesai between '".datetomysql($frm_s_tgl_selesai1)."' and '".datetomysql($frm_s_tgl_selesai2)."'"; }
		else
		{
			if($frm_s_tgl_selesai1!="")
			{ $sql=$sql." and ta.tanggal_selesai>='".datetomysql($frm_s_tgl_selesai1)."'"; }
			if($frm_s_tgl_selesai2!="")
			{ $sql=$sql." and ta.tanggal_selesai<='".datetomysql($frm_s_tgl_selesai2)."'"; }
		}
	}
	
	if ($frm_s_nomor_surat!="")
	{ $sql=$sql." and ta.no_surat_tugas like '%".$frm_s_nomor_surat."%'"; } 
	if ($frm_s_judul!="")
	{ $sql=$sql." and ta.judul like '%".$frm_s_judul."%'"; } */
	if ($frm_s_nama!="")
	{
		 $sql .= " and (gabungan.nama LIKE '%".$frm_s_nama."%')";
	}
	/*if ($frm_s_jurusan!="all")
	{ $sql .= " and master_mhs.jurusan='".$frm_s_jurusan."'";}
	
	if ($frm_s_kode_dosen1!="")
    {
					$sql8="select * from dosen where kode=".$frm_s_kode_dosen1;
					if(!($result8=mysql_db_query($DB,$sql8)))
					{
						echo "Kode Dosen Pembimbing 1 tidak terdaftar";
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
						echo "Kode Dosen Pembimbing 2 tidak terdaftar";
					}
					else
					{
						if ($row8 = mysql_fetch_array($result8)) $dsn2=$row8["kode"]; 
					}  
	$sql .= " and (master_ta.KODOS2=".$dsn2." or master_ta.KODOS2=".$frm_s_kode_dosen2.")"; }
	
	*/
	
//echo "<br>SQL= ".$sql;
	//$sql=$sql." order by ".$frm_o1.", ".$frm_o2.", ".$frm_o3;
}

// UNTUK PAGING --------------------------------
if ($mode=="2")
{
$result=@mysql_query($sql);
$maxrows=mysql_num_rows($result);				
if($hal=="") { $hal=1; }
$recke=(($hal-1)*$frm_s_jum_data);
$limit="$recke,$frm_s_jum_data";
$jumhal=ceil($maxrows/$frm_s_jum_data);

$vlink="index.php";
$abc="?mode=2&frm_s_nama=$frm_s_nama&frm_s_jum_data=$frm_s_jum_data&menu=gabungan";

$vlink=$vlink.$abc;

$fontface="Verdana,Arial,Helvetica,sans-serif";
$fontsize="2";
}
// JIKA MODE HASIL LAPORAN DI MONITOR MAKA PAGING HALAMAN
if ($mode=="2") { $sql=$sql." limit ".$limit; }

if(!($result=mysql_db_query($DB,$sql)))
{
	echo mysql_error();
        return 0;
}
//---------------------------------



   /*if ($frm_s_jurusan!="all")
	{
		$sql_jur="SELECT jurusan as nama_jur
					FROM jurusan
				   WHERE id2='".$frm_s_jurusan."'";
		$result_jur = @mysql_query($sql_jur);
		$row_jur=@mysql_fetch_array($result_jur);
		echo "<b>Jurusan: </b>".$row_jur["nama_jur"];
	}*/
	

if (mysql_num_rows($result)==0) {
    echo "<br><font color=FF0000><b>Data Gabungan Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=index.php?menu=gabungan class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}
if ($mode=="2") { 
echo "<div align=\"left\">";
f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); 
echo "</div>";
}
?> 
<table id="mytable" cellspacing="0"> 
  <tbody> 
    <tr> 
      <th><b>No.</b></th> 
      <th><b>NAMA</b></th> 
      <th>ALAMAT</th>
      <th>KOTA</th> 
      <th>PROPINSI</th> 
    </tr> 
    <?

$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
?> 
    <tr> 
      <td><? echo ($hal-1)*$frm_s_jum_data+$a; ?></td> 
      <td nowrap>
		  <a class='example7' href="edit_gabungan.php?id_gabungan=<?=$row["id_gabungan"];?>&nama_gabungan=<?=$row["nama"];?>"><?=$row["nama"];?></a>
	  </td> 
      <td nowrap><? echo $row["alamat"]; ?></td>
      <td nowrap><? //echo $row["kode_dosen1"]." - ".$row["nama_dosen1"] ; 
			$sql2="SELECT * FROM kota WHERE id_kota='".$row["kota_gabungan"]."'";
			$result2=mysql_db_query($DB,$sql2);
			
			if ($row2 = mysql_fetch_array($result2))
			{
				echo $row2["nama"];				
			}
			
			?> </td> 
      <td nowrap> <? 
			$sql2="SELECT * FROM propinsi WHERE id_propinsi='".$row["propinsi_gabungan"]."'";
			$result2 = mysql_db_query($DB,$sql2);
			if ($row2 = mysql_fetch_array($result2))
			{
				echo $row2["nama"];			
			}
			?> </td> 
      <!-- BEGIN STATUS PROPINSI--> 
      <!--END STATUS PROPINSI--> 
	  
	  <!--BEGIN STATUS PUSAT-->
      <!--END STATUS PUSAT-->    
</tr> 
    <?
}
?> 
  </tbody> 
</table> 
<?
if ($mode=="2")
{
?> 
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="gabungan_export.php"> 
  <input type="hidden" name="mode" value="3"> 
  <input type="hidden" name="frm_s_judul" value="<?php echo $frm_s_judul; ?>"> 
  <input type="hidden" name="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>"> 
  <input type="hidden" name="frm_s_nama" value="<?php echo $frm_s_nama; ?>"> 
  <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
  <?
	}
	?> 
  <div align="right"> 
    <input name="excel"   type="image" onClick="document.fexcel.action='gabungan_export.php?t=excel'" src="../image/Mexcel.jpg" align="middle" width="18" height="18"> 
&nbsp; | &nbsp; 
    <input name="printer" type="image" onClick="document.fexcel.action='gabungan_export.php?t=printer'" src="../image/print.gif" align="middle" width="18" height="18"> 
  </div> 
</form> 
<?
}
if ($mode=="2") { 
echo "<div align=\"left\">";
f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); 
echo "</div>";
}

if ($_GET['var_apr_kab']=="1")
{
	$result = mysql_query("INSERT INTO apr_kabupaten (id_member, tipe_member, status, admin_user)VALUES(".$_GET['id_gabungan'].", 'gabungan', 1, '".$_GET['admin_user']."')" );
	if ($result) 
		{
			$pesan = $pesan."<br>Data Gabungan '".$_GET['frm_nama_gab_gabungan']."' telah di SETUJUI";	
		}
	else
		{ 
			$pesan = $pesan."<br>Gagal menambahkan data gabungan '".$_GET['frm_nama_gab_gabungan']."' - mohon hubungi admin". mysql_error();
		}

}
if ($_GET['var_apr_kab']=="0")
{
	$result = mysql_query("INSERT INTO apr_kabupaten (id_member, tipe_member, status, admin_user)VALUES(".$_GET['id_gabungan'].", 'gabungan', 0, '".$_GET['admin_user']."')" );
	if ($result) 
		{
			$pesan = $pesan."<br>Data Gabungan '".$_GET['frm_nama_gab']."' telah di SET ULANG";	
		}
	else
		{ 
			$pesan = $pesan."<br>Gagal menambahkan data gabungan '".$_GET['frm_nama_gab']."' - mohon hubungi admin". mysql_error();
		}

}
// BEGIN log PROPINSI
if ($_GET['var_apr_prop']=="1")
{
	$result = mysql_query("INSERT INTO apr_propinsi (id_member, tipe_member, status, admin_user)VALUES(".$_GET['id_gabungan'].", 'gabungan', 1, '".$_GET['admin_user']."')" );
	if ($result) 
		{
			$pesan = $pesan."<br>Data Gabungan '".$_GET['frm_nama_gab']."' telah di SETUJUI";	
		}
	else
		{ 
			$pesan = $pesan."<br>Gagal menambahkan data gabungan '".$_GET['frm_nama_gab']."' - mohon hubungi admin". mysql_error();
		}

}
if ($_GET['var_apr_prop']=="0")
{
	$result = mysql_query("INSERT INTO apr_propinsi (id_member, tipe_member, status, admin_user)VALUES(".$_GET['id_gabungan'].", 'gabungan', 0, '".$_GET['admin_user']."')" );
	if ($result) 
		{
			$pesan = $pesan."<br>Data Gabungan '".$_GET['frm_nama_gab']."' telah di SET ULANG";	
		}
	else
		{ 
			$pesan = $pesan."<br>Gagal menambahkan data gabungan '".$_GET['frm_nama_gab']."' - mohon hubungi admin". mysql_error();
		}

}  // END log PROPINSI

// BEGIN log PUSAT
if ($_GET['var_apr_pusat']=="1")
{
	$result = mysql_query("INSERT INTO apr_pusat (id_member, tipe_member, status, admin_user)VALUES(".$_GET['id_gabungan'].", 'gabungan', 1, '".$_GET['admin_user']."')" );
	if ($result) 
		{
			$pesan = $pesan."<br>Data Gabungan '".$_GET['frm_nama_gab']."' telah di SETUJUI";	
		}
	else
		{ 
			$pesan = $pesan."<br>Gagal menambahkan data gabungan '".$_GET['frm_nama_gab']."' - mohon hubungi admin". mysql_error();
		}

}
if ($_GET['var_apr_pusat']=="0")
{
	$result = mysql_query("INSERT INTO apr_pusat (id_member, tipe_member, status, admin_user)VALUES(".$_GET['id_gabungan'].", 'gabungan', 0, '".$_GET['admin_user']."')" );
	if ($result) 
		{
			$pesan = $pesan."<br>Data Gabungan '".$_GET['frm_nama_gab']."' telah di SET ULANG";	
		}
	else
		{ 
			$pesan = $pesan."<br>Gagal menambahkan data gabungan '".$_GET['frm_nama_gab']."' - mohon hubungi admin". mysql_error();
		}

}  // END log PUSAT
?> 
<!-- END CLUB -->

<?
}
else
{
	header('Location: ../process.php');
}?>