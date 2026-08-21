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


function redirect_target_for_role($role)
{
    if ($role == "user") {
        return "bmi.php";
    }
    return "profile.php";
}

if (isset($_SESSION["id"])) {
    header("location:profile.php");
    exit;
}

$error = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['createAccountBtn'])) {

    $name = cleaninput($_POST["name"]);
    $email = cleaninput($_POST["email"]);
    $password = cleaninput($_POST["password"]);
    $confirmPassword = cleaninput($_POST["confirmPassword"]);
    $role = cleaninput($_POST["role"] ?? "");

    // Name
    if (empty($name)) {
        $error[] = "full name is required";
    }

    // Email
    if (empty($email)) {
        $error[] = "email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "email must contain @ and tld (.net, .org, .com...)";
    }


    if (empty($password)) {
        $error[] = "password is required";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", $password)) {
        $error[] = "password must contain 1 small, 1 capital, 1 digit, 1 special character, min 8 chars";
    }


    if ($password !== $confirmPassword) {
        $error[] = "passwords do not match";
    }


    if (!in_array($role, ["user", "owner"])) {
        $role = "user";
    }

    if (empty($error)) {

        try {
            $con = dbconnect();


            $check = $con->prepare("SELECT id FROM users WHERE email = :email");
            $check->execute([':email' => $email]);

            if ($check->fetch()) {

                $error[] = "an account with this email already exists";
            } else {


                $sql = "INSERT INTO users (fullname, email, password, role) VALUES (:fullname, :email, :password, :role)";

                $stmt = $con->prepare($sql);
                $stmt->execute([
                    ':fullname' => $name,
                    ':email' => $email,
                    ':password' => $password,
                    ':role' => $role
                ]);


                $newId = $con->lastInsertId();

                $_SESSION['username']  = $name;
                $_SESSION['useremail'] = $email;
                $_SESSION['id']        = $newId;
                $_SESSION['role']      = $role;

                session_regenerate_id(true);

                header("Location: " . redirect_target_for_role($role));
                exit;
            }
        } catch (PDOException $e) {
            $error[] = "something went wrong, please try again later";
        }
    }
}


$_SESSION['signup_errors'] = $error;
$_SESSION['signup_old'] = [
    'name' => $_POST['name'] ?? '',
    'email' => $_POST['email'] ?? '',
    'role' => $_POST['role'] ?? 'user'
];

header("Location: signUp.php");
exit;
