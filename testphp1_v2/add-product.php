<?php

require_once("./connect.php");

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
            $vali['priceError'] = "must to greater than 0";
            $is_flag = false;
        } else {
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
            $vali['quantityError'] = "must to greater than 0";
            $is_flag = false;
        } else {
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
    $allowtype = array('jpg', 'png', 'image');
    $imageFileType = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $is_image = true;
    if ($_FILES['image']['name'] == "") {
        $vali['image'] = "is-invalid";
        $is_flag = false;
    } else {
        if (!in_array($imageFileType, $allowtype)) {
            $vali['image'] = "is-invalid";
            $vali['imageType'] = "must to type jpg,png";
            $is_flag = false;
            $is_image = false;
        }
        if ($_FILES['image']['size'] > 30000) {
            $vali['image'] = "is-invalid";
            $vali['imageSize'] = "must to greater than 3MB";
            $is_flag = false;
            $is_image = false;
        }
        if ($is_image == true) {
            $vali['image'] = "is-valid";
            $image = $_FILES['image']['name'];
            $tmp = $_FILES['image']['tmp_name'];
            move_uploaded_file($tmp, "./uploads/$image");
        }
    }
    if ($is_flag == true) {
        $query = "INSERT INTo `cars`(`car_name`,`car_image`,`car_price`,`car_quantity`,`car_description`) Values('$name','$image',$price,$quantity,'$description')";
        exeQuery($query, false);
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
                    <input type="text" class="form-control <?= isset($vali['name']) ? $vali['name'] : "" ?>" name="name" value="<?= isset($name) ? $name : "" ?>">
                    <div class="invalid-feedback">
                        Car name require!!
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Car price </label>
                    <input type="text" class="form-control <?= isset($vali['price']) ? $vali['price'] : "" ?>" name="price" value="<?= isset($price) ? $price : "" ?>">
                    <div class="invalid-feedback">
                        <?= isset($vali['priceError']) ? $vali['priceError'] : "Car price require!!" ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">Car quantity </label>
                    <input type="text" class="form-control <?= isset($vali['quantity']) ? $vali['quantity'] : "" ?>" name="quantity" value="<?= isset($quantity) ? $quantity : "" ?>">
                    <div class="invalid-feedback">
                        <?= isset($vali['quantityError']) ? $vali['quantityError'] : "Car quantity require!!" ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Default file input example</label>
                    <input class="form-control" type="file" id="formFile" name="name">
                </div>
                <div class="form-group">
                    <label for="" class="">Car image</label>
                    <input type="file" class="form-control-file <?= isset($vali['image']) ? $vali['image'] : "" ?> " name="image">
                    <div class="invalid-feedback">

                        <?php
                        if (isset($vali['imageSize']) || isset($vali['imageType'])) {
                            echo isset($vali['imageSize']) ? $vali['imageSize'] : "";
                            echo "<br>";
                            echo isset($vali['imageType']) ? $vali['imageType'] : "";
                        } else {
                            echo "Car image require";
                        }
                        ?>
                    </div>
                    <div class="valid-feedback">
                        success
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Car description </label>
                    <textarea name="description" id="" rows="5" class="form-control <?= isset($vali['description']) ? $vali['description'] : "" ?>"><?= isset($description) ? $description : "" ?></textarea>
                    <div class="invalid-feedback">
                        Car description require!!
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-success">Add</button>
                <a href="./index.php" class="btn btn-warning">Cancel</a>
            </form>
        </div>
    </div>
</body>

</html>