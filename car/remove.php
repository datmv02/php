<?php
require_once("./connect.php");
$id = isset($_GET['id']) ? $_GET['id'] : -1;


if ($id == -1) {
    header("location:index.php");
} else {
    if (isset($_POST['cancel'])) {
        header("location:index.php");
    }
    if (isset($_POST['ok'])) {

        $queryGetId = "DELETE from cars where car_id=$id";
        $result = exeQuery($queryGetId, false);
        header("location:index.php");
      
    }
}


?>
