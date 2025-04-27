<?php

    function conectar(){
        $host = "localhost";
        $user = "root";  
        $pass = "";
        $bd = "bd_sena_stock";
        $con = mysqli_connect($host,$user,$pass,$bd);
        mysqli_select_db($con,$bd);
        return $con;
    }

?>