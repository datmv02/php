<?php

require_once('./connect.php');
$id = isset($_GET['id'])?$_GET['id']:-1;
if ($id==-1) {
    # code...
    header("location:index.php");
}else{
    $dete = "DELETE FROM books where bookid = $id";
    exeQuery($dete,false);
    header("location:index.php");

}

?>