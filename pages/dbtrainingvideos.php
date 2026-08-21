<?php
require_once("dbconnection.php");

function get_all_training_videos()
{
    try {
        $con = dbconnect();
        $sql = "SELECT id, muscle_group, title, youtube_id FROM training_videos ORDER BY muscle_group ASC, created_at DESC";
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

function add_training_video($muscle_group, $title, $youtube_id)
{
    try {
        $con = dbconnect();
        $sql = "INSERT INTO training_videos (muscle_group, title, youtube_id) VALUES (:muscle_group, :title, :youtube_id)";
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
