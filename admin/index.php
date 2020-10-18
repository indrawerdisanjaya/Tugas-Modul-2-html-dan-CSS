<?php
include_once '../config/config.php';
$con=new Config();
if($con ->auten()){
    //panggil fungsi
    switch(@$_GET['mod']){
        case 'pegawai':
            include_once 'controller/pegawai.php';
        break;
        default:
        include_once 'controller/pegawai.php';
        //include_once 'controller/login.php';
    }
}else{
   include_once 'controller/login.php';

}
?>