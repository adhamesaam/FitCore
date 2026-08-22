<?php
require_once("dbconnection.php");

const MAX_ADMINS = 3;

function count_admins()
{
    try {
        $con = dbconnect();
        $sql = "select count(*) from users where role = 'admin'";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $count = (int) $stmt->fetchColumn();
        $con = null;
        return $count;
    } catch (PDOException $e) {
        return MAX_ADMINS; // fail safe: if we can't count, don't allow more admins
    }
}

function get_all_users()
{
    try {
        $con = dbconnect();
        $sql = "select * from users ";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        if ($stmt->rowCount() > 0) {
            $con = null;
            return ["status" => true, "data" => $data];
        } else {
            $con = null;
            return ["status" => false, "message" => "No departments Found"];
        }
    } catch (PDOException $e) {
        $con = null;
        return ["status" => true, "message" => $e->getMessage()];
    }
}

function get_user_by_id($id)
{
    try {
        $con = dbconnect();
        $sql = "SELECT id, fullname, email, gender, role, photo FROM users WHERE id = :id";
        $stmt = $con->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch();
        $con = null;

        if ($data) {
            return ["status" => true, "data" => $data];
        } else {
            return ["status" => false, "message" => "User not found"];
        }
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}

function update_user_profile($id, $fullname, $email, $photo = null)
{
    try {
        $con = dbconnect();

        if ($photo !== null) {
            $sql = "UPDATE users SET fullname = :fullname, email = :email, photo = :photo WHERE id = :id";
            $params = [
                ':fullname' => $fullname,
                ':email' => $email,
                ':photo' => $photo,
                ':id' => $id
            ];
        } else {
            $sql = "UPDATE users SET fullname = :fullname, email = :email WHERE id = :id";
            $params = [
                ':fullname' => $fullname,
                ':email' => $email,
                ':id' => $id
            ];
        }

        $stmt = $con->prepare($sql);
        $stmt->execute($params);
        $con = null;

        return ["status" => true, "message" => "Profile updated"];
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}

function addUser($data)
{
    foreach ($data as $key => $val) {
        $$key = $val;
    }
 
    // sensible defaults for optional fields
    $photo = $photo ?? null;
    $gym_location_id = $gym_location_id ?? null;
    $created_at = $created_at ?? date('Y-m-d H:i:s');
    $remember_token = bin2hex(random_bytes(16));
 
    try {
        $con = dbconnect();
        $sql = "insert into users (fullname, email, gender, role, photo, created_at, gym_location_id, password, remember_token)
                values (:fullname, :email, :gender, :role, :photo, :created_at, :gym_location_id, :password, :remember_token)";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":fullname", $fullname, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":gender", $gender, PDO::PARAM_STR);
        $stmt->bindParam(":role", $role, PDO::PARAM_STR);
        $stmt->bindParam(":photo", $photo, PDO::PARAM_STR);
        $stmt->bindParam(":created_at", $created_at, PDO::PARAM_STR);
        $stmt->bindParam(":gym_location_id", $gym_location_id, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->bindParam(":remember_token", $remember_token, PDO::PARAM_STR);
 
        if ($stmt->execute()) {
            $userId = $con->lastInsertId();
            $con = null;
            return ["status" => true, "message" => "User #$userId added successfully"];
        } else {
            $con = null;
            return ["status" => false, "message" => "Could not add user"];
        }
    } catch (PDOException $e) {
        $con = null;
        return ["status" => false, "message" => $e->getMessage()];
    }
}

function delete_user($delid)
{
    try {
        $con = dbconnect();
        $sql = "delete from users where id = :user_id";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":user_id", $delid, PDO::PARAM_INT);
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            $con = null;
            return ["status" => true, "message" => "user delete success"];
        } else {
            $con = null;
            return ["status" => false, "message" => "deleted id not found"];
        }
    } catch (PDOException $er) {
        $con = null;
        return ["status" => false, "message" => $er->getMessage()];
    }
}

function update_user($id, $fullname, $email, $gender, $role, $photo = null)
{
    try {
        $con = dbconnect();
 
        if ($photo !== null) {
            $sql = "UPDATE users SET fullname = :fullname, email = :email, gender = :gender, role = :role, photo = :photo WHERE id = :id";
            $params = [
                ':fullname' => $fullname,
                ':email' => $email,
                ':gender' => $gender,
                ':role' => $role,
                ':photo' => $photo,
                ':id' => $id
            ];
        } else {
            $sql = "UPDATE users SET fullname = :fullname, email = :email, gender = :gender, role = :role WHERE id = :id";
            $params = [
                ':fullname' => $fullname,
                ':email' => $email,
                ':gender' => $gender,
                ':role' => $role,
                ':id' => $id
            ];
        }
 
        $stmt = $con->prepare($sql);
        $stmt->execute($params);
        $con = null;
 
        return ["status" => true, "message" => "User updated successfully"];
    } catch (PDOException $e) {
        $con = null;
        return ["status" => false, "message" => $e->getMessage()];
    }
}
