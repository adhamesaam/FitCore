<?php
session_start();
require_once("../header.php");

require_once("dbconnection.php");
require_once("dbsubscription.php");


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

$hasPendingSubscription = isset($_SESSION["subscription"]);
$subscription = $hasPendingSubscription ? $_SESSION["subscription"] : null;




if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmPaymentBtn'])) {

    $cardName = cleaninput($_POST["card_name"] ?? "");
    $cardNumber = str_replace(" ", "", cleaninput($_POST["card_number"] ?? ""));
    $expiry = cleaninput($_POST["expiry"] ?? "");
    $cvv = cleaninput($_POST["cvv"] ?? "");

    if (!$hasPendingSubscription) {
        $error[] = "there's no plan selected to pay for";
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

        $activateResult = activate_user_subscription(
            $_SESSION["id"],
            $subscription["plan_id"],
            $subscription["plan_name"],
            $subscription["price"]
        );

        unset($_SESSION["subscription"]);

        if ($activateResult["status"]) {
            $_SESSION["flash_success"] = "Payment successful! Your " . $subscription["plan_name"] . " subscription is now active.";
            header("Location: userSub.php");
            exit;
        } else {
            $error[] = $activateResult["message"];
        }
    }
}
?>
<link rel="stylesheet" href="styles/paymentsubstyle.css">

<div class="psub-page">

    <div class="psub-header">
        <h1>Payment</h1>
        <p class="psub-subtitle">Complete your subscription</p>
    </div>

    <?php if (!empty($error)) { ?>
        <div class="psub-alert psub-alert-error">
            <ul>
                <?php foreach ($error as $val) { ?>
                    <li><?php echo htmlspecialchars($val); ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <?php if (!$hasPendingSubscription) { ?>

        <div class="psub-empty">
            No plan selected yet. <a href="userSub.php">Choose a plan</a> to get started.
        </div>

    <?php } else { ?>

        <div class="psub-summary">
            <h3 class="psub-summary-title">Subscription Summary</h3>

            <div class="psub-plan-row">
                <span class="psub-plan-name">
                    <?php echo htmlspecialchars($subscription['plan_name']); ?>
                    <span class="psub-plan-badge">Monthly</span>
                </span>
            </div>

            <div class="psub-summary-total">
                <span class="psub-summary-total-label">Total (per month)</span>
                <span class="psub-summary-total-value"><?php echo number_format($subscription['price']); ?>EGP</span>
            </div>

            <p class="psub-billing-note">You'll be billed this amount monthly until you cancel.</p>
        </div>

        <form method="POST" action="paymentsub.php" class="psub-form">

            <h3 class="psub-form-title">Card Details</h3>

            <div class="psub-form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="card_name">Cardholder Name</label>
                    <input type="text" id="card_name" name="card_name" placeholder="Name on card" required>
                </div>
            </div>

            <div class="psub-form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="card_number">Card Number</label>
                    <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19" required>
                </div>
            </div>

            <div class="psub-form-row">
                <div class="form-group">
                    <label for="expiry">Expiry (MM/YY)</label>
                    <input type="text" id="expiry" name="expiry" placeholder="MM/YY" maxlength="5" required>
                </div>

                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="4" required>
                </div>
            </div>

            <button type="submit" name="confirmPaymentBtn" class="psub-pay-btn">Confirm Payment</button>

            <p class="psub-secure-note">This is a demo checkout - no real charge will be made.</p>

        </form>

    <?php } ?>

</div>
<?php include "../footer.php"; ?>