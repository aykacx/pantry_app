<?php include_once "db.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>

    <style>
        .spacer-row {
            height: 20px;
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <nav>
        <div class="container">
            <a style="float:left" href="index.php">Pantry App</a>
            <a style="float:right" href="add_product.php">Products</a><br>
        </div>
    </nav>
    <div class="container">
        <form action="" method="POST">
            <select name="productId">
                <div class="col">
                    <?php
                    $query = $conn->query("SELECT * FROM inventory", PDO::FETCH_ASSOC);
                    if ($query->rowCount()) {
                        foreach ($query as $row) {
                            print "<option value='" . $row['id'] . "'>" . $row['product_name'] . "</option>";
                        }
                    }
                    ?>
                </div>
            </select>
            <div class="col">
                <input type="number" name="addedAmount" placeholder="Amount">
                <input type="submit" name="addProduct" value="Add">
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
                    print $productId . "\n" . "ID numbered product new amount is: " . $newAmount;
                }
            }
            ?>
        </form>
    </div>
    <center>
        <h2>Inventory</h2>
        <table style="background-color: lightgray; width:600px; text-align: center;">
            <tr>
                <td>Product Id</td>
                <td>Product Name</td>
                <td>Amount</td>
            </tr>
            <tr>
                <?php
                $sql = $conn->query("SELECT * FROM inventory", PDO::FETCH_ASSOC);
                if ($sql->rowCount()) {
                    foreach ($sql as $row) {
                        print "<tr class='spacer-row'><td>" . $row['id'] . "</td><td>" . $row['product_name'] . "</td><td>" . $row['amount'] . "</td></tr>";
                    }
                }
                ?>
            </tr>
        </table>
    </center>
</body>

</html>