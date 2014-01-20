<?
/* 
   DATE CREATED : 31/05/11
   KEGUNAAN     : EDIT DATA GABUNGAN
   VARIABEL     : 
*/

include("../include/session.php");
if($session->logged_in){

require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);
	
$frm_ID_gab = $_POST['frm_ID_gab'];
$frm_nama_gab = $_POST['frm_nama_gab'];
$frm_alamat_gab   =   $_POST['frm_alamat_gab'];
$frm_id_kota_gab  =  $_POST['frm_id_kota_gab'];
$frm_id_propinsi_gab  =  $_POST['frm_id_propinsi_gab'];

$frm_exist = $_POST['frm_exist'];
$act = $_GET['act'];
//
/*
echo "<br>frm_no_ID_gabungan=".$frm_no_ID_gabungan;
echo "<br>frm_nama=".$frm_nama;
echo "<br>frm_propinsi=".$frm_propinsi;
echo "<br>act=".$act;
echo "<br>frm_exist=".$frm_exist;*/

if ($act==1)   // INSERT
{ // simpan data


// NRP dan NAMA harus diisi
	if (($frm_ID_gab=='') or ($frm_nama_gab=='') or ($frm_alamat_gab=='') or ($frm_id_kota_gab=='')or ($frm_id_propinsi_gab=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Data Gabungan tidak lengkap.<br> 
			Silahkan konfirmasi ke gabungan untuk melengkapi datanya.<br>
			Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
			if ($frm_exist==1) // update nomer induk gabungan
				{
					$result = mysql_query(" UPDATE gabungan SET `nama` = '$frm_nama_gab',
																`alamat` = '$frm_alamat_gab',
																`kota_gabungan` =  $frm_id_kota_gab,
																`propinsi_gabungan` = $frm_id_propinsi_gab
														  WHERE `id_gabungan` = $frm_ID_gab");
					if ($result) 
						{
							$pesan = $pesan."<br>Data Gabungan telah diubah";	
							/*
							$result = mysql_query("INSERT INTO apr_pusat (id_member, tipe_member, status, admin_user)VALUES(".$frm_ID_gab.", 'gabungan', 1, '".$session->username."')" );
							if ($result) 
								{
									//$pesan = $pesan."<br>Data Gabungan '".$_GET['frm_nama_gab']."' telah di SETUJUI";	
									$pesan = $pesan."<br>Nomer Induk Gabungan telah diubah";	
								}
							else
								{ 
									//$pesan = $pesan."<br>Gagal menambahkan data gabungan '".$_GET['frm_nama_gab']."' - mohon hubungi admin". mysql_error();
									$pesan = $pesan."<br>Gagal mengubah data Nomer Induk Gabungan - '".$frm_nama_gab."' - mohon hubungi admin". mysql_error();
								}
								*/
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal mengubah data Gabungan - ". mysql_error();
						}
				}
		}
	}


if ($act==2) { // hapus data

/*$result = mysql_query("DELETE FROM gabungan WHERE id_gabungan = ".$frm_no_ID_gabungan);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
	*/
	//header("Location: {$_SERVER['PHP_SELF']}");
	?>
    <script language="javascript">//confirmRefresh();
	    alert ('Data Gabungan <? echo $frm_nama_gab;?> telah di Hapus.');
		document.location="index.php?menu=gabungan";    
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
			$(".example7").colorbox({width:"50%", height:800, iframe:true});
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
$frm_ID_gab=$_GET["id_gabungan"];
$frm_nama_gab=$_GET["nama_gabungan"];

		if ($frm_nama_gab!='')  {
		$result_cek = mysql_query("SELECT *
									 FROM gabungan 
									WHERE (nama='".$frm_nama_gab."' AND id_gabungan=".$frm_ID_gab.")");
					if ($row = mysql_fetch_array($result_cek)) {
							$frm_exist=1;
							$frm_ID_gab   =  $row["id_gabungan"];
							$frm_nama_gab   =   $row["nama"];
							$frm_alamat_gab   =   $row["alamat"];
							$frm_id_kota_gab  =  $row["kota_gabungan"];
							$frm_id_propinsi_gab  =  $row["propinsi_gabungan"];
							$pesan = $pesan."<br>Data Gabungan ditemukan";
						}
					else
						{
							$frm_exist=0;
							$pesan = $pesan."<br>Data Gabungan tidak ditemukan<br>
							Silahkan hubungi administrator";
						}
			
		}

}

?>
<div id="stylized" class="myform"> 
    <form id="form_edit_gabungan" name="form_edit_gabungan" method="post" action="edit_gabungan.php?ok=1">
		<label>ID Gabungan<span class="small">data nomor ID Gabungan</span> </label>
		<input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist;?>">
		<input name="frm_ID_gab" type="text" id="frm_ID_gab" value="<?=$frm_ID_gab;?>" size="3" maxlength="3" readonly="readonly" />
		<label>Nama Gabungan<span class="small">data nama Gabungan</span> </label>
		<input type="text" name="frm_nama_gab" id="frm_nama_gab" value="<?=$frm_nama_gab;?>"/>
		<label>Alamat Gabungan<span class="small">data alamat Gabungan</span> </label>
		<input type="text" name="frm_alamat_gab" id="frm_alamat_gab" value="<?=$frm_alamat_gab;?>"/>
		<label>Nama Kota<span class="small">data nama kota gabungan</span> </label>
		<select name="frm_id_kota_gab" id="frm_id_kota_gab" class="tekboxku">
            <option <?php if ($frm_id_kota_gab==''){echo "selected";}?>>--- Pilih ---</option>
              <?php 
                    $sql_kota="SELECT * FROM kota";
                    $result_kota = @mysql_query($sql_kota);
                    $c=0;
                    while ($row=@mysql_fetch_object($result_kota))  {
                    $c=$c+1;
                    ?>
              <option value="<?php echo $row->id_kota; ?>" <?php if ($frm_id_kota_gab==$row->id_kota) { echo "selected"; }?>> <?php echo $row->nama; ?>			</option>
				<?php
				}
				?>
          </select>
		  <label>Nama Propinsi<span class="small">data nama propinsi gabungan</span> </label>
		<select name="frm_id_propinsi_gab" id="frm_id_propinsi_gab" class="tekboxku">
            <option <?php if ($frm_propinsi==''){echo "selected";}?>>--- Pilih ---</option>
              <?php 
                    $sql_propinsi="SELECT * FROM propinsi";
                    $result = @mysql_query($sql_propinsi);
                    $c=0;
                    while ($row=@mysql_fetch_object($result))  {
                    $c=$c+1;
                    ?>
              <option value="<?php echo $row->id_propinsi; ?>" <?php if ($frm_id_propinsi_gab==$row->id_propinsi) { echo "selected"; }?>> <?php echo $row->nama; ?>			</option>
              <?php
                    }
                    ?>
          </select>
		<label>&nbsp;<span class="small"></span> </label>
            <input style="width:100px;" name="frm_simpan" id="frm_simpan" type="submit" onClick="this.form.action+='&act=1';this.form.submit();" value="Simpan">
            <input style="width:100px;" name="frm_batal" id="frm_batal" type="reset"  value="Batal">
        <? if ($frm_no_ID_gabungan) { ?>
            <input name="frm_hapus" id="frm_hapus" type="submit" onClick="if(confirm('Hapus ?')){this.form.action+='&act=2&id=<?php echo $frm_no_ID_gabungan;?>';this.form.submit()};" value="Hapus">
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
