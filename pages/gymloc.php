<?php
session_start();
require_once("../header.php");

require_once("dbconnection.php");
function get_all_locations()
{
    try {
        $con = dbconnect();
        $sql = "SELECT gymId, name, location FROM gym_locations ORDER BY name ASC";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $con = null;

        if ($stmt->rowCount() > 0) {
            return ["status" => true, "data" => $data];
        } else {
            return ["status" => false, "message" => "No gym locations found"];
        }
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}

function add_location($name, $location)
{
    try {
        $con = dbconnect();
        $sql = "INSERT INTO gym_locations (name, location) VALUES (:name, :location)";
        $stmt = $con->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':location' => $location
        ]);
        $con = null;
        return ["status" => true, "message" => "Branch added"];
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}

function delete_location($gymId)
{
    try {
        $con = dbconnect();
        $sql = "DELETE FROM gym_locations WHERE gymId = :gymId";
        $stmt = $con->prepare($sql);
        $stmt->execute([':gymId' => $gymId]);
        $con = null;
        return ["status" => true, "message" => "Branch deleted"];
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}

if (!isset($_SESSION["id"])) {
    header("location:login.php");
    exit;
}

$isadmin = ($_SESSION["role"] == "admin");

function cleaninput($data)
{
    $data = trim($data);
    $data = strip_tags($data);
    $data = stripslashes($data);
    return $data;
}

$error = [];


if ($isadmin && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addBranchBtn'])) {

    $name = cleaninput($_POST["name"] ?? "");
    $location = cleaninput($_POST["location"] ?? "");

    if (empty($name)) {
        $error[] = "branch name is required";
    }

    if (empty($location)) {
        $error[] = "location is required";
    }

    if (empty($error)) {
        $result = add_location($name, $location);
        if ($result["status"]) {
            header("Location: gymloc.php?added=1");
            exit;
        } else {
            $error[] = $result["message"];
        }
    }
}


if ($isadmin && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteBranchBtn'])) {

    $gymId = $_POST["gymId"] ?? null;

    if ($gymId !== null) {
        delete_location($gymId);
    }

    header("Location: gymloc.php?deleted=1");
    exit;
}

$result = get_all_locations();
$locations = $result["status"] ? $result["data"] : [];
?>
<link rel="stylesheet" href="styles/gymlocstyle.css">

<div class="gymloc-page">

    <div class="gymloc-header">
        <h1>Gym Locations</h1>
        <p class="gymloc-subtitle">Find a FitCore branch near you</p>
    </div>

    <?php if (isset($_GET['added'])) { ?>
        <div class="gymloc-alert gymloc-alert-success">Branch added.</div>
    <?php } ?>

    <?php if (isset($_GET['deleted'])) { ?>
        <div class="gymloc-alert gymloc-alert-success">Branch deleted.</div>
    <?php } ?>

    <?php if (!empty($error)) { ?>
        <div class="gymloc-alert gymloc-alert-error">
            <ul>
                <?php foreach ($error as $val) { ?>
                    <li><?php echo htmlspecialchars($val); ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <?php if ($isadmin) { ?>

        <form method="POST" action="gymloc.php" class="gymloc-add-form">

            <h3 class="gymloc-add-title">Add a new branch</h3>

            <div class="gymloc-add-row">

                <div class="form-group">
                    <label for="name">Branch Name</label>
                    <input type="text" id="name" name="name" placeholder="e.g. FitCore Maadi" required>
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" placeholder="e.g. Maadi" required>
                </div>

            </div>

            <button type="submit" name="addBranchBtn" class="gymloc-add-btn">Add Branch</button>

        </form>

    <?php } ?>

    <?php if (empty($locations)) { ?>

        <p class="gymloc-empty">
            No gym locations available right now.
        </p>

    <?php } else { ?>

        <div class="row row-cols-1 row-cols-md-2 g-4">

            <?php foreach ($locations as $loc) { ?>

                <div class="col">

                    <div class="card">

                        <?php if ($isadmin) { ?>
                            <form method="POST" action="gymloc.php" class="card-delete-form" onsubmit="return confirm('Delete this branch?');">
                                <input type="hidden" name="gymId" value="<?php echo htmlspecialchars($loc['gymId']); ?>">
                                <button type="submit" name="deleteBranchBtn" class="card-delete-btn">&times;</button>
                            </form>
                        <?php } ?>

                        <form method="POST" action="userSub.php" class="card-form">
                            <input type="hidden" name="gymId" value="<?php echo htmlspecialchars($loc['gymId']); ?>">
                            <button type="submit" class="card-link">
                                <div class="card-icon">&#127970;</div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($loc['name']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($loc['location']); ?></p>
                                </div>
                            </button>
                        </form>

                    </div>

                </div>

            <?php } ?>

        </div>

    <?php } ?>

</div>