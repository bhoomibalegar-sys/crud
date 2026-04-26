<?php
$conn = new mysqli("localhost", "root", "", "student_db");

if ($conn->connect_error) {
    die(json_encode(["status"=>"error","message"=>$conn->connect_error]));
}
?>
