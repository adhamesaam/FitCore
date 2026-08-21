<?php
session_start();
echo "see";
if (!isset($_SESSION["id"])) {
    header("location:login.php");
    exit;
}

if ($_SESSION["role"] != "user") {
    header("location:profile.php");
    exit;
}



$bmi = "";
$result = "";
$calories = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $weight = $_POST["weight"];
    $height = $_POST["height"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $activity = $_POST["activity"];

    if (
        empty($weight) ||
        empty($height) ||
        empty($age) ||
        empty($gender) ||
        empty($activity)
    ) {

        $error = "Please fill in all fields.";
    } elseif ($weight <= 0 || $height <= 0 || $age <= 0) {

        $error = "Weight, height and age must be greater than 0.";
    } else {

        // =========================
        // BMI
        // =========================

        $heightMeter = $height / 100;

        $bmi = $weight / ($heightMeter * $heightMeter);

        $bmi = round($bmi, 2);


        // =========================
        // BMI Result
        // =========================

        if ($bmi < 18.5) {

            $result = "Underweight";
        } elseif ($bmi < 25) {

            $result = "Normal Weight";
        } elseif ($bmi < 30) {

            $result = "Overweight";
        } else {

            $result = "Obesity";
        }


        // =========================
        // BMR
        // =========================

        if ($gender == "male") {

            $bmr = (10 * $weight) +
                (6.25 * $height) -
                (5 * $age) +
                5;
        } else {

            $bmr = (10 * $weight) +
                (6.25 * $height) -
                (5 * $age) -
                161;
        }


        // =========================
        // Activity Multiplier
        // =========================

        if ($activity == "sedentary") {

            $multiplier = 1.2;
        } elseif ($activity == "light") {

            $multiplier = 1.375;
        } elseif ($activity == "moderate") {

            $multiplier = 1.55;
        } elseif ($activity == "active") {

            $multiplier = 1.725;
        } else {

            $multiplier = 1.9;
        }


        // =========================
        // Daily Calories
        // =========================

        $calories = $bmr * $multiplier;

        $calories = round($calories);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BMI Calculator</title>

    <link rel="stylesheet" href="styles/bmistyle.css">

</head>

<body>

    <div class="bmi-container">

        <div class="form-card">

            <h1>BMI Calculator</h1>

            <form method="POST">



                <div class="form-group">

                    <label for="weight">
                        Weight (kg)
                    </label>

                    <input
                        type="number"
                        id="weight"
                        name="weight"
                        step="0.1"
                        placeholder="Enter your weight"
                        required>

                </div>




                <div class="form-group">

                    <label for="height">
                        Height (cm)
                    </label>

                    <input
                        type="number"
                        id="height"
                        name="height"
                        step="0.1"
                        placeholder="Enter your height"
                        required>

                </div>




                <div class="form-group">

                    <label for="age">
                        Age
                    </label>

                    <input
                        type="number"
                        id="age"
                        name="age"
                        placeholder="Enter your age"
                        required>

                </div>




                <div class="form-group">

                    <label for="gender">
                        Gender
                    </label>

                    <select
                        id="gender"
                        name="gender"
                        required>

                        <option value="">
                            Select Gender
                        </option>

                        <option value="male">
                            Male
                        </option>

                        <option value="female">
                            Female
                        </option>

                    </select>

                </div>




                <div class="form-group">

                    <label for="activity">
                        Activity Level
                    </label>

                    <select
                        id="activity"
                        name="activity"
                        required>

                        <option value="">
                            Select Activity Level
                        </option>

                        <option value="sedentary">
                            Sedentary - Little or no exercise
                        </option>

                        <option value="light">
                            Light - Exercise 1-3 days/week
                        </option>

                        <option value="moderate">
                            Moderate - Exercise 3-5 days/week
                        </option>

                        <option value="active">
                            Active - Exercise 6-7 days/week
                        </option>

                        <option value="very_active">
                            Very Active - Hard exercise
                        </option>

                    </select>

                </div>




                <button
                    type="submit"
                    name="bmibtn"
                    class="btn-primary">
                    Calculate
                </button>




                <?php if (!empty($error)) { ?>

                    <div class="alert-danger">

                        <?php echo $error; ?>

                    </div>

                <?php } ?>




                <?php if (!empty($bmi)) { ?>

                    <div class="bmi-result">

                        <h2>Your BMI</h2>

                        <div class="bmi-number">
                            <?php echo $bmi; ?>
                        </div>

                        <p>
                            <?php echo $result; ?>
                        </p>


                        <div class="calories-result">

                            <h2>Daily Calories</h2>

                            <div class="calories-number">

                                <?php echo $calories; ?>

                                <span> kcal/day</span>

                            </div>

                            <p>
                                Estimated calories to maintain your current weight
                            </p>

                        </div>

                        <a href="profile.php" class="btn-primary" style="display:flex; align-items:center; justify-content:center; text-decoration:none; margin-top:16px; line-height:normal;">
                            Go to Profile
                        </a>

                    </div>

                <?php } ?>

            </form>

        </div>

    </div>

</body>

</html>