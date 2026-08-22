<?php
require_once('dbuser.php');
include_once('../header.php');

$del_info = null;

// handle delete via ?delId=... then redirect so refreshing the page
// doesn't try to delete the same id again
if (isset($_GET['delId'])) {
    $targetUser = get_user_by_id($_GET['delId']);

    // admin accounts can't be deleted through this page, regardless of who's asking
    if ($targetUser['status'] && $targetUser['data']['role'] === 'admin') {
        header('Location: userManager.php?deleted=admin_protected');
        exit;
    }

    $del_info = delete_user($_GET['delId']);
    header('Location: userManager.php?deleted=' . ($del_info['status'] ? '1' : '0'));
    exit;
}

if (isset($_GET['deleted'])) {
    if ($_GET['deleted'] === 'admin_protected') {
        $del_info = ["status" => false, "message" => "Admin accounts can't be deleted"];
    } else {
        $del_info = $_GET['deleted'] === '1'
            ? ["status" => true, "message" => "User deleted successfully"]
            : ["status" => false, "message" => "Could not delete user"];
    }
}

if (isset($_GET['editBlocked'])) {
    $del_info = ["status" => false, "message" => "Admin accounts can't be edited"];
}

$userInfo = get_all_users();
?>
<main>
    <link rel="stylesheet" href="styles/userManager.css">

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body p-4">

                <?php
                if (isset($del_info['status'])) {
                    if ($del_info['status']) {
                        echo "<div class='alert alert-success'>" . $del_info['message'] . "</div>";
                    } else {
                        echo "<div class='alert alert-danger'>" . $del_info['message'] . "</div>";
                    }
                }
                ?>

                <div class="row mb-4 align-items-center">
                    <div class="col-md-6 px-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 py-2 px-3">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    class="text-muted"
                                    viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0"/>
                                </svg>
                            </span>
                            <input
                                type="text"
                                id="searchBar"
                                class="form-control border-start-0 ps-2 py-2"
                                placeholder="Type to search users..."
                            >
                        </div>
                    </div>
                    <!-- Add User -->
                    <div class="col-md-auto ms-auto px-3">
                        <a href="addUser.php" class="btn btn-primary px-4 py-2" style="text-decoration: none;">
                            <i class="fa-solid fa-plus me-1"></i>
                            Add User
                        </a>
                    </div>
                </div>

                <div>
                    <table class="table table-hover space-between" id="userTable">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <!-- <th scope="col">subscribed At</th> -->
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            <?php if ($userInfo['status']) { ?>
                                <?php foreach ($userInfo['data'] as $user) { ?>
                                    <tr>
                                        <th scope="row"><?php echo $user['id'] ?></th>
                                        <td><?php echo $user['fullname'] ?></td>
                                        <td><?php echo $user['email'] ?></td>
                                        <td><?php echo $user['role'] ?></td>
                                        <!-- <td><?//php echo $user['subscribed_at'] ?></td> -->
                                        <td>
                                            <?php if ($user['role'] === 'admin') { ?>
                                                <button type="button"
                                                        class="btn btn-danger"
                                                        disabled
                                                        title="Admin accounts can't be deleted">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                |
                                                <button type="button"
                                                        class="btn btn-warning"
                                                        disabled
                                                        title="Admin accounts can't be edited">
                                                    <i class="fa-solid fa-lock" style="color:whitesmoke"></i>
                                                </button>
                                            <?php } else { ?>
                                                <a href="userManager.php?delId=<?php echo $user['id'] ?>"
                                                   class="btn btn-danger"
                                                   onclick="return confirm('Delete this user?');">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                                |
                                                <a class="btn btn-warning" href="editUser.php?userId=<?php echo $user['id'] ?>">
                                                    <i class="fa-solid fa-pen-to-square" style="color:whitesmoke"></i>
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</main>

<script>
    const searchInput = document.getElementById('searchBar');
    const tableBody = document.getElementById('userTableBody');

    searchInput.addEventListener('input', (e) => {
        let searchValue = e.target.value.toLowerCase();
        let rows = tableBody.getElementsByTagName('tr');
        for (let i = 0; i < rows.length; i++) {
            let id = rows[i].cells[0].textContent.trim();
            if (id === searchValue || searchValue === '') {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    })
</script>