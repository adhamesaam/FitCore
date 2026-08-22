<?php
include_once('../header.php');
require_once('dbuser.php');

$add_info = null;
$adminCapReached = count_admins() >= MAX_ADMINS;

if (isset($_POST['addmember'])) {
    $fullname = trim($_POST['fname']) . ' ' . trim($_POST['lname']);

    $add_info = addUser([
        'fullname'         => $fullname,
        'email'            => $_POST['email'],
        'gender'           => $_POST['gender'],
        'role'             => $_POST['role'],
        'password'         => $_POST['password'],
        'created_at'       => $_POST['join_date'] ?: date('Y-m-d H:i:s'),
    ]);
}
?>
<main>
    <link rel="stylesheet" href="styles/addUser.css">

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body p-4">

                <h3 class="mb-4">Add New Member</h3>

                <?php
                if (isset($add_info['status'])) {
                    if ($add_info['status']) {
                        echo "<div class='alert alert-success'>" . $add_info['message'] . "</div>";
                    } else {
                        echo "<div class='alert alert-danger'>" . $add_info['message'] . "</div>";
                    }
                }
                ?>

                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" id="fname" name="fname" class="form-control">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" id="lname" name="lname" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Gender</label>
                            <select id="gender" name="gender" class="form-control">
                                <option selected disabled>--Please select gender--</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Join Date</label>
                            <input type="date" id="join_date" name="join_date" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Role</label>
                            <select id="role" name="role" class="form-control">
                                <option selected disabled>--Please select role--</option>
                                <option value="user">Member</option>
                                <option value="trainer">Trainer</option>
                                <option value="admin" <?php echo $adminCapReached ? 'disabled' : ''; ?>>
                                    Admin<?php echo $adminCapReached ? ' (limit reached)' : ''; ?>
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <a href="userManager.php" class="btn btn-secondary px-4 py-2 me-2">Cancel</a>
                        <button type="submit" name="addmember" class="btn btn-primary px-4 py-2">
                            <i class="fa-solid fa-plus me-1"></i>
                            Add Member
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</main>