<?php
/* 
   DATE CREATED : 04/05/11
   KEGUNAAN     : MENAMPILKAN DATA ATLIT
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
<link href="../css/layout.css" rel="stylesheet" type="text/css">
  <link href="../src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
  <link href="../css/example.css" media="screen" rel="stylesheet" type="text/css" />
  <script src="../jquery/jquery-1.4.4.js" type="text/javascript"></script>
  <script src="../src/facebox.js" type="text/javascript"></script>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : '../src/loading.gif',
        closeImage   : '../src/closelabel.png'
      })
    })
  </script>
<script language="JavaScript">
function konfirmasiSetuju()
{
		var checkconfirm=confirm("Apakah Anda yakin MENYETUJUI Data Atlit ini" + " " + "\?")
		if (checkconfirm == true) 
			return true;
		else
			return false;
}
function konfirmasiReset()
{
		var checkconfirm=confirm("Apakah Anda yakin SET ULANG Data Atlit ini" + " " + "\?")
		if (checkconfirm == true) 
			return true;
		else
			return false;
}
</script>
</head>
<body> 
<?php
if ($mode=="" || $mode=="0") 
{ ?> 
<font color="#FF0000"><strong><?php echo $pesan; ?></strong></font> 
<div id="stylized" class="myform"> 
  <form id="form" name="form"> 
    <h1>Cari Data Atlit</h1> 
    <p>Gunakan form dibawah ini untuk mencari Data Atlit</p> 
    <label>Nama <span class="small">ketik nama atlit</span> </label> 
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
    <input type="hidden" name="menu" value="atlit"> 
    <div class="spacer"></div> 
  </form> 
</div> 
<br>
<?
}
else
{
// JIKA MODE<>0 MAKSUDNYA JIKA FORM DI SUBMIT MAKA KELUAR DAFTAR ATLIT
				 $sql="SELECT id_atlit,
				 			  no_induk_atlit, 
					  		  nama, 
					    	  kelamin, 
							  tempat_lahir, 
							  tanggal_lahir, 
							  DATE_FORMAT(`tanggal_lahir`,'%d/%m/%Y') as tanggal_lahir,
							  alamat, 
							  kota_atlit, 
							  propinsi_atlit, 
							  email, 
							  club, 
							  gabungan
						 FROM atlit 
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
		 $sql .= " and (atlit.nama LIKE '%".$frm_s_nama."%')";
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
$abc="?mode=2&frm_s_nama=$frm_s_nama&frm_s_jum_data=$frm_s_jum_data&mode=2&menu=atlit";

$vlink=$vlink.$abc;

$fontface="Verdana,Arial,Helvetica,sans-serif";
$fontsize="2";
}
// SELESAI MBULETNYA PAGING ------------------------------
// JIKA MODE HASIL LAPORAN DI MONITOR MAKA PAGING IN ACTION
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
    echo "<br><font color=FF0000><b>Data Belum Tersedia !</b></font><br>Mohon periksa kembali data yang Anda cari";
	echo "<br><br><a href=index.php?menu=atlit class=menu_left>:: Kembali</a>";
	//mysql_free_result($result);
    exit;
}
if ($mode=="2") { 
echo "<div align=\"left\">";
f_paging($hal,$jumhal,$vlink,$fontface,$fontsize); 
echo "</div>";
}
echo "halo, ".$session->username;
?> 
<table id="mytable" cellspacing="0"> 
  <tbody> 
    <tr> 
      <th><b>No.</b></th> 
      <th><b>NAMA</b></th> 
      <th>L/P</th> 
      <th>KOTA</th> 
      <th>PROPINSI</th> 
      <th>Status III <br> 
        (Kab.) </th> 
      <th>Status II<br> 
        (Prop.) </th> 
      <th>Status I<br> 
        (Pusat) </th> 
    </tr> 
    <?

$a=0;
while(($row = mysql_fetch_array($result)))
{
	$a++;
?> 
    <tr> 
      <td><? echo ($hal-1)*$frm_s_jum_data+$a; ?></td> 
      <td nowrap><? echo $row["nama"]; ?></td> 
      <td nowrap><? echo $row["kelamin"]; ?></td> 
      <td nowrap><? //echo $row["kode_dosen1"]." - ".$row["nama_dosen1"] ; 
			$sql2="select * from kota where id_kota='".$row["kota_atlit"]."'";
			if(!($result2=mysql_db_query($DB,$sql2)))
			{
				// echo mysql_error();
				// return 0;
				//						echo "Kode dosen tidak terdaftar";
				echo "Kode - ";
			}
			else
			{
				if ($row2 = mysql_fetch_array($result2)) echo $row2["id_kota"]." - "; 
			}  
			echo $row2["nama"];				
			?> </td> 
      <td nowrap> <? 
			$sql2="select * from propinsi where id_propinsi='".$row["propinsi_atlit"]."'";
			if(!($result2 = mysql_db_query($DB,$sql2)))
			{
				// echo mysql_error();
				// return 0;
				//						echo "Kode dosen tidak terdaftar";
				echo "Kode - ";
			}
			else
			{
				if ($row2 = mysql_fetch_array($result2)) echo $row2["id_propinsi"]." - "; 
			}  
			echo $row2["nama"];
			?> </td> 
      <td nowrap> <div class="approval_font"> 
          <? 
					$sql_kab="SELECT * FROM apr_kabupaten 
							   WHERE tipe_member='atlit' AND
								     id_member='".$row["id_atlit"]."'
							  ORDER BY id_kab_apr DESC";
					$result_kab = mysql_db_query($DB,$sql_kab);
					if ($row_kab = mysql_fetch_array($result_kab)) 
					{
						if ($row_kab["status"]==1)
						{
						    echo "Disetujui";
							?> 
          <form action="<? echo curPageURL();?>" onSubmit="return konfirmasiReset();"> 
            <input type="hidden" name="frm_s_nama" id="frm_s_nama" value="<?php echo $frm_s_nama; ?>"> 
            <input type="hidden" name="frm_nama_atlit" id="frm_nama_atlit" value="<? echo $row["nama"];?>"> 
            <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
            <input type="hidden" name="var_apr_kab" id="var_apr_kab" value="0"> 
            <input type="hidden" name="id_atlit" id="id_atlit" value="<? echo $row["id_atlit"];?>"> 
            <input type="hidden" name="menu" id="menu" value="<? echo $_GET['menu'];?>"> 
            <input type="hidden" name="admin_user" id="admin_user" value="<? echo $session->username;?>"> 
            <input type="submit" name="btn_reset" id="submit" value="Set Ulang" class="approval_button"> 
          </form> 
          <?
						}
						else
						{
							echo "Belum- status 0";
							?> 
          <form action="<? echo curPageURL();?>" onSubmit="return konfirmasiSetuju();"> 
            <input type="hidden" name="frm_s_nama" value="<?php echo $frm_s_nama; ?>"> 
            <input type="hidden" name="frm_nama_atlit" id="frm_nama_atlit" value="<? echo $row["nama"];?>"> 
            <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
            <input type="hidden" name="var_apr_kab" id="var_apr_kab" value="1"> 
            <input type="hidden" name="id_atlit" id="id_atlit" value="<? echo $row["id_atlit"];?>"> 
            <input type="hidden" name="menu" id="menu" value="<? echo $_GET['menu'];?>"> 
            <input type="hidden" name="admin_user" id="admin_user" value="<? echo $session->username;?>"> 
            <input type="submit" name="btn_pending" id="submit" value="Pending" class="approval_button"> 
          </form> 
          <?
							
						}
					}
					else
					{
					//echo curPageURL();
					?> 
          <form action="<? echo curPageURL();?>" onSubmit="return konfirmasiSetuju();"> 
            <input type="hidden" name="frm_s_nama" value="<?php echo $frm_s_nama; ?>"> 
            <input type="hidden" name="frm_nama_atlit" id="frm_nama_atlit" value="<? echo $row["nama"];?>"> 
            <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
            <input type="hidden" name="var_apr_kab" id="var_apr_kab" value="1"> 
            <input type="hidden" name="id_atlit" id="id_atlit" value="<? echo $row["id_atlit"];?>"> 
            <input type="hidden" name="menu" id="menu" value="<? echo $_GET['menu'];?>"> 
            <input type="hidden" name="admin_user" id="admin_user" value="<? echo $session->username;?>"> 
            <input type="submit" name="btn_pending" id="submit" value="Pending" class="approval_button"> 
          </form> 
          <?
					}  
					 //echo curPageURL();
					?> 
        </div></td> 
      <!-- BEGIN STATUS PROPINSI--> 
      <td nowrap> <div class="approval_font"> 
          <? 
					$sql_prop="SELECT * FROM apr_propinsi  
							   WHERE tipe_member='atlit' AND
								     id_member='".$row["id_atlit"]."'
							  ORDER BY id_pro_apr DESC";
					$result_prop = mysql_db_query($DB,$sql_prop);
					if ($row_prop = mysql_fetch_array($result_prop)) 
					{
						if ($row_prop["status"]==1)
						{
						    echo "Disetujui";
							?> 
          <form action="<? echo curPageURL();?>" onSubmit="return konfirmasiReset();"> 
            <input type="hidden" name="frm_s_nama" id="frm_s_nama" value="<?php echo $frm_s_nama; ?>"> 
            <input type="hidden" name="frm_nama_atlit" id="frm_nama_atlit" value="<? echo $row["nama"];?>"> 
            <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
            <input type="hidden" name="var_apr_prop" id="var_apr_prop" value="0"> 
            <input type="hidden" name="id_atlit" id="id_atlit" value="<? echo $row["id_atlit"];?>"> 
            <input type="hidden" name="menu" id="menu" value="<? echo $_GET['menu'];?>"> 
            <input type="hidden" name="admin_user" id="admin_user" value="<? echo $session->username;?>"> 
            <input type="submit" name="btn_reset" id="submit" value="Set Ulang" class="approval_button"> 
          </form> 
          <?
						}
						else
						{
							echo "Belum- status 0";
							?> 
          <form action="<? echo curPageURL();?>" onSubmit="return konfirmasiSetuju();"> 
            <input type="hidden" name="frm_s_nama" value="<?php echo $frm_s_nama; ?>"> 
            <input type="hidden" name="frm_nama_atlit" id="frm_nama_atlit" value="<? echo $row["nama"];?>"> 
            <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
            <input type="hidden" name="var_apr_prop" id="var_apr_prop" value="1"> 
            <input type="hidden" name="id_atlit" id="id_atlit" value="<? echo $row["id_atlit"];?>"> 
            <input type="hidden" name="menu" id="menu" value="<? echo $_GET['menu'];?>"> 
            <input type="hidden" name="admin_user" id="admin_user" value="<? echo $session->username;?>"> 
            <input type="submit" name="btn_pending" id="submit" value="Pending" class="approval_button"> 
          </form> 
          <?
							
						}
					}
					else
					{
					//echo curPageURL();
					?> 
          <form action="<? echo curPageURL();?>" onSubmit="return konfirmasiSetuju();"> 
            <input type="hidden" name="frm_s_nama" value="<?php echo $frm_s_nama; ?>"> 
            <input type="hidden" name="frm_nama_atlit" id="frm_nama_atlit" value="<? echo $row["nama"];?>"> 
            <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
            <input type="hidden" name="var_apr_prop" id="var_apr_prop" value="1"> 
            <input type="hidden" name="id_atlit" id="id_atlit" value="<? echo $row["id_atlit"];?>"> 
            <input type="hidden" name="menu" id="menu" value="<? echo $_GET['menu'];?>"> 
            <input type="hidden" name="admin_user" id="admin_user" value="<? echo $session->username;?>"> 
            <input type="submit" name="btn_pending" id="submit" value="Pending" class="approval_button"> 
          </form> 
          <?
					}  
					 //echo curPageURL();
					?> 
        </div></td> 
      <!--END STATUS PROPINSI--> 
	  
	  <!--BEGIN STATUS PUSAT-->
      <td nowrap> 
	  <div class="approval_font">
	  <? 
					$sql_pusat="SELECT * FROM apr_pusat
							     WHERE tipe_member='atlit' AND
								       id_member='".$row["id_atlit"]."'";
					$result_pusat=mysql_db_query($DB,$sql_pusat);
					if ($row_pusat = mysql_fetch_array($result_pusat))
					{
						if ($row_pusat["status"]==1)
						{
						    echo "Disetujui";
							?> 
           <a href="nia.php?id_atlit=<?=$row["id_atlit"];?>&nama_atlit=<?=$row["nama"];?>" rel="facebox">remote.html</a>
          <form action="<? echo curPageURL();?>" onSubmit="return konfirmasiReset();"> 
            <input type="hidden" name="frm_s_nama" id="frm_s_nama" value="<?php echo $frm_s_nama; ?>"> 
            <input type="hidden" name="frm_nama_atlit" id="frm_nama_atlit" value="<? echo $row["nama"];?>"> 
            <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
            <input type="hidden" name="var_apr_pusat" id="var_apr_pusat" value="0"> 
            <input type="hidden" name="id_atlit" id="id_atlit" value="<? echo $row["id_atlit"];?>"> 
            <input type="hidden" name="menu" id="menu" value="<? echo $_GET['menu'];?>"> 
            <input type="hidden" name="admin_user" id="admin_user" value="<? echo $session->username;?>"> 
            <input type="submit" name="btn_reset" id="submit" value="Set Ulang" class="approval_button"> 
          </form> 
          <?
						}
						else
						{
							echo "Belum- status 0";
							?> 
          <form action="<? echo curPageURL();?>" onSubmit="return konfirmasiSetuju();"> 
            <input type="hidden" name="frm_s_nama" value="<?php echo $frm_s_nama; ?>"> 
            <input type="hidden" name="frm_nama_atlit" id="frm_nama_atlit" value="<? echo $row["nama"];?>"> 
            <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
            <input type="hidden" name="var_apr_pusat" id="var_apr_pusat" value="1"> 
            <input type="hidden" name="id_atlit" id="id_atlit" value="<? echo $row["id_atlit"];?>"> 
            <input type="hidden" name="menu" id="menu" value="<? echo $_GET['menu'];?>"> 
            <input type="hidden" name="admin_user" id="admin_user" value="<? echo $session->username;?>"> 
            <input type="submit" name="btn_pending" id="submit" value="Pending" class="approval_button"> 
          </form> 
          <?
							
						}
					}
					else
					{
					//echo curPageURL();
					?> 
          <form action="<? echo curPageURL();?>" onSubmit="return konfirmasiSetuju();"> 
            <input type="hidden" name="frm_s_nama" value="<?php echo $frm_s_nama; ?>"> 
            <input type="hidden" name="frm_nama_atlit" id="frm_nama_atlit" value="<? echo $row["nama"];?>"> 
            <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
            <input type="hidden" name="var_apr_pusat" id="var_apr_pusat" value="1"> 
            <input type="hidden" name="id_atlit" id="id_atlit" value="<? echo $row["id_atlit"];?>"> 
            <input type="hidden" name="menu" id="menu" value="<? echo $_GET['menu'];?>"> 
            <input type="hidden" name="admin_user" id="admin_user" value="<? echo $session->username;?>"> 
            <input type="submit" name="btn_pending" id="submit" value="Pending" class="approval_button"> 
          </form> 
          <?
					}  
					 //echo curPageURL();
					?> 
					</div>
					</td> 
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
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="atlit_export.php"> 
  <input type="hidden" name="mode" value="3"> 
  <input type="hidden" name="frm_s_judul" value="<?php echo $frm_s_judul; ?>"> 
  <input type="hidden" name="frm_s_jurusan" value="<?php echo $frm_s_jurusan; ?>"> 
  <input type="hidden" name="frm_s_nama" value="<?php echo $frm_s_nama; ?>"> 
  <input type="hidden" name="frm_s_kode_dosen1" value="<?php echo $frm_s_kode_dosen1; ?>"> 
  <input type="hidden" name="frm_s_kode_dosen2" value="<?php echo $frm_s_kode_dosen2; ?>"> 
  <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
  <?
	}
	?> 
  <div align="right"> 
    <input name="excel"   type="image" onClick="document.fexcel.action='atlit_export.php?t=excel'" src="../image/Mexcel.jpg" align="middle" width="18" height="18"> 
&nbsp; | &nbsp; 
    <input name="printer" type="image" onClick="document.fexcel.action='atlit_export.php?t=printer'" src="../image/print.gif" align="middle" width="18" height="18"> 
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
	$result = mysql_query("INSERT INTO apr_kabupaten (id_member, tipe_member, status, admin_user)VALUES(".$_GET['id_atlit'].", 'atlit', 1, '".$_GET['admin_user']."')" );
	if ($result) 
		{
			$pesan = $pesan."<br>Data Atlit '".$_GET['frm_nama_atlit']."' telah di SETUJUI";	
		}
	else
		{ 
			$pesan = $pesan."<br>Gagal menambahkan data atlit '".$_GET['frm_nama_atlit']."' - mohon hubungi admin". mysql_error();
		}

}
if ($_GET['var_apr_kab']=="0")
{
	$result = mysql_query("INSERT INTO apr_kabupaten (id_member, tipe_member, status, admin_user)VALUES(".$_GET['id_atlit'].", 'atlit', 0, '".$_GET['admin_user']."')" );
	if ($result) 
		{
			$pesan = $pesan."<br>Data Atlit '".$_GET['frm_nama_atlit']."' telah di SET ULANG";	
		}
	else
		{ 
			$pesan = $pesan."<br>Gagal menambahkan data atlit '".$_GET['frm_nama_atlit']."' - mohon hubungi admin". mysql_error();
		}

}
// BEGIN log PROPINSI
if ($_GET['var_apr_prop']=="1")
{
	$result = mysql_query("INSERT INTO apr_propinsi (id_member, tipe_member, status, admin_user)VALUES(".$_GET['id_atlit'].", 'atlit', 1, '".$_GET['admin_user']."')" );
	if ($result) 
		{
			$pesan = $pesan."<br>Data Atlit '".$_GET['frm_nama_atlit']."' telah di SETUJUI";	
		}
	else
		{ 
			$pesan = $pesan."<br>Gagal menambahkan data atlit '".$_GET['frm_nama_atlit']."' - mohon hubungi admin". mysql_error();
		}

}
if ($_GET['var_apr_prop']=="0")
{
	$result = mysql_query("INSERT INTO apr_propinsi (id_member, tipe_member, status, admin_user)VALUES(".$_GET['id_atlit'].", 'atlit', 0, '".$_GET['admin_user']."')" );
	if ($result) 
		{
			$pesan = $pesan."<br>Data Atlit '".$_GET['frm_nama_atlit']."' telah di SET ULANG";	
		}
	else
		{ 
			$pesan = $pesan."<br>Gagal menambahkan data atlit '".$_GET['frm_nama_atlit']."' - mohon hubungi admin". mysql_error();
		}

}  // END log PROPINSI

// BEGIN log PUSAT
if ($_GET['var_apr_pusat']=="1")
{
	$result = mysql_query("INSERT INTO apr_pusat (id_member, tipe_member, status, admin_user)VALUES(".$_GET['id_atlit'].", 'atlit', 1, '".$_GET['admin_user']."')" );
	if ($result) 
		{
			$pesan = $pesan."<br>Data Atlit '".$_GET['frm_nama_atlit']."' telah di SETUJUI";	
		}
	else
		{ 
			$pesan = $pesan."<br>Gagal menambahkan data atlit '".$_GET['frm_nama_atlit']."' - mohon hubungi admin". mysql_error();
		}

}
if ($_GET['var_apr_pusat']=="0")
{
	$result = mysql_query("INSERT INTO apr_pusat (id_member, tipe_member, status, admin_user)VALUES(".$_GET['id_atlit'].", 'atlit', 0, '".$_GET['admin_user']."')" );
	if ($result) 
		{
			$pesan = $pesan."<br>Data Atlit '".$_GET['frm_nama_atlit']."' telah di SET ULANG";	
		}
	else
		{ 
			$pesan = $pesan."<br>Gagal menambahkan data atlit '".$_GET['frm_nama_atlit']."' - mohon hubungi admin". mysql_error();
		}

}  // END log PUSAT
?> 
<font color="#FF0000"><strong><?php echo $pesan; ?></strong></font> 
</body>
</html>
