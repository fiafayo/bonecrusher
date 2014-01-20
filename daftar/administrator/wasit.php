<?php
/* 
   DATE CREATED : 26/05/11
   KEGUNAAN     : MENAMPILKAN DATA WASIT
   VARIABEL     : 
*/
if($session->logged_in){
 
require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);
?>
<html>
<head>
<link href="../css/layout.css" rel="stylesheet" type="text/css">

<link media="screen" rel="stylesheet" href="../css/colorbox.css" />
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
			$(".example7").colorbox({width:"50%", height:350, iframe:true});
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

<script language="JavaScript">
function konfirmasiSetuju()
{
		var checkconfirm=confirm("Apakah Anda yakin MENYETUJUI Data Wasit ini" + " " + "\?")
		if (checkconfirm == true) 
			return true;
		else
			return false;
}
function konfirmasiReset()
{
		var checkconfirm=confirm("Apakah Anda yakin SET ULANG Data Wasit ini" + " " + "\?")
		if (checkconfirm == true) 
			return true;
		else
			return false;
}
</script>
<link rel="stylesheet" href="../css/modalbox.css" type="text/css" />
<style type="text/css" media="screen">
		#MB_loading {
			font-size: 13px;
		}
		#errmsg {
			margin: 1em;
			padding: 1em;
			color: #C30;
			background-color: #FCC;
			border: 1px solid #F00;
		}
	</style>
</head>
<body> 
<?php
if ($mode=="" || $mode=="0") 
{ ?> 
<font color="#FF0000"><strong><?php echo $pesan; ?></strong></font> 
<div id="stylized" class="myform"> 
  <form id="form" name="form"> 
    <h1>Cari Data Wasit</h1> 
    <p>Gunakan form dibawah ini untuk mencari Data Wasit</p> 
    <label>Nama <span class="small">ketik nama wasit</span> </label> 
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
    <input type="hidden" name="menu" value="wasit"> 
    <div class="spacer"></div> 
  </form> 
</div> 
<br>
<?
}
else
{
				 $sql="SELECT `id_wasit`,
				 			  `no_induk_wasit`,
							  `nama`,
							  `kelamin`,
							  `tempat_lahir`,
	   						   DATE_FORMAT(`tanggal_lahir`,'%d/%m/%Y') as tanggal_lahir,
							  `alamat`, 
							  `kota_wasit`,
							  `propinsi_wasit`,
							  `email`
						 FROM wasit 
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
		 $sql .= " and (wasit.nama LIKE '%".$frm_s_nama."%')";
	}
	/*if ($frm_s_jurusan!="all")
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
$abc="?mode=2&frm_s_nama=$frm_s_nama&frm_s_jum_data=$frm_s_jum_data&menu=wasit";

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
	echo "<br><br><a href=http://localhost/daftar/administrator/index.php?menu=wasit class=menu_left>:: Kembali</a>";
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
      <th>L/P</th> 
      <th>KOTA</th> 
      <th>PROPINSI</th> 
      <th nowrap>Status III <br> 
        (Kab.) </th> 
      <th nowrap>Status II<br> 
        (Prop.) </th> 
      <th nowrap>Status I<br> 
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
			$sql2="SELECT * FROM kota WHERE id_kota='".$row["kota_wasit"]."'";
			if(!($result2=mysql_db_query($DB,$sql2)))
			{
				// echo mysql_error();
				// return 0;
				//						echo "NPK Dosen tidak terdaftar";
				echo "Kode - ";
			}
			else
			{
				if ($row2 = mysql_fetch_array($result2)) echo $row2["id_kota"]." - "; 
			}  
			echo $row2["nama"];				
			?> </td> 
      <td nowrap> <? 
			$sql2="SELECT * FROM propinsi WHERE id_propinsi='".$row["propinsi_wasit"]."'";
			if(!($result2 = mysql_db_query($DB,$sql2)))
			{
				// echo mysql_error();
				// return 0;
				//						echo "NPK Dosen tidak terdaftar";
				echo "Kode - ";
			}
			else
			{
				if ($row2 = mysql_fetch_array($result2)) echo $row2["id_propinsi"]." - "; 
			}  
			echo $row2["nama"];
			?> </td> 
      <td nowrap <? if ($session->isLevel_kab()==1) { echo "style=\"background-color:#FFEAEA\""; }?>> 
	  <div class="approval_font"> 
          <? 
					$sql_kab="SELECT * FROM apr_kabupaten 
							   WHERE tipe_member='wasit' AND
								     id_member='".$row["id_wasit"]."'
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
            <input type="hidden" name="frm_nama_wasit" id="frm_nama_wasit" value="<? echo $row["nama"];?>"> 
            <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
            <input type="hidden" name="var_apr_kab" id="var_apr_kab" value="0"> 
            <input type="hidden" name="id_wasit" id="id_wasit" value="<? echo $row["id_wasit"];?>"> 
            <input type="hidden" name="menu" id="menu" value="<? echo $_GET['menu'];?>"> 
            <input type="hidden" name="admin_user" id="admin_user" value="<? echo $session->username;?>"> 
            <input type="submit" name="btn_reset" id="submit" value="Set Ulang" class="approval_button" <? if ($session->isLevel_kab()<>1) { echo "disabled"; }?>> 
          </form> 
          <?
						}
						else
						{
							echo "Belum- status 0";
							?> 
          <form action="<? echo curPageURL();?>" onSubmit="return konfirmasiSetuju();"> 
            <input type="hidden" name="frm_s_nama" value="<?php echo $frm_s_nama; ?>"> 
            <input type="hidden" name="frm_nama_wasit" id="frm_nama_wasit" value="<? echo $row["nama"];?>"> 
            <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
            <input type="hidden" name="var_apr_kab" id="var_apr_kab" value="1"> 
            <input type="hidden" name="id_wasit" id="id_wasit" value="<? echo $row["id_wasit"];?>"> 
            <input type="hidden" name="menu" id="menu" value="<? echo $_GET['menu'];?>"> 
            <input type="hidden" name="admin_user" id="admin_user" value="<? echo $session->username;?>"> 
            <input type="submit" name="btn_pending" id="submit" value="Pending" class="approval_button" <? if ($session->isLevel_kab()<>1) { echo "disabled"; }?>> 
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
            <input type="hidden" name="frm_nama_wasit" id="frm_nama_wasit" value="<? echo $row["nama"];?>"> 
            <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
            <input type="hidden" name="var_apr_kab" id="var_apr_kab" value="1"> 
            <input type="hidden" name="id_wasit" id="id_wasit" value="<? echo $row["id_wasit"];?>"> 
            <input type="hidden" name="menu" id="menu" value="<? echo $_GET['menu'];?>"> 
            <input type="hidden" name="admin_user" id="admin_user" value="<? echo $session->username;?>"> 
            <input type="submit" name="btn_pending" id="submit" value="Pending" class="approval_button" <? if ($session->isLevel_kab()<>1) { echo "disabled"; }?>> 
          </form> 
          <?
					}  
					 //echo curPageURL();
					?> 
        </div></td> 
      <!-- BEGIN STATUS PROPINSI--> 
      <td nowrap <? if ($session->isLevel_prop()==1) { echo "style=\"background-color:#FFEAEA\""; }?>> 
	  <div class="approval_font"> 
          <? 
					$sql_prop="SELECT * FROM apr_propinsi  
							   WHERE tipe_member='wasit' AND
								     id_member='".$row["id_wasit"]."'
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
            <input type="hidden" name="frm_nama_wasit" id="frm_nama_wasit" value="<? echo $row["nama"];?>"> 
            <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
            <input type="hidden" name="var_apr_prop" id="var_apr_prop" value="0"> 
            <input type="hidden" name="id_wasit" id="id_wasit" value="<? echo $row["id_wasit"];?>"> 
            <input type="hidden" name="menu" id="menu" value="<? echo $_GET['menu'];?>"> 
            <input type="hidden" name="admin_user" id="admin_user" value="<? echo $session->username;?>"> 
            <input type="submit" name="btn_reset" id="submit" value="Set Ulang" class="approval_button" <? if ($session->isLevel_prop()<>1) { echo "disabled"; }?>> 
          </form> 
          <?
						}
						else
						{
							echo "Belum- status 0";
							?> 
          <form action="<? echo curPageURL();?>" onSubmit="return konfirmasiSetuju();"> 
            <input type="hidden" name="frm_s_nama" value="<?php echo $frm_s_nama; ?>"> 
            <input type="hidden" name="frm_nama_wasit" id="frm_nama_wasit" value="<? echo $row["nama"];?>"> 
            <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
            <input type="hidden" name="var_apr_prop" id="var_apr_prop" value="1"> 
            <input type="hidden" name="id_wasit" id="id_wasit" value="<? echo $row["id_wasit"];?>"> 
            <input type="hidden" name="menu" id="menu" value="<? echo $_GET['menu'];?>"> 
            <input type="hidden" name="admin_user" id="admin_user" value="<? echo $session->username;?>"> 
            <input type="submit" name="btn_pending" id="submit" value="Pending" class="approval_button" <? if ($session->isLevel_prop()<>1) { echo "disabled"; }?>> 
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
            <input type="hidden" name="frm_nama_wasit" id="frm_nama_wasit" value="<? echo $row["nama"];?>"> 
            <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
            <input type="hidden" name="var_apr_prop" id="var_apr_prop" value="1"> 
            <input type="hidden" name="id_wasit" id="id_wasit" value="<? echo $row["id_wasit"];?>"> 
            <input type="hidden" name="menu" id="menu" value="<? echo $_GET['menu'];?>"> 
            <input type="hidden" name="admin_user" id="admin_user" value="<? echo $session->username;?>"> 
            <input type="submit" name="btn_pending" id="submit" value="Pending" class="approval_button" <? if ($session->isLevel_prop()<>1) { echo "disabled"; }?>> 
          </form> 
          <?
					}  
					 //echo curPageURL();
					?> 
        </div></td> 
      <!--END STATUS PROPINSI--> 
	  
	  <!--BEGIN STATUS PUSAT-->
      <td nowrap <? if ($session->isLevel_pusat()==1) { echo "style=\"background-color:#FFEAEA\""; }?>> 
	  <div class="approval_font">
	  <? 
					$sql_pusat="SELECT * FROM apr_pusat
							     WHERE tipe_member='wasit' AND
								       id_member='".$row["id_wasit"]."'";
					$result_pusat=mysql_db_query($DB,$sql_pusat);
					if ($row_pusat = mysql_fetch_array($result_pusat))
					{
						if ($row_pusat["status"]==1)
						{
						    echo "Disetujui";
				             
						    if ($session->isLevel_pusat()==1) { 
							?> 
						     <a class='example7' href="niw.php?id_wasit=<?=$row["id_wasit"];?>&nama_wasit=<?=$row["nama"];?>">Set NIW</a>
						   <? }?>
		  <form action="<? echo curPageURL();?>" onSubmit="return konfirmasiReset();"> 
            <input type="hidden" name="frm_s_nama" id="frm_s_nama" value="<?php echo $frm_s_nama; ?>"> 
            <input type="hidden" name="frm_nama_wasit" id="frm_nama_wasit" value="<? echo $row["nama"];?>"> 
            <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
            <input type="hidden" name="var_apr_pusat" id="var_apr_pusat" value="0"> 
            <input type="hidden" name="id_wasit" id="id_wasit" value="<? echo $row["id_wasit"];?>"> 
            <input type="hidden" name="menu" id="menu" value="<? echo $_GET['menu'];?>"> 
            <input type="hidden" name="admin_user" id="admin_user" value="<? echo $session->username;?>"> 
            <input type="submit" name="btn_reset" id="submit" value="Set Ulang" class="approval_button" <? if ($session->isLevel_pusat()<>1) { echo "disabled"; }?>> 
          </form> 
          <?
						}
						else
						{
							echo "Belum- status 0";
							?> 
          <form action="<? echo curPageURL();?>" onSubmit="return konfirmasiSetuju();"> 
            <input type="hidden" name="frm_s_nama" value="<?php echo $frm_s_nama; ?>"> 
            <input type="hidden" name="frm_nama_wasit" id="frm_nama_wasit" value="<? echo $row["nama"];?>"> 
            <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
            <input type="hidden" name="var_apr_pusat" id="var_apr_pusat" value="1"> 
            <input type="hidden" name="id_wasit" id="id_wasit" value="<? echo $row["id_wasit"];?>"> 
            <input type="hidden" name="menu" id="menu" value="<? echo $_GET['menu'];?>"> 
            <input type="hidden" name="admin_user" id="admin_user" value="<? echo $session->username;?>"> 
            <input type="submit" name="btn_pending" id="submit" value="Pending" class="approval_button" <? if ($session->isLevel_pusat()<>1) { echo "disabled"; }?>> 
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
            <input type="hidden" name="frm_nama_wasit" id="frm_nama_wasit" value="<? echo $row["nama"];?>"> 
            <input type="hidden" name="frm_s_jum_data" value="<?php echo $frm_s_jum_data; ?>"> 
            <input type="hidden" name="var_apr_pusat" id="var_apr_pusat" value="1"> 
            <input type="hidden" name="id_wasit" id="id_wasit" value="<? echo $row["id_wasit"];?>"> 
            <input type="hidden" name="menu" id="menu" value="<? echo $_GET['menu'];?>"> 
            <input type="hidden" name="admin_user" id="admin_user" value="<? echo $session->username;?>"> 
            <input type="submit" name="btn_pending" id="submit" value="Pending" class="approval_button" <? if ($session->isLevel_pusat()<>1) { echo "disabled"; }?>> 
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
<FORM METHOD="Post" name="fexcel" id="fexcel" ACTION="wasit_export.php"> 
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
    <input name="excel"   type="image" onClick="document.fexcel.action='wasit_export.php?t=excel'" src="../image/Mexcel.jpg" align="middle" width="18" height="18"> 
&nbsp; | &nbsp; 
    <input name="printer" type="image" onClick="document.fexcel.action='wasit_export.php?t=printer'" src="../image/print.gif" align="middle" width="18" height="18"> 
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
	$result = mysql_query("INSERT INTO apr_kabupaten (id_member, tipe_member, status, admin_user)VALUES(".$_GET['id_wasit'].", 'wasit', 1, '".$_GET['admin_user']."')" );
	if ($result) 
		{
			$pesan = $pesan."<br>Data Wasit '".$_GET['frm_nama_wasit']."' telah di SETUJUI";	
		}
	else
		{ 
			$pesan = $pesan."<br>Gagal menambahkan data wasit '".$_GET['frm_nama_wasit']."' - mohon hubungi admin". mysql_error();
		}

}
if ($_GET['var_apr_kab']=="0")
{
	$result = mysql_query("INSERT INTO apr_kabupaten (id_member, tipe_member, status, admin_user)VALUES(".$_GET['id_wasit'].", 'wasit', 0, '".$_GET['admin_user']."')" );
	if ($result) 
		{
			$pesan = $pesan."<br>Data Wasit '".$_GET['frm_nama_wasit']."' telah di SET ULANG";	
		}
	else
		{ 
			$pesan = $pesan."<br>Gagal menambahkan data wasit '".$_GET['frm_nama_wasit']."' - mohon hubungi admin". mysql_error();
		}

}
// BEGIN log PROPINSI
if ($_GET['var_apr_prop']=="1")
{
	$result = mysql_query("INSERT INTO apr_propinsi (id_member, tipe_member, status, admin_user)VALUES(".$_GET['id_wasit'].", 'wasit', 1, '".$_GET['admin_user']."')" );
	if ($result) 
		{
			$pesan = $pesan."<br>Data Wasit '".$_GET['frm_nama_wasit']."' telah di SETUJUI";	
		}
	else
		{ 
			$pesan = $pesan."<br>Gagal menambahkan data wasit '".$_GET['frm_nama_wasit']."' - mohon hubungi admin". mysql_error();
		}

}
if ($_GET['var_apr_prop']=="0")
{
	$result = mysql_query("INSERT INTO apr_propinsi (id_member, tipe_member, status, admin_user)VALUES(".$_GET['id_wasit'].", 'wasit', 0, '".$_GET['admin_user']."')" );
	if ($result) 
		{
			$pesan = $pesan."<br>Data Wasit '".$_GET['frm_nama_wasit']."' telah di SET ULANG";	
		}
	else
		{ 
			$pesan = $pesan."<br>Gagal menambahkan data wasit '".$_GET['frm_nama_wasit']."' - mohon hubungi admin". mysql_error();
		}

}  // END log PROPINSI

// BEGIN log PUSAT
if ($_GET['var_apr_pusat']=="1")
{
	$result = mysql_query("INSERT INTO apr_pusat (id_member, tipe_member, status, admin_user)VALUES(".$_GET['id_wasit'].", 'wasit', 1, '".$_GET['admin_user']."')" );
	if ($result) 
		{
			$pesan = $pesan."<br>Data Wasit '".$_GET['frm_nama_wasit']."' telah di SETUJUI";	
		}
	else
		{ 
			$pesan = $pesan."<br>Gagal menambahkan data wasit '".$_GET['frm_nama_wasit']."' - mohon hubungi admin". mysql_error();
		}

}
if ($_GET['var_apr_pusat']=="0")
{
	$result = mysql_query("INSERT INTO apr_pusat (id_member, tipe_member, status, admin_user)VALUES(".$_GET['id_wasit'].", 'wasit', 0, '".$_GET['admin_user']."')" );
	if ($result) 
		{
			$pesan = $pesan."<br>Data Wasit '".$_GET['frm_nama_wasit']."' telah di SET ULANG";	
		}
	else
		{ 
			$pesan = $pesan."<br>Gagal menambahkan data wasit '".$_GET['frm_nama_wasit']."' - mohon hubungi admin". mysql_error();
		}

}  // END log PUSAT
?> 
<font color="#FF0000"><strong><?php echo $pesan; ?></strong></font> 
</body>
</html>
<?
}
else
{
	header('Location: ../process.php');
}?>
