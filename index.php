<!DOCTYPE HTML>  
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" type="text/css" href="style.css">
<title>Login</title>
</head>
<body>
<form  name ="loginform"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

<!-- تقوم دالة  htmlspecialchars () بتحويل الأحرف الخاصة إلى كيانات HTML. هذا يعني أنه سيستبدل أحرف HTML مثل <and> بـ &lt؛ و &gt. هذا يمنع المهاجمين من استغلال التعليمات البرمجية عن طريق حقن كود HTML 
 يُرجع اسم الملف الجاري تنفيذه حاليًا.$_SERVER["PHP_SELF"]-->
<?php 
session_start();
require_once './vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();
// نستطيع الان قراءة المتغيرات من الملف
     
     
$db_host = getenv('DB_host'); //استدعاء البيانات من الملف المحتوي على البيانات الحساسه
$db_username = getenv('DB_username');
$db_password = getenv('DB_password');
$Database = getenv('DB');
$passErr="";$nameErr="";$dataerr="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {//يحدد ما إذا كان الطلب عبارة عن طلب POST أو GET. يمكن أن يساعد هذا في تحديد ما إذا كان سيتم تحليل المعاملات الواردة من $ _GET أو $ _POST.
    if (!empty($_POST["usernameadmin"])) {//التحقق ان اسم المستخدم وكلمة المرور ليست فارغه
        if (!empty($_POST["passwordadmin"])) {
            $connection = mysqli_connect($db_host, $db_username, $db_password, $Database); // الاتصال بقاعدة البيانات 
            $Username = mysqli_real_escape_string($connection, $_POST["usernameadmin"]);//تأمين المدخلات قبل ادخالها قاعدة البيانات
            $Password = mysqli_real_escape_string($connection, $_POST["passwordadmin"]);
            //الاستعلام عن اسم المستخدم وكلمة المرور
            $query = mysqli_query($connection, "select * from Admin where Username='$Username'")
            or die("failed to query database " . mysqli_error($connection));
            $result = mysqli_fetch_array($query);
            $db_adminpassword = $result['Password'];// جلب كلمة المرور من قاعدة البيانات
            //التحقق من ان اسم المستخدم وكلمة المرور موجوده بقاعدة البيانات وان كلمة المرور المدخله تماثل كلمة المرور بقاعدة البيانات
            if ($result > 0 && password_verify($Password, $db_adminpassword)) {
                $_SESSION['userid']= $Username;
                header("location: data.php");//اذا كان الشرط صحيح ينتقل للصفحه 
            } else {
                $dataerr="Incorrect username or password "; //اذا كانت كلمة الرور واسم المستخدم خاطئه يظهر بالصفحه 
            }
                
        } 
        else{
            $passErr = "Password is required";
        }
    }
    else {
        $passErr = "Password is required";//اذا كانت كلمة المرور واسم المستخدم فارغه يظهر بالصفحه
        $nameErr = "username is required";
    }
}

?>
        <div id="basicdiv">
            <img id="psauimage" src="images/Prince_Sattam_Bin_Abdulaziz_University.png">
            <img id="fepimage" src="images/FEP.png">
            <hr>
            <div id="inputdiv">
                <table>
                    <tr>
                        <td class="usernameinput">Username</td>
                        <td><input type="text" name="usernameadmin"><br>
                        <span class="error"> <?php echo $nameErr;?></span>
                        </td>
                    </tr><br>
                    <tr>
                    <td class="usernameinput">Password</td>
                    <td><input type="password" name="passwordadmin"><br>
                    <span class="error"> <?php echo $passErr;?></span></td>
                    </tr><br>
                </table><br>
            <input id="loginsubmit" type="submit" value="Login"> <br>
            <span class="error"> <?php echo  $dataerr;?></span><br><br>
            <a href="enter_email.php">Forget password?</a> 
        </div>
    </div>
</form>
</body>
</html>