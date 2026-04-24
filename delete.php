<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;

$sql = "DELETE FROM students WHERE id=$id";

if ($conn->query($sql)) {
    echo json_encode(["message" => "Student deleted"]);
} else {
    echo json_encode(["error" => $conn->error]);
}
?>