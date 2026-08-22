<?php
require_once("dbconnection.php");

function add_to_cart($user_id, $supplement_id, $quantity = 1)
{
    try {
        $con = dbconnect();

        $checkSql = "SELECT id, quantity FROM cart_items WHERE user_id = :user_id AND supplement_id = :supplement_id";
        $checkStmt = $con->prepare($checkSql);
        $checkStmt->execute([':user_id' => $user_id, ':supplement_id' => $supplement_id]);
        $existing = $checkStmt->fetch();

        if ($existing) {
            $newQty = $existing["quantity"] + $quantity;
            $sql = "UPDATE cart_items SET quantity = :quantity WHERE id = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute([':quantity' => $newQty, ':id' => $existing["id"]]);
        } else {
            $sql = "INSERT INTO cart_items (user_id, supplement_id, quantity) VALUES (:user_id, :supplement_id, :quantity)";
            $stmt = $con->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':supplement_id' => $supplement_id,
                ':quantity' => $quantity
            ]);
        }

        $con = null;
        return ["status" => true, "message" => "Added to cart"];
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}

function get_cart_items($user_id)
{
    try {
        $con = dbconnect();
        $sql = "SELECT ci.id, ci.quantity, s.id AS supplement_id, s.name, s.price, s.image_path
                FROM cart_items ci
                JOIN supplements s ON s.id = ci.supplement_id
                WHERE ci.user_id = :user_id
                ORDER BY ci.added_at DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        $data = $stmt->fetchAll();
        $con = null;

        if ($stmt->rowCount() > 0) {
            return ["status" => true, "data" => $data];
        } else {
            return ["status" => false, "message" => "Cart is empty"];
        }
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}

function update_cart_quantity($cart_id, $user_id, $quantity)
{
    try {
        $con = dbconnect();
        $sql = "UPDATE cart_items SET quantity = :quantity WHERE id = :id AND user_id = :user_id";
        $stmt = $con->prepare($sql);
        $stmt->execute([
            ':quantity' => $quantity,
            ':id' => $cart_id,
            ':user_id' => $user_id
        ]);
        $con = null;
        return ["status" => true, "message" => "Quantity updated"];
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}

function remove_cart_item($cart_id, $user_id)
{
    try {
        $con = dbconnect();
        $sql = "DELETE FROM cart_items WHERE id = :id AND user_id = :user_id";
        $stmt = $con->prepare($sql);
        $stmt->execute([':id' => $cart_id, ':user_id' => $user_id]);
        $con = null;
        return ["status" => true, "message" => "Item removed"];
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}

function clear_cart($user_id)
{
    try {
        $con = dbconnect();
        $sql = "DELETE FROM cart_items WHERE user_id = :user_id";
        $stmt = $con->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        $con = null;
        return ["status" => true, "message" => "Cart cleared"];
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}
