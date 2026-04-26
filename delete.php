<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");
include "db.php";

// ✅ Check if ID is received
if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "ID not received ❌"
    ]);
    exit();
}

$id = intval($_POST['id']); // secure conversion

// ✅ Check if record exists
$check = $conn->query("SELECT * FROM students WHERE id = $id");

if ($check->num_rows == 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Student not found ❌"
    ]);
    exit();
}

// ✅ Delete query
$sql = "DELETE FROM students WHERE id = $id";

if ($conn->query($sql)) {
    echo json_encode([
        "status" => "success",
        "message" => "Student deleted successfully ✅"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => $conn->error
    ]);
}

$conn->close();
?>
?>
