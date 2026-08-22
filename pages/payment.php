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

$result = get_cart_items($_SESSION["id"]);
$cartItems = $result["status"] ? $result["data"] : [];

$cartTotal = 0;
foreach ($cartItems as $item) {
    $cartTotal += $item["price"] * $item["quantity"];
}




if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmPaymentBtn'])) {

    $cardName = cleaninput($_POST["card_name"] ?? "");
    $cardNumber = str_replace(" ", "", cleaninput($_POST["card_number"] ?? ""));
    $expiry = cleaninput($_POST["expiry"] ?? "");
    $cvv = cleaninput($_POST["cvv"] ?? "");

    if (empty($cartItems)) {
        $error[] = "your cart is empty";
    }

    if (empty($cardName)) {
        $error[] = "cardholder name is required";
    }

    if (!preg_match('/^\d{16}$/', $cardNumber)) {
        $error[] = "please enter a valid 16-digit card number";
    }

    if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $expiry)) {
        $error[] = "expiry date must be in MM/YY format";
    }

    if (!preg_match('/^\d{3,4}$/', $cvv)) {
        $error[] = "please enter a valid CVV";
    }

    if (empty($error)) {
        clear_cart($_SESSION["id"]);
        $_SESSION["flash_success"] = "Payment successful! Your order has been placed.";
        header("Location: supplements.php");
        exit;
    }
}
?>
<link rel="stylesheet" href="styles/paymentstyle.css">

<div class="pm-page">

    <div class="pm-header">
        <h1>Payment</h1>
        <p class="pm-subtitle">Complete your order</p>
    </div>

    <?php if (!empty($error)) { ?>
        <div class="pm-alert pm-alert-error">
            <ul>
                <?php foreach ($error as $val) { ?>
                    <li><?php echo htmlspecialchars($val); ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <?php if (empty($cartItems)) { ?>

        <div class="pm-empty">
            Your cart is empty. <a href="supplements.php">Browse supplements</a> to add something before checking out.
        </div>

    <?php } else { ?>

        <div class="pm-summary">
            <h3 class="pm-summary-title">Order Summary</h3>

            <?php foreach ($cartItems as $item) { ?>
                <div class="pm-summary-row">
                    <span class="pm-summary-item-name"><?php echo htmlspecialchars($item['name']); ?> x <?php echo htmlspecialchars($item['quantity']); ?></span>
                    <span><?php echo number_format($item['price'] * $item['quantity'], 2); ?> EGP</span>
                </div>
            <?php } ?>

            <div class="pm-summary-total">
                <span class="pm-summary-total-label">Total</span>
                <span class="pm-summary-total-value"><?php echo number_format($cartTotal, 2); ?> EGP</span>
            </div>
        </div>

        <form method="POST" action="payment.php" class="pm-form">

            <h3 class="pm-form-title">Card Details</h3>

            <div class="pm-form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="card_name">Cardholder Name</label>
                    <input type="text" id="card_name" name="card_name" placeholder="Name on card" required>
                </div>
            </div>

            <div class="pm-form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="card_number">Card Number</label>
                    <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19" required>
                </div>
            </div>

            <div class="pm-form-row">
                <div class="form-group">
                    <label for="expiry">Expiry (MM/YY)</label>
                    <input type="text" id="expiry" name="expiry" placeholder="MM/YY" maxlength="5" required>
                </div>

                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="4" required>
                </div>
            </div>

            <button type="submit" name="confirmPaymentBtn" class="pm-pay-btn">Confirm Payment</button>

            <p class="pm-secure-note">This is a demo checkout - no real charge will be made.</p>

        </form>

    <?php } ?>

</div>
<?php include "../footer.php"; ?>