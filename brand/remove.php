<?php
require_once('./connect.php');
$id = isset($_GET['id'])?$_GET['id']:-1;
if ($id==-1) {
    header('location:index.php');
}else{
    $query = "DELETE From products where product_id=$id";
    exeQuery($query,false);
    header('location:index.php');

}

?>