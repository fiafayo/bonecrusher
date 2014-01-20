<?
/* 
   DATE CREATED : 04/05/11
   KEGUNAAN     : GABSI PUSAT MEMBERIKAN NIW(nomer induk wasit)
   VARIABEL     : 
*/

include("../include/session.php");
if($session->logged_in){

require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);
	
$frm_no_ID_Wasit = $_POST['frm_no_ID_Wasit'];
$frm_nama_wasit = $_POST['frm_nama_wasit'];
$frm_NIW = $_POST['frm_NIW'];						
$frm_exist = $_POST['frm_exist'];
$act = $_GET['act'];
//
/*
echo "<br>frm_no_ID_kota=".$frm_no_ID_kota;
echo "<br>frm_nama=".$frm_nama;
echo "<br>frm_propinsi=".$frm_propinsi;
echo "<br>act=".$act;
echo "<br>frm_exist=".$frm_exist;*/

if ($act==1)   // INSERT
{ // simpan data


// NRP dan NAMA harus diisi
	if (($frm_no_ID_Wasit=='') or ($frm_nama_wasit=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Data Wasit tidak lengkap.<br> 
			Silahkan konfirmasi ke wasit untuk melengkapi datanya.<br>
			Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
			if ($frm_exist==1) // update nomer induk wasit
				{
					$result = mysql_query(" UPDATE wasit SET `no_induk_wasit` = '$frm_NIW'
													   WHERE `id_wasit` = $frm_no_ID_Wasit");
					if ($result) 
						{
							//$pesan = $pesan."<br>Nomer Induk Wasit telah diubah";	
							$result = mysql_query("INSERT INTO apr_pusat (id_member, tipe_member, status, admin_user)VALUES(".$frm_no_ID_Wasit.", 'wasit', 1, '".$session->username."')" );
							if ($result) 
								{
									//$pesan = $pesan."<br>Data Wasit '".$_GET['frm_nama_wasit']."' telah di SETUJUI";	
									$pesan = $pesan."<br>Nomer Induk Wasit telah diubah";	
								}
							else
								{ 
									//$pesan = $pesan."<br>Gagal menambahkan data wasit '".$_GET['frm_nama_wasit']."' - mohon hubungi admin". mysql_error();
									$pesan = $pesan."<br>Gagal mengubah data Nomer Induk Wasit - '".$frm_nama_wasit."' - mohon hubungi admin". mysql_error();
								}
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal mengubah data - ". mysql_error();
						}
				}
		}
	}


if ($act==2) { // hapus data

/*$result = mysql_query("DELETE FROM kota WHERE id_kota = ".$frm_no_ID_kota);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
	*/
	//header("Location: {$_SERVER['PHP_SELF']}");
	?>
    <script language="javascript">//confirmRefresh();
	    alert ('Data Wasit <? echo $frm_nama;?> telah di Hapus.');
		document.location="index.php?menu=wasit";    
    </script>
    <?
}

	
?>
<link href="../css/layout.css" rel="stylesheet" type="text/css">
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
			$(".example7").colorbox({width:"50%", height:"80%", iframe:true});
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
			$('#frm_batal').click(function () {
				//$(".example7").colorbox({transition:"fade"});
               // parent.$.fn.colorbox.close();
				
				$('.example7').fadeOut(9000, function() {
				// Animation complete.
				
				});
				parent.$.fn.colorbox.close();
                return false;
            });
		});
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
<!--p><a href="javascript:confirmRefresh();">Refresh Page</a></p-->

<?
if ($act <> 1)
{
$frm_no_ID_Wasit=$_GET["id_wasit"];
$frm_nama_wasit=$_GET["nama_wasit"];

		if ($frm_nama_wasit!='')  {
		$result_cek = mysql_query("SELECT *
									 FROM wasit 
									WHERE (nama='".$frm_nama_wasit."' AND id_wasit=".$frm_no_ID_Wasit.")");
					if ($row = mysql_fetch_array($result_cek)) {
							$frm_exist=1;
							$frm_NIW =  $row["no_induk_wasit"];
							$frm_nama_wasit   =   $row["nama"];
							$frm_no_ID_Wasit   =  $row["id_wasit"];
							$pesan = $pesan."<br>Data Wasit ditemukan";
						}
					else
						{
							$frm_exist=0;
							$pesan = $pesan."<br>Data Wasit tidak ditemukan<br>
							Silahkan hubungi administrator";
						}
			
		}

}

?>
<div id="stylized" class="myform"> 
    <form id="form_input_niw" name="form_input_niw" method="post" action="niw.php?ok=1">
		<label>ID Wasit<span class="small">data nomor ID Wasit</span> </label>
		<input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist;?>">
		<input name="frm_no_ID_Wasit" type="text" id="frm_no_ID_Wasit" value="<?=$frm_no_ID_Wasit;?>" size="3" maxlength="3" readonly="readonly" /></td>
		<label>Nama Wasit<span class="small">data nama Wasit</span> </label>
		<input type="text" name="frm_nama_wasit" id="frm_nama_wasit" value="<?=$frm_nama_wasit;?>" readonly="readonly"/></td>
		<label>NIP<span class="small">ketik Nomor Induk Wasit</span> </label>
		<input name="frm_NIW" type="text" id="frm_NIW" value="<?=$frm_NIW;?>" size="30" maxlength="12"/></td>
		<label>&nbsp;<span class="small"></span> </label>
            <input style="width:100px;" name="frm_simpan" id="frm_simpan" type="submit" onClick="this.form.action+='&act=1';this.form.submit();" value="Simpan">
            <input style="width:100px;" name="frm_batal" id="frm_batal" type="reset"  value="Batal">
        <? if ($frm_no_ID_kota) { ?>
            <input name="frm_hapus" id="frm_hapus" type="submit" onClick="if(confirm('Hapus ?')){this.form.action+='&act=2&id=<?php echo $frm_no_ID_kota;?>';this.form.submit()};" value="Hapus">
        <? } ?>
    </form>

	<div class="spacer">
	</div>
	<font color="#FF6600"><b><? echo $pesan;?></b></font>
</div>
<?
}
else
{
	header('Location: ../process.php');
}?>
