<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rounak's Academy</title>
    <?php include('./client/commonFiles.php') ?>
</head>

<body>
    <?php
    session_start();
    include('./client/header.php');
    if (isset($_GET['register']) && !isset($_SESSION['username']) && !isset($_SESSION['isUserAdmin'])) {
        include('./client/register.php');
    } else if (isset($_GET['login']) && !isset($_SESSION['username']) && !isset($_SESSION['isUserAdmin'])) {
        include('./client/login.php');
    } else if (isset($_GET['adminlogin']) && isset($_SESSION['username']) && !isset($_SESSION['isUserAdmin'])) {
        include('./client/adminLogin.php');
    } else if (isset($_GET['create']) && isset($_SESSION['isUserAdmin'])) {
        include('./client/createCourse.php');
    } else {
        
        include('./client/home.php');
    }
    ?>
</body>

</html>