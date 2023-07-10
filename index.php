<?php include_once "db.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pantry App</title>

</head>

<body>
    <nav>
        <div class="container">
            <a href="index.php">Pantry App</a>
            <a href="add_product.php">Products</a>
        </div>
    </nav>
    <br><br>
    <h2>Orders</h2>
    <div class="container">
        <form action="" method="POST">
            <select name="food">
                <?php
                $query = $conn->query('SELECT * FROM foods', PDO::FETCH_ASSOC);
                if ($query->rowCount()) {
                    foreach ($query as $row) {
                        print "<option value='" . $row['id'] . "'>" . $row['food_name'] . "</option>";
                    }
                }
                ?>
            </select>
            <input type="submit" name="order" value="Order">
        </form>
    </div>
    <?php
    if (isset($_POST['order'])) {
        $orderId = $_POST['food'];
        $query = $conn->query("SELECT product_1, product_2, product_3, product_4 FROM foods WHERE {'$orderId'}")->fetch(PDO::FETCH_ASSOC);
        $product_1 = $query['product_1'];
        $product_2 = $query['product_2'];
        $product_3 = $query['product_3'];
        $product_4 = $query['product_4'];

        $query2 = $conn->query("SELECT amount FROM inventory WHERE product_name = '{$product_1}'")->fetch(PDO::FETCH_ASSOC);
        $product1amount = $query2['amount'];

        $query3 = $conn->query("SELECT amount FROM inventory WHERE product_name = '{$product_2}'")->fetch(PDO::FETCH_ASSOC);
        $product2amount = $query3['amount'];

        $query4 = $conn->query("SELECT amount FROM inventory WHERE product_name = '{$product_3}'")->fetch(PDO::FETCH_ASSOC);
        $product3amount = $query4['amount'];

        $query5 = $conn->query("SELECT amount FROM inventory WHERE product_name = '{$product_4}'")->fetch(PDO::FETCH_ASSOC);
        $product4amount = $query5['amount'];


        if ($product1amount == 0 || $product2amount == 0 || $product3amount == 0 || $product4amount == 0) {
            echo 'insufficient product';
            if ($product1amount == 0) {
                echo $product_1 . 'Finised';
            }
            if ($product2amount == 0) {
                echo $product_2 . 'Finised';
            }
            if ($product1amount == 0) {
                echo $product_3 . 'Finised';
            }
            if ($product1amount == 0) {
                echo $product_4 . 'Finised';
            }
        } else {
            $product1amount--;
            $product2amount--;
            $product3amount--;
            $product4amount--;

            $db_prepare = $conn->prepare("UPDATE inventory SET amount= :new_amount WHERE product_name= :p_name");
            $update = $db_prepare->execute(
                array(
                    "new_amount" => $product1amount,
                    "p_name" => $product_1
                )
            );

            $db_prepare1 = $conn->prepare("UPDATE inventory SET amount= :new_amount WHERE product_name= :p_name");
            $update = $db_prepare1->execute(
                array(
                    "new_amount" => $product2amount,
                    "p_name" => $product_2
                )
            );

            $db_prepare2 = $conn->prepare("UPDATE inventory SET amount= :new_amount WHERE product_name= :p_name");
            $update = $db_prepare2->execute(
                array(
                    "new_amount" => $product3amount,
                    "p_name" => $product_3
                )
            );

            $db_prepare3 = $conn->prepare("UPDATE inventory SET amount= :new_amount WHERE product_name= :p_name");
            $update = $db_prepare3->execute(
                array(
                    "new_amount" => $product4amount,
                    "p_name" => $product_4
                )
            );
        }
    }
    ?>

</body>

</html>