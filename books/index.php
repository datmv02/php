<?php

require_once('./connect.php');
$queryAll = "SELECT * FROM books inner join categories on categories.cateid = books.cateid";
$resultAll = exeQuery($queryAll,true);
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
        <div class="row">
            <table class="table table-hover" style="text-align: center;">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Detail</th>
                        <th>Price</th>
                        <th>Cate</th>
                        <th>
                            <a href="add.php" class="btn btn-success">Add</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($resultAll as $u ):?>
                        <tr>
                            <th><?=$index++?></th>
                            <td><?=$u['title']?></td>
                            <td><img src="./uploads/<?=$u['image']?>" width="100" alt=""></td>
                            <td><?=$u['detail']?></td>
                            <td><?=number_format($u['price'],0,'.',',')?> VND</td>
                            <td><?=$u['catename']?></td>
                            <td>
                                <a href="edit.php?id=<?=$u['bookid']?>" class="btn btn-warning">Edit</a>
                                <a onclick="return confirm('Are you sure delete??')" href="remove.php?id=<?=$u['bookid']?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>