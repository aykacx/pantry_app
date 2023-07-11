<?php include_once "db.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Pantry App</title>

    <style>
        * {
            box-sizing: border-box;
        }

        .navigation_bar {
            background-color: #f0f0f0;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navigation_bar a {
            padding: 5px 10px;
            background-color: lightblue;
            color: black;
            text-decoration: none;
            border-radius: 4px;
        }

        body {
            font-family: Verdana, Geneva, sans-serif;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: #f0f0f0;
            padding: 10px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h2 {
            margin: 20px 0;
            text-align: center;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        select,
        input[type="submit"] {
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: lightblue;
            color: black;
        }

        .result {
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <nav class='navigation_bar'>
        <a href="index.php">Pantry App</a>
        <a href="add_product.php">Products</a>
    </nav>

    <h2>Orders</h2>

    <div class="form-container">
        <form action="" method="POST">
            <div>
                <select name="foodId">
                    <?php
                    $query = $conn->query('SELECT * FROM foods', PDO::FETCH_ASSOC);
                    if ($query->rowCount()) {
                        foreach ($query as $row) {
                            echo "<option value='" . $row['id'] . "'>" . $row['food_name'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <input type="submit" name="order" value="Order">
            </div>
        </form>
    </div>

    <?php
    if (isset($_POST['order'])) {
        $orderId = $_POST['foodId'];

        $query = $conn->query("SELECT product_1, product_2, product_3, product_4 FROM foods WHERE id= '$orderId'", PDO::FETCH_ASSOC);
        $products = $query->fetch();

        $product_1 = $products['product_1'];
        $product_2 = $products['product_2'];
        $product_3 = $products['product_3'];
        $product_4 = $products['product_4'];

        $product1amount = $conn->query("SELECT amount FROM inventory WHERE product_name = '{$product_1}'")->fetchColumn();
        $product2amount = $conn->query("SELECT amount FROM inventory WHERE product_name = '{$product_2}'")->fetchColumn();
        $product3amount = $conn->query("SELECT amount FROM inventory WHERE product_name = '{$product_3}'")->fetchColumn();
        $product4amount = $conn->query("SELECT amount FROM inventory WHERE product_name = '{$product_4}'")->fetchColumn();

        if ($product1amount == 0 || $product2amount == 0 || $product3amount == 0 || $product4amount == 0) {
            echo 'Insufficient products:<br>';
            if ($product1amount == 0) {
                echo $product_1 . ' - Finished<br>';
            }
            if ($product2amount == 0) {
                echo $product_2 . ' - Finished<br>';
            }
            if ($product3amount == 0) {
                echo $product_3 . ' - Finished<br>';
            }
            if ($product4amount == 0) {
                echo $product_4 . ' - Finished<br>';
            }
        } else {
            $product1amount--;
            $product2amount--;
            $product3amount--;
            $product4amount--;

            $conn->query("UPDATE inventory SET amount = $product1amount WHERE product_name = '{$product_1}'");
            $conn->query("UPDATE inventory SET amount = $product2amount WHERE product_name = '{$product_2}'");
            $conn->query("UPDATE inventory SET amount = $product3amount WHERE product_name = '{$product_3}'");
            $conn->query("UPDATE inventory SET amount = $product4amount WHERE product_name = '{$product_4}'");

            echo 'Order successfully placed!';
        }
    }
    ?>

</body>

</html>