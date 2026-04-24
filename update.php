<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json");

require_once __DIR__ . '/db.php';

// --- ADJUST THIS PART ---
// If your db.php uses $con, change $conn to $con below
$db = $conn ?? $con ?? null; 

if (!$db) {
    die(json_encode(["error" => "Connection variable not found. Check db.php"]));
}
// ------------------------

$json = file_get_contents("php://input");
$data = json_decode($json);

if (!$data) {
    die(json_encode(["error" => "Invalid JSON received"]));
}

$id    = $data->id ?? null;
$name  = $data->name ?? null;
$email = $data->email ?? null;
$age   = $data->age ?? null;

if (!$id) {
    die(json_encode(["error" => "ID is missing from the JSON body"]));
}

// Using the detected variable $db
$sql = "UPDATE students SET name='$name', email='$email', age='$age' WHERE id=$id";

if ($db->query($sql)) {
    echo json_encode(["status" => "success", "message" => "Student updated successfully"]);
} else {
    echo json_encode(["status" => "error", "sql_error" => $db->error]);
}
?>