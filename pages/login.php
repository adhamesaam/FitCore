<?php
session_start();
require_once("dbconnection.php");


function cleaninput($data)
{
    $data = trim($data);
    $data = strip_tags($data);
    $data = stripslashes($data);
    return $data;
}

if (isset($_SESSION["id"])) {
    header("location:profile.php");
    exit;
}

if (isset($_COOKIE["token"])) {

    try {
        $con = dbconnect();

        $sql = "SELECT id, fullname, email, role FROM users WHERE remember_token = :token";

        $stmt = $con->prepare($sql);

        $stmt->execute([
            ':token' => $_COOKIE["token"]
        ]);

        $user = $stmt->fetch();

        if ($user) {

            $_SESSION['username']  = $user['fullname'];
            $_SESSION['useremail'] = $user['email'];
            $_SESSION['id']        = $user['id'];
            $_SESSION['role']      = $user['role'];

            session_regenerate_id(true);

            header("Location: profile.php");
            exit;
        }
    } catch (PDOException $e) {
        // invalid/expired token or db error -> just fall through to login form
    }
}

$error = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loginbtn'])) {

    $uemail = cleaninput($_POST["loginemail"]);
    $upass = cleaninput($_POST["loginpassword"]);

    // Email validation
    if (empty($uemail)) {
        $error[] = "user email required";
    }

    if (!filter_var($uemail, FILTER_VALIDATE_EMAIL)) {
        $error[] = "user email must contain @ and tld (.net, .org, .com...)";
    }

    // Password validation
    if (empty($upass)) {
        $error[] = "Password Required";
    }

    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", $upass)) {
        $error[] = "Password Wrong";
    }

    if (empty($error)) {

        try {
            // ======== select user from database

            $con = dbconnect();

            $sql = "SELECT id, fullname, email, password, role FROM users WHERE email = :email";

            $stmt = $con->prepare($sql);

            $stmt->execute([':email' => $uemail]);

            $user = $stmt->fetch();


            if ($user && $upass === $user['password']) {

                $_SESSION['username']  = $user['fullname'];
                $_SESSION['useremail'] = $user['email'];
                $_SESSION['id'] = $user['id'];
                $_SESSION['role'] = $user['role'];

                // prevent session fixation
                session_regenerate_id(true);

                if (isset($_POST['rm'])) {

                    $token = bin2hex(random_bytes(32));

                    $update = $con->prepare(
                        "UPDATE users SET remember_token = :token WHERE id = :id"
                    );

                    $update->execute([
                        ':token' => $token,
                        ':id' => $user['id']
                    ]);

                    setcookie(
                        'token',
                        $token,
                        time() + (365 * 24 * 60 * 60),
                        '/',
                        '',
                        false,
                        true // HttpOnly - JS can't read the cookie
                    );
                }

                // this was missing before - without it, a successful
                // login just re-showed the login form
                header("Location: profile.php");
                exit;
            } else {

                $error[] = "user email or password incorrect";
            }
        } catch (PDOException $e) {
            $error[] = "something went wrong, please try again later";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Log In</title>

    <link rel="stylesheet" href="styles/loginstyle.css">
    <style>
        .login-card {
            background-color: #141b26;
        }

        body {
            background-color: #0b0f17;
        }
    </style>
</head>

<body>

    <div class="login-container">

        <div class="login-card">

            <h1>Log In</h1>

            <form method="POST" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">

                <div class="login-group">

                    <label for="email">Email Address</label>

                    <input
                        type="email"
                        id="loginemail"
                        name="loginemail"
                        required>

                </div>

                <div class="login-group">

                    <label for="password">Password</label>

                    <input
                        type="password"
                        id="loginpassword"
                        name="loginpassword"
                        required>

                </div>

                <?php

                if (!empty($error)) {

                    echo '<div class="login-error">
                            <ul>';

                    foreach ($error as $val) {
                        echo "<li>$val</li>";
                    }

                    echo '</ul>
                          </div>';
                }

                ?>

                <div class="login-options">

                    <div class="remember-box">

                        <input
                            type="checkbox"
                            name="rm"
                            value="rember"
                            id="form2Example3">

                        <label for="form2Example3">
                            Remember me
                        </label>

                    </div>

                </div>

                <button
                    type="submit"
                    name="loginbtn"
                    class="login-button">
                    Login
                </button>

                <p class="login-register">
                    Don't have an account?
                    <a href="signUp.php">Register</a>
                </p>

            </form>

        </div>

    </div>

</body>

</html>