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




//echo "OK";
//print(DB_SERVER);
if (isset($_POST['register_button']))
{

    //echo('post');
    $database = "db_design_login";
    $db_found = new mysqli(DB_SERVER, DB_USER,DB_PASS,$database);
    if($db_found)
    {
        //echo "db found";
    }

    $u_name= $_POST['username'];
    //echo $u_name;

    //get the user input from the textbox
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



    //check if confirm password match to first
    if($u_password != $u_password){
        array_push($errors_messages,"The two passwords do not match");
    }

    //if ther errors list is empty, we can register
    if(count($errors_messages) == 0)
    {
        //check if this email is already taken
        $sql_email= "SELECT * FROM db_design_login.login WHERE email='$u_email'";
        $result_email=mysqli_query($db_found,$sql_email);
        if(mysqli_num_rows($result_email) == 1){
            $_SESSION['username'] = $u_name;
            $_SESSION['success'] = "this email is already taken";
            //echo "this email is already taken";
            array_push($errors_messages,"this email is already taken");

        }else
        {
            //we'll use the md5 function in order to encrypt the password before saving in the database
            $password_encrypt = md5($u_password);
            $sql_insert="INSERT INTO login (userName, email, usrPass) VALUES ('$u_name','$u_email','$password_encrypt')";
            mysqli_query($db_found,$sql_insert);

//            echo ($db_found->errno);
//            print($db_found->error);

//        echo "here";
//        echo"<br/>";


            $_SESSION['username'] = $u_name;
            $_SESSION['success'] = "You are now logged in";
            header('location: index1.php');
        }
    }
    else{

    }




}


?>

<html>
<head>
    <title>User Login System - PHP & MySQL</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">



</head>
<body>

<div class="header">
    <h2>Register</h2>
</div>

<form METHOD="post" ACTION="/idf/design_login/home.php">
    <?php include('errors.php'); ?>
    <div class="input1">
        <label>UserName</label>
        <input type="text" name="username" value="<?PHP print $u_name;?>">
    </div>

    <div class="input1">
        <label>Email</label>
        <input type="email" name="email" value="<?PHP print $u_email;?>">
    </div>

    <div class="input1">
        <label>Password</label>
        <input type="password" name="pssword" value="<?PHP print $u_password;?>">
    </div>

    <div class="input1">
        <label>Confirm password</label>
        <input type="password" name="pssword2" value="<?PHP print $u_confirm_pass;?>">
    </div>

    <div class="input1">
        <button type="submit" class="btn btn-danger " name="register_button">Register</button>


    </div>
    <p>
        Have an account? <a href="login.php">Sign in</a>
    </p>


</form>

</body>
</html>
