<?php
// Dashboard-style goals page. It intentionally does not include header.php because
// the member dashboard uses its own fixed sidebar/header layout.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitCore | Dashboard</title>
    <link rel="stylesheet" href="styles/goalsStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <div class="dashboard-shell">
        <aside class="sidebar">
            <a class="brand" href="home.php" aria-label="FitCore home">
                <span class="brand-mark"><i class="fa-solid fa-dumbbell"></i></span>
                <span class="brand-text"><strong>FIT</strong><span>CORE</span></span>
            </a>

            <nav class="sidebar-nav" aria-label="Dashboard navigation">
                <a class="nav-item active" href="goals.php"><i class="fa-solid fa-house"></i><span>Dashboard</span></a>
                <a class="nav-item" href="goals.php#goals"><i class="fa-solid fa-bullseye"></i><span>My Goals</span></a>
                <a class="nav-item" href="goals.php#workout"><i class="fa-solid fa-dumbbell"></i><span>Workouts</span></a>
                <a class="nav-item" href="goals.php#history"><i class="fa-regular fa-calendar"></i><span>History</span></a>
                <a class="nav-item" href="#"><i class="fa-solid fa-apple-whole"></i><span>Nutrition</span></a>
                <a class="nav-item" href="#"><i class="fa-solid fa-person-running"></i><span>Progress</span></a>
                <a class="nav-item" href="#"><i class="fa-regular fa-user"></i><span>Profile</span></a>
                <a class="nav-item" href="#"><i class="fa-solid fa-gear"></i><span>Settings</span></a>
            </nav>

            <a class="logout" href="#"><i class="fa-solid fa-right-from-bracket"></i><span>Log out</span></a>
        </aside>

        <main class="dashboard-content">
            <header class="topbar">
                <div class="mobile-brand">
                    <span class="brand-mark"><i class="fa-solid fa-dumbbell"></i></span>
                    <span class="brand-text"><strong>FIT</strong><span>CORE</span></span>
                </div>
                <div class="topbar-actions">
                    <button class="icon-button notification" type="button" aria-label="Notifications">
                        <i class="fa-regular fa-bell"></i><span></span>
                    </button>
                    <button class="profile-menu" type="button">
                        <img src="images/avatar-1.jpg" alt="Ahmed profile photo">
                        <span>Ahmed</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                </div>
            </header>

            <div class="page-container">
                <section class="welcome">
                    <h1>Good evening, Ahmed <span>👋</span></h1>
                    <p>Let’s keep pushing your limits today.</p>
                </section>

                <section class="top-grid">
                    <article class="card streak-card">
                        <h2>YOUR STREAK</h2>
                        <div class="streak-value"><i class="fa-solid fa-fire-flame-curved"></i><strong>14</strong><span>DAYS</span></div>
                        <p class="muted">Best streak: 21 days</p>
                        <div class="week-streak" aria-label="Weekly workout streak">
                            <div><span>M</span><b>✓</b></div>
                            <div><span>T</span><b>✓</b></div>
                            <div><span>W</span><b>✓</b></div>
                            <div><span>T</span><b>✓</b></div>
                            <div><span>F</span><b>✓</b></div>
                            <div><span>S</span><b>✓</b></div>
                            <div><span>S</span><b class="empty"></b></div>
                        </div>
                    </article>

                    <article class="card workout-card" id="workout">
                        <div class="workout-copy">
                            <h2>TODAY'S WORKOUT</h2>
                            <div class="workout-title-row">
                                <div class="workout-icon"><i class="fa-solid fa-dumbbell"></i></div>
                                <div>
                                    <h3>Chest &amp; Triceps</h3>
                                    <p>6 exercises <span>•</span> 45 min <span>•</span> Intermediate</p>
                                </div>
                            </div>
                            <button class="primary-button" type="button">START WORKOUT <i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                        <div class="workout-image" role="img" aria-label="Gym workout image"></div>
                    </article>
                </section>

                <section class="bottom-grid">
                    <article class="card goals-card" id="goals">
                        <div class="card-heading">
                            <h2>MY GOALS</h2>
                            <a href="#goals">View all</a>
                        </div>

                        <div class="goal-list">
                            <div class="goal-row">
                                <div class="goal-icon"><i class="fa-solid fa-weight-scale"></i></div>
                                <div class="goal-main">
                                    <div class="goal-title-line"><h3>Lose 10 KG</h3><strong>70%</strong></div>
                                    <div class="progress"><span style="width:70%"></span></div>
                                    <div class="goal-meta"><span>7 / 10 KG</span><span>Dec 20, 2026</span></div>
                                </div>
                            </div>
                            <div class="goal-row">
                                <div class="goal-icon"><i class="fa-solid fa-dumbbell"></i></div>
                                <div class="goal-main">
                                    <div class="goal-title-line"><h3>Bench Press 100 KG</h3><strong>50%</strong></div>
                                    <div class="progress"><span style="width:50%"></span></div>
                                    <div class="goal-meta"><span>50 / 100 KG</span><span>Jan 15, 2027</span></div>
                                </div>
                            </div>
                        </div>

                        <button class="outline-button" id="addGoalButton" type="button"><i class="fa-solid fa-plus"></i> ADD NEW GOAL</button>
                    </article>

                    <article class="card recent-card" id="history">
                        <div class="card-heading">
                            <h2>RECENT WORKOUTS</h2>
                            <a href="#history">View all</a>
                        </div>

                        <div class="recent-list">
                            <div class="recent-row">
                                <div class="recent-icon"><i class="fa-solid fa-dumbbell"></i></div>
                                <div class="recent-copy"><h3>Chest &amp; Triceps</h3><p>6 exercises <span>•</span> 45 min</p></div>
                                <span class="recent-date today">Today</span><i class="fa-solid fa-chevron-right arrow"></i>
                            </div>
                            <div class="recent-row">
                                <div class="recent-icon"><i class="fa-solid fa-person-running"></i></div>
                                <div class="recent-copy"><h3>Legs</h3><p>7 exercises <span>•</span> 50 min</p></div>
                                <span class="recent-date">Yesterday</span><i class="fa-solid fa-chevron-right arrow"></i>
                            </div>
                            <div class="recent-row">
                                <div class="recent-icon"><i class="fa-solid fa-child-reaching"></i></div>
                                <div class="recent-copy"><h3>Back &amp; Biceps</h3><p>8 exercises <span>•</span> 55 min</p></div>
                                <span class="recent-date">Aug 16, 2026</span><i class="fa-solid fa-chevron-right arrow"></i>
                            </div>
                        </div>

                        <button class="outline-button history-button" type="button"><i class="fa-regular fa-calendar"></i> VIEW FULL HISTORY</button>
                    </article>
                </section>
            </div>
        </main>
    </div>

    <div class="modal" id="goalModal" aria-hidden="true">
        <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="goalModalTitle">
            <button class="modal-close" id="closeGoalModal" type="button" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            <h2 id="goalModalTitle">Add New Goal</h2>
            <p>Create a simple target and keep moving toward it.</p>
            <form id="goalForm">
                <label>Goal name<input type="text" id="goalName" placeholder="e.g. Lose 5 KG" required></label>
                <label>Target<input type="text" id="goalTarget" placeholder="e.g. 5 KG" required></label>
                <label>Deadline<input type="date" id="goalDate" required></label>
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
        form.addEventListener('submit', event => {
            event.preventDefault();
            toggleGoalModal(false);
            form.reset();
        });
    </script>
</body>
</html>
