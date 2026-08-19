<?php
/*
 * Backend-ready dashboard data.
 * Replace these temporary values with database queries when your backend is ready.
 */
$userName = 'Ahmed';
$streakDays = 14;
$bestStreak = 21;

$weekDays = [
    ['label' => 'M', 'completed' => true],
    ['label' => 'T', 'completed' => true],
    ['label' => 'W', 'completed' => true],
    ['label' => 'T', 'completed' => true],
    ['label' => 'F', 'completed' => true],
    ['label' => 'S', 'completed' => true],
    ['label' => 'S', 'completed' => false],
];

$todayWorkout = [
    'name' => 'Chest & Triceps',
    'exercises' => 6,
    'duration' => 45,
    'level' => 'Intermediate',
    'image' => 'images/cross_fit_image.jpg'
];

$goals = [
    ['name' => 'Lose 10 KG', 'current' => 7, 'target' => 10, 'unit' => 'KG', 'deadline' => 'Dec 20, 2026', 'icon' => 'fa-weight-scale'],
    ['name' => 'Bench Press 100 KG', 'current' => 50, 'target' => 100, 'unit' => 'KG', 'deadline' => 'Jan 15, 2027', 'icon' => 'fa-dumbbell']
];

$recentWorkouts = [
    ['name' => 'Chest & Triceps', 'exercises' => 6, 'duration' => 45, 'date' => 'Today', 'icon' => 'fa-dumbbell', 'today' => true],
    ['name' => 'Legs', 'exercises' => 7, 'duration' => 50, 'date' => 'Yesterday', 'icon' => 'fa-person-running', 'today' => false],
    ['name' => 'Back & Biceps', 'exercises' => 8, 'duration' => 55, 'date' => 'Aug 16, 2026', 'icon' => 'fa-child-reaching', 'today' => false]
];

function goalPercentage(array $goal): int
{
    if ((float)$goal['target'] <= 0) return 0;
    return min(100, max(0, (int)round(($goal['current'] / $goal['target']) * 100)));
}

/* Your existing FitCore header is used here instead of a dashboard sidebar. */
include_once('../header.php');
?>

<link rel="stylesheet" href="styles/goalsStyle.css">

<main class="dashboard-page">
    <div class="page-container">
        <section class="welcome">
            <h1>Good evening, <?= htmlspecialchars($userName) ?> <span>👋</span></h1>
            <p>Let’s keep pushing your limits today.</p>
        </section>

        <section class="top-grid">
            <article class="dashboard-card streak-card">
                <h2>YOUR STREAK</h2>
                <div class="streak-value">
                    <i class="fa-solid fa-fire-flame-curved"></i>
                    <strong><?= $streakDays ?></strong>
                    <span>DAYS</span>
                </div>
                <p class="muted">Best streak: <?= $bestStreak ?> days</p>

                <div class="week-streak" aria-label="Weekly workout streak">
                    <?php foreach ($weekDays as $day): ?>
                        <div>
                            <span><?= htmlspecialchars($day['label']) ?></span>
                            <b class="<?= $day['completed'] ? '' : 'empty' ?>"><?= $day['completed'] ? '✓' : '' ?></b>
                        </div>
                    <?php endforeach; ?>
                </div>
            </article>

            <article class="dashboard-card workout-card" id="workout">
                <div class="workout-copy">
                    <h2>TODAY'S WORKOUT</h2>
                    <div class="workout-title-row">
                        <div class="workout-icon"><i class="fa-solid fa-dumbbell"></i></div>
                        <div>
                            <h3><?= htmlspecialchars($todayWorkout['name']) ?></h3>
                            <p><?= (int)$todayWorkout['exercises'] ?> exercises <span>•</span> <?= (int)$todayWorkout['duration'] ?> min <span>•</span> <?= htmlspecialchars($todayWorkout['level']) ?></p>
                        </div>
                    </div>
                    <a class="primary-button" href="workout.php">START WORKOUT <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="workout-image" style="background-image: linear-gradient(90deg, #111517 0%, transparent 42%), url('<?= htmlspecialchars($todayWorkout['image']) ?>');"></div>
            </article>
        </section>

        <section class="bottom-grid">
            <article class="dashboard-card goals-card" id="goals">
                <div class="card-heading">
                    <h2>MY GOALS</h2>
                    <a href="goals.php#goals">View all</a>
                </div>

                <div class="goal-list">
                    <?php foreach ($goals as $goal): $percentage = goalPercentage($goal); ?>
                        <div class="goal-row">
                            <div class="goal-icon"><i class="fa-solid <?= htmlspecialchars($goal['icon']) ?>"></i></div>
                            <div class="goal-main">
                                <div class="goal-title-line">
                                    <h3><?= htmlspecialchars($goal['name']) ?></h3>
                                    <strong><?= $percentage ?>%</strong>
                                </div>
                                <div class="progress"><span style="width: <?= $percentage ?>%"></span></div>
                                <div class="goal-meta">
                                    <span><?= htmlspecialchars($goal['current']) ?> / <?= htmlspecialchars($goal['target']) ?> <?= htmlspecialchars($goal['unit']) ?></span>
                                    <span><?= htmlspecialchars($goal['deadline']) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button class="outline-button" id="addGoalButton" type="button">
                    <i class="fa-solid fa-plus"></i> ADD NEW GOAL
                </button>
            </article>

            <article class="dashboard-card recent-card" id="history">
                <div class="card-heading">
                    <h2>RECENT WORKOUTS</h2>
                    <a href="history.php">View all</a>
                </div>

                <div class="recent-list">
                    <?php foreach ($recentWorkouts as $workout): ?>
                        <a class="recent-row" href="workout.php">
                            <div class="recent-icon"><i class="fa-solid <?= htmlspecialchars($workout['icon']) ?>"></i></div>
                            <div class="recent-copy">
                                <h3><?= htmlspecialchars($workout['name']) ?></h3>
                                <p><?= (int)$workout['exercises'] ?> exercises <span>•</span> <?= (int)$workout['duration'] ?> min</p>
                            </div>
                            <span class="recent-date <?= $workout['today'] ? 'today' : '' ?>"><?= htmlspecialchars($workout['date']) ?></span>
                            <i class="fa-solid fa-chevron-right arrow"></i>
                        </a>
                    <?php endforeach; ?>
                </div>

                <a class="outline-button history-button" href="history.php">
                    <i class="fa-regular fa-calendar"></i> VIEW FULL HISTORY
                </a>
            </article>
        </section>
    </div>
</main>

<!-- This form is ready for a PHP POST handler/database insert later. -->
<div class="modal" id="goalModal" aria-hidden="true">
    <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="goalModalTitle">
        <button class="modal-close" id="closeGoalModal" type="button" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
        <h2 id="goalModalTitle">Add New Goal</h2>
        <p>Enter your goal details.</p>

        <form id="goalForm" method="POST" action="">
            <!-- Backend fields: $_POST['goal_name'], $_POST['target_value'], $_POST['deadline'] -->
            <label>Goal name
                <input type="text" name="goal_name" id="goalName" placeholder="e.g. Lose 5 KG" required>
            </label>
            <label>Target
                <input type="text" name="target_value" id="goalTarget" placeholder="e.g. 5 KG" required>
            </label>
            <label>Deadline
                <input type="date" name="deadline" id="goalDate" required>
            </label>
            <button class="primary-button" type="submit">SAVE GOAL <i class="fa-solid fa-check"></i></button>
        </form>
    </div>
</div>

<script>
const modal = document.getElementById('goalModal');
const openButton = document.getElementById('addGoalButton');
const closeButton = document.getElementById('closeGoalModal');
const form = document.getElementById('goalForm');

function toggleGoalModal(open) {
    modal.classList.toggle('show', open);
    modal.setAttribute('aria-hidden', String(!open));
    if (open) document.getElementById('goalName').focus();
}

openButton.addEventListener('click', () => toggleGoalModal(true));
closeButton.addEventListener('click', () => toggleGoalModal(false));
modal.addEventListener('click', event => {
    if (event.target === modal) toggleGoalModal(false);
});
document.addEventListener('keydown', event => {
    if (event.key === 'Escape') toggleGoalModal(false);
});

/*
 * BACKEND HOOK:
 * Remove this submit listener when you are ready for PHP to process the form.
 * The form already sends:
 *   goal_name
 *   target_value
 *   deadline
 */
form.addEventListener('submit', event => {
    event.preventDefault();
    toggleGoalModal(false);
});
</script>

<?php include_once('../footer.php'); ?>
