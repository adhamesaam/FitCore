<?php
require_once("dbconnection.php");
//$con
function get_all_subscriptions()
{
    try {
        $con = dbconnect();
        $sql = "select * from subscriptions";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        if ($stmt->rowCount() > 0) {
            $con = null;
            return ["status" => true, "data" => $data];
        } else {
            $con = null;
            return ["status" => false, "message" => "No subscriptions Found"];
        }
    } catch (PDOException $e) {
        $con = null;
        return ["status" => false, "message" => $e->getMessage()];
    }
}

function check_user_subscription($user_id)
{
    try {
        $con = dbconnect();
        $sql = "SELECT * FROM subscriptions WHERE user_id = :user_id";
        $stmt = $con->prepare($sql);
        $stmt->execute([
            ':user_id' => (int)$user_id
        ]);
        $data = $stmt->fetch();
        $con = null;
        if ($data) {
            return [
                "status" => true,
                "exists" => true,
                "data" => $data
            ];
        }
        return [
            "status" => true,
            "exists" => false
        ];
    } catch (PDOException $e) {
        $con = null;
        return [
            "status" => false,
            "message" => $e->getMessage()
        ];
    }
}

function add_subscription(
    $user_id,
    $plan_id,
    $plan_name,
    $price,
    $start_date,
    $end_date
) {
    try {
        $con = dbconnect();

        $sql = "INSERT INTO subscriptions
                (user_id, plan_id, plan_name, price, start_date, end_date)
                VALUES
                (:user_id, :plan_id, :plan_name, :price, :start_date, :end_date)";

        $stmt = $con->prepare($sql);

        $stmt->execute([
            ':user_id' => (int)$user_id,
            ':plan_id' => (int)$plan_id,
            ':plan_name' => $plan_name,
            ':price' => $price,
            ':start_date' => $start_date,
            ':end_date' => $end_date
        ]);

        $con = null;

        return [
            "status" => true,
            "message" => "Subscription added successfully"
        ];

    } catch (PDOException $e) {

        $con = null;

        return [
            "status" => false,
            "message" => $e->getMessage()
        ];
    }
}

