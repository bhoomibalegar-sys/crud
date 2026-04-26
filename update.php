<?php
header("Content-Type: application/json");
include "db.php";

$id = $_POST['id'] ?? '';
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$age = $_POST['age'] ?? '';

if (!$id || !$name || !$email || !$age) {
    echo json_encode(["status"=>"error","message"=>"All fields required"]);
    exit();
}

$sql = "UPDATE students 
        SET name='$name', email='$email', age='$age' 
        WHERE id=$id";

if ($conn->query($sql)) {
    echo json_encode(["status"=>"success","message"=>"Student updated successfully ✅"]);
} else {
    echo json_encode(["status"=>"error","message"=>$conn->error]);
}
?>
