<?php
require_once('./connect.php');
$query = "SELECT * from cars";
$result = exeQuery($query,true);
$index=1;
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
            <table class="table" style="text-align: center;">
                <thead class="thead-dark text-white">
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Description</th>
                        <th>
                            <a href="add-product.php" class="btn btn-success">Add Product</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result as $u):?>
                        <tr>
                            <th><?=$index++?></th>
                            <td><?=$u['car_name']?></td>
                            <td><img src="./uploads/<?=$u['car_image']?>" alt="" width="60" height="80"></td>
                            <td><?=$u['car_price']?></td>
                            <td><?=$u['car_quantity']?></td>
                            <td><?=$u['car_description']?></td>
                            <td>
                                <a href="edit-product.php?id=<?=$u['car_id']?>" class="btn btn-warning">Edit</a>
                                <a onclick="return confirm('Are you sure delete')" href="remove.php?id=<?=$u['car_id']?>" class="btn btn-danger">Delete</a>

                            </td>
                        </tr>
                    <?php endforeach?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>