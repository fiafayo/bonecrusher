<?
/* 
   DATE CREATED : 31/05/11
   KEGUNAAN     : EDIT DATA CLUB
   VARIABEL     : 
*/

include("../include/session.php");
if($session->logged_in){

require("../include/global.php");
require("../include/fungsi.php");

f_connecting();
	mysql_select_db($DB);
	
$frm_ID_club = $_POST['frm_ID_club'];
$frm_nama_club = $_POST['frm_nama_club'];
$frm_alamat_club  =  $_POST['frm_alamat_club'];
$frm_id_kota_club  =  $_POST['frm_id_kota_club'];;
$frm_id_propinsi_club  =  $_POST['frm_id_propinsi_club'];
$frm_exist = $_POST['frm_exist'];
$act = $_GET['act'];
//
/*
echo "<br>frm_no_ID_club=".$frm_no_ID_club;
echo "<br>frm_nama=".$frm_nama;
echo "<br>frm_propinsi=".$frm_propinsi;
echo "<br>act=".$act;
echo "<br>frm_exist=".$frm_exist;*/

if ($act==1)   // INSERT
{ // simpan data


// NRP dan NAMA harus diisi
	if (($frm_ID_club=='') or ($frm_nama_club=='') or ($frm_alamat_club=='') or ($frm_id_kota_club=='') or ($frm_id_propinsi_club=='')) 
		{
			$error = 1;
			$pesan=$pesan."<br>Maaf, Data Club tidak lengkap.<br> 
			Silahkan konfirmasi ke club untuk melengkapi datanya.<br>
			Gagal menyimpan data.";
		}

	if ($error !=1) // Jika semua isian form valid 
		{
			if ($frm_exist==1) // update nomer induk club
				{
					$result = mysql_query(" UPDATE club SET `nama` = '$frm_nama_club',
														    `alamat` = '$frm_alamat_club',
															`kota_club` =  $frm_id_kota_club,
													        `propinsi_club` = $frm_id_propinsi_club
													  WHERE `id_club` = $frm_ID_club");
					if ($result) 
						{
							$pesan = $pesan."<br>Data Club telah diubah";	
							/*
							$result = mysql_query("INSERT INTO apr_pusat (id_member, tipe_member, status, admin_user)VALUES(".$frm_ID_club.", 'club', 1, '".$session->username."')" );
							if ($result) 
								{
									//$pesan = $pesan."<br>Data Club '".$_GET['frm_nama_club']."' telah di SETUJUI";	
									$pesan = $pesan."<br>Nomer Induk Club telah diubah";	
								}
							else
								{ 
									//$pesan = $pesan."<br>Gagal menambahkan data club '".$_GET['frm_nama_club']."' - mohon hubungi admin". mysql_error();
									$pesan = $pesan."<br>Gagal mengubah data Nomer Induk Club - '".$frm_nama_club."' - mohon hubungi admin". mysql_error();
								}
								*/
						}
					else
						{ 
							$pesan = $pesan."<br>Gagal mengubah data Club - ". mysql_error();
						}
				}
		}
	}


if ($act==2) { // hapus data

/*$result = mysql_query("DELETE FROM club WHERE id_club = ".$frm_no_ID_club);
	if ($result) {$pesan = "data telah dihapus";	}else{ $pesan = "gagal menghapus data";}
	*/
	//header("Location: {$_SERVER['PHP_SELF']}");
	?>
    <script language="javascript">//confirmRefresh();
	    alert ('Data Club <? echo $frm_nama_club;?> telah di Hapus.');
		document.location="index.php?menu=club";    
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
$frm_ID_club=$_GET["id_club"];
$frm_nama_club=$_GET["nama_club"];

		if ($frm_nama_club!='')  {
		$result_cek = mysql_query("SELECT *
									 FROM club 
									WHERE (nama='".$frm_nama_club."' AND id_club=".$frm_ID_club.")");
					if ($row = mysql_fetch_array($result_cek)) {
							$frm_exist=1;
							$frm_ID_club   =  $row["id_club"];
							$frm_nama_club   =   $row["nama"];
							$frm_alamat_club   =   $row["alamat"];
							$frm_id_kota_club  =  $row["kota_club"];
							$frm_id_propinsi_club  =  $row["propinsi_club"];
							$pesan = $pesan."<br>Data Club ditemukan";
						}
					else
						{
							$frm_exist=0;
							$pesan = $pesan."<br>Data Club tidak ditemukan<br>
							Silahkan hubungi administrator";
						}
			
		}

}

?>
<div id="stylized" class="myform"> 
    <form id="form_edit_club" name="form_edit_club" method="post" action="edit_club.php?ok=1">
		<label>ID Club<span class="small">data nomor ID Club</span> </label>
		<input name="frm_exist" type="hidden" id="frm_exist"  value="<?php echo $frm_exist;?>">
		<input name="frm_ID_club" type="text" id="frm_ID_club" value="<?=$frm_ID_club;?>" size="3" maxlength="3" readonly="readonly" />
		<label>Nama Club<span class="small">data nama Club</span> </label>
		<input type="text" name="frm_nama_club" id="frm_nama_club" value="<?=$frm_nama_club;?>"/>
		<label>Alamat Club<span class="small">data alamat Club</span> </label>
		<input type="text" name="frm_alamat_club" id="frm_alamat_club" value="<?=$frm_alamat_club;?>"/>
		<label>Nama Kota<span class="small">data nama kota club</span> </label>
		<select name="frm_id_kota_club" id="frm_id_kota_club" class="tekboxku">
            <option <?php if ($frm_id_kota_club==''){echo "selected";}?>>--- Pilih ---</option>
              <?php 
                    $sql_kota="SELECT * FROM kota";
                    $result_kota = @mysql_query($sql_kota);
                    $c=0;
                    while ($row=@mysql_fetch_object($result_kota))  {
                    $c=$c+1;
                    ?>
              <option value="<?php echo $row->id_kota; ?>" <?php if ($frm_id_kota_club==$row->id_kota) { echo "selected"; }?>> <?php echo $row->nama; ?>			</option>
				<?php
				}
				?>
          </select>
		  <label>Nama Propinsi<span class="small">data nama propinsi club</span> </label>
		<select name="frm_id_propinsi_club" id="frm_id_propinsi_club" class="tekboxku">
            <option <?php if ($frm_id_propinsi_club==''){echo "selected";}?>>--- Pilih ---</option>
              <?php 
                    $sql_propinsi="SELECT * FROM propinsi";
                    $result = @mysql_query($sql_propinsi);
                    $c=0;
                    while ($row=@mysql_fetch_object($result))  {
                    $c=$c+1;
                    ?>
              <option value="<?php echo $row->id_propinsi; ?>" <?php if ($frm_id_propinsi_club==$row->id_propinsi) { echo "selected"; }?>> <?php echo $row->nama; ?>			</option>
              <?php
                    }
                    ?>
          </select>
		<label>&nbsp;<span class="small"></span> </label>
            <input style="width:100px;" name="frm_simpan" id="frm_simpan" type="submit" onClick="this.form.action+='&act=1';this.form.submit();" value="Simpan">
            <input style="width:100px;" name="frm_batal" id="frm_batal" type="reset"  value="Batal">
        <? if ($frm_no_ID_club) { ?>
            <input name="frm_hapus" id="frm_hapus" type="submit" onClick="if(confirm('Hapus ?')){this.form.action+='&act=2&id=<?php echo $frm_no_ID_club;?>';this.form.submit()};" value="Hapus">
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
