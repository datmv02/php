<?php

function exeQuery($query,$getAll = true){
    $conn = new PDO("mysql:host=127.0.0.1;dbname=ph17185_examphp5;charset=utf8","root","");
    $stmt = $conn -> prepare($query);
    $stmt -> execute();

    if ($getAll == true) {
        return $stmt -> fetchAll();
    }else{
        return $stmt -> fetch();

    }
}
?>