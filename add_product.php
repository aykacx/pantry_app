<?php include_once "db.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Verdana, Geneva, sans-serif;
            margin: 0;
            padding: 0;
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

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .form-container select,
        .form-container input {
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-container input[type="number"] {
            width: 80px;
        }

        .form-container input[type="submit"] {
            background-color: lightblue;
            color: black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }

        table tr:first-child {
            background-color: #f0f0f0;
        }

        table tr.spacer-row td {
            background-color: #f0f0f0;
            height: 20px;
            border-bottom: none;
        }
        .updateText{
            text-align: center;
        }
    </style>
</head>

<body>
    <nav class='navigation_bar'>
        <a href="index.php">Pantry App</a>
        <a href="add_product.php">Products</a>
    </nav>
    <div class="form-container">
        <form action="" method="POST">
            <?php
            $query = $conn->query("SELECT * FROM inventory", PDO::FETCH_ASSOC);
            if ($query->rowCount()) {
                echo '<select name="productId">';
                foreach ($query as $row) {
                    echo "<option value='" . $row['id'] . "'>" . $row['product_name'] . "</option>";
                }
                echo '</select>';
            }
            ?>
            <input type="number" name="addedAmount" placeholder="Amount">
            <input type="submit" name="addProduct" value="Add">
        </form>
    </div>

    <?php
    if (isset($_POST['addProduct'])) {
        $productId = $_POST['productId'];
        $addedAmount = $_POST['addedAmount'];
        $amount = 0;

        $sql = $conn->query("SELECT * FROM inventory WHERE id='$productId'", PDO::FETCH_ASSOC);
        if ($sql->rowCount()) {
            foreach ($sql as $row) {
                $amount = $row['amount'];
            }
        }

        $newAmount = $addedAmount + $amount;

        $sql = $conn->prepare("UPDATE inventory SET amount= :newAmount WHERE id=:id");
        $update = $sql->execute(array("newAmount" => $newAmount, "id" => $productId));
        if ($update) {
            echo "<nav class='updateText'>".$productId . " " . "ID numbered product new amount is: " . $newAmount."</nav>";
        }
    }
    ?>

    <h2>Inventory</h2>
    <table>
        <tr>
            <td>Product Id</td>
            <td>Product Name</td>
            <td>Amount</td>
        </tr>
        <?php
        $sql = $conn->query("SELECT * FROM inventory", PDO::FETCH_ASSOC);
        if ($sql->rowCount()) {
            foreach ($sql as $row) {
                echo "<tr><td>" . $row['id'] . "</td><td>" . $row['product_name'] . "</td><td>" . $row['amount'] . "</td></tr>";
                echo "<tr class='spacer-row'><td colspan='3'></td></tr>";
            }
        }
        ?>
    </table>
</body>

</html>