<?php
header("Content-Type: application/json");
include "db.php";

$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$age = $_POST['age'];

$sql = "UPDATE students SET name='$name', email='$email', age='$age' WHERE id=$id";

if ($conn->query($sql)) {
    echo json_encode(["status"=>"success","message"=>"Updated"]);
} else {
    echo json_encode(["status"=>"error","message"=>$conn->error]);
}
