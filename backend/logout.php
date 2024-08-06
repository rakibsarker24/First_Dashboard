<?php
    session_start();

    unset($_SESSION['user']);
    header("location: ../frontend/user_login/user_login.php");
?>