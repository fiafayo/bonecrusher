<?
/* 
   DATE CREATED : 31/05/11
   KEGUNAAN     : EDIT DATA KOTA
   VARIABEL     : 
*/

include("../include/session.php");
if($session->logged_in){

require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);
	
$frm_ID_kota = $_POST['frm_ID_kota'];
$frm_nama_kota = $_POST['frm_nama_kota'];
$frm_id_propinsi_kota = $_POST['frm_id_propinsi_kota'];

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
	if (($frm_ID_kota=='') or ($frm_nama_kota=='') or ($frm_id_propinsi_kota=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Data Kota tidak lengkap.<br> 
			Silahkan konfirmasi ke kota untuk melengkapi datanya.<br>
			Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
			if ($frm_exist==1) // update nomer induk kota
				{
					$result = mysql_query(" UPDATE kota SET `nama` = '$frm_nama_kota',
													        `id_propinsi_kota` = $frm_id_propinsi_kota
													  WHERE `id_kota` = $frm_ID_kota");
					if ($result) 
						{
							$pesan = $pesan."<br>Data Kota telah diubah";	
							/*
							$result = mysql_query("INSERT INTO apr_pusat (id_member, tipe_member, status, admin_user)VALUES(".$frm_ID_kota.", 'kota', 1, '".$session->username."')" );
							if ($result) 
								{
									//$pesan = $pesan."<br>Data Kota '".$_GET['frm_nama_kota']."' telah di SETUJUI";	
									$pesan = $pesan."<br>Nomer Induk Kota telah diubah";	
								}
							else
								{ 
									//$pesan = $pesan."<br>Gagal menambahkan data kota '".$_GET['frm_nama_kota']."' - mohon hubungi admin". mysql_error();
									$pesan = $pesan."<br>Gagal mengubah data Nomer Induk Kota - '".$frm_nama_kota."' - mohon hubungi admin". mysql_error();
								}
								*/
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal mengubah data Kota - ". mysql_error();
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
	    alert ('Data Kota <? echo $frm_nama_kota;?> telah di Hapus.');
		document.location="index.php?menu=kota";    
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
$frm_ID_kota=$_GET["id_kota"];
$frm_nama_kota=$_GET["nama_kota"];

		if ($frm_nama_kota!='')  {
		$result_cek = mysql_query("SELECT *
									 FROM kota 
									WHERE (nama='".$frm_nama_kota."' AND id_kota=".$frm_ID_kota.")");
					if ($row = mysql_fetch_array($result_cek)) {
							$frm_exist=1;
							$frm_id_propinsi_kota  =  $row["id_propinsi_kota"];
							$frm_nama_kota   =   $row["nama"];
							$frm_ID_kota   =  $row["id_kota"];
							$pesan = $pesan."<br>Data Kota ditemukan";
						}
					else
						{
							$frm_exist=0;
							$pesan = $pesan."<br>Data Kota tidak ditemukan<br>
							Silahkan hubungi administrator";
						}
			
		}

}

?>
<div id="stylized" class="myform"> 
    <form id="form_edit_kota" name="form_edit_kota" method="post" action="edit_kota.php?ok=1">
		<label>ID Kota<span class="small">data nomor ID Kota</span> </label>
		<input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist;?>">
		<input name="frm_ID_kota" type="text" id="frm_ID_kota" value="<?=$frm_ID_kota;?>" size="3" maxlength="3" readonly="readonly" /></td>
		<label>Nama Kota<span class="small">data nama Kota</span> </label>
		<input type="text" name="frm_nama_kota" id="frm_nama_kota" value="<?=$frm_nama_kota;?>" readonly="readonly"/></td>
		<label>Nama Propinsi<span class="small">data nama propinsi kota</span> </label>
		<select name="frm_id_propinsi_kota" id="frm_id_propinsi_kota" class="tekboxku">
            <option <?php if ($frm_propinsi==''){echo "selected";}?>>--- Pilih ---</option>
              <?php 
                    $sql_propinsi="SELECT * FROM propinsi";
                    $result = @mysql_query($sql_propinsi);
                    $c=0;
                    while ($row=@mysql_fetch_object($result))  {
                    $c=$c+1;
                    ?>
              <option value="<?php echo $row->id_propinsi; ?>" <?php if ($frm_id_propinsi_kota==$row->id_propinsi) { echo "selected"; }?>> <?php echo $row->nama; ?>			</option>
              <?php
                    }
                    ?>
          </select>
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
