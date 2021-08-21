<?php
require_once('./connect.php');

$query1 = "SELECT * FROM categories";
$result = exeQuery($query1, true);

if (isset($_POST['submit'])) {
    $is_flag = true;
    if ( empty($_POST['name'])) {
        $vali['name'] = "is-invalid";
        $is_flag = false;
    } else {
        $vali['name'] = "is-valid";
        $name = $_POST['name'];
    }
    if (empty($_POST['intro'])) {
        $vali['intro'] = "is-invalid";
        $is_flag = false;
    } else {
        $vali['intro'] = "is-valid";
        $intro = $_POST['intro'];
    }
    if (empty($_POST['description']) ) {
        $vali['description'] = "is-invalid";
        $is_flag = false;
    } else {
        $vali['description'] = "is-valid";
        $description = $_POST['description'];
    }
    if (empty($_POST['cate'])) {
        $vali['cate'] = "is-invalid";
        $is_flag = false;
    } else {
        $vali['cate'] = "is-valid";
        $cate = $_POST['cate'];
    }
    // function check1($ten, $is_flag, $get)
    // {
    //     $x = null;
    //     if (empty($_POST["$ten"])) {
    //         $validate = "is-invalid";
    //         $is_flag = false;
    //     } else {
    //         $validate = "is-valid";
    //         $x = $_POST["$ten"];
    //     }
    //     switch ($get) {
    //         case 'name':
    //             return $x;
    //             break;
    //         case 'vali':
    //             return $validate;
    //             break;
    //         case 'boolean':
    //             return $is_flag;
    //             break;
    //     }
    // }
    // $name = check1("name", true, 'name');
    // $vali['name'] = check1("name", true, 'vali');
    // $is_flag = check1("name", true, 'boolean');

    // $intro = check1("intro", true, 'name');
    // $vali['intro'] = check1("intro", true, 'vali');
    // $is_flag = check1("intro", true, 'boolean');

    // $cate = check1("cate", true, 'name');
    // $vali['cate'] = check1("cate", true, 'vali');
    // $is_flag = check1("cate", true, 'boolean');

    // $description = check1("description", true, 'name');
    // $vali['description'] = check1("description", true, 'vali');
    // $is_flag = check1("description", true, 'boolean');
    if (empty($_POST['price'])) {
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
    if (empty($_POST['date'])) {
        $vali['date'] = "is-invalid";
        $is_flag = false;
    } else {
        if ($_POST['date'] < 0) {
            $vali['date'] = "is-invalid";
            $vali['dateError'] = "must to greater than 0";
            $is_flag = false;
        } else {
            $vali['date'] = "is-valid";
            $date = $_POST['date'];
        }
    }

    if ($_FILES['image']['name'] == "") {
        $vali['image'] = "is-invalid";
        $is_flag = false;
    } else {
        $is_image = true;
        $allowType = array('jpg', 'png', 'image');
        $imageType = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        if ($_FILES['image']['size'] > 3145728) {
            $vali['image'] = "is-invalid";
            $vali['imageSize'] = "must to lesser than 3MB";
            $is_flag = false;
            $is_image = false;
        }
        if (!in_array(strtolower($imageType), $allowType)) {
            $vali['image'] = "is-invalid";
            $vali['imageType'] = "must to type jpg,png";
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
        $query = "INSERT INTO `tours`( `tour_name`, `image`, `intro`, `description`, `number_date`, `price`, `cate_id`) 
                    VALUES ('$name','$image','$intro','$description',$date,$price,$cate)";
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
        <h4 style="padding: 2rem 0; font-weight: bolder; text-align: center;">Add tour</h2>
            <div class="row" style="justify-content: center;">
                <form action="add.php" method="post" enctype="multipart/form-data" class="col-sm-5">
                    <div class="form-group">
                        <label for="">Tour name </label>
                        <input type="text" class="form-control <?= isset($vali['name']) ? $vali['name'] : "" ?>" name="name" value="<?= isset($name) ? $name : "" ?>">
                        <div class="invalid-feedback">
                            Tour name require!!
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Intro </label>
                        <input type="text" class="form-control <?= isset($vali['intro']) ? $vali['intro'] : "" ?>" name="intro" value="<?= isset($intro) ? $intro : "" ?>">
                        <div class="invalid-feedback">
                            Intro require!!
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Number Date </label>
                        <input type="number" class="form-control <?= isset($vali['date']) ? $vali['date'] : "" ?>" name="date" value="<?= isset($date) ? $date : "" ?>">
                        <div class="invalid-feedback">
                            <?= isset($vali['dateError']) ? $vali['dateError'] : "Number date require!!" ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Price </label>
                        <input type="number" class="form-control <?= isset($vali['price']) ? $vali['price'] : "" ?>" name="price" value="<?= isset($price) ? $price : "" ?>">
                        <div class="invalid-feedback">
                            <?= isset($vali['priceError']) ? $vali['priceError'] : "Price require!!" ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Cate name </label>
                        <select name="cate" class="form-control <?= isset($vali['cate']) ? $vali['cate'] : "" ?>" value="<?= isset($cate) ? $cate : "" ?>">
                            <?php foreach ($result as $u) : ?>
                                <option value="<?= $u['cate_id'] ?>"><?= $u['cate_name']  ?></option>
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
                        <label for="">Description </label>
                        <textarea type="text" rows="3" class="form-control <?= isset($vali['description']) ? $vali['description'] : "" ?>" name="description" value=""><?= isset($description) ? $description : "" ?></textarea>
                        <div class="invalid-feedback">
                            Description require!!
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-success">Add</button>
                    <a href="./index.php" class="btn btn-warning">Cancel</a>
                </form>
            </div>
    </div>
</body>
</html>