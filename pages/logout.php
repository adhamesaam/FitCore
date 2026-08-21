<?php
session_start();

unset($_SESSION);

session_destroy();

setcookie("token", "null", time() - 1, '/');

header("location:login.php");
