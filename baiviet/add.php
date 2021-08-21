<?php

require_once('./connect.php');

$query = "SELECT * FROM danh_muc";

$result = exeQuery($query, true);
$is_flag = true;
if (isset($_POST['submit'])) {
    if ($_POST['name'] == "") {
        $is_flag = false;
        $vali['name'] = "is-invalid";
    } else {
        $vali['name'] = "is-valid";
        $name = $_POST['name'];
    }
    if ($_POST['detail'] == "") {
        $is_flag = false;
        $vali['detail'] = "is-invalid";
    } else {
        $vali['detail'] = "is-valid";
        $detail = $_POST['detail'];
    }
    if ($_POST['like'] == "") {
        $is_flag = false;
        $vali['like'] = "is-invalid";
    } else {
        if ($_POST['like'] < 0) {
            $is_flag = false;
            $vali['likeError'] = "like greater than 0";
            $vali['like'] = "is-invalid";
        } else {
            $vali['like'] = "is-valid";
            $like = $_POST['like'];
        }
    }
    if ($_POST['danhmuc'] == "-1") {
        $is_flag = false;
        $vali['danhmuc'] = "is-invalid";
    } else {
        if ($_POST['danhmuc'] < 0) {
            $is_flag = false;
            $vali['likeError'] = "danhmuc greater than 0";
            $vali['danhmuc'] = "is-invalid";
        }
        $vali['danhmuc'] = "is-valid";
        $danhmuc = $_POST['danhmuc'];
    }
    $allowType = ['image', 'jpeg', 'jpg', 'png'];
    $typeImage =pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

    if ($_FILES['image']['name'] == "") {
        $is_flag = false;
        $vali['image'] = "is-invalid";
    } else {
        $is_image=true;
        if (!in_array($typeImage, $allowType)) {
            $is_flag = false;
            $is_image = false;
            $vali['image'] = "is-invalid";
            $vali['imageType'] = "Type doesn't jpg";
        }
        if ($_FILES['image']['size']> 30000) {
            $is_image = false;
            $is_flag = false;
            $vali['image'] = "is-invalid";
            $vali['imageSize'] = " Size > 3MB";
        }
        if ($is_image==true){
            $vali['image'] = "is-valid";
            $image = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],"./uploads/$image");
        }
        
    }
    if ($is_flag== true){
        $query = "INSERT into bai_viet(`tieu_de`,`noi_dung`,`anh`,`so_luot_like`,`danhmuc_id`) values('$name','$detail','$image',$like,$danhmuc)";
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
        <div class="row" sryle="justify-content: center;">
            <form action="add.php" method="post" enctype="multipart/form-data" class="form col-sm-5">
                <div class="form-group">
                    <label for="">Tiêu đề</label>
                    <input type="text" class="form-control  <?= isset($vali['name']) ? $vali['name'] : "" ?>" name="name" value="<?= isset($name) ? $name : "" ?>">
                    <div class="invalid-feedback">
                        tieu de required
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Nội dung</label>
                    <input type="text" class="form-control  <?= isset($vali['detail']) ? $vali['detail'] : "" ?>" name="detail" value="<?= isset($detail) ? $detail : "" ?>">
                    <div class="invalid-feedback">
                        noi dung required
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Ảnh</label>
                    <input type="file" class="form-control  <?= isset($vali['image']) ? $vali['image'] : "" ?>" name="image" value="<?= isset($image) ? $image : "" ?>">
                    <div class="invalid-feedback">
                        <?php
                        if(isset($vali['imageType'])||isset($vali['imageType'])){
                            echo isset($vali['imageType'])?$vali['imageType']:"";
                            echo isset($vali['imageSize'])?$vali['imageSize']:"";
                        }else{
                            echo "Ảnh required";
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Lượt Like</label>
                    <input type="number" class="form-control  <?= isset($vali['like']) ? $vali['like'] : "" ?>" name="like" value="<?= isset($like) ? $like : "" ?>">
                    <div class="invalid-feedback">
                        <?= isset($vali['likeError']) ? $vali['likeError'] : "Like required" ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Danh mục</label>
                    <select name="danhmuc" class="form-control  <?= isset($vali['danhmuc']) ? $vali['danhmuc'] : "" ?>">
                        <option value="-1">Chọn</option>
                        <?php foreach ($result as  $u) : ?>
                            <option value="<?= $u['danhmuc_id'] ?>"><?= $u['name'] ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback">
                        Danh muc required
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-success">Thêm</button>
                <a href="./index.php" class="btn btn-warning">Quay lại</a>

            </form>
        </div>
    </div>
</body>

</html>