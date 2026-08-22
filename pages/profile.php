<?php
session_start();
require_once("../header.php");

require_once("dbconnection.php");
require_once("dbuser.php");

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
$success = "";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['savebtn'])) {

    $fullname = cleaninput($_POST["fullname"]);
    $email = cleaninput($_POST["email"]);

    if (empty($fullname)) {
        $error[] = "Full name is required";
    }

    if (empty($email)) {
        $error[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Please enter a valid email address";
    }

    $photoPath = null;

    // Handle photo upload if a new file was chosen
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $fileType = mime_content_type($_FILES['photo']['tmp_name']);

        if (!in_array($fileType, $allowedTypes)) {
            $error[] = "Photo must be a JPG, PNG, GIF or WEBP image";
        } elseif ($_FILES['photo']['size'] > 3 * 1024 * 1024) {
            $error[] = "Photo must be smaller than 3MB";
        } else {
            $uploadDir = __DIR__ . "/uploads/profile_photos/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $newFileName = "user_" . $_SESSION["id"] . "_" . uniqid() . "." . $ext;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $newFileName)) {
                $photoPath = "uploads/profile_photos/" . $newFileName;
            } else {
                $error[] = "Failed to upload photo, please try again";
            }
        }
    }

    if (empty($error)) {

        $result = update_user_profile($_SESSION["id"], $fullname, $email, $photoPath);

        if ($result["status"]) {
            $_SESSION['username'] = $fullname;
            $_SESSION['useremail'] = $email;
            header("Location: profile.php?updated=1");
            exit;
        } else {
            $error[] = $result["message"];
        }
    }
}


$userResult = get_user_by_id($_SESSION["id"]);
$user = $userResult["status"] ? $userResult["data"] : null;

if (!$user) {

    $user = [
        "fullname" => $_SESSION["username"] ?? "",
        "email" => $_SESSION["useremail"] ?? "",
        "gender" => "",
        "role" => $_SESSION["role"] ?? "",
        "photo" => null
    ];
}

$justUpdated = isset($_GET["updated"]);

$photoUrl = !empty($user["photo"]) ? htmlspecialchars($user["photo"]) : null;
$initial = strtoupper(substr($user["fullname"] ?? "U", 0, 1));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="styles/profilestyle.css">
</head>

<body>

    <div class="profile-page">

        <div class="profile-card">

            <div class="profile-card-header">
                <h1>My Profile</h1>
                <p class="profile-subtitle">Manage your personal information</p>
            </div>

            <?php if ($justUpdated) { ?>
                <div class="alert-success">Your profile has been updated.</div>
            <?php } ?>

            <?php if (!empty($error)) { ?>
                <div class="alert-error">
                    <ul>
                        <?php foreach ($error as $val) { ?>
                            <li><?php echo htmlspecialchars($val); ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

            <div class="profile-view" id="viewMode" style="<?php echo !empty($error) ? 'display:none;' : ''; ?>">

                <div class="avatar-block">
                    <?php if ($photoUrl) { ?>
                        <img src="<?php echo $photoUrl; ?>" alt="Profile photo" class="avatar-img">
                    <?php } else { ?>
                        <div class="avatar-placeholder"><?php echo htmlspecialchars($initial); ?></div>
                    <?php } ?>
                </div>

                <div class="info-list">

                    <div class="info-row">
                        <span class="info-label">Full Name</span>
                        <span class="info-value"><?php echo htmlspecialchars($user["fullname"]); ?></span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Email Address</span>
                        <span class="info-value"><?php echo htmlspecialchars($user["email"]); ?></span>
                    </div>

                    <?php if (!empty($user["gender"])) { ?>
                        <div class="info-row">
                            <span class="info-label">Gender</span>
                            <span class="info-value"><?php echo htmlspecialchars($user["gender"]); ?></span>
                        </div>
                    <?php } ?>

                    <div class="info-row">
                        <span class="info-label">Role</span>
                        <span class="info-value role-badge"><?php echo htmlspecialchars($user["role"]); ?></span>
                    </div>

                </div>

                <button type="button" id="editBtn" class="btn-edit">Edit Profile</button>

            </div>

            <form method="POST" action="profile.php" enctype="multipart/form-data" class="profile-form" id="editMode" style="<?php echo !empty($error) ? '' : 'display:none;'; ?>">

                <div class="avatar-block">

                    <label for="photo" class="avatar-upload">
                        <?php if ($photoUrl) { ?>
                            <img src="<?php echo $photoUrl; ?>" alt="Profile photo" class="avatar-img">
                        <?php } else { ?>
                            <div class="avatar-placeholder"><?php echo htmlspecialchars($initial); ?></div>
                        <?php } ?>
                        <span class="avatar-upload-icon">&#8593;</span>
                    </label>

                    <input type="file" id="photo" name="photo" accept="image/*" class="avatar-input">
                    <span class="upload-hint">Click the circle to change photo</span>

                </div>

                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input
                        type="text"
                        id="fullname"
                        name="fullname"
                        value="<?php echo htmlspecialchars($user["fullname"]); ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?php echo htmlspecialchars($user["email"]); ?>"
                        required>
                </div>

                <div class="form-actions">
                    <button type="button" id="cancelBtn" class="btn-cancel">Cancel</button>
                    <button type="submit" name="savebtn" class="btn-save">Save Changes</button>
                </div>

            </form>

        </div>

    </div>

    <script>
        const editBtn = document.getElementById('editBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const viewMode = document.getElementById('viewMode');
        const editMode = document.getElementById('editMode');

        if (editBtn) {
            editBtn.addEventListener('click', function() {
                viewMode.style.display = 'none';
                editMode.style.display = 'block';
            });
        }

        if (cancelBtn) {
            cancelBtn.addEventListener('click', function() {
                editMode.style.display = 'none';
                viewMode.style.display = 'block';
            });
        }

        const photoInput = document.getElementById('photo');
        if (photoInput) {
            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function(ev) {
                    const block = document.querySelector('.avatar-upload');
                    let img = block.querySelector('.avatar-img');
                    const placeholder = block.querySelector('.avatar-placeholder');

                    if (!img) {
                        img = document.createElement('img');
                        img.className = 'avatar-img';
                        block.insertBefore(img, block.firstChild);
                    }
                    if (placeholder) placeholder.remove();

                    img.src = ev.target.result;
                };
                reader.readAsDataURL(file);
            });
        }
    </script>


</body>

</html>