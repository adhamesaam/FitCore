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

if (!isset($_SESSION["id"])) {
    header("location:login.php");
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

    <?php if (empty($locations)) { ?>

        <p class="gymloc-empty">
            No gym locations available right now.
        </p>

    <?php } else { ?>

        <div class="row row-cols-1 row-cols-md-2 g-4">

            <?php foreach ($locations as $loc) { ?>

                <div class="col">
                    <form method="POST" action="userSub.php" class="card-form">
                        <input type="hidden" name="gymId" value="<?php echo htmlspecialchars($loc['gymId']); ?>">
                        <button type="submit" class="card-link">
                            <div class="card">
                                <div class="card-icon">&#127970;</div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($loc['name']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($loc['location']); ?></p>
                                </div>
                            </div>
                        </button>
                    </form>
                </div>

            <?php } ?>

        </div>

    <?php }
    ?>

</div>