<?php
require_once './vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();
// نستطيع الان قراءة المتغيرات من الملف
$db_host = getenv('DB_host'); //استدعاء البيانات من الملف المحتوي على البيانات الحساسه
$db_username = getenv('DB_username');
$db_password = getenv('DB_password');
$Database = getenv('DB');
$connection = mysqli_connect($db_host, $db_username, $db_password, $Database);
$subject=$_POST['subject'];
$time=$_POST['time'];
     $E_update="UPDATE Examdata
            SET `exam_times`='$time' 
            WHERE Subject_ID='$subject' ";
     $EE_update=mysqli_query($connection,$E_update);
?>
