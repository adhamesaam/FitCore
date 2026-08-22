<?php
include_once('../header.php');
require_once('dbuser.php');

$edit_info = null;

if (!isset($_GET['userId'])) {
    header('Location: userManager.php');
    exit;
}

$userId = $_GET['userId'];
$userResult = get_user_by_id($userId);

if (!$userResult['status']) {
    header('Location: userManager.php');
    exit;
}

$user = $userResult['data'];

// admin accounts can't be edited through this page
if ($user['role'] === 'admin') {
    header('Location: userManager.php?editBlocked=1');
    exit;
}

// split the stored fullname into first/last for the two inputs
$nameParts = explode(' ', $user['fullname'], 2);
$fname = $nameParts[0] ?? '';
$lname = $nameParts[1] ?? '';

$adminCapReached = count_admins() >= MAX_ADMINS;

if (isset($_POST['editmember'])) {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $fullname = $fname . ' ' . $lname;

    $edit_info = update_user(
        $userId,
        $fullname,
        $_POST['email'],
        $_POST['gender'],
        $_POST['role']
    );

    // refresh local values so the form reflects what was just saved
    $user['email'] = $_POST['email'];
    $user['gender'] = $_POST['gender'];
    $user['role'] = $_POST['role'];
}
?>
<main>
    <link rel="stylesheet" href="styles/editUser.css">

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body p-4">

                <h3 class="mb-4">Edit User</h3>

                <?php
                if (isset($edit_info['status'])) {
                    if ($edit_info['status']) {
                        echo "<div class='alert alert-success'>" . $edit_info['message'] . "</div>";
                    } else {
                        echo "<div class='alert alert-danger'>" . $edit_info['message'] . "</div>";
                    }
                }
                ?>

                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" id="fname" name="fname" class="form-control" value="<?php echo htmlspecialchars($fname); ?>">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" id="lname" name="lname" class="form-control" value="<?php echo htmlspecialchars($lname); ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Gender</label>
                            <select id="gender" name="gender" class="form-control">
                                <option value="male" <?php echo $user['gender'] === 'male' ? 'selected' : ''; ?>>Male</option>
                                <option value="female" <?php echo $user['gender'] === 'female' ? 'selected' : ''; ?>>Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Role</label>
                            <select id="role" name="role" class="form-control">
                                <option value="member" <?php echo $user['role'] === 'member' ? 'selected' : ''; ?>>Member</option>
                                <option value="trainer" <?php echo $user['role'] === 'trainer' ? 'selected' : ''; ?>>Trainer</option>
                                <option value="admin" <?php echo $adminCapReached ? 'disabled' : ''; ?> <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>
                                    Admin<?php echo $adminCapReached ? ' (limit reached)' : ''; ?>
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <a href="userManager.php" class="btn btn-secondary px-4 py-2 me-2">Cancel</a>
                        <button type="submit" name="editmember" class="btn btn-primary px-4 py-2">
                            <i class="fa-solid fa-pen-to-square me-1"></i>
                            Save Changes
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</main>