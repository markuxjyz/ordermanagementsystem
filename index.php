<?php  
$menu = [
    ['name' => 'Hamburger', 'price' => 40, 'quantity' => 10],
    ['name' => 'Footlong', 'price' => 70, 'quantity' => 10],
    ['name' => 'Cheeseburger', 'price' => 50, 'quantity' => 10],
];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Management System</title>
</head>
<body>
    <h1>Welcome to Bangel Burger Stand!</h1>
    <h3>Here are the prices:</h3>
    <ul>
        <?php foreach ($menu as $item) : ?>
            <li><?= htmlspecialchars($item['name']); ?> - <?= htmlspecialchars($item['price']); ?> PHP</li>
        <?php endforeach; ?>
    </ul>
    <form method="POST" action="">
        <p>
            <label for="order">Choose your order: </label>
            <select name="order" id="order">
                <option value="">Select an option</option>
                <?php foreach ($menu as $item) : ?>
                    <option value="<?= htmlspecialchars($item['name']); ?>"><?= htmlspecialchars($item['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            Quantity:
            <input type="text" name="quantity">
        </p>
        <p>
            Cash:
            <input type="text" name="cash">
        </p>
        <p>
            <input type="submit" value="Submit" name="Submit">
        </p>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $order = isset($_POST['order']) && $_POST['order'] != "" ? $_POST['order'] : null;
        $quantity = isset($_POST['quantity']) && trim($_POST['quantity']) !== "" ? floatval($_POST['quantity']) : 0;
        $cash = isset($_POST['cash']) && trim($_POST['cash']) !== "" ? floatval($_POST['cash']) : 0;

        if (!$order) {
            echo "<p>Please choose from the available choices!</p>";
        } else {
            if ($quantity <= 0) {
                echo "<p>Please enter a valid quantity.</p>";
            } elseif ($cash <= 0) {
                echo "<p>Please enter the amount of cash you're paying with.</p>";
            } else {
                foreach ($menu as $item) {
                    if ($item['name'] === $order) {
                        $totalCost = $item['price'] * $quantity;
                        if ($cash < $totalCost) {
                            echo "<p>I'm sorry, but you have insufficient payment. You need exactly <b>" . ($totalCost - $cash) . " PHP</b> more.</p>";
                        } elseif ($cash == $totalCost) {
                            echo "<p>Thank you! Your payment is exact. Enjoy your $order!</p>";
                        } else {
                            echo "<p>Here is your change: <b>" . ($cash - $totalCost) . " PHP</b>. Enjoy your $order and order again!</p>";
                        }
                        break;
                    }
                }
            }
        }
    }
    ?>
</body>
</html>
