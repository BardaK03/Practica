<?php
require_once 'cridentials.php';
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: ". $conn->connect_error);
}

require_once 'insert.php';
insertData($conn); // Pass the $conn variable to the insert.php file

$offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;

$stmt = $conn->prepare("SELECT m.id, m.title, c.name as category FROM movies m JOIN categories c ON m.category_id = c.id LIMIT ?, ?");
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

$movies = array();
while ($row = $result->fetch_assoc()) {
  $movies[] = array(
    "id" => $row['id'],
    "title" => $row['title'],
    "category" => $row['category']
  );
}

header('Content-Type: application/json');
echo json_encode($movies, JSON_PRETTY_PRINT);
