<?php
$servername = "localhost";
$username = "root";
$password = "parola";
$dbname = "movies";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: ". $conn->connect_error);
}

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

// if ($conn->connect_error) {
//   die("Connection failed: ". $conn->connect_error);
// }
// echo "Connected to database: $dbname";

// $csv_file = 'netflix_titles.csv';

// if (($handle = fopen($csv_file, 'r'))!== FALSE) {
//   $categories = array();
//   while (($data = fgetcsv($handle, 1000, ","))!== FALSE) {
//     $category_name = trim(explode(' ', $data[10])[0]); // Get first word of category name
//     if (!in_array($category_name, $categories)) {
//       $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
//       $stmt->bind_param("s", $category_name);
//       $stmt->execute();
//       $category_id = $conn->insert_id; // get the auto-generated category ID
//       $categories[] = $category_name;
//       echo "Inserted category: $category_name\n";
//     } else {
//       $stmt = $conn->prepare("SELECT id FROM categories WHERE name = ?");
//       $stmt->bind_param("s", $category_name);
//       $stmt->execute();
//       $result = $stmt->get_result();
//       $row = $result->fetch_assoc();
//       $category_id = $row['id'];
//     }

//     $title = $data[2];
//     $release_year = (int) $data[7]; // Convert to integer

//     $stmt = $conn->prepare("INSERT INTO movies (title, release_year, category_id) VALUES (?,?,?)");
//     $stmt->bind_param("sii", $title, $release_year, $category_id);
//     $stmt->execute();
//     echo "Inserted movie: $title\n";
//   }
//   fclose($handle);
// }
// ?>