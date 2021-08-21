<?php
require_once("./connect.php");
$id = isset($_GET['id']) ? $_GET['id'] : -1;


if ($id == -1) {
    header("location:index.php");
} else {

        $queryGetId = "DELETE from tours where tour_id=$id";
        $result = exeQuery($queryGetId, false);
        header("location:index.php");
      
   
}