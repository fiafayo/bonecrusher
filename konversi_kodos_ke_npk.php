<?php
/*
 * Terlebih dahulu lakukan SQL ini :
 * ALTER TABLE `dosen` ADD `kode_dosen` INT NULL , ADD INDEX ( `kode_dosen` ) ;
 * ALTER TABLE `riwayat_jabatan_kopertis` ADD `kode_dosen` INT NULL , ADD INDEX ( `kode_dosen` ) ;
 * ALTER TABLE `riwayat_jabatan_lokal` ADD `kode_dosen` INT NULL , ADD INDEX ( `kode_dosen` ) ;
 * ALTER TABLE `master_karyawan` ADD `kode_dosen` INT NULL , ADD INDEX ( `kode_dosen` ) ;
 * UPDATE master_karyawan set kode_dosen=kode;
 * UPDATE master_karyawan set kode=nip;
 * UPDATE riwayat_jabatan_kopertis set kode_dosen=kode;
 * UPDATE riwayat_jabatan_lokal set kode_dosen=kode;
 * UPDATE riwayat_jabatan_kopertis set kode=NPK;
 * UPDATE riwayat_jabatan_lokal set kode=NPK;
 * UPDATE dosen set kode_dosen=kode;
 * UPDATE dosen set kode=npk WHERE npk<>'---' AND npk<>'';
 */
$tableNames=array(
    'absensi'=>array('Kode_Dosen'),
    'daftar_kp'=>array('DOSEN'),
    'daftar_kp_old'=>array('DOSEN'),
    'daftar_uji'=>array('kode_ketua','kode_sekre','kode_dosen1','kode_dosen2','kode_dosen3'),
    'daftar_uji_lp'=>array('PEMBIMBING_1','PEMBIMBING_2','PENGUJI_1','PENGUJI_2'),
    'ganti_dobing'=>array('kode_dobing_lama','kode_dobing_baru'),
    'ganti_dobing_lp'=>array('kode_dobing_lama','kode_dobing_baru'),
    'gan_dos'=>array('F_KOLA','F_KOBA'),
    'index_belajar_dosen'=>array('kode_dosen'),
    'master_lp'=>array('KODOS1','KODOS2'),
    'master_ta'=>array('KODOS1','KODOS2'),
    'penelitian'=>array('kode_dosen'),
    'pengabdian'=>array('kode_dosen'),
    'profil_kerjasama'=>array('kode_dosen'),
    'publikasi'=>array('kode_kary','kode_kary2','kode_kary3','kode_kary4','kode_kary5'),
    'publikasi2'=>array('kode_kary','kode_kary2','kode_kary3','kode_kary4','kode_kary5'),
    'publikasi_okt_2009'=>array('kode_kary','kode_kary2','kode_kary3','kode_kary4','kode_kary5'),
    'rekap_dosen'=>array('kode_dsn'),
    'riwayat_pendidikan'=>array('kode_dosen'),
    'tulisan_ilmiah'=>array('kode_dosen1','kode_dosen2','kode_dosen3','kode_dosen4','kode_dosen5'),
    'usulan'=>array('Kode_Dosen')
);

$kode2npk=array(
'6102'=>'186011',
'6103'=>'186014',
'6104'=>'186012',
'6106'=>'186015',
'6108'=>'187012',
'6109'=>'187015',
'6110'=>'187016',
'6111'=>'187014',
'6112'=>'187018',
'6114'=>'210008',
'6116'=>'188019',
'6117'=>'188018',
'6122'=>'189017',
'6128'=>'191028',
'6131'=>'192008',
'6133'=>'192014',
'6134'=>'193015',
'6136'=>'193032',
'6137'=>'194005',
'6138'=>'194008',
'6142'=>'194029',
'6143'=>'194024',
'6144'=>'194023',
'6145'=>'195003',
'6147'=>'195011',
'6149'=>'195012',
'6150'=>'195013',
'6153'=>'195017',
'6158'=>'195035',
'6162'=>'195040',
'6163'=>'195055',
'6165'=>'196034',
'6166'=>'196035',
'6168'=>'197010',
'6169'=>'197030',
'6173'=>'197027',
'6178'=>'199024',
'6179'=>'200006',
'6181'=>'198011',
'6182'=>'198016',
'6185'=>'198025',
'6186'=>'198032',
'6187'=>'198031',
'6188'=>'198033',
'6189'=>'198036',
'6190'=>'198034',
'6193'=>'199005',
'6196'=>'199013',
'6197'=>'199019',
'6198'=>'199020',
'6199'=>'199018',
'6201'=>'205717',
'6203'=>'209300',
'6205'=>'210107',
'6206'=>'203601',
'6211'=>'209301',
'6213'=>'209302',
'6215'=>'205704',
'6216'=>'210108',
'6218'=>'209303',
'6221'=>'210111',
'6228'=>'205711',
'6232'=>'205726',
'6233'=>'209304',
'6234'=>'205708',
'6235'=>'209305',
'6246'=>'209306',
'6250'=>'209307',
'6301'=>'205720',
'6316'=>'205712',
'6323'=>'205724',
'6332'=>'205721',
'6335'=>'205725',
'6343'=>'205722',
'6394'=>'205714',
'6413'=>'205723',
'6440'=>'209308',
'6441'=>'209309',
'6442'=>'205715',
'6448'=>'199004',
'6451'=>'209310',
'6467'=>'205706',
'6470'=>'199814',
'6490'=>'210112',
'6495'=>'209311',
'6506'=>'205719',
'6512'=>'209312',
'6546'=>'209313',
'6548'=>'209314',
'6553'=>'209315',
'6558'=>'209316',
'6559'=>'209317',
'6561'=>'209318',
'6593'=>'209319',
'6595'=>'209320',
'6713'=>'209321',
'6715'=>'205750',
'6716'=>'205733',
'6725'=>'210123',
'6731'=>'208818',
'6733'=>'209323',
'6738'=>'209324',
'6739'=>'209325',
'6740'=>'209326',
'6742'=>'209327',
'6744'=>'209328',
'6745'=>'210105',
'6747'=>'209329',
'6748'=>'209330',
'6749'=>'209331',
'6751'=>'209332',
'6752'=>'209333',
'6753'=>'209334',
'6757'=>'209335',
'6758'=>'209336',
'6759'=>'209337',
'6760'=>'209023',
'6763'=>'209339',
'6764'=>'210113',
'6765'=>'209340',
'6766'=>'209341',
'6768'=>'209342',
'6769'=>'209343',
'6770'=>'209344',
'6771'=>'209345',
'6773'=>'209346',
'6774'=>'209347',
'6775'=>'209348',
'6776'=>'209349',
'6777'=>'209350',
'6778'=>'209351',
'6779'=>'210042',
'6780'=>'209353',
'6781'=>'209354',
'6783'=>'210106',
'6784'=>'210110',
'6785'=>'210109',
'6786'=>'210115',
'6787'=>'210121',
'6788'=>'210133',
'6789'=>'210134',
'61104'=>'200008',
'61106'=>'200044',
'61107'=>'200042',
'61110'=>'200046',
'61111'=>'200047',
'61113'=>'201007',
'61115'=>'201014',
'61117'=>'199026',
'61118'=>'200055',
'61120'=>'201026',
'61121'=>'201034',
'61124'=>'202010',
'61126'=>'202007',
'61129'=>'202017',
'61131'=>'202034',
'61132'=>'202033',
'61133'=>'202029',
'61135'=>'202046',
'61136'=>'202049',
'61137'=>'203009',
'61138'=>'203010',
'61139'=>'203008',
'61141'=>'203013',
'61142'=>'203036',
'61143'=>'203016',
'61144'=>'203014',
'61145'=>'203031',
'61146'=>'203034',
'61147'=>'203038',
'61148'=>'204005',
'61149'=>'204006',
'61151'=>'204027',
'61153'=>'204037',
'61154'=>'205002',
'61155'=>'204033',
'61156'=>'206002',
'61158'=>'206001',
'61160'=>'206020',
'61161'=>'207010',
'61163'=>'208003',
'61165'=>'207018',
'61166'=>'207022',
'61168'=>'208002',
'61169'=>'208014',
'61170'=>'208020',
'61171'=>'208013',
'61172'=>'209014',
'61175'=>'210003',

);

require("include/fungsi.php");
require("include/global.php");

f_connecting();
$fsql=fopen('/tmp/query_ubah_npk.sql','w');
$fkar=fopen('/tmp/query_ubah_npk_karyawan.sql','w');


//$query="SELECT kode_dosen,nip FROM master_karyawan WHERE (id_jenis=1) OR (id_jenis=2) OR (id_jenis=3) order by kode_dosen";
//$query="SELECT kode_dosen,NPK FROM dosen WHERE (NPK<>'---') AND (NPK<>'') AND (NOT NPK  IS NULL) order by kode_dosen";
//$rs=mysql_db_query("$DB", $query) OR die ("Gagal eksekusi SQL TABEL karena ".  mysql_error());
//while ($row=mysql_fetch_assoc($rs)) {
foreach ($kode2npk as $kodos=>$npk) {
    //$kodos=$row['kode_dosen'];
    //$npk=$row['NPK'];
    if ($npk && $kodos) {
        echo "Memproses npk=$npk kode=$kodos \n";
        $query="UPDATE dosen SET NPK='$npk' WHERE kode='$kodos'";
        fputs($fkar, $query.";\n", 4096);
        foreach ($tableNames as $tName=>$tFields) {
            foreach ($tFields as $fName) {
                $query="UPDATE $tName SET $fName='$npk' WHERE $fName='$kodos'";
                fputs($fsql, $query.";\n", 4096);
                echo $query."\n";

                //mysql_db_query("$DB", $query);
            }
        }
    }

}
fclose($fsql);
fclose($fkar);


?>
