<?php
$con ->auten();
$conn=$con->koneksi();
switch (@$_GET['page']){
    case 'add':
        $sql="SELECT * FROM kategori_pegawai ";
        $kategoripeg=$conn->query($sql);
        $content = "views/pegawai/tambah.php";
        include_once 'views/template.php';
    break;
    case 'save':
        if($_SERVER['REQUEST_METHOD']=="POST"){
            if(empty($_POST['id_pegawai'])){
                $err['id_pegawai']="ID Pegawai Wajib";
            }
            if(!is_numeric($_POST['no_ktp'])){
                $err['no_ktp']="NIK Wajib Angka";
            }
            if(empty($_POST['nama'])){
                $err['nama']="Nama Wajib Terisi";
            }
            if(empty($_POST['alamat'])){
                $err['alamat']="Pendidikan Wajib Terisi";
            }
            if(!is_numeric($_POST['no_telp'])){
                $err['no_telp']="No TELP Wajib Angka";
            }
            if(empty($_POST['id_kategori_pegawai'])){
                $err['id_kategori_pegawai']="ID Kategori Wajib Terisi";
            }
           if(!isset($err)){ 
                if(!empty($_POST['kode_pegawai'])){
                    //update
                    $sql="UPDATE pegawai set id_pegawai='$_POST[id_pegawai]',no_ktp='$_POST[no_ktp]', nama='$_POST[nama]',alamat='$_POST[alamat]',
                    no_telp='$_POST[no_telp]',id_kategori_pegawai='$_POST[id_kategori_pegawai]' where md5(kode_pegawai)='$_POST[kode_pegawai]'";  
                
                }else{ 
                //save
                    $sql = "INSERT INTO pegawai(id_pegawai,no_ktp,nama,alamat,no_telp,id_kategori_pegawai)
                    VALUES ('$_POST[id_pegawai]','$_POST[no_ktp]','$_POST[nama]','$_POST[alamat]','$_POST[no_telp]','$_POST[id_kategori_pegawai]')";
                }
                if($conn->query($sql)==TRUE){
                    header('Location:'.$con->site_url().'/admin/index.php?mod=pegawai');
                }else{
                    $err['msg']= "ERROR: " . $sql . "<br>" . $conn ->error;
                }
            }
        }else{
            $err['msg']="Tidak diijinkan";
        }
        if(isset($err)){
            $sql="SELECT * FROM kategori_pegawai ";
            $kategoripeg=$conn->query($sql);
            $content = "views/pegawai/tambah.php";
            include_once 'views/template.php';
        }
    break;
    case 'edit':
        $pegawai ="SELECT * FROM pegawai where md5(id_pegawai)='$_GET[id]'";
        $pegawai=$conn->query($pegawai);
        $_POST=$pegawai->fetch_assoc();
        $_POST['kode_pegawai']=md5($_POST['kode_pegawai']);
        //var_dump($dokter);
        $sql="SELECT * FROM kategori_pegawai ";
        $kategoripeg=$conn->query($sql);
        $content = "views/pegawai/tambah.php";
        include_once 'views/template.php';  
    break;
    case 'delete';
    $pegawai ="DELETE FROM pegawai WHERE md5(id_pegawai)='$_GET[id]'";
    $pegawai=$conn->query($pegawai);
    header('Location: '.$con->site_url().'/admin/index.php?mod=pegawai');
    break;
    default:
    $sql = "SELECT * FROM pegawai";
    $pegawai=$conn ->query($sql);
    $conn->close();
    $content="views/pegawai/tampil.php";
    include_once 'views/template.php';
}
?>