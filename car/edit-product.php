<?php

require_once("./connect.php");
$id = isset($_GET['id'])?$_GET['id']:-1;
if ($id==-1) {
   header("location:index.php");
}else{
    $queryGetId = "SELECT * FROM cars where car_id=$id";
    $result=exeQuery($queryGetId,false);
}

if (isset($_POST['submit'])) {
    $is_flag = true;
    if ($_POST['name'] == "") {
        $vali['name'] = "is-invalid";
        $is_flag = false;
    } else {
        $vali['name'] = "is-valid";
        $name = $_POST['name'];
    }
    if ($_POST['price'] == "") {
        $vali['price'] = "is-invalid";
        $is_flag = false;
    } else {
        if ($_POST['price'] < 0) {
            $vali['price'] = "is-invalid";
            $vali['priceError']="must to greater than 0";
            $is_flag = false;
        }else{
            $vali['price'] = "is-valid";
            $price = $_POST['price'];
        }
    }
    if ($_POST['quantity'] == "") {
        $vali['quantity'] = "is-invalid";
        $is_flag = false;
    } else {
        if ($_POST['quantity'] < 0) {
            $vali['quantity'] = "is-invalid";
            $vali['quantityError']="must to greater than 0";
            $is_flag = false;
        }else{
            $vali['quantity'] = "is-valid";
            $quantity = $_POST['quantity'];
        }
    }
    if ($_POST['description'] == "") {
        $vali['description'] = "is-invalid";
        $is_flag = false;
    } else {
        $vali['description'] = "is-valid";
        $description = $_POST['description'];
    }
    if ($_FILES['image']['name'] == "") {
        $vali['image'] = "is-valid";
        $image =$result['car_image'];
        
    } else {
        $vali['image'] = "is-valid";
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp,"./uploads/$image");
    }
    if ($is_flag==true) {
       $query = "UPDATE `cars` SET`car_name`='$name',`car_image`='$image',`car_price`=$price,`car_quantity`=$quantity,`car_description`='$description' where car_id=$id";
       exeQuery($query,false);
        header('location:index.php');
    }
}


?>
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <div class="container">
        <div class="row" style="justify-content: center;">
            <form action="" method="post" enctype="multipart/form-data" class="col-sm-5">
                <div class="form-group">
                    <label for="">Car name </label>
                    <input type="text" class="form-control <?= isset($vali['name']) ? $vali['name'] : "" ?>" name="name" value="<?= isset($result['car_name']) ? $result['car_name']: "" ?>">
                    <div class="invalid-feedback">
                        Car name require!!
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Car price </label>
                    <input type="text" class="form-control <?= isset($vali['price']) ? $vali['price'] : "" ?>" name="price" value="<?= isset($result['car_price']) ? $result['car_price'] : "" ?>">
                    <div class="invalid-feedback">
                        <?= isset($vali['priceError']) ? $vali['priceError'] : "Car price require!!" ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Car quantity </label>
                    <input type="text" class="form-control <?= isset($vali['quantity']) ? $vali['quantity'] : "" ?>" name="quantity" value="<?= isset($result['car_quantity']) ? $result['car_quantity'] : "" ?>">
                    <div class="invalid-feedback">
                        <?= isset($vali['quantityError']) ? $vali['quantityError'] : "Car quantity require!!" ?>
                    </div>
                </div>
                <div class="form-group">
                    <img src="./uploads/<?=isset($result['car_image'])?$result['car_image']:""?>" width="100" height="100" alt="">
                </div>
                <div class="form-group">
                    <label for="">Car image</label>
                    <input type="file" class="form-control-file <?= isset($vali['image']) ? $vali['image'] : "" ?>" name="image" >
                    <div class="invalid-feedback">
                        Car image require
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Car name </label>
                    <textarea name="description" id="" rows="5" class="form-control <?= isset($vali['description']) ? $vali['description'] : "" ?>"><?= isset($result['car_description']) ? $result['car_description'] : "" ?></textarea>
                    <div class="invalid-feedback">
                        Car description require!!
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-success">Edit</button>
                <a href="./index.php" class="btn btn-warning">Cancel</a>
            </form>
        </div>
    </div>
</body>

</html>