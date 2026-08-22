<?php
session_start();
require_once("../header.php");

require_once("dbconnection.php");
require_once("dbcart.php");


if (!isset($_SESSION["id"])) {
    header("location:login.php");
    exit;
}

function cleaninput($data)
{
    $data = trim($data);
    $data = strip_tags($data);
    $data = stripslashes($data);
    return $data;
}

$error = [];



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateQtyBtn'])) {

    $cartId = $_POST["cart_id"] ?? null;
    $qtyInput = cleaninput($_POST["quantity"] ?? "");

    if ($cartId !== null && is_numeric($qtyInput) && intval($qtyInput) > 0) {
        update_cart_quantity($cartId, $_SESSION["id"], intval($qtyInput));
        $_SESSION["flash_success"] = "Cart updated.";
        header("Location: carts.php");
        exit;
    } else {
        $error[] = "please enter a valid quantity";
    }
}



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['removeItemBtn'])) {

    $cartId = $_POST["cart_id"] ?? null;

    if ($cartId !== null) {
        remove_cart_item($cartId, $_SESSION["id"]);
    }

    $_SESSION["flash_success"] = "Item removed from cart.";
    header("Location: carts.php");
    exit;
}

$flashSuccess = $_SESSION["flash_success"] ?? null;
unset($_SESSION["flash_success"]);

$result = get_cart_items($_SESSION["id"]);
$cartItems = $result["status"] ? $result["data"] : [];

$cartTotal = 0;
foreach ($cartItems as $item) {
    $cartTotal += $item["price"] * $item["quantity"];
}
?>
<link rel="stylesheet" href="styles/cartstyle.css">

<div class="ct-page">

    <div class="ct-header">
        <h1>Your Cart</h1>
        <p class="ct-subtitle">Review your items before checking out</p>
    </div>

    <?php if ($flashSuccess) { ?>
        <div class="ct-alert ct-alert-success"><?php echo htmlspecialchars($flashSuccess); ?></div>
    <?php } ?>

    <?php if (!empty($error)) { ?>
        <div class="ct-alert ct-alert-error">
            <ul>
                <?php foreach ($error as $val) { ?>
                    <li><?php echo htmlspecialchars($val); ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <?php if (empty($cartItems)) { ?>

        <div class="ct-empty">
            Your cart is empty. <a href="supplements.php">Browse supplements</a> to add something.
        </div>

    <?php } else { ?>

        <div class="ct-list">
            <?php foreach ($cartItems as $item) { ?>

                <div class="ct-row">

                    <div class="ct-thumb">
                        <?php if (!empty($item['image_path'])) { ?>
                            <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <?php } ?>
                    </div>

                    <div class="ct-info">
                        <p class="ct-name"><?php echo htmlspecialchars($item['name']); ?></p>
                        <p class="ct-unit-price"><?php echo number_format($item['price'], 2); ?> EGP each</p>
                    </div>

                    <form method="POST" action="carts.php" class="ct-qty-form">
                        <input type="hidden" name="cart_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                        <input type="number" name="quantity" min="1" value="<?php echo htmlspecialchars($item['quantity']); ?>" required>
                        <button type="submit" name="updateQtyBtn" class="ct-update-btn">Update</button>
                    </form>

                    <div class="ct-subtotal">
                        <?php echo number_format($item['price'] * $item['quantity'], 2); ?> EGP
                    </div>

                    <form method="POST" action="carts.php" onsubmit="return confirm('Remove this item from your cart?');">
                        <input type="hidden" name="cart_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                        <button type="submit" name="removeItemBtn" class="ct-remove-btn">Remove</button>
                    </form>

                </div>

            <?php } ?>
        </div>

        <div class="ct-summary">
            <div>
                <span class="ct-total-label">Total</span>
                <span class="ct-total-value"><?php echo number_format($cartTotal, 2); ?> EGP</span>
            </div>
            <a href="payment.php" class="ct-confirm-btn">Confirm your order</a>
        </div>

    <?php } ?>

</div>
<?php include "../footer.php"; ?>