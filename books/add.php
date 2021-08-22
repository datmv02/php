<?php

require_once('./connect.php');

$getCate = "SELECT * FROM categories";
$cateAll = exeQuery($getCate, true);

if (isset($_POST['submit'])) {
    $is_flag = true;
    if (empty($_POST['title'])) {
        $vali['title'] = "is-invalid";
        $is_flag = false;
    } else {
        $vali['title'] = "is-valid";
        $title = $_POST['title'];
    }
    if (empty($_POST['detail'])) {
        $vali['detail'] = "is-invalid";
        $is_flag = false;
    } else {
        $vali['detail'] = "is-valid";
        $detail = $_POST['detail'];
    }
    if (empty($_POST['cate'])) {
        $vali['cate'] = "is-invalid";
        $is_flag = false;
    } else {
        $vali['cate'] = "is-valid";
        $cate = $_POST['cate'];
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
    if (empty($_FILES['image']['name'])) {
        $vali['image'] = "is-invalid";
        $is_flag = false;
    } else {
        $is_image = true;
        $allowType = ['png', 'jpg'];
        $imageType = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        if (!in_array(strtolower($imageType), $allowType)) {
            $vali['image'] = "is-invalid";
            $vali['imageType'] = "Image must to type : jpg,png";
            $is_flag = false;
            $is_image = false;
        }
        if ($_FILES['image']['size'] > 3000000) {
            $vali['image'] = "is-invalid";
            $vali['imageSize'] = "Image must to size < 3MB";
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
        $insert = "INSERT INTO books(`title`,`price`,`detail`,`image`,`cateid`) Values ('$title',$price,'$detail','$image',$cate)";
        exeQuery($insert,false);
        header("location:index.php");
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
            <form action="" method="post" enctype="multipart/form-data" class="col-sm-4">
                <div class="form-group">
                    <label for="">Title </label>
                    <input type="text" class="form-control <?= isset($vali['title']) ? $vali['title'] : "" ?>" name="title" value="<?= isset($title) ? $title : "" ?>">
                    <div class="invalid-feedback">
                        Title require!!
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Price </label>
                    <input type="number" class="form-control <?= isset($vali['price']) ? $vali['price'] : "" ?>" name="price" value="<?= isset($price) ? $price : "" ?>">
                    <div class="invalid-feedback">
                        <?= isset($vali['priceError']) ? $vali['priceError'] : "price require!!" ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Cate name </label>
                    <select name="cate" class="form-control <?= isset($vali['cate']) ? $vali['cate'] : "" ?>" value="<?= isset($cate) ? $cate : "" ?>">
                        <?php foreach ($cateAll as $u) : ?>
                            <option value="<?= $u['cateid'] ?>"><?= $u['catename']  ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback">
                        Cate name require!!
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Image </label>
                    <input type="file" class="form-control <?= isset($vali['image']) ? $vali['image'] : "" ?>" name="image" value="<?= isset($image) ? $image : "" ?>">
                    <div class="invalid-feedback">
                        <?php
                        if (isset($vali['imageType']) || isset($vali['imageSize'])) {
                            echo isset($vali['imageType']) ? $vali['imageType'] : "";
                            echo "<br>";
                            echo isset($vali['imageSize']) ? $vali['imageSize'] : "";
                        } else {
                            echo "Image require!!";
                        }

                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Detail </label>
                    <textarea type="text" rows="3" class="form-control <?= isset($vali['detail']) ? $vali['detail'] : "" ?>" name="detail" value=""><?= isset($detail) ? $detail : "" ?></textarea>
                    <div class="invalid-feedback">
                        detail require!!
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-success">Add</button>
                <a href="./index.php" class="btn btn-warning">Cancel</a>
            </form>
        </div>
    </div>
</body>

</html>