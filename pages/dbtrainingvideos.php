<?php
require_once("dbconnection.php");

function get_all_training_videos()
{
    try {
        $con = dbconnect();
        $sql = "SELECT id, muscle_group, title, youtube_id, is_default FROM training_videos ORDER BY muscle_group ASC, created_at DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $con = null;

        if ($stmt->rowCount() > 0) {
            return ["status" => true, "data" => $data];
        } else {
            return ["status" => false, "message" => "No training videos found"];
        }
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}

// Only the default/free videos - for non-subscribed users
function get_default_training_videos()
{
    try {
        $con = dbconnect();
        $sql = "SELECT id, muscle_group, title, youtube_id, is_default FROM training_videos WHERE is_default = 1 ORDER BY muscle_group ASC, created_at DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $con = null;

        if ($stmt->rowCount() > 0) {
            return ["status" => true, "data" => $data];
        } else {
            return ["status" => false, "message" => "No training videos found"];
        }
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}


function is_user_subscribed($id)
{
    try {
        $con = dbconnect();
        $sql = "SELECT id FROM users
                WHERE id = :id
                AND subscription_start IS NOT NULL
                AND subscription_end IS NOT NULL
                AND CURDATE() BETWEEN subscription_start AND subscription_end";
        $stmt = $con->prepare($sql);
        $stmt->execute([':id' => $id]);
        $found = $stmt->fetch();
        $con = null;

        return $found ? true : false;
    } catch (PDOException $e) {
        return false;
    }
}

function add_training_video($muscle_group, $title, $youtube_id)
{
    try {
        $con = dbconnect();
        $sql = "INSERT INTO training_videos (muscle_group, title, youtube_id, is_default) VALUES (:muscle_group, :title, :youtube_id, 0)";
        $stmt = $con->prepare($sql);
        $stmt->execute([
            ':muscle_group' => $muscle_group,
            ':title' => $title,
            ':youtube_id' => $youtube_id
        ]);
        $con = null;
        return ["status" => true, "message" => "Video added"];
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}

function delete_training_video($id)
{
    try {
        $con = dbconnect();
        $sql = "DELETE FROM training_videos WHERE id = :id";
        $stmt = $con->prepare($sql);
        $stmt->execute([':id' => $id]);
        $con = null;
        return ["status" => true, "message" => "Video deleted"];
    } catch (PDOException $e) {
        return ["status" => false, "message" => $e->getMessage()];
    }
}
