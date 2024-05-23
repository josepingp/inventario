<?php require "./inc/session_start.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "./inc/head.php"; ?>
</head>

<body>
    <?php

    if (!isset($_GET['view']) || $_GET['view'] == '') {
        $_GET['view'] = 'login';
    }

    if (
        is_file("./views/" . $_GET['view'] . ".php")
        && $_GET['view'] != 'login' && $_GET['view'] != '404'
    ) {

        //Cerrar sision forzada si no hay login
        if ( (!isset($_SESSION['id']) || $_SESSION['id'] == '') || (!isset($_SESSION['user_user']) || $_SESSION['user_user']== '')) {
            require'./views/logout.php';
            exit();
        }


        include "./inc/navbar.php";
        
        include "./views/" . $_GET['view'] . ".php";

        include "./inc/script.php";

    } else {

        if ( $_GET['view'] == 'login') {
            include "./views/login.php";
        } else {
            include "./views/404.php";
        }

    }




    ?>
</body>

</html>