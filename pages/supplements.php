<?php
session_start();
require_once("../header.php");

require_once("dbconnection.php");
require_once("dbsupplements.php");
require_once("dbcart.php");


if (!isset($_SESSION["id"])) {
    header("location:login.php");
    exit;
}

$isadmin = ($_SESSION["role"] == "admin");

$uploadDir = "uploads/supplements/";
$allowedTypes = ["image/jpeg", "image/png", "image/webp"];
$maxFileSize = 5 * 1024 * 1024; // 5MB

function cleaninput($data)
{
    $data = trim($data);
    $data = strip_tags($data);
    $data = stripslashes($data);
    return $data;
}

$error = [];
$success = "";


if ($isadmin && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addSupplementBtn'])) {

    $name = cleaninput($_POST["name"] ?? "");
    $description = cleaninput($_POST["description"] ?? "");
    $priceInput = cleaninput($_POST["price"] ?? "");

    if (empty($name)) {
        $error[] = "product name is required";
    }

    if (empty($description)) {
        $error[] = "product description is required";
    }

    if (!is_numeric($priceInput) || floatval($priceInput) < 0) {
        $error[] = "please enter a valid price";
    }

    $imagePath = null;

    if (!isset($_FILES["image"]) || $_FILES["image"]["error"] == UPLOAD_ERR_NO_FILE) {
        $error[] = "product image is required";
    } elseif ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
        $error[] = "there was a problem uploading the image";
    } else {
        $file = $_FILES["image"];

        if (!in_array($file["type"], $allowedTypes)) {
            $error[] = "image must be a jpg, png or webp file";
        } elseif ($file["size"] > $maxFileSize) {
            $error[] = "image must be smaller than 5MB";
        } else {
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
            $filename = uniqid("sup_", true) . "." . $ext;
            $destination = $uploadDir . $filename;

            if (move_uploaded_file($file["tmp_name"], $destination)) {
                $imagePath = $destination;
            } else {
                $error[] = "couldn't save the uploaded image, please try again";
            }
        }
    }

    if (empty($error)) {
        $result = add_supplement($name, $description, floatval($priceInput), $imagePath);
        if ($result["status"]) {
            $_SESSION["flash_success"] = "Supplement added.";
            header("Location: supplements.php");
            exit;
        } else {
            $error[] = $result["message"];
        }
    }
}




if ($isadmin && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatePriceBtn'])) {

    $supplementId = $_POST["supplement_id"] ?? null;
    $priceInput = cleaninput($_POST["new_price"] ?? "");

    if ($supplementId !== null && is_numeric($priceInput) && floatval($priceInput) >= 0) {
        update_supplement_price($supplementId, floatval($priceInput));
        $_SESSION["flash_success"] = "Price updated.";
        header("Location: supplements.php");
        exit;
    } else {
        $error[] = "please enter a valid price";
    }
}




if ($isadmin && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteSupplementBtn'])) {

    $supplementId = $_POST["supplement_id"] ?? null;

    if ($supplementId !== null) {
        $existing = get_supplement_by_id($supplementId);
        if ($existing["status"] && !empty($existing["data"]["image_path"]) && file_exists($existing["data"]["image_path"])) {
            unlink($existing["data"]["image_path"]);
        }
        delete_supplement($supplementId);
    }

    $_SESSION["flash_success"] = "Supplement deleted.";
    header("Location: supplements.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addToCartBtn'])) {

    $supplementId = $_POST["supplement_id"] ?? null;

    if ($supplementId !== null) {
        add_to_cart($_SESSION["id"], $supplementId, 1);
        $_SESSION["flash_success"] = "Added to cart.";
    }

    header("Location: supplements.php");
    exit;
}


$flashSuccess = $_SESSION["flash_success"] ?? null;
unset($_SESSION["flash_success"]);

$result = get_all_supplements();
$supplements = $result["status"] ? $result["data"] : [];
?>
<link rel="stylesheet" href="styles/supplementsstyle.css">

<div class="sp-page">

    <div class="sp-header">
        <div>
            <h1>Supplements</h1>
            <p class="sp-subtitle">Browse the supplements available at the gym</p>
        </div>
        <a href="carts.php" class="sp-cart-link">View Cart</a>
    </div>

    <?php if ($flashSuccess) { ?>
        <div class="sp-alert sp-alert-success"><?php echo htmlspecialchars($flashSuccess); ?></div>
    <?php } ?>

    <?php if (!empty($error)) { ?>
        <div class="sp-alert sp-alert-error">
            <ul>
                <?php foreach ($error as $val) { ?>
                    <li><?php echo htmlspecialchars($val); ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <?php if ($isadmin) { ?>


        <form method="POST" action="supplements.php" class="sp-add-form" enctype="multipart/form-data">

            <h3 class="sp-add-title">Add a new supplement</h3>

            <div class="sp-add-row">

                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" id="name" name="name" placeholder="e.g. Whey Protein" required>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" placeholder="e.g. 750" required>
                </div>

                <div class="form-group">
                    <label for="image">Product Image</label>
                    <input type="file" id="image" name="image" accept="image/png, image/jpeg, image/webp" required>
                </div>

            </div>

            <div class="sp-add-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Short description shown to members" required></textarea>
                </div>
            </div>

            <button type="submit" name="addSupplementBtn" class="sp-add-btn">Add Supplement</button>

        </form>

    <?php } ?>

    <?php if (empty($supplements)) { ?>

        <p class="sp-empty">No supplements added yet.</p>

    <?php } else { ?>

        <div class="sp-grid">
            <?php foreach ($supplements as $item) { ?>

                <div class="sp-card">

                    <div class="sp-img-wrap">
                        <?php if (!empty($item['image_path'])) { ?>
                            <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <?php } else { ?>
                            <div class="sp-img-placeholder">No image</div>
                        <?php } ?>
                    </div>

                    <div class="sp-body">
                        <h5 class="sp-title"><?php echo htmlspecialchars($item['name']); ?></h5>
                        <p class="sp-desc"><?php echo htmlspecialchars($item['description']); ?></p>
                        <p class="sp-price"><?php echo number_format($item['price'], 2); ?> EGP</p>
                    </div>

                    <form method="POST" action="supplements.php" class="sp-cart-form">
                        <input type="hidden" name="supplement_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                        <button type="submit" name="addToCartBtn" class="sp-cart-btn">Add to Cart</button>
                    </form>

                    <?php if ($isadmin) { ?>
                        <div class="sp-card-footer">

                            <form method="POST" action="supplements.php" class="sp-price-form">
                                <input type="hidden" name="supplement_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                <input type="number" name="new_price" step="0.01" min="0" value="<?php echo htmlspecialchars($item['price']); ?>" required>
                                <button type="submit" name="updatePriceBtn" class="sp-save-btn">Save</button>
                            </form>

                            <form method="POST" action="supplements.php" onsubmit="return confirm('Delete this supplement?');">
                                <input type="hidden" name="supplement_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                <button type="submit" name="deleteSupplementBtn" class="sp-delete-btn">Delete</button>
                            </form>

                        </div>
                    <?php } ?>

                </div>

            <?php } ?>
        </div>

    <?php } ?>

</div>
<?php include "../footer.php"; ?>