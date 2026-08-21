<?php
require_once("dbconnection.php");
//$con
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
