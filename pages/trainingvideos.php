<?php
session_start();
require_once("../header.php");

require_once("dbconnection.php");
require_once("dbtrainingvideos.php");


if (!isset($_SESSION["id"])) {
    header("location:login.php");
    exit;
}

$isadmin = ($_SESSION["role"] == "admin");
$isSubscribed = is_user_subscribed($_SESSION["id"]);
$canSeeAllVideos = $isadmin || $isSubscribed;
$muscleGroups = ["Chest", "Back", "Legs", "Arms", "Shoulders", "Abs"];

function cleaninput($data)
{
    $data = trim($data);
    $data = strip_tags($data);
    $data = stripslashes($data);
    return $data;
}

function extract_youtube_id($input)
{
    $input = trim($input);

    if (preg_match('/^[\w-]{11}$/', $input)) {
        return $input;
    }

    if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.*&v=))([\w-]{11})/', $input, $m)) {
        return $m[1];
    }

    return null;
}

$error = [];
$success = "";


//  ==============================Add video (owner only)==============================

if ($isadmin && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addVideoBtn'])) {

    $muscle = cleaninput($_POST["muscle_group"] ?? "");
    $title = cleaninput($_POST["title"] ?? "");
    $urlInput = cleaninput($_POST["youtube_url"] ?? "");

    if (!in_array($muscle, $muscleGroups)) {
        $error[] = "please choose a valid muscle group";
    }

    if (empty($title)) {
        $error[] = "video title is required";
    }

    $youtubeId = extract_youtube_id($urlInput);

    if (empty($urlInput)) {
        $error[] = "youtube link is required";
    } elseif (!$youtubeId) {
        $error[] = "couldn't read a video id from that youtube link";
    }

    if (empty($error)) {
        $result = add_training_video($muscle, $title, $youtubeId);
        if ($result["status"]) {
            header("Location: trainingvideos.php?added=1");
            exit;
        } else {
            $error[] = $result["message"];
        }
    }
}


// ==============================Delete video (owner only)==============================

if ($isadmin && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteVideoBtn'])) {

    $videoId = $_POST["video_id"] ?? null;

    if ($videoId !== null) {
        delete_training_video($videoId);
    }

    header("Location: trainingvideos.php?deleted=1");
    exit;
}

$result = $canSeeAllVideos ? get_all_training_videos() : get_default_training_videos();
$videos = $result["status"] ? $result["data"] : [];

$grouped = [];
foreach ($muscleGroups as $group) {
    $grouped[$group] = [];
}
foreach ($videos as $video) {
    $grouped[$video["muscle_group"]][] = $video;
}
?>
<link rel="stylesheet" href="styles/trainingvideosstyle.css">

<div class="tv-page">

    <div class="tv-header">
        <h1>Training Videos</h1>
        <p class="tv-subtitle">Exercise tutorials organized by muscle group</p>
    </div>

    <?php if (isset($_GET['added'])) { ?>
        <div class="tv-alert tv-alert-success">Video added.</div>
    <?php } ?>

    <?php if (isset($_GET['deleted'])) { ?>
        <div class="tv-alert tv-alert-success">Video deleted.</div>
    <?php } ?>

    <?php if (!empty($error)) { ?>
        <div class="tv-alert tv-alert-error">
            <ul>
                <?php foreach ($error as $val) { ?>
                    <li><?php echo htmlspecialchars($val); ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <?php if (!$canSeeAllVideos) { ?>
        <div class="tv-alert tv-alert-info">
            You're viewing our free video library. Subscribe to a gym branch to unlock the full library.
        </div>
    <?php } ?>

    <?php if ($isadmin) { ?>

        <!-- ================= Add video form (owner only) ================= -->
        <form method="POST" action="trainingvideos.php" class="tv-add-form">

            <h3 class="tv-add-title">Add a new video</h3>

            <div class="tv-add-row">

                <div class="form-group">
                    <label for="muscle_group">Muscle Group</label>
                    <select id="muscle_group" name="muscle_group" required>
                        <option value="">Select</option>
                        <?php foreach ($muscleGroups as $group) { ?>
                            <option value="<?php echo $group; ?>"><?php echo $group; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="title">Video Title</label>
                    <input type="text" id="title" name="title" placeholder="e.g. Barbell Squat Form" required>
                </div>

                <div class="form-group">
                    <label for="youtube_url">YouTube Link</label>
                    <input type="text" id="youtube_url" name="youtube_url" placeholder="https://youtube.com/watch?v=..." required>
                </div>

            </div>

            <button type="submit" name="addVideoBtn" class="tv-add-btn">Add Video</button>

        </form>

    <?php } ?>

    <div class="tv-tabs">
        <?php foreach ($muscleGroups as $index => $group) { ?>
            <button
                type="button"
                class="tv-tab <?php echo $index === 0 ? 'active' : ''; ?>"
                data-target="tv-panel-<?php echo strtolower($group); ?>">
                <?php echo $group; ?>
            </button>
        <?php } ?>
    </div>

    <?php foreach ($muscleGroups as $index => $group) { ?>

        <div id="tv-panel-<?php echo strtolower($group); ?>" class="tv-panel <?php echo $index === 0 ? 'active' : ''; ?>">

            <?php if (empty($grouped[$group])) { ?>

                <p class="tv-empty">No videos added for <?php echo $group; ?> yet.</p>

            <?php } else { ?>

                <div class="tv-grid">
                    <?php foreach ($grouped[$group] as $video) { ?>

                        <div class="tv-card">
                            <div class="tv-video-wrap">
                                <iframe
                                    src="https://www.youtube.com/embed/<?php echo htmlspecialchars($video['youtube_id']); ?>"
                                    title="<?php echo htmlspecialchars($video['title']); ?>"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>

                            <div class="tv-card-footer">
                                <h5 class="tv-title"><?php echo htmlspecialchars($video['title']); ?></h5>

                                <?php if ($isadmin) { ?>
                                    <form method="POST" action="trainingvideos.php" onsubmit="return confirm('Delete this video?');">
                                        <input type="hidden" name="video_id" value="<?php echo htmlspecialchars($video['id']); ?>">
                                        <button type="submit" name="deleteVideoBtn" class="tv-delete-btn">Delete</button>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>

                    <?php } ?>
                </div>

            <?php } ?>

        </div>

    <?php } ?>

</div>

<script>
    const tabs = document.querySelectorAll('.tv-tab');
    const panels = document.querySelectorAll('.tv-panel');

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            tabs.forEach(function(t) {
                t.classList.remove('active');
            });
            panels.forEach(function(p) {
                p.classList.remove('active');
            });

            tab.classList.add('active');
            document.getElementById(tab.dataset.target).classList.add('active');
        });
    });
</script>
<?php include "../footer.php"; ?>