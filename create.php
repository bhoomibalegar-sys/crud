<?php
require_once __DIR__ . '/db.php';

echo "Student ctreated successfully";
exit();

// SET HEADER
header("Content-Type: application/json");

// GET DATA
$data = json_decode(file_get_contents("php://input"));

if (!$data) {
    echo json_encode(["error" => "Invalid JSON"]);
    exit();
}

$name = $data->name ?? '';
$email = $data->email ?? '';
$age = $data->age ?? '';

$sql = "INSERT INTO students (name, email, age)
        VALUES ('$name', '$email', '$age')";

if ($conn->query($sql)) {
    echo json_encode(["message" => "Student created successfully"]);
} else {
    echo json_encode(["error" => $conn->error]);
}
?>