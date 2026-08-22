<?php
require_once("dbconnection.php");

function get_all_supplements()
{
    try {
        $con = dbconnect();
        $sql = "SELECT id, name, description, price, image_path FROM supplements ORDER BY created_at DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $con = null;

        if ($stmt->rowCount() > 0) {
            return ["status" => true, "data" => $data];
        } else {
            return ["status" => false, "message" => "No supplements found"];
        }
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}

function get_supplement_by_id($id)
{
    try {
        $con = dbconnect();
        $sql = "SELECT id, name, description, price, image_path FROM supplements WHERE id = :id";
        $stmt = $con->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        $con = null;

        if ($data) {
            return ["status" => true, "data" => $data];
        } else {
            return ["status" => false, "message" => "Supplement not found"];
        }
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}

function add_supplement($name, $description, $price, $image_path)
{
    try {
        $con = dbconnect();
        $sql = "INSERT INTO supplements (name, description, price, image_path) VALUES (:name, :description, :price, :image_path)";
        $stmt = $con->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':image_path' => $image_path
        ]);
        $con = null;
        return ["status" => true, "message" => "Supplement added"];
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}


function update_supplement_price($id, $price)
{
    try {
        $con = dbconnect();
        $sql = "UPDATE supplements SET price = :price WHERE id = :id";
        $stmt = $con->prepare($sql);
        $stmt->execute([
            ':price' => $price,
            ':id' => $id
        ]);
        $con = null;
        return ["status" => true, "message" => "Price updated"];
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}

function delete_supplement($id)
{
    try {
        $con = dbconnect();
        $sql = "DELETE FROM supplements WHERE id = :id";
        $stmt = $con->prepare($sql);
        $stmt->execute([':id' => $id]);
        $con = null;
        return ["status" => true, "message" => "Supplement deleted"];
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}
