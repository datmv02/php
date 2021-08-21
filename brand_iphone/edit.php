<?php
require_once('./connect.php');
$query1 = "SELECT * From brands";
$result1 = exeQuery($query1, true);

$id = isset($_GET['id']) ? $_GET['id'] : -1;

if ($id == -1) {
    header('location:index.php');
} else {
    $query = "SELECT * From products inner join brands on products.brand_id=brands.brand_id where product_id=$id";
    $resultGetId = exeQuery($query, false);
}

$is_flag = true;
if (isset($_POST['submit'])) {
    if (empty($_POST['name'])) {
        $vali['name'] = "is-invalid";
        $is_flag = false;
    } else {
        $vali['name'] = "is-valid";
        $name = $_POST['name'];
    }
    if (empty($_POST['brand'])) {
        $vali['brand'] = "is-invalid";
        $is_flag = false;
    } else {
        $vali['brand'] = "is-valid";
        $brand = $_POST['brand'];
    }
    if (empty($_POST['description'])) {
        $vali['description'] = "is-invalid";
        $is_flag = false;
    } else {
        $vali['description'] = "is-valid";
        $description = $_POST['description'];
    }
    if (empty($_POST['price'])) {
        $vali['price'] = "is-invalid";
        $is_flag = false;
    } else {
        if ($_POST['price'] < 0) {
            $vali['price'] = "is-invalid";
            $vali['priceError'] = "Price must to greater than 0";
            $is_flag = false;
        } else {
            $vali['price'] = "is-valid";
            $price = $_POST['price'];
        }
    }
    if (empty($_POST['quantity'])) {
        $vali['quantity'] = "is-invalid";
        $is_flag = false;
    } else {
        if ($_POST['quantity'] < 0) {
            $vali['quantity'] = "is-invalid";
            $vali['quantityError'] = "quantity must to greater than 0";
            $is_flag = false;
        } else {
            $vali['quantity'] = "is-valid";
            $quantity = $_POST['quantity'];
        }
    }
    if (empty($_FILES['image']['name'])) {
        $vali['image'] = "is-valid";
        $image = $resultGetId['image'];
    } else {
        $is_image = true;
        $allowType = ['jpg', 'png'];
        $imageType = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        if ($_FILES['image']['size'] > 3000000) {
            $vali['image'] = "is-invalid";
            $vali['sizeError'] = "Size must to lesser than 3MB";
            $is_flag = false;
            $is_image = false;
        }
        if (!in_array(strtolower($imageType), $allowType)) {
            $vali['image'] = "is-invalid";
            $vali['typeError'] = "Image must to type :jpg, png";
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
        $queryUpdate = "UPDATE products SET `product_name`='$name',`price`=$price,`quantity`=$quantity,`image`='$image',`description`='$description',`brand_id`=$brand where product_id = $id";
        exeQuery($queryUpdate,false);
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
            <form action="" method="post" class="col-sm-4" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Product name</label>
                    <input type="text" class="form-control <?= isset($vali['name']) ? $vali['name'] : "" ?>" name="name" value="<?= isset($resultGetId['product_name']) ? $resultGetId['product_name'] : '' ?>">
                    <div class="invalid-feedback">
                        product name require
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Product price</label>
                    <input type="number" class="form-control <?= isset($vali['price']) ? $vali['price'] : "" ?>" name="price" value="<?= isset($resultGetId['price']) ? $resultGetId['price'] : '' ?>">
                    <div class="invalid-feedback">
                        <?= isset($vali['priceError']) ? $vali['priceError'] : "product price require" ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Product quantity</label>
                    <input type="number" class="form-control <?= isset($vali['quantity']) ? $vali['quantity'] : "" ?>" name="quantity" value="<?= isset($resultGetId['quantity']) ? $resultGetId['quantity'] : '' ?>">
                    <div class="invalid-feedback">
                        <?= isset($vali['quantityError']) ? $vali['quantityError'] : "product quantity require" ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Product image</label>
                    <input type="file" class="form-control <?= isset($vali['image']) ? $vali['image'] : "" ?>" name="image">
                    <div class="invalid-feedback">
                        <?php
                            if (isset($vali['sizeError'])||isset($vali['typeError'])) {
                                echo isset($vali['sizeError'])?$vali['sizeError']:"";
                                echo "<br>";
                                echo isset($vali['typeError'])?$vali['typeError']:"";
                            }else{
                                echo "Image require";
                            }
                        
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Brand</label>
                    <select name="brand" class="form-control <?= isset($vali['brand']) ? $vali['brand'] : "" ?>" id="">
                        <option value="<?= $resultGetId['brand_id'] ?>"><?= $resultGetId['brand_name'] ?></option>
                        <?php foreach ($result1 as $u) : ?>
                            <option value="<?= $u['brand_id'] ?>"><?= $u['brand_name'] ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback">
                        product brand require
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Description</label>
                    <textarea name="description" class="form-control <?= isset($vali['description']) ? $vali['description'] : "" ?>" id="" rows="4"><?= isset($resultGetId['description']) ? $resultGetId['description'] : '' ?></textarea>
                    <div class="invalid-feedback">
                        Description require
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-success">Add</button>
                <a href="./index.php" class="btn btn-warning">Cancel</a>
            </form>
        </div>
    </div>
</body>

</html>