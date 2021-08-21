<?php
function exeQuery($query,$getAll=true){
    $dsn="mysql:host=127.0.0.1;dbname=dattestv2;charset=utf8";
    $dbuser="root";
    $dbpass="";

    $conn = new PDO($dsn,$dbuser,$dbpass);
    $stmt = $conn->prepare($query);
    $stmt ->execute();

    if ($getAll==true) {
        return $stmt->fetchAll();
    }else{
        return $stmt->fetch();

    }



}

?>