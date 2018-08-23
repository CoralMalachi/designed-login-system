<?php
    session_start();
    if (!isset($_SESSION['username']))
    {
        echo 'hi';
        $_SESSION['note']="You must login";
        header('location: login.php');
    }

    if (isset($_GET['logout']))
    {
        echo 'here';
        session_destroy();
        unset($_SESSION['username']);
        header("location: login.php");
    }


?>

<html>
<head>
    <title>Home page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header">
    <h2>Home Page</h2>
</div>
<div class="content">
    <?php if(isset($_SESSION['success'])) { ?>
    <div class="error success">
        <h3>
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            }
            ?>

        </h3>
    </div>
    <?php if(isset($_SESSION['username'])){ ?>
    <p>Welcome <strong><?php print $_SESSION['username'];?></strong></p>
    <p><a href="index1.php?logout='1'" style="color: red;">logout</a> </p>
    <?php } ?>

</div>
</body>
</html>
