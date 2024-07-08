<?php
require_once 'cridentials.php';
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: ". $conn->connect_error);
}

$offset = isset($_GET['offset'])? max(0, (int) $_GET['offset']) : 0;
$limit = isset($_GET['limit'])? max(1, (int) $_GET['limit']) : 15;

$stmt = $conn->prepare("SELECT m.id, m.title, c.name as category FROM movies m JOIN categories c ON m.category_id = c.id LIMIT?,?");
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();
$movies = $result->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($movies, JSON_PARTIAL_OUTPUT_ON_ERROR);
error_log(print_r($movies, true));