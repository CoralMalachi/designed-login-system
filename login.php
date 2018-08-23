<?php
session_start();

global $mysqli;
$_SESSION['success']='';
$u_name = "";
$u_email = '';
$u_password = "";
$u_confirm_pass = "";
$errors_messages = array();
include('server_conf.php');

if (isset($_POST['login_button']))
{

    $database = "db_design_login";
    $db_found = new mysqli(DB_SERVER, DB_USER,DB_PASS,$database);
    $u_name = mysqli_real_escape_string($db_found,$_POST['username']);
    $u_email = mysqli_real_escape_string($db_found,$_POST['email']);
    $u_password = mysqli_real_escape_string($db_found,$_POST['pssword']);

    //check if all fields not empty
    if(empty($u_name)){
        array_push($errors_messages,"UserName is required");
    }

    if(empty($u_email)){
        array_push($errors_messages,"Email is required");
    }

    if(empty($u_password)){
        array_push($errors_messages,"Password is required");
    }
    //echo (count($errors_messages));

    if(count($errors_messages) == 0){
//        echo "ma";
        //we'll use the md5 function in order to encrypt the password before saving in the database
        $password_encrypt = md5($u_password);
//        echo $u_name;
//        echo "<br/>";
//        echo $u_email;
//        echo "<br/>";
//        echo $u_password;
//        echo "<br/>";
        $sql_find_user = "SELECT * FROM db_design_login.login WHERE userName='$u_name' AND usrPass='$password_encrypt' AND  email='$u_email'";
        $result = mysqli_query($db_found,$sql_find_user);
        if ($result)
        {
            echo 'here';
            echo "<br/>";
        }
//                    //echo ($db_found->errno);
//        echo "<br/>";
//            //print($db_found->error);
//        echo "<br/>";
            $num = mysqli_num_rows($result);
//        echo "<br/>";
           // echo $num;
        if(mysqli_num_rows($result) == 1)
        {
            $_SESSION['username']=$u_name;
            $_SESSION['success']="you are now login";
            //echo 'good';
           // echo "<br/>";
            header('location: /idf/design_login/index1.php');
        }else{
//            echo "<br/>";
//            echo 'bad';
            array_push($errors_messages,"wrong username/password/email combination");
        }

    }




}

?>

<html>
<head>
    <title>User Login System - PHP & MySQL</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">


</head>
<body>
<div class="header">
    <h2>Login</h2>
</div>

<form method="post" action="login.php">
    <?php include('errors.php'); ?>
    <div class="input1">
        <label>UserName</label>
        <input type="text" name="username">
    </div>

    <div class="input1">
        <label>Email</label>
        <input type="email" name="email">
    </div>

    <div class="input1">
        <label>Password</label>
        <input type="password" name="pssword">
    </div>



    <div class="input1">
        <button type="submit" class="btn btn-danger " name="login_button">Login</button>


    </div>
    <p>
        Not have an account yet? <a href="home.php">Sign up</a>
    </p>


</form>
</body>
</html>
