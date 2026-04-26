<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");
include "db.php";

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$age = $_POST['age'] ?? '';

if ($name == '' || $email == '' || $age == '') {
    echo json_encode(["status"=>"error","message"=>"All fields required"]);
    exit();
}

$sql = "INSERT INTO students (name, email, age) VALUES ('$name', '$email', '$age')";

if ($conn->query($sql)) {
    echo json_encode(["status"=>"success","message"=>"Inserted"]);
} else {
    echo json_encode(["status"=>"error","message"=>$conn->error]);
}
?>
