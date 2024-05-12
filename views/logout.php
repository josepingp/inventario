<?php 
    session_destroy();

    if (headers_sent()) {
        echo "<script> window.location.href='index.php?view=login' </script>";
    } else {
        header('location: index.php?view=login');
    }