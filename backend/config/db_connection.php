<?php
    $host_name = 'localhost';
    $uer_name ='root';
    $password = '';
    $database_name='portfolio';

    $db_connection = mysqli_connect($host_name, $uer_name, $password, $database_name);

    if(!$db_connection){
        echo "db not connect.";
    }
?>

